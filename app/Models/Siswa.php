<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'kelas',
        'no_wa',
        'alamat',
        'nama_tentor',
    ];

    protected $table = 'siswas';

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function kelas(){
        return $this->belongsTo(Kelas::class);
    } 

}
