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
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().appendTo('.dataTables_length label');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar selectAndDeselectCheckbox = function selectAndDeselectCheckbox(attr) {\n  $(attr).click(function () {\n    var checkbox = $(attr);\n\n    for (var i = 0; i < checkbox.length; i++) {\n      checkbox[i].checked = !checkbox[i].checked;\n    }\n\n    if (this.checked) {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-multiple-blank-outline\"></i>';\n    } else {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-marked-outline\"></i>\\n';\n    }\n\n    if (this.childNodes[0].className == \"h3 mdi mdi-checkbox-multiple-blank-outline\") {\n      for (var _i2 = 0; _i2 < checkbox.length; _i2++) {\n        checkbox[_i2].checked = true;\n      }\n\n      $(\".bulk-action\")[0].hidden = false;\n      var checkboxes = document.querySelectorAll(\".js-user-checkbox:checked\").length;\n      $(\".bulk-action\")[0].innerText = \" \\u0395\\u03C0\\u03B9\\u03BB\\u03BF\\u03B3\\u03AD\\u03C2 \".concat(checkboxes == 0 ? \"\" : \"( \".concat(checkboxes, \" ) \"), \" \");\n    } else {\n      for (var _i3 = 0; _i3 < checkbox.length; _i3++) {\n        checkbox[_i3].checked = false;\n      }\n\n      $(\".bulk-action\")[0].hidden = true;\n    }\n  });\n};\n\nvar changeInputHidden = function changeInputHidden(attr, hiddenAttr) {\n  $(attr).change(function () {\n    if (attr == \"#activeMaterial\") {\n      this.value = $(this).prop('checked') == true ? 1 : 0;\n    }\n\n    console.log($(hiddenAttr));\n    var hiddenValue = $(hiddenAttr)[0].value = this.value;\n  });\n};\n\nvar tableLocale = {\n  emptyTable: \"Δεν υπάρχουν εγγραφές\",\n  info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n  infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n  lengthMenu: \"_MENU_\",\n  loadingRecords: \"Φόρτωση ...\",\n  processing: \"Επεξεργασία ...\",\n  search: \"\",\n  searchPlaceholder: \"Αναζήτηση... \",\n  zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n  paginate: {\n    previous: \"<i class='mdi mdi-chevron-left'>\",\n    next: \"<i class='mdi mdi-chevron-right'>\"\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  selectAndDeselectCheckbox: selectAndDeselectCheckbox,\n  tableLocale: tableLocale,\n  changeInputHidden: changeInputHidden\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciIsImZpbHRlckJ1dHRvbiIsImF0dHIiLCJjb2x1bW4iLCJ0YWJsZSIsIiQiLCJkZXRhY2giLCJhcHBlbmRUbyIsIm9uIiwiY29sdW1ucyIsInNlYXJjaCIsInZhbHVlIiwiZHJhdyIsInNlbGVjdEFuZERlc2VsZWN0Q2hlY2tib3giLCJjbGljayIsImNoZWNrYm94IiwiaW5uZXJIVE1MIiwiY2hpbGROb2RlcyIsImNsYXNzTmFtZSIsImhpZGRlbiIsImNoZWNrYm94ZXMiLCJkb2N1bWVudCIsInF1ZXJ5U2VsZWN0b3JBbGwiLCJpbm5lclRleHQiLCJjaGFuZ2VJbnB1dEhpZGRlbiIsImhpZGRlbkF0dHIiLCJjaGFuZ2UiLCJwcm9wIiwiY29uc29sZSIsImxvZyIsImhpZGRlblZhbHVlIiwidGFibGVMb2NhbGUiLCJlbXB0eVRhYmxlIiwiaW5mbyIsImluZm9FbXB0eSIsImxlbmd0aE1lbnUiLCJsb2FkaW5nUmVjb3JkcyIsInByb2Nlc3NpbmciLCJzZWFyY2hQbGFjZWhvbGRlciIsInplcm9SZWNvcmRzIiwicGFnaW5hdGUiLCJwcmV2aW91cyIsIm5leHQiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUEsU0FBU0EsVUFBVCxDQUFvQkMsSUFBcEIsRUFBMEJDLE9BQTFCLEVBQW1DO0FBQy9CQyxNQUFJLENBQUNDLElBQUwsQ0FBVTtBQUNOQyxTQUFLLEVBQUUsTUFERDtBQUVOQyxZQUFRLEVBQUUs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QSxJQUFNb0IsV0FBVyxHQUFHO0FBQ25CQyxZQUFVLEVBQUksdUJBREs7QUFFbkJDLE1BQUksRUFBTSwrQ0FGUztBQUduQkMsV0FBUyxFQUFRLDJCQUhFO0FBSW5CQyxZQUFVLEVBQUksUUFKSztBQUtuQkMsZ0JBQWMsRUFBRyxhQUxFO0FBTW5CQyxZQUFVLEVBQUksaUJBTks7QUFPbkIzQixRQUFNLEVBQUssRUFQUTtBQVFuQjRCLG1CQUFpQixFQUFHLGVBUkQ7QUFTbkJDLGFBQVcsRUFBSSwyQkFUSTtBQVVuQkMsVUFBUSxFQUFDO0FBQ1JDLFlBQVEsRUFBQyxrQ0FERDtBQUVSQyxRQUFJLEVBQUM7QUFGRztBQVZVLENBQXBCO0FBZWU7QUFDWDNELFlBQVUsRUFBVkEsVUFEVztBQUVYVyxzQkFBb0IsRUFBcEJBLG9CQUZXO0FBR1hNLHVCQUFxQixFQUFyQkEscUJBSFc7QUFJWEMsY0FBWSxFQUFaQSxZQUpXO0FBS2RZLDJCQUF5QixFQUF6QkEseUJBTGM7QUFNZGtCLGFBQVcsRUFBWEEsV0FOYztBQU9YUCxtQkFBaUIsRUFBakJBO0FBUFcsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xyXG4gICAgU3dhbC5maXJlKHtcclxuICAgICAgICB0b2FzdDogJ3RydWUnLFxyXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXHJcbiAgICAgICAgaWNvbjogaWNvbixcclxuICAgICAgICB0aXRsZTogbWVzc2FnZSxcclxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXHJcbiAgICAgICAgdGltZXI6IDMwMDAsXHJcbiAgICAgICAgdGltZXJQcm9ncmVzc0JhcjogdHJ1ZVxyXG4gICAgfSk7XHJcbn1cclxuXHJcbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XHJcblxyXG4gICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgIGlmICghbWlub3JbaV0uY2hlY2tlZCkge1xyXG4gICAgICAgICAgICBtYWluLmNoZWNrZWQgPSBmYWxzZTtcclxuICAgICAgICAgICAgYnJlYWs7XHJcbiAgICAgICAgfSBlbHNlIHtcclxuICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gdHJ1ZTtcclxuICAgICAgICB9XHJcbiAgICB9XHJcblxyXG59XHJcblxyXG5mdW5jdGlvbiBtaW5vckNoZWNrYm94U3dpdGNoZXIobWFpbiwgbWlub3IpIHtcclxuXHJcbiAgICBpZiAobWFpbi5jaGVja2VkKSB7XHJcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xyXG4gICAgICAgICAgICBtaW5vcltpXS5jaGVja2VkID0gdHJ1ZTtcclxuICAgICAgICB9XHJcbiAgICB9IGVsc2Uge1xyXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgbWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xyXG4gICAgICAgIH1cclxuICAgIH1cclxuXHJcbn1cclxuXHJcbmNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XHJcbiAgICAkKGF0dHIpLmRldGFjaCgpLmFwcGVuZFRvKCcuZGF0YVRhYmxlc19sZW5ndGggbGFiZWwnKVxyXG4gICAgJChhdHRyKS5vbignY2hhbmdlJywgZnVuY3Rpb24gKCkge1xyXG4gICAgICAgIHRhYmxlLmNvbHVtbnMoY29sdW1uKS5zZWFyY2godGhpcy52YWx1ZSkuZHJhdygpO1xyXG4gICAgfSk7XHJcbn1cclxuXHJcbmNvbnN0IHNlbGVjdEFuZERlc2VsZWN0Q2hlY2tib3ggPSBmdW5jdGlvbiAoYXR0cikge1xyXG4gICAgJChhdHRyKS5jbGljayhmdW5jdGlvbiAoKSB7XHJcbiAgICAgICAgbGV0IGNoZWNrYm94ID0gJChhdHRyKVxyXG5cclxuICAgICAgICBmb3IgKGxldCBpID0gMDsgaSA8IGNoZWNrYm94Lmxlbmd0aDsgaSsrKSB7XHJcbiAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSAhY2hlY2tib3hbaV0uY2hlY2tlZFxyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYgKHRoaXMuY2hlY2tlZCkge1xyXG5cclxuICAgICAgICAgICAgdGhpcy5pbm5lckhUTUwgPSAnPGkgY2xhc3M9XCJoMyBtZGkgbWRpLWNoZWNrYm94LW11bHRpcGxlLWJsYW5rLW91dGxpbmVcIj48L2k+J1xyXG4gICAgICAgIH0gZWxzZSB7XHJcblxyXG4gICAgICAgICAgICB0aGlzLmlubmVySFRNTCA9ICc8aSBjbGFzcz1cImgzIG1kaSBtZGktY2hlY2tib3gtbWFya2VkLW91dGxpbmVcIj48L2k+XFxuJ1xyXG4gICAgICAgIH1cclxuXHJcbiAgICAgICAgaWYodGhpcy5jaGlsZE5vZGVzWzBdLmNsYXNzTmFtZT09XCJoMyBtZGkgbWRpLWNoZWNrYm94LW11bHRpcGxlLWJsYW5rLW91dGxpbmVcIil7XHJcbiAgICAgICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSB0cnVlXHJcbiAgICAgICAgICAgIH1cclxuICAgICAgICAgICAgJChcIi5idWxrLWFjdGlvblwiKVswXS5oaWRkZW4gPSBmYWxzZVxyXG4gICAgICAgICAgICBsZXQgY2hlY2tib3hlcz0gZG9jdW1lbnQucXVlcnlTZWxlY3RvckFsbChcIi5qcy11c2VyLWNoZWNrYm94OmNoZWNrZWRcIikubGVuZ3RoXHJcbiAgICAgICAgICAgICQoXCIuYnVsay1hY3Rpb25cIilbMF0uaW5uZXJUZXh0ID0gYCDOlc+AzrnOu86/zrPOrc+CICR7Y2hlY2tib3hlcyA9PSAwID8gXCJcIiA6IGAoICR7Y2hlY2tib3hlc30gKSBgfSBgXHJcbiAgICAgICAgfWVsc2V7XHJcbiAgICAgICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcclxuICAgICAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSBmYWxzZVxyXG4gICAgICAgICAgICB9XHJcbiAgICAgICAgICAgICQoXCIuYnVsay1hY3Rpb25cIilbMF0uaGlkZGVuID0gdHJ1ZVxyXG4gICAgICAgIH1cclxuICAgIH0pXHJcbn1cclxuXHJcbmNvbnN0IGNoYW5nZUlucHV0SGlkZGVuID0gKGF0dHIsIGhpZGRlbkF0dHIpPT57XHJcblxyXG5cclxuICAgICQoYXR0cikuY2hhbmdlKGZ1bmN0aW9uKCl7XHJcbiAgICAgICAgaWYoYXR0ciA9PVwiI2FjdGl2ZU1hdGVyaWFsXCIpe1xyXG4gICAgICAgICAgICAgdGhpcy52YWx1ZSA9ICQodGhpcykucHJvcCgnY2hlY2tlZCcpID09IHRydWUgPyAxIDogMDtcclxuICAgICAgICB9XHJcblxyXG4gICAgICAgIGNvbnNvbGUubG9nKCQoaGlkZGVuQXR0cikpXHJcbiAgICAgICAgbGV0IGhpZGRlblZhbHVlID0gJChoaWRkZW5BdHRyKVswXS52YWx1ZSA9dGhpcy52YWx1ZVxyXG5cclxuICAgIH0pXHJcbn1cclxuXHJcbmNvbnN0IHRhYmxlTG9jYWxlID0ge1xyXG5cdGVtcHR5VGFibGU6IFx0XHRcIs6UzrXOvSDPhc+AzqzPgc+Hzr/Phc69IM61zrPOs8+BzrHPhs6tz4JcIixcclxuXHRpbmZvOiBcdFx0XHRcdFwiX1NUQVJUXyDOrc+Jz4IgX0VORF8gzrHPgM6/IM+EzrEgX1RPVEFMXyDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcclxuXHRpbmZvRW1wdHk6ICAgICAgXHRcIjAgzrHPgM6/IDAgz4TOsSAwIM6xz4DOv8+EzrXOu86tz4POvM6xz4TOsVwiLFxyXG5cdGxlbmd0aE1lbnU6IFx0XHRcIl9NRU5VX1wiLFxyXG5cdGxvYWRpbmdSZWNvcmRzOiBcdFwizqbPjM+Bz4TPic+DzrcgLi4uXCIsXHJcblx0cHJvY2Vzc2luZzogXHRcdFwizpXPgM61zr7Otc+BzrPOsc+Dzq/OsSAuLi5cIixcclxuXHRzZWFyY2g6IFx0XHRcdFwiXCIsXHJcblx0c2VhcmNoUGxhY2Vob2xkZXI6IFx0XCLOkc69zrHOts6uz4TOt8+DzrcuLi4gXCIsXHJcblx0emVyb1JlY29yZHM6IFx0XHRcIs6UzrXOvSDOss+Bzq3OuM63zrrOsc69IM6xz4DOv8+EzrXOu86tz4POvM6xz4TOsVwiLFxyXG5cdHBhZ2luYXRlOntcclxuXHRcdHByZXZpb3VzOlwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1sZWZ0Jz5cIixcclxuXHRcdG5leHQ6XCI8aSBjbGFzcz0nbWRpIG1kaS1jaGV2cm9uLXJpZ2h0Jz5cIn1cclxufVxyXG5cclxuZXhwb3J0IGRlZmF1bHQge1xyXG4gICAgdG9hc3RBbGVydCxcclxuICAgIG1haW5DaGVja2JveFN3aXRjaGVyLFxyXG4gICAgbWlub3JDaGVja2JveFN3aXRjaGVyLFxyXG4gICAgZmlsdGVyQnV0dG9uLFxyXG5cdHNlbGVjdEFuZERlc2VsZWN0Q2hlY2tib3gsXHJcblx0dGFibGVMb2NhbGUsXHJcbiAgICBjaGFuZ2VJbnB1dEhpZGRlblxyXG59XHJcbiJdLCJzb3VyY2VSb290IjoiIn0=\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 10:
/*!**********************************************!*\
  !*** multi ./resources/js/dashboard/main.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! D:\Coding\DarkProjects\Demo LMS\resources\js\dashboard\main.js */"./resources/js/dashboard/main.js");


/***/ })

/******/ });