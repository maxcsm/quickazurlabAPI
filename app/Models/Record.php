<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    use HasFactory;

protected $fillable = [
    'location_id','title', 'subtitle','ph', 'tac', 'th', 'clBr', 'ct', 'clib', 'cya', 'pht', 'cuiv', 'fer', 'salt', 'selreq', 'obser','temp','content','category',
     'image', 'image2', 'image3', 'image4','url','edited_by','view','project_id','type'
];






}
