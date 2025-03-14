const sidebarMenu = document.getElementById("sidebar-menu");
const menuNavbarButton = document.getElementById("navbar-menu-button");

menuNavbarButton.addEventListener("click", () => {
    sidebarMenu.classList.add("active-sidebar")
});

document.addEventListener("click", (e) => {
    if (!sidebarMenu.contains(e.target) && !menuNavbarButton.contains(e.target)) {
        sidebarMenu.classList.remove("active-sidebar");
    }
})

window.addEventListener("resize", (e) => {
    const width = window.innerWidth;
    if (width > 720) {
        sidebarMenu.classList.remove("active-sidebar")
    }
})