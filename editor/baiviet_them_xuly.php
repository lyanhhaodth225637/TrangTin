<?php
	$TieuDe = $_POST['TieuDe'];
	$ChuDe = $_POST['ChuDe'];
	$TomTat = $_POST['TomTat'];
	$NoiDung = $_POST['NoiDung'];
	$ChuThichAnh = $_POST['ChuThichAnh'];
	
	if(trim($TieuDe) == "")
		ThongBaoLoi("Tiêu đề không được bỏ trống!");
	elseif(trim($ChuDe) == "")
		ThongBaoLoi("Chưa chọn chủ đề!");
	elseif(trim($TomTat) == "")
		ThongBaoLoi("Tóm tắt bài viết không được bỏ trống!");
	elseif(trim($NoiDung) == "")
		ThongBaoLoi("Nội dung bài viết không được bỏ trống!");
	else
	{
		function changeTitle($str) {
			$str = trim($str);
			$str = preg_replace('/[^a-zA-Z0-9-_\.]/', '-', $str);
			return strtolower($str);
		}
		
		$filename = basename($_FILES['HinhAnh']['name']);
		$newfilename = time() . "_" . changeTitle($filename);  
		$target_path = "../images/" . $newfilename;
		
		if (move_uploaded_file($_FILES['HinhAnh']['tmp_name'], $target_path)) {
			
			$hinhAnhDB = $target_path;
		} else {
			echo "Tập tin upload không thành công.<br/>";
			$hinhAnhDB = ""; 
		}
		

		$MaNguoiDung = $_SESSION['MaNguoiDung'];
		
		$KiemDuyet = ($_SESSION['QuyenHan'] == 1) ? 1 : 0;

		
			$sql = "INSERT INTO `tbl_noidungtin`(`MaChuDe`, `MaNguoiDung`, `TieuDe`, `TomTat`, `NoiDung`, `NgayDang`, `HinhAnh`, `ChuThichAnh`, `LuotXem`, `KiemDuyet`)
			VALUES ($ChuDe, $MaNguoiDung, '$TieuDe', '$TomTat', '$NoiDung', now(), '$hinhAnhDB', '$ChuThichAnh', 0, $KiemDuyet)";
			$danhsach = $connect->query($sql);
			
		if (!$danhsach) {
			die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
			exit();
		}
		else
		{
			ThongBao("Tạo bài viết thành công, đợi quản trị viên kiểm duyệt bài!");
		}
	}
?>