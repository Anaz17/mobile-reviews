<?php include 'db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Comments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">💬 Comments Page</h2>
    <a href="index.php" class="btn btn-secondary mb-3">⬅ Back to Reviews</a>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $review_id = $_POST["review_id"];
        $comment = $_POST["comment"];
        $created_at = date("Y-m-d H:i:s");

        $sql = "INSERT INTO comments (review_id, comment, created_at) 
                VALUES ('$review_id', '$comment', '$created_at')";
        if ($conn->query($sql)) {
            header("Location: comments.php");
        } else {
            echo "<div class='alert alert-danger'>Error: " . $conn->error . "</div>";
        }
    }
    ?>

    <!-- Comment Form -->
    <form method="POST" class="card p-3 mb-4 shadow-sm">
        <div class="mb-3">
            <label>Select Review</label>
            <select name="review_id" class="form-control" required>
                <option value="">-- Select --</option>
                <?php
                $reviews = $conn->query("SELECT id, title FROM reviews");
                while ($r = $reviews->fetch_assoc()) {
                    echo "<option value='{$r['id']}'>{$r['title']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label>Comment</label>
            <textarea name="comment" class="form-control" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Add Comment</button>
    </form>

    <!-- Comment List -->
    <h4>All Comments</h4>
    <table class="table table-bordered">
        <thead class="table-dark">
            <tr>
                <th>Review Title</th>
                <th>Comment</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $result = $conn->query("
            SELECT c.comment, c.created_at, r.title 
            FROM comments c 
            JOIN reviews r ON c.review_id = r.id 
            ORDER BY c.created_at DESC
        ");
        if (!$result) {
            echo "<tr><td colspan='3' class='text-danger'>Query failed: " . $conn->error . "</td></tr>";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['title']}</td>";
                echo "<td>{$row['comment']}</td>";
                echo "<td>" . date("d M Y, h:i A", strtotime($row['created_at'])) . "</td>";
                echo "</tr>";
            }
        }
        ?>
        </tbody>
    </table>
</div>

</body>
</html>
