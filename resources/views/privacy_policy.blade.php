@extends('layouts.main')
@section('title', 'Privacy Policy')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/css/privacy_policy.css') }}">

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
