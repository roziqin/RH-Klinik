<?php
    if ($_GET['menu']=='home' || $_GET['menu']=='') {

        include "components/dashboard.page.php";

    } elseif ($_GET['menu']=='pendaftaran') {

        include "components/pendaftaran.page.php";

    } elseif ($_GET['menu']=='transaksi') {

        include "components/transaksi.page.php";

    } elseif ($_GET['menu']=='pembayaran') {

        include "components/pembayaran.page.php";

    } elseif ($_GET['menu']=='apotek') {

        include "components/apotek.page.php";

    } elseif ($_GET['menu']=='pembelian') {

        include "components/pembelian.page.php";

    } elseif ($_GET['menu']=='transaksigudang') {

        include "components/transaksigudang.page.php";

    } elseif ($_GET['menu']=='transaksigudangumum') {

        include "components/transaksigudangumum.page.php";

    } elseif ($_GET['menu']=='transaksibarangmasuk') {

        include "components/transaksibarangmasuk.page.php";

    } elseif ($_GET['menu']=='stok') {

        include "components/stok.page.php";

    } elseif ($_GET['menu']=='stokgudang') {

        include "components/stokgudang.page.php";

    } elseif ($_GET['menu']=='produk') {

        include "components/produk.page.php";

    } elseif ($_GET['menu']=='laporan') {

        include "components/laporan.page.php";

    } elseif ($_GET['menu']=='member') {

        include "components/member.page.php";

    } elseif ($_GET['menu']=='user') {

        include "components/user.page.php";

    } elseif ($_GET['menu']=='setting') {

        include "components/setting.page.php";

    }