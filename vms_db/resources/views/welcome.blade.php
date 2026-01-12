<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NLCOM - Volunteer Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333;
            background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 20px;
        }

        /* Navigation */
        nav {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .nav-container {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .logo {
            font-size: 1.8rem;
            font-weight: bold;
            color: #1976d2;
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            align-items: center;
        }

        .nav-links a {
            color: #555;
            text-decoration: none;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: #1976d2;
        }

        .btn-primary {
            background: #1976d2;
            color: white;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: #1565c0;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(25, 118, 210, 0.3);
        }

        .btn-secondary {
            background: white;
            color: #1976d2;
            padding: 0.6rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            border: 2px solid #1976d2;
            transition: all 0.3s;
        }

        .btn-secondary:hover {
            background: #1976d2;
            color: white;
        }

        /* Hero Section */
        .hero {
            padding: 5rem 0;
            text-align: center;
        }

        .hero h1 {
            font-size: 3rem;
            color: #1976d2;
            margin-bottom: 1rem;
            animation: fadeInUp 0.8s ease;
        }

        .hero p {
            font-size: 1.3rem;
            color: #666;
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease 0.2s backwards;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            animation: fadeInUp 0.8s ease 0.4s backwards;
        }

        /* Features Section */
        .features {
            padding: 4rem 0;
            background: white;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            color: #1976d2;
            margin-bottom: 3rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            padding: 2rem;
            border-radius: 12px;
            background: linear-gradient(135deg, #e3f2fd 0%, #ffffff 100%);
            transition: all 0.3s;
            border: 2px solid transparent;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 24px rgba(25, 118, 210, 0.15);
            border-color: #1976d2;
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: #1976d2;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            color: white;
            font-size: 1.5rem;
        }

        .feature-card h3 {
            color: #1976d2;
            margin-bottom: 0.5rem;
            font-size: 1.5rem;
        }

        .feature-card p {
            color: #666;
        }

        /* Benefits Section */
        .benefits {
            padding: 4rem 0;
        }

        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 1.5rem;
        }

        .benefit-item {
            display: flex;
            align-items: flex-start;
            gap: 1rem;
            padding: 1.5rem;
            background: white;
            border-radius: 8px;
            transition: all 0.3s;
        }

        .benefit-item:hover {
            transform: translateX(8px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .check-icon {
            color: #1976d2;
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        /* CTA Section */
        .cta {
            padding: 4rem 0;
            background: linear-gradient(135deg, #1976d2 0%, #1565c0 100%);
            color: white;
            text-align: center;
        }

        .cta h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        /* Footer */
        footer {
            background: #0d47a1;
            color: white;
            padding: 2rem 0;
            text-align: center;
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

        @media (max-width: 768px) {
            .nav-links {
                display: none;
            }

            .hero h1 {
                font-size: 2rem;
            }

            .hero p {
                font-size: 1.1rem;
            }

            .hero-buttons {
                flex-direction: column;
                align-items: center;
            }

            .section-title {
                font-size: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav>
        <div class="nav-container">
            <div class="logo">NLCOM</div>
            <div class="nav-links">
                <a href="#features">Features</a>
                <a href="#benefits">Benefits</a>
                <a href="#contact">Contact</a>
                <a href="/signup">Sign Up</a>
                <a href="/signup" class="btn-primary">Get Started</a>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <div class="container">
            <h1>Streamline Your Volunteer Management</h1>
            <p>Empower your organization with NLCOM's comprehensive volunteer coordination platform</p>
            <div class="hero-buttons">
                <a href="#" class="btn-primary">Start Free Trial</a>
                <a href="#" class="btn-secondary">Watch Demo</a>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features" id="features">
        <div class="container">
            <h2 class="section-title">Powerful Features</h2>
            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">👥</div>
                    <h3>Volunteer Database</h3>
                    <p>Centralize all volunteer information in one secure, easy-to-access platform with advanced search and filtering capabilities.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📅</div>
                    <h3>Smart Scheduling</h3>
                    <p>Create and manage shifts effortlessly with automated notifications and conflict detection to optimize your workforce.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📊</div>
                    <h3>Analytics & Reports</h3>
                    <p>Gain insights with detailed analytics on volunteer hours, engagement rates, and program effectiveness.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">✉️</div>
                    <h3>Communication Hub</h3>
                    <p>Send targeted messages, newsletters, and updates to volunteers through integrated email and SMS.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🎯</div>
                    <h3>Task Management</h3>
                    <p>Assign, track, and manage tasks with real-time updates and progress monitoring.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">🏆</div>
                    <h3>Recognition System</h3>
                    <p>Celebrate achievements with badges, certificates, and automated milestone recognition.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="benefits" id="benefits">
        <div class="container">
            <h2 class="section-title">Why Choose NLCOM?</h2>
            <div class="benefits-grid">
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Save Time</h4>
                        <p>Automate administrative tasks and reduce manual work by up to 70%</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Increase Engagement</h4>
                        <p>Keep volunteers connected and motivated with seamless communication</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Easy to Use</h4>
                        <p>Intuitive interface requires minimal training for staff and volunteers</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Secure & Reliable</h4>
                        <p>Enterprise-grade security with 99.9% uptime guarantee</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Mobile Access</h4>
                        <p>Manage volunteers on-the-go with our mobile-responsive design</p>
                    </div>
                </div>
                <div class="benefit-item">
                    <span class="check-icon">✓</span>
                    <div>
                        <h4>Dedicated Support</h4>
                        <p>24/7 customer support to help you succeed</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contact">
        <div class="container">
            <h2>Ready to Transform Your Volunteer Program?</h2>
            <p>Join thousands of organizations already using NLCOM</p>
            <a href="#" class="btn-secondary">Request a Demo</a>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class="container">
            <p>&copy; 2025 NLCOM. All rights reserved.</p>
            <p>Empowering organizations through better volunteer management</p>
        </div>
    </footer>
</body>
</html>
