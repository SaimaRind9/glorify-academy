<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1">

    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>
        The Glorify Academy Umerkot
    </title>

    <meta
        name="description"
        content="The Glorify Academy - Quality education, character building and a supportive learning environment."
    >


    <link rel="preconnect"
          href="https://fonts.bunny.net">

    <link
        href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800,900&display=swap"
        rel="stylesheet"
    >


    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"
    >


    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])


    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html {
            scroll-behavior: smooth;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #ffffff;
            color: #0f172a;
            overflow-x: hidden;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --navy: #0f172a;
            --navy-light: #172554;
            --muted: #64748b;
            --soft: #f8fafc;
            --border: #e2e8f0;
            --white: #ffffff;
        }

        a {
            text-decoration: none;
        }

        img {
            max-width: 100%;
        }

        .site-container {
            width: min(1180px, calc(100% - 40px));
            margin: auto;
        }


        /* =========================================================
           TOP BAR
        ========================================================= */

        .top-bar {
            background: #0f172a;
            color: #cbd5e1;
            font-size: 12px;
        }

        .top-bar-inner {
            min-height: 38px;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;
        }

        .top-contact {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .top-contact span {
            display: inline-flex;
            align-items: center;
            gap: 7px;
        }

        .top-contact i {
            color: #60a5fa;
        }

        .top-social {
            display: flex;
            gap: 12px;
        }

        .top-social a {
            color: #cbd5e1;
            transition: .25s;
        }

        .top-social a:hover {
            color: #60a5fa;
            transform: translateY(-2px);
        }


        /* =========================================================
           NAVBAR
        ========================================================= */

        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;

            background: rgba(255,255,255,.96);
            backdrop-filter: blur(15px);

            border-bottom: 1px solid rgba(226,232,240,.8);

            transition: box-shadow .3s ease;
        }

        .navbar.scrolled {
            box-shadow:
                0 8px 30px rgba(15,23,42,.08);
        }

        .nav-inner {
            min-height: 76px;

            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 25px;
        }


        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
        }

        .brand-icon {
            width: 46px;
            height: 46px;

            border-radius: 13px;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #2563eb
                );

            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;

            box-shadow:
                0 8px 20px rgba(37,99,235,.20);
        }

        .brand-text strong {
            display: block;
            color: #0f172a;
            font-size: 17px;
            font-weight: 850;
        }

        .brand-text span {
            display: block;
            margin-top: 1px;

            color: #64748b;
            font-size: 9px;

            letter-spacing: 1px;
            text-transform: uppercase;
        }


        .nav-links {
            display: flex;
            align-items: center;

            gap: 26px;
        }

        .nav-links > a {
            position: relative;

            padding: 28px 0;

            color: #475569;

            font-size: 12px;
            font-weight: 700;

            transition: color .25s ease;
        }

        .nav-links > a::after {
            content: "";

            position: absolute;
            left: 0;
            bottom: 19px;

            width: 0;
            height: 2px;

            border-radius: 3px;

            background: #2563eb;

            transition: width .25s ease;
        }

        .nav-links > a:hover {
            color: #2563eb;
        }

        .nav-links > a:hover::after {
            width: 100%;
        }


        .auth-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .login-btn,
        .register-btn,
        .dashboard-btn {
            min-height: 39px;

            padding: 0 15px;

            border-radius: 10px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 6px;

            font-size: 11px;
            font-weight: 750;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .login-btn {
            color: #1d4ed8;
            background: #eff6ff;
        }

        .register-btn,
        .dashboard-btn {
            color: white;

            background:
                linear-gradient(
                    135deg,
                    #2563eb,
                    #1d4ed8
                );

            box-shadow:
                0 7px 17px rgba(37,99,235,.18);
        }

        .login-btn:hover,
        .register-btn:hover,
        .dashboard-btn:hover {
            transform: translateY(-2px);
        }


        .menu-button {
            display: none;

            width: 41px;
            height: 41px;

            border: 1px solid #e2e8f0;
            border-radius: 10px;

            background: #f8fafc;
            color: #0f172a;

            cursor: pointer;

            font-size: 17px;
        }


        /* =========================================================
           HERO
        ========================================================= */

        .hero {
            position: relative;

            min-height: 650px;

            overflow: hidden;

            background: #0f172a;
        }

        .hero-slide {
            position: absolute;
            inset: 0;

            opacity: 0;

            transition:
                opacity 1s ease,
                transform 6s ease;

            transform: scale(1.04);

            background-position: center;
            background-size: cover;
        }

        .hero-slide.active {
            opacity: 1;
            transform: scale(1);
        }

        .hero-slide::after {
            content: "";

            position: absolute;
            inset: 0;

            background:
                linear-gradient(
                    90deg,
                    rgba(7,17,39,.90) 0%,
                    rgba(15,23,42,.67) 48%,
                    rgba(15,23,42,.30) 100%
                );
        }

        .slide-one {
            background-image:
                url('{{ asset('images/website/hero1.jpg') }}');
        }

        .slide-two {
            background-image:
                url('{{ asset('images/website/hero2.jpg') }}');
        }

        .slide-three {
            background-image:
                url('{{ asset('images/website/hero3.jpg') }}');
        }


        .hero-content {
            position: relative;
            z-index: 5;

            min-height: 650px;

            display: flex;
            align-items: center;
        }

        .hero-copy {
            max-width: 720px;

            color: white;
        }

        .hero-eyebrow {
            width: fit-content;

            margin-bottom: 15px;

            padding: 7px 12px;

            border: 1px solid rgba(255,255,255,.20);
            border-radius: 30px;

            background: rgba(255,255,255,.08);

            display: inline-flex;
            align-items: center;

            gap: 7px;

            color: #bfdbfe;

            font-size: 10px;
            font-weight: 700;

            backdrop-filter: blur(10px);
        }

        .hero-copy h1 {
            margin-bottom: 17px;

            font-size: clamp(38px, 5vw, 65px);
            line-height: 1.05;

            font-weight: 900;

            letter-spacing: -2px;
        }

        .hero-copy h1 span {
            color: #60a5fa;
        }

        .hero-copy p {
            max-width: 620px;

            margin-bottom: 28px;

            color: #dbeafe;

            font-size: 15px;
            line-height: 1.8;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;

            gap: 10px;
        }

        .hero-primary,
        .hero-secondary {
            min-height: 48px;

            padding: 0 20px;

            border-radius: 11px;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 8px;

            font-size: 12px;
            font-weight: 750;

            transition:
                transform .25s ease,
                box-shadow .25s ease;
        }

        .hero-primary {
            background: #2563eb;
            color: white;

            box-shadow:
                0 10px 25px rgba(37,99,235,.28);
        }

        .hero-secondary {
            border: 1px solid rgba(255,255,255,.22);

            background: rgba(255,255,255,.08);
            color: white;

            backdrop-filter: blur(10px);
        }

        .hero-primary:hover,
        .hero-secondary:hover {
            transform: translateY(-3px);
        }


        .hero-dots {
            position: absolute;
            z-index: 10;

            left: 50%;
            bottom: 26px;

            transform: translateX(-50%);

            display: flex;
            gap: 7px;
        }

        .hero-dot {
            width: 9px;
            height: 9px;

            border: none;
            border-radius: 50%;

            background: rgba(255,255,255,.40);

            cursor: pointer;

            transition: .3s;
        }

        .hero-dot.active {
            width: 27px;

            border-radius: 10px;

            background: #60a5fa;
        }


        .slider-arrow {
            position: absolute;
            z-index: 10;

            top: 50%;

            width: 44px;
            height: 44px;

            border: 1px solid rgba(255,255,255,.20);
            border-radius: 50%;

            background: rgba(15,23,42,.35);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            backdrop-filter: blur(10px);

            cursor: pointer;

            transition: .25s;
        }

        .slider-arrow:hover {
            background: #2563eb;
        }

        .prev-arrow {
            left: 24px;
        }

        .next-arrow {
            right: 24px;
        }


        /* =========================================================
           GENERAL SECTIONS
        ========================================================= */

        .section {
            padding: 90px 0;
        }

        .section-soft {
            background: #f8fafc;
        }

        .section-heading {
            max-width: 720px;

            margin: 0 auto 45px;

            text-align: center;
        }

        .section-kicker {
            display: inline-flex;
            align-items: center;

            gap: 7px;

            margin-bottom: 9px;

            color: #2563eb;

            font-size: 10px;
            font-weight: 800;

            letter-spacing: 1.5px;

            text-transform: uppercase;
        }

        .section-heading h2 {
            margin-bottom: 12px;

            color: #0f172a;

            font-size: clamp(28px, 4vw, 40px);
            font-weight: 850;

            letter-spacing: -1px;
        }

        .section-heading p {
            color: #64748b;

            font-size: 13px;
            line-height: 1.8;
        }


        /* =========================================================
           ABOUT
        ========================================================= */

        .about-grid {
            display: grid;

            grid-template-columns:
                1fr 1fr;

            gap: 55px;

            align-items: center;
        }

        .about-image {
            position: relative;

            min-height: 490px;

            border-radius: 26px;

            overflow: hidden;

            background: #dbeafe;

            box-shadow:
                0 25px 55px rgba(15,23,42,.12);
        }

        .about-image img {
    width: 100%;
    height: 490px;
    object-fit: contain;
    object-position: center;
    background: #f8fafc;
}
        .about-badge {
            position: absolute;

            right: 20px;
            bottom: 20px;

            width: 145px;
            height: 120px;

            padding: 15px;

            border-radius: 17px;

            background: rgba(255,255,255,.92);

            display: flex;
            flex-direction: column;
            justify-content: center;

            backdrop-filter: blur(15px);

            box-shadow:
                0 12px 30px rgba(15,23,42,.12);
        }

        .about-badge strong {
            color: #2563eb;

            font-size: 27px;
            font-weight: 900;
        }

        .about-badge span {
            color: #64748b;

            font-size: 9px;
            font-weight: 650;
        }

        .about-content .section-kicker {
            margin-bottom: 9px;
        }

        .about-content h2 {
            margin-bottom: 17px;

            color: #0f172a;

            font-size: 37px;
            line-height: 1.2;

            font-weight: 850;

            letter-spacing: -1px;
        }

        .about-content > p {
            margin-bottom: 20px;

            color: #64748b;

            font-size: 13px;
            line-height: 1.85;
        }

        .about-points {
            display: grid;

            grid-template-columns:
                repeat(2, minmax(0,1fr));

            gap: 12px;
        }

        .about-point {
            padding: 14px;

            border: 1px solid #e2e8f0;
            border-radius: 12px;

            display: flex;
            align-items: center;

            gap: 9px;
        }

        .about-point i {
            width: 31px;
            height: 31px;

            flex-shrink: 0;

            border-radius: 9px;

            background: #dbeafe;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .about-point span {
            color: #334155;

            font-size: 10px;
            font-weight: 700;
        }


        /* =========================================================
           MISSION VISION
        ========================================================= */

        .mission-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0,1fr));

            gap: 20px;
        }

        .mission-card {
            padding: 30px;

            border: 1px solid #e2e8f0;
            border-radius: 20px;

            background: white;

            box-shadow:
                0 9px 30px rgba(15,23,42,.045);

            transition:
                transform .3s ease,
                box-shadow .3s ease;
        }

        .mission-card:hover {
            transform: translateY(-7px);

            box-shadow:
                0 20px 45px rgba(15,23,42,.10);
        }

        .mission-icon {
            width: 55px;
            height: 55px;

            margin-bottom: 20px;

            border-radius: 15px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 21px;
        }

        .mission-card:nth-child(1) .mission-icon {
            background: #dbeafe;
            color: #2563eb;
        }

        .mission-card:nth-child(2) .mission-icon {
            background: #ede9fe;
            color: #7c3aed;
        }

        .mission-card:nth-child(3) .mission-icon {
            background: #dcfce7;
            color: #16a34a;
        }

        .mission-card h3 {
            margin-bottom: 9px;

            color: #0f172a;

            font-size: 17px;
            font-weight: 800;
        }

        .mission-card p {
            color: #64748b;

            font-size: 11px;
            line-height: 1.8;
        }


        /* =========================================================
           CLASSES
        ========================================================= */

        .classes-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0,1fr));

            gap: 18px;
        }

        .class-card {
            position: relative;

            overflow: hidden;

            padding: 25px;

            border: 1px solid #e2e8f0;
            border-radius: 18px;

            background: white;

            transition:
                transform .3s ease,
                box-shadow .3s ease,
                border-color .3s ease;
        }

        .class-card::before {
            content: "";

            position: absolute;
            top: 0;
            left: 0;

            width: 5px;
            height: 100%;

            background:
                linear-gradient(
                    #2563eb,
                    #60a5fa
                );
        }

        .class-card:hover {
            transform: translateY(-6px);

            border-color: #bfdbfe;

            box-shadow:
                0 18px 40px rgba(15,23,42,.09);
        }

        .class-icon {
            width: 48px;
            height: 48px;

            margin-bottom: 15px;

            border-radius: 13px;

            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 18px;
        }

        .class-card h3 {
            margin-bottom: 7px;

            color: #0f172a;

            font-size: 15px;
            font-weight: 800;
        }

        .class-card p {
            color: #64748b;

            font-size: 10px;
            line-height: 1.7;
        }

        .empty-class {
            grid-column: 1 / -1;

            padding: 35px;

            border: 1px dashed #cbd5e1;
            border-radius: 16px;

            color: #64748b;

            text-align: center;
        }


        /* =========================================================
           WHY US
        ========================================================= */

        .why-grid {
            display: grid;

            grid-template-columns:
                repeat(4, minmax(0,1fr));

            gap: 18px;
        }

        .why-card {
            padding: 24px;

            border-radius: 17px;

            background: #0f172a;
            color: white;

            transition: transform .3s ease;
        }

        .why-card:hover {
            transform: translateY(-6px);
        }

        .why-number {
            margin-bottom: 18px;

            color: #60a5fa;

            font-size: 11px;
            font-weight: 800;
        }

        .why-card i {
            margin-bottom: 15px;

            color: #60a5fa;

            font-size: 24px;
        }

        .why-card h3 {
            margin-bottom: 7px;

            font-size: 14px;
            font-weight: 800;
        }

        .why-card p {
            color: #94a3b8;

            font-size: 9px;
            line-height: 1.7;
        }


        /* =========================================================
           GALLERY
        ========================================================= */

        .gallery-grid {
            display: grid;

            grid-template-columns:
                repeat(3, minmax(0,1fr));

            gap: 12px;
        }

        .gallery-item {
            position: relative;

            height: 250px;

            border-radius: 16px;

            overflow: hidden;

            cursor: zoom-in;

            background: #dbeafe;
        }

        .gallery-item:nth-child(1),
        .gallery-item:nth-child(5) {
            grid-column: span 2;
        }

        .gallery-item img {
            width: 100%;
            height: 100%;

            object-fit: cover;

            transition: transform .4s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.07);
        }

        .gallery-overlay {
            position: absolute;
            inset: 0;

            display: flex;
            align-items: center;
            justify-content: center;

            background: rgba(15,23,42,.0);

            transition: .3s;
        }

        .gallery-overlay i {
            width: 45px;
            height: 45px;

            border-radius: 50%;

            background: rgba(255,255,255,.92);
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;

            opacity: 0;
            transform: scale(.8);

            transition: .3s;
        }

        .gallery-item:hover .gallery-overlay {
            background: rgba(15,23,42,.35);
        }

        .gallery-item:hover .gallery-overlay i {
            opacity: 1;
            transform: scale(1);
        }


        /* =========================================================
           CTA
        ========================================================= */

        .cta-section {
            padding: 75px 0;

            background:
                linear-gradient(
                    135deg,
                    #172554,
                    #1d4ed8
                );
        }

        .cta-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;

            gap: 35px;
        }

        .cta-copy {
            max-width: 700px;

            color: white;
        }

        .cta-copy span {
            display: block;

            margin-bottom: 7px;

            color: #bfdbfe;

            font-size: 9px;
            font-weight: 800;

            letter-spacing: 1.4px;
        }

        .cta-copy h2 {
            margin-bottom: 8px;

            font-size: 31px;
            font-weight: 850;
        }

        .cta-copy p {
            color: #dbeafe;

            font-size: 11px;
            line-height: 1.7;
        }

        .cta-button {
            min-width: 155px;
            min-height: 47px;

            padding: 0 18px;

            border-radius: 11px;

            background: white;
            color: #1d4ed8;

            display: inline-flex;
            align-items: center;
            justify-content: center;

            gap: 7px;

            font-size: 11px;
            font-weight: 800;

            transition: transform .25s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
        }


        /* =========================================================
           CONTACT
        ========================================================= */

        .contact-grid {
            display: grid;

            grid-template-columns:
                .85fr 1.15fr;

            gap: 45px;

            align-items: start;
        }

        .contact-copy h2 {
            margin-bottom: 14px;

            color: #0f172a;

            font-size: 35px;
            font-weight: 850;
        }

        .contact-copy > p {
            margin-bottom: 25px;

            color: #64748b;

            font-size: 12px;
            line-height: 1.8;
        }

        .contact-list {
            display: grid;
            gap: 12px;
        }

        .contact-item {
            padding: 15px;

            border: 1px solid #e2e8f0;
            border-radius: 13px;

            display: flex;
            align-items: center;

            gap: 11px;
        }

        .contact-icon {
            width: 40px;
            height: 40px;

            flex-shrink: 0;

            border-radius: 11px;

            background: #eff6ff;
            color: #2563eb;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .contact-item span {
            display: block;

            color: #94a3b8;

            font-size: 8px;
        }

        .contact-item strong {
            display: block;

            margin-top: 2px;

            color: #0f172a;

            font-size: 10px;
        }


        .contact-panel {
            padding: 30px;

            border-radius: 22px;

            background: #f8fafc;

            border: 1px solid #e2e8f0;
        }

        .contact-panel h3 {
            margin-bottom: 7px;

            color: #0f172a;

            font-size: 18px;
            font-weight: 800;
        }

        .contact-panel > p {
            margin-bottom: 21px;

            color: #64748b;

            font-size: 10px;
            line-height: 1.7;
        }

        .contact-highlight {
            padding: 17px;

            border-radius: 13px;

            background: white;

            display: flex;
            gap: 11px;

            margin-bottom: 10px;
        }

        .contact-highlight i {
            color: #2563eb;
            font-size: 18px;
        }

        .contact-highlight strong {
            display: block;

            margin-bottom: 3px;

            color: #0f172a;

            font-size: 11px;
        }

        .contact-highlight span {
            color: #64748b;

            font-size: 9px;
            line-height: 1.6;
        }


        /* =========================================================
           FOOTER
        ========================================================= */

        .footer {
            padding-top: 65px;

            background: #0b1220;
            color: white;
        }

        .footer-grid {
            padding-bottom: 45px;

            display: grid;

            grid-template-columns:
                1.4fr .8fr .8fr 1fr;

            gap: 40px;
        }

        .footer-brand {
            max-width: 300px;
        }

        .footer-brand .brand-text strong {
            color: white;
        }

        .footer-brand .brand-text span {
            color: #94a3b8;
        }

        .footer-brand > p {
            margin-top: 17px;

            color: #94a3b8;

            font-size: 10px;
            line-height: 1.8;
        }

        .footer-column h4 {
            margin-bottom: 16px;

            font-size: 12px;
            font-weight: 800;
        }

        .footer-links {
            display: grid;
            gap: 9px;
        }

        .footer-links a,
        .footer-links span {
            color: #94a3b8;

            font-size: 10px;

            transition: color .25s ease;
        }

        .footer-links a:hover {
            color: #60a5fa;
        }

        .footer-social {
            margin-top: 17px;

            display: flex;

            gap: 8px;
        }

        .footer-social a {
            width: 36px;
            height: 36px;

            border: 1px solid #253047;
            border-radius: 10px;

            background: #111827;
            color: #94a3b8;

            display: flex;
            align-items: center;
            justify-content: center;

            transition: .25s;
        }

        .footer-social a:hover {
            background: #2563eb;
            color: white;

            transform: translateY(-3px);
        }

        .footer-bottom {
            min-height: 65px;

            border-top: 1px solid #1e293b;

            display: flex;
            justify-content: space-between;
            align-items: center;

            gap: 20px;

            color: #64748b;

            font-size: 9px;
        }


        /* =========================================================
           GALLERY MODAL
        ========================================================= */

        .gallery-modal {
            position: fixed;
            inset: 0;

            z-index: 9999;

            display: none;
            align-items: center;
            justify-content: center;

            padding: 25px;

            background: rgba(0,0,0,.91);

            backdrop-filter: blur(5px);
        }

        .gallery-modal.active {
            display: flex;
        }

        .gallery-modal img {
            max-width: 95vw;
            max-height: 92vh;

            object-fit: contain;

            border-radius: 10px;

            box-shadow:
                0 20px 60px rgba(0,0,0,.5);
        }

        .gallery-close {
            position: absolute;

            top: 20px;
            right: 24px;

            width: 42px;
            height: 42px;

            border: none;
            border-radius: 50%;

            background: rgba(255,255,255,.15);
            color: white;

            display: flex;
            align-items: center;
            justify-content: center;

            cursor: pointer;

            font-size: 19px;
        }


        /* =========================================================
           ANIMATION
        ========================================================= */

        .reveal {
            opacity: 0;
            transform: translateY(25px);

            transition:
                opacity .7s ease,
                transform .7s ease;
        }

        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
.gallery-video {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

        /* =========================================================
           RESPONSIVE
        ========================================================= */

        @media (max-width: 1000px) {

            .nav-links {
                gap: 15px;
            }

            .about-grid {
                gap: 30px;
            }

            .mission-grid,
            .classes-grid {
                grid-template-columns:
                    repeat(2, minmax(0,1fr));
            }

            .why-grid {
                grid-template-columns:
                    repeat(2, minmax(0,1fr));
            }

            .footer-grid {
                grid-template-columns:
                    repeat(2, minmax(0,1fr));
            }

        }


        @media (max-width: 820px) {

            .menu-button {
                display: inline-flex;
                align-items: center;
                justify-content: center;
            }

            .nav-links {
                position: absolute;

                top: 76px;
                left: 0;

                width: 100%;

                padding: 16px 20px 20px;

                background: white;

                border-bottom: 1px solid #e2e8f0;

                flex-direction: column;
                align-items: stretch;

                gap: 0;

                opacity: 0;
                visibility: hidden;

                transform: translateY(-10px);

                transition: .25s;
            }

            .nav-links.open {
                opacity: 1;
                visibility: visible;

                transform: translateY(0);
            }

            .nav-links > a {
                padding: 11px 0;

                border-bottom: 1px solid #f1f5f9;
            }

            .nav-links > a::after {
                display: none;
            }

            .auth-actions {
                padding-top: 12px;

                flex-direction: column;
                align-items: stretch;
            }

            .login-btn,
            .register-btn,
            .dashboard-btn {
                width: 100%;
            }


            .about-grid,
            .contact-grid {
                grid-template-columns: 1fr;
            }

            .about-image {
                min-height: 380px;
            }

            .about-image img {
                height: 380px;
            }

            .cta-inner {
                flex-direction: column;
                align-items: flex-start;
            }

        }


        @media (max-width: 650px) {

            .site-container {
                width: min(100% - 24px, 1180px);
            }

            .top-bar-inner {
                padding: 8px 0;
            }

            .top-social {
                display: none;
            }

            .top-contact {
                gap: 8px 16px;
            }

            .brand-text strong {
                font-size: 14px;
            }

            .brand-text span {
                font-size: 7px;
            }

            .hero,
            .hero-content {
                min-height: 590px;
            }

            .hero-copy h1 {
                font-size: 39px;
            }

            .slider-arrow {
                display: none;
            }

            .section {
                padding: 65px 0;
            }

            .about-content h2 {
                font-size: 29px;
            }

            .about-points {
                grid-template-columns: 1fr;
            }

            .mission-grid,
            .classes-grid,
            .why-grid {
                grid-template-columns: 1fr;
            }

            .gallery-grid {
                grid-template-columns: 1fr;
            }

            .gallery-item,
            .gallery-item:nth-child(1),
            .gallery-item:nth-child(5) {
                grid-column: auto;
            }

            .gallery-item {
                height: 220px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
            }

            .footer-bottom {
                padding: 17px 0;

                flex-direction: column;
                align-items: flex-start;

                justify-content: center;
            }

        }

    </style>

</head>


<body>


{{-- =========================================================
    TOP BAR
========================================================= --}}

<div class="top-bar">

    <div class="site-container top-bar-inner">

        <div class="top-contact">

            <span>
                <i class="fa-solid fa-envelope"></i>
                theglorifyacademyuk@gmail.com
            </span>

            <span>
                <i class="fa-solid fa-phone"></i>
                0312-2860332
            </span>

        </div>


        <div class="top-social">

            <a href="https://www.facebook.com/share/1LjJfMzJWQ/?mibextid=wwXIfr" aria-label="Facebook">
                <i class="fa-brands fa-facebook-f"></i>
            </a>

            <a href="https://www.instagram.com/theglorifyacademy" aria-label="Instagram">
                <i class="fa-brands fa-instagram"></i>
            </a>

            <a href="https://www.tiktok.com/@theglorifyacademy" aria-label="TikTok">
              <i class="fa-brands fa-tiktok"></i>
            </a>

            <a href="https://wa.me/923122860332" aria-label="Whatsapp">
                <i class="fa-brands fa-whatsapp"></i>
            </a>

        </div>

    </div>

</div>



{{-- =========================================================
    NAVBAR
========================================================= --}}

<header class="navbar" id="navbar">

    <div class="site-container nav-inner">

        <a href="{{ route('home') }}" class="brand">

            <div class="brand-icon">
                <img
                            src="{{ asset('images/logo.jpeg') }}"
                            alt="The Glorify Academy"
                        >
            </div>

            <div class="brand-text">
                <strong>The Glorify Academy</strong>
                <span>Learn • Grow • Succeed</span>
            </div>

        </a>


        <button
            type="button"
            class="menu-button"
            id="menuButton"
            aria-label="Open menu"
        >
            <i class="fa-solid fa-bars"></i>
        </button>


        <nav class="nav-links" id="navLinks">

            <a href="#home">Home</a>

            <a href="#about">About</a>

            <a href="#mission">Mission & Vision</a>

            <a href="#classes">Classes</a>

            <a href="#gallery">Gallery</a>

            <a href="#contact">Contact</a>


            <div class="auth-actions">

                @auth

                    <a
                        href="{{ route('dashboard') }}"
                        class="dashboard-btn"
                    >
                        <i class="fa-solid fa-gauge-high"></i>
                        Dashboard
                    </a>

                @else

                    @if(Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="register-btn"
                        >
                            <i class="fa-solid fa-user-plus"></i>
                            Register
                        </a>

                    @endif


                    @if(Route::has('login'))

                        <a
                            href="{{ route('login') }}"
                            class="login-btn"
                        >
                            <i class="fa-solid fa-right-to-bracket"></i>
                            Login
                        </a>

                    @endif

                @endauth

            </div>

        </nav>

    </div>

</header>



{{-- =========================================================
    HERO SLIDER
========================================================= --}}

<section class="hero" id="home">

    <div class="hero-slide slide-one active"></div>

    <div class="hero-slide slide-two"></div>

    <div class="hero-slide slide-three"></div>


    <div class="site-container hero-content">

        <div class="hero-copy">

            <div class="hero-eyebrow">
                <i class="fa-solid fa-star"></i>
                Welcome to The Glorify Academy
            </div>

            <h1>
                Building Bright
                <span>Futures</span>
                Through Education
            </h1>

            <p>
                A caring learning environment where academic excellence,
                confidence, discipline and character development grow
                together.
            </p>


            <div class="hero-actions">

                @guest

                    @if(Route::has('register'))

                        <a
                            href="{{ route('register') }}"
                            class="hero-primary"
                        >
                            <i class="fa-solid fa-user-plus"></i>
                            Parent Registration
                        </a>

                    @endif

                @endguest


                <a
                    href="#about"
                    class="hero-secondary"
                >
                    <i class="fa-solid fa-arrow-down"></i>
                    Explore Academy
                </a>

            </div>

        </div>

    </div>


    <button
        class="slider-arrow prev-arrow"
        id="prevSlide"
        aria-label="Previous slide"
    >
        <i class="fa-solid fa-chevron-left"></i>
    </button>


    <button
        class="slider-arrow next-arrow"
        id="nextSlide"
        aria-label="Next slide"
    >
        <i class="fa-solid fa-chevron-right"></i>
    </button>


    <div class="hero-dots">

        <button class="hero-dot active" data-slide="0"></button>

        <button class="hero-dot" data-slide="1"></button>

        <button class="hero-dot" data-slide="2"></button>

    </div>

</section>



{{-- =========================================================
    ABOUT
========================================================= --}}

<section class="section" id="about">

    <div class="site-container">

        <div class="about-grid">

            <div class="about-image reveal">

                <img
                    src="{{ asset('images/website/about.jpg') }}"
                    alt="The Glorify Academy"
                >

                <div class="about-badge">
                    <strong>100%</strong>
                    <span>
                        Commitment to quality education
                    </span>
                </div>

            </div>


            <div class="about-content reveal">

                <span class="section-kicker">
                    <i class="fa-solid fa-school"></i>
                    About Our Academy
                </span>

                <h2>
                    Education That Goes Beyond the Classroom
                </h2>

                <p>
                    The Glorify Academy is dedicated to creating a
                    supportive, disciplined and inspiring learning
                    environment where every child has the opportunity
                    to develop academically and personally.
                </p>

                <p>
                    Our goal is not only strong academic performance,
                    but also confidence, responsibility, creativity
                    and good character.
                </p>


                <div class="about-points">

                    <div class="about-point">
                        <i class="fa-solid fa-user-tie"></i>
                        <span>Dedicated Teachers</span>
                    </div>

                    <div class="about-point">
                        <i class="fa-solid fa-shield-heart"></i>
                        <span>Safe Environment</span>
                    </div>

                    <div class="about-point">
                        <i class="fa-solid fa-book-open-reader"></i>
                        <span>Quality Learning</span>
                    </div>

                    <div class="about-point">
                        <i class="fa-solid fa-people-roof"></i>
                        <span>Parent Communication</span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    MISSION / VISION
========================================================= --}}

<section class="section section-soft" id="mission">

    <div class="site-container">

        <div class="section-heading reveal">

            <span class="section-kicker">
                Our Direction
            </span>

            <h2>
                Mission, Vision & Values
            </h2>

            <p>
                The principles that guide our approach to education
                and student development.
            </p>

        </div>


        <div class="mission-grid">

            <div class="mission-card reveal">

                <div class="mission-icon">
                    <i class="fa-solid fa-bullseye"></i>
                </div>

                <h3>Our Mission</h3>

                <p>
                    To provide quality education in a supportive
                    environment that develops academic ability,
                    discipline, confidence and strong moral values.
                </p>

            </div>


            <div class="mission-card reveal">

                <div class="mission-icon">
                    <i class="fa-solid fa-eye"></i>
                </div>

                <h3>Our Vision</h3>

                <p>
                    To nurture capable, responsible and confident
                    learners who are prepared for future academic
                    and personal challenges.
                </p>

            </div>


            <div class="mission-card reveal">

                <div class="mission-icon">
                    <i class="fa-solid fa-heart"></i>
                </div>

                <h3>Our Values</h3>

                <p>
                    Respect, integrity, discipline, responsibility,
                    creativity, teamwork and a lifelong love of
                    learning.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    CLASSES — DATABASE
========================================================= --}}

<section class="section" id="classes">

    <div class="site-container">

        <div class="section-heading reveal">

            <span class="section-kicker">
                <i class="fa-solid fa-book-open"></i>
                Academics
            </span>

            <h2>
                Our Classes
            </h2>

            <p>
                Explore the classes currently available at
                The Glorify Academy.
            </p>

        </div>


        <div class="classes-grid">

            @forelse($classes as $class)

                <div class="class-card reveal">

                    <div class="class-icon">
                        <i class="fa-solid fa-chalkboard-user"></i>
                    </div>

                    <h3>
                        {{ $class->class_name }}
                    </h3>

                    <p>
                        A structured academic environment focused on
                        building strong concepts, confidence and
                        continuous learning.
                    </p>

                </div>

            @empty

                <div class="empty-class">
                    Class information will be available soon.
                </div>

            @endforelse

        </div>

    </div>

</section>



{{-- =========================================================
    WHY CHOOSE US
========================================================= --}}

<section class="section section-soft">

    <div class="site-container">

        <div class="section-heading reveal">

            <span class="section-kicker">
                Why Glorify?
            </span>

            <h2>
                Why Parents Choose Us
            </h2>

            <p>
                Education is most effective when school,
                teachers and parents work together.
            </p>

        </div>


        <div class="why-grid">

            <div class="why-card reveal">

                <div class="why-number">01</div>

                <i class="fa-solid fa-book-open-reader"></i>

                <h3>Academic Focus</h3>

                <p>
                    Regular learning, assessment and progress
                    monitoring for every student.
                </p>

            </div>


            <div class="why-card reveal">

                <div class="why-number">02</div>

                <i class="fa-solid fa-person-chalkboard"></i>

                <h3>Dedicated Teaching</h3>

                <p>
                    Teachers focus on understanding, participation
                    and student improvement.
                </p>

            </div>


            <div class="why-card reveal">

                <div class="why-number">03</div>

                <i class="fa-solid fa-shield-heart"></i>

                <h3>Safe & Caring</h3>

                <p>
                    A respectful and supportive environment where
                    children can learn with confidence.
                </p>

            </div>


            <div class="why-card reveal">

                <div class="why-number">04</div>

                <i class="fa-solid fa-users"></i>

                <h3>Parent Connection</h3>

                <p>
                    Parents can remain informed about attendance,
                    results and important academic information.
                </p>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    GALLERY
========================================================= --}}

<section class="section" id="gallery">

    <div class="site-container">

        <div class="section-heading reveal">

            <span class="section-kicker">
                Academy Life
            </span>

            <h2>
                Our Gallery
            </h2>

            <p>
                A glimpse into learning, activities and memorable
                moments at The Glorify Academy.
            </p>

        </div>


        <div class="gallery-grid">

            @for($i = 1; $i <= 6; $i++)

                <div
                    class="gallery-item reveal"
                    onclick="openGalleryImage(
                        '{{ asset('images/website/gallery' . $i . '.jpg') }}'
                    )"
                >

                    <img
                        src="{{ asset('images/website/gallery' . $i . '.jpg') }}"
                        alt="Academy Gallery {{ $i }}"
                    >

                    <div class="gallery-overlay">
                        <i class="fa-solid fa-magnifying-glass-plus"></i>
                    </div>

                </div>

            @endfor
            <div class="gallery-item reveal video-item">

    <video
        class="gallery-video"
        controls
    >
        <source
            src="{{ asset('images/website/academy-video.mp4') }}"
            type="video/mp4"
        >
    </video>

</div>

        </div>

    </div>

</section>



{{-- =========================================================
    PARENT REGISTRATION CTA
========================================================= --}}

@guest

    @if(Route::has('register'))

        <section class="cta-section">

            <div class="site-container cta-inner">

                <div class="cta-copy reveal">

                    <span>
                        PARENT PORTAL
                    </span>

                    <h2>
                        Already Have a Child Registered With Us?
                    </h2>

                    <p>
                        Eligible parents can register their account
                        using the student information already
                        available in the academy system.
                    </p>

                </div>


                <a
                    href="{{ route('register') }}"
                    class="cta-button reveal"
                >
                    <i class="fa-solid fa-user-plus"></i>
                    Register Account
                </a>

            </div>

        </section>

    @endif

@endguest



{{-- =========================================================
    CONTACT
========================================================= --}}

<section class="section" id="contact">

    <div class="site-container">

        <div class="contact-grid">

            <div class="contact-copy reveal">

                <span class="section-kicker">
                    Contact Us
                </span>

                <h2>
                    Get in Touch With The Glorify Academy
                </h2>

                <p>
                    Contact our academy for information about
                    classes, admissions and general enquiries.
                </p>


                <div class="contact-list">

                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="fa-solid fa-location-dot"></i>
                        </div>

                        <div>
                            <span>Academy Address</span>
                            <strong>
                                Near College Road, Front of Sindh College & Bright Future School, Umerkot
                            </strong>
                        </div>

                    </div>


                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="fa-solid fa-envelope"></i>
                        </div>

                        <div>
                            <span>Email</span>
                            <strong>
                                theglorifyacademyuk@gmail.com
                            </strong>
                        </div>

                    </div>


                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="fa-solid fa-phone"></i>
                        </div>

                        <div>
                            <span>Phone</span>
                            <strong>
                                03312-2860332
                            </strong>
                        </div>

                    </div>

                </div>

            </div>


            <div class="contact-panel reveal">

                <h3>
                    Visit Our Academy
                </h3>

                <p>
                    We welcome parents who would like to learn more
                    about our academic environment.
                </p>


                <div class="contact-highlight">

                    <i class="fa-solid fa-clock"></i>

                    <div>
                        <strong>Office Hours</strong>

                        <span>
                            09:00 AM - 05:00 PM
                        </span>
                    </div>

                </div>


                <div class="contact-highlight">

                    <i class="fa-solid fa-circle-info"></i>

                    <div>
                        <strong>Parent Accounts</strong>

                        <span>
                            Parent registration is available only
                            when the student's information already
                            exists in the academy database.
                        </span>
                    </div>

                </div>


                <div class="contact-highlight">

                    <i class="fa-solid fa-lock"></i>

                    <div>
                        <strong>Secure Portal</strong>

                        <span>
                            Registered parents and teachers can
                            access their dedicated dashboards after
                            login.
                        </span>
                    </div>

                </div>

            </div>

        </div>

    </div>

</section>



{{-- =========================================================
    FOOTER
========================================================= --}}

<footer class="footer">

    <div class="site-container">

        <div class="footer-grid">

            <div class="footer-brand">

                <a href="#home" class="brand">

                    <div class="brand-icon">
                       <img
                            src="{{ asset('images/logo.jpeg') }}"
                            alt="The Glorify Academy"
                        >
                    </div>

                    <div class="brand-text">
                        <strong>The Glorify Academy</strong>
                        <span>Learn • Grow • Succeed</span>
                    </div>

                </a>

                <p>
                    Creating a supportive environment for academic
                    excellence, confidence, discipline and character
                    development.
                </p>


                <div class="footer-social">

                    <a href="https://www.facebook.com/share/1LjJfMzJWQ/?mibextid=wwXIfr" aria-label="Facebook">
                        <i class="fa-brands fa-facebook-f"></i>
                    </a>

                    <a href="https://www.instagram.com/theglorifyacademy" aria-label="Instagram">
                        <i class="fa-brands fa-instagram"></i>
</a>

<a href="https://www.tiktok.com/@theglorifyacademy" aria-label="TikTok">
    <i class="fa-brands fa-tiktok"></i>
</a>

                    <a href="https://wa.me/923122860332" aria-label="Whatsapp">
                        <i class="fa-brands fa-whatsapp"></i>
                    </a>

                </div>

            </div>


            <div class="footer-column">

                <h4>Quick Links</h4>

                <div class="footer-links">

                    <a href="#home">Home</a>

                    <a href="#about">About Academy</a>

                    <a href="#classes">Classes</a>

                    <a href="#gallery">Gallery</a>

                    <a href="#contact">Contact</a>

                </div>

            </div>


            <div class="footer-column">

                <h4>Portal</h4>

                <div class="footer-links">

                    @guest

                        @if(Route::has('login'))
                            <a href="{{ route('login') }}">
                                Login
                            </a>
                        @endif

                        @if(Route::has('register'))
                            <a href="{{ route('register') }}">
                                Parent Registration
                            </a>
                        @endif

                    @else

                        <a href="{{ route('dashboard') }}">
                            Dashboard
                        </a>

                    @endguest

                </div>

            </div>


            <div class="footer-column">

                <h4>Contact</h4>

                <div class="footer-links">

                    <span>
                        <i class="fa-solid fa-envelope"></i>
                        &nbsp;
                        theglorifyacademyuk@gmail.com
                    </span>

                    <span>
                        <i class="fa-solid fa-phone"></i>
                        &nbsp;
                        0312-2860332
                    </span>

                    <span>
                        <i class="fa-solid fa-location-dot"></i>
                        &nbsp;
                        Near College Road, Front of Sindh College & Bright Future School, Umerkot
                    </span>

                </div>

            </div>

        </div>


        <div class="footer-bottom">

    <span>
        © {{ now()->year }} The Glorify Academy.
        All rights reserved.
    </span>

    <span>
        Designed & Developed by
        <strong>SAIMA RIND</strong>
    </span>

</div>

    </div>

</footer>



{{-- =========================================================
    GALLERY MODAL
========================================================= --}}

<div id="galleryModal" class="gallery-modal">

    <button
        type="button"
        class="gallery-close"
        onclick="closeGalleryImage()"
    >
        <i class="fa-solid fa-xmark"></i>
    </button>

    <img
        id="galleryFullImage"
        src=""
        alt="Academy Gallery"
    >

</div>



<script>

    document.addEventListener(
        'DOMContentLoaded',
        function () {

            /*
            |--------------------------------------------------------------------------
            | Mobile Menu
            |--------------------------------------------------------------------------
            */

            const menuButton =
                document.getElementById('menuButton');

            const navLinks =
                document.getElementById('navLinks');


            menuButton?.addEventListener(
                'click',
                function () {

                    navLinks.classList.toggle('open');

                    const icon =
                        menuButton.querySelector('i');

                    icon.className =
                        navLinks.classList.contains('open')
                            ? 'fa-solid fa-xmark'
                            : 'fa-solid fa-bars';

                }
            );


            navLinks
                ?.querySelectorAll('a')
                .forEach(function (link) {

                    link.addEventListener(
                        'click',
                        function () {

                            navLinks.classList.remove('open');

                            const icon =
                                menuButton?.querySelector('i');

                            if (icon) {
                                icon.className =
                                    'fa-solid fa-bars';
                            }

                        }
                    );

                });


            /*
            |--------------------------------------------------------------------------
            | Navbar Scroll
            |--------------------------------------------------------------------------
            */

            const navbar =
                document.getElementById('navbar');


            window.addEventListener(
                'scroll',
                function () {

                    navbar.classList.toggle(
                        'scrolled',
                        window.scrollY > 20
                    );

                }
            );


            /*
            |--------------------------------------------------------------------------
            | Hero Slider
            |--------------------------------------------------------------------------
            */

            const slides =
                document.querySelectorAll('.hero-slide');

            const dots =
                document.querySelectorAll('.hero-dot');

            const prev =
                document.getElementById('prevSlide');

            const next =
                document.getElementById('nextSlide');

            let currentSlide = 0;

            let sliderTimer;


            function showSlide(index) {

                slides.forEach(
                    function (slide, i) {

                        slide.classList.toggle(
                            'active',
                            i === index
                        );

                    }
                );


                dots.forEach(
                    function (dot, i) {

                        dot.classList.toggle(
                            'active',
                            i === index
                        );

                    }
                );


                currentSlide = index;

            }


            function nextSlide() {

                showSlide(
                    (currentSlide + 1)
                    % slides.length
                );

            }


            function previousSlide() {

                showSlide(
                    (currentSlide - 1 + slides.length)
                    % slides.length
                );

            }


            function restartSlider() {

                clearInterval(sliderTimer);

                sliderTimer =
                    setInterval(
                        nextSlide,
                        5000
                    );

            }


            next?.addEventListener(
                'click',
                function () {

                    nextSlide();

                    restartSlider();

                }
            );


            prev?.addEventListener(
                'click',
                function () {

                    previousSlide();

                    restartSlider();

                }
            );


            dots.forEach(
                function (dot) {

                    dot.addEventListener(
                        'click',
                        function () {

                            showSlide(
                                Number(
                                    dot.dataset.slide
                                )
                            );

                            restartSlider();

                        }
                    );

                }
            );


            restartSlider();


            /*
            |--------------------------------------------------------------------------
            | Scroll Reveal
            |--------------------------------------------------------------------------
            */

            const revealElements =
                document.querySelectorAll('.reveal');


            const observer =
                new IntersectionObserver(
                    function (entries) {

                        entries.forEach(
                            function (entry) {

                                if (entry.isIntersecting) {

                                    entry.target
                                        .classList
                                        .add('visible');

                                }

                            }
                        );

                    },
                    {
                        threshold: .12
                    }
                );


            revealElements.forEach(
                function (element) {
                    observer.observe(element);
                }
            );

        }
    );


    /*
    |--------------------------------------------------------------------------
    | Gallery Viewer
    |--------------------------------------------------------------------------
    */

    function openGalleryImage(src) {

        const modal =
            document.getElementById(
                'galleryModal'
            );

        const image =
            document.getElementById(
                'galleryFullImage'
            );

        image.src = src;

        modal.classList.add('active');

        document.body.style.overflow =
            'hidden';

    }


    function closeGalleryImage() {

        const modal =
            document.getElementById(
                'galleryModal'
            );

        modal.classList.remove('active');

        document.body.style.overflow =
            '';

    }


    document
        .getElementById('galleryModal')
        ?.addEventListener(
            'click',
            function (event) {

                if (event.target === this) {
                    closeGalleryImage();
                }

            }
        );


    document.addEventListener(
        'keydown',
        function (event) {

            if (event.key === 'Escape') {
                closeGalleryImage();
            }

        }
    );

</script>


</body>

</html>