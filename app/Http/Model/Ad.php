<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table='ad';
    protected $primaryKey='ad_id';
    public $timestamps=false;
    protected $guarded=[];
    public function cate(){
        return  $this->belongsTo("App\Http\Model\Category","ad_cate_id","cate_id");
    }
}
