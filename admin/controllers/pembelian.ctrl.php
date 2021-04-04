<?php 
session_start();
include '../../config/database.php';
include "../../include/slug.php";
date_default_timezone_set('Asia/jakarta');
$tgl=date('Y-m-j');
$bln=date('Y-m');
$wkt=date('H:i:s');
$array_datas = array();


$user = $_SESSION['login_user'];
$order_type = '';
if($_GET['ket']=='tambahmenu'){

	$id = $_POST['barang_id'];	
	$jumlah = $_POST['jumlah'];
	$ket = $_POST['keterangan'];
	$hargamanual = $_POST['hargamanual'];

	$sql="SELECT * from barang where barang_id='$id'";
	$query=mysqli_query($con,$sql);
	$data=mysqli_fetch_assoc($query);
	$hargajual = $data['barang_harga_jual'];


	$jml=$jumlah;
	

	if($hargamanual!=0) {
		$harga = $hargamanual;
	} else {
	
		$harga = $data['barang_harga_beli'];
	}

	$diskon = $harga*$data['barang_diskon']/100;
	if ($diskon!=0) {
		$harga = $harga - $diskon;
	}

	$tot = $harga*$jumlah;
	
	$sql = "INSERT INTO pembelian_detail_temp(pembelian_detail_temp_barang_id,pembelian_detail_temp_harga,pembelian_detail_temp_harga_beli,pembelian_detail_temp_diskon,pembelian_detail_temp_jumlah,pembelian_detail_temp_total,pembelian_detail_temp_keterangan,pembelian_detail_temp_user)values('$id','$hargajual','$harga','$diskon','$jumlah','$tot','$ket','$user')";

	mysqli_query($con,$sql);

	$query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_user='$user' ORDER BY pembelian_detail_temp_id DESC LIMIT 1";
	$result = mysqli_query($con,$query);

	while($baris = mysqli_fetch_assoc($result))
	{
	  $array_datas['item']=$baris;
	}

	$total = 0;
	$query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_user='$user' ORDER BY pembelian_detail_temp_id";
	$result = mysqli_query($con,$query);
	while($data = mysqli_fetch_assoc($result)) {
		$total+=$data['pembelian_detail_temp_total'];
	}

	$array_datas['totalordertemp']=$total;
	
	$array_datas['ok']="ok";
	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='batal'){

    $sql = "DELETE from pembelian_detail_temp where pembelian_detail_temp_user='$user'";
    mysqli_query($con,$sql);

		$_SESSION['order_type'] = "";
		$array_datas[] = ["ok"];
	echo json_encode($array_datas);

} elseif($_GET['ket']=='removeitem'){
	$id = $_POST['id'];	
    $sql = "DELETE from pembelian_detail_temp where pembelian_detail_temp_id='$id'";
    mysqli_query($con,$sql);

	$total = 0;
	$query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_user='$user' ORDER BY pembelian_detail_temp_id";
	$result = mysqli_query($con,$query);
	while($data = mysqli_fetch_assoc($result)) {
		$total+=$data['pembelian_detail_temp_total'];
	}

	$array_datas['totalordertemp']=$total;
	echo json_encode($array_datas);

} elseif($_GET['ket']=='plusminus'){
	$id = $_POST['id'];
	$idbarang = $_POST['idbarang'];
	$keterangan = $_POST['keterangan'];	

	if ($keterangan=='plus') {
		$jumlah = $_POST['jumlah']+1;
	} else {
		$jumlah = $_POST['jumlah']-1;
	}
	$jml=$jumlah;

	$sql="SELECT * from barang where barang_id='$idbarang'";
	$query=mysqli_query($con,$sql);
	$data=mysqli_fetch_assoc($query);

	$sql1="SELECT * from pembelian_detail_temp where pembelian_detail_temp_id='$id'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$harga = $data1['pembelian_detail_temp_harga_beli'];
	$tot = $harga*$jumlah;

	$array_datas['jumlahordertemp']=1;
		
	if ($keterangan=='minus' && $jumlah==0) {
		$sql="DELETE from pembelian_detail_temp where pembelian_detail_temp_id='$id'";
		$array_datas['jumlahordertemp']=0;
	} else {
		$sql="UPDATE pembelian_detail_temp set pembelian_detail_temp_jumlah='$jumlah',pembelian_detail_temp_total='$tot' where pembelian_detail_temp_id='$id'";

	}

	mysqli_query($con,$sql);

	$query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_id=$id ";
	$result = mysqli_query($con,$query);

	while($baris = mysqli_fetch_assoc($result)) {
	  $array_datas['item']=$baris;
	}

	$total = 0;
	$query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_user='$user' ORDER BY pembelian_detail_temp_id";
	$result = mysqli_query($con,$query);
	while($data = mysqli_fetch_assoc($result)) {
		$total+=$data['pembelian_detail_temp_total'];
	}

	$array_datas['totalordertemp']=$total;
	
	
	echo json_encode($array_datas);

} elseif($_GET['ket']=='prosespembelian') {
	$total = $_POST['ip-total'];

	$qcn= "SELECT MAX( pembelian_nota_print ) AS nota_print FROM pembelian";
    $rcn=mysqli_query($con,$qcn);
    $dcn=mysqli_fetch_assoc($rcn);
    $nota_print = $dcn['nota_print']+1;

	$sql = "INSERT INTO pembelian (pembelian_nota_print,pembelian_tanggal,pembelian_bulan,pembelian_waktu,pembelian_total,pembelian_diskon,pembelian_bayar,pembelian_type_bayar,pembelian_user,pembelian_ket) VALUES ('$nota_print','$tgl','$bln','$wkt','$total','0','$total','','$user','')" ;

	mysqli_query($con,$sql);

	$qn= "SELECT MAX( pembelian_id ) AS nota FROM pembelian where pembelian_user='$user'";
    $rn=mysqli_query($con,$qn);
    $dn=mysqli_fetch_assoc($rn);
    $no_not = $dn['nota'];
    $_SESSION['no-nota'] = $no_not;	

    $query="SELECT * from pembelian_detail_temp where pembelian_detail_temp_user='$user'";
	$result = mysqli_query($con,$query);
	while($baris = mysqli_fetch_assoc($result)) {

    	$barang = $baris['pembelian_detail_temp_barang_id'];
    	$harga = $baris['pembelian_detail_temp_harga'];
    	$hargabeli = $baris['pembelian_detail_temp_harga_beli'];
    	$diskon = $baris['pembelian_detail_temp_diskon'];
    	$jumlah = $baris['pembelian_detail_temp_jumlah'];
    	$total = $baris['pembelian_detail_temp_total'];
    	$ket = $baris['pembelian_detail_temp_keterangan'];
    	$status = $baris['pembelian_detail_temp_status'];
    	$user = $baris['pembelian_detail_temp_user'];


    	$a="INSERT into pembelian_detail(pembelian_detail_nota,pembelian_detail_barang_id,pembelian_detail_harga,pembelian_detail_harga_beli,pembelian_detail_diskon,pembelian_detail_jumlah,pembelian_detail_total,pembelian_detail_keterangan,pembelian_detail_status,pembelian_detail_user)values('$no_not','$barang','$harga','$hargabeli','$diskon','$jumlah','$total','$ket','$status','$user')";
		mysqli_query($con,$a);

		//Select Stok Barang
		$sqlstok="SELECT * from barang where barang_id='$barang'";
        $resultstok=mysqli_query($con,$sqlstok);
	    $datastok=mysqli_fetch_assoc($resultstok);


		$awal=$datastok['barang_stok'];
    	$jml_stok = $awal + $jumlah;

    	$sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,keterangan)values('$user','$barang','$awal','$jml_stok','$tgl','tambah')";
		mysqli_query($con,$sql1);
    
        $sqlupdatestok = "UPDATE barang SET barang_stok='$jml_stok' WHERE barang_id='$barang'";
        mysqli_query($con,$sqlupdatestok);
		
    }

    $_SESSION['kembalian'] = $kembalian;
    $_SESSION['print'] = 'ya';
    $_SESSION['order']='';

    $sqldelete = "DELETE from pembelian_detail_temp where pembelian_detail_temp_user='$user'";
    mysqli_query($con,$sqldelete);

    $array_dataa = array('nota'=>$no_not);


	echo json_encode($array_dataa);

}  elseif($_GET['ket']=='tutupkasir'){

	$uangfisik = $_POST['uangfisik'];
	//$uangfisik = 200000;

	$sqlcek="SELECT count(*) as jml from validasi where validasi_user_id='$user' and validasi_tanggal='$tgl'";
	$querycek=mysqli_query($con,$sqlcek);
	$datacek=mysqli_fetch_assoc($querycek);

	if ($datacek['jml']!=0) {
		$array_datas['ket'] = "gagal";

	} else {

		$sql="SELECT * from users where id='$user'";
		$query=mysqli_query($con,$sql);
		$data=mysqli_fetch_assoc($query);
		$usernama=$data['name'];

		$sql1="SELECT count(pembelian_id) as jumlah, sum(pembelian_total) as total, sum(pembelian_diskon) as diskon from pembelian where pembelian_tanggal='$tgl' and pembelian_user = '$user' group by pembelian_tanggal";
		$query1=mysqli_query($con,$sql1);
		$data1=mysqli_fetch_assoc($query1);

		$sql2="SELECT count(pembelian_id) as jumlah, sum(pembelian_total) as debet, sum(pembelian_diskon) as diskon from pembelian where pembelian_tanggal='$tgl' and pembelian_user = '$user' and pembelian_type_bayar='Debet' group by pembelian_tanggal";
		$query2=mysqli_query($con,$sql2);
		$data2=mysqli_fetch_assoc($query2);

		$sql3="SELECT count(pembelian_id) as jumlah, sum(pembelian_total) as cash, sum(pembelian_diskon) as diskon from pembelian where pembelian_tanggal='$tgl' and pembelian_user = '$user' and pembelian_type_bayar='Cash' group by pembelian_tanggal";
		$query3=mysqli_query($con,$sql3);
		$data3=mysqli_fetch_assoc($query3);

		$a="INSERT into validasi(validasi_tanggal,validasi_waktu,validasi_user_id,validasi_user_nama,validasi_jumlah,validasi_cash,validasi_debet,validasi_omset)values('$tgl','$wkt','$user','$usernama','$uangfisik','$data3[cash]','$data2[debet]','$data1[total]')";
			mysqli_query($con,$a);

		if ($data2['debet']=='') {
			$totdebet = 0;
		} else {
			$totdebet = $data2['debet'];
		}

		if ($data3['cash']=='') {
			$totcash = 0;
		} else {
			$totcash = $data3['cash'];
		}

		$array_datas['omset'] = $data1['total'];
		$array_datas['debet'] = $totdebet;
		$array_datas['cash'] = $totcash;
		$array_datas['uangfisik'] = $uangfisik;
		$array_datas['ket'] = "sukses";

	}
	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='tes') {
	$sql1="SELECT * from member_temp where member_temp_user_id='$user'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$member = $data1['member_temp_member_id'];
	echo $_SESSION['kembalian'];
}

?>  