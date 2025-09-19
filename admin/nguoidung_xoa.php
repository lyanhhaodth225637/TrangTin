<?php
// Kết nối database
include_once '../includes/config.php';

// Kiểm tra xem có tham số id không và id là số hợp lệ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("ID người dùng không hợp lệ.");
}

$id = intval($_GET['id']);

// Tránh xóa chính tài khoản đang đăng nhập (nếu cần)
session_start();
if (isset($_SESSION['MaNguoiDung']) && $_SESSION['MaNguoiDung'] == $id) {
    die("Bạn không thể xóa chính tài khoản đang đăng nhập.");
}

// Thực hiện câu lệnh xóa người dùng
$sql = "DELETE FROM `tbl_nguoidung` WHERE MaNguoiDung = $id";
$result = $connect->query($sql);

if ($result) {
    // Xóa thành công, chuyển hướng về trang danh sách người dùng
    header("Location: index.php?do=nguoidung");  // Đổi do=nguoidung_ds thành trang danh sách người dùng của bạn
    exit();
} else {
    echo "Xóa người dùng thất bại: " . $connect->error;
}
?>
