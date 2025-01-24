document.addEventListener("DOMContentLoaded", function () {
    // Znajdujemy element o klasie "message"
    const messageDiv = document.querySelector('.message');

    // Sprawdzamy, czy element istnieje
    if (messageDiv) {
        // Po 3 sekundach ustawiamy styl display na 'none'
        setTimeout(() => {
            messageDiv.style.display = 'none';
        }, 3000); 
    }
});