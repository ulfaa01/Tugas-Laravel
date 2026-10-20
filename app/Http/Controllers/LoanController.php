<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use Illuminate\Http\Request;

class LoanController extends Controller
{
    public function index()
    {
        return response()->json(Loan::with(['member', 'book'])->get(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
            'loan_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        $loan = Loan::create($request->all());
        return response()->json($loan->load(['member', 'book']), 201);
    }

    public function show($id)
    {
        $loan = Loan::with(['member', 'book'])->findOrFail($id);
        return response()->json($loan, 200);
    }

    public function update(Request $request, $id)
    {
        $loan = Loan::findOrFail($id);
        $request->validate([
            'member_id' => 'sometimes|required|exists:members,id',
            'book_id' => 'sometimes|required|exists:books,id',
            'loan_date' => 'sometimes|required|date',
            'return_date' => 'nullable|date',
        ]);

        $loan->update($request->all());
        return response()->json($loan->load(['member', 'book']), 200);
    }

    public function destroy($id)
    {
        Loan::destroy($id);
        return response()->json(null, 204);
    }
}
