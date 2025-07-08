<?php include 'db.php'; ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category = $_POST["category"];
    $is_active = $_POST["is_active"];
    $created_at = date("Y-m-d H:i:s");
    $updated_at = $created_at;

    $image = $_FILES["image"]["name"];
    $temp = $_FILES["image"]["tmp_name"];

    // Create uploads folder if not exist
    if (!is_dir("uploads")) {
        mkdir("uploads");
    }

    move_uploaded_file($temp, "uploads/" . $image);

    $sql = "INSERT INTO reviews (title, content, category, image, is_active, created_at, updated_at)
            VALUES ('$title', '$content', '$category', '$image', '$is_active', '$created_at', '$updated_at')";

    if ($conn->query($sql)) {
        header("Location: index.php");
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">📝 Add New Review</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white">
        <div class="mb-3">
            <label class="form-label">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Content</label>
            <textarea name="content" class="form-control" required></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Category</label>
            <input type="text" name="category" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Image</label>
            <input type="file" name="image" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="is_active" class="form-control">
                <option value="1">Active</option>
                <option value="0">Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Submit</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>

</body>
</html>
