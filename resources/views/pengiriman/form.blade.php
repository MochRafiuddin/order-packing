@push('css-app')
<link href="{{asset('/')}}assets/file_upload/jquery.dm-uploader.min.css" rel="stylesheet">
<link href="{{asset('/')}}assets/file_upload/styles.css" rel="stylesheet">
@endpush
@extends('template')
@section('content')
<?php 
use App\Traits\Helper;
$name[] = 'file[]';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} Pengiriman</h6>
                <form action="{{$url}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                        
                        <!-- Our markup, the important part here! -->
                            <div id="drag-and-drop-zone" class="dm-uploader p-5">
                                <h3 class="mb-5 mt-5 text-muted">Drag &amp; drop files here</h3>

                                <div class="btn btn-primary btn-block mb-5">
                                    <span>Open the file Browser</span>
                                    <input type="file" title='Click to add Files' />
                                </div>
                            </div><!-- /uploader -->

                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="card h-100">
                                <div class="card-header">
                                    File List
                                </div>

                                <ul class="list-unstyled p-2 d-flex flex-column col" id="files">
                                    <li class="text-muted text-center empty">No files uploaded.</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <a class="btn btn-success" href="{{url('pengiriman')}}">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
@push('js')
<script src="{{asset('/')}}assets/file_upload/jquery.dm-uploader.min.js"></script>
<script src="{{asset('/')}}assets/file_upload/demo-ui.js"></script>
<script src="{{asset('/')}}assets/file_upload/demo-config.js"></script>
<!-- File item template -->
    <script type="text/html" id="files-template">
        <li class="media">
            <div class="media-body mb-1">
                <p class="mb-2">
                    <strong>%%filename%%</strong> - Status: <span class="text-muted">Waiting</span>
                </p>
                <div class="progress mb-2">
                    <div class="progress-bar progress-bar-striped progress-bar-animated bg-primary" 
                    role="progressbar"
                    style="width: 0%" 
                    aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                    </div>
                </div>
                <hr class="mt-1 mb-1" />
            </div>
        </li>
    </script>
@endpush