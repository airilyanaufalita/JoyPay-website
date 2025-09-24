<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KloterRule extends Model
{
    protected $table = 'kloter_rules';
    protected $fillable = ['kloter_id', 'rule_text'];
    public $timestamps = true;
}