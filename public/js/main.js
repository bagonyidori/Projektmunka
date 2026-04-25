document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const notification = document.getElementById('notification');
    const logo = document.querySelector('.logo-class');
    const preloader = document.getElementById('preloader');

    const hidePreloader = () => {
        if (preloader) {
            preloader.classList.add('is-hidden');
        }
    };

    setTimeout(hidePreloader, 1000);

    let darkLogo = "";
    let lightLogo = "";

    let rnd = Math.floor(Math.random() * 10);

    if (rnd <= 2) {
        darkLogo = "/img/Critiqly_Logo.png";
        lightLogo = "/img/Critiqly_Logo_BW.png";
    } else if (rnd > 2 && rnd <= 4) {
        darkLogo = "/img/Critiqly_Logo2.png";
        lightLogo = "/img/Critiqly_Logo2_BW.png";
    } else if (rnd > 4 && rnd <= 6) {
        darkLogo = "/img/Critiqly_Logo3.png";
        lightLogo = "/img/Critiqly_Logo3_BW.png";
    } else if (rnd > 6 && rnd <= 8) {
        darkLogo = "/img/Critiqly_Logo4.png";
        lightLogo = "/img/Critiqly_Logo4_BW.png";
    } else {
        darkLogo = "/img/Critiqly_Logo5.png";
        lightLogo = "/img/Critiqly_Logo5_BW.png";
    }

    const updateLogo = () => {
        if (logo) {
            const targetSrc = body.classList.contains('light_mode') ? lightLogo : darkLogo;
            logo.onload = () => logo.classList.add('is_visible');
            logo.onerror = () => logo.classList.add('is_visible');
            logo.src = targetSrc;
            if (logo.complete) {
                logo.classList.add('is_visible');
            }
        }
    };

    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light_mode');
    } else {
        localStorage.setItem('theme', 'dark');
    }
    updateLogo();

    if (themeToggle) {
        themeToggle.addEventListener('click', () => {
            body.classList.toggle('light_mode');
            localStorage.setItem('theme', body.classList.contains('light_mode') ? 'light' : 'dark');
            updateLogo();
        });
    }

    const showNotification = (message) => {
        if (notification) {
            notification.textContent = message;
            notification.classList.add('is_visible');
            setTimeout(() => notification.classList.remove('is_visible'), 3000);
        }
    };

    const favBtn = document.getElementById('favBtn');

        if (favBtn) {
            favBtn.addEventListener('click', function(e) {
                if (this.classList.contains('guest-fav-btn')) {
                    e.preventDefault();
                    e.stopPropagation();
                    if (typeof showNotification === "function") {
                        showNotification('A kedvencekhez adáshoz jelentkezz be!');
                    }
                    return;
                }

                this.classList.toggle('is_active');
        
                const isActive = this.classList.contains('is_active');
                showNotification(isActive ? 'Hozzáadva!' : 'Eltávolítva.');

                if (isActive) {
                    this.innerHTML = `
                        <svg class="favBtn-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 21.23L4.22 13.45a5.5 5.5 0 0 1 7.78-7.78L12 5.67" />
                            <path d="M12 5.67l1.06-1.06a5.5 5.5 0 0 1 7.78 7.78L12 21.23" />
                            <path d="M12 5.67l-2 4 3 2-2 4" />
                        </svg>
                        Eltávolítás
                    `;
                } else {
                    this.innerHTML = `
                        <svg class="favBtn-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
                        </svg>
                        Kedvencekhez
                    `;
                }
            });
        }

    const shareBtn = document.getElementById('shareBtn');
    if (shareBtn) {
        shareBtn.addEventListener('click', () => {
            navigator.clipboard.writeText(window.location.href);
            showNotification('Link másolva!');
        });
    }

    const platformButtons = document.querySelectorAll('.platform_btn');
    platformButtons.forEach(btn => {
        const platform = btn.getAttribute('data-platform');
        const movieId = btn.getAttribute('data-movie-id');
        const storageKey = `voted_${movieId}_${platform}`;

        if (localStorage.getItem(storageKey)) {
            btn.classList.add('voted');
        }

        btn.addEventListener('click', () => {
        
            if (btn.classList.contains('guest-btn')) {
                if (typeof showNotification === "function") {
                    showNotification('A szavazáshoz kérjük, jelentkezz be!', 'warning');
                } else {
                    alert('A szavazáshoz bejelentkezés szükséges!');
                }
                return;
            }
        
            const isVoted = btn.classList.contains('voted');
         const action = isVoted ? 'down' : 'up';

            fetch(`/movies/${movieId}/vote/${platform}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ action: action })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const countSpan = btn.querySelector('.vote_count');
                    countSpan.innerText = data.new_count;

                    if (isVoted) {
                        btn.classList.remove('voted');
                        localStorage.removeItem(storageKey);
                        if(typeof showNotification === "function") showNotification('Szavazat visszavonva.');
                    } else {
                        btn.classList.add('voted');
                        localStorage.setItem(storageKey, "true");
                        if(typeof showNotification === "function") showNotification('Köszönjük a szavazatot!');
                    }
                }
            })
            .catch(err => console.error("Hiba történt:", err));
        });
    });    

    document.querySelectorAll('.filter_btn').forEach(button => {
        button.addEventListener('click', () => {
            document.querySelectorAll('.filter_btn').forEach(btn => btn.classList.remove('is_active'));
            button.classList.add('is_active');
        });
    });

    const swiperConfig = (next, prev) => ({
        slidesPerView: 'auto',
        spaceBetween: 15,
        centeredSlides: false,
        grabCursor: true,
        navigation: {
            nextEl: next,
            prevEl: prev,
        },
        breakpoints: {
            1024: { slidesPerView: 3, spaceBetween: 20 },
            1400: { slidesPerView: 4, spaceBetween: 25 }
        }
    });

    if (document.querySelector('.trending-swiper')) {
        new Swiper('.trending-swiper', swiperConfig('.trending-next', '.trending-prev'));
    }
    
    if (document.querySelector('.daily-swiper')) {
        new Swiper('.daily-swiper', swiperConfig('.daily-next', '.daily-prev'));
    }

    if (document.querySelector('.upcoming-swiper')) {
        new Swiper('.upcoming-swiper', swiperConfig('.upcoming-next', '.upcoming-prev'));
    }
});