<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;

class TrashController extends Controller
{
    public function index()
    {
        $notesCollection = Note::whereBelongsTo(auth()->user())->onlyTrashed()->latest('updated_at')->paginate(5);
        return view('notes.index', ['notes' => $notesCollection]);
    }

    public function show(Note $note)
    {
        if (\request()->user()->cannot('view', $note)) {
            abort(403);
        }

        return view('notes.show', ['note' => $note]);
    }

    public function restore(Note $note)
    {
        if (\request()->user()->cannot('restore', $note)) {
            abort(403);
        }

        $note->restore();

        return redirect()->route('trash.index')->with('success', 'Note restored successfully');
    }

    public function destroy(Note $note)
    {
        if (\request()->user()->cannot('forceDelete', $note)) {
            abort(403);
        }

        $note->forceDelete();

        return redirect()->route('trash.index')->with('success', 'Note deleted successfully');
    }
}
