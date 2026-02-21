

// Basic Countdown Timer
let timer = document.getElementById('timer');
let countDownDate = new Date().getTime() + 24 * 60 * 60 * 1000; // 24 hours

let x = setInterval(function() {
    let now = new Date().getTime();
    let distance = countDownDate - now;

    let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    let seconds = Math.floor((distance % (1000 * 60)) / 1000);

    timer.innerHTML = hours + ":" + minutes + ":" + seconds;

    if (distance < 0) {
        clearInterval(x);
        timer.innerHTML = "EXPIRED";
    }
}, 1000);






// JavaScript function to perform the search
function performSearch(event) {
    event.preventDefault(); // Prevent form submission
    const query = document.querySelector('.search-input').value.trim();
    if (query) {
        // Example: Redirect to a search results page with the query
        window.location.href = `search-results.html?query=${encodeURIComponent(query)}`;
    } else {
        alert('Please enter a search term');
    }
}



