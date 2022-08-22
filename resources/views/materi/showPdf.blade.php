@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Preview Materi</h1>
        </div>
        <div class="section-body">

            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-book"></i> {{$materis->mapel}}</h4>
                </div>
                <?php use Illuminate\Support\Facades\Storage; ?>
                <iframe src="{{ Storage::url('public/materis/'.$materis->link) }}" frameborder="0" style="width: 100%; height: 100%;"></frame>

                </div>
            </div>
    </section>
</div>

@stop