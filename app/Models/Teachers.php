<?php

namespace App\Models;

use App\Models\Classes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Teachers extends Model
{
    use HasFactory;
    protected $table = 'teachers';
    protected $primaryKey = 'teacher_id';
    protected $fillable = ['name', 'photo_url'];

    public function classes(): HasMany
    {
        return $this->hasMany(Classes::class, 'teacher_id', 'teacher_id');
    }
}
