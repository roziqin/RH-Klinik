<?php 
session_start();

include '../../../include/format_rupiah.php';

include '../modals/bayar.modal.php';

$kond = $_GET['kond'];
$userid = $_SESSION['login_user'];


if ($kond=='home' || $kond=='') { 
    ?>
    <h3 class="text-center mb-5">Pilih Transaksi</h3>
    <table id="example" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">
        <thead>
            <tr>
                <th>nama</th>
                <th>total</th>
                <th></th>
            </tr>
        </thead>
    </table>



    <script type="text/javascript">
      
    $(document).ready(function() {


        $('#example').DataTable( {
            "processing": true,
            "serverSide": true,
            "ajax": 
            {
                "url": "api/datatable.api.php?ket=listbayar", // URL file untuk proses select datanya
                "type": "POST"
            },
            "deferRender": true,
            "columns": [
                { "data": "member_nama" },
                { "data": "transaksi_total" },
                { "width": "50px", "render": function(data, type, full){
                   return '<a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalbayar" data-id="' + full['transaksi_id'] + '" title="Edit"><i class="fas fa-pen"></i></a>';
                  }
                },
            ],
            "initComplete": function( settings, json ) {
              
            },
            "drawCallback": function( settings ) {
              $('.btn-edit').on('click',function(){
                  var notaid = $(this).data('id');
                  $.ajax({
                      type:'POST',
                      url:'api/view.api.php?func=cek-transaksi',
                      dataType: "json",
                      data:{notaid:notaid},
                      success:function(data){
                          for (var i in data) {

                            if (i==0) {
                                      $('#modalbayar p.nama').text('Nama: '+data[i].nama);
                                      $('#modalbayar p.nonota').text('No Nota: '+data[i].notaid);
                                      $('#modalbayar p.admin').text('Admin: '+data[i].user);
                                      $('#modalbayar p.total').text(data[i].total);
                                      $('#modalbayar #defaultForm-totalmodal').val(data[i].total);
                                      $('#modalbayar #defaultForm-id').val(data[i].notaid);
                            } else {
                              $('#listbarangpembelian tbody').append("<tr><td>"+data[i].barang_nama+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_harga.toString(), 'Rp. ')+"</td><td class='text-right'>"+data[i].transaksi_detail_jumlah+"</td><td class='text-right'>"+formatRupiah(data[i].transaksi_detail_total.toString(), 'Rp. ')+"</td></tr>");
                            }
                          }

                      }
                  });
              });
              
            }
        } );

      
    } );
    </script>


<?php } elseif ($kond=='kembalian') { ?>
    <input type="hidden" id="ketnota" value="<?php echo $_SESSION['no-nota']; ?>" name="ketnota">   
    <div class="row row-jumlah justify-content-md-center text-center">
      <div class="col-12 mt-5">
        <h3 class="text-center mb-5">Jumlah Kembalian</h3>
        <h1 class="text-center mt-5 mb-3" id="jumlahkembalian">Rp. <?php echo format_rupiah($_SESSION['kembalian']); ?></h1>
        <button class="btn btn-primary transaksibaru">Kembali</button>
        <button class="btn btn-default printulangnota">Print Ulang nota</button>
      </div>
    </div>

    <script type="text/javascript">
        var nota = $("#ketnota").val();
        windowList = new Array('../print/nota.print.php?id='+nota);
        i = 0;
        windowName = "window";
        windowInterval = window.setInterval(function(){
            window.open(windowList[i],windowName+i,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,titlebar=no');
            i++;
            if(i==windowList.length){
                window.clearInterval(windowInterval);
            }
        },1000);

        $('.printulangnota').on('click',function(){
            windowList = new Array('../print/nota.print.php?id='+nota);
            i = 0;
            windowName = "window";
            windowInterval = window.setInterval(function(){
                window.open(windowList[i],windowName+i,'toolbar=0,scrollbars=1,location=0,statusbar=0,menubar=0,resizable=0,titlebar=no');
                i++;
                if(i==windowList.length){
                    window.clearInterval(windowInterval);
                }
            },1000);
        });


        $('.transaksibaru').on('click',function(){
            window.location.reload();
            $('.container__load').load('components/content/pembayaran.content.php?kond=home');
        });
    </script>

<?php } ?> 