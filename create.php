<?php
include 'db.php';

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = trim($_POST["title"]);
    $year = trim($_POST["year"]);
    $author = trim($_POST["author"]);
    $price = trim($_POST["price"]);
    $category = trim($_POST["category"]);

    if(!empty($title) || !empty($author)) {
        $stmt = $conn->prepare("INSERT INTO books (title, author, category, price, year) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssdi", $title, $author, $category, $price, $year);

        if($stmt->execute()) {
            header("Location: index.php?msg=added");
            exit;
        } else {
            $error = "❌ Lỗi khi thêm sách: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $error = "⚠️ Vui lòng nhập đầy đủ Tên sách và Tác giả!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white text-center">
            <h4>📚 Thêm Sách Mới</h4>
        </div>
        <div class="card-body">
            <?php if(isset($error)): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>

            <form method="POST" action="">
                <div class="mb-3">
                    <label class="form-label">Tên sách</label>
                    <input type="text" name="title" class="form-control" placeholder="Nhập tên sách" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Tác giả</label>
                    <input type="text" name="author" class="form-control" placeholder="Nhập tên tác giả" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Thể loại</label>
                    <input type="text" name="category" class="form-control" placeholder="Nhập thể loại">
                </div>
                <div class="mb-3">
                    <label class="form-label">Giá bán</label>
                    <input type="number" step="0.01" name="price" class="form-control" placeholder="VD: 50000">
                </div>
                <div class="mb-3">
                    <label class="form-label">Năm xuất bản</label>
                    <input type="number" name="year" class="form-control" placeholder="VD: 2020">
                </div>
                <button type="submit" class="btn btn-success w-100">Thêm Sách</button>
            </form>
        </div>
        <div class="card-footer text-center">
            <a href="index.php" class="btn btn-secondary mt-2">← Quay lại danh sách</a>
        </div>
    </div>
</div>
</body>
</html>