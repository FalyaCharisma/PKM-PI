@extends('layouts.app')

@section('content')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Forum Diskusi</h1>
            </div>

            <div class="section-body">

                <div class="card">
                    <div class="card-header">
                        <h4><i class="fas fa-question"></i> {{ $diskusi->materi->getMapel($diskusi->materi_id) }} - {{ $diskusi->materi->getJudul($diskusi->materi_id) }}</h4>
                     
                    </div>

                    <div class="card-body">
                        @can('diskusi.showDiskusi')
                            <div class="card card-default mb-2">
                                <div class="card-body">
                                    <span class="">{{ $diskusi->user->username }},
                                        <b>{{ $diskusi->created_at }}</b></span>
                                    <hr>
                                    <p class=""><b>Pertanyaan: </b> {{ $diskusi->pertanyaan }} </p>
                                </div>
                                <div class="card-body">
                                    @if ($diskusi->link)
                                        <img src="{{url('storage/public/diskusi/'.$diskusi->link)}}" alt="lampiran">
                                    @else
                                        <img src="{{url('storage/public/handler/no-photo.png')}}" alt="lampiran" width="25%" height="25%">
                                    @endif
                                </div>
                            </div>
                        @endcan
                     
                        @foreach ($respon as $item)
                            @can('diskusi.showDiskusi')
                                <div class="card card-default  mb-2">
                                    <div class="card-header">
                                        <span class="">{{ $item->user->username }},
                                            <b>{{ $item->created_at }}</b></span>
                                    </div>
                                    <div class="card-body">
                                        <p class="">{{ $item->respon }} </p>
                                        <div class="input-group-prepend">
                                            @if($item->user_id == Auth::user()->id)
                                            <a href="{{ route('editRespon', $item->id) }}"  class="btn btn-sm btn-primary">Edit</a>
                                            <form method="POST" action="{{ url('diskusi/respon/delete', $item->id) }}" style="margin-left:5px">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-sm btn-danger">Hapus</button>
                                            </form>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endcan 
                        @endforeach

                        @can('diskusi.respon')
                                <form action="{{ url('diskusi/respon', $diskusi->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('POST')
                                    <div class="form-group">
                                        <label>Beri Tanggapan</label>
                                        <textarea name="respon" value="{{ old('respon') }}" class="form-control @error('respon') is-invalid @enderror"
                                            placeholder="Place some text here"
                                            style="width: 100%; height: 100px; font-size: 14px; line-height: 18px; border: 1px solid #dddddd; padding: 10px;" required></textarea>
                                        @error('respon')
                                            <div class="invalid-feedback" style="display: block">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary mr-1 btn-submit" type="submit"><i
                                                class="fa fa-paper-plane"></i>Kirim</button>
                                    </div>
                                </form>
                            @endcan
                    </div>
                </div>
            </div>
        </section>
    </div>

@stop
