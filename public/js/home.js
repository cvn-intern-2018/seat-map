
var modal = document.getElementById('id01');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

  $('.delete-button').on('click', function() {
    var id = $(this).data('id');
    $('#deleteID').val(id);
    $('#frmDeleteID').submit();
});