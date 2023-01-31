<?php

declare (strict_types = 1);

namespace App\Models;

use App\Enums\SurveyStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'status',
    ];

    protected $casts = [
        'status' => SurveyStatus::class,
    ];

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }
}
