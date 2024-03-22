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

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}

$maNV = $_GET['id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tenNV = $_POST["txtName"];
    $gioiTinh = $_POST["gioiTinh"];
    $noiSinh = $_POST["txtNoiSinh"];
    $maPhong = $_POST["txtMaPhong"];
    $luong = $_POST["txtLuong"];

    $updatedNhanVien = new NhanVien($maNV, $tenNV, $gioiTinh, $noiSinh, $maPhong, $luong);
    
    $result = $updatedNhanVien->update();
    if ($result) {
        header("Location: index.php");
        exit();
    } else {
        $error_message = "Failed to update employee information.";
    }
}

$nhanvien = NhanVien::get_nhanvien($maNV);
if (!$nhanvien) {
    header("Location: index.php");
    exit();
}
?>

<?php include_once("header.php"); ?>

<h2>Edit Employee</h2>
<?php if (isset($error_message)): ?>
    <p style="color: red;"><?php echo $error_message; ?></p>
<?php endif; ?>
<form method="post">
<div class="row">
<div class="row">
        <div class="lbtitle">
            <label>Name:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="txtName" value="<?php echo $nhanvien->Ten_NV; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Gender:</label>
        </div>
        <div class="lbinput">
            <input type="radio" name="gioiTinh" value="Nam" <?php if ($nhanvien->Phai === 'Nam') echo 'checked'; ?>> Male
            <input type="radio" name="gioiTinh" value="Nu" <?php if ($nhanvien->Phai === 'Nu') echo 'checked'; ?>> Female
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Place of Birth:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="txtNoiSinh" value="<?php echo $nhanvien->Noi_Sinh; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Department:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="txtMaPhong" value="<?php echo $nhanvien->Ma_Phong; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="lbtitle">
            <label>Salary:</label>
        </div>
        <div class="lbinput">
            <input type="text" name="txtLuong" value="<?php echo $nhanvien->Luong; ?>" />
        </div>
    </div>
    <div class="row">
        <div class="submit">
        <input type="submit" name="btnsubmit" value="Update Employee">
        </div>
    </div>
</form>

<?php include_once("footer.php"); ?>
