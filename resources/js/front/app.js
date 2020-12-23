require("bootstrap/dist/js/bootstrap.bundle");

const burger = document.getElementById("burger");
burger.addEventListener("click", function() {
	const sidebar = document.getElementsByClassName("sidebar")[0];
	const overlay = document.getElementsByClassName("sidebar-overlay")[0];

	sidebar.classList.toggle("sidebar-active");
	overlay.classList.toggle("sidebar-active");
})