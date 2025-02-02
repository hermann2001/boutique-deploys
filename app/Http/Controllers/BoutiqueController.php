<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class BoutiqueController extends Controller
{
    public function viewCreateBoutique(Request $request): RedirectResponse|View
    {
        // Vérifier si aucun utilisateur n'est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $btqName = $request->query('btqName');

        if ($btqName) return view('create_boutique', ['successCreateBtq' => true, 'btqName' => $btqName]);

        return view('create_boutique');
    }

    public function createBoutique(Request $request)
    {
        // Vérifier si aucun utilisateur n'est connecté
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Validation des données
        $request->validate([
            'boutique_name' => 'required|string|max:255|unique:shops,name|bail',
        ]);

        $shop = Shop::create([
            'name' => $request->boutique_name,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('createBtq', ['btqName' => $shop->name]);
    }

    public function viewBoutique($btq): RedirectResponse|View
    {
        $boutique = Shop::where('name', $btq)->first();
        if (!$boutique) {
            abort(404);
        }

        $user = User::where('id', $boutique->user_id)->first();

        return view('boutique', [
            'name_btq' => $boutique->name,
            'name' => $user->name,
            'email' => $user->email,
            'age' => $user->age,
        ]);
    }
}
