<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orders extends Model
{
    use HasFactory;
//    use SoftDeletes;
    protected $table = 'orders';

    protected $dates = ['deleted_at'];
}
