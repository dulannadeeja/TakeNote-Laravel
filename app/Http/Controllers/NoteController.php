<?php

namespace App\Http\Controllers;

use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
//        $notesCollection = Note::where('user_id', auth()->id())->latest('updated_at')->paginate(5);
//        $notesCollection = auth()->user()->notes()->latest('updated_at')->paginate(5);
        $notesCollection = Note::whereBelongsTo(auth()->user())->latest('updated_at')->paginate(5);
        return view('notes.index', ['notes' => $notesCollection]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('notes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        // create a new note
        $note = new Note();
//        $note->fill([
//            'uuid' => Str::uuid(),
//            'user_id' => auth()->id(),
//            'title' => $request->title,
//            'body' => $request->body
//        ]);
//        $note->save();

        auth()->user()->notes()->create([
            'uuid' => Str::uuid(),
            'title' => $request->title,
            'body' => $request->body
        ]);


        // redirect to the index page
        return redirect()->route('notes.index')->with('success', 'Note created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request,Note $note)
    {
        if (!$note->user->is(auth()->user())) {
            abort(403);
        }

//        if (! Gate::allows('show-note', $note)) {
//            abort(403);
//        }

//        if ($request->user()->cannot('view', $note)) {
//            abort(403);
//        }

        return view('notes.show', ['note' => $note]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,Note $note)
    {
        if($request->user()->cannot('update', $note)) {
            abort(403);
        }

        return view('notes.edit', ['note' => $note]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Note $note)
    {
        if($request->user()->cannot('update', $note)) {
            abort(403);
        }

        // validate the request
        $request->validate([
            'title' => 'required|max:255',
            'body' => 'required'
        ]);

        // update the note
        $note->update([
            'title' => $request->title,
            'body' => $request->body
        ]);

        // redirect to the index page
        return redirect()->route('notes.show', ['note' => $note])->with('success', 'Note updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,Note $note)
    {
        if($request->user()->cannot('delete', $note)) {
            abort(403);
        }

        $note->delete();

        return redirect()->route('notes.index')->with('success', 'Note Moved to Trash successfully!');
    }
}
