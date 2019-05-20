<?php

if (!isset($_SESSION)) {
    session_start();
}
  error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'DBconnect.php';
$con = DBconnect::createObj();

?>
<!DOCTYPE html>
<html>
<head>
	<title>TODO</title>
  <script src="jquery.js"></script>
  <script src="script.js"></script>
<style>
#page
{
  border: 1px solid #D1D1D1;
  margin-top: 5%;
  margin-right: 30%;
  margin-left: 30%;
  box-shadow: 5px 10px 18px #888888;
  padding: 2%;
  border-radius: 5px;
}
p,h1
{
  text-align: center;
}
button
{
   background-color: Transparent;
   background-repeat:no-repeat;
   border: none;
   cursor:pointer;
   overflow: hidden;
   outline:none;
}
button:hover,input[type=button]:hover
{
  color: green;
  text-decoration: underline;
}
button:focus,input[type=button]
{
  outline: none;
}
input[type=text]
{
  background: transparent;
  border: 1px solid grey;
  border-radius: 5px;
}
input[type=button]
{
  margin-left: 40%;
  background-color: Transparent;
  background-repeat:no-repeat;
  border: none;
  cursor:pointer;
  overflow: hidden;
  outline:none;
}
#main
{
  align-content: center;
}
table
{
  margin-left: 22%;
}
a
{
  text-decoration: none;
  color: black;
  margin-left: 6px;
}
a:hover
{
  color: green;
}
</style>
</head>
<body>
<div id='page'>
  <h1>ToDo List</h1>
    <div id = 'main'>
    <?php
    if (isset($_SESSION['id'])) {
      ?>
        <div id='side'>

            <p> Welcome  <?php echo $_SESSION['name'];?> </p> <br><br>
            <center>
              <form method="post" action="home.php" class="input_form">
              <input type="text" name="task" class="task_input">
              <input type="hidden" name="user_id" class="task_input_user_id" value="<?php echo $_SESSION['id'];?>">
              <label class='error_msg'></label>
              <button type="submit" name="submit" id="add_btn" class="add_btn">Add Task</button>
              </form><br>
            </center>
            

            <?php if (isset($errors)) { ?>
              <p><?php echo $errors; ?></p>
            <?php } ?>

            <table class = 'task_table'>
              <tbody>
                <?php 

                $tasks = $con->fetchTask();

                $i = 1;
                if (is_array($tasks)) {
                  foreach ($tasks as $key => $value) { 
                    $checked = '';
                    if ($value['is_complete'] == 1) {
                      $checked = 'checked';
                    }
                    ?>
                    <tr>
                      <td> <input type="checkbox" name="mark_complete" value="<?php echo $value['id'] ?>" <?php echo $checked; ?>></td>
                      <td class="task"> <?php echo $value['task_detail']; ?> </td>
                      <td class="delete"> 
                        <a href="#" class = "delete" data-id = "<?php echo $value['id']?>">delete</a> 
                        <a href="#" class = "update" data-id = "<?php echo $value['id']?>">update</a>
                      </td>
                    </tr>
                  <?php $i++; }
                }
                 ?>
              </tbody>
            </table>
        </div>
        <br>
        <a href="logout.php"><input type = 'button' name = 'btn_logut' value = 'Logout'></a>
        <?php
    } else {
        ?>
        <a href="register.php"><input type = 'button' name = 'btn_ragister' value = 'Register' ></a>
        <a href="login.php"><input type ='button' name = 'btn_login' value = 'Login'></a>
    <?php
    }
    ?>
  	</p>
    </div>
</div>
<script>
  if(document.getElementsByClassName("example");)
</script>
</body>
</html>