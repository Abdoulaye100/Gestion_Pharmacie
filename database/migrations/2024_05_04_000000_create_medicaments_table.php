<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('medicaments', function (Blueprint $table) {
            $table->id(); // Identifiant unique
            $table->string('nom'); // Nom du médicament
            $table->text('description')->nullable(); // Détails facultatifs
            $table->decimal('prix_achat', 10, 2); // Prix d'achat unitaire
            $table->decimal('prix_vente', 10, 2); // Prix de vente unitaire
            $table->integer('quantite_stock'); // Quantité disponible en stock
            $table->date('date_expiration'); // Date de péremption
            $table->unsignedBigInteger('categorie_id'); // Clé étrangère vers categories
            $table->unsignedBigInteger('fournisseur_id')->nullable(); // Clé étrangère vers fournisseurs (optionnel)
            $table->timestamps(); // created_at & updated_at

            // Contraintes de clé étrangère
            $table->foreign('categorie_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('fournisseur_id')->references('id')->on('fournisseurs')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('medicaments');
    }
}; 