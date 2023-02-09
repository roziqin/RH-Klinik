<?php

$ket = $_GET['ket'];

?>
    <input type="hidden" id="defaultForm-role" name="ip-role" value="<?php echo $_SESSION['role']; ?>">
    <input type="hidden" id="defaultForm-user" name="ip-user" value="<?php echo $_SESSION['name']; ?>">
	<main class="transaksi p-0 mr-0">
		<div class="main-wrapper">
		    <div class="container-fluid">
				<div class="row">
					<div class="col-md-8 pl-0 pr-0 container__load">

					</div>

					<div class="col-md-4 position-relative box-right">
						
							<div class="row">
								<div class="col-md-12 position-fixed info-color text-white col-right"></div>
								<div class="col-md-12">
									<h3 class="text-white pt-3 float-left">List Pendaftaran</h3>
									<span class="text-white pt-4 float-right" id="datetime"></span>
									<div class="clear"></div>

								</div>
								<div class="col-md-12 text-white mt-0 fadeIn animated info-color-dark pt-3 pb-1" id="listpasien">
									<table style="width: 100%;">
										<thead>
											<tr>
												<th>No Urut</th>
												<th>Nama</th>
												<th>Alamat</th>
											</tr>
										</thead>
										<tbody></tbody>
									</table>
								</div>
							</div>
					</div>
				</div>
		    </div>
		</div>
	</main>

	<?php include 'partials/footer.php'; ?>

	<?php include 'modals/transaksi.modal.php'; ?>
	<?php include 'modals/discount.modal.php'; ?>

<?php if ($ket=='pendaftaran' || $ket=='') { ?>

<script type="text/javascript">
	$(document).ready(function(){
		setInterval(function(){
			$.ajax({
	            type:'POST',
	            url:'api/view.api.php?func=list-pendaftaran',
	            dataType: "json",
	            success:function(data){
	                $('#listpasien table tbody').empty();
	                var nama = ''; 
	                if (data!='') {
	               		
						for (var i in data) {
	                    	$('#listpasien table tbody').append('<tr><td>'+data[i].pendaftaran_no_urut+'</td><td>'+data[i].member_nama+'</td><td>'+data[i].member_alamat+'</td></tr>');
		                }
	                }
	            }
	        });
		}, 2000);

	});
</script>

<? } else { ?>

<?php } ?>
<script type="text/javascript">
	$(document).ready(function(){

	    $('.ordertype').on('click',function(){
			var id = $(this).data('id');

            $.ajax({
				type:'POST',
		        url: "controllers/transaksi.ctrl.php?ket=ordertype",
                dataType: "json",
                data:{id:id},
                success:function(data){
                	$('#defaultForm-ordertype').val(data[0]);

					$('#bayar').removeAttr("disabled");
					$('.ordertype').removeAttr("disabled");
					$('#'+data[0]).attr("disabled","true");
					$('.container__load').load('components/content/transaksi.content.php?kond=home');
                	/*
                	if (data[0]=="dinein") {}
                		ordertype
                	*/

                }
            });
	    });

		
		setInterval(function(){ 
			$('#datetime').empty(); 
			$('#datetime').append(moment(new Date()).format('ddd MMM DD YYYY | HH:mm:ss '));
		
		}, 1000);

		$('.container__load').load('components/content/transaksi.content.php?kond=home');

		$('#carimenu').bind("enterKey",function(e){
			var search = $(this).val();
			$('.container__load').load('components/content/transaksi.content.php?kond=search&q='+search);
			//alert(search);
			/*
			$.ajax({
                type: 'POST',
                url: "components/content/transaksi.content.php?kond=search",
                dataType: "json",
                data:{search:search},
                success: function(data) {
                	console.log(data)
                  //$('.container__load').load(data);
                }
            });
            */
		});
		

		$('#carimenu').keyup(function(e){
			if(e.keyCode == 13) {
				$(this).trigger("enterKey");
			}
		});


		$('#batal').on('click',function(){
			$.ajax({
                type: 'POST',
		        url: "controllers/transaksi.ctrl.php?ket=batal",
                dataType: "json",
                success: function() {
                  	console.log("delete sukses")
					$('.container__load').load('components/content/transaksi.content.php?kond=home');
		        	$('#listitem table').empty();
		        	$('#subtotal').empty();
		        	$('#subtotal').append('Rp. 0');
					$('#bayar').attr("disabled","true");
					$('#listmember table').empty();
                }
            });
		});


		$('#bayar').on('click',function(){
		    $("#totaltransaksi").empty();
		    $("#totaltransaksi").append($("#total").text());
        	$('#defaultForm-totalmodal').val($("#defaultForm-total").val());


		    $('.btn.paytype').on('click',function(){
				var id = $(this).data('id');
            	$('#defaultForm-paytype').val(id);

				$('.paytype').removeAttr("disabled");
				$('#'+id).attr("disabled","true");

				$('.btn.paytype').removeClass("select");
				$(this).addClass("select");

				if (id=='cash') {
					$('#price').removeAttr("disabled");
					$('#price').val('');
                  	$("#modaltransaksi label").removeClass("active");
				} else {
                  	$("#modaltransaksi label").addClass("active");
					$('#price').val(formatCurrency($('#defaultForm-totalmodal').val().toString(), ''));
					$('#price').attr("disabled","true");
				}

		    });
			
		});

	});
</script>