<?php
$host = "localhost";
$dbname = "employee_management";
$username = "root";
$password = "";
$port = 3307;

$dsn = "mysql:host=$host;port=$port;dbname=$dbname";

// Create connection
try {
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    // echo "Connection Successful!";
} catch (PDOException $e) {
    echo "Connection Failed! " . $e->getMessage();
}