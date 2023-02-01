<?php

declare (strict_types = 1);

use App\Enums\QuestionType;
use App\Models\Survey;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Survey::class, 'survey_id');
            $table->integer('position');
            $table->text('content');
            $table->enum('type', [
                QuestionType::SINGLE_CHOICE->value,
                QuestionType::MULTIPLE_CHOICE->value,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('questions');
    }
};
