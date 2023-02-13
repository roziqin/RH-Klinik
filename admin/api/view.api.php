<?php
include '../../config/database.php';
session_start();
$bln=date('Y-m');
$user = $_SESSION['login_user'];

$func = $_GET['func'];

if ($func=='dasboard-omset') {

	$query = "SELECT transaksi_tanggal, sum(transaksi_total) as total FROM transaksi where transaksi_bulan = '$bln' GROUP BY transaksi_tanggal";

} elseif ($func=='dasboard-pelanggan') {

	$query = "SELECT count(*) as jumlah FROM transaksi where transaksi_bulan = '$bln' GROUP BY transaksi_tanggal";

} elseif ($func=='dasboard-itemsold') {

    $id = $_POST['jenisid'];
    $query = "SELECT jenis_nama, barang_nama, sum(transaksi_detail_jumlah) as jumlah FROM transaksi, transaksi_detail, barang, kategori, jenis where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_kategori=kategori_id and kategori_jenis=jenis_id and jenis_id='$id' and transaksi_bulan='$bln' GROUP BY barang_id ORDER BY jumlah DESC LIMIT 10";

} elseif ($func=='getjenis') {

    $query = "SELECT * from jenis ORDER BY jenis_id ASC";

} elseif ($func=='listproduk') {

	$query = "SELECT barang_nama, kategori_nama, barang_stok, barang_harga_beli, barang_harga_jual, barang_harga_jual_online FROM barang, kategori where barang_kategori=kategori_id";

} elseif ($func=='editproduk') {
	$id = $_POST['produk_id'];
	$query = "SELECT * from barang, kategori where barang_kategori=kategori_id and barang_id='$id'";

} elseif ($func=='listkategori') {

	$query = "SELECT * FROM kategori";

} elseif ($func=='editkategori') {
	$id = $_POST['kategori_id'];
	$query = "SELECT * from kategori where kategori_id='$id'";

} elseif ($func=='editjenis') {
    $id = $_POST['jenis_id'];
    $query = "SELECT * from jenis where jenis_id='$id'";

} elseif ($func=='edituser') {
	$id = $_POST['id'];
	$query = "SELECT * from users where id='$id'";

} elseif ($func=='editmember') {
    $id = $_POST['id'];
    $query = "SELECT * from member where member_id='$id'";

} elseif ($func=='editsetting') {
	$id = 1;
	$query = "SELECT * from pengaturan_perusahaan where pengaturan_id='$id'";

} elseif ($func=='editstok') {
	$id = $_POST['id'];
	$query = "SELECT * from barang where barang_id='$id'";

} elseif ($func=='historymember') {
    $id = $_POST['id'];
    $query = "SELECT * from transaksi, transaksi_detail, barang, kategori, jenis where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_kategori=kategori_id and kategori_jenis=jenis_id and transaksi_member='$id' ORDER BY transaksi_tanggal DESC";

} elseif ($func=='historytransaksi') {
    $id = $_POST['id'];
    $query = "SELECT * from transaksi, transaksi_detail, barang, kategori, jenis where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_kategori=kategori_id and kategori_jenis=jenis_id and transaksi_detail_nota='$id'";

} elseif ($func=='detailkomisi') {
    $id = $_POST['id'];
    $role = $_POST['role'];
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tahun1 = $_POST['tahun'];
    $bln1 = $bulan - 1;
    if ($bln1==0) {
        # code...
        $bln1=12;
        $tahun1 = $tahun1 - 1;
    }
    if ($bln1<10) {
        # code...
        $bln1 = '0'.$bln1;
    }
    $tgl1=$tahun1.'-'.$bln1."-01";
    $tgl2=$tahun.'-'.$bulan.'-31';
    $t = $bulan.'-'.$tahun;
    if ($role=='dokter') {
        $query = "SELECT transaksi_tanggal, barang_nama, transaksi_detail_komisi_dokter as komisi FROM transaksi, transaksi_detail, barang where transaksi_id=transaksi_detail_nota and barang_id=transaksi_detail_barang_id and transaksi_dokter='$id' and transaksi_tanggal between '$tgl1' and '$tgl2'";
    } elseif ($role=='therapist') {
        $query = "SELECT transaksi_tanggal, barang_nama, transaksi_detail_komisi_therapist as komisi FROM transaksi, transaksi_detail, barang where transaksi_id=transaksi_detail_nota and barang_id=transaksi_detail_barang_id and transaksi_therapist='$id' and transaksi_tanggal between '$tgl1' and '$tgl2'";
    }

} elseif ($func=='list-transaksi-temp') {
    $query="SELECT * from transaksi_detail_temp, barang, kategori where transaksi_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_detail_temp_user='$user' ORDER BY transaksi_detail_temp_id";
} elseif ($func=='list-transaksi-temp-gudang') {
    $query="SELECT * from transaksi_gudang_detail_temp, barang, kategori where transaksi_gudang_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_gudang_detail_temp_user='$user' ORDER BY transaksi_gudang_detail_temp_id";
} elseif ($func=='list-transaksibarangmasuk-temp') {
    $query="SELECT * from transaksi_barangmasuk_detail_temp, barang, kategori where transaksi_barangmasuk_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and transaksi_barangmasuk_detail_temp_user='$user' ORDER BY transaksi_barangmasuk_detail_temp_id";
} elseif ($func=='list-pembelian-temp') {
    $query="SELECT * from pembelian_detail_temp, barang, kategori where pembelian_detail_temp_barang_id=barang_id and kategori_id=barang_kategori and pembelian_detail_temp_user='$user' ORDER BY pembelian_detail_temp_id";
} elseif ($func=='list-member-temp') {

    $query="SELECT * from member_temp, member, users where  member_temp_member_id=member_id and member_temp_dokter=id and member_temp_user_id='$user' ORDER BY member_temp_id DESC LIMIT 1";

} elseif ($func=='list-pendaftaran') {

    $query="SELECT * from pendaftaran, member, users where pendaftaran_member=member_id and pendaftaran_dokter=id and pendaftaran_user='$user' and pendaftaran_status=0";

} elseif ($func=='list-faktur-temp') {

    $query="SELECT * from transaksi_barangmasuk_temp, users where transaksi_barangmasuk_temp_user=id and transaksi_barangmasuk_temp_user='$user' ORDER BY transaksi_barangmasuk_temp_id DESC LIMIT 1";

} elseif ($func=='laporan-omset') {
	
    
    $typebayar = $_POST['typebayar'];
    if ($typebayar=='') {
        $bayartext = '';
    } else {
        $bayartext = "transaksi_type_bayar='".$typebayar."' and ";

    }
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
		$tgl11 = date("Y-m-j", strtotime($_POST['start']));
	    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
		$tgl11 = date("Y-m", strtotime($_POST['start']));
	    $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

	$query ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_total) as total, sum(transaksi_diskon) as diskon from transaksi WHERE $bayartext $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

} elseif ($func=='laporan-laba') {
    
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
        $tgl11 = date("Y-m", strtotime($_POST['start']));
        $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

    $query ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_total) as total, sum(transaksi_diskon) as diskon from transaksi WHERE $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

} elseif ($func=='laporan-omsetkategori') {
    
    $kategori = $_POST['kategori'];

    if ($kategori=='-') {
        $text1 = '';
    } else {
        $text1 = 'barang_kategori='.$kategori.' and ';

    }
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
        $tgl11 = date("Y-m", strtotime($_POST['start']));
        $tgl22 = date("Y-m", strtotime($_POST['end']));
    }


    $query ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_detail_total) as total, kategori_nama, barang_kategori from transaksi, transaksi_detail, barang, kategori WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and barang_kategori=kategori_id and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

} elseif ($func=='laporan-labagudang') {
    

    $bayartext = '';
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_gudang_tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_gudang_bulan";     
        $tgl11 = date("Y-m", strtotime($_POST['start']));
        $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

    $query ="SELECT transaksi_gudang_tanggal, transaksi_gudang_bulan, sum(transaksi_gudang_total) as total, sum(transaksi_gudang_bayar_debet) as debet, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang WHERE transaksi_gudang_nota_print LIKE '%GU%' and $bayartext $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

} elseif ($func=='laporan-omsetgudang') {
    
    
    $typebayar = $_POST['typebayar'];
    if ($typebayar=='') {
        $bayartext = '';
    } else {
        $bayartext = "transaksi_gudang_type_bayar='".$typebayar."' and ";

    }
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_gudang_tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_gudang_bulan";     
        $tgl11 = date("Y-m", strtotime($_POST['start']));
        $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

    $query ="SELECT transaksi_gudang_tanggal, transaksi_gudang_bulan, sum(transaksi_gudang_total) as total, sum(transaksi_gudang_bayar_debet) as debet, sum(transaksi_gudang_diskon) as diskon from transaksi_gudang WHERE $bayartext $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket  ";

} elseif ($func=='laporan-kasir') {
	
    $kasir = $_POST['kasir'];

    if ($kasir==0) {
        $text1 = '';
        $text2 = ', transaksi_user';
    } else {
        $text1 = 'transaksi_user='.$kasir.' and ';
        $text2 = '';

    }

    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
		$tgl11 = date("Y-m-j", strtotime($_POST['start']));
	    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
		$tgl11 = date("Y-m", strtotime($_POST['start']));
	    $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

	$query ="SELECT transaksi_tanggal, transaksi_bulan, sum(transaksi_total) as total, sum(transaksi_diskon) as diskon, transaksi_user, id, name from transaksi, users WHERE transaksi_user=id and $text1 $bayartext $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ";

}  elseif ($func=='laporan-menu') {
	
    $menu = $_POST['menu'];

    if ($menu==0) {
        $text1 = '';
        $text2 = ', barang_id';
    } else {
        $text1 = 'barang_id='.$menu.' and ';
        $text2 = '';

    }

    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
		$tgl11 = date("Y-m-j", strtotime($_POST['start']));
	    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
		$tgl11 = date("Y-m", strtotime($_POST['start']));
	    $tgl22 = date("Y-m", strtotime($_POST['end']));
    }

	$query ="SELECT transaksi_tanggal, transaksi_bulan, barang_nama, barang_id, sum(transaksi_detail_jumlah) as jumlah from transaksi, transaksi_detail, barang WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 ORDER BY transaksi_tanggal ASC";

}  elseif ($func=='laporan-stok') {
    
    $menu = $_POST['menu'];

    if ($menu==0) {
        $text1 = '';
        $text2 = ', barang_id';
    } else {
        $text1 = 'barang_id='.$menu.' and ';
        $text2 = '';

    }

        $ket = "tanggal"; 
        $tgl11 = date("Y-m-j", strtotime($_POST['start']));
        $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from log_stok, barang, users WHERE log_stok.barang=barang_id and id=log_stok.user and keterangan='tambah' and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' ORDER BY tanggal ASC";

}  elseif ($func=='laporan-stokkeluar') {
    
    $menu = $_POST['menu'];

    if ($menu==0) {
        $text1 = '';
        $text2 = ', barang_id';
    } else {
        $text1 = 'barang_id='.$menu.' and ';
        $text2 = '';

    }
    
    $ket = "transaksi_tanggal"; 
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));


    $query ="SELECT name, transaksi_tanggal, barang_nama, barang_id, sum(transaksi_detail_jumlah) as jumlah from transaksi, transaksi_detail, barang, users WHERE transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and transaksi_user=users.id and barang_set_stok=1 and $text1 $ket BETWEEN '$tgl11' AND '$tgl22' GROUP BY $ket $text2 , users.id ORDER BY transaksi_tanggal ASC";

}  elseif ($func=='laporan-validasi') {

    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));

    $query="SELECT * from  validasi WHERE validasi_tanggal BETWEEN '$tgl11' AND '$tgl22' ORDER BY validasi_id asc";
    
} elseif ($func=='laporan-nota') {
       
    $ket = "transaksi_tanggal"; 

    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from transaksi, users, member WHERE transaksi_member=member_id and transaksi_user=id and transaksi_tanggal BETWEEN '$tgl11' AND '$tgl22'  ";

} elseif ($func=='cek-nota') {
       
    $nota = $_POST['notaid'];

    $query ="SELECT * from transaksi_detail, barang where transaksi_detail_barang_id=barang_id and transaksi_detail_nota='$nota' ORDER BY transaksi_detail_id ASC";

} elseif ($func=='laporan-pembelian') {
       
    $ket = "pembelian_tanggal"; 
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from pembelian, users WHERE pembelian_user=id and pembelian_tanggal BETWEEN '$tgl11' AND '$tgl22'  ";

} elseif ($func=='laporan-gaji') {

    $query ="SELECT * from users, roles WHERE role=roles_id ";

} elseif ($func=='cek-pembelian') {
       
    $nota = $_POST['notaid'];

    $query ="SELECT * from pembelian_detail, barang where pembelian_detail_barang_id=barang_id and pembelian_detail_nota='$nota' ORDER BY pembelian_detail_id ASC";

} elseif ($func=='cek-transaksi') {
       
    $nota = $_POST['notaid'];

    $query ="SELECT * from transaksi_detail, barang where transaksi_detail_barang_id=barang_id and transaksi_detail_nota='$nota' ORDER BY transaksi_detail_id ASC";

} elseif ($func=='laporan-member') {
       
    $member = $_POST['member'];
    $ket = "transaksi_tanggal"; 
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));
    

    $query ="SELECT * from transaksi, users, member WHERE transaksi_member=member_id and transaksi_user=id and transaksi_member=$member and transaksi_tanggal BETWEEN '$tgl11' AND '$tgl22'  ";

}  elseif ($func=='laporan-mutasi') {
    
    $query ="SELECT * from barang WHERE barang_set_stok=1 ORDER BY barang_nama ASC";

}  elseif ($func=='laporan-stokmenu') {
    
    $menu = $_POST['menu'];
    
    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));


    $query ="SELECT * FROM log_stok where barang='$menu' and tanggal BETWEEN '$tgl11' AND '$tgl22' ORDER BY tanggal ASC";

}


$result = mysqli_query($con,$query);
$array_data = array();
if ($func=="laporan-omset" || $func=="laporan-kasir") {
	
	if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
    }
    
    //$ket = "transaksi_tanggal";
	while($data = mysqli_fetch_assoc($result))
	{
		if ($func=="laporan-kasir") {
	        $text = 'transaksi_user='.$data['id'].' and ';
            $text1 = '';
	    } else {
	    	$text = '';
            $text1 = '';
	    }

		$tglket = $data[$ket];
        $sqlcash="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='cash' GROUP BY $ket $text1 ";
        $querycash=mysqli_query($con, $sqlcash);
        $datacash=mysqli_fetch_assoc($querycash);
        $totalcash = 0;
        if ($datacash['total']!='') {
            $totalcash = $datacash['total'];
        }
		
        /*
        $sqlonline="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='GoResto' GROUP BY $ket $text1 ";
        $queryonline=mysqli_query($con, $sqlonline);
        $dataonline=mysqli_fetch_assoc($queryonline);
        */
        $totalonline = 0;
        //if ($dataonline['total']!='') {
        //    $totalonline = $dataonline['total'];
        //}

        $sqldebet="SELECT sum(transaksi_total) as total from transaksi WHERE $text $ket='$tglket' and transaksi_type_bayar='debet' GROUP BY $ket $text1 ";
        $querydebet=mysqli_query($con, $sqldebet);
        $datadebet=mysqli_fetch_assoc($querydebet);
        $totaldebet = 0;
        if ($datadebet['total']!='') {
            $totaldebet = $datadebet['total'];
        }
        
	  //$array_data[]=($ket=>$data[$ket], 'cash'=>$totalcash, 'debet'=>$totaldebet, 'online'=>$totalonline);
        if ($func=="laporan-kasir") {
			$row_array['kasir'] = $data['name'];
        }
        $typebayar = $_POST['typebayar'];
        if ($typebayar=="debet") {
            $totalcash = 0;
        } elseif ($typebayar=="cash") {
            $totaldebet = 0;
        }
		$row_array[$ket] = $data[$ket];
	    $row_array['cash'] = $totalcash;
	    $row_array['debet'] = $totaldebet;
	    $row_array['online'] = $totalonline;
		$row_array['total'] = $data['total'];
        array_push($array_data,$row_array);
	}
} elseif ($func=="laporan-laba") {
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
    }
    
    //$ket = "transaksi_tanggal";
    while($data = mysqli_fetch_assoc($result))
    {
        
        $tglket = $data[$ket];
        $sqlcash="SELECT transaksi_detail_jumlah, sum(transaksi_detail_harga*transaksi_detail_jumlah) as jual, sum(transaksi_detail_harga_beli*transaksi_detail_jumlah) as beli, sum(transaksi_detail_diskon*transaksi_detail_jumlah) as diskon  from transaksi, transaksi_detail WHERE transaksi_id=transaksi_detail_nota and $ket='$tglket' GROUP BY $ket ";
        $querycash=mysqli_query($con, $sqlcash);
        $datacash=mysqli_fetch_assoc($querycash);

        $totaljual = $datacash['jual'];
        $totalbeli = $datacash['beli'];
        $totaldiskon = $datacash['diskon'];

        $diskontran = $data["diskon"];

        $n = $data['total']-$totalbeli;

        $row_array[$ket] = $data[$ket];
        $row_array['laba'] = $n;
        $row_array['total'] = $data['total'];
        array_push($array_data,$row_array);
    }
} elseif ($func=="laporan-omsetkategori") {
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_bulan";     
    }
    
    //$ket = "transaksi_tanggal";
    while($data = mysqli_fetch_assoc($result))
    {
       
        $row_array[$ket] = $data[$ket];
        $row_array['kategori'] = $data['kategori_nama'];
        $row_array['total'] = $data['total'];
        array_push($array_data,$row_array);
    }
} elseif ($func=="laporan-omsetgudang") {
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_gudang_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_gudang_bulan";     
    }
    
    //$ket = "transaksi_gudang_tanggal";
    while($data = mysqli_fetch_assoc($result))
    {
        if ($func=="laporan-kasir") {
            $text = 'transaksi_gudang_user='.$data['id'].' and ';
            $text1 = '';
        } else {
            $text = '';
            $text1 = '';
        }

        $tglket = $data[$ket];

        $sqldebet1="SELECT sum(transaksi_gudang_bayar_debet) as total from transaksi_gudang WHERE $ket='$tglket' GROUP BY $ket ";
        $querydebet1=mysqli_query($con, $sqldebet1);
        $datadebet1=mysqli_fetch_assoc($querydebet1);
        $totaldebet1 = 0;

        $totaldebet1 = isset($datadebet1['total']) ? $datadebet1['total'] : '0';

        $sqldebet="SELECT sum(transaksi_gudang_total) as total from transaksi_gudang WHERE $ket='$tglket' and transaksi_gudang_type_bayar='Debet' GROUP BY $ket ";
        $querydebet=mysqli_query($con, $sqldebet);
        $datadebet=mysqli_fetch_assoc($querydebet);
        $totaldebet = 0;
        $totaldebet = isset($datadebet['total']) ? $datadebet['total'] : '0';
        $totaldebet = $totaldebet + $totaldebet1;

        $sqlcash="SELECT sum(transaksi_gudang_total) as total from transaksi_gudang WHERE $ket='$tglket' and transaksi_gudang_type_bayar='Cash' GROUP BY $ket ";
        $querycash=mysqli_query($con, $sqlcash);
        $datacash=mysqli_fetch_assoc($querycash);
        $totalcash = 0;
        $dcash = isset($datacash['total']) ? $datacash['total'] : '0';

        $totalcash = $datacash['total'] - $totaldebet1;

        
      //$array_data[]=($ket=>$data[$ket], 'cash'=>$totalcash, 'debet'=>$totaldebet, 'online'=>$totalonline);
        
        $typebayar = $_POST['typebayar'];
        if ($typebayar=="debet") {
            $totalcash = 0;
        } elseif ($typebayar=="cash") {
            $totaldebet = 0;
        }
        
        $row_array[$ket] = $data[$ket];
        $row_array['cash'] = $totalcash;
        $row_array['debet'] = $totaldebet;
        $row_array['online'] = 0;
        $row_array['total'] = $data['total']+$data['debet'];
        array_push($array_data,$row_array);
    }
} elseif ($func=="laporan-labagudang") {
    
    if ($_POST['daterange']=="harian") {
        $ket = "transaksi_gudang_tanggal"; 
    } elseif ($_POST['daterange']=="bulanan") {
        $ket = "transaksi_gudang_bulan";     
    }
    
    //$ket = "transaksi_gudang_tanggal";
    while($data = mysqli_fetch_assoc($result))
    {
       
        $text = '';
        $text1 = '';

        $tglket = $data[$ket];
        $sqlcash="SELECT transaksi_gudang_detail_jumlah, sum(transaksi_gudang_detail_harga*transaksi_gudang_detail_jumlah) as jual, sum(transaksi_gudang_detail_harga_beli*transaksi_gudang_detail_jumlah) as beli, sum(transaksi_gudang_detail_diskon*transaksi_gudang_detail_jumlah) as diskon  from transaksi_gudang, transaksi_gudang_detail WHERE transaksi_gudang_id=transaksi_gudang_detail_nota and transaksi_gudang_nota_print LIKE '%GU%' and $ket='$tglket' GROUP BY $ket ";
        $querycash=mysqli_query($con, $sqlcash);
        $datacash=mysqli_fetch_assoc($querycash);

        $totaljual = $datacash['jual'];
        $totalbeli = $datacash['beli'];
        $totaldiskon = $datacash['diskon'];

        $diskontran = $data["diskon"];

        $n = $totaljual-$totalbeli-$diskontran;

      
        $row_array[$ket] = $data[$ket];
        $row_array['laba'] = $n;
        $row_array['total'] = $data['total']+$data['debet'];
        array_push($array_data,$row_array);
    }
} elseif ($func=="cek-nota") {

    $nota = $_POST['notaid'];
    $sqlnot="SELECT * FROM transaksi, users, member where transaksi_member=member_id and transaksi_user=id and transaksi_id='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $total = $datanot['transaksi_total'];
    $pelanggan = $datanot['member_nama'];
    $therapist = $datanot['transaksi_therapist'];
    $diskon = $datanot['transaksi_diskon'];
    $user = $datanot['name'];

    $sqlt="SELECT * FROM users where id='$therapist' ";
    $queryt=mysqli_query($con,$sqlt);
    $datat=mysqli_fetch_assoc($queryt);
    $namatherapist = $datat['name'];

    $row_array['subtotal'] = $total+$diskon;
    $row_array['total'] = $total;
    $row_array['pelanggan'] = $pelanggan;
    $row_array['user'] = $user;
    $row_array['therapist'] = $namatherapist;
    $row_array['potongan'] = $diskon;
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="laporan-gaji") {
    
    $bulan = $_POST['bulan'];
    $tahun = $_POST['tahun'];
    $tahun1 = $_POST['tahun'];
    $bln1 = $bulan - 1;
    if ($bln1==0) {
        # code...
        $bln1=12;
        $tahun1 = $tahun1 - 1;
    }
    if ($bln1<10) {
        # code...
        $bln1 = '0'.$bln1;
    }
    $tgl1=$tahun1.'-'.$bln1."-01";
    $tgl2=$tahun.'-'.$bulan.'-31';
    $t = $bulan.'-'.$tahun;
    
    //$ket = "transaksi_tanggal";
    while($data = mysqli_fetch_assoc($result))
    {
        $role = $data['roles_name'];
        $id = $data['id'];
        $totalkomisi = 0;
        if ($role=='dokter') {
            $sqlkomisi="SELECT sum(transaksi_detail_komisi_dokter) as total, sum(barang_komisi_dokter) as komisi from transaksi, transaksi_detail, barang where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and transaksi_dokter='$id' and transaksi_tanggal between '$tgl1' and '$tgl2'";
            $querykomisi=mysqli_query($con, $sqlkomisi);
            $datakomisi=mysqli_fetch_assoc($querykomisi);
            if ($datakomisi['total']!='') {
                $totalkomisi = $datakomisi['komisi'];
            }
        } elseif ($role=='therapist') {
            $sqlkomisi="SELECT sum(transaksi_detail_komisi_therapist) as total, sum(barang_komisi) as komisi from transaksi, transaksi_detail, barang where transaksi_id=transaksi_detail_nota and transaksi_detail_barang_id=barang_id and transaksi_therapist='$id' and transaksi_tanggal between '$tgl1' and '$tgl2'";
            $querykomisi=mysqli_query($con, $sqlkomisi);
            $datakomisi=mysqli_fetch_assoc($querykomisi);
            
            if ($datakomisi['total']!='') {
                $totalkomisi = $datakomisi['komisi'];
            }
        }
        
        

        $row_array['id'] = $data['id'];
        $row_array['role'] = $data['roles_name'];
        $row_array['name'] = $data['name'];
        $row_array['gaji'] = $data['gaji'];
        $row_array['komisi'] = $totalkomisi;
        $row_array['total'] = $data['gaji']+$totalkomisi;
        array_push($array_data,$row_array);
    }

} elseif ($func=="detailkomisi") {

    $id = $_POST['id'];
    $sqluser="SELECT * FROM users, roles where role=roles_id and id='$id' ";
    $queryuser=mysqli_query($con,$sqluser);
    $datauser=mysqli_fetch_assoc($queryuser);

    $nama = $datauser['name'];
    $role = $datauser['roles_name'];
    $gajipokok = $datauser['gaji'];

    $row_array['nama'] = $nama;
    $row_array['role'] = $role;
    $row_array['gajipokok'] = $gajipokok;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="cek-pembelian") {

    $nota = $_POST['notaid'];
    $sqlnot="SELECT * FROM pembelian, users where pembelian_user=id and pembelian_id='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $total = $datanot['pembelian_total'];
    $user = $datanot['name'];

    $row_array['total'] = $total;
    $row_array['user'] = $user;
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="cek-transaksi") {

    $nota = $_POST['notaid'];
    $sqlnot="SELECT * FROM transaksi, users where transaksi_user=id and transaksi_id='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $total = $datanot['transaksi_total'];
    $user = $datanot['name'];

    $row_array['total'] = $total;
    $row_array['user'] = $user;
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="cek-pembelian") {

    $nota = $_POST['notaid'];
    $sqlnot="SELECT * FROM transaksi_barangmasuk, users where transaksi_barangmasuk_user=id and transaksi_barangmasuk_id='$nota' ";
    $querynot=mysqli_query($con,$sqlnot);
    $datanot=mysqli_fetch_assoc($querynot);

    $total = $datanot['transaksi_barangmasuk_total'];
    $user = $datanot['name'];
    $nofaktur = $datanot['transaksi_barangmasuk_nofaktur'];

    $row_array['nofaktur'] = $nofaktur;
    $row_array['total'] = $total;
    $row_array['user'] = $user;
    $row_array['notaid'] = $nota;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data[]=$data;
    }

} elseif ($func=="historymember") {

    $id = $_POST['id'];
    $sqlmember="SELECT * FROM member where member_id='$id' ";
    $querymember=mysqli_query($con,$sqlmember);
    $datamember=mysqli_fetch_assoc($querymember);

    $member_id = $datamember['member_id'];
    $member_no = $datamember['member_no'];
    $member_nama = $datamember['member_nama'];
    $member_alamat = $datamember['member_alamat'];
    $member_usia = $datamember['member_usia'];
    $member_hp = $datamember['member_hp'];
    $member_gender = $datamember['member_gender'];
    $member_tgl_lahir = $datamember['member_tgl_lahir'];

    $row_array['member']['member_id'] = $member_id;
    $row_array['member']['member_no'] = $member_no;
    $row_array['member']['member_nama'] = $member_nama;
    $row_array['member']['member_alamat'] = $member_alamat;
    $row_array['member']['member_usia'] = $member_usia;
    $row_array['member']['member_hp'] = $member_hp;
    $row_array['member']['member_gender'] = $member_gender;
    $row_array['member']['member_tgl_lahir'] = $member_tgl_lahir;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data['table'][]=$data;
    }

} elseif ($func=="historytransaksi") {

    $id = $_POST['id'];
    $sql1 = "SELECT * FROM transaksi,member where transaksi_member=member_id AND transaksi_id='$id'";
    $query1=mysqli_query($con,$sql1);
    $data1=mysqli_fetch_assoc($query1);
    $iddokter = $data1['transaksi_dokter'];
    $idtherapist = $data1['transaksi_therapist'];

    $sqldokter = "SELECT * FROM users where id='$iddokter'";
    $querydokter=mysqli_query($con,$sqldokter);
    $datadokter=mysqli_fetch_assoc($querydokter);

    $sqltherapist = "SELECT * FROM users where id='$idtherapist'";
    $querytherapist=mysqli_query($con,$sqltherapist);
    $datatherapist=mysqli_fetch_assoc($querytherapist);

    $member_id = $data1['member_id'];
    $member_nama = $data1['member_nama'];
    $member_alamat = $data1['member_alamat'];
    $member_usia = $data1['member_usia'];
    $member_hp = $data1['member_hp'];
    $member_gender = $data1['member_gender'];
    $member_tgl_lahir = $data1['member_tgl_lahir'];
    $dokter_nama = $datadokter['name'];
    $therapist_nama = $datatherapist['name'];

    $row_array['member']['member_id'] = $member_id;
    $row_array['member']['member_nama'] = $member_nama;
    $row_array['member']['member_alamat'] = $member_alamat;
    $row_array['member']['member_usia'] = $member_usia;
    $row_array['member']['member_hp'] = $member_hp;
    $row_array['member']['member_gender'] = $member_gender;
    $row_array['member']['member_tgl_lahir'] = $member_tgl_lahir;
    $row_array['member']['dokter_nama'] = $dokter_nama;
    $row_array['member']['therapist_nama'] = $therapist_nama;
    array_push($array_data,$row_array);
    while($data = mysqli_fetch_assoc($result))
    {
        $array_data['table'][]=$data;
    }

} elseif ($func=="laporan-mutasi") {

    $tgl11 = date("Y-m-j", strtotime($_POST['start']));
    $tgl22 = date("Y-m-j", strtotime($_POST['end']));

    while($baris = mysqli_fetch_assoc($result))
    {
        $barang_id = $baris['barang_id'];
        $barang_nama = $baris['barang_nama'];
        
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
        
        $row_array['barang_id'] = $barang_id;
        $row_array['barang_nama'] = $barang_nama;
        $row_array['stok_awal'] = $dataawal['stok_awal'];
        $row_array['stok_masuk'] = $datamasuk['stok_masuk'];
        $row_array['stok_keluar'] = $datakeluar['jumlah'] + $datakurang['stok_kurang'];
        $row_array['stok_sisa'] = $dataawal['stok_awal'] + $datamasuk['stok_masuk'] - $datakeluar['jumlah'] - $datakurang['stok_kurang'];
        array_push($array_data,$row_array);
    }

} elseif ($func=="laporan-stokmenu") {
    $n=0;
    while($baris = mysqli_fetch_assoc($result))
    {
        $tanggal = $baris['tanggal'];
        $stok_awal = $baris['stok_awal'];
        $stok_jumlah = $baris['stok_jumlah'];
        $keterangan = $baris['keterangan'];


        $row_array['tanggal'] = $tanggal;
        if ($n==0) {
            $row_array['stok_awal'] = $stok_awal;
        } else {
            $row_array['stok_awal'] = '-';
        }
        if ($keterangan=='tambah') {
            $row_array['stok_masuk'] = $stok_jumlah - $stok_awal;
            $row_array['stok_keluar'] = 0;
        } else {
            $row_array['stok_masuk'] = 0;
            $row_array['stok_keluar'] = $stok_awal - $stok_jumlah;

        }
        $row_array['stok_sisa'] = $stok_jumlah;
        array_push($array_data,$row_array);
        $n++;
    }

} elseif ($func=="list-member-temp") {
    $nama = '';
    while($baris = mysqli_fetch_assoc($result))
    {

        if ($baris['member_temp_member_id']==0) {
            $nama = $baris['member_temp_nama'];
        } else {
            $nama = $baris['member_nama'];            
        }
        $member_alamat = $baris['member_alamat'];
        $dokter = $baris['name'];
        $idtherapist = $baris['member_temp_therapist'];


        $sql="SELECT * FROM users Where id='$idtherapist' ";
        $query=mysqli_query($con,$sql);
        $data=mysqli_fetch_assoc($query);
        $therapist = $data['name'];

        
        $row_array['nama'] = $nama;
        $row_array['member_alamat'] = $member_alamat;
        $row_array['dokter'] = $dokter;
        $row_array['therapist'] = $therapist;
        array_push($array_data,$row_array);
    }

} else {
	while($baris = mysqli_fetch_assoc($result))
	{
	  $array_data[]=$baris;
	}
}

if ($func=='listproduk') {
	$array_datas = array();
	$array_datas['data'] = $array_data;
	echo json_encode($array_datas);
} else {

	echo json_encode($array_data);
}

?>


