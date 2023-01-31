<?php

namespace App\Enums;

enum QuestionType: string
{
    case SINGLE_CHOICE = 'Single choice';
    case MULTIPLE_CHOICE = 'Multiple choice';
}
