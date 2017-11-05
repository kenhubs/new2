<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    protected $table='ad';
    protected $primaryKey='ad_id';
    public $timestamps=false;
    protected $guarded=[];
}
