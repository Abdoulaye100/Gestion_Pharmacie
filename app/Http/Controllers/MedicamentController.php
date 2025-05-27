<?php

namespace App\Http\Controllers;

use App\Models\Medicament;
use Illuminate\Http\Request;

class MedicamentController extends Controller
{
    public function index()
    {
        $medicaments = Medicament::with(['categorie', 'fournisseur'])->get();
        return view('admin.medicaments', compact('medicaments'));
    }
} 