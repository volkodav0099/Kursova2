<?php
session_start();
unset($_SESSION["login"]);
unset($_SESSION["password"]);
header('location: ../login/index.php');