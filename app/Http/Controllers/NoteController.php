<?php

namespace App\Http\Controllers;

use App\Http\Resources\NoteResource;
use App\Models\Note;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class NoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $notes = Auth::user()->notes()->orderByDesc('id')->paginate(15, ['id', 'note', 'detail', 'created_at']);
        return Response::json([
            'notes' => NoteResource::collection($notes),
            'total' => ceil($notes->total() / 15)
        ]);
    }

    public function store(Request $request)
    {
        $data = $this->validate($request, [
            'note' => 'required|min:2|max:255',
            'detail' => ''
        ]);

        $note = Auth::user()->notes()->create($data);
        return Response::json([
            'message' => 'Record added successfully!',
            'note' => new NoteResource($note)
        ]);
    }

    public function show(Note $note)
    {
        return Response::json([
            'note' => new NoteResource($note)
        ]);
    }

    public function update(Request $request, Note $note)
    {
        $this->checkAuthority($note);

        $data = $this->validate($request, [
            'note' => 'required|min:2|max:255',
            'detail' => ''
        ]);

        $note->update($data);
        return Response::json([
            'message' => 'Record updated successfully!'
        ]);
    }

    public function destroy(Note $note)
    {
        $this->checkAuthority($note);

        try {
            $note->delete();
            $msg = 'Record deleted successfully!';
        } catch (Exception $e) {
            $msg = 'Something went wrong!';
        }

        return Response::json([
            'message' => $msg
        ]);
    }

    private function checkAuthority(Note $note) {
        if ($note->getOriginal('user_id') !== Auth::user()->id) {
            return Response::json([
                'message' => 'You do not have permission!'
            ]);
        }
    }
}
