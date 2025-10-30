<?php
include 'db.php';

if(isset($_GET["id"]) && is_numeric($_GET["id"])) {
    $id = $_GET["id"];
    $stmt = $conn->prepare("DELETE FROM books WHERE id = ?");
    $stmt->bind_param("i", $id);

    if($stmt->execute()) {
        header("Location: index.php?msg=deleted");
        exit;
    } else {
        header("Location: index.php?msg=error");
        exit;
    }

    $stmt->close();
} else {
    header("Location: index.php?msg=error");
    exit;
}

?>