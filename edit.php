<?php
session_start();
include_once "./templates/header.php";
require_once "./config.php";

$first_name = $last_name = "";
$first_name_err = $last_name_err = "";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "SELECT * FROM employees WHERE id = :a";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":a", $id);
    $stmt->execute();
    $employee = $stmt->fetch();
    // print_r($employee);

    $first_name = $employee->first_name;
    $last_name = $employee->last_name;
}

if (isset($_POST['submit'])) {
    // Validate first name
    if (empty($_POST['first_name'])) {
        $first_name_err = "Please enter first name";
    } else {
        $first_name = $_POST['first_name'];
    }

    // Validate last name
    if (empty($_POST['last_name'])) {
        $last_name_err = "Please enter last name";
    } else {
        $last_name = $_POST['last_name'];
    }

    if (empty($first_name_err) && empty($last_name_err)) {
        $id = $_POST['id'];

        $sql = "UPDATE employees SET first_name = :a, last_name = :b WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":a", $first_name);
        $stmt->bindParam(":b", $last_name);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            $_SESSION['success_msg'] = "Employee Updated!";
            header('Location: index.php');
        } else {
            $_SESSION['error_msg'] = "Employee Not Updated!";
        }
    }

    $conn = null;
}
?>

<div class="row justify-content-center">
    <div class="col-md-8">
        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Edit Employee</h1>
                <a href="./index.php" class="btn btn-primary">Employees</a>
            </div>
            <div class="card-body">
                <form action="<?= $_SERVER['PHP_SELF'] ?>" method="POST" enctype="application/x-www-form-urlencoded">
                    <div class="mb-3">
                        <label for="first-name" class="form-label">First Name</label>
                        <input type="text" class="form-control <?= $first_name_err ? 'is-invalid' : null ?>" id="first-name" name="first_name" value="<?= $first_name ?>">
                        <span class="invalid-feedback">
                            <?= $first_name_err ?>
                        </span>
                    </div>
                    <div class="mb-3">
                        <label for="last-name" class="form-label">Last Name</label>
                        <input type="text" class="form-control <?= $last_name_err ? 'is-invalid' : null ?>" id="last-name" name="last_name" value="<?= $last_name ?>">
                        <span class="invalid-feedback">
                            <?= $last_name_err ?>
                        </span>
                    </div>
                    <input type="hidden" name="id" value="<?= $_GET['id'] ?>">
                    <button type="submit" name="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include_once "./templates/footer.php"; ?>