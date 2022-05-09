<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'type', 'price', 'description', 'avaliable', 'image'];

    public function rules() {
        return [
            "name" => "required|min:3|max:30|unique:items,name,$this->id",
            "type" => "required",
            "price" => "required",
            "description" => "min:3|max:100",
            "avaliable" => "required",
            "image" => "file|mimes:png,jpg,jpeg,svg"
        ];
    }

    public function feedback() {
        return [
            "required" => "O campo :attribute é obrigatório",
            "name.min" => "O campo nome deve ter no mínimo 3 caracteres",
            "name.max" => "O campo nome deve ter no máximo 30 caracteres",
            "description.min" => "O campo descrição deve ter no mínimo 3 caracteres",
            "description.max" => "O campo descrição deve ter no máximo 100 caracteres",
            "image.mines" => "O arquivo precisa ser uma imagem do tipo PNG, JPG, JPEG ou SVG"
        ];
    }

    public function order() {
        return this->belongsTo('App\Models\Order');
    }
}
