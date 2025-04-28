<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollments extends Model
{
    use HasFactory;
    protected $table = 'enrollments';
    protected $primaryKey = 'enrollment_id';
    protected $fillable = ['user_id', 'class_id'];
    // Relasi ke model User
    public function users()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke model Classes
    public function classes()
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }
}
