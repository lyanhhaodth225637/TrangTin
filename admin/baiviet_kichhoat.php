<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once '../includes/config.php';

// Kiểm tra quyền admin
if (!isset($_SESSION['QuyenHan']) || $_SESSION['QuyenHan'] != 1) {
    echo "Bạn không có quyền thực hiện thao tác này.";
    exit();
}

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = (int)$_GET['id'];

    // Duyệt bài
    if (isset($_GET['duyet'])) {
        $stmt = $connect->prepare("UPDATE tbl_noidungtin SET KiemDuyet = 1 WHERE MaBaiViet = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Đã duyệt bài viết.";
    }

    // Xóa bài
    if (isset($_GET['xoa'])) {
        $stmt = $connect->prepare("DELETE FROM tbl_noidungtin WHERE MaBaiViet = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();

        $_SESSION['success'] = "Đã xóa bài viết.";
    }
} else {
    $_SESSION['error'] = "ID không hợp lệ.";
}

// Quay lại danh sách
header("Location: index.php?do=baiviet_kiemduyet");
exit();
