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
	
	$ket1 = $_GET['ket'];
	
	$filename = "laporan_omset".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);

	
	?>

	<center>
		<h1>Data Laba</h1>
	</center>
	<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>Total Omset</th>
			<th>Laba</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];
		$tot = 0;
		$laba = 0;


		if ($_GET['ket']=="harian") {
	    $ket = "transaksi_tanggal"; 
		} elseif ($_GET['ket']=="bulanan") {
		    $ket = "transaksi_bulan";     
		}

		$sql ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_total) as total, sum(transaksi_diskon) as diskon from transaksi WHERE $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket ORDER BY transaksi_tanggal ASC";



		$query = mysqli_query($con,$sql);

		while ($datatea=mysqli_fetch_assoc($query)) {

			$tglket = $datatea[$ket];

			
	        $sqlcash="SELECT transaksi_detail_jumlah, sum(transaksi_detail_harga_beli*transaksi_detail_jumlah) as beli  from transaksi, transaksi_detail WHERE transaksi_id=transaksi_detail_nota and $ket='$tglket' GROUP BY $ket ";
	        $querycash=mysqli_query($con, $sqlcash);
	        $datacash=mysqli_fetch_assoc($querycash);

	        $totalbeli = $datacash['beli'];
	        $n = $datatea['total']-$totalbeli;

			?>
			<tr>
				<td><?php echo $tglket; ?></td>
				<td><?php echo $datatea["total"]; ?></td>
				<td><?php echo $n; ?></td>
			</tr>

			<?php
			$tot += $datatea["total"];
			$laba += $n; 
		}
		
		?>
		<tr>
			<td >Total</td>
			<td align="right"><?php echo $tot; ?></td>
			<td align="right"><?php echo $laba; ?></td>
		</tr>
	</table>
</body>
</html>