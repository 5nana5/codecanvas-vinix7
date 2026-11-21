<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->string('question_type')->default('multiple_choice')->after('quiz_id');
            $table->string('option_a')->nullable()->change();
            $table->string('option_b')->nullable()->change();
            $table->string('option_c')->nullable()->change();
            $table->string('option_d')->nullable()->change();
            $table->text('correct_answer')->change();
        });
    }

    public function down(): void
    {
        Schema::table('questions', function (Blueprint $table) {
            $table->dropColumn('question_type');
        });
    }
};
