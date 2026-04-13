<footer class="site-footer">
    <div class="container">
        <div class="row g-5 footer-top">

            {{-- Tentang --}}
            <div class="col-lg-5 col-md-12 mb-4">
                <h5 class="footer-title">Perpustakaan Nasional</h5>
                <p class="footer-desc">
                    Platform perpustakaan nasional dan digital yang memudahkan
                    kamu mencari dan meminjam buku kapan saja dan di mana saja.
                </p>
            </div>

            {{-- Navigasi --}}
            <div class="col-lg-3 col-md-6 mb-4">
                
            </div>

            {{-- Kontak --}}
            <div class="col-lg-4 col-md-6 mb-4">
                <h5 class="footer-title">Kontak</h5>
                <div class="contact-item">
                    <div class="contact-icon">📍</div>
                    <p class="contact-text">Jl. Perpustakaan No. 123, Bandung</p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">📞</div>
                    <p class="contact-text">0812-3456-7890</p>
                </div>
                <div class="contact-item">
                    <div class="contact-icon">✉️</div>
                    <p class="contact-text">perpusku@email.com</p>
                </div>
            </div>

        </div>

        {{-- Bottom Bar --}}
        <div class="footer-bottom">
            <p class="footer-copy">© 2026 Perpustakaan Nasional. All Rights Reserved.</p>
            <p class="footer-brand">Est. 2026</p>
        </div>
    </div>
</footer>
<style>
    /* ── Footer ── */
.site-footer {
    background: #3A2010;
    font-family: 'Jost', sans-serif;
    padding: 56px 0 0;
}

.footer-top {
    padding-bottom: 3rem;
}

.footer-title {
    font-family: 'Cormorant Garamond', serif;
    font-size: 18px;
    font-weight: 600;
    color: #F5E6CC;
    letter-spacing: 0.04em;
    margin-bottom: 14px;
    padding-bottom: 10px;
    border-bottom: 1px solid rgba(212, 180, 130, 0.25);
}

.footer-desc {
    font-size: 13px;
    color: #B89A72;
    line-height: 1.8;
    font-weight: 300;
}

/* Nav links dengan animasi garis */
.footer-nav {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer-nav li {
    margin-bottom: 10px;
}

.footer-nav li a {
    font-size: 13px;
    color: #B89A72;
    text-decoration: none;
    letter-spacing: 0.04em;
    display: flex;
    align-items: center;
    gap: 8px;
    transition: color 0.2s, gap 0.2s;
}

.footer-nav li a::before {
    content: '';
    width: 14px;
    height: 1px;
    background: #7B4A2D;
    flex-shrink: 0;
    transition: width 0.2s;
}

.footer-nav li a:hover {
    color: #F5E6CC;
    gap: 12px;
}

.footer-nav li a:hover::before {
    width: 20px;
}

/* Kontak */
.contact-item {
    display: flex;
    align-items: flex-start;
    gap: 10px;
    margin-bottom: 12px;
}

.contact-icon {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    background: rgba(123, 74, 45, 0.25);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    flex-shrink: 0;
}

.contact-text {
    font-size: 13px;
    color: #B89A72;
    line-height: 1.6;
    font-weight: 300;
    margin: 0;
}

/* Bottom bar */
.footer-bottom {
    border-top: 1px solid rgba(212, 180, 130, 0.15);
    padding: 18px 0;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.footer-copy {
    font-size: 11px;
    color: #7A6248;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    margin: 0;
}

.footer-brand {
    font-family: 'Cormorant Garamond', serif;
    font-size: 13px;
    color: #7A6248;
    letter-spacing: 0.08em;
    margin: 0;
}
</style>