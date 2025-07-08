<?php include 'db.php'; ?>

<?php
if (!isset($_GET['id'])) {
    echo "No review selected.";
    exit;
}

$id = $_GET['id'];
$data = $conn->query("SELECT * FROM reviews WHERE id=$id")->fetch_assoc();

if (!$data) {
    echo "Review not found.";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $content = $_POST["content"];
    $category = $_POST["category"];
    $is_active = $_POST["is_active"];
    $updated_at = date("Y-m-d H:i:s");

    // Handle image (optional)
    if ($_FILES["image"]["name"]) {
        $image = $_FILES["image"]["name"];
        move_uploaded_file($_FILES["image"]["tmp_name"], "uploads/" . $image);
        $conn->query("UPDATE reviews SET image='$image' WHERE id=$id");
    }

    $sql = "UPDATE reviews SET 
            title='$title', content='$content', category='$category',
            is_active='$is_active', updated_at='$updated_at' 
            WHERE id=$id";

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
    <title>Edit Review</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <h2>Edit Review</h2>

    <form method="POST" enctype="multipart/form-data" class="card p-4 shadow-sm bg-white">
        <div class="mb-3">
            <label>Title</label>
            <input type="text" name="title" value="<?= $data['title'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Content</label>
            <textarea name="content" class="form-control"><?= $data['content'] ?></textarea>
        </div>

        <div class="mb-3">
            <label>Category</label>
            <input type="text" name="category" value="<?= $data['category'] ?>" class="form-control" required>
        </div>

        <div class="mb-3">
            <label>Change Image</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="mb-3">
            <label>Status</label>
            <select name="is_active" class="form-control">
                <option value="1" <?= $data['is_active'] == 1 ? 'selected' : '' ?>>Active</option>
                <option value="0" <?= $data['is_active'] == 0 ? 'selected' : '' ?>>Inactive</option>
            </select>
        </div>

        <button class="btn btn-primary">Update</button>
        <a href="index.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
