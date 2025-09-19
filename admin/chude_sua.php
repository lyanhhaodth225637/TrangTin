<?php
    // Lấy chủ đề cần sửa "đổ" vào form
    $sql = "SELECT * FROM `tbl_chude` WHERE MaChuDe = " . $_GET['id'];
    $danhsach = $connect->query($sql);
    if (!$danhsach) {
        die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
        exit();
    }
    $dong = $danhsach->fetch_array(MYSQLI_ASSOC);
?>
<style>
    h3 {
        color: #990000;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 25px;
    }

    form.FormSuaChuDeContainer {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fbe2e2;
        padding: 30px;
        border: 1px solid #990000;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
    }

    table.FormSuaChuDe {
        width: 100%;
        border-collapse: collapse;
    }

    table.FormSuaChuDe td {
        padding: 12px 8px;
        vertical-align: top;
    }

    .MyFormLabel {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #990000;
    }

    .InputTenChuDe {
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

<h3>Sửa chủ đề</h3>
<form class="FormSuaChuDeContainer" action="index.php?do=chude_sua_xuly" method="post">
    <input type="hidden" name="MaChuDe" value="<?php echo $dong['MaChuDe']; ?>" />
    <table class="FormSuaChuDe">
        <tr>
            <td>
                <span class="MyFormLabel">Tên chủ đề:</span>
                <input type="text" name="TenChuDe" class="InputTenChuDe" value="<?php echo $dong['TenChuDe']; ?>" required />
            </td>
        </tr>
    </table>
    <input type="submit" value="Cập nhật" class="SubmitButton" />
</form>
