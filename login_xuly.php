<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include_once 'includes/config.php';

$tenDangNhap = $_POST['username'] ?? '';
$matKhau = $_POST['password'] ?? '';

if (empty($tenDangNhap) || empty($matKhau)) {
    echo "<script>alert('Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.'); window.location.href='login.php';</script>";
    exit;
}

$matKhauMd5 = md5($matKhau);

$sql = "SELECT * FROM tbl_nguoidung WHERE TenDangNhap = ? AND MatKhau = ?";
$stmt = $connect->prepare($sql);

if (!$stmt) {
    echo "<script>alert('Lỗi hệ thống, vui lòng thử lại sau.'); window.location.href='login.php';</script>";
    exit;
}

$stmt->bind_param("ss", $tenDangNhap, $matKhauMd5);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $user = $result->fetch_assoc();

    if ($user['Khoa'] == 1) {
        echo "<script>alert('Tài khoản đã bị khóa. Vui lòng liên hệ quản trị viên.'); window.location.href='login.php';</script>";
        exit;
    }

    if ($user['TrangThai'] != 1) {
        echo "<script>alert('Tài khoản chưa được duyệt. Vui lòng chờ admin duyệt.'); window.location.href='login.php';</script>";
        exit;
    }
    
    $_SESSION['MaNguoiDung'] = $user['MaNguoiDung'];
    $_SESSION['TenNguoiDung'] = $user['TenNguoiDung'];
    $_SESSION['QuyenHan'] = $user['QuyenHan'];

    
    if ($user['QuyenHan'] == 1) {
        header("Location: admin/index.php");
    } elseif ($user['QuyenHan'] == 2) {
        header("Location: editor/index.php"); 
    } else {
        header("Location: /index.php");
    }
    exit;

} else {
    echo "<script>alert('Sai tên đăng nhập hoặc mật khẩu.'); window.location.href='login.php';</script>";
    exit;
}
