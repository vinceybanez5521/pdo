<?php
include_once "./templates/header.php";
require_once "./config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Positional Parameters
    $sql = "SELECT * FROM employees WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(1, $id);
    $stmt->execute();
    $employee = $stmt->fetch();

    // Named Parameters
    $sql = "SELECT * FROM employees WHERE id = :a";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":a", $id);
    $stmt->execute();
    $employee = $stmt->fetch();

    // print_r($employee);
    // print_r($stmt->rowCount());

    $conn = null;
}
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Employee Information</h1>
                <a href="./index.php" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <p>First Name: <strong><?= $employee->first_name ?></strong></p>
                <p>Last Name: <strong><?= $employee->last_name ?></strong></p>
                <p>Date Added: <strong><?= date_format(date_create($employee->date_added), 'F j, Y h:i:s a') ?></strong></p>
            </div>
        </div>
    </div>
</div>

<?php include_once "./templates/footer.php"; ?>