/******/ (function(modules) { // webpackBootstrap
/******/ 	// The module cache
/******/ 	var installedModules = {};
/******/
/******/ 	// The require function
/******/ 	function __webpack_require__(moduleId) {
/******/
/******/ 		// Check if module is in cache
/******/ 		if(installedModules[moduleId]) {
/******/ 			return installedModules[moduleId].exports;
/******/ 		}
/******/ 		// Create a new module (and put it into the cache)
/******/ 		var module = installedModules[moduleId] = {
/******/ 			i: moduleId,
/******/ 			l: false,
/******/ 			exports: {}
/******/ 		};
/******/
/******/ 		// Execute the module function
/******/ 		modules[moduleId].call(module.exports, module, module.exports, __webpack_require__);
/******/
/******/ 		// Flag the module as loaded
/******/ 		module.l = true;
/******/
/******/ 		// Return the exports of the module
/******/ 		return module.exports;
/******/ 	}
/******/
/******/
/******/ 	// expose the modules object (__webpack_modules__)
/******/ 	__webpack_require__.m = modules;
/******/
/******/ 	// expose the module cache
/******/ 	__webpack_require__.c = installedModules;
/******/
/******/ 	// define getter function for harmony exports
/******/ 	__webpack_require__.d = function(exports, name, getter) {
/******/ 		if(!__webpack_require__.o(exports, name)) {
/******/ 			Object.defineProperty(exports, name, { enumerable: true, get: getter });
/******/ 		}
/******/ 	};
/******/
/******/ 	// define __esModule on exports
/******/ 	__webpack_require__.r = function(exports) {
/******/ 		if(typeof Symbol !== 'undefined' && Symbol.toStringTag) {
/******/ 			Object.defineProperty(exports, Symbol.toStringTag, { value: 'Module' });
/******/ 		}
/******/ 		Object.defineProperty(exports, '__esModule', { value: true });
/******/ 	};
/******/
/******/ 	// create a fake namespace object
/******/ 	// mode & 1: value is a module id, require it
/******/ 	// mode & 2: merge all properties of value into the ns
/******/ 	// mode & 4: return value when already ns object
/******/ 	// mode & 8|1: behave like require
/******/ 	__webpack_require__.t = function(value, mode) {
/******/ 		if(mode & 1) value = __webpack_require__(value);
/******/ 		if(mode & 8) return value;
/******/ 		if((mode & 4) && typeof value === 'object' && value && value.__esModule) return value;
/******/ 		var ns = Object.create(null);
/******/ 		__webpack_require__.r(ns);
/******/ 		Object.defineProperty(ns, 'default', { enumerable: true, value: value });
/******/ 		if(mode & 2 && typeof value != 'string') for(var key in value) __webpack_require__.d(ns, key, function(key) { return value[key]; }.bind(null, key));
/******/ 		return ns;
/******/ 	};
/******/
/******/ 	// getDefaultExport function for compatibility with non-harmony modules
/******/ 	__webpack_require__.n = function(module) {
/******/ 		var getter = module && module.__esModule ?
/******/ 			function getDefault() { return module['default']; } :
/******/ 			function getModuleExports() { return module; };
/******/ 		__webpack_require__.d(getter, 'a', getter);
/******/ 		return getter;
/******/ 	};
/******/
/******/ 	// Object.prototype.hasOwnProperty.call
/******/ 	__webpack_require__.o = function(object, property) { return Object.prototype.hasOwnProperty.call(object, property); };
/******/
/******/ 	// __webpack_public_path__
/******/ 	__webpack_require__.p = "/";
/******/
/******/
/******/ 	// Load entry module and return exports
/******/ 	return __webpack_require__(__webpack_require__.s = 6);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/main.js":
/*!****************************************!*\
  !*** ./resources/js/dashboard/main.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciJdLCJtYXBwaW5ncyI6IkFBQUE7QUFBQSxTQUFTQSxVQUFULENBQXFCQyxJQUFyQixFQUEyQkMsT0FBM0IsRUFBcUM7QUFDcENDLE1BQUksQ0FBQ0MsSUFBTCxDQUFVO0FBQ1JDLFNBQUssRUFBRSxNQURDO0FBRVJDLFlBQVEsRUFBRSxTQUZGO0FBR1JMLFFBQUksRUFBRUEsSUFIRTtBQUlSTSxTQUFLLEVBQUVMLE9BSkM7QUFLUk0scUJBQWlCLEVBQUUsS0FMWDtBQU1SQyxTQUFLLEVBQUUsSUFOQztBQU9OQyxvQkFBZ0IsRUFBRTtBQVBaLEdBQVY7QUFTQTs7QUFFRCxTQUFTQyxvQkFBVCxDQUErQkMsSUFBL0IsRUFBcUNDLEtBQXJDLEVBQTRDO0FBRTNDLE9BQU0sSUFBSUMsQ0FBQyxHQUFHLENBQWQsRUFBaUJBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUEzQixFQUFtQ0QsQ0FBQyxFQUFwQyxFQUF5QztBQUN4QyxRQUFLLENBQUNELEtBQUssQ0FBQ0MsQ0FBRCxDQUFMLENBQVNFLE9BQWYsRUFBeUI7QUFDeEJKLFVBQUksQ0FBQ0ksT0FBTCxHQUFlLEtBQWY7QUFDQTtBQUNBLEtBSEQsTUFJSztBQUNKSixVQUFJLENBQUNJLE9BQUwsR0FBZSxJQUFmO0FBQ0E7QUFDRDtBQUVEOztBQUVELFNBQVNDLHFCQUFULENBQWdDTCxJQUFoQyxFQUFzQ0MsS0FBdEMsRUFBOEM7QUFFN0MsTUFBS0QsSUFBSSxDQUFDSSxPQUFWLEVBQW9CO0FBQ25CLFNBQU0sSUFBSUYsQ0FBQyxHQUFHLENBQWQsRUFBaUJBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUEzQixFQUFtQ0QsQ0FBQyxFQUFwQyxFQUF5QztBQUN4Q0QsV0FBSyxDQUFDQyxDQUFELENBQUwsQ0FBU0UsT0FBVCxHQUFtQixJQUFuQjtBQUNBO0FBQ0QsR0FKRCxNQUtLO0FBQ0osU0FBTSxJQUFJRixFQUFDLEdBQUcsQ0FBZCxFQUFpQkEsRUFBQyxHQUFHRCxLQUFLLENBQUNFLE1BQTNCLEVBQW1DRCxFQUFDLEVBQXBDLEVBQXlDO0FBQ3hDRCxXQUFLLENBQUNDLEVBQUQsQ0FBTCxDQUFTRSxPQUFULEdBQW1CLEtBQW5CO0FBQ0E7QUFDRDtBQUVEOztBQUVjO0FBQ2RoQixZQUFVLEVBQVZBLFVBRGM7QUFFZFcsc0JBQW9CLEVBQXBCQSxvQkFGYztBQUdkTSx1QkFBcUIsRUFBckJBO0FBSGMsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoIGljb24sIG1lc3NhZ2UgKSB7XHJcblx0U3dhbC5maXJlKHtcclxuXHRcdFx0dG9hc3Q6ICd0cnVlJyxcclxuXHRcdFx0cG9zaXRpb246ICd0b3AtZW5kJyxcclxuXHRcdFx0aWNvbjogaWNvbixcclxuXHRcdFx0dGl0bGU6IG1lc3NhZ2UsXHJcblx0XHRcdHNob3dDb25maXJtQnV0dG9uOiBmYWxzZSxcclxuXHRcdFx0dGltZXI6IDMwMDAsXHJcblx0XHRcdCAgdGltZXJQcm9ncmVzc0JhcjogdHJ1ZVxyXG5cdFx0fSk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKCBtYWluLCBtaW5vcikge1xyXG5cclxuXHRmb3IgKCBsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKyApIHtcclxuXHRcdGlmICggIW1pbm9yW2ldLmNoZWNrZWQgKSB7XHJcblx0XHRcdG1haW4uY2hlY2tlZCA9IGZhbHNlO1xyXG5cdFx0XHRicmVhaztcclxuXHRcdH1cclxuXHRcdGVsc2Uge1xyXG5cdFx0XHRtYWluLmNoZWNrZWQgPSB0cnVlO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcbn1cclxuXHJcbmZ1bmN0aW9uIG1pbm9yQ2hlY2tib3hTd2l0Y2hlciggbWFpbiwgbWlub3IgKSB7XHJcblxyXG5cdGlmICggbWFpbi5jaGVja2VkICkge1xyXG5cdFx0Zm9yICggbGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKysgKSB7XHJcblx0XHRcdG1pbm9yW2ldLmNoZWNrZWQgPSB0cnVlO1xyXG5cdFx0fVxyXG5cdH1cclxuXHRlbHNlIHtcclxuXHRcdGZvciAoIGxldCBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrICkge1xyXG5cdFx0XHRtaW5vcltpXS5jaGVja2VkID0gZmFsc2U7XHJcblx0XHR9XHJcblx0fVxyXG5cclxufVxyXG5cclxuZXhwb3J0IGRlZmF1bHQge1xyXG5cdHRvYXN0QWxlcnQsXHJcblx0bWFpbkNoZWNrYm94U3dpdGNoZXIsXHJcblx0bWlub3JDaGVja2JveFN3aXRjaGVyXHJcbn0iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 6:
/*!**********************************************!*\
  !*** multi ./resources/js/dashboard/main.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\Real Projects\Demo LMS\resources\js\dashboard\main.js */"./resources/js/dashboard/main.js");


/***/ })

/******/ });