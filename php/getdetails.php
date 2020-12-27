<?php

$mysqli = new mysqli("localhost", "root", "", "busrs");
 
if($mysqli === false){
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}
$i=0;
$o = $_GET['o'];
$d = $_GET['d'];

//echo "".$o."  ".$d."<br>";

$sqlo = "SELECT rid FROM route WHERE route.origin='$o'";
$sqld = "SELECT rid FROM route WHERE route.destination='$d'";

if($result = $mysqli->query($sqlo)){
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            if($i != 0)
                $orid[$i++]=',';
            $temp[$i]=$row['rid'];
            $orid[$i++]=$row['rid'];
        }
        $result->free();
    } else{
        echo "Sorry! no Bus is scheduled from $o to $d";
        die();
    }
} else{
    echo "ERROR: Could not able to execute $sqlo. " . $mysqli->error;
    die();
}

if($result = $mysqli->query($sqld)){
    $i=0;
    if($result->num_rows > 0){
        while($row = $result->fetch_array()){
            if($i != 0)
                $drid[$i++]=',';
            $drid[$i++]=$row['rid'];
        }
        $result->free();
    } else{
        echo "Sorry! no Bus is from $o to $d";
        die();
    }
} else{
    echo "Sorry! no Bus is from $o to $d";
    die();
}

$min="SELECT min(a.rid)
FROM busschedule bs
JOIN bshasroute a
ON bs.path like '%$o%$d%' AND a.rid IN (".implode($orid).") AND bs.bsid=a.bsid";

$resultmin = $mysqli->query($min);
$row = $resultmin->fetch_array();

$j=$row['min(a.rid)'];

$max="SELECT max(a.rid)
FROM busschedule bs
JOIN bshasroute a
ON bs.path like '%$o%$d%' AND a.rid IN (".implode($drid).") AND bs.bsid=a.bsid";

$resultmax = $mysqli->query($max);
$row = $resultmax->fetch_array();


for($k=0;$j<=$row['max(a.rid)'];){
    if($k != 0)
        $minmax[$k++]=',';
    $minmax[$k++]=$j;
    $j++;
}

$sql = "SELECT bs.bsid,time_format(a.departureTime,'%h:%i %p'),time_format(b.arrivalTime,'%h:%i %p'),sum(r.fare)
FROM busschedule bs
JOIN bshasroute a
ON bs.path like '%$o%$d%' AND a.rid IN (".implode($orid).") AND bs.bsid=a.bsid
JOIN bshasroute b
ON b.rid IN (".implode($drid).") AND bs.bsid=b.bsid
JOIN  bshasroute c
ON bs.bsid=c.bsid and c.rid in (".implode($minmax).")
JOIN route r
ON c.rid=r.rid  GROUP BY bs.bsid;";

$i=0;

if($result = $mysqli->query($sql)){
    if($result->num_rows > 0){
        echo "<table>";
            echo "<tr>";
                echo "<th>Bus Schedule ID</th>";
                echo "<th>Departure Time</th>";
                echo "<th>Arrival Time</th>";
                echo "<th>Fare (in .Rs)</th>";
            echo "</tr>";
            echo "<tbody id='tbody'>";
        while($row = $result->fetch_array()){
            echo "<tr onclick='table(this)' tabindex='".$i++."'>";
                echo "<td>" . $row['bsid'] . "</td>";
                echo "<td>" . $row["time_format(a.departureTime,'%h:%i %p')"] . "</td>";
                echo "<td>" . $row["time_format(b.arrivalTime,'%h:%i %p')"] . "</td>";
                echo "<td>" . $row['sum(r.fare)'] . "</td>";
            echo "</tr>";
        }
        echo '</tbody>';
        echo "</table>";
        $result->free();
    } else{
        echo "Sorry! no Bus is from $o to $d";
        die();
    }
} else{
    echo "Sorry! no Bus is from $o to $d";
    die();
}

$mysqli->close();

//echo '<br>'.implode($orid).'<br>'.implode($drid).'<br>'.implode($minmax);
?>

