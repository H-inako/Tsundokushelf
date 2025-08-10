<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;
use App\Models\User;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('email', 'test@example.com')->first();

        if (!$user) {
            $this->command->error('User not found. Run UserSeeder first.');
            return;
        }

        $isbns = [
            '9784101010014', '9784167711305', '9784041019325', '9784087457275', '9784121023892',
            '9784532171603', '9784065187399', '9784022647570', '9784309028404', '9784344030039',
            '9784781617458', '9784004305860', '9784591168810', '9784334765152', '9784408538412',
            '9784837987752', '9784905158651', '9784815604140', '9784776212171', '9784575244997',
            '9784569765759', '9784828868824', '9784198656001', '9784396781062', '9784845637903',
            '9784797391824', '9784065210141', '9784864108613', '9784862556874', '9784480429814',
            '9784101357317', '9784309467500', '9784167900174', '9784781691571', '9784758446070',
            '9784797394863', '9784480432265', '9784163900505', '9784022519280', '9784041015556',
            '9784062768815', '9784334036818', '9784575238286', '9784098254332', '9784296000168',
            '9784776212058', '9784309418045', '9784334038713', '9784811320778', '9784532310231',
        ];

        foreach ($isbns as $isbn) {
            $res = Http::get('https://www.googleapis.com/books/v1/volumes', [
                'q' => 'isbn:' . $isbn,
                'key' => env('GOOGLE_BOOKS_API_KEY'),
            ]);

            $data = $res->json();
            if (!isset($data['items'][0]['volumeInfo'])) continue;

            $info = $data['items'][0]['volumeInfo'];

            $title = $info['title'] ?? 'No Title';
            $authors = implode(', ', $info['authors'] ?? ['Unknown']);
            $thumbnailUrl = $info['imageLinks']['thumbnail'] ?? null;

            $localImagePath = null;

            if ($thumbnailUrl) {
                try {
                    $imageContents = file_get_contents($thumbnailUrl);
                    $filename = 'covers/' . $isbn . '.jpg';
                    Storage::disk('public')->put($filename, $imageContents);
                    $localImagePath = 'storage/' . $filename;
                } catch (\Exception $e) {
                    $localImagePath = null;
                }
            }

            Book::updateOrCreate(
                ['isbn' => $isbn, 'user_id' => $user->id],
                [
                    'title' => $title,
                    'author' => $authors,
                    'cover_path' => $localImagePath, 
                ]
            );
        }
    }
}
