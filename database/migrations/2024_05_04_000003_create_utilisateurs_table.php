<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('utilisateurs', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom de l'utilisateur
            $table->string('email')->unique(); // Email unique
            $table->string('mot_de_passe'); // Mot de passe
            $table->enum('role', ['admin', 'vendeur'])->default('vendeur'); // Rôle
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('utilisateurs');
    }
}; 