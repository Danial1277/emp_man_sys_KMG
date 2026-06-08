<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    // Связь: У компании может быть много сотрудников
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

    // Связь: У компании может быть много скважин
    public function wells()
    {
        return $this->hasMany(Well::class);
    }
}