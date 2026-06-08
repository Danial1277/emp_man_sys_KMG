<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = ['company_id', 'first_name', 'last_name'];

    // Связь: Сотрудник работает в конкретной компании
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}