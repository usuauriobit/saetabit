<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class LPSeccionHero extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'subtitle',
        'path_bg',
        'path_img',
        'nro_orden',
    ];

    public function getUrlBgAttribute(){
        return ($this->path_bg == null)
            ? asset('img/banner1.png')
            : asset(Storage::url($this->path_bg));
    }
    public function getUrlImgAttribute(){
        return ($this->path_img == null)
            ? asset('img/airplane.png')
            : asset(Storage::url($this->path_img));
    }
}
