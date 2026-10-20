<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        return response()->json(Book::with(['author', 'publisher'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'required|exists:publishers,id',
        ]);

        $book = Book::create($request->all());
        return response()->json($book->load(['author', 'publisher']), 201);
    }

    public function show($id)
    {
        $book = Book::with(['author', 'publisher'])->findOrFail($id);
        return response()->json($book, 200);
    }

    public function update(Request $request, $id)
    {
        $book = Book::findOrFail($id);
        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'author_id' => 'sometimes|required|exists:authors,id',
            'publisher_id' => 'sometimes|required|exists:publishers,id',
        ]);

        $book->update($request->all());
        return response()->json($book->load(['author', 'publisher']), 200);
    }

    public function destroy($id)
    {
        Book::destroy($id);
        return response()->json(null, 204);
    }
}
