<?php
// Lấy dữ liệu từ form
$maNguoiDung = isset($_POST['MaNguoiDung']) ? intval($_POST['MaNguoiDung']) : 0;
$hoVaTen = isset($_POST['HoVaTen']) ? trim($_POST['HoVaTen']) : '';

// Kiểm tra dữ liệu
if ($maNguoiDung <= 0 || empty($hoVaTen)) {
    echo "<div class='message error'>";
    echo "Dữ liệu không hợp lệ!<br>";
    echo "<a href='index.php?do=hosocanhan' class='button-link'>Quay lại</a>";
    echo "</div>";
    exit;
}

// Cập nhật thông tin
$sql = "UPDATE tbl_nguoidung SET TenNguoiDung = ? WHERE MaNguoiDung = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("si", $hoVaTen, $maNguoiDung);

if ($stmt->execute()) {
    $_SESSION['HoTen'] = $hoVaTen;
    echo "<div class='message success'>";
    echo "Cập nhật hồ sơ thành công!<br>";
    echo "<a href='index.php?do=hosocanhan' class='button-link'>Quay lại hồ sơ</a>";
    echo "</div>";
} else {
    echo "<div class='message error'>";
    echo "Cập nhật thất bại: " . htmlspecialchars($connect->error) . "<br>";
    echo "<a href='index.php?do=hosocanhan' class='button-link'>Quay lại hồ sơ</a>";
    echo "</div>";
}

// Đóng kết nối
$stmt->close();
$connect->close();
?>
