document.addEventListener('DOMContentLoaded', function () {
    const showTriggers = document.querySelectorAll(".show-password-trigger");
    const closeButtons = document.querySelectorAll("dialog button");
    const addDialog = document.getElementById("add-dialog");
    const addButton = document.getElementById("add-button");
    const cancelButton = document.getElementById("cancel-btn");

    showTriggers.forEach((trigger) => {
        trigger.addEventListener("click", () => {
            const dialogId = trigger.getAttribute("data-dialog");
            const dialog = document.getElementById(dialogId);
            dialog.showModal();
        });
    });

    closeButtons.forEach((button) => {
        button.addEventListener("click", () => {
            const dialog = button.closest("dialog");
            dialog.close();
        });
    });

    addButton.addEventListener("click", () => {
        addDialog.showModal();
    });

    cancelButton.addEventListener("click", () => {
        addDialog.close();
    });



});
