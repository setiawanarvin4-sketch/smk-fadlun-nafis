// Matikan pemulihan posisi scroll otomatis dari browser. Tanpa ini, kalau
// halaman di-refresh saat sedang di posisi scroll tertentu, browser suka
// "melompat" dulu ke posisi lama (misal ke section Sambutan) sebelum
// akhirnya balik ke atas — bikin kesan halaman loncat-loncat pas dibuka.
if ('scrollRestoration' in history) {
    history.scrollRestoration = 'manual';
}
window.scrollTo(0, 0);

// Livewire v4 sudah membawa & menyalakan Alpine.js sendiri secara otomatis
// (lewat @livewireScripts). JANGAN import/start Alpine manual di sini lagi.

// Scroll-reveal: elemen dengan atribut data-reveal muncul halus saat masuk layar
document.addEventListener('DOMContentLoaded', () => {
    const activeNavLink = document.querySelector('#admin-sidebar-nav .nav-active');
    if (activeNavLink) {
        activeNavLink.scrollIntoView({ block: 'center' });
    }
    const items = document.querySelectorAll('[data-reveal]');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('reveal-in');
                observer.unobserve(entry.target);
            }
        });
    }, { threshold: 0.12 });
    items.forEach((el) => observer.observe(el));

    // Jaring pengaman: kalau animasi reveal belum sempat jalan (observer
    // telat/gagal), paksa tampilkan kontennya supaya tidak nyangkut
    // transparan permanen.
    setTimeout(() => {
        document.querySelectorAll('[data-reveal]:not(.reveal-in)').forEach((el) => {
            el.classList.add('reveal-in');
        });
    }, 2500);

    // Angka statistik "menghitung naik" (count-up) saat masuk layar
    const counters = document.querySelectorAll('[data-counter]');
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting) return;
            const el = entry.target;
            const raw = el.getAttribute('data-counter') || '0';
            const suffix = (raw.match(/[^\d.,]+$/) || [''])[0];
            const target = parseInt(raw.replace(/[^\d]/g, ''), 10) || 0;
            const duration = 1500;
            const start = performance.now();

            function tick(now) {
                const progress = Math.min((now - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                const current = Math.floor(eased * target);
                el.textContent = current.toLocaleString('id-ID') + suffix;
                if (progress < 1) {
                    requestAnimationFrame(tick);
                } else {
                    el.textContent = target.toLocaleString('id-ID') + suffix;
                }
            }
            requestAnimationFrame(tick);
            counterObserver.unobserve(el);
        });
    }, { threshold: 0.3 });
    counters.forEach((el) => counterObserver.observe(el));
});

// Toast notifikasi global — nangkep event 'notify' yang di-dispatch dari
// komponen Livewire manapun ($this->dispatch('notify', message: '...', type: 'success'|'error')).
// Tanpa ini, notifikasi sukses/gagal di beberapa halaman (Admin FAQ,
// Pengumuman Guru, User, Guru Profil, Guru Dashboard) tidak pernah kelihatan.
document.addEventListener('livewire:init', () => {
    Livewire.on('notify', (event) => {
        const { message, type } = Array.isArray(event) ? event[0] : event;
        if (!message) return;

        let container = document.getElementById('toast-container');
        if (!container) {
            container = document.createElement('div');
            container.id = 'toast-container';
            container.className = 'fixed top-4 right-4 z-[300] flex flex-col gap-2 items-end';
            document.body.appendChild(container);
        }

        const isError = type === 'error';
        const toast = document.createElement('div');
        toast.className = 'flex items-center gap-2.5 px-4 py-3 rounded-xl shadow-lg text-sm font-medium text-white max-w-sm transition-all duration-300 translate-x-4 opacity-0'
            + (isError ? ' bg-red-500' : ' bg-emerald-600');
        toast.innerHTML = (isError
            ? '<svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126zM12 15.75h.007v.008H12v-.008z"/></svg>'
            : '<svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24"><path stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>')
            + '<span>' + message + '</span>';

        container.appendChild(toast);
        requestAnimationFrame(() => {
            toast.classList.remove('translate-x-4', 'opacity-0');
        });

        setTimeout(() => {
            toast.classList.add('opacity-0');
            setTimeout(() => toast.remove(), 300);
        }, 4000);
    });
});