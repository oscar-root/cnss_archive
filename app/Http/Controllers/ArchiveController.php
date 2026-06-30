<?php

namespace App\Http\Controllers;

use App\Models\Archive;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ArchiveController extends Controller
{
    /**
     * Tâche COMMUNE : Liste des archives filtrée par rôle et recherche.
     * Respecte l'étanchéité des données et le workflow métier.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $query = Archive::query();

        // 1. Restriction de visibilité par Rôle
        if ($user->isSecretaire()) {
            // Le secrétaire voit ses propres documents.
            // Tri : On met les dossiers rejetés ou signés (à classer) en haut de liste
            $query->where('user_id', $user->id)
                  ->orderByRaw("FIELD(status, 'signe_directeur', 'rejete', 'en_attente', 'valide_chef', 'classe') ASC");
        } elseif ($user->isChefDeService()) {
            // Le Chef voit ce qui attend son expertise
            $query->whereIn('status', ['en_attente', 'valide_chef', 'rejete']);
        } elseif ($user->isDirecteur()) {
            // Le Directeur voit les dossiers validés par le chef et ceux qu'il a déjà signés
            $query->whereIn('status', ['valide_chef', 'signe_directeur']);
        } elseif ($user->isAdmin()) {
            // L'Admin voit absolument tout pour la gestion globale
            $query->withTrashed(); // Optionnel : si vous utilisez SoftDeletes
        }

        // 2. Moteur de Recherche (Intitulé, Projet, Référence)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('intitule', 'like', '%' . $request->search . '%')
                  ->orWhere('projet', 'like', '%' . $request->search . '%')
                  ->orWhere('reference', 'like', '%' . $request->search . '%');
            });
        }

        // 3. Filtre par statut spécifique
        if ($request->filled('filter_status')) {
            $query->where('status', $request->filter_status);
        }

        $archives = $query->latest()->get();
        return view('archives.index', compact('archives'));
    }

    /**
     * Tâche COMMUNE : Visualisation du document (Show)
     */
    public function show(Archive $archive): View
    {
        return view('archives.show', compact('archive'));
    }

    /**
     * Tâche SECRETAIRE : Formulaire de constitution
     */
    public function create(): View
    {
        return view('archives.create');
    }

    /**
     * Tâche SECRETAIRE : Enregistrement de la nouvelle archive
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'intitule' => 'required|string|max:255',
            'projet' => 'required|string|max:255',
            'date_projet' => 'required|date',
            'fichier' => 'required|mimes:pdf,docx|max:10240', // 10Mo max
        ]);

        $path = $request->file('fichier')->store('archives_techniques', 'public');

        Archive::create([
            'intitule' => $request->intitule,
            'projet' => $request->projet,
            'date_projet' => $request->date_projet,
            'fichier_path' => $path,
            'user_id' => auth()->id(),
            'status' => 'en_attente',
        ]);

        return redirect()->route('archives.index')->with('success', 'Archive constituée et transmise au Chef de Service.');
    }

    /**
     * Tâche SECRETAIRE : Formulaire de correction (Edit)
     */
    public function edit(Archive $archive): View
    {
        // Sécurité : Seul le créateur peut éditer un document rejeté
        if ($archive->user_id !== auth()->id() || $archive->status !== 'rejete') {
            abort(403, 'Accès refusé : Ce document n\'est pas en état de correction.');
        }
        return view('archives.edit', compact('archive'));
    }

    /**
     * Tâche SECRETAIRE : Mise à jour et RENVOI (Update)
     */
    public function update(Request $request, Archive $archive): RedirectResponse
    {
        // Sécurité identique à edit
        if ($archive->user_id !== auth()->id() || $archive->status !== 'rejete') {
            abort(403);
        }

        $validated = $request->validate([
            'intitule' => 'required|string|max:255',
            'projet' => 'required|string|max:255',
            'fichier' => 'nullable|mimes:pdf,docx|max:80240', // Augmenté à 80Mo comme demandé
        ]);

        if ($request->hasFile('fichier')) {
            // Suppression de l'ancien fichier
            Storage::disk('public')->delete($archive->fichier_path);
            $archive->fichier_path = $request->file('fichier')->store('archives_techniques', 'public');
        }

        // RESET DU FLUX : Redevient "En attente" pour le Chef et effacement de l'erreur
        $archive->update([
            'intitule' => $validated['intitule'],
            'projet' => $validated['projet'],
            'status' => 'en_attente', 
            'commentaires_chef' => null 
        ]);

        return redirect()->route('archives.index')->with('success', 'Le rapport a été rectifié et renvoyé pour une nouvelle expertise.');
    }

    /**
     * Tâche CHEF DE SERVICE : Amendement (Validation ou Rejet)
     */
    public function validerChef(Request $request, Archive $archive): RedirectResponse
    {
        $request->validate([
            'action' => 'required|in:valider,rejeter',
            'commentaire' => 'required_if:action,rejeter|nullable|string|max:1000',
        ]);

        if ($request->action === 'valider') {
            $archive->update(['status' => 'valide_chef', 'commentaires_chef' => null]);
            $msg = "Archive validée et transmise pour Visa du Directeur.";
        } else {
            $archive->update(['status' => 'rejete', 'commentaires_chef' => $request->commentaire]);
            $msg = "Archive rejetée. Le secrétaire a été notifié pour correction.";
        }

        return redirect()->route('archives.index')->with('success', $msg);
    }

    public function signer(Archive $archive)
{
    $archive->status = 'signe_directeur';
    $archive->save(); // Force l'enregistrement réel

    return redirect()->route('archives.index')
        ->with('success', 'Visa accordé avec succès. Le dossier est transmis au Secrétaire pour classement final.');
}

    public function classer(Request $request, Archive $archive): RedirectResponse
    {
        $request->validate([
            'reference' => 'required|string|max:50|unique:archives,reference'
        ]);

        $archive->update([
            'reference' => $request->reference,
            'status' => 'classe'
        ]);

        return redirect()->route('archives.index')->with('success', 'Document classé définitivement (Réf : ' . $request->reference . ').');
    }

    /**
     * Tâche ADMIN : Suppression définitive
     */
    public function destroy(Archive $archive): RedirectResponse
    {
        if (!Auth::user()->isAdmin()) {
            abort(403);
        }

        // Supprimer le fichier physique
        Storage::disk('public')->delete($archive->fichier_path);
        
        // Supprimer l'entrée en base de données
        $archive->delete();

        return redirect()->route('archives.index')->with('success', 'L\'archive a été supprimée définitivement du système.');
    }
}