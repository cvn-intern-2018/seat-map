document.addEventListener("DOMContentLoaded", function($){
    var fixedThreshold = 0;
    var control_panel = {}
    control_panel.el = document.querySelector("section.control-panel");
    window.addEventListener("load", function(){
        fixedThreshold = control_panel.el.offsetTop;
        control_panel.style = window.getComputedStyle(control_panel.el);
        control_panel.outerHeight = control_panel.el.clientHeight;
        control_panel.style.marginTop !== "" && (control_panel.outerHeight += parseInt(control_panel.style.marginTop));
        control_panel.style.marginBottom !== "" && (control_panel.outerHeight += parseInt(control_panel.style.marginBottom));
        console.log(fixedThreshold);
    });

    window.addEventListener('wheel', function(e){
        if (e.deltaY > 0) {
            console.log(window.pageYOffset);
            if ( window.pageYOffset >= fixedThreshold ) {
                if ( !control_panel.el.classList.contains("fixed") ) {
                    control_panel.el.classList.add("fixed");
                    control_panel.el.nextElementSibling.style.marginTop = control_panel.outerHeight + "px";
                }
            }
        }
        else {
            if ( window.pageYOffset <= fixedThreshold ) {
                if ( control_panel.el.classList.contains("fixed") ) {
                    control_panel.el.classList.remove("fixed");
                    control_panel.el.nextElementSibling.style.marginTop = "";
                }
            }
        }
    });
});