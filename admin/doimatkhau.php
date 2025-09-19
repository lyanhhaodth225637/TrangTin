<style>
    .hoso-container {
        max-width: 600px;
        margin: 0 auto;
        background-color: #fbe2e2;
        padding: 30px;
        border: 1px solid #990000;
        border-radius: 8px;
        box-shadow: 0 0 10px rgba(153, 0, 0, 0.2);
    }

    .hoso-container h3 {
        color: #990000;
        text-align: center;
        margin-bottom: 25px;
        font-weight: bold;
    }

    table.Form {
        width: 100%;
        border-collapse: collapse;
    }

    table.Form td {
        padding: 12px 8px;
        vertical-align: top;
        font-weight: bold;
        color: #990000;
    }

    table.Form input[type="password"] {
        width: 100%;
        padding: 10px;
        font-size: 14px;
        border: 1px solid #990000;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .hoso-container input[type="submit"] {
        background-color: #990000;
        color: white;
        border: none;
        padding: 12px 24px;
        font-size: 16px;
        font-weight: bold;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
        display: block;
        margin: 20px auto 0;
    }

    .hoso-container input[type="submit"]:hover {
        background-color: #cc0000;
    }
</style>


<div class="hoso-container">
  <h3>Đổi mật khẩu</h3>
  <form action="index.php?do=doimatkhau_xuly" method="post">
    <input type="hidden" name="MaNguoiDung" value="<?php echo intval($_SESSION['MaNguoiDung']); ?>" />
    <table class="Form">
      <tr>
        <td>Mật khẩu cũ:</td>
        <td><input type="password" name="MatKhauCu" required /></td>
      </tr>
      <tr>
        <td>Mật khẩu mới:</td>
        <td><input type="password" name="MatKhauMoi" required /></td>
      </tr>
      <tr>
        <td>Xác nhận mật khẩu mới:</td>
        <td><input type="password" name="XacNhanMatKhauMoi" required /></td>
      </tr>
    </table>
    <input type="submit" value="Cập nhật mật khẩu" />
  </form>
</div>
