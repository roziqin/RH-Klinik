<?php 
include '../modals/stokgudang.modal.php'; 

if ($_GET['ket']=='') { ?>
  


    <table id="table-stok" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">

        <thead>

            <tr>

                <th>kode barang</th>

                <th>nama</th>

                <th>stok</th>

                <th>tanggal input stok</th>

                <th></th>

            </tr>

        </thead>

    </table>







    <script type="text/javascript">

      

    $(document).ready(function() {



        $('#table-stok').DataTable( {

            "processing": true,

            "serverSide": true,

            "ajax": 

            {

                "url": "api/datatable.api.php?ket=stokgudang", // URL file untuk proses select datanya

                "type": "POST"

            },

            "deferRender": true,

            "columns": [

                { "data": "barang_kode" },

                { "data": "barang_nama" },

                { "data": "barang_stok_gudang" },
                
                { "data": "stok_tanggal" },

                { "width": "150px", "render": function(data, type, full){



                    if (full['barang_set_stok']==0) {

                     return '<a class="btn-floating btn-sm btn-primary mr-2 btn-tambah disabled" title="Tambah" ><i class="fas fa-plus"></i></a> <a class="btn-floating btn-sm btn-default mr-2 btn-edit disabled" title="Kurang" ><i class="fas fa-minus"></i></a>';



                    } else {
                        if (full['barang_gudang_status']==0) {
                          return '<a class="btn-floating btn-sm btn-primary mr-2 btn-tambah" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Tambah"><i class="fas fa-plus"></i></a><a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Kurang"><i class="fas fa-minus"></i></a>';

                        } else {                          return '<a class="btn-floating btn-sm btn-primary mr-2 btn-tambah" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Tambah"><i class="fas fa-plus"></i></a><a class="btn-floating btn-sm btn-default mr-2 btn-edit" data-toggle="modal" data-target="#modalstok" data-id="' + full['barang_id'] + '" title="Kurang"><i class="fas fa-minus"></i></a>';

                        }

                    }

                  }

                },

            ],

            /*

            "initComplete": function( settings, json ) {

              $('.btn-edit').on('click',function(){

                  var stok_id = $(this).data('id');

                  console.log(stok_id)

                  $.ajax({

                      type:'POST',

                      url:'api/view.api.php?func=editstok',

                      dataType: "json",

                      data:{stok_id:stok_id},

                      success:function(data){

                        $("#modalstok #update-stok").removeClass('hidden');

                        $("#modalstok #submit-stok").addClass('hidden');

                        $('#modalstok h4.modal-title').text('Edit stok');

                          $("#modalstok label").addClass("active");

                          $("#modalstok #defaultForm-id").val(data[0].stok_id);

                          $("#modalstok #defaultForm-nama").val(data[0].stok_nama);

                          $("#modalstok #defaultForm-jenis").val(data[0].stok_jenis);



                      }

                  });

                  

              });

            },

            */

            "drawCallback": function( settings ) {

              $('.btn-tambah').on('click',function(){

                  var id = $(this).data('id');

                  console.log(id)

                  $.ajax({

                      type:'POST',

                      url:'api/view.api.php?func=editstok',

                      dataType: "json",

                      data:{id:id},

                      success:function(data){

                      $("#modalstok #update-stok-gudang").addClass('hidden');

                      $("#modalstok #submit-stok-gudang").removeClass('hidden');

                      $("#modalstok #md-form-ket").addClass('hidden');

                      $('#modalstok h4.modal-title').text('Tambah stok');

                          $("#modalstok label").addClass("active");

                          $("#modalstok #defaultForm-id").val(data[0].barang_id);

                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);

                      }

                  });

              });



              $('.btn-edit').on('click',function(){

                  var id = $(this).data('id');

                  console.log(id)

                  $.ajax({

                      type:'POST',

                      url:'api/view.api.php?func=editstok',

                      dataType: "json",

                      data:{id:id},

                      success:function(data){

                          $("#modalstok #update-stok-gudang").removeClass('hidden');

                          $("#modalstok #submit-stok-gudang").addClass('hidden');

                          $("#modalstok #md-form-ket").removeClass('hidden');

                          $("[name='ip-ket']").attr('required',true);

                          $('#modalstok h4.modal-title').text('Kurangi stok');

                          $("#modalstok label").addClass("active");

                          $("#modalstok #defaultForm-id").val(data[0].barang_id);

                          $("#modalstok #defaultForm-nama").val(data[0].barang_nama);

                      }

                  });

              });



             

              

            }

        } );



      

    } );

    </script>


<?php } elseif ($_GET['ket']=='cekstok') { ?> 
  


    <table id="table-stok" class="table table-striped table-bordered fadeInLeft slow animated" style="width:100%">

        <thead>

            <tr>

                <th>kode barang</th>

                <th>nama</th>

                <th>size</th>

                <th>stok</th>

                <th>update stok</th>

                <th>keterangan</th>

                <th></th>

            </tr>

        </thead>

    </table>







    <script type="text/javascript">

      

    $(document).ready(function() {



        $('#table-stok').DataTable( {

            "processing": true,

            "serverSide": true,

            "ajax": 

            {

                "url": "api/datatable.api.php?ket=cekstokgudang", // URL file untuk proses select datanya

                "type": "POST"

            },

            "deferRender": true,

            "columns": [

                { "data": "barang_kode" },

                { "data": "barang_nama" },

                { "data": "ukuran_nama" },

                { "data": "barang_stok_gudang" },

                { "render": function(data, type, full){

                      var jml = parseInt(full['barang_stok_gudang']) - parseInt(full['barang_stok_gudang_temp']);

                   
                          return jml;

                        
                  

                  }

                },

                { "data": "barang_gudang_ket_temp" },

                { "width": "150px", "render": function(data, type, full){
                   
                          return '<a class="btn-floating btn-sm btn-primary btn-cekstok" data-id="' + full['barang_id'] + '" title="Delete"><i class="fas fa-pen"></i></a>';                  

                  }

                },

            ],

            "drawCallback": function( settings ) {

              $('.btn-cekstok').on('click', function(){

                  var produk_id = $(this).data('id');

                  $.confirm({

                      title: 'Konfirmasi Approve Stok',

                      content: 'Apakah yakin menyetujui update stok produk ini?',

                      buttons: {

                          confirm: {

                              text: 'Ya',

                              btnClass: 'col-md-6 btn btn-primary',

                              action: function(){

                                  console.log(produk_id);

                                  

                                  $.ajax({

                                    type: 'POST',

                                    url: "controllers/stok.ctrl.php?ket=approve-stok-gudang",

                                    dataType: "json",

                                    data:{produk_id:produk_id},

                                    success: function(data) {

                                      if (data[0]=="ok") {

                                        $('#table-stok').DataTable().ajax.reload();

                                      } else {

                                        alert('Produk gagal diupdate')

                                      }

                                    }

                                  });

                                  

                              }

                          },

                          cancel: {

                              text: 'Tidak',

                              btnClass: 'col-md-6 btn btn-danger text-white',

                              action: function(){

                                  console.log("tidak")

                                 

                              }

                              

                          }

                      }

                  });

              });
              

            }

        } );



      

    } );

    </script>
<?php } ?>