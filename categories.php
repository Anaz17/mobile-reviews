<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Categories</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Category List</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Back to Reviews</a>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $name = $_POST['name'];

        $sql = "INSERT INTO categories (name) VALUES ('$name')";
        if ($conn->query($sql)) {
            header("Location: categories.php");
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
    ?>

    <!-- Category Form -->
    <form method="POST" class="mb-4">
        <div class="mb-3">
            <label>Add New Category:</label>
            <input type="text" name="name" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Add</button>
    </form>

    <!-- Category List -->
    <h4>All Categories</h4>
    <table class="table table-bordered">
        <tr class="table-dark">
            <th>ID</th>
            <th>Category Name</th>
        </tr>
        <?php
        $result = $conn->query("SELECT * FROM categories");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['id']}</td>";
            echo "<td>{$row['name']}</td>";
            echo "</tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
