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
/******/ 	return __webpack_require__(__webpack_require__.s = 8);
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
eval("__webpack_require__.r(__webpack_exports__);\nElement.prototype.findParent = function (loops) {\n  var parent = this;\n\n  for (var i = 0; i < loops; i++) {\n    parent = parent.parentElement;\n  }\n\n  return parent;\n}, false;\nElement.prototype.appendBefore = function (element) {\n  element.parentNode.insertBefore(this, element);\n}, false;\nElement.prototype.appendAfter = function (element) {\n  element.parentNode.insertBefore(this, element.nextSibling);\n}, false; //!##########################################\n//!\t\t\t\tConfigurations\t\t\t\t#\n//!##########################################\n//!ALERT\n//!============================================================\n\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction toastAlertDelete(text) {\n  var icon = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : \"warning\";\n  return Swal.fire({\n    title: 'Είστε σίγουρος;',\n    text: text,\n    icon: icon,\n    showCancelButton: true,\n    confirmButtonText: 'Ναί, διαγραφή!',\n    cancelButtonText: 'Άκυρο'\n  });\n} //!CONFIG\n//!============================================================\n\n\nvar redactorConfig = {\n  style: false,\n  minHeight: '150px'\n};\nvar datePickerConfig = {\n  ranges: {\n    'Today': [moment(), moment()],\n    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],\n    'Last 7 Days': [moment().subtract(6, 'days'), moment()],\n    'Last 30 Days': [moment().subtract(29, 'days'), moment()],\n    'This Month': [moment().startOf('month'), moment().endOf('month')],\n    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]\n  },\n  alwaysShowCalendars: true,\n  showCustomRangeLabel: false,\n  drops: \"auto\",\n  autoUpdateInput: false,\n  opens: \"center\",\n  locale: {\n    format: \"DD/MM/YYYY\"\n  }\n};\nvar tableLocale = {\n  emptyTable: \"Δεν υπάρχουν εγγραφές\",\n  info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n  infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n  lengthMenu: \"_MENU_\",\n  loadingRecords: \"Φόρτωση ...\",\n  processing: \"Επεξεργασία ...\",\n  search: \"\",\n  searchPlaceholder: \"Αναζήτηση... \",\n  zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n  paginate: {\n    previous: \"<i class='mdi mdi-chevron-left'>\",\n    next: \"<i class='mdi mdi-chevron-right'>\"\n  }\n}; //!GLOBAL FUNCTION\n//!============================================================\n\nfunction mainCheckboxSwitcher(main, minor) {\n  var bulkBtn = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;\n  var status = true;\n  var counter = 0;\n  main.checked = true;\n\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      minor[i].findParent(3).classList.remove(\"bg-selected\");\n      main.checked = false;\n    } else {\n      minor[i].findParent(3).classList.add(\"bg-selected\");\n      counter++;\n      status = false;\n    }\n  }\n\n  if (bulkBtn) {\n    bulkModifier(bulkBtn, status, counter);\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  var bulkBtn = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;\n  var counter = 0;\n  var status = true;\n\n  if (main.checked && minor.length > 0) {\n    counter = minor.length;\n    status = false;\n\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n      minor[i].findParent(3).classList.add(\"bg-selected\");\n    }\n  } else {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = false;\n      minor[i].findParent(3).classList.remove(\"bg-selected\");\n    }\n  }\n\n  if (bulkBtn) {\n    bulkModifier(bulkBtn, status, counter);\n  }\n}\n\nfunction bulkModifier(bulkBtn, status, sum) {\n  var text = bulkBtn.dataset.text ? bulkBtn.dataset.text : \"Επιλογές\";\n  var enabledColor = bulkBtn.dataset.enabledColor ? bulkBtn.dataset.enabledColor : \"btn-warning\";\n  var disabledColor = bulkBtn.dataset.disabledColor ? bulkBtn.dataset.disabledColor : \"btn-secondary\";\n\n  if (status) {\n    bulkBtn.classList.add(disabledColor);\n    bulkBtn.classList.remove(enabledColor);\n    bulkBtn.textContent = \"\".concat(text, \" (0)  \");\n    bulkBtn.disabled = true;\n  } else {\n    bulkBtn.classList.add(enabledColor);\n    bulkBtn.classList.remove(disabledColor);\n    bulkBtn.textContent = \"\".concat(text, \"  (\").concat(sum, \")  \");\n    bulkBtn.disabled = false;\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().appendTo('.dataTables_length label');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar changeInputHidden = function changeInputHidden(attr, hiddenAttr) {\n  $(attr).change(function () {\n    if (attr == \"#activeMaterial\") {\n      this.value = $(this).prop('checked') == true ? 1 : 0;\n    }\n\n    var hiddenValue = $(hiddenAttr)[0].value = this.value;\n  });\n};\n\nfunction createStateSelect() {\n  var selectElm = document.createElement(\"select\");\n  selectElm.classList.add(\"ml-1\", \"custom-select\", \"custom-select-sm\", \"form-control\", \"form-control-sm\");\n  selectElm.innerHTML = \"\\n\\t\\t<option value=\\\"\\\">\\u038C\\u03BB\\u03B5\\u03C2 \\u03BF\\u03B9 \\u039A\\u03B1\\u03C4\\u03B1\\u03C3\\u03C4\\u03AC\\u03C3\\u03B5\\u03B9\\u03C2</option>\\n\\t\\t<option value=\\\"1\\\">\\u0395\\u03BD\\u03B5\\u03C1\\u03B3\\u03AC</option>\\n\\t\\t<option value=\\\"0\\\">\\u0391\\u03BD\\u03B5\\u03BD\\u03B5\\u03C1\\u03B3\\u03AC</option>\\n\\t\";\n  return selectElm;\n}\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  tableLocale: tableLocale,\n  changeInputHidden: changeInputHidden,\n  redactorConfig: redactorConfig,\n  createStateSelect: createStateSelect,\n  datePickerConfig: datePickerConfig,\n  toastAlertDelete: toastAlertDelete\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJFbGVtZW50IiwicHJvdG90eXBlIiwiZmluZFBhcmVudCIsImxvb3BzIiwicGFyZW50IiwiaSIsInBhcmVudEVsZW1lbnQiLCJhcHBlbmRCZWZvcmUiLCJlbGVtZW50IiwicGFyZW50Tm9kZSIsImluc2VydEJlZm9yZSIsImFwcGVuZEFmdGVyIiwibmV4dFNpYmxpbmciLCJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwidG9hc3RBbGVydERlbGV0ZSIsInRleHQiLCJzaG93Q2FuY2VsQnV0dG9uIiwiY29uZmlybUJ1dHRvblRleHQiLCJjYW5jZWxCdXR0b25UZXh0IiwicmVkYWN0b3JDb25maWciLCJzdHlsZSIsIm1pbkhlaWdodCIsImRhdGVQaWNrZXJDb25maWciLCJyYW5nZXMiLCJtb21lbnQiLCJzdWJ0cmFjdCIsInN0YXJ0T2YiLCJlbmRPZiIsImFsd2F5c1Nob3dDYWxlbmRhcnMiLCJzaG93Q3VzdG9tUmFuZ2VMYWJlbCIsImRyb3BzIiwiYXV0b1VwZGF0ZUlucHV0Iiwib3BlbnMiLCJsb2NhbGUiLCJmb3JtYXQiLCJ0YWJsZUxvY2FsZSIsImVtcHR5VGFibGUiLCJpbmZvIiwiaW5mb0VtcHR5IiwibGVuZ3RoTWVudSIsImxvYWRpbmdSZWNvcmRzIiwicHJvY2Vzc2luZyIsInNlYXJjaCIsInNlYXJjaFBsYWNlaG9sZGVyIiwiemVyb1JlY29yZHMiLCJwYWdpbmF0ZSIsInByZXZpb3VzIiwibmV4dCIsIm1haW5DaGVja2JveFN3aXRjaGVyIiwibWFpbiIsIm1pbm9yIiwiYnVsa0J0biIsInN0YXR1cyIsImNvdW50ZXIiLCJjaGVja2VkIiwibGVuZ3RoIiwiY2xhc3NMaXN0IiwicmVtb3ZlIiwiYWRkIiwiYnVsa01vZGlmaWVyIiwibWlub3JDaGVja2JveFN3aXRjaGVyIiwic3VtIiwiZGF0YXNldCIsImVuYWJsZWRDb2xvciIsImRpc2FibGVkQ29sb3IiLCJ0ZXh0Q29udGVudCIsImRpc2FibGVkIiwiZmlsdGVyQnV0dG9uIiwiYXR0ciIsImNvbHVtbiIsInRhYmxlIiwiJCIsImRldGFjaCIsImFwcGVuZFRvIiwib24iLCJjb2x1bW5zIiwidmFsdWUiLCJkcmF3IiwiY2hhbmdlSW5wdXRIaWRkZW4iLCJoaWRkZW5BdHRyIiwiY2hhbmdlIiwicHJvcCIsImhpZGRlblZhbHVlIiwiY3JlYXRlU3RhdGVTZWxlY3QiLCJzZWxlY3RFbG0iLCJkb2N1bWVudCIsImNyZWF0ZUVsZW1lbnQiLCJpbm5lckhUTUwiXSwibWFwcGluZ3MiOiJBQUFBQTtBQUFBQSxPQUFPLENBQUNDLFNBQVIsQ0FBa0JDLFVBQWxCLEdBQStCLFVBQVVDLEtBQVYsRUFBaUI7QUFDL0MsTUFBSUMsTUFBTSxHQUFHLElBQWI7O0FBRUEsT0FBTSxJQUFJQyxDQUFDLEdBQUcsQ0FBZCxFQUFpQkEsQ0FBQyxHQUFHRixLQUFyQixFQUE0QkUsQ0FBQyxFQUE3QixFQUFrQztBQUNqQ0QsVUFBTSxHQUFHQSxNQUFNLENBQUNFLGFBQWhCO0FBQ0E7O0FBRUQsU0FBT0YsTUFBUDtBQUNBLENBUkQsRUFRRSxLQVJGO0FBVUFKLE9BQU8sQ0FBQ0MsU0FBUixDQUFrQk0sWUFBbEIsR0FBaUMsVUFBVUMsT0FBVixFQUFtQjtBQUNuREEsU0FBTyxDQUFDQyxVQUFSLENBQW1CQyxZQUFuQixDQUFnQyxJQUFoQyxFQUFzQ0YsT0FBdEM7QUFDQSxDQUZELEVBRUUsS0FGRjtBQUlBUixPQUFPLENBQUNDLFNBQVIsQ0FBa0JVLFdBQWxCLEdBQWdDLFVBQVVILE9BQVYsRUFBbUI7QUFFbERBLFNBQU8sQ0FBQ0MsVUFBUixDQUFtQkMsWUFBbkIsQ0FBZ0MsSUFBaEMsRUFBc0NGLE9BQU8sQ0FBQ0ksV0FBOUM7QUFFQSxDQUpELEVBSUUsS0FK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SUFBUixDQUFhLFNBQWIsS0FBMkIsSUFBM0IsR0FBa0MsQ0FBbEMsR0FBc0MsQ0FBbkQ7QUFDSDs7QUFFRCxRQUFJQyxXQUFXLEdBQUdYLENBQUMsQ0FBQ1EsVUFBRCxDQUFELENBQWMsQ0FBZCxFQUFpQkgsS0FBakIsR0FBeUIsS0FBS0EsS0FBaEQ7QUFFSCxHQVBEO0FBUUgsQ0FYRDs7QUFhQSxTQUFTTyxpQkFBVCxHQUE2QjtBQUN6QixNQUFNQyxTQUFTLEdBQUdDLFFBQVEsQ0FBQ0MsYUFBVCxDQUF1QixRQUF2QixDQUFsQjtBQUNBRixXQUFTLENBQUM1QixTQUFWLENBQW9CRSxHQUFwQixDQUF3QixNQUF4QixFQUFnQyxlQUFoQyxFQUFpRCxrQkFBakQsRUFBcUUsY0FBckUsRUFBcUYsaUJBQXJGO0FBRUEwQixXQUFTLENBQUNHLFNBQVY7QUFNQSxTQUFPSCxTQUFQO0FBQ0g7O0FBR2M7QUFDWGpGLFlBQVUsRUFBVkEsVUFEVztBQUVYNkMsc0JBQW9CLEVBQXBCQSxvQkFGVztBQUdYWSx1QkFBcUIsRUFBckJBLHFCQUhXO0FBSVhPLGNBQVksRUFBWkEsWUFKVztBQUtYaEMsYUFBVyxFQUFYQSxXQUxXO0FBTVgyQyxtQkFBaUIsRUFBakJBLGlCQU5XO0FBT1gzRCxnQkFBYyxFQUFkQSxjQVBXO0FBUVhnRSxtQkFBaUIsRUFBakJBLGlCQVJXO0FBU1g3RCxrQkFBZ0IsRUFBaEJBLGdCQVRXO0FBVVhSLGtCQUFnQixFQUFoQkE7QUFWVyxDQUFmIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2Rhc2hib2FyZC9tYWluLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiRWxlbWVudC5wcm90b3R5cGUuZmluZFBhcmVudCA9IGZ1bmN0aW9uIChsb29wcykge1xyXG5cdGxldCBwYXJlbnQgPSB0aGlzO1xyXG5cclxuXHRmb3IgKCBsZXQgaSA9IDA7IGkgPCBsb29wczsgaSsrICkge1xyXG5cdFx0cGFyZW50ID0gcGFyZW50LnBhcmVudEVsZW1lbnQ7XHJcblx0fVxyXG5cclxuXHRyZXR1cm4gcGFyZW50O1xyXG59LGZhbHNlO1xyXG5cclxuRWxlbWVudC5wcm90b3R5cGUuYXBwZW5kQmVmb3JlID0gZnVuY3Rpb24gKGVsZW1lbnQpIHtcclxuXHRlbGVtZW50LnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKHRoaXMsIGVsZW1lbnQpO1xyXG59LGZhbHNlO1xyXG5cclxuRWxlbWVudC5wcm90b3R5cGUuYXBwZW5kQWZ0ZXIgPSBmdW5jdGlvbiAoZWxlbWVudCkge1xyXG5cclxuXHRlbGVtZW50LnBhcmVudE5vZGUuaW5zZXJ0QmVmb3JlKHRoaXMsIGVsZW1lbnQubmV4dFNpYmxpbmcpO1xyXG5cclxufSxmYWxzZTtcclxuXHJcbi8vISMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjI1xyXG4vLyFcdFx0XHRcdENvbmZpZ3VyYXRpb25zXHRcdFx0XHQjXHJcbi8vISMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjIyMjI1xyXG5cclxuLy8hQUxFUlRcclxuLy8hPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbmZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xyXG4gICAgU3dhbC5maXJlKHtcclxuICAgICAgICB0b2FzdDogJ3RydWUnLFxyXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXHJcbiAgICAgICAgaWNvbjogaWNvbixcclxuICAgICAgICB0aXRsZTogbWVzc2FnZSxcclxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXHJcbiAgICAgICAgdGltZXI6IDMwMDAsXHJcbiAgICAgICAgdGltZXJQcm9ncmVzc0JhcjogdHJ1ZVxyXG4gICAgfSk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIHRvYXN0QWxlcnREZWxldGUodGV4dCxpY29uPVwid2FybmluZ1wiKXtcclxuICAgIHJldHVybiAgIFN3YWwuZmlyZSh7XHJcbiAgICAgICAgdGl0bGU6ICfOlc6vz4PPhM61IM+Dzq/Os86/z4XPgc6/z4I7JyxcclxuICAgICAgICB0ZXh0OnRleHQsXHJcbiAgICAgICAgaWNvbjogaWNvbixcclxuICAgICAgICBzaG93Q2FuY2VsQnV0dG9uOiB0cnVlLFxyXG4gICAgICAgIGNvbmZpcm1CdXR0b25UZXh0OiAnzp3Osc6vLCDOtM65zrHOs8+BzrHPhs6uIScsXHJcbiAgICAgICAgY2FuY2VsQnV0dG9uVGV4dDogJ86GzrrPhc+Bzr8nXHJcbiAgICB9KTtcclxufVxyXG5cclxuXHJcbi8vIUNPTkZJR1xyXG4vLyE9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuY29uc3QgcmVkYWN0b3JDb25maWcgPSB7XHJcbiAgICBzdHlsZTogZmFsc2UsXHJcbiAgICBtaW5IZWlnaHQ6ICcxNTBweCcsXHJcbn1cclxuXHJcbmNvbnN0IGRhdGVQaWNrZXJDb25maWcgPSB7XHJcbiAgICByYW5nZXM6IHtcclxuICAgICAgICAnVG9kYXknOiBbbW9tZW50KCksIG1vbWVudCgpXSxcclxuICAgICAgICAnWWVzdGVyZGF5JzogW21vbWVudCgpLnN1YnRyYWN0KDEsICdkYXlzJyksIG1vbWVudCgpLnN1YnRyYWN0KDEsICdkYXlzJyldLFxyXG4gICAgICAgICdMYXN0IDcgRGF5cyc6IFttb21lbnQoKS5zdWJ0cmFjdCg2LCAnZGF5cycpLCBtb21lbnQoKV0sXHJcbiAgICAgICAgJ0xhc3QgMzAgRGF5cyc6IFttb21lbnQoKS5zdWJ0cmFjdCgyOSwgJ2RheXMnKSwgbW9tZW50KCldLFxyXG4gICAgICAgICdUaGlzIE1vbnRoJzogW21vbWVudCgpLnN0YXJ0T2YoJ21vbnRoJyksIG1vbWVudCgpLmVuZE9mKCdtb250aCcpXSxcclxuICAgICAgICAnTGFzdCBNb250aCc6IFttb21lbnQoKS5zdWJ0cmFjdCgxLCAnbW9udGgnKS5zdGFydE9mKCdtb250aCcpLCBtb21lbnQoKS5zdWJ0cmFjdCgxLCAnbW9udGgnKS5lbmRPZignbW9udGgnKV1cclxuICAgIH0sXHJcbiAgICBhbHdheXNTaG93Q2FsZW5kYXJzOiB0cnVlLFxyXG4gICAgc2hvd0N1c3RvbVJhbmdlTGFiZWw6IGZhbHNlLFxyXG4gICAgZHJvcHM6IFwiYXV0b1wiLFxyXG4gICAgYXV0b1VwZGF0ZUlucHV0OiBmYWxzZSxcclxuICAgIG9wZW5zOiBcImNlbnRlclwiLFxyXG4gICAgbG9jYWxlOiB7XHJcbiAgICAgICAgZm9ybWF0OiBcIkREL01NL1lZWVlcIixcclxuICAgIH0sXHJcbn1cclxuXHJcbmNvbnN0IHRhYmxlTG9jYWxlID0ge1xyXG4gICAgZW1wdHlUYWJsZTogXCLOlM61zr0gz4XPgM6sz4HPh86/z4XOvSDOtc6zzrPPgc6xz4bOrc+CXCIsXHJcbiAgICBpbmZvOiBcIl9TVEFSVF8gzq3Pic+CIF9FTkRfIM6xz4DOvyDPhM6xIF9UT1RBTF8gzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXHJcbiAgICBpbmZvRW1wdHk6IFwiMCDOsc+Azr8gMCDPhM6xIDAgzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXHJcbiAgICBsZW5ndGhNZW51OiBcIl9NRU5VX1wiLFxyXG4gICAgbG9hZGluZ1JlY29yZHM6IFwizqbPjM+Bz4TPic+DzrcgLi4uXCIsXHJcbiAgICBwcm9jZXNzaW5nOiBcIs6Vz4DOtc6+zrXPgc6zzrHPg86vzrEgLi4uXCIsXHJcbiAgICBzZWFyY2g6IFwiXCIsXHJcbiAgICBzZWFyY2hQbGFjZWhvbGRlcjogXCLOkc69zrHOts6uz4TOt8+DzrcuLi4gXCIsXHJcbiAgICB6ZXJvUmVjb3JkczogXCLOlM61zr0gzrLPgc6tzrjOt866zrHOvSDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuICAgIHBhZ2luYXRlOiB7XHJcbiAgICAgICAgcHJldmlvdXM6IFwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1sZWZ0Jz5cIixcclxuICAgICAgICBuZXh0OiBcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tcmlnaHQnPlwiXHJcbiAgICB9XHJcbn1cclxuXHJcblxyXG5cclxuXHJcbi8vIUdMT0JBTCBGVU5DVElPTlxyXG4vLyE9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuICAgIGZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yLCBidWxrQnRuID0gZmFsc2UpIHtcclxuICAgICAgICBsZXQgc3RhdHVzID0gdHJ1ZTtcclxuICAgICAgICBsZXQgY291bnRlciA9IDA7XHJcbiAgICAgICAgbWFpbi5jaGVja2VkID0gdHJ1ZTtcclxuXHJcbiAgICAgICAgZm9yICh2YXIgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgICAgICBpZiAoIW1pbm9yW2ldLmNoZWNrZWQpIHtcclxuICAgICAgICAgICAgICAgIG1pbm9yW2ldLmZpbmRQYXJlbnQoMykuY2xhc3NMaXN0LnJlbW92ZShcImJnLXNlbGVjdGVkXCIpO1xyXG4gICAgICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gZmFsc2U7XHJcbiAgICAgICAgICAgIH0gZWxzZSB7XHJcbiAgICAgICAgICAgICAgICBtaW5vcltpXS5maW5kUGFyZW50KDMpLmNsYXNzTGlzdC5hZGQoXCJiZy1zZWxlY3RlZFwiKTtcclxuICAgICAgICAgICAgICAgIGNvdW50ZXIrK1xyXG4gICAgICAgICAgICAgICAgc3RhdHVzID0gZmFsc2U7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGlmIChidWxrQnRuKSB7XHJcbiAgICAgICAgICAgIGJ1bGtNb2RpZmllcihidWxrQnRuLCBzdGF0dXMsIGNvdW50ZXIpO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxuXHJcbiAgICBmdW5jdGlvbiBtaW5vckNoZWNrYm94U3dpdGNoZXIobWFpbiwgbWlub3IsIGJ1bGtCdG4gPSBmYWxzZSkge1xyXG4gICAgICAgIGxldCBjb3VudGVyID0gMDtcclxuICAgICAgICBsZXQgc3RhdHVzID0gdHJ1ZTtcclxuXHJcbiAgICAgICAgaWYgKG1haW4uY2hlY2tlZCAmJiBtaW5vci5sZW5ndGggPiAwKSB7XHJcblxyXG4gICAgICAgICAgICBjb3VudGVyID0gbWlub3IubGVuZ3RoO1xyXG4gICAgICAgICAgICBzdGF0dXMgPSBmYWxzZTtcclxuXHJcbiAgICAgICAgICAgIGZvciAodmFyIGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgICAgIG1pbm9yW2ldLmNoZWNrZWQgPSB0cnVlO1xyXG4gICAgICAgICAgICAgICAgbWlub3JbaV0uZmluZFBhcmVudCgzKS5jbGFzc0xpc3QuYWRkKFwiYmctc2VsZWN0ZWRcIik7XHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICB9IGVsc2Uge1xyXG4gICAgICAgICAgICBmb3IgKHZhciBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrKSB7XHJcbiAgICAgICAgICAgICAgICBtaW5vcltpXS5jaGVja2VkID0gZmFsc2U7XHJcbiAgICAgICAgICAgICAgICBtaW5vcltpXS5maW5kUGFyZW50KDMpLmNsYXNzTGlzdC5yZW1vdmUoXCJiZy1zZWxlY3RlZFwiKTtcclxuICAgICAgICAgICAgfVxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYgKGJ1bGtCdG4pIHtcclxuICAgICAgICAgICAgYnVsa01vZGlmaWVyKGJ1bGtCdG4sIHN0YXR1cywgY291bnRlcik7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIGZ1bmN0aW9uIGJ1bGtNb2RpZmllcihidWxrQnRuLCBzdGF0dXMsIHN1bSkge1xyXG5cclxuICAgICAgICBsZXQgdGV4dCA9IGJ1bGtCdG4uZGF0YXNldC50ZXh0ID8gYnVsa0J0bi5kYXRhc2V0LnRleHQgOiBcIs6Vz4DOuc67zr/Os86tz4JcIjtcclxuICAgICAgICBsZXQgZW5hYmxlZENvbG9yID0gYnVsa0J0bi5kYXRhc2V0LmVuYWJsZWRDb2xvciA/IGJ1bGtCdG4uZGF0YXNldC5lbmFibGVkQ29sb3IgOiBcImJ0bi13YXJuaW5nXCI7XHJcbiAgICAgICAgbGV0IGRpc2FibGVkQ29sb3IgPSBidWxrQnRuLmRhdGFzZXQuZGlzYWJsZWRDb2xvciA/IGJ1bGtCdG4uZGF0YXNldC5kaXNhYmxlZENvbG9yIDogXCJidG4tc2Vjb25kYXJ5XCI7XHJcblxyXG4gICAgICAgIGlmIChzdGF0dXMpIHtcclxuICAgICAgICAgICAgYnVsa0J0bi5jbGFzc0xpc3QuYWRkKGRpc2FibGVkQ29sb3IpXHJcbiAgICAgICAgICAgIGJ1bGtCdG4uY2xhc3NMaXN0LnJlbW92ZShlbmFibGVkQ29sb3IpXHJcbiAgICAgICAgICAgIGJ1bGtCdG4udGV4dENvbnRlbnQgPSBgJHt0ZXh0fSAoMCkgIGBcclxuICAgICAgICAgICAgYnVsa0J0bi5kaXNhYmxlZCA9IHRydWU7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgYnVsa0J0bi5jbGFzc0xpc3QuYWRkKGVuYWJsZWRDb2xvcik7XHJcbiAgICAgICAgICAgIGJ1bGtCdG4uY2xhc3NMaXN0LnJlbW92ZShkaXNhYmxlZENvbG9yKTtcclxuICAgICAgICAgICAgYnVsa0J0bi50ZXh0Q29udGVudCA9IGAke3RleHR9ICAoJHtzdW19KSAgYFxyXG4gICAgICAgICAgICBidWxrQnRuLmRpc2FibGVkID0gZmFsc2U7XHJcbiAgICAgICAgfVxyXG4gICAgfVxyXG5cclxuICAgIGNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XHJcbiAgICAgICAgJChhdHRyKS5kZXRhY2goKS5hcHBlbmRUbygnLmRhdGFUYWJsZXNfbGVuZ3RoIGxhYmVsJylcclxuICAgICAgICAkKGF0dHIpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgICAgIHRhYmxlLmNvbHVtbnMoY29sdW1uKS5zZWFyY2godGhpcy52YWx1ZSkuZHJhdygpO1xyXG4gICAgICAgIH0pO1xyXG4gICAgfVxyXG5cclxuICAgIGNvbnN0IGNoYW5nZUlucHV0SGlkZGVuID0gKGF0dHIsIGhpZGRlbkF0dHIpID0+IHtcclxuXHJcblxyXG4gICAgICAgICQoYXR0cikuY2hhbmdlKGZ1bmN0aW9uICgpIHtcclxuICAgICAgICAgICAgaWYgKGF0dHIgPT0gXCIjYWN0aXZlTWF0ZXJpYWxcIikge1xyXG4gICAgICAgICAgICAgICAgdGhpcy52YWx1ZSA9ICQodGhpcykucHJvcCgnY2hlY2tlZCcpID09IHRydWUgPyAxIDogMDtcclxuICAgICAgICAgICAgfVxyXG5cclxuICAgICAgICAgICAgbGV0IGhpZGRlblZhbHVlID0gJChoaWRkZW5BdHRyKVswXS52YWx1ZSA9IHRoaXMudmFsdWVcclxuXHJcbiAgICAgICAgfSlcclxuICAgIH1cclxuXHJcbiAgICBmdW5jdGlvbiBjcmVhdGVTdGF0ZVNlbGVjdCgpIHtcclxuICAgICAgICBjb25zdCBzZWxlY3RFbG0gPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KFwic2VsZWN0XCIpO1xyXG4gICAgICAgIHNlbGVjdEVsbS5jbGFzc0xpc3QuYWRkKFwibWwtMVwiLCBcImN1c3RvbS1zZWxlY3RcIiwgXCJjdXN0b20tc2VsZWN0LXNtXCIsIFwiZm9ybS1jb250cm9sXCIsIFwiZm9ybS1jb250cm9sLXNtXCIpO1xyXG5cclxuICAgICAgICBzZWxlY3RFbG0uaW5uZXJIVE1MID0gYFxyXG5cdFx0PG9wdGlvbiB2YWx1ZT1cIlwiPs6MzrvOtc+CIM6/zrkgzprOsc+EzrHPg8+EzqzPg861zrnPgjwvb3B0aW9uPlxyXG5cdFx0PG9wdGlvbiB2YWx1ZT1cIjFcIj7Olc69zrXPgc6zzqw8L29wdGlvbj5cclxuXHRcdDxvcHRpb24gdmFsdWU9XCIwXCI+zpHOvc61zr3Otc+BzrPOrDwvb3B0aW9uPlxyXG5cdGA7XHJcblxyXG4gICAgICAgIHJldHVybiBzZWxlY3RFbG07XHJcbiAgICB9XHJcblxyXG5cclxuICAgIGV4cG9ydCBkZWZhdWx0IHtcclxuICAgICAgICB0b2FzdEFsZXJ0LFxyXG4gICAgICAgIG1haW5DaGVja2JveFN3aXRjaGVyLFxyXG4gICAgICAgIG1pbm9yQ2hlY2tib3hTd2l0Y2hlcixcclxuICAgICAgICBmaWx0ZXJCdXR0b24sXHJcbiAgICAgICAgdGFibGVMb2NhbGUsXHJcbiAgICAgICAgY2hhbmdlSW5wdXRIaWRkZW4sXHJcbiAgICAgICAgcmVkYWN0b3JDb25maWcsXHJcbiAgICAgICAgY3JlYXRlU3RhdGVTZWxlY3QsXHJcbiAgICAgICAgZGF0ZVBpY2tlckNvbmZpZyxcclxuICAgICAgICB0b2FzdEFsZXJ0RGVsZXRlXHJcblxyXG4gICAgfVxyXG4iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ "./resources/js/dashboard/materials/materialNew.js":
/*!*********************************************************!*\
  !*** ./resources/js/dashboard/materials/materialNew.js ***!
  \*********************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main */ \"./resources/js/dashboard/main.js\");\n //! EDITOR INIT\n//!============================================================\n\n$R('#summaryMaterial', {\n  minHeight: '150px'\n});\n$R('#descriptionMaterial', {\n  minHeight: '150px'\n});\n$R('#contentMaterial', {\n  minHeight: '150px'\n}); //! METHOD INIT\n//!============================================================\n\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#urlMaterial', '#urlMaterialHiden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#activeMaterial', '#activeMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#typeMaterial', '#typeMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#instructorMaterial', '#instructorMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#topicMaterial', '#topicMaterialHidden'); // utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')\n//! SELECT2\n//!============================================================\n\n$(\"#typeMaterial\").select2({\n  minimumResultsForSearch: -1,\n  allowClear: true,\n  placeholder: 'Ολοι οι Τύποι'\n});\n$(\"#instructorMaterial\").select2({\n  allowClear: true,\n  placeholder: 'Ολοι οι Εισηγητής'\n});\n$(\"#topicMaterial\").select2({\n  allowClear: true,\n  placeholder: 'Ολα τα Τοpic',\n  tags: true\n}); //sortable\n\n$(\"ul.select2-selection__rendered\").sortable({\n  containment: 'parent'\n}); //! DATARANGE\n//!============================================================\n\nvar dataRange = $(\"#createAtMaterial\");\ndataRange.daterangepicker({\n  locale: {\n    format: 'YY/MM/DD '\n  },\n  startDate: moment().startOf('hour'),\n  // ranges: {\n  //     'Today': [moment(), moment()],\n  //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],\n  //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],\n  //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],\n  //     'This Month': [moment().startOf('month'), moment().endOf('month')],\n  //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]\n  // },\n  alwaysShowCalendars: true,\n  showCustomRangeLabel: false,\n  drops: \"auto\",\n  autoUpdateInput: false,\n  opens: \"center\"\n}); //! METHOD\n//!============================================================\n\n$(\".buton-create-material\").click(function (e) {\n  $(\"#topicMaterialHidden\").replaceWith($(\"#topicMaterial\"));\n}); //! EVENT listener\n//!============================================================\n\n$(\"#update-btn\").click(function () {\n  $(\"#topicMaterialHidden\").replaceWith($(\"#topicMaterial\"));\n  $(\".formPrevent\").submit();\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21hdGVyaWFscy9tYXRlcmlhbE5ldy5qcz80YTI1Il0sIm5hbWVzIjpbIiRSIiwibWluSGVpZ2h0IiwidXRpbGl0aWVzIiwiY2hhbmdlSW5wdXRIaWRkZW4iLCIkIiwic2VsZWN0MiIsIm1pbmltdW1SZXN1bHRzRm9yU2VhcmNoIiwiYWxsb3dDbGVhciIsInBsYWNlaG9sZGVyIiwidGFncyIsInNvcnRhYmxlIiwiY29udGFpbm1lbnQiLCJkYXRhUmFuZ2UiLCJkYXRlcmFuZ2VwaWNrZXIiLCJsb2NhbGUiLCJmb3JtYXQiLCJzdGFydERhdGUiLCJtb21lbnQiLCJzdGFydE9mIiwiYWx3YXlzU2hvd0NhbGVuZGFycyIsInNob3dDdXN0b21SYW5nZUxhYmVsIiwiZHJvcHMiLCJhdXRvVXBkYXRlSW5wdXQiLCJvcGVucyIsImNsaWNrIiwiZSIsInJlcGxhY2VXaXRoIiwic3VibWl0Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0NBQ0E7QUFDQTs7QUFFQUEsRUFBRSxDQUFDLGtCQUFELEVBQW9CO0FBQ2xCQyxXQUFTLEVBQUU7QUFETyxDQUFwQixDQUFGO0FBR0FELEVBQUUsQ0FBQyxzQkFBRCxFQUF3QjtBQUN0QkMsV0FBUyxFQUFFO0FBRFcsQ0FBeEIsQ0FBRjtBQUdBRCxFQUFFLENBQUMsa0JBQUQsRUFBb0I7QUFDbEJDLFdBQVMsRUFBRTtBQURPLENBQXBCLENBQUYsQyxDQUtBO0FBQ0E7O0FBRUFDLDZDQUFTLENBQUNDLGlCQUFWLENBQTRCLGNBQTVCLEVBQTJDLG1CQUEzQztBQUNBRCw2Q0FBUyxDQUFDQyxpQkFBVixDQUE0QixpQkFBNUIsRUFBOEMsdUJBQTlDO0FBQ0FELDZDQUFTLENBQUNDLGlCQUFWLENBQTRCLGVBQTVCLEVBQTRDLHFCQUE1QztBQUNBRCw2Q0FBUyxDQUFDQyxpQkFBVixDQUE0QixxQkFBNUIsRUFBa0QsMkJBQWxEO0FBQ0FELDZDQUFTLENBQUNDLGlCQUFWLENBQTRCLGdCQUE1QixFQUE2QyxzQkFBN0MsRSxDQUNBO0FBSUE7QUFDQTs7QUFDQUMsQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkMsT0FBbkIsQ0FBMkI7QUFDdkJDLHlCQUF1QixFQUFFLENBQUMsQ0FESDtBQUV2QkMsWUFBVSxFQUFFLElBRlc7QUFHdkJDLGFBQVcsRUFBRTtBQUhVLENBQTNCO0FBTUFKLENBQUMsQ0FBQyxxQkFBRCxDQUFELENBQXlCQyxPQUF6QixDQUFpQztBQUM3QkUsWUFBVSxFQUFFLElBRGlCO0FBRTdCQyxhQUFXLEVBQUU7QUFGZ0IsQ0FBakM7QUFLQUosQ0FBQyxDQUFDLGdCQUFELENBQUQsQ0FBb0JDLE9BQXBCLENBQTRCO0FBQ3hCRSxZQUFVLEVBQUUsSUFEWTtBQUV4QkMsYUFBVyxFQUFFLGNBRlc7QUFHeEJDLE1BQUksRUFBRTtBQUhrQixDQUE1QixFLENBTUE7O0FBRUFMLENBQUMsQ0FBQyxnQ0FBRCxDQUFELENBQW9DTSxRQUFwQyxDQUE2QztBQUN6Q0MsYUFBVyxFQUFFO0FBRDRCLENBQTdDLEUsQ0FLQTtBQUNBOztBQUVBLElBQUlDLFNBQVMsR0FBR1IsQ0FBQyxDQUFDLG1CQUFELENBQWpCO0FBRUFRLFNBQVMsQ0FBQ0MsZUFBVixDQUEwQjtBQUN0QkMsUUFBTSxFQUFFO0FBQ0pDLFVBQU0sRUFBRTtBQURKLEdBRGM7QUFJdEJDLFdBQVMsRUFBRUMsTUFBTSxHQUFHQyxPQUFULENBQWlCLE1BQWpCLENBSlc7QUFLdEI7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBQyxxQkFBbUIsRUFBRSxJQWJDO0FBY3RCQyxzQkFBb0IsRUFBRSxLQWRBO0FBZXRCQyxPQUFLLEVBQUUsTUFmZTtBQWdCdEJDLGlCQUFlLEVBQUUsS0FoQks7QUFpQnRCQyxPQUFLLEVBQUU7QUFqQmUsQ0FBMUIsRSxDQXdCQTtBQUNBOztBQUNBbkIsQ0FBQyxDQUFDLHdCQUFELENBQUQsQ0FBNEJvQixLQUE1QixDQUFrQyxVQUFTQyxDQUFULEVBQVc7QUFDekNyQixHQUFDLENBQUUsc0JBQUYsQ0FBRCxDQUE0QnNCLFdBQTVCLENBQXlDdEIsQ0FBQyxDQUFFLGdCQUFGLENBQTFDO0FBRUgsQ0FIRCxFLENBUUE7QUFDQTs7QUFDQUEsQ0FBQyxDQUFDLGFBQUQsQ0FBRCxDQUFpQm9CLEtBQWpCLENBQXdCLFlBQVc7QUFDL0JwQixHQUFDLENBQUUsc0JBQUYsQ0FBRCxDQUE0QnNCLFdBQTVCLENBQXlDdEIsQ0FBQyxDQUFFLGdCQUFGLENBQTFDO0FBQ0FBLEdBQUMsQ0FBQyxjQUFELENBQUQsQ0FBa0J1QixNQUFsQjtBQUNILENBSEQiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21hdGVyaWFscy9tYXRlcmlhbE5ldy5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB1dGlsaXRpZXMgZnJvbSAnLi4vbWFpbic7XHJcbi8vISBFRElUT1IgSU5JVFxyXG4vLyE9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuXHJcbiRSKCcjc3VtbWFyeU1hdGVyaWFsJyx7XHJcbiAgICBtaW5IZWlnaHQ6ICcxNTBweCdcclxufSk7XHJcbiRSKCcjZGVzY3JpcHRpb25NYXRlcmlhbCcse1xyXG4gICAgbWluSGVpZ2h0OiAnMTUwcHgnXHJcbn0pO1xyXG4kUignI2NvbnRlbnRNYXRlcmlhbCcse1xyXG4gICAgbWluSGVpZ2h0OiAnMTUwcHgnXHJcbn0pO1xyXG5cclxuXHJcbi8vISBNRVRIT0QgSU5JVFxyXG4vLyE9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cclxuXHJcbnV0aWxpdGllcy5jaGFuZ2VJbnB1dEhpZGRlbignI3VybE1hdGVyaWFsJywnI3VybE1hdGVyaWFsSGlkZW4nKVxyXG51dGlsaXRpZXMuY2hhbmdlSW5wdXRIaWRkZW4oJyNhY3RpdmVNYXRlcmlhbCcsJyNhY3RpdmVNYXRlcmlhbEhpZGRlbicpXHJcbnV0aWxpdGllcy5jaGFuZ2VJbnB1dEhpZGRlbignI3R5cGVNYXRlcmlhbCcsJyN0eXBlTWF0ZXJpYWxIaWRkZW4nKVxyXG51dGlsaXRpZXMuY2hhbmdlSW5wdXRIaWRkZW4oJyNpbnN0cnVjdG9yTWF0ZXJpYWwnLCcjaW5zdHJ1Y3Rvck1hdGVyaWFsSGlkZGVuJylcclxudXRpbGl0aWVzLmNoYW5nZUlucHV0SGlkZGVuKCcjdG9waWNNYXRlcmlhbCcsJyN0b3BpY01hdGVyaWFsSGlkZGVuJylcclxuLy8gdXRpbGl0aWVzLmNoYW5nZUlucHV0SGlkZGVuKCcjY291cnNlc01hdGVyaWFsJywnI2NvdXJzZXNNYXRlcmlhbEhpZGRlbicpXHJcblxyXG5cclxuXHJcbi8vISBTRUxFQ1QyXHJcbi8vIT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4kKFwiI3R5cGVNYXRlcmlhbFwiKS5zZWxlY3QyKHtcclxuICAgIG1pbmltdW1SZXN1bHRzRm9yU2VhcmNoOiAtMSxcclxuICAgIGFsbG93Q2xlYXI6IHRydWUsXHJcbiAgICBwbGFjZWhvbGRlcjogJ86fzrvOv865IM6/zrkgzqTPjc+Azr/OuSdcclxufSk7XHJcblxyXG4kKFwiI2luc3RydWN0b3JNYXRlcmlhbFwiKS5zZWxlY3QyKHtcclxuICAgIGFsbG93Q2xlYXI6IHRydWUsXHJcbiAgICBwbGFjZWhvbGRlcjogJ86fzrvOv865IM6/zrkgzpXOuc+DzrfOs863z4TOrs+CJ1xyXG59KTtcclxuXHJcbiQoXCIjdG9waWNNYXRlcmlhbFwiKS5zZWxlY3QyKHtcclxuICAgIGFsbG93Q2xlYXI6IHRydWUsXHJcbiAgICBwbGFjZWhvbGRlcjogJ86fzrvOsSDPhM6xIM6kzr9waWMnLFxyXG4gICAgdGFnczogdHJ1ZVxyXG59KTtcclxuXHJcbi8vc29ydGFibGVcclxuXHJcbiQoXCJ1bC5zZWxlY3QyLXNlbGVjdGlvbl9fcmVuZGVyZWRcIikuc29ydGFibGUoe1xyXG4gICAgY29udGFpbm1lbnQ6ICdwYXJlbnQnXHJcbn0pO1xyXG5cclxuXHJcbi8vISBEQVRBUkFOR0VcclxuLy8hPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcblxyXG5sZXQgZGF0YVJhbmdlID0gJChcIiNjcmVhdGVBdE1hdGVyaWFsXCIpXHJcblxyXG5kYXRhUmFuZ2UuZGF0ZXJhbmdlcGlja2VyKHtcclxuICAgIGxvY2FsZToge1xyXG4gICAgICAgIGZvcm1hdDogJ1lZL01NL0REICdcclxuICAgIH0sXHJcbiAgICBzdGFydERhdGU6IG1vbWVudCgpLnN0YXJ0T2YoJ2hvdXInKSxcclxuICAgIC8vIHJhbmdlczoge1xyXG4gICAgLy8gICAgICdUb2RheSc6IFttb21lbnQoKSwgbW9tZW50KCldLFxyXG4gICAgLy8gICAgICdZZXN0ZXJkYXknOiBbbW9tZW50KCkuc3VidHJhY3QoMSwgJ2RheXMnKSwgbW9tZW50KCkuc3VidHJhY3QoMSwgJ2RheXMnKV0sXHJcbiAgICAvLyAgICAgJ0xhc3QgNyBEYXlzJzogW21vbWVudCgpLnN1YnRyYWN0KDYsICdkYXlzJyksIG1vbWVudCgpXSxcclxuICAgIC8vICAgICAnTGFzdCAzMCBEYXlzJzogW21vbWVudCgpLnN1YnRyYWN0KDI5LCAnZGF5cycpLCBtb21lbnQoKV0sXHJcbiAgICAvLyAgICAgJ1RoaXMgTW9udGgnOiBbbW9tZW50KCkuc3RhcnRPZignbW9udGgnKSwgbW9tZW50KCkuZW5kT2YoJ21vbnRoJyldLFxyXG4gICAgLy8gICAgICdMYXN0IE1vbnRoJzogW21vbWVudCgpLnN1YnRyYWN0KDEsICdtb250aCcpLnN0YXJ0T2YoJ21vbnRoJyksIG1vbWVudCgpLnN1YnRyYWN0KDEsICdtb250aCcpLmVuZE9mKCdtb250aCcpXVxyXG4gICAgLy8gfSxcclxuICAgIGFsd2F5c1Nob3dDYWxlbmRhcnM6IHRydWUsXHJcbiAgICBzaG93Q3VzdG9tUmFuZ2VMYWJlbDogZmFsc2UsXHJcbiAgICBkcm9wczogXCJhdXRvXCIsXHJcbiAgICBhdXRvVXBkYXRlSW5wdXQ6IGZhbHNlLFxyXG4gICAgb3BlbnM6IFwiY2VudGVyXCIsXHJcbn0pO1xyXG5cclxuXHJcblxyXG5cclxuXHJcbi8vISBNRVRIT0RcclxuLy8hPT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09XHJcbiQoXCIuYnV0b24tY3JlYXRlLW1hdGVyaWFsXCIpLmNsaWNrKGZ1bmN0aW9uKGUpe1xyXG4gICAgJCggXCIjdG9waWNNYXRlcmlhbEhpZGRlblwiICkucmVwbGFjZVdpdGgoICQoIFwiI3RvcGljTWF0ZXJpYWxcIiApICk7XHJcblxyXG59KVxyXG5cclxuXHJcblxyXG5cclxuLy8hIEVWRU5UIGxpc3RlbmVyXHJcbi8vIT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxyXG4kKFwiI3VwZGF0ZS1idG5cIikuY2xpY2soIGZ1bmN0aW9uKCkge1xyXG4gICAgJCggXCIjdG9waWNNYXRlcmlhbEhpZGRlblwiICkucmVwbGFjZVdpdGgoICQoIFwiI3RvcGljTWF0ZXJpYWxcIiApICk7XHJcbiAgICAkKFwiLmZvcm1QcmV2ZW50XCIpLnN1Ym1pdCgpO1xyXG59KTtcclxuXHJcblxyXG5cclxuXHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/dashboard/materials/materialNew.js\n");

/***/ }),

/***/ 8:
/*!***************************************************************!*\
  !*** multi ./resources/js/dashboard/materials/materialNew.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\DarkProjects\Demo LMS\resources\js\dashboard\materials\materialNew.js */"./resources/js/dashboard/materials/materialNew.js");


/***/ })

/******/ });