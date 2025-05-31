<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User; // N'oubliez pas d'importer le modèle User
use Illuminate\Support\Facades\Hash; // Importez la façade Hash
use Illuminate\Support\Facades\Log; // Importez la façade Log
use Illuminate\Validation\ValidationException; // Importez ValidationException

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all(); // Récupère tous les utilisateurs de la base de données

        // Log pour vérifier le contenu de $users
        Log::info('Utilisateurs récupérés pour la page index', ['count' => $users->count(), 'users_data' => $users->toArray()]);

        return view('admin.utilisateurs', compact('users')); // Passe les utilisateurs à la vue
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Log::info('Début de la création d\'un nouvel utilisateur', ['request_data' => $request->all()]);

        try {
            // Valider les données de la requête
            $validatedData = $request->validate([
                'nom' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
                'role' => 'required|in:admin,vendeur', // Assurez-vous que le rôle est valide
            ]);

            // Log::info('Données utilisateur validées', ['validated_data' => $validatedData]);

            // Créer le nouvel utilisateur
            $user = User::create([
                'name' => $validatedData['nom'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => $validatedData['role'],
            ]);

             // Log::info('Utilisateur créé avec succès', ['user_id' => $user->id]);

            // Réponse pour les requêtes AJAX (ou JSON)
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'message' => 'Utilisateur ajouté avec succès !',
                    'user' => $user
                ], 201); // 201 Created
            }

            // Rediriger en cas de soumission de formulaire classique
            return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur ajouté avec succès !');

        } catch (ValidationException $e) {
            // Log::error('Erreur de validation lors de la création d\'utilisateur', [
            //     'errors' => $e->errors(),
            //     'request_data' => $request->all()
            // ]);

            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Erreur de validation.',
                     'errors' => $e->errors()
                 ], 422); // 422 Unprocessable Entity
            }

             return redirect()->back()->withErrors($e->errors())->withInput();

        } catch (\Exception $e) {
            // Log::error('Erreur lors de la création d\'utilisateur', [
            //     'error' => $e->getMessage(),
            //     'trace' => $e->getTraceAsString(),
            //     'request_data' => $request->all()
            // ]);

             if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Une erreur est survenue lors de la création de l\'utilisateur.',
                     'error' => $e->getMessage()
                 ], 500); // 500 Internal Server Error
             }

            return redirect()->back()->with('error', 'Une erreur est survenue lors de la création de l\'utilisateur.');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $utilisateur)
    {
        // Validation des données
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $utilisateur->id, // Ignore current user's email
            'role' => 'required|in:admin,vendeur',
            // Ajoutez la validation du mot de passe si vous l'incluez dans le modal de modification
            // 'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Mise à jour de l'utilisateur
        $utilisateur->name = $validatedData['nom'];
        $utilisateur->email = $validatedData['email'];
        $utilisateur->role = $validatedData['role'];

        // Gérez la mise à jour du mot de passe si le champ est présent et non vide
        // if (isset($validatedData['password']) && !empty($validatedData['password'])) {
        //     $utilisateur->password = Hash::make($validatedData['password']);
        // }

        $utilisateur->save();

        // Réponse JSON pour AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Utilisateur modifié avec succès !',
                'user' => $utilisateur // Retourne l'utilisateur modifié
            ]);
        }

        // Redirection pour soumission classique
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur modifié avec succès !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, User $utilisateur)
    {
         // Vérification pour ne pas supprimer l'utilisateur admin principal (ajustez selon votre logique d'autorisation)
        if ($utilisateur->role === 'admin') {
            if ($request->ajax() || $request->wantsJson()) {
                 return response()->json([
                     'message' => 'Impossible de supprimer l\'administrateur principal.'
                 ], 403); // 403 Forbidden
            }
             return redirect()->back()->with('error', 'Impossible de supprimer l\'administrateur principal.');
        }

        $utilisateur->delete();

        // Réponse JSON pour AJAX
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'message' => 'Utilisateur supprimé avec succès !',
                'user_id' => $utilisateur->id
            ]);
        }

        // Redirection pour soumission classique
        return redirect()->route('admin.utilisateurs.index')->with('success', 'Utilisateur supprimé avec succès !');
    }

    // Vous pouvez ajouter les méthodes show, edit plus tard
}
