<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'includes/config.php';

$tenNguoiDung = $_POST['fullname'] ?? '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';
$password_confirm = $_POST['password_confirm'] ?? '';
$quyenhan = $_POST['quyenhan'] ?? 0;

if (empty($tenNguoiDung) || empty($username) || empty($password) || empty($password_confirm)) {
    $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
    header('Location: register.php');
    exit;
}

if ($password !== $password_confirm) {
    $_SESSION['error'] = 'Mật khẩu xác nhận không khớp.';
    header('Location: register.php');
    exit;
}

$sql = "SELECT * FROM tbl_nguoidung WHERE TenDangNhap = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param('s', $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $_SESSION['error'] = 'Tên đăng nhập đã được sử dụng.';
    header('Location: register.php');
    exit;
}

$password_hash = md5($password);

$trangthai = ($quyenhan == 2) ? 0 : 1;

$sql_insert = "INSERT INTO tbl_nguoidung (TenNguoiDung, TenDangNhap, MatKhau, QuyenHan, TrangThai, Khoa) VALUES (?, ?, ?, ?, ?, 0)";
$stmt_insert = $connect->prepare($sql_insert);
$stmt_insert->bind_param('sssii', $tenNguoiDung, $username, $password_hash, $quyenhan, $trangthai);

if ($stmt_insert->execute()) {
    if ($quyenhan == 2) {
        $_SESSION['success'] = 'Đăng ký thành công. Tài khoản Editor đang chờ admin duyệt.';
    } else {
        $_SESSION['success'] = 'Đăng ký thành công. Bạn có thể đăng nhập ngay bây giờ.';
    }
    header('Location: login.php');
    exit;
} else {
    $_SESSION['error'] = 'Lỗi hệ thống, vui lòng thử lại.';
    header('Location: register.php');
    exit;
}

?>
