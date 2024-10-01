<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipoPagamento extends Model
{
    public static function listagem(){
        return TipoPagamento::get();
    }
}
