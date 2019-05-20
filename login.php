<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) {
    session_start();
}
if (isset($_SESSION['name'])) {
    header('Location: home.php'); /* Redirect browser to home after login */
    die;
}
$err_msg = '';
if (isset($_POST['submit'])) {
    if ($_POST['user'] != '' && $_POST['pass'] != '') {
        require 'DBconnect.php';
        $con = DBconnect::createObj();
        $con->login($_POST['user'], $_POST['pass']);
    } else {
        $err_msg = "username or password can't be blank";
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>Sign-In</title>
<link rel="stylesheet" type="text/css" href="style-sign.css">
<style type="text/css">
.err {
  color: red;
}
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
input[type=text]
{
  background: transparent;
  border: 1px solid grey;
  border-radius: 5px;
}
input[type=password]
{
  background: transparent;
  border: 1px solid grey;
  border-radius: 5px;
}
input[type=submit], input[type=button]
{
  margin-right: 4%;
  background-color: Transparent;
  background-repeat:no-repeat;
  border: none;
  cursor: pointer;
  overflow: hidden;
  outline: none;
  display: inline-block;
}
input[type=submit]:hover, input[type=button]:hover
{
  color: green;
  text-decoration: underline;
}
</style>
<script type="text/javascript">

  function ajax () {
    console.log("in ajax")
    var mail=document.getElementById("abc").value;
        var xmlhttp = new XMLHttpRequest();
        xmlhttp.onreadystatechange = function() {
            if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                document.getElementById("txt").innerHTML = xmlhttp.responseText;
            }
        };
        xmlhttp.open("GET", "send_password.php?mail=" + mail, true);
        xmlhttp.send();
}

 function mail(str)
      {
          var key=str.value;
          if(!key.search(/^[-a-z0-9~!$%^&*_=+}{\'?]+(\.[-a-z0-9~!$%^&*_=+}{\'?]+)*@([a-z0-9_][-a-z0-9_]*(\.[-a-z0-9_]+)*\.(aero|arpa|biz|com|coop|edu|gov|info|int|mil|museum|name|net|org|pro|travel|mobi|[a-z][a-z])|([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}))(:[0-9]{1,5})?$/i)){
              //console.log(key);
              //Test
              document.getElementById("mail").innerHTML = "";
              return true;
          }
          else
              document.getElementById("mail").innerHTML = "Enter Valid Email";
      }
</script>
</head>
<body>
<p><span id="txt"></span></p>
<center>
<div id="Sign-In">
	<fieldset style="width:30%; border-radius: 5px;">
		<legend>LOG-IN HERE</legend>
    <div class="err"><?php echo $err_msg; ?></div>
		<form method="POST" action="">
			<br><input type="text" name="user" placeholder="Username" size="40"><br>
			<br><input type="password" name="pass" placeholder="Password" size="40"><br><br>
			<input class="button" type="submit" name="submit" value="Log-In">
		</form>
	</fieldset>
	<br><br>
</div>
</center>
</body>
</html>