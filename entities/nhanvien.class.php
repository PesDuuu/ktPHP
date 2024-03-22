<?php
  require_once("config/db.class.php");


  class NhanVien{
    public $maNV;
    public $tenNV;
    public $gioiTinh;
    public $noiSinh;
    public $maPhong;
    public $luong;

    public function __construct($ma_nv, $ten_nv, $gioi_tinh, $noi_sinh, $ma_phong, $luong){
      $this->maNV = $ma_nv;
      $this->tenNV= $ten_nv;
      $this->gioiTinh= $gioi_tinh;
      $this->noiSinh= $noi_sinh;
      $this->maPhong= $ma_phong;
      $this->luong= $luong;
    }
    public function save(){
      $db= new Db();
      $sql = "INSERT INTO nhanvien (Ma_NV, Ten_NV, Phai, Noi_Sinh, Ma_Phong, Luong) VALUES
      ('$this->maNV','$this->tenNV','$this->gioiTinh','$this->noiSinh','$this->maPhong','$this->luong')";
      $result = $db->query_execute($sql);
      return $result;
    }

    public static function get_nhanvien($maNV)
    {
        $db = new Db();
        $sql = "SELECT * FROM nhanvien WHERE Ma_NV = '$maNV'";
        $result = $db->select_to_array($sql);
        if (count($result) > 0) {
            return $result[0];
        } else {
            return null;
        }
    }

    public function update()
    {
        $db = new Db();
        $sql = "UPDATE nhanvien SET Ten_NV = '$this->tenNV', Phai = '$this->gioiTinh', Noi_Sinh = '$this->noiSinh', Ma_Phong = '$this->maPhong', Luong = '$this->luong' WHERE Ma_NV = '$this->maNV'";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function delete_nhanvien($maNV)
    {
        $db = new Db();
        $sql = "DELETE FROM nhanvien WHERE Ma_NV = '$maNV'";
        $result = $db->query_execute($sql);
        return $result;
    }

    public static function list_nhanvien(){
			$db=new Db();
			$sql="SELECT * FROM nhanvien";
			$result = $db->select_to_array($sql);
			return $result;
		}

    public static function list_nhanvien_pagination($start_from, $records_per_page)
    {
        $db = new Db();
        $sql = "SELECT * FROM nhanvien LIMIT $start_from, $records_per_page";
        $result = $db->select_to_array($sql);
        return $result;
    }

    public static function count_nhanvien()
    {
        $db = new Db();
        $sql = "SELECT COUNT(*) AS total_records FROM nhanvien";
        $result = $db->query_execute($sql);
        $row = $result->fetch_assoc();
        return $row['total_records'];
    }
  }
?>
