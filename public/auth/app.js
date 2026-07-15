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
const registerForm = document.getElementById("mainRegisterForm");

registerForm.addEventListener("submit", async function (e) {
    e.preventDefault();

    let formData = new FormData(this);

    try {
        let response = await fetch("/register", {
            method: "POST",

            headers: {
                "X-CSRF-TOKEN": document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),

                Accept: "application/json",
            },

            body: formData,
        });

        let result = await response.json();

        if (result.status) {
            document.getElementById("userEmail").value =
                result?.data?.email ?? null;
            ToastEngine.show(result.message, "success");
            registerFormStep.classList.add("d-none");
            registerOtpStep.classList.remove("d-none");
        } else {
            ToastEngine.show(result.message, "error");
        }
    } catch (error) {
        console.log(error);
        ToastEngine.show("Something went wrong.", "error");
    }
});

document
    .getElementById("registerOtpForm")
    .addEventListener("submit", function (e) {
        e.preventDefault();

        let otp = "";

        document.querySelectorAll(".otp-input").forEach((input) => {
            otp += input.value;
        });

        let userEmail = document.getElementById("userEmail").value;

        $.ajax({
            url: "/verify-otp",
            type: "POST",
            data: {
                _token: document
                    .querySelector('meta[name="csrf-token"]')
                    .getAttribute("content"),
                otp: otp,
                email: userEmail,
            },
            success: function (response) {
                if (response.status) {
                    ToastEngine.show(response.message, "success");

                    setTimeout(() => {
                        wrapper.className = "wrapper";
                    }, 1000);
                } else {
                    ToastEngine.show(response.message, "error");
                }
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    let errors = xhr.responseJSON.errors;
                    ToastEngine.show(Object.values(errors)[0][0], "error");
                } else {
                    ToastEngine.show(
                        "Something went wrong. Please try again.",
                        "error",
                    );
                }
            },
        });
    });

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

$.ajaxSetup({
    headers: {
        "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    },
});

$("#loginForm").submit(function (e) {
    e.preventDefault();
    $.ajax({
        url: "login",
        type: "POST",
        data: $(this).serialize(),
        success: function (response) {
            ToastEngine.show(response.message, "success");

            setTimeout(function () {
                window.location.href = response.redirect;
            }, 1000);
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                let errors = xhr.responseJSON.errors;
                let errorText = "";

                $.each(errors, function (key, value) {
                    errorText += value[0] + "<br>";
                });

                ToastEngine.show(errorText, "error");
            } else {
                ToastEngine.show(xhr.responseJSON.message, "error");
            }
        },
    });
});

const ToastEngine = {
    container: document.getElementById("toastContainer"),

    show: function (message, type = "success", duration = 4000) {
        if (!this.container) return;

        const configs = {
            success: {
                icon: "bi-check-circle",
                iconColor: "text-emerald-400",
            },
            error: {
                icon: "bi-x-circle",
                iconColor: "text-rose-400",
            },
            info: {
                icon: "bi-info-circle",
                iconColor: "text-sky-400",
            },
        };

        const config = configs[type] || configs.info;

        const toast = document.createElement("div");
        toast.className =
            "pointer-events-auto w-full max-w-sm overflow-hidden rounded-xl bg-slate-900 border border-slate-800 shadow-xl ring-1 ring-black ring-opacity-5 transition-all duration-300 transform translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2";

        toast.innerHTML = `
            <div class="p-4">
                <div class="flex items-start">
                <div class="flex-shrink-0">
                    <i class="bi ${config.icon} ${config.iconColor} text-xl"></i>
                </div>
                <div class="ml-3 w-0 flex-1 pt-0.5">
                    <p class="text-sm font-semibold text-white capitalize">${type} Notification</p>
                    <p class="mt-1 text-sm text-slate-400 leading-normal">${message}</p>
                </div>
                <div class="ml-4 flex flex-shrink-0">
                    <button type="button" class="inline-flex rounded-md bg-slate-900 text-slate-500 hover:text-slate-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:ring-offset-2 focus:ring-offset-slate-900 transition" onclick="this.closest('.pointer-events-auto').remove()">
                    <span class="sr-only">Close</span>
                    <i class="bi bi-x-lg text-xs p-1"></i>
                    </button>
                </div>
                </div>
            </div>
            `;

        this.container.appendChild(toast);

        requestAnimationFrame(() => {
            toast.classList.remove(
                "translate-y-2",
                "sm:translate-x-2",
                "opacity-0",
            );
            toast.classList.add(
                "translate-y-0",
                "sm:translate-x-0",
                "opacity-100",
            );
        });

        setTimeout(() => {
            toast.classList.remove(
                "translate-y-0",
                "sm:translate-x-0",
                "opacity-100",
            );
            toast.classList.add(
                "translate-y-2",
                "sm:translate-x-2",
                "opacity-0",
            );
            toast.addEventListener("transitionend", () => toast.remove());
        }, duration);
    },
};
