@extends('layouts.layout')
@section('title','Tagihan')

@section('content')

<div id="main-content">
    <h1>Data Tagihan</h1>
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{url('/')}}">Beranda</a>
        <a class="breadcrumb-item" href="{{url('/data/tagihan')}}">Data Tagihan</a>
        <span class="breadcrumb-item active"></span>
    </nav>

    <div class="row mt-4">
        <div class="col-md-9">
            <div class="form-group position-relative">
                <i class="fas fa-search position-absolute" style="margin-left: 15px; margin-top: 11px;"></i>
                <input type="text" class="form-control pl-5" name="" id="" aria-describedby="helpId" placeholder="Cari Tagihan Disini . . ." style="border: none; border-radius: 8px; box-shadow: 1px 1px 6px rgba(0,0,0,0.1); padding-top: 8px;">
            </div>
        </div>
        <div class="col-md-3 pl-0">
            <a type="button" href="{{url('/data/tagihan/tambah')}}" class="btn w-100" style="background: #3AA9A5; color: #ffffff; box-shadow: 1px 3px 6px rgba(0,0,0,0.1);">Tambah Tagihan</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-striped align-center" id="table-refresh">
                <thead align="center">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Nama Tagihan</th>
                        <th scope="col">Nominal</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($tipetagihan as $t)
                        <tr>
                            <th scope="row">{{$no++}}</th>
                            <td>{{ $t->nama_tagihan }}</td>
                            <td>Rp. {{ $t->nominal }}</td>
                            <td>
                                <button type="button" data-url="{{ url('data/tagihan/hapus/' . $t->id) }}" class="btn btn-danger text-light" id="btn-hapus"
                                    style="padding: 4px 10px; font-size: 14.5px;">Hapus</button>
                                <a href="{{ url('data/tagihan/perbaharui/' . $t->slug ) }}" class="btn btn-success"  style="padding: 4px 15px; font-size: 14.5px;">Edit</button>
                            </td>
                        </tr>                        
                    @endforeach
                </tbody>
            </table>
        </div>
      </div>
</div>

@include('partials.footer')
@endsection