<?php
// logout.php
require_once 'inc/config.php';
require_once 'inc/template.php';

session_unset();
session_destroy();
header('Location: index.php');
exit;
?>