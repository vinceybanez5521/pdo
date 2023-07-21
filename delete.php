<?php
echo "Delte";
session_start();
require_once "./config.php";

if(isset($_POST['id'])) {
    $id= $_POST['id'];

    $sql = "DELETE FROM employees WHERE id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);

    if($stmt->execute()) {
        $_SESSION['success_msg'] = "Employee Deleted!";
    } else {
        $_SESSION['error_msg'] = "Employee Not Deleted!";
    }

    $conn = null;
}