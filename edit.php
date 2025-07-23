<?php
include('config/db_connect.php');

// Check if id is set
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // Fetch existing data
    $sql = "SELECT * FROM cohort_food WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $delicacy = mysqli_fetch_assoc($result);

    mysqli_free_result($result);
} else {
    header('Location: index.php');
    exit();
}

// Handle form submission
if (isset($_POST['update'])) {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $ingredients = mysqli_real_escape_string($conn, $_POST['ingredients']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "UPDATE cohort_food SET title='$title', ingredients='$ingredients', email='$email' WHERE id=$id";

    if (mysqli_query($conn, $sql)) {
        header('Location: details.php?id=' . $id);
        exit();
    } else {
        echo 'Update error: ' . mysqli_error($conn);
    }
}

mysqli_close($conn);
?>

<!DOCTYPE html>
<html>
<?php include('templates/header.php'); ?>

<div class="container my-5">
    <h4>Edit Delicacy</h4>
    <form action="" method="POST">
        <div class="mb-3">
            <label for="title" class="form-label">Title:</label>
            <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($delicacy['title']); ?>">
        </div>
        <div class="mb-3">
            <label for="ingredients" class="form-label">Ingredients:</label>
            <input type="text" name="ingredients" class="form-control" value="<?php echo htmlspecialchars($delicacy['ingredients']); ?>" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email:</label>
            <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($delicacy['email']); ?>" required>
        </div>
        <button type="submit" name="update" class="btn btn-primary">Update</button>
        <a href="details.php?id=<?php echo $id; ?>" class="btn btn-secondary ms-2">Cancel</a>
    </form>
</div>

<?php include('templates/footer.php'); ?>
</html>