<?php 
	date_default_timezone_set('Asia/jakarta');
	$tgl=date('m-j');
	$q= "SELECT count(*) as jumlah FROM member where member_tgl_lahir LIKE '%$tgl%'";
	$r=mysqli_query($con, $q);
	$d=mysqli_fetch_assoc($r);

?>

<ul class="nav navbar-nav nav-flex-icons ml-auto" style="">
      <!-- Dropdown -->
    <li class="nav-item dropdown notifications-nav">
        <a class="nav-link dropdown-toggle waves-effect" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          	<span class="badge red"><?php echo $d['jumlah']; ?></span> <i class="fas fa-bell"></i>
          	<span class="d-none d-md-inline-block">Notif Member</span>
        </a>
        <div class="dropdown-menu dropdown-primary" aria-labelledby="navbarDropdownMenuLink">
        	<a class="dropdown-item waves-effect waves-light" href="#">
	        	<div class="row">
	      			<div class="col-md-6">
	      				<b>Nama Member</b>
	      			</div>
	      			<div class="col-md-6 text-right">
	      				<b>Telp Member</b>
	      			</div>
	      		</div>
	      	</a>
        	<?php 
        	$query= "SELECT member_nama, member_hp FROM member where member_tgl_lahir LIKE '%$tgl%'";
			$result=mysqli_query($con, $query);
			while ($data=mysqli_fetch_assoc($result)){
			?>
	          	<a class="dropdown-item waves-effect waves-light" href="#">
	          		<div class="row">
	          			<div class="col-md-6">
	          				<?php echo $data['member_nama']; ?>
	          			</div>
	          			<div class="col-md-6 text-right">
	          				<?php echo $data['member_hp']; ?>
	          			</div>
	          		</div>
	          	</a>
			<?php
			}
        	?>
        	<a class="dropdown-item waves-effect waves-light text-center" href="?menu=member">Lihat Semua</a>
        </div>
    </li>

</ul>