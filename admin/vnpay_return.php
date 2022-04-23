<?php
require_once("./core/config.php");
require_once("./core/init.php");


$id_hv = $data_user['id'];
$ten_hv = $data_user['username'];
$ma_hv = $_SESSION['ma_hv'];
$id_lop = $_SESSION['id_lop'];
$id_nv = null;
$ten_nv = "Thanh Toán Online";
$ma_nv = null;
$count = count($id_lop);
$sotien = 0;
$noidung = "Thu học phí học viên $ten_hv - Mã Học Viên: $ma_hv";
# code...
$thu_chi = 'Thu';
$loai = 7;

$ngay_thang =  date("Ymd");
$year = date('Y', strtotime($ngay_thang));
$month = date('m', strtotime($ngay_thang));

if ($month == '01' || $month == '02' || $month == '03') {
    $quy = 1;
} elseif ($month == '04' || $month == '05' || $month == '06') {
    $quy = 2;
} elseif ($month == '07' || $month == '08' || $month == '09') {
    $quy = 3;
} else $quy = 4;
$search1 = '-';
$replace1 = '';
$date = str_replace($search1, $replace1, $ngay_thang);
$ma_thu = $date . "_" . $id_hv;
//thanh toán

$giamgia = 0;
# câu lệnh insert vào bảng hoá đơn chính
$hoadon = "INSERT INTO 
    `hoa_don`(`MaThu`, `SoTien`, `NoiDung`, `nv_thu`, `ma_nv`, `id_hs`) 
    VALUES ('$ma_thu',0,'$noidung','$ten_nv','$ma_nv','$id_hv')";
//câu lệnh insert vào bảng chi tiết hoá đơn
$id_hoadon ="(SELECT id_hd FROM `hoa_don` ORDER BY hoa_don.id_hd DESC LIMIT 1 )";
// print_r($id_hoadon);
#nếu hoá đơn chạy

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>K&Q Company</title>
    <!-- Custom fonts for this template-->
    <link href="css/jumbotron-narrow.css" rel="stylesheet">

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- bootstrap wysihtml5 - text editor -->
    <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
    <link rel="stylesheet" href="plugins/fullcalendar/fullcalendar.min.css" />
    <script src="plugins/fullcalendar/lib/jquery.min.js"></script>
    <script src="plugins/fullcalendar/lib/moment.min.js"></script>
    <script src="plugins/fullcalendar/fullcalendar.min.js"></script>
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/table.css" rel="stylesheet">
    <script src="plugins/ckeditor/ckeditor.js"></script>
    <script type="text/javascript" src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>

<body>
    <?php
    // Coi kĩ khúc query này nha men
    if ($_GET['vnp_ResponseCode'] == 00) {
        if (!$db->query($hoadon)) {
            for ($i = 0; $i < $count; $i++) {
                #chạy câu lệnh select số tiền học
                $hocphi = "(SELECT mon_hoc.hocphi FROM chi_tiet_lop_hoc 
                    JOIN lop_hoc On lop_hoc.id_lop=chi_tiet_lop_hoc.id_lop
                    JOIN mon_hoc On mon_hoc.id_mon=lop_hoc.id_mh 
                    WHERE chi_tiet_lop_hoc.id_hs='$id_hv' and chi_tiet_lop_hoc.id_lop='$id_lop[$i]')";
                #chạy câu lệnh insert vào chi tiết hoá đơn
                $ct_hoadon = "INSERT INTO 
                    `hoa_don_ct`(`id_lop_ct_hd`, `ct_hocphi`, `ct_giamgia`, `id_hoadon`) 
                    VALUES($id_lop[$i],(SELECT mon_hoc.hocphi FROM chi_tiet_lop_hoc 
                    JOIN lop_hoc On lop_hoc.id_lop=chi_tiet_lop_hoc.id_lop
                    JOIN mon_hoc On mon_hoc.id_mon=lop_hoc.id_mh 
                    WHERE chi_tiet_lop_hoc.id_hs='$id_hv' and chi_tiet_lop_hoc.id_lop='$id_lop[$i]'),$giamgia,$id_hoadon)";
                #chạy câu lệnh update trạng thái thanh toán
                $thanhtoan = "UPDATE chi_tiet_lop_hoc 
                    JOIN lop_hoc ON lop_hoc.id_lop=chi_tiet_lop_hoc.id_lop
                    SET chi_tiet_lop_hoc.thanhtoan=1 
                    WHERE chi_tiet_lop_hoc.id_hs='$id_hv' AND chi_tiet_lop_hoc.id_lop='$id_lop[$i]' and lop_hoc.trangthailop In(2,3)";
                !$db->query($ct_hoadon);
                !$db->query($thanhtoan);
            }
            #select ra tiền thu để bỏ vào thu chi
            $tien_thu = "(SELECT SUM(hoa_don_ct.ct_hocphi) FROM `hoa_don_ct` WHERE hoa_don_ct.id_hoadon=$id_hoadon)";
            $tien_chi = 0;

            #chạy câu lệnh chèn vào bảng thu chi
            $query = "INSERT INTO 
        `thu_chi`
        (`NgayThang`, `ThuChi`, `NoiDung`, `SoTienThu`, `SoTienChi`, `LuyKe`, `Nam`, `Thang`, `Quy`, `loai`, `id_nv`,`id_hd_thanhtoan`) 
        VALUES('$ngay_thang','$thu_chi','$noidung',$tien_thu,'$tien_chi',$tien_thu,'$year','$month','$quy','$loai','$id_nv',$id_hoadon)";
            $query_run = $db->query($query);

            # update lại tổng số tiền
            $update = "UPDATE `hoa_don` 
            SET `SoTien`= (SELECT SUM(hoa_don_ct.ct_hocphi) FROM `hoa_don_ct` WHERE hoa_don_ct.id_hoadon=$id_hoadon) 
            WHERE hoa_don.id_hd=$id_hoadon";
            $db->query($update);



        // Sau khi thanh toán thành công
            $vnp_SecureHash = $_GET['vnp_SecureHash'];
            $inputData = array();
            foreach ($_GET as $key => $value) {
                if (substr($key, 0, 4) == "vnp_") {
                    $inputData[$key] = $value;
                }
            }

            unset($inputData['vnp_SecureHash']);
            ksort($inputData);
            $i = 0;
            $hashData = "";
            foreach ($inputData as $key => $value) {
                if ($i == 1) {
                    $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
                } else {
                    $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                    $i = 1;
                }
            }

            $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
            // $_SESSION['status'] = "Thanh Toán Thành Công ";
            // new Redirect($_DOMAIN . 'thanhtoan_dshv');
        } else {
            // $_SESSION['status'] = "Thanh Toán Thất Bại ";
            // new Redirect($_DOMAIN . 'thanhtoan_dshv');
        }
    }



    ?>
    <!--Begin display -->
    <div class="container">
        <div class="header clearfix">
            <h3 class="text-muted">VNPAY RESPONSE</h3>
        </div>
        <div class="table-responsive">
            <div class="form-group">
                <label>Mã đơn hàng:</label>

                <label><?php echo $_GET['vnp_TxnRef'] ?></label>
            </div>
            <div class="form-group">

                <label>Số tiền:</label>
                <label><?php echo $_GET['vnp_Amount'] ?></label>
            </div>
            <div class="form-group">
                <label>Nội dung thanh toán:</label>
                <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã phản hồi (vnp_ResponseCode):</label>
                <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã GD Tại VNPAY:</label>
                <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
            </div>
            <div class="form-group">
                <label>Mã Ngân hàng:</label>
                <label><?php echo $_GET['vnp_BankCode'] ?></label>
            </div>
            <div class="form-group">
                <label>Thời gian thanh toán:</label>
                <label><?php echo $_GET['vnp_PayDate'] ?></label>
            </div>
            <div class="form-group">
                <label>Kết quả:</label>
                <label>
                    <?php
                    if ($secureHash == $vnp_SecureHash) {
                        if ($_GET['vnp_ResponseCode'] == '00') {
                            echo "<span style='color:blue'>GD Thanh cong</span>";
                        } else {
                            echo "<span style='color:red'>GD Khong thanh cong</span>";
                        }
                    } else {
                        echo "<span style='color:red'>Chu ky khong hop le</span>";
                    }
                    ?>

                </label>
            </div>
        </div>
        <p>
            &nbsp;
        </p>
        <footer class="footer">
            <p>&copy; VNPAY <?php echo date('Y') ?></p>
        </footer>
    </div>

</body>

</html>