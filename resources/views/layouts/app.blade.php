<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#0b0f19">
    <title>@yield('title', 'Criticly')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js" defer></script>
    <script src="{{ asset('js/main.js') }}" defer></script>
</head>
<body>
    <div id="preloader">
    <div class="loader-box">
        <img src="/img/Page_Loader.gif" alt="Loading..." class="loader-gif">
    </div>
</div>
    @include('components.navbar')

    <div class="page_shell">
        @yield('content')
    </div>

    <button class="theme_toggle" id="themeToggle" type="button" aria-label="Téma váltása">
        <span class="theme_toggle_icon">◐</span>
    </button>

    <div class="notification" id="notification"></div>
    
    <div id="openWizard" class="cricklee_trigger">
        <div class="cricklee_bubble">
            <img src="{{ asset('img/Cricklee_Wizzard_1.png') }}" alt="Cricklee">
            <span>Segítsek?</span>
        </div>
    </div>

    <div class="assistant_overlay" id="assistantModal">
        <div class="assistant_card">
            <button class="close_wizard" id="closeWizard">&times;</button>
        
            <div class="assistant_header">
                <img src="{{ asset('img/Cricklee_Wizzard_2.png') }}" alt="Cricklee">
                <h3>Cricklee varázsfilmjei</h3>
            </div>

            <div id="wizardSteps">
                <div class="wizard_step active" data-step="1">
                    <p class="step_q">Melyik ösvény a leghívogatóbb?</p>
                    <div class="choice_grid">
                        <button class="choice_btn" data-type="genre" data-value="Akció,Sci-Fi,Fantasy">Más világok és hősök</button>   
                        <button class="choice_btn" data-type="genre" data-value="Komédia,Romantikus">Nevetés és érzelmek</button> 
                        <button class="choice_btn" data-type="genre" data-value="Horror">Sötét titkok és rettegés</button>
                        <button class="choice_btn" data-type="genre" data-value="Dráma">Mély, feszült történetek</button>
                    </div>
                </div>

                <div class="wizard_step" data-step="2" style="display: none;">
                    <p class="step_q">Melyik korszakból varázsoljak?</p>
                    <div class="choice_grid">
                        <button class="choice_btn" data-type="era" data-value="new">Új filmek (2020+)</button>
                        <button class="choice_btn" data-type="era" data-value="classic">Klasszikusok</button>
                        <button class="choice_btn" data-type="era" data-value="any">Bármelyik korszak</button>
                    </div>
                </div>

                <div class="wizard_step" data-step="3" style="display: none;">
                    <p class="step_q">Szerintem ezek tetszeni fognak:</p>
                    <div id="wizardResults" class="results_list"></div>
                    <button class="restart_btn" id="restartWizard">Varázsolj újra!</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>