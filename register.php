<?php
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['name'])) {
    header('Location: home.php'); /* Redirect browser to home after login */
    die;
}
error_reporting(E_ALL);
ini_set('display_errors', 1);

if (isset($_POST['submit'])) {
    if (strlen($_POST['pass'])>5) {
        if ($_POST['pass']==$_POST['cpass']) {
            if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                if (filter_var($_POST['name'], FILTER_SANITIZE_STRING)) {
                    require 'DBconnect.php';
                    $con = DBconnect::createObj();
                    $con->reg($_POST['name'], $_POST['uname'], $_POST['pass'], $_POST['email']);
                } else {
                    echo "Enter Valid Name";
                }
            } else {
                echo "Enter Valid Email";
            }
        } else {
            echo "Password and confirm password should be same";
        }
    } else {
        echo "Password should be minimum 6 characters";
    }
}
?>
<!DOCTYPE HTML>
<html>
 <head>
    <title>Sign-In</title>
    <link rel="stylesheet" type="text/css" href="style-sign.css">

     <script type="text/javascript">
      function mail(str)
      {
          var key=str.value;
          if(!key.search(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i)){
              //console.log(key);
              document.getElementById("mail").innerHTML = "";
              return true;
          }
          else
              document.getElementById("mail").innerHTML = "Enter Valid Email";
      }

      function passcheck(){
        if(document.getElementById("password1").value==document.getElementById("password2").value && document.getElementById("password1").length>5){
          document.getElementById("mail").innerHTML = "";
              return true;
        }
        else{
          document.getElementById("mail").innerHTML = "Enter Valid Password";
        }
      }

</script>

<style>
#Sign-In
{
  border: 1px solid #D1D1D1;
  margin-top: 5%;
  margin-right: 30%;
  margin-left: 30%;
  box-shadow: 5px 10px 18px #888888;
  padding: 2%;
  border-radius: 5px;
}
input[type=text], input[type=password]
{
  background: transparent;
  border: 1px solid grey;
  border-radius: 5px;
}
input[type=submit]
{
  background-color: Transparent;
  background-repeat:no-repeat;
  border: none;
  cursor: pointer;
  overflow: hidden;
  outline: none;
  display: inline-block;
}
input[type=submit]:hover
{
  color: green;
  text-decoration: underline;
}
</style>

</head>
<body>
  <center>
    <div id="Sign-In">
       <fieldset style="width:30%; border-radius: 5px;">
          <legend>REGISTER HERE</legend>
          <form method="POST" onsubmit="passcheck" action="">
             <br> <input type="text" name="name" size="40" value="" placeholder="Name"  pattern="[A-Z][a-zA-Z ]*$"title="only character with first letter capital"  required><br>
             <br><input type="text" name="uname" size="40" placeholder="Username"  pattern="[a-zA-Z]*$" 
             title="only characters allowed"  required><br>
             <br> <input type="text" name="email" size="40" placeholder="Email" 
             onfocusout="return mail(this)" required ><br>
             <br><input type="password" id="password1" placeholder="Password" name="pass" size="40"  ><br>
             <br><input type="password" id="password2" placeholder="Confirm Password" name="cpass" size="40"><br><br>
             <input id="button" type="submit" name="submit" value="Submit">
             <p id="mail"></p>
          </form>
       </fieldset>
    </div> </center>
 </body>
</html>