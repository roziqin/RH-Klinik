<?php
include 'config/database.php';
session_start();

if(isset($_SESSION['login'])){
    header('location: admin?menu=');
}
else{

?>
<!DOCTYPE html>
<html>
<head>
	<?php include 'views/partials/head.php'; ?>
</head>
<body>
	<div class="view jarallax custom animated fadeIn" style="background-image: url('assets/img/gradient3.png'); background-repeat: no-repeat; background-size: cover; background-position: center center;">
        <div class="mask rgba-gradient d-flex justify-content-center align-items-center">
			<div class="container portal">
                <div class="row">

                  <!-- Grid column -->
                  <div class="col-lg-4 col-md-12 mb-4 text-center">

                    <!-- Card -->
                    <div class="card hoverable">
                      <div class="card-body">

                        <h5>Klinik</h5>
                        <div class="d-flex justify-content-center mt-3 mb-4">
                          <div class="card-circle d-flex justify-content-center align-items-center">
                            <i class="fas fa-cash-register"></i>
                          </div>
                        </div>

                        <a class="btn btn-light-blue btn-rounded waves-effect waves-light pilih" data-ket="klinik">Pilih</a>

                      </div>
                    </div>
                    <!-- Card -->

                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-lg-4 col-md-12 mb-4 text-center">

                    <!-- Card -->
                    <div class="card purple-gradient hoverable text-white">
                      <div class="card-body">

                        <h5>Apotek</h5>
                        <div class="d-flex justify-content-center mt-3 mb-4">
                          <div class="card-circle d-flex justify-content-center align-items-center">
                            <i class="fas fa-prescription-bottle-alt white-text"></i>
                          </div>
                        </div>

                        <a class="btn btn-outline-white btn-rounded waves-effect waves-light pilih" data-ket="apotek">Pilih</a>

                      </div>
                    </div>
                    <!-- Card -->

                  </div>
                  <!-- Grid column -->

                  <!-- Grid column -->
                  <div class="col-lg-4 col-md-12 mb-4 text-center">

                    <!-- Card -->
                    <div class="card hoverable">
                      <div class="card-body">

                        <h5>Pendaftaran</h5>
                        <div class="d-flex justify-content-center mt-3 mb-4">
                          <div class="card-circle d-flex justify-content-center align-items-center">
                            <i class="fas fa-user-plus"></i>
                          </div>
                        </div>

                        <a class="btn btn-light-blue btn-rounded waves-effect waves-light pilih" data-ket="pendaftaran">Pilih</a>

                      </div>
                    </div>
                    <!-- Card -->

                  </div>
                  <!-- Grid column -->

                </div>
            </div>
            <div class="container-fluid full-page-container form-login hidden">
				<div class="row h-100 justify-content-center align-items-center">
					<div class="col-lg-4 col-sm-8 animated fadeIn">
                        <section class="form-elegant slow bounceInDown animated">
                            <div class="card" style="">
                              <div class="card-body mx-4">

                                    <div class="row delay-2s fadeIn animated">
                                        <div class="col-12">
                                            <div class="align-items-center">
                                                <div class="text-center"><img src="assets/img/logo-baru1.jpeg" width="150px" class="m-lr-auto"></div>
                                            </div>
                                        </div>
                                    </div>
                                        
                                        <h3 class=" delay-2s fadeIn animated display-4 text-center mt-2 mb-3 text-capitalize title"></h3>
                                        <input type="hidden" id="type" name="type">
                                        <div class="md-form delay-2s fadeIn animated mb-5">
                                            <input type="text" id="username" name="username" class="form-control ">
                                            <label for="username" class="" >USERNAME</label>
                                        </div>
                                        <div class="md-form delay-2s fadeIn animated mb-4">
                                            <input type="password" id="password" name="password" class="form-control ">
                                            <label for="password" class="" >PASSWORD</label>
                                        </div>

                                        <div class="text-center mb-3 delay-2s fadeIn animated">
                                            <button class="btn blue-gradient btn-block btn-rounded z-depth-1a waves-effect waves-light" type="submit" onclick="check_login();">Login</button>
                                        </div>
                              

                                </div>
                            </div>
                        </section>  
					</div>
				</div>
			</div>
        </div>
    </div>
	<?php include 'views/partials/footer.php'; ?>
    <script type="text/javascript">
        $('.pilih').on('click',function(e){
            e.preventDefault();
            console.log("tes "+$(this).data('ket'))
            $("#type").val($(this).data('ket'));
            $("h3.title").text($(this).data('ket'));
            $(".portal").addClass("hidden");
            $(".form-login").removeClass("hidden");
        });

        function check_login()
        {
            //Mengambil value dari input username & Password
            var username = $('#username').val();
            var password = $('#password').val();
            var type = $('#type').val();
            //Ubah alamat url berikut, sesuaikan dengan alamat script pada komputer anda
            var url_login    = 'controllers/login.ctrl.php';
            var url_admin    = 'admin/?menu=';
            var url_kasir    = 'admin/?menu=transaksi';
            var url_kasirapotek    = 'admin/?menu=apotek';
            var url_member    = 'admin/?menu=member';
            
            //Ubah tulisan pada button saat click login
            
            
            //Gunakan jquery AJAX
            $.ajax({
                url     : url_login,
                //mengirimkan username dan password ke script login.php
                data    : 'var_usn='+username+'&var_pwd='+password+'&var_type='+type, 
                //Method pengiriman
                type    : 'POST',
                //Data yang akan diambil dari script pemroses
                dataType: 'html',
                //Respon jika data berhasil dikirim
                success : function(pesan){

                    if (pesan=='klinik') {
                        window.location = url_admin;
                    } else if (pesan=='apotek') {
                        window.location = url_kasirapotek;
                    } else if (pesan=='pendaftaran') {
                        window.location = url_member;
                    }
                    else if (pesan=='salah') {
                        alert("Username atau Password Salah !");
                    } else {
                        window.location = url_kasir;

                    }
                },
            });
        }
    </script>
</body>
</html>

<?php
}
?>