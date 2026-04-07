<?php include 'includes/header.php'; ?>

<main class="lc-landing">

    <!-- ===== HERO ===== -->
    <section class="lc-hero">
        <div class="lc-container lc-hero__inner">
            <div class="lc-hero__text">
                <div class="lc-badge">
                    <span class="lc-badge__dot"></span>
                    Trusted by 2,000+ locals in your city
                </div>
                <h1 class="lc-hero__headline">
                    Quality services,<br>
                    <span class="lc-hero__accent">right at your door.</span>
                </h1>
                <p class="lc-hero__sub">
                    Find verified local professionals in seconds — transparent pricing,
                    instant scheduling, and zero surprises.
                </p>
                <div class="lc-hero__actions">
                    <a href="auth/register_user.php" class="lc-btn lc-btn--primary">
                        Get started free
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="auth/login.php" class="lc-btn lc-btn--ghost">Member login</a>
                </div>
                <div class="lc-hero__trust">
                    <div class="lc-trust-avatars">
                        <span class="lc-avatar" style="background:#c7d7f7;color:#1a3a8a">AK</span>
                        <span class="lc-avatar" style="background:#d4f3e8;color:#0d5c3a">PR</span>
                        <span class="lc-avatar" style="background:#fce8d4;color:#7a3210">SM</span>
                        <span class="lc-avatar" style="background:#ede8fc;color:#3b2590">VN</span>
                    </div>
                    <span class="lc-trust-text">
                        <strong>4.9 ★</strong> from 1,200+ verified reviews
                    </span>
                </div>
            </div>
            <div class="lc-hero__visual" aria-hidden="true">
                <img
                    src="https://images.unsplash.com/photo-1581578731548-c64695cc6952?auto=format&fit=crop&q=80&w=900"
                    alt="Professional at work"
                    class="lc-hero__img"
                    loading="eager"
                >
                <div class="lc-hero__card lc-hero__card--tl">
                    <svg width="16" height="16" viewBox="0 0 16 16"><circle cx="8" cy="8" r="8" fill="#22c55e"/><path d="M5 8l2 2 4-4" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    100% background-verified
                </div>
                <div class="lc-hero__card lc-hero__card--br">
                    <svg width="16" height="16" viewBox="0 0 16 16"><path d="M8 1l1.8 3.6L14 5.6l-3 2.9.7 4.1L8 10.4l-3.7 2.2.7-4.1L2 5.6l4.2-.9L8 1z" fill="#f59e0b"/></svg>
                    Avg. 4.9 / 5 stars
                </div>
            </div>
        </div>
    </section>

    <!-- ===== LOGOS / SOCIAL PROOF ===== -->
    <div class="lc-social-proof">
        <div class="lc-container lc-social-proof__inner">
            <span class="lc-social-proof__label">As featured in</span>
            <span class="lc-social-proof__logo">Times of India</span>
            <span class="lc-social-proof__sep"></span>
            <span class="lc-social-proof__logo">YourStory</span>
            <span class="lc-social-proof__sep"></span>
            <span class="lc-social-proof__logo">Inc42</span>
            <span class="lc-social-proof__sep"></span>
            <span class="lc-social-proof__logo">Economic Times</span>
        </div>
    </div>

    <!-- ===== CATEGORIES ===== -->
    <section class="lc-section lc-section--white">
        <div class="lc-container">
            <div class="lc-section__header">
                <p class="lc-section__eyebrow">Browse services</p>
                <h2 class="lc-section__title">What do you need today?</h2>
                <p class="lc-section__desc">Pick a category and we'll match you with verified local pros instantly.</p>
            </div>
            <div class="lc-categories">
                <?php
                $cats = [
                    ['icon' => '⚡', 'name' => 'Electrician',   'count' => '48 pros'],
                    ['icon' => '🔧', 'name' => 'Plumbing',       'count' => '62 pros'],
                    ['icon' => '🧹', 'name' => 'Cleaning',       'count' => '91 pros'],
                    ['icon' => '🪵', 'name' => 'Carpentry',      'count' => '37 pros'],
                    ['icon' => '🖌️', 'name' => 'Painting',      'count' => '55 pros'],
                    ['icon' => '🐛', 'name' => 'Pest Control',   'count' => '29 pros'],
                ];
                foreach ($cats as $cat): ?>
                <a href="user/search_services.php" class="lc-cat-card">
                    <span class="lc-cat-card__icon"><?= $cat['icon'] ?></span>
                    <span class="lc-cat-card__name"><?= $cat['name'] ?></span>
                    <span class="lc-cat-card__count"><?= $cat['count'] ?></span>
                </a>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- ===== HOW IT WORKS ===== -->
    <section class="lc-section lc-section--tinted">
        <div class="lc-container">
            <div class="lc-section__header">
                <p class="lc-section__eyebrow">Simple workflow</p>
                <h2 class="lc-section__title">Three steps to done</h2>
            </div>
            <div class="lc-steps">
                <div class="lc-step">
                    <div class="lc-step__num">01</div>
                    <h3 class="lc-step__title">Search</h3>
                    <p class="lc-step__desc">Browse our vetted directory and filter by service, price, and availability.</p>
                </div>
                <div class="lc-step__connector" aria-hidden="true"></div>
                <div class="lc-step">
                    <div class="lc-step__num">02</div>
                    <h3 class="lc-step__title">Book</h3>
                    <p class="lc-step__desc">Pick a professional and select a time slot that suits your schedule.</p>
                </div>
                <div class="lc-step__connector" aria-hidden="true"></div>
                <div class="lc-step">
                    <div class="lc-step__num">03</div>
                    <h3 class="lc-step__title">Relax</h3>
                    <p class="lc-step__desc">Sit back while a verified expert handles the job — or your money back.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== FEATURES / WHY US ===== -->
    <section class="lc-section lc-section--white">
        <div class="lc-container">
            <div class="lc-section__header">
                <p class="lc-section__eyebrow">Why LocalConnect</p>
                <h2 class="lc-section__title">Built differently, on purpose.</h2>
                <p class="lc-section__desc">Every design decision starts with one question: what does the customer actually need?</p>
            </div>
            <div class="lc-features">
                <div class="lc-feature-card">
                    <div class="lc-feature-card__icon lc-feature-card__icon--blue">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><path d="M12 2L3 7v5c0 5.25 3.75 10.15 9 11.5C17.25 22.15 21 17.25 21 12V7l-9-5z" stroke="currentColor" stroke-width="1.7" stroke-linejoin="round"/></svg>
                    </div>
                    <h3 class="lc-feature-card__title">Vetted experts</h3>
                    <p class="lc-feature-card__desc">Rigorous background checks and skill verification before any provider joins the platform.</p>
                    <a href="auth/register_user.php" class="lc-feature-card__link">Learn how we vet →</a>
                </div>
                <div class="lc-feature-card lc-feature-card--featured">
                    <div class="lc-feature-card__icon lc-feature-card__icon--green">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="3" y="4" width="18" height="18" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M16 2v4M8 2v4M3 10h18" stroke="currentColor" stroke-width="1.7" stroke-linecap="round"/><path d="M8 14h.01M12 14h.01M16 14h.01M8 18h.01M12 18h.01" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg>
                    </div>
                    <span class="lc-feature-card__badge">Most popular</span>
                    <h3 class="lc-feature-card__title">Instant scheduling</h3>
                    <p class="lc-feature-card__desc">Book a service in under 60 seconds. Pick from real-time availability, not a call-back queue.</p>
                    <a href="auth/register_user.php" class="lc-feature-card__link">Try it now →</a>
                </div>
                <div class="lc-feature-card">
                    <div class="lc-feature-card__icon lc-feature-card__icon--purple">
                        <svg width="22" height="22" viewBox="0 0 24 24" fill="none"><rect x="2" y="5" width="20" height="15" rx="2" stroke="currentColor" stroke-width="1.7"/><path d="M2 10h20" stroke="currentColor" stroke-width="1.7"/><circle cx="6" cy="15" r="1" fill="currentColor"/><circle cx="10" cy="15" r="1" fill="currentColor"/></svg>
                    </div>
                    <h3 class="lc-feature-card__title">Secure payments</h3>
                    <p class="lc-feature-card__desc">Transparent pricing, digital invoices, and zero hidden fees. Pay only when satisfied.</p>
                    <a href="auth/register_user.php" class="lc-feature-card__link">See pricing →</a>
                </div>
            </div>
        </div>
    </section>

    <!-- ===== STATS ===== -->
    <section class="lc-stats-bar">
        <div class="lc-container lc-stats-bar__inner">
            <div class="lc-stat">
                <span class="lc-stat__num">2,400+</span>
                <span class="lc-stat__label">Happy customers</span>
            </div>
            <div class="lc-stat__divider" aria-hidden="true"></div>
            <div class="lc-stat">
                <span class="lc-stat__num">320+</span>
                <span class="lc-stat__label">Verified providers</span>
            </div>
            <div class="lc-stat__divider" aria-hidden="true"></div>
            <div class="lc-stat">
                <span class="lc-stat__num">4.9 ★</span>
                <span class="lc-stat__label">Average rating</span>
            </div>
            <div class="lc-stat__divider" aria-hidden="true"></div>
            <div class="lc-stat">
                <span class="lc-stat__num">15 min</span>
                <span class="lc-stat__label">Avg. booking time</span>
            </div>
        </div>
    </section>

    <!-- ===== PROVIDER CTA ===== -->
    <section class="lc-section lc-section--dark">
        <div class="lc-container lc-cta__inner">
            <div class="lc-cta__text">
                <p class="lc-section__eyebrow lc-section__eyebrow--light">For professionals</p>
                <h2 class="lc-cta__title">Ready to grow your business?</h2>
                <p class="lc-cta__desc">Join our network of local experts and get a steady pipeline of pre-qualified clients — no cold calls, no chasing.</p>
                <div class="lc-cta__actions">
                    <a href="auth/register_provider.php" class="lc-btn lc-btn--white">
                        Join as a provider
                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"><path d="M3 8h10M9 4l4 4-4 4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    </a>
                    <a href="auth/login.php" class="lc-btn lc-btn--ghost-white">Already a member?</a>
                </div>
            </div>
            <div class="lc-cta__checklist" aria-hidden="true">
                <?php
                $perks = [
                    'Free to join, no monthly fees',
                    'Get matched with nearby customers',
                    'Manage bookings from one dashboard',
                    'Get paid securely, on time',
                ];
                foreach ($perks as $perk): ?>
                <div class="lc-check-item">
                    <svg width="18" height="18" viewBox="0 0 18 18" fill="none"><circle cx="9" cy="9" r="9" fill="rgba(255,255,255,0.15)"/><path d="M5 9l3 3 5-5" stroke="#fff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <?= $perk ?>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

</main>

<?php include 'includes/footer.php'; ?>