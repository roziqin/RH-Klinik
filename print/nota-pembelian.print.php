<?php
session_start();
include '../config/database.php';
include "../include/format_rupiah.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');
$wkt=date('G:i:s');

$aid = $_SESSION['login_user'];
$aa = "select * from users where id='$aid'";
$bb=mysqli_query($con,$aa);
$cc=mysqli_fetch_assoc($bb);

$id=$cc['name'];
$iduser=$cc['id'];
  
$sqlpengaturan="SELECT * from pengaturan_perusahaan where  pengaturan_id='1' ";
$querypengaturan=mysqli_query($con,$sqlpengaturan);
$datapengaturan=mysqli_fetch_assoc($querypengaturan);
    

    $t = $_GET['id'];
//$t = 5;
    $sql="SELECT * from pembelian where pembelian_id='$t' ";
    $query = mysqli_query($con,$sql);
    while($data = mysqli_fetch_assoc($query)) {

      $tanggal = $data['pembelian_tanggal'];
      $tran_tot = $data['pembelian_total'];
      $nota_print=$data['pembelian_nota_print'];
    }
        

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="../assets/css/style-print.css?ab">
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<script type="text/javascript">
  window.setTimeout(function() {
    window.close();
  },1000)
</script>
</head>
<body onLoad="window.print()" style=" font-size: 12px;">
    <div class="wrapper">
      <div class="box">
        <div class="box-custom">
          <img src="../assets/img/<?php echo $datapengaturan['pengaturan_logo']; ?>" style=" width: 100px;">
        </div>
        <div class="box-custom" style="width: 200px;">
          <p style=" font-size: 13px;"><?php echo $datapengaturan['pengaturan_nama']; ?></p>
          <p><?php echo $datapengaturan['pengaturan_alamat']; ?></p>
          <p>Tlp. <?php echo $datapengaturan['pengaturan_telp']; ?></p>
          <p style=" font-size: 15px;">Nota Pembelian</p> 
        </div>
      </div>
     
      
      <table  width="100%" border="0" >
        <tr>
          <td width="80">Tgl & Waktu</td>
          <td width="10">:</td>
          <td ><?php echo $tgl." - ".$wkt; ?></td>
          <td width="80" align="right">No. Nota - <?php echo $nota_print; ?></td>
        </tr>
      </table>
      <table  width="100%" border="0" >
        <tr>
          <td width="80">Admin</td>
          <td width="10">:</td>
          <td ><?php echo $id;?></td>
          <td align="right"></td>
        </tr>
      </table>

      <table width="100%" border="0">
        <tr>
          <th align="left">Barang</th>
          <th width="24" align="center">Jml.</th>
          <th width="60" align="center">Harga</th>
          <th width="60" align="center">Subtotal</th>
        </tr>
         <?php
          $no=1;
          $sql="SELECT * from pembelian_detail,barang WHERE pembelian_detail_barang_id=barang_id and pembelian_detail_nota='$t'";
          $query = mysqli_query($con,$sql);
          while($data = mysqli_fetch_assoc($query)) {

            $barang=$data['barang_nama'];
            $jumlah=$data['pembelian_detail_jumlah'];
            $harga=$data['pembelian_detail_harga_beli'];
            $tot=$data['pembelian_detail_total'];

            echo "

            <tr>
              <td>".$barang."</td>
              <td align='center'>".$jumlah."</td>
              <td align='right'>".format_rupiah($harga)."</td>
              <td align='right'>".format_rupiah($tot)."</td>
            </tr>
            ";
            
            $no=$no+1;
          }         
        ?>
        <tr>
          <td colspan="4"><hr color="black"></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Total</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_tot) ; ?></td>
        </tr>
      </table>
  </div>
</body>
</html>
