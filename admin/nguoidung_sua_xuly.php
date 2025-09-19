<?php
session_start();
include_once '../includes/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu gửi lên
    $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
    $tenNguoiDung = isset($_POST['TenNguoiDung']) ? trim($_POST['TenNguoiDung']) : '';
    $quyenHan = isset($_POST['QuyenHan']) ? intval($_POST['QuyenHan']) : 0;
    $khoa = isset($_POST['Khoa']) ? intval($_POST['Khoa']) : 0;

    if ($id <= 0) {
        $_SESSION['error'] = "ID người dùng không hợp lệ.";
        header("Location: index.php?do=nguoidung");
        exit();
    }

    if (empty($tenNguoiDung)) {
        $_SESSION['error'] = "Tên người dùng không được để trống.";
        header("Location: index.php?do=nguoidung_sua&id=$id");
        exit();
    }

    // Kiểm tra quyền hợp lệ (0,1,2)
    if (!in_array($quyenHan, [0, 1, 2])) {
        $_SESSION['error'] = "Quyền không hợp lệ.";
        header("Location: index.php?do=nguoidung_sua&id=$id");
        exit();
    }

    // Kiểm tra khóa hợp lệ (0 hoặc 1)
    if (!in_array($khoa, [0, 1])) {
        $_SESSION['error'] = "Trạng thái khóa không hợp lệ.";
        header("Location: index.php?do=nguoidung_sua&id=$id");
        exit();
    }

    // Cập nhật dữ liệu
    $stmt = $connect->prepare("UPDATE tbl_nguoidung SET TenNguoiDung = ?, QuyenHan = ?, Khoa = ? WHERE MaNguoiDung = ?");
    if (!$stmt) {
        $_SESSION['error'] = "Lỗi chuẩn bị câu lệnh: " . $connect->error;
        header("Location: index.php?do=nguoidung_sua&id=$id");
        exit();
    }

    $stmt->bind_param("siii", $tenNguoiDung, $quyenHan, $khoa, $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Cập nhật người dùng thành công!";
    } else {
        $_SESSION['error'] = "Lỗi cập nhật người dùng: " . $stmt->error;
    }

    $stmt->close();
    header("Location: index.php?do=nguoidung");
    exit();
} else {
    // Nếu không phải POST thì chuyển hướng về trang danh sách
    header("Location: index.php?do=nguoidung");
    exit();
}
