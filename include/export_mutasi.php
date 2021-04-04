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
	
	$ket1 = "transaksi_tanggal";
	
	$filename = "laporan_member_".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);
	
	
	?>

	<center>
		<h1>Data Mutasi</h1>
		<h3>Tanggal: <?php echo $tgl; ?></h3>
	</center>
	<table border="1">
		<tr>
            <th>Barang Nama</th>
            <th>awal</th>
            <th>masuk</th>
            <th>keluar</th>
            <th>sisa</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];

		$sql ="SELECT * from barang WHERE barang_set_stok=1 ORDER BY barang_nama ASC";
		$query = mysqli_query($con,$sql);
		while ($datatea=mysqli_fetch_assoc($query)) {
			$barang_id = $datatea['barang_id'];
	        $barang_nama = $datatea['barang_nama'];
	        
	        $sqlawal="SELECT IFNULL( (SELECT stok_awal FROM log_stok where barang='$barang_id' and tanggal BETWEEN '$tgl11' AND '$tgl22' group by barang order by log_id),'0') as stok_awal ";
	        $queryawal=mysqli_query($con,$sqlawal);
	        $dataawal=mysqli_fetch_assoc($queryawal);

	        $sqlmasuk="SELECT IFNULL( (SELECT sum(stok_jumlah-stok_awal) as stok_masuk FROM log_stok where barang='$barang_id' and keterangan='tambah' and tanggal BETWEEN '$tgl11' AND '$tgl22' group by barang order by log_id),'0') as stok_masuk ";
	        $querymasuk=mysqli_query($con,$sqlmasuk);
	        $datamasuk=mysqli_fetch_assoc($querymasuk);

	        $sqlkurang="SELECT IFNULL( (SELECT sum(stok_awal-stok_jumlah) as stok_kurang FROM log_stok where barang='$barang_id' and keterangan='kurang' and tanggal BETWEEN '$tgl11' AND '$tgl22' group by barang order by log_id),'0') as stok_kurang ";
	        $querykurang=mysqli_query($con,$sqlkurang);
	        $datakurang=mysqli_fetch_assoc($querykurang);

	        $sqlkeluar="SELECT sum(transaksi_detail_jumlah) as jumlah FROM transaksi, transaksi_detail where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id='$barang_id' and transaksi_tanggal BETWEEN '$tgl11' AND '$tgl22' group by transaksi_detail_barang_id ";
	        $querykeluar=mysqli_query($con,$sqlkeluar);
	        $datakeluar=mysqli_fetch_assoc($querykeluar);

			?>
			<tr>
				<td><?php echo $barang_nama; ?></td>
				<td><?php echo $dataawal['stok_awal']; ?></td>
				<td><?php echo $datamasuk['stok_masuk']; ?></td>
				<td><?php echo $datakeluar['jumlah'] + $datakurang['stok_kurang']; ?></td>
				<td><?php echo $dataawal['stok_awal'] + $datamasuk['stok_masuk'] - $datakeluar['jumlah'] - $datakurang['stok_kurang']; ?></td>
			</tr>

			<?php
		}
		
		?>
	</table>
</body>
</html>