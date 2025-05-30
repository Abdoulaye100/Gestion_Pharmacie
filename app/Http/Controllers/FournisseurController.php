<?php

namespace App\Http\Controllers;

use App\Models\Fournisseur;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    public function index(Request $request)
    {
        $query = Fournisseur::query();
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%$q%")
                    ->orWhere('email', 'like', "%$q%")
                    ->orWhere('telephone', 'like', "%$q%")
                    ->orWhere('adresse', 'like', "%$q%")
                ;
            });
        }
        $fournisseurs = $query->orderByDesc('created_at')->get();
        if ($request->ajax()) {
            return view('admin.partials.fournisseurs_tbody', compact('fournisseurs'))->render();
        }
        return view('admin.fournisseurs', compact('fournisseurs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:50',
            'adresse' => 'required|string|max:255',
        ]);
        $fournisseur = Fournisseur::create($validated);
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Fournisseur ajouté avec succès !',
                'fournisseur' => $fournisseur
            ]);
        }
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur ajouté avec succès !');
    }

    public function update(Request $request, Fournisseur $fournisseur)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'telephone' => 'required|string|max:50',
            'adresse' => 'required|string|max:255',
        ]);
        $fournisseur->update($validated);
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Fournisseur modifié avec succès !',
                'fournisseur' => $fournisseur
            ]);
        }
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur modifié avec succès !');
    }

    public function destroy(Fournisseur $fournisseur)
    {
        $fournisseur->delete();
        if (request()->ajax()) {
            return response()->json([
                'message' => 'Fournisseur supprimé avec succès !'
            ]);
        }
        return redirect()->route('fournisseurs.index')->with('success', 'Fournisseur supprimé avec succès !');
    }
} 