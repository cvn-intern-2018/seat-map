var modal = document.getElementById('id01');


//
$('.delete-button').on('click', function () {
    var id = $(this).data('id');
    var name = $('#seatmap-name-'+id).html()
    $('#deleteID').val(id);
    $('#deleteName').val(name);
    if (confirm('Are you sure that you want to delete "' + name + '"??')) {

        $('#frmDeleteSM').submit();
    }
});

var loadFile = function(event) {
    var output = document.getElementById('img-preview');
    output.src = URL.createObjectURL(event.target.files[0]);
};
