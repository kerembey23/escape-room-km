// Starttijd in seconden (bijv. 30 minuten = 1800 seconden)
let timeLeft = 1800; 
const timerDisplay = document.getElementById('timer');

function updateTimer() {
    let minutes = Math.floor(timeLeft / 60);
    let seconds = timeLeft % 60;

    // Voeg een extra nulletje toe als het getal onder de 10 is
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;

    timerDisplay.textContent = `${minutes}:${seconds}`;

    if (timeLeft <= 0) {
        clearInterval(countdownInterval);
        // Tijd is op! Stuur door naar het verliesscherm
        saveTimeAndRedirect('00:00', 'lose.php');
    }
    timeLeft--;
}

// Elke seconde updaten
const countdownInterval = setInterval(updateTimer, 1000);

function saveTimeAndRedirect(finalTime, targetPage) {
    // Stuur de tijd via een POST-verzoek naar de server om op te slaan
    const formData = new FormData();
    formData.append('final_time', finalTime);

    fetch('save_time.php', {
        method: 'POST',
        body: formData
    }).then(() => {
        window.location.href = targetPage;
    });
}

// Deze functie roep je aan zodra de speler de laatste kamer succesvol verlaat
function teamEscaped() {
    clearInterval(countdownInterval);
    let minutes = Math.floor((1800 - timeLeft) / 60);
    let seconds = (1800 - timeLeft) % 60;
    let formattedTime = `${minutes < 10 ? '0' + minutes : minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    
    saveTimeAndRedirect(formattedTime, 'win.php');
}