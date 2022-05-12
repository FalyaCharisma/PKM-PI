<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Diskusi extends Model
{
    use HasFactory;

    protected $fillable = ['user_id','materi', 'pertanyaan'];

    public function materi(){
        return $this->belongsTo(Materi::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function respon(){
        return $this->hasMany(Respon::class);
    }

}
 