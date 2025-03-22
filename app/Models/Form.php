<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Form extends Model
{
    use HasFactory;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'published' => 'boolean',
        ];
    }

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function inputs() : HasMany
    {
        return $this->hasMany(FormInput::class);
    }

    public function responses() : HasMany
    {
        return $this->hasMany(FormResponse::class);
    }
}
