<?php

declare (strict_types = 1);

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'position',
        'content',
        'type',
    ];

    protected $casts = [
        'type' => QuestionType::class,
    ];

    public function options(): HasMany
    {
        return $this->hasMany(Option::class);
    }
}
