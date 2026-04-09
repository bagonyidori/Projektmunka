document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;
    const notification = document.getElementById('notification');
    const logo = document.querySelector('.logo-class');

    let darkLogo = "";
    let lightLogo = "";

    window.onload = (event) => {
        let rnd = Math.floor(Math.random() * 10);

        if(rnd <= 2){
            darkLogo = "/img/Critiqly_Logo.png";
            lightLogo = "/img/Critiqly_Logo_BW.png"
            updateLogo();
        }
        else if(rnd > 2 && rnd <= 4){
            darkLogo = "/img/Critiqly_Logo2.png";
            lightLogo = "/img/Critiqly_Logo2_BW.png"
            updateLogo();
        }
        else if(rnd > 4 && rnd <= 6){
            darkLogo = "/img/Critiqly_Logo3.png";
            lightLogo = "/img/Critiqly_Logo3_BW.png"
            updateLogo();
        }
        else if(rnd > 6 && rnd <= 8){
            darkLogo = "/img/Critiqly_Logo4.png";
            lightLogo = "/img/Critiqly_Logo4_BW.png"
            updateLogo();
        }
        else{
            darkLogo = "/img/Critiqly_Logo5.png";
            lightLogo = "/img/Critiqly_Logo5_BW.png"
            updateLogo();
        }


    }

    const updateLogo = () => {
        if (logo) {
            logo.src = body.classList.contains('light_mode') ? lightLogo : darkLogo;
        }
    };

    if (localStorage.getItem('theme') === 'light') {
        body.classList.add('light_mode');
    } else {
        localStorage.setItem('theme', 'dark');
    }
    updateLogo();

    themeToggle.addEventListener('click', () => {
        body.classList.toggle('light_mode');
        localStorage.setItem('theme', body.classList.contains('light_mode') ? 'light' : 'dark');
        updateLogo();
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
            if (favBtn.classList.contains('is_active')) {
                favBtn.innerHTML = `
                    <svg class="favBtn-heart" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 21.23L4.22 13.45a5.5 5.5 0 0 1 7.78-7.78L12 5.67" />
                        <path d="M12 5.67l1.06-1.06a5.5 5.5 0 0 1 7.78 7.78L12 21.23" />
                        <path d="M12 5.67l-2 4 3 2-2 4" />
                    </svg>
                    Eltávolítás
                `;
            } else {
                favBtn.innerHTML = `
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
});

document.querySelectorAll('.filter_btn').forEach(button => {
    button.addEventListener('click', () => {
        document.querySelectorAll('.filter_btn').forEach(btn => btn.classList.remove('is_active'));
        button.classList.add('is_active');
    });
});

const swiperConfig = (next, prev) => ({
    slidesPerView: 1.2,
    spaceBetween: 15,
    centeredSlides: false,
    grabCursor: true,
    navigation: {
        nextEl: next,
        prevEl: prev,
    },
    breakpoints: {
        480: {
            slidesPerView: 2.2,
            spaceBetween: 15,
        },
        768: {
            slidesPerView: 3.2,
            spaceBetween: 20,
        },
        1024: {
            slidesPerView: 4.2,
            spaceBetween: 20,
        },
        1400: {
            slidesPerView: 5.2,
            spaceBetween: 25,
        }
    }
});

new Swiper('.trending-swiper', swiperConfig('.trending-next', '.trending-prev'));
new Swiper('.daily-swiper', swiperConfig('.daily-next', '.daily-prev'));