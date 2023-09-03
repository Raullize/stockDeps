const navbarToggle = document.querySelector(".navbar-toggler");
const navbarCollapse = document.querySelector("#navbarSupportedContent");

navbarToggle.addEventListener("click", () => {
  navbarCollapse.classList.toggle("show");
  navbarCollapse.style.float = "right";
});