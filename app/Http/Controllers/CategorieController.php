<?php

namespace App\Http\Controllers;

use App\Models\Categorie;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    public function index(Request $request)
    {
        $query = Categorie::query();
        if ($request->filled('q')) {
            $q = $request->input('q');
            $query->where(function($sub) use ($q) {
                $sub->where('nom', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                ;
            });
        }
        $categories = $query->orderByDesc('created_at')->get();
        return view('admin.categories', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $categorie = Categorie::create($validated);
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Catégorie ajoutée avec succès !',
                'categorie' => $categorie
            ]);
        }
        return redirect()->route('categories.index')->with('success', 'Catégorie ajoutée avec succès !');
    }

    public function update(Request $request, Categorie $categorie)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        $categorie->update($validated);
        if ($request->ajax()) {
            return response()->json([
                'message' => 'Catégorie modifiée avec succès !',
                'categorie' => $categorie
            ]);
        }
        return redirect()->route('categories.index')->with('success', 'Catégorie modifiée avec succès !');
    }

    public function destroy(Categorie $categorie)
    {
        $categorie->delete();
        if (request()->ajax()) {
            return response()->json([
                'message' => 'Catégorie supprimée avec succès !'
            ]);
        }
        return redirect()->route('categories.index')->with('success', 'Catégorie supprimée avec succès !');
    }
} 