<?php
$sql1 = "SELECT COUNT(MaBaiViet) AS total FROM tbl_noidungtin WHERE KiemDuyet = 1";
$result1 = $connect->query($sql1);
$row1 = $result1->fetch_array(MYSQLI_ASSOC);
$total_records = $row1['total'];

$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$limit = 5; 

$total_page = ceil($total_records / $limit);
if ($current_page < 1) $current_page = 1;
elseif ($current_page > $total_page) $current_page = $total_page;

$start = ($current_page - 1) * $limit;

$sql = "SELECT MaBaiViet, TieuDe, NgayDang, TomTat, MaChuDe, HinhAnh, ChuThichAnh
        FROM tbl_noidungtin
        WHERE KiemDuyet = 1
        ORDER BY NgayDang DESC
        LIMIT $start, $limit";
$danhsach = $connect->query($sql);

if (!$danhsach) {
    die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
}


$danhsach = $connect->query($sql);
if (!$danhsach) {
    die("Không thể thực hiện câu lệnh SQL: " . $connect->connect_error);
}

while ($row = $danhsach->fetch_array(MYSQLI_ASSOC)) {
?>
  <div class="baiviet-item">
    <?php if (!empty($row["HinhAnh"])): ?>
      <img class="baiviet-hinh" src="<?= htmlspecialchars('../' . $row["HinhAnh"]) ?>" alt="<?= htmlspecialchars($row["ChuThichAnh"]) ?>">
      <?php endif; ?>

    <div class="baiviet-noidung">
      <h4>
        <a href="index.php?do=baiviet_chitiet&id=<?= $row['MaBaiViet'] ?>" class="tieude-baiviet">
          <?= htmlspecialchars($row['TieuDe']) ?>
        </a>
      </h4>
      <p class="baiviet-tomtat"><?= nl2br(htmlspecialchars($row["TomTat"])) ?></p>
      <p class="baiviet-ngaydang"><?= $row["NgayDang"] ?></p>
    </div>
  </div>
<?php
}
?>
<div class="phan-trang">
  <?php if ($total_page > 1): ?>
    <?php if ($current_page > 1): ?>
      <a href="index.php?page=<?= $current_page - 1 ?>">&laquo; Trước</a>
    <?php endif; ?>

    <?php for ($i = 1; $i <= $total_page; $i++): ?>
      <?php if ($i == $current_page): ?>
        <span class="trang-hien-tai"><?= $i ?></span>
      <?php else: ?>
        <a href="index.php?page=<?= $i ?>"><?= $i ?></a>
      <?php endif; ?>
    <?php endfor; ?>

    <?php if ($current_page < $total_page): ?>
      <a href="index.php?page=<?= $current_page + 1 ?>">Sau &raquo;</a>
    <?php endif; ?>
  <?php endif; ?>
</div>
