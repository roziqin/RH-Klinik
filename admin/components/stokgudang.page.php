

	<div class="container-fluid p-0 fadeIn animated" style="z-index: 1;">

		<div class="row header-content pt-3 pb-0 info-color text-white">

			<div class="col-md-9">

				<h2>Stok Gudang</h2>

			</div>

			<div class="col-md-3">

				<?php include 'partials/notifications.php'; ?>

			</div>
			<div class="col-md-12 pl-0 pr-0 border-top border-white mb-0 pt-2 ">

				<ul class="nav">

				    <li class="nav-item">

				      <a class="nav-link waves-light active show" id="stok">Stok</a>

				    </li>

					<?php if ($_SESSION['role']=="owner") { ?>

				    <li class="nav-item">

				      <a class="nav-link waves-light active show" id="cekstok">Approve Stok</a>

				    </li>
					<?php } ?>
				</ul>
			</div>

		</div>

	</div>

	<main class="pt-4 stok pl-3 pr-3 mr-0">

		<div class="main-wrapper">

		    <div class="container-fluid">

				<div class="row mt-2">

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

				if(menu == "stok"){

					$('.container__load').load('components/content/stokgudang.content.php?ket=');					

				}else if(menu == "cekstok"){

					$('.container__load').load('components/content/stokgudang.content.php?ket=cekstok');					

				}

			});

			$('.container__load').load('components/content/stokgudang.content.php?ket=');					

		});

	</script>