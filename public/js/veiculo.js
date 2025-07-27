// Evento de clique no botão editar
$(function () {
    $(document).on("click", ".btn-editar-veiculos", function () {
        const id = $(this).data("id");
        window.location.href = `/veiculos/edit/${id}`;
    });
})

// Evento de clique no botão excluir
$(function () {

    let idToDelete = null;

    $(document).on("click", ".btn-deletar-veiculos", function () {
        idToDelete = $(this).data("id");
        console.log("ID do veículo a ser excluído:", idToDelete);
        $("#confirmDeleteModal").modal("show");
    });

    $("#confirmDeleteBtn").on("click", function () {
        if (!idToDelete) return;

        $("#confirmDeleteModal").modal("hide");

        const form = document.getElementById('form-excluir-veiculos');
        form.action = `/veiculos/delete/${idToDelete}`;
        form.submit();

    });
})

//Evento de clique no botão visualizar
$(function () {
    $(document).on("click", ".btn-ver-veiculos", function () {
        const id = $(this).data("id");
        window.location.href = `/veiculos/show/${id}`;
    });
})
