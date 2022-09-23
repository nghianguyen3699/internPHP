<?php
    define('DATABASE_HOST', '192.168.1.215');
    define('DATABASE_USER', 'root');
    define('DATABASE_PASSWORD', 'cms-8341');
    define('DATABASE_NAME', 'mysql');

    $conn = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD, DATABASE_NAME);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
?>