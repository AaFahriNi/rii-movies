// Ambil elemen header
let header = document.querySelector('header');

// Tambahkan efek bayangan pada header saat scroll
window.addEventListener('scroll', () => {
    header.classList.toggle('shadow', window.scrollY > 0);
});

// Ambil elemen ikon menu dan navbar
let menu = document.querySelector('#menu-icon');
let navbar = document.querySelector('.navbar');

// Toggle menu dan navbar saat ikon menu diklik
menu.onclick = () => {
    menu.classList.toggle('bx-x'); // Ubah ikon menu
    navbar.classList.toggle('active'); // Tampilkan atau sembunyikan navbar
}

// Hapus class aktif dari menu dan navbar saat scroll
window.onscroll = () => {
    menu.classList.remove('bx-x'); // Kembalikan ikon menu ke bentuk semula
    navbar.classList.remove('active'); // Sembunyikan navbar
}

// Inisialisasi slider untuk elemen dengan class 'home'
var swiperHome = new Swiper(".home", {
    spaceBetween: 30, // Jarak antar slide
    centeredSlides: true, // Slide berada di tengah
    autoplay: {
        delay: 4000, // Interval 4 detik untuk berganti slide
        disableOnInteraction: false, // Autoplay tetap aktif meski pengguna berinteraksi
    },
    pagination: {
        el: ".swiper-pagination", // Elemen pagination
        clickable: true, // Pagination bisa diklik
    },
});

// Inisialisasi slider untuk elemen dengan class 'coming-container'
var swiperComing = new Swiper(".coming-container", {
    spaceBetween: 20, // Jarak antar slide
    loop: true, // Looping slider
    centeredSlides: true, // Slide berada di tengah
    autoplay: {
        delay: 2000, // Interval 2 detik untuk berganti slide
        disableOnInteraction: false, // Autoplay tetap aktif meski pengguna berinteraksi
    },
    breakpoints: {
        0: { slidesPerView: 2 }, // Tampilkan 2 slide pada layar kecil
        568: { slidesPerView: 3 }, // Tampilkan 3 slide pada layar sedang
        768: { slidesPerView: 4 }, // Tampilkan 4 slide pada layar besar
        968: { slidesPerView: 5 }, // Tampilkan 5 slide pada layar sangat besar
    }
});
