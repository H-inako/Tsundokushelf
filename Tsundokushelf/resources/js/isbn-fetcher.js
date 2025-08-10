const isbnInput = document.getElementById('isbn');
const titleInput = document.getElementById('title');
const authorInput = document.getElementById('author');
const coverUrlInput = document.getElementById('cover-url');
const container = document.getElementById('cover-preview-container');
const preview = document.getElementById('cover-preview');

if (isbnInput) {
    isbnInput.addEventListener('input', async function () {
        const isbn = this.value.trim();
        if (isbn.length !== 10 && isbn.length !== 13) return;

        try {
            const res = await fetch(`/api/book-info?isbn=${isbn}`);
            if (!res.ok) return;
            const data = await res.json();

            if (data.title) titleInput.value = data.title;
            if (data.author) authorInput.value = data.author;

            // いったんクリア
            preview.src = '';
            preview.style.display = 'none';
            coverUrlInput.value = '';

            if (data.cover_url) {
                preview.src = data.cover_url;
                preview.style.display = 'block';
                coverUrlInput.value = data.cover_url;
                container.classList.remove('hidden');
            } else {
                container.classList.add('hidden');
            }

        } catch (e) {
            console.error('ISBN検索エラー:', e);
        }
    });
}
