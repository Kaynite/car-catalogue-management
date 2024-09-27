<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'make',
        'model',
        'year',
        'price',
        'description',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public function imageUrl(): Attribute
    {
        return Attribute::get(
            fn () => $this->image ? Storage::url($this->image) : null,
        );
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
