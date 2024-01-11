(window["webpackJsonp"] = window["webpackJsonp"] || []).push([["ninja-forms"],{

/***/ "../src/modules/ninja-forms/ninja-forms.core.js":
/*!******************************************************!*\
  !*** ../src/modules/ninja-forms/ninja-forms.core.js ***!
  \******************************************************/
/*! exports provided: run */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, \"run\", function() { return run; });\nfunction _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError(\"Cannot call a class as a function\"); } }\n\nfunction _defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if (\"value\" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } }\n\nfunction _createClass(Constructor, protoProps, staticProps) { if (protoProps) _defineProperties(Constructor.prototype, protoProps); if (staticProps) _defineProperties(Constructor, staticProps); Object.defineProperty(Constructor, \"prototype\", { writable: false }); return Constructor; }\n\nvar run = function run(opts) {\n  new NFModifier(opts);\n};\n\nvar NFModifier = /*#__PURE__*/function () {\n  function NFModifier(props) {\n    _classCallCheck(this, NFModifier);\n\n    _.defaults(props, {\n      classesToMoveOnNFField: null,\n      countryListWrapFixSelector: '.listcountry-wrap.list-wrap' // For some reason, the default country dropdown is missing a class and looks different\n\n    });\n\n    this.opts = props;\n    this.moveClassesToNFField();\n    this.fixCountry();\n  }\n\n  _createClass(NFModifier, [{\n    key: \"moveClassesToNFField\",\n    value: function moveClassesToNFField() {\n      if (this.opts.classesToMoveOnNFField) {\n        this.opts.classesToMoveOnNFField.forEach(function (className, idx) {\n          $('nf-field').each(function () {\n            if ($('.' + className, $(this)).length) {\n              $(this).addClass(className);\n            }\n          });\n        });\n      }\n    }\n  }, {\n    key: \"fixCountry\",\n    value: function fixCountry() {\n      if (this.opts.countryListWrapFixSelector) {\n        $(this.opts.countryListWrapFixSelector).addClass('list-select-wrap');\n      }\n    }\n  }]);\n\n  return NFModifier;\n}();\n\n//# sourceURL=webpack:///../src/modules/ninja-forms/ninja-forms.core.js?");

/***/ })

}]);