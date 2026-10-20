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
