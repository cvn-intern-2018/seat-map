var modal = document.getElementById('id01');

window.onclick = function (event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
$(document).on('keyup', function (event) {
    if (event.keyCode == 27) {
        modal.style.display = "none";
    }
});


$('.delete-button').on('click', function () {
    var id = $(this).data('id');
    var name = $('#seatmap-name-'+id).html()
    $('#deleteID').val(id);
    $('#deleteName').val(name);
    if (confirm('Are you sure that you want to delete "' + name + '"??')) {

        $('#frmDeleteSM').submit();
    }
});