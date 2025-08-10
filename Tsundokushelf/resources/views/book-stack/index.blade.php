<x-app-layout>
  <div class="flex flex-col min-h-screen bg-yellow-50">
    <div class="flex justify-center gap-6 my-6">
        <a href="{{ route('book.stack', ['view' => 'all']) }}"
           class="px-4 py-2 rounded {{ request('view') === 'all' || !request('view') ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-gray-500' }}">
            すべて
        </a>
        <a href="{{ route('book.stack', ['view' => 'read']) }}"
           class="px-4 py-2 rounded {{ request('view') === 'read' ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-gray-500' }}">
            読了
        </a>
        <a href="{{ route('book.stack', ['view' => 'unread']) }}"
           class="px-4 py-2 rounded {{ request('view') === 'unread' ? 'bg-yellow-500 text-white' : 'bg-yellow-50 text-gray-500' }}">
            積読
        </a>
    </div>

    @if ($books->isEmpty())
      <p class="text-gray-500 text-lg mt-10 text-center min-h-screen">まだこの棚に本はありません。</p>
    @else
      <main class="flex-grow flex flex-col items-center">
  <div class="space-y-10 mt-2">
    @foreach ($books->chunk(15)->reverse() as $chunk)
      @php
        $colors = [  '#D38A53', '#C6797B', '#D9A44D', '#DB9686', '#C09A91', '#B98B5D', '#D4A671', '#CC6E6D',
    '#8B9C75', '#A3B29B', '#84986F', '#678788', '#9CAF84', '#8FAABF'];
        shuffle($colors);
      @endphp

      <div class="relative flex gap-[4px] justify-start items-end pb-2">
        @foreach ($chunk as $index => $book)
          <a href="{{ route('books.edit', $book) }}"
             class="fall-in transform transition duration-300 ease-in-out hover:scale-110"
             style="
                 animation-delay: {{ $loop->iteration * 0.05 }}s;
                 writing-mode: vertical-rl;
                 background-color: {{ $colors[$index % count($colors)] }};
                 height: {{ rand(100, 160) }}px;
                 width: {{ rand(30, 50) }}px;
                 font-size: 12px;
                 color: white;
                 border-radius: 4px;
                 display: flex;
                 align-items: center;
                 justify-content: center;
                 text-align: center;
                 padding: 4px;
             ">
              {{ Str::limit($book->title, 20) }}
          </a>
        @endforeach

        <!-- 棚板 -->
        <div class="absolute bottom-0 left-0 -translate-x-8 w-[calc(100%+4rem)] h-2 bg-yellow-700 rounded-full shadow-md"></div>
      </div>
    @endforeach
  </div>
</main>

    @endif

    <footer class="mt-10">
      @include('layouts.footer')
    </footer>
  </div>
</x-app-layout>
