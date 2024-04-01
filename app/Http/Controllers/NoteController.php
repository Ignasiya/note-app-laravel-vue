<?php

namespace App\Http\Controllers;

use App\Http\Requests\NoteRequest;
use App\Http\Requests\UpdateNoteRequest;
use App\Http\Resources\NoteResource;
use App\Models\Note;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class NoteController extends Controller
{
    public function view(Note $note)
    {
        return Inertia::render('Note/View', [
            'note' => new NoteResource($note)
        ]);
    }

    public function store(NoteRequest $request)
    {
        $data = $request->validated();
        if ($data['user_id'] == Auth::id()) {
            Note::create($data);
        }

        return back();
    }

    public function update(NoteRequest $request, Note $note)
    {
        $data = $request->validated();
        if ($note->isOwner(Auth::id())) {
            $note->update($data);

            return back();
        }
        return response('Отсутствует доступ для удаления заметки', 403);
    }

    public function destroy(Note $note)
    {
        if ($note->isOwner(Auth::id())) {
            $note->delete();

            return back();
        }
        return response('Отсутствует доступ для удаления заметки', 403);
    }
}
