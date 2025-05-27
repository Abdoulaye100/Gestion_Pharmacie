<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventes_medicament', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->unsignedBigInteger('vente_id'); // Référence à la vente
            $table->unsignedBigInteger('medicament_id'); // Référence au médicament
            $table->integer('quantite'); // Quantité vendue
            $table->decimal('prix_unitaire', 10, 2); // Prix unitaire au moment de la vente
            $table->timestamps(); // created_at & updated_at

            // Clés étrangères
            $table->foreign('vente_id')->references('id')->on('ventes')->onDelete('cascade');
            $table->foreign('medicament_id')->references('id')->on('medicaments')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes_medicament');
    }
}; 