<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;

class BookStackController extends Controller
{
    public function index(Request $request)
    {
        $view = $request->get('view');

        if ($view === 'unread') {
            $books = $request->user()->books()
                        ->whereIn('status', ['未読', '読書中'])
                        ->orderBy('created_at', 'asc') 
                        ->get();
        } elseif ($view === 'read') {
            $books = $request->user()->books()
                        ->where('status', '読了')
                        ->orderBy('finished_at', 'asc') 
                        ->get();
        } else {
            $books = $request->user()->books()
                        ->orderBy('created_at', 'asc') 
                        ->get();
        }

        return view('book-stack.index', compact('books'));
        }
}
