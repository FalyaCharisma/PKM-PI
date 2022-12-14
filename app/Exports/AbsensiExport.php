<?php

namespace App\Exports;

use App\Models\Absensi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AbsensiExport implements FromView
{
    private $start_date, $end_date,$name;

    public function __construct($start_date, $end_date, $name) {
        $this->start_date = $start_date;
        $this->end_date = $end_date;
        $this->name = $name;
    }

    public function view(): View
    { 
        return view('absensi.absensi', [
           
            'absens'=> Absensi::whereBetween('created_at',[$this->start_date, $this->end_date])->where('name', [$this->name])->get()
        ]);
    }
}