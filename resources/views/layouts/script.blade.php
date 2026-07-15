<script>
    const sidebarPanel = document.getElementById("sidebarPanel");
    const sidebarOverlay = document.getElementById("sidebarOverlay");
    const notificationMenu = document.getElementById("notificationMenu");
    const profileMenu = document.getElementById("profileMenu");

    function toggleSidebar() {
        const isOpen = sidebarPanel.classList.contains("translate-x-0");
        if (isOpen) {
            sidebarPanel.classList.remove("translate-x-0");
            sidebarPanel.classList.add("-translate-x-full");
            sidebarOverlay.classList.add("hidden");
        } else {
            sidebarPanel.classList.remove("-translate-x-full");
            sidebarPanel.classList.add("translate-x-0");
            sidebarOverlay.className = "fixed inset-0 bg-black/60 z-30 lg:hidden backdrop-blur-sm";
        }
    }

    function toggleNotificationMenu() {
        notificationMenu.classList.toggle("hidden");
        profileMenu.classList.add("hidden");
    }

    function toggleProfileMenu() {
        profileMenu.classList.toggle("hidden");
        notificationMenu.classList.add("hidden");
    }

    function processLogout() {
        const confirmLog = confirm("Are you sure you want to terminate this encrypted session?");
        if (confirmLog) {
            alert("Session keys erased. Redirecting back to access checkpoint portal.");
        }
    }

    window.onclick = function(event) {
        if (!event.target.closest('#notificationMenu') && !event.target.closest(
                'button[onclick="toggleNotificationMenu()"]')) {
            notificationMenu.classList.add("hidden");
        }
        if (!event.target.closest('#profileMenu') && !event.target.closest(
                'button[onclick="toggleProfileMenu()"]')) {
            profileMenu.classList.add("hidden");
        }
    }

    /**
     * Official Tailwind UI Specification Toast Engine
     */
    const ToastEngine = {
        container: document.getElementById('toastContainer'),

        show: function(message, type = 'success', duration = 4000) {
            if (!this.container) return;

            const configs = {
                success: {
                    icon: 'bi-check-circle',
                    iconColor: 'text-emerald-400'
                },
                error: {
                    icon: 'bi-x-circle',
                    iconColor: 'text-rose-400'
                },
                info: {
                    icon: 'bi-info-circle',
                    iconColor: 'text-sky-400'
                }
            };

            const config = configs[type] || configs.info;

            const toast = document.createElement('div');
            toast.className =
                'pointer-events-auto w-full max-w-sm overflow-hidden rounded-xl bg-slate-900 border border-slate-800 shadow-xl ring-1 ring-black ring-opacity-5 transition-all duration-300 transform translate-y-2 opacity-0 sm:translate-y-0 sm:translate-x-2';

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
                toast.classList.remove('translate-y-2', 'sm:translate-x-2', 'opacity-0');
                toast.classList.add('translate-y-0', 'sm:translate-x-0', 'opacity-100');
            });

            setTimeout(() => {
                toast.classList.remove('translate-y-0', 'sm:translate-x-0', 'opacity-100');
                toast.classList.add('translate-y-2', 'sm:translate-x-2', 'opacity-0');
                toast.addEventListener('transitionend', () => toast.remove());
            }, duration);
        }
    };

    document.addEventListener('DOMContentLoaded', () => {

        const sessionMessage = "Test Message"; // Inject backend message key value here
        const sessionType = "success"; // Inject backend success key value here

        if (sessionMessage && sessionMessage.trim() !== "") {
            ToastEngine.show(sessionMessage, sessionType);
        }
    });



    /**
     * Toggles Parent-Child Submenus inside the Sidebar view
     * @param {HTMLElement} element - The parent menu trigger button
     */
    function toggleSubmenu(element) {
        const container = element.nextElementSibling;
        const chevron = element.querySelector('.submenu-chevron');

        if (container && container.classList.contains('hidden')) {
            container.classList.remove('hidden');
            if (chevron) chevron.classList.add('rotate-180');
        } else if (container) {
            container.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
        }
    }
</script>
