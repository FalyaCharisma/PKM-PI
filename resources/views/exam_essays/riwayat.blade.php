@extends('layouts.app')

@section('content')
<div class="main-content">
    <section class="section">
        @hasanyrole('teacher')
        <div class="section-header">
            <h1>Riwayat Ujian Esai</h1>
        </div>
 
        <div class="section-body">
  
            <div class="card">
                <div class="card-header">
                    <h4><i class="fas fa-exam"></i>{{ $exam_essay->name }}</h4>
                </div>

                <div class="card-body">
                    
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>NO</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">SCORE</th>
                                <th scope="col">LIHAT</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $count=1;
                            @endphp
                            @foreach ($exam_essay->users as $no => $exam_user)
                                <tr>   
                                    <td> {{ $count++ }}</td>         
                                    <td>{{ $users->getName($exam_user->pivot->user_id) }}</td>
                                    @if( $exam_user->pivot->score === null)
                                    <td>Belum Dikerjakan</td>
                                    @else
                                    <td>{{ $exam_user->pivot->score }}</td>
                                    @endif
                                    <td>
                                        <a href="{{ route('exam_essays.review', [$exam_user->pivot->user_id, $exam_essay->id]) }}"><i class="fa fa-eye"></i></a>
                                    </td>
                                  
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                       
                    </div>
                </div>
            </div>
   
        </div>
        @endhasanyrole
    </section>
</div>

@stop