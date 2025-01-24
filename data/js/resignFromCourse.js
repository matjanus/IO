async function confirmDelete() {
    const result = await Swal.fire({
        title: 'Czy na pewno chcesz usunąć wszystkie kody kursu?',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Tak, usuń!',
        cancelButtonText: 'Anuluj',
    });
    return result.isConfirmed;
}

async function deleteCodes(id_course) {
    const userConfirmed = await confirmDelete(); // Czekamy na wynik potwierdzenia

    if (!userConfirmed) {
        return; 
    }
    const output = document.getElementById('output');
    
    try {
        const response = await fetch('/deleteCouresCodes?id_course=' + id_course);
        if (!response.ok) {
            throw new Error('Błąd w komunikacji z serwerem');
        }
        
        const data = await response.json();
        console.log(data);
        if (data.ans) {
            output.innerHTML =  data.ans;
        }
    } catch (error) {
        output.innerHTML = "Wystąpił błąd: " + error;
    }
}