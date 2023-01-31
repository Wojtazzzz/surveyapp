<?php

declare (strict_types = 1);

namespace App\Models;

use App\Enums\QuestionType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
