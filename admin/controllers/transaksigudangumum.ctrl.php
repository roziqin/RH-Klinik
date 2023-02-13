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
	$potongan = $_POST['potongan'];
	$jenispotongan = $_POST['jenispotongan'];
	$hargamanual = 0;

	$sql="SELECT * from barang where barang_id='$id'";
	$query=mysqli_query($con,$sql);
	$data=mysqli_fetch_assoc($query);
	$hargabeli = $data['barang_harga_beli'];

	$sqla="SELECT sum(transaksi_gudang_detail_temp_jumlah) as transaksi_gudang_detail_temp_jumlah from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_barang_id='$id' and transaksi_gudang_detail_temp_user='$user'";
	$querya=mysqli_query($con,$sqla);
	$dataa=mysqli_fetch_assoc($querya);

	if($dataa!=null) {
		$jml=$dataa['transaksi_gudang_detail_temp_jumlah']+$jumlah;
	} else {
		$jml=$jumlah;
	}

	if ($jml>$data['barang_stok_gudang']) {

		$array_datas['totalordertemp']=["Stok Kurang"];
		//echo ("<script>location.href='../home.php?menu=jumlah&id=$id&nama=$data[barang_nama]&ket=Stok Kurang&pelanggan='</script>");
	} else {

		if($hargamanual!=0) {
			$harga = $hargamanual;
		} else {
		
			$harga = $data['barang_harga_jual'];
		}

		$diskon = $harga*$data['barang_diskon']/100;
		if ($diskon!=0) {
			$harga = $harga - $diskon;
		}

		if ($potongan!=0) {
			if ($jenispotongan=='persen') {
				$diskon = $harga*$potongan/100;
				$harga = $harga - $diskon;
			} else {
				$harga = $harga - $potongan;
				$diskon = $potongan;
			}
		}

		$tot = $harga*$jumlah;
		
		$sql = "INSERT INTO transaksi_gudang_detail_temp(transaksi_gudang_detail_temp_barang_id,transaksi_gudang_detail_temp_harga,transaksi_gudang_detail_temp_harga_beli,transaksi_gudang_detail_temp_diskon,transaksi_gudang_detail_temp_jumlah,transaksi_gudang_detail_temp_total,transaksi_gudang_detail_temp_keterangan,transaksi_gudang_detail_temp_user)values('$id','$harga','$hargabeli','$diskon','$jumlah','$tot','$ket','$user')";

		mysqli_query($con,$sql);

		$query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_user='$user' ORDER BY transaksi_gudang_detail_temp_id DESC LIMIT 1";
		$result = mysqli_query($con,$query);

		while($baris = mysqli_fetch_assoc($result))
		{
		  $array_datas['item']=$baris;
		}

		$total = 0;
		$query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_user='$user' ORDER BY transaksi_gudang_detail_temp_id";
		$result = mysqli_query($con,$query);
		while($data = mysqli_fetch_assoc($result)) {
			$total+=$data['transaksi_gudang_detail_temp_total'];
		}

		$array_datas['totalordertemp']=$total;
	}
	$array_datas['ok']="ok bos";
	echo json_encode($array_datas);
	
} elseif($_GET['ket']=='batal'){

    $sql = "DELETE from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_user='$user'";
    mysqli_query($con,$sql);

    $sql1 = "DELETE from member_temp where member_temp_user_id='$user'";
    mysqli_query($con,$sql1);


		$_SESSION['order_type'] = "";
		$array_datas[] = ["ok"];
	echo json_encode($array_datas);

} elseif($_GET['ket']=='removeitem'){
	$id = $_POST['id'];	
    $sql = "DELETE from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_id='$id'";
    mysqli_query($con,$sql);

	$total = 0;
	$query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_user='$user' ORDER BY transaksi_gudang_detail_temp_id";
	$result = mysqli_query($con,$query);
	while($data = mysqli_fetch_assoc($result)) {
		$total+=$data['transaksi_gudang_detail_temp_total'];
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

	$sql1="SELECT * from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_id='$id'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$harga = $data1['transaksi_gudang_detail_temp_harga'];
	$tot = $harga*$jumlah;

	$array_datas['jumlahordertemp']=1;

	if ($jml>$data['barang_stok_gudang']) {

		$array_datas['totalordertemp']=["Stok Kurang"];

	} else {
		
		if ($keterangan=='minus' && $jumlah==0) {
			$sql="DELETE from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_id='$id'";
			$array_datas['jumlahordertemp']=0;
		} else {
			$sql="UPDATE transaksi_gudang_detail_temp set transaksi_gudang_detail_temp_jumlah='$jumlah',transaksi_gudang_detail_temp_total='$tot' where transaksi_gudang_detail_temp_id='$id'";
	
		}

		mysqli_query($con,$sql);

		$query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_id=$id ";
		$result = mysqli_query($con,$query);

		while($baris = mysqli_fetch_assoc($result)) {
		  $array_datas['item']=$baris;
		}

		$total = 0;
		$query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_user='$user' ORDER BY transaksi_gudang_detail_temp_id";
		$result = mysqli_query($con,$query);
		while($data = mysqli_fetch_assoc($result)) {
			$total+=$data['transaksi_gudang_detail_temp_total'];
		}

		$array_datas['totalordertemp']=$total;
	}
	
	echo json_encode($array_datas);

} elseif($_GET['ket']=='ordertype'){

	$id = $_POST['id'];	
	if ($id=='dinein') {
		$array_datas[] = ["dinein"];
		$_SESSION['order_type'] = "dinein";

	} elseif ($id=='takeaway') {
		$array_datas[] = ["takeaway"];
		$_SESSION['order_type'] = "takeaway";

	} elseif ($id=='online') {
		$array_datas[] = ["online"];
		$_SESSION['order_type'] = "online";

	}
	echo json_encode($array_datas);

} elseif($_GET['ket']=='pilihmember'){

	$idmember = $_POST['idmember'];
	$cs = $_POST['cs'];
	$kasir = $_POST['kasir'];

	$sql = "INSERT INTO member_temp(member_temp_member_id,member_temp_user_id,member_temp_cs,member_temp_kasir)values('$idmember','$user','$cs','$kasir')";

	mysqli_query($con,$sql);

	$query="SELECT * from member_temp, member, users where  member_temp_member_id=member_id and member_temp_user_id=id and member_temp_user_id='$user' ORDER BY member_temp_id DESC LIMIT 1";

	$result = mysqli_query($con,$query);

	while($baris = mysqli_fetch_assoc($result))
	{
	  $array_datas['member']=$baris;
	}

	echo json_encode($array_datas);	

} elseif($_GET['ket']=='tambahmember'){

	$nama = $_POST['nama'];
	$hp = $_POST['tlp'];

	$sqlcek="SELECT count(*) as jml from member where member_nama='$nama' and member_hp='$hp'";
	$querycek=mysqli_query($con,$sqlcek);
	$datacek=mysqli_fetch_assoc($querycek);

	if ($datacek['jml']!=0) {
		$array_datas['ket'] = "gagal";

	} else {
		$array_datas['ket'] = "sukses";
		$a = substr($nama,0,1);
		$qn= "SELECT COUNT( member_id ) AS jml FROM member where member_no LIKE '$a%'";
	    $rn=mysqli_query($con,$qn);
	    $dn=mysqli_fetch_assoc($rn);
	    if ($dn['jml']==NULL || $dn['jml']=='') {
	    	$nomember = $a."1";
	    } else {
	    	$jml = $dn['jml']+1;
	    	$nomember = $a."".$jml;
	    }

		$sql1 = "INSERT into member(member_no,member_nama,member_hp)values('$nomember','$nama','$hp')";
		mysqli_query($con,$sql1);

		$query="SELECT * from member where member_no='$nomember'";
		$result = mysqli_query($con,$query);
		while($baris = mysqli_fetch_assoc($result))
		{
		  $array_datas['member']=$baris;
		}
	}

	echo json_encode($array_datas);

} elseif($_GET['ket']=='prosestransaksi'){

	$total = $_POST['ip-total'];
	$nama = $_POST['ip-nama'];
	$paytype = $_POST['ip-paytype'];
	$jenisdiskon = $_POST['ip-jenisdiskon'];
	$jumlahdiskon = $_POST['ip-jumlahdiskon'];
	$tax = $_POST['ip-tax'];
	$bayar = $_POST['ip-bayar'];
	$debet = $_POST['ip-bayar-debet'];
	$debetket = $_POST['ip-bayar-debet-ket'];

	$kembalian = $bayar + $debet - $total;

	if ($paytype=='cashdebet') {
		$paytype = 'cash';
	}

	$sql1="SELECT * from member_temp where member_temp_user_id='$user'";
	$query1=mysqli_query($con,$sql1);
	$data1=mysqli_fetch_assoc($query1);
	$member = $data1['member_temp_member_id'];
	$kasir = $data1['member_temp_kasir'];
	$cs = $data1['member_temp_cs'];
	//$therapist = $data1['member_temp_therapist'];
	$therapist = 0;

	$qcn= "SELECT MAX( transaksi_gudang_id ) AS nota_print FROM transaksi_gudang ";
    $rcn=mysqli_query($con,$qcn);
    $dcn=mysqli_fetch_assoc($rcn);
    $nota_print = $dcn['nota_print']+1;
    $nota_print = 'GU'.$nota_print;

	$sql = "INSERT INTO transaksi_gudang (transaksi_gudang_nota_print,transaksi_gudang_tanggal,transaksi_gudang_bulan,transaksi_gudang_waktu,transaksi_gudang_member,transaksi_gudang_total,transaksi_gudang_diskon,transaksi_gudang_tax,transaksi_gudang_tax_service,transaksi_gudang_bayar,transaksi_gudang_type_bayar,transaksi_gudang_bayar_debet,transaksi_gudang_bayar_debet_ket,transaksi_gudang_user,transaksi_gudang_therapist,transaksi_gudang_cs,transaksi_gudang_kasir,transaksi_gudang_nama,transaksi_gudang_ket) VALUES ('$nota_print','$tgl','$bln','$wkt','$member','$total','$jumlahdiskon','$tax','0','$bayar','$paytype','$debet','$debetket','$user','$therapist','$cs','$kasir','$nama','umum')" ;

	mysqli_query($con,$sql);

	$qn= "SELECT MAX( transaksi_gudang_id ) AS nota FROM transaksi_gudang where transaksi_gudang_user='$user' and transaksi_gudang_ket='umum'";
    $rn=mysqli_query($con,$qn);
    $dn=mysqli_fetch_assoc($rn);
    $no_not = $dn['nota'];
    $_SESSION['no-nota'] = $no_not;	

    $query="SELECT * from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_user='$user'";
	$result = mysqli_query($con,$query);
	while($baris = mysqli_fetch_assoc($result)) {

    	$barang = $baris['transaksi_gudang_detail_temp_barang_id'];
    	$harga = $baris['transaksi_gudang_detail_temp_harga'];
    	$hargabeli = $baris['transaksi_gudang_detail_temp_harga_beli'];
    	$diskon = $baris['transaksi_gudang_detail_temp_diskon'];
    	$jumlah = $baris['transaksi_gudang_detail_temp_jumlah'];
    	$total = $baris['transaksi_gudang_detail_temp_total'];
    	$ket = $baris['transaksi_gudang_detail_temp_keterangan'];
    	$status = $baris['transaksi_gudang_detail_temp_status'];
    	$user = $baris['transaksi_gudang_detail_temp_user'];


    	$a="INSERT into transaksi_gudang_detail(transaksi_gudang_detail_nota,transaksi_gudang_detail_barang_id,transaksi_gudang_detail_harga,transaksi_gudang_detail_harga_beli,transaksi_gudang_detail_diskon,transaksi_gudang_detail_jumlah,transaksi_gudang_detail_total,transaksi_gudang_detail_keterangan,transaksi_gudang_detail_status,transaksi_gudang_detail_user)values('$no_not','$barang','$harga','$hargabeli','$diskon','$jumlah','$total','$ket','$status','$user')";
		mysqli_query($con,$a);

		//Select Stok Barang
		$sqlstok="SELECT * from barang where barang_id='$barang'";
        $resultstok=mysqli_query($con,$sqlstok);
	    $datastok=mysqli_fetch_assoc($resultstok);

		$awal=$datastok['barang_stok'];
		$awalgudang=$datastok['barang_stok_gudang'];

        if($datastok['barang_set_stok']!=0) {
        	echo 'www';
        	$jml_stok_gudang = $datastok['barang_stok_gudang'] - $jumlah;
        	
	        $sql1 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$barang','$awalgudang','$jml_stok_gudang','$tgl','','transaksi','Gudangumum')";
			mysqli_query($con,$sql1);
        
	        $sqlupdatestokgudang = "UPDATE barang SET barang_stok_gudang='$jml_stok_gudang' WHERE barang_id='$barang'";
	        mysqli_query($con,$sqlupdatestokgudang);



        	$jml_stok = $datastok['barang_stok'] + $jumlah;
        	
	        $sql2 = "INSERT into log_stok(user,barang,stok_awal,stok_jumlah,tanggal,alasan,keterangan,tempat)values('$user','$barang','$awal','$jml_stok','$tgl','','tambah','Toko')";
			//mysqli_query($con,$sql2);
        
	        $sqlupdatestok = "UPDATE barang SET barang_stok='$jml_stok' WHERE barang_id='$barang'";
	        //mysqli_query($con,$sqlupdatestok);

        }

		
    }

    $_SESSION['kembalian'] = $kembalian;
    $_SESSION['print'] = 'ya';
    $_SESSION['order']='';

    $sqldelete = "DELETE from transaksi_gudang_detail_temp where transaksi_gudang_detail_temp_user='$user'";
    mysqli_query($con,$sqldelete);

    $sqldelete1 = "DELETE from member_temp where member_temp_user_id='$user'";
    mysqli_query($con,$sqldelete1);

    $array_dataa = array('nota'=>$no_not);


	echo json_encode($array_dataa);

}  elseif($_GET['ket']=='tutupkasir'){

	$uangfisik = $_POST['uangfisik'];
	//$uangfisik = 200000;

	$sqlcek="SELECT count(*) as jml from validasi_gudang where validasi_gudang_user_id='$user' and validasi_gudang_tanggal='$tgl'";
	$querycek=mysqli_query($con,$sqlcek);
	$datacek=mysqli_fetch_assoc($querycek);

	if ($datacek['jml']!=0) {
		$array_datas['ket'] = "gagal";

	} else {

		$sql="SELECT * from users where id='$user'";
		$query=mysqli_query($con,$sql);
		$data=mysqli_fetch_assoc($query);
		$usernama=$data['name'];

		$sql1="SELECT count(transaksi_gudang_id) as jumlah, sum(transaksi_gudang_total) as total, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang where transaksi_gudang_tanggal='$tgl' and transaksi_gudang_user = '$user' and transaksi_gudang_ket='umum' group by transaksi_gudang_tanggal";
		$query1=mysqli_query($con,$sql1);
		$data1=mysqli_fetch_assoc($query1);

		$sql2="SELECT count(transaksi_gudang_id) as jumlah, sum(transaksi_gudang_total) as debet, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang where transaksi_gudang_tanggal='$tgl' and transaksi_gudang_user = '$user' and transaksi_gudang_ket='umum' and transaksi_gudang_type_bayar='Debet' group by transaksi_gudang_tanggal";
		$query2=mysqli_query($con,$sql2);
		$data2=mysqli_fetch_assoc($query2);

		$query11=mysqli_query($con,"SELECT count(transaksi_gudang_id) as jumlah, sum(transaksi_gudang_bayar_debet) as total, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang where transaksi_gudang_tanggal='$tgl' and transaksi_gudang_user = '$user' and transaksi_gudang_ket='umum' group by transaksi_gudang_tanggal ");
		$datadebet1=mysqli_fetch_assoc($query11);
		$ddebet = isset($data2['debet']) ? $data2['debet'] : '0';
		$omsetdebet = $ddebet+$datadebet1['total'];

		$sql3="SELECT count(transaksi_gudang_id) as jumlah, sum(transaksi_gudang_total) as cash, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang where transaksi_gudang_tanggal='$tgl' and transaksi_gudang_user = '$user' and transaksi_gudang_ket='umum' and transaksi_gudang_type_bayar='Cash' group by transaksi_gudang_tanggal";
		$query3=mysqli_query($con,$sql3);
		$data3=mysqli_fetch_assoc($query3);
		$dcash = isset($data3['cash']) ? $data3['cash'] : '0';
		$omsetcash = $dcash-$datadebet1['total'];

		if ($ddebet=='') {
			$totdebet = 0;
		} else {
			$totdebet = $omsetdebet;
		}

		if ($dcash=='') {
			$totcash = 0;
		} else {
			$totcash = $omsetcash;
		}

		$a="INSERT into validasi_gudang(validasi_gudang_tanggal,validasi_gudang_waktu,validasi_gudang_user_id,validasi_gudang_user_nama,validasi_gudang_jumlah,validasi_gudang_cash,validasi_gudang_debet,validasi_gudang_omset)values('$tgl','$wkt','$user','$usernama','$uangfisik','$totcash','$totdebet','$data1[total]')";
			mysqli_query($con,$a);


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