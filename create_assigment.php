<?php
include 'db.php';

if(isset($_POST['submit'])){

    $title = $_POST['title'];
    $description = $_POST['description'];
    $due_date = $_POST['due_date'];

    $sql = "INSERT INTO assignments (title, description, due_date)
            VALUES ('$title', '$description', '$due_date')";

    if($conn->query($sql) === TRUE){
        echo "Assignment berjaya ditambah!";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create Assignment</title>
</head>
<body>

<h2>Create Assignment</h2>

<form method="POST">
    <label>Title:</label><br>
    <input type="text" name="title" required><br><br>

    <label>Description:</label><br>
    <textarea name="description" required></textarea><br><br>

    <label>Due Date:</label><br>
    <input type="date" name="due_date" required><br><br>

    <button type="submit" name="submit">Create</button>
</form>

</body>
</html>