<?php
include_once '../includes/config.php';

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    $_SESSION['error'] = "ID người dùng không hợp lệ!";
    header("Location: index.php?do=nguoidung");
    exit();
}

$id = (int)$_GET['id'];

$stmt = $connect->prepare("SELECT * FROM tbl_nguoidung WHERE MaNguoiDung = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 0) {
    $_SESSION['error'] = "Không tìm thấy người dùng.";
    header("Location: index.php?do=nguoidung");
    exit();
}

$user = $result->fetch_assoc();
$stmt->close();
?>

<style>
    h3 {
        color: #990000;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 25px;
    }
    form.UserProfileForm {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fbe2e2;
        padding: 30px;
        border: 1px solid #990000;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
    }
    table.UserProfileTable {
        width: 100%;
        border-collapse: collapse;
    }
    table.UserProfileTable td {
        padding: 12px 8px;
        vertical-align: top;
    }
    .ProfileLabel {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #990000;
    }
    .ProfileInput {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #990000;
        border-radius: 4px;
        box-sizing: border-box;
    }
    .SubmitButton {
        background-color: #990000;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        margin-top: 20px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }
    .SubmitButton:hover {
        background-color: #cc0000;
    }
</style>

<h3>Sửa thông tin người dùng</h3>
<form class="UserProfileForm" method="POST" action="index.php?do=nguoidung_sua_xuly">
    <input type="hidden" name="id" value="<?= $user['MaNguoiDung'] ?>" />
    <table class="UserProfileTable">
        <tr>
            <td>
                <label class="ProfileLabel" for="TenNguoiDung">Họ và tên:</label>
                <input id="TenNguoiDung" type="text" name="TenNguoiDung" class="ProfileInput" value="<?= htmlspecialchars($user['TenNguoiDung']) ?>" required />
            </td>
        </tr>
        <tr>
            <td>
                <label class="ProfileLabel" for="TenDangNhap">Tên đăng nhập:</label>
                <input id="TenDangNhap" type="text" name="TenDangNhap" class="ProfileInput" value="<?= htmlspecialchars($user['TenDangNhap']) ?>" disabled />
            </td>
        </tr>
        <tr>
            <td>
                <label class="ProfileLabel" for="QuyenHan">Quyền:</label>
                <select id="QuyenHan" name="QuyenHan" class="ProfileInput" required>
                    <option value="0" <?= $user['QuyenHan'] == 0 ? 'selected' : '' ?>>Khách</option>
                    <option value="1" <?= $user['QuyenHan'] == 1 ? 'selected' : '' ?>>Quản trị viên</option>
                    <option value="2" <?= $user['QuyenHan'] == 2 ? 'selected' : '' ?>>Editor</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label class="ProfileLabel" for="Khoa">Trạng thái khóa:</label>
                <select id="Khoa" name="Khoa" class="ProfileInput" required>
                    <option value="0" <?= $user['Khoa'] == 0 ? 'selected' : '' ?>>Hoạt động</option>
                    <option value="1" <?= $user['Khoa'] == 1 ? 'selected' : '' ?>>Đã khóa</option>
                </select>
            </td>
        </tr>
    </table>
    <input type="submit" value="Cập nhật" class="SubmitButton" />
</form>
