<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Feedbacks extends Model
{
    use HasFactory;
    protected $table = 'feedbacks';
    protected $primaryKey = 'feedback_id';
    protected $fillable = ['user_id', 'class_id', 'rating', 'comment'];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }
    public function users(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
