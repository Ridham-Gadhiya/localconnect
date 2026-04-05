</div> <footer class="bg-dark text-white pt-5 pb-4 mt-5 position-relative overflow-hidden">
    <div class="position-absolute top-0 start-0 w-100 h-100 opacity-10" 
         style="background: radial-gradient(circle at 10% 20%, rgb(37, 99, 235) 0%, transparent 40%);"></div>

    <div class="container position-relative z-index-2">
        <div class="row g-5">
            <div class="col-lg-4 col-md-12">
                <a class="navbar-brand fw-bold d-flex align-items-center mb-4 text-white" href="../index.php">
                    <div class="bg-primary rounded-3 p-2 me-2 d-flex align-items-center justify-content-center shadow-lg" style="width: 38px; height: 38px;">
                        <i class="fas fa-plug-circle-check fs-5 text-white"></i>
                    </div>
                    <span class="fs-4 ls-tight">LocalConnect</span>
                </a>
                <p class="text-secondary small pe-lg-5 mb-4">
                    Empowering local communities by bridging the gap between skilled service providers and those who seek excellence. Join the ecosystem of trusted professionals.
                </p>
                <div class="d-flex gap-2 mt-4">
                    <a href="#" class="social-btn" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social-btn" aria-label="Twitter"><i class="fab fa-x-twitter"></i></a>
                    <a href="#" class="social-btn" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="social-btn" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                </div>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="fw-bold text-white mb-4 text-uppercase small ls-2">Services</h6>
                <ul class="list-unstyled footer-nav">
                    <li><a href="search_services.php">Find Plumbers</a></li>
                    <li><a href="search_services.php">Electricians</a></li>
                    <li><a href="search_services.php">Home Cleaning</a></li>
                    <li><a href="search_services.php">Mechanics</a></li>
                </ul>
            </div>

            <div class="col-lg-2 col-md-4 col-6">
                <h6 class="fw-bold text-white mb-4 text-uppercase small ls-2">Platform</h6>
                <ul class="list-unstyled footer-nav">
                    <li><a href="user/my_bookings.php">My Account</a></li>
                    <li><a href="auth/register_provider.php">Become a Pro</a></li>
                    <li><a href="#">Security Guide</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                </ul>
            </div>

            <div class="col-lg-4 col-md-4">
                <h6 class="fw-bold text-white mb-4 text-uppercase small ls-2">Stay Updated</h6>
                <p class="text-secondary small mb-4">Subscribe to get the latest service updates and local offers.</p>
                <form class="input-group mb-4 custom-newsletter">
                    <input type="email" class="form-control bg-secondary bg-opacity-10 border-0 text-white" placeholder="Email Address" aria-label="Email">
                    <button class="btn btn-primary" type="button"><i class="fas fa-paper-plane"></i></button>
                </form>
                <div class="contact-pill d-flex align-items-center bg-white bg-opacity-5 rounded-pill p-2">
                    <div class="icon-sm bg-primary rounded-circle me-3"><i class="fas fa-headset text-white"></i></div>
                    <div>
                        <p class="x-small text-secondary mb-0">24/7 Support</p>
                        <p class="small fw-bold mb-0 text-white">+91 98765 43210</p>
                    </div>
                </div>
            </div>
        </div>

        <hr class="my-5 border-secondary opacity-25">

        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                <p class="mb-0 text-secondary x-small">
                    &copy; <?= date("Y"); ?> <span class="text-white fw-bold">LocalConnect</span>. Designed for college capstone excellence.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <div class="d-flex justify-content-center justify-content-md-end gap-3 x-small">
                    <a href="#" class="text-secondary text-decoration-none">Privacy</a>
                    <a href="#" class="text-secondary text-decoration-none">Terms</a>
                    <a href="#" class="text-secondary text-decoration-none">Sitemap</a>
                </div>
            </div>
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>