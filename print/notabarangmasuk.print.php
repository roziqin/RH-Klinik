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

$nota_print = 0;
$nofaktur = '';
    $t = $_GET['id'];
//$t = 5;
    $sql="SELECT * from transaksi_barangmasuk where transaksi_barangmasuk_id='$t' ";
    $query = mysqli_query($con,$sql);
    while($data = mysqli_fetch_assoc($query)) {


      $nofaktur=$data['transaksi_barangmasuk_nofaktur'];
      $type=$data['transaksi_barangmasuk_type_bayar'];
      $tanggal = $data['transaksi_barangmasuk_tanggal'];
      $tran_diskon = $data['transaksi_barangmasuk_diskon'];
      $tran_tot = $data['transaksi_barangmasuk_total'];
      $bayar = $data['transaksi_barangmasuk_bayar'];
      $kembalian = $bayar - $tran_tot;
      $type = $data['transaksi_barangmasuk_type_bayar'];
      $nota_print=$data['transaksi_barangmasuk_nota_print'];
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
      
      <div style="text-align: center;">
       <img src="../assets/img/<?php echo $datapengaturan['pengaturan_logo']; ?>" style=" width: 40px;">
       <h4><?php echo $datapengaturan['pengaturan_nama']; ?></h4>
       <h2>Pembelian Barang</h2>
       <p><?php echo $datapengaturan['pengaturan_alamat']; ?></p>
        <p>Tlp. <?php echo $datapengaturan['pengaturan_telp']; ?></p>
      </div>
      
      <table  width="100%" border="0" >
        <tr>
          <td colspan="4" align="center"><?php echo $tgl." - ".$wkt; ?></td>
        </tr>
        <tr>
          <td width="60">Kasir</td>
          <td width="10">:</td>
          <td colspan="2"><?php echo $id;?></td>
        </tr>
        <tr>
          <td width="60">No Faktur</td>
          <td width="10">:</td>
          <td colspan="2"><?php echo $nofaktur; ?></td>
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
          $sql="SELECT * from transaksi_barangmasuk_detail,barang WHERE transaksi_barangmasuk_detail_barang_id=barang_id and transaksi_barangmasuk_detail_nota='$t'";
          $query = mysqli_query($con,$sql);
          while($data = mysqli_fetch_assoc($query)) {

            $barang=$data['barang_nama'];
            $jumlah=$data['transaksi_barangmasuk_detail_jumlah'];
            $diskon=$data['transaksi_barangmasuk_detail_diskon'];
            $harga=$data['transaksi_barangmasuk_detail_harga_beli'];
            $tot=$data['transaksi_barangmasuk_detail_total'];

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
          <td align="left" scope="row" colspan="2">Subtotal</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_tot+$tran_diskon) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Diskon</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_diskon) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Total</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_tot) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Bayar</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($bayar) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Kembalian</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($kembalian) ; ?></td>
        </tr>
      </table>
      <table width="100%" border="0" style="margin-top: 10px;">
        <tr>
          <td colspan="2"><hr color="black"></td>
        </tr>
        <tr>
          <td colspan="2" style="text-align: center;">TERIMA KASIH</td>
        </tr>
        <tr>
          <td colspan="2"><hr color="black"></td>
        </tr>
      </table>
  </div>
</body>
</html>
