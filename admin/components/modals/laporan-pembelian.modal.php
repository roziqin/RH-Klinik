
<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modaldetailpembelian" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
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
      </div>
      <div class="modal-footer d-flex justify-content-center">
        <button class="btn btn-primary" data-dismiss="modal" aria-label="Close">Tutup</button>
      </div>
    </div>
  </div>
</div>

<!-------------- End modal tambah produk -------------->



  <script type="text/javascript">
    $(document).ready(function(){


    });
  </script> 