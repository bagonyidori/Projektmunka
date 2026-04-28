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
            e.preventDefault();

            if (this.classList.contains('guest-fav-btn')) {
                if (typeof showNotification === "function") {
                    showNotification('A kedvencekhez adáshoz jelentkezz be!');
                }
                return;
            }

            const movieId = this.getAttribute('data-id');
            const form = document.getElementById('favForm');
            const url = form.getAttribute('action');
            const csrfToken = document.querySelector('input[name="_token"]').value;

            if (this.disabled) return;
            this.disabled = true;

            fetch(url, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                this.classList.toggle('is_active');
                const isActive = this.classList.contains('is_active');

                if (isActive) {
                    this.innerHTML = `
                        <svg class="favBtn-heart" viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2">
                            <path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"></path>
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

                if (typeof showNotification === "function") {
                    showNotification(isActive ? 'Hozzáadva a kedvencekhez!' : 'Eltávolítva a kedvencekből.');
                }
            })
            .catch(err => {
                console.error('Hiba:', err);
                if (typeof showNotification === "function") {
                    showNotification('Hiba történt a művelet során.', 'error');
                }
            })
            .finally(() => {
                this.disabled = false;
            });
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

        btn.addEventListener('click', function() {
            const streamUrl = this.getAttribute('data-url');

            if (this.classList.contains('is-verified') && streamUrl) {
                window.open(streamUrl, '_blank');
                return;
            }

            if (this.classList.contains('voting-closed')) {
                if (typeof showNotification === "function") {
                    showNotification('A szavazás lezárult, a forrás hitelesítve lett.', 'info');
                }
                return;
            }

            if (this.classList.contains('guest-btn')) {
                if (typeof showNotification === "function") {
                    showNotification('A szavazáshoz kérjük, jelentkezz be!', 'warning');
                } else {
                    alert('A szavazáshoz bejelentkezés szükséges!');
                }
                return;
            }

            if (this.disabled) return;
            this.disabled = true;

            const isVoted = this.classList.contains('voted');
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
                    const countSpan = this.querySelector('.vote_count');
                    countSpan.innerText = data.new_count;

                    if (isVoted) {
                        this.classList.remove('voted');
                        localStorage.removeItem(storageKey);
                        if(typeof showNotification === "function") showNotification('Szavazat visszavonva.');
                    } else {
                        this.classList.add('voted');
                        localStorage.setItem(storageKey, "true");
                        if(typeof showNotification === "function") showNotification('Köszönjük a szavazatot!');
                    }
                }
            })
            .catch(err => console.error("Hiba történt:", err))
            .finally(() => {
                this.disabled = false;
            });
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

    document.querySelectorAll('.show_more_btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const container = this.previousElementSibling; 
        
            if (container && container.classList.contains('expandable_container')) {
                const isExpanding = !container.classList.contains('is_expanded');            
                container.classList.toggle('is_expanded');

                if (isExpanding) {
                    this.textContent = 'Kevesebb megjelenítése';
                } else {
                    this.textContent = 'Összes megjelenítése';
                    container.parentElement.scrollIntoView({ 
                        behavior: 'smooth', 
                        block: 'start' 
                    });
                }
            }
        });
    });

    window.onload = function() {
        console.log("Az oldal teljes tartalma betöltődött.");

        const trigger = document.getElementById('openWizard');
        const modal = document.getElementById('assistantModal');
        const closeBtn = document.getElementById('closeWizard');
        const restartBtn = document.getElementById('restartWizard');

        let selections = { 
            genre: '', 
            era: '' 
        };

        if (!trigger) {
            console.error("HIBA: Nem találom az 'openWizard' ID-val rendelkező gombot!");
        } else {
            console.log("Siker: A gomb megvan, eseménykezelő hozzáadása...");

            trigger.onclick = function(e) {
                console.log("KATTINTÁS ÉSZLELVE!");
                if (modal) {
                    modal.style.display = 'block';
                } else {
                    console.error("HIBA: A modal (assistantModal) nem található!");
                }
            };
        }

        if (closeBtn) {
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            };
        }

        const choiceButtons = document.querySelectorAll('.choice_btn');
        choiceButtons.forEach(btn => {
            btn.onclick = function() {
                const type = this.getAttribute('data-type');
                const value = this.getAttribute('data-value');
                const currentStepDiv = this.closest('.wizard_step');
                const currentStepNum = parseInt(currentStepDiv.getAttribute('data-step'));

                console.log(`Választás: ${type} = ${value}`);
                selections[type] = value;

                currentStepDiv.style.display = 'none';

                const nextStepNum = currentStepNum + 1;
                const nextStepDiv = document.querySelector(`.wizard_step[data-step="${nextStepNum}"]`);

                if (nextStepDiv) {
                    nextStepDiv.style.display = 'block';

                    if (nextStepNum === 3) {
                        fetchRecommendations();
                    }
                }
            };
        });

        function fetchRecommendations() {
            const resultsDiv = document.getElementById('wizardResults');
            resultsDiv.innerHTML = '<p style="color: #333333;">Cricklee elővarázsolja a filmeket...</p>';

            const apiUrl = `/api/recommend?genre=${selections.genre}&era=${selections.era}`;
            console.log("Lekérés indítása:", apiUrl);

            fetch(apiUrl)
                .then(response => {
                    if (!response.ok) throw new Error("Hálózati hiba történt.");
                    return response.json();
                })
                .then(movies => {
                    resultsDiv.innerHTML = '';
                
                    if (movies.length === 0) {
                        resultsDiv.innerHTML = '<p>A jövő ködbe vész... nem találtam ilyen filmet a jóslataimban. Próbálkozz más opciókkal!</p>';
                    } else {
                        movies.forEach(movie => {
                            const link = document.createElement('a');
                            link.href = `/movies/${movie.id}`;
                            link.className = 'result_item';
                            link.innerHTML = `🎬 ${movie.title}`;
                            link.style.display = 'block';
                            link.style.marginBottom = '10px';
                            link.style.color = '#2c2c2c';
                            link.style.fontWeight = 'bold';
                            link.style.textDecoration = 'none';
                        
                            resultsDiv.appendChild(link);
                        });
                    }
                })
                .catch(error => {
                    console.error("Fetch hiba:", error);
                    resultsDiv.innerHTML = '<p>Hiba történt a lekéréskor.</p>';
                });
        }

        if (restartBtn) {
            restartBtn.onclick = function() {
                console.log("Varázsló újraindítása...");
                selections = { genre: '', era: '' };

                document.querySelectorAll('.wizard_step').forEach(step => {
                    step.style.display = 'none';
                });
                document.querySelector('.wizard_step[data-step="1"]').style.display = 'block';
                document.getElementById('wizardResults').innerHTML = '';
            };
        }
    };
});