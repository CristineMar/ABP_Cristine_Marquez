let deleteModal = document.getElementById("deleteModal");
deleteModal.addEventListener("show.bs.modal", function (event) {
    let button = event.relatedTarget;
    let siglas = button.getAttribute("data-bs-siglas");
    let action = button.getAttribute("data-bs-action");

    let modalBodyInput = deleteModal.querySelector(".modal-body");

    deleteModal.querySelector("#myForm").action = action;

    modalBodyInput.innerHTML =
        "Estas segur de que vols esborrar el curs " + siglas + " ?";
});
