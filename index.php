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


<style>
    /* ==============================================
   LocalConnect — Landing Page Styles
   File: assets/css/landing.css
   ============================================== */

/* ---------- Reset & base ---------- */
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
    font-size: 16px;
    line-height: 1.65;
    color: #111827;
    background: #ffffff;
    -webkit-font-smoothing: antialiased;
}

img { display: block; max-width: 100%; }
a { text-decoration: none; color: inherit; }

/* ---------- Layout helpers ---------- */
.lc-container {
    width: 100%;
    max-width: 1180px;
    margin-inline: auto;
    padding-inline: clamp(1.25rem, 5vw, 2.5rem);
}

.lc-section {
    padding-block: clamp(4rem, 8vw, 6rem);
}

.lc-section--white  { background: #ffffff; }
.lc-section--tinted { background: #f8f9fb; }

.lc-section__header {
    max-width: 600px;
    margin-inline: auto;
    text-align: center;
    margin-bottom: clamp(2.5rem, 5vw, 3.5rem);
}

.lc-section__eyebrow {
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.12em;
    text-transform: uppercase;
    color: #4f46e5;
    margin-bottom: 0.6rem;
}

.lc-section__eyebrow--light { color: rgba(255,255,255,0.6); }

.lc-section__title {
    font-size: clamp(1.75rem, 3.5vw, 2.5rem);
    font-weight: 700;
    letter-spacing: -0.025em;
    line-height: 1.2;
    color: #0f172a;
    margin-bottom: 0.9rem;
}

.lc-section__desc {
    font-size: 1.0625rem;
    color: #64748b;
    line-height: 1.7;
}

/* ---------- Buttons ---------- */
.lc-btn {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9375rem;
    font-weight: 600;
    padding: 0.75rem 1.5rem;
    border-radius: 8px;
    transition: all 0.18s ease;
    cursor: pointer;
    border: 1.5px solid transparent;
    white-space: nowrap;
}

.lc-btn--primary {
    background: #4f46e5;
    color: #ffffff;
    border-color: #4f46e5;
}
.lc-btn--primary:hover { background: #4338ca; border-color: #4338ca; transform: translateY(-1px); box-shadow: 0 6px 20px rgba(79,70,229,0.35); }

.lc-btn--ghost {
    background: transparent;
    color: #374151;
    border-color: #d1d5db;
}
.lc-btn--ghost:hover { background: #f3f4f6; }

.lc-btn--white {
    background: #ffffff;
    color: #111827;
    border-color: #ffffff;
}
.lc-btn--white:hover { background: #f1f5f9; transform: translateY(-1px); }

.lc-btn--ghost-white {
    background: transparent;
    color: rgba(255,255,255,0.75);
    border-color: rgba(255,255,255,0.3);
}
.lc-btn--ghost-white:hover { background: rgba(255,255,255,0.1); color: #ffffff; }

/* ==============================================
   HERO
   ============================================== */
.lc-hero {
    background: #ffffff;
    padding-block: clamp(5rem, 10vw, 7rem);
    border-bottom: 1px solid #f1f5f9;
}

.lc-hero__inner {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: center;
}

/* Badge */
.lc-badge {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
    font-size: 0.8125rem;
    font-weight: 500;
    padding: 0.375rem 0.875rem;
    border-radius: 100px;
    margin-bottom: 1.5rem;
}

.lc-badge__dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #22c55e;
    animation: pulse-dot 2s infinite;
}

@keyframes pulse-dot {
    0%, 100% { opacity: 1; }
    50%       { opacity: 0.4; }
}

/* Headline */
.lc-hero__headline {
    font-size: clamp(2.5rem, 5vw, 3.75rem);
    font-weight: 800;
    letter-spacing: -0.04em;
    line-height: 1.1;
    color: #0f172a;
    margin-bottom: 1.25rem;
}

.lc-hero__accent {
    background: linear-gradient(135deg, #4f46e5, #7c3aed);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.lc-hero__sub {
    font-size: 1.125rem;
    color: #64748b;
    line-height: 1.7;
    max-width: 480px;
    margin-bottom: 2rem;
}

/* CTA row */
.lc-hero__actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}

/* Trust row */
.lc-hero__trust {
    display: flex;
    align-items: center;
    gap: 12px;
}

.lc-trust-avatars {
    display: flex;
}

.lc-avatar {
    width: 32px;
    height: 32px;
    border-radius: 50%;
    font-size: 0.6875rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #ffffff;
    margin-left: -8px;
}
.lc-trust-avatars .lc-avatar:first-child { margin-left: 0; }

.lc-trust-text {
    font-size: 0.875rem;
    color: #64748b;
}
.lc-trust-text strong { color: #0f172a; }

/* Visual column */
.lc-hero__visual {
    position: relative;
}

.lc-hero__img {
    width: 100%;
    aspect-ratio: 4/3;
    object-fit: cover;
    border-radius: 20px;
}

.lc-hero__card {
    position: absolute;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    padding: 0.625rem 1rem;
    font-size: 0.8125rem;
    font-weight: 600;
    color: #0f172a;
    display: flex;
    align-items: center;
    gap: 8px;
    box-shadow: 0 4px 24px rgba(0,0,0,0.09);
    white-space: nowrap;
}

.lc-hero__card--tl { top: -14px; left: -14px; }
.lc-hero__card--br { bottom: -14px; right: -14px; }

/* ==============================================
   SOCIAL PROOF BAR
   ============================================== */
.lc-social-proof {
    background: #f8f9fb;
    border-top: 1px solid #f1f5f9;
    border-bottom: 1px solid #f1f5f9;
    padding-block: 1.25rem;
}

.lc-social-proof__inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 1.5rem;
    flex-wrap: wrap;
}

.lc-social-proof__label {
    font-size: 0.75rem;
    font-weight: 600;
    letter-spacing: 0.1em;
    text-transform: uppercase;
    color: #94a3b8;
}

.lc-social-proof__logo {
    font-size: 0.875rem;
    font-weight: 700;
    color: #94a3b8;
    letter-spacing: -0.01em;
    transition: color 0.15s;
}
.lc-social-proof__logo:hover { color: #475569; }

.lc-social-proof__sep {
    width: 4px;
    height: 4px;
    border-radius: 50%;
    background: #cbd5e1;
}

/* ==============================================
   CATEGORIES
   ============================================== */
.lc-categories {
    display: grid;
    grid-template-columns: repeat(6, 1fr);
    gap: 1rem;
}

.lc-cat-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 1.5rem 1rem;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    transition: all 0.18s ease;
    text-align: center;
}
.lc-cat-card:hover {
    border-color: #c7d2fe;
    background: #f5f3ff;
    transform: translateY(-3px);
    box-shadow: 0 8px 24px rgba(79,70,229,0.1);
}

.lc-cat-card__icon { font-size: 1.75rem; line-height: 1; }
.lc-cat-card__name { font-size: 0.875rem; font-weight: 600; color: #1e293b; }
.lc-cat-card__count { font-size: 0.75rem; color: #94a3b8; }

/* ==============================================
   HOW IT WORKS
   ============================================== */
.lc-steps {
    display: flex;
    align-items: flex-start;
    justify-content: center;
    gap: 0;
}

.lc-step {
    flex: 1;
    text-align: center;
    padding: 0 2rem;
    max-width: 280px;
}

.lc-step__num {
    width: 56px;
    height: 56px;
    border-radius: 14px;
    background: #eef2ff;
    color: #4f46e5;
    font-size: 1.125rem;
    font-weight: 800;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.25rem;
    border: 1px solid #c7d2fe;
}

.lc-step__title {
    font-size: 1.0625rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.5rem;
}

.lc-step__desc { font-size: 0.9rem; color: #64748b; line-height: 1.6; }

.lc-step__connector {
    flex: 0 0 80px;
    height: 2px;
    background: repeating-linear-gradient(90deg, #c7d2fe 0, #c7d2fe 6px, transparent 6px, transparent 12px);
    margin-top: 28px;
    align-self: flex-start;
}

/* ==============================================
   FEATURES
   ============================================== */
.lc-features {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 1.25rem;
}

.lc-feature-card {
    padding: 2rem;
    border-radius: 16px;
    border: 1px solid #e2e8f0;
    background: #ffffff;
    transition: box-shadow 0.18s ease, transform 0.18s ease;
    display: flex;
    flex-direction: column;
    gap: 0;
}
.lc-feature-card:hover {
    box-shadow: 0 12px 36px rgba(0,0,0,0.08);
    transform: translateY(-3px);
}

.lc-feature-card--featured {
    border-color: #818cf8;
    border-width: 1.5px;
    box-shadow: 0 8px 32px rgba(79,70,229,0.12);
}

.lc-feature-card__icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-bottom: 1.25rem;
}
.lc-feature-card__icon--blue   { background: #eff6ff; color: #1d4ed8; }
.lc-feature-card__icon--green  { background: #f0fdf4; color: #15803d; }
.lc-feature-card__icon--purple { background: #faf5ff; color: #7e22ce; }

.lc-feature-card__badge {
    display: inline-block;
    background: #eff6ff;
    color: #1d4ed8;
    font-size: 0.7rem;
    font-weight: 700;
    letter-spacing: 0.08em;
    text-transform: uppercase;
    padding: 0.25rem 0.6rem;
    border-radius: 100px;
    margin-bottom: 0.75rem;
    align-self: flex-start;
}

.lc-feature-card__title {
    font-size: 1.125rem;
    font-weight: 700;
    color: #0f172a;
    margin-bottom: 0.6rem;
}

.lc-feature-card__desc {
    font-size: 0.9375rem;
    color: #64748b;
    line-height: 1.65;
    flex: 1;
    margin-bottom: 1.25rem;
}

.lc-feature-card__link {
    font-size: 0.875rem;
    font-weight: 600;
    color: #4f46e5;
    transition: gap 0.15s;
}
.lc-feature-card__link:hover { color: #4338ca; text-decoration: underline; }

/* ==============================================
   STATS BAR
   ============================================== */
.lc-stats-bar {
    background: #0f172a;
    padding-block: 3.5rem;
}

.lc-stats-bar__inner {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0;
    flex-wrap: wrap;
}

.lc-stat {
    text-align: center;
    padding: 0 3rem;
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.lc-stat__num {
    font-size: clamp(1.75rem, 3.5vw, 2.5rem);
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.03em;
    line-height: 1;
}

.lc-stat__label {
    font-size: 0.875rem;
    color: #64748b;
    font-weight: 400;
}

.lc-stat__divider {
    width: 1px;
    height: 50px;
    background: rgba(255,255,255,0.1);
    flex-shrink: 0;
}

/* ==============================================
   PROVIDER CTA
   ============================================== */
.lc-section--dark {
    background: #1e1b4b;
    padding-block: clamp(4rem, 8vw, 6rem);
}

.lc-cta__inner {
    display: grid;
    grid-template-columns: 1fr auto;
    align-items: center;
    gap: 4rem;
}

.lc-cta__title {
    font-size: clamp(1.75rem, 3.5vw, 2.75rem);
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.03em;
    line-height: 1.15;
    margin-bottom: 0.9rem;
}

.lc-cta__desc {
    font-size: 1.0625rem;
    color: rgba(255,255,255,0.6);
    line-height: 1.7;
    max-width: 500px;
    margin-bottom: 2rem;
}

.lc-cta__actions {
    display: flex;
    align-items: center;
    gap: 12px;
    flex-wrap: wrap;
}

.lc-cta__checklist {
    display: flex;
    flex-direction: column;
    gap: 0.875rem;
}

.lc-check-item {
    display: flex;
    align-items: center;
    gap: 10px;
    font-size: 0.9375rem;
    color: rgba(255,255,255,0.8);
    font-weight: 500;
    white-space: nowrap;
}

/* ==============================================
   RESPONSIVE
   ============================================== */

/* Tablet */
@media (max-width: 1024px) {
    .lc-hero__inner    { grid-template-columns: 1fr; gap: 3rem; }
    .lc-hero__visual   { display: none; }
    .lc-hero__sub      { max-width: 100%; }
    .lc-categories     { grid-template-columns: repeat(3, 1fr); }
    .lc-features       { grid-template-columns: repeat(2, 1fr); }
    .lc-cta__inner     { grid-template-columns: 1fr; gap: 2.5rem; }
    .lc-cta__checklist { flex-direction: row; flex-wrap: wrap; gap: 0.75rem 1.5rem; }
    .lc-check-item     { white-space: normal; }
}

/* Mobile */
@media (max-width: 640px) {
    .lc-categories          { grid-template-columns: repeat(2, 1fr); }
    .lc-features            { grid-template-columns: 1fr; }
    .lc-steps               { flex-direction: column; align-items: center; gap: 2rem; }
    .lc-step__connector     { display: none; }
    .lc-stats-bar__inner    { gap: 0; }
    .lc-stat                { padding: 1rem 1.5rem; }
    .lc-stat__divider       { display: none; }
    .lc-hero__actions       { flex-direction: column; align-items: flex-start; }
}
</style>