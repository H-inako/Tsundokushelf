<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Http;

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\Encoders\PngEncoder;
use Illuminate\Support\Facades\Storage;


class BookController extends Controller
{

        public function index()
    {
        $books = Book::with('user')
                ->where('is_public', true)
                ->inRandomOrder()
                ->take(5)
                ->get();

        $nextBook = null;
            if (auth()->check()) {
                $nextBook = auth()->user()->books()
                    ->whereIn('status', ['未読', '読書中'])
                    ->inRandomOrder()
                    ->first();
            }

        return view('books.index', compact('books', 'nextBook'));
    }
        public function create()
    {
        return view('books.create');
    }

       public function store(Request $request)
    {
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'author' => 'nullable|string|max:255',
        'format' => 'required|in:紙,電子',
        'status' => 'required|in:未読,読書中,読了',
        'isbn' => 'nullable|string',
        'notes' => 'nullable|string',
        'finished_at' => 'nullable|date',
        'cover' => 'nullable|image|max:2048',
        'cover_url' => 'nullable|url',
        'is_public' => 'nullable|boolean',
    ]);

    $validated['is_public'] = $request->boolean('is_public');

    $coverPath = null;

    if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('covers', 'public');
    } elseif ($request->filled('cover_url')) {
        $coverPath = $request->input('cover_url'); // 画像URLをそのまま保存
    }

    $request->user()->books()->create(array_merge($validated, [
        'cover_path' => $coverPath
    ]));

    return redirect()->route('books.create')->with('success', '本を登録しました！');
    }

    public function cover($id)
    {
        $book = \App\Models\Book::findOrFail($id);

        if ($book->cover_path && !str_starts_with($book->cover_path, 'http')) {
            return redirect(Storage::url($book->cover_path));
        }

        if ($book->cover_path && str_starts_with($book->cover_path, 'http')) {
            return redirect($book->cover_path);
        }
        
        $path = public_path('images/default_cover.png');
        
        if (!file_exists($path)) {
            logger("ファイルが存在しません: {$path}");
            abort(404);
        }
        
        $manager = new ImageManager(new Driver());
        $image = $manager->read(fopen($path, 'r'))
            ->resize(300, 400)
            ->text($book->title ?? 'タイトル未設定', 150, 200, function ($font) {
                $font->filename(public_path('fonts/KaiseiDecol-Regular.ttf'));
                $font->size(24);
                $font->color('#000');
                $font->align('center');
                $font->valign('center');
            });

        return response($image->encode(new PngEncoder()))
            ->header('Content-Type', 'image/png');
    }
    public function fetchFromIsbn(Request $request)
    {
        $isbn = $request->query('isbn');
        if (!$isbn) return response()->json([], 400);

        $res = Http::get('https://www.googleapis.com/books/v1/volumes', [
            'q' => 'isbn:' . $isbn,
            'printType' => 'books',
            'maxResults' => 1,
        ]);

        $book = $res->json()['items'][0]['volumeInfo'] ?? null;

        return response()->json([
            'title' => $book['title'] ?? '',
            'author' => $book['authors'][0] ?? '',
            'cover_url' => $book['imageLinks']['thumbnail'] ?? null,
        ]);
    }
//本の情報更新
public function edit(Book $book)
{
    if ($book->user_id !== auth()->id()) {
        abort(403, 'この本は編集できません。');
    }

    return view('books.edit', compact('book'));
}

public function update(Request $request, Book $book)
{
    if ($book->user_id !== auth()->id()) {
        abort(403, 'この本は編集できません。');
    }

    $validated = $request->validate([
        'status' => 'required|in:未読,読書中,読了',
        'notes' => 'nullable|string',
        'finished_at' => 'nullable|date',
        'cover' => 'nullable|image|max:2048',
        'is_public' => 'nullable|boolean',
    ]);

    $validated['is_public'] = $request->boolean('is_public');

    if ($request->hasFile('cover')) {
        $coverPath = $request->file('cover')->store('covers', 'public');
        $validated['cover_path'] = $coverPath;
    }

    $book->update($validated);

    return redirect()->route('dashboard')->with('success', '更新しました！');
}

public function destroy(Book $book)
{
    if ($book->user_id !== auth()->id()) {
        abort(403);
    }

    $book->delete();

    return redirect()->route('dashboard')->with('success', '本を削除しました');
}


}
