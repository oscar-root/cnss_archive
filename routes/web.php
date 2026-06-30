<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Models\Archive;
use App\Models\User;
use Illuminate\Support\Facades\DB;


// --- 1. ACCÈS PUBLIC ---
Route::get('/', function () {
    return view('welcome');
});

// --- 2. ESPACE CONNECTÉ (DASHBOARD & PROFIL) ---
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard : Calcul des statistiques réelles pour chaque rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();
        $stats = [];
        
        if ($user->isSecretaire()) {
            $stats['crees'] = Archive::where('user_id', $user->id)->count();
            $stats['rejete'] = Archive::where('user_id', $user->id)->where('status', 'rejete')->count();
            $stats['classes'] = Archive::where('user_id', $user->id)->where('status', 'classe')->count();
            $stats['prets_a_classer'] = Archive::where('user_id', $user->id)->where('status', 'signe_directeur')->count();
        } 
        elseif ($user->isChefDeService()) {
            $stats['a_verifier'] = Archive::where('status', 'en_attente')->count();
            $stats['total'] = Archive::count();
        }
        elseif ($user->isDirecteur()) {
            $stats['a_signer'] = Archive::where('status', 'valide_chef')->count();
            $stats['signes'] = Archive::where('status', 'signe_directeur')->count();
        }
        elseif ($user->isAdmin()) {
            $stats['users'] = User::count();
            $stats['archives'] = Archive::count();
        }

        $recentActivities = Archive::latest()->take(5)->get();

        return view('dashboard', compact('stats', 'recentActivities'));
    })->name('dashboard');

    // Gestion du Profil (Identité Numérique)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- 3. REGISTRE DES ARCHIVES (Consultation Commune) ---
    Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');

    // --- 4. BLOC SECRÉTAIRE (Constitution & Rectification) ---
    // Note : On place /create AVANT /{archive} pour éviter les erreurs 404
    Route::middleware('role:secretaire')->group(function () {
        Route::get('/archives/create', [ArchiveController::class, 'create'])->name('archives.create');
        Route::post('/archives', [ArchiveController::class, 'store'])->name('archives.store');
        
        Route::get('/archives/{archive}/edit', [ArchiveController::class, 'edit'])->name('archives.edit');
        Route::put('/archives/{archive}', [ArchiveController::class, 'update'])->name('archives.update');
        
        Route::post('/archives/{archive}/classer', [ArchiveController::class, 'classer'])->name('archives.classer');
    });

    // --- 5. VISUALISATION (Détails du document - Commun aux validateurs) ---
    Route::get('/archives/{archive}', [ArchiveController::class, 'show'])->name('archives.show');

    // --- 6. BLOC CHEF DE SERVICE (Expertise Technique) ---
    Route::middleware('role:chef_de_service')->group(function () {
        Route::post('/archives/{archive}/valider-chef', [ArchiveController::class, 'validerChef'])->name('archives.validerChef');
    });

    // --- 7. BLOC DIRECTEUR (Visa & Signature) ---
    Route::middleware('role:directeur')->group(function () {
        Route::post('/archives/{archive}/signer', [ArchiveController::class, 'signer'])->name('archives.signer');
    });

    // --- 8. BLOC ADMIN (Gestion des Comptes & Nettoyage) ---
    Route::middleware('role:admin')->group(function () {
        // CRUD Complet Utilisateurs
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('users.destroy');
        
        // Suppression définitive d'un rapport technique
        Route::delete('/archives/{archive}', [ArchiveController::class, 'destroy'])->name('archives.destroy');
    });
});

require __DIR__.'/auth.php';