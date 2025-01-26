<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('featured')->default(false);
            $table->timestamps();
        });

        Schema::create('project_project_type', function (Blueprint $table) {
            $table->tinyInteger('project_id')->constrained('projects','id')->onDelete('cascade'); // Ensures correct reference
            $table->foreignId('project_type_id')->constrained('project_types')->onDelete('cascade');
        });
        
        Schema::create('city_project', function (Blueprint $table) {
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
        Schema::dropIfExists('project_project_type');
        Schema::dropIfExists('city_project');
    }
};
