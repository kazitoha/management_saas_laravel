<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>{{ config('app.name', 'Task Manager') }} — Create account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <style>
        html,
        body {
            font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue",
                Arial, "Noto Sans", "Liberation Sans", sans-serif;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50">
    <div class="min-h-screen">
        <!-- subtle background -->
        <div class="pointer-events-none fixed inset-0">
            <div class="absolute -top-24 left-1/2 h-72 w-72 -translate-x-1/2 rounded-full bg-blue-200/40 blur-3xl">
            </div>
            <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-indigo-200/40 blur-3xl"></div>
        </div>

        <div class="relative mx-auto flex min-h-screen max-w-6xl items-center justify-center px-4 py-10">
            <div
                class="grid w-full overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm md:grid-cols-2">
                <!-- Left / Brand panel -->
                <div class="hidden md:block">
                    <div class="h-full bg-slate-900 p-10 text-white">
                        <div class="flex items-center gap-3">
                            <div class="grid h-11 w-11 place-items-center rounded-2xl bg-white/10">
                                <span class="text-sm font-bold">TM</span>
                            </div>
                            <div>
                                <div class="text-lg font-bold leading-tight">Task Manager</div>
                                <div class="text-xs text-white/70">Admin Platform</div>
                            </div>
                        </div>

                        <div class="mt-10">
                            <h2 class="text-2xl font-extrabold leading-snug">
                                Welcome back 👋
                            </h2>
                            <p class="mt-3 text-sm leading-relaxed text-white/75">
                                Sign in to manage tasks, projects, attendance, invoices, and team performance
                                from one dashboard.
                            </p>
                        </div>

                        <div class="mt-10 space-y-3">
                            <div class="flex items-start gap-3 rounded-2xl bg-white/5 p-4">
                                <div class="mt-0.5">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M9 11l3 3L22 4" />
                                        <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">Track work easily</div>
                                    <div class="text-xs text-white/70">Tasks, reminders, and progress in one place.
                                    </div>
                                </div>
                            </div>

                            <div class="flex items-start gap-3 rounded-2xl bg-white/5 p-4">
                                <div class="mt-0.5">
                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
                                        stroke-width="2">
                                        <path d="M12 3v19" />
                                        <path d="M19 12H5" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-sm font-semibold">Fast & secure</div>
                                    <div class="text-xs text-white/70">Modern UI with sensible defaults.</div>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 text-xs text-white/50">
                            © 2026 Task Manager. All rights reserved.
                        </div>
                    </div>
                </div>

                <!-- Right / Login form -->
                <div class="p-7 sm:p-10">
                    <div class="md:hidden">
                        <div class="flex items-center gap-3">
                            <div class="grid h-11 w-11 place-items-center rounded-2xl bg-slate-900 text-white">
                                <span class="text-sm font-bold">TM</span>
                            </div>
                            <div>
                                <div class="text-base font-bold leading-tight">Task Manager</div>
                                <div class="text-xs text-slate-500">Admin Platform</div>
                            </div>
                        </div>
                    </div>

	                    <div class="mt-8 md:mt-0">
	                        <h1 class="text-2xl font-extrabold tracking-tight text-slate-900">
	                            Create your account
	                        </h1>
	                        <p class="mt-2 text-sm text-slate-500">
	                            Create an account to access the dashboard.
	                        </p>
	                    </div>

	                    <form class="mt-7 space-y-4" action="{{ route('register.store') }}" method="post" novalidate>
	                        @csrf

	                        @if (session('status'))
	                            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-800">
	                                {{ session('status') }}
	                            </div>
	                        @endif

	                        @if ($errors->any())
	                            <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
	                                {{ $errors->first() }}
	                            </div>
	                        @endif

	                        <!-- Name -->
	                        <div>
	                            <label class="text-sm font-semibold text-slate-700">Name</label>
	                            <div class="relative mt-2">
	                                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
	                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
	                                        <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" />
	                                        <circle cx="12" cy="7" r="4" />
	                                    </svg>
	                                </span>
	                                <input type="text" name="name" placeholder="Your name"
	                                    value="{{ old('name') }}"
	                                    autocomplete="name"
	                                    class="w-full rounded-2xl border bg-slate-50 py-3 pl-10 pr-4 text-sm outline-none ring-blue-200 focus:ring-4 {{ $errors->has('name') ? 'border-red-300 focus:border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-blue-300' }}"
	                                    required />
	                            </div>
	                            @error('name')
	                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
	                            @enderror
	                        </div>

	                        <!-- Email -->
	                        <div>
	                            <label class="text-sm font-semibold text-slate-700">Email</label>
	                            <div class="relative mt-2">
	                                <span
	                                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
	                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
	                                        stroke-width="2">
	                                        <path d="M4 4h16v16H4z" opacity="0.2" />
	                                        <path d="M4 6l8 6 8-6" />
	                                        <path d="M4 18h16" />
	                                    </svg>
	                                </span>
	                                <input type="email" name="email" placeholder="you@example.com"
	                                    value="{{ old('email') }}"
	                                    autocomplete="email"
	                                    class="w-full rounded-2xl border bg-slate-50 py-3 pl-10 pr-4 text-sm outline-none ring-blue-200 focus:ring-4 {{ $errors->has('email') ? 'border-red-300 focus:border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-blue-300' }}"
	                                    required />
	                            </div>
	                            @error('email')
	                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
	                            @enderror
	                        </div>

	                        <!-- Password -->
	                        <div>
	                            <label class="text-sm font-semibold text-slate-700">Password</label>
	                            <div class="relative mt-2">
	                                <span
	                                    class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
	                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor"
	                                        stroke-width="2">
	                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
	                                        <rect x="5" y="11" width="14" height="10" rx="2" />
	                                    </svg>
	                                </span>

	                                <input id="password" type="password" name="password" placeholder="••••••••"
	                                    autocomplete="new-password"
	                                    class="w-full rounded-2xl border bg-slate-50 py-3 pl-10 pr-12 text-sm outline-none ring-blue-200 focus:ring-4 {{ $errors->has('password') ? 'border-red-300 focus:border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-blue-300' }}"
	                                    required />

	                                <button type="button" data-toggle-password="password"
	                                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded-xl px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white">
	                                    Show
	                                </button>
	                            </div>
	                            @error('password')
	                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
	                            @enderror
	                        </div>

	                        <!-- Confirm Password -->
	                        <div>
	                            <label class="text-sm font-semibold text-slate-700">Confirm password</label>
	                            <div class="relative mt-2">
	                                <span class="pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">
	                                    <svg viewBox="0 0 24 24" class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2">
	                                        <path d="M7 11V7a5 5 0 0 1 10 0v4" />
	                                        <rect x="5" y="11" width="14" height="10" rx="2" />
	                                    </svg>
	                                </span>
	                                <input id="password_confirmation" type="password" name="password_confirmation" placeholder="••••••••"
	                                    autocomplete="new-password"
	                                    class="w-full rounded-2xl border bg-slate-50 py-3 pl-10 pr-12 text-sm outline-none ring-blue-200 focus:ring-4 {{ $errors->has('password_confirmation') ? 'border-red-300 focus:border-red-400 focus:ring-red-200' : 'border-slate-200 focus:border-blue-300' }}"
	                                    required />
	                                <button type="button" data-toggle-password="password_confirmation"
	                                    class="absolute right-2 top-1/2 -translate-y-1/2 rounded-xl px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-white">
	                                    Show
	                                </button>
	                            </div>
	                            @error('password_confirmation')
	                                <p class="mt-2 text-xs font-medium text-red-600">{{ $message }}</p>
	                            @enderror
	                        </div>

	                        <!-- Submit -->
	                        <button type="submit"
	                            class="w-full rounded-2xl bg-slate-900 py-3 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus:outline-none focus:ring-4 focus:ring-slate-300">
	                            Create account
	                        </button>

                        <!-- Divider -->
                        <div class="relative py-2">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-slate-200"></div>
                            </div>
                            <div class="relative flex justify-center">
                                <span class="bg-white px-3 text-xs text-slate-500">or continue with</span>
                            </div>
                        </div>

                        <!-- Social -->
                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                            <button type="button"
                                class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true">
                                    <path fill="currentColor"
                                        d="M12 11.7v3.4h5.8c-.2 1.4-1.6 4.1-5.8 4.1-3.5 0-6.4-2.9-6.4-6.5S8.5 6.2 12 6.2c2 0 3.3.9 4.1 1.6l2.8-2.7C17.1 3.4 14.8 2 12 2 6.9 2 2.8 6.1 2.8 11.2S6.9 20.4 12 20.4c6 0 8.1-4.2 8.1-6.3 0-.4-.1-.8-.1-1.1H12z" />
                                </svg>
                                Google
                            </button>

                            <button type="button"
                                class="flex items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white py-3 text-sm font-semibold text-slate-700 hover:bg-slate-50">
                                <svg viewBox="0 0 24 24" class="h-5 w-5" aria-hidden="true">
                                    <path fill="currentColor"
                                        d="M12 2C6.5 2 2 6.5 2 12c0 4.4 2.9 8.1 6.8 9.4.5.1.7-.2.7-.5v-1.8c-2.8.6-3.4-1.2-3.4-1.2-.5-1.2-1.1-1.5-1.1-1.5-1-.7.1-.7.1-.7 1.1.1 1.7 1.2 1.7 1.2 1 .1.8-1 .8-1 0-.7.4-1.1.7-1.3-2.2-.3-4.5-1.1-4.5-5 0-1.1.4-2 .9-2.7-.1-.2-.4-1.3.1-2.7 0 0 .8-.3 2.7 1a9.2 9.2 0 0 1 4.9 0c1.9-1.3 2.7-1 2.7-1 .5 1.4.2 2.5.1 2.7.6.7.9 1.6.9 2.7 0 3.9-2.3 4.7-4.5 5 .4.3.7.9.7 1.8v2.6c0 .3.2.6.7.5C19.1 20.1 22 16.4 22 12c0-5.5-4.5-10-10-10z" />
                                </svg>
                                GitHub
                            </button>
                        </div>

	                        <p class="pt-2 text-center text-sm text-slate-600">
	                            Already have an account?
	                            <a href="{{ route('login') }}" class="font-semibold text-slate-900 hover:underline">Sign in</a>
	                        </p>
	                    </form>
	                </div>
	            </div>
	        </div>
    </div>

	    <script>
	        document.querySelectorAll("[data-toggle-password]").forEach((btn) => {
	            const targetId = btn.getAttribute("data-toggle-password");
	            const input = document.getElementById(targetId);
	            if (!input) return;

	            btn.addEventListener("click", () => {
	                const isPassword = input.type === "password";
	                input.type = isPassword ? "text" : "password";
	                btn.textContent = isPassword ? "Hide" : "Show";
	            });
	        });
	    </script>
</body>

</html>
