<?php 
include 'db.php';

if(!isset($_GET["id"]) && !is_numeric($_GET["id"])) {
    header("Location: index.php?msg=error");
    exit;
}
$id = $_GET["id"];

if($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = trim($_POST["title"]);
    $year = trim($_POST["year"]);
    $author = trim($_POST["author"]);
    $price = trim($_POST["price"]);
    $category = trim($_POST["category"]);

    if(!empty($title) && !empty($author)) {
        $stmt = $conn->prepare("UPDATE books SET title=?, author=?, category=?, price=?, year=? WHERE id=?");
        $stmt->bind_param("sssdii", $title, $author, $category, $price, $year, $id);

        if($stmt->execute()) {
            header("Location: index.php?msg=updated");
            exit;
        } else {
            $error = "❌ Cập nhật thất bại: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "⚠️ Vui lòng nhập đầy đủ Tên sách và Tác giả!";
    }
}

$stmt = $conn->prepare("SELECT * FROM books WHERE id=?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$book = $result->fetch_assoc();

if(!$book) {
    header("Location: index.php?msg=error");
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cập nhật sách</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3 class="mb-4">✏️ Cập nhật thông tin sách</h3>

    <?php if (isset($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Tên sách</label>
            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($book['title']) ?>" required>
        </div>
        <div class="col-md-6">
            <label class="form-label">Tác giả</label>
            <input type="text" name="author" class="form-control" value="<?= htmlspecialchars($book['author']) ?>" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Thể loại</label>
            <input type="text" name="category" class="form-control" value="<?= htmlspecialchars($book['category']) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Giá</label>
            <input type="number" step="0.01" name="price" class="form-control" value="<?= htmlspecialchars($book['price']) ?>">
        </div>
        <div class="col-md-4">
            <label class="form-label">Năm</label>
            <input type="number" name="year" class="form-control" value="<?= htmlspecialchars($book['year']) ?>">
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">💾 Lưu thay đổi</button>
            <a href="index.php" class="btn btn-secondary">⬅️ Quay lại</a>
        </div>
    </form>
</div>
</body>
</html>
