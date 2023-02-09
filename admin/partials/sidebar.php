<header>
	<a href="#" data-activates="slide-out" class="btn btn-primary p-3 button-collapse"><i
    class="fas fa-bars"></i></a>

    <!-- Sidebar navigation -->
	<div id="slide-out" class="side-nav fixed wide slim">
		<ul class="custom-scrollbar smooth-scroll">

		    <!-- Logo -->
		    <li>
		    	<div class="logo-wrapper sn-ad-avatar-wrapper">
		        	<a href="#" class="grey-text"><img src="../assets/img/avatar-1.png"
		            class="rounded-circle"><span><?php echo $_SESSION['role']." ".$_SESSION['name']; ?></span></a>
		      	</div>
		    </li>
		    <!--/. Logo -->
		    <!-- Side navigation links -->
		    <li>
		      	<ul class="collapsible collapsible-accordion">
		      		<?php if ($_SESSION['role']=="administrator") { ?>
		      			
			        <li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=home" data-toggle="tooltip" title="Dashboard"><i class="sv-slim-icon fas fa-home"></i>Dashboard</a>
					</li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=transaksi&ket=" data-toggle="tooltip" title="Transaksi"><i class="sv-slim-icon fas fa-shopping-basket"></i>Transaksi</a>
					</li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=apotek&ket=" data-toggle="tooltip" title="Apotek"><i class="sv-slim-icon fas fa-shopping-basket"></i>Apotek</a>
					</li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=produk" data-toggle="tooltip" title="Produk"><i class="sv-slim-icon fas fa-box-open"></i>Produk</a>
			        </li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=stok" data-toggle="tooltip" title="Stok"><i class="sv-slim-icon fas fa-clipboard-list"></i>Stok</a>
			        </li>
			        <li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=laporan" data-toggle="tooltip" title="Laporan"><i class="sv-slim-icon fas fa-chart-bar"></i>Laporan</a>
			        </li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=setting" data-toggle="tooltip" title="Setting"><i class="sv-slim-icon fas fa-tools"></i>Setting</a>
			        </li>
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=member" data-toggle="tooltip" title="Member"><i class="sv-slim-icon fas fa-address-book"></i>Member</a>
			        </li>	
					<li class="menu-item">
				        <a class="waves-effect grey-text" href="?menu=user" data-toggle="tooltip" title="User"><i class="sv-slim-icon fas fa-user-cog"></i>User</a>
			        </li>
					<?php } elseif ($_SESSION['role']=="admin") { ?>
						<?php if ($_SESSION['type']=="klinik") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=transaksi&ket=" data-toggle="tooltip" title="Transaksi"><i class="sv-slim-icon fas fa-shopping-basket"></i>Transaksi</a>
						</li>
						<?php } elseif ($_SESSION['type']=="apotek") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=apotek&ket=" data-toggle="tooltip" title="Apotek"><i class="sv-slim-icon fas fa-shopping-basket"></i>Apotek</a>
						</li>
						<?php } ?>
						<?php if ($_SESSION['type']!="pendaftaran") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=produk" data-toggle="tooltip" title="Produk"><i class="sv-slim-icon fas fa-box-open"></i>Produk</a>
				        </li>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=stok" data-toggle="tooltip" title="Stok"><i class="sv-slim-icon fas fa-clipboard-list"></i>Stok</a>
				        </li>
				        <li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=laporan" data-toggle="tooltip" title="Laporan"><i class="sv-slim-icon fas fa-chart-bar"></i>Laporan</a>
				        </li>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=member" data-toggle="tooltip" title="Member"><i class="sv-slim-icon fas fa-address-book"></i>Member</a>
				        </li>	
						
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=setting" data-toggle="tooltip" title="Setting"><i class="sv-slim-icon fas fa-tools"></i>Setting</a>
				        </li>
						<?php } else { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=member" data-toggle="tooltip" title="Member"><i class="sv-slim-icon fas fa-address-book"></i>Member</a>
				        </li>	
						<?php } ?>
					<?php } elseif ($_SESSION['role']=="kasir") { ?>
						<?php if ($_SESSION['type']=="klinik") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=transaksi&ket=" data-toggle="tooltip" title="Transaksi"><i class="sv-slim-icon fas fa-shopping-basket"></i>Transaksi</a>
						</li>
						<?php } elseif ($_SESSION['type']=="apotek") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=stok" data-toggle="tooltip" title="Stok"><i class="sv-slim-icon fas fa-clipboard-list"></i>Stok</a>
				        </li>
						<?php } ?>
				        <li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=laporan" data-toggle="tooltip" title="Laporan"><i class="sv-slim-icon fas fa-chart-bar"></i>Laporan</a>
				        </li>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=member" data-toggle="tooltip" title="Member"><i class="sv-slim-icon fas fa-address-book"></i>Member</a>
				        </li>


					<?php } else { ?>  
						<?php if ($_SESSION['type']=="klinik") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=transaksi&ket=" data-toggle="tooltip" title="Transaksi"><i class="sv-slim-icon fas fa-shopping-basket"></i>Transaksi</a>
						</li>
						<?php } elseif ($_SESSION['type']=="apotek") { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=apotek&ket=" data-toggle="tooltip" title="Apotek"><i class="sv-slim-icon fas fa-shopping-basket"></i>Apotek</a>
						</li>
						<?php } else { ?>
						<li class="menu-item">
					        <a class="waves-effect grey-text" href="?menu=member" data-toggle="tooltip" title="Member"><i class="sv-slim-icon fas fa-address-book"></i>Member</a>
				        </li>	
						<?php } ?>
					<?php } ?>        
			        <li class="menu-item">
			        	<a class="waves-effect grey-text" href="?logout=1" data-toggle="tooltip" title="Logout"><i class="sv-slim-icon fas fa-sign-out-alt"></i>Logout</a>
			        </li>  
			    </ul>
			</li>
		</ul>
		<div class="sidenav-bg rgba-blue-strong"></div>
	</div>
</header>