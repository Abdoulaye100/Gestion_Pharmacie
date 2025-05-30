<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log; // Importer la façade Log

class CategorieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Categorie::query(); // Commence une nouvelle requête Eloquent

        // Gère la recherche si le paramètre 'q' est présent dans la requête
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $categories = $query->orderByDesc('created_at')->get(); // Exécute la requête et récupère les catégories triées

        // Si la requête est AJAX, retourne seulement la vue partielle du tableau
        if ($request->ajax()) {
            return view('admin.partials.categories_tbody', compact('categories'))->render();
        }

        // Sinon, retourne la vue principale avec toutes les données
        return view('admin.categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données entrantes
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Création de la nouvelle catégorie dans la base de données
        $categorie = Categorie::create($validated);

        // Réponse pour la requête AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Catégorie ajoutée avec succès !',
                'categorie' => $categorie // Vous pouvez retourner la catégorie ajoutée si nécessaire
            ], 201); // Code 201 pour Created
        }

        // Redirection en cas de soumission de formulaire classique (non AJAX)
        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès !');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categorie $category)
    {
        // Log::info('Début de la méthode update pour la catégorie ID:' . $category->id); // Log au début

        // 1. Validation des données entrantes
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Log::info('Données validées pour la catégorie ID ' . $category->id . ': ', $validated); // Log des données validées
        // Log::info('Catégorie avant update ID ' . $category->id . ': ', $category->toArray()); // Log de la catégorie avant

        // Log::info('Objet Categorie juste avant l\'update ID ' . $category->id . ': ', $category->toArray()); // NOUVEAU LOG (syntaxe corrigée)

        // 2. Mise à jour de la catégorie
        $updateSuccess = $category->update($validated);

        // Log::info('Résultat de la mise à jour pour la catégorie ID ' . $category->id . ': ' . ($updateSuccess ? 'Succès' : 'Échec')); // Log du résultat de l'update
        
        // Correction de la ligne de log pour éviter l'erreur "Array to string conversion"
        // if ($category) {
        //      Log::info('Catégorie après update ID ' . $category->id . ': ', $category->fresh() ? $category->fresh()->toArray() : 'NULL');
        // } else {
        //      Log::info('Catégorie après update: Objet modèle est NULL');
        // }
       

        // 3. Réponse pour la requête AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Catégorie modifiée avec succès !',
                // Retourne la catégorie fraîchement récupérée si possible, sinon null
                'categorie' => $category ? $category->fresh() : null
            ]);
        }

        // 4. Redirection en cas de soumission de formulaire classique (non AJAX)
        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Categorie $category)
    {
        // Log::info('Début de la méthode destroy pour la catégorie ID:' . $category->id); // Log au début

        // Suppression de la catégorie
        $deleteSuccess = $category->delete();

        // Log::info('Résultat de la suppression pour la catégorie ID ' . $category->id . ': ' . ($deleteSuccess ? 'Succès' : 'Échec')); // Log du résultat

        // Réponse pour la requête AJAX
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'message' => 'Catégorie supprimée avec succès !'
            ]);
        }

        // Redirection en cas de soumission de formulaire classique (non AJAX)
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
} 