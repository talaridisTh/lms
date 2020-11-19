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

eval("var optionId = document.getElementById(\"page-title\").dataset.optionId;\nvar editor = ace.edit(\"editor\");\neditor.setTheme(\"ace/theme/monokai\");\neditor.session.setMode(\"ace/mode/javascript\");\nvar updateBtn = document.getElementById(\"update-btn\");\nupdateBtn.addEventListener(\"click\", function () {\n  var value = editor.getValue(); // console.log(JSON.stringify(value));\n\n  jsonUpdate(value);\n});\n\nfunction jsonUpdate(value) {\n  axios.post(\"/dashboard/dev-tools/\".concat(optionId, \"/update\"), {\n    value: value\n  }).then(function (res) {\n    console.log(res);\n  })[\"catch\"](function (err) {\n    console.log(err);\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL3NldHRpbmdzL29wdGlvbnMuanM/MTZiNyJdLCJuYW1lcyI6WyJvcHRpb25JZCIsImRvY3VtZW50IiwiZ2V0RWxlbWVudEJ5SWQiLCJkYXRhc2V0IiwiZWRpdG9yIiwiYWNlIiwiZWRpdCIsInNldFRoZW1lIiwic2Vzc2lvbiIsInNldE1vZGUiLCJ1cGRhdGVCdG4iLCJhZGRFdmVudExpc3RlbmVyIiwidmFsdWUiLCJnZXRWYWx1ZSIsImpzb25VcGRhdGUiLCJheGlvcyIsInBvc3QiLCJ0aGVuIiwicmVzIiwiY29uc29sZSIsImxvZyIsImVyciJdLCJtYXBwaW5ncyI6IkFBQUEsSUFBTUEsUUFBUSxHQUFHQyxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsWUFBeEIsRUFBc0NDLE9BQXRDLENBQThDSCxRQUEvRDtBQUVBLElBQU1JLE1BQU0sR0FBR0MsR0FBRyxDQUFDQyxJQUFKLENBQVMsUUFBVCxDQUFmO0FBQ0FGLE1BQU0sQ0FBQ0csUUFBUCxDQUFnQixtQkFBaEI7QUFDQUgsTUFBTSxDQUFDSSxPQUFQLENBQWVDLE9BQWYsQ0FBdUIscUJBQXZCO0FBRUEsSUFBTUMsU0FBUyxHQUFHVCxRQUFRLENBQUNDLGNBQVQsQ0FBd0IsWUFBeEIsQ0FBbEI7QUFDQVEsU0FBUyxDQUFDQyxnQkFBVixDQUEyQixPQUEzQixFQUFvQyxZQUFXO0FBQzlDLE1BQU1DLEtBQUssR0FBR1IsTUFBTSxDQUFDUyxRQUFQLEVBQWQsQ0FEOEMsQ0FHOUM7O0FBQ0FDLFlBQVUsQ0FBQ0YsS0FBRCxDQUFWO0FBQ0EsQ0FMRDs7QUFPQSxTQUFTRSxVQUFULENBQW9CRixLQUFwQixFQUEyQjtBQUUxQkcsT0FBSyxDQUFDQyxJQUFOLGdDQUFtQ2hCLFFBQW5DLGNBQXNEO0FBQUNZLFNBQUssRUFBRUE7QUFBUixHQUF0RCxFQUNDSyxJQURELENBQ08sVUFBQUMsR0FBRyxFQUFJO0FBQ2JDLFdBQU8sQ0FBQ0MsR0FBUixDQUFZRixHQUFaO0FBQ0EsR0FIRCxXQUlTLFVBQUFHLEdBQUcsRUFBSTtBQUNmRixXQUFPLENBQUNDLEdBQVIsQ0FBWUMsR0FBWjtBQUNBLEdBTkQ7QUFPQSIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvc2V0dGluZ3Mvb3B0aW9ucy5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImNvbnN0IG9wdGlvbklkID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJwYWdlLXRpdGxlXCIpLmRhdGFzZXQub3B0aW9uSWQ7XHJcblxyXG5jb25zdCBlZGl0b3IgPSBhY2UuZWRpdChcImVkaXRvclwiKTtcclxuZWRpdG9yLnNldFRoZW1lKFwiYWNlL3RoZW1lL21vbm9rYWlcIik7XHJcbmVkaXRvci5zZXNzaW9uLnNldE1vZGUoXCJhY2UvbW9kZS9qYXZhc2NyaXB0XCIpO1xyXG5cclxuY29uc3QgdXBkYXRlQnRuID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoXCJ1cGRhdGUtYnRuXCIpO1xyXG51cGRhdGVCdG4uYWRkRXZlbnRMaXN0ZW5lcihcImNsaWNrXCIsIGZ1bmN0aW9uKCkge1xyXG5cdGNvbnN0IHZhbHVlID0gZWRpdG9yLmdldFZhbHVlKCk7XHJcblxyXG5cdC8vIGNvbnNvbGUubG9nKEpTT04uc3RyaW5naWZ5KHZhbHVlKSk7XHJcblx0anNvblVwZGF0ZSh2YWx1ZSk7XHJcbn0pXHJcblxyXG5mdW5jdGlvbiBqc29uVXBkYXRlKHZhbHVlKSB7XHJcblxyXG5cdGF4aW9zLnBvc3QoYC9kYXNoYm9hcmQvZGV2LXRvb2xzLyR7b3B0aW9uSWR9L3VwZGF0ZWAsIHt2YWx1ZTogdmFsdWV9KVxyXG5cdC50aGVuKCByZXMgPT4ge1xyXG5cdFx0Y29uc29sZS5sb2cocmVzKTtcclxuXHR9KVxyXG5cdC5jYXRjaCAoIGVyciA9PiB7XHJcblx0XHRjb25zb2xlLmxvZyhlcnIpO1xyXG5cdH0pXHJcbn0iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/dashboard/settings/options.js\n");

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