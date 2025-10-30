<?php
include 'db.php';

$search = "";
if(isset($_GET["search"]) && trim($_GET['search']) !== "") {
    $search = trim($_GET["search"]);
    $stmt = $conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $like);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM books");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Sách - Danh Sách</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
</head>
<body>
<nav class="navbar navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand fw-bold" href="#">📚 Book Manager</a>
        <div>
            <a href="create.php" class="btn btn-success">+ Thêm sách</a>
        </div>
    </div>
</nav>
<div class="container mt-4">
    <!-- Message -->
    <?php if(isset($_GET["msg"])): ?>
        <?php if ($_GET['msg'] === 'added'): ?>
            <div class="alert alert-success">✅ Thêm sách thành công.</div>
        <?php elseif ($_GET['msg'] === 'deleted'): ?>
            <div class="alert alert-success">🗑️ Xóa sách thành công.</div>
        <?php elseif ($_GET['msg'] === 'updated'): ?>
            <div class="alert alert-success">✏️ Cập nhật thành công.</div>
        <?php elseif ($_GET['msg'] === 'error'): ?>
            <div class="alert alert-danger">❌ Đã có lỗi. Vui lòng thử lại.</div>
        <?php endif; ?> 
    <?php endif; ?>

    <div class="d-flex align-items-center mb-3 gap-3">
        <!-- Search form -->
         <form class="d-flex w-100" method="GET" action="">
            <input 
            class="form-control me-2" type="search" name="search" 
            placeholder="Tìm theo tên sách hoặc tác giả" aria-label="Search"
            value="<?= isset($_GET["search"]) ? htmlspecialchars($_GET["search"]) : '' ?>"
            >
            <button class="btn btn-outline-primary" type="submit">Tìm kiếm</button>
         </form>
         <!-- Optional: Clear search button -->
        <?php if ($search !== ""): ?>
            <a href="index.php" class="btn btn-outline-secondary">Xóa</a>
        <?php endif; ?>
    </div>
    <div class="table-wrap">
        <h5 class="mb-3">Danh sách sách</h5>

        <?php if ($result && $result->num_rows > 0): ?>
            <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th style="width:70px">ID</th>
                        <th>Tên sách</th>
                        <th style="width:180px">Tác giả</th>
                        <th style="width:140px">Thể loại</th>
                        <th style="width:120px">Giá</th>
                        <th style="width:120px">Năm</th>
                        <th style="width:140px">Ngày tạo</th>
                        <th style="width:120px">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= $row['id'] ?></td>
                            <td><?= htmlspecialchars($row['title']) ?></td>
                            <td><?= htmlspecialchars($row['author']) ?></td>
                            <td><?= htmlspecialchars($row['category']) ?></td>
                            <td><?= $row['price'] === null ? '-' : number_format($row['price'], 0, ',', '.') ?></td>
                            <td><?= $row['year'] ?: '-' ?></td>
                            <td><?= $row['created_at'] ?></td>
                            <td class="action-links">
                                <a href="update.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary">Sửa</a>
                                <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger"
                                   onclick="return confirm('Bạn có chắc muốn xóa sách này không?')">Xóa</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            </div>
        <?php else: ?>
            <div class="no-data">
                <?php if ($search !== ""): ?>
                    Không tìm thấy kết quả cho "<strong><?= htmlspecialchars($search) ?></strong>"
                <?php else: ?>
                    Chưa có sách nào. Hãy thêm sách mới.
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>