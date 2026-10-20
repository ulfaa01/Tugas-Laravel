<?php

namespace App\Http\Controllers;

use App\Models\Publisher;
use Illuminate\Http\Request;

class PublisherController extends Controller
{
    public function index()
    {
        return response()->json(Publisher::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $publisher = Publisher::create($request->all());
        return response()->json($publisher, 201);
    }

    public function show($id)
    {
        $publisher = Publisher::findOrFail($id);
        return response()->json($publisher, 200);
    }

    public function update(Request $request, $id)
    {
        $publisher = Publisher::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
        ]);

        $publisher->update($request->all());
        return response()->json($publisher, 200);
    }

    public function destroy($id)
    {
        Publisher::destroy($id);
        return response()->json(null, 204);
    }
}
