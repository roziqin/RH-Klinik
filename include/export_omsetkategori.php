<?php
session_start();
include '../config/database.php';

?>
<!DOCTYPE html>
<html>
<head>
	<title>Export Data Ke Excel </title>
</head>
<body>
	<style type="text/css">
	body{
		font-family: Calibri,Candara,Segoe,Segoe UI,Optima,Arial,sans-serif; ;
	}
	table{
		margin: 20px auto;
		border-collapse: collapse;
	}
	table th,
	table td{
		border: 1px solid #3c3c3c;
		padding: 3px 8px;
 
	}
	</style>
 
	<?php

	$kategorinama = '';
	$kategori = $_GET['kategori'];
	$tgl = $_GET['date'];
	$ket1 = $_GET['ket'];

	if($kategori!=null || $kategori!='') {
		$sqlmenu="SELECT * from kategori where kategori_id='$kategori'";
	    $resultmenu=mysqli_query($con,$sqlmenu);
	    $datamenu=mysqli_fetch_assoc($resultmenu);
	    $kategorinama = $datamenu['kategori_nama'];
	}
	
	$filename = "laporan_omsetkategori_".$kategorinama."-".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);

	
	?>

	<center>
		<h1>Data Omset <?php echo $kategorinama;?></h1>
	</center>
	<table border="1">
		<tr>
			<th>Tanggal</th>
            <th>Kategori</th>
			<th>Omset</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];
		$tot = 0;

		if ($kategori==null || $kategori=='') {
	        $text1 = '';
	    } else {
	        $text1 = 'barang_kategori='.$kategori.' and ';

	    }

		if ($_GET['ket']=="harian") {
	    $ket = "transaksi_tanggal"; 
		} elseif ($_GET['ket']=="bulanan") {
		    $ket = "transaksi_bulan";     
		}

		$sql ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_detail_total) as total, kategori_nama, barang_kategori from transaksi, transaksi_detail, barang, kategori WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_kategori=kategori_id and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket";



		$query = mysqli_query($con,$sql);

		while ($datatea=mysqli_fetch_assoc($query)) {

			$tglket = $datatea[$ket];

			
	        $sqlcash="SELECT transaksi_detail_jumlah, sum(transaksi_detail_harga_beli*transaksi_detail_jumlah) as beli  from transaksi, transaksi_detail WHERE transaksi_id=transaksi_detail_nota and $ket='$tglket' GROUP BY $ket ";
	        $querycash=mysqli_query($con, $sqlcash);
	        $datacash=mysqli_fetch_assoc($querycash);

			?>
			<tr>
				<td><?php echo $tglket; ?></td>
				<td><?php echo $datatea['kategori_nama']; ?></td>
				<td><?php echo $datatea["total"]; ?></td>
			</tr>

			<?php
		}
		
		?>
	</table>
</body>
</html>