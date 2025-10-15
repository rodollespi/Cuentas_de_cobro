<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Roles extends Model
{
    use HasFactory;

    protected $table = 'roles';

    protected $fillable = [
        'name',
        'description',
        'permissions'
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * Relación con usuarios - un rol tiene muchos usuarios
     * CORREGIR: especificar la clave foránea correcta
     */
    public function users()
    {
        return $this->hasMany(User::class, 'role_id', 'id');
    }
}