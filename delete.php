<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="index.php">App Reviews</a>
    <div class="navbar-nav">
      <a class="nav-link" href="index.php">Reviews</a>
      <a class="nav-link" href="categories.php">Categories</a>
      <a class="nav-link" href="comments.php">Comments</a>
    </div>
  </div>
</nav>
<?php include 'db.php'; ?>
<?php
$id = $_GET['id'];
$conn->query("DELETE FROM reviews WHERE id = $id");
header("Location: index.php");
?>
