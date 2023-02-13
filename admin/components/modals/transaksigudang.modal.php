<!-------------- Modal Transaksi -------------->

<div class="modal fade" id="modaltransaksi" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h2 class="modal-title w-100 font-weight-bold" id="totaltransaksi">Barang Keluar</h2>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <table id="listbarang" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Kode Barang</th>
            <th>Nama</th>
            <th width="50px" style="padding-right: 8px; ">Jumlah</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <div class="md-form mb-0 hidden">
          <input type="text" id="price" class="form-control validate mb-1" name="ip-bayar">
          <label for="price">Bayar</label>
        </div>
        
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="submit-transaksi" data-dismiss="modal" aria-label="Close">Proses</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal transaksi -------------->





  <script type="text/javascript">
      
      $('#price').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.', centsLimit: 0 });

      $("#submit-transaksi").click(function(e){
        e.preventDefault();
        var data = new FormData();

        $.ajax({
          type: 'POST',
          url: "controllers/transaksigudang.ctrl.php?ket=prosestransaksi",
          data: data,
          cache: false,
          processData: false,
          contentType: false,
          success: function(data) {
            console.log(data);
          
            
            $('.container__load').load('components/content/transaksigudang.content.php?kond=home');
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