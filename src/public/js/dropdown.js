var dropdown = document.getElementById("dropdown");
var dropIcon = document.querySelector(".drop-icon");

document.addEventListener("click", function (event) {

    if (!dropdown.contains(event.target) && !dropIcon.contains(event.target)) {
        dropdown.style.display = "none";
        dropdown.style.opacity = "0";
    }
});

function toggleDropdown() {
    var dropdown = document.getElementById("dropdown");
    dropdown.style.display = (dropdown.style.display === "block") ? "none" : "block";
    dropdown.style.opacity = (dropdown.style.opacity === "1") ? "0" : "1";
}

dropIcon.addEventListener("click", function (event) {
    // Impedir a propagação do evento para evitar interferência com os diálogos
    event.stopPropagation();
    toggleDropdown();
});