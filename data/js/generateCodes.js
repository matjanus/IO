async function generateCodes(id_course) {
    const numCodes = document.getElementById('numCodes').value;
    const output = document.getElementById('output');
    
    // Sprawdzenie poprawności liczby
    if (!numCodes || numCodes <= 0) {
        output.innerHTML = "Proszę wpisać poprawną liczbę.";
        return;
    }
    try {
        // Wysłanie żądania do serwera PHP
        const response = await fetch('/generateCodes?count=' + numCodes + "&id_course=" + id_course);
        if (!response.ok) {
            throw new Error('Błąd w komunikacji z serwerem');
        }
        
        // Odczyt odpowiedzi JSON
        const data = await response.json();
        console.log(data);
        if (data.codes) {
            // Wyświetlenie wygenerowanych kodów
            output.innerHTML =  
                data.codes.map(code => `${code}`).join('\n');
        } else {
            output.innerHTML = "Błąd: " + data.message;
        }
    } catch (error) {
        output.innerHTML = "Wystąpił błąd: " + error;
    }
}