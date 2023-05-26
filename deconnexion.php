<?php 
session_start();
unset($SESSION["user"]);

header("Location: index.php");