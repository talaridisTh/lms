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
/******/ 	return __webpack_require__(__webpack_require__.s = 10);
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
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().appendTo('.dataTables_length label');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar selectAndDeselectCheckbox = function selectAndDeselectCheckbox(attr) {\n  $(attr).click(function () {\n    var checkbox = $(attr);\n\n    for (var i = 0; i < checkbox.length; i++) {\n      checkbox[i].checked = !checkbox[i].checked;\n    }\n\n    if (this.checked) {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-multiple-blank-outline\"></i>';\n    } else {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-marked-outline\"></i>\\n';\n    }\n\n    if (this.childNodes[0].className == \"h3 mdi mdi-checkbox-multiple-blank-outline\") {\n      for (var _i2 = 0; _i2 < checkbox.length; _i2++) {\n        checkbox[_i2].checked = true;\n      }\n\n      $(\".bulk-action\")[0].hidden = false;\n      var checkboxes = document.querySelectorAll(\".js-user-checkbox:checked\").length;\n      $(\".bulk-action\")[0].innerText = \" \\u0395\\u03C0\\u03B9\\u03BB\\u03BF\\u03B3\\u03AD\\u03C2 \".concat(checkboxes == 0 ? \"\" : \"( \".concat(checkboxes, \" ) \"), \" \");\n    } else {\n      for (var _i3 = 0; _i3 < checkbox.length; _i3++) {\n        checkbox[_i3].checked = false;\n      }\n\n      $(\".bulk-action\")[0].hidden = true;\n    }\n  });\n};\n\nvar changeInputHidden = function changeInputHidden(attr, hiddenAttr) {\n  $(attr).change(function () {\n    if (attr == \"#activeMaterial\") {\n      this.value = $(this).prop('checked') == true ? 1 : 0;\n    }\n\n    console.log($(hiddenAttr));\n    var hiddenValue = $(hiddenAttr)[0].value = this.value;\n  });\n};\n\nvar tableLocale = {\n  emptyTable: \"Δεν υπάρχουν εγγραφές\",\n  info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n  infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n  lengthMenu: \"_MENU_\",\n  loadingRecords: \"Φόρτωση ...\",\n  processing: \"Επεξεργασία ...\",\n  search: \"\",\n  searchPlaceholder: \"Αναζήτηση... \",\n  zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n  paginate: {\n    previous: \"<i class='mdi mdi-chevron-left'>\",\n    next: \"<i class='mdi mdi-chevron-right'>\"\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  selectAndDeselectCheckbox: selectAndDeselectCheckbox,\n  tableLocale: tableLocale,\n  changeInputHidden: changeInputHidden\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciIsImZpbHRlckJ1dHRvbiIsImF0dHIiLCJjb2x1bW4iLCJ0YWJsZSIsIiQiLCJkZXRhY2giLCJhcHBlbmRUbyIsIm9uIiwiY29sdW1ucyIsInNlYXJjaCIsInZhbHVlIiwiZHJhdyIsInNlbGVjdEFuZERlc2VsZWN0Q2hlY2tib3giLCJjbGljayIsImNoZWNrYm94IiwiaW5uZXJIVE1MIiwiY2hpbGROb2RlcyIsImNsYXNzTmFtZSIsImhpZGRlbiIsImNoZWNrYm94ZXMiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJpbm5lclRleHQiLCJjaGFuZ2VJbnB1dEhpZGRlbiIsImhpZGRlbkF0dHIiLCJjaGFuZ2UiLCJwcm9wIiwiY29uc29sZSIsImxvZyIsImhpZGRlblZhbHVlIiwidGFibGVMb2NhbGUiLCJlbXB0eVRhYmxlIiwiaW5mbyIsImluZm9FbXB0eSIsImxlbmd0aE1lbnUiLCJsb2FkaW5nUmVjb3JkcyIsInByb2Nlc3NpbmciLCJzZWFyY2hQbGFjZWhvbGRlciIsInplcm9SZWNvcmRzIiwicGFnaW5hdGUiLCJwcmV2aW91cyIsIm5leHQiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUEsU0FBU0EsVUFBVCxDQUFvQkMsSUFBcEIsRUFBMEJDLE9BQTFCLEVBQW1DO0FBQy9CQyxNQUFJLENBQUNDLElBQUwsQ0FBVTtBQUNOQyxTQUFLLEVBQUUsTUFERDtBQUVOQyxZQUFRLEVBQUUsU0FGSjtBQUdOTCxRQUFJLEVBQUVBLElBSEE7QUFJTk0sU0FBSyxFQUFFTCxPQUpEO0FBS05NLHFCQUFpQixFQUFFLEtBTGI7QUFNTkMsU0FBSyxFQUFFLElBTkQ7QUFPTkMsb0JBQWdCLEVBQUU7QUFQWixHQUFWO0FBU0g7O0FBRUQsU0FBU0Msb0JBQVQsQ0FBOEJDLElBQTlCLEVBQW9DQyxLQUFwQyxFQUEyQztBQUV2QyxPQUFLLElBQUlDLENBQUMsR0FBRyxDQUFiLEVBQWdCQSxDQUFDLEdBQUdELEtBQUssQ0FBQ0UsTUFBMUIsRUFBa0NELENBQUMsRUFBbkMsRUFBdUM7QUFDbkMsUUFBSSxDQUFDRCxLQUFLLENBQUNDLENBQUQsQ0FBTCxDQUFTRSxPQUFkLEVBQXVCO0FBQ25CSixVQUFJLENBQUNJLE9BQUwsR0FBZSxLQUFmO0FBQ0E7QUFDSCxLQUhELE1BR087QUFDSEosVUFBSSxDQUFDSSxPQUFMLEdBQWUsSUFBZjtBQUNIO0FBQ0o7QUFFSjs7QUFFRCxTQUFTQyxxQkFBVCxDQUErQkwsSUFBL0IsRUFBcUNDLEtBQXJDLEVBQTRDO0FBRXhDLE1BQUlELElBQUksQ0FBQ0ksT0FBVCxFQUFrQjtBQUNkLFNBQUssSUFBSUYsQ0FBQyxHQUFHLENBQWIsRUFBZ0JBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUExQixFQUFrQ0QsQ0FBQyxFQUFuQyxFQUF1QztBQUNuQ0QsV0FBSyxDQUFDQyxDQUFELENBQUwsQ0FBU0UsT0FBVCxHQUFtQixJQUFuQjtBQUNIO0FBQ0osR0FKRCxNQUlPO0FBQ0gsU0FBSyxJQUFJRixFQUFDLEdBQUcsQ0FBYixFQUFnQkEsRUFBQyxHQUFHRCxLQUFLLENBQUNFLE1BQTFCLEVBQWtDRCxFQUFDLEVBQW5DLEVBQXVDO0FBQ25DRCxXQUFLLENBQUNDLEVBQUQsQ0FBTCxDQUFTRSxPQUFULEdBQW1CLEtBQW5CO0FBQ0g7QUFDSjtBQUVKOztBQUVELElBQU1FLFlBQVksR0FBRyxTQUFmQSxZQUFlLENBQVVDLElBQVYsRUFBZ0JDLE1BQWhCLEVBQXdCQyxLQUF4QixFQUErQjtBQUNoREMsR0FBQyxDQUFDSCxJQUFELENBQUQsQ0FBUUksTUFBUixHQUFpQkMsUUFBakIsQ0FBMEIsMEJBQTFCO0FBQ0FGLEdBQUMsQ0FBQ0gsSUFBRCxDQUFELENBQVFNLEVBQVIsQ0FBVyxRQUFYLEVBQXFCLFlBQVk7QUFDN0JKLFNBQUssQ0FBQ0ssT0FBTixDQUFjTixNQUFkLEVBQXNCTyxNQUF0QixDQUE2QixLQUFLQyxLQUFsQyxFQUF5Q0MsSUFBekM7QUFDSCxHQUZEO0FBR0gsQ0FMRDs7QUFPQSxJQUFNQyx5QkFBeUIsR0FBRyxTQUE1QkEseUJBQTRCLENBQVVYLElBQVYsRUFBZ0I7QUFDOUNHLEdBQUMsQ0FBQ0gsSUFBRCxDQUFELENBQVFZLEtBQVIsQ0FBYyxZQUFZO0FBQ3RCLFFBQUlDLFFBQVEsR0FBR1YsQ0FBQyxDQUFDSCxJQUFELENBQWhCOztBQUVBLFNBQUssSUFBSUwsQ0FBQyxHQUFHLENBQWIsRUFBZ0JBLENBQUMsR0FBR2tCLFFBQVEsQ0FBQ2pCLE1BQTdCLEVBQXFDRCxDQUFDLEVBQXRDLEVBQTBDO0FBQ3RDa0IsY0FBUSxDQUFDbEIsQ0FBRCxDQUFSLENBQVlFLE9BQVosR0FBc0IsQ0FBQ2dCLFFBQVEsQ0FBQ2xCLENBQUQsQ0FBUixDQUFZRSxPQUFuQztBQUNIOztBQUVELFFBQUksS0FBS0EsT0FBVCxFQUFrQjtBQUVkLFdBQUtpQixTQUFMLEdBQWlCLDREQUFqQjtBQUNILEtBSEQsTUFHTztBQUVILFdBQUtBLFNBQUwsR0FBaUIsc0RBQWpCO0FBQ0g7O0FBRUQsUUFBRyxLQUFLQyxVQUFMLENBQWdCLENBQWhCLEVBQW1CQyxTQUFuQixJQUE4Qiw0Q0FBakMsRUFBOEU7QUFDMUUsV0FBSyxJQUFJckIsR0FBQyxHQUFHLENBQWIsRUFBZ0JBLEdBQUMsR0FBR2tCLFFBQVEsQ0FBQ2pCLE1BQTdCLEVBQXFDRCxHQUFDLEVBQXRDLEVBQTBDO0FBQ3RDa0IsZ0JBQVEsQ0FBQ2xCLEdBQUQsQ0FBUixDQUFZRSxPQUFaLEdBQXNCLElBQXRCO0FBQ0g7O0FBQ0RNLE9BQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0IsQ0FBbEIsRUFBcUJjLE1BQXJCLEdBQThCLEtBQTlCO0FBQ0EsVUFBSUMsVUFBVSxHQUFFQyxRQUFRLENBQUNDLGdCQUFULENBQTBCLDJCQUExQixFQUF1RHhCLE1BQXZFO0FBQ0FPLE9BQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0IsQ0FBbEIsRUFBcUJrQixTQUFyQiwrREFBOENILFVBQVUsSUFBSSxDQUFkLEdBQWtCLEVBQWxCLGVBQTRCQSxVQUE1QixRQUE5QztBQUNILEtBUEQsTUFPSztBQUNELFdBQUssSUFBSXZCLEdBQUMsR0FBRyxDQUFiLEVBQWdCQSxHQUFDLEdBQUdrQixRQUFRLENBQUNqQixNQUE3QixFQUFxQ0QsR0FBQyxFQUF0QyxFQUEwQztBQUN0Q2tCLGdCQUFRLENBQUNsQixHQUFELENBQVIsQ0FBWUUsT0FBWixHQUFzQixLQUF0QjtBQUNIOztBQUNETSxPQUFDLENBQUMsY0FBRCxDQUFELENBQWtCLENBQWxCLEVBQXFCYyxNQUFyQixHQUE4QixJQUE5QjtBQUNIO0FBQ0osR0E1QkQ7QUE2QkgsQ0E5QkQ7O0FBZ0NBLElBQU1LLGlCQUFpQixHQUFHLFNBQXBCQSxpQkFBb0IsQ0FBQ3RCLElBQUQsRUFBT3VCLFVBQVAsRUFBb0I7QUFHMUNwQixHQUFDLENBQUNILElBQUQsQ0FBRCxDQUFRd0IsTUFBUixDQUFlLFlBQVU7QUFDckIsUUFBR3hCLElBQUksSUFBRyxpQkFBVixFQUE0QjtBQUN2QixXQUFLUyxLQUFMLEdBQWFOLENBQUMsQ0FBQyxJQUFELENBQUQsQ0FBUXNCLElBQVIsQ0FBYSxTQUFiLEtBQTJCLElBQTNCLEdBQWtDLENBQWxDLEdBQXNDLENBQW5EO0FBQ0o7O0FBRURDLFdBQU8sQ0FBQ0MsR0FBUixDQUFZeEIsQ0FBQyxDQUFDb0IsVUFBRCxDQUFiO0FBQ0EsUUFBSUssV0FBVyxHQUFHekIsQ0FBQyxDQUFDb0IsVUFBRCxDQUFELENBQWMsQ0FBZCxFQUFpQmQsS0FBakIsR0FBd0IsS0FBS0EsS0FBL0M7QUFFSCxHQVJEO0FBU0gsQ0FaRDs7QUFjQSxJQUFNb0IsV0FBVyxHQUFHO0FBQ25CQyxZQUFVLEVBQUksdUJBREs7QUFFbkJDLE1BQUksRUFBTSwrQ0FGUztBQUduQkMsV0FBUyxFQUFRLDJCQUhFO0FBSW5CQyxZQUFVLEVBQUksUUFKSztBQUtuQkMsZ0JBQWMsRUFBRyxhQUxFO0FBTW5CQyxZQUFVLEVBQUksaUJBTks7QUFPbkIzQixRQUFNLEVBQUssRUFQUTtBQVFuQjRCLG1CQUFpQixFQUFHLGVBUkQ7QUFTbkJDLGFBQVcsRUFBSSwyQkFUSTtBQVVuQkMsVUFBUSxFQUFDO0FBQ1JDLFlBQVEsRUFBQyxrQ0FERDtBQUVSQyxRQUFJLEVBQUM7QUFGRztBQVZVLENBQXBCO0FBZWU7QUFDWDNELFlBQVUsRUFBVkEsVUFEVztBQUVYVyxzQkFBb0IsRUFBcEJBLG9CQUZXO0FBR1hNLHVCQUFxQixFQUFyQkEscUJBSFc7QUFJWEMsY0FBWSxFQUFaQSxZQUpXO0FBS2RZLDJCQUF5QixFQUF6QkEseUJBTGM7QUFNZGtCLGFBQVcsRUFBWEEsV0FOYztBQU9YUCxtQkFBaUIsRUFBakJBO0FBUFcsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xuICAgIFN3YWwuZmlyZSh7XG4gICAgICAgIHRvYXN0OiAndHJ1ZScsXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXG4gICAgICAgIGljb246IGljb24sXG4gICAgICAgIHRpdGxlOiBtZXNzYWdlLFxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXG4gICAgICAgIHRpbWVyOiAzMDAwLFxuICAgICAgICB0aW1lclByb2dyZXNzQmFyOiB0cnVlXG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIGlmICghbWlub3JbaV0uY2hlY2tlZCkge1xuICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gZmFsc2U7XG4gICAgICAgICAgICBicmVhaztcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIG1haW4uY2hlY2tlZCA9IHRydWU7XG4gICAgICAgIH1cbiAgICB9XG5cbn1cblxuZnVuY3Rpb24gbWlub3JDaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBpZiAobWFpbi5jaGVja2VkKSB7XG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIG1pbm9yW2ldLmNoZWNrZWQgPSB0cnVlO1xuICAgICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgbWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xuICAgICAgICB9XG4gICAgfVxuXG59XG5cbmNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XG4gICAgJChhdHRyKS5kZXRhY2goKS5hcHBlbmRUbygnLmRhdGFUYWJsZXNfbGVuZ3RoIGxhYmVsJylcbiAgICAkKGF0dHIpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHRhYmxlLmNvbHVtbnMoY29sdW1uKS5zZWFyY2godGhpcy52YWx1ZSkuZHJhdygpO1xuICAgIH0pO1xufVxuXG5jb25zdCBzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94ID0gZnVuY3Rpb24gKGF0dHIpIHtcbiAgICAkKGF0dHIpLmNsaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgbGV0IGNoZWNrYm94ID0gJChhdHRyKVxuXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSAhY2hlY2tib3hbaV0uY2hlY2tlZFxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHRoaXMuY2hlY2tlZCkge1xuXG4gICAgICAgICAgICB0aGlzLmlubmVySFRNTCA9ICc8aSBjbGFzcz1cImgzIG1kaSBtZGktY2hlY2tib3gtbXVsdGlwbGUtYmxhbmstb3V0bGluZVwiPjwvaT4nXG4gICAgICAgIH0gZWxzZSB7XG5cbiAgICAgICAgICAgIHRoaXMuaW5uZXJIVE1MID0gJzxpIGNsYXNzPVwiaDMgbWRpIG1kaS1jaGVja2JveC1tYXJrZWQtb3V0bGluZVwiPjwvaT5cXG4nXG4gICAgICAgIH1cblxuICAgICAgICBpZih0aGlzLmNoaWxkTm9kZXNbMF0uY2xhc3NOYW1lPT1cImgzIG1kaSBtZGktY2hlY2tib3gtbXVsdGlwbGUtYmxhbmstb3V0bGluZVwiKXtcbiAgICAgICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgICAgICBjaGVja2JveFtpXS5jaGVja2VkID0gdHJ1ZVxuICAgICAgICAgICAgfVxuICAgICAgICAgICAgJChcIi5idWxrLWFjdGlvblwiKVswXS5oaWRkZW4gPSBmYWxzZVxuICAgICAgICAgICAgbGV0IGNoZWNrYm94ZXM9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCIuanMtdXNlci1jaGVja2JveDpjaGVja2VkXCIpLmxlbmd0aFxuICAgICAgICAgICAgJChcIi5idWxrLWFjdGlvblwiKVswXS5pbm5lclRleHQgPSBgIM6Vz4DOuc67zr/Os86tz4IgJHtjaGVja2JveGVzID09IDAgPyBcIlwiIDogYCggJHtjaGVja2JveGVzfSApIGB9IGBcbiAgICAgICAgfWVsc2V7XG4gICAgICAgICAgICBmb3IgKGxldCBpID0gMDsgaSA8IGNoZWNrYm94Lmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICAgICAgY2hlY2tib3hbaV0uY2hlY2tlZCA9IGZhbHNlXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICAkKFwiLmJ1bGstYWN0aW9uXCIpWzBdLmhpZGRlbiA9IHRydWVcbiAgICAgICAgfVxuICAgIH0pXG59XG5cbmNvbnN0IGNoYW5nZUlucHV0SGlkZGVuID0gKGF0dHIsIGhpZGRlbkF0dHIpPT57XG5cblxuICAgICQoYXR0cikuY2hhbmdlKGZ1bmN0aW9uKCl7XG4gICAgICAgIGlmKGF0dHIgPT1cIiNhY3RpdmVNYXRlcmlhbFwiKXtcbiAgICAgICAgICAgICB0aGlzLnZhbHVlID0gJCh0aGlzKS5wcm9wKCdjaGVja2VkJykgPT0gdHJ1ZSA/IDEgOiAwO1xuICAgICAgICB9XG5cbiAgICAgICAgY29uc29sZS5sb2coJChoaWRkZW5BdHRyKSlcbiAgICAgICAgbGV0IGhpZGRlblZhbHVlID0gJChoaWRkZW5BdHRyKVswXS52YWx1ZSA9dGhpcy52YWx1ZVxuXG4gICAgfSlcbn1cblxuY29uc3QgdGFibGVMb2NhbGUgPSB7XG5cdGVtcHR5VGFibGU6IFx0XHRcIs6UzrXOvSDPhc+AzqzPgc+Hzr/Phc69IM61zrPOs8+BzrHPhs6tz4JcIixcblx0aW5mbzogXHRcdFx0XHRcIl9TVEFSVF8gzq3Pic+CIF9FTkRfIM6xz4DOvyDPhM6xIF9UT1RBTF8gzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXG5cdGluZm9FbXB0eTogICAgICBcdFwiMCDOsc+Azr8gMCDPhM6xIDAgzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXG5cdGxlbmd0aE1lbnU6IFx0XHRcIl9NRU5VX1wiLFxuXHRsb2FkaW5nUmVjb3JkczogXHRcIs6mz4zPgc+Ez4nPg863IC4uLlwiLFxuXHRwcm9jZXNzaW5nOiBcdFx0XCLOlc+AzrXOvs61z4HOs86xz4POr86xIC4uLlwiLFxuXHRzZWFyY2g6IFx0XHRcdFwiXCIsXG5cdHNlYXJjaFBsYWNlaG9sZGVyOiBcdFwizpHOvc6xzrbOrs+EzrfPg863Li4uIFwiLFxuXHR6ZXJvUmVjb3JkczogXHRcdFwizpTOtc69IM6yz4HOrc64zrfOus6xzr0gzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXG5cdHBhZ2luYXRlOntcblx0XHRwcmV2aW91czpcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tbGVmdCc+XCIsXG5cdFx0bmV4dDpcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tcmlnaHQnPlwifVxufVxuXG5leHBvcnQgZGVmYXVsdCB7XG4gICAgdG9hc3RBbGVydCxcbiAgICBtYWluQ2hlY2tib3hTd2l0Y2hlcixcbiAgICBtaW5vckNoZWNrYm94U3dpdGNoZXIsXG4gICAgZmlsdGVyQnV0dG9uLFxuXHRzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94LFxuXHR0YWJsZUxvY2FsZSxcbiAgICBjaGFuZ2VJbnB1dEhpZGRlblxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 10:
/*!**********************************************!*\
  !*** multi ./resources/js/dashboard/main.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\lmsdemo\resources\js\dashboard\main.js */"./resources/js/dashboard/main.js");


/***/ })

/******/ });