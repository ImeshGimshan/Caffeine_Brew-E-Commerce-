document.addEventListener('DOMContentLoaded', () => {
    // Show coffee products by default
    filterProducts('coffee');
});

function filterProducts(category) {
    const productCards = document.querySelectorAll('.product-card');
    productCards.forEach(card => {
        if (card.dataset.category === category) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}





