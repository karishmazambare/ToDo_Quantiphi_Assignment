<?php

if (!isset($_SESSION)) {
    session_start();
}
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once 'DBconnect.php';
$con = DBconnect::createObj();

if ($_POST['call'] == 'add_task') {
    if (empty($_POST['task'])) {
        die;
    }else{
        $con->insertTask($_POST['task']);
        die;
    }
}

if ($_POST['call'] == 'delete_task') {
    if (empty($_POST['taskId'])) {
        die;
    }else{
        $con->deleteTask($_POST['taskId']);
        die;
    }
}

if ($_POST['call'] == 'mark_complete') {
    if (empty($_POST['taskId'])) {
        die;
    }else{
        $con->markComplete($_POST['taskId'], $_POST['completeStatus']);
        die;
    }
}

if ($_POST['call'] == 'update_task') {
    if (empty($_POST['taskId']) || empty($_POST['task'])) {
        die;
    }else{
        $con->updateTask($_POST['task'], $_POST['taskId']);
        die;
    }
}
