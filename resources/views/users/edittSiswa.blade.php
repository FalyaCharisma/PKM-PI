@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Siswa</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-unlock"></i> Edit Siswa</h4>
                </div>
 
                <div class="card-body">
                    <form action="{{ url('users/siswa/updateSiswa', $siswa->id) }}" method="POST"
                        enctype="multipart/form-data"> 
                        @csrf
    
                        <div class="form-group">
                            <label>NAMA SISWA</label>
                            <input type="text" name="name" value="{{ old('name', $siswa->name) }}"
                                class="form-control">
                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>JENJANG</label>
                            <select class="form-control select-jenjang @error('jenjang') is-invalid @enderror" name="jenjang">
                                <option value="">- SELECT JENJANG -</option>
                                    @if ($siswa->jenjang !== null )
                                    <option value="{{ $siswa->jenjang }}" selected>{{ $siswa->jenjang }}</option>
                                    @else
                                        <option value="{{ $siswa->jenjang }}">{{ $siswa->jenjang }}</option>
                                    @endif
                            </select>
                            @error('jenjang')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>NO. WA</label>
                            <input type="text" name="no_wa" value="{{ old('no_wa', $siswa->no_wa) }}"
                                class="form-control">

                            @error('no_wa')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>ASAL SEKOLAH</label>
                            <input type="text" name="asal_sekolah" value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"
                                class="form-control">

                            @error('asal_sekolah')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>ALAMAT</label>
                            <input type="text" name="alamat" value="{{ old('alamat', $siswa->alamat) }}"
                                class="form-control">

                            @error('alamat')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>NAMA TENTOR</label>
                            <select class="form-control" name="nama_tentor">
                                @foreach ($tentor as $no => $tentor)    
                                <option value="{{ $tentor->name }}" selected>{{ $tentor->name }}</option>     
                                <option value="{{ $tentor->name }}">{{ $tentor->name }}</option>
                                @endforeach
                            </select>
                            @error('nama_tentor')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            UPDATE</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@stop