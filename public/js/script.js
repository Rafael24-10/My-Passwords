document.getElementById("form").addEventListener("submit", function() {

    location.reload();
});

function confirmDelete(passwordName) {
var confirmation = confirm("Are you sure you want to delete this password?");
if (confirmation) {
    window.location.href = '../controller/password_delete.php?name=' + encodeURIComponent(passwordName);
}
}