<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coming Soon</title>
    <style>
        /* Import Google Fonts */
        @import url("https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@300;400;600&display=swap");

        /* CSS Variables for easy theme management */
        :root {
            --font-primary: "Playfair Display", serif;
            --font-secondary: "Poppins", sans-serif;
            --color-gold: #D4AF37; /* A classic, rich gold */
            --color-text: #F5F5F5; /* A softer white */
            --color-dark: #121212;
            --color-dark-accent: #1a1a1a;
        }

        /* Base & Reset Styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-secondary);
            background-color: var(--color-dark);
            overflow: hidden; /* Prevents scrollbars from the background image */
        }

        /* Main Container & Background */
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            text-align: center;
            min-height: 100vh;
            width: 100%;
            padding: 20px;
            position: relative;
            z-index: 2;
        }

        /* Background Image & Overlay */
        .container .background-image {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            object-fit: cover;
            z-index: -1;
            /* The image provided in the request */
            /*background-image: url('https://i.pinimg.com/originals/3d/67/58/3d675850006da34bb139122aa7073eb8.jpg');*/
            background-image: url('https://www.mannatjewels.com/images/inner_page/necklace/5.jpg');
            background-position: center center;
            background-size: cover;
        }

        /* Gradient Overlay for better text readability */
        .container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: linear-gradient(360deg, rgba(18, 18, 18, 0.95) 0%, rgba(18, 18, 18, 0.7) 100%);
            z-index: -1;
        }

        /* Header & Paragraph Styling */
        header {
            font-family: var(--font-primary);
            font-size: 4rem; /* 64px */
            font-weight: 700;
            color: var(--color-gold);
            letter-spacing: 2px;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.5);
        }

        .container p {
            font-size: 1.1rem; /* 18px */
            font-weight: 300;
            color: var(--color-text);
            max-width: 600px;
            line-height: 1.6;
        }

        /* Countdown Timer Styling */
        .time-content {
            display: flex;
            gap: 2rem;
            align-items: center;
            margin: 3rem 0;
        }

        .time-content .time {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            width: 120px;
            height: 120px;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
            backdrop-filter: blur(5px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        
        .time-content .time:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .time .number {
            font-weight: 600;
            font-size: 3.5rem; /* 56px */
            line-height: 1;
            color: var(--color-text);
        }

        .time .text {
            text-transform: uppercase;
            color: var(--color-gold);
            font-weight: 400;
            font-size: 0.75rem; /* 12px */
            letter-spacing: 1px;
            margin-top: 0.5rem;
        }

        /* Email Subscription Form */
        .email-content {
            display: flex;
            flex-direction: column;
            align-items: center;
            width: 100%;
            margin-top: 1rem;
        }

        .email-content p {
            font-size: 1rem; /* 16px */
            margin-bottom: 1.5rem;
            font-weight: 400;
        }

        .input-box {
            display: flex;
            align-items: center;
            height: 50px;
            max-width: 420px;
            width: 100%;
            position: relative;
        }

        .input-box input {
            height: 100%;
            width: 100%;
            border: 1px solid rgba(212, 175, 55, 0.5);
            border-radius: 8px;
            background-color: transparent;
            padding: 0 150px 0 20px; /* Space for the button */
            font-size: 1rem;
            color: var(--color-text);
            outline: none;
            transition: border-color 0.3s ease;
        }

        .input-box input::placeholder {
            color: rgba(245, 245, 245, 0.6);
            font-weight: 300;
        }

        .input-box input:focus {
            border-color: var(--color-gold);
        }

        .input-box button {
            position: absolute;
            right: 6px;
            top: 6px;
            bottom: 6px;
            cursor: pointer;
            width: 130px;
            border: none;
            border-radius: 6px;
            background-color: var(--color-gold);
            color: var(--color-dark-accent);
            font-size: 1rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        .input-box button:hover {
            background-color: #EACD6A; /* Lighter gold on hover */
            transform: scale(1.02);
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            header {
                font-size: 3rem; /* 48px */
            }
            .time-content {
                gap: 1rem;
            }
            .time-content .time {
                width: 90px;
                height: 90px;
            }
            .time .number {
                font-size: 2.5rem; /* 40px */
            }
        }

        @media screen and (max-width: 480px) {
            header {
                font-size: 2.5rem; /* 40px */
            }
            .container p {
                font-size: 1rem;
            }
            .time-content {
                flex-wrap: wrap;
                justify-content: center;
                gap: 1rem;
                margin: 2rem 0;
            }
            .time-content .time {
                width: calc(50% - 0.5rem); /* Two items per row */
                height: 100px;
            }
            .input-box {
                flex-direction: column;
                height: auto;
                gap: 1rem;
            }
            .input-box input {
                width: 100%;
                height: 50px;
                padding: 0 20px;
                text-align: center;
            }
            .input-box button {
                position: static;
                width: 100%;
                height: 50px;
            }
        }
    </style>
</head>
<body>

    <section class="container">
        <div class="background-image"></div>
      
        <header>Something New is Coming</header>
      
        <p>
            We are putting the final touches on our new platform. Be the first to know when we launch and get exclusive access to our opening collections.
        </p>
      
        <div class="time-content">
            <div class="time days">
                <span class="number">00</span>
                <span class="text">days</span>
            </div>
            <div class="time hours">
                <span class="number">00</span>
                <span class="text">hours</span>
            </div>
            <div class="time minutes">
                <span class="number">00</span>
                <span class="text">minutes</span>
            </div>
            <div class="time seconds">
                <span class="number">00</span>
                <span class="text">seconds</span>
            </div>
        </div>
      
        <div class="email-content">
            <p>Subscribe now to get the latest updates!</p>
            <div class="input-box">
                <input type="email" placeholder="Enter your email..." />
                <button>Notify Me</button>
            </div>
        </div>
    </section>

    <script>
        // Select all time elements
        const secondsEl = document.querySelector(".seconds .number"),
              minutesEl = document.querySelector(".minutes .number"),
              hoursEl = document.querySelector(".hours .number"),
              daysEl = document.querySelector(".days .number");
        
        const timeContent = document.querySelector(".time-content");
        const mainHeader = document.querySelector("header");

        // Set the launch date (Year, Month (0-11), Day, Hour, Minute, Second)
        // Example: 30 days from now. Today is July 22, 2025. Launch date is August 21, 2025.
        const launchDate = new Date("2025-08-21T12:00:00").getTime();

        const timeFunction = setInterval(() => {
            const now = new Date().getTime();
            const distance = launchDate - now;

            if (distance < 0) {
                clearInterval(timeFunction);
                // What happens when the countdown is over
                mainHeader.textContent = "We're Live!";
                timeContent.innerHTML = "<p>Our new website is officially open. Welcome!</p>";
                return;
            }

            // Time calculations
            const days = Math.floor(distance / (1000 * 60 * 60 * 24));
            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Add leading zero if number is less than 10
            daysEl.textContent = days < 10 ? `0${days}` : days;
            hoursEl.textContent = hours < 10 ? `0${hours}` : hours;
            minutesEl.textContent = minutes < 10 ? `0${minutes}` : minutes;
            secondsEl.textContent = seconds < 10 ? `0${seconds}` : seconds;

        }, 1000); // Update every second

    </script>

</body>
</html>
