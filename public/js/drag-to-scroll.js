//
// const slider = document.querySelector('.seatmap-viewport')
// const slider2 = document.querySelector('.seatmap-container')
// let isDown = false;
// let startX;
// let startY;
// let scrollLeft;
// let scrollTop;
//
// slider.addEventListener('mousedown',(e)=>
// {
//
//     isDown = true;
//     startX = e.offsetX ;
//     startY = e.offsetY ;
//     console.log(startX,startY);
//     scrollLeft = slider.scrollLeft;
//     scrollTop= slider.scrollTop;
//
//
// });
// slider.addEventListener('mouseleave',()=>
// {
//     isDown = false;
//
// });
// slider.addEventListener('mouseup',()=>
// {
//     isDown = false;
// });
// slider.addEventListener('mousemove',(e)=>
// {
//     if(!isDown) return;
//     var x = e.offsetX ;
//     const walkX=(x-startX) ;
//     var y = e.offsetY ;
//     const walkY=(y-startY) ;
//     slider.scrollLeft=scrollLeft-walkX;
//     slider.scrollTop=scrollTop-walkY;
//     console.log(scrollLeft);
// });

/**
 * @fileoverview dragscroll - scroll area by dragging
 * @version 0.0.8
 *
 * @license MIT, see http://github.com/asvd/dragscroll
 * @copyright 2015 asvd <heliosframework@gmail.com>
 */


(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        define(['exports'], factory);
    } else if (typeof exports !== 'undefined') {
        factory(exports);
    } else {
        factory((root.dragscroll = {}));
    }
}(this, function (exports) {
    var _window = window;
    var _document = document;
    var mousemove = 'mousemove';
    var mouseup = 'mouseup';
    var mousedown = 'mousedown';
    var EventListener = 'EventListener';
    var addEventListener = 'add' + EventListener;
    var removeEventListener = 'remove' + EventListener;
    var newScrollX, newScrollY;

    var dragged = [];
    var reset = function (i, el) {
        for (i = 0; i < dragged.length;) {
            el = dragged[i++];
            el = el.container || el;
            el[removeEventListener](mousedown, el.md, 0);
            _window[removeEventListener](mouseup, el.mu, 0);
            _window[removeEventListener](mousemove, el.mm, 0);
        }

        // cloning into array since HTMLCollection is updated dynamically
        dragged = [].slice.call(_document.getElementsByClassName('dragscroll'));
        for (i = 0; i < dragged.length;) {
            (function (el, lastClientX, lastClientY, pushed, scroller, cont) {
                (cont = el.container || el)[addEventListener](
                    mousedown,
                    cont.md = function (e) {
                        if ((!el.hasAttribute('nochilddrag') ||
                            _document.elementFromPoint(
                                e.pageX, e.pageY
                            ) == cont) && (!$(e.target).hasClass("avatar-container"))
                        ) {

                            pushed = 1;
                            lastClientX = e.clientX;
                            lastClientY = e.clientY;
                            console.log(e);
                            e.preventDefault();
                        }
                    }, 0
                );

                _window[addEventListener](
                    mouseup, cont.mu = function () {
                        pushed = 0;
                    }, 0
                );

                _window[addEventListener](
                    mousemove,
                    cont.mm = function (e) {
                        if (pushed) {
                            (scroller = el.scroller || el).scrollLeft -=
                                newScrollX = (-lastClientX + (lastClientX = e.clientX));
                            scroller.scrollTop -=
                                newScrollY = (-lastClientY + (lastClientY = e.clientY));
                            if (el == _document.body) {
                                (scroller = _document.documentElement).scrollLeft -= newScrollX;
                                scroller.scrollTop -= newScrollY;
                            }
                        }
                    }, 0
                );
            })(dragged[i++]);
        }
    }


    if (_document.readyState == 'complete') {
        reset();
    } else {
        _window[addEventListener]('load', reset, 0);
    }

    exports.reset = reset;
}));

