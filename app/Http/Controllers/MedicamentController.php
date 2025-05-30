<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class MedicamentController extends Controller
{
    public function index(Request $request)
    {
        $query = Medicament::with(['categorie', 'fournisseur']);

        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $medicaments = $query->orderByDesc('created_at')->get();
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();

        if ($request->ajax()) {
            return view('admin.partials.medicaments_tbody', compact('medicaments'))->render();
        }

        return view('admin.medicaments', compact('medicaments', 'categories', 'fournisseurs'));
    }

    public function store(Request $request)
    {
        // Log::info('Début de l\'ajout d\'un nouveau médicament', ['request_data' => $request->all()]);

        try {
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'prix_achat' => 'required|numeric',
                'prix_vente' => 'required|numeric',
                'quantite_stock' => 'required|integer',
                'date_expiration' => 'required|date',
                'categorie_id' => 'required|exists:categories,id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            ]);

            // Log::info('Données d\'ajout validées', ['validated_data' => $validated]);

            $medicament = Medicament::create($validated);

            // Log::info('Résultat de la création du médicament', [
            //     'success' => (bool) $medicament,
            //     'medicament_id' => $medicament->id ?? null
            // ]);

            // Réponse pour la requête AJAX
            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Médicament ajouté avec succès !',
                     'medicament' => $medicament // Retourne le médicament créé
                 ], 201); // Code 201 Created
            }

            // Redirection en cas de soumission de formulaire classique (non AJAX)
            return redirect()->route('admin.medicaments.index')->with('success', 'Médicament ajouté avec succès !');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Log::error('Erreur de validation lors de l\'ajout du médicament', [
            //     'errors' => $e->errors(),
            //     'request_data' => $request->all()
            // ]);

            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Erreur de validation.',
                     'errors' => $e->errors()
                 ], 422); // Code 422 Unprocessable Entity
            }

            return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Log::error('Erreur lors de l\'ajout du médicament', [
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            //     'request_data' => $request->all()
            // ]);

            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Erreur lors de l\'ajout du médicament.',
                     'error' => $e->getMessage()
                 ], 500); // Code 500 Internal Server Error
            }

            return redirect()->back()->with('error', 'Erreur lors de l\'ajout du médicament.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Medicament $medicament)
    {
        Log::info('Début de la modification du médicament', [
            'medicament_id' => $medicament->id,
            'request_data' => $request->all()
        ]);

        try {
            // Validation des données entrantes
            $validated = $request->validate([
                'nom' => 'required|string|max:255',
                'description' => 'nullable|string',
                'prix_achat' => 'required|numeric',
                'prix_vente' => 'required|numeric',
                'quantite_stock' => 'required|integer',
                'date_expiration' => 'required|date',
                'categorie_id' => 'required|exists:categories,id',
                'fournisseur_id' => 'nullable|exists:fournisseurs,id',
            ]);

            Log::info('Données validées', ['validated_data' => $validated]);

            // Mise à jour du médicament
            $updated = $medicament->update($validated);
            
            Log::info('Résultat de la mise à jour', [
                'success' => $updated,
                'medicament' => $medicament->fresh()->toArray()
            ]);

            // Réponse pour la requête AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Médicament modifié avec succès !',
                    'medicament' => $medicament->fresh(['categorie', 'fournisseur']) // Retourne le médicament fraîchement récupéré avec ses relations
                ]);
            }

            // Redirection en cas de soumission de formulaire classique (non AJAX)
            return redirect()->route('medicaments.index')->with('success', 'Médicament modifié avec succès !');

        } catch (\Exception $e) {
            Log::error('Erreur lors de la modification du médicament', [
                'medicament_id' => $medicament->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Erreur lors de la modification du médicament',
                    'error' => $e->getMessage()
                ], 500);
            }

            return redirect()->back()->with('error', 'Erreur lors de la modification du médicament');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Medicament $medicament)
    {
        $medicament->delete();

        // Réponse pour la requête AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Médicament supprimé avec succès !',
                'medicament_id' => $medicament->id
            ]); // Code 200 OK par défaut
        }

        // Redirection en cas de soumission de formulaire classique (non AJAX)
        return redirect()->route('medicaments.index')->with('success', 'Médicament supprimé avec succès !');
    }
} 