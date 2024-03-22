<?php
session_start();
require_once("entities/nhanvien.class.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION["role"];
if ($user_role !== 'admin') {
    header("Location: index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $maNV = $_POST["maNV"];
    $tenNV = $_POST["tenNV"];
    $gioiTinh = $_POST["gioiTinh"];
    $noiSinh = $_POST["noiSinh"];
    $maPhong = $_POST["maPhong"];
    $luong = $_POST["luong"];

    $newNhanVien = new NhanVien($maNV, $tenNV, $gioiTinh, $noiSinh, $maPhong, $luong);

    $result = $newNhanVien->save();

    if (!$result) {
        $error_message = "Thêm nhân viên không thành công.";
    } else {
        header("Location: index.php?inserted");
        exit();
    }
}
?>

<?php include_once("header.php"); ?>

<h2>Thêm nhân viên</h2>

<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>

<form method="post">
    <div class="row">
        <div class="lbtitle">
            <label>Mã nhân viên:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="maNV" required>
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Tên nhân viên:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="tenNV" required>
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Giới tính:</label>
        </div>
        <div class="lbinput">
            <select name="gioiTinh">
                <option value="NAM">Nam</option>
                <option value="NU">Nữ</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Nơi sinh:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="noiSinh" required>
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Mã phòng:</label>
        </div>
        <div class="lbinput">
            <select name="maPhong">
                <option value="TC">Tài chính</option>
                <option value="KT">Kỹ thuật</option>
                <option value="QT">Quản trị</option>
            </select>
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Lương:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="luong" required>
        </div>
    </div>
    <div class="row">
        <div class="submit">
            <input type="submit" name="btnsubmit" value="Thêm nhân viên">
        </div>
    </div>
</form>

<?php include_once("footer.php"); ?>
