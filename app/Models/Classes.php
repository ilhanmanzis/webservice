<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Classes extends Model
{
    use HasFactory;
    protected $table = 'classes';
    protected $primaryKey = 'class_id';
    protected $fillable = ['teacher_id', 'category_id', 'title', 'thumbnail_url', 'description'];

    public function teachers(): BelongsTo
    {
        return $this->belongsTo(Teachers::class, 'teacher_id', 'teacher_id');
    }

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id', 'category_id');
    }
    public function materials(): HasMany
    {
        return $this->hasMany(Materials::class, 'class_id', 'class_id');
    }

    public function feedbacks(): HasMany
    {
        return $this->hasMany(Feedbacks::class, 'class_id', 'class_id');
    }

    // Relasi ke tabel enrollments
    public function enrollments()
    {
        return $this->hasMany(Enrollments::class, 'class_id', 'class_id');
    }

    // Relasi ke tabel users melalui enrollments
    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'class_id', 'user_id')
            ->withPivot('enrollment_id') // Optional, kalau ingin mengakses enrollment_id di relasi
            ->withTimestamps();
    }

    public function scopeFilterByTeacher($query, $teacherId)
    {
        if ($teacherId) {
            $query->whereHas('teachers', function ($q) use ($teacherId) {
                $q->where('teachers.teacher_id', $teacherId);
            });
        }
        return $query;
    }

    public function scopeFilterByCategory($query, $categoryId)
    {
        if ($categoryId) {
            $query->whereHas('categories', function ($q) use ($categoryId) {
                $q->where('categories.category_id', $categoryId);
            });
        }
        return $query;
    }
}
