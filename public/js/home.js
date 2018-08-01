var modal = document.getElementById('id01');



$('#delete-confirm').on('click', function () {

    $('#deleteID').val($(this).data('id'));
    $('#deleteName').val($(this).data('name'));
    $('#frmDeleteSM').submit();
});

var loadFile = function (event) {
    var output = document.getElementById('img-preview');
    output.src = URL.createObjectURL(event.target.files[0]);
};
