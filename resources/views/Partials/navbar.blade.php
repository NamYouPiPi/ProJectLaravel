<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Cinema Navbar</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            /* background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%); */
            color: white;
        }

        /* Navbar Styles */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            /* background: rgba(15, 23, 42, 0.95); */
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            padding: 15px 0;
            z-index: 1000;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar.scrolled {
            /* background: rgba(15, 23, 42, 0.98); */
            padding: 10px 0;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .nav-container {
            max-width: 1400px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 30px;
        }

        /* Logo Section */
        .logo-section {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            font-weight: bold;
            color: white;
            transition: transform 0.3s ease;
        }

        .logo>img {
            width: 100%;
            height: 100%;
            border-radius: 12px;
            object-fit: cover;
        }

        .logo:hover {
            transform: scale(1.05);
        }

        .brand-name {
            font-size: 24px;
            font-weight: 700;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        /* Navigation Menu */
        .nav-menu {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(30, 41, 59, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 50px;
            padding: 8px;
        }

        .nav-item {
            position: relative;
            padding: 12px 24px;
            border-radius: 40px;
            text-decoration: none;
            color: #cbd5e1;
            font-weight: 500;
            font-size: 15px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            white-space: nowrap;
        }

        .nav-item:hover,
        .nav-item.active {
            color: white;
            background: linear-gradient(135deg,
                    rgba(245, 158, 11, 0.2),
                    rgba(239, 68, 68, 0.2));
            border: 1px solid rgba(245, 158, 11, 0.3);
            transform: translateY(-1px);
        }

        .nav-item::before {
            content: "";
            position: absolute;
            inset: 0;
            border-radius: inherit;
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            opacity: 0;
            transition: opacity 0.3s ease;
            z-index: -1;
        }

        .nav-item.active::before {
            opacity: 0.1;
        }

        /* Action Buttons */
        .nav-actions {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .btn {
            padding: 12px 24px;
            border: none;
            border-radius: 50px;
            font-weight: 600;
            font-size: 14px;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .btn-login {
            background: transparent;
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .btn-login:hover {
            background: rgba(255, 255, 255, 0.1);
            color: white;
            border-color: rgba(255, 255, 255, 0.3);
            transform: translateY(-1px);
        }

        .btn-ticket {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            color: white;
            border: 1px solid transparent;
            box-shadow: 0 4px 15px rgba(245, 158, 11, 0.3);
        }

        .btn-ticket:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(245, 158, 11, 0.4);
        }

        .btn-ticket::before {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #fbbf24, #f87171);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-ticket:hover::before {
            opacity: 1;
        }

        .btn span {
            position: relative;
            z-index: 1;
        }

        /* Mobile Menu Toggle */
        .mobile-toggle {
            display: none;
            flex-direction: column;
            gap: 4px;
            cursor: pointer;
            padding: 8px;
        }

        .mobile-toggle span {
            width: 25px;
            height: 3px;
            background: #cbd5e1;
            border-radius: 2px;
            transition: all 0.3s ease;
        }

        /* Demo Content */
        .content {
            margin-top: 100px;
            padding: 50px 30px;
            max-width: 1200px;
            margin-left: auto;
            margin-right: auto;
        }

        .hero-section {
            text-align: center;
            padding: 100px 0;
        }

        .hero-title {
            font-size: 4rem;
            font-weight: 800;
            margin-bottom: 20px;
            background: linear-gradient(135deg, #f59e0b, #ef4444, #8b5cf6);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .demo-sections {
            margin: 100px 0;
        }

        .demo-section {
            padding: 80px 0;
            text-align: center;
        }

        .demo-section h2 {
            font-size: 2.5rem;
            margin-bottom: 20px;
            color: #f1f5f9;
        }

        .demo-section p {
            font-size: 1.2rem;
            color: #cbd5e1;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .nav-container {
                padding: 0 20px;
            }

            .nav-menu {
                display: none;
                position: fixed;
                top: 65px;
                left: 0;
                right: 0;
                background: rgba(30, 41, 59, 0.98);
                flex-direction: column;
                gap: 0;
                border-radius: 0 0 20px 20px;
                box-shadow: 0 8px 32px rgba(0, 0, 0, 0.25);
                z-index: 2000;
                padding: 20px 0 10px 0;
                animation: slideDown 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            }

            .nav-menu.open {
                display: flex;
            }

            .nav-item {
                padding: 18px 0;
                font-size: 18px;
                text-align: center;
                width: 100%;
            }

            .mobile-toggle {
                display: flex;
            }

            .nav-actions {
                gap: 10px;
            }

            .btn {
                padding: 10px 18px;
                font-size: 13px;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .brand-name {
                font-size: 20px;
            }
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Animations */
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

        .hero-section * {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Scrollbar Styling */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #1e293b;
        }

        ::-webkit-scrollbar-thumb {
            background: linear-gradient(135deg, #f59e0b, #ef4444);
            border-radius: 4px;
        }

    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar" id="navbar">
        <div class="nav-container">
            <!-- Logo Section -->
            <div class="logo-section">
                <div class="logo">
                    <img src="{{ asset('assets/image/logo.png') }}" alt="Cinemagic Logo">
                </div>
                <div class="brand-name">AURORA CINEMAS</div>
            </div>

            <!-- Navigation Menu -->
            <div class="nav-menu">
                <a href="#home" class="nav-item active">Home</a>
                <a href="#movies" class="nav-item">Movies</a>
                <a href="#promotion" class="nav-item">Promotion</a>
                <a href="#promotion" class="nav-item">Offers</a>

                <a href="#about" class="nav-item">About Us</a>
            </div>

            <!-- Action Buttons -->
            <div class="nav-actions">

                <a href="{{ route('login') }}" class="btn btn-login">
                    <span>👤</span>
                    <span>Login</span>
                </a>

            </div>

            <!-- Mobile Toggle -->
            <div class="mobile-toggle">
                <span></span>
                <span></span>
                <span></span>

            </div>
        </div>
    </nav>

    <script>
        // Navbar scroll effect
        window.addEventListener("scroll", function () {
            const navbar = document.getElementById("navbar");
            if (window.scrollY > 50) {
                navbar.classList.add("scrolled");
            } else {
                navbar.classList.remove("scrolled");
            }
        });

        // Responsive nav toggle
        const navMenu = document.querySelector(".nav-menu");
        const mobileToggle = document.querySelector(".mobile-toggle");
        const navActions = document.querySelector(".nav-actions");
        const navItems = document.querySelectorAll(".nav-item");
        const sections = document.querySelectorAll(".demo-section");

        // Toggle nav menu on mobile
        mobileToggle.addEventListener("click", function (e) {
            e.stopPropagation();
            navMenu.classList.toggle("open");
        });

        // Close nav menu when clicking outside (on mobile)
        document.addEventListener("click", function (e) {
            if (window.innerWidth <= 768 && navMenu.classList.contains("open")) {
                if (!navMenu.contains(e.target) && !mobileToggle.contains(e.target)) {
                    navMenu.classList.remove("open");
                }
            }
        });

        // Close nav menu when clicking a nav link (on mobile)
        navItems.forEach((item) => {
            item.addEventListener("click", function () {
                if (window.innerWidth <= 768) {
                    navMenu.classList.remove("open");
                }
            });
        });

        // Active nav item highlighting
        window.addEventListener("scroll", function () {
            let current = "";
            sections.forEach((section) => {
                const sectionTop = section.offsetTop - 200;
                if (scrollY >= sectionTop) {
                    current = section
                        .querySelector("h2")
                        .textContent.toLowerCase()
                        .replace(" ", "");
                }
            });
            navItems.forEach((item) => {
                item.classList.remove("active");
                if (item.getAttribute("href").includes(current)) {
                    item.classList.add("active");
                }
            });
            // Keep home active at the top
            if (window.scrollY < 300) {
                navItems.forEach((item) => item.classList.remove("active"));
                document.querySelector('[href="#home"]').classList.add("active");
            }
        });

        // Smooth scrolling for nav links
        navItems.forEach((item) => {
            item.addEventListener("click", function (e) {
                e.preventDefault();
                const targetId = this.getAttribute("href").substring(1);
                if (targetId === "home") {
                    window.scrollTo({ top: 0, behavior: "smooth" });
                } else {
                    const targetSection = Array.from(sections).find(
                        (section) =>
                            section
                                .querySelector("h2")
                                .textContent.toLowerCase()
                                .replace(" ", "") === targetId
                    );
                    if (targetSection) {
                        targetSection.scrollIntoView({ behavior: "smooth" });
                    }
                }
            });
        });

        // Button click effects
        document.querySelectorAll(".btn").forEach((btn) => {
            btn.addEventListener("click", function (e) {
                e.preventDefault();
                // Create ripple effect
                const ripple = document.createElement("div");
                ripple.style.position = "absolute";
                ripple.style.borderRadius = "50%";
                ripple.style.background = "rgba(255, 255, 255, 0.3)";
                ripple.style.transform = "scale(0)";
                ripple.style.animation = "ripple 0.6s linear";
                ripple.style.left =
                    e.clientX - this.getBoundingClientRect().left - 10 + "px";
                ripple.style.top =
                    e.clientY - this.getBoundingClientRect().top - 10 + "px";
                ripple.style.width = "20px";
                ripple.style.height = "20px";
                this.appendChild(ripple);
                setTimeout(() => {
                    ripple.remove();
                }, 600);

            });
        });

        // Add ripple animation
        const style = document.createElement("style");
        style.textContent = `
            @keyframes ripple {
                to {
                    transform: scale(4);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
        // Theme toggle logic

    </script>
</body>

</html>
