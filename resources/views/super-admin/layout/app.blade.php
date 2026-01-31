<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Admin Dashboard</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        html,
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial,
                "Noto Sans", "Liberation Sans", sans-serif;
        }

        /* Smooth transitions */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        /* Disable transitions on transform/opacity for performance */
        * {
            transition: background-color 0.2s ease, color 0.2s ease, border-color 0.2s ease, opacity 0.2s ease;
        }

        /* Smooth drawer animation */
        #mobileDrawer {
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        #drawerOverlay {
            transition: opacity 0.3s ease;
        }

        /* Smooth scroll behavior */
        html {
            scroll-behavior: smooth;
        }

        /* Loading pulse animation */
        @keyframes pulse-soft {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.7;
            }
        }

        .animate-pulse-soft {
            animation: pulse-soft 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        /* Link hover animation */
        a {
            position: relative;
        }

        /* Dropdown smooth appearance */
        #profileMenu,
        #bottomProfileMenu {
            transition: opacity 0.2s ease, transform 0.2s ease;
            transform-origin: top right;
        }

        #profileMenu.hidden,
        #bottomProfileMenu.hidden {
            opacity: 0;
            transform: scale(0.95);
            pointer-events: none;
        }

        #profileMenu:not(.hidden),
        #bottomProfileMenu:not(.hidden) {
            opacity: 1;
            transform: scale(1);
        }

        /* Input focus smooth */
        input:focus {
            transition: all 0.3s ease;
        }

        /* Button hover scale */
        button {
            transition: all 0.2s ease;
        }

        button:hover {
            transform: translateY(-1px);
        }

        button:active {
            transform: translateY(0);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">

    @include('super-admin.layout.mobile-menu')

    <div class="min-h-screen">
        <div class="flex min-h-screen">

            @include('super-admin.layout.options')

            <!-- MAIN -->
            <div class="flex min-w-0 flex-1 flex-col">

                @include('super-admin.layout.header')

                <!-- CONTENT -->
                <main class="flex-1 px-4 py-5 md:px-8 md:py-6 pb-24 md:pb-6">



                    @yield('admin-content')

                    <!-- Footer -->
                    <div class="mt-8 pb-6 text-center text-xs text-slate-400">
                        © 2026 Task Manager • Developed by Zentrik Technology Ltd.
                    </div>
                </main>
            </div>
        </div>
    </div>


    @include('super-admin.layout.mobile-buttom-bar')




    @stack('scripts')



    <script>
        // -------- Dynamic Clock --------
        function updateClock() {
            const dateEl = document.querySelector('[data-date]');
            const timeEl = document.querySelector('[data-time]');
            if (!dateEl || !timeEl) return;

            const now = new Date();
            const dateFormatter = new Intl.DateTimeFormat('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric'
            });
            const timeFormatter = new Intl.DateTimeFormat('en-US', {
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            });

            dateEl.textContent = dateFormatter.format(now);
            timeEl.textContent = timeFormatter.format(now);
        }

        updateClock();
        setInterval(updateClock, 1000);

        // -------- Drawer --------
        const overlay = document.getElementById("drawerOverlay");
        const drawer = document.getElementById("mobileDrawer");
        const openBtns = [document.getElementById("mobileMenuBtn"), document.getElementById("bottomMenuBtn")].filter(
            Boolean);
        const closeBtn = document.getElementById("drawerClose");

        function openDrawer() {
            overlay.classList.remove("hidden");
            setTimeout(() => drawer.classList.remove("-translate-x-full"), 10);
            drawer.setAttribute("aria-hidden", "false");
            document.body.classList.add("overflow-hidden");
        }

        function closeDrawer() {
            drawer.classList.add("-translate-x-full");
            setTimeout(() => overlay.classList.add("hidden"), 300);
            drawer.setAttribute("aria-hidden", "true");
            document.body.classList.remove("overflow-hidden");
        }

        openBtns.forEach((btn) => btn.addEventListener("click", openDrawer));
        closeBtn?.addEventListener("click", closeDrawer);
        overlay?.addEventListener("click", closeDrawer);

        document.addEventListener("keydown", (e) => {
            if (e.key === "Escape") closeDrawer();
        });

        // -------- Active Navigation Link --------
        function updateActiveNavLink() {
            const currentPath = window.location.pathname;
            document.querySelectorAll('a[href^="/"]').forEach(link => {
                link.classList.remove('bg-blue-50', 'text-blue-600', 'border-blue-200');
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('bg-blue-50', 'text-blue-600', 'border-blue-200');
                }
            });
        }

        updateActiveNavLink();
        window.addEventListener('popstate', updateActiveNavLink);

        // -------- Top profile dropdown --------
        const profileBtn = document.getElementById("profileBtn");
        const profileMenu = document.getElementById("profileMenu");

        function closeProfileMenu() {
            profileMenu?.classList.add("hidden");
            profileBtn?.setAttribute("aria-expanded", "false");
        }

        profileBtn?.addEventListener("click", (e) => {
            e.stopPropagation();
            const isHidden = profileMenu?.classList.contains("hidden");
            // close bottom menu if open
            if (bottomProfileMenu) bottomProfileMenu.classList.add("hidden");
            if (isHidden) {
                profileMenu?.classList.remove("hidden");
                profileBtn.setAttribute("aria-expanded", "true");
            } else {
                closeProfileMenu();
            }
        });

        // -------- Bottom profile dropdown --------
        const bottomProfileBtn = document.getElementById("bottomProfileBtn");
        const bottomProfileMenu = document.getElementById("bottomProfileMenu");

        bottomProfileBtn?.addEventListener("click", (e) => {
            e.stopPropagation();
            // close top menu if open
            closeProfileMenu();
            bottomProfileMenu?.classList.toggle("hidden");
        });

        // -------- Click outside to close menus --------
        document.addEventListener("click", () => {
            closeProfileMenu();
            if (bottomProfileMenu) bottomProfileMenu.classList.add("hidden");
        });

        // prevent menu click from bubbling to document
        profileMenu?.addEventListener("click", (e) => e.stopPropagation());
        bottomProfileMenu?.addEventListener("click", (e) => e.stopPropagation());
        drawer?.addEventListener("click", (e) => e.stopPropagation());

        // -------- Smooth page transitions --------
        document.addEventListener('click', (e) => {
            const link = e.target.closest('a[href^="/"]');
            if (link && !e.metaKey && !e.ctrlKey) {
                const mainContent = document.querySelector('main');
                if (mainContent) {
                    mainContent.style.opacity = '0.7';
                    mainContent.style.pointerEvents = 'none';
                }
            }
        });

        // Restore when page loads
        window.addEventListener('load', () => {
            const mainContent = document.querySelector('main');
            if (mainContent) {
                mainContent.style.opacity = '1';
                mainContent.style.pointerEvents = 'auto';
            }
        });
    </script>
</body>

</html>
