
	<div class="container-fluid p-0 fadeIn animated position-relative">
		<div class="row header-content pt-3 pb-0 info-color text-white ">
			<div class="col-md-9">
				<h2>Member</h2>
			</div>
			<div class="col-md-12 pl-0 pr-0 border-top border-white mb-0 pt-2 ">
				<ul class="nav">
				    <li class="nav-item">
				      <a class="nav-link waves-light active show" id="member">Member</a>
				    </li>
				    <li class="nav-item">
				      <a class="nav-link waves-light" id="jadwal">Jadwal Kontrol</a>
				    </li>
				</ul>
			</div>
		</div>
	</div>
	
	<main class="pt-4 produk pl-3 pr-3 mr-0">
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
				if(menu == "jadwal"){
					$('.container__load').load('components/content/member.content.php?ket=jadwal');						
				}else if(menu == "member"){
					$('.container__load').load('components/content/member.content.php?ket=member');						
				}
			});
	 
	 
			$('.container__load').load('components/content/member.content.php?ket=member');					
	 
		});
	</script>


