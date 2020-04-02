@extends('layouts.layout')
@section('title','Kelas')

@section('content')

<div id="main-content">
    <h1>Data Kelas</h1>
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{url('/')}}">Beranda</a>
        <a class="breadcrumb-item" href="{{url('/data/kelas')}}">Data Kelas</a>
        <span class="breadcrumb-item active"></span>
    </nav>

    <div class="row mt-4">
        <div class="col-md-9">
            <div class="form-group position-relative">
                <i class="fas fa-search position-absolute" style="margin-left: 15px; margin-top: 11px;"></i>
                <input type="text" class="form-control pl-5" name="field_cari" id="field_cari" aria-describedby="helpId"
                    placeholder="Cari Kelas Disini . . ."
                    style="border: none; border-radius: 8px; box-shadow: 1px 1px 6px rgba(0,0,0,0.1); padding-top: 8px;">
            </div>
        </div>
        <div class="col-md-3 pl-0">
            <a type="button" href="{{url('/data/kelas/tambah')}}" class="btn w-100"
                style="background: #3AA9A5; color: #ffffff; box-shadow: 1px 3px 6px rgba(0,0,0,0.1);">Tambah Kelas</a>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-md-12">
            <table class="table table-striped align-center" id="table-refresh">
                <thead align="center">
                    <tr id="header-tr">
                        <th scope="col">No</th>
                        <th scope="col">Nama Kelas</th>
                        <th scope="col">Tingkat</th>
                        <th scope="col">Jurusan</th>
                        <th scope="col">Wali Kelas</th>
                        <th scope="col">Aksi</th>
                    </tr>
                </thead>
                <tbody align="center">
                    @php
                    $no = 1;
                    @endphp
                    @foreach ($kelas as $k)
                    <tr href="kelas/detail/{{ $k->slug }}" id="row-main">
                        <th scope="row">{{$no++}}</th>
                        <td>{{$k->nama_kelas}}</td>
                        <td>{{$k->tipekelas->nama_tipekelas}}</td>
                        <td>{{$k->jurusan}}</td>
                        <td>{{$k->wali_kelas}}</td>
                        <td>
                            <button type="button" data-url="{{ url('data/kelas/hapus/' . $k->id) }}" class="btn btn-danger text-light" id="btn-hapus"
                                style="padding: 4px 10px; font-size: 13px;">Hapus</button>
                            <a type="button" href="{{url('/data/kelas/perbaharui/' . $k->slug )}}"
                                class="btn btn-success" style="padding: 4px 10px; font-size: 13px;">Edit</a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <div class="row m-3 float-right">
        {{ $kelas->links() }}
    </div>
    <div class="clearfix"></div>
</div>

@include('partials.footer')
@endsection