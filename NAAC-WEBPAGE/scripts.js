/* When the user clicks on the button, 
                    toggle between hiding and showing the dropdown content */
  /*                  function myFunction() {
                      document.getElementById("myDropdown").classList.toggle("show");
                    }
                    
                    // Close the dropdown if the user clicks outside of it
                    window.onclick = function(event) {
                      if (!event.target.matches('.dropbtn')) {
                        var dropdowns = document.getElementsByClassName("dropdown-content");
                        var i;
                        for (i = 0; i < dropdowns.length; i++) {
                          var openDropdown = dropdowns[i];
                          if (openDropdown.classList.contains('show')) {
                            openDropdown.classList.remove('show');
                          }
                        }
                      }
                    }
                    
*/
/*                    function disappear(a)
{
    if (document.getElementById(a).style.display === "none")
        document.getElementById(a).style.display="block";
    else
        document.getElementById(a).style.display="none";
}

*/


/*********VARIABLES*********/
// const selectCriteria = $(".selectCriteria");
//var displayCriteriaSection = $(".displayCriteriaSection");

var Wi = $(".Wi");
var KAGPi = $(".KAGPi");
var KAWGPi = $(".KAWGPi");
const submit = $(".submit");


const result = $(".result");
var cgpa = $(".cgpa");
var grade = $(".grade");
var outcome = $(".outcome");

/*********EVENT LISTNERS*********/
submit.click(calculateResult);

/*********FUNCTIONS **********/
//Selecting the criteria
// function select() {
//     displayCriteria(selectCriteria.val());
//     event.stopImmediatePropagation();
//   }

//Displaying the selected criteria
/*function displayCriteria(criteria) {
//   let criteria=  selectCriteria.val()
  if (criteria !== "") {
    displayCriteriaSection.children().filter((child) => {
      // console.log(displayCriteriaSection.children()[child].className !== criteria);
      if (displayCriteriaSection.children()[child].className !== criteria) {
        let hide = displayCriteriaSection.children()[child].className;
        // console.log("true block");
        $(`.${hide}`).css("display", "none");
      } else {
        // console.log("false block");
        $(`.displayCriteriaSection .${criteria}`).css("display", "block");
      }
    });
  }
}
*/
function calculateResult(event) {
  //window.alert("hello");
  //event.preventDefault();
  let KAWGP = 0;
  let flag = true;
 // window.alert("hello");
  for (let i = 0; i < KAGPi.length; i++) {
    if (KAGPi[i].value === "" || KAGPi[i].value < 0 || KAGPi[i].value > 4) {
      window.alert("You have not filled the grades within range[0-4]\n");
      result.css('display','none')
      flag = false;
      break;
    }
  }
  

  if (flag) {
    for (let i = 0; i < KAWGPi.length; i++) {
      KAWGPi[i].innerHTML = (Wi[i].innerHTML * KAGPi[i].value).toPrecision(4);
      KAWGP += `+ ${KAWGPi[i].innerHTML}`;
    }
    displayResult(eval(KAWGP));
  }
}




function closer(n,a,b){
  let x="displaytable";
  let p="bu";
  //window.alert("hello");
  if(a==1){
        for(let i = 0;i<7;i++)
        {
          //window.alert();
          let y=(x+String(i+1));
          let z=(p+String(i+1));
          //window.alert(y);
          //window.alert(z);
        //document.getElementById(y).style.display="none";
        // if (document.getElementById(y).style.display === "none")
            //  document.getElementById(y).style.display="block";
          //else
          if((i+1)!=b)
          {
              document.getElementById(y).style.display="none";
              document.getElementById(z).style.display="none";
          }
          //document.getElementById(a).style.display="none";
          //document.getElementsByClassName()[0].style.visibility = "hidden";
        // window.alert("Hello");
          //window.alert(x+String(i+1));
          //$(`.${x+String(i+1)}`).css("display","none");
        }
        if(
          document.getElementById(x+String(b)).style.display==="none" &&
        document.getElementById(p+String(b)).style.display==="none"
        )
        {
          document.getElementById(x+String(b)).style.display="block";
        document.getElementById(p+String(b)).style.display="block";
        }
        else{
          document.getElementById(x+String(b)).style.display="none";
        document.getElementById(p+String(b)).style.display="none";
        }
}
else{
  document.getElementById(b).style.display="none";
}

  //$(`.${x+String(a)}`).css("display","block");
}

//Displaying the result
function displayResult(KAWGP) {
  result.css("display", "block");

  console.log(KAWGP);

  let CGPA = (KAWGP / 1000).toPrecision(3);
  cgpa.html("CGPA    :"+" "+String(CGPA));

  if (CGPA > 1.5) {
    if (CGPA > 3.5) {
      grade.html("GRADE   : A++");
    } else if (CGPA > 3.25) {
      grade.html("GRADE   : A+");
    } else if (CGPA > 3) {
      grade.html("GRADE   : A");
    } else if (CGPA > 2.75) {
      grade.html("GRADE   : B++");
    } else if (CGPA > 2.5) {
      grade.html("GRADE   : B+");
    } else if (CGPA > 2) {
      grade.html("GRADE   : B");
    } else if (CGPA > 1.5) {
      grade.html("GRADE   : C");
    }
    outcome.html("STATUS  : Accredited");
    outcome.css("color", "green");
  } else {
    grade.html("GRADE   : D");
    outcome.html("STATUS  : Not Accredited");
    outcome.css("color", "red");
  }
}