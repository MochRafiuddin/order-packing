@extends('template')
@section('content')
<?php 
use App\Traits\Helper;  
$name[] = 'username';
$name[] = 'password';
?>
<div class="main-panel">
    <div class="content-wrapper">
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">{{$titlePage}} User</h6>
                <form action="{{$url}}" method="post" enctype="multipart/form-data">
                    @csrf                    
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="text" class="form-control @error($name[0]) is-invalid @enderror"
                                value="{{Helper::showData($data,$name[0])}}" name="{{$name[0]}}" />
                        </div>
                    </div>
                    @if($data == null)
                    <div class="row">
                        <div class="form-group col">
                            <label for="exampleInputEmail1">Password</label>
                            <input type="text" class="form-control @error($name[1]) is-invalid @enderror" value="" name="{{$name[1]}}" />
                        </div>
                    </div>
                    @endif
                    <input type="submit" class="btn btn-success" value="Simpan" />
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
