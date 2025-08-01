<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

isset($_SESSION['usuario']) ? $postear = 'posts.php' : $postear = 'security/login.php';

include 'includes/header.php';

include 'includes/navbar.php';

include 'pages/home.php';

include 'includes/footer.php'

    ?>