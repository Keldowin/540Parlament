<?php
session_start();
session_destroy();
require_once 'Assets/TemplatesPages/functions.php';
header_safe('loginform.php');
?>