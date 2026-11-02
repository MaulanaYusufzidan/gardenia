<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('design_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('category')->default('Desain Rumah');
            $table->decimal('budget_min', 15, 2)->default(0);
            $table->decimal('budget_max', 15, 2)->default(0);
            $table->integer('area_min')->default(0);
            $table->integer('area_max')->default(0);
            $table->integer('duration_months');
            $table->decimal('feature_score', 4, 2)->default(5.00);
            $table->decimal('material_score', 4, 2)->default(5.00);
            $table->text('description')->nullable();
            $table->text('includes')->nullable();
            $table->string('image')->nullable();
            $table->decimal('price_start', 15, 2)->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('design_packages'); }
};
