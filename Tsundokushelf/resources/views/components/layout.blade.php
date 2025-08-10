<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'TsundokuShelf' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- ここにCSSやJSの読み込み -->
     @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <header>
        <h1></h1>
        <!-- ナビゲーションなど -->
        @include('layouts.navigation')
    </header>
    
    <main>
        {{ $slot }}
    </main>

    <footer>
        @include('layouts.footer')
    </footer>
</body>
</html><div>
    <!-- The biggest battle is the war against ignorance. - Mustafa Kemal Atatürk -->
</div>