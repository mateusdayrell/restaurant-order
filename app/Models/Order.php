<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'item_id', 'status', 'qtd', 'value'];

    public function rules() {
        return [
            "client_id" => "required",
            "item_id" => "required",
            "status" => "required",
            "qtd" => "required",
            "value" => "required",
        ]; 
    }

    public function feedback() {
        return [
            "required" => "O campo :attribute é obrigatório",
        ];
    }

    public function item() {
        return $this->hasOne('App\Models\Item', 'id', 'item_id');
        // hasOne('Class', 'class_fK', local_pk);
    }

    public function client() {
        return $this->belongsTo('App\Models\Client');
        // belongsTo('Class', 'local_fk', 'class_pk');
    }
}
