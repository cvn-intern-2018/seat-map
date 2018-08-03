

var loadFile = function (event) {
    var output = document.getElementById('img-preview');
    output.src = URL.createObjectURL(event.target.files[0]);
};
