    <input type="hidden" id="defaultForm-role" name="ip-role" value="<?php echo $_SESSION['role']; ?>">
    <input type="hidden" id="defaultForm-user" name="ip-user" value="<?php echo $_SESSION['name']; ?>">
	<main class="transaksi p-0 mr-0">
		<div class="main-wrapper">
		    <div class="container-fluid">
				<div class="row justify-content-md-center">
					<div class="col-md-6 pl-2 pr-2 pt-5 container__load">

					</div>
				</div>
		    </div>
		</div>
	</main>

	<?php include 'partials/footer.php'; ?>

	<?php include 'modals/transaksi.modal.php'; ?>
	<?php include 'modals/discount.modal.php'; ?>

<script type="text/javascript">
	$(document).ready(function(){
			$.ajax({
            type:'POST',
            url:'api/view.api.php?func=list-member-temp',
            dataType: "json",
            success:function(data){
                $('#listmember table').empty();
                if (data!='') {
					$('#bayar').removeAttr("disabled");
                } else {
					$('#bayar').attr("disabled","true");

                }
            }
        });
		
		setInterval(function(){ 
			$('#datetime').empty(); 
			$('#datetime').append(moment(new Date()).format('ddd MMM DD YYYY | HH:mm:ss '));
		
		}, 1000);

		$('.container__load').load('components/content/pembayaran.content.php?kond=home');



		$('#bayar').on('click',function(){
		    $("#totaltransaksi").empty();
		    $("#totaltransaksi").append($("#total").text());
        	$('#defaultForm-statusmodal').val($("#defaultForm-status").val());
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