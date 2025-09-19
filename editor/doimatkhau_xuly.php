<?php
if (!isset($_SESSION['MaNguoiDung']) || empty($_SESSION['MaNguoiDung'])) {
    die("Bạn chưa đăng nhập.");
}

$maNguoiDung = isset($_POST['MaNguoiDung']) ? intval($_POST['MaNguoiDung']) : 0;
$matKhauCu = isset($_POST['MatKhauCu']) ? trim($_POST['MatKhauCu']) : '';
$matKhauMoi = isset($_POST['MatKhauMoi']) ? trim($_POST['MatKhauMoi']) : '';
$xacNhanMatKhauMoi = isset($_POST['XacNhanMatKhauMoi']) ? trim($_POST['XacNhanMatKhauMoi']) : '';

if ($maNguoiDung <= 0 || empty($matKhauCu) || empty($matKhauMoi) || empty($xacNhanMatKhauMoi)) {
    echo "<div class='message error'>";
    echo "Vui lòng điền đầy đủ thông tin!";
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Quay lại</a></div>";
    echo "</div>";
    exit;
}

if ($matKhauMoi !== $xacNhanMatKhauMoi) {
    echo "<div class='message error'>";
    echo "Mật khẩu mới và xác nhận mật khẩu không khớp!";
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Quay lại</a></div>";
    echo "</div>";
    exit;
}

// Lấy mật khẩu cũ từ CSDL
$sql = "SELECT MatKhau FROM tbl_nguoidung WHERE MaNguoiDung = ?";
$stmt = $connect->prepare($sql);
$stmt->bind_param("i", $maNguoiDung);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "<div class='message error'>";
    echo "Người dùng không tồn tại!";
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Quay lại</a></div>";
    echo "</div>";
    exit;
}

$row = $result->fetch_assoc();
$matKhauTrongDB = $row['MatKhau'];

// So sánh mật khẩu cũ với MD5
if (md5($matKhauCu) !== $matKhauTrongDB) {
    echo "<div class='message error'>";
    echo "Mật khẩu cũ không đúng!";
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Quay lại</a></div>";
    echo "</div>";
    exit;
}

// Mã hóa mật khẩu mới bằng MD5 trước khi lưu
$matKhauMoiMD5 = md5($matKhauMoi);

// Cập nhật mật khẩu mới vào CSDL
$sqlUpdate = "UPDATE tbl_nguoidung SET MatKhau = ? WHERE MaNguoiDung = ?";
$stmtUpdate = $connect->prepare($sqlUpdate);
$stmtUpdate->bind_param("si", $matKhauMoiMD5, $maNguoiDung);

if ($stmtUpdate->execute()) {
    echo "<div class='message success'>";
    echo "Đổi mật khẩu thành công!";
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Quay lại đổi mật khẩu</a></div>";
    echo "</div>";
} else {
    echo "<div class='message error'>";
    echo "Có lỗi xảy ra khi cập nhật mật khẩu: " . $connect->error;
    echo "<div style='text-align:center; margin-top: 15px;'><a href='index.php?do=doimatkhau' class='button-link'>Thử lại</a></div>";
    echo "</div>";
}

$stmt->close();
$stmtUpdate->close();
$connect->close();
?>
