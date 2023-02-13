<?php 
session_start();
include '../../config/database.php';
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');

if($_GET['ket']=='submit-stok'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok'];
	$jumlah = $_POST['ip-jumlah']+$awal;

	$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','tambah','Toko')";
	mysqli_query($con,$sql1);

	$sql2="UPDATE barang set barang_stok='$jumlah' where barang_id='$id'";

	mysqli_query($con,$sql2);
	
	
} elseif($_GET['ket']=='update-stok'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$ket = $_POST['ip-ket'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok'];
	$jumlah = $awal-$_POST['ip-jumlah'];

	if ($jumlah>0) {

		$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','$ket','kurang','Toko')";
		mysqli_query($con,$sql1);

		$sql2="UPDATE barang set barang_stok='$jumlah' where barang_id='$id'";

		mysqli_query($con,$sql2);
	}
}elseif($_GET['ket']=='approve-stok') {

	$id = $_POST['produk_id'];

	$array_datas = array();

	$sql1="SELECT * from barang where barang_id='$id'";
	$query1=mysqli_query($con, $sql1);
	$data1=mysqli_fetch_assoc($query1);

	$awal=$data1['barang_stok'];
	$stokbaru = $data1['barang_stok'] - $data1['barang_stok_temp']; 
	
		$sql2="SELECT * from log_stok where barang='$id'";
	$query2=mysqli_query($con, $sql2);
	$data2=mysqli_fetch_assoc($query2);
	$keterangan=$data2['alasan'];

	$sql="UPDATE barang set barang_stok='$stokbaru', barang_status=0, barang_ket_temp='' where barang_id='$id'";

	if (!mysqli_query($con,$sql)) {

		$array_datas[] = ["gagal"];

	}else{

		$sql1 = "INSERT into log_approve(log_approve_tanggal,log_approve_barang_id,log_approve_stok_awal,log_approve_stok_akhir,log_approve_keterangan)values('$tgl','$id','$awal','$stokbaru','$keterangan')";
		mysqli_query($con,$sql1);
		
		$array_datas[] = ["ok"];

	}

	echo json_encode($array_datas);

	

} elseif($_GET['ket']=='reject-stok') {

	$id = $_POST['produk_id'];

	$sql="SELECT * from barang where barang_id='$id'";
	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$jumlah=$data['barang_stok'];
	$awal = $data['barang_stok'] - $data['barang_stok_temp']; 

	$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','$ket','Reject Stok','Toko')";
	mysqli_query($con,$sql1);
	$sql2="UPDATE barang set barang_stok_temp='0', barang_status=0, barang_ket_temp='' where barang_id='$id'";

	mysqli_query($con,$sql2);

} elseif($_GET['ket']=='submit-stok-gudang'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok_gudang'];
	$jumlah = $_POST['ip-jumlah']+$awal;

	$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','tambah','Gudang')";
	mysqli_query($con,$sql1);

	$sql2="UPDATE barang set barang_stok_gudang='$jumlah' where barang_id='$id'";

	mysqli_query($con,$sql2);
	
	
} elseif($_GET['ket']=='update-stok-gudang'){


	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];

	$ket = $_POST['ip-ket'];

	$sql="SELECT * from barang where barang_id='$id'";

	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok_gudang'];
	$jumlah = $awal-$_POST['ip-jumlah'];

	if ($jumlah<0) {

	} else {

		$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','$ket','kurang','Gudang')";
		mysqli_query($con,$sql1);

		$sql2="UPDATE barang set barang_stok_gudang='$jumlah' where barang_id='$id'";

		mysqli_query($con,$sql2);
	}
} elseif($_GET['ket']=='update-stok-gudang-temp'){

	$id = $_POST['ip-id'];
	$user = $_SESSION['login_user'];
	$ket = $_POST['ip-ket'];

	$sql="SELECT * from barang where barang_id='$id'";
	$query=mysqli_query($con, $sql);
	$data=mysqli_fetch_assoc($query);

	$awal=$data['barang_stok_gudang'];

	$jumlah = $awal-$_POST['ip-jumlah'];
	$j = $_POST['ip-jumlah'];


	if ($jumlah>=0) {
		$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$id','$awal','$jumlah','$tgl','$ket','kurang','Gudang')";
		mysqli_query($con,$sql1);
		$sql2="UPDATE barang set barang_stok_gudang_temp='$j', barang_gudang_status=1, barang_gudang_ket_temp='$ket' where barang_id='$id'";

		mysqli_query($con,$sql2);

	}

} elseif($_GET['ket']=='approve-stok-gudang'){

	$id = $_POST['produk_id'];

	$array_datas = array();

	$sql1="SELECT * from barang where barang_id='$id'";
	$query1=mysqli_query($con, $sql1);
	$data1=mysqli_fetch_assoc($query1);

	$stokbaru = $data1['barang_stok_gudang'] - $data1['barang_stok_gudang_temp']; 

	$sql="UPDATE barang set barang_stok_gudang='$stokbaru', barang_gudang_status=0, barang_gudang_ket_temp='' where barang_id='$id'";

	if (!mysqli_query($con,$sql)) {

		$array_datas[] = ["gagal"];

	}else{

		$array_datas[] = ["ok"];

	}

	echo json_encode($array_datas);

	

}

?>  