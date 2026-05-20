<?php
session_start();
if(isset($_SESSION['studentID'])) {
  header('Location: dashboard');
} else {
  header('Location: ../auth/login');
}
?>
<!--
  Redirect to the auth folder for user authentication if user not logged in
-->