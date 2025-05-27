<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    public function index()
    {
        $medicaments = Medicament::with(['categorie', 'fournisseur'])->get();
        $categories = Categorie::all();
        $fournisseurs = Fournisseur::all();
        return view('admin.medicaments', compact('medicaments', 'categories', 'fournisseurs'));
    }

    public function store(Request $request)
    {
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
        Medicament::create($validated);
        return redirect()->route('medicaments')->with('success', 'Médicament ajouté avec succès !');
    }
} 