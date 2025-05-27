<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fournisseurs', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom du fournisseur
            $table->string('email')->nullable(); // Email facultatif
            $table->string('telephone'); // Téléphone
            $table->string('adresse'); // Adresse
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fournisseurs');
    }
}; 