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

    foreach ($nvs as $nvs) {
        echo "<div class='nhanvien'>";
        echo "<h3>Mã Nhân Viên: ".$nvs->Ma_NV."</h3>";
        echo "<p>Tên Nhân Viên: ".$nvs->Ten_NV."</p>";
        $anh_gt = ($nvs->Phai == 'NU') ? "images/female.png" : "images/male.png";
        echo "<img src='$anh_gt' alt='Gender Image'>";
        echo "<p>Nơi Sinh: ".$nvs->Noi_Sinh."</p>";
        $ten_phong = getTenPhong($nvs->Ma_Phong);
        echo "<p>Tên Phòng: ".$ten_phong."</p>";
        echo "<p>Lương: ".$nvs->Luong."</p>";
        echo "</div>";
    }

    $total_records = NhanVien::count_nhanvien();
    $total_pages = ceil($total_records / $records_per_page);

    echo "<div class='pagination'>";
    for ($i = 1; $i <= $total_pages; $i++) {
        echo "<a href='list_nhanvien.php?page=" . $i . "'>" . $i . "</a>&nbsp;";
    }
    echo "</div>";

?>
<?php include_once("footer.php"); ?>

