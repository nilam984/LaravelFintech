<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fintech Portal - Secure Access</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: "Segoe UI", system-ui, -apple-system, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            overflow: hidden;
            background: linear-gradient(-45deg, #0b1528, #112240, #1a365d, #0f172a);
            background-size: 400% 400%;
            animation: bg 12s ease infinite;
        }

        @keyframes bg {
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

        .circle {
            position: absolute;
            border-radius: 50%;
            background: rgba(0, 180, 216, 0.08);
            backdrop-filter: blur(5px);
            animation: float 8s infinite ease-in-out;
        }

        .circle:nth-child(1) {
            width: 220px;
            height: 220px;
            top: 8%;
            left: 8%;
        }

        .circle:nth-child(2) {
            width: 160px;
            height: 160px;
            bottom: 10%;
            right: 12%;
            animation-delay: 2s;
        }

        .circle:nth-child(3) {
            width: 120px;
            height: 120px;
            top: 60%;
            left: 20%;
            animation-delay: 4s;
        }

        .circle:nth-child(4) {
            width: 180px;
            height: 180px;
            top: 20%;
            right: 18%;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-35px);
            }
        }

        .wrapper {
            position: relative;
            width: 900px;
            height: 580px;
            background: rgba(255, 255, 255, 0.06);
            border-radius: 24px;
            backdrop-filter: blur(25px);
            border: 1px solid rgba(255, 255, 255, 0.12);
            overflow: hidden;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.45);
        }

        .form-box {
            position: absolute;
            width: 50%;
            height: 100%;
            padding: 60px;
            transition: 0.7s cubic-bezier(0.25, 1, 0.5, 1);
        }

        /* View Positions & Opacity States */
        .login {
            left: 0;
            opacity: 1;
            z-index: 2;
        }

        .register {
            right: -50%;
            opacity: 0;
            z-index: 1;
        }

        .forgot {
            left: -50%;
            opacity: 0;
            z-index: 1;
        }

        /* Active State: Registration Mode */
        .wrapper.active-register .login {
            left: -50%;
            opacity: 0;
        }

        .wrapper.active-register .register {
            right: 0;
            opacity: 1;
            z-index: 2;
        }

        .wrapper.active-register .forgot {
            left: -50%;
            opacity: 0;
        }

        /* Active State: Forgot Password Mode */
        .wrapper.active-forgot .login {
            left: -50%;
            opacity: 0;
        }

        .wrapper.active-forgot .register {
            right: -50%;
            opacity: 0;
        }

        .wrapper.active-forgot .forgot {
            left: 0;
            opacity: 1;
            z-index: 2;
        }

        /* Internal Multi-step Flow Animation Controls */
        .register-step,
        .forgot-step {
            transition: opacity 0.4s ease, transform 0.4s ease;
        }

        .register-step.d-none,
        .forgot-step.d-none {
            display: none !important;
            opacity: 0;
            transform: translateX(20px);
        }

        /* OTP Digits Inputs */
        .otp-container {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            margin: 25px 0;
        }

        .otp-input {
            width: 55px;
            height: 55px;
            text-align: center;
            font-size: 24px;
            font-weight: 700;
            color: white;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 12px;
        }

        .otp-input:focus {
            background: rgba(255, 255, 255, 0.15);
            border-color: #52b788;
            box-shadow: 0 0 15px rgba(82, 183, 136, 0.3);
            outline: none;
        }

        /* Forgot View OTP focus border */
        .forgot .otp-input:focus {
            border-color: #e63946;
            box-shadow: 0 0 15px rgba(230, 57, 70, 0.3);
        }

        /* Info Overlay Styling & Mechanics */
        .info {
            position: absolute;
            width: 50%;
            height: 100%;
            right: 0;
            background: linear-gradient(135deg, #00b4d8, #0077b6, #03045e);
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px;
            transition: 0.7s cubic-bezier(0.25, 1, 0.5, 1);
            color: white;
            z-index: 3;
        }

        .wrapper.active-register .info {
            right: 50%;
        }

        .wrapper.active-forgot .info {
            right: 0;
        }

        .info-content {
            animation: fade 1s;
        }

        @keyframes fade {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .info h1 {
            font-size: 38px;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .info p {
            margin: 20px 0;
            color: rgba(255, 255, 255, 0.85);
        }

        .info button {
            border-radius: 50px;
            padding: 12px 40px;
            font-weight: 600;
            border: none;
            color: #0077b6 !important;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
        }

        .title {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
            margin-bottom: 15px;
            letter-spacing: -0.5px;
        }

        .subtitle-text {
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            margin-bottom: 35px;
        }

        .form-control {
            height: 50px;
            border-radius: 50px;
            padding-left: 20px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
        }

        .form-control::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .form-control:focus {
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid #00b4d8;
            box-shadow: 0 0 15px rgba(0, 180, 216, 0.3);
            color: white;
        }

        .input-group-text {
            border-radius: 0 50px 50px 0;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-left: none;
            color: rgba(255, 255, 255, 0.6);
            cursor: pointer;
        }

        .input-group .form-control {
            border-radius: 50px 0 0 50px;
        }

        .btn-fintech {
            height: 50px;
            border-radius: 50px;
            font-weight: 600;
            font-size: 16px;
            transition: 0.3s;
            border: none;
        }

        .btn-primary-fintech {
            background: #00b4d8;
            color: #0b1528;
        }

        .btn-primary-fintech:hover {
            background: #90e0ef;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 180, 216, 0.4);
        }

        .btn-secondary-fintech {
            background: #52b788;
            color: #0b1528;
        }

        .btn-secondary-fintech:hover {
            background: #74c69d;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(82, 183, 136, 0.4);
        }

        .btn-accent-fintech {
            background: #e63946;
            color: white;
        }

        .btn-accent-fintech:hover {
            background: #f15bb5;
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(230, 57, 70, 0.4);
        }

        .social {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-top: 20px;
        }

        .social a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.1);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            text-decoration: none;
            transition: 0.3s;
        }

        .social a:hover {
            background: rgba(255, 255, 255, 0.2);
            color: #00b4d8;
            transform: translateY(-3px);
        }

        .text-link {
            color: #00b4d8 !important;
            cursor: pointer;
            transition: 0.2s;
        }

        .text-link:hover {
            color: #90e0ef !important;
            text-decoration: underline !important;
        }

        @media (max-width: 768px) {
            .wrapper {
                width: 95%;
                height: auto;
                padding-bottom: 30px;
            }

            .info {
                display: none;
            }

            .form-box {
                position: relative;
                width: 100%;
                padding: 35px;
            }

            .login,
            .register,
            .forgot {
                left: 0;
                right: 0;
                opacity: 1;
                display: none;
            }

            .login {
                display: block;
            }

            .wrapper.active-register .login,
            .wrapper.active-register .forgot {
                display: none;
            }

            .wrapper.active-register .register {
                display: block;
            }

            .wrapper.active-forgot .login,
            .wrapper.active-forgot .register {
                display: none;
            }

            .wrapper.active-forgot .forgot {
                display: block;
            }
        }
    </style>
</head>

<body>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>
    <div class="circle"></div>

    <div class="wrapper" id="wrapper">

        <!-- 1. SIGN IN BOX -->
        <div class="form-box login">
            <h2 class="title">Sign In</h2>
            <div class="subtitle-text">Access your high-yield secure panel</div>

            <form onsubmit="event.preventDefault();">
                <div class="mb-3">
                    <input type="email" class="form-control" placeholder="Corporate Email Address" />
                </div>

                <div class="input-group mb-3">
                    <input type="password" class="form-control password" placeholder="Password" />
                    <span class="input-group-text toggle"><i class="bi bi-eye"></i></span>
                </div>

                <div class="d-flex justify-content-between text-white-50 small mb-4">
                    <div>
                        <input type="checkbox" id="remember" class="me-1" />
                        <label for="remember" class="text-white">Remember device</label>
                    </div>
                    <span id="toForgotBtn" class="text-link text-decoration-none">Forgot Password?</span>
                </div>

                <button class="btn btn-primary-fintech w-100 btn-fintech">Secure Login</button>
                <div class="text-center text-white-50 small mt-4">Or Continue With</div>

                <div class="social">
                    <a href="#"><i class="bi bi-google"></i></a>
                    <a href="#"><i class="bi bi-apple"></i></a>
                    <a href="#"><i class="bi bi-key-fill"></i></a>
                </div>
            </form>
        </div>

        <!-- 2. REGISTER BOX (Multi-step) -->
        <div class="form-box register">

            <!-- Sub-step A: Initial Form Data -->
            <div id="registerFormStep" class="register-step">
                <h2 class="title">Create Account</h2>
                <div class="subtitle-text">Open a clear path to asset growth</div>

                <form id="mainRegisterForm" onsubmit="event.preventDefault();">
                    <div class="mb-3">
                        <input type="text" class="form-control" placeholder="Full Name" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" class="form-control" placeholder="Email Address" required />
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control password" placeholder="Password" required />
                        <span class="input-group-text toggle"><i class="bi bi-eye"></i></span>
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" placeholder="Confirm Password" required />
                    </div>

                    <button type="submit" class="btn btn-secondary-fintech w-100 btn-fintech">
                        Open Free Account
                    </button>
                    <div class="text-center text-white-50 small mt-4">
                        Already registered?
                        <span id="loginFromRegBtn" class="text-link text-decoration-none fw-bold">Sign In</span>
                    </div>
                </form>
            </div>

            <!-- Sub-step B: OTP Verification Form -->
            <div id="registerOtpStep" class="register-step d-none">
                <h2 class="title">Verify Email</h2>
                <div class="subtitle-text">We have transmitted a 4-digit token security key to your email address.</div>

                <form id="registerOtpForm" onsubmit="event.preventDefault();">
                    <div class="otp-container">
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                    </div>

                    <button type="submit" class="btn btn-primary-fintech w-100 btn-fintech mb-3">
                        Verify & Activate Account
                    </button>

                    <div class="text-center text-white-50 small">
                        Didn't receive code?
                        <span class="text-link text-decoration-none fw-bold">Resend Token</span>
                    </div>
                </form>
            </div>

        </div>

        <!-- 3. FORGOT PASSWORD BOX (Multi-step Custom Pipeline) -->
        <div class="form-box forgot">

            <!-- Forgot Step 1: Enter Email -->
            <div id="forgotEmailStep" class="forgot-step">
                <h2 class="title">Reset Password</h2>
                <div class="subtitle-text">Provide verification email to recover account credentials</div>

                <form id="forgotEmailForm" onsubmit="event.preventDefault();">
                    <div class="mb-4">
                        <input type="email" class="form-control" placeholder="Registered Email Address" required />
                    </div>

                    <button type="submit" class="btn btn-accent-fintech w-100 btn-fintech mb-4">Request Security
                        OTP</button>

                    <div class="text-center text-white-50 small">
                        Remembered it?
                        <span id="loginFromForgotBtn" class="text-link text-decoration-none fw-bold">Sign In</span>
                    </div>
                    <div class="text-center text-white-50 small mt-2">
                        New here?
                        <span id="regFromForgotBtn" class="text-link text-decoration-none fw-bold">Create
                            Account</span>
                    </div>
                </form>
            </div>

            <!-- Forgot Step 2: Enter OTP -->
            <div id="forgotOtpStep" class="forgot-step d-none">
                <h2 class="title">Security Token</h2>
                <div class="subtitle-text">Enter the 4-digit secure access token dispatched to your email address.
                </div>

                <form id="forgotOtpForm" onsubmit="event.preventDefault();">
                    <div class="otp-container">
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                        <input type="text" maxlength="1" class="otp-input" required />
                    </div>

                    <button type="submit" class="btn btn-accent-fintech w-100 btn-fintech mb-3">Verify Identity
                        Token</button>

                    <div class="text-center text-white-50 small">
                        No code received?
                        <span class="text-link text-decoration-none fw-bold">Resend OTP</span>
                    </div>
                </form>
            </div>

            <!-- Forgot Step 3: Enter New Password -->
            <div id="forgotNewPasswordStep" class="forgot-step d-none">
                <h2 class="title">New Password</h2>
                <div class="subtitle-text">Create a robust and secure cryptographic password for protection</div>

                <form id="forgotNewPasswordForm" onsubmit="event.preventDefault();">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control password" placeholder="New Password" required />
                        <span class="input-group-text toggle"><i class="bi bi-eye"></i></span>
                    </div>
                    <div class="mb-4">
                        <input type="password" class="form-control" placeholder="Confirm New Password" required />
                    </div>

                    <button type="submit" class="btn btn-primary-fintech w-100 btn-fintech">Update
                        Credentials</button>
                </form>
            </div>

        </div>

        <!-- SIDE INTERACTIVE OVERLAY -->
        <div class="info">
            <div class="info-content">
                <h1>Welcome to Apex</h1>
                <p>Experience next-generation asset management, automated investing, and military-grade transactional
                    security.</p>
                <button class="btn btn-light" id="registerBtn">Get Started</button>
            </div>
        </div>

    </div>

    <script>
        const wrapper = document.getElementById("wrapper");

        // --- Views Step References ---
        const registerFormStep = document.getElementById("registerFormStep");
        const registerOtpStep = document.getElementById("registerOtpStep");

        const forgotEmailStep = document.getElementById("forgotEmailStep");
        const forgotOtpStep = document.getElementById("forgotOtpStep");
        const forgotNewPasswordStep = document.getElementById("forgotNewPasswordStep");

        // Reset Functions to bring internal dynamic pipelines back to Step 1
        function resetRegisterSteps() {
            registerOtpStep.classList.add("d-none");
            registerFormStep.classList.remove("d-none");
        }

        function resetForgotSteps() {
            forgotOtpStep.classList.add("d-none");
            forgotNewPasswordStep.classList.add("d-none");
            forgotEmailStep.classList.remove("d-none");
        }

        // --- Navigation Switch Targets ---
        document.getElementById("registerBtn").onclick = () => {
            wrapper.className = "wrapper active-register";
            resetRegisterSteps();
        };
        document.getElementById("regFromForgotBtn").onclick = () => {
            wrapper.className = "wrapper active-register";
            resetRegisterSteps();
        };
        document.getElementById("loginFromRegBtn").onclick = () => {
            wrapper.className = "wrapper";
        };
        document.getElementById("loginFromForgotBtn").onclick = () => {
            wrapper.className = "wrapper";
        };
        document.getElementById("toForgotBtn").onclick = () => {
            wrapper.className = "wrapper active-forgot";
            resetForgotSteps();
        };

        // --- Registration Form Transitions ---
        document.getElementById("mainRegisterForm").onsubmit = (e) => {
            e.preventDefault();
            const simulatedBackendSaved = true; // Simulated validation
            if (simulatedBackendSaved) {
                registerFormStep.classList.add("d-none");
                registerOtpStep.classList.remove("d-none");
            }
        };

        document.getElementById("registerOtpForm").onsubmit = (e) => {
            e.preventDefault();
            alert("Activation Complete! Redirecting to secure panel.");
            wrapper.className = "wrapper"; // Redirect to Log In View
        };

        // --- Forgot Password Multi-Step Form Transitions ---
        // Step 1 -> Step 2 (Email to OTP)
        document.getElementById("forgotEmailForm").onsubmit = (e) => {
            e.preventDefault();
            const simulatedEmailChecked = true;
            if (simulatedEmailChecked) {
                forgotEmailStep.classList.add("d-none");
                forgotOtpStep.classList.remove("d-none");
            }
        };

        // Step 2 -> Step 3 (OTP to New Password)
        document.getElementById("forgotOtpForm").onsubmit = (e) => {
            e.preventDefault();
            const simulatedOtpVerified = true;
            if (simulatedOtpVerified) {
                forgotOtpStep.classList.add("d-none");
                forgotNewPasswordStep.classList.remove("d-none");
            }
        };

        // Step 3 -> Back to Login
        document.getElementById("forgotNewPasswordForm").onsubmit = (e) => {
            e.preventDefault();
            alert("Your cryptographic credentials have been updated successfully!");
            wrapper.className = "wrapper"; // Direct user to clean Sign In panel
        };

        // --- Universal UI Enhancements ---
        // Auto-focus mechanics for OTP digits inputs (Both Registration & Forgot sections)
        document.querySelectorAll('.otp-container').forEach(container => {
            const inputs = container.querySelectorAll('.otp-input');
            inputs.forEach((input, index) => {
                input.oninput = () => {
                    if (input.value.length === 1 && index < inputs.length - 1) {
                        inputs[index + 1].focus();
                    }
                };
                input.onkeydown = (e) => {
                    if (e.key === "Backspace" && input.value.length === 0 && index > 0) {
                        inputs[index - 1].focus();
                    }
                };
            });
        });

        // Universal password field eye-icon visual toggle
        document.querySelectorAll(".toggle").forEach((btn) => {
            btn.onclick = function() {
                let input = this.previousElementSibling;
                let icon = this.querySelector("i");
                if (input.type === "password") {
                    input.type = "text";
                    icon.classList.replace("bi-eye", "bi-eye-slash");
                } else {
                    input.type = "password";
                    icon.classList.replace("bi-eye-slash", "bi-eye");
                }
            };
        });
    </script>
</body>

</html>
