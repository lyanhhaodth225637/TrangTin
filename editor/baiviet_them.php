<style>
    h3 {
        color: #990000;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 25px;
    }

    form.FormDangBaiVietContainer {
        max-width: 800px;
        margin: 0 auto;
        background-color: #fbe2e2;
        padding: 30px;
        border: 1px solid #990000;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
    }

    table.FormDangBaiViet {
        width: 100%;
        border-collapse: collapse;
    }

    table.FormDangBaiViet td {
        padding: 12px 8px;
        vertical-align: top;
    }

    .MyFormLabel {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #990000;
    }

    .InputTieuDe,
    .InputChuDe,
    .InputTomTat,
    .InputHinhAnh,
    .InputChuThichAnh,
    .InputNoiDung {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #990000;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .InputTomTat,
    .InputNoiDung {
        min-height: 100px;
        resize: vertical;
    }

    .InputHinhAnh {
        border: none;
        margin-top: 4px;
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

    .cke_editor_NoiDung {
        border: 1px solid #990000;
        border-radius: 4px;
    }
</style>

<h3>Đăng bài viết</h3>
<script src="https://cdn.ckeditor.com/4.20.2/standard/ckeditor.js"></script>
<form class="FormDangBaiVietContainer" enctype="multipart/form-data" action="/editor/index.php?do=baiviet_them_xuly" method="post">
    <table class="FormDangBaiViet">
        <tr>
            <td>
                <span class="MyFormLabel">Tiêu đề:</span>
                <input type="text" name="TieuDe" class="InputTieuDe" />
            </td>
        </tr>
        <tr>
            <td>
                <span class="MyFormLabel">Chủ đề:</span>
                <select name="ChuDe" class="InputChuDe">
                    <option value="">-- Chọn --</option>
                    <?php
                        $sql = "SELECT * FROM `tbl_chude` ORDER BY TenChuDe";
                        $danhsach = $connect->query($sql);
                        if (!$danhsach) {
                            die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
                        }
                        while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {
                            echo "<option value='" . $dong['MaChuDe'] . "'>" . $dong['TenChuDe'] . "</option>";
                        }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <span class="MyFormLabel">Tóm tắt:</span>
                <textarea name="TomTat" class="InputTomTat" cols="50"></textarea>
            </td>
        </tr>
        <tr>
            <td>
                <span class="MyFormLabel">Hình ảnh:</span>
                <input type="file" name="HinhAnh" class="InputHinhAnh">
            </td>
        </tr>
        <tr>
            <td>
                <span class="MyFormLabel">Chú thích ảnh:</span>
                <input type="text" name="ChuThichAnh" class="InputChuThichAnh" size="50">
            </td>
        </tr>
        <tr>
            <td>
                <span class="MyFormLabel">Nội dung bài viết:</span>
                <textarea name="NoiDung" id="NoiDung" class="InputNoiDung"></textarea>
                <script>
                    CKEDITOR.replace('NoiDung');
                </script>
            </td>
        </tr>
    </table>
    <input type="submit" value="Đăng bài" class="SubmitButton" />
</form>
