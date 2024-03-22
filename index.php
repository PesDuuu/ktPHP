<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$user_role = $_SESSION["role"];

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: login.php");
    exit();
}
?>
<?php require_once("entities/nhanvien.class.php"); ?>
<?php include_once("header.php"); ?>
<link rel="stylesheet" type="text/css" href="site.css">
<?php

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 5;
$start_from = ($page - 1) * $records_per_page;

function getTenPhong($maPhong) {
    switch ($maPhong) {
        case 'TC':
            return "Tài chính";
        case 'KT':
            return "Kỹ thuật";
        case 'QT':
            return "Quản trị";
        default:
            return "Unknown";
    }
}

$nvs = NhanVien::list_nhanvien_pagination($start_from, $records_per_page);

$total_records = NhanVien::count_nhanvien();
$total_pages = ceil($total_records / $records_per_page);

?>

<div class="container">
    <h2>Danh sách nhân viên</h2>
    <table>
        <tr>
            <th>Mã NV</th>
            <th>Tên NV</th>
            <th>Giới tính</th>
            <th>Nơi sinh</th>
            <th>Phòng ban</th>
            <th>Lương</th>
            <?php if ($user_role === 'admin'): ?>
                <th>Thao tác</th>
            <?php endif; ?>
        </tr>
        <?php foreach ($nvs as $nvs): ?>
            <tr>
                <td><?php echo $nvs->Ma_NV; ?></td>
                <td><?php echo $nvs->Ten_NV; ?></td>
                <td>
                    <?php if ($nvs->Phai == 'NU'): ?>
                        <img src="images/female.png" alt="Female" class="gender-icon">
                    <?php else: ?>
                        <img src="images/male.png" alt="Male" class="gender-icon">
                    <?php endif; ?>
                </td>
                <td><?php echo $nvs->Noi_Sinh; ?></td>
                <td><?php echo getTenPhong($nvs->Ma_Phong); ?></td>
                <td><?php echo $nvs->Luong; ?></td>
                <?php if ($user_role === 'admin'): ?>
                    <td>
                        <a href='edit_nhanvien.php?id=<?php echo $nvs->Ma_NV; ?>' class="edit-btn">Edit</a>
                        <a href='delete_nhanvien.php?id=<?php echo $nvs->Ma_NV; ?>' class="delete-btn">Delete</a>
                    </td>
                <?php endif; ?>
            </tr>
        <?php endforeach; ?>
    </table>

    <div class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
            <a href='index.php?page=<?php echo $i; ?>' class="page-link"><?php echo $i; ?></a>&nbsp;
        <?php endfor; ?>
    </div>

    <a href='index.php?logout=true' class="btn logout-btn">Logout</a>
    <?php if ($user_role === 'admin'): ?>
        <a href='add_nhanvien.php' class="btn add-btn">Add Employee</a>
    <?php endif; ?>
</div>

<?php include_once("footer.php"); ?>


