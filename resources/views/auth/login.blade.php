<x-layouts.auth>
    <h1 class="text-2xl font-extrabold text-navy tracking-tight mb-1">Masuk Admin</h1>
    <p class="text-sm text-[#667085] mb-8">Gunakan email & password akun Admin kamu.</p>

    <x-auth-session-status class="mb-5" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="text-sm font-medium text-navy">Email</label>
            <div class="relative mt-1.5">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4.5 h-4.5 text-[#98A2B3]" style="width:1.1rem;height:1.1rem" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                    class="w-full border border-[#E5E7EB] rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue transition-all">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <div>
            <label for="password" class="text-sm font-medium text-navy">Password</label>
            <div class="relative mt-1.5">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 text-[#98A2B3]" style="width:1.1rem;height:1.1rem" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full border border-[#E5E7EB] rounded-xl pl-11 pr-4 py-3 focus:outline-none focus:ring-2 focus:ring-accent-blue/20 focus:border-accent-blue transition-all">
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        <label class="flex items-center gap-2 text-sm text-[#667085]">
            <input id="remember_me" type="checkbox" name="remember" class="rounded border-[#E5E7EB] text-accent-blue focus:ring-accent-blue/20">
            Ingat saya
        </label>

        <button type="submit" class="group w-full bg-gradient-to-r from-navy to-accent-blue text-white rounded-xl py-3.5 font-bold hover:shadow-lg hover:shadow-accent-blue/25 transition-all duration-300 mt-2 flex items-center justify-center gap-2">
            Masuk
            <svg class="w-4 h-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m-6-6l6 6-6 6"/></svg>
        </button>

        @if (Route::has('password.request'))
            <a href="{{ route('password.request') }}" class="block text-center text-sm text-[#667085] hover:text-accent-blue transition-colors">
                Lupa password?
            </a>
        @endif
    </form>

    <a href="{{ route('home') }}" class="flex items-center justify-center gap-1.5 text-sm text-[#667085] hover:text-accent-blue mt-6 transition-colors">
        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
        Kembali ke Beranda
    </a>
</x-layouts.auth>