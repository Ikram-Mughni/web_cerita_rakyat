// assets/JS/script.js

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Smooth Scroll untuk link internal
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });

    // 2. Fungsi untuk menghilangkan notifikasi sukses/gagal (Kecuali alert-info)
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        
        // Cek apakah alert BUKAN alert-info (yang digunakan untuk pesan login)
        if (!alert.classList.contains('alert-info')) {
            
            // Atur waktu hilangnya alert (5 detik)
            setTimeout(() => {
                alert.style.transition = 'opacity 1s ease'; // Tambahkan transisi
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 1000);
            }, 5000); 
        }
        // JIKA alert adalah alert-info, kode ini dilewati, dan alert tetap ada.
    });


    // 3. Tambahkan dan kelola tombol "Scroll to Top"
    const body = document.querySelector('body');
    const scrollButton = document.createElement('button');
    scrollButton.classList.add('btn', 'btn-info', 'text-white', 'shadow-lg');
    scrollButton.style.position = 'fixed';
    scrollButton.style.bottom = '20px';
    scrollButton.style.right = '20px';
    scrollButton.style.display = 'none'; 
    scrollButton.innerHTML = '&#8593;'; 
    scrollButton.title = 'Kembali ke Atas';
    
    body.appendChild(scrollButton);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollButton.style.display = 'block';
        } else {
            scrollButton.style.display = 'none';
        }
    });

    scrollButton.addEventListener('click', () => {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });

});