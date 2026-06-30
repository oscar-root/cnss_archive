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
    Schema::create('archives', function (Blueprint $table) {
        $table->id();
        $table->string('reference')->unique()->nullable();
        $table->string('intitule');
        $table->string('projet');
        $table->date('date_projet');
        $table->string('fichier_path');
        $table->enum('status', ['en_attente', 'rejete', 'valide_chef', 'signe_directeur', 'classe'])->default('en_attente');
        $table->text('commentaires_chef')->nullable();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->timestamps();
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archives');
    }
};
