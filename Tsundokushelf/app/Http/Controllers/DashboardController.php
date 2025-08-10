<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
     public function index(Request $request)
    {
        $query = $request->user()->books();

        if ($request->filled('keyword')) {
            $keyword = $request->keyword;
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('author', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('status')) {
            $query->whereIn('status', $request->status);
        }


        switch ($request->sort) {
                case 'created_at_asc':
                    $query->orderBy('created_at', 'asc');
                    break;
                case 'created_at_desc':
                    $query->orderBy('created_at', 'desc');
                    break;
                case 'finished_at_asc':
                    $query->orderBy('finished_at', 'asc');
                    break;
                case 'finished_at_desc':
                    $query->orderBy('finished_at', 'desc');
                    break;
                default:
                    $query->latest();
                    break;
                }
        $books = $query->paginate(5)->withQueryString(); 

        return view('dashboard', compact('books'));

    }
}
