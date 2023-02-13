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



    $t = $_GET['id'];

//$t = 5;

    $sql="SELECT * from transaksi_gudang, member, users where transaksi_gudang_member=member_id and transaksi_gudang_id='$t' ";
    $query = mysqli_query($con,$sql);
    while($data = mysqli_fetch_assoc($query)) {


      $pelanggan=$data['member_nama'];
      //$pelanggan=$data['transaksi_gudang_nama'];

      $tanggal = $data['transaksi_gudang_tanggal'];
      $tran_diskon = $data['transaksi_gudang_diskon'];
      $tran_tot = $data['transaksi_gudang_total'];
      $bayar = $data['transaksi_gudang_bayar'];
      $debet = $data['transaksi_gudang_bayar_debet'];
      $kembalian = $bayar + $debet - $tran_tot;
      $type = $data['transaksi_gudang_type_bayar'];
      $nota_print=$data['transaksi_gudang_nota_print'];

      $bayar1 = $bayar;
      if ($bayar==0) {
        $type = 'transfer';
        $bayar1 = $debet;
      }

      $kasir = $data['transaksi_gudang_kasir'];


      $sqlkasir="SELECT * from users where id='$kasir' ";
      $querykasir=mysqli_query($con,$sqlkasir);
      $datakasir=mysqli_fetch_assoc($querykasir);

      $namakasir = $datakasir['name'];
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
       <img src="../assets/img/<?php echo $datapengaturan['pengaturan_logo']; ?>" style=" width: 140px;">
       <h4><?php echo $datapengaturan['pengaturan_nama']; ?></h4>
       <p><?php echo $datapengaturan['pengaturan_alamat']; ?></p>
        <p>Tlp. <?php echo $datapengaturan['pengaturan_telp']; ?></p>
      </div>

      

      <table  width="100%" border="0" >
        <tr>
          <td colspan="4" align="center"><?php echo $tgl." - ".$wkt; ?></td>
        </tr>
        <tr>
          <td width="60">Customer</td>
          <td width="10">:</td>
          <td ><?php echo $pelanggan;?></td>
          <td width="80" align="right">Nota - <?php echo $nota_print; ?></td>
        </tr>
        <tr>
          <td width="60">Kasir</td>
          <td width="10">:</td>
          <td ><?php echo $namakasir;?></td>
          <td width="80" align="right"></td>
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
          $jmldiskon = 0;
          $sql="SELECT * from transaksi_gudang_detail,barang WHERE transaksi_gudang_detail_barang_id=barang_id and transaksi_gudang_detail_nota='$t'";
          $query = mysqli_query($con,$sql);
          while($data = mysqli_fetch_assoc($query)) {

            $barang=$data['barang_nama'];
            $jumlah=$data['transaksi_gudang_detail_jumlah'];
            $diskon=$data['transaksi_gudang_detail_diskon']*$jumlah;
            $harga=$data['transaksi_gudang_detail_harga'];
            $tot=$data['transaksi_gudang_detail_total'];
            $hargaawal = $harga+$data['transaksi_gudang_detail_diskon'];
            $totawal = $tot+$diskon;

            echo "

            <tr>
              <td>".$barang."</td>
              <td align='center'>".$jumlah."</td>
              <td align='right'>".format_rupiah($hargaawal)."</td>
              <td align='right'>".format_rupiah($totawal)."</td>
            </tr>
            ";


            if ($diskon!=0) {
              echo "
              <tr>
                <td></td>
                <td align='center'></td>
                <td align='right'></td>
                <td align='right'>-".format_rupiah($diskon)."</td>
              </tr>
              ";            
            }

            $no=$no+1;
            $jmldiskon = $jmldiskon + $diskon;
          }         
        ?>
        <tr>
          <td colspan="4"><hr color="black"></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Subtotal</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_tot+$tran_diskon+$jmldiskon) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Diskon</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_diskon+$jmldiskon) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Total</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($tran_tot) ; ?></td>
        </tr>
        <tr>
          <td align="left" scope="row" colspan="2">Bayar(<?php echo $type; ?>)</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($bayar1) ; ?></td>
        </tr>
        <?php if ($debet!=0 && $bayar!=0) { ?>
        <tr>
          <td align="left" scope="row" colspan="2">Debet/Transfer</td>
          <td align="right">: Rp.</td>
          <td align="right"><?php echo format_rupiah($debet) ; ?></td>
        </tr>
      <?php } ?>
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
          <td colspan="2" align="center">IG: @elmoist.skincare</td>
        </tr>
        <tr>
          <td colspan="2" align="center">Testimoni: @elmoist.testimoni</td>
        </tr>
        <tr>
          <td colspan="2" align="center" style="font-size:10px;">Mohon untuk dicek kembali<br>Barang yang telah dibeli tidak dapat ditukar/dikembalikan.</td>
        </tr>
        <tr>
          <td colspan="2" align="center">Terima Kasih</td>
        </tr>
        <tr>
          <td colspan="2"><hr color="black"></td>
        </tr>
      </table>
  </div>
</body>
</html>

