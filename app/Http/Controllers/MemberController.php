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
            'name' => 'required',
            'email' => 'required|email|unique:members',
            'phone' => 'required',
        ]);

        $member = Member::create($request->all());
        return response()->json($member, 201);
    }

    public function show($id)
    {
        $member = Member::findOrFail($id);
        return response()->json($member, 200);
    }

    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);
        $request->validate([
            'name' => 'sometimes|required',
            'email' => 'sometimes|required|email|unique:members,email,' . $id,
            'phone' => 'sometimes|required',
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
