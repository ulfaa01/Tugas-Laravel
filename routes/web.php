<?php

use Illuminate\Support\Facades\Route;
use App\Models\Book;
use App\Models\Member;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Loan;

Route::get('/', function () {
    $books = Book::with(['author', 'publisher'])->get();
    $members = Member::all();
    $authorsCount = Author::count();
    $loans = Loan::with(['member', 'book'])->get();

    return view('dashboard', compact('books', 'members', 'authorsCount', 'loans'));
});

Route::get('/api/books', function () {
    return response()->json(Book::with(['author', 'publisher'])->get());
});

Route::get('/api/loans', function () {
    return response()->json(Loan::with(['member', 'book'])->get());
});
