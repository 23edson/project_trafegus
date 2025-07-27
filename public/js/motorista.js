// Evento de clique no botão editar
$(function () {
    $(document).on("click", ".btn-editar-motoristas", function () {
        const id = $(this).data("id");
        window.location.href = `/motoristas/edit/${id}`;
    });
})

// Evento de clique no botão excluir
$(function () {

    let idToDelete = null;

    $(document).on("click", ".btn-deletar-motoristas", function () {
        idToDelete = $(this).data("id");
        console.log("ID do motorista a ser excluído:", idToDelete);
        $("#confirmDeleteModal").modal("show");
    });

    $("#confirmDeleteBtn").on("click", function () {
        if (!idToDelete) return;

        $("#confirmDeleteModal").modal("hide");

        const form = document.getElementById('form-excluir-motoristas');
        form.action = `/motoristas/delete/${idToDelete}`;
        form.submit();

    });
})

//Evento de clique no botão visualizar
$(function () {
    $(document).on("click", ".btn-ver-motoristas", function () {
        const id = $(this).data("id");
        window.location.href = `/motoristas/show/${id}`;
    });
})
