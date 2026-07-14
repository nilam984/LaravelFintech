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
      if (!event.target.closest('#notificationMenu') && !event.target.closest('button[onclick="toggleNotificationMenu()"]')) {
        notificationMenu.classList.add("hidden");
      }
      if (!event.target.closest('#profileMenu') && !event.target.closest('button[onclick="toggleProfileMenu()"]')) {
        profileMenu.classList.add("hidden");
      }
    }