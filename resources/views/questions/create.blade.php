@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Tambah Soal</h1>
        </div>

        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-question"></i> Tambah Soal Pilihan Ganda</h4>
                </div>

                <div class="card-body">
                    <form action="{{ route('questions.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>SUBJECT</label>
                            <select class="form-control select-subject @error('subject_id') is-invalid @enderror" name="subject_id">
                                <option value="">- SELECT SUBJECT -</option>
                                @foreach ($subjects as $subject)
                                @if($subject->user_id == Auth::user()->id)
                                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('subject_id')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-3">
                                <div class="form-group">
                                    <label>VIDEO</label>
                                    <select class="form-control select-video @error('video_id') is-invalid @enderror" name="video_id">
                                        <option value="">- SELECT VIDEO -</option>
                                        @foreach ($videos as $video)
                                        @if($video->user_id == Auth::user()->id)
                                            <option value="{{ $video->id }}">{{ $video->title }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('video_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label>AUDIO</label>
                                    <select class="form-control select-audio @error('audio_id') is-invalid @enderror" name="audio_id">
                                        <option value="">- SELECT AUDIO -</option>
                                        @foreach ($audios as $audio)
                                        @if($audio->user_id == Auth::user()->id)
                                            <option value="{{ $audio->id }}">{{ $audio->title }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('audio_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label>IMAGE</label>
                                    <select class="form-control select-image @error('image_id') is-invalid @enderror" name="image_id">
                                        <option value="">- SELECT IMAGE -</option>
                                        @foreach ($images as $image)
                                        @if($image->user_id == Auth::user()->id)
                                            <option value="{{ $image->id }}">{{ $image->title }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('image_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>

                            <div class="col-3">
                                <div class="form-group">
                                    <label>DOCUMENT</label>
                                    <select class="form-control select-document @error('document_id') is-invalid @enderror" name="document_id">
                                        <option value="">- SELECT DOCUMENT -</option>
                                        @foreach ($documents as $document)
                                        @if($document->user_id == Auth::user()->id)
                                            <option value="{{ $document->id }}">{{ $document->title }}</option>
                                        @endif
                                        @endforeach
                                    </select>
                                    @error('document_id')
                                    <div class="invalid-feedback" style="display: block">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>PERTANYAAN</label>
                            <textarea name="pertanyaan" cols="30" rows="30" class="form-control">{{ old('pertanyaan') }}</textarea>
                            @error('pertanyaan')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>OPTION A</label>
                            <input type="text" name="option_A" value="{{ old('option_A') }}" class="form-control" >

                            @error('option_A')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>OPTION B</label>
                            <input type="text" name="option_B" value="{{ old('option_B') }}" class="form-control" >

                            @error('option_B')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>OPTION C</label>
                            <input type="text" name="option_C" value="{{ old('option_C') }}" class="form-control" >

                            @error('option_C')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>OPTION D</label>
                            <input type="text" name="option_D" value="{{ old('option_D') }}" class="form-control" >

                            @error('option_D')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>OPTION E</label>
                            <input type="text" name="option_E" value="{{ old('option_E') }}" class="form-control" >

                            @error('option_E')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>JAWABAN</label>
                            <input type="text" name="answer" value="{{ old('answer') }}" class="form-control" >

                            @error('answer')
                            <div class="invalid-feedback" style="display: block">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>PENJELASAN</label>
                            <textarea name="penjelasan" cols="30" rows="30" class="form-control">{{ old('penjelasan') }}</textarea>
                            @error('penjelasan')
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
    </section>
</div>
@stop