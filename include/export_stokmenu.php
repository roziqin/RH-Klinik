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

	$tgl = $_GET['date'];
	$menu = $_GET['menu'];

	$sqlmenu="SELECT * from barang where barang_id='$menu'";
    $resultmenu=mysqli_query($con,$sqlmenu);
    $datamenu=mysqli_fetch_assoc($resultmenu);
	
	$ket1 = "transaksi_tanggal";
	
	$filename = "laporan_stok_".$datamenu['barang_nama']."-".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);
	
	
	?>

	<center>
		<h1>Data Stok <?php echo $datamenu["barang_nama"]; ?></h1>
	</center>
	<table border="1">
		<tr>
            <th>Tanggal</th>
            <th>awal</th>
            <th>masuk</th>
            <th>keluar</th>
            <th>sisa</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];
	    $n=0;

		$sql ="SELECT * FROM log_stok where barang='$menu' and tanggal BETWEEN '$tgl11' AND '$tgl22' ORDER BY tanggal ASC";
		$query = mysqli_query($con,$sql);
		while ($datatea=mysqli_fetch_assoc($query)) {
			$tanggal = $datatea['tanggal'];
			if ($n==0) {
		        $stok_awal = $datatea['stok_awal'];
	        } else {
	            $stok_awal = '-';
	        }
	        $stok_jumlah = $datatea['stok_jumlah'];
	        $keterangan = $datatea['keterangan'];

	        if ($keterangan=='tambah') {
	            $masuk = $stok_jumlah - $datatea['stok_awal'];
	            $keluar = 0;
	        } else {
	            $masuk = 0;
	            $keluar = $datatea['stok_awal'] - $stok_jumlah;

	        }

			?>
			<tr>
				<td><?php echo $tanggal; ?></td>
				<td><?php echo $stok_awal; ?></td>
				<td><?php echo $masuk; ?></td>
				<td><?php echo $keluar; ?></td>
				<td><?php echo $stok_jumlah; ?></td>
			</tr>

			<?php
			$n++;
		}
		
		?>
	</table>
</body>
</html>