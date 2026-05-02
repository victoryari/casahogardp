<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') – CasaHogar</title>
    
    {{-- Fonts & Assets --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')

    {{-- Alpine.js for interactivity --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full bg-[#F8FAF8] font-outfit" x-data="{ sidebarOpen: true, mobileMenuOpen: false }">

<div class="flex h-screen overflow-hidden">

    {{-- ── Mobile Sidebar Overlay ── --}}
    <div x-show="mobileMenuOpen" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click="mobileMenuOpen = false"
         class="fixed inset-0 z-50 bg-slate-900/60 backdrop-blur-sm lg:hidden"></div>

    {{-- ── SIDEBAR ── --}}
    <aside :class="sidebarOpen ? 'w-72' : 'w-20'" 
           class="fixed inset-y-0 left-0 z-50 flex flex-col bg-[#0F172A] transition-all duration-500 ease-[cubic-bezier(0.4,0,0.2,1)] lg:static lg:z-auto lg:translate-x-0"
           :class="mobileMenuOpen ? 'translate-x-0' : '-translate-x-full'">
        
        {{-- Logo Area --}}
        <div class="flex items-center h-16 px-6 border-b border-white/5">
            <div class="flex items-center gap-3 overflow-hidden">
                <div class="w-8 h-8 bg-gradient-to-tr from-teal-400 to-emerald-500 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                </div>
                <div class="transition-opacity duration-300" :class="sidebarOpen ? 'opacity-100' : 'opacity-0 w-0'">
                    <span class="text-white font-bold text-lg tracking-tight">Casa<span class="text-teal-400">Hogar</span></span>
                </div>
            </div>
        </div>

        {{-- Navigation --}}
        <nav class="flex-1 px-4 py-6 space-y-8 overflow-y-auto custom-scrollbar">
            
            {{-- General Section --}}
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" @class(['sidebar-item', 'active' => request()->routeIs('dashboard')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    <span x-show="sidebarOpen" x-transition>Panel General</span>
                </a>
            </div>

            {{-- Clinical Section --}}
            @if(auth()->user()->tienePermiso('pacientes.gestionar') || auth()->user()->tienePermiso('servicios.gestionar'))
            <div class="space-y-1">
                <p x-show="sidebarOpen" class="sidebar-section-title">Atención Clínica</p>
                @if(auth()->user()->tienePermiso('pacientes.gestionar'))
                <a href="{{ route('pacientes.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('pacientes.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Pacientes</span>
                </a>
                @endif
                @if(auth()->user()->tienePermiso('servicios.gestionar'))
                <a href="{{ route('servicios.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('servicios.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.675.337a6 6 0 00-3.86.517l-2.387.477a2 2 0 00-1.022.547l-1.162 1.163a2 2 0 00.597 3.301l1.56.445a4 4 0 001.142.164h12.162a4 4 0 001.142-.164l1.56-.445a2 2 0 00.597-3.301l-1.162-1.163z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Servicios</span>
                </a>
                @endif
            </div>
            @endif

            {{-- Operational Section --}}
            @if(auth()->user()->tienePermiso('personal.gestionar') || auth()->user()->tienePermiso('turnos.gestionar'))
            <div class="space-y-1">
                <p x-show="sidebarOpen" class="sidebar-section-title">Operaciones</p>
                @if(auth()->user()->tienePermiso('personal.gestionar'))
                <a href="{{ route('personal.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('personal.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/></svg>
                    <span x-show="sidebarOpen" x-transition>Personal</span>
                </a>
                @endif
                @if(auth()->user()->tienePermiso('turnos.gestionar'))
                <a href="{{ route('turnos.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('turnos.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Turnos</span>
                </a>
                @endif
            </div>
            @endif

            {{-- Admin Section --}}
            @if(auth()->user()->esAdmin() || auth()->user()->tienePermiso('facturacion.gestionar') || auth()->user()->tienePermiso('finanzas.gestionar'))
            <div class="space-y-1">
                <p x-show="sidebarOpen" class="sidebar-section-title">Administración</p>
                @if(auth()->user()->tienePermiso('facturacion.gestionar'))
                <a href="{{ route('facturacion.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('facturacion.*')])>
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Facturación</span>
                </a>
                @endif
                @if(auth()->user()->tienePermiso('finanzas.gestionar'))
                <a href="{{ route('finanzas.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('finanzas.*')]) title="Egresos y balances">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <span x-show="sidebarOpen" x-transition>Egresos / Finanzas</span>
                </a>
                @endif
                
                @if(auth()->user()->esAdmin())
                <div class="pt-2 mt-2 border-t border-white/5">
                    <p x-show="sidebarOpen" class="text-[9px] font-bold text-slate-500 uppercase px-4 mb-2 tracking-widest">Sistema</p>
                    <a href="{{ route('usuarios.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('usuarios.*')])>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                        <span x-show="sidebarOpen" x-transition>Usuarios</span>
                    </a>
                    <a href="{{ route('roles.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('roles.*')])>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A3.323 3.323 0 0010.603 3.303l-2.408 2.41a3.323 3.323 0 000 4.699 3.323 3.323 0 004.699 0l2.408-2.41a3.323 3.323 0 000-4.699zM12 14a3 3 0 110-6 3 3 0 010 6z"/></svg>
                        <span x-show="sidebarOpen" x-transition>Roles</span>
                    </a>
                    <a href="{{ route('configuracion.index') }}" @class(['sidebar-item', 'active' => request()->routeIs('configuracion.*')])>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                        <span x-show="sidebarOpen" x-transition>Configuración</span>
                    </a>
                </div>
                @endif
            </div>
            @endif
        </nav>

        {{-- Sidebar Footer --}}
        <div class="p-4 border-t border-white/5">
            <div class="bg-white/5 rounded-2xl p-4 flex items-center gap-3">
                <div class="w-8 h-8 bg-teal-500 rounded-xl flex items-center justify-center font-bold text-white shadow-lg">
                    {{ strtoupper(substr(auth()->user()->nombre_usuario, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0" x-show="sidebarOpen" x-transition>
                    <p class="text-white text-sm font-semibold truncate">{{ auth()->user()->nombre_usuario }}</p>
                    <p class="text-slate-400 text-xs truncate">{{ optional(auth()->user()->rol)->nombre_rol }}</p>
                </div>
            </div>
        </div>
    </aside>

    {{-- ── MAIN CONTENT AREA ── --}}
    <div class="flex-1 flex flex-col min-w-0 bg-[#F8FAF8]">
        
        {{-- Glass Top Nav --}}
        <header class="h-16 glass-header flex items-center justify-between px-8 flex-shrink-0">
            <div class="flex items-center gap-4">
                <button @click="mobileMenuOpen = true" class="p-2 text-slate-500 lg:hidden">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                </button>
                <button @click="sidebarOpen = !sidebarOpen" class="hidden lg:block p-2 text-slate-400 hover:text-teal-600 transition-colors">
                    <svg class="w-5 h-5" :class="!sidebarOpen && 'rotate-180'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/></svg>
                </button>
                <div class="ml-2">
                    <h2 class="text-xl font-bold text-slate-800 tracking-tight">@yield('page-title', 'Dashboard')</h2>
                    <nav class="text-[10px] font-bold text-slate-400 uppercase tracking-widest flex items-center gap-2">
                        <span>CasaHogar</span>
                        <svg class="w-2 h-2" fill="currentColor" viewBox="0 0 20 20"><path d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"/></svg>
                        @yield('breadcrumb', 'Overview')
                    </nav>
                </div>
            </div>

            <div class="flex items-center gap-4">
                {{-- Quick Notifications --}}
                <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors relative">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></button>
                    <span class="absolute top-2 right-2 w-2 h-2 bg-rose-500 rounded-full border-2 border-white"></span>
                </button>

                <div class="h-6 w-px bg-slate-200 mx-1"></div>
                
                @yield('header-actions')

                {{-- Profile Dropdown --}}
                <div class="relative" x-data="{ open: false }" @click.away="open = false">
                    <button @click="open = !open" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-2xl hover:bg-slate-50 transition-colors group">
                        <div class="text-right hidden md:block">
                            <p class="text-xs font-bold text-slate-800 leading-none group-hover:text-teal-600 transition-colors">{{ auth()->user()->nombre_usuario }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ optional(auth()->user()->rol)->nombre_rol }}</p>
                        </div>
                        <div class="w-8 h-8 bg-gradient-to-tr from-slate-100 to-slate-200 rounded-full flex items-center justify-center border-2 border-white shadow-sm ring-1 ring-slate-100 group-hover:ring-teal-200 transition-all">
                             <span class="text-slate-600 text-[10px] font-bold">{{ strtoupper(substr(auth()->user()->nombre_usuario, 0, 1)) }}</span>
                        </div>
                    </button>

                    <div x-show="open" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-[60]">
                        
                        <div class="px-4 py-3 border-b border-slate-50 mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Cuenta</p>
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nombre_usuario }}</p>
                        </div>

                        <a href="{{ route('configuracion.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-teal-600 transition-all font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configuración
                        </a>

                        <div class="border-t border-slate-50 my-2"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-all font-bold text-left">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        {{-- Main Viewport --}}
        <main class="flex-1 overflow-y-auto px-8 py-8 custom-scrollbar">
            
            {{-- Notifications Area --}}
            <div class="mb-6 space-y-3">
                @if(session('success'))
                    <div class="animate-fade-in flex items-center gap-4 bg-emerald-500 text-white p-4 rounded-2xl shadow-lg shadow-emerald-500/20">
                        <div class="bg-white/20 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-sm font-semibold">{{ session('success') }}</span>
                    </div>
                @endif
                @if(session('error'))
                    <div class="animate-fade-in flex items-center gap-4 bg-rose-500 text-white p-4 rounded-2xl shadow-lg shadow-rose-500/20">
                        <div class="bg-white/20 p-2 rounded-xl">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                        </div>
                        <span class="text-sm font-semibold">{{ session('error') }}</span>
                    </div>
                @endif
            </div>

            {{-- Content Slot --}}
            <div class="animate-fade-in">
                @yield('content')
            </div>
        </main>

        {{-- Minimal Footer --}}
        <footer class="px-8 py-4 bg-white/50 border-t border-slate-200/60 text-[10px] font-bold text-slate-400 uppercase tracking-[0.2em] flex justify-between">
            <span>&copy; {{ date('Y') }} CasaHogar Management System</span>
            <span class="text-teal-500">v2.1.0 Premium</span>
        </footer>
    </div>
</div>

<style>
    .custom-scrollbar::-webkit-scrollbar { width: 6px; }
    .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #E2E8F0; border-radius: 10px; }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #CBD5E1; }
</style>

@stack('scripts')
</body>
</html>
