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
/******/ 	return __webpack_require__(__webpack_require__.s = 3);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/bundles/bundlesMain.js":
/*!*******************************************************!*\
  !*** ./resources/js/dashboard/bundles/bundlesMain.js ***!
  \*******************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main */ \"./resources/js/dashboard/main.js\");\n //! EventListeners\n//!==================\n\n$(\"#submit-form-btn\").click(function () {\n  $(\"#new-bundle-form\").submit();\n});\n$(\"#bundle-table\").DataTable({\n  columns: [{\n    data: \"action\",\n    name: \"action\",\n    width: \"5%\",\n    orderable: false,\n    searchable: false\n  }, {\n    data: \"name\",\n    name: \"name\",\n    className: \"js-link cursor-pointer\"\n  }, {\n    data: \"active\",\n    name: \"active\",\n    width: \"5%\",\n    searchable: false\n  }, {\n    data: \"updated_at\",\n    name: \"updated_at\",\n    className: \"js-link cursor-pointer\"\n  }, {\n    data: \"created_at\",\n    name: \"created_at\",\n    className: \"js-link cursor-pointer\"\n  }],\n  processing: true,\n  serverSide: true,\n  ajax: {\n    url: \"/bundles/bundles-datatable\",\n    headers: {\n      'X-CSRF-TOKEN': $('meta[name=\"csrf-token\"]').attr('content')\n    },\n    type: \"post\"\n  },\n  language: {\n    emptyTable: \"Δεν υπάρχουν εγγραφές\",\n    info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n    infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n    lengthMenu: \"_MENU_ Αποτελέσματα ανα σελίδα\",\n    loadingRecords: \"Φόρτωση ...\",\n    processing: \"Επεξεργασία ...\",\n    search: \"Αναζήτηση: \",\n    zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n    paginate: {\n      previous: \"<i class='mdi mdi-chevron-left'>\",\n      next: \"<i class='mdi mdi-chevron-right'>\"\n    }\n  },\n  drawCallback: function drawCallback() {\n    $(\".dataTables_paginate > .pagination\").addClass(\"pagination-rounded\");\n    $(\".js-remove-table-classes > thead > tr > th\").removeClass(\"js-link cursor-pointer\");\n    jsLinkInit();\n    activeToggleInit();\n  }\n});\n\nfunction activeToggleInit() {\n  var toggle = $(\".js-toggle\");\n  toggle.change(function () {\n    var _this = this;\n\n    axios.patch(\"/bundles/bundles-toggle-active/\".concat(this.dataset.bundleId), {\n      state: this.checked ? 1 : 0\n    }).then(function (res) {\n      var icon = _this.checked ? \"success\" : \"info\";\n      var message = _this.checked ? \"Ενεργοποιήθηκε!\" : \"Απενεργοποιήθηκε\";\n      _main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].toastAlert(icon, message);\n    })[\"catch\"](function (err) {\n      _main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].toastAlert(\"error\", \"Παρουσιάστηκε κάποιο πρόβλημα ...\");\n    });\n  });\n}\n\nfunction jsLinkInit() {\n  $('.js-link').click(function () {\n    var bundleId = this.parentElement.dataset.bundleId;\n    window.location = \"bundle/\".concat(bundleId);\n  });\n}//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL2J1bmRsZXMvYnVuZGxlc01haW4uanM/Y2RhYSJdLCJuYW1lcyI6WyIkIiwiY2xpY2siLCJzdWJtaXQiLCJEYXRhVGFibGUiLCJjb2x1bW5zIiwiZGF0YSIsIm5hbWUiLCJ3aWR0aCIsIm9yZGVyYWJsZSIsInNlYXJjaGFibGUiLCJjbGFzc05hbWUiLCJwcm9jZXNzaW5nIiwic2VydmVyU2lkZSIsImFqYXgiLCJ1cmwiLCJoZWFkZXJzIiwiYXR0ciIsInR5cGUiLCJsYW5ndWFnZSIsImVtcHR5VGFibGUiLCJpbmZvIiwiaW5mb0VtcHR5IiwibGVuZ3RoTWVudSIsImxvYWRpbmdSZWNvcmRzIiwic2VhcmNoIiwiemVyb1JlY29yZHMiLCJwYWdpbmF0ZSIsInByZXZpb3VzIiwibmV4dCIsImRyYXdDYWxsYmFjayIsImFkZENsYXNzIiwicmVtb3ZlQ2xhc3MiLCJqc0xpbmtJbml0IiwiYWN0aXZlVG9nZ2xlSW5pdCIsInRvZ2dsZSIsImNoYW5nZSIsImF4aW9zIiwicGF0Y2giLCJkYXRhc2V0IiwiYnVuZGxlSWQiLCJzdGF0ZSIsImNoZWNrZWQiLCJ0aGVuIiwicmVzIiwiaWNvbiIsIm1lc3NhZ2UiLCJ1dGlsaXRpZXMiLCJ0b2FzdEFsZXJ0IiwiZXJyIiwicGFyZW50RWxlbWVudCIsIndpbmRvdyIsImxvY2F0aW9uIl0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBO0NBRUE7QUFDQTs7QUFFQUEsQ0FBQyxDQUFDLGtCQUFELENBQUQsQ0FBc0JDLEtBQXRCLENBQTZCLFlBQVc7QUFFdkNELEdBQUMsQ0FBQyxrQkFBRCxDQUFELENBQXNCRSxNQUF0QjtBQUVBLENBSkQ7QUFNQUYsQ0FBQyxDQUFDLGVBQUQsQ0FBRCxDQUFtQkcsU0FBbkIsQ0FBNkI7QUFDNUJDLFNBQU8sRUFBRSxDQUNSO0FBQUVDLFFBQUksRUFBRSxRQUFSO0FBQWtCQyxRQUFJLEVBQUUsUUFBeEI7QUFBa0NDLFNBQUssRUFBRSxJQUF6QztBQUErQ0MsYUFBUyxFQUFFLEtBQTFEO0FBQWlFQyxjQUFVLEVBQUU7QUFBN0UsR0FEUSxFQUVSO0FBQUVKLFFBQUksRUFBRSxNQUFSO0FBQWdCQyxRQUFJLEVBQUUsTUFBdEI7QUFBOEJJLGFBQVMsRUFBRTtBQUF6QyxHQUZRLEVBR1I7QUFBRUwsUUFBSSxFQUFFLFFBQVI7QUFBa0JDLFFBQUksRUFBRSxRQUF4QjtBQUFrQ0MsU0FBSyxFQUFFLElBQXpDO0FBQStDRSxjQUFVLEVBQUU7QUFBM0QsR0FIUSxFQUlSO0FBQUVKLFFBQUksRUFBRSxZQUFSO0FBQXNCQyxRQUFJLEVBQUUsWUFBNUI7QUFBMENJLGFBQVMsRUFBRTtBQUFyRCxHQUpRLEVBS1I7QUFBRUwsUUFBSSxFQUFFLFlBQVI7QUFBc0JDLFFBQUksRUFBRSxZQUE1QjtBQUEwQ0ksYUFBUyxFQUFFO0FBQXJELEdBTFEsQ0FEbUI7QUFRNUJDLFlBQVUsRUFBRSxJQVJnQjtBQVM1QkMsWUFBVSxFQUFFLElBVGdCO0FBVTVCQyxNQUFJLEVBQUU7QUFDTEMsT0FBRyxFQUFFLDRCQURBO0FBRUxDLFdBQU8sRUFBRTtBQUFDLHNCQUFnQmYsQ0FBQyxDQUFDLHlCQUFELENBQUQsQ0FBNkJnQixJQUE3QixDQUFrQyxTQUFsQztBQUFqQixLQUZKO0FBR0xDLFFBQUksRUFBRTtBQUhELEdBVnNCO0FBZTVCQyxVQUFRLEVBQUU7QUFDVEMsY0FBVSxFQUFJLHVCQURMO0FBRVRDLFFBQUksRUFBTSwrQ0FGRDtBQUdUQyxhQUFTLEVBQVEsMkJBSFI7QUFJVEMsY0FBVSxFQUFJLGdDQUpMO0FBS1RDLGtCQUFjLEVBQUcsYUFMUjtBQU1UWixjQUFVLEVBQUksaUJBTkw7QUFPVGEsVUFBTSxFQUFLLGFBUEY7QUFRVEMsZUFBVyxFQUFJLDJCQVJOO0FBU1RDLFlBQVEsRUFBQztBQUNSQyxjQUFRLEVBQUMsa0NBREQ7QUFFUkMsVUFBSSxFQUFDO0FBRkc7QUFUQSxHQWZrQjtBQTRCNUJDLGNBQVksRUFBQyx3QkFBVTtBQUN0QjdCLEtBQUMsQ0FBQyxvQ0FBRCxDQUFELENBQXdDOEIsUUFBeEMsQ0FBaUQsb0JBQWpEO0FBQ0E5QixLQUFDLENBQUMsNENBQUQsQ0FBRCxDQUFnRCtCLFdBQWhELENBQTRELHdCQUE1RDtBQUVBQyxjQUFVO0FBQ1ZDLG9CQUFnQjtBQUNoQjtBQWxDMkIsQ0FBN0I7O0FBcUNBLFNBQVNBLGdCQUFULEdBQTRCO0FBRTNCLE1BQUlDLE1BQU0sR0FBR2xDLENBQUMsQ0FBQyxZQUFELENBQWQ7QUFFQWtDLFFBQU0sQ0FBQ0MsTUFBUCxDQUFlLFlBQVc7QUFBQTs7QUFFekJDLFNBQUssQ0FBQ0MsS0FBTiwwQ0FBK0MsS0FBS0MsT0FBTCxDQUFhQyxRQUE1RCxHQUF3RTtBQUN2RUMsV0FBSyxFQUFFLEtBQUtDLE9BQUwsR0FBZSxDQUFmLEdBQW1CO0FBRDZDLEtBQXhFLEVBR0NDLElBSEQsQ0FHTyxVQUFDQyxHQUFELEVBQVM7QUFDZixVQUFJQyxJQUFJLEdBQUcsS0FBSSxDQUFDSCxPQUFMLEdBQWUsU0FBZixHQUEyQixNQUF0QztBQUNBLFVBQUlJLE9BQU8sR0FBRyxLQUFJLENBQUNKLE9BQUwsR0FBZSxpQkFBZixHQUFtQyxrQkFBakQ7QUFDQUssbURBQVMsQ0FBQ0MsVUFBVixDQUFzQkgsSUFBdEIsRUFBNEJDLE9BQTVCO0FBQ0EsS0FQRCxXQVFRLFVBQUNHLEdBQUQsRUFBUztBQUNoQkYsbURBQVMsQ0FBQ0MsVUFBVixDQUFzQixPQUF0QixFQUErQixtQ0FBL0I7QUFDQSxLQVZEO0FBV0EsR0FiRDtBQWNBOztBQUVELFNBQVNmLFVBQVQsR0FBc0I7QUFFckJoQyxHQUFDLENBQUMsVUFBRCxDQUFELENBQWNDLEtBQWQsQ0FBcUIsWUFBVztBQUMvQixRQUFJc0MsUUFBUSxHQUFHLEtBQUtVLGFBQUwsQ0FBbUJYLE9BQW5CLENBQTJCQyxRQUExQztBQUVBVyxVQUFNLENBQUNDLFFBQVAsb0JBQTRCWixRQUE1QjtBQUNBLEdBSkQ7QUFNQSIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvYnVuZGxlcy9idW5kbGVzTWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImltcG9ydCB1dGlsaXRpZXMgZnJvbSAnLi4vbWFpbic7XHJcblxyXG4vLyEgRXZlbnRMaXN0ZW5lcnNcclxuLy8hPT09PT09PT09PT09PT09PT09XHJcblxyXG4kKFwiI3N1Ym1pdC1mb3JtLWJ0blwiKS5jbGljayggZnVuY3Rpb24oKSB7XHJcblx0XHJcblx0JChcIiNuZXctYnVuZGxlLWZvcm1cIikuc3VibWl0KClcclxuXHJcbn0pO1xyXG5cclxuJChcIiNidW5kbGUtdGFibGVcIikuRGF0YVRhYmxlKHtcclxuXHRjb2x1bW5zOiBbXHJcblx0XHR7IGRhdGE6IFwiYWN0aW9uXCIsIG5hbWU6IFwiYWN0aW9uXCIsIHdpZHRoOiBcIjUlXCIsIG9yZGVyYWJsZTogZmFsc2UsIHNlYXJjaGFibGU6IGZhbHNlIH0sXHJcblx0XHR7IGRhdGE6IFwibmFtZVwiLCBuYW1lOiBcIm5hbWVcIiwgY2xhc3NOYW1lOiBcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXJcIn0sXHJcblx0XHR7IGRhdGE6IFwiYWN0aXZlXCIsIG5hbWU6IFwiYWN0aXZlXCIsIHdpZHRoOiBcIjUlXCIsIHNlYXJjaGFibGU6IGZhbHNlIH0sXHJcblx0XHR7IGRhdGE6IFwidXBkYXRlZF9hdFwiLCBuYW1lOiBcInVwZGF0ZWRfYXRcIiwgY2xhc3NOYW1lOiBcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXJcIn0sXHJcblx0XHR7IGRhdGE6IFwiY3JlYXRlZF9hdFwiLCBuYW1lOiBcImNyZWF0ZWRfYXRcIiwgY2xhc3NOYW1lOiBcImpzLWxpbmsgY3Vyc29yLXBvaW50ZXJcIn0sXHJcblx0XSxcclxuXHRwcm9jZXNzaW5nOiB0cnVlLFxyXG5cdHNlcnZlclNpZGU6IHRydWUsXHJcblx0YWpheDoge1xyXG5cdFx0dXJsOiBcIi9idW5kbGVzL2J1bmRsZXMtZGF0YXRhYmxlXCIsXHJcblx0XHRoZWFkZXJzOiB7J1gtQ1NSRi1UT0tFTic6ICQoJ21ldGFbbmFtZT1cImNzcmYtdG9rZW5cIl0nKS5hdHRyKCdjb250ZW50Jyl9LFxyXG5cdFx0dHlwZTogXCJwb3N0XCJcclxuXHR9LFxyXG5cdGxhbmd1YWdlOiB7XHJcblx0XHRlbXB0eVRhYmxlOiBcdFx0XCLOlM61zr0gz4XPgM6sz4HPh86/z4XOvSDOtc6zzrPPgc6xz4bOrc+CXCIsXHJcblx0XHRpbmZvOiBcdFx0XHRcdFwiX1NUQVJUXyDOrc+Jz4IgX0VORF8gzrHPgM6/IM+EzrEgX1RPVEFMXyDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRcdGluZm9FbXB0eTogICAgICBcdFwiMCDOsc+Azr8gMCDPhM6xIDAgzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXHJcblx0XHRsZW5ndGhNZW51OiBcdFx0XCJfTUVOVV8gzpHPgM6/z4TOtc67zq3Pg868zrHPhM6xIM6xzr3OsSDPg861zrvOr860zrFcIixcclxuXHRcdGxvYWRpbmdSZWNvcmRzOiBcdFwizqbPjM+Bz4TPic+DzrcgLi4uXCIsXHJcblx0XHRwcm9jZXNzaW5nOiBcdFx0XCLOlc+AzrXOvs61z4HOs86xz4POr86xIC4uLlwiLFxyXG5cdFx0c2VhcmNoOiBcdFx0XHRcIs6Rzr3Osc62zq7PhM63z4POtzogXCIsXHJcblx0XHR6ZXJvUmVjb3JkczogXHRcdFwizpTOtc69IM6yz4HOrc64zrfOus6xzr0gzrHPgM6/z4TOtc67zq3Pg868zrHPhM6xXCIsXHJcblx0XHRwYWdpbmF0ZTp7XHJcblx0XHRcdHByZXZpb3VzOlwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1sZWZ0Jz5cIixcclxuXHRcdFx0bmV4dDpcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tcmlnaHQnPlwifVxyXG5cdH0sXHJcblx0ZHJhd0NhbGxiYWNrOmZ1bmN0aW9uKCl7XHJcblx0XHQkKFwiLmRhdGFUYWJsZXNfcGFnaW5hdGUgPiAucGFnaW5hdGlvblwiKS5hZGRDbGFzcyhcInBhZ2luYXRpb24tcm91bmRlZFwiKTtcclxuXHRcdCQoXCIuanMtcmVtb3ZlLXRhYmxlLWNsYXNzZXMgPiB0aGVhZCA+IHRyID4gdGhcIikucmVtb3ZlQ2xhc3MoXCJqcy1saW5rIGN1cnNvci1wb2ludGVyXCIpO1xyXG5cclxuXHRcdGpzTGlua0luaXQoKTtcclxuXHRcdGFjdGl2ZVRvZ2dsZUluaXQoKTtcclxuXHR9XHJcbn0pXHJcblxyXG5mdW5jdGlvbiBhY3RpdmVUb2dnbGVJbml0KCkge1xyXG5cclxuXHRsZXQgdG9nZ2xlID0gJChcIi5qcy10b2dnbGVcIik7XHJcblxyXG5cdHRvZ2dsZS5jaGFuZ2UoIGZ1bmN0aW9uKCkge1xyXG5cclxuXHRcdGF4aW9zLnBhdGNoKCBgL2J1bmRsZXMvYnVuZGxlcy10b2dnbGUtYWN0aXZlLyR7dGhpcy5kYXRhc2V0LmJ1bmRsZUlkfWAsIHtcclxuXHRcdFx0c3RhdGU6IHRoaXMuY2hlY2tlZCA/IDEgOiAwXHJcblx0XHR9KVxyXG5cdFx0LnRoZW4oIChyZXMpID0+IHtcclxuXHRcdFx0bGV0IGljb24gPSB0aGlzLmNoZWNrZWQgPyBcInN1Y2Nlc3NcIiA6IFwiaW5mb1wiO1xyXG5cdFx0XHRsZXQgbWVzc2FnZSA9IHRoaXMuY2hlY2tlZCA/IFwizpXOvc61z4HOs86/z4DOv865zq7OuM63zrrOtSFcIiA6IFwizpHPgM61zr3Otc+BzrPOv8+Azr/Ouc6uzrjOt866zrVcIjtcclxuXHRcdFx0dXRpbGl0aWVzLnRvYXN0QWxlcnQoIGljb24sIG1lc3NhZ2UgKTtcclxuXHRcdH0pXHJcblx0XHQuY2F0Y2goIChlcnIpID0+IHtcclxuXHRcdFx0dXRpbGl0aWVzLnRvYXN0QWxlcnQoIFwiZXJyb3JcIiwgXCLOoM6xz4HOv8+Fz4POuc6sz4PPhM63zrrOtSDOus6sz4DOv865zr8gz4DPgc+MzrLOu863zrzOsSAuLi5cIiApO1xyXG5cdFx0fSlcclxuXHR9KTtcclxufVxyXG5cclxuZnVuY3Rpb24ganNMaW5rSW5pdCgpIHtcclxuXHJcblx0JCgnLmpzLWxpbmsnKS5jbGljayggZnVuY3Rpb24oKSB7XHJcblx0XHRsZXQgYnVuZGxlSWQgPSB0aGlzLnBhcmVudEVsZW1lbnQuZGF0YXNldC5idW5kbGVJZDtcclxuXHJcblx0XHR3aW5kb3cubG9jYXRpb24gPSBgYnVuZGxlLyR7YnVuZGxlSWR9YDtcclxuXHR9KTtcclxuXHJcbn0iXSwic291cmNlUm9vdCI6IiJ9\n//# sourceURL=webpack-internal:///./resources/js/dashboard/bundles/bundlesMain.js\n");

/***/ }),

/***/ "./resources/js/dashboard/main.js":
/*!****************************************!*\
  !*** ./resources/js/dashboard/main.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciJdLCJtYXBwaW5ncyI6IkFBQ0E7QUFBQSxTQUFTQSxVQUFULENBQXFCQyxJQUFyQixFQUEyQkMsT0FBM0IsRUFBcUM7QUFDcENDLE1BQUksQ0FBQ0MsSUFBTCxDQUFVO0FBQ1JDLFNBQUssRUFBRSxNQURDO0FBRVJDLFlBQVEsRUFBRSxTQUZGO0FBR1JMLFFBQUksRUFBRUEsSUFIRTtBQUlSTSxTQUFLLEVBQUVMLE9BSkM7QUFLUk0scUJBQWlCLEVBQUUsS0FMWDtBQU1SQyxTQUFLLEVBQUUsSUFOQztBQU9OQyxvQkFBZ0IsRUFBRTtBQVBaLEdBQVY7QUFTQTs7QUFFRCxTQUFTQyxvQkFBVCxDQUErQkMsSUFBL0IsRUFBcUNDLEtBQXJDLEVBQTRDO0FBRTNDLE9BQU0sSUFBSUMsQ0FBQyxHQUFHLENBQWQsRUFBaUJBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUEzQixFQUFtQ0QsQ0FBQyxFQUFwQyxFQUF5QztBQUN4QyxRQUFLLENBQUNELEtBQUssQ0FBQ0MsQ0FBRCxDQUFMLENBQVNFLE9BQWYsRUFBeUI7QUFDeEJKLFVBQUksQ0FBQ0ksT0FBTCxHQUFlLEtBQWY7QUFDQTtBQUNBLEtBSEQsTUFJSztBQUNKSixVQUFJLENBQUNJLE9BQUwsR0FBZSxJQUFmO0FBQ0E7QUFDRDtBQUVEOztBQUVELFNBQVNDLHFCQUFULENBQWdDTCxJQUFoQyxFQUFzQ0MsS0FBdEMsRUFBOEM7QUFFN0MsTUFBS0QsSUFBSSxDQUFDSSxPQUFWLEVBQW9CO0FBQ25CLFNBQU0sSUFBSUYsQ0FBQyxHQUFHLENBQWQsRUFBaUJBLENBQUMsR0FBR0QsS0FBSyxDQUFDRSxNQUEzQixFQUFtQ0QsQ0FBQyxFQUFwQyxFQUF5QztBQUN4Q0QsV0FBSyxDQUFDQyxDQUFELENBQUwsQ0FBU0UsT0FBVCxHQUFtQixJQUFuQjtBQUNBO0FBQ0QsR0FKRCxNQUtLO0FBQ0osU0FBTSxJQUFJRixFQUFDLEdBQUcsQ0FBZCxFQUFpQkEsRUFBQyxHQUFHRCxLQUFLLENBQUNFLE1BQTNCLEVBQW1DRCxFQUFDLEVBQXBDLEVBQXlDO0FBQ3hDRCxXQUFLLENBQUNDLEVBQUQsQ0FBTCxDQUFTRSxPQUFULEdBQW1CLEtBQW5CO0FBQ0E7QUFDRDtBQUVEOztBQUVjO0FBQ2RoQixZQUFVLEVBQVZBLFVBRGM7QUFFZFcsc0JBQW9CLEVBQXBCQSxvQkFGYztBQUdkTSx1QkFBcUIsRUFBckJBO0FBSGMsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbIlxyXG5mdW5jdGlvbiB0b2FzdEFsZXJ0KCBpY29uLCBtZXNzYWdlICkge1xyXG5cdFN3YWwuZmlyZSh7XHJcblx0XHRcdHRvYXN0OiAndHJ1ZScsXHJcblx0XHRcdHBvc2l0aW9uOiAndG9wLWVuZCcsXHJcblx0XHRcdGljb246IGljb24sXHJcblx0XHRcdHRpdGxlOiBtZXNzYWdlLFxyXG5cdFx0XHRzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXHJcblx0XHRcdHRpbWVyOiAzMDAwLFxyXG5cdFx0XHQgIHRpbWVyUHJvZ3Jlc3NCYXI6IHRydWVcclxuXHRcdH0pO1xyXG59XHJcblxyXG5mdW5jdGlvbiBtYWluQ2hlY2tib3hTd2l0Y2hlciggbWFpbiwgbWlub3IpIHtcclxuXHJcblx0Zm9yICggbGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKysgKSB7XHJcblx0XHRpZiAoICFtaW5vcltpXS5jaGVja2VkICkge1xyXG5cdFx0XHRtYWluLmNoZWNrZWQgPSBmYWxzZTtcclxuXHRcdFx0YnJlYWs7XHJcblx0XHR9XHJcblx0XHRlbHNlIHtcclxuXHRcdFx0bWFpbi5jaGVja2VkID0gdHJ1ZTtcclxuXHRcdH1cclxuXHR9XHJcblxyXG59XHJcblxyXG5mdW5jdGlvbiBtaW5vckNoZWNrYm94U3dpdGNoZXIoIG1haW4sIG1pbm9yICkge1xyXG5cclxuXHRpZiAoIG1haW4uY2hlY2tlZCApIHtcclxuXHRcdGZvciAoIGxldCBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrICkge1xyXG5cdFx0XHRtaW5vcltpXS5jaGVja2VkID0gdHJ1ZTtcclxuXHRcdH1cclxuXHR9XHJcblx0ZWxzZSB7XHJcblx0XHRmb3IgKCBsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKyApIHtcclxuXHRcdFx0bWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xyXG5cdFx0fVxyXG5cdH1cclxuXHJcbn1cclxuXHJcbmV4cG9ydCBkZWZhdWx0IHtcclxuXHR0b2FzdEFsZXJ0LFxyXG5cdG1haW5DaGVja2JveFN3aXRjaGVyLFxyXG5cdG1pbm9yQ2hlY2tib3hTd2l0Y2hlclxyXG59XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 3:
/*!*************************************************************!*\
  !*** multi ./resources/js/dashboard/bundles/bundlesMain.js ***!
  \*************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\Real Projects\Demo LMS\resources\js\dashboard\bundles\bundlesMain.js */"./resources/js/dashboard/bundles/bundlesMain.js");


/***/ })

/******/ });