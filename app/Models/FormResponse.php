<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FormResponse extends Model
{
    use HasFactory;

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function form() : BelongsTo
    {
        return $this->belongsTo(Form::class);
    }

    public function answers() : HasMany
    {
        return $this->hasMany(FormResponseAnswer::class);
    }
}
