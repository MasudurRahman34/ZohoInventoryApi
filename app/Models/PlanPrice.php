<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class PlanPrice extends Model
{
    use HasFactory;
    protected $hidden = ['pivot'];
}
