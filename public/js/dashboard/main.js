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
/******/ 	return __webpack_require__(__webpack_require__.s = 9);
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
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().prependTo('#containerCol');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar selectAndDeselectCheckbox = function selectAndDeselectCheckbox(attr) {\n  $(attr).click(function () {\n    var checkbox = $(attr);\n\n    for (var i = 0; i < checkbox.length; i++) {\n      checkbox[i].checked = !checkbox[i].checked;\n    }\n\n    if (this.checked) {\n      this.innerHTML = '<i class=\" h3 mdi mdi-checkbox-multiple-blank-outline\"></i>';\n    } else {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-marked-outline\"></i>\\n';\n    }\n  });\n};\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  selectAndDeselectCheckbox: selectAndDeselectCheckbox\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciIsImZpbHRlckJ1dHRvbiIsImF0dHIiLCJjb2x1bW4iLCJ0YWJsZSIsIiQiLCJkZXRhY2giLCJwcmVwZW5kVG8iLCJvbiIsImNvbHVtbnMiLCJzZWFyY2giLCJ2YWx1ZSIsImRyYXciLCJzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94IiwiY2xpY2siLCJjaGVja2JveCIsImlubmVySFRNTCJdLCJtYXBwaW5ncyI6IkFBQUE7QUFBQSxTQUFTQSxVQUFULENBQW9CQyxJQUFwQixFQUEwQkMsT0FBMUIsRUFBbUM7QUFDL0JDLE1BQUksQ0FBQ0MsSUFBTCxDQUFVO0FBQ05DLFNBQUssRUFBRSxNQUREO0FBRU5DLFlBQVEsRUFBRSxTQUZKO0FBR05MLFFBQUksRUFBRUEsSUFIQTtBQUlOTSxTQUFLLEVBQUVMLE9BSkQ7QUFLTk0scUJBQWlCLEVBQUUsS0FMYjtBQU1OQyxTQUFLLEVBQUUsSUFORDtBQU9OQyxvQkFBZ0IsRUFBRTtBQVBaLEdBQVY7QUFTSDs7QUFFRCxTQUFTQyxvQkFBVCxDQUE4QkMsSUFBOUIsRUFBb0NDLEtBQXBDLEVBQTJDO0FBRXZDLE9BQUssSUFBSUMsQ0FBQyxHQUFHLENBQWIsRUFBZ0JBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUExQixFQUFrQ0QsQ0FBQyxFQUFuQyxFQUF1QztBQUNuQyxRQUFJLENBQUNELEtBQUssQ0FBQ0MsQ0FBRCxDQUFMLENBQVNFLE9BQWQsRUFBdUI7QUFDbkJKLFVBQUksQ0FBQ0ksT0FBTCxHQUFlLEtBQWY7QUFDQTtBQUNILEtBSEQsTUFHTztBQUNISixVQUFJLENBQUNJLE9BQUwsR0FBZSxJQUFmO0FBQ0g7QUFDSjtBQUVKOztBQUVELFNBQVNDLHFCQUFULENBQStCTCxJQUEvQixFQUFxQ0MsS0FBckMsRUFBNEM7QUFFeEMsTUFBSUQsSUFBSSxDQUFDSSxPQUFULEVBQWtCO0FBQ2QsU0FBSyxJQUFJRixDQUFDLEdBQUcsQ0FBYixFQUFnQkEsQ0FBQyxHQUFHRCxLQUFLLENBQUNFLE1BQTFCLEVBQWtDRCxDQUFDLEVBQW5DLEVBQXVDO0FBQ25DRCxXQUFLLENBQUNDLENBQUQsQ0FBTCxDQUFTRSxPQUFULEdBQW1CLElBQW5CO0FBQ0g7QUFDSixHQUpELE1BSU87QUFDSCxTQUFLLElBQUlGLEVBQUMsR0FBRyxDQUFiLEVBQWdCQSxFQUFDLEdBQUdELEtBQUssQ0FBQ0UsTUFBMUIsRUFBa0NELEVBQUMsRUFBbkMsRUFBdUM7QUFDbkNELFdBQUssQ0FBQ0MsRUFBRCxDQUFMLENBQVNFLE9BQVQsR0FBbUIsS0FBbkI7QUFDSDtBQUNKO0FBRUo7O0FBRUQsSUFBTUUsWUFBWSxHQUFHLFNBQWZBLFlBQWUsQ0FBVUMsSUFBVixFQUFnQkMsTUFBaEIsRUFBd0JDLEtBQXhCLEVBQStCO0FBQ2hEQyxHQUFDLENBQUNILElBQUQsQ0FBRCxDQUFRSSxNQUFSLEdBQWlCQyxTQUFqQixDQUEyQixlQUEzQjtBQUdBRixHQUFDLENBQUNILElBQUQsQ0FBRCxDQUFRTSxFQUFSLENBQVcsUUFBWCxFQUFxQixZQUFZO0FBQzdCSixTQUFLLENBQUNLLE9BQU4sQ0FBY04sTUFBZCxFQUFzQk8sTUFBdEIsQ0FBNkIsS0FBS0MsS0FBbEMsRUFBeUNDLElBQXpDO0FBQ0gsR0FGRDtBQUdILENBUEQ7O0FBU0EsSUFBTUMseUJBQXlCLEdBQUcsU0FBNUJBLHlCQUE0QixDQUFVWCxJQUFWLEVBQWdCO0FBQzlDRyxHQUFDLENBQUNILElBQUQsQ0FBRCxDQUFRWSxLQUFSLENBQWMsWUFBWTtBQUN0QixRQUFJQyxRQUFRLEdBQUdWLENBQUMsQ0FBQ0gsSUFBRCxDQUFoQjs7QUFFQSxTQUFLLElBQUlMLENBQUMsR0FBRyxDQUFiLEVBQWdCQSxDQUFDLEdBQUdrQixRQUFRLENBQUNqQixNQUE3QixFQUFxQ0QsQ0FBQyxFQUF0QyxFQUEwQztBQUN0Q2tCLGNBQVEsQ0FBQ2xCLENBQUQsQ0FBUixDQUFZRSxPQUFaLEdBQXNCLENBQUNnQixRQUFRLENBQUNsQixDQUFELENBQVIsQ0FBWUUsT0FBbkM7QUFDSDs7QUFFRCxRQUFJLEtBQUtBLE9BQVQsRUFBa0I7QUFDZCxXQUFLaUIsU0FBTCxHQUFpQiw2REFBakI7QUFDSCxLQUZELE1BRU87QUFDSCxXQUFLQSxTQUFMLEdBQWlCLHNEQUFqQjtBQUNIO0FBQ0osR0FaRDtBQWFILENBZEQ7O0FBaUJlO0FBQ1hqQyxZQUFVLEVBQVZBLFVBRFc7QUFFWFcsc0JBQW9CLEVBQXBCQSxvQkFGVztBQUdYTSx1QkFBcUIsRUFBckJBLHFCQUhXO0FBSVhDLGNBQVksRUFBWkEsWUFKVztBQUtYWSwyQkFBeUIsRUFBekJBO0FBTFcsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xuICAgIFN3YWwuZmlyZSh7XG4gICAgICAgIHRvYXN0OiAndHJ1ZScsXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXG4gICAgICAgIGljb246IGljb24sXG4gICAgICAgIHRpdGxlOiBtZXNzYWdlLFxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXG4gICAgICAgIHRpbWVyOiAzMDAwLFxuICAgICAgICB0aW1lclByb2dyZXNzQmFyOiB0cnVlXG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIGlmICghbWlub3JbaV0uY2hlY2tlZCkge1xuICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gZmFsc2U7XG4gICAgICAgICAgICBicmVhaztcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIG1haW4uY2hlY2tlZCA9IHRydWU7XG4gICAgICAgIH1cbiAgICB9XG5cbn1cblxuZnVuY3Rpb24gbWlub3JDaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBpZiAobWFpbi5jaGVja2VkKSB7XG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIG1pbm9yW2ldLmNoZWNrZWQgPSB0cnVlO1xuICAgICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgbWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xuICAgICAgICB9XG4gICAgfVxuXG59XG5cbmNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XG4gICAgJChhdHRyKS5kZXRhY2goKS5wcmVwZW5kVG8oJyNjb250YWluZXJDb2wnKVxuXG5cbiAgICAkKGF0dHIpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHRhYmxlLmNvbHVtbnMoY29sdW1uKS5zZWFyY2godGhpcy52YWx1ZSkuZHJhdygpO1xuICAgIH0pO1xufVxuXG5jb25zdCBzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94ID0gZnVuY3Rpb24gKGF0dHIpIHtcbiAgICAkKGF0dHIpLmNsaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgbGV0IGNoZWNrYm94ID0gJChhdHRyKVxuXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSAhY2hlY2tib3hbaV0uY2hlY2tlZFxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHRoaXMuY2hlY2tlZCkge1xuICAgICAgICAgICAgdGhpcy5pbm5lckhUTUwgPSAnPGkgY2xhc3M9XCIgaDMgbWRpIG1kaS1jaGVja2JveC1tdWx0aXBsZS1ibGFuay1vdXRsaW5lXCI+PC9pPidcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIHRoaXMuaW5uZXJIVE1MID0gJzxpIGNsYXNzPVwiaDMgbWRpIG1kaS1jaGVja2JveC1tYXJrZWQtb3V0bGluZVwiPjwvaT5cXG4nXG4gICAgICAgIH1cbiAgICB9KVxufVxuXG5cbmV4cG9ydCBkZWZhdWx0IHtcbiAgICB0b2FzdEFsZXJ0LFxuICAgIG1haW5DaGVja2JveFN3aXRjaGVyLFxuICAgIG1pbm9yQ2hlY2tib3hTd2l0Y2hlcixcbiAgICBmaWx0ZXJCdXR0b24sXG4gICAgc2VsZWN0QW5kRGVzZWxlY3RDaGVja2JveFxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 9:
/*!**********************************************!*\
  !*** multi ./resources/js/dashboard/main.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\lmsdemo\resources\js\dashboard\main.js */"./resources/js/dashboard/main.js");


/***/ })

/******/ });