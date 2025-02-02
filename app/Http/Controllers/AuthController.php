<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function viewLogin(Request $request): RedirectResponse|View
    {
        // Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            return redirect()->route('createBtq');
        }

        $success = $request->query('success', false);

        if ($success !== false) return view('login')->with('successMSG', "Votre compte est créé avec succès !");

        return view('login');
    }

    public function login(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|string|email|bail',
            'password' => 'required|string|bail',
        ]);

        // Tentative de connexion
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            // Authentification réussie
            return redirect()->route('createBtq');
        }

        // Authentification échouée
        return redirect()->back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function viewSignup(): RedirectResponse|View
    {
        // Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            return redirect()->route('createBtq');
        }

        return view('signup');
    }

    public function signup(Request $request)
    {
        // Validation des données
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|bail',
            'email' => 'required|string|email|max:255|unique:users|bail',
            'age' => 'required|numeric|min:1|bail',
            'password' => 'required|string|min:8|confirmed|bail',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Création d'un nouvel utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'age' => $request->age,
            'password' => Hash::make($request->password), // Hachage du mot de passe
        ]);

        // Envoyer l'email de bienvenue
        Mail::send('emails.welcome', ['name' => $user->name], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Bienvenue chez nous');
        });

        // Redirection vers la route de connexion
        return redirect()->route('login', ['success' => true]);
    }

    public function viewForgotPassword(): RedirectResponse|View
    {
        // Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            return redirect()->route('createBtq');
        }

        return view('forgotPassword');
    }

    public function forgotPassword(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|string|email|bail',
        ]);

        $user = User::where('email', $request->email)->first();

        // Vérifier si l'utilisateur n'existe pas
        if (!$user) {
            return redirect()->back()->withErrors(['emailForgot' => 'Email not found'])->withInput();
        }

        // Créer un token de réinitialisation
        $code = strtoupper(Str::random(6));

        $user->code_rein = $code;
        $user->code_rein_at = now();
        $user->save();

        // Envoyer l'email avec le lien de réinitialisation
        Mail::send('emails.reset_password', ['code' => $code], function ($message) use ($user) {
            $message->to($user->email);
            $message->subject('Password Reset Request');
        });

        return redirect()->route('resetpass', ['email' => $user->email]);
    }

    public function viewResetPassword(Request $request): RedirectResponse|View
    {
        // Vérifier si l'utilisateur est déjà connecté
        if (Auth::check()) {
            return redirect()->route('createBtq');
        }

        $email = $request->query('email');

        if (!isset($email)) return redirect()->route('forgotpass');

        return view('resetPassword', ['email' => $email]);
    }

    public function resetPassword(Request $request)
    {
        // Validation des données
        $request->validate([
            'email' => 'required|string|email|bail',
            'code_rein' => 'required|alpha_num|size:6|bail',
            'password' => 'required|string|min:8|confirmed|bail',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) return redirect()->back()->withErrors(['email' => "L'utilisateur n'existe pas"]);

        // Vérifier le code
        if ($user->code_rein === $request->code_rein) {
            $codeReinAt = Carbon::parse($user->code_rein_at);

            if ($codeReinAt->addMinutes(15) < now()) {
                // Si le code a expiré, le supprimer et rediriger avec une erreur
                $user->code_rein = null;
                $user->code_rein_at = null;
                return redirect()->back()->withErrors(['code_rein' => "Le code a expiré, veuillez reprendre le processus"]);
            }

            // Mettre le nouveau mot de passe, supprimer le code
            $user->password = Hash::make($request->password);
            $user->code_rein = null;
            $user->code_rein_at = null;
            $user->save();
        } else {
            return redirect()->back()->withErrors(['code_rein' => "Code incorrect !"]);
        }

        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
