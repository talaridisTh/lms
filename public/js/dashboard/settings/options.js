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
/******/ 	return __webpack_require__(__webpack_require__.s = 18);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/settings/options.js":
/*!****************************************************!*\
  !*** ./resources/js/dashboard/settings/options.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

eval("var optionName = document.getElementById(\"page-title\").dataset.optionName;\nvar editor = ace.edit(\"editor\");\neditor.setTheme(\"ace/theme/monokai\");\neditor.session.setMode(\"ace/mode/javascript\");\nvar updateBtn = document.getElementById(\"update-btn\");\nupdateBtn.addEventListener(\"click\", function () {\n  var value = editor.getValue(); // console.log(JSON.stringify(value));\n\n  jsonUpdate(value);\n});\n\nfunction jsonUpdate(value) {\n  axios.post(\"/dashboard/dev-tools/\".concat(optionName, \"/update\"), {\n    value: value\n  }).then(function (res) {\n    console.log(res);\n  })[\"catch\"](function (err) {\n    console.log(err);\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL3NldHRpbmdzL29wdGlvbnMuanM/MTZiNyJdLCJuYW1lcyI6WyJvcHRpb25OYW1lIiwiZG9jdW1lbnQiLCJnZXRFbGVtZW50QnlJZCIsImRhdGFzZXQiLCJlZGl0b3IiLCJhY2UiLCJlZGl0Iiwic2V0VGhlbWUiLCJzZXNzaW9uIiwic2V0TW9kZSIsInVwZGF0ZUJ0biIsImFkZEV2ZW50TGlzdGVuZXIiLCJ2YWx1ZSIsImdldFZhbHVlIiwianNvblVwZGF0ZSIsImF4aW9zIiwicG9zdCIsInRoZW4iLCJyZXMiLCJjb25zb2xlIiwibG9nIiwiZXJyIl0sIm1hcHBpbmdzIjoiQUFBQSxJQUFNQSxVQUFVLEdBQUdDLFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixZQUF4QixFQUFzQ0MsT0FBdEMsQ0FBOENILFVBQWpFO0FBRUEsSUFBTUksTUFBTSxHQUFHQyxHQUFHLENBQUNDLElBQUosQ0FBUyxRQUFULENBQWY7QUFDQUYsTUFBTSxDQUFDRyxRQUFQLENBQWdCLG1CQUFoQjtBQUNBSCxNQUFNLENBQUNJLE9BQVAsQ0FBZUMsT0FBZixDQUF1QixxQkFBdkI7QUFFQSxJQUFNQyxTQUFTLEdBQUdULFFBQVEsQ0FBQ0MsY0FBVCxDQUF3QixZQUF4QixDQUFsQjtBQUNBUSxTQUFTLENBQUNDLGdCQUFWLENBQTJCLE9BQTNCLEVBQW9DLFlBQVc7QUFDOUMsTUFBTUMsS0FBSyxHQUFHUixNQUFNLENBQUNTLFFBQVAsRUFBZCxDQUQ4QyxDQUc5Qzs7QUFDQUMsWUFBVSxDQUFDRixLQUFELENBQVY7QUFDQSxDQUxEOztBQU9BLFNBQVNFLFVBQVQsQ0FBb0JGLEtBQXBCLEVBQTJCO0FBRTFCRyxPQUFLLENBQUNDLElBQU4sZ0NBQW1DaEIsVUFBbkMsY0FBd0Q7QUFBQ1ksU0FBSyxFQUFFQTtBQUFSLEdBQXhELEVBQ0NLLElBREQsQ0FDTyxVQUFBQyxHQUFHLEVBQUk7QUFDYkMsV0FBTyxDQUFDQyxHQUFSLENBQVlGLEdBQVo7QUFDQSxHQUhELFdBSVMsVUFBQUcsR0FBRyxFQUFJO0FBQ2ZGLFdBQU8sQ0FBQ0MsR0FBUixDQUFZQyxHQUFaO0FBQ0EsR0FORDtBQU9BIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2Rhc2hib2FyZC9zZXR0aW5ncy9vcHRpb25zLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiY29uc3Qgb3B0aW9uTmFtZSA9IGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKFwicGFnZS10aXRsZVwiKS5kYXRhc2V0Lm9wdGlvbk5hbWU7XHJcblxyXG5jb25zdCBlZGl0b3IgPSBhY2UuZWRpdChcImVkaXRvclwiKTtcclxuZWRpdG9yLnNldFRoZW1lKFwiYWNlL3RoZW1lL21vbm9rYWlcIik7XHJcbmVkaXRvci5zZXNzaW9uLnNldE1vZGUoXCJhY2UvbW9kZS9qYXZhc2NyaXB0XCIpO1xyXG5cclxuY29uc3QgdXBkYXRlQnRuID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJ1cGRhdGUtYnRuXCIpO1xyXG51cGRhdGVCdG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIGZ1bmN0aW9uKCkge1xyXG5cdGNvbnN0IHZhbHVlID0gZWRpdG9yLmdldFZhbHVlKCk7XHJcblxyXG5cdC8vIGNvbnNvbGUubG9nKEpTT04uc3RyaW5naWZ5KHZhbHVlKSk7XHJcblx0anNvblVwZGF0ZSh2YWx1ZSk7XHJcbn0pXHJcblxyXG5mdW5jdGlvbiBqc29uVXBkYXRlKHZhbHVlKSB7XHJcblxyXG5cdGF4aW9zLnBvc3QoYC9kYXNoYm9hcmQvZGV2LXRvb2xzLyR7b3B0aW9uTmFtZX0vdXBkYXRlYCwge3ZhbHVlOiB2YWx1ZX0pXHJcblx0LnRoZW4oIHJlcyA9PiB7XHJcblx0XHRjb25zb2xlLmxvZyhyZXMpO1xyXG5cdH0pXHJcblx0LmNhdGNoICggZXJyID0+IHtcclxuXHRcdGNvbnNvbGUubG9nKGVycik7XHJcblx0fSlcclxufSJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/dashboard/settings/options.js\n");

/***/ }),

/***/ 18:
/*!**********************************************************!*\
  !*** multi ./resources/js/dashboard/settings/options.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\DarkProjects\Idrogeios\Demo LMS\resources\js\dashboard\settings\options.js */"./resources/js/dashboard/settings/options.js");


/***/ })

/******/ });