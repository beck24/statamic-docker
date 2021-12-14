/******/ (() => { // webpackBootstrap
var __webpack_exports__ = {};
/*!***********************************!*\
  !*** ./resources/js/accordion.js ***!
  \***********************************/
(function () {
  var triggers = document.querySelectorAll('.ac-trigger');
  triggers.forEach(function (t) {
    t.addEventListener('click', function () {
      var accordian = t.closest('.accordion-container');
      var accordians = accordian.querySelectorAll('.ac');
      accordians.forEach(function (ac) {
        var panel = ac.querySelector('.ac-panel');

        if (ac.contains(t)) {
          ac.classList.toggle('is-active');

          if (panel.style.maxHeight) {
            panel.style.maxHeight = null;
          } else {
            panel.style.maxHeight = panel.scrollHeight + "px";
          }
        } else {
          ac.classList.remove('is-active');
          panel.style.maxHeight = null;
        }
      });
    });
  });
})();
/******/ })()
;