<!-------------- Modal pembelian -------------->

<div class="modal fade" id="modalpembelian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="modal-title w-100 font-weight-bold" id="totalpembelian"></h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <input type="hidden" id="defaultForm-total" name="ip-total">
        <table id="table-preview" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody></tbody>
        </table>
        
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-pembelian" data-dismiss="modal" aria-label="Close">Proses</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal pembelian -------------->





  <script type="text/javascript">
      
      $('#price').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.', centsLimit: 0 });

      $("#submit-pembelian").click(function(e){
        e.preventDefault();
        var data = new FormData();
        data.append('ip-total', $("#defaultForm-total").val());
      
        $.ajax({
          type: 'POST',
          url: "controllers/pembelian.ctrl.php?ket=prosespembelian",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log(data);
          
            
            $('.container__load').load('components/content/pembelian.content.php?kond=pembeliansukses');
            $('#listitem table').empty();
            $('#subtotal').empty();
            $('#subtotal').append('Rp. 0');
            $('#pajak').empty();
            $('#pajak').append('Rp. 0');
            $('#total').empty();
            $('#total').append('Rp. 0');
            $('.text-jenisdiskon').empty();
            $('.text-jumlahdiskon').empty();

            
          }
        });
          
        
      }); 
    
  </script> 