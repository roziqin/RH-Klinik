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
	
	$ket1 = "pembelian_tanggal";
	
	$filename = "laporan_pembelian_nota".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);
	
	
	?>

	<center>
		<h1>Data Nota Pembelian</h1>
	</center>
	<table border="1">
		<tr>
			<th>Tanggal</th>
			<th>No Nota</th>
			<th>Admin</th>
			<th>Total</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];
		$tot = 0;

		$sql ="SELECT * from pembelian, users WHERE pembelian_user=id and $ket1 BETWEEN '$tgl11' AND '$tgl22' ORDER BY pembelian_id ASC";



		$query = mysqli_query($con,$sql);

		while ($datatea=mysqli_fetch_assoc($query)) {
					

			?>
			<tr>
				<td><?php echo $datatea["pembelian_tanggal"]; ?></td>
				<td><?php echo $datatea["pembelian_id"]; ?></td>
				<td><?php echo $datatea["name"]; ?></td>
				<td align="right"><?php echo $datatea["pembelian_total"]; ?></td>
			</tr>

			<?php
			$tot += $datatea["pembelian_total"];
		}
		
		?>
		<tr>
			<td colspan="3">Total</td>
			<td align="right"><?php echo $tot; ?></td>
		</tr>
	</table>
</body>
</html>