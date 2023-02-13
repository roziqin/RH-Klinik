
<!-------------- Modal tambah produk -------------->

<div class="modal fade" id="modaldetailbarangkeluar" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header text-center">
        <h4 class="modal-title w-100 font-weight-bold">Detail Transaksi Barang Keluar</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body mx-3">
        <div class="row">
          <div class="col-md-12 col-md-offset-0">
            <p class="nofaktur"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="kasir"></p>
          </div>
          <div class="col-md-6 col-md-offset-0">
            <p class="tanggal"></p>
          </div>
        </div>
        <table id="listbarangkeluar" class="table table-bordered table-striped">
          <thead>
          <tr>
            <th>Nama Menu</th>
            <th width="50px"class="text-right">Jumlah</th>
          </tr>
          </thead>
          <tbody>
          </tbody>
        </table>
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