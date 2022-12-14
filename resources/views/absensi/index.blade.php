@extends('layouts.app')
@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Absensi</h1>
        </div>
        <div class="section-body">
            @can('absensi.create')
                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-image"></i> Upload Imagee</h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('absensi.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group">
                                <label>FOTO</label>
                                <input type="file" name="image" id="image" class="form-control @error('image') is-invalid @enderror">
                                @error('image')
                                <div class="invalid-feedback" style="display: block">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                            <div class="form-group">
                            <label>KETERANGAN</label><br>
                            <input type="radio" name="keterangan" value="Hadir" checked> Hadir
                            <input type="radio" name="keterangan" value="Izin"> Izin
                            <input type="radio" name="keterangan" value="Sakit"> Sakit
                            @error('keterangan')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                            </div>
                            <div class="form-group">
                            <label>NAMA SISWA</label>
                            <select class="form-control select-nama_siswa @error('nama_siswa') is-invalid @enderror" name="nama_siswa" required>
                                <option value="">- SELECT SISWA -</option>
                                @foreach ($siswa as $no => $siswa)
                                @if(Auth::user()->tentor->name==$siswa->nama_tentor)         
                                <option value="{{ $siswa->name }}">{{ $siswa->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('nama_tentor')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                            </div>
                            <button class="btn btn-primary mr-1 btn-submit" type="submit" id="submit"><i class="fa fa-upload"></i> UPLOAD</button>
                            <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>
                        </form>
                    </div>
                </div>
            @endcan
            @can('absensi.tentor')
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-image"></i> Riwayat Absensi</h4>
                </div>
                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">FOTO</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">KETERANGAN</th>
                                <th scope="col">TANGGAL</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($absens as $no => $absensis)
                            @if($absensis->name == Auth::user()->tentor->name)
                                <tr>
                                    <th scope="row" style="text-align: center">
                                    {{ ++$no + ($absens->currentPage() - 1) * $absens->perPage() }}</th>
                                    <td><img src="{{ asset('storage/public/absensis/' . $absensis->link) }}"width="150"></td>
                                    <td>{{ $absensis->nama_siswa }}</td>
                                    <td>{{ $absensis->keterangan }}</td>
                                    <td>{{ $absensis->created_at }}</td>
                                </tr>
                            @endif
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                        {{ $absens->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            @endcan
            @can('absensi.riwayat')
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-image"></i> Riwayat Absensi</h4>
                </div>
                <div class="card-body">
                    <div class="my-2">
                        <form action="{{ route('absensi.index') }}" method="GET">
                     
                            <div class="input-group mb-3">
                                <select class="form-control" name="name" id="name">
                                    <option value="">- SELECT TENTOR -</option>
                                    @foreach ($absens as $no => $absensis)         
                                    <option value="{{ $absensis->name }}">{{ $absensis->name }}</option>
                                    @endforeach
                                </select>
                                <input type="date" class="form-control" name="start_date" id="start_date">
                                <input type="date" class="form-control" name="end_date" id="end_date">
                                <a href="" onclick="this.href='/absensi/export_excel/'+ document.getElementById('start_date').value +
                                        '/' + document.getElementById('end_date').value +  '/' + document.getElementById('name').value " target="_blank" class="btn btn-success" style="padding-top: 8px;"> Cetak Excel</a>

                                <a href="" onclick="this.href='/absensi/exportPDF/'+ document.getElementById('start_date').value +
                                        '/' + document.getElementById('end_date').value +
                                        '/' + document.getElementById('name').value" target="_blank" class="btn btn-danger" style="padding-top: 10px; margin-left: 5px;"> Cetak PDF</a>
                            </div>
                        </form>
                    </div>
                                
                    <form action="{{ route('absensi.index') }}" method="GET">
                        <div class="form-group">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="q"
                                       placeholder="cari berdasarkan nama tentor">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i> CARI
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th scope="col" style="text-align: center;width: 6%">NO.</th>
                                <th scope="col">NAMA</th>
                                <th scope="col">FOTO</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">KETERANGAN</th>
                                <th scope="col">TANGGAL</th>
                                <th scope="col">AKSI</th>
                            </tr>
                            </thead>
                           
                            <tbody>
                            @foreach ($absens as $no => $absensis)
                                <tr>
                                <th scope="row" style="text-align: center">
                                                    {{ ++$no + ($absens->currentPage() - 1) * $absens->perPage() }}</th>
                                    <td>{{ $absensis->name }}</td>
                                    <td><img src="{{ asset('storage/public/absensis/' . $absensis->link) }}"
                                                        width="150"></td>
                                    <td>{{ $absensis->nama_siswa }}</td>
                                    <td>{{ $absensis->keterangan }}</td>
                                    <td>{{ $absensis->created_at }}</td>
                                    <td class="text-center">
                                    @can('absensi.delete')
                                                        <button onClick="Delete(this.id)" class="btn btn-sm btn-danger"
                                                            id="{{ $absensis->id }}">
                                                <i class="fa fa-trash"></i>
                                            </button>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div style="text-align: center">
                        {{ $absens->links('vendor.pagination.bootstrap-4') }}
                        </div>
                    </div>
                </div>
            </div>
            @endcan
        </div>
    </section>
</div>
<script>
    //ajax delete
    function Delete(id) {
            var id = id;
            var token = $("meta[name='csrf-token']").attr("content");
            swal({
                title: "APAKAH KAMU YAKIN ?",
                text: "INGIN MENGHAPUS DATA INI!",
                icon: "warning",
                buttons: [
                    'TIDAK',
                    'YA'
                ],
                dangerMode: true,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    //ajax delete
                    jQuery.ajax({
                        url: "{{ route('absensi.index') }}/" + id,
                        data: {
                            "id": id,
                            "_token": token
                        },
                        type: 'DELETE',
                        success: function(response) {
                            if (response.status == "success") {
                                swal({
                                    title: 'BERHASIL!',
                                    text: 'DATA BERHASIL DIHAPUS!',
                                    icon: 'success',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            } else {
                                swal({
                                    title: 'GAGAL!',
                                    text: 'DATA GAGAL DIHAPUS!',
                                    icon: 'error',
                                    timer: 1000,
                                    showConfirmButton: false,
                                    showCancelButton: false,
                                    buttons: false,
                                }).then(function() {
                                    location.reload();
                                });
                            }
                        }
                    });
                } else {
                    return true;
                }
            })
        }
</script>
@stop