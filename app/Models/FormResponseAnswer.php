<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FormResponseAnswer extends Model
{
    use HasFactory;

    public function response() : BelongsTo
    {
        return $this->belongsTo(FormResponse::class);
    }

    public function input() : BelongsTo
    {
        return $this->belongsTo(FormInput::class);
    }
}
