<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $userId = Auth::id();
        $notes = Note::query()
            ->select('notes.*')
            ->join('users AS u', 'u.id', '=', 'notes.user_id')
            ->where('notes.user_id', $userId)
            ->latest()
            ->paginate(10);

        $notes = NoteResource::collection($notes);

        if ($request->wantsJson()) {
            return $notes;
        }

        return Inertia::render('Home', [
            'notes' => $notes,
        ]);
    }
}
