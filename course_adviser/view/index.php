<?php 
session_start();
if(isset($_SESSION['courseAdvisorID'])) {
  header('Location: dashboard');
} else {
  header('Location: ../auth/login');
}
?>
<!--
  Redirect to the auth folder for user authentication if user not logged in
-->