<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();

require_once __DIR__ . '/config/config.php';

isset($_SESSION['usuario']) ? $postear = 'pages/posts.php' : $postear = 'pages/security/login.php';

// __DIR__ para asegurar que siempre se referencie bien desde cualquier lugar
include __DIR__ . '/includes/header.php';
include __DIR__ . '/pages/home.php';
include __DIR__ . '/includes/footer.php';
?>