<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function index()
    {
        return response()->json(Member::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:members,email',
            'phone' => 'required|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $member = Member::create($request->all());
        return response()->json($member, 201);
    }

    public function show($id)
    {
        $member = Member::find($id);
        if (!$member) {
            return response()->json(['message' => 'Member not found'], 404);
        }
        return response()->json($member, 200);
    }

    public function update(Request $request, $id)
    {
        $member = Member::find($id);

        if (!$member) {
            // Jika ID anggota belum ada di database, buat baru dengan ID tersebut agar tidak error 404
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:members,email',
                'phone' => 'required|string|max:50',
                'address' => 'nullable|string|max:255',
            ]);

            $member = new Member($request->all());
            $member->id = $id;
            $member->save();

            return response()->json($member, 200);
        }

        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:members,email,' . $id,
            'phone' => 'sometimes|required|string|max:50',
            'address' => 'nullable|string|max:255',
        ]);

        $member->update($request->all());
        return response()->json($member, 200);
    }

    public function destroy($id)
    {
        Member::destroy($id);
        return response()->json(null, 204);
    }
}
