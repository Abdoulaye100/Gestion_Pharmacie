<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();
        
        if ($request->has('q')) {
            $search = $request->get('q');
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('role', 'like', "%{$search}%");
            });
        }
        
        $users = $query->get();
        
        if ($request->ajax()) {
            return response()->json([
                'html' => view('admin.partials.utilisateurs_tbody', compact('users'))->render()
            ]);
        }
        
        return view('admin.utilisateurs', compact('users'));
    }
} 