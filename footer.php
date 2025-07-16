<!-- Footer -->
<footer style="border-top: 4px solid #ee4d2d; background-color: #fef6f5;" id="contact">
    <div class="container" style="padding: 40px 0;">
        <div class="row">
            <!-- Kolom 1: Info Toko -->
            <div class="col-md-4">
                <h4 style="color: #ee4d2d;"><b>Lokalista – Etalase Produk Lokal Terbaik</b></h4>
                <p>Jl. Tanah Merah Indah 1 No.10C</p>
                <p><i class="fas fa-phone"></i> +62 878 0461 6097</p>
                <p><i class="fas fa-envelope"></i> o-cake@gmail.com</p>
            </div>

            <!-- Kolom 2: Menu Navigasi -->
            <div class="col-md-4">
                <h5 style="color: #ee4d2d;"><b>Menu</b></h5>
                <p><a href="produk.php" style="color: #333; text-decoration: none;">Produk</a></p>
                <p><a href="tentang.php" style="color: #333; text-decoration: none;">Tentang Kami</a></p>
                <p><a href="kontak.php" style="color: #333; text-decoration: none;">Hubungi Kami</a></p>
            </div>

            <!-- Kolom 3: Sosial Media -->
            <div class="col-md-4">
                <h5 style="color: #ee4d2d;"><b>Ikuti Kami</b></h5>
                <p>
                    <a href="https://facebook.com" target="_blank" style="color: #333; text-decoration: none;"><i class="fab fa-facebook"></i> Facebook</a>
                </p>
                <p>
                    <a href="https://instagram.com" target="_blank" style="color: #333; text-decoration: none;"><i class="fab fa-instagram"></i> Instagram</a>
                </p>
                <p>
                    <a href="https://wa.me/6287804616097" target="_blank" style="color: #333; text-decoration: none;"><i class="fab fa-whatsapp"></i> WhatsApp</a>
                </p>
            </div>
        </div>
    </div>

    <!-- Copyright -->
    <div class="copy" style="background-color: #ee4d2d; padding: 10px; color: #fff; text-align: center;">
        &copy; <?= date('Y') ?> Lokalista. All Rights Reserved.
    </div>
</footer>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        // Slider functionality
        let currentSlideIndex = 0;
        const slides = document.querySelectorAll('.slide');
        const dots = document.querySelectorAll('.nav-dot');

        function showSlide(index) {
            slides.forEach((slide, i) => {
                slide.classList.toggle('active', i === index);
            });
            dots.forEach((dot, i) => {
                dot.classList.toggle('active', i === index);
            });
        }

        function currentSlide(index) {
            currentSlideIndex = index - 1;
            showSlide(currentSlideIndex);
        }

        function nextSlide() {
            currentSlideIndex = (currentSlideIndex + 1) % slides.length;
            showSlide(currentSlideIndex);
        }

        // Auto-advance slides
        setInterval(nextSlide, 5000);

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Fade-in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in-up').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
            observer.observe(el);
        });

        // Add loading animation for product cards
        document.querySelectorAll('.product-card').forEach((card, index) => {
            card.style.animationDelay = `${index * 0.1}s`;
        });
    </script>
</body>
</html>