<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    protected $fillable = ['number', 'waiter'];

    public function rules() {
        return [
            "number" => "required",
            "waiter" => "required",
        ];
    }

    public function feedback() {
        return [
            "required" => "O campo :attribute é obrigatório",
        ];
    }

    public function client() {
        return this->belongsTo('App\Models\Client');
    }
}
