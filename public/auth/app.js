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
document.querySelectorAll(".otp-container").forEach((container) => {
    const inputs = container.querySelectorAll(".otp-input");
    inputs.forEach((input, index) => {
        input.oninput = () => {
            if (input.value.length === 1 && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
        };
        input.onkeydown = (e) => {
            if (
                e.key === "Backspace" &&
                input.value.length === 0 &&
                index > 0
            ) {
                inputs[index - 1].focus();
            }
        };
    });
});

// Universal password field eye-icon visual toggle
document.querySelectorAll(".toggle").forEach((btn) => {
    btn.onclick = function () {
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
