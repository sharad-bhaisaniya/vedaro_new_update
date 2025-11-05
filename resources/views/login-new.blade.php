<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login / Signup Modal</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background-color: #e0e0e0;
    }

    /* Background blur when modal is active */
    .overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0,0,0,0.5);
      backdrop-filter: blur(8px);
      display: flex; /* Show directly */
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    /* Modal Container */
    .modal {
      background: #f2ecdd;
      border-radius: 12px;
      display: flex;
      overflow: hidden;
      max-width: 600px; /* Increased max-width slightly */
      width: 90%;
      box-shadow: 0 6px 20px rgba(0,0,0,0.3);
      position: relative;
    }

    /* Left Image Panel */
    .modal .modal-img {
      flex-basis: 40%; /* Set a base width */
      background: url("https://cdn.pixabay.com/photo/2014/04/28/21/59/gem-334066_1280.jpg") no-repeat center center/cover;
    }

    /* Right Form Panel */
    .modal .modal-content {
      flex-basis: 60%; /* Set a base width */
      padding: 30px;
      display: flex;
      flex-direction: column;
      justify-content: center;
      background: #f2ecdd;
    }

    .modal-content h3 {
      margin-top: 0;
      margin-bottom: 20px;
      font-size: 22px; /* Increased font size */
      color: #0f2a1d;
      font-weight: 600;
    }
    
    .mobile-input-container {
        position: relative;
        display: flex;
        align-items: center;
        margin: 8px 0;
    }
    
    .mobile-input-container label {
        position: absolute;
        left: 12px;
        color: #555;
        font-size: 14px;
    }

    .modal-content input {
      width: 100%;
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 14px;
      box-sizing: border-box;
    }
    
    .mobile-input-container input {
        padding-left: 45px; /* Make space for the +91 label */
    }

    .modal-content button {
      margin-top: 15px;
      background: #0f2a1d;
      color: #fff;
      border: none;
      padding: 12px;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .modal-content button:hover {
      background: #1b3b2f;
    }

    /* Close button */
    .close-btn {
      position: absolute;
      top: 12px;
      right: 15px;
      font-size: 24px; 
      cursor: pointer;
      color: #333;
      z-index: 10;
    }

    /* OTP Inputs */
    .otp-inputs {
      display: flex;
      justify-content: space-between; 
      gap: 8px;
    }
    .otp-inputs input {
      width: 40px;
      height: 40px;
      text-align: center;
      font-size: 18px;
      font-weight: bold;
    }
    
    /* Responsive Design for Mobile */
    @media (max-width: 600px) {
        .modal .modal-img {
            display: none; 
        }
        .modal .modal-content {
            flex-basis: 100%; 
        }
        .otp-inputs input {
            width: 35px;
            height: 35px;
        }
    }
  </style>
</head>
<body>

  <div class="overlay" id="overlay">
    <div class="modal">
      <div class="modal-img"></div>

      <div class="modal-content" id="loginModal">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Login / Signup</h3>
        <div class="mobile-input-container">
            <label>+91</label>
            <input type="tel" placeholder="Enter Mobile Number" maxlength="10">
        </div>
        <button onclick="showOTP()">Continue</button>
      </div>

      <div class="modal-content" id="otpModal" style="display: none;">
        <span class="close-btn" onclick="closeModal()">&times;</span>
        <h3>Enter OTP</h3>
        <div class="otp-inputs">
          <input type="text" maxlength="1" onkeyup="moveToNext(this, 'otp2')">
          <input id="otp2" type="text" maxlength="1" onkeyup="moveToNext(this, 'otp3')">
          <input id="otp3" type="text" maxlength="1" onkeyup="moveToNext(this, 'otp4')">
          <input id="otp4" type="text" maxlength="1" onkeyup="moveToNext(this, 'otp5')">
          <input id="otp5" type="text" maxlength="1" onkeyup="moveToNext(this, 'otp6')">
          <input id="otp6" type="text" maxlength="1">
        </div>
        <button>Continue</button>
      </div>
    </div>
  </div>

  <script>
    const overlay = document.getElementById("overlay");
    const loginModal = document.getElementById("loginModal");
    const otpModal = document.getElementById("otpModal");

    function closeModal() {
      overlay.style.display = "none";
      loginModal.style.display = "flex";
      otpModal.style.display = "none";
    }

    function showOTP() {
      loginModal.style.display = "none";
      otpModal.style.display = "flex";
    }

    function moveToNext(current, nextFieldID) {
      if (current.value.length >= current.maxLength) {
        document.getElementById(nextFieldID).focus();
      }
    }
  </script>
</body>
</html>
