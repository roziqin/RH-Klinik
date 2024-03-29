<?php
include '../modals/laporan.modal.php';
include '../modals/laporan-pembelian.modal.php';
$con = mysqli_connect("localhost","root","","klinik_new");
$ket = $_GET['ket'];

if ($ket=='omset' || $ket=='kasir') {
	if ($ket=='kasir') {
		$kasir = '';
		$col = 'col-md-6';
		$btn = 'btn-proses-laporan-kasir';
	} else {
		$kasir = 'hidden';
		$col = 'col-md-7';
		$btn = 'btn-proses-laporan-omset';
	}
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-typebayar" name="ip-typebayar">
		                    <option value="" selected>Pilih Bayar</option>
				            <option value="cash">Cash</option>
				            <option value="debet">Debet</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-2 <?php echo $kasir; ?>">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-kasir" name="ip-kasir">
		                    <option value="" disabled selected>Pilih Kasir</option>
		                <?php
		                	$sql="SELECT * from users";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[id]'>$data1[name]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="<?php echo $col; ?>">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary <?php echo $btn; ?>">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
					<?php
					if ($ket=='kasir') {
					?>
					<div class="col-md-12"><h2 class="text-center mb-4">Omset per Kasir</h2></div>
					<div class="col-md-12">
						<table id="table-kasir" class="table table-striped table-bordered" style="width:100%">
					        <thead>
					            <tr>
		                            <th>tanggal</th>
		                            <th>kasir</th>
		                            <th style="text-align: right;">Cash</th>
		                            <th style="text-align: right;">Debet</th>
		                            <th style="text-align: right;">total omset</th>
					            </tr>
					        </thead>
					    </table>
					</div>


					<?php
					} else {
					?>
					<div class="col-md-12"><h2 class="text-center mb-4">Omset</h2></div>
					<div class="col-md-12">
						<table id="table-omset" class="table table-striped table-bordered" style="width:100%">
					        <thead>
					            <tr>
		                            <th>tanggal</th>
		                            <th style="text-align: right;">Cash</th>
		                            <th style="text-align: right;">Debet</th>
		                            <th style="text-align: right;">total omset</th>
					            </tr>
					        </thead>
					    </table>
					</div>
					<div class="col-md-12">
					    <div class="md-form">
					    	<a class="btn btn-default export-omset hidden" href="" target="_blank">Export</a>
					    </div>
					</div>
					<?php
					}
					?>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='laba') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-8">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-laba">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
					<div class="col-md-12"><h2 class="text-center mb-4">Laba Rugi</h2></div>
					<div class="col-md-12">
						<table id="table-laba" class="table table-striped table-bordered" style="width:100%">
					        <thead>
					            <tr>
		                            <th>tanggal</th>
		                            <th style="text-align: right;">omset</th>
		                            <th style="text-align: right;">laba</th>
					            </tr>
					        </thead>
					    </table>
					</div>
					<div class="col-md-12">
					    <div class="md-form">
					    	<a class="btn btn-default export-laba hidden" href="" target="_blank">Export</a>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='omsetkategori') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-kategori" name="ip-kategori">
		                    <option value="-" selected>Pilih Kategori</option>
		                <?php
		                	$sql="SELECT * from kategori";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[kategori_id]'>$data1[kategori_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-omsetkategori">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
					<div class="col-md-12"><h2 class="text-center mb-4">Omset</h2></div>
					<div class="col-md-12">
						<table id="table-omsetkategori" class="table table-striped table-bordered" style="width:100%">
					        <thead>
					            <tr>
		                            <th>tanggal</th>
		                            <th>Kategori</th>
		                            <th style="text-align: right;">omset</th>
					            </tr>
					        </thead>
					    </table>
					</div>
					<div class="col-md-12">
					    <div class="md-form">
					    	<a class="btn btn-default export-omsetkategori hidden" href="" target="_blank">Export</a>
					    </div>
					</div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='menu') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-menu" name="ip-menu">
		                    <option value="" disabled selected>Pilih barang</option>
		                <?php
		                	$sql="SELECT * from barang";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[barang_id]'>$data1[barang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
					<div class="row form-month hidden">
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startmonth" name="ip-startmonth">
						                    <option value="" disabled selected>Bulan Mulai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="startyear" name="ip-startyear">
						                    <option value="" disabled selected>Tahun Mulai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form m-0">
				            	<div class="row">
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endmonth" name="ip-endmonth">
						                    <option value="" disabled selected>Bulan Sampai</option>
								            <option value="01">01</option>
								            <option value="02">02</option>
								            <option value="03">03</option>
								            <option value="04">04</option>
								            <option value="05">05</option>
								            <option value="06">06</option>
								            <option value="07">07</option>
								            <option value="08">08</option>
								            <option value="09">09</option>
								            <option value="10">10</option>
								            <option value="11">11</option>
								            <option value="12">12</option>
								        </select>
					            	</div>
					            	<div class="col-md-6">
								        <select class="mdb-select md-form" id="endyear" name="ip-endyear">
						                    <option value="" disabled selected>Tahun Sampai</option>
								            <option value="2018">2018</option>
								            <option value="2019">2019</option>
								            <option value="2020">2020</option>
								            <option value="2021">2021</option>
								            <option value="2022">2022</option>
								            <option value="2023">2023</option>
								            <option value="2024">2024</option>
								            <option value="2025">2025</option>
								        </select>
					            	</div>
					            </div>
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-menu">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Barang</h2></div>
				<div class="col-md-12">
					<table id="table-menu" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='stok') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<input type="hidden" name="ip-daterange" id="daterange" value="harian">
				<!--
				<div class="col-md-2">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="daterange" name="ip-daterange">
				            <option value="harian">Harian</option>
				            <option value="bulanan">Bulanan</option>
				        </select>
				    </div>
				</div>
			-->
				<div class="col-md-4">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-menu" name="ip-menu" searchable="Search here..">
		                    <option value="" disabled selected>Pilih Barang</option>
		                <?php
		                	$sql="SELECT * from barang where barang_set_stok=1";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[barang_id]'>$data1[barang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-stok">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Stok Masuk</h2></div>
				<div class="col-md-12">
					<table id="table-stok" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
	                            <th>user</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
	                            <th>user</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-stokmasuk hidden" href="">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='stokkeluar') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<input type="hidden" name="ip-daterange" id="daterange" value="harian">
				<div class="col-md-4">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-menu" name="ip-menu" searchable="Search here..">
		                    <option value="" disabled selected>Pilih Barang</option>
		                <?php
		                	$sql="SELECT * from barang where barang_set_stok=1";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[barang_id]'>$data1[barang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-stokkeluar">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Stok Keluar</h2></div>
				<div class="col-md-12">
					<table id="table-stokkeluar" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
	                            <th>user</th>
				            </tr>
				        </thead>
				        <tfoot>
				            <tr>
	                            <th>tanggal</th>
	                            <th>item</th>
	                            <th>jumlah</th>
	                            <th>user</th>
				            </tr>
				        </tfoot>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-stokkeluar hidden" href="">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='validasi') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<input type="hidden" name="ip-daterange" id="daterange" value="harian">
				<div class="col-md-10">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-validasi">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Tutup Kasir</h2></div>
				<div class="col-md-12">
					<table id="table-validasi" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>  
		                        <th>tanggal</th>
		                        <th>waktu</th>
		                        <th>nama</th>
		                        <th>uang fisik</th>
		                        <th>cash</th>
		                        <th>debet</th>
		                        <th>total omset</th>
				            </tr>
				        </thead>
				    </table>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='nota') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-10">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-nota">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12">
					<table id="table-nota" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>nota</th>
	                            <th>tanggal</th>
	                            <th>pelanggan</th>
	                            <th>kasir</th>
	                            <th>total</th>
	                            <th></th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-nota hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='pembelian') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-10">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-pembelian">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Pembelian</h2></div>
				<div class="col-md-12">
					<table id="table-pembelian" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>nota</th>
	                            <th>tanggal</th>
	                            <th>admin</th>
	                            <th>total</th>
	                            <th></th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-pembelian hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='member') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-4 <?php echo $kasir; ?>">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-member" name="ip-member" searchable="Search here..">
		                    <option value="" disabled selected>Pilih Member</option>
		                <?php
		                	$sql="SELECT * from member ORDER BY member_nama ASC";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[member_id]'>$data1[member_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-member">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12">
					<table id="table-member" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>nota</th>
	                            <th>tanggal</th>
	                            <th>pelanggan</th>
	                            <th>kasir</th>
	                            <th>total</th>
	                            <th></th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-member hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php
} elseif ($ket=='mutasi') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<input type="hidden" name="ip-daterange" id="daterange" value="harian">
				<div class="col-md-10">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-mutasi">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Mutasi</h2></div>
				<div class="col-md-12"><h4 class="text-center mb-4">Tanggal: <span id="mutasi-tanggal"></span></h4></div>
				<div class="col-md-12">
					<table id="table-mutasi" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>Barang Nama</th>
	                            <th>awal</th>
	                            <th>masuk</th>
	                            <th>keluar</th>
	                            <th>sisa</th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-mutasi hidden" href="">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='stokmenu') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<input type="hidden" name="ip-daterange" id="daterange" value="harian">
				<div class="col-md-4">
				    <div class="md-form">
				        <select class="mdb-select md-form" id="defaultForm-menu" name="ip-menu" searchable="Search here..">
		                    <option value="" disabled selected>Pilih Barang</option>
		                <?php
		                	$sql="SELECT * from barang where barang_set_stok=1";
		                  	$result=mysqli_query($con,$sql);
		                  	while ($data1=mysqli_fetch_array($result,MYSQLI_ASSOC)) {
		                      	echo "<option value='$data1[barang_id]'>$data1[barang_nama]</option>";
		                  	}
		                ?>
				        </select>
				    </div>
				</div>
				<div class="col-md-6">
					<div class="row form-date">
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="Start date" type="text" id="defaultForm-startdate" class="form-control datepicker">
				            </div>
						</div>
						<div class="col-md-6">
				            <div class="md-form">
							  	<input placeholder="End date" type="text" id="defaultForm-enddate" class="form-control datepicker">
				            </div>
				        </div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-stokmenu">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12"><h2 class="text-center mb-4">Stok</h2></div>
				<div class="col-md-12">
					<table id="table-stokmenu" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>tanggal</th>
	                            <th>awal</th>
	                            <th>masuk</th>
	                            <th>keluar</th>
	                            <th>sisa</th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-stokmenu hidden" href="">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php

} elseif ($ket=='gaji') {
	?>
	<div class="row justify-content-md-center">
		<div class="col-md-10">
			<div class="row">
				<div class="col-md-10">
					<div class="row form-date">
						<div class="col-md-6">
					        <select class="mdb-select md-form" id="month" name="ip-month">
			                    <option value="" disabled selected>Bulan</option>
					            <option value="01">01</option>
					            <option value="02">02</option>
					            <option value="03">03</option>
					            <option value="04">04</option>
					            <option value="05">05</option>
					            <option value="06">06</option>
					            <option value="07">07</option>
					            <option value="08">08</option>
					            <option value="09">09</option>
					            <option value="10">10</option>
					            <option value="11">11</option>
					            <option value="12">12</option>
					        </select>
		            	</div>
		            	<div class="col-md-6">
					        <select class="mdb-select md-form" id="year" name="ip-year">
			                    <option value="" disabled selected>Tahun</option>
					            <option value="2022">2022</option>
					            <option value="2023">2023</option>
					            <option value="2024">2024</option>
					            <option value="2025">2025</option>
					        </select>
		            	</div>
					</div>
				</div>
				<div class="col-md-2">
				    <div class="md-form">
				    	<button class="btn btn-primary btn-proses-laporan-gaji">Proses</button>
				    </div>
				</div>
			</div>	
			<div class="row fadeInLeft slow animated">
				<div class="col-md-12">
					<table id="table-gaji" class="table table-striped table-bordered" style="width:100%">
				        <thead>
				            <tr>
	                            <th>Posisi</th>
								<th>Nama Pegawai</th>
								<th>Gaji Pokok</th>
								<th>Komisi</th>
								<th>Total Gaji</th>
	                            <th></th>
				            </tr>
				        </thead>
				    </table>
				</div>
				<div class="col-md-12">
				    <div class="md-form">
				    	<a class="btn btn-default export-gaji hidden" href="" target="_blank">Export</a>
				    </div>
				</div>
			</div>
		</div>
	</div>

<?php
}




?>
<script type="text/javascript">

  $(document).ready(function(){
      	$('.mdb-select').materialSelect();
		
		$("#daterange").change(function(){
			if ($(this).val()=="harian") {

	            $("#defaultForm-startdate").val('');
	            $("#startmonth").val('');
	            $("#startyear").val('');
	            $("#endmonth").val('');
	            $("#endyear").val('');

	           
	            $(".form-month").addClass('hidden');
	            $(".form-date").removeClass('hidden');
			
			} else if ($(this).val()=="bulanan") {
	        
	            $("#defaultForm-startdate").val('');
	            $("#startmonth").val('');
	            $("#startyear").val('');
	            $("#endmonth").val('');
	            $("#endyear").val('');

	            $(".form-month").removeClass('hidden');
	            $(".form-date").addClass('hidden');
			
			}
		});
		$('.datepicker').datepicker({
			    format: 'yyyy-mm-dd'
			});
		/*
		$('.datepicker').pickadate({
			weekdaysShort: ['Su', 'Mo', 'Tu', 'We', 'Th', 'Fr', 'Sa'],
			showMonthsShort: true
		})
		*/
		function convertToRupiah(angka)
		{
		  var rupiah = '';    
		  var angkarev = angka.toString().split('').reverse().join('');
		  for(var i = 0; i < angkarev.length; i++) if(i%3 == 0) rupiah += angkarev.substr(i,3)+'.';
		  return 'Rp. '+rupiah.split('',rupiah.length-1).reverse().join('');
		}
		
		var dateformat = ["01","02","03","04","05","06","07","08","09","10",
		            "11","12","13","14","15","16","17","18","19","20",
		            "21","22","23","24","25","26","27","28","29","30","31"];

		
		$('.btn-proses-laporan-omset').on('click',function(){
			var daterange = $('#daterange').val();
			var typebayar = $('#defaultForm-typebayar').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-omset',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		typebayar:typebayar,
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-omset').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-omset').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'transaksi_bulan' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['cash'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['debet'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-omset').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'transaksi_tanggal' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['cash'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['debet'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} 


		        	$("a.export-omset").removeClass("hidden");
			        $("a.export-omset").attr("href","../include/export_omset.php?date="+date+"&ket="+daterange+"&typebayar="+typebayar);
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
			
		});

		

		$('.btn-proses-laporan-laba').on('click',function(){
			var daterange = $('#daterange').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-laba',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-laba').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-laba').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'transaksi_bulan' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['laba'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-laba').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'transaksi_tanggal' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['laba'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} 


		        	$("a.export-laba").removeClass("hidden");
			        $("a.export-laba").attr("href","../include/export_laba.php?date="+date+"&ket="+daterange);
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
			
		});

		$('.btn-proses-laporan-omsetkategori').on('click',function(){
			var daterange = $('#daterange').val();
			var kategori = $('#defaultForm-kategori').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-omsetkategori',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		kategori:kategori
            	},
		        success:function(data){
		        	$('#table-omsetkategori').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-omsetkategori').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'transaksi_bulan' },
						        { data: 'kategori' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                },
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-omsetkategori').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'transaksi_tanggal' },
						        { data: 'kategori' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                },
						    ]
						} );

		        	} 


		        	$("a.export-omsetkategori").removeClass("hidden");
			        $("a.export-omsetkategori").attr("href","../include/export_omsetkategori.php?kategori="+kategori+"&date="+date+"&ket="+daterange);
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
			
		});
	
		$('.btn-proses-laporan-kasir').on('click',function(){
			var daterange = $('#daterange').val();
			var typebayar = $('#defaultForm-typebayar').val();
			var kasir = $('#defaultForm-kasir').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-kasir',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		typebayar:typebayar,
            		start:start,
            		end:end,
            		kasir:kasir
            	},
		        success:function(data){
		        	console.log(kasir);
		        	$('#table-kasir').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-kasir').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'transaksi_bulan' },
						        { data: 'kasir' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['cash'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['debet'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-kasir').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
				            deferRender: true,
						    columns: [
						        { data: 'transaksi_tanggal' },
						        { data: 'kasir' },
				                { render: function(data, type, full){
				                   return formatRupiah(full['cash'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['debet'].toString(), 'Rp. ');
				                  }
				                },
				                { render: function(data, type, full){
				                   return formatRupiah(full['total'].toString(), 'Rp. ');
				                  }
				                }
						    ]
						} );

		        	} 

		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		});   

		$('.btn-proses-laporan-menu').on('click',function(){
			var daterange = $('#daterange').val();
			var menu = $('#defaultForm-menu').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-menu',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		menu:menu
            	},
		        success:function(data){
		        	console.log(menu);
		        	$('#table-menu').DataTable().clear().destroy();
		        	if (kettext=='transaksi_bulan') {
			        	$('#table-menu').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
						    columns: [
						        { data: 'transaksi_bulan' },
						        { data: 'barang_nama' },
						        { data: 'jumlah' }
						    ]
						} );

		        	} else if (kettext=='transaksi_tanggal') {
			        	$('#table-menu').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
						    data: data,
						    columns: [
						        { data: 'transaksi_tanggal' },
						        { data: 'barang_nama' },
						        { data: 'jumlah' }
						    ]
						} );

		        	} 

			        $("a.export-menu").removeClass("hidden");
			        $("a.export-menu").attr("href","../include/export_itemterjual.php?data="+menu+"&date="+date+"&ket="+daterange);
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		}); 

		$('.btn-proses-laporan-stok').on('click',function(){
			var daterange = $('#daterange').val();
			var menu = $('#defaultForm-menu').val();

			if (daterange=='harian') {

	          	var start = $('#defaultForm-startdate').val();
	          	var end = $('#defaultForm-enddate').val();
	          	var kettext = 'transaksi_tanggal';
				
			} else if (daterange=='bulanan') {

	          	var start = $("#startyear").val()+"-"+$("#startmonth").val();
	          	var end = $("#endyear").val()+"-"+$("#endmonth").val();
	          	var kettext = 'transaksi_bulan';
				
			}
			var date = start+":"+end;

			if (menu==null) {
				menu = 0;
			}


			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-stok',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		menu:menu
            	},
		        success:function(data){
		        	console.log(menu);
		        	$('#table-stok').DataTable().clear().destroy();
		        	
			        	$('#table-stok').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'tanggal' },
						        { data: 'barang_nama' },
				                { "render": function(data, type, full){
				                	var jml = full['stok_jumlah'] - full['stok_awal'];
				                   return jml;
				                  }
				                },
						        { data: 'name' }
						    ]
						} );

		        	
			        $("a.export-stokmasuk").removeClass("hidden");
			        $("a.export-stokmasuk").attr("href","../include/export.php?data="+menu+"&date="+date+"&waktu="+daterange+"&ket=masuk");
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		}); 

		$('.btn-proses-laporan-stokkeluar').on('click',function(){
			var daterange = $('#daterange').val();
			var menu = $('#defaultForm-menu').val();

          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
          	var kettext = 'transaksi_tanggal';
				
			
			var date = start+":"+end;

			if (menu==null) {
				menu = 0;
			}

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-stokkeluar',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end,
            		menu:menu
            	},
		        success:function(data){
		        	console.log(menu);
		        	$('#table-stokkeluar').DataTable().clear().destroy();
		        	
			        	$('#table-stokkeluar').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'transaksi_tanggal' },
						        { data: 'barang_nama' },
						        { data: 'jumlah' },
						        { data: 'name' }
						    ]
						} );

		        	

			        $("a.export-stokkeluar").removeClass("hidden");
			        $("a.export-stokkeluar").attr("href","../include/export.php?data="+menu+"&date="+date+"&waktu="+daterange+"&ket=keluar");
		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		}); 

		$('.btn-proses-laporan-validasi').on('click',function(){

          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();

			
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-validasi',
		        dataType: "json",
            	data:{
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	console.log(menu);
		        	$('#table-validasi').DataTable().clear().destroy();
		        	
			        	$('#table-validasi').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
		                          { data: 'validasi_tanggal' },
		                          { data: 'validasi_waktu' },
		                          { data: 'validasi_user_nama' },
		                          { "render": function(data, type, full){
		                             return formatRupiah(full['validasi_jumlah'].toString(), 'Rp. ');
		                            }
		                          },
		                          { "render": function(data, type, full){
		                             return formatRupiah(full['validasi_cash'].toString(), 'Rp. ');
		                            }
		                          },
		                          { "render": function(data, type, full){
		                             return formatRupiah(full['validasi_debet'].toString(), 'Rp. ');
		                            }
		                          },
		                          { "render": function(data, type, full){
		                             return formatRupiah(full['validasi_omset'].toString(), 'Rp. ');
		                            }
		                          }
						    ]
						} );

		        	

		        	console.log("success "+kettext);
		        	console.log(data);
		        }
		    });
		});

		$('.btn-proses-laporan-nota').on('click',function(){
			
          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
          	var kettext = 'transaksi_tanggal';

			var date = start+":"+end;
			console.log("nota")
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-nota',
		        dataType: "json",
            	data:{
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-nota').DataTable().clear().destroy();
		        	
		        	$('#table-nota').DataTable( {
					    paging: true,
					    searching: true,
					    ordering: true,
					    data: data,
			            deferRender: true,
					    columns: [
					        { data: 'transaksi_id' },
					        { data: 'transaksi_tanggal' },
					        { data: 'member_nama' },
					        { data: 'name' },
					        { render: function(data, type, full){
			                   return formatRupiah(full['transaksi_total'].toString(), 'Rp. ');
			                  }
			                },
			                { render: function(data, type, full){
			                   return '<a class="btn-floating btn-sm btn-primary mr-2 btn-detailnota" data-toggle="modal" data-target="#modaldetail" data-id="' + full['transaksi_id'] + '" title="Detail"><i class="far fa-file-alt"></i></a>';
			                  }
			                }
					    ],
			            drawCallback: function( settings ) {
		
							$('.btn-detailnota').on('click',function(){
								var notaid = $(this).data('id');
					          	$.ajax({
							        type:'POST',
							        url:'api/view.api.php?func=cek-nota',
							        dataType: "json",
					            	data:{
					            		notaid:notaid
					            	},
							        success:function(data){
							        	for (var i in data) {

							        		if (i==0) {
					                        	$('#modaldetail p.nama').text('Pelanggan: '+data[i].pelanggan);
					                        	$('#modaldetail p.nonota').text('No Nota: '+data[i].notaid);
					                        	$('#modaldetail p.kasir').text('Kasir: '+data[i].user);
					                        	$('#modaldetail p.therapist').text('Therapist: '+data[i].therapist);
					                        	$('#modaldetail p.potongan').text(formatRupiah(data[i].potongan.toString(), 'Rp. '));
					                        	$('#modaldetail p.total').text(formatRupiah(data[i].total.toString(), 'Rp. '));
					                        	$('#modaldetail p.subtotal').text(formatRupiah(data[i].subtotal.toString(), 'Rp. '));
							        		} else {
							        			$('#listbarang tbody').append("<tr><td>"+data[i].barang_nama+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_harga.toString(), 'Rp. ')+"</td><td class='text-right'>"+data[i].transaksi_detail_jumlah+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_total.toString(), 'Rp. ')+"</td></tr>");
							        		}
							            }

							        }
							    });
							}); 

			            }
					});

		        	$("a.export-nota").removeClass("hidden");
			        $("a.export-nota").attr("href","../include/export_nota.php?date="+date);
		        }
		    });
			
		}); 

		$('.btn-proses-laporan-gaji').on('click',function(){
			
          	var bulan = $('#month').val();
          	var tahun = $('#year').val();

			console.log("nota")
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-gaji',
		        dataType: "json",
            	data:{
            		bulan:bulan,
            		tahun:tahun
            	},
		        success:function(data){
		        	$('#table-gaji').DataTable().clear().destroy();
		        	
		        	$('#table-gaji').DataTable( {
					    paging: false,
					    searching: true,
					    ordering: true,
					    data: data,
			            deferRender: true,
					    columns: [
					        { data: 'role' },
					        { data: 'name' },
					        { render: function(data, type, full){
			                   return formatRupiah(full['gaji'].toString(), 'Rp. ');
			                  }
			                },
					        { render: function(data, type, full){
			                   return formatRupiah(full['komisi'].toString(), 'Rp. ');
			                  }
			                },
					        { render: function(data, type, full){
			                   return formatRupiah(full['total'].toString(), 'Rp. ');
			                  }
			                },
			                { render: function(data, type, full){
			                   return '<a class="btn-floating btn-sm btn-primary mr-2 btn-detailnota" data-toggle="modal" data-target="#komisipegawai" data-id="' + full['id'] + '" data-bulan="' + bulan + '" data-tahun="' + tahun + '" data-role="' + full['role'] + '" title="Detail"><i class="far fa-file-alt"></i></a>';
			                  }
			                }
					    ],
			            drawCallback: function( settings ) {
		
							$('.btn-detailnota').on('click',function(){
								var id = $(this).data('id');
								var bulan = $(this).data('bulan');
								var tahun = $(this).data('tahun');
								var role = $(this).data('role');
					          	$.ajax({
							        type:'POST',
							        url:'api/view.api.php?func=detailkomisi',
							        dataType: "json",
					            	data:{
					            		id:id,
					            		bulan:bulan,
					            		tahun:tahun,
					            		role:role
					            	},
							        success:function(data){
							        	$('#komisipegawai tbody').empty();
							        	for (var i in data) {

							        		if (i==0) {
					                        	$('#komisipegawai p.nama').text('Nama: '+data[i].nama);
					                        	$('#komisipegawai p.role').text('Jabatan: '+data[i].role);
					                        	$('#komisipegawai p.gaji').text('Gaji Pokok: '+data[i].gajipokok);
							        		} else {
							        			$('#komisipegawai tbody').append("<tr><td>"+data[i].transaksi_tanggal+"</td><td>"+data[i].barang_nama+"</td><td class='text-right'>"+data[i].komisi+"</td></tr>");
							        		}
							            }

							        }
							    });
							}); 

			            }
					});
		        }
		    });
			
		});

		$('.btn-proses-laporan-pembelian').on('click',function(){
			
          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
          	var kettext = 'transaksi_tanggal';

			var date = start+":"+end;
			console.log("pembelian")
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-pembelian',
		        dataType: "json",
            	data:{
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-pembelian').DataTable().clear().destroy();
		        	
		        	$('#table-pembelian').DataTable( {
					    paging: true,
					    searching: true,
					    ordering: true,
					    data: data,
			            deferRender: true,
					    columns: [
					        { data: 'pembelian_id' },
					        { data: 'pembelian_tanggal' },
					        { data: 'name' },
					        { render: function(data, type, full){
			                   return formatRupiah(full['pembelian_total'].toString(), 'Rp. ');
			                  }
			                },
			                { render: function(data, type, full){
			                   return '<a class="btn-floating btn-sm btn-primary mr-2 btn-detailpembelian" data-toggle="modal" data-target="#modaldetailpembelian" data-id="' + full['pembelian_id'] + '" title="Detail"><i class="far fa-file-alt"></i></a>';
			                  }
			                }
					    ],
			            drawCallback: function( settings ) {
		
							$('.btn-detailpembelian').on('click',function(){
								var notaid = $(this).data('id');
					          	$.ajax({
							        type:'POST',
							        url:'api/view.api.php?func=cek-pembelian',
							        dataType: "json",
					            	data:{
					            		notaid:notaid
					            	},
							        success:function(data){
							        	for (var i in data) {

							        		if (i==0) {
					                        	$('#modaldetailpembelian p.nonota').text('No Nota: '+data[i].notaid);
					                        	$('#modaldetailpembelian p.admin').text('Admin: '+data[i].user);
					                        	$('#modaldetailpembelian p.total').text(formatRupiah(data[i].total.toString(), 'Rp. '));
							        		} else {
							        			$('#listbarangpembelian tbody').append("<tr><td>"+data[i].barang_nama+"</td><td class='text-right'>"+formatRupiah(data[i].pembelian_detail_harga_beli.toString(), 'Rp. ')+"</td><td class='text-right'>"+data[i].pembelian_detail_jumlah+"</td><td class='text-right'>"+formatRupiah(data[i].pembelian_detail_total.toString(), 'Rp. ')+"</td></tr>");
							        		}
							            }

							        }
							    });
							}); 

			            }
					});

		        	$("a.export-pembelian").removeClass("hidden");
			        $("a.export-pembelian").attr("href","../include/export_pembelian.php?date="+date);
		        }
		    });
			
		});   

		$('.btn-proses-laporan-member').on('click',function(){
			
          	var member = $('#defaultForm-member').val();
          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
          	var kettext = 'transaksi_tanggal';

			var date = start+":"+end;
			console.log("nota")
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-member',
		        dataType: "json",
            	data:{
            		member:member,
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-member').DataTable().clear().destroy();
		        	
		        	$('#table-member').DataTable( {
					    paging: true,
					    searching: true,
					    ordering: true,
					    data: data,
			            deferRender: true,
					    columns: [
					        { data: 'transaksi_id' },
					        { data: 'transaksi_tanggal' },
					        { data: 'member_nama' },
					        { data: 'name' },
					        { render: function(data, type, full){
			                   return formatRupiah(full['transaksi_total'].toString(), 'Rp. ');
			                  }
			                },
			                { render: function(data, type, full){
			                   return '<a class="btn-floating btn-sm btn-primary mr-2 btn-detailmember" data-toggle="modal" data-target="#modaldetail" data-id="' + full['transaksi_id'] + '" title="Detail"><i class="far fa-file-alt"></i></a>';
			                  }
			                }
					    ],
			            drawCallback: function( settings ) {
		
							$('.btn-detailmember').on('click',function(){
								var notaid = $(this).data('id');
					          	$.ajax({
							        type:'POST',
							        url:'api/view.api.php?func=cek-nota',
							        dataType: "json",
					            	data:{
					            		notaid:notaid
					            	},
							        success:function(data){
							        	for (var i in data) {

							        		if (i==0) {
					                        	$('#modaldetail p.nama').text('Pelanggan: '+data[i].pelanggan);
					                        	$('#modaldetail p.nonota').text('No Nota: '+data[i].notaid);
					                        	$('#modaldetail p.kasir').text('Kasir: '+data[i].user);
					                        	$('#modaldetail p.therapist').text('Therapist: '+data[i].therapist);
					                        	$('#modaldetail p.potongan').text(formatRupiah(data[i].potongan.toString(), 'Rp. '));
					                        	$('#modaldetail p.total').text(formatRupiah(data[i].total.toString(), 'Rp. '));
					                        	$('#modaldetail p.subtotal').text(formatRupiah(data[i].subtotal.toString(), 'Rp. '));
							        		} else {
							        			$('#listbarang tbody').append("<tr><td>"+data[i].barang_nama+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_harga.toString(), 'Rp. ')+"</td><td class='text-right'>"+data[i].transaksi_detail_jumlah+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_total.toString(), 'Rp. ')+"</td></tr>");
							        		}
							            }

							        }
							    });
							}); 

			            }
					});

		        	$("a.export-member").removeClass("hidden");
			        $("a.export-member").attr("href","../include/export_member.php?member="+member+"&date="+date);
		        }
		    });
			
		});  

		$('.btn-proses-laporan-mutasi').on('click',function(){
			var daterange = $('#daterange').val();
          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
          	var kettext = 'transaksi_tanggal';
				
			var date = start+":"+end;
			
        	$("#mutasi-tanggal").text(date);
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-mutasi',
		        dataType: "json",
            	data:{
            		daterange:daterange,
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	$('#table-mutasi').DataTable().clear().destroy();
		        	
			        	$('#table-mutasi').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'barang_nama' },
						        { data: 'stok_awal' },
						        { data: 'stok_masuk' },
						        { data: 'stok_keluar' },
						        { data: 'stok_sisa' }
						    ]
						} );

		        	
			        $("a.export-mutasi").removeClass("hidden");
			        $("a.export-mutasi").attr("href","../include/export_mutasi.php?date="+date);
		        }
		    });
		});

		$('.btn-proses-laporan-stokmenu').on('click',function(){
			var menu = $('#defaultForm-menu').val();

          	var start = $('#defaultForm-startdate').val();
          	var end = $('#defaultForm-enddate').val();
				
			var date = start+":"+end;
			$.ajax({
		        type:'POST',
		        url:'api/view.api.php?func=laporan-stokmenu',
		        dataType: "json",
            	data:{
            		menu:menu,
            		start:start,
            		end:end
            	},
		        success:function(data){
		        	console.log(data);
		        	$('#table-stokmenu').DataTable().clear().destroy();
		        	
			        	$('#table-stokmenu').DataTable( {
						    paging: false,
						    searching: false,
						    ordering: false,
				            deferRender: true,
						    data: data,
						    columns: [
						        { data: 'tanggal' },
						        { data: 'stok_awal' },
						        { data: 'stok_masuk' },
						        { data: 'stok_keluar' },
						        { data: 'stok_sisa' }
						    ]
						} );

		        	
			        $("a.export-stokmenu").removeClass("hidden");
			        $("a.export-stokmenu").attr("href","../include/export_stokmenu.php?menu="+menu+"&date="+date);
		        }
		    });
		});      
	});


</script>