// script.js
window.addEventListener("scroll", revealElements);

function revealElements() {
    const elements = document.querySelectorAll(".animate-text, .animate-image");
    elements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (elementTop < windowHeight - 100) {
            element.classList.add("revealed");
        } else {
            element.classList.remove("revealed");
        }
    });
}
