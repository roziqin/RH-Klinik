
<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modalbayar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Detail Pembelian</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="row">
          <div class="col-md-12 col-md-offset-0">
            <p class="nonota"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="admin"></p>
          </div>
        </div>
        <table id="listbarangpembelian" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nama Barang</th>
            <th class="text-right">Harga</th>
            <th width="50px" style="padding-right: 8px; ">Jumlah</th>
            <th class="text-right">Total</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
        <div class="row">
          <div class="col-md-6">Total</div>
          <div class="col-md-6 text-right"><p class="total"></p></div>
        </div>
        <input type="hidden" id="defaultForm-totalmodal" name="ip-total">
        <input type="hidden" id="defaultForm-id" name="ip-id">
        <div class="md-form mb-0 mt-0">
            <select class="mdb-select md-form" id="defaultForm-payment" name="ip-payment">
                <option value="cash" selected>Cash</option>
                <option value="debet">Debet</option>
            </select>
        </div>
        <div class="md-form mb-0">
          <input type="text" id="price" class="form-control validate mb-1" name="ip-bayar">
          <label for="price">Bayar</label>
        </div>
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" id="btn-transaksi" data-dismiss="modal" aria-label="Close">Bayar</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal tambah produk -------------->



  <script type="text/javascript">
    $(document).ready(function(){
      $('#price').priceFormat({ prefix: '', centsSeparator: ',', thousandsSeparator: '.', centsLimit: 0 });

      $('.mdb-select').materialSelect();
      $("#btn-transaksi").click(function(e){
        e.preventDefault();
        var data = new FormData();
        data.append('ip-payment', $("#defaultForm-payment").val());
        data.append('ip-total', $("#defaultForm-total").val());
        data.append('ip-id', $("#defaultForm-id").val());
        
        var total = parseInt($("#defaultForm-totalmodal").val());
        var bayar = '';
        var text_line = $("#price").val().split(".");
        var length = text_line.length;

        if (length==1) {
          bayar=text_line[0];

        } else if (length==2) {
          bayar=text_line[0]+""+text_line[1];

        } else if (length==3) {
          bayar=text_line[0]+""+text_line[1]+""+text_line[2];

        } else if (length==4) {
          bayar=text_line[0]+""+text_line[1]+""+text_line[2]+""+text_line[3];

        } else if (length==5) {
          bayar=text_line[0]+""+text_line[1]+""+text_line[2]+""+text_line[3]+""+text_line[4];

        }

        data.append('ip-bayar', bayar);
        console.log(bayar+" "+total);

        bayar = parseInt(bayar);

        if (bayar < total) {
            alert("Angka yang dibayarkan Kurang");
            $("#price").val("");
        } else {
   
          $.ajax({
            type: 'POST',
            url: "controllers/transaksi.ctrl.php?ket=prosesbayar",
            data: data,
            cache: false,
            processData: false,
            contentType: false,
            success: function(data) {
              console.log(data);
            
              
              $('.container__load').load('components/content/pembayaran.content.php?kond=kembalian');

              
            }
          });
          
          
        }
      }); 

    });
  </script> 