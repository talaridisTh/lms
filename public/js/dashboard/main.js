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
eval("__webpack_require__.r(__webpack_exports__);\nfunction toastAlert(icon, message) {\n  Swal.fire({\n    toast: 'true',\n    position: 'top-end',\n    icon: icon,\n    title: message,\n    showConfirmButton: false,\n    timer: 3000,\n    timerProgressBar: true\n  });\n}\n\nfunction mainCheckboxSwitcher(main, minor) {\n  for (var i = 0; i < minor.length; i++) {\n    if (!minor[i].checked) {\n      main.checked = false;\n      break;\n    } else {\n      main.checked = true;\n    }\n  }\n}\n\nfunction minorCheckboxSwitcher(main, minor) {\n  if (main.checked) {\n    for (var i = 0; i < minor.length; i++) {\n      minor[i].checked = true;\n    }\n  } else {\n    for (var _i = 0; _i < minor.length; _i++) {\n      minor[_i].checked = false;\n    }\n  }\n}\n\nvar filterButton = function filterButton(attr, column, table) {\n  $(attr).detach().appendTo('.dataTables_length label');\n  $(attr).on('change', function () {\n    table.columns(column).search(this.value).draw();\n  });\n};\n\nvar selectAndDeselectCheckbox = function selectAndDeselectCheckbox(attr) {\n  $(attr).click(function () {\n    var checkbox = $(attr);\n    var checkboxes = document.querySelectorAll(\".js-user-checkbox:checked\").length;\n\n    for (var i = 0; i < checkbox.length; i++) {\n      checkbox[i].checked = !checkbox[i].checked;\n    }\n\n    if (this.checked) {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-multiple-blank-outline\"></i>';\n    } else {\n      this.innerHTML = '<i class=\"h3 mdi mdi-checkbox-marked-outline\"></i>\\n';\n    }\n\n    if (this.childNodes[0].className == \"h3 mdi mdi-checkbox-multiple-blank-outline\") {\n      for (var _i2 = 0; _i2 < checkbox.length; _i2++) {\n        checkbox[_i2].checked = true;\n\n        checkbox[_i2].parentElement.parentElement.parentElement.classList.add(\"trHover\");\n      }\n\n      $(\".bulk-action\")[0].hidden = false;\n      $(\".bulk-action\")[0].innerText = \" \\u0395\\u03C0\\u03B9\\u03BB\\u03BF\\u03B3\\u03AD\\u03C2 \".concat(checkboxes == 0 ? \"\" : \"( \".concat(checkboxes, \" ) \"), \" \");\n    } else {\n      for (var _i3 = 0; _i3 < checkbox.length; _i3++) {\n        checkbox[_i3].checked = false;\n\n        checkbox[_i3].parentElement.parentElement.parentElement.classList.remove(\"trHover\");\n      }\n\n      $(\".bulk-action\")[0].hidden = true;\n    }\n  });\n};\n\nvar changeInputHidden = function changeInputHidden(attr, hiddenAttr) {\n  $(attr).change(function () {\n    if (attr == \"#activeMaterial\") {\n      this.value = $(this).prop('checked') == true ? 1 : 0;\n    }\n\n    console.log($(hiddenAttr));\n    var hiddenValue = $(hiddenAttr)[0].value = this.value;\n  });\n};\n\nvar tableLocale = {\n  emptyTable: \"Δεν υπάρχουν εγγραφές\",\n  info: \"_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα\",\n  infoEmpty: \"0 απο 0 τα 0 αποτελέσματα\",\n  lengthMenu: \"_MENU_\",\n  loadingRecords: \"Φόρτωση ...\",\n  processing: \"Επεξεργασία ...\",\n  search: \"\",\n  searchPlaceholder: \"Αναζήτηση... \",\n  zeroRecords: \"Δεν βρέθηκαν αποτελέσματα\",\n  paginate: {\n    previous: \"<i class='mdi mdi-chevron-left'>\",\n    next: \"<i class='mdi mdi-chevron-right'>\"\n  }\n};\n/* harmony default export */ __webpack_exports__[\"default\"] = ({\n  toastAlert: toastAlert,\n  mainCheckboxSwitcher: mainCheckboxSwitcher,\n  minorCheckboxSwitcher: minorCheckboxSwitcher,\n  filterButton: filterButton,\n  selectAndDeselectCheckbox: selectAndDeselectCheckbox,\n  tableLocale: tableLocale,\n  changeInputHidden: changeInputHidden\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21haW4uanM/ODIyYiJdLCJuYW1lcyI6WyJ0b2FzdEFsZXJ0IiwiaWNvbiIsIm1lc3NhZ2UiLCJTd2FsIiwiZmlyZSIsInRvYXN0IiwicG9zaXRpb24iLCJ0aXRsZSIsInNob3dDb25maXJtQnV0dG9uIiwidGltZXIiLCJ0aW1lclByb2dyZXNzQmFyIiwibWFpbkNoZWNrYm94U3dpdGNoZXIiLCJtYWluIiwibWlub3IiLCJpIiwibGVuZ3RoIiwiY2hlY2tlZCIsIm1pbm9yQ2hlY2tib3hTd2l0Y2hlciIsImZpbHRlckJ1dHRvbiIsImF0dHIiLCJjb2x1bW4iLCJ0YWJsZSIsIiQiLCJkZXRhY2giLCJhcHBlbmRUbyIsIm9uIiwiY29sdW1ucyIsInNlYXJjaCIsInZhbHVlIiwiZHJhdyIsInNlbGVjdEFuZERlc2VsZWN0Q2hlY2tib3giLCJjbGljayIsImNoZWNrYm94IiwiY2hlY2tib3hlcyIsImRvY3VtZW50IiwicXVlcnlTZWxlY3RvckFsbCIsImlubmVySFRNTCIsImNoaWxkTm9kZXMiLCJjbGFzc05hbWUiLCJwYXJlbnRFbGVtZW50IiwiY2xhc3NMaXN0IiwiYWRkIiwiaGlkZGVuIiwiaW5uZXJUZXh0IiwicmVtb3ZlIiwiY2hhbmdlSW5wdXRIaWRkZW4iLCJoaWRkZW5BdHRyIiwiY2hhbmdlIiwicHJvcCIsImNvbnNvbGUiLCJsb2ciLCJoaWRkZW5WYWx1ZSIsInRhYmxlTG9jYWxlIiwiZW1wdHlUYWJsZSIsImluZm8iLCJpbmZvRW1wdHkiLCJsZW5ndGhNZW51IiwibG9hZGluZ1JlY29yZHMiLCJwcm9jZXNzaW5nIiwic2VhcmNoUGxhY2Vob2xkZXIiLCJ6ZXJvUmVjb3JkcyIsInBhZ2luYXRlIiwicHJldmlvdXMiLCJuZXh0Il0sIm1hcHBpbmdzIjoiQUFBQTtBQUFBLFNBQVNBLFVBQVQsQ0FBb0JDLElBQXBCLEVBQTBCQyxPQUExQixFQUFtQztBQUMvQkMsTUFBSSxDQUFDQyxJQUFM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V0FBS1MsS0FBTCxHQUFhTixDQUFDLENBQUMsSUFBRCxDQUFELENBQVEwQixJQUFSLENBQWEsU0FBYixLQUEyQixJQUEzQixHQUFrQyxDQUFsQyxHQUFzQyxDQUFuRDtBQUNIOztBQUVEQyxXQUFPLENBQUNDLEdBQVIsQ0FBWTVCLENBQUMsQ0FBQ3dCLFVBQUQsQ0FBYjtBQUNBLFFBQUlLLFdBQVcsR0FBRzdCLENBQUMsQ0FBQ3dCLFVBQUQsQ0FBRCxDQUFjLENBQWQsRUFBaUJsQixLQUFqQixHQUF5QixLQUFLQSxLQUFoRDtBQUVILEdBUkQ7QUFTSCxDQVpEOztBQWNBLElBQU13QixXQUFXLEdBQUc7QUFDaEJDLFlBQVUsRUFBRSx1QkFESTtBQUVoQkMsTUFBSSxFQUFFLCtDQUZVO0FBR2hCQyxXQUFTLEVBQUUsMkJBSEs7QUFJaEJDLFlBQVUsRUFBRSxRQUpJO0FBS2hCQyxnQkFBYyxFQUFFLGFBTEE7QUFNaEJDLFlBQVUsRUFBRSxpQkFOSTtBQU9oQi9CLFFBQU0sRUFBRSxFQVBRO0FBUWhCZ0MsbUJBQWlCLEVBQUUsZUFSSDtBQVNoQkMsYUFBVyxFQUFFLDJCQVRHO0FBVWhCQyxVQUFRLEVBQUU7QUFDTkMsWUFBUSxFQUFFLGtDQURKO0FBRU5DLFFBQUksRUFBRTtBQUZBO0FBVk0sQ0FBcEI7QUFnQmU7QUFDWC9ELFlBQVUsRUFBVkEsVUFEVztBQUVYVyxzQkFBb0IsRUFBcEJBLG9CQUZXO0FBR1hNLHVCQUFxQixFQUFyQkEscUJBSFc7QUFJWEMsY0FBWSxFQUFaQSxZQUpXO0FBS1hZLDJCQUF5QixFQUF6QkEseUJBTFc7QUFNWHNCLGFBQVcsRUFBWEEsV0FOVztBQU9YUCxtQkFBaUIsRUFBakJBO0FBUFcsQ0FBZiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZXNDb250ZW50IjpbImZ1bmN0aW9uIHRvYXN0QWxlcnQoaWNvbiwgbWVzc2FnZSkge1xuICAgIFN3YWwuZmlyZSh7XG4gICAgICAgIHRvYXN0OiAndHJ1ZScsXG4gICAgICAgIHBvc2l0aW9uOiAndG9wLWVuZCcsXG4gICAgICAgIGljb246IGljb24sXG4gICAgICAgIHRpdGxlOiBtZXNzYWdlLFxuICAgICAgICBzaG93Q29uZmlybUJ1dHRvbjogZmFsc2UsXG4gICAgICAgIHRpbWVyOiAzMDAwLFxuICAgICAgICB0aW1lclByb2dyZXNzQmFyOiB0cnVlXG4gICAgfSk7XG59XG5cbmZ1bmN0aW9uIG1haW5DaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBmb3IgKGxldCBpID0gMDsgaSA8IG1pbm9yLmxlbmd0aDsgaSsrKSB7XG4gICAgICAgIGlmICghbWlub3JbaV0uY2hlY2tlZCkge1xuICAgICAgICAgICAgbWFpbi5jaGVja2VkID0gZmFsc2U7XG4gICAgICAgICAgICBicmVhaztcbiAgICAgICAgfSBlbHNlIHtcbiAgICAgICAgICAgIG1haW4uY2hlY2tlZCA9IHRydWU7XG4gICAgICAgIH1cbiAgICB9XG5cbn1cblxuZnVuY3Rpb24gbWlub3JDaGVja2JveFN3aXRjaGVyKG1haW4sIG1pbm9yKSB7XG5cbiAgICBpZiAobWFpbi5jaGVja2VkKSB7XG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgbWlub3IubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIG1pbm9yW2ldLmNoZWNrZWQgPSB0cnVlO1xuICAgICAgICB9XG4gICAgfSBlbHNlIHtcbiAgICAgICAgZm9yIChsZXQgaSA9IDA7IGkgPCBtaW5vci5sZW5ndGg7IGkrKykge1xuICAgICAgICAgICAgbWlub3JbaV0uY2hlY2tlZCA9IGZhbHNlO1xuICAgICAgICB9XG4gICAgfVxuXG59XG5cbmNvbnN0IGZpbHRlckJ1dHRvbiA9IGZ1bmN0aW9uIChhdHRyLCBjb2x1bW4sIHRhYmxlKSB7XG4gICAgJChhdHRyKS5kZXRhY2goKS5hcHBlbmRUbygnLmRhdGFUYWJsZXNfbGVuZ3RoIGxhYmVsJylcbiAgICAkKGF0dHIpLm9uKCdjaGFuZ2UnLCBmdW5jdGlvbiAoKSB7XG4gICAgICAgIHRhYmxlLmNvbHVtbnMoY29sdW1uKS5zZWFyY2godGhpcy52YWx1ZSkuZHJhdygpO1xuICAgIH0pO1xufVxuXG5jb25zdCBzZWxlY3RBbmREZXNlbGVjdENoZWNrYm94ID0gZnVuY3Rpb24gKGF0dHIpIHtcbiAgICAkKGF0dHIpLmNsaWNrKGZ1bmN0aW9uICgpIHtcbiAgICAgICAgbGV0IGNoZWNrYm94ID0gJChhdHRyKVxuICAgICAgICBsZXQgY2hlY2tib3hlcyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3JBbGwoXCIuanMtdXNlci1jaGVja2JveDpjaGVja2VkXCIpLmxlbmd0aFxuXG4gICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgIGNoZWNrYm94W2ldLmNoZWNrZWQgPSAhY2hlY2tib3hbaV0uY2hlY2tlZFxuICAgICAgICB9XG5cbiAgICAgICAgaWYgKHRoaXMuY2hlY2tlZCkge1xuXG4gICAgICAgICAgICB0aGlzLmlubmVySFRNTCA9ICc8aSBjbGFzcz1cImgzIG1kaSBtZGktY2hlY2tib3gtbXVsdGlwbGUtYmxhbmstb3V0bGluZVwiPjwvaT4nXG4gICAgICAgIH0gZWxzZSB7XG5cbiAgICAgICAgICAgIHRoaXMuaW5uZXJIVE1MID0gJzxpIGNsYXNzPVwiaDMgbWRpIG1kaS1jaGVja2JveC1tYXJrZWQtb3V0bGluZVwiPjwvaT5cXG4nXG4gICAgICAgIH1cblxuICAgICAgICBpZiAodGhpcy5jaGlsZE5vZGVzWzBdLmNsYXNzTmFtZSA9PSBcImgzIG1kaSBtZGktY2hlY2tib3gtbXVsdGlwbGUtYmxhbmstb3V0bGluZVwiKSB7XG5cbiAgICAgICAgICAgIGZvciAobGV0IGkgPSAwOyBpIDwgY2hlY2tib3gubGVuZ3RoOyBpKyspIHtcbiAgICAgICAgICAgICAgICBjaGVja2JveFtpXS5jaGVja2VkID0gdHJ1ZVxuICAgICAgICAgICAgICAgIGNoZWNrYm94W2ldLnBhcmVudEVsZW1lbnQucGFyZW50RWxlbWVudC5wYXJlbnRFbGVtZW50LmNsYXNzTGlzdC5hZGQoXCJ0ckhvdmVyXCIpXG4gICAgICAgICAgICB9XG4gICAgICAgICAgICAkKFwiLmJ1bGstYWN0aW9uXCIpWzBdLmhpZGRlbiA9IGZhbHNlXG5cbiAgICAgICAgICAgICQoXCIuYnVsay1hY3Rpb25cIilbMF0uaW5uZXJUZXh0ID0gYCDOlc+AzrnOu86/zrPOrc+CICR7Y2hlY2tib3hlcyA9PSAwID8gXCJcIiA6IGAoICR7Y2hlY2tib3hlc30gKSBgfSBgXG4gICAgICAgIH0gZWxzZSB7XG4gICAgICAgICAgICBmb3IgKGxldCBpID0gMDsgaSA8IGNoZWNrYm94Lmxlbmd0aDsgaSsrKSB7XG4gICAgICAgICAgICAgICAgY2hlY2tib3hbaV0uY2hlY2tlZCA9IGZhbHNlXG4gICAgICAgICAgICAgICAgY2hlY2tib3hbaV0ucGFyZW50RWxlbWVudC5wYXJlbnRFbGVtZW50LnBhcmVudEVsZW1lbnQuY2xhc3NMaXN0LnJlbW92ZShcInRySG92ZXJcIilcbiAgICAgICAgICAgIH1cbiAgICAgICAgICAgICQoXCIuYnVsay1hY3Rpb25cIilbMF0uaGlkZGVuID0gdHJ1ZVxuICAgICAgICB9XG4gICAgfSlcbn1cblxuY29uc3QgY2hhbmdlSW5wdXRIaWRkZW4gPSAoYXR0ciwgaGlkZGVuQXR0cikgPT4ge1xuXG5cbiAgICAkKGF0dHIpLmNoYW5nZShmdW5jdGlvbiAoKSB7XG4gICAgICAgIGlmIChhdHRyID09IFwiI2FjdGl2ZU1hdGVyaWFsXCIpIHtcbiAgICAgICAgICAgIHRoaXMudmFsdWUgPSAkKHRoaXMpLnByb3AoJ2NoZWNrZWQnKSA9PSB0cnVlID8gMSA6IDA7XG4gICAgICAgIH1cblxuICAgICAgICBjb25zb2xlLmxvZygkKGhpZGRlbkF0dHIpKVxuICAgICAgICBsZXQgaGlkZGVuVmFsdWUgPSAkKGhpZGRlbkF0dHIpWzBdLnZhbHVlID0gdGhpcy52YWx1ZVxuXG4gICAgfSlcbn1cblxuY29uc3QgdGFibGVMb2NhbGUgPSB7XG4gICAgZW1wdHlUYWJsZTogXCLOlM61zr0gz4XPgM6sz4HPh86/z4XOvSDOtc6zzrPPgc6xz4bOrc+CXCIsXG4gICAgaW5mbzogXCJfU1RBUlRfIM6tz4nPgiBfRU5EXyDOsc+Azr8gz4TOsSBfVE9UQUxfIM6xz4DOv8+EzrXOu86tz4POvM6xz4TOsVwiLFxuICAgIGluZm9FbXB0eTogXCIwIM6xz4DOvyAwIM+EzrEgMCDOsc+Azr/PhM61zrvOrc+DzrzOsc+EzrFcIixcbiAgICBsZW5ndGhNZW51OiBcIl9NRU5VX1wiLFxuICAgIGxvYWRpbmdSZWNvcmRzOiBcIs6mz4zPgc+Ez4nPg863IC4uLlwiLFxuICAgIHByb2Nlc3Npbmc6IFwizpXPgM61zr7Otc+BzrPOsc+Dzq/OsSAuLi5cIixcbiAgICBzZWFyY2g6IFwiXCIsXG4gICAgc2VhcmNoUGxhY2Vob2xkZXI6IFwizpHOvc6xzrbOrs+EzrfPg863Li4uIFwiLFxuICAgIHplcm9SZWNvcmRzOiBcIs6UzrXOvSDOss+Bzq3OuM63zrrOsc69IM6xz4DOv8+EzrXOu86tz4POvM6xz4TOsVwiLFxuICAgIHBhZ2luYXRlOiB7XG4gICAgICAgIHByZXZpb3VzOiBcIjxpIGNsYXNzPSdtZGkgbWRpLWNoZXZyb24tbGVmdCc+XCIsXG4gICAgICAgIG5leHQ6IFwiPGkgY2xhc3M9J21kaSBtZGktY2hldnJvbi1yaWdodCc+XCJcbiAgICB9XG59XG5cbmV4cG9ydCBkZWZhdWx0IHtcbiAgICB0b2FzdEFsZXJ0LFxuICAgIG1haW5DaGVja2JveFN3aXRjaGVyLFxuICAgIG1pbm9yQ2hlY2tib3hTd2l0Y2hlcixcbiAgICBmaWx0ZXJCdXR0b24sXG4gICAgc2VsZWN0QW5kRGVzZWxlY3RDaGVja2JveCxcbiAgICB0YWJsZUxvY2FsZSxcbiAgICBjaGFuZ2VJbnB1dEhpZGRlblxufVxuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

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