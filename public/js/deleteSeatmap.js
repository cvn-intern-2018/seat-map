$('#delete-confirm').on('click', function () {

    $('#deleteID').val($(this).data('id'));
    $('#deleteName').val($(this).data('name'));
    $('#frmDeleteSM').submit();
});
$(document).on("click", ".delete-seatmap", function () {
    document.querySelector("#delete-confirm").dataset.id = this.dataset.id;
    document.querySelector("#delete-confirm").dataset.name = this.dataset.name;
    document.querySelector("#delete-name").innerHTML = this.dataset.name;

});