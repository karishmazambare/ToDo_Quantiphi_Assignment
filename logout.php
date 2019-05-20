<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION)) {
    session_start();
}
unset($_SESSION['username']);
session_destroy();
header('Location: home.php'); /* Redirect browser to home after login */
