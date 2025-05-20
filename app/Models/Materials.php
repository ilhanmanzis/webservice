<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materials extends Model
{
    use HasFactory;
    protected $table = 'materials';
    protected $primaryKey = 'material_id';
    protected $fillable = ['class_id', 'title', 'description', 'video_url', 'external_url'];

    public function classes(): BelongsTo
    {
        return $this->belongsTo(Classes::class, 'class_id', 'class_id');
    }
}
