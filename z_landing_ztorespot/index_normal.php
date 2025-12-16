<?
require __DIR__ . "/includes/header.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= APP_URL ?>favicon.png">
    <link rel="canonical" href="<?= " http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <!-- Primary Meta Tags -->
    <title>Ztorespot.com - Your Dream Online Store within 2 mins</title>
    <meta name="title" content="Ztorespot.com - Your Dream Online Store within 2 mins" />
    <meta name="description"
        content="Plan to Start an Online Ecommerce Store? Ztorespot.com helps you to Create a beautiful E com website within 2 mins!. No coding requires!.Best Shopify alternative for small medium business owners." />

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website" />
    <meta property="og:url" content="<?= " http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" />
    <meta property="og:title" content="Ztorespot.com - Your Dream Online Store within 2 mins" />
    <meta property="og:description"
        content="Plan to Start an Online Ecommerce Store ? Ztorespot.com helps you to Create a beautiful E com website within 2 mins!. No coding requires!.Best Shopify Alternative for small medium business owners" />
    <meta property="og:image" content="<?= CONTROL_PANEL_UPLOADS . getData(" favicon", "settings") ?>" />

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image" />
    <meta property="twitter:url" content="<?= " http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>" />
    <meta property="twitter:title" content="Ztorespot.com - Your Dream Online Store within 2 mins" />
    <meta property="twitter:description"
        content="Plan to Start an Online Ecommerce Store ? Ztorespot.com helps you to Create a beautiful E com website within 5 mins!. No coding requires!." />
    <meta property="twitter:image" content="<?= CONTROL_PANEL_UPLOADS . getData(" favicon", "settings") ?>" />
    <script src="<?= APP_URL ?>/landing/tailwindcss/tailwind-3.4.17.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '674693734794365');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=674693734794365&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

    <!-- Google Tag Manager -->
    <script>
        (function(w, d, s, l, i) {
            w[l] = w[l] || [];
            w[l].push({
                'gtm.start': new Date().getTime(),
                event: 'gtm.js'
            });
            var f = d.getElementsByTagName(s)[0],
                j = d.createElement(s),
                dl = l != 'dataLayer' ? '&l=' + l : '';
            j.async = true;
            j.src =
                'https://www.googletagmanager.com/gtm.js?id=' + i + dl;
            f.parentNode.insertBefore(j, f);
        })(window, document, 'script', 'dataLayer', 'GTM-PXR9TRDF');
    </script>
    <!-- End Google Tag Manager -->
    <script type="text/javascript">
        (function(c, l, a, r, i, t, y) {
            c[a] = c[a] || function() {
                (c[a].q = c[a].q || []).push(arguments)
            };
            t = l.createElement(r);
            t.async = 1;
            t.src = "https://www.clarity.ms/tag/" + i;
            y = l.getElementsByTagName(r)[0];
            y.parentNode.insertBefore(t, y);
        })(window, document, "clarity", "script", "p8m5vdbei6");
    </script>

    <script type="text/javascript" src="https://d3mkw6s8thqya7.cloudfront.net/integration-plugin.js"
        id="aisensy-wa-widget" widget-id="UY5uLT">
    </script>

    <!-- Tailwind Configuration -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'inter': ['Inter', 'sans-serif'],
                    },
                    colors: {
                        'ztore-purple': '#8A00FF',
                        'ztore-pink': '#FF00A8',
                        'custom-dark': '#000',
                    },
                    animation: {
                        'logo-pulse': 'logoPulse 2s ease-in-out infinite',
                        'slide-in-left': 'slideInLeft 0.8s ease 0.2s forwards',
                        'slide-in-down': 'slideInDown 0.6s ease forwards',
                        'fade-in-up': 'fadeInUp 0.8s ease forwards',
                        'float': 'float 6s ease-in-out infinite',
                        'float-reverse': 'float 6s ease-in-out infinite reverse',
                    },
                    keyframes: {
                        logoPulse: {
                            '0%, 100%': {
                                transform: 'scale(1)'
                            },
                            '50%': {
                                transform: 'scale(1.1)'
                            },
                        },
                        slideInLeft: {
                            'from': {
                                opacity: '0',
                                transform: 'translateX(-30px)'
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateX(0)'
                            },
                        },
                        slideInDown: {
                            'from': {
                                opacity: '0',
                                transform: 'translateY(-10px)'
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        fadeInUp: {
                            'from': {
                                opacity: '0',
                                transform: 'translateY(30px)'
                            },
                            'to': {
                                opacity: '1',
                                transform: 'translateY(0)'
                            },
                        },
                        float: {
                            '0%, 100%': {
                                transform: 'translateY(0px) scale(1)'
                            },
                            '50%': {
                                transform: 'translateY(-20px) scale(1.05)'
                            },
                        },
                    },
                    backdropBlur: {
                        'xs': '2px',
                    },
                }
            }
        }
    </script>

    <!-- ===== CUSTOM STYLES ===== -->
    <style type="text/tailwindcss">
        /* ===== BASE STYLES ===== */
        @layer utilities {
            .bg-gradient-radial {
                background: radial-gradient(circle at 30% -10%, #1a0a2e, #000);
            }
            
            .text-gradient {
                background: linear-gradient(135deg, #8A00FF 0%, #FF00A8 100%);
                -webkit-background-clip: text;
                background-clip: text;
                -webkit-text-fill-color: transparent;
                color: transparent;
            }

            .gradient-border::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 0;
                height: 2px;
                background: linear-gradient(135deg, #8A00FF, #FF00A8);
                transition: width 0.3s ease;
            }
            
            .gradient-border:hover::after {
                width: 100%;
            }
            
            .btn-hover::before {
                content: '';
                position: absolute;
                top: 0;
                left: -100%;
                width: 100%;
                height: 100%;
                background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
                transition: left 0.5s;
            }
            
            .btn-hover:hover::before {
                left: 100%;
            }
            
            /* Mobile Navigation */
            .mobile-nav-menu {
                transform: translateX(-100%);
                opacity: 0;
                visibility: hidden;
                transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1),
                          opacity 0.4s ease, visibility 0.4s ease;
            }
            
            .mobile-nav-menu.active {
                transform: translateX(0);
                opacity: 1;
                visibility: visible;
            }
            
            body.no-scroll {
                overflow: hidden;
            }
            
            /* Fade-in links for mobile */
            .mobile-nav-menu nav a {
                opacity: 0;
                transform: translateY(10px);
                transition: opacity 0.3s ease, transform 0.3s ease;
            }
            
            .mobile-nav-menu.active nav a {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Stagger animation for mobile nav links */
            .mobile-nav-menu.active nav a:nth-child(1) { transition-delay: 0.1s; }
            .mobile-nav-menu.active nav a:nth-child(2) { transition-delay: 0.15s; }
            .mobile-nav-menu.active nav a:nth-child(3) { transition-delay: 0.2s; }
            .mobile-nav-menu.active nav a:nth-child(4) { transition-delay: 0.25s; }
            .mobile-nav-menu.active nav a:nth-child(5) { transition-delay: 0.3s; }
        }


/* ===== Typing Container fix style ===== */
.typing-container {
    height: 45vh;
    min-height: 100px;
    max-height: 200px;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

/* Ensure text stays centered and has proper fallback */
#typing-headline {
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0;
    width: 100%;
    opacity: 1 !important; /* Force visible during load */
}

#typing-text {
    display: inline-block;
    text-align: center;
    min-height: 1.2em;
    line-height: 1.2;
    width: 100%;
    /* Ensure text is visible during loading */
    visibility: visible !important;
    opacity: 1 !important;
}

/* Override the initial opacity for typing container */
.typing-container .opacity-0 {
    opacity: 1 !important;
    animation: none !important;
}

/* Apply fade-in animation only when ready */
.typing-headline-loaded {
    opacity: 0;
    animation: fadeInUp 0.8s ease 0.6s forwards !important;
}

/* Optional: Fine-tune for different screen sizes */
@media (max-width: 640px) {
    .typing-container {
        height: 40vh;
        min-height: 80px;
    }
}

@media (min-width: 1920px) {
    .typing-container {
        height: 40vh;
        max-height: 180px;
    }
}

/* For landscape mobile */
@media (max-height: 500px) and (orientation: landscape) {
    .typing-container {
        height: 50vh;
        min-height: 60px;
    }
}
 /* ===== Border Input Animation ===== */
        .rainbow-border-input {
            padding: 2px;
            background: linear-gradient(45deg, 
                #ff0000, #ff8000, #ffff00, #80ff00, 
                #00ff00, #00ff80, #00ffff, #0080ff, 
                #0000ff, #8000ff, #ff00ff, #ff0080, #ff0000);
            background-size: 400% 400%;
            border-radius: 50px;
            animation: rainbow-border 3s linear infinite;
        }

        .input-content {
            background: rgba(17, 24, 39, 0.9);
            backdrop-filter: blur(20px);
            border-radius: 50px;
            position: relative;
            z-index: 1;
        }

        @keyframes rainbow-border {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }

        /* Animation for the container */
        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease forwards;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

 /* ===== Dot Glowing Effect ===== */
  @keyframes glow {
    0%, 100% {
      box-shadow: 0 0 8px rgba(74, 222, 128, 0.8), 0 0 15px rgba(163, 230, 53, 0.5);
      opacity: 1;
      transform: scale(1);
    }
    50% {
      box-shadow: 0 0 15px rgba(74, 222, 128, 1), 0 0 30px rgba(163, 230, 53, 0.7);
      opacity: 0.9;
      transform: scale(1.2);
    }
  }

  .glow-dot {
    width: 8px;
    height: 8px;
    border-radius: 9999px;
    display: inline-block;
    animation: glow 1.6s infinite ease-in-out;
  }

        /* ===== GLOW BORDER EFFECTS ===== */
        @layer utilities {
            .glow-border {
                position: absolute;
                inset: 0;
                border-radius: 1rem;
                overflow: hidden;
                pointer-events: none;
            }
            
            .glow-border::before {
                content: "";
                position: absolute;
                width: 140%;
                height: 140%;
                top: -2.5%;
                left: -2.5%;
                background: conic-gradient(
                    from 0deg,
                    #aaff00,
                    #00ffcc,
                    #a000ff,
                    #ff00c8,
                    #aaff00
                );
                animation: rotateGlow 10s linear infinite;
                filter: blur(1px);
                border-radius: 1rem;
            }
            
            .glow-border::after {
                content: "";
                position: absolute;
                inset: 2px;
                border-radius: 1rem;
                background: #121019;
            }

            @keyframes rotateGlow {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
            }
            
            /* Mobile optimization */
            @media (max-width: 768px) {
                .glow-border::before {
                    animation: rotateGlow 15s linear infinite;
                }
            }
        }

        /* ===== LOGO MARQUEE STYLES ===== */
        @keyframes circularMarquee {
            0% { transform: translateX(-70%); }
            100% { transform: translateX(0); }
        }

        .animate-circular-marquee {
            animation: circularMarquee 60s linear infinite;
            display: flex;
        }

       .marquee-wrapper {
  overflow: hidden;
  position: relative;
  width: 100%; /* 👈 default for mobile */
  mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
  -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 10%, #000 90%, transparent 100%);
}




        .marquee-track {
            display: flex;
            align-items: center;
            width: max-content;
        }

        /* Logo container fixes */
        .customer-logos .flex.items-center.justify-center {
            flex-shrink: 0;
            transition: transform 0.3s ease;
        }

        .customer-logos .flex.items-center.justify-center:hover {
            transform: scale(1.05);
        }

        /* Remove gradient overlays */
        .customer-logos .absolute.left-0,
        .customer-logos .absolute.right-0 {
            display: none;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .animate-circular-marquee {
                animation-duration: 60s;
            }
            
            .marquee-wrapper {
                mask-image: linear-gradient(90deg, transparent 0%, #000 5%, #000 95%, transparent 100%);
                -webkit-mask-image: linear-gradient(90deg, transparent 0%, #000 5%, #000 95%, transparent 100%);
            }
        }

        /* Pause on hover */
        .marquee-track:hover {
            animation-play-state: paused;
        }
/* ✅ Desktop only — widen the marquee */
@media (min-width: 1024px) {
  .marquee-wrapper {
    width: 120%;
    left: -10%;
  }
}
        /* ===== TESTIMONIAL SCROLL STYLES ===== */
        .testimonials-scroll-section {
            background: radial-gradient(circle at 30% -10%, #1a0a2e, #000);
        }

        .testimonials-scroll-wrapper {
            overflow: hidden;
            position: relative;
            padding: 1.5rem 0;
        }

        .testimonials-scroll-track {
            display: flex;
            gap: 1.5rem;
            animation: testimonials-scroll-animation 60s linear infinite;
            width: max-content;
        }

        .testimonial-review-card {
            flex: 0 0 320px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 1.25rem;
            padding: 1.5rem;
            transition: all 0.3s ease;
            cursor: pointer;
            height: fit-content;
        }

        .testimonial-review-card:hover {
            transform: translateY(-5px);
            border-color: rgba(138, 0, 255, 0.3);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.3);
        }

        .review-stars {
            display: flex;
            gap: 0.2rem;
            margin-bottom: 0.875rem;
        }

        .review-stars i {
            color: #FFD700;
            font-size: 0.875rem;
        }

        .review-stars-large {
            display: flex;
            gap: 0.2rem;
            justify-content: center;
        }

        .review-stars-large i {
            color: #FFD700;
            font-size: 1.25rem;
        }

        .review-text {
            color: #d1d5db;
            line-height: 1.5;
            margin-bottom: 1.25rem;
            font-style: italic;
            font-size: 0.9rem;
        }

        .review-author {
            display: flex;
            align-items: center;
            gap: 0.875rem;
        }

        .customer-avatar {
            width: 2.5rem;
            height: 2.5rem;
            border-radius: 50%;
            background: linear-gradient(135deg, #8A00FF, #FF00A8);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 600;
            color: white;
            flex-shrink: 0;
            font-size: 0.875rem;
        }

        .customer-info h4 {
            color: white;
            font-weight: 600;
            margin-bottom: 0.125rem;
            font-size: 0.95rem;
        }

        .customer-info p {
            color: #9ca3af;
            font-size: 0.8rem;
        }

        /* Scroll Animation */
        @keyframes testimonials-scroll-animation {
            0% { transform: translateX(-90%); }
            100% { transform: translateX(0%); }
        }

        /* Pause animation on hover */
        .testimonials-scroll-wrapper:hover .testimonials-scroll-track {
            animation-play-state: paused;
        }

        /* Gradient fade edges */
        .testimonials-scroll-wrapper::before,
        .testimonials-scroll-wrapper::after {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 80px;
            z-index: 2;
            pointer-events: none;
        }

        .testimonials-scroll-wrapper::before {
            left: 0;
            background: linear-gradient(to right, rgba(26, 10, 46, 1), rgba(26, 10, 46, 0));
        }

        .testimonials-scroll-wrapper::after {
            right: 0;
            background: linear-gradient(to left, rgba(26, 10, 46, 1), rgba(26, 10, 46, 0));
        }

        /* Mobile responsiveness */
        @media (max-width: 1024px) {
            .testimonial-review-card {
                flex: 0 0 300px;
                padding: 1.25rem;
            }
        }

        @media (max-width: 768px) {
            .testimonial-review-card {
                flex: 0 0 280px;
                padding: 1.25rem;
            }

            .testimonials-scroll-track {
                gap: 1rem;
                animation: testimonials-scroll-animation-mobile 60s linear infinite;
            }

            @keyframes testimonials-scroll-animation-mobile {
                0% { transform: translateX(-90%); }
                100% { transform: translateX(0%); }
            }
        }

        @media (max-width: 480px) {
            .testimonial-review-card {
                flex: 0 0 260px;
                padding: 1rem;
            }

            .review-text {
                font-size: 0.85rem;
                margin-bottom: 1rem;
            }

            .customer-info h4 {
                font-size: 0.9rem;
            }

            .customer-info p {
                font-size: 0.75rem;
            }

            .review-stars i {
                font-size: 0.8rem;
            }

            .customer-avatar {
                width: 2rem;
                height: 2rem;
                font-size: 0.75rem;
            }
        }

        /* ===== Why Ztorespot best ===== */
/* Multi-color star animation - 1 second changes */
@keyframes star-colors-1s {
    0%, 33% {
        color: #fbbf24; /* yellow-400 */
    }
    34%, 66% {
        color: #ec4899; /* pink-500 */
    }
    67%, 100% {
        color: #60a5fa; /* blue-400 */
    }
}

.animate-star-colors-1s {
    animation: star-colors-1s 3s ease-in-out infinite;
}

/* Smooth ping animation */
@keyframes ping-slow {
    0% {
        transform: scale(0.8);
        opacity: 0.8;
    }
    75%, 100% {
        transform: scale(1.5);
        opacity: 0;
    }
}

.animate-ping-slow {
    animation: ping-slow 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
        /* ===== HOW IT WORKS SECTION ===== */
        /* Tablet (≤1024px) */
        @media (max-width: 1024px) {
            .order-image {
                width: 100%;
            }
        }

        /* Mobile (≤640px) */
        @media (max-width: 640px) {
            .order-image {
                width: 110%;
            }
        }

        /* ===== 3D CAROUSEL STYLES ===== */
        .carousel-3d-circle-container {
            perspective: 1500px;
        }

        .carousel-3d-circle {
            position: relative;
            width: 100%;
            height: 100%;
            transform-style: preserve-3d;
            transition: transform 1s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .circle-3d-card {
            position: absolute;
            top: 50%;
            left: 50%;
            width: 280px;
            height: 320px;
            transform-style: preserve-3d;
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: center;
        }

        .card-inner {
            width: 100%;
            height: 100%;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4);
            border: 1px solid rgba(255, 255, 255, 0.3);
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(20px);
            transform-style: preserve-3d;
            transition: all 0.4s ease;
        }

        .image-wrapper {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .card-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .card-content {
            padding: 1.2rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        /* 3D Positioning */
        .circle-3d-card[data-position="0"] { 
            transform: translate(-50%, -50%) rotateY(0deg) translateZ(300px); 
        }
        .circle-3d-card[data-position="1"] { 
            transform: translate(-50%, -50%) rotateY(60deg) translateZ(300px); 
        }
        .circle-3d-card[data-position="2"] { 
            transform: translate(-50%, -50%) rotateY(120deg) translateZ(300px); 
        }
        .circle-3d-card[data-position="3"] { 
            transform: translate(-50%, -50%) rotateY(180deg) translateZ(300px); 
        }
        .circle-3d-card[data-position="4"] { 
            transform: translate(-50%, -50%) rotateY(240deg) translateZ(300px); 
        }
        .circle-3d-card[data-position="5"] { 
            transform: translate(-50%, -50%) rotateY(300deg) translateZ(300px); 
        }

        /* Active state */
        .circle-3d-card.active .card-inner {
            transform: translateZ(50px) scale(1.1);
            filter: brightness(1.2);
            border-color: rgba(255, 255, 255, 0.5);
            opacity: 1;
        }

        /* Side cards styling */
        .circle-3d-card:not(.active) .card-inner {
            filter: brightness(0.6) blur(1px);
            opacity: 0.6;
            transform: translateZ(20px) scale(0.9);
        }

        /* Hover effects only on active card */
        .circle-3d-card.active:hover .card-inner {
            transform: translateZ(60px) scale(1.15);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.6);
        }

        .circle-3d-card.active:hover .card-img {
            transform: scale(1.1);
        }

        /* Disable hover on non-active cards */
        .circle-3d-card:not(.active):hover .card-inner {
            transform: translateZ(20px) scale(0.9);
            cursor: default;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .circle-3d-card[data-position="0"],
            .circle-3d-card[data-position="1"],
            .circle-3d-card[data-position="2"],
            .circle-3d-card[data-position="3"],
            .circle-3d-card[data-position="4"],
            .circle-3d-card[data-position="5"] {
                transform: translate(-50%, -50%) rotateY(var(--rotate)) translateZ(200px);
            }
            
            .circle-3d-card {
                width: 240px;
                height: 280px;
            }
        }

        @media (max-width: 768px) {
            .circle-3d-card[data-position="0"],
            .circle-3d-card[data-position="1"],
            .circle-3d-card[data-position="2"],
            .circle-3d-card[data-position="3"],
            .circle-3d-card[data-position="4"],
            .circle-3d-card[data-position="5"] {
                transform: translate(-50%, -50%) rotateY(var(--rotate)) translateZ(150px);
            }
            
            .circle-3d-card {
                width: 200px;
                height: 240px;
            }
            
            .image-wrapper {
                height: 140px;
            }
        }

        /* 3D Depth Effects for active card only */
        .circle-3d-card.active::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, transparent 30%, rgba(255,255,255,0.1) 100%);
            border-radius: 20px;
            opacity: 0;
            transition: opacity 0.3s ease;
            pointer-events: none;
        }

        .circle-3d-card.active:hover::before {
            opacity: 1;
        }

        /* ===== THEME PORTFOLIO STYLES ===== */

.perspective-1000 {
    perspective: 1000px;
}

/* 3D Positions for 5 items */
.carousel-item[data-position="left"] {
    transform: translateX(-120%) scale(0.8) rotateY(15deg);
    opacity: 0.6;
    z-index: 5;
    filter: blur(1px);
}

.carousel-item[data-position="center"] {
    transform: translateX(0) scale(1) rotateY(0deg);
    opacity: 1;
    z-index: 10;
    filter: blur(0);
}

.carousel-item[data-position="right"] {
    transform: translateX(120%) scale(0.8) rotateY(-15deg);
    opacity: 0.6;
    z-index: 5;
    filter: blur(1px);
}

/* Hide items that are not in view */
.carousel-item:not([data-position="left"]):not([data-position="center"]):not([data-position="right"]) {
    opacity: 0;
    transform: translateX(200%) scale(0.7);
    z-index: 1;
    filter: blur(2px);
}

/* Smooth transitions */
.carousel-item {
    transition: all 0.7s cubic-bezier(0.4, 0, 0.2, 1);
}

/* Carousel container adjustments */
.carousel-container {
    overflow: visible;
}

/* Button styles */
.theme-btn {
    transition: all 0.3s ease;
}

.carousel-item[data-position="center"] .theme-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(139, 92, 246, 0.4);
}

/* Ensure proper image display */
.carousel-item img {
    max-width: 100%;
    max-height: 100%;
    display: block;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .carousel-container {
        height: 440px;
    }

    /* Adjust positions for mobile */
    .carousel-item[data-position="left"] {
        transform: translateX(-100%) scale(0.75) rotateY(10deg);
    }

    .carousel-item[data-position="right"] {
        transform: translateX(100%) scale(0.75) rotateY(-10deg);
    }

    .carousel-item:not([data-position="left"]):not([data-position="center"]):not([data-position="right"]) {
        transform: translateX(150%) scale(0.6);
    }
}

@media (max-width: 640px) {
    .carousel-container {
        height: 400px;
    }

    .carousel-item {
        width: 280px !important;
    }

    .carousel-item[data-position="center"] {
        width: 300px !important;
    }

    /* Further adjust positions for small mobile */
    .carousel-item[data-position="left"] {
        transform: translateX(-90%) scale(0.7) rotateY(8deg);
    }

    .carousel-item[data-position="right"] {
        transform: translateX(90%) scale(0.7) rotateY(-8deg);
    }
}

/* Ensure smooth scrolling and performance */
.carousel-track {
    transform-style: preserve-3d;
}

.carousel-item {
    transform-style: preserve-3d;
    backface-visibility: hidden;
}

/* Gradient text for section header */
.text-gradient {
    background: linear-gradient(135deg, #8B5CF6 0%, #EC4899 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}



            /* ===== FLEX-BASED IMAGE SCROLLER ===== */
            .more-themes {
                padding-top: 0 !important;
                padding-bottom: 0 !important;
            }

            .scroller-wrapper {
                overflow: hidden;
                position: relative;
            }

            /* Left to Right Animation */
            .scroller-track-left {
                animation: scrollLeftToRight 80s linear infinite;
                width: max-content;
            }

            @keyframes scrollLeftToRight {
                0% {
                    transform: translateX(-50%);
                }

                100% {
                    transform: translateX(0);
                }
            }

            /* Right to Left Animation */
            .scroller-track-right {
                animation: scrollRightToLeft 80s linear infinite;
                width: max-content;
            }

            @keyframes scrollRightToLeft {
                0% {
                    transform: translateX(0);
                }

                100% {
                    transform: translateX(-50%);
                }
            }

            /* Image Styles - Direct images with natural sizing */
            .theme-image {
                flex: 0 0 auto;
                width: auto;
                height: auto;
                max-width: 300px;
                max-height: 350px;
                display: block;
                object-fit: contain;
                border-radius: 8px;
                transition: all 0.3s ease;
                filter: drop-shadow(0 10px 20px rgba(0, 0, 0, 0.25));
            }

            .theme-image:hover {
                transform: scale(1.05) translateY(-3px);
                filter: drop-shadow(0 20px 40px rgba(0, 0, 0, 0.35)) drop-shadow(0 0 15px rgba(138, 0, 255, 0.25));
            }

            /* Pause animation on hover */
            .scroller-wrapper:hover .scroller-track-left,
            .scroller-wrapper:hover .scroller-track-right {
                animation-play-state: paused;
            }

            /* Responsive maximum size limits */
            @media (max-width: 1536px) {
                .theme-image {
                    max-width: 280px;
                    max-height: 330px;
                }
            }

            @media (max-width: 1280px) {
                .theme-image {
                    max-width: 240px;
                    max-height: 300px;
                }
            }

            @media (max-width: 1024px) {
                .theme-image {
                    max-width: 200px;
                    max-height: 250px;
                }

                .scroller-track-left,
                .scroller-track-right {
                    gap: 1rem;
                }
            }

            @media (max-width: 768px) {
                .theme-image {
                    max-width: 160px;
                    max-height: 200px;
                }

                .scroller-track-left,
                .scroller-track-right {
                    gap: 0.75rem;
                    animation-duration: 60s;
                }

                .scroller-wrapper .absolute.left-0,
                .scroller-wrapper .absolute.right-0 {
                    width: 20px;
                }
            }

            @media (max-width: 640px) {
                .theme-image {
                    max-width: 140px;
                    max-height: 175px;
                }

                .scroller-track-left,
                .scroller-track-right {
                    gap: 0.5rem;
                    animation-duration: 50s;
                }

                .more-themes {
                    padding-left: 0.25rem;
                    padding-right: 0.25rem;
                }
            }

            @media (max-width: 480px) {
                .theme-image {
                    max-width: 120px;
                    max-height: 150px;
                }

                .scroller-track-left,
                .scroller-track-right {
                    gap: 0.4rem;
                    animation-duration: 40s;
                }

                .scroller-wrapper .absolute.left-0,
                .scroller-wrapper .absolute.right-0 {
                    width: 15px;
                }
            }

            /* Smooth transitions */
            .theme-image,
            .scroller-track-left,
            .scroller-track-right {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            /* Enhanced fog effects */
            .more-themes::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                height: 60px;
                background: linear-gradient(to bottom,
                        rgba(10, 10, 30, 1) 0%,
                        rgba(10, 10, 30, 0.6) 50%,
                        transparent 100%);
                pointer-events: none;
                z-index: 5;
            }

            .more-themes::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                right: 0;
                height: 60px;
                background: linear-gradient(to top,
                        rgba(10, 10, 30, 1) 0%,
                        rgba(10, 10, 30, 0.6) 50%,
                        transparent 100%);
                pointer-events: none;
                z-index: 5;
            }

            /* Remove any extra padding */
            .scroller-track-left,
            .scroller-track-right {
                padding-top: 0;
                padding-bottom: 0;
            }

            .scroller-section {
                padding: 0;
            }


        /* ===== FAQ STYLES ===== */
        /* FAQ Smooth Animations */
        .faq-answer {
            overflow: hidden;
            will-change: height, opacity;
        }

        .faq-item.active {
            border-color: rgba(138, 0, 255, 0.5) !important;
            box-shadow: 0 10px 30px rgba(138, 0, 255, 0.15);
            transform: translateY(-2px);
        }

        .faq-item {
            transition: all 0.3s ease;
        }

        .faq-item:hover {
            border-color: rgba(138, 0, 255, 0.3) !important;
            transform: translateY(-1px);
        }

        /* Smooth icon rotation */
        .faq-item svg {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced question hover */
        .faq-question:hover {
            background: rgba(255, 255, 255, 0.03) !important;
        }

        /* Mobile optimizations */
        @media (max-width: 768px) {
            .faq-question {
                padding: 1rem 1.5rem !important;
            }

            .faq-question span {
                font-size: 1rem !important;
                line-height: 1.4;
                padding-right: 1rem;
            }
        }


        /* ===== FOOTER STYLES ===== */
        .footer-link {
            position: relative;
            color: #9ca3af;
            transition: color 0.3s ease;
        }
        
        .footer-link:hover {
            color: #ffffff;
        }
        
        .footer-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: linear-gradient(135deg, #8A00FF, #FF00A8);
            transition: width 0.3s ease;
        }
        
        .footer-link:hover::after {
            width: 100%;
        }

        .footer-icon {
            width: 42px;
            height: 42px;
            background: rgba(255,255,255,0.05);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #aaa;
        }
        
        .footer-icon:hover {
            background: linear-gradient(135deg, #8A00FF, #FF00A8);
            color: #fff;
            transform: scale(1.1);
            box-shadow: 0 0 12px rgba(255, 0, 168, 0.3);
        }
    </style>
</head>

<body class="font-inter bg-gradient-radial text-white overflow-x-hidden">
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PXR9TRDF" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->


    <!-- Popup Overlay with Festive Effects -->
    <div id="popupOverlay" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden items-center justify-center p-4 overflow-hidden">
        <!-- Confetti Container -->
        <div id="confettiContainer" class="absolute inset-0 pointer-events-none"></div>

        <!-- Sky Crackers -->
        <div class="absolute top-0 left-0 w-full h-1/3 pointer-events-none">
            <!-- Left Sky Cracker -->
            <div id="skyCrackerLeft" class="absolute left-1/4 top-10 transform -translate-x-1/2 opacity-0">
                <div class="relative">
                    <!-- Cracker string -->
                    <div class="absolute left-1/2 top-0 w-0.5 h-8 bg-gray-300 transform -translate-x-1/2"></div>
                    <!-- Cracker body -->
                    <div class="w-8 h-12 bg-gradient-to-b from-red-500 via-yellow-400 to-red-600 rounded-sm shadow-lg"></div>
                    <!-- Cracker ends -->
                    <div class="absolute -bottom-1 left-1/2 w-2 h-2 bg-gray-800 rounded-full transform -translate-x-1/2"></div>
                    <div class="absolute top-1/2 -right-2 w-2 h-2 bg-gray-800 rounded-full"></div>
                </div>
            </div>

            <!-- Right Sky Cracker -->
            <div id="skyCrackerRight" class="absolute right-1/4 top-16 transform translate-x-1/2 opacity-0">
                <div class="relative">
                    <!-- Cracker string -->
                    <div class="absolute left-1/2 top-0 w-0.5 h-8 bg-gray-300 transform -translate-x-1/2"></div>
                    <!-- Cracker body -->
                    <div class="w-8 h-12 bg-gradient-to-b from-blue-500 via-green-400 to-blue-600 rounded-sm shadow-lg"></div>
                    <!-- Cracker ends -->
                    <div class="absolute -bottom-1 left-1/2 w-2 h-2 bg-gray-800 rounded-full transform -translate-x-1/2"></div>
                    <div class="absolute top-1/2 -left-2 w-2 h-2 bg-gray-800 rounded-full"></div>
                </div>
            </div>
        </div>

        <!-- BIG Sky Shots (Fireworks/Explosions) -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- BIG Firework 1 - Center Top -->
            <div class="absolute top-1/4 left-1/2 transform -translate-x-1/2 -translate-y-1/2 animate-big-firework-1">
                <div class="relative">
                    <!-- Big central explosion -->
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full blur-md opacity-70"></div>
                    <!-- Expanding rings -->
                    <div class="absolute top-1/2 left-1/2 w-32 h-32 border-2 border-yellow-400/50 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-1"></div>
                    <div class="absolute top-1/2 left-1/2 w-48 h-48 border-2 border-orange-400/30 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-2"></div>
                    <!-- Burst rays -->
                    <div class="absolute top-1/2 left-1/2 w-1 h-24 bg-gradient-to-b from-yellow-400 to-transparent -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-24 bg-gradient-to-b from-yellow-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-24 bg-gradient-to-b from-yellow-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-90"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-24 bg-gradient-to-b from-yellow-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-135"></div>
                </div>
            </div>

            <!-- BIG Firework 2 - Left Top -->
            <div class="absolute top-1/3 left-1/4 transform -translate-x-1/2 -translate-y-1/2 animate-big-firework-2">
                <div class="relative">
                    <!-- Big central explosion -->
                    <div class="w-14 h-14 bg-gradient-to-br from-pink-500 to-purple-600 rounded-full blur-md opacity-70"></div>
                    <!-- Expanding rings -->
                    <div class="absolute top-1/2 left-1/2 w-28 h-28 border-2 border-pink-400/50 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-3"></div>
                    <div class="absolute top-1/2 left-1/2 w-40 h-40 border-2 border-purple-400/30 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-4"></div>
                    <!-- Burst rays -->
                    <div class="absolute top-1/2 left-1/2 w-1 h-20 bg-gradient-to-b from-pink-400 to-transparent -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-20 bg-gradient-to-b from-pink-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-20 bg-gradient-to-b from-pink-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-90"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-20 bg-gradient-to-b from-pink-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-135"></div>
                </div>
            </div>

            <!-- BIG Firework 3 - Right Top -->
            <div class="absolute top-1/3 right-1/4 transform translate-x-1/2 -translate-y-1/2 animate-big-firework-3">
                <div class="relative">
                    <!-- Big central explosion -->
                    <div class="w-12 h-12 bg-gradient-to-br from-cyan-400 to-blue-500 rounded-full blur-md opacity-70"></div>
                    <!-- Expanding rings -->
                    <div class="absolute top-1/2 left-1/2 w-24 h-24 border-2 border-cyan-400/50 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-5"></div>
                    <div class="absolute top-1/2 left-1/2 w-36 h-36 border-2 border-blue-400/30 rounded-full -translate-x-1/2 -translate-y-1/2 animate-expand-ring-6"></div>
                    <!-- Burst rays -->
                    <div class="absolute top-1/2 left-1/2 w-1 h-18 bg-gradient-to-b from-cyan-400 to-transparent -translate-x-1/2 -translate-y-1/2"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-18 bg-gradient-to-b from-cyan-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-45"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-18 bg-gradient-to-b from-cyan-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-90"></div>
                    <div class="absolute top-1/2 left-1/2 w-1 h-18 bg-gradient-to-b from-cyan-400 to-transparent -translate-x-1/2 -translate-y-1/2 rotate-135"></div>
                </div>
            </div>

            <!-- Floating Glitter Particles -->
            <div class="absolute top-10 left-1/3 animate-glitter-1">
                <div class="w-2 h-2 bg-yellow-300 rounded-full"></div>
            </div>
            <div class="absolute top-20 right-1/3 animate-glitter-2">
                <div class="w-2 h-2 bg-pink-300 rounded-full"></div>
            </div>
            <div class="absolute top-16 left-1/2 animate-glitter-3">
                <div class="w-2 h-2 bg-cyan-300 rounded-full"></div>
            </div>
        </div>

        <!-- Optimized Floating Paper Shapes -->
        <div class="absolute inset-0 pointer-events-none">
            <!-- Only 4 shapes instead of 7 for better performance -->
            <div class="absolute top-10 left-10 animate-paper-float-1">
                <div class="w-5 h-5 bg-gradient-to-br from-red-400 to-pink-500 clip-triangle"></div>
            </div>
            <div class="absolute top-20 right-20 animate-paper-float-2">
                <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full"></div>
            </div>
            <div class="absolute bottom-20 left-20 animate-paper-float-3">
                <div class="w-5 h-5 bg-gradient-to-br from-green-400 to-teal-500"></div>
            </div>
            <div class="absolute bottom-40 right-1/4 animate-paper-float-4">
                <div class="w-5 h-5 bg-gradient-to-br from-yellow-400 to-orange-500 rounded-full"></div>
            </div>
        </div>

        <div id="popupContent" class="bg-gradient-to-br from-ztore-purple/20 to-ztore-pink/20 rounded-3xl border-2 border-white/20 backdrop-blur-xl max-w-md w-full p-6 relative transform scale-0 transition-transform duration-300 shadow-2xl">
            <!-- Close Button -->
            <button id="closePopup" class="absolute -top-2 -right-2 w-8 h-8 bg-white/10 hover:bg-white/20 rounded-full flex items-center justify-center text-gray-400 hover:text-white transition-all duration-300 border border-white/20 hover:border-white/40 cursor-pointer z-50">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Content -->
            <div class="text-center relative z-10">
                <!-- Limited Time Badge with Pulsing Effect -->
                <div class="inline-flex items-center gap-2 bg-gradient-to-r from-green-400/20 to-emerald-400/20 border border-green-400/40 rounded-full px-5 py-2 mb-4 animate-pulse shadow-lg">
                    <span class="text-green-300 font-bold text-sm">✨NEW YEAR SPECIAL OFFER ✨</span>
                </div>

                <?php
                // IMPORTANT: Check if PHP functions exist before using them
                if (!function_exists('getData') || !function_exists('readData') || !function_exists('calculateGst') || !function_exists('currencyToSymbol')) {
                    // Hide popup if functions don't exist
                    echo '<script>document.addEventListener("DOMContentLoaded", function() { document.getElementById("popupOverlay").style.display = "none"; });</script>';
                } else {
                    try {
                        // Get the correct WHERE condition (same as pricing section)
                        $where = "new = 0 AND group_3 = 0";

                        // Check for new plan activation with error handling
                        $newPlanStartDate = getData("new_plan_start_date", "settings");
                        if ($newPlanStartDate && date('Y-m-d H:i:s') >= $newPlanStartDate) {
                            $checkNewPlan = getData("id", "subscription_plans", "new = 1");
                            if ($checkNewPlan) {
                                $where = "new = 1";
                            }
                        }

                        // Check for group_3 plan activation with error handling
                        $group3PlanStartDate = getData("group_3_plan_start_date", "settings");
                        if ($group3PlanStartDate && date('Y-m-d H:i:s') >= $group3PlanStartDate) {
                            $checkGroup3Plan = getData("id", "subscription_plans", "group_3 = 1");
                            if ($checkGroup3Plan) {
                                $where = "group_3 = 1";
                            }
                        }

                        // Get GST and currency settings (same as pricing section)
                        $gstRate = getData("gst_percentage", "settings") ?: 0;
                        $gstNumber = getData("gst_number", "settings") ?: '';
                        $gstType = getData("gst_tax_type", "settings") ?: 'exclusive';
                        $currency = currencyToSymbol(getData("currency", "settings")) ?: '₹';

                        $professionalPlan = null;
                        $targetDuration = 12;

                        // Try to get Professional plan from main table first with error handling
                        $professionalResult = readData(
                            "*",
                            "subscription_plans",
                            "$where AND name = 'Professional' AND status = 1 AND lifetime = 0 LIMIT 1"
                        );

                        if ($professionalResult) {
                            $professionalPlan = $professionalResult->fetch();
                        }

                        $planFound = false;
                        $planData = [];

                        if ($professionalPlan) {
                            // If main plan duration is not 12, check subscription_plan_durations
                            if (($professionalPlan['duration'] ?? 0) != $targetDuration) {
                                $durationResult = readData(
                                    "spd.*, sp.name, sp.description, sp.features, sp.id, sp.previous_amount",
                                    "subscription_plan_durations spd 
                        JOIN subscription_plans sp ON sp.id = spd.plan_id",
                                    "sp.$where AND sp.name = 'Professional' AND sp.status = 1 
                        AND spd.duration = $targetDuration LIMIT 1"
                                );

                                if ($durationResult) {
                                    $durationPlan = $durationResult->fetch();
                                    if ($durationPlan) {
                                        $planData = array_merge($professionalPlan, $durationPlan);
                                        $planData['amount'] = $durationPlan['amount'] ?? 0;
                                        $planData['previous_amount'] = $durationPlan['previous_amount'] ?? 0;
                                        $planData['plan_duration'] = $durationPlan['duration'] ?? $targetDuration;
                                        $planFound = true;
                                    }
                                }
                            } else {
                                $planData = $professionalPlan;
                                $planData['plan_duration'] = $professionalPlan['duration'] ?? $targetDuration;
                                $planFound = true;
                            }
                        } else {
                            // Try to get from subscription_plan_durations directly
                            $durationResult = readData(
                                "spd.*, sp.name, sp.description, sp.features, sp.id, sp.previous_amount",
                                "subscription_plan_durations spd 
                    JOIN subscription_plans sp ON sp.id = spd.plan_id",
                                "sp.$where AND sp.name = 'Professional' AND sp.status = 1 
                    AND spd.duration = $targetDuration LIMIT 1"
                            );

                            if ($durationResult) {
                                $professionalPlan = $durationResult->fetch();
                                if ($professionalPlan) {
                                    $planData = $professionalPlan;
                                    $planData['plan_duration'] = $professionalPlan['duration'] ?? $targetDuration;
                                    $planFound = true;
                                }
                            }
                        }

                        // Only show popup if Professional plan exists and has amount
                        if ($planFound && isset($planData['amount']) && !empty($planData['amount'])) {
                            // Use the correct amount field (same as pricing section)
                            $planAmount = (float)($planData['amount'] ?? 0);
                            $previousAmount = (float)($planData['previous_amount'] ?? 0);

                            // **FIXED: Calculate GST for current price (same as pricing section)**
                            if ($gstType === 'exclusive') {
                                // GST is added on top
                                $gstAmount = ($planAmount * $gstRate) / 100;
                                $gstInclusivePrice = $planAmount + $gstAmount;
                            } else {
                                // GST is already included in the price
                                $gstInclusivePrice = $planAmount;
                            }

                            // **FIXED: Calculate savings based on GST-inclusive prices (same as pricing section)**
                            if ($previousAmount > 0 && $previousAmount > $planAmount) {
                                if ($gstType === 'exclusive') {
                                    // For exclusive GST: Compare GST-inclusive prices
                                    $previousGstInclusivePrice = $previousAmount;
                                    $savingsAmount = $previousGstInclusivePrice - $gstInclusivePrice;
                                    $discountPercentage = round(($savingsAmount / $previousGstInclusivePrice) * 100);
                                    $mrpPrice = number_format($previousGstInclusivePrice);
                                } else {
                                    // For inclusive GST: Compare GST-inclusive prices
                                    $savingsAmount = $previousAmount - $gstInclusivePrice;
                                    $discountPercentage = round(($savingsAmount / $previousAmount) * 100);
                                    $mrpPrice = number_format($previousAmount);
                                }
                                $showSavings = true;
                            } else {
                                // If no previous amount or not higher, use fixed discount for popup
                                $mrpAmount = $planAmount * 2; // Original price assumed to be 2x
                                if ($gstType === 'exclusive') {
                                    $mrpGstAmount = ($mrpAmount * $gstRate) / 100;
                                    $mrpGstInclusivePrice = $mrpAmount + $mrpGstAmount;
                                    $savingsAmount = $mrpGstInclusivePrice - $gstInclusivePrice;
                                    $discountPercentage = round(($savingsAmount / $mrpGstInclusivePrice) * 100);
                                    $mrpPrice = number_format($mrpGstInclusivePrice);
                                } else {
                                    $savingsAmount = $mrpAmount - $gstInclusivePrice;
                                    $discountPercentage = round(($savingsAmount / $mrpAmount) * 100);
                                    $mrpPrice = number_format($mrpAmount);
                                }
                                $showSavings = true;
                            }

                            // Format final price (with GST if exclusive)
                            $finalPrice = number_format($gstInclusivePrice);

                            $duration = $planData['plan_duration'] ?? ($planData['duration'] ?? 12);
                            $years = $duration / 12;
                            $durationLabel = $years . " Year" . ($years > 1 ? "s" : "");

                            $planId = $planData['id'] ?? 0;
                ?>

                            <!-- Main Heading with Glitch Effect -->
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3 relative">
                                <span class="text-gradient animate-text-shine">Professional Plan</span>
                                <div class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 w-24 h-1 bg-gradient-to-r from-transparent via-ztore-purple to-transparent animate-pulse"></div>
                            </h3>

                            <!-- URGENCY MESSAGE: Price Increase Warning -->
                            <div class="bg-gradient-to-r from-red-500/20 to-orange-500/20 border border-red-400/40 rounded-xl p-3 mb-4 animate-pulse shadow-lg">
                                <div class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5 text-red-400 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.342 16.5c-.77.833.192 2.5 1.732 2.5z" />
                                    </svg>
                                    <span class="text-red-300 font-bold text-sm">PRICE INCREASE SOON!<span class="text-yellow-300"><br> Purchase quickly</span></span>
                                </div>
                            </div>

                            <!-- Offer Text -->
                            <div class="mb-4 relative">
                                <?php if ($showSavings): ?>
                                    <!-- Discount Badge with Celebration -->
                                    <div class="flex items-center justify-center gap-2 mb-3">
                                        <div class="relative">
                                            <span class="bg-gradient-to-r from-red-500 to-orange-500 text-white text-xs px-4 py-2 rounded-full font-bold shadow-lg animate-discount-pulse">
                                                <?= $discountPercentage ?>% OFF
                                            </span>
                                        </div>
                                        <p class="text-green-300 text-xs font-semibold animate-pulse">Save <?= $currency . number_format($savingsAmount) ?></p>
                                    </div>
                                <?php endif; ?>

                                <!-- Price Display with Scale Animation -->
                                <div class="flex flex-col items-center justify-center mb-1 transform transition-transform duration-300 hover:scale-105">
                                    <!-- MRP and Current Price in one line -->
                                    <div class="flex items-baseline justify-center gap-2 mb-1">
                                        <?php if ($showSavings): ?>
                                            <span class="text-gray-400 text-sm line-through animate-slide-in-left"><?= $currency . $mrpPrice ?></span>
                                        <?php endif; ?>
                                        <span class="text-4xl font-bold text-white animate-price-bounce"><?= $currency . $finalPrice ?></span>
                                        <span class="text-gray-300 animate-slide-in-right">/ <?= $durationLabel ?></span>
                                    </div>

                                    <!-- GST Info -->
                                    <p class="text-gray-500 text-xs mt-1">
                                        Inclusive of GST
                                    </p>
                                </div>
                            </div>

                            <!-- Countdown Timer with Glow Effect -->
                            <div class="bg-gradient-to-br from-white/10 to-white/5 rounded-2xl p-4 mb-6 border border-ztore-purple/30 shadow-lg animate-glow">
                                <p class="text-gray-300 text-sm mb-2 font-semibold">⏰ Offer ends in:</p>
                                <div id="countdownTimer" class="flex justify-center gap-3 text-white font-mono">
                                    <div class="text-center">
                                        <div id="hours" class="text-2xl font-bold bg-gradient-to-b from-ztore-purple to-ztore-pink rounded-lg py-2 px-3 animate-digit-flip">02</div>
                                        <div class="text-xs text-gray-400 mt-1">HOURS</div>
                                    </div>
                                    <div class="text-2xl font-bold text-ztore-pink pt-2 animate-pulse">:</div>
                                    <div class="text-center">
                                        <div id="minutes" class="text-2xl font-bold bg-gradient-to-b from-ztore-purple to-ztore-pink rounded-lg py-2 px-3 animate-digit-flip" style="animation-delay: 0.1s">00</div>
                                        <div class="text-xs text-gray-400 mt-1">MINUTES</div>
                                    </div>
                                    <div class="text-2xl font-bold text-ztore-pink pt-2 animate-pulse">:</div>
                                    <div class="text-center">
                                        <div id="seconds" class="text-2xl font-bold bg-gradient-to-b from-ztore-purple to-ztore-pink rounded-lg py-2 px-3 animate-digit-flip" style="animation-delay: 0.2s">00</div>
                                        <div class="text-xs text-gray-400 mt-1">SECONDS</div>
                                    </div>
                                </div>
                            </div>

                            <!-- CTA Buttons with Hover Effects -->
                            <div class="flex flex-col gap-3">
                                <a href="<?= SELLER_URL . 'register?redirect=' . SELLER_URL . 'checkout?plan=' . $planId . '&duration=' . $duration ?>"
                                    id="ctaButton"
                                    class="relative bg-gradient-to-br from-ztore-purple to-ztore-pink hover:from-ztore-purple/90 hover:to-ztore-pink/90 text-white py-4 rounded-xl font-bold transition-all duration-300 shadow-2xl hover:shadow-ztore-purple/50 hover:scale-105 text-center text-lg group overflow-hidden">
                                    <!-- Button shine effect -->
                                    <div class="absolute inset-0 -translate-x-full group-hover:translate-x-full h-full w-1/2 bg-gradient-to-r from-transparent via-white/20 to-transparent transition-transform duration-1000"></div>

                                    <!-- Button text -->
                                    <span class="relative z-10 flex items-center justify-center gap-2">
                                        GET PROFESSIONAL PLAN NOW
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                        </svg>
                                    </span>
                                </a>

                                <button id="noThanksBtn"
                                    class="bg-white/5 hover:bg-white/10 text-gray-300 hover:text-white py-3 rounded-xl font-semibold transition-all duration-300 border border-white/10 hover:border-white/30 group cursor-pointer">
                                    <span class="group-hover:animate-shake">No Thanks, Maybe Later</span>
                                </button>
                            </div>

                <?php
                        } else {
                            // If no Professional plan found, hide the popup
                            echo '<script>document.addEventListener("DOMContentLoaded", function() { document.getElementById("popupOverlay").style.display = "none"; });</script>';
                        }
                    } catch (Exception $e) {
                        // Log error and hide popup
                        error_log("Popup error: " . $e->getMessage());
                        echo '<script>document.addEventListener("DOMContentLoaded", function() { document.getElementById("popupOverlay").style.display = "none"; });</script>';
                    }
                }
                ?>

                <!-- Trust Badge -->
                <div class="flex items-center justify-center gap-2 mt-6 text-gray-400 text-sm">
                    <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    <span class="animate-pulse">• Cancel anytime • 14-Day Money Back</span>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Optimized Paper Shape Class
        class PaperShape {
            constructor(container) {
                this.container = container;
                this.element = document.createElement('div');
                this.init();
            }

            init() {
                const shape = Math.random() > 0.5 ? 'circle' : 'triangle';
                const colors = [
                    '#FF6B6B', '#4ECDC4', '#FFEAA7', '#FD79A8',
                    '#FFD700', '#45B7D1', '#96CEB4', '#FDCB6E'
                ];
                const color = colors[Math.floor(Math.random() * colors.length)];
                const size = Math.random() * 10 + 4;

                this.element.className = 'paper-shape absolute';
                this.element.style.width = `${size}px`;
                this.element.style.height = `${size}px`;
                this.element.style.backgroundColor = color;

                if (shape === 'circle') {
                    this.element.style.borderRadius = '50%';
                } else {
                    this.element.style.clipPath = 'polygon(50% 0%, 0% 100%, 100% 100%)';
                }

                this.element.style.willChange = 'transform, opacity';

                this.x = Math.random() * window.innerWidth;
                this.y = -20;

                this.speedX = Math.random() * 4 - 2;
                this.speedY = Math.random() * 3 + 2;
                this.rotation = 0;
                this.rotationSpeed = Math.random() * 4 - 2;
                this.opacity = Math.random() * 0.6 + 0.4;

                this.updatePosition();
                this.container.appendChild(this.element);
            }

            update() {
                this.x += this.speedX;
                this.y += this.speedY;
                this.rotation += this.rotationSpeed;
                this.updatePosition();
                return this.y < window.innerHeight + 50;
            }

            updatePosition() {
                this.element.style.transform = `translate3d(${this.x}px, ${this.y}px, 0) rotate(${this.rotation}deg)`;
                this.element.style.opacity = this.opacity;
            }

            remove() {
                if (this.element.parentNode) {
                    this.container.removeChild(this.element);
                }
            }
        }

        // Sky Cracker Animation
        function animateSkyCracker(element, delay = 0) {
            setTimeout(() => {
                element.style.opacity = '1';
                element.style.animation = 'skyCrackerDrop 1s forwards, skyCrackerSwing 2s 1s infinite';

                setTimeout(() => {
                    createPaperBlast(element.getBoundingClientRect().left + 20, element.getBoundingClientRect().top + 60);
                }, 1000);
            }, delay);
        }

        // Paper Blast
        function createPaperBlast(x, y) {
            const container = document.getElementById('confettiContainer');
            if (!container) return;

            const blastCount = 30;
            const colors = ['#FF0000', '#FFA500', '#FFFF00', '#00FF00', '#0000FF'];

            for (let i = 0; i < blastCount; i++) {
                setTimeout(() => {
                    const paper = new PaperShape(container);
                    paper.x = x;
                    paper.y = y;

                    const angle = Math.random() * Math.PI * 2;
                    const speed = Math.random() * 8 + 4;
                    paper.speedX = Math.cos(angle) * speed;
                    paper.speedY = Math.sin(angle) * speed;
                    paper.rotationSpeed = Math.random() * 10 - 5;

                    paperBlasts.push(paper);
                }, i * 15);
            }
        }

        // Create BIG Sky Shot (Big Firework)
        function createBigSkyShot() {
            const container = document.getElementById('confettiContainer');
            if (!container) return;

            // Choose random position in top half of screen
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * (window.innerHeight / 3) + 50;

            // Colors for big firework
            const colors = [{
                    primary: '#FFD700',
                    secondary: '#FFA500'
                }, // Gold/Orange
                {
                    primary: '#FF6B6B',
                    secondary: '#FF1493'
                }, // Pink/Red
                {
                    primary: '#00FFFF',
                    secondary: '#0000FF'
                }, // Cyan/Blue
                {
                    primary: '#98FF98',
                    secondary: '#00FF00'
                } // Green/Lime
            ];

            const colorSet = colors[Math.floor(Math.random() * colors.length)];

            // Create big firework container
            const firework = document.createElement('div');
            firework.className = 'big-firework absolute';
            firework.style.left = `${x}px`;
            firework.style.top = `${y}px`;
            firework.style.willChange = 'transform, opacity';

            // Create central explosion
            const center = document.createElement('div');
            center.className = 'absolute';
            center.style.width = '40px';
            center.style.height = '40px';
            center.style.background = `radial-gradient(circle, ${colorSet.primary}, ${colorSet.secondary})`;
            center.style.borderRadius = '50%';
            center.style.filter = 'blur(5px)';
            center.style.transform = 'translate(-50%, -50%)';

            // Create expanding rings
            for (let i = 0; i < 3; i++) {
                const ring = document.createElement('div');
                ring.className = 'absolute';
                ring.style.width = `${(i + 1) * 60}px`;
                ring.style.height = `${(i + 1) * 60}px`;
                ring.style.border = `2px solid ${colorSet.primary}`;
                ring.style.borderRadius = '50%';
                ring.style.opacity = '0.3';
                ring.style.transform = 'translate(-50%, -50%)';

                // Animate ring
                ring.animate([{
                        transform: 'translate(-50%, -50%) scale(0)',
                        opacity: 0.8
                    },
                    {
                        transform: 'translate(-50%, -50%) scale(1.5)',
                        opacity: 0
                    }
                ], {
                    duration: 1000,
                    delay: i * 200,
                    easing: 'ease-out'
                });

                setTimeout(() => {
                    if (ring.parentNode) ring.parentNode.removeChild(ring);
                }, 1000 + (i * 200));

                firework.appendChild(ring);
            }

            // Create burst rays
            for (let i = 0; i < 8; i++) {
                const ray = document.createElement('div');
                ray.className = 'absolute';
                ray.style.width = '2px';
                ray.style.height = '60px';
                ray.style.background = `linear-gradient(to bottom, ${colorSet.primary}, transparent)`;
                ray.style.transformOrigin = 'bottom center';
                ray.style.transform = `translate(-50%, -50%) rotate(${i * 45}deg)`;

                // Animate ray
                ray.animate([{
                        transform: `translate(-50%, -50%) rotate(${i * 45}deg) scaleY(0)`,
                        opacity: 0
                    },
                    {
                        transform: `translate(-50%, -50%) rotate(${i * 45}deg) scaleY(1)`,
                        opacity: 1
                    },
                    {
                        transform: `translate(-50%, -50%) rotate(${i * 45}deg) scaleY(0)`,
                        opacity: 0
                    }
                ], {
                    duration: 800,
                    delay: 100,
                    easing: 'ease-out'
                });

                setTimeout(() => {
                    if (ray.parentNode) ray.parentNode.removeChild(ray);
                }, 900);

                firework.appendChild(ray);
            }

            // Create spark particles
            for (let i = 0; i < 40; i++) {
                setTimeout(() => {
                    const spark = document.createElement('div');
                    spark.className = 'absolute';
                    spark.style.width = '4px';
                    spark.style.height = '4px';
                    spark.style.background = colorSet.primary;
                    spark.style.borderRadius = '50%';
                    spark.style.transform = 'translate(-50%, -50%)';

                    const angle = Math.random() * Math.PI * 2;
                    const distance = Math.random() * 80 + 40;

                    spark.animate([{
                            transform: `translate(-50%, -50%) translate(0, 0) scale(1)`,
                            opacity: 1
                        },
                        {
                            transform: `translate(-50%, -50%) translate(${Math.cos(angle) * distance}px, ${Math.sin(angle) * distance}px) scale(0)`,
                            opacity: 0
                        }
                    ], {
                        duration: 1200,
                        easing: 'ease-out'
                    });

                    setTimeout(() => {
                        if (spark.parentNode) spark.parentNode.removeChild(spark);
                    }, 1200);

                    firework.appendChild(spark);
                }, i * 20);
            }

            container.appendChild(firework);

            // Remove firework after animation
            setTimeout(() => {
                if (firework.parentNode) {
                    firework.parentNode.removeChild(firework);
                }
            }, 2000);
        }

        // Popup Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const popupOverlay = document.getElementById('popupOverlay');
            const popupContent = document.getElementById('popupContent');
            const ctaButton = document.getElementById('ctaButton');
            const skyCrackerLeft = document.getElementById('skyCrackerLeft');
            const skyCrackerRight = document.getElementById('skyCrackerRight');

            if (!popupOverlay || popupOverlay.style.display === 'none') {
                return;
            }

            const closePopup = document.getElementById('closePopup');
            const noThanksBtn = document.getElementById('noThanksBtn');
            const hoursElement = document.getElementById('hours');
            const minutesElement = document.getElementById('minutes');
            const secondsElement = document.getElementById('seconds');

            let popupShown = false;
            let popupTimer = null;
            let countdownInterval = null;
            let paperBlasts = [];
            let animationFrameId = null;
            let lastUpdateTime = 0;
            let skyShotInterval = null;

            // Calculate end time
            const endTime = new Date();
            endTime.setHours(endTime.getHours() + 2);

            // Function to update countdown timer
            function updateCountdown() {
                const now = new Date();
                const timeLeft = endTime - now;

                if (timeLeft <= 0) {
                    endTime.setHours(endTime.getHours() + 2);
                    return;
                }

                const hours = Math.floor((timeLeft % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

                if (hoursElement) hoursElement.textContent = hours.toString().padStart(2, '0');
                if (minutesElement) minutesElement.textContent = minutes.toString().padStart(2, '0');
                if (secondsElement) secondsElement.textContent = seconds.toString().padStart(2, '0');
            }

            // Animation loop
            function animationLoop(timestamp) {
                if (!lastUpdateTime) lastUpdateTime = timestamp;

                const elapsed = timestamp - lastUpdateTime;

                if (elapsed > 16) {
                    paperBlasts = paperBlasts.filter(p => p.update());

                    if (Math.random() < 0.3) {
                        const container = document.getElementById('confettiContainer');
                        if (container) {
                            const paper = new PaperShape(container);
                            paperBlasts.push(paper);
                        }
                    }

                    lastUpdateTime = timestamp;
                }

                if (popupShown) {
                    animationFrameId = requestAnimationFrame(animationLoop);
                }
            }

            // Function to show popup
            function showPopup() {
                if (popupShown || !popupOverlay) return;

                popupOverlay.classList.remove('hidden');
                popupOverlay.classList.add('flex');
                document.body.classList.add('no-scroll');

                if (skyCrackerLeft) animateSkyCracker(skyCrackerLeft, 300);
                if (skyCrackerRight) animateSkyCracker(skyCrackerRight, 600);

                setTimeout(() => {
                    popupContent.classList.remove('scale-0');
                    popupContent.classList.add('scale-100');
                }, 100);

                lastUpdateTime = 0;
                animationFrameId = requestAnimationFrame(animationLoop);

                // Start big sky shots at random intervals
                skyShotInterval = setInterval(() => {
                    if (Math.random() < 0.4) { // 40% chance every 4 seconds
                        createBigSkyShot();
                        // Sometimes create two at once
                        if (Math.random() < 0.3) {
                            setTimeout(() => createBigSkyShot(), 300);
                        }
                    }
                }, 4000);

                popupShown = true;

                updateCountdown();
                countdownInterval = setInterval(updateCountdown, 1000);
            }

            // Function to hide popup IMMEDIATELY
            function hidePopup() {
                if (!popupOverlay) return;

                popupOverlay.classList.add('hidden');
                popupOverlay.classList.remove('flex');
                document.body.classList.remove('no-scroll');
                popupContent.classList.remove('scale-100');
                popupContent.classList.add('scale-0');

                if (animationFrameId) {
                    cancelAnimationFrame(animationFrameId);
                    animationFrameId = null;
                }

                if (skyShotInterval) {
                    clearInterval(skyShotInterval);
                    skyShotInterval = null;
                }

                paperBlasts.forEach(paper => paper.remove());
                paperBlasts = [];

                if (countdownInterval) {
                    clearInterval(countdownInterval);
                    countdownInterval = null;
                }

                popupShown = false;
            }

            // CTA Button Celebration
            if (ctaButton) {
                ctaButton.addEventListener('click', function(e) {
                    const rect = ctaButton.getBoundingClientRect();
                    createPaperBlast(rect.left + rect.width / 2, rect.top);

                    // Add 3 big sky shots when CTA is clicked
                    createBigSkyShot();
                    setTimeout(() => createBigSkyShot(), 200);
                    setTimeout(() => createBigSkyShot(), 400);
                });
            }

            // Intersection Observer
            const nextYouSection = document.querySelector('.customer-logos');

            if (nextYouSection && popupOverlay) {
                const observer = new IntersectionObserver(function(entries) {
                    entries.forEach(entry => {
                        if (entry.isIntersecting && !popupShown) {
                            popupTimer = setTimeout(() => {
                                showPopup();
                            }, 3000);
                        }
                    });
                }, {
                    threshold: 0.3,
                    rootMargin: '0px'
                });

                observer.observe(nextYouSection);
            }

            // Close popup functionality - IMMEDIATE CLOSE
            if (closePopup) {
                closePopup.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    hidePopup();
                });
            }

            // No Thanks button - IMMEDIATE CLOSE
            if (noThanksBtn) {
                noThanksBtn.addEventListener('click', function(e) {
                    e.preventDefault();
                    e.stopPropagation();
                    hidePopup();
                });
            }

            // Close when clicking outside popup - IMMEDIATE CLOSE
            if (popupOverlay) {
                popupOverlay.addEventListener('click', function(e) {
                    if (e.target === popupOverlay) {
                        hidePopup();
                    }
                });
            }

            // Close with Escape key - IMMEDIATE CLOSE
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && popupOverlay && popupOverlay.classList.contains('flex')) {
                    hidePopup();
                }
            });

            // Cleanup
            window.addEventListener('beforeunload', function() {
                if (popupTimer) clearTimeout(popupTimer);
                if (countdownInterval) clearInterval(countdownInterval);
                if (animationFrameId) cancelAnimationFrame(animationFrameId);
                if (skyShotInterval) clearInterval(skyShotInterval);
                paperBlasts.forEach(paper => paper.remove());
            });
        });
    </script>

    <style>
        /* Performance optimized styles */
        #popupOverlay {
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        .scale-0 {
            transform: scale(0);
            transform-origin: center;
        }

        .scale-100 {
            transform: scale(1);
            transform-origin: center;
        }

        /* BIG SKY SHOT ANIMATIONS */
        @keyframes bigFirework {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 0;
            }

            20% {
                transform: translate(-50%, -50%) scale(1.2);
                opacity: 1;
            }

            80% {
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.8;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        .animate-big-firework-1 {
            animation: bigFirework 4s infinite ease-in-out;
        }

        .animate-big-firework-2 {
            animation: bigFirework 5s infinite ease-in-out;
            animation-delay: 1.5s;
        }

        .animate-big-firework-3 {
            animation: bigFirework 4.5s infinite ease-in-out;
            animation-delay: 3s;
        }

        @keyframes expandRing {
            0% {
                transform: translate(-50%, -50%) scale(0);
                opacity: 0.8;
            }

            100% {
                transform: translate(-50%, -50%) scale(1.5);
                opacity: 0;
            }
        }

        .animate-expand-ring-1 {
            animation: expandRing 3s infinite ease-out;
        }

        .animate-expand-ring-2 {
            animation: expandRing 4s infinite ease-out;
            animation-delay: 0.5s;
        }

        .animate-expand-ring-3 {
            animation: expandRing 3.5s infinite ease-out;
            animation-delay: 1s;
        }

        .animate-expand-ring-4 {
            animation: expandRing 4.5s infinite ease-out;
            animation-delay: 1.5s;
        }

        .animate-expand-ring-5 {
            animation: expandRing 3s infinite ease-out;
            animation-delay: 2s;
        }

        .animate-expand-ring-6 {
            animation: expandRing 4s infinite ease-out;
            animation-delay: 2.5s;
        }

        @keyframes glitter {

            0%,
            100% {
                transform: translateY(0) scale(1);
                opacity: 0.3;
            }

            50% {
                transform: translateY(-5px) scale(1.3);
                opacity: 1;
            }
        }

        .animate-glitter-1 {
            animation: glitter 3s infinite ease-in-out;
        }

        .animate-glitter-2 {
            animation: glitter 4s infinite ease-in-out;
            animation-delay: 1s;
        }

        .animate-glitter-3 {
            animation: glitter 3.5s infinite ease-in-out;
            animation-delay: 2s;
        }

        /* Optimized paper float animations */
        @keyframes paperFloat {
            0% {
                transform: translate3d(0, 0, 0) rotate(0deg);
            }

            50% {
                transform: translate3d(0, -12px, 0) rotate(180deg);
            }

            100% {
                transform: translate3d(0, 0, 0) rotate(360deg);
            }
        }

        .animate-paper-float-1 {
            animation: paperFloat 4s infinite ease-in-out;
        }

        .animate-paper-float-2 {
            animation: paperFloat 5s infinite ease-in-out 0.5s;
        }

        .animate-paper-float-3 {
            animation: paperFloat 4.5s infinite ease-in-out 1s;
        }

        .animate-paper-float-4 {
            animation: paperFloat 5.5s infinite ease-in-out 1.5s;
        }

        /* Performance optimizations */
        .paper-shape,
        .big-firework {
            will-change: transform, opacity;
            transform: translate3d(0, 0, 0);
            backface-visibility: hidden;
            pointer-events: none;
        }

        /* Optimized other animations */
        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 10px rgba(147, 51, 234, 0.5);
            }

            50% {
                transform: scale(1.03);
                box-shadow: 0 0 15px rgba(147, 51, 234, 0.7);
            }
        }

        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 10px rgba(147, 51, 234, 0.2);
            }

            50% {
                box-shadow: 0 0 20px rgba(147, 51, 234, 0.4);
            }
        }

        @keyframes discountPulse {

            0%,
            100% {
                transform: scale(1);
                box-shadow: 0 0 0 rgba(255, 107, 107, 0.5);
            }

            50% {
                transform: scale(1.03);
                box-shadow: 0 0 15px rgba(255, 107, 107, 0.7);
            }
        }

        @keyframes textShine {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        @keyframes priceBounce {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }

        @keyframes slideInLeft {
            from {
                transform: translate3d(-10px, 0, 0);
                opacity: 0;
            }

            to {
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        @keyframes slideInRight {
            from {
                transform: translate3d(10px, 0, 0);
                opacity: 0;
            }

            to {
                transform: translate3d(0, 0, 0);
                opacity: 1;
            }
        }

        @keyframes digitFlip {
            0% {
                transform: rotateX(0deg);
            }

            50% {
                transform: rotateX(90deg);
            }

            100% {
                transform: rotateX(0deg);
            }
        }

        /* Sky Cracker Animations */
        @keyframes skyCrackerDrop {
            0% {
                transform: translate3d(var(--start-x), -100px, 0) rotate(0deg);
                opacity: 0;
            }

            100% {
                transform: translate3d(0, 0, 0) rotate(var(--end-rotate));
                opacity: 1;
            }
        }

        @keyframes skyCrackerSwing {

            0%,
            100% {
                transform: rotate(var(--start-rotate));
            }

            50% {
                transform: rotate(var(--end-rotate));
            }
        }

        /* Triangle clip path */
        .clip-triangle {
            clip-path: polygon(50% 0%, 0% 100%, 100% 100%);
        }

        /* Cursor styles */
        #closePopup,
        #noThanksBtn,
        #ctaButton {
            cursor: pointer !important;
        }

        /* Prevent background scroll when popup is open */
        body.no-scroll {
            overflow: hidden;
        }

        /* Close button hover effect */
        #closePopup:hover {
            background-color: rgba(255, 255, 255, 0.2) !important;
            transform: scale(1.05);
        }
    </style>

    <!-- Top Offer Bar -->
    <!-- <div
        class="w-full bg-gradient-to-r from-emerald-500 via-green-500 to-lime-400 py-2 px-4 fixed top-0 z-[60] shadow-md">
        <div class="max-w-7xl mx-auto"> -->
    <!-- Offer Content - Stacked on mobile, inline on desktop -->
    <!-- <div
                class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-3 text-white text-xs sm:text-sm text-center"> -->
    <!-- Limited Time Badge -->
    <!-- <div
                    class="bg-white/20 rounded-full px-2 py-0.5 flex items-center gap-1 flex-shrink-0 backdrop-blur-sm">
                    <span class="font-bold">🔥</span>
                    <span class="font-semibold">LIMITED TIME</span>
                </div> -->

    <!-- Offer Text -->
    <!-- <span class="font-medium">
                    Launch your store in 2 minutes & get <span class="font-bold">50% OFF!</span>
                </span>
            </div>
        </div>
    </div> -->

    <!-- Christmas Offer Bar -->
    <div class="w-full bg-gradient-to-r from-red-500 via-green-500 to-amber-400 py-2 px-4 fixed top-0 z-[60] shadow-md overflow-hidden">
        <!-- Snowfall Animation -->
        <div class="absolute inset-0 pointer-events-none">
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
            <div class="snowflake">❄</div>
        </div>

        <!-- Glowing Border Effect -->
        <div class="absolute inset-0 border-2 border-white/30 rounded-lg shadow-[0_0_15px_rgba(255,255,255,0.5)] animate-pulse"></div>

        <div class="max-w-7xl mx-auto relative z-10">
            <!-- Offer Content - Stacked on mobile, inline on desktop -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-1 sm:gap-3 text-white text-xs sm:text-sm text-center">
                <!-- Christmas Badge -->
                <div class="bg-white/20 rounded-full px-2 py-0.5 flex items-center gap-1 flex-shrink-0 backdrop-blur-sm border border-white/40 shadow-lg">
                    <span class="font-bold">🎄🎅</span>
                    <span class="font-semibold">CHRISTMAS SPECIAL</span>
                    <span class="font-bold">🤶☃️</span>
                </div>

                <!-- Offer Text with Glow -->
                <span class="font-medium relative">
                    <span class="drop-shadow-[0_0_8px_rgba(255,255,255,0.8)]">Merry Christmas! Get </span>
                    <span class="font-bold text-white">60% OFF</span>

                </span>


            </div>
        </div>
    </div>

    <style>
        /* Snowfall Animation */
        .snowflake {
            position: absolute;
            color: white;
            font-size: 0.8rem;
            opacity: 0.8;
            animation: fall linear infinite;
        }

        .snowflake:nth-child(1) {
            left: 10%;
            animation-delay: 0s;
            animation-duration: 8s;
        }

        .snowflake:nth-child(2) {
            left: 20%;
            animation-delay: 1s;
            animation-duration: 10s;
        }

        .snowflake:nth-child(3) {
            left: 30%;
            animation-delay: 2s;
            animation-duration: 7s;
        }

        .snowflake:nth-child(4) {
            left: 40%;
            animation-delay: 3s;
            animation-duration: 9s;
        }

        .snowflake:nth-child(5) {
            left: 50%;
            animation-delay: 4s;
            animation-duration: 6s;
        }

        .snowflake:nth-child(6) {
            left: 60%;
            animation-delay: 5s;
            animation-duration: 8s;
        }

        .snowflake:nth-child(7) {
            left: 70%;
            animation-delay: 6s;
            animation-duration: 10s;
        }

        .snowflake:nth-child(8) {
            left: 80%;
            animation-delay: 7s;
            animation-duration: 7s;
        }

        .snowflake:nth-child(9) {
            left: 90%;
            animation-delay: 8s;
            animation-duration: 9s;
        }

        .snowflake:nth-child(10) {
            left: 95%;
            animation-delay: 9s;
            animation-duration: 6s;
        }

        @keyframes fall {
            0% {
                transform: translateY(-20px) rotate(0deg);
                opacity: 0;
            }

            10% {
                opacity: 1;
            }

            90% {
                opacity: 1;
            }

            100% {
                transform: translateY(40px) rotate(360deg);
                opacity: 0;
            }
        }

        /* Subtle glow animation for the entire bar */
        @keyframes glow {

            0%,
            100% {
                box-shadow: 0 0 20px rgba(255, 50, 50, 0.3);
            }

            50% {
                box-shadow: 0 0 30px rgba(50, 255, 50, 0.4);
            }
        }

        /* Apply glow to the main container */
        .bg-gradient-to-r {
            animation: glow 3s ease-in-out infinite;
        }
    </style>

    <!-- Header Navigation -->
    <header
        class="w-full py-2 px-4 sm:px-[6%] grid grid-cols-[auto_1fr_auto] items-center fixed top-14 sm:top-10 z-50 bg-[rgba(10,10,30,0.6)] backdrop-blur-xl border-b border-white/10 transition-all duration-400 ease-[cubic-bezier(0.4,0,0.2,1)]">

        <!-- Logo -->
        <a href="<?= APP_URL ?>" class="logo flex items-center gap-2 font-bold text-xl text-white opacity-0 animate-slide-in-left block">
            <img src="<?= APP_URL ?>/landing/images/logo.png" alt="Ztorespot Logo" class="h-10 sm:h-12 lg:h-14 w-auto">
        </a>

        <!-- Centered Navigation Links -->
        <nav class="hidden lg:flex items-center justify-center">
            <div class="flex items-center gap-6 xl:gap-8">
                <a href="#features"
                    class="nav-link text-gray-300 font-medium hover:text-white text-sm xl:text-base">Features</a>
                <a href="#testimonials"
                    class="nav-link text-gray-300 font-medium hover:text-white text-sm xl:text-base">Testimonials</a>
                <a href="#pricing"
                    class="nav-link text-gray-300 font-medium hover:text-white text-sm xl:text-base">Pricing</a>
                <a href="#themes"
                    class="nav-link text-gray-300 font-medium hover:text-white text-sm xl:text-base">Themes</a>
                <a href="https://www.youtube.com/@Ztorespot/videos" target="_blank" rel="noopener noreferrer"
                    class="text-gray-300 font-medium hover:text-white text-sm xl:text-base">Help Videos</a>
                <a href="<?= APP_URL ?>contact"
                    class="text-gray-300 font-medium hover:text-white text-sm xl:text-base">Contact Us</a>
            </div>
        </nav>

        <!-- Right CTA Buttons -->
        <div class="hidden lg:flex items-center gap-3 justify-end">
            <a href="<?= SELLER_URL ?>login">
                <button
                    class="bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0 text-sm xl:text-base">
                    Login
                </button>
            </a>
            <a href="<?= SELLER_URL ?>register">
                <button
                    class="bg-gradient-to-br from-ztore-purple to-ztore-pink text-white font-semibold py-3 px-6 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0 text-sm xl:text-base">
                    Get Started
                </button>
            </a>
        </div>

        <!-- Mobile Toggle -->
        <div class="mobile-toggle lg:hidden cursor-pointer p-2 z-50 justify-self-end">
            <img src="<?= APP_URL ?>/landing/images/nav_icon.svg" alt="Menu" class="w-7 h-7 mobile-icon">
        </div>
    </header>

    <!-- Mobile Navigation -->
    <nav
        class="mobile-nav-menu fixed top-0 left-0 w-full sm:w-80 h-full bg-[rgba(10,10,30,0.98)] backdrop-blur-2xl z-40 flex flex-col p-6 sm:p-8 lg:hidden">
        <!-- Close Button -->
        <div class="flex justify-between items-center mb-12">
            <a href="<?= APP_URL ?>" class="logo flex items-center gap-2 font-bold text-xl text-white">
                <img src="<?= APP_URL ?>/landing/images/logo.png" alt="Ztorespot Logo" class="h-8 w-auto">
                <span class="text-gradient">Ztorespot</span>
            </a>
            <button class="close-mobile-menu text-gray-300 hover:text-white p-2">
                <img src="<?= APP_URL ?>/landing/images/nav_close.svg" alt="Close Menu" class="w-6 h-6">
            </button>
        </div>

        <!-- Mobile Navigation Links -->
        <div class="flex flex-col gap-6">
            <a href="#features"
                class="text-lg mt-4 text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Features</a>
            <a href="#testimonials"
                class="text-lg font-medium text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Testimonials</a>
            <a href="#pricing"
                class="text-lg font-medium text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Pricing</a>
            <a href="#themes"
                class="text-lg font-medium text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Themes</a>
            <a href="https://www.youtube.com/@Ztorespot/videos" target="_blank" rel="noopener noreferrer"
                class="text-lg font-medium text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Help
                Videos</a>
            <a href="<?= APP_URL ?>contact"
                class="text-lg font-medium text-gray-300 transition-colors duration-300 hover:text-white py-3 border-b border-white/10">Contact Us</a>

            <!-- Mobile Buttons - Side by Side with Rounded Style -->
            <div class="flex flex-row gap-3 mt-4">
                <!-- Mobile Login Button -->
                <div class="flex-1">
                    <a href="<?= SELLER_URL ?>login">
                        <button
                            class="bg-gradient-to-br from-green-500 to-emerald-600 hover:from-green-600 hover:to-emerald-700 text-white font-semibold py-3 px-4 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0 text-base w-full text-center">
                            Login
                        </button>
                    </a>
                </div>

                <!-- Mobile Get Started Button -->
                <div class="flex-1">
                    <a href="<?= SELLER_URL ?>register">
                        <button
                            class="bg-gradient-to-br from-ztore-purple to-ztore-pink text-white font-semibold py-3 px-4 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0 text-base w-full text-center">
                            Get Started
                        </button>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="pt-32 relative overflow-hidden">

        <!-- Hero Section -->
        <section class="hero text-center px-4 sm:px-6 mt-6">
            <!-- Background Elements -->
            <div
                class="absolute top-[-150px] left-[-100px] w-64 sm:w-96 h-64 sm:h-96 rounded-full bg-ztore-pink blur-[100px] sm:blur-[150px] z-0 animate-float">
            </div>

            <div class="badge bg-white/10 inline-flex items-center gap-2 rounded-full py-1.5 px-4 text-xs sm:text-sm text-gray-400 mb-5 opacity-0 animate-fade-in-up"
                style="animation-delay: 0.4s">
                <span
                    class="bg-gradient-to-br from-ztore-purple to-ztore-pink text-white font-semibold py-0.5 px-2.5 rounded-full text-xs">NEW</span>
                We've just released new features →
            </div>

            <!-- VH-Based Typing Container -->
            <div class="typing-container mb-6">
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold leading-tight text-white opacity-0 animate-fade-in-up flex items-center justify-center text-center"
                    style="animation-delay: 0.6s" id="typing-headline">
                    <span id="typing-text" class="leading-relaxed px-4 inline-block"></span>
                </h1>
            </div>

            <p class="text-base sm:text-lg text-gray-300 mb-8 opacity-0 animate-fade-in-up max-w-2xl mx-auto px-4"
                style="animation-delay: 0.8s">
                Simple setup. Affordable pricing. Everything you need to start selling in minutes.
            </p>

            <!-- Rest of your content remains the same -->
            <div class="flex flex-col items-center justify-center mt-10 space-y-6 text-center">
                <!-- Input + Button -->

                <div class="max-w-2xl w-full">
                    <form action="<?= SELLER_URL ?>register" class="w-full">
                        <div class="flex flex-row justify-center items-center gap-2 sm:gap-3 w-full flex-wrap opacity-0 animate-fade-in-up"
                            style="animation-delay: 1s">

                            <!-- Input Field -->
                            <div
                                class="rainbow-border-input relative flex-[1_1_60%] max-w-[260px] sm:max-w-[380px] rounded-full">
                                <div
                                    class="input-content rounded-full py-3 px-4 sm:py-4 sm:px-6 text-gray-100 flex items-center transition-all duration-300 focus-within:ring-2 focus-within:ring-emerald-400/70">
                                    <span class="text-white-300 text-sm sm:text-base select-none">
                                        <?= $_SERVER['SERVER_NAME'] ?>/
                                    </span>
                                    <input type="text" placeholder="yourstore" name="storename"
                                        value="<?= isset($_GET['storename']) ? htmlspecialchars($_GET['storename']) : '' ?>"
                                        class="bg-transparent border-none outline-none ml-1 w-full text-white placeholder-gray-400 text-sm sm:text-base focus:text-white" />
                                </div>
                            </div>

                            <!-- Claim Button -->
                            <button type="submit"
                                class="bg-gradient-to-br from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white font-semibold py-3 sm:py-4 px-6 sm:px-8 rounded-full text-sm sm:text-base transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0">
                                Create Store
                            </button>
                        </div>
                    </form>
                </div>


                <!-- Already have account -->
                <p class="text-gray-400 text-sm sm:text-base">
                    Already have an account?
                    <a href="<?= SELLER_URL ?>login" class="font-medium">
                        <span class="text-gradient">Log in</span>
                    </a>
                </p>

                <!-- Stats Section -->
                <div
                    class="flex flex-col sm:flex-row items-center justify-center gap-4 sm:gap-8 mt-4 text-gray-300 text-xs sm:text-sm font-medium">
                    <div class="flex items-center gap-1">
                        <span class="glow-dot bg-emerald-400"></span>
                        <span>Onboarding Merchants: <span class="text-white font-semibold">7K+</span></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="glow-dot bg-lime-400"></span>
                        <span>Total Sales: <span class="text-white font-semibold">₹1.5Cr+</span></span>
                    </div>
                    <div class="flex items-center gap-1">
                        <span class="glow-dot bg-emerald-300"></span>
                        <span>Avg Customer Profit / Month: <span class="text-white font-semibold">₹30K+</span></span>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dashboard Section -->
        <section
            class="dashboard mt-12 sm:mt-16 mx-auto w-full max-w-4xl xl:max-w-5xl bg-[#121019]/80 rounded-2xl p-4 sm:p-6 backdrop-blur-xl shadow-[0_0_40px_rgba(0,0,0,0.4)] relative z-[30] overflow-hidden mb-9 transform-gpu transition-transform duration-700 will-change-transform">
            <div class="glow-border"></div>
            <div class="relative z-10">
                <!-- Remove fixed height and let video determine container size -->
                <div class="w-full rounded-xl overflow-hidden">
                    <video
                        class="w-full h-auto max-w-full rounded-xl transition-transform duration-700 hover:scale-105"
                        autoplay muted loop playsinline preload="auto"
                        poster="<?= APP_URL ?>/landing/images/hero_ztorespot.svg">
                        <source src="<?= APP_URL ?>/landing/images/hero.mp4" type="video/webm">
                        <source src="<?= APP_URL ?>/landing/images/hero.mp4" type="video/mp4">
                        <img src="<?= APP_URL ?>/landing/images/hero_ztorespot.svg" alt="Dashboard Preview"
                            class="w-full h-auto max-w-full rounded-xl">
                    </video>
                </div>
            </div>
        </section>

        <!-- Comparison Section -->
        <section id="compare" class="compare-plans py-20 px-2 sm:px-4 relative overflow-hidden text-gray-300">
            <!-- Background Glow Elements -->
            <div class="absolute top-20 left-[5%] w-48 h-48 bg-purple-600/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-[5%] w-56 h-56 bg-pink-500/10 rounded-full blur-3xl"></div>

            <div class="max-w-6xl mx-auto relative z-10 text-center">
                <!-- Section Header -->
                <header class="mb-12">
                    <h2 class="text-3xl sm:text-4xl font-bold mb-4 text-gray-100">
                        Why Thousands of Sellers Are Moving to<br> <span
                            class="text-gradient font-semibold">Ztorespot</span>
                    </h2>
                </header>

                <!-- Comparison Table -->
                <div
                    class="w-full mx-auto overflow-hidden rounded-xl border border-white/10 backdrop-blur-xl bg-gradient-to-br from-purple-700/10 to-pink-600/10 shadow-lg">
                    <table class="w-full border-collapse text-left text-gray-300 text-xs sm:text-sm">
                        <!-- Table Head -->
                        <thead class="bg-gradient-to-r from-purple-700/40 to-pink-600/30 text-gray-100">
                            <tr>
                                <th class="p-3 sm:p-4 font-semibold border-r border-gray-700 w-1/4">Features</th>
                                <th
                                    class="p-3 sm:p-4 font-semibold text-center border-r border-gray-700 bg-gradient-to-b from-purple-500/30 to-purple-600/30">
                                    <span class="text-white font-semibold">Ztorespot</span>
                                </th>
                                <th
                                    class="p-3 sm:p-4 font-semibold text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/30 to-blue-600/30">
                                    Dukaan</th>
                                <th
                                    class="p-3 sm:p-4 font-semibold text-center bg-gradient-to-b from-orange-500/30 to-orange-600/30">
                                    WooCommerce</th>
                            </tr>
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Setup Time</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    2 Minutes</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    10 mins</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    1–2 Days</td>
                            </tr>

                            <!-- Monthly Cost Row - Fully Highlighted with Green Price -->
                            <tr
                                class="border-t border-gray-700 bg-gradient-to-r from-purple-500/30 via-blue-500/30 to-orange-500/30">
                                <td
                                    class="p-3 sm:p-4 font-medium border-r bg-gradient-to-r from-emerald-500 to-green-600 border-gray-700">
                                    Monthly Cost</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white font-bold border-r border-gray-700 bg-gradient-to-r from-emerald-500 to-green-600 shadow-lg">
                                    ₹199</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white font-semibold border-r border-gray-700  bg-gradient-to-r from-emerald-500 to-green-600">
                                    ₹999+</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white font-semibold  bg-gradient-to-r from-emerald-500 to-green-600">
                                    ₹1,200+</td>
                            </tr>

                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Transaction Fees</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    0%</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    2–3%</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    1–2%</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">No-Code Platform</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    Yes</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    Yes</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-red-400 bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    No</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Plugins Required</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    No</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    No</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-red-400 bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    Yes</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Add - On</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    Free</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    ₹ 5,759/year</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    ₹9,960/year</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Support</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    Support Team <br>100% Human Support</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    Email Only</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    Limited</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Templates</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    10+ Premium</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    5+</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    Free & Paid</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-medium border-r border-gray-700">Automation</td>
                                <td
                                    class="p-3 sm:p-4 text-center text-white-400 font-semibold border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    Built-in</td>
                                <td
                                    class="p-3 sm:p-4 text-center border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    Limited</td>
                                <td class="p-3 sm:p-4 text-center bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    Add-on</td>
                            </tr>
                            <tr class="border-t border-gray-700">
                                <td class="p-3 sm:p-4 font-semibold border-r border-gray-700">Overall Rating</td>
                                <td
                                    class="p-3 sm:p-4 text-center font-semibold text-white-400 border-r border-gray-700 bg-gradient-to-b from-purple-500/20 to-purple-600/20">
                                    ⭐ 4.9</td>
                                <td
                                    class="p-3 sm:p-4 text-center font-semibold text-blue-400 border-r border-gray-700 bg-gradient-to-b from-blue-500/20 to-blue-600/20">
                                    ⭐ 4.2</td>
                                <td
                                    class="p-3 sm:p-4 text-center font-semibold text-orange-400 bg-gradient-to-b from-orange-500/20 to-orange-600/20">
                                    ⭐ 4.0</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>



        <!-- Testimonials Section - Interactive Cards -->
        <section id="testimonials" class="testimonials py-20 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-20 left-5% w-48 h-48 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-5% w-56 h-56 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16 opacity-0 animate-fade-in-up">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        5 Reasons Why Sellers <br> Love <span class="text-gradient">Ztorespot</span>
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto">
                        See how sellers go from struggle to success with Ztorespot.
                    </p>
                </div>

                <!-- Interactive Testimonial Grid -->
                <div class="testimonial-grid grid lg:grid-cols-2 gap-6 mb-12">
                    <!-- Main Featured Testimonial -->
                    <div class="featured-testimonial opacity-0 animate-slide-in-left">
                        <div
                            class="bg-gradient-to-br from-ztore-purple/20 to-ztore-pink/20 rounded-2xl p-8 h-full border border-white/10 backdrop-blur-xl relative overflow-hidden group hover:scale-[1.02] transition-transform duration-500">

                            <!-- Floating Elements -->
                            <div
                                class="absolute -top-4 -right-4 w-20 h-20 bg-ztore-purple/30 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500">
                            </div>
                            <div
                                class="absolute -bottom-4 -left-4 w-16 h-16 bg-ztore-pink/30 rounded-full blur-xl group-hover:scale-150 transition-transform duration-500">
                            </div>

                            <!-- Quote Icon -->
                            <div class="absolute top-6 right-6 opacity-20">
                                <svg class="w-12 h-12 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path
                                        d="M4.583 17.321C3.553 16.227 3 15 3 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179zm10 0C13.553 16.227 13 15 13 13.011c0-3.5 2.457-6.637 6.03-8.188l.893 1.378c-3.335 1.804-3.987 4.145-4.247 5.621.537-.278 1.24-.375 1.929-.311 1.804.167 3.226 1.648 3.226 3.489a3.5 3.5 0 01-3.5 3.5c-1.073 0-2.099-.49-2.748-1.179z" />
                                </svg>
                            </div>

                            <div class="relative z-10">
                                <!-- Rating Stars -->
                                <div class="flex gap-1 mb-4">
                                    <!-- 5 Stars -->
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-5 h-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>

                                <p class="text-lg text-gray-200 mb-6 leading-relaxed">
                                    "Very good platform to display your products. User-friendly website, friendly
                                    staff,
                                    and very affordable pricing. Payment gateway is also available now - I strongly
                                    recommend creating your own website with their help."
                                </p>

                                <div class="flex items-center gap-4">
                                    <!-- Profile Image -->
                                    <div class="w-12 h-12 rounded-full overflow-hidden flex-shrink-0">
                                        <img src="<?= APP_URL ?>/landing/images/clients-logos/rcu_nighties.png"
                                            alt="Ruc nighties logo" class="w-full h-full object-cover" />
                                    </div>

                                    <div>
                                        <h4 class="font-semibold text-white">Priyajai</h4>
                                        <p class="text-gray-400 text-sm">Saree Business Owner, Fashion Retailer</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- Smaller Testimonials Grid -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        <!-- Testimonial 1 -->
                        <div class="testimonial-card opacity-0 animate-slide-in-left" style="animation-delay: 0.2s">
                            <div
                                class="bg-white/5 rounded-2xl p-6 h-full border border-white/5 backdrop-blur-xl hover:border-white/10 transition-all duration-300 group hover:scale-105">
                                <div class="flex gap-1 mb-3">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                    "As a new comer to e-commerce, Ztore Spot guided me perfectly and made
                                    everything
                                    easy to understand. Really appreciate their patience and support!"
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden">
                                        <img src="<?= APP_URL ?>/landing/images/clients-logos/sridhar_badhri.png"
                                            alt="Profile Image" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white text-sm">Sridhar Badhri</h4>
                                        <p class="text-gray-400 text-xs">Startup Founder</p>
                                    </div>
                                </div>

                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="testimonial-card opacity-0 animate-slide-in-left" style="animation-delay: 0.3s">
                            <div
                                class="bg-white/5 rounded-2xl p-6 h-full border border-white/5 backdrop-blur-xl hover:border-white/10 transition-all duration-300 group hover:scale-105">
                                <div class="flex gap-1 mb-3">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                    "Ztore Spot was patient, professional, and supportive. They made e-commerce
                                    simple
                                    and their platform is perfect for beginners."
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden">
                                        <img src="<?= APP_URL ?>/landing/images/clients-logos/abdul_razack.png"
                                            alt="Profile Image" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white text-sm">Abdul Razack</h4>
                                        <p class="text-gray-400 text-xs">Grocery Seller</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="testimonial-card opacity-0 animate-slide-in-left" style="animation-delay: 0.4s">
                            <div
                                class="bg-white/5 rounded-2xl p-6 h-full border border-white/5 backdrop-blur-xl hover:border-white/10 transition-all duration-300 group hover:scale-105">
                                <div class="flex gap-1 mb-3">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                    "Great experience! Special thanks to Prabha mam for clearing all my doubts.
                                    Ztore
                                    Spot is the best platform to build a business website."
                                </p>
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white text-xs font-bold">
                                        S
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white text-sm">Swe Sri</h4>
                                        <p class="text-gray-400 text-xs">Electronics Product Seller</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 4 -->
                        <div class="testimonial-card opacity-0 animate-slide-in-left" style="animation-delay: 0.5s">
                            <div
                                class="bg-white/5 rounded-2xl p-6 h-full border border-white/5 backdrop-blur-xl hover:border-white/10 transition-all duration-300 group hover:scale-105">
                                <div class="flex gap-1 mb-3">
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                    <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                </div>
                                <p class="text-gray-300 text-sm mb-4 leading-relaxed">
                                    "ZtoreSpot made launching my business easy! The website setup was perfect, the
                                    admin
                                    panel simple to use, and the pricing very affordable."
                                </p>
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full overflow-hidden">
                                        <img src="<?= APP_URL ?>/landing/images/clients-logos/giftson.png"
                                            alt="Profile Image" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-white text-sm">Giftson</h4>
                                        <p class="text-gray-400 text-xs">Toy Shop</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stats Bar -->
                <div class="stats-bar opacity-0 animate-fade-in-up" style="animation-delay: 0.6s">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div
                            class="text-center p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/5 hover:border-white/10 transition-all duration-300">
                            <div class="text-3xl font-bold text-gradient mb-2">98%</div>
                            <div class="text-white-400 text-sm">Customer Satisfaction</div>
                        </div>
                        <div
                            class="text-center p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/5 hover:border-white/10 transition-all duration-300">
                            <div class="text-3xl font-bold text-gradient mb-2">4.9/5</div>
                            <div class="text-white-400 text-sm">Average Rating</div>
                        </div>
                        <div
                            class="text-center p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/5 hover:border-white/10 transition-all duration-300">
                            <div class="text-3xl font-bold text-gradient mb-2">2K+</div>
                            <div class="text-white-400 text-sm">Happy Customers</div>
                        </div>
                        <div
                            class="text-center p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/5 hover:border-white/10 transition-all duration-300">
                            <div class="text-3xl font-bold text-gradient mb-2">100%</div>
                            <div class="text-white-400 text-sm">Human Support</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Logo Section -->
        <section class="customer-logos py-12 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-20 left-5 w-24 h-24 bg-ztore-purple/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-20 right-5 w-28 h-28 bg-ztore-pink/10 rounded-full blur-2xl"></div>

            <div class="max-w-6xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-8">
                    <h3 class="text-2xl sm:text-3xl font-bold text-white mb-3">
                        Trusted by Thousands of Sellers
                    </h3>
                    <p class="text-gray-400 text-base max-w-2xl mx-auto">
                        Join Thousands of Businesses Growing with Ztorespot
                    </p>
                </div>

                <!-- Marquee Container - CIRCULAR NO START/END -->
                <div class="marquee-wrapper relative mb-8">
                    <!-- Marquee Track with DUPLICATE content for seamless loop -->
                    <div class="marquee-track animate-circular-marquee mt-2 mb-2">

                        <!-- FIRST SET - All 22 Logos -->
                        <!-- Logo 1 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/AivaLogo.png" alt="Aiva Logo"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 2 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/arisuclothing.png"
                                    alt="Arisu Clothing" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 3 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/BuyCoorg.jpg" alt="Buy Coorg"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 4 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/himajalittleshopee.png"
                                    alt="Himaja Little Shoppe" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 5 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/hyzafashion.png"
                                    alt="Hyza Fashion" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 6 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/karuvattukadal.png"
                                    alt="Karuvattukadal" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 7 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/kingspark.png"
                                    alt="Kings Park" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 8 - ROUND (littlelanterns) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/littlelanterns.jpg"
                                    alt="Little Lanterns" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 9 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/Lotystore.png" alt="Lotystore"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 10 - ROUND (MDF) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/MDF.jpg" alt="MDF"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 11 - ROUND (momanionshop) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/momanionshop.jpg"
                                    alt="Momanion Shop" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 12 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/mr2s.png" alt="MR2S"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 13 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/nammagarden.png"
                                    alt="Namma Garden" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 14 - ROUND (Nayem Mobiles) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/Nayem Mobiles.jpeg"
                                    alt="Nayem Mobiles" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 15 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/paatiyamma.png"
                                    alt="Paatiyamma" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 16 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/PoornaProductTMLogo.png"
                                    alt="Poorna Product" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 17 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/qqchef.png" alt="QQ Chef"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 18 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/smartkadai.png"
                                    alt="Smart Kadai" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 19 - ROUND (uniqfashions) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/uniqfashions.jpg"
                                    alt="Uniq Fashions" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 20 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/VJGraphicsLogo.png"
                                    alt="VJ Graphics" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 21 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/vronlineshopping.png"
                                    alt="VR Online Shopping" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 22 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/xtra.png" alt="Xtra"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>
                        <!-- Logo 23 - ROUND (Rcu sarees) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/rcu_nighties.png"
                                    alt="Rcu nighties" class="w-full h-full object-cover">
                            </div>
                        </div>
                        <!-- SECOND SET - EXACT DUPLICATE for seamless loop -->
                        <!-- Logo 1 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/AivaLogo.png" alt="Aiva Logo"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 2 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/arisuclothing.png"
                                    alt="Arisu Clothing" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 3 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/BuyCoorg.jpg" alt="Buy Coorg"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 4 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/himajalittleshopee.png"
                                    alt="Himaja Little Shoppe" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 5 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/hyzafashion.png"
                                    alt="Hyza Fashion" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 6 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/karuvattukadal.png"
                                    alt="Karuvattukadal" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 7 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/kingspark.png"
                                    alt="Kings Park" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 8 - ROUND (littlelanterns) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/littlelanterns.jpg"
                                    alt="Little Lanterns" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 9 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/Lotystore.png" alt="Lotystore"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 10 - ROUND (MDF) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/MDF.jpg" alt="MDF"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 11 - ROUND (momanionshop) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/momanionshop.jpg"
                                    alt="Momanion Shop" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 12 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/mr2s.png" alt="MR2S"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 13 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/nammagarden.png"
                                    alt="Namma Garden" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 14 - ROUND (Nayem Mobiles) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/Nayem Mobiles.jpeg"
                                    alt="Nayem Mobiles" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 15 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/paatiyamma.png"
                                    alt="Paatiyamma" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 16 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/PoornaProductTMLogo.png"
                                    alt="Poorna Product" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 17 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/qqchef.png" alt="QQ Chef"
                                    class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 18 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/smartkadai.png"
                                    alt="Smart Kadai" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 19 - ROUND (uniqfashions) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/uniqfashions.jpg"
                                    alt="Uniq Fashions" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 20 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/VJGraphicsLogo.png"
                                    alt="VJ Graphics" class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 21 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-20 h-12 sm:w-24 sm:h-14 md:w-28 md:h-16 lg:w-32 lg:h-18 overflow-hidden border border-white/20 bg-white/5 rounded-lg flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/vronlineshopping.png"
                                    alt="VR Online Shopping" class="w-full h-full object-contain p-1">
                            </div>
                        </div>

                        <!-- Logo 22 - Rectangular -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/xtra.png" alt="Xtra"
                                    class="w-full h-full object-cover">
                            </div>
                        </div>

                        <!-- Logo 23 - ROUND (Rcu sarees) -->
                        <div class="flex items-center justify-center mx-3 sm:mx-4">
                            <div
                                class="w-14 h-14 sm:w-16 sm:h-16 md:w-18 md:h-18 lg:w-20 lg:h-20 rounded-full overflow-hidden border-2 border-white/20 bg-white/5 flex-shrink-0">
                                <img src="<?= APP_URL ?>/landing/images/clients-logos/rcu_nighties.png"
                                    alt="Rcu nighties" class="w-full h-full object-cover">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rest of your existing code for arrow and "Next You" section -->
                <!-- Image Arrow -->
                <div class="flex justify-center mb-6">
                    <div class="flex flex-col items-center">
                        <img src="<?= APP_URL ?>/landing/images/arrow.gif" alt="Arrow"
                            class="w-24 h-20 sm:w-28 sm:h-24 md:w-32 md:h-28 animate-smoothFadeShake">
                    </div>
                </div>

                <!-- "Next You" Section -->
                <div class="text-center">
                    <div
                        class="inline-flex flex-col items-center gap-2 sm:gap-3 p-3 sm:p-4 bg-white/5 rounded-xl border border-white/10 backdrop-blur-xl">
                        <!-- Empty Frame with Green Question Mark -->
                        <div
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-full border-2 border-dashed border-gray-500 flex items-center justify-center overflow-hidden bg-white/5">
                            <span class="text-xl sm:text-2xl font-bold text-green-400">?</span>
                        </div>

                        <!-- Text -->
                        <div>
                            <h4 class="text-sm sm:text-base font-bold text-white mb-1">Is Your Store Next?</h4>
                            <p class="text-gray-400 text-xs max-w-xs">
                                Join our growing community of successful businesses
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!-- Testimonials Section with Marquee -->
        <section class="testimonials-scroll-section py-8 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-10 left-5% w-40 h-40 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-5% w-48 h-48 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        Success Stories from <br> <span class="text-gradient">Ztorespot</span> Users
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto">
                        Our users say it best - here's what makes their journey with us so successful.
                    </p>
                </div>

                <!-- Testimonials Scroll Container -->
                <div class="testimonials-scroll-wrapper mb-12">
                    <div class="testimonials-scroll-track">
                        <!-- Testimonial 1 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "I used Ztorespot to create my online store. Found the platform easy to use, no
                                coding
                                required."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>NB</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Nafila Begum</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 2 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Super budget-friendly and totally worth it for beginners. Support team is really
                                good
                                and helpful."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/Mohamed_Nayem.png"
                                        alt="Mohamed Nayem Logo" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>Mohamed Nayem</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 3 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "They understood my vision and turned it into a stunning, user-friendly website."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/KRComputers.png"
                                        alt="K R Computers Logo" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>K R Computers</h4>
                                    <p>Water World RO Systems</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 4 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Pricing was affordable, design is simple yet elegant. Excellent coordination
                                throughout."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>BK</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Bala Kumar</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 5 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Very good software for users with minimal budget. Customer service is satisfying."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/Selva.png"
                                        alt="Selva Logo" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>Selva</h4>
                                    <p>Local Guide</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 6 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Using Ztorespot is really wonderful. Customer service is excellent and site is easy
                                to
                                use."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/Balu MB.png"
                                        alt="Balu MB Logo" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>Balu MB</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 7 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "High-quality e-commerce websites at affordable prices within short time frame."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>TM</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Thoupik Mohamed</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 8 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Beautifully designed, user-friendly, and perfectly aligned with my brand."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>SK</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Saravanakumar</h4>
                                    <p>Poorna Products</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 9 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Process was very fast and website is easy to access. Proper response from
                                executives."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/Shubha Karthikeyan.png"
                                        alt="Shubha Karthikeyan" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>Shubha Karthikeyan</h4>
                                    <p>Handmade Jewelry</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 10 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Excellent web portal with easy setup. Great support for every query."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>VR</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Venkat Reddy</h4>
                                    <p>Local Guide</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 11 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Best price and best support from Ztorespot team. Best service for small business
                                owners."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <img src="<?= APP_URL ?>/landing/images/clients-logos/Abraham M.png"
                                        alt="Abraham M Logo" class="customer-logo">
                                </div>
                                <div class="customer-info">
                                    <h4>Abraham M</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 12 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Incredibly affordable with excellent support team. Highly recommended!"
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>NV</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Nandhakumar V</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 13 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Smooth and efficient process with expert guidance. Truly appreciate the support."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>SS</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Subash S</h4>
                                    <p>Local Guide</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 14 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Purchased website at affordable price, very happy with service. Excellent support
                                throughout."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>RK</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Rk</h4>
                                    <p>GayuFashion</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 15 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "User-friendly and affordable ecommerce platform. Great experience with customer
                                service."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>TI</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Toymiz India</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 16 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Good platform, user friendly. Thanks for valuable support."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>TT</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Thulasi</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 17 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Thank you for creating wonderful website for our business. Great support."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>MM</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Mohamed Mujamil</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 18 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Very good platform to display products. User friendly website for all business
                                needs."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>RS</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Ruc Sarees</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 19 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Very nice services, easily accessible website. Customer and owner portal
                                simplified."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>KV</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Kamalakannan</h4>
                                    <p>Local Guide</p>
                                </div>
                            </div>
                        </div>

                        <!-- Testimonial 20 -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "Excellent service, incredibly affordable. Support team clears all doubts easily."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>SS</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Subashini</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>

                        <!-- Duplicate for seamless loop -->
                        <div class="testimonial-review-card">
                            <div class="review-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <p class="review-text">
                                "I used Ztorespot to create my online store. Found the platform easy to use, no
                                coding
                                required."
                            </p>
                            <div class="review-author">
                                <div class="customer-avatar">
                                    <span>NB</span>
                                </div>
                                <div class="customer-info">
                                    <h4>Nafila Begum</h4>
                                    <p>Store Owner</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- See More Testimonials Button -->
                <div class="flex justify-center mt-12">
                    <div class="text-center">
                        <!-- Copy above button -->
                        <p class="text-gray-400 italic text-sm mb-4">
                            Still unsure? Hear sellers share their success journey with Ztorespot.
                        </p>

                        <a href="https://share.google/oDzuVJQXy0yE2g2z6"
                            target="_blank" rel="noopener noreferrer" class="inline-block">
                            <button
                                class="bg-gradient-to-br from-ztore-purple to-ztore-pink hover:from-ztore-purple/90 hover:to-ztore-pink/90 text-white font-semibold py-3 px-8 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0 text-base">
                                See More Success Stories
                            </button>
                        </a>
                    </div>
                </div>

                <!-- Last 30 Days Results Section - Monthly Dynamic Version -->
                <section class="py-12 px-4 sm:px-6 lg:px-8" id="dynamic-results">
                    <div class="max-w-5xl mx-auto">
                        <div
                            class="bg-white/5 rounded-3xl p-6 sm:p-8 backdrop-blur-xl border border-white/10 shadow-[0_0_30px_rgba(138,0,255,0.3)] transition-all duration-300">

                            <!-- Title -->
                            <div class="text-center mb-4">
                                <h3
                                    class="text-base sm:text-lg md:text-xl font-semibold flex justify-center items-center gap-2 mb-2 leading-tight">
                                    🏆 <span class="text-gradient font-bold" id="period-title">Monthly Results</span>
                                </h3>
                                <p class="text-gray-400 text-xs sm:text-sm">
                                    from our store owners across India
                                </p>
                            </div>

                            <!-- Stats Grid -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 sm:gap-6">
                                <!-- Card 1 - Total Sales -->
                                <div
                                    class="text-center p-4 sm:p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 shadow-[0_0_20px_rgba(138,0,255,0.2)] transition-all duration-300">
                                    <div class="text-2xl sm:text-3xl font-bold text-gradient mb-2" id="total-sales">₹24L</div>
                                    <div class="text-white-400 text-xs sm:text-sm">Total Sales</div>
                                </div>

                                <!-- Card 2 - Orders Processed -->
                                <div
                                    class="text-center p-4 sm:p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 shadow-[0_0_20px_rgba(138,0,255,0.2)] transition-all duration-300">
                                    <div class="text-2xl sm:text-3xl font-bold text-gradient mb-2" id="orders-processed">4.2k</div>
                                    <div class="text-white-400 text-xs sm:text-sm">Orders Processed</div>
                                </div>

                                <!-- Card 3 - New Stores Live -->
                                <div
                                    class="text-center p-4 sm:p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 shadow-[0_0_20px_rgba(138,0,255,0.2)] transition-all duration-300">
                                    <div class="text-2xl sm:text-3xl font-bold text-gradient mb-2" id="new-stores">847</div>
                                    <div class="text-white-400 text-xs sm:text-sm">New Stores Live</div>
                                </div>

                                <!-- Card 4 - Customer Satisfaction -->
                                <div
                                    class="text-center p-4 sm:p-6 bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 shadow-[0_0_20px_rgba(138,0,255,0.2)] transition-all duration-300">
                                    <div class="text-2xl sm:text-3xl font-bold text-gradient mb-2" id="satisfaction">98%</div>
                                    <div class="text-white-400 text-xs sm:text-sm">Customer Satisfaction</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>



            </div>
        </section>


        <!-- Dashboard Stats Section -->
        <section class="relative py-16 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-white leading-tight">
                        <span class="text-gradient">Low Cost</span>, More Customers, More Orders
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto italic">
                        This seller started with our Welcome Plan and achieved impressive revenue results
                    </p>
                </div>


                <!-- Dashboard Image - Reduced Padding -->
                <div class="relative max-w-5xl mx-auto">
                    <div
                        class="bg-[#121019]/80 rounded-2xl p-4 sm:p-6 backdrop-blur-xl shadow-2xl border border-white/10 relative overflow-hidden">
                        <div class="glow-border"></div>

                        <!-- Your Dashboard Image -->
                        <div class="relative z-10 rounded-xl overflow-hidden">
                            <img src="<?= APP_URL ?>/landing/images/dashboard_smartkadai.svg"
                                alt="Business Dashboard" class="w-full h-auto rounded-xl">
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- What Makes Ztorespot Different Section -->
        <section id="features"
            class="different-section py-8 sm:py-10 lg:py-24 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div
                class="absolute top-10 left-5% w-32 h-32 sm:w-40 sm:h-40 bg-ztore-purple/10 rounded-full blur-2xl sm:blur-3xl">
            </div>
            <div
                class="absolute bottom-10 right-5% w-36 h-36 sm:w-48 sm:h-48 bg-ztore-pink/10 rounded-full blur-2xl sm:blur-3xl">
            </div>

            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12 sm:mb-16">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 px-4">
                        What Makes <span class="text-gradient">Ztorespot Different</span>
                    </h2>
                    <p class="text-lg sm:text-xl text-gray-300 max-w-3xl mx-auto px-4">
                        Ztorespot is built for sellers who want to manage their online store easily, without any technical struggle.
                    </p>
                </div>

                <!-- Main Grid - Video on top for mobile, side-by-side for desktop -->
                <div class="flex flex-col lg:grid lg:grid-cols-2 gap-8 sm:gap-10 lg:gap-12 items-center">
                    <!-- Video Section - Always on top for mobile, left for desktop -->
                    <div class="relative w-full order-1">
                        <!-- Video Container -->
                        <div
                            class="bg-gradient-to-br from-ztore-purple/20 to-ztore-pink/20 rounded-2xl sm:rounded-3xl p-4 sm:p-6 backdrop-blur-xl border border-white/10 relative overflow-hidden">
                            <div class="glow-border"></div>

                            <div class="relative z-10 rounded-xl overflow-hidden">
                                <!-- Video -->
                                <video
                                    class="w-full h-auto rounded-xl transition-transform duration-700 hover:scale-105"
                                    autoplay muted loop playsinline preload="auto"
                                    poster="<?= APP_URL ?>/landing/images/hero_ztorespot.svg">
                                    <source src="<?= APP_URL ?>/landing/images/ztorespot_different.webm" type="video/webm">
                                    <source src="<?= APP_URL ?>/landing/images/ztorespot_different.mp4" type="video/mp4">
                                    <!-- Fallback to image if video not supported -->
                                    <img src="<?= APP_URL ?>/landing/images/hero_ztorespot.svg"
                                        alt="Ztorespot Dashboard Preview"
                                        class="w-full h-full object-cover rounded-xl">
                                </video>
                            </div>
                        </div>

                        <!-- Floating Cards with Top-Down Animation - Fixed positions and smaller sizes -->
                        <!-- No Extra Apps Card -->
                        <div
                            class="absolute -top-2 -left-2 sm:-top-3 sm:-left-3 w-20 h-16 sm:w-22 sm:h-18 lg:w-24 lg:h-20 bg-white/5 rounded-lg sm:rounded-xl backdrop-blur-xl border border-white/10 p-1 sm:p-1.5 transform rotate-3 sm:rotate-6 animate-float">
                            <div
                                class="flex flex-col items-center justify-center h-full w-full space-y-1 sm:space-y-1.5">
                                <div
                                    class="w-4 h-4 sm:w-5 sm:h-5 bg-green-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5 text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </div>
                                <span
                                    class="text-white text-[10px] sm:text-xs font-semibold leading-none whitespace-nowrap text-center px-0.5">No
                                    Extra Apps</span>
                            </div>
                        </div>

                        <!-- Secure Login Card -->
                        <div
                            class="absolute -bottom-2 -right-2 sm:-bottom-3 sm:-right-3 w-20 h-16 sm:w-22 sm:h-18 lg:w-24 lg:h-20 bg-white/5 rounded-lg sm:rounded-xl backdrop-blur-xl border border-white/10 p-1 sm:p-1.5 transform -rotate-3 sm:-rotate-6 animate-float-reverse">
                            <div
                                class="flex flex-col items-center justify-center h-full w-full space-y-1 sm:space-y-1.5">
                                <div
                                    class="w-4 h-4 sm:w-5 sm:h-5 bg-blue-500 rounded-full flex items-center justify-center flex-shrink-0">
                                    <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5 text-white" fill="none"
                                        stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </div>
                                <span
                                    class="text-white text-[10px] sm:text-xs font-semibold leading-none whitespace-nowrap text-center px-0.5">Secure
                                    Login</span>
                            </div>
                        </div>

                        <!-- Stats Overlay - Smaller and better positioned -->
                        <div
                            class="absolute -bottom-4 sm:-bottom-5 left-1/2 transform -translate-x-1/2 bg-white/10 backdrop-blur-xl rounded-xl sm:rounded-2xl p-2 sm:p-3 border border-white/10 min-w-[160px] sm:min-w-[180px] lg:min-w-[200px]">
                            <div class="grid grid-cols-3 gap-2 sm:gap-3 text-center">
                                <div>
                                    <div class="text-sm sm:text-base lg:text-lg font-bold text-white mb-0.5">100%
                                    </div>
                                    <div class="text-gray-300 text-[10px] sm:text-xs">No-Code</div>
                                </div>
                                <div>
                                    <div class="text-sm sm:text-base lg:text-lg font-bold text-white mb-0.5">0₹
                                    </div>
                                    <div class="text-gray-300 text-[10px] sm:text-xs">Fees</div>
                                </div>
                                <div>
                                    <div class="text-sm sm:text-base lg:text-lg font-bold text-white mb-0.5">2min
                                    </div>
                                    <div class="text-gray-300 text-[10px] sm:text-xs">Setup</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Features Grid - Right Side (18 Cards) -->
                    <div class="w-full order-2">
                        <!-- Mobile: 2 columns, Desktop: 3 columns - Now perfect 6 rows -->
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3 sm:gap-4">
                            <!-- Card 1: No Code Platform  -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-orange-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-orange-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-code-slash text-orange-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No Code Platform</span>
                                </div>
                            </div>

                            <!-- Card 2: No Drag & Drop -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-blue-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-blue-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-cursor text-blue-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No Drag & Drop</span>
                                </div>
                            </div>

                            <!-- Card 3: No Technical Skills -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-yellow-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-yellow-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person-workspace text-yellow-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No Technical Skills</span>
                                </div>
                            </div>

                            <!-- Card 4: WhatsApp Notification -->
                            <div
                                class="feature-card bg-gradient-to-br from-[#25D366]/45 to-[#128C7E]/45 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-green-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="absolute -top-2 -right-2">
                                    <div class="relative">
                                        <!-- Multi-color Ping effects -->
                                        <div class="absolute -inset-1 bg-yellow-400 rounded-full opacity-0 animate-ping-slow"
                                            style="animation-delay: 0s;"></div>
                                        <div class="absolute -inset-1 bg-pink-500 rounded-full opacity-0 animate-ping-slow"
                                            style="animation-delay: 1s;"></div>
                                        <div class="absolute -inset-1 bg-blue-400 rounded-full opacity-0 animate-ping-slow"
                                            style="animation-delay: 2s;"></div>

                                        <!-- Multi-color rotating star -->
                                        <div
                                            class="relative w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                                            <i
                                                class="bi bi-star-fill text-yellow-500 text-xs animate-star-colors-1s"></i>
                                        </div>
                                    </div>
                                </div>


                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-[#25D366]/25 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-whatsapp text-green-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">WhatsApp Notification</span>
                                </div>
                            </div>

                            <!-- Card 5: No AI Promotion -->
                            <div
                                class="feature-card bg-gradient-to-br from-[#8B5CF6]/45 to-[#6D28D9]/45 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-purple-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div class="absolute -top-2 -right-2">
                                        <div class="relative">
                                            <!-- Multi-color Ping effects -->
                                            <div class="absolute -inset-1 bg-yellow-400 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 0s;"></div>
                                            <div class="absolute -inset-1 bg-pink-500 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 1s;"></div>
                                            <div class="absolute -inset-1 bg-blue-400 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 2s;"></div>

                                            <!-- Multi-color rotating star -->
                                            <div
                                                class="relative w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                                                <i
                                                    class="bi bi-star-fill text-yellow-500 text-xs animate-star-colors-1s"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="w-8 h-8 bg-[#8B5CF6]/25 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-robot text-purple-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No AI Prompting</span>
                                </div>
                            </div>

                            <!-- Card 6: No Transaction Fees -->
                            <div
                                class="feature-card bg-gradient-to-br from-[#14B8A6]/25 to-[#0D9488]/45 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-teal-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div class="absolute -top-2 -right-2">
                                        <div class="relative">
                                            <!-- Multi-color Ping effects -->
                                            <div class="absolute -inset-1 bg-yellow-400 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 0s;"></div>
                                            <div class="absolute -inset-1 bg-pink-500 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 1s;"></div>
                                            <div class="absolute -inset-1 bg-blue-400 rounded-full opacity-0 animate-ping-slow"
                                                style="animation-delay: 2s;"></div>

                                            <!-- Multi-color rotating star -->
                                            <div
                                                class="relative w-6 h-6 bg-white rounded-full flex items-center justify-center shadow-sm">
                                                <i
                                                    class="bi bi-star-fill text-yellow-500 text-xs animate-star-colors-1s"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div
                                        class="w-8 h-8 bg-[#14B8A6]/25 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-currency-rupee text-teal-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No Transaction Fees</span>
                                </div>
                            </div>




                            <!-- Card 7: Easy to Use -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-green-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-green-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-check-circle text-green-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Easy to Use</span>
                                </div>
                            </div>

                            <!-- Card 8: No Additional Apps -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-red-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-red-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-plugin text-red-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">No Additional Apps & Plugins</span>
                                </div>
                            </div>


                            <!-- Card 7: Manage Inventory -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-indigo-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-indigo-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-box-seam text-indigo-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Manage Inventory</span>
                                </div>
                            </div>

                            <!-- Card 8: Manage Store Orders -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-pink-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-pink-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-cart-check text-pink-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Manage Store Orders</span>
                                </div>
                            </div>

                            <!-- Card 9: Multiple Staff Accounts -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-cyan-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-cyan-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-people text-cyan-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Multiple Staff Accounts</span>
                                </div>
                            </div>

                            <!-- Card 10: Multiple Templates -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-violet-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-violet-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-layout-text-window text-violet-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Multiple Templates</span>
                                </div>
                            </div>

                            <!-- Card 11: Custom Domain -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-amber-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-amber-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-globe text-amber-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Custom Domain</span>
                                </div>
                            </div>





                            <!-- Card 12: Secure Payments -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-lime-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-lime-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-shield-check text-lime-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Secure Payments</span>
                                </div>
                            </div>

                            <!-- Card 13: Reliable SMS OTP -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-sky-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-sky-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-chat-dots text-sky-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Reliable SMS OTP</span>
                                </div>
                            </div>




                            <!-- Card 14: Real-time Analytics -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-fuchsia-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-fuchsia-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-speedometer2 text-fuchsia-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Real-time Analytics</span>
                                </div>
                            </div>

                            <!-- Card 15: Unique Product Reports -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-teal-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-teal-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-graph-up text-teal-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Unique Product Reports</span>
                                </div>
                            </div>

                            <!-- Card 16: Customer Based Reports -->
                            <div
                                class="feature-card bg-white/5 rounded-xl p-3 sm:p-4 backdrop-blur-xl border border-white/10 hover:border-rose-400/30 transition-all duration-300 group hover:scale-105">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 bg-rose-500/20 rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="bi bi-person-lines-fill text-rose-400 text-sm"></i>
                                    </div>
                                    <span class="text-white text-sm font-medium">Customer Based Reports</span>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- A/B Testing Section -->
        <section class="ab-testing py-20 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-10 left-5% w-40 h-40 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-5% w-48 h-48 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-6 opacity-0 animate-fade-in-up">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        Why <span class="text-gradient">Ztorespot</span> Is Better</span>
                    </h2>
                </div>

                <!-- A/B Test 1 - Variant B -->
                <div class="ab-test-1 mb-20 opacity-0 animate-slide-in-left">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Mobile: Image Top, Content Bottom -->
                        <!-- Desktop: Image Left, Content Right -->
                        <div class="relative order-1">
                            <div
                                class="relative z-10 transform hover:scale-[1.02] transition-transform duration-500">
                                <!-- Main Image Container -->
                                <div
                                    class="bg-gradient-to-br from-orange-500/20 to-red-600/20 rounded-3xl p-6 backdrop-blur-xl border border-white/10">
                                    <div class="relative">
                                        <!-- Image -->
                                        <div
                                            class="flex items-center justify-center w-full rounded-2xl overflow-hidden bg-white/5">
                                            <img src="<?= APP_URL ?>/landing/images/A_B_testing_pain.svg"
                                                alt="Variant B - Optimized Workflow"
                                                class="w-full h-auto object-contain rounded-2xl" />
                                        </div>

                                    </div>
                                </div>

                                <!-- Decorative Elements -->
                                <div
                                    class="absolute -bottom-4 -left-4 w-20 h-20 bg-orange-400/30 rounded-full blur-xl">
                                </div>
                                <div class="absolute -top-4 -right-4 w-16 h-16 bg-red-400/30 rounded-full blur-xl">
                                </div>
                            </div>
                        </div>

                        <!-- Mobile: Content Bottom, Image Top -->
                        <!-- Desktop: Content Right, Image Left -->
                        <div class="lg:pl-8 order-2">
                            <div class="bg-white/5 rounded-2xl p-8 backdrop-blur-xl border border-white/10">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="w-12 h-12 bg-orange-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-orange-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">Other Platforms</h3>
                                </div>

                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Investment for online Store</span>
                                        <span class="text-red-400 font-bold text-lg">+58%</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Time to Complete</span>
                                        <span class="text-green-400 font-bold text-lg">5 - 10 days</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Ease of Use</span>
                                        <span class="text-green-400 font-bold text-lg">+64%</span>
                                    </div>
                                </div>

                                <p class="text-gray-300 leading-relaxed text-left md:text-left">
                                    Other platforms demand higher investment, require more time to complete tasks,
                                    and
                                    offer a less intuitive interface. Users face difficulties, extra steps, and
                                    slower outcomes.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- A/B Test 2 - Variant A -->
                <div class="ab-test-2 opacity-0 animate-slide-in-left" style="animation-delay: 0.3s">
                    <div class="grid lg:grid-cols-2 gap-12 items-center">
                        <!-- Mobile: Image Top, Content Bottom -->
                        <!-- Desktop: Image Right, Content Left -->
                        <div class="relative order-1 lg:order-2">
                            <div
                                class="relative z-10 transform hover:scale-[1.02] transition-transform duration-500">
                                <!-- Main Image Container -->
                                <div
                                    class="bg-gradient-to-br from-blue-500/20 to-purple-600/20 rounded-3xl p-6 backdrop-blur-xl border border-white/10">
                                    <div class="relative">
                                        <!-- Image -->
                                        <div
                                            class="flex items-center justify-center w-full rounded-2xl overflow-hidden bg-white/5">
                                            <img src="<?= APP_URL ?>/landing/images/A_B_testing_happy.svg"
                                                alt="Variant B - Optimized Workflow"
                                                class="w-full h-auto object-contain rounded-2xl">
                                        </div>
                                    </div>
                                </div>

                                <!-- Decorative Elements -->
                                <div
                                    class="absolute -bottom-4 -right-4 w-20 h-20 bg-blue-400/30 rounded-full blur-xl">
                                </div>
                                <div
                                    class="absolute -top-4 -left-4 w-16 h-16 bg-purple-400/30 rounded-full blur-xl">
                                </div>
                            </div>
                        </div>

                        <!-- Mobile: Content Bottom, Image Top -->
                        <!-- Desktop: Content Left, Image Right -->
                        <div class="lg:pr-8 order-2 lg:order-1">
                            <div class="bg-white/5 rounded-2xl p-8 backdrop-blur-xl border border-white/10">
                                <div class="flex items-center gap-3 mb-6">
                                    <div
                                        class="w-12 h-12 bg-blue-500/20 rounded-xl flex items-center justify-center">
                                        <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-2xl font-bold text-white">In Ztorespot</h3>
                                </div>

                                <div class="space-y-4 mb-6">
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Investment for online Store</span>
                                        <span class="text-green-400 font-bold text-lg">20%</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Time to Complete</span>
                                        <span class="text-green-400 font-bold text-lg">2 min</span>
                                    </div>
                                    <div class="flex justify-between items-center p-4 bg-white/5 rounded-xl">
                                        <span class="text-gray-300">Ease of Use</span>
                                        <span class="text-green-400 font-bold text-lg">+94%</span>
                                    </div>
                                </div>

                                <p class="text-gray-300 leading-relaxed text-left md:text-left">
                                    ZtoreSpot saves time and money, letting you set up your website in 2 minutes.
                                    Its
                                    user-friendly interface and smooth workflow make tasks simple, fast, and
                                    satisfying.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>



        <!--How Its Work-->
        <section class="relative min-h-[400px] py-12 bg-gradient-to-b from-[#060618] to-[#0b001f] overflow-hidden"
            id="order-cycle-3d">
            <div class="max-w-6xl mx-auto px-6 text-center relative">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold text-white mb-4">
                    How Its <span class="text-gradient">Work</span>
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-400 mb-12">From cart to customer powered by
                    ZtoreSpot.</p>

                <!-- Image (no orbit) -->
                <div class="image-container">
                    <img src="<?= APP_URL ?>/landing/images/How Its Work.gif" alt="Order Cycle Image"
                        class="order-image" />
                </div>
            </div>
        </section>



        <!-- Use Case Section -->
        <section class="relative py-12 overflow-hidden">
            <div class="max-w-6xl mx-auto text-center mb-12 px-6">
                <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4 text-white">
                    Who Can Uses <span class="text-gradient"> ZtoreSpot</span> ?
                </h2>
                <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-2xl mx-auto">
                    Used by sellers and startups, built to save time and minimize costs.
                </p>
            </div>

            <!-- 3D Circle Carousel Container -->
            <div
                class="carousel-3d-circle-container relative h-[500px] md:h-[600px] flex items-center justify-center">

                <div class="carousel-3d-circle relative w-full h-full">

                    <!-- Card 1 -->
                    <div class="circle-3d-card active" data-position="0">
                        <div class="card-inner bg-gradient-to-br from-blue-600 to-blue-800">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images/electronics_niche.jpg" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Electronics</h3>
                                <p class="text-gray-100 text-sm">Gadgets & accessories</p>

                            </div>
                        </div>
                    </div>

                    <!-- Card 2 -->
                    <div class="circle-3d-card" data-position="1">
                        <div class="card-inner bg-gradient-to-br from-pink-600 to-pink-800">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images//clothes_niche.jpg" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Fashion</h3>
                                <p class="text-gray-100 text-sm">Trending for all ages</p>

                            </div>
                        </div>
                    </div>

                    <!-- Card 3 -->
                    <div class="circle-3d-card" data-position="2">
                        <div class="card-inner bg-gradient-to-br from-amber-600 to-amber-800">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images/toys_niche.jpg" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Toys & Games</h3>
                                <p class="text-gray-100 text-sm">Trending for all ages</p>

                            </div>
                        </div>
                    </div>

                    <!-- Card 4 -->
                    <div class="circle-3d-card" data-position="3">
                        <div class="card-inner bg-gradient-to-br from-green-700 to-green-900">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images/grocery_niche.jpg" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Groceries</h3>
                                <p class="text-gray-100 text-sm">Fresh essentials</p>

                            </div>
                        </div>
                    </div>

                    <!-- Card 5 -->
                    <div class="circle-3d-card" data-position="4">
                        <div class="card-inner bg-gradient-to-br from-purple-600 to-purple-800">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images/homedecor_niche.png" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Home Decor</h3>
                                <p class="text-gray-100 text-sm">Stylish & functional</p>

                            </div>
                        </div>
                    </div>

                    <!-- Card 6 -->
                    <div class="circle-3d-card" data-position="5">
                        <div class="card-inner bg-gradient-to-br from-cyan-600 to-cyan-800">
                            <div class="image-wrapper">
                                <img src="<?= APP_URL ?>/landing/images/dropshipping_niche.jpg" class="card-img">
                            </div>
                            <div class="card-content">
                                <h3 class="text-xl md:text-2xl font-bold text-white mb-2">Dropshipping</h3>
                                <p class="text-gray-100 text-sm">Global fulfillment</p>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Side Navigation Arrows Only -->
                <button
                    class="circle-carousel-prev absolute left-4 md:left-8 bg-white/10 hover:bg-white/20 text-white p-3 rounded-full backdrop-blur-xl border border-white/10 transition-all duration-300 z-20 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button
                    class="circle-carousel-next absolute right-4 md:right-8 bg-white/10 hover:bg-white/20 text-white p-3 rounded-full backdrop-blur-xl border border-white/10 transition-all duration-300 z-20 hover:scale-110">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

            </div>
        </section>

        <!-- Pricing Plans Section -->
        <section id="pricing" class="pricing py-20 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-20 left-10% w-48 h-48 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-10% w-56 h-56 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-16">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        <span class="text-gradient">Choose</span> a plan that saves time and money
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto">
                        Simple Pricing for Every Business, Know exactly what you pay, start growing today.
                    </p>
                </div>

                <!-- Billing Toggle -->
                <div class="flex justify-center mb-12 lg:mb-16">
                    <div class="bg-white/5 rounded-2xl p-2 backdrop-blur-xl border border-white/10 relative">
                        <!-- Save Message Style Bubble -->
                        <div class="absolute -top-12 -right-4">
                            <div class="bg-green-500 text-white px-4 py-2 rounded-2xl font-semibold text-sm shadow-lg relative">
                                Save up to 67% yearly!
                                <div class="absolute -bottom-2 right-6 w-4 h-4 bg-green-500 transform rotate-45"></div>
                            </div>
                        </div>

                        <div class="flex items-center gap-2">
                            <button class="tab-btn monthly-toggle px-6 py-3 rounded-3xl font-semibold transition-all duration-500 bg-gradient-to-br from-ztore-purple to-ztore-pink text-white" data-tab="monthly">
                                Monthly
                            </button>
                            <button class="tab-btn yearly-toggle px-6 py-3 rounded-3xl font-semibold text-gray-300 transition-all duration-500 hover:text-white" data-tab="yearly">
                                Yearly
                            </button>
                        </div>
                    </div>
                </div>

                <?php
                // Debug: Check if functions exist
                if (!function_exists('getData') || !function_exists('readData') || !function_exists('calculateGst') || !function_exists('currencyToSymbol')) {
                    echo '<div class="text-center text-red-500 p-8">Error: Required PHP functions not found. Please check your includes.</div>';
                    return;
                }

                try {
                    // Get settings with error handling
                    $where = "new = 0 AND group_3 = 0";

                    // Check for new plan activation
                    $newPlanStartDate = getData("new_plan_start_date", "settings");
                    if ($newPlanStartDate && date('Y-m-d H:i:s') >= $newPlanStartDate) {
                        $checkNewPlan = getData("id", "subscription_plans", "new = 1");
                        if ($checkNewPlan) {
                            $where = "new = 1";
                        }
                    }

                    // Check for group_3 plan activation
                    $group3PlanStartDate = getData("group_3_plan_start_date", "settings");
                    if ($group3PlanStartDate && date('Y-m-d H:i:s') >= $group3PlanStartDate) {
                        $checkGroup3Plan = getData("id", "subscription_plans", "group_3 = 1");
                        if ($checkGroup3Plan) {
                            $where = "group_3 = 1";
                        }
                    }

                    // Get GST and currency settings
                    $gstRate = getData("gst_percentage", "settings") ?: 0;
                    $gstNumber = getData("gst_number", "settings") ?: '';
                    $gstType = getData("gst_tax_type", "settings") ?: 'exclusive';
                    $currency = currencyToSymbol(getData("currency", "settings")) ?: '₹';

                    // Debug log (remove in production)
                    error_log("Pricing Section - Where clause: $where");
                    error_log("Pricing Section - GST Rate: $gstRate, Currency: $currency, GST Type: $gstType");
                ?>

                    <!-- Monthly Plans Container -->
                    <div class="tab-content active" id="monthly">
                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 max-w-7xl mx-auto">
                            <?php
                            $monthlyPlans = [];
                            $yearlyPlans = [];
                            $allPlans = [];

                            try {
                                // Get ALL monthly plans (<12 months) for Welcome and Starter
                                $data = readData("*", "subscription_plans", "$where AND lifetime = 0 AND status = 1 ORDER BY CAST(amount AS DECIMAL) ASC");
                                if ($data) {
                                    while ($row = $data->fetch()) {
                                        $mainDuration = (int)($row['duration'] ?? 0);
                                        if ($mainDuration >= 12) continue;
                                        $row['plan_duration'] = $mainDuration;
                                        $monthlyPlans[$row['id'] . '_' . $mainDuration] = $row;
                                    }
                                }

                                // Get extra durations for monthly plans
                                $durations = readData("spd.*, sp.*", "subscription_plan_durations spd JOIN subscription_plans sp ON sp.id = spd.plan_id", $where);
                                if ($durations) {
                                    while ($row = $durations->fetch()) {
                                        $row['plan_duration'] = (int)($row['duration'] ?? 0);
                                        $row['amount'] = $row['amount'] ?? 0;
                                        $row['previous_amount'] = $row['previous_amount'] ?? 0;
                                        if ($row['plan_duration'] >= 12) continue;
                                        $monthlyPlans[$row['plan_id'] . '_' . $row['plan_duration']] = $row;
                                    }
                                }

                                // Get yearly plans for Intermediate and Professional
                                $targetDuration = 12;

                                // Get Intermediate and Professional yearly plans from main table
                                $yearlyData = readData("*", "subscription_plans", "$where AND lifetime = 0 AND status = 1 AND duration = $targetDuration AND (name = 'Intermediate' OR name = 'Professional') ORDER BY CAST(amount AS DECIMAL) ASC");
                                if ($yearlyData) {
                                    while ($row = $yearlyData->fetch()) {
                                        $row['plan_duration'] = (int)($row['duration'] ?? 0);
                                        $row['amount'] = $row['amount'] ?? 0;
                                        $row['previous_amount'] = $row['previous_amount'] ?? 0;
                                        $yearlyPlans[$row['id'] . '_' . $targetDuration] = $row;
                                    }
                                }

                                // Get extra durations for Intermediate and Professional yearly plans
                                $yearlyDurations = readData(
                                    "spd.*, sp.name, sp.description, sp.features, sp.id, sp.previous_amount",
                                    "subscription_plan_durations spd JOIN subscription_plans sp ON sp.id = spd.plan_id",
                                    "sp.$where AND spd.duration = $targetDuration AND (sp.name = 'Intermediate' OR sp.name = 'Professional')"
                                );

                                if ($yearlyDurations) {
                                    while ($row = $yearlyDurations->fetch()) {
                                        $row['plan_duration'] = (int)($row['duration'] ?? 0);
                                        $row['amount'] = $row['amount'] ?? 0;
                                        $row['previous_amount'] = $row['previous_amount'] ?? 0;
                                        $yearlyPlans[$row['plan_id'] . '_' . $targetDuration] = $row;
                                    }
                                }

                                // Combine both monthly and yearly plans for monthly tab
                                $allPlans = array_merge($monthlyPlans, $yearlyPlans);
                                usort($allPlans, fn($a, $b) => ((float)($a['amount'] ?? 0)) <=> ((float)($b['amount'] ?? 0)));
                            } catch (Exception $e) {
                                error_log("Error fetching plans: " . $e->getMessage());
                                $allPlans = [];
                            }

                            if (count($allPlans) > 0) :
                                foreach ($allPlans as $row) :
                                    // Validate required fields
                                    $planName = $row['name'] ?? 'Unknown Plan';
                                    $planAmount = (float)($row['amount'] ?? 0);
                                    $previousAmount = (float)($row['previous_amount'] ?? 0);
                                    $planDuration = (int)($row['plan_duration'] ?? ($row['duration'] ?? 1));
                                    $planId = $row['id'] ?? 0;
                                    $planDescription = $row['description'] ?? '';
                                    $planFeatures = $row['features'] ?? '';

                                    // Determine if this plan should show yearly price in monthly tab
                                    $showYearlyPriceInMonthly = ($planName === 'Intermediate' || $planName === 'Professional');

                                    // Calculate GST for current price
                                    if ($gstType === 'exclusive') {
                                        // GST is added on top
                                        $gstAmount = ($planAmount * $gstRate) / 100;
                                        $gstInclusivePrice = $planAmount + $gstAmount;
                                    } else {
                                        // GST is already included in the price
                                        $gstInclusivePrice = $planAmount;
                                    }

                                    // **FIXED: Calculate savings based on GST-inclusive prices**
                                    if ($previousAmount > 0 && $previousAmount > $planAmount) {
                                        if ($gstType === 'exclusive') {
                                            // For exclusive GST: Compare GST-inclusive prices
                                            $previousGstInclusivePrice = $previousAmount;
                                            $savingsAmount = $previousGstInclusivePrice - $gstInclusivePrice;
                                            $discountPercentage = round(($savingsAmount / $previousGstInclusivePrice) * 100);
                                            $mrpPrice = number_format($previousGstInclusivePrice);
                                        } else {
                                            // For inclusive GST: Compare GST-inclusive prices
                                            $savingsAmount = $previousAmount - $gstInclusivePrice;
                                            $discountPercentage = round(($savingsAmount / $previousAmount) * 100);
                                            $mrpPrice = number_format($previousAmount);
                                        }
                                        $showSavings = true;
                                    } else {
                                        $savingsAmount = 0;
                                        $discountPercentage = 0;
                                        $mrpPrice = '';
                                        $showSavings = false;
                                    }

                                    // Format final price (with GST if exclusive)
                                    $finalPrice = number_format($gstInclusivePrice);

                                    // Set duration label
                                    if ($showYearlyPriceInMonthly) {
                                        $years = $planDuration / 12;
                                        $durationLabel = $years . " Year" . ($years > 1 ? "s" : "");

                                        // Calculate monthly equivalent
                                        $monthlyEquivalent = $gstInclusivePrice / 12;
                                        $monthlyEquivalentPrice = number_format($monthlyEquivalent);
                                    } else {
                                        $durationLabel = $planDuration . " Month" . ($planDuration > 1 ? "s" : "");
                                    }

                                    // UI Configuration
                                    $uiConfig = [
                                        'Welcome' => ['recommended' => false, 'best_value' => false],
                                        'Starter Plan' => ['recommended' => false, 'best_value' => false],
                                        'Intermediate' => ['recommended' => true, 'best_value' => false],
                                        'Professional' => ['recommended' => false, 'best_value' => true]
                                    ];
                                    $config = $uiConfig[$planName] ?? $uiConfig['Welcome'];

                                    // Process features
                                    $allFeatures = !empty($planFeatures) ? explode(",", $planFeatures) : [];
                                    $visibleFeatures = array_slice($allFeatures, 0, 6);
                                    $hiddenFeatures = array_slice($allFeatures, 6);
                                    $hasHiddenFeatures = !empty($hiddenFeatures);

                                    // CSS class names
                                    $planSlug = strtolower(str_replace(' ', '-', $planName));
                            ?>
                                    <div class="pricing-card group relative <?= $config['recommended'] || $config['best_value'] ? 'transform scale-105 z-10 mt-8 lg:mt-4' : '' ?>">
                                        <?php if ($config['recommended']): ?>
                                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-black px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                                    RECOMMENDED
                                                </div>
                                            </div>
                                            <div class="bg-gradient-to-br from-ztore-purple/30 to-ztore-pink/30 rounded-3xl p-6 h-full border-2 border-yellow-400/50 backdrop-blur-xl shadow-2xl shadow-yellow-400/20">
                                            <?php elseif ($config['best_value']): ?>
                                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                                        BEST VALUE
                                                    </div>
                                                </div>
                                                <div class="bg-gradient-to-br from-amber-400/30 to-orange-500/30 rounded-3xl p-6 h-full border-2 border-purple-400/50 backdrop-blur-xl shadow-2xl shadow-purple-400/20">
                                                <?php else: ?>
                                                    <div class="bg-white/5 rounded-3xl p-6 h-full border border-white/10 backdrop-blur-xl transition-all duration-500">
                                                    <?php endif; ?>

                                                    <!-- Plan Header -->
                                                    <div class="text-center mb-6">
                                                        <h3 class="text-xl font-bold text-white mb-2"><?= htmlspecialchars($planName) ?></h3>

                                                        <?php if ($showSavings): ?>
                                                            <!-- Discount Badge -->
                                                            <div class="flex items-center justify-center gap-2 mb-3">
                                                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded"><?= $discountPercentage ?>% OFF</span>
                                                                <p class="text-green-400 text-xs">Save <?= $currency . number_format($savingsAmount) ?></p>
                                                            </div>
                                                        <?php endif; ?>

                                                        <?php if ($showYearlyPriceInMonthly): ?>
                                                            <!-- Show yearly price for Intermediate and Professional -->
                                                            <div class="flex flex-col items-center justify-center mb-1">
                                                                <?php if ($showSavings): ?>
                                                                    <!-- MRP and Current Price -->
                                                                    <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                        <span class="text-gray-400 text-sm line-through"><?= $currency . $mrpPrice ?></span>
                                                                        <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                        <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <!-- Current Price only -->
                                                                    <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                        <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                        <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                            <div class="text-sm text-gray-400 mb-2">
                                                                <span>Equivalent to <?= $currency . $monthlyEquivalentPrice ?>/month</span>
                                                            </div>
                                                        <?php else: ?>
                                                            <!-- Show monthly price for Welcome and Starter -->
                                                            <div class="flex flex-col items-center justify-center mb-1">
                                                                <?php if ($showSavings): ?>
                                                                    <!-- MRP and Current Price -->
                                                                    <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                        <span class="text-gray-400 text-sm line-through"><?= $currency . $mrpPrice ?></span>
                                                                        <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                        <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                    </div>
                                                                <?php else: ?>
                                                                    <!-- Current Price only -->
                                                                    <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                        <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                        <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                    </div>
                                                                <?php endif; ?>
                                                            </div>
                                                        <?php endif; ?>

                                                        <p class="text-gray-400 text-sm mt-2">
                                                            <?= htmlspecialchars($planDescription) ?>
                                                        </p>

                                                        <p class="text-gray-500 text-xs mt-1">
                                                            Inclusive of GST
                                                        </p>
                                                    </div>

                                                    <!-- Features -->
                                                    <ul class="space-y-3 mb-4 <?= $planSlug ?>-features">
                                                        <?php foreach ($visibleFeatures as $index => $value):
                                                            $trimmedValue = trim($value);
                                                            if (empty($trimmedValue)) continue;
                                                        ?>
                                                            <?php if ($planName === 'Professional' && $index === 0): ?>
                                                                <!-- Enhanced Custom Domain Mapping Feature for Professional -->
                                                                <li class="flex items-center gap-2 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-lg p-2 border border-purple-400/30">
                                                                    <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                                    </svg>
                                                                    <span class="text-white text-sm font-semibold"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                </li>
                                                            <?php else: ?>
                                                                <li class="flex items-center gap-2">
                                                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    <span class="text-gray-300 text-sm"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>

                                                        <!-- Hidden features -->
                                                        <?php if ($hasHiddenFeatures): ?>
                                                            <div class="<?= $planSlug ?>-hidden-features hidden space-y-3">
                                                                <?php foreach ($hiddenFeatures as $value):
                                                                    $trimmedValue = trim($value);
                                                                    if (empty($trimmedValue)) continue;
                                                                ?>
                                                                    <li class="flex items-center gap-2">
                                                                        <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                        </svg>
                                                                        <span class="text-gray-300 text-sm"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                    </li>
                                                                <?php endforeach; ?>
                                                            </div>
                                                        <?php endif; ?>
                                                    </ul>

                                                    <!-- See More/Less Button -->
                                                    <?php if ($hasHiddenFeatures): ?>
                                                        <div class="text-center mb-4">
                                                            <button class="see-more-btn <?= $planSlug ?>-see-more <?= $config['recommended'] ? 'text-yellow-400 hover:text-orange-400' : ($config['best_value'] ? 'text-purple-300 hover:text-indigo-300' : 'text-ztore-purple hover:text-ztore-pink') ?> text-sm font-semibold transition-colors duration-300">
                                                                See More Features ↓
                                                            </button>
                                                            <button class="see-less-btn <?= $planSlug ?>-see-less hidden <?= $config['recommended'] ? 'text-yellow-400 hover:text-orange-400' : ($config['best_value'] ? 'text-purple-300 hover:text-indigo-300' : 'text-ztore-purple hover:text-ztore-pink') ?> text-sm font-semibold transition-colors duration-300">
                                                                See Less Features ↑
                                                            </button>
                                                        </div>
                                                    <?php endif; ?>

                                                    <!-- CTA Button -->
                                                    <?php
                                                    $buttonClass = "w-full py-3 rounded-xl font-semibold transition-all duration-300 text-sm ";
                                                    if ($config['recommended']) {
                                                        $buttonClass .= "bg-gradient-to-br from-yellow-400 to-orange-500 text-black shadow-lg hover:scale-105 font-bold";
                                                    } elseif ($config['best_value']) {
                                                        $buttonClass .= "bg-gradient-to-br from-purple-600 to-indigo-600 text-white shadow-lg hover:scale-105 font-bold";
                                                    } else {
                                                        $buttonClass .= "bg-white/10 text-white border border-white/10 hover:bg-white/20";
                                                    }

                                                    // Determine checkout URL
                                                    if ($planId == 1) {
                                                        $checkoutUrl = SELLER_URL . "register";
                                                    } else {
                                                        $durationParam = $planDuration;
                                                        $checkoutUrl = SELLER_URL . "register?redirect=" . SELLER_URL . "checkout?plan=" . $planId . "&duration=" . $durationParam;
                                                    }
                                                    ?>
                                                    <a href="<?= $checkoutUrl ?>" class="<?= $buttonClass ?> block text-center">
                                                        Choose <?= htmlspecialchars($planName) ?>
                                                    </a>
                                                    </div>
                                                </div>
                                            <?php
                                        endforeach;
                                    else :
                                            ?>
                                            <div class="col-span-4 text-center py-12">
                                                <div class="bg-white/5 rounded-2xl p-8 backdrop-blur-xl border border-white/10">
                                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <h3 class="text-xl font-semibold text-gray-300 mb-2">No Plans Available</h3>
                                                    <p class="text-gray-400">Please check your subscription plan settings.</p>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                            </div>
                                    </div>

                                    <!-- Yearly Plans Container -->
                                    <div class="tab-content hidden" id="yearly">
                                        <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-4 gap-6 lg:gap-8 max-w-7xl mx-auto">
                                            <?php
                                            $yearlyTabPlans = [];
                                            $targetDuration = 12;

                                            try {
                                                // Get ALL yearly plans from main table
                                                $yearlyTabData = readData("*", "subscription_plans", "$where AND lifetime = 0 AND status = 1 AND duration = $targetDuration ORDER BY CAST(amount AS DECIMAL) ASC");
                                                if ($yearlyTabData) {
                                                    while ($row = $yearlyTabData->fetch()) {
                                                        $row['plan_duration'] = (int)($row['duration'] ?? 0);
                                                        $row['amount'] = $row['amount'] ?? 0;
                                                        $row['previous_amount'] = $row['previous_amount'] ?? 0;
                                                        $yearlyTabPlans[$row['id'] . '_' . $targetDuration] = $row;
                                                    }
                                                }

                                                // Get ALL extra durations for yearly
                                                $yearlyTabDurations = readData(
                                                    "spd.*, sp.name, sp.description, sp.features, sp.id, sp.previous_amount",
                                                    "subscription_plan_durations spd JOIN subscription_plans sp ON sp.id = spd.plan_id",
                                                    "sp.$where AND spd.duration = $targetDuration"
                                                );

                                                if ($yearlyTabDurations) {
                                                    while ($row = $yearlyTabDurations->fetch()) {
                                                        $row['plan_duration'] = (int)($row['duration'] ?? 0);
                                                        $row['amount'] = $row['amount'] ?? 0;
                                                        $row['previous_amount'] = $row['previous_amount'] ?? 0;
                                                        $yearlyTabPlans[$row['plan_id'] . '_' . $targetDuration] = $row;
                                                    }
                                                }

                                                usort($yearlyTabPlans, fn($a, $b) => ((float)($a['amount'] ?? 0)) <=> ((float)($b['amount'] ?? 0)));
                                            } catch (Exception $e) {
                                                error_log("Error fetching yearly plans: " . $e->getMessage());
                                                $yearlyTabPlans = [];
                                            }

                                            if (count($yearlyTabPlans) > 0) :
                                                foreach ($yearlyTabPlans as $row) :
                                                    // Validate required fields
                                                    $planName = $row['name'] ?? 'Unknown Plan';
                                                    $planAmount = (float)($row['amount'] ?? 0);
                                                    $previousAmount = (float)($row['previous_amount'] ?? 0);
                                                    $planDuration = (int)($row['plan_duration'] ?? ($row['duration'] ?? 12));
                                                    $planId = $row['id'] ?? 0;
                                                    $planDescription = $row['description'] ?? '';
                                                    $planFeatures = $row['features'] ?? '';

                                                    // Calculate GST for current price
                                                    if ($gstType === 'exclusive') {
                                                        // GST is added on top
                                                        $gstAmount = ($planAmount * $gstRate) / 100;
                                                        $gstInclusivePrice = $planAmount + $gstAmount;
                                                    } else {
                                                        // GST is already included in the price
                                                        $gstInclusivePrice = $planAmount;
                                                    }

                                                    // **FIXED: Calculate savings based on GST-inclusive prices**
                                                    if ($previousAmount > 0 && $previousAmount > $planAmount) {
                                                        if ($gstType === 'exclusive') {
                                                            // For exclusive GST: Compare GST-inclusive prices
                                                            $previousGstInclusivePrice = $previousAmount;
                                                            $savingsAmount = $previousGstInclusivePrice - $gstInclusivePrice;
                                                            $discountPercentage = round(($savingsAmount / $previousGstInclusivePrice) * 100);
                                                            $mrpPrice = number_format($previousGstInclusivePrice);
                                                        } else {
                                                            // For inclusive GST: Compare GST-inclusive prices
                                                            $savingsAmount = $previousAmount - $gstInclusivePrice;
                                                            $discountPercentage = round(($savingsAmount / $previousAmount) * 100);
                                                            $mrpPrice = number_format($previousAmount);
                                                        }
                                                        $showSavings = true;
                                                    } else {
                                                        $savingsAmount = 0;
                                                        $discountPercentage = 0;
                                                        $mrpPrice = '';
                                                        $showSavings = false;
                                                    }

                                                    // Format final price (with GST if exclusive)
                                                    $finalPrice = number_format($gstInclusivePrice);

                                                    // Set duration label
                                                    $years = $planDuration / 12;
                                                    $durationLabel = $years . " Year" . ($years > 1 ? "s" : "");

                                                    // UI Configuration
                                                    $uiConfig = [
                                                        'Welcome' => ['recommended' => false, 'best_value' => false],
                                                        'Starter Plan' => ['recommended' => false, 'best_value' => false],
                                                        'Intermediate' => ['recommended' => true, 'best_value' => false],
                                                        'Professional' => ['recommended' => false, 'best_value' => true]
                                                    ];
                                                    $config = $uiConfig[$planName] ?? $uiConfig['Welcome'];

                                                    // Process features
                                                    $allFeatures = !empty($planFeatures) ? explode(",", $planFeatures) : [];
                                                    $visibleFeatures = array_slice($allFeatures, 0, 6);
                                                    $hiddenFeatures = array_slice($allFeatures, 6);
                                                    $hasHiddenFeatures = !empty($hiddenFeatures);

                                                    // CSS class names
                                                    $planSlug = strtolower(str_replace(' ', '-', $planName));
                                            ?>
                                                    <div class="pricing-card group relative <?= $config['recommended'] || $config['best_value'] ? 'transform scale-105 z-10 mt-8 lg:mt-4' : '' ?>">
                                                        <?php if ($config['recommended']): ?>
                                                            <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                                                <div class="bg-gradient-to-r from-yellow-400 to-orange-500 text-black px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                                                    RECOMMENDED
                                                                </div>
                                                            </div>
                                                            <div class="bg-gradient-to-br from-ztore-purple/30 to-ztore-pink/30 rounded-3xl p-6 h-full border-2 border-yellow-400/50 backdrop-blur-xl shadow-2xl shadow-yellow-400/20">
                                                            <?php elseif ($config['best_value']): ?>
                                                                <div class="absolute -top-4 left-1/2 transform -translate-x-1/2 z-20">
                                                                    <div class="bg-gradient-to-r from-purple-600 to-indigo-600 text-white px-6 py-2 rounded-full text-sm font-bold shadow-lg animate-pulse">
                                                                        BEST VALUE
                                                                    </div>
                                                                </div>
                                                                <div class="bg-gradient-to-br from-amber-400/30 to-orange-500/30 rounded-3xl p-6 h-full border-2 border-purple-400/50 backdrop-blur-xl shadow-2xl shadow-purple-400/20">
                                                                <?php else: ?>
                                                                    <div class="bg-white/5 rounded-3xl p-6 h-full border border-white/10 backdrop-blur-xl transition-all duration-500">
                                                                    <?php endif; ?>

                                                                    <!-- Plan Header -->
                                                                    <div class="text-center mb-6">
                                                                        <h3 class="text-xl font-bold text-white mb-2"><?= htmlspecialchars($planName) ?></h3>

                                                                        <?php if ($showSavings): ?>
                                                                            <!-- Discount Badge -->
                                                                            <div class="flex items-center justify-center gap-2 mb-3">
                                                                                <span class="bg-green-500/20 text-green-400 text-xs px-2 py-1 rounded"><?= $discountPercentage ?>% OFF</span>
                                                                                <p class="text-green-400 text-xs">Save <?= $currency . number_format($savingsAmount) ?></p>
                                                                            </div>
                                                                        <?php endif; ?>

                                                                        <div class="flex flex-col items-center justify-center mb-1">
                                                                            <?php if ($showSavings): ?>
                                                                                <!-- MRP and Current Price -->
                                                                                <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                                    <span class="text-gray-400 text-sm line-through"><?= $currency . $mrpPrice ?></span>
                                                                                    <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                                    <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                                </div>
                                                                            <?php else: ?>
                                                                                <!-- Current Price only -->
                                                                                <div class="flex items-baseline justify-center gap-2 mb-1">
                                                                                    <span class="text-3xl font-bold text-white"><?= $currency . $finalPrice ?></span>
                                                                                    <span class="text-gray-300">/ <?= $durationLabel ?></span>
                                                                                </div>
                                                                            <?php endif; ?>
                                                                        </div>

                                                                        <p class="text-gray-400 text-sm mt-2">
                                                                            <?= htmlspecialchars($planDescription) ?>
                                                                        </p>

                                                                        <p class="text-gray-500 text-xs mt-1">
                                                                            Inclusive of GST
                                                                        </p>
                                                                    </div>

                                                                    <!-- Features -->
                                                                    <ul class="space-y-3 mb-4 <?= $planSlug ?>-features">
                                                                        <?php foreach ($visibleFeatures as $index => $value):
                                                                            $trimmedValue = trim($value);
                                                                            if (empty($trimmedValue)) continue;
                                                                        ?>
                                                                            <?php if ($planName === 'Professional' && $index === 0): ?>
                                                                                <!-- Enhanced Custom Domain Mapping Feature for Professional -->
                                                                                <li class="flex items-center gap-2 bg-gradient-to-r from-purple-500/20 to-pink-500/20 rounded-lg p-2 border border-purple-400/30">
                                                                                    <svg class="w-4 h-4 text-yellow-400 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                                                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z" />
                                                                                    </svg>
                                                                                    <span class="text-white text-sm font-semibold"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                                </li>
                                                                            <?php else: ?>
                                                                                <li class="flex items-center gap-2">
                                                                                    <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                                    </svg>
                                                                                    <span class="text-gray-300 text-sm"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                                </li>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>

                                                                        <!-- Hidden features -->
                                                                        <?php if ($hasHiddenFeatures): ?>
                                                                            <div class="<?= $planSlug ?>-hidden-features hidden space-y-3">
                                                                                <?php foreach ($hiddenFeatures as $value):
                                                                                    $trimmedValue = trim($value);
                                                                                    if (empty($trimmedValue)) continue;
                                                                                ?>
                                                                                    <li class="flex items-center gap-2">
                                                                                        <svg class="w-4 h-4 text-green-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                                        </svg>
                                                                                        <span class="text-gray-300 text-sm"><?= htmlspecialchars($trimmedValue) ?></span>
                                                                                    </li>
                                                                                <?php endforeach; ?>
                                                                            </div>
                                                                        <?php endif; ?>
                                                                    </ul>

                                                                    <!-- See More/Less Button -->
                                                                    <?php if ($hasHiddenFeatures): ?>
                                                                        <div class="text-center mb-4">
                                                                            <button class="see-more-btn <?= $planSlug ?>-see-more <?= $config['recommended'] ? 'text-yellow-400 hover:text-orange-400' : ($config['best_value'] ? 'text-purple-300 hover:text-indigo-300' : 'text-ztore-purple hover:text-ztore-pink') ?> text-sm font-semibold transition-colors duration-300">
                                                                                See More Features ↓
                                                                            </button>
                                                                            <button class="see-less-btn <?= $planSlug ?>-see-less hidden <?= $config['recommended'] ? 'text-yellow-400 hover:text-orange-400' : ($config['best_value'] ? 'text-purple-300 hover:text-indigo-300' : 'text-ztore-purple hover:text-ztore-pink') ?> text-sm font-semibold transition-colors duration-300">
                                                                                See Less Features ↑
                                                                            </button>
                                                                        </div>
                                                                    <?php endif; ?>

                                                                    <!-- CTA Button -->
                                                                    <?php
                                                                    $buttonClass = "w-full py-3 rounded-xl font-semibold transition-all duration-300 text-sm ";
                                                                    if ($config['recommended']) {
                                                                        $buttonClass .= "bg-gradient-to-br from-yellow-400 to-orange-500 text-black shadow-lg hover:scale-105 font-bold";
                                                                    } elseif ($config['best_value']) {
                                                                        $buttonClass .= "bg-gradient-to-br from-purple-600 to-indigo-600 text-white shadow-lg hover:scale-105 font-bold";
                                                                    } else {
                                                                        $buttonClass .= "bg-white/10 text-white border border-white/10 hover:bg-white/20";
                                                                    }

                                                                    // Determine checkout URL
                                                                    if ($planId == 1) {
                                                                        $checkoutUrl = SELLER_URL . "register";
                                                                    } else {
                                                                        $checkoutUrl = SELLER_URL . "register?redirect=" . SELLER_URL . "checkout?plan=" . $planId . "&duration=" . $planDuration;
                                                                    }
                                                                    ?>
                                                                    <a href="<?= $checkoutUrl ?>" class="<?= $buttonClass ?> block text-center">
                                                                        Choose <?= htmlspecialchars($planName) ?>
                                                                    </a>
                                                                    </div>
                                                                </div>
                                                            <?php
                                                        endforeach;
                                                    else :
                                                            ?>
                                                            <div class="col-span-4 text-center py-12">
                                                                <div class="bg-white/5 rounded-2xl p-8 backdrop-blur-xl border border-white/10">
                                                                    <svg class="w-16 h-16 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                                    </svg>
                                                                    <h3 class="text-xl font-semibold text-gray-300 mb-2">No Yearly Plans Available</h3>
                                                                    <p class="text-gray-400">Please check your yearly subscription plan settings.</p>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                            </div>
                                                    </div>

                                                    <!-- Trust Badge -->
                                                    <div class="text-center mt-12">
                                                        <div class="inline-flex items-center gap-4 text-gray-400 text-sm">
                                                            <svg class="w-5 h-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                                            </svg>
                                                            <span>14-day money-back guarantee • Cancel anytime</span>
                                                        </div>
                                                    </div>

                                                <?php
                                            } catch (Exception $e) {
                                                echo '<div class="text-center text-red-500 p-8">Error loading pricing plans: ' . htmlspecialchars($e->getMessage()) . '</div>';
                                            }
                                                ?>
                                        </div>
        </section>

        <!-- JavaScript (Improved) -->
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const tabButtons = document.querySelectorAll('.tab-btn');
                const tabContents = document.querySelectorAll('.tab-content');

                // Function to set the active tab
                function setActiveTab(tabId) {
                    // Update button styles
                    tabButtons.forEach(btn => {
                        btn.classList.remove('bg-gradient-to-br', 'from-ztore-purple', 'to-ztore-pink', 'text-white');
                        btn.classList.add('text-gray-300');

                        // Reset hover styles for yearly button
                        if (btn.classList.contains('yearly-toggle')) {
                            btn.classList.remove('hover:text-white');
                        }
                    });

                    // Set active button
                    const activeButton = document.querySelector(`[data-tab="${tabId}"]`);
                    if (activeButton) {
                        activeButton.classList.remove('text-gray-300');
                        activeButton.classList.add('bg-gradient-to-br', 'from-ztore-purple', 'to-ztore-pink', 'text-white');
                    }

                    // Show/hide tab contents with animation
                    tabContents.forEach(content => {
                        content.style.opacity = '0';
                        content.style.transform = 'translateY(20px)';
                        setTimeout(() => {
                            content.classList.add('hidden');
                            content.classList.remove('active');
                        }, 300);
                    });

                    const targetContent = document.getElementById(tabId);
                    if (targetContent) {
                        setTimeout(() => {
                            targetContent.classList.remove('hidden');
                            targetContent.classList.add('active');
                            setTimeout(() => {
                                targetContent.style.opacity = '1';
                                targetContent.style.transform = 'translateY(0)';
                                // Re-initialize see more functionality
                                initializeSeeMoreFunctionality(targetContent);
                            }, 50);
                        }, 300);
                    }
                }

                // Initialize tab system
                function initializeTabSystem() {
                    tabButtons.forEach(button => {
                        button.addEventListener('click', function() {
                            const targetTab = this.getAttribute('data-tab');
                            setActiveTab(targetTab);
                        });
                    });

                    // Set Yearly as default on page load
                    setActiveTab('yearly');
                }

                // Initialize see more functionality for a specific tab
                function initializeSeeMoreFunctionality(activeTab) {
                    if (!activeTab) return;

                    const seeMoreButtons = activeTab.querySelectorAll('.see-more-btn');
                    const seeLessButtons = activeTab.querySelectorAll('.see-less-btn');

                    // Add click event to See More buttons
                    seeMoreButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            const buttonClass = this.className;
                            const planTypeMatch = buttonClass.match(/(welcome|starter-plan|intermediate|professional)-see-more/);

                            if (planTypeMatch) {
                                const planType = planTypeMatch[1];
                                const hiddenFeatures = activeTab.querySelector(`.${planType}-hidden-features`);
                                const seeLessBtn = activeTab.querySelector(`.${planType}-see-less`);

                                if (hiddenFeatures && seeLessBtn) {
                                    // Show hidden features with animation
                                    hiddenFeatures.classList.remove('hidden');
                                    this.classList.add('hidden');
                                    seeLessBtn.classList.remove('hidden');

                                    // Animate the expansion
                                    requestAnimationFrame(() => {
                                        hiddenFeatures.style.maxHeight = hiddenFeatures.scrollHeight + 'px';
                                        hiddenFeatures.style.opacity = '1';
                                    });
                                }
                            }
                        });
                    });

                    // Add click event to See Less buttons
                    seeLessButtons.forEach(button => {
                        button.addEventListener('click', function(e) {
                            e.preventDefault();
                            e.stopPropagation();

                            const buttonClass = this.className;
                            const planTypeMatch = buttonClass.match(/(welcome|starter-plan|intermediate|professional)-see-less/);

                            if (planTypeMatch) {
                                const planType = planTypeMatch[1];
                                const hiddenFeatures = activeTab.querySelector(`.${planType}-hidden-features`);
                                const seeMoreBtn = activeTab.querySelector(`.${planType}-see-more`);

                                if (hiddenFeatures && seeMoreBtn) {
                                    // Hide features with animation
                                    hiddenFeatures.style.maxHeight = '0';
                                    hiddenFeatures.style.opacity = '0';

                                    setTimeout(() => {
                                        hiddenFeatures.classList.add('hidden');
                                        this.classList.add('hidden');
                                        seeMoreBtn.classList.remove('hidden');
                                    }, 300);
                                }
                            }
                        });
                    });
                }

                // Initialize on page load
                initializeTabSystem();

                // Initialize see more for the initially active tab (yearly)
                const yearlyTab = document.getElementById('yearly');
                if (yearlyTab) {
                    initializeSeeMoreFunctionality(yearlyTab);
                }
            });
        </script>

        <!-- CSS (Keep the same) -->
        <style>
            /* Smooth See More/Less Animations */
            .animate-feature-slideDown {
                animation: featureSlideDown 0.4s ease-out forwards;
            }

            .animate-feature-slideUp {
                animation: featureSlideUp 0.4s ease-out forwards;
            }

            @keyframes featureSlideDown {
                0% {
                    opacity: 0;
                    max-height: 0;
                    transform: translateY(-10px);
                }

                100% {
                    opacity: 1;
                    max-height: 1000px;
                    transform: translateY(0);
                }
            }

            @keyframes featureSlideUp {
                0% {
                    opacity: 1;
                    max-height: 1000px;
                    transform: translateY(0);
                }

                100% {
                    opacity: 0;
                    max-height: 0;
                    transform: translateY(-10px);
                }
            }

            /* Ensure smooth transitions for hidden features */
            .welcome-hidden-features,
            .starter-plan-hidden-features,
            .intermediate-hidden-features,
            .professional-hidden-features {
                overflow: hidden;
                max-height: 0;
                opacity: 0;
                transition: all 0.4s ease-in-out;
            }

            /* Button hover effects */
            .see-more-btn,
            .see-less-btn {
                transition: all 0.3s ease;
                cursor: pointer;
            }

            .see-more-btn:hover,
            .see-less-btn:hover {
                transform: translateY(-2px);
            }

            /* Responsive spacing for pricing cards */
            @media (max-width: 1024px) {
                .pricing-card {
                    margin-bottom: 1rem;
                }
            }

            @media (max-width: 768px) {
                .pricing-card {
                    margin-bottom: 1.5rem;
                }
            }

            /* Smooth tab transitions */
            .tab-content {
                transition: all 0.3s ease-in-out;
            }
        </style>

        <!-- Theme Portfolio Section -->
        <section id="themes" class="theme-portfolio py-16 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Glows -->
            <div class="absolute top-10 left-[5%] w-40 h-40 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-[5%] w-48 h-48 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-7xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        See <span class="text-gradient">Your Store</span> in Style
                    </h2>
                </div>

                <!-- Carousel Section -->

                <div class="relative mb-8 flex flex-col items-center justify-center">
                    <!-- Carousel -->
                    <div
                        class="carousel-container relative w-full max-w-6xl h-[480px] sm:h-[500px] flex items-center justify-center perspective-1000">
                        <div class="carousel-track relative flex items-center justify-center h-full w-full">

                            <!-- Theme 4 -->
                            <div class="carousel-item absolute w-[320px] sm:w-[360px] md:w-[400px] transition-all duration-700 transform cursor-pointer flex flex-col items-center"
                                data-position="left">
                                <div
                                    class="bg-gradient-to-br from-green-600 to-teal-700 rounded-2xl p-4 border border-green-500 shadow-xl flex flex-col h-[400px] sm:h-[420px]">
                                    <!-- Image with proper responsive sizing -->
                                    <div class="flex-1 flex items-center justify-center p-2">
                                        <img src="<?= APP_URL ?>/landing/images/Theme - 1.svg"
                                            alt="Minimalist Theme"
                                            class="w-auto h-auto max-w-full max-h-full rounded-2xl object-contain">
                                    </div>
                                    <!-- Button Section - Centered with smaller width -->
                                    <div class="flex justify-center mt-2">
                                        <a href="https://kingspark.in/" target="_blank"
                                            class="theme-btn bg-white text-green-700 py-2 px-8 rounded-lg font-semibold text-sm transition-all duration-300 hover:bg-green-50 w-40 text-center">
                                            Preview Theme
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme 2 -->
                            <div class="carousel-item absolute w-[320px] sm:w-[360px] md:w-[400px] transition-all duration-700 transform cursor-pointer flex flex-col items-center"
                                data-position="left">
                                <div
                                    class="bg-gradient-to-br from-orange-600 to-red-700 rounded-2xl p-4 border border-orange-500 shadow-xl flex flex-col h-[400px] sm:h-[420px]">
                                    <!-- Image with proper responsive sizing -->
                                    <div class="flex-1 flex items-center justify-center p-2">
                                        <img src="<?= APP_URL ?>/landing/images/Theme - 3.svg"
                                            alt="Bold Store Theme"
                                            class="w-auto h-auto max-w-full max-h-full rounded-2xl object-contain">
                                    </div>
                                    <!-- Button Section - Centered with smaller width -->
                                    <div class="flex justify-center mt-2">
                                        <a href="https://buycoorg.co.in/" target="_blank"
                                            class="theme-btn bg-white text-orange-700 py-2 px-8 rounded-lg font-semibold text-sm transition-all duration-300 hover:bg-orange-50 w-40 text-center">
                                            Preview Theme
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme 1 (Center) -->
                            <div class="carousel-item absolute w-[320px] sm:w-[360px] md:w-[400px] transition-all duration-700 transform cursor-pointer z-10 flex flex-col items-center"
                                data-position="center">
                                <div
                                    class="bg-gradient-to-br from-blue-600 to-purple-700 rounded-2xl p-4 border-2 border-white shadow-2xl flex flex-col h-[400px] sm:h-[420px]">
                                    <!-- Image with proper responsive sizing -->
                                    <div class="flex-1 flex items-center justify-center p-2">
                                        <img src="<?= APP_URL ?>/landing/images/Theme - 8.svg"
                                            alt="Modern Store Theme"
                                            class="w-auto h-auto max-w-full max-h-full rounded-2xl object-contain">
                                    </div>
                                    <!-- Button Section - Centered with smaller width -->
                                    <div class="flex justify-center mt-2">
                                        <a href="https://nammagarden.in/" target="_blank"
                                            class="theme-btn bg-white text-blue-700 py-2 px-8 rounded-lg font-semibold text-sm transition-all duration-300 hover:scale-[1.02] hover:bg-blue-50 w-40 text-center">
                                            Preview Theme
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme 3 -->
                            <div class="carousel-item absolute w-[320px] sm:w-[360px] md:w-[400px] transition-all duration-700 transform cursor-pointer flex flex-col items-center"
                                data-position="right">
                                <div
                                    class="bg-gradient-to-br from-ztore-purple to-ztore-pink rounded-2xl p-4 border border-purple-500 shadow-xl flex flex-col h-[400px] sm:h-[420px]">
                                    <!-- Image with proper responsive sizing -->
                                    <div class="flex-1 flex items-center justify-center p-2">
                                        <img src="<?= APP_URL ?>/landing/images/Theme - 9.svg" alt="Sales Pro Theme"
                                            class="w-auto h-auto max-w-full max-h-full rounded-2xl object-contain">
                                    </div>
                                    <!-- Button Section - Centered with smaller width -->
                                    <div class="flex justify-center mt-2">
                                        <a href="https://smartkadai.in/" target="_blank"
                                            class="theme-btn bg-white text-purple-700 py-2 px-8 rounded-lg font-semibold text-sm transition-all duration-300 hover:bg-purple-50 w-40 text-center">
                                            Preview Theme
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <!-- Theme 5 -->
                            <div class="carousel-item absolute w-[320px] sm:w-[360px] md:w-[400px] transition-all duration-700 transform cursor-pointer flex flex-col items-center"
                                data-position="right">
                                <div
                                    class="bg-gradient-to-br from-indigo-600 to-blue-700 rounded-2xl p-4 border border-indigo-500 shadow-xl flex flex-col h-[400px] sm:h-[420px]">
                                    <!-- Image with proper responsive sizing -->
                                    <div class="flex-1 flex items-center justify-center p-2">
                                        <img src="<?= APP_URL ?>/landing/images/Theme - 10.svg"
                                            alt="Professional Theme"
                                            class="w-auto h-auto max-w-full max-h-full rounded-2xl object-contain">
                                    </div>
                                    <!-- Button Section - Centered with smaller width -->
                                    <div class="flex justify-center mt-2">
                                        <a href="https://ztorespot.in/deepak/" target="_blank"
                                            class="theme-btn bg-white text-indigo-700 py-2 px-8 rounded-lg font-semibold text-sm transition-all duration-300 hover:bg-indigo-50 w-40 text-center">
                                            Preview Theme
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Carousel Controls -->
                    <div class="flex justify-center items-center gap-6 mt-4 z-20 relative">
                        <button
                            class="themes-carousel-prev bg-gradient-to-br from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white p-3 rounded-full border border-purple-400 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 19l-7-7 7-7" />
                            </svg>
                        </button>
                        <button
                            class="themes-carousel-next bg-gradient-to-br from-purple-600 to-pink-600 hover:from-purple-700 hover:to-pink-700 text-white p-3 rounded-full border border-purple-400 transition-all duration-300">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </section>


        <!-- More Themes Section -->
        <section class="more-themes py-0 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-10 left-5% w-40 h-40 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-5% w-48 h-48 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <!-- Fog Effects -->
            <div
                class="absolute top-0 left-0 w-full h-20 bg-gradient-to-b from-[#0a0a1e] to-transparent z-10 pointer-events-none">
            </div>
            <div
                class="absolute bottom-0 left-0 w-full h-20 bg-gradient-to-t from-[#0a0a1e] to-transparent z-10 pointer-events-none">
            </div>

            <div class="max-w-7xl mx-auto mt-6 relative z-20">
                <!-- Section Header -->
                <div class="text-center mb-8">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        More Beautiful <span class="text-gradient">Themes</span>
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto">
                        Explore our collection of stunning themes designed for every business type
                    </p>
                </div>

                <!-- Left to Right Scroller - 13 Images -->
                <div class="scroller-section mb-8">
                    <div class="scroller-wrapper relative">
                        <!-- Left Gradient Fade -->
                        <div
                            class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-[#0a0a1e] to-transparent z-10 pointer-events-none">
                        </div>

                        <!-- Right Gradient Fade -->
                        <div
                            class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-[#0a0a1e] to-transparent z-10 pointer-events-none">
                        </div>

                        <!-- Scroller Track -->
                        <div class="scroller-track-left flex gap-6 animate-scroll-left py-2">
                            <!-- 13 Images - NO CONTAINERS -->
                            <img src="<?= APP_URL ?>/landing/images/9.png" alt="Theme 9" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/3.png" alt="Theme 3" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/12.png" alt="Theme 12" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/1.png" alt="Theme 1" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/7.png" alt="Theme 7" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/13.png" alt="Theme 13" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/4.png" alt="Theme 4" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/10.png" alt="Theme 10" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/2.png" alt="Theme 2" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/6.png" alt="Theme 6" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/11.png" alt="Theme 11" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/5.png" alt="Theme 5" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/8.png" alt="Theme 8" class="theme-image">


                            <img src="<?= APP_URL ?>/landing/images/4.png" alt="Theme 4" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/11.png" alt="Theme 11" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/1.png" alt="Theme 1" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/8.png" alt="Theme 8" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/13.png" alt="Theme 13" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/6.png" alt="Theme 6" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/3.png" alt="Theme 3" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/10.png" alt="Theme 10" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/7.png" alt="Theme 7" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/2.png" alt="Theme 2" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/12.png" alt="Theme 12" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/9.png" alt="Theme 9" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/5.png" alt="Theme 5" class="theme-image">

                        </div>
                    </div>
                </div>

                <!-- Right to Left Scroller - 13 Images -->
                <div class="scroller-section mb-8">
                    <div class="scroller-wrapper relative">
                        <!-- Left Gradient Fade -->
                        <div
                            class="absolute left-0 top-0 bottom-0 w-32 bg-gradient-to-r from-[#0a0a1e] to-transparent z-10 pointer-events-none">
                        </div>

                        <!-- Right Gradient Fade -->
                        <div
                            class="absolute right-0 top-0 bottom-0 w-32 bg-gradient-to-l from-[#0a0a1e] to-transparent z-10 pointer-events-none">
                        </div>

                        <!-- Scroller Track -->
                        <div class="scroller-track-right flex gap-6 animate-scroll-right py-2">
                            <!-- 13-26 Images - NO CONTAINERS -->
                            <img src="<?= APP_URL ?>/landing/images/19.png" alt="Theme 19" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/25.png" alt="Theme 25" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/14.png" alt="Theme 14" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/22.png" alt="Theme 22" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/26.png" alt="Theme 26" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/17.png" alt="Theme 17" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/20.png" alt="Theme 20" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/15.png" alt="Theme 15" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/24.png" alt="Theme 24" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/13.png" alt="Theme 13" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/23.png" alt="Theme 23" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/18.png" alt="Theme 18" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/21.png" alt="Theme 21" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/16.png" alt="Theme 16" class="theme-image">


                            <!-- Duplicate for seamless loop -->
                            <img src="<?= APP_URL ?>/landing/images/24.png" alt="Theme 24" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/16.png" alt="Theme 16" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/21.png" alt="Theme 21" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/18.png" alt="Theme 18" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/14.png" alt="Theme 14" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/26.png" alt="Theme 26" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/20.png" alt="Theme 20" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/23.png" alt="Theme 23" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/15.png" alt="Theme 15" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/25.png" alt="Theme 25" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/19.png" alt="Theme 19" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/22.png" alt="Theme 22" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/17.png" alt="Theme 17" class="theme-image">
                            <img src="<?= APP_URL ?>/landing/images/13.png" alt="Theme 13" class="theme-image">

                        </div>
                    </div>
                </div>
            </div>
        </section>




        <!-- FAQ Section -->
        <section class="faq py-16 px-4 sm:px-6 relative overflow-hidden">
            <!-- Background Elements -->
            <div class="absolute top-20 left-5% w-48 h-48 bg-ztore-purple/10 rounded-full blur-3xl"></div>
            <div class="absolute bottom-20 right-5% w-56 h-56 bg-ztore-pink/10 rounded-full blur-3xl"></div>

            <div class="max-w-4xl mx-auto">
                <!-- Section Header -->
                <div class="text-center mb-12">
                    <h2 class="text-3xl sm:text-4xl md:text-5xl font-bold mb-4">
                        Frequently Asked <span class="text-gradient">Questions</span>
                    </h2>
                    <p class="text-base sm:text-lg lg:text-xl text-gray-300 max-w-3xl mx-auto">
                        Get all the answers to the most common questions about Ztorespot
                    </p>
                </div>

                <!-- Interactive FAQ Grid -->
                <div class="faq-grid grid md:grid-cols-2 gap-6 mb-8">
                    <!-- Column 1 -->
                    <div class="space-y-6">
                        <!-- FAQ Item 1 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">What is Ztorespot.com?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    Ztorespot.com is a DIY platform that lets anyone create their dream online store
                                    in
                                    just 2 minutes.
                                    It’s an ideal solution for small and medium-sized business owners — including
                                    those
                                    running
                                    offline shops like grocery stores, apparel boutiques, snack vendors,
                                    restaurants,
                                    and homemade
                                    product sellers.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ Item 2 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">How is Ztorespot.com different
                                    from
                                    other e-commerce platforms?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    Ztorespot.com stands out for its simplicity. Unlike other platforms that can be
                                    complex,
                                    Ztorespot.com is designed to be easy to understand and use. There are no
                                    complicated
                                    steps,
                                    making it perfect for users with basic computer or mobile skills.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ Item 3 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">Is Ztorespot.com affordable
                                    compared
                                    to other e-commerce platforms?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    Yes. Ztorespot.com offers more budget-friendly pricing than other e-commerce
                                    platforms such as Shopify,
                                    Dukaan, Wix, or WooCommerce. We believe in providing cost-effective solutions
                                    that
                                    meet the
                                    needs of small and medium-scale businesses.
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Column 2 -->
                    <div class="space-y-6">
                        <!-- FAQ Item 4 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">What types of businesses is
                                    Ztorespot.com suitable for?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    Ztorespot.com is perfect for a variety of businesses, including grocery stores,
                                    apparel shops, snack vendors,
                                    restaurants, and homemade business owners. It’s designed to help small and
                                    medium-scale businesses
                                    establish their online presence effortlessly.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ Item 5 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">Do I need coding skills to use
                                    Ztorespot.com?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    No. Ztorespot.com is a no-code platform. You only need basic computer or mobile
                                    knowledge to run your store.
                                    The platform is built to be user-friendly, so anyone can set up and manage their
                                    online store without
                                    coding experience.
                                </p>
                            </div>
                        </div>

                        <!-- FAQ Item 6 -->
                        <div
                            class="faq-item bg-white/5 rounded-2xl backdrop-blur-xl border border-white/10 overflow-hidden group hover:border-ztore-purple/30 transition-all duration-500">
                            <button
                                class="faq-question w-full text-left p-6 flex justify-between items-center hover:bg-white/5 transition-all duration-300">
                                <span class="font-semibold text-white text-lg pr-4">Is there a free trial
                                    available?</span>
                                <svg class="w-6 h-6 text-ztore-purple transform group-hover:scale-110 transition-transform duration-300 flex-shrink-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div class="faq-answer px-6 pb-6 hidden">
                                <p class="text-gray-300 leading-relaxed">
                                    While there isn’t a traditional free trial, Ztorespot.com offers a 1-month
                                    introductory period for just ₹199.
                                    This allows you to explore and use the platform. If it fits your needs, you can
                                    upgrade to one of our SIP
                                    plans — Starter, Intermediate, or Professional.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Final CTA Section -->
                <div class="final-cta text-center">
                    <div
                        class="bg-gradient-to-br from-ztore-purple/20 to-ztore-pink/20 rounded-2xl p-8 backdrop-blur-xl border border-white/10">
                        <!-- Icon -->
                        <div
                            class="w-16 h-16 bg-gradient-to-br from-ztore-purple to-ztore-pink rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>

                        <h3 class="text-2xl font-bold text-white mb-4">Still have questions?</h3>
                        <p class="text-gray-300 mb-6 max-w-md mx-auto">
                            Our team is ready to assist you and get you started quickly.
                        </p>

                        <div class="flex flex-col sm:flex-row gap-4 justify-center">
                            <a href="https://wa.me/+919442899754" target="_blank" rel="noopener noreferrer">
                                <button
                                    class="bg-gradient-to-br from-ztore-purple to-ztore-pink hover:from-ztore-purple/90 hover:to-ztore-pink/90 text-white px-8 py-3 rounded-full font-semibold transition-all duration-300 shadow-lg hover:shadow-xl backdrop-blur-xl transform hover:scale-105 whitespace-nowrap flex-shrink-0">
                                    Contact Support
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>



    </main>

    <!-- Footer -->

    <?php require __DIR__ . "/includes/footer.php" ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <script type="application/ld+json">
        {
            "@context": "https://schema.org",
            "@type": "FAQPage",
            "mainEntity": [{
                    "@type": "Question",
                    "name": "What is Ztorespot.com?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Ztorespot.com is a DIY platform that lets anyone create their dream online store in just 2 minutes. It’s an ideal solution for small and medium-sized business owners — including those running offline shops like grocery stores, apparel boutiques, snack vendors, restaurants, and homemade product sellers."
                    }
                },
                {
                    "@type": "Question",
                    "name": "How is Ztorespot.com different from other e-commerce platforms?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Ztorespot.com stands out for its simplicity. Unlike other platforms that can be complex, Ztorespot.com is designed to be easy to understand and use. There are no complicated steps, making it perfect for users with basic computer or mobile skills."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is Ztorespot.com affordable compared to other e-commerce platforms?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Yes. Ztorespot.com offers more budget-friendly pricing than other e-commerce platforms such as Shopify, Dukaan, Wix, or WooCommerce. We believe in providing cost-effective solutions that meet the needs of small and medium-scale businesses."
                    }
                },
                {
                    "@type": "Question",
                    "name": "What types of businesses is Ztorespot.com suitable for?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "Ztorespot.com is perfect for a variety of businesses, including grocery stores, apparel shops, snack vendors, restaurants, and homemade business owners. It’s designed to help small and medium-scale businesses establish their online presence effortlessly."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Do I need coding skills to use Ztorespot.com?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "No. Ztorespot.com is a no-code platform. You only need basic computer or mobile knowledge to run your store. The platform is built to be user-friendly, so anyone can set up and manage their online store without coding experience."
                    }
                },
                {
                    "@type": "Question",
                    "name": "Is there a free trial available?",
                    "acceptedAnswer": {
                        "@type": "Answer",
                        "text": "While there isn’t a traditional free trial, Ztorespot.com offers a 1-month introductory period for just ₹199. This allows you to explore and use the platform. If it fits your needs, you can upgrade to one of our SIP plans — Starter, Intermediate, or Professional."
                    }
                }
            ]
        }
    </script>

    <script>
        // -------------- js Style Nav Smooth Scrolling --------------
        // Smooth Scrolling Functionality
        document.addEventListener('DOMContentLoaded', function() {
            // Add nav-link class to all navigation links
            const navLinks = document.querySelectorAll('a[href^="#"]');
            navLinks.forEach(link => {
                link.classList.add('nav-link');
            });

            // Smooth scrolling function
            function smoothScroll(targetId) {
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    const headerHeight = document.querySelector('header').offsetHeight;
                    const targetPosition = targetSection.offsetTop - headerHeight - 20; // 20px extra spacing

                    window.scrollTo({
                        top: targetPosition,
                        behavior: 'smooth'
                    });
                }
            }

            // Click event for all navigation links
            document.querySelectorAll('.nav-link').forEach(link => {
                link.addEventListener('click', function(e) {
                    e.preventDefault();

                    const targetId = this.getAttribute('href');

                    // Close mobile menu if open
                    const mobileNav = document.querySelector('.mobile-nav-menu');
                    if (mobileNav && mobileNav.classList.contains('active')) {
                        mobileNav.classList.remove('active');
                        document.body.classList.remove('no-scroll');
                        const mobileIcon = document.querySelector('.mobile-icon');
                        if (mobileIcon) {
                            mobileIcon.src = "<?= APP_URL ?>/landing/images/nav_icon.svg";
                        }
                    }

                    // Smooth scroll to section
                    smoothScroll(targetId);
                });
            });

            // Update active nav link on scroll
            function updateActiveNavLink() {
                const sections = document.querySelectorAll('section[id]');
                const navLinks = document.querySelectorAll('.nav-link');

                let currentSection = '';
                const scrollPosition = window.scrollY + 100; // Offset for better detection

                sections.forEach(section => {
                    const sectionTop = section.offsetTop;
                    const sectionHeight = section.offsetHeight;
                    const sectionId = section.getAttribute('id');

                    if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
                        currentSection = sectionId;
                    }
                });

                navLinks.forEach(link => {
                    link.classList.remove('active', 'text-white');
                    link.classList.add('text-gray-300');

                    if (link.getAttribute('href') === `#${currentSection}`) {
                        link.classList.remove('text-gray-300');
                        link.classList.add('active', 'text-white');
                    }
                });
            }

            // Throttle scroll events for performance
            let scrollTimer;
            window.addEventListener('scroll', function() {
                if (!scrollTimer) {
                    scrollTimer = setTimeout(function() {
                        updateActiveNavLink();
                        scrollTimer = null;
                    }, 100);
                }
            });

            // Initial update
            updateActiveNavLink();
        });

        // -------------- js Style Nav --------------
        // Your existing JavaScript remains the same...
        const mobileToggle = document.querySelector('.mobile-toggle');
        const mobileIcon = document.querySelector('.mobile-icon');
        const mobileNavMenu = document.querySelector('.mobile-nav-menu');
        const closeMobileMenu = document.querySelector('.close-mobile-menu');
        const body = document.body;

        const menuIconSrc = "<?= APP_URL ?>/landing/images/nav_icon.svg";
        const closeIconSrc = "<?= APP_URL ?>/landing/images/nav_close.svg";

        function openMobileMenu() {
            mobileNavMenu.classList.add('active');
            body.classList.add('no-scroll');
            setTimeout(() => {
                mobileIcon.src = closeIconSrc;
            }, 150);
        }

        function closeMobileMenuFunc() {
            mobileNavMenu.classList.remove('active');
            body.classList.remove('no-scroll');
            setTimeout(() => {
                mobileIcon.src = menuIconSrc;
            }, 250);
        }

        // Toggle on icon click
        mobileToggle.addEventListener('click', () => {
            if (mobileNavMenu.classList.contains('active')) {
                closeMobileMenuFunc();
            } else {
                openMobileMenu();
            }
        });

        // Inside menu close button
        closeMobileMenu.addEventListener('click', closeMobileMenuFunc);

        // Close on link click
        document.querySelectorAll('.mobile-nav-menu a').forEach(link => {
            link.addEventListener('click', closeMobileMenuFunc);
        });

        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && mobileNavMenu.classList.contains('active')) {
                closeMobileMenuFunc();
            }
        });

        // Navigation Scroll Behavior
        let lastScrollY = window.scrollY;
        const header = document.querySelector('header');

        window.addEventListener('scroll', () => {
            const currentScrollY = window.scrollY;

            // Sticky background
            if (currentScrollY > 50) {
                header.classList.add('scrolled');
                header.classList.add('bg-[rgba(10,10,30,0.95)]', 'backdrop-blur-2xl', 'shadow-[0_4px_30px_rgba(0,0,0,0.3)]');
                header.classList.remove('bg-[rgba(10,10,30,0.6)]', 'backdrop-blur-xl');
            } else {
                header.classList.remove('scrolled');
                header.classList.remove('bg-[rgba(10,10,30,0.95)]', 'backdrop-blur-2xl', 'shadow-[0_4px_30px_rgba(0,0,0,0.3)]');
                header.classList.add('bg-[rgba(10,10,30,0.6)]', 'backdrop-blur-xl');
            }

            // Hide/show on scroll direction (desktop only)
            if (window.innerWidth > 1024) {
                if (currentScrollY > lastScrollY && currentScrollY > 200) {
                    // Scrolling down - hide with fade
                    header.style.transform = 'translateY(-100%)';
                    header.style.opacity = '0';
                } else {
                    // Scrolling up - show with fade
                    header.style.transform = 'translateY(0)';
                    header.style.opacity = '1';
                }
            }

            lastScrollY = currentScrollY;
        });

        // Add smooth transition
        header.style.transition = 'transform 0.3s ease, background 0.3s ease';

        window.addEventListener('load', () => {
            document.body.style.opacity = '0';
            document.body.style.transition = 'opacity 0.5s ease';
            setTimeout(() => {
                document.body.style.opacity = '1';
            }, 100);
        });



        // -------------- js Style Header Heading Typing --------------
        // Enhanced Typing Animation with Pre-loaded English Text
        document.addEventListener('DOMContentLoaded', function() {
            const typingElement = document.getElementById('typing-text');
            const typingHeadline = document.getElementById('typing-headline');
            const languages = [{
                    text: "Launch your online store in just 2 minutes.",
                    highlight: "2 minutes",
                    speed: 80,
                    delay: 4000
                },
                {
                    text: "2 நிமிடத்தில் உங்கள் ஆன்லைன் ஸ்டோர் தொடங்கலாம்.",
                    highlight: "2 நிமிடத்தில்",
                    speed: 90,
                    delay: 4000
                },
                {
                    text: "अपना ऑनलाइन स्टोर सिर्फ 2 मिनट में शुरू करें।",
                    highlight: "2 मिनट",
                    speed: 85,
                    delay: 4000
                }
            ];

            let currentLanguageIndex = 0;
            let currentCharIndex = 0;
            let isDeleting = false;
            let typingTimeout;
            let animationStarted = false;

            // Set English as default text immediately
            function setInitialEnglishText() {
                const englishLang = languages[0];
                const fullText = englishLang.text;
                const highlightText = englishLang.highlight;

                const highlightStart = fullText.indexOf(highlightText);
                const before = fullText.substring(0, highlightStart);
                const during = highlightText;
                const after = fullText.substring(highlightStart + highlightText.length);

                typingElement.innerHTML = before +
                    '<span style="background: linear-gradient(135deg, #8A00FF 0%, #FF00A8 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent;">' +
                    during +
                    '</span>' +
                    after;

                // Set initial state for animation
                currentLanguageIndex = 0;
                currentCharIndex = fullText.length;

                // Apply fade-in animation after text is set
                setTimeout(() => {
                    typingHeadline.classList.add('animate-fade-in-up');
                }, 100);
            }

            function typeText() {
                if (!animationStarted) return;

                const currentLang = languages[currentLanguageIndex];
                const fullText = currentLang.text;
                const highlightText = currentLang.highlight;

                if (isDeleting) {
                    // Deleting phase - reveal from back to front
                    currentCharIndex--;

                    if (currentCharIndex <= 0) {
                        // COMPLETELY CLEAR before moving to next language
                        typingElement.innerHTML = '';

                        // Move to next language
                        isDeleting = false;
                        currentCharIndex = 0;
                        currentLanguageIndex = (currentLanguageIndex + 1) % languages.length;

                        // Start typing next language after a brief pause
                        setTimeout(typeText, 500);
                        return;
                    }
                } else {
                    // Typing phase
                    currentCharIndex++;

                    if (currentCharIndex > fullText.length) {
                        // Start deleting after delay
                        isDeleting = true;
                        setTimeout(typeText, currentLang.delay);
                        return;
                    }
                }

                // Update display with back-to-front reveal effect
                updateDisplay(currentLang, currentCharIndex);

                // Set speed - faster when deleting for better UX
                const speed = isDeleting ? currentLang.speed * 0.4 : currentLang.speed;
                typingTimeout = setTimeout(typeText, speed);
            }

            function updateDisplay(currentLang, charIndex) {
                const fullText = currentLang.text;
                const highlightText = currentLang.highlight;

                // If charIndex is 0, clear completely (transition state)
                if (charIndex === 0) {
                    typingElement.innerHTML = '';
                    return;
                }

                if (!highlightText) {
                    // No highlight - plain text
                    typingElement.textContent = fullText.substring(0, charIndex);
                    return;
                }

                const highlightStart = fullText.indexOf(highlightText);

                if (highlightStart === -1 || charIndex <= highlightStart) {
                    // Text before highlight
                    typingElement.textContent = fullText.substring(0, charIndex);
                } else if (charIndex > highlightStart && charIndex <= highlightStart + highlightText.length) {
                    // Inside highlight - use HTML with gradient span
                    const before = fullText.substring(0, highlightStart);
                    const during = fullText.substring(highlightStart, charIndex);
                    typingElement.innerHTML = before +
                        '<span style="background: linear-gradient(135deg, #8A00FF 0%, #FF00A8 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent;">' +
                        during +
                        '</span>';
                } else {
                    // After highlight
                    const before = fullText.substring(0, highlightStart);
                    const during = highlightText;
                    const after = fullText.substring(highlightStart + highlightText.length, charIndex);
                    typingElement.innerHTML = before +
                        '<span style="background: linear-gradient(135deg, #8A00FF 0%, #FF00A8 100%); -webkit-background-clip: text; background-clip: text; -webkit-text-fill-color: transparent; color: transparent;">' +
                        during +
                        '</span>' +
                        after;
                }
            }

            function startAnimation() {
                if (animationStarted) return;

                animationStarted = true;
                // Start by deleting the English text (back to front)
                isDeleting = true;
                currentCharIndex = languages[0].text.length;
                typeText();
            }

            // Initialize with English text immediately
            setInitialEnglishText();

            // Start typing animation after page is fully loaded and user has seen English text
            window.addEventListener('load', function() {
                // Wait 3 seconds after page load to start animation cycle
                setTimeout(startAnimation, 3000);
            });

            // Fallback: if page takes too long to load, start animation anyway
            const fallbackTimer = setTimeout(() => {
                if (!animationStarted) {
                    startAnimation();
                }
            }, 6000);

            // Cleanup
            window.addEventListener('beforeunload', () => {
                clearTimeout(typingTimeout);
                clearTimeout(fallbackTimer);
            });
        });
        // -------------- js Style For Hero Vide Line animation --------------
        //Style For Hero Vide Line animation
        const section = document.querySelector(".dashboard");
        const video = document.querySelector("video");

        // Video autoplay when section is straight to viewer
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    // Section is visible and straight to viewer
                    video.play().catch();
                } else {
                    // Section is not visible
                    video.pause();
                }
            });
        }, {
            threshold: 0.7 // Trigger when 70% of section is visible
        });

        if (section) {
            observer.observe(section);
        }

        window.addEventListener("scroll", () => {
            if (!section) return;

            const rect = section.getBoundingClientRect();
            const windowHeight = window.innerHeight;
            const sectionCenter = rect.top + rect.height / 2;

            // Calculate how far the section is from the center of the viewport
            const distanceFromCenter = sectionCenter - windowHeight / 2;

            // Clamp the tilt so it doesn't go too extreme
            const maxTilt = 10; // degrees
            const tilt = Math.max(-maxTilt, Math.min(maxTilt, distanceFromCenter * 0.05));

            // When section is centered, rotateX = 0 (flat)
            // Above center → tilts back (positive), below → slightly forward (negative)
            section.style.transform = `perspective(1000px) rotateX(${tilt}deg) translateY(${distanceFromCenter * 0.05}px)`;
        });

        // Set initial state (lying back when page loads)
        section.style.transform = `perspective(1000px) rotateX(8deg) translateY(20px)`;

        // -------------- js for Dynamic Month Results --------------
        // Dynamic Month Result for Previous Month
        document.addEventListener('DOMContentLoaded', function() {
            // Monthly data configuration (Jan-Dec)
            const monthlyData = {
                // Format: [salesMin, salesMax, ordersMin, ordersMax, storesMin, storesMax, satisfactionMin, satisfactionMax]
                // Month 0 = January, Month 11 = December
                0: [20, 25, 4200, 5000, 565, 700, 96, 99], // January
                1: [22, 28, 4500, 5500, 600, 750, 97, 99], // February
                2: [25, 32, 5000, 6200, 650, 800, 96, 98], // March
                3: [28, 35, 5500, 6500, 700, 850, 97, 99], // April
                4: [30, 38, 5800, 6800, 750, 900, 96, 98], // May
                5: [32, 40, 6000, 6900, 800, 950, 97, 99], // June
                6: [28, 35, 5500, 6500, 750, 900, 96, 98], // July
                7: [26, 32, 5200, 6200, 700, 850, 97, 99], // August
                8: [24, 30, 4800, 5800, 650, 800, 96, 98], // September
                9: [22, 28, 4500, 5500, 600, 750, 97, 99], // October
                10: [25, 32, 5000, 6200, 650, 800, 96, 98], // November
                11: [30, 40, 6000, 6900, 800, 978, 97, 99] // December
            };

            // DOM Elements
            const elements = {
                title: document.getElementById('period-title'),
                totalSales: document.getElementById('total-sales'),
                ordersProcessed: document.getElementById('orders-processed'),
                newStores: document.getElementById('new-stores'),
                satisfaction: document.getElementById('satisfaction')
            };

            // Helper function to format numbers
            function formatNumber(num, type = 'default') {
                if (type === 'percentage') {
                    return `${Math.round(num)}%`;
                }

                if (num >= 100000) {
                    const lakhs = Math.round(num / 100000);
                    return type === 'currency' ? `₹${lakhs}L` : `${lakhs}L`;
                }

                if (num >= 1000) {
                    // For Orders Processed - show decimals like 5.9k, 6.5k
                    if (type === 'orders') {
                        const thousands = (num / 1000).toFixed(1);
                        // Remove .0 if it's a whole number
                        return thousands.endsWith('.0') ? thousands.replace('.0', '') + 'k' : thousands + 'k';
                    }
                    // For other values - show integers
                    const thousands = Math.round(num / 1000);
                    return `${thousands}k`;
                }

                return type === 'currency' ? `₹${num}` : num.toString();
            }

            // Function to get values for PREVIOUS month
            function getPreviousMonthValues() {
                const now = new Date();
                let previousMonth = now.getMonth() - 1;
                let previousYear = now.getFullYear();

                // Handle January (month 0)
                if (previousMonth < 0) {
                    previousMonth = 11; // December
                    previousYear -= 1; // Previous year
                }

                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];

                const monthData = monthlyData[previousMonth];

                // For previous month, show COMPLETED results (100% progress)
                const monthProgress = 1.0; // 100% - previous month is complete

                // Calculate final values for previous month (at max)
                const salesLakhs = monthData[1]; // Use MAX value for completed month
                const salesValue = salesLakhs * 100000;

                // For orders, use max value with one decimal
                const ordersValue = monthData[3]; // Use MAX value

                const storesValue = monthData[5]; // Use MAX value

                const satisfactionValue = monthData[7]; // Use MAX value

                return {
                    monthName: monthNames[previousMonth],
                    salesValue,
                    ordersValue,
                    storesValue,
                    satisfactionValue,
                    monthProgress
                };
            }

            // Function to update display with previous month values
            function updateWithPreviousMonthValues() {
                const monthlyValues = getPreviousMonthValues();

                // Update DOM elements - Show previous month name only
                elements.title.textContent = `${monthlyValues.monthName} Results`;

                elements.totalSales.textContent = formatNumber(monthlyValues.salesValue, 'currency');
                elements.ordersProcessed.textContent = formatNumber(monthlyValues.ordersValue, 'orders');
                elements.newStores.textContent = formatNumber(monthlyValues.storesValue, 'default');
                elements.satisfaction.textContent = formatNumber(monthlyValues.satisfactionValue, 'percentage');

                // console.log(`Previous Month (${monthlyValues.monthName}) Results:`);
                // console.log(`- Total Sales: ${formatNumber(monthlyValues.salesValue, 'currency')}`);
                // console.log(`- Orders Processed: ${formatNumber(monthlyValues.ordersValue, 'orders')}`);
                // console.log(`- New Stores: ${formatNumber(monthlyValues.storesValue, 'default')}`);
                // console.log(`- Customer Satisfaction: ${formatNumber(monthlyValues.satisfactionValue, 'percentage')}`);

                // Show what month it actually is
                const currentDate = new Date();
                const currentMonth = currentDate.getMonth();
                const monthNames = [
                    'January', 'February', 'March', 'April', 'May', 'June',
                    'July', 'August', 'September', 'October', 'November', 'December'
                ];
                // console.log(`Current Month: ${monthNames[currentMonth]} (showing ${monthlyValues.monthName} results)`);
            }

            // Initialize - Update once on page load
            updateWithPreviousMonthValues();

            // console.log('Previous Month Results Loaded');
            // console.log('Showing completed results from previous month');
        });


        // -------------- js for Testimonial --------------
        // Animation trigger for testimonials section
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Animate section header
                        const header = entry.target.querySelector('.text-center');
                        header.style.animation = 'fadeInUp 0.8s ease forwards';

                        // Animate featured testimonial
                        const featured = entry.target.querySelector('.featured-testimonial');
                        featured.style.animation = 'slideInLeft 0.8s ease 0.2s forwards';

                        // Animate testimonial cards with stagger
                        const cards = entry.target.querySelectorAll('.testimonial-card');
                        cards.forEach((card, index) => {
                            card.style.animation = `slideInLeft 0.8s ease ${0.3 + (index * 0.1)}s forwards`;
                        });

                        // Animate stats bar
                        const stats = entry.target.querySelector('.stats-bar');
                        stats.style.animation = 'fadeInUp 0.8s ease 0.7s forwards';

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const testimonialsSection = document.querySelector('.testimonials');
            if (testimonialsSection) {
                observer.observe(testimonialsSection);
            }
        });

        // -------------- js for A/B testing --------------

        // Animation trigger for A/B testing section
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        // Animate section header
                        const header = entry.target.querySelector('.text-center');
                        header.style.animation = 'fadeInUp 0.8s ease forwards';

                        // Animate first A/B test
                        const test1 = entry.target.querySelector('.ab-test-1');
                        test1.style.animation = 'slideInLeft 0.8s ease 0.2s forwards';

                        // Animate second A/B test
                        const test2 = entry.target.querySelector('.ab-test-2');
                        test2.style.animation = 'slideInLeft 0.8s ease 0.4s forwards';

                        // Animate results summary
                        const results = entry.target.querySelector('.results-summary');
                        results.style.animation = 'fadeInUp 0.8s ease 0.6s forwards';

                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const abTestingSection = document.querySelector('.ab-testing');
            if (abTestingSection) {
                observer.observe(abTestingSection);
            }
        });


        // -------------- js for 3D Circle Carousel --------------
        class CircleCarousel3D {
            constructor() {
                this.carousel = document.querySelector('.carousel-3d-circle');
                this.cards = document.querySelectorAll('.circle-3d-card');
                this.prevBtn = document.querySelector('.circle-carousel-prev');
                this.nextBtn = document.querySelector('.circle-carousel-next');

                this.currentRotation = 0;
                this.angle = 60; // 360 / 6 cards
                this.isAnimating = false;

                this.init();
            }

            init() {
                this.setCardPositions();

                // Fixed rotation directions - now intuitive
                this.prevBtn.addEventListener('click', () => this.showPrevious());
                this.nextBtn.addEventListener('click', () => this.showNext());

                // Add touch/mouse drag support
                this.addDragSupport();

                // Auto-rotate
                setInterval(() => this.showNext(), 4000);
            }

            showNext() {
                this.rotate(-this.angle); // Rotate left to show next card
            }

            showPrevious() {
                this.rotate(this.angle); // Rotate right to show previous card
            }

            setCardPositions() {
                this.cards.forEach((card, index) => {
                    const rotate = index * this.angle;
                    card.style.setProperty('--rotate', `${rotate}deg`);
                    card.classList.remove('active');
                });

                // Set front card as active
                const activeIndex = this.getActiveIndex();
                this.cards[activeIndex].classList.add('active');
            }

            getActiveIndex() {
                const normalizedRotation = (360 - this.currentRotation) % 360;
                const activeIndex = Math.round(normalizedRotation / this.angle) % this.cards.length;
                return activeIndex;
            }

            rotate(angle) {
                if (this.isAnimating) return;
                this.isAnimating = true;

                this.currentRotation = (this.currentRotation + angle) % 360;
                this.carousel.style.transform = `rotateY(${this.currentRotation}deg)`;

                setTimeout(() => {
                    this.setCardPositions();
                    this.isAnimating = false;
                }, 800);
            }

            addDragSupport() {
                let startX = 0;
                let currentX = 0;
                let isDragging = false;

                const container = this.carousel;

                container.addEventListener('mousedown', (e) => {
                    startX = e.clientX;
                    isDragging = true;
                    container.style.cursor = 'grabbing';
                });

                container.addEventListener('mousemove', (e) => {
                    if (!isDragging) return;
                    currentX = e.clientX;
                    const diff = currentX - startX;

                    if (Math.abs(diff) > 50) {
                        const dragRotation = this.currentRotation + (diff * 0.5);
                        container.style.transform = `rotateY(${dragRotation}deg)`;
                    }
                });

                container.addEventListener('mouseup', (e) => {
                    if (!isDragging) return;
                    isDragging = false;
                    container.style.cursor = 'grab';

                    const diff = e.clientX - startX;

                    if (Math.abs(diff) > 50) {
                        // Fixed drag direction
                        const direction = diff > 0 ? this.angle : -this.angle;
                        this.rotate(direction);
                    } else {
                        container.style.transform = `rotateY(${this.currentRotation}deg)`;
                    }
                });

                container.addEventListener('mouseleave', () => {
                    if (isDragging) {
                        isDragging = false;
                        container.style.cursor = 'grab';
                        container.style.transform = `rotateY(${this.currentRotation}deg)`;
                    }
                });

                // Touch support
                container.addEventListener('touchstart', (e) => {
                    startX = e.touches[0].clientX;
                    isDragging = true;
                });

                container.addEventListener('touchmove', (e) => {
                    if (!isDragging) return;
                    currentX = e.touches[0].clientX;
                    const diff = currentX - startX;

                    if (Math.abs(diff) > 30) {
                        const dragRotation = this.currentRotation + (diff * 0.5);
                        container.style.transform = `rotateY(${dragRotation}deg)`;
                    }
                });

                container.addEventListener('touchend', (e) => {
                    if (!isDragging) return;
                    isDragging = false;

                    const diff = e.changedTouches[0].clientX - startX;

                    if (Math.abs(diff) > 50) {
                        const direction = diff > 0 ? this.angle : -this.angle;
                        this.rotate(direction);
                    } else {
                        container.style.transform = `rotateY(${this.currentRotation}deg)`;
                    }
                });

                container.style.cursor = 'grab';
            }
        }

        // Initialize carousel when DOM is loaded
        document.addEventListener('DOMContentLoaded', () => {
            new CircleCarousel3D();
        });


        // -------------- js for 3D Carousel Functionality themes --------------
        // 3D Carousel Functionality
        document.addEventListener('DOMContentLoaded', function() {
            const carouselItems = document.querySelectorAll('.carousel-item');
            const prevButton = document.querySelector('.themes-carousel-prev');
            const nextButton = document.querySelector('.themes-carousel-next');

            let currentIndex = 2; // Start with Theme 1 (Modern Store) as center

            function updateCarousel() {
                carouselItems.forEach((item, index) => {
                    let position;
                    const diff = (index - currentIndex + carouselItems.length) % carouselItems.length;

                    if (diff === 0) {
                        position = 'center';
                    } else if (diff === 1 || diff === 2) {
                        position = 'right';
                    } else {
                        position = 'left';
                    }

                    item.setAttribute('data-position', position);
                });
            }

            function nextSlide() {
                currentIndex = (currentIndex + 1) % carouselItems.length;
                updateCarousel();
            }

            function prevSlide() {
                currentIndex = (currentIndex - 1 + carouselItems.length) % carouselItems.length;
                updateCarousel();
            }

            // Event Listeners
            prevButton.addEventListener('click', prevSlide);
            nextButton.addEventListener('click', nextSlide);

            // Initialize carousel
            updateCarousel();

            // Auto-rotate every 5 seconds
            setInterval(nextSlide, 5000);

            // Animation trigger for portfolio section
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const elements = entry.target.querySelectorAll('.opacity-0');
                        elements.forEach((el, index) => {
                            el.style.animation = `fadeInUp 0.8s ease ${0.2 + (index * 0.2)}s forwards`;
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const portfolioSection = document.querySelector('.theme-portfolio');
            if (portfolioSection) {
                observer.observe(portfolioSection);
            }
        });


        // -------------- js for Smooth FAQ Functionality --------------
        // FAQ Accordion Functionality with Smooth Animations
        document.addEventListener('DOMContentLoaded', function() {
            const faqItems = document.querySelectorAll('.faq-item');

            faqItems.forEach(item => {
                const question = item.querySelector('.faq-question');
                const answer = item.querySelector('.faq-answer');
                const icon = item.querySelector('svg');

                // Set initial state for smooth animations
                gsap.set(answer, {
                    height: 0,
                    opacity: 0,
                    display: 'none'
                });

                question.addEventListener('click', () => {
                    const isActive = item.classList.contains('active');

                    // Close all other items with smooth animation
                    faqItems.forEach(otherItem => {
                        if (otherItem !== item && otherItem.classList.contains('active')) {
                            const otherAnswer = otherItem.querySelector('.faq-answer');
                            const otherIcon = otherItem.querySelector('svg');

                            // Smooth close animation
                            gsap.timeline()
                                .to(otherAnswer, {
                                    height: 0,
                                    opacity: 0,
                                    duration: 0.3,
                                    ease: "power2.inOut"
                                })
                                .set(otherAnswer, {
                                    display: 'none'
                                })
                                .to(otherIcon, {
                                    rotation: 0,
                                    duration: 0.3,
                                    ease: "power2.inOut"
                                }, 0);

                            otherItem.classList.remove('active');
                        }
                    });

                    // Toggle current item with smooth animation
                    if (!isActive) {
                        // Open animation
                        item.classList.add('active');
                        gsap.set(answer, {
                            display: 'block'
                        });

                        gsap.timeline()
                            .to(answer, {
                                height: "auto",
                                opacity: 1,
                                duration: 0.4,
                                ease: "power2.out"
                            })
                            .to(icon, {
                                rotation: 180,
                                duration: 0.2,
                                ease: "power2.out"
                            }, 0);
                    } else {
                        // Close animation
                        gsap.timeline()
                            .to(answer, {
                                height: 0,
                                opacity: 0,
                                duration: 0.3,
                                ease: "power2.inOut"
                            })
                            .set(answer, {
                                display: 'none'
                            })
                            .to(icon, {
                                rotation: 0,
                                duration: 0.3,
                                ease: "power2.inOut"
                            }, 0);

                        item.classList.remove('active');
                    }
                });
            });

            // Animation trigger for FAQ section
            const observerOptions = {
                threshold: 0.2,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        const elements = entry.target.querySelectorAll('.opacity-0');
                        elements.forEach((el, index) => {
                            el.style.animation = `fadeInUp 0.8s ease ${0.2 + (index * 0.2)}s forwards`;
                        });
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const faqSection = document.querySelector('.faq');
            if (faqSection) {
                observer.observe(faqSection);
            }
        });
    </script>

</body>

</html>