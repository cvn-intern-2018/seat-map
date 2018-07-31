
var modal = document.getElementById('id01');

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}

  $('.delete-button').on('click', function() {
      $name= $(this).data('name');
   if( confirm('Bạn có chắc rằng bạn muốn xóa seat map này chứ?'))
  {
    var id = $(this).data('id');
    $('#deleteID').val(id);
    $('#frmDeleteID').submit();
  }
});