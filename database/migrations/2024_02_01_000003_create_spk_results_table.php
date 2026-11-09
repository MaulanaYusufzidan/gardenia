<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('spk_results', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('budget_input', 15, 2);
            $table->integer('area_input');
            $table->string('style_preference')->nullable();
            $table->integer('duration_pref')->nullable();
            $table->json('ranking_result');
            $table->foreignId('recommended_package_id')->nullable()->constrained('design_packages')->onDelete('set null');
            $table->timestamps();
        });
    }
    public function down(): void { Schema::dropIfExists('spk_results'); }
};
