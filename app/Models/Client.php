<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory; 

    protected $fillable = ['name', 'table_id', 'bill', 'status',];

    public function rules() {
        return [
            "name" => "required|min:3|max:30|unique:clients,name,$this->id",
            "table_id" => "required",
            "bill" => "required",
            "status" => "required",
        ];
    }

    public function feedback() {
        return [
            "required" => "O campo :attribute é obrigatório",
            "name.min" => "O campo nome deve ter no mínimo 3 caracteres",
            "name.max" => "O campo nome deve ter no máximo 30 caracteres",
            "name.unique" => "O nome selecionado já está sendo utilizado",
            "description.min" => "O campo descrição deve ter no mínimo 3 caracteres",
            "description.max" => "O campo descrição deve ter no máximo 100 caracteres",
            "image.mines" => "O arquivo precisa ser uma imagem do tipo PNG, JPG, JPEG ou SVG"
        ];
    }

    public function order() {
        return this->hasMany('App\Models\Order');
    }

    public function table() {
        return this->hasOne('App\Models\Table');
    }
}
