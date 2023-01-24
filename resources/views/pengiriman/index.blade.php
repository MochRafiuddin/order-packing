@extends('template')
@section('content')
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h4>Data Pengiriman</h4><br>
                <div class="row">
                    <div class="form-group col-3">
                        <label for="filterMonthYear">Tanggal</label>                                    
                        <input class="form-control pickerdate" type="text" name="tanggal" id="tanggal" value="{{$mulai}}">
                    </div>
                    <div class="form-group col-3">
                        <label for="filterMonthYear">Marketplace</label>
                        <select class="form-control js-example-basic-single" name="marketplace" id="marketplace" style="width:100%">
                            <option value="0">Semua</option>
                            @foreach($market as $data)
                                <option value="{{$data->id}}">{{$data->nama}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row mb-4">
                    <div class="col text-right">                        
                        <a href="{{url('pengiriman/create')}}" class="btn btn-info">Tambah</a>                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="table-responsive">
                            <table class="table w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Kode</th>
                                        <th>Marketplace</th>
                                        <th>Tanggal</th>
                                        <th>Cetak</th>
                                        <th>verifikasi</th>
                                        <th>Opsi</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content-wrapper ends -->
    <!-- partial:partials/_footer.html -->

<div class="modal fade" id="ajaxModelexa" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Print</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">        
        <input type="hidden" name="id" id="id">
        <div class="row">
            <div class="col-12">
                <iframe id="pdf" src="" align="top" height="500" width="100%" frameborder="0" scrolling="auto"></iframe>
            </div>
        </div>  
      </div>
      <div class="modal-footer">        
        <button type="button" class="btn btn-success" onclick="printIframe()">Print</button>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="ajaxModel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form action="" method="post" id="form" enctype="multipart/form-data">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">Verifikasi</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body text-center">        
        <input type="hidden" name="id" id="idvarif">
        <input type="hidden" name="varifikasi" id="varifikasi">
        <div class="row">
            <div class="col-12">
                <iframe id="pdfvarif" src="" align="top" height="500" width="100%" frameborder="0" scrolling="auto"></iframe>
            </div>            
            <div class="form-group col-12 gambar_file">
                <br>                
                <img src="" alt="" id='gambar_f' width="80%">                
            </div>
            <div class="col-12" id="camera">
                <br>                
                <input type="hidden" name="image" class="image-tag">
                <select name="camera_list" id="camera_list" class="form-control mb-3"></select>
                <!-- <div id="my_camera"></div> -->
                <video id="my_camera" class='mx-auto img-fluid' width='315' height='420'></video>
            </div>
            <div class="col-12" id="hasil_camera">
                <br>                
                <div id="results">.......Hasil Foto.......</div>
                <canvas id="canvas" width='420' height='340' style="display: none;"></canvas>
                <br>                
                <div id="msg1"></div>
            </div>
            <div class="form-group col-12 text">
                <br>                
                <textarea class="form-control" name="catatan" id="catatan" style="height:100px;"></textarea>
            </div>
        </div>  
      </div>
      <div class="modal-footer">
            <button type=button class="btn btn-info take" onClick="take_snapshot()">Take Snapshot</button>
            <button type="button" class="btn btn-success kirim">Submit</button>
        <div class="col-12 pilihan">
              <button type="button" class="btn btn-success float-left" onclick="verifikasi(2)">Setuju</button>
              <button type="button" class="btn btn-danger float-right" onclick="verifikasi(3)">Tolak</button>
        </div>
      </div>
      </form>
    </div>
  </div>
</div>

    @include("partial.footer")
    <!-- partial -->
</div>
@endsection
@push('js')
<script src="{{asset('/')}}assets/js/dropify.js"></script>
<script src="{{asset('/')}}assets/js/webcam.min.js"></script>
<script>
    $(document).ready(function () {
        camera();
        read_data();

        $(".pickerdate").datepicker( {
            format: "dd-mm-yyyy",
            orientation: "bottom",
            autoclose: true
        });
        
         $(document).on('click','.delete',function(e){
            e.preventDefault();
            Swal.fire({
                title: 'Kamu Yakin?',
                text: "Menghapus data ini",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya',
                cancelButtonText: 'Tidak'
                }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('href');
                }
                })
        })

        $('body').on('click', '.editPost', function () {                
            var id = $(this).data('id');
            var pdf = $(this).data('pdf');
            $('#ajaxModelexa').modal('show');
            $('#id').val(id);
            $('#pdf').attr('src',pdf);
            
        });

        $('body').on('click', '.varifPost', function () {                
            var id = $(this).data('id');
            var pdf = $(this).data('pdf');
            var gambar = $(this).data('gambar');
            var catatan = $(this).data('catatan');
            var verifikasi = $(this).data('verifikasi');
            $('#ajaxModel').modal('show');
            if (verifikasi == 0) {                
                $('.pilihan').hide();
                $('.gambar_file').hide();
                $('.text').hide();
                $('#results').show();
                $('.kirim').show();
                $('.gambar').show();
                $('.take').show();
                $('#camera').show();
                $('#hasil_camera').show();
            }else if(verifikasi == 1){                
                $('.kirim').hide();
                $('.gambar').hide();
                $('#camera').hide();
                $('.take').hide();
                $('#hasil_camera').hide();
                $('#results').hide();
                $('#gambar_f').attr('src',gambar);
                $('.pilihan').show();
                $('.gambar_file').show();
                $('.text').show();
                $('#catatan').val('');
            }else{
                $('#results').show();
                $('#camera').hide();
                $('#hasil_camera').hide();
                $('.kirim').hide();
                $('.gambar').hide();                
                $('.pilihan').hide();
                $('.take').hide();
                $('.gambar_file').show();
                $('.text').show();
                $('#gambar_f').attr('src',gambar);
                $('#catatan').val(catatan);
            }
            $('#varifikasi').val(verifikasi);
            $('#idvarif').val(id);
            $('#pdfvarif').attr('src',pdf);
            
        });
    });

        function read_data() {
            var market = $('#marketplace').val();
            var tanggal = $('#tanggal').val();
            $('.table').DataTable().destroy();
            $('.table').DataTable({
                processing: true,
                serverSide: true,

                "scrollX": true,
                ajax: {
                    url: '{{ url("pengiriman/data") }}',
                    type: 'GET',
                    data: {
                        market : market,
                        tanggal : tanggal,
                    },
                },
                rowReorder: {
                    selector: 'td:nth-child(1)'
                },

                responsive: true,
                columns: [{
                        "data": 'DT_RowIndex',
                        orderable: false,
                        searchable: false,
                        width: '4%',
                        className: 'text-center'
                    },                    
                    {
                        data: 'kode',
                        name: 'kode',                        
                    },
                    {
                        data: 'nama_marketplace',
                        name: 'nama_marketplace',
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                    },
                    {
                        data: 'cetak',
                        name: 'cetak',
                    },
                    {
                        data: 'verifikasi',
                        name: 'verifikasi',
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ]
            });
        }

function printIframe() {
    var id = $('#id').val();
    $.ajax({
        url: '{{ url("pengiriman/print") }}',
        type: "POST",
        data: { id: id},
        success: function(response) {
            var iframe = document.getElementById('pdf');
            iframe.contentWindow.print();
            $('#ajaxModelexa').modal('hide');
            read_data();
        }
    });
}

function verifikasi(varif) {
    var id = $('#idvarif').val();
    var catatan = $('#catatan').val();
    $.ajax({
        url: '{{ url("pengiriman/verifikasi") }}',
        type: "POST",
        data: { id: id, varifikasi: varif, catatan: catatan},
        success: function(response) {            
            $('#ajaxModel').modal('hide');
            read_data();
        }
    });
    $('#catatan').val('');
}

$('.kirim').click(function(){
    $.ajax({
        url: '{{ url("pengiriman/verifikasi") }}',
        type: "POST",
        data: new FormData($('#form')[0]),
        processData: false,
        contentType: false,
        success: function(response) {
            read_data();
            // $('.dropify-preview').hide();
            $("#msg1").html("<div class='alert alert-success alert-block'>\
            <button type='button' class='close' data-dismiss='alert'>&times;</button>Data Berhasil Disimpan</div>");
            // document.getElementById('results').innerHTML = '.......Hasil Foto.......';
        }
    });    
});

$('#ajaxModel').on('hide.bs.modal', function (e) {
    document.getElementById('results').innerHTML = '.......Hasil Foto.......';
});

$('#marketplace').on('change', function(e) {
    read_data();            
});
$('#tanggal').on('change', function(e) {
    read_data();            
});
function camera() {
    var video = document.getElementById('my_camera');
    var select = document.getElementById("camera_list");    
// Get access to the camera!
  navigator.mediaDevices.enumerateDevices()
  .then(function(devices) {
    devices.forEach(function(device) {
      if (device.kind === 'videoinput') {
        var option = document.createElement("option");
        option.value = device.deviceId;
        option.text = device.label;
        select.appendChild(option);
      }
    });    
    
    navigator.mediaDevices.getUserMedia({ video: { deviceId: select.value } })
    .then(function (stream) {
        video.srcObject = stream;
        video.play();
    })
    .catch(function (err) {
        console.log("Something went wrong!");
    });
  })
  .catch(function(err) {
    console.log(err.name + ": " + err.message);
  });  

select.onchange = function() {
  // stop any active streams before switching camera
  if (video.srcObject) {
    video.srcObject.getTracks().forEach(function(track) {
      track.stop();
    });
  }

  navigator.mediaDevices.getUserMedia({ video: { deviceId: select.value } })
    .then(function (stream) {
        video.srcObject = stream;
        video.play();   
    })
    .catch(function (err) {
        console.log("Something went wrong!");
    });
}



    // if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
    //     // Not adding `{ audio: true }` since we only want video now
     
    //      var mediaConfig =  {video : { 
    //         facingMode: { exact: "environment" }
    //      }};
     
    //     navigator.mediaDevices.getUserMedia(mediaConfig).then(function(stream) {
    //         //video.src = window.URL.createObjectURL(stream);
    //         video.srcObject = stream;
    //         video.play();
    //     });
    // }

}    
    function take_snapshot() {
        var video = document.getElementById('my_camera');
        var canvas = document.createElement("canvas");
        var context = canvas.getContext("2d");
        canvas.width = video.videoWidth;
        canvas.height = video.videoHeight;
        context.drawImage(video, 0, 0, canvas.width, canvas.height);

        
        // link.href = canvas.toDataURL();        
        $(".image-tag").val(canvas.toDataURL());            
        document.getElementById('results').innerHTML = '<img src="'+canvas.toDataURL()+'" width="80%"/>';        
    }
</script>
@endpush