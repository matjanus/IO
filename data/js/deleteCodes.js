

async function deleteCodes(id_course) {


    if (!confirm('Czy na pewno chcesz usunąć kody?')) {
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

