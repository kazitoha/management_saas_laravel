<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TaskShaper — Task Management for Service Teams</title>

    <!-- Tailwind CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ["Inter", "ui-sans-serif", "system-ui"]
                    },
                },
            },
        };
    </script>
</head>

<body class="bg-white text-slate-900 font-sans">
    <!-- Header -->
    <header class="sticky top-0 z-50 bg-white/80 backdrop-blur border-b border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 items-center justify-between">
                <a href="#" class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-xl bg-slate-900 text-white grid place-items-center font-extrabold">TS
                    </div>
                    <div class="leading-tight">
                        <div class="font-bold">TaskShaper</div>
                        <div class="text-xs text-slate-500 -mt-0.5">Task & project management</div>
                    </div>
                </a>

                <nav class="hidden md:flex items-center gap-8 text-sm font-medium text-slate-700">
                    <a class="hover:text-slate-900" href="#features">Features</a>
                    <a class="hover:text-slate-900" href="#how">Workflow</a>
                    <a class="hover:text-slate-900" href="#usecases">Use cases</a>
                    <a class="hover:text-slate-900" href="#faq">FAQ</a>
                </nav>

                <div class="hidden md:flex items-center gap-3">
                    <a href="{{ route('login') }}"
                        class="rounded-xl px-4 py-2 text-sm font-semibold text-slate-800 hover:bg-slate-100">
                        Sign in
                    </a>
                    <a href="#contact"
                        class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">
                        Request access
                    </a>
                </div>

                <!-- Mobile -->
                <button id="menuBtn"
                    class="md:hidden inline-flex items-center justify-center rounded-xl p-2 hover:bg-slate-100"
                    aria-label="Open menu">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>

        <div id="mobileMenu" class="md:hidden hidden border-t border-slate-200 bg-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-4 space-y-3 text-sm font-medium">
                <a class="block text-slate-700 hover:text-slate-900" href="#features">Features</a>
                <a class="block text-slate-700 hover:text-slate-900" href="#how">Workflow</a>
                <a class="block text-slate-700 hover:text-slate-900" href="#usecases">Use cases</a>
                <a class="block text-slate-700 hover:text-slate-900" href="#faq">FAQ</a>
                <div class="pt-2 flex gap-2">
                    <a href="{{ route('login') }}"
                        class="flex-1 rounded-xl px-4 py-2 text-center font-semibold hover:bg-slate-100">Sign in</a>
                    <a href="#contact"
                        class="flex-1 rounded-xl bg-slate-900 px-4 py-2 text-center font-semibold text-white hover:bg-slate-800">Request
                        access</a>
                </div>
            </div>
        </div>
    </header>

    <!-- Hero -->
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 -z-10">
            <div class="absolute -top-24 -right-24 h-72 w-72 rounded-full bg-slate-100 blur-2xl"></div>
            <div class="absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-slate-100 blur-2xl"></div>
        </div>

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="grid items-center gap-10 lg:grid-cols-2">
                <div>
                    <span
                        class="inline-flex items-center gap-2 rounded-full border border-slate-200 px-3 py-1 text-xs font-semibold text-slate-700">
                        <span class="h-2 w-2 rounded-full bg-emerald-500"></span>
                        Built for service-based teams
                    </span>

                    <h1 class="mt-5 text-4xl sm:text-5xl font-extrabold tracking-tight">
                        Professional task management — built for delivery-focused teams.
                    </h1>

                    <p class="mt-4 text-lg text-slate-600 max-w-xl">
                        TaskShaper centralizes projects, tasks, and clients so teams stay aligned, accountable, and on
                        time — without tool overload.
                    </p>

                    <div class="mt-8 flex flex-col sm:flex-row gap-3">
                        <a href="#contact"
                            class="inline-flex items-center justify-center rounded-2xl bg-slate-900 px-6 py-3 text-base font-semibold text-white hover:bg-slate-800">
                            Request access
                        </a>
                        <a href="#features"
                            class="inline-flex items-center justify-center rounded-2xl border border-slate-300 px-6 py-3 text-base font-semibold text-slate-800 hover:bg-slate-50">
                            Explore features
                        </a>
                    </div>

                    <div class="mt-8 grid grid-cols-2 gap-4 sm:flex sm:items-center sm:gap-8 text-sm text-slate-600">
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-5 w-5 rounded-lg bg-slate-900"></span>
                            Clear ownership
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-5 w-5 rounded-lg bg-slate-900"></span>
                            Manager visibility
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-5 w-5 rounded-lg bg-slate-900"></span>
                            Client-linked work
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="inline-block h-5 w-5 rounded-lg bg-slate-900"></span>
                            Fast onboarding
                        </div>
                    </div>
                </div>

                <!-- Mock UI -->
                <div class="relative">
                    <div class="rounded-3xl border border-slate-200 bg-white shadow-sm overflow-hidden">
                        <div class="flex items-center gap-2 border-b border-slate-200 px-5 py-4">
                            <div class="flex gap-2">
                                <span class="h-3 w-3 rounded-full bg-slate-300"></span>
                                <span class="h-3 w-3 rounded-full bg-slate-300"></span>
                                <span class="h-3 w-3 rounded-full bg-slate-300"></span>
                            </div>
                            <div class="ml-auto text-xs text-slate-500">Workspace dashboard</div>
                        </div>

                        <div class="p-5">
                            <div class="flex items-start justify-between gap-4">
                                <div>
                                    <div class="text-sm font-semibold">Operational overview</div>
                                    <div class="text-xs text-slate-500">Active work across teams</div>
                                </div>
                                <button
                                    class="rounded-xl bg-slate-900 px-3 py-2 text-xs font-semibold text-white">Create
                                    task</button>
                            </div>

                            <div class="mt-5 grid grid-cols-3 gap-3">
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">Open</div>
                                    <div class="mt-1 text-2xl font-extrabold">24</div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">In progress</div>
                                    <div class="mt-1 text-2xl font-extrabold">11</div>
                                </div>
                                <div class="rounded-2xl border border-slate-200 p-4">
                                    <div class="text-xs text-slate-500">Completed</div>
                                    <div class="mt-1 text-2xl font-extrabold">38</div>
                                </div>
                            </div>

                            <div class="mt-5">
                                <div class="text-sm font-semibold">Priority tasks</div>
                                <div class="mt-3 space-y-3">
                                    <div
                                        class="flex items-center justify-between rounded-2xl border border-slate-200 p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1 h-4 w-4 rounded border border-slate-300"></div>
                                            <div>
                                                <div class="text-sm font-semibold">Finalize client proposal</div>
                                                <div class="text-xs text-slate-500">Client: Acme Co • Due: Fri</div>
                                            </div>
                                        </div>
                                        <span
                                            class="rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-800">High</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between rounded-2xl border border-slate-200 p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1 h-4 w-4 rounded border border-slate-300"></div>
                                            <div>
                                                <div class="text-sm font-semibold">QA website changes</div>
                                                <div class="text-xs text-slate-500">Project: Website Revamp • Due: Thu
                                                </div>
                                            </div>
                                        </div>
                                        <span
                                            class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">Medium</span>
                                    </div>

                                    <div
                                        class="flex items-center justify-between rounded-2xl border border-slate-200 p-4">
                                        <div class="flex items-start gap-3">
                                            <div class="mt-1 h-4 w-4 rounded border border-slate-300"></div>
                                            <div>
                                                <div class="text-sm font-semibold">Send weekly update</div>
                                                <div class="text-xs text-slate-500">Owner: You • Due: Today</div>
                                            </div>
                                        </div>
                                        <span
                                            class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">Low</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div
                        class="absolute -bottom-6 -left-6 hidden sm:block rounded-3xl border border-slate-200 bg-white px-5 py-4 shadow-sm">
                        <div class="text-xs text-slate-500">Live status</div>
                        <div class="mt-1 text-sm font-semibold">Workload stable ✅</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Trust strip -->
    <section class="border-y border-slate-200 bg-slate-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="text-sm font-semibold">Clarity</div>
                    <p class="mt-1 text-sm text-slate-600">One system for projects, tasks, and ownership.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="text-sm font-semibold">Accountability</div>
                    <p class="mt-1 text-sm text-slate-600">Every task has an owner, due date, and status.</p>
                </div>
                <div class="rounded-2xl border border-slate-200 bg-white p-5">
                    <div class="text-sm font-semibold">Visibility</div>
                    <p class="mt-1 text-sm text-slate-600">Managers see progress across teams in real time.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features -->
    <section id="features" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-extrabold tracking-tight">Core capabilities</h2>
            <p class="mt-3 text-slate-600">
                Built to reduce operational noise and help teams execute consistently.
            </p>
        </div>

        <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Project-based structure</h3>
                <p class="mt-2 text-slate-600 text-sm">Organize work by project with clear scope and progress.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Task ownership</h3>
                <p class="mt-2 text-slate-600 text-sm">Assign owners, due dates, priority, and status — no ambiguity.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Client-linked delivery</h3>
                <p class="mt-2 text-slate-600 text-sm">Connect tasks and projects to clients for better delivery flow.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Team visibility</h3>
                <p class="mt-2 text-slate-600 text-sm">My Tasks and All Tasks views for individuals and managers.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Permissions</h3>
                <p class="mt-2 text-slate-600 text-sm">Control access with roles for owners, managers, and members.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold text-lg">Operational insights</h3>
                <p class="mt-2 text-slate-600 text-sm">Track throughput, overdue tasks, and workload balance
                    (optional).</p>
            </div>
        </div>
    </section>

    <!-- Workflow -->
    <section id="how" class="bg-slate-50 border-y border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
            <div class="grid gap-10 lg:grid-cols-2 lg:items-center">
                <div>
                    <h2 class="text-3xl font-extrabold tracking-tight">A simple workflow that scales</h2>
                    <p class="mt-3 text-slate-600">
                        Set up your structure once — then operate with consistent execution every week.
                    </p>

                    <ol class="mt-8 space-y-5">
                        <li class="flex gap-4">
                            <div
                                class="mt-1 h-8 w-8 rounded-2xl bg-slate-900 text-white grid place-items-center font-bold">
                                1</div>
                            <div>
                                <div class="font-bold">Create project & define deliverables</div>
                                <div class="text-sm text-slate-600">Keep work grouped under real outcomes.</div>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div
                                class="mt-1 h-8 w-8 rounded-2xl bg-slate-900 text-white grid place-items-center font-bold">
                                2</div>
                            <div>
                                <div class="font-bold">Assign tasks with owners & due dates</div>
                                <div class="text-sm text-slate-600">Set expectations clearly from day one.</div>
                            </div>
                        </li>
                        <li class="flex gap-4">
                            <div
                                class="mt-1 h-8 w-8 rounded-2xl bg-slate-900 text-white grid place-items-center font-bold">
                                3</div>
                            <div>
                                <div class="font-bold">Track, review, and deliver</div>
                                <div class="text-sm text-slate-600">Visibility for managers and focus for team members.
                                </div>
                            </div>
                        </li>
                    </ol>
                </div>

                <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-sm font-semibold">Project health</div>
                            <div class="text-xs text-slate-500">Weekly execution snapshot</div>
                        </div>
                        <span class="rounded-full bg-emerald-100 px-3 py-1 text-xs font-semibold text-emerald-800">On
                            track</span>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-semibold">Delivery readiness</span>
                                <span class="text-slate-500">72%</span>
                            </div>
                            <div class="mt-2 h-2 rounded-full bg-slate-100 overflow-hidden">
                                <div class="h-2 w-[72%] bg-slate-900 rounded-full"></div>
                            </div>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="text-xs text-slate-500">Overdue</div>
                                <div class="mt-1 text-xl font-extrabold">2</div>
                            </div>
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="text-xs text-slate-500">Due this week</div>
                                <div class="mt-1 text-xl font-extrabold">9</div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-200 p-4">
                            <div class="text-xs text-slate-500">Manager note</div>
                            <div class="mt-1 text-sm font-semibold">Follow up on overdue items before Friday.</div>
                        </div>
                    </div>

                    <p class="mt-6 text-xs text-slate-500">
                        Replace these placeholders with real metrics/screenshots from your app.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases -->
    <section id="usecases" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-extrabold tracking-tight">Designed for service operations</h2>
            <p class="mt-3 text-slate-600">
                Ideal for teams delivering work for clients on a recurring basis.
            </p>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-3">
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Agencies</h3>
                <p class="mt-2 text-sm text-slate-600">Manage multiple clients, projects, and deliverables without
                    chaos.</p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Studios</h3>
                <p class="mt-2 text-sm text-slate-600">Keep production tasks moving with clear ownership and deadlines.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Consulting teams</h3>
                <p class="mt-2 text-sm text-slate-600">Link execution to clients, outcomes, and consistent follow-ups.
                </p>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section id="faq" class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16 sm:py-20">
        <div class="max-w-2xl">
            <h2 class="text-3xl font-extrabold tracking-tight">FAQ</h2>
            <p class="mt-3 text-slate-600">Common questions.</p>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">What makes TaskShaper different?</h3>
                <p class="mt-2 text-sm text-slate-600">
                    TaskShaper is built around service delivery: projects, tasks, and clients stay connected with clear
                    ownership.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Can managers see all work?</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Yes. Use All Tasks and project views to monitor progress and follow up quickly.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Is it suitable for small teams?</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Yes. The workflow is simple, but the structure supports growth without added complexity.
                </p>
            </div>
            <div class="rounded-3xl border border-slate-200 p-6">
                <h3 class="font-bold">Does it support client management?</h3>
                <p class="mt-2 text-sm text-slate-600">
                    Yes. Clients are part of the core model so delivery and communication stay organized.
                </p>
            </div>
        </div>
    </section>

    <!-- Contact / Early access -->
    <section id="contact" class="bg-slate-900">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-14">
            <div class="rounded-3xl bg-white/5 border border-white/10 p-8 sm:p-10">
                <div class="grid gap-8 lg:grid-cols-2 lg:items-center">
                    <div>
                        <h2 class="text-3xl font-extrabold tracking-tight text-white">Request early access</h2>
                        <p class="mt-2 text-slate-300">
                            Share your email and team size. We’ll reach out with access details.
                        </p>
                        <ul class="mt-6 space-y-2 text-sm text-slate-300">
                            <li>• Clean workspace setup</li>
                            <li>• Projects + tasks + clients</li>
                            <li>• Built for service delivery workflows</li>
                        </ul>
                    </div>

                    <form class="rounded-3xl bg-white p-6">
                        <div class="grid gap-4">
                            <div>
                                <label class="text-sm font-semibold text-slate-700">Work email</label>
                                <input type="email" placeholder="you@company.com"
                                    class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-900"
                                    required />
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">Team size</label>
                                <select
                                    class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-900">
                                    <option>1–5</option>
                                    <option>6–15</option>
                                    <option>16–50</option>
                                    <option>51+</option>
                                </select>
                            </div>

                            <div>
                                <label class="text-sm font-semibold text-slate-700">What do you manage?</label>
                                <input type="text"
                                    placeholder="e.g., agency projects, client delivery, internal ops"
                                    class="mt-2 w-full rounded-2xl border border-slate-300 px-4 py-3 text-sm outline-none focus:ring-2 focus:ring-slate-900" />
                            </div>

                            <button type="button"
                                class="mt-2 inline-flex w-full justify-center rounded-2xl bg-slate-900 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                                Submit request
                            </button>

                            <p class="text-xs text-slate-500">
                                This form is UI-only. Connect it to your backend endpoint later.
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="border-t border-slate-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-10">
            <div class="flex flex-col sm:flex-row gap-6 sm:items-center sm:justify-between">
                <div class="flex items-center gap-2">
                    <div class="h-9 w-9 rounded-xl bg-slate-900 text-white grid place-items-center font-extrabold">TS
                    </div>
                    <div class="font-bold">TaskShaper</div>
                </div>
                <div class="text-sm text-slate-600">© <span id="year"></span> TaskShaper. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Mobile menu toggle
        const menuBtn = document.getElementById("menuBtn");
        const mobileMenu = document.getElementById("mobileMenu");
        menuBtn?.addEventListener("click", () => mobileMenu.classList.toggle("hidden"));

        // Year
        document.getElementById("year").textContent = new Date().getFullYear();
    </script>
</body>

</html>
