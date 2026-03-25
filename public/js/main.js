document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const notification = document.getElementById('notification');

    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light_mode');
    } else {
        localStorage.setItem('theme', 'dark');
    }

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light_mode');
        localStorage.setItem('theme', body.classList.contains('light_mode') ? 'light' : 'dark');
    });

    const showNotification = (message) => {
        notification.textContent = message;
        notification.classList.add('is_visible');
        setTimeout(() => notification.classList.remove('is_visible'), 3000);
    };

    const favBtn = document.getElementById('favBtn');
    if (favBtn) {
        favBtn.addEventListener('click', () => {
            favBtn.classList.toggle('is_active');
            showNotification(favBtn.classList.contains('is_active') ? 'Hozzáadva!' : 'Eltávolítva.');
        });
    }

    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
        shareBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href);
            showNotification('Link másolva!');
        });
    }
});

const filterButtons = document.querySelectorAll('.chip');
    const movieCards = document.querySelectorAll('.movie_card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            filterButtons.forEach(btn => btn.classList.remove('is_active'));
            button.classList.add('is_active');

            const filterValue = button.getAttribute('data-filter');

            movieCards.forEach(card => {
                const cardGenre = card.getAttribute('data-genre');
                
                if (filterValue === 'all' || filterValue === cardGenre) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });