<?php
require_once 'config/config.php';

unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_type']);
unset($_SESSION['admin_sesion']);
session_destroy();

header('Location: index.php');