// Znajdź kontener galerii i pasek wyszukiwania
const galleryContainer = document.querySelector('.gallery-container');
const searchBar = document.querySelector('.search-bar');

// Funkcja pobierająca dane galerii z serwera
let allGalleries = []; // Przechowywanie wszystkich galerii w pamięci
async function fetchGalleries() {
    try {
        const response = await fetch('/api/galleries'); // Wykonanie żądania GET
        if (!response.ok) {
            throw new Error('Błąd podczas pobierania galerii');
        }
        allGalleries = await response.json(); // Oczekiwanie na odpowiedź w formacie JSON
        renderGalleries(allGalleries); // Wywołanie funkcji renderującej
    } catch (error) {
        console.error('Błąd:', error);
        galleryContainer.innerHTML = error;
    }
}

// Funkcja renderująca galerie w kontenerze
function renderGalleries(galleries) {
    galleryContainer.innerHTML = ''; // Wyczyść zawartość kontenera
    galleries.forEach(gallery => {
        // Tworzenie elementu kwadratu
        const square = document.createElement('div');
        const title = document.createElement('p');
        const image = document.createElement('img');
        square.className = 'gallery-box';

        title.textContent = gallery.name;
        image.src = "img/placeholder.bmp";
        image.className = 'gallery-image';
        square.appendChild(image);
        square.appendChild(title);
        square.dataset.name = gallery.name.toLowerCase(); // Dodaj dane z nazwą galerii
        square.addEventListener('click', () => {
            window.location.href = "gallery/" + gallery.id;
        });

        // Dodanie kwadratu do kontenera
        galleryContainer.appendChild(square);
    });
}

// Funkcja obsługująca wyszukiwanie
function filterGalleries() {

    const searchText = searchBar.value.toLowerCase(); // Pobierz tekst z paska wyszukiwania
    const galleryBoxes = document.querySelectorAll('.gallery-box'); // Znajdź wszystkie galerie
    galleryBoxes.forEach(box => {
        if (box.dataset.name.includes(searchText)) {
            box.style.display = ''; // Pokaż element
        } else {
            box.style.display = 'none'; // Ukryj element
        }
    });
}


// Obsługa wpisywania w polu wyszukiwania
searchBar.addEventListener('input', filterGalleries);
  
// Wywołanie funkcji pobierającej dane
fetchGalleries();
