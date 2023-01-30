<?php

namespace App\Enums;

enum SurveyStatus: string
{
    case EDITING = 'Editing';
    case TESTING = 'Testing';
    case READY = 'Ready';
}
