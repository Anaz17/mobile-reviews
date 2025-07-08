<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Review List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2 class="mb-4">📱 Application Reviews</h2>

    <div class="mb-3 d-flex flex-wrap gap-2">
        <a href="create.php" class="btn btn-primary">➕ Add New Review</a>
        <a href="categories.php" class="btn btn-secondary">📁 Categories</a>
        <a href="comments.php" class="btn btn-secondary">💬 Comments</a>
        <a href="export_pdf.php" class="btn btn-danger">🖨 Export PDF</a>
    </div>

    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>Image</th>
                <th>Title</th>
                <th>Category</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("SELECT * FROM reviews ORDER BY id DESC");
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td><img src='uploads/{$row['image']}' width='70'></td>";
            echo "<td>{$row['title']}</td>";
            echo "<td>{$row['category']}</td>";

            if ($row['is_active']) {
                echo "<td><span class='badge bg-success'>Active</span></td>";
            } else {
                echo "<td><span class='badge bg-secondary'>Inactive</span></td>";
            }

            echo "<td>
                    <a href='edit.php?id={$row['id']}' class='btn btn-sm btn-warning'>Edit</a>
                    <a href='delete.php?id={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirm(\"Delete this review?\")'>Delete</a>
                  </td>";
            echo "</tr>";
        }
        ?>
        </tbody>
    </table>
</div>
</body>
</html>
