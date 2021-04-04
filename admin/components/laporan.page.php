
	<div class="container-fluid p-0 fadeIn animated position-relative" style="z-index: 1;">
		<div class="row header-content pt-3 pb-0 info-color text-white ">
			<div class="col-md-9">
				<h2>Laporan</h2>
			</div>
			<div class="col-md-3">
				<?php include 'partials/notifications.php'; ?>
			</div>
			<div class="col-md-12 pl-0 pr-0 border-top border-white mb-0 pt-2 ">
				<ul class="nav">
				    <li class="nav-item">
				      <a class="nav-link waves-light active show" id="omset">Omset</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="kasir">Kasir</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="member">Member</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="nota">Nota</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="menu">Item Terjual</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="pembelian">Pembelian</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="mutasi">Mutasi</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="stokmenu">Stok</a>
				    </li>
				    <!--
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="stok">Stok Masuk</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="stokkeluar">Stok Keluar</a>
				    </li>
					-->
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="validasi">Validasi</a>
				    </li>
				</ul>
			</div>
		</div>
	</div>
	
	<main class="pt-4 produk pl-3 pr-3 mr-0">
		<div class="main-wrapper">
		    <div class="container-fluid">
				<div class="row mt-2 ">
					<div class="col-md-12 container__load fadeIn animated">
						
					</div>
				</div>
		    </div>
		</div>
	</main>


	<?php include 'partials/footer.php'; ?>

	<script type="text/javascript">
		$(document).ready(function(){
			$('.nav-link').click(function(){
				var menu = $(this).attr('id');
				if(menu == "omset"){
					$('.container__load').load('components/content/laporan.content.php?ket=omset');						
				} else if(menu == "kasir"){
					$('.container__load').load('components/content/laporan.content.php?ket=kasir');			
				} else if(menu == "nota"){
					$('.container__load').load('components/content/laporan.content.php?ket=nota');			
				} else if(menu == "menu"){
					$('.container__load').load('components/content/laporan.content.php?ket=menu');			
				} else if(menu == "stok"){
					$('.container__load').load('components/content/laporan.content.php?ket=stok');			
				} else if(menu == "stokkeluar"){
					$('.container__load').load('components/content/laporan.content.php?ket=stokkeluar');			
				} else if(menu == "validasi"){
					$('.container__load').load('components/content/laporan.content.php?ket=validasi');			
				} else if(menu == "pembelian"){
					$('.container__load').load('components/content/laporan.content.php?ket=pembelian');			
				} else if(menu == "member"){
					$('.container__load').load('components/content/laporan.content.php?ket=member');			
				} else if(menu == "mutasi"){
					$('.container__load').load('components/content/laporan.content.php?ket=mutasi');			
				} else if(menu == "stokmenu"){
					$('.container__load').load('components/content/laporan.content.php?ket=stokmenu');			
				} 
			});
	 
			$('.container__load').load('components/content/laporan.content.php?ket=omset');
	 
		});
	</script>


