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
	$barangnama = '';
	$tgl = $_GET['date'];
	$menu = $_GET['menu'];
	
	if($menu!=null || $menu!='') {
		$sqlmenu="SELECT * from barang where barang_id='$menu'";
	    $resultmenu=mysqli_query($con,$sqlmenu);
	    $datamenu=mysqli_fetch_assoc($resultmenu);
	    $barangnama = $datamenu['barang_nama'];
	}
	
	$ket1 = "transaksi_tanggal";
	
	$filename = "laporan_itemterjual_".$barangnama."-".$ket1."-".$tgl.".xls";
	header("Content-type: application/vnd-ms-excel");
	header("Content-Disposition: attachment; filename=".$filename);
	
	
	?>

	<center>
		<h1>Data Item Terjual <?php echo $barangnama; ?></h1>
	</center>
	<table border="1">
		<tr>
            <th>tanggal</th>
            <th>item</th>
            <th>jumlah</th>
		</tr>
		<?php
		$text_line = explode(":",$_GET['date']);
		$tgl11=$text_line[0];
		$tgl22=$text_line[1];

		if ($_GET['ket']=="harian") {
	    	$ket = "transaksi_tanggal"; 
		} elseif ($_GET['ket']=="bulanan") {
		    $ket = "transaksi_bulan";     
		}

		if ($menu==0 || $menu==null || $menu=='') {
        	$text1 = '';
        	$text2 = ', barang_id';
	    } else {
	        $text1 = 'barang_id='.$menu.' and ';
	        $text2 = '';
	    }

	    $n=0;

		$sql ="SELECT transaksi_tanggal, transaksi_bulan, barang_nama, barang_id, sum(transaksi_detail_jumlah) as jumlah from transaksi, transaksi_detail, barang WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY transaksi_tanggal ASC";

		$query = mysqli_query($con,$sql);
		while ($datatea=mysqli_fetch_assoc($query)) {

			$tglket = $datatea[$ket];


			?>
			<tr>
				<td><?php echo $tglket; ?></td>
				<td><?php echo $datatea['barang_nama']; ?></td>
				<td><?php echo $datatea['jumlah']; ?></td>
			</tr>

			<?php
		}
		
		?>
	</table>
</body>
</html>