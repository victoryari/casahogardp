<nav x-data="{ open: false, userMenuOpen: false }" class="bg-white/80 backdrop-blur-md border-b border-slate-200/60 sticky top-0 z-50 transition-all duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            
            {{-- Left Side: Logo & Search --}}
            <div class="flex items-center gap-8">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                    <div class="w-8 h-8 bg-gradient-to-tr from-teal-500 to-emerald-400 rounded-xl flex items-center justify-center shadow-lg shadow-teal-500/20 group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    </div>
                    <span class="text-lg font-bold text-slate-800 tracking-tight">Divina<span class="text-teal-500">Providencia</span></span>
                </a>

                {{-- Search Mockup (Visual Only) --}}
                <div class="hidden md:flex items-center">
                    <div class="relative group">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-4 w-4 text-slate-400 group-focus-within:text-teal-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <input type="text" placeholder="Buscar..." class="block w-64 pl-10 pr-3 py-1.5 bg-slate-100 border-none rounded-xl text-xs text-slate-600 focus:ring-2 focus:ring-teal-500/20 focus:bg-white transition-all">
                    </div>
                </div>
            </div>

            {{-- Right Side: Profile --}}
            <div class="hidden sm:flex sm:items-center sm:gap-4">
                
                {{-- Quick Actions? (Optional) --}}
                <button class="p-2 text-slate-400 hover:text-slate-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></button>
                
                <div class="h-6 w-px bg-slate-200 mx-2"></div>

                {{-- Profile Dropdown --}}
                <div class="relative" @click.away="userMenuOpen = false">
                    <button @click="userMenuOpen = !userMenuOpen" class="flex items-center gap-3 pl-2 pr-1 py-1 rounded-2xl hover:bg-slate-50 transition-colors group">
                        <div class="text-right hidden lg:block">
                            <p class="text-xs font-bold text-slate-800 leading-none group-hover:text-teal-600 transition-colors">{{ auth()->user()->nombre_usuario }}</p>
                            <p class="text-[9px] font-bold text-slate-400 uppercase tracking-widest mt-1">{{ optional(auth()->user()->rol)->nombre_rol }}</p>
                        </div>
                        <div class="w-8 h-8 bg-gradient-to-tr from-slate-100 to-slate-200 rounded-full flex items-center justify-center border-2 border-white shadow-sm ring-1 ring-slate-100 group-hover:ring-teal-200 transition-all">
                             <span class="text-slate-600 text-[10px] font-bold">{{ strtoupper(substr(auth()->user()->nombre_usuario, 0, 1)) }}</span>
                        </div>
                    </button>

                    {{-- Dropdown Menu --}}
                    <div x-show="userMenuOpen" 
                         x-transition:enter="transition ease-out duration-200"
                         x-transition:enter-start="opacity-0 scale-95 translate-y-2"
                         x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                         x-transition:leave="transition ease-in duration-75"
                         x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                         x-transition:leave-end="opacity-0 scale-95 translate-y-2"
                         class="absolute right-0 mt-3 w-56 bg-white rounded-2xl shadow-2xl border border-slate-100 py-2 z-[60]">
                        
                        <div class="px-4 py-3 border-b border-slate-50 mb-2">
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Identificado como</p>
                            <p class="text-sm font-bold text-slate-800">{{ auth()->user()->nombre_usuario }}</p>
                        </div>

                        <a href="{{ route('configuracion.index') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm text-slate-600 hover:bg-slate-50 hover:text-teal-600 transition-all font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            Configuración
                        </a>

                        <div class="border-t border-slate-50 my-2"></div>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full flex items-center gap-3 px-4 py-2.5 text-sm text-rose-600 hover:bg-rose-50 transition-all font-bold">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                Cerrar Sesión
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Mobile Toggle --}}
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="p-2 rounded-xl text-slate-500 hover:bg-slate-100 transition-colors">
                    <svg class="h-5 w-5" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         class="sm:hidden border-t border-slate-100 bg-white">
        <div class="pt-2 pb-3 space-y-1 px-4">
            <a href="{{ route('dashboard') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-600 transition-all">Dashboard</a>
            <a href="{{ route('pacientes.index') }}" class="block px-4 py-2.5 rounded-xl text-sm font-semibold text-slate-700 hover:bg-teal-50 hover:text-teal-600 transition-all">Pacientes</a>
        </div>
        <div class="pt-4 pb-1 border-t border-slate-100 px-4">
            <div class="flex items-center gap-3 px-4 py-3">
                <div class="w-8 h-8 bg-teal-500 rounded-xl flex items-center justify-center text-white font-bold text-xs">{{ strtoupper(substr(auth()->user()->nombre_usuario, 0, 1)) }}</div>
                <div>
                    <div class="text-sm font-bold text-slate-800">{{ auth()->user()->nombre_usuario }}</div>
                    <div class="text-[10px] text-slate-400 font-medium">{{ optional(auth()->user()->rol)->nombre_rol }}</div>
                </div>
            </div>
            <div class="mt-2 space-y-1 pb-4">
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="w-full text-left px-8 py-2.5 text-rose-600 font-bold text-sm hover:bg-rose-50 transition-colors">Cerrar Sesión</button>
                </form>
            </div>
        </div>
    </div>
</nav>
