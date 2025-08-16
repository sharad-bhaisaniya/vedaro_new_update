@extends('layouts.main')
@section('title', 'Privacy Policy')
@section('content')


  <style>
        /* Base Styles */
        :root {
            --primary-color: #3c3b6e;
            --secondary-color: #6d6b9e;
            --text-color: #333;
            --light-text: #555;
            --background-color: #f9f9f9;
            --section-bg: #ffffff;
            --border-radius: 8px;
            --box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--background-color);
        }

   
        /* Main Content */
        .content {
            max-width: 1200px;
            margin: 120px auto 40px;
            padding: 0 20px;
        }
      

        .policy_section {
            background-color: var(--section-bg);
            padding: 30px;
            margin-bottom: 15px;
            border-radius: var(--border-radius);
            /*box-shadow: var(--box-shadow);*/
            transition: transform 0.3s ease;
        }

        /*.policy_section:hover {*/
        /*    transform: translateY(-3px);*/
        /*}*/

        .policy_section h2 {
            font-size: 1.8rem;
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #f0f0f0;
        }

        .policy_section p {
            font-size: 1.1rem;
            color: var(--light-text);
            margin: 15px 0;
        }

        .policy_section ul {
            list-style-type: disc;
            padding-left: 25px;
            margin: 15px 0;
        }

        .policy_section li {
            margin-bottom: 8px;
            color: var(--light-text);
        }

        .policy_section a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s ease;
        }

        .policy_section a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }

        /* Side by Side Section */
        .policy_images {
            display: flex;
            align-items: center;
            gap: 40px;
            flex-wrap: wrap;
        }

        .policy_images .policy_text {
            flex: 1;
            min-width: 300px;
        }

        .policy_images .policy_image {
            flex: 1;
            min-width: 300px;
            text-align: center;
        }

        .policy_images .policy_image img {
            max-width: 100%;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        /* Back to Top Button */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background-color: var(--primary-color);
            color: white;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            font-size: 1.5rem;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
            z-index: 100;
        }

        .back-to-top.visible {
            opacity: 1;
            visibility: visible;
        }

        .back-to-top:hover {
            background-color: var(--secondary-color);
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .content {
                margin-top: 100px;
            }
            
            .policy_section {
                padding: 25px;
            }
            
            .policy_section h2 {
                font-size: 1.6rem;
            }
        }

        @media (max-width: 768px) {
            .content {
                margin-top: 80px;
            }
            
            .policy_section {
                padding: 20px;
            }
            
            .policy_section h2 {
                font-size: 1.2rem;
            }
            
            .policy_section p {
                font-size: 0.8rem;
            }
            
            .policy_images {
                flex-direction: column;
                gap: 20px;
            }
            
            .policy_images .policy_text,
            .policy_images .policy_image {
                min-width: 100%;
            }
            .policy_section ul {
                font-size: 0.7rem;
            }
        }

        @media (max-width: 576px) {
            .content {
                margin-top: 70px;
                padding: 0 15px;
            }
            
            .policy_section {
                padding: 15px;
            }
            
            .policy_section h2 {
                font-size: 1.3rem;
            }
            
            .back-to-top {
                width: 40px;
                height: 40px;
                font-size: 1.2rem;
                bottom: 20px;
                right: 20px;
            }
        }
    </style>

    <main class="content">

    <!-- Privacy Policy Header -->
    <section class="policy_section" style="margin-top:90px">
        <h1 class="text-center" style="    border-bottom: 2px solid #f0f0f0;padding-bottom: 10px;">Privacy Policy</h1>
       
        <p>Your privacy is important to us. This policy explains how we collect, use, and protect your information.</p>
    </section>

        <section class="policy_section">
            <h2>Introduction</h2>
            <p>
                At Vedaro, your privacy is of utmost importance to us. This Privacy Policy outlines how we collect, use, and safeguard your information when you interact with our website or services. By using our services, you agree to the terms outlined in this policy.
            </p>
        </section>
        
        <section class="policy_section">
            <h2>Information We Collect</h2>
            <p>
                We may collect the following types of information:
            </p>
            <ul>
                <li>Personal Information: Name, email address, phone number, billing and shipping address.</li>
                <li>Payment Information: Credit/debit card details and other payment methods (processed securely).</li>
                <li>Browsing Data: IP address, browser type, pages visited, and other analytical data.</li>
            </ul>
        </section>
        
        <section class="policy_section">
            <h2>How We Use Your Information</h2>
            <p>
                The information we collect is used for the following purposes:
            </p>
            <ul>
                <li>To process and deliver your orders.</li>
                <li>To provide customer support and respond to your inquiries.</li>
                <li>To improve our website and services through analytics.</li>
                <li>To send promotional offers, newsletters, and updates (only with your consent).</li>
            </ul>
        </section>
        
        <section class="policy_section">
            <h2>How We Protect Your Data</h2>
            <p>
                We implement industry-standard security measures to protect your personal data against unauthorized access, alteration, disclosure, or destruction. These measures include encryption, secure servers, and regular security audits.
            </p>
        </section>
        
        <section class="policy_section policy_images">
            <div class="policy_text">
                <h2>Cookies and Tracking Technologies</h2>
                <p>
                    Our website uses cookies to enhance your browsing experience. Cookies are small text files stored on your device that help us understand your preferences and provide personalized content.
                </p>
                <ul>
                    <li>Essential Cookies: Necessary for website functionality.</li>
                    <li>Analytics Cookies: Used to analyze website traffic and performance.</li>
                    <li>Marketing Cookies: Used to show relevant advertisements.</li>
                </ul>
            </div>
            <div class="policy_image" style="width:200px;height:200px">
                <img src="https://images.prismic.io/secure-privacy/fb0afe12-0fbe-4d3a-919a-915816aa4701_Cookie%20Tracking_%20%20blog.png?ixlib=gatsbyFP&auto=compress%2Cformat&fit=max&q=45" alt="Cookies and Tracking" style="    width: 400px; height: 200px;object-fit: cover;" />
            </div>
        </section>
        
        <section class="policy_section">
            <h2>Sharing Your Information</h2>
            <p>
                We do not sell or rent your personal data. However, we may share your information with trusted third parties for the following purposes:
            </p>
            <ul>
                <li>Payment processing and fraud prevention.</li>
                <li>Order fulfillment and shipping services.</li>
                <li>Analytics and marketing assistance.</li>
            </ul>
        </section>

        <section class="policy_section">
            <h2>Your Rights</h2>
            <p>
                You have the right to:
            </p>
            <ul>
                <li>Access your personal data.</li>
                <li>Request corrections to inaccurate or incomplete information.</li>
                <li>Request deletion of your personal data, subject to applicable laws.</li>
                <li>Opt out of marketing communications at any time.</li>
            </ul>
        </section>

        <section class="policy_section">
            <h2>Changes to This Policy</h2>
            <p>
                We may update this Privacy Policy from time to time to reflect changes in our practices or legal requirements. Any changes will be posted on this page with the updated effective date.
            </p>
        </section>
        
        <section class="policy_section">
            <h2>Contact Us</h2>
            <p>
                If you have any questions or concerns about our Privacy Policy, please contact us at 
                <a href="mailto:support@vedaro.com">support@vedaro.com</a> or call us at +91-9079673886
            </p>
        </section>
    </main>

    <a href="#" class="back-to-top" id="backToTop">↑</a>

    <script>
        // Back to Top Button
        const backToTopButton = document.getElementById('backToTop');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                backToTopButton.classList.add('visible');
            } else {
                backToTopButton.classList.remove('visible');
            }
        });
        
        backToTopButton.addEventListener('click', (e) => {
            e.preventDefault();
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });
    </script>

@endsection
