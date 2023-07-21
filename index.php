<?php
session_start();
include_once "./templates/header.php";
require_once "./config.php";

try {
    $sql = "SELECT *, CONCAT(first_name, ' ', last_name) AS full_name FROM employees";
    $result = $conn->query($sql);
    // $employees = $result->fetchAll(PDO::FETCH_ASSOC);
    // $employees = $result->fetchAll(PDO::FETCH_OBJ);
    $employees = $result->fetchAll();
    // print_r($employees);
} catch (PDOException $e) {
    echo $e->getMessage();
} finally {
    $conn = null;
}
?>

<div class="row">
    <div class="col-12">
        <?php if (isset($_SESSION['success_msg'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?= $_SESSION['success_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['success_msg']);
        endif; ?>
        <?php if (isset($_SESSION['error_msg'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?= $_SESSION['error_msg'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php unset($_SESSION['error_msg']);
        endif; ?>
        <div class="card">
            <div class="card-header d-md-flex justify-content-between align-items-center">
                <h1 class="card-title fw-light">Employees</h1>
                <a href="./create.php" class="btn btn-primary">Add New Employee</a>
            </div>
            <div class="card-body">
                <?php if (empty($employees)) : ?>
                    <p class="lead text-center">No employees yet</p>
                <?php endif; ?>

                <?php if (!empty($employees)) : ?>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Date Added</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($employees as $employee) : ?>
                                    <tr>
                                        <td><?= $employee->full_name ?></td>
                                        <td><?= date_format(date_create($employee->date_added), 'F j, Y h:i:s a') ?></td>
                                        <td>
                                            <a class="btn btn-info" href="./show.php?id=<?= $employee->id ?>">View</a>
                                            <a class="btn btn-success" href="./edit.php?id=<?= $employee->id ?>">Edit</a>
                                            <button class="btn btn-danger delete-employee" value="<?= $employee->id ?>">Delete</button>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once "./templates/footer.php"; ?>