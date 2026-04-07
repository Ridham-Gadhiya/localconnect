<?php include 'includes/header.php'; ?>
<link rel="stylesheet" href="../assets/css/landing.css">

<main class="landing-page">
    <section class="premium-hero">
        <div class="container">
            <div class="row align-items-center min-vh-75 py-5">
                <div class="col-lg-6 text-center text-lg-start pe-lg-5">
                    <div class="hero-badge mb-4 animate-fade-in">
                        <span class="badge-pill"><i class="fas fa-sparkles me-2 text-warning"></i> Trusted by 2000+ Locals</span>
                    </div>
                    <h1 class="hero-title display-2 fw-extrabold mb-4">
                        Quality Services <br>
                        <span class="text-gradient">Right at Your Door.</span>
                    </h1>
                    <p class="hero-description lead mb-5 opacity-75">
                        The smartest way to find local experts. Verified professionals, 
                        instant scheduling, and transparent pricing in one elegant platform.
                    </p>
                    <div class="d-flex flex-column flex-sm-row justify-content-center justify-content-lg-start gap-3">
                        <a href="auth/register_user.php" class="btn btn-primary btn-lg px-5 btn-pill shadow-lg">
                            Get Started Now <i class="fas fa-arrow-right ms-2"></i>
                        </a>
                        <a href="auth/login.php" class="btn btn-outline-dark btn-lg px-5 btn-pill">
                            Member Login
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 d-none d-lg-block">
                    <div class="hero-visual-container">
                        <div class="floating-card c-1 shadow-lg animate-float">
                            <i class="fas fa-check-circle text-success me-2"></i> 100% Verified
                        </div>
                        <div class="floating-card c-2 shadow-lg animate-float-delayed">
                            <i class="fas fa-star text-warning me-2"></i> 4.9 Avg Rating
                        </div>
                        <img src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&q=80&w=800" alt="Professional Service" class="hero-img rounded-5 shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="category-section py-5 bg-white">
        <div class="container py-4">
            <div class="section-header text-center mb-5">
                <h2 class="fw-bold text-dark">Popular Categories</h2>
                <p class="text-muted">What do you need help with today?</p>
            </div>
            <div class="row g-3 justify-content-center">
                <?php 
                $cats = [
                    ['icon' => 'fa-bolt', 'name' => 'Electrician'],
                    ['icon' => 'fa-faucet', 'name' => 'Plumbing'],
                    ['icon' => 'fa-broom', 'name' => 'Cleaning'],
                    ['icon' => 'fa-hammer', 'name' => 'Carpentry'],
                    ['icon' => 'fa-paint-roller', 'name' => 'Painting'],
                    ['icon' => 'fa-bug', 'name' => 'Pest Control']
                ];
                foreach($cats as $cat): ?>
                <div class="col-6 col-md-4 col-lg-2">
                    <a href="user/search_services.php" class="category-card shadow-sm border">
                        <i class="fas <?= $cat['icon'] ?> mb-2"></i>
                        <span><?= $cat['name'] ?></span>
                    </a>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <section class="how-it-works py-5 bg-light">
        <div class="container">
            <div class="section-header text-center mb-5">
                <h6 class="text-primary fw-bold ls-2">SIMPLE WORKFLOW</h6>
                <h2 class="fw-bold">How it Works</h2>
            </div>
            <div class="row g-4 text-center">
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">1</div>
                        <h5 class="fw-bold">Search</h5>
                        <p class="small text-muted">Find the service you need from our vetted directory.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">2</div>
                        <h5 class="fw-bold">Book</h5>
                        <p class="small text-muted">Select a professional and schedule a convenient time.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="step-item">
                        <div class="step-number">3</div>
                        <h5 class="fw-bold">Relax</h5>
                        <p class="small text-muted">Sit back while the expert handles the job perfectly.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="features-section py-5">
        <div class="container py-5">
            <div class="section-header text-center mb-5">
                <h6 class="text-primary text-uppercase fw-bold ls-2">The Difference</h6>
                <h2 class="display-5 fw-bold text-dark">Why LocalConnect?</h2>
                <div class="accent-line mx-auto"></div>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="glass-feature h-100">
                        <div class="icon-box bg-blue">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h4 class="fw-bold mt-4">Vetted Experts</h4>
                        <p class="text-muted">Rigorous background checks and skill verification for every single provider.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-feature h-100 highlighted">
                        <div class="icon-box bg-green">
                            <i class="fas fa-calendar-check"></i>
                        </div>
                        <h4 class="fw-bold mt-4">Fast Scheduling</h4>
                        <p class="text-muted">Book your service in seconds. Pick a time that works perfectly for your schedule.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="glass-feature h-100">
                        <div class="icon-box bg-purple">
                            <i class="fas fa-fingerprint"></i>
                        </div>
                        <h4 class="fw-bold mt-4">Secure Payment</h4>
                        <p class="text-muted">Transparent pricing with secure digital payments. No hidden fees, ever.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="container mb-5 pb-5">
        <div class="cta-gradient-box rounded-5 p-5 text-center text-white shadow-2xl overflow-hidden position-relative">
            <div class="bg-pattern-overlay"></div>
            <div class="position-relative z-index-2 py-4">
                <h2 class="display-4 fw-extrabold mb-3">Ready to scale your business?</h2>
                <p class="lead mb-5 opacity-75">Join our elite network of local service providers and find your next client today.</p>
                <a href="auth/register_provider.php" class="btn btn-warning btn-pill btn-lg px-5 fw-bold hover-scale shadow">
                    Join as a Provider <i class="fas fa-user-tie ms-2"></i>
                </a>
            </div>
        </div>
    </section>
</main>

<?php include 'includes/footer.php'; ?>