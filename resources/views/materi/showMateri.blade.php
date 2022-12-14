@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Materi</h1>
        </div>
        {{-- @can('materi.showMateri') --}}
        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book"></i> {{ $materis->mapel }}</h4>
                </div>
                    <section class="content">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="card card-primary">
                                    <div class="card-body">
                                        <h3 class="card-title">{{ $materis->judul }}</h3>
                                        {!! $materis->isi !!}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                    <div class="card card-outline card-primary">
                                        <div class="card-body">
                                            <h5><strong>Info :</strong></h5>
                                            <p><strong>Mata Pelajaran : </strong>{{ $materis->mapel }}</p>
                                            <p><strong>Untuk Kelas :</strong> {{ $materis->kelas }}</p>
                                            <p><strong>Tanggal :</strong> {{ $materis->created_at }}</p>
                                            <br>
                                            <p></p>
                                        </div>
                                    </div>
                                    <div class="card card-outline card-primary">
                                        <div class="card-header">
                                            <h5>Download Materi</h5>
                                        </div>
                                        <div class="card-body">
                                             @if($materis->link == '')
                                            <a href="#"> <i class="fa-solid fa-empty-set"></i>Tidak ada File </a>
                                        @else
                                            <a href="{{ asset('storage/public/materis/'.$materis->link) }}" download> <i class="fas fa-file-download"></i> Download </a>
                                            {{-- <a href="{{ route('downloadPdf',$materis->link) }}"> <i class="fas fa-file-download"></i> Download </a> --}}
                                            <a href="{{ route('showPdf',$materis->id)}}" target="_blank"> <i class="fas fa-file-download"></i> Preview </a>
                                        @endif
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </section>  
                </div>
            </div>
        {{-- @endcan --}}
    </section>
</div>

@stop