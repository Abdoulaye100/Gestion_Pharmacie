<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->unsignedBigInteger('utilisateur_id'); // Référence à l'utilisateur
            $table->dateTime('date_vente'); // Date et heure de la vente
            $table->decimal('total', 10, 2); // Total de la vente
            $table->timestamps(); // created_at & updated_at

            // Clé étrangère
            $table->foreign('utilisateur_id')->references('id')->on('utilisateurs')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
}; 