@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        @hasanyrole('admin|superadmin')
        <div class="section-header">
            <h1>Tambah Penilaian Tentor</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i> Tambah Penilaian Tentor</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('penilaian.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>NAME</label>
                            <input type="text" name="name" value="{{ old('name') }}" class="form-control" >
                            @error('name')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>TIME (MINUTE)</label>
                            <input type="number" name="time" value="{{ old('time') }}" class="form-control" >

                            @error('time')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>TOTAL PERTANYAAN</label>
                            <input type="number" name="total_pertanyaan" value=3 class="form-control" >

                            @error('total_pertanyaan')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>START</label>
                            <input type="datetime-local" name="start" value="<?= date('Y-m-d', time()); ?>" class="form-control @error('start') is-invalid @enderror">

                            @error('start')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>END</label>
                            <input type="datetime-local" name="end" value="<?= date('Y-m-d', time()); ?>" class="form-control @error('end') is-invalid @enderror">

                            @error('end')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i class="fa fa-paper-plane"></i>
                            SIMPAN</button>
                        <button class="btn btn-warning btn-reset" type="reset"><i class="fa fa-redo"></i> RESET</button>

                    </form>
                </div>
            </div>
        </div>
        @endhasanyrole
    </section>
</div>

@stop
