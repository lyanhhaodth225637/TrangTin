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

<?php
$sql = "SELECT * FROM `tbl_nguoidung` WHERE MaNguoiDung = " . intval($_SESSION['MaNguoiDung']);
$danhsach = $connect->query($sql);

if (!$danhsach) {
    die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
}

$dong = $danhsach->fetch_array(MYSQLI_ASSOC);
?>

<h3>Hồ sơ cá nhân</h3>
<form class="UserProfileForm" action="index.php?do=hosocanhan_xuly" method="post">
    <input type="hidden" value="<?php echo $dong['MaNguoiDung']; ?>" name="MaNguoiDung" />
    <table class="UserProfileTable">
        <tr>
            <td>
                <span class="ProfileLabel">Họ và tên:</span>
                <input type="text" value="<?php echo $dong['TenNguoiDung']; ?>" name="HoVaTen" class="ProfileInput" />
            </td>
        </tr>
        <tr>
            <td>
                <span class="ProfileLabel">Tên đăng nhập:</span>
                <input type="text" value="<?php echo $dong['TenDangNhap']; ?>" name="TenDangNhap" class="ProfileInput" disabled />
            </td>
        </tr>
    </table>
    <input type="submit" value="Cập nhật hồ sơ" class="SubmitButton" />
</form>
