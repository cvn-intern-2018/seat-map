var zindex=2;
$('.user-seat').click(
    function () {
        if (this.classList.contains("active")) {
            this.classList.remove("active");
        }
        else {
            this.classList.add("active");
            this.style.zIndex= zindex;
            zindex++;
        }
    }
)

