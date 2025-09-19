<?php
	$MaBV = $_GET['id'];
	
	$sql = "SELECT * FROM `tbl_noidungtin` WHERE MaBaiViet = $MaBV";
	
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
        font-size: 24px;
    }

    form.FormSuaBaiVietContainer {
        max-width: 700px;
        margin: 0 auto;
        background-color: #fbe2e2;
        padding: 30px;
        border: 1px solid #990000;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
        box-sizing: border-box;
    }

    table.FormSuaBaiViet {
        width: 100%;
        border-collapse: collapse;
    }

    table.FormSuaBaiViet td {
        padding: 12px 8px;
        vertical-align: top;
    }

    .MyFormLabel {
        display: block;
        margin-bottom: 6px;
        font-weight: bold;
        color: #990000;
    }

    input[type="text"],
    select,
    textarea {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #990000;
        border-radius: 4px;
        box-sizing: border-box;
        resize: vertical;
    }

    input[type="text"]:focus,
    select:focus,
    textarea:focus {
        border-color: #cc0000;
        outline: none;
    }

    textarea {
        min-height: 120px;
    }

    input.SubmitButton {
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

    input.SubmitButton:hover {
        background-color: #cc0000;
    }
</style>

<h3>Sửa bài viết</h3>
<form class="FormSuaBaiVietContainer" action="index.php?do=baiviet_sua_xuly" method="post">
	<input type="hidden" name="MaBaiViet" value="<?php echo $dong['MaBaiViet']; ?>" />
	<table class="FormSuaBaiViet">
		<tr>
			<td>
				<span class="MyFormLabel">Tiêu đề:</span>
				<input type="text" name="TieuDe" value="<?php echo htmlspecialchars($dong['TieuDe']); ?>" required />
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">Chủ đề:</span>
				<select name="ChuDe" required>
					<option value="">-- Chọn --</option>
					<?php
						$sql = "SELECT * FROM `tbl_chude` ORDER BY TenChuDe";
						$danhsach = $connect->query($sql);
						if (!$danhsach) {
							die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
							exit();
						}
						
						while($dong_dscd = $danhsach->fetch_array(MYSQLI_ASSOC)) {
							$selected = ($dong['MaChuDe'] == $dong_dscd['MaChuDe']) ? "selected" : "";
							echo "<option value='" . $dong_dscd['MaChuDe'] . "' $selected>" . htmlspecialchars($dong_dscd['TenChuDe']) . "</option>";
						}
					?>
				</select>
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">Tóm tắt:</span>
				<textarea name="TomTat"><?php echo htmlspecialchars($dong['TomTat']); ?></textarea>
			</td>
		</tr>
		<tr>
			<td>
				<span class="MyFormLabel">Nội dung bài viết:</span>
				<textarea name="NoiDung" id="NoiDung"><?php echo htmlspecialchars($dong['NoiDung']); ?></textarea>
				<script type="text/javascript">
					var editor = CKEDITOR.replace('NoiDung');
					CKFinder.setupCKEditor(editor, '/trangtin_v0.6/scripts/ckfinder/');
				</script>
			</td>
		</tr>
	</table>
	<input type="submit" value="Cập nhật" class="SubmitButton" />
</form>
