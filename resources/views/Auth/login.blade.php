<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fintech Portal - Secure Access</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('auth/style.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                {{-- <div class="subtitle-text">Open a clear path to asset growth</div> --}}

                <form id="mainRegisterForm" onsubmit="event.preventDefault();">
                    <div class="mb-3">
                        <input type="text" name="name" class="form-control" placeholder="Full Name" required />
                    </div>
                    <div class="mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email Address" required />
                    </div>

                    <div class="mb-3">
                        <input type="text" name="mobile" class="form-control" placeholder="Mobile Number" required />
                    </div>


                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control password" placeholder="Password" required />
                        <span class="input-group-text toggle"><i class="bi bi-eye"></i></span>
                    </div>
                    <div class="mb-4">
                        <input type="password" name="password_confirmation" class="form-control" placeholder="Confirm Password" required />
                    </div>

                    <button type="submit" class="btn btn-secondary-fintech w-100 btn-fintech">
                       Sign Up & Verify Email
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
                <button class="btn btn-light" id="registerBtn">Sign Up</button>
            </div>
        </div>

    </div>
    <script src="{{ asset('auth/app.js') }}"></script>
</body>

</html>
