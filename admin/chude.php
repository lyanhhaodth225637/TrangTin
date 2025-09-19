<head>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
</head>
<style>
    h3 {
        color: #990000;
        font-weight: bold;
        text-align: center;
        margin-top: 20px;
        margin-bottom: 25px;
    }

    table.DanhSach {
        width: 90%;
        margin: 0 auto;
        border-collapse: collapse;
        background-color: #fbe2e2;
        border: 1px solid #990000;
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
    }

    table.DanhSach th,
    table.DanhSach td {
        padding: 12px 15px;
        text-align: center;
        border-bottom: 1px solid #d69c9c;
    }

    table.DanhSach th {
        background-color: #990000;
        color: white;
    }

    table.DanhSach tr:nth-child(even) {
    background-color: #fbe2e2;
}

table.DanhSach tr:hover {
    background-color: #f3a8a8; /* Đậm hơn màu gốc */
    transition: background-color 0.2s ease;
}


    table.DanhSach a {
        text-decoration: none;
        font-size: 18px;
    }

    table.DanhSach i {
        transition: transform 0.2s;
    }

    table.DanhSach a:hover i {
        transform: scale(1.2);
    }

    a[href*="chude_them"] {
        display: block;
        width: fit-content;
        margin: 20px auto;
        padding: 10px 20px;
        background-color: #990000;
        color: white;
        border-radius: 5px;
        font-weight: bold;
        text-decoration: none;
        transition: background-color 0.3s ease;
    }

    a[href*="chude_them"]:hover {
        background-color: #cc0000;
    }
</style>
<?php
	$sql = "SELECT * FROM `tbl_chude` WHERE 1";
	$danhsach = $connect->query($sql);
	//Nếu kết quả kết nối không được thì xuất báo lỗi và thoát
	if (!$danhsach) {
		die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
		exit();
	}
?>
<h3>Danh sách chủ đề</h3>
<table class="DanhSach">
	<tr>
		<th width="15%">Mã chủ đề</th>
		<th width="70%">Tên chủ đề</th>
		<th width="15%" colspan="2">Hành động</th>
	</tr>
	<?php
		while ($dong = $danhsach->fetch_array(MYSQLI_ASSOC)) {
			echo "<tr>";
				echo "<td>" . $dong["MaChuDe"] . "</td>";
				echo "<td>" . $dong["TenChuDe"] . "</td>";
				echo "<td align='center'><a href='index.php?do=chude_sua&id=" . $dong["MaChuDe"] . "'><i class='fas fa-edit' style='color: #007bff;'></i></a></td>";
				echo "<td align='center'><a href='index.php?do=chude_xoa&id=" . $dong["MaChuDe"] . "' onclick='return confirm(\"Bạn có muốn xóa chủ đề " . $dong['TenChuDe'] . " không?\")'><i class='fas fa-trash-alt' style='color: #dc3545;'></i></a></td>";
			echo "</tr>";
		}
		
	?>
</table>
<a href="index.php?do=chude_them">Thêm mới chủ đề</a>
</form>
