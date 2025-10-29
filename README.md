# 📚 Dự án Quản Lý Sách (Book Management System)

## 🧩 Giới thiệu

Dự án **Quản lý sách** là ứng dụng CRUD cơ bản (Create - Read - Update - Delete) được xây dựng bằng **PHP + MySQL**.  
Mục tiêu của dự án:

- Thực hành thao tác với cơ sở dữ liệu MySQL.
- Thành thạo xử lý form và prepared statement trong PHP.
- Nắm vững quy trình CRUD thực tế.

---

## 🗂️ Cấu trúc thư mục

```plaintext
book-manager/
│
├── db.php # File kết nối database
├── index.php # Trang hiển thị danh sách + tìm kiếm
├── create.php # Xử lý thêm sách
├── update.php # Cập nhật thông tin sách
├── delete.php # Xóa sách
├── assets/
│ └── style.css # (tuỳ chọn) chứa CSS
└── README.md # Tài liệu mô tả dự án
```

---

## 🧱 Cấu trúc bảng Database (MySQL)

**Tên database:** `book_manager`

**Tên bảng:** `books`

| Trường     | Kiểu dữ liệu                      | Ghi chú      |
| ---------- | --------------------------------- | ------------ |
| id         | INT (AUTO_INCREMENT, PRIMARY KEY) | Mã sách      |
| title      | VARCHAR(255)                      | Tên sách     |
| author     | VARCHAR(255)                      | Tác giả      |
| category   | VARCHAR(100)                      | Thể loại     |
| price      | DECIMAL(10,2)                     | Giá bán      |
| year       | INT                               | Năm xuất bản |
| created_at | TIMESTAMP                         | Ngày thêm    |

---

## ⚙️ Các bước cài đặt

1️⃣ Tạo database:

```sql
CREATE DATABASE book_manager;
USE book_manager;
```

2️⃣ Tạo bảng:

```sql
CREATE TABLE books (
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  author VARCHAR(255) NOT NULL,
  category VARCHAR(100),
  price DECIMAL(10,2),
  year INT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

3️⃣ Cập nhật file db.php:

```php
<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_manager";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>
```

🧠 Các chức năng chính
✅ Thêm sách mới
✅ Hiển thị danh sách sách
✅ Cập nhật thông tin sách
✅ Xóa sách
✅ Tìm kiếm theo tên hoặc tác giả
✅ Hiển thị thông báo (success/error)
✅ Giao diện thân thiện, dễ sử dụng

💡 Gợi ý mở rộng (tùy chọn)

Thêm phân trang (pagination).

Upload ảnh bìa sách.

Xác thực dữ liệu nâng cao (validate form).

Dùng AJAX để cập nhật mà không cần reload trang.

Dùng React hoặc Vue để làm frontend.

👨‍💻 Tác giả
Họ tên: Đặng Trung Tín
Ngày bắt đầu: [29/10/2025]
Ngôn ngữ: PHP, MySQL, HTML, CSS, Javascript
IDE: VS Code

📸 Giao diện demo

🧾 Ghi chú

Nếu bạn gặp lỗi “Cannot connect to database”, hãy kiểm tra lại db.php.

Nếu khi cập nhật không chuyển trang, thêm exit; sau header("Location: index.php").
