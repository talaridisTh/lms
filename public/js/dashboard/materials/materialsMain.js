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
/******/ 	return __webpack_require__(__webpack_require__.s = 5);
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
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().prependTo('#containerCol');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar selectAndDeselectCheckbox = function selectAndDeselectCheckbox(attr) {\n  $(attr).click(function () {\n    var checkbox = $(attr);\n\n    for (var i = 0; i < checkbox.length; i++) {\n      checkbox[i].checked = !checkbox[i].checked;\n    }\n\n    if (this.checked) {\n      this.innerHTML = '<i class=\" h3 mdi mdi-checkbox-multiple-blank-outline\"></i>';\n    } else {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-marked-outline\"></i>\\n';\n    }\n  });\n};\n\nvar tableLocale = {\n  emptyTable: \"Δεν υπάρχουν εγγραφές\",\n  info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n  infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n  lengthMenu: \"_MENU_\",\n  loadingRecords: \"Φόρτωση ...\",\n  processing: \"Επεξεργασία ...\",\n  search: \"\",\n  searchPlaceholder: \"Αναζήτηση... \",\n  zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n  paginate: {\n    previous: \"<i class='mdi mdi-chevron-left'>\",\n    next: \"<i class='mdi mdi-chevron-right'>\"\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  selectAndDeselectCheckbox: selectAndDeselectCheckbox,\n  tableLocale: tableLocale\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciIsImZpbHRlckJ1dHRvbiIsImF0dHIiLCJjb2x1bW4iLCJ0YWJsZSIsIiQiLCJkZXRhY2giLCJwcmVwZW5kVG8iLCJvbiIsImNvbHVtbnMiLCJzZWFyY2giLCJ2YWx1ZSIsImRyYXciLCJzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94IiwiY2xpY2siLCJjaGVja2JveCIsImlubmVySFRNTCIsInRhYmxlTG9jYWxlIiwiZW1wdHlUYWJsZSIsImluZm8iLCJpbmZvRW1wdHkiLCJsZW5ndGhNZW51IiwibG9hZGluZ1JlY29yZHMiLCJwcm9jZXNzaW5nIiwic2VhcmNoUGxhY2Vob2xkZXIiLCJ6ZXJvUmVjb3JkcyIsInBhZ2luYXRlIiwicHJldmlvdXMiLCJuZXh0Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBLFNBQVNBLFVBQVQsQ0FBb0JDLElBQXBCLEVBQTBCQyxPQUExQixFQUFtQztBQUMvQkMsTUFBSSxDQUFDQyxJQUFMLENBQVU7QUFDTkMsU0FBSyxFQUFFLE1BREQ7QUFFTkMsWUFBUSxFQUFFLFNBRko7QUFHTkwsUUFBSSxFQUFFQSxJQUhBO0FBSU5NLFNBQUssRUFBRUwsT0FKRDtBQUtOTSxxQkFBaUIsRUFBRSxLQUxiO0FBTU5DLFNBQUssRUFBRSxJQU5EO0FBT05DLG9CQUFnQixFQUFFO0FBUFosR0FBVjtBQVNIOztBQUVELFNBQVNDLG9CQUFULENBQThCQyxJQUE5QixFQUFvQ0MsS0FB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QyxjQUFZLEVBQVpBLFlBSlc7QUFLZFksMkJBQXlCLEVBQXpCQSx5QkFMYztBQU1kSSxhQUFXLEVBQVhBO0FBTmMsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xyXG4gICAgU3dhbC5maXJlKHtcclxuICAgICAgICB0b2FzdDogJ3RydWUnLFxyXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXHJcbiAgICAgICAgaWNvbjogaWNvbixcclxuICAgICAgICB0aXRsZTogbWVzc2FnZSxcclxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXHJcbiAgICAgICAgdGltZXI6IDMwMDAsXHJcbiAgICAgICAgdGltZXJQcm9ncmVzc0JhcjogdHJ1ZVxyXG4gICAgfSk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XHJcblxyXG4gICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgIGlmICghbWlub3JbaV0uY2hlY2tlZCkge1xyXG4gICAgICAgICAgICBtYWluLmNoZWNrZWQgPSBmYWxzZTtcclxuICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gdHJ1ZTtcclxuICAgICAgICB9XHJcbiAgICB9XHJcblxyXG59XHJcblxyXG5mdW5jdGlvbiBtaW5vckNoZWNrYm94U3dpdGNoZXIobWFpbiwgbWlub3IpIHtcclxuXHJcbiAgICBpZiAobWFpbi5jaGVja2VkKSB7XHJcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgICAgICBtaW5vcltpXS5jaGVja2VkID0gdHJ1ZTtcclxuICAgICAgICB9XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgbWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxuXHJcbn1cclxuXHJcbmNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XHJcbiAgICAkKGF0dHIpLmRldGFjaCgpLnByZXBlbmRUbygnI2NvbnRhaW5lckNvbCcpXHJcblxyXG5cclxuICAgICQoYXR0cikub24oJ2NoYW5nZScsIGZ1bmN0aW9uICgpIHtcclxuICAgICAgICB0YWJsZS5jb2x1bW5zKGNvbHVtbikuc2VhcmNoKHRoaXMudmFsdWUpLmRyYXcoKTtcclxuICAgIH0pO1xyXG59XHJcblxyXG5jb25zdCBzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94ID0gZnVuY3Rpb24gKGF0dHIpIHtcclxuICAgICQoYXR0cikuY2xpY2soZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIGxldCBjaGVja2JveCA9ICQoYXR0cilcclxuXHJcblxyXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgY2hlY2tib3hbaV0uY2hlY2tlZCA9ICFjaGVja2JveFtpXS5jaGVja2VkXHJcbiAgICAgICAgfVxyXG5cclxuICAgICAgICBpZiAodGhpcy5jaGVja2VkKSB7XHJcbiAgICAgICAgICAgIHRoaXMuaW5uZXJIVE1MID0gJzxpIGNsYXNzPVwiIGgzIG1kaSBtZGktY2hlY2tib3gtbXVsdGlwbGUtYmxhbmstb3V0bGluZVwiPjwvaT4nXHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgdGhpcy5pbm5lckhUTUwgPSAnPGkgY2xhc3M9XCJoMyBtZGkgbWRpLWNoZWNrYm94LW1hcmtlZC1vdXRsaW5lXCI+PC9pPlxcbidcclxuICAgICAgICB9XHJcbiAgICB9KVxyXG59XHJcblxyXG5jb25zdCB0YWJsZUxvY2FsZSA9IHtcclxuXHRlbXB0eVRhYmxlOiBcdFx0XCLOlM61zr0gz4XPgM6sz4HPh86/z4XOvSDOtc6zzrPPgc6xz4bOrc+CXCIsXHJcblx0aW5mbzogXHRcdFx0XHRcIl9TVEFSVF8gzq3Pic+CIF9FTkRfIM6xz4DOvyDPhM6xIF9UT1RBTF8gzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXHJcblx0aW5mb0VtcHR5OiAgICAgIFx0XCIwIM6xz4DOvyAwIM+EzrEgMCDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRsZW5ndGhNZW51OiBcdFx0XCJfTUVOVV9cIixcclxuXHRsb2FkaW5nUmVjb3JkczogXHRcIs6mz4zPgc+Ez4nPg863IC4uLlwiLFxyXG5cdHByb2Nlc3Npbmc6IFx0XHRcIs6Vz4DOtc6+zrXPgc6zzrHPg86vzrEgLi4uXCIsXHJcblx0c2VhcmNoOiBcdFx0XHRcIlwiLFxyXG5cdHNlYXJjaFBsYWNlaG9sZGVyOiBcdFwizpHOvc6xzrbOrs+EzrfPg863Li4uIFwiLFxyXG5cdHplcm9SZWNvcmRzOiBcdFx0XCLOlM61zr0gzrLPgc6tzrjOt866zrHOvSDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRwYWdpbmF0ZTp7XHJcblx0XHRwcmV2aW91czpcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tbGVmdCc+XCIsXHJcblx0XHRuZXh0OlwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1yaWdodCc+XCJ9XHJcbn1cclxuXHJcblxyXG5leHBvcnQgZGVmYXVsdCB7XHJcbiAgICB0b2FzdEFsZXJ0LFxyXG4gICAgbWFpbkNoZWNrYm94U3dpdGNoZXIsXHJcbiAgICBtaW5vckNoZWNrYm94U3dpdGNoZXIsXHJcbiAgICBmaWx0ZXJCdXR0b24sXHJcblx0c2VsZWN0QW5kRGVzZWxlY3RDaGVja2JveCxcclxuXHR0YWJsZUxvY2FsZVxyXG59XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ "./resources/js/dashboard/materials/materialsMain.js":
/*!***********************************************************!*\
  !*** ./resources/js/dashboard/materials/materialsMain.js ***!
  \***********************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main */ \"./resources/js/dashboard/main.js\");\n\nvar materialsDatatable = $(\"#materials-datatable\").DataTable({\n  dom: 'lfrtip',\n  order: [1, \"asc\"],\n  processing: true,\n  serverSide: true,\n  ajax: {\n    url: \"/materials/materials-datatable\",\n    headers: {\n      'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')\n    },\n    type: \"post\"\n  },\n  columns: [{\n    data: \"action\",\n    name: \"action\",\n    width: \"5%\",\n    searchable: false,\n    orderable: false\n  }, {\n    data: \"title\",\n    name: \"title\",\n    className: \"js-link cursor-pointer\"\n  }, {\n    data: \"active\",\n    name: \"active\",\n    width: \"5%\",\n    searchable: false\n  }, {\n    data: \"type\",\n    name: \"type\",\n    className: \"js-link cursor-pointer\"\n  }, {\n    data: \"updated_at\",\n    name: \"updated_at\",\n    className: \"js-link cursor-pointer js-updated-at\"\n  }, {\n    data: \"created_at\",\n    name: \"created_at\",\n    className: \"js-link cursor-pointer\"\n  }],\n  language: {\n    emptyTable: \"Δεν υπάρχουν εγγραφές\",\n    info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n    infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n    lengthMenu: \"_MENU_ Αποτελέσματα ανα σελίδα\",\n    loadingRecords: \"Φόρτωση ...\",\n    processing: \"Επεξεργασία ...\",\n    search: \"Αναζήτηση: \",\n    zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n    paginate: {\n      previous: \"<i class='mdi mdi-chevron-left'>\",\n      next: \"<i class='mdi mdi-chevron-right'>\"\n    }\n  },\n  drawCallback: function drawCallback() {\n    $(\".dataTables_paginate > .pagination\").addClass(\"pagination-rounded\");\n    $(\".js-remove-table-classes > thead > tr > th\").removeClass(\"js-link cursor-pointer js-updated-at\");\n    atLinkEventListener();\n    toggleInit();\n  }\n});\n\nfunction toggleInit() {\n  $(\".js-toggle\").change(function () {\n    var _this = this;\n\n    var materialId = this.dataset.materialId;\n    var updatedAtCnt = this.parentElement.parentElement.getElementsByClassName(\"js-updated-at\")[0];\n    axios.patch(\"/materials/toggle-active/\".concat(materialId), {\n      state: this.checked ? 1 : 0\n    }).then(function (res) {\n      var icon = _this.checked ? \"success\" : \"info\";\n      var message = _this.checked ? \"Ενεργοποιήθηκε\" : \"Απενεργοποιήθηκε\";\n      _main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].toastAlert(icon, message);\n      updatedAtCnt.textContent = \"Μόλις τώρα\";\n    })[\"catch\"](function (err) {\n      _main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].toastAlert(\"error\", \"Παρουσιάστηκε κάποιο πρόβλημα ...\");\n    });\n  });\n}\n\nfunction atLinkEventListener() {\n  $('.js-link').click(function () {\n    var materialId = this.parentElement.dataset.materialId;\n    window.location = \"material/\".concat(materialId);\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21hdGVyaWFscy9tYXRlcmlhbHNNYWluLmpzP2YzZjkiXSwibmFtZXMiOlsibWF0ZXJpYWxzRGF0YXRhYmxlIiwiJCIsIkRhdGFUYWJsZSIsImRvbSIsIm9yZGVyIiwicHJvY2Vzc2luZyIsInNlcnZlclNpZGUiLCJhamF4IiwidXJsIiwiaGVhZGVycyIsImF0dHIiLCJ0eXBlIiwiY29sdW1ucyIsImRhdGEiLCJuYW1lIiwid2lkdGgiLCJzZWFyY2hhYmxlIiwib3JkZXJhYmxlIiwiY2xhc3NOYW1lIiwibGFuZ3VhZ2UiLCJlbXB0eVRhYmxlIiwiaW5mbyIsImluZm9FbXB0eSIsImxlbmd0aE1lbnUiLCJsb2FkaW5nUmVjb3JkcyIsInNlYXJjaCIsInplcm9SZWNvcmRzIiwicGFnaW5hdGUiLCJwcmV2aW91cyIsIm5leHQiLCJkcmF3Q2FsbGJhY2siLCJhZGRDbGFzcyIsInJlbW92ZUNsYXNzIiwiYXRMaW5rRXZlbnRMaXN0ZW5lciIsInRvZ2dsZUluaXQiLCJjaGFuZ2UiLCJtYXRlcmlhbElkIiwiZGF0YXNldCIsInVwZGF0ZWRBdENudCIsInBhcmVudEVsZW1lbnQiLCJnZXRFbGVtZW50c0J5Q2xhc3NOYW1lIiwiYXhpb3MiLCJwYXRjaCIsInN0YXRlIiwiY2hlY2tlZCIsInRoZW4iLCJyZXMiLCJpY29uIiwibWVzc2FnZSIsInV0aWxpdGllcyIsInRvYXN0QWxlcnQiLCJ0ZXh0Q29udGVudCIsImVyciIsImNsaWNrIiwid2luZG93IiwibG9jYXRpb24iXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7QUFBQTtBQUVBLElBQU1BLGtCQUFrQixHQUFHQyxDQUFDLENBQUMsc0JBQUQsQ0FBRCxDQUEwQkMsU0FBMUIsQ0FBb0M7QUFDOURDLEtBQUcsRUFBRSxRQUR5RDtBQUc5REMsT0FBSyxFQUFFLENBQUMsQ0FBRCxFQUFJLEtBQUosQ0FIdUQ7QUFJOURDLFlBQVUsRUFBRSxJQUprRDtBQUs5REMs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L0I7QUFDQSxLQVhEO0FBWUEsR0FqQkQ7QUFrQkE7O0FBRUQsU0FBU2pCLG1CQUFULEdBQStCO0FBQzlCaEMsR0FBQyxDQUFDLFVBQUQsQ0FBRCxDQUFjb0QsS0FBZCxDQUFxQixZQUFXO0FBQy9CLFFBQUlqQixVQUFVLEdBQUcsS0FBS0csYUFBTCxDQUFtQkYsT0FBbkIsQ0FBMkJELFVBQTVDO0FBRUFrQixVQUFNLENBQUNDLFFBQVAsc0JBQThCbkIsVUFBOUI7QUFDQSxHQUpEO0FBS0EiLCJmaWxlIjoiLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21hdGVyaWFscy9tYXRlcmlhbHNNYWluLmpzLmpzIiwic291cmNlc0NvbnRlbnQiOlsiaW1wb3J0IHV0aWxpdGllcyBmcm9tICcuLi9tYWluJztcclxuXHJcbmNvbnN0IG1hdGVyaWFsc0RhdGF0YWJsZSA9ICQoXCIjbWF0ZXJpYWxzLWRhdGF0YWJsZVwiKS5EYXRhVGFibGUoe1xyXG5cdGRvbTogJ2xmcnRpcCcsXHJcblxyXG5cdG9yZGVyOiBbMSwgXCJhc2NcIl0sXHJcblx0cHJvY2Vzc2luZzogdHJ1ZSxcclxuXHRzZXJ2ZXJTaWRlOiB0cnVlLFxyXG5cdGFqYXg6IHtcclxuXHRcdHVybDogXCIvbWF0ZXJpYWxzL21hdGVyaWFscy1kYXRhdGFibGVcIixcclxuXHRcdGhlYWRlcnM6IHsnWC1DU1JGLVRPS0VOJzogJCgnbWV0YVtuYW1lPVwiY3NyZi10b2tlblwiXScpLmF0dHIoJ2NvbnRlbnQnKX0sXHJcblx0XHR0eXBlOiBcInBvc3RcIlxyXG5cdH0sXHJcblx0Y29sdW1uczogW1xyXG5cdFx0eyBkYXRhOiBcImFjdGlvblwiLCBuYW1lOiBcImFjdGlvblwiLCB3aWR0aDogXCI1JVwiLCBzZWFyY2hhYmxlOiBmYWxzZSwgb3JkZXJhYmxlOiBmYWxzZSB9LFxyXG5cdFx0eyBkYXRhOiBcInRpdGxlXCIsIG5hbWU6IFwidGl0bGVcIiwgY2xhc3NOYW1lOiBcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXJcIiB9LFxyXG5cdFx0eyBkYXRhOiBcImFjdGl2ZVwiLCBuYW1lOiBcImFjdGl2ZVwiLCB3aWR0aDogXCI1JVwiLCBzZWFyY2hhYmxlOiBmYWxzZSB9LFxyXG5cdFx0eyBkYXRhOiBcInR5cGVcIiwgbmFtZTogXCJ0eXBlXCIsIGNsYXNzTmFtZTogXCJqcy1saW5rIGN1cnNvci1wb2ludGVyXCIgfSxcclxuXHRcdHsgZGF0YTogXCJ1cGRhdGVkX2F0XCIsIG5hbWU6IFwidXBkYXRlZF9hdFwiLCAgY2xhc3NOYW1lOiBcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXIganMtdXBkYXRlZC1hdFwiIH0sXHJcblx0XHR7IGRhdGE6IFwiY3JlYXRlZF9hdFwiLCBuYW1lOiBcImNyZWF0ZWRfYXRcIiwgIGNsYXNzTmFtZTogXCJqcy1saW5rIGN1cnNvci1wb2ludGVyXCIgfSxcclxuXHRdLFxyXG5cdGxhbmd1YWdlOntcclxuXHRcdGVtcHR5VGFibGU6IFx0XHRcIs6UzrXOvSDPhc+AzqzPgc+Hzr/Phc69IM61zrPOs8+BzrHPhs6tz4JcIixcclxuXHRcdGluZm86IFx0XHRcdFx0XCJfU1RBUlRfIM6tz4nPgiBfRU5EXyDOsc+Azr8gz4TOsSBfVE9UQUxfIM6xz4DOv8+EzrXOu86tz4POvM6xz4TOsVwiLFxyXG5cdFx0aW5mb0VtcHR5OiAgICAgIFx0XCIwIM6xz4DOvyAwIM+EzrEgMCDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRcdGxlbmd0aE1lbnU6IFx0XHRcIl9NRU5VXyDOkc+Azr/PhM61zrvOrc+DzrzOsc+EzrEgzrHOvc6xIM+DzrXOu86vzrTOsVwiLFxyXG5cdFx0bG9hZGluZ1JlY29yZHM6IFx0XCLOps+Mz4HPhM+Jz4POtyAuLi5cIixcclxuXHRcdHByb2Nlc3Npbmc6IFx0XHRcIs6Vz4DOtc6+zrXPgc6zzrHPg86vzrEgLi4uXCIsXHJcblx0XHRzZWFyY2g6IFx0XHRcdFwizpHOvc6xzrbOrs+EzrfPg863OiBcIixcclxuXHRcdHplcm9SZWNvcmRzOiBcdFx0XCLOlM61zr0gzrLPgc6tzrjOt866zrHOvSDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRcdHBhZ2luYXRlOntcclxuXHRcdFx0cHJldmlvdXM6XCI8aSBjbGFzcz0nbWRpIG1kaS1jaGV2cm9uLWxlZnQnPlwiLFxyXG5cdFx0XHRuZXh0OlwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1yaWdodCc+XCJ9XHJcblx0fSxcclxuXHRkcmF3Q2FsbGJhY2s6ZnVuY3Rpb24oKXtcclxuXHRcdCQoXCIuZGF0YVRhYmxlc19wYWdpbmF0ZSA+IC5wYWdpbmF0aW9uXCIpLmFkZENsYXNzKFwicGFnaW5hdGlvbi1yb3VuZGVkXCIpO1xyXG5cdFx0JChcIi5qcy1yZW1vdmUtdGFibGUtY2xhc3NlcyA+IHRoZWFkID4gdHIgPiB0aFwiKS5yZW1vdmVDbGFzcyhcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXIganMtdXBkYXRlZC1hdFwiKTtcclxuXHRcdGF0TGlua0V2ZW50TGlzdGVuZXIoKTtcclxuXHRcdHRvZ2dsZUluaXQoKTtcclxuXHR9XHJcbn0pO1xyXG5cclxuXHJcbmZ1bmN0aW9uIHRvZ2dsZUluaXQoKSB7XHJcblx0JChcIi5qcy10b2dnbGVcIikuY2hhbmdlKCBmdW5jdGlvbigpIHtcclxuXHJcblx0XHRsZXQgbWF0ZXJpYWxJZCA9IHRoaXMuZGF0YXNldC5tYXRlcmlhbElkXHJcblx0XHRsZXQgdXBkYXRlZEF0Q250ID0gdGhpcy5wYXJlbnRFbGVtZW50LnBhcmVudEVsZW1lbnQuZ2V0RWxlbWVudHNCeUNsYXNzTmFtZShcImpzLXVwZGF0ZWQtYXRcIilbMF07XHJcblx0XHRcclxuXHRcdGF4aW9zLnBhdGNoKCBgL21hdGVyaWFscy90b2dnbGUtYWN0aXZlLyR7bWF0ZXJpYWxJZH1gLCB7XHJcblx0XHRcdHN0YXRlOiB0aGlzLmNoZWNrZWQgPyAxIDogMFxyXG5cdFx0fSlcclxuXHRcdC50aGVuKCAocmVzKSA9PiB7XHJcblx0XHRcdGxldCBpY29uID0gdGhpcy5jaGVja2VkID8gXCJzdWNjZXNzXCIgOiBcImluZm9cIjtcclxuXHRcdFx0bGV0IG1lc3NhZ2UgPSB0aGlzLmNoZWNrZWQgPyBcIs6Vzr3Otc+BzrPOv8+Azr/Ouc6uzrjOt866zrVcIiA6IFwizpHPgM61zr3Otc+BzrPOv8+Azr/Ouc6uzrjOt866zrVcIjtcclxuXHRcdFx0dXRpbGl0aWVzLnRvYXN0QWxlcnQoIGljb24sIG1lc3NhZ2UgKTtcclxuXHRcdFx0dXBkYXRlZEF0Q250LnRleHRDb250ZW50ID0gXCLOnM+MzrvOuc+CIM+Ez47Pgc6xXCI7XHJcblx0XHR9KVxyXG5cdFx0LmNhdGNoKCAoZXJyKSA9PiB7XHJcblx0XHRcdHV0aWxpdGllcy50b2FzdEFsZXJ0KCBcImVycm9yXCIsIFwizqDOsc+Bzr/Phc+DzrnOrM+Dz4TOt866zrUgzrrOrM+Azr/Ouc6/IM+Az4HPjM6yzrvOt868zrEgLi4uXCIgKTtcclxuXHRcdH0pXHJcblx0fSk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIGF0TGlua0V2ZW50TGlzdGVuZXIoKSB7XHJcblx0JCgnLmpzLWxpbmsnKS5jbGljayggZnVuY3Rpb24oKSB7XHJcblx0XHRsZXQgbWF0ZXJpYWxJZCA9IHRoaXMucGFyZW50RWxlbWVudC5kYXRhc2V0Lm1hdGVyaWFsSWQ7XHJcblxyXG5cdFx0d2luZG93LmxvY2F0aW9uID0gYG1hdGVyaWFsLyR7bWF0ZXJpYWxJZH1gO1xyXG5cdH0pO1xyXG59Il0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/materials/materialsMain.js\n");

/***/ }),

/***/ 5:
/*!*****************************************************************!*\
  !*** multi ./resources/js/dashboard/materials/materialsMain.js ***!
  \*****************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\DarkProjects\lmsdemo\resources\js\dashboard\materials\materialsMain.js */"./resources/js/dashboard/materials/materialsMain.js");


/***/ })

/******/ });