<?php
include_once '../includes/config.php';

// Kiểm tra tham số ID hợp lệ
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID người dùng không hợp lệ.";
    header("Location: index.php?do=nguoidung");
    exit();
}

$id = (int) $_GET['id'];
$thongBao = "";
$loi = "";

// Xử lý thay đổi quyền
if (isset($_GET['quyen']) && is_numeric($_GET['quyen'])) {
    $quyen = (int) $_GET['quyen'];
    $stmt = $connect->prepare("UPDATE tbl_nguoidung SET QuyenHan = ? WHERE MaNguoiDung = ?");
    $stmt->bind_param("ii", $quyen, $id);

    if ($stmt->execute()) {
        $thongBao = "Cập nhật quyền thành công.";
    } else {
        $loi = "Lỗi khi cập nhật quyền.";
    }
    $stmt->close();
}

// Xử lý khóa/mở tài khoản
elseif (isset($_GET['khoa']) && is_numeric($_GET['khoa'])) {
    $khoa = (int) $_GET['khoa'];
    $stmt = $connect->prepare("UPDATE tbl_nguoidung SET Khoa = ? WHERE MaNguoiDung = ?");
    $stmt->bind_param("ii", $khoa, $id);

    if ($stmt->execute()) {
        $thongBao = ($khoa === 1) ? "Đã khóa tài khoản." : "Đã mở khóa tài khoản.";
    } else {
        $loi = "Lỗi khi cập nhật trạng thái khóa.";
    }
    $stmt->close();
}

// Xử lý duyệt tài khoản (chuyển TrangThai từ 0 -> 1)
if (isset($_GET['duyet']) && $_GET['duyet'] == 1) {
    $stmt = $connect->prepare("UPDATE tbl_nguoidung SET TrangThai = 1 WHERE MaNguoiDung = ? AND TrangThai = 0");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $thongBao = "Đã duyệt tài khoản.";
    } else {
        $loi = "Lỗi khi duyệt tài khoản.";
    }
    $stmt->close();
}

// Xử lý xóa tài khoản
elseif (isset($_GET['xoa']) && $_GET['xoa'] == 1) {
    $stmt = $connect->prepare("DELETE FROM tbl_nguoidung WHERE MaNguoiDung = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $thongBao = "Đã xóa tài khoản.";
    } else {
        $loi = "Lỗi khi xóa tài khoản.";
    }
    $stmt->close();
}

// Nếu không có tham số hợp lệ
else {
    $_SESSION['error'] = "Tham số không hợp lệ.";
    header("Location: index.php?do=nguoidung");
    exit();
}

// Lưu thông báo vào session
if (!empty($thongBao)) {
    $_SESSION['success'] = $thongBao;
} elseif (!empty($loi)) {
    $_SESSION['error'] = $loi;
}

// Quay về danh sách người dùng
header("Location: index.php?do=nguoidung");
exit();
?>
