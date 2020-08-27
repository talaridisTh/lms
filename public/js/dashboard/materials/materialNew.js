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
/******/ 	return __webpack_require__(__webpack_require__.s = 7);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/main.js":
/*!****************************************!*\
  !*** ./resources/js/dashboard/main.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed (from ./node_modules/babel-loader/lib/index.js):\\nSyntaxError: C:\\\\laragon\\\\www\\\\lmsdemo\\\\resources\\\\js\\\\dashboard\\\\main.js: Unexpected token (159:0)\\n\\n\\u001b[0m \\u001b[90m 157 | \\u001b[39m    minorCheckboxSwitcher\\u001b[33m,\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 158 | \\u001b[39m    filterButton\\u001b[33m,\\u001b[39m\\u001b[0m\\n\\u001b[0m\\u001b[31m\\u001b[1m>\\u001b[22m\\u001b[39m\\u001b[90m 159 | \\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<\\u001b[39m \\u001b[33mHEAD\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m     | \\u001b[39m\\u001b[31m\\u001b[1m^\\u001b[22m\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 160 | \\u001b[39m    selectAndDeselectCheckbox\\u001b[33m,\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 161 | \\u001b[39m    tableLocale\\u001b[33m,\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 162 | \\u001b[39m    changeInputHidden\\u001b[0m\\n    at Parser._raise (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:757:17)\\n    at Parser.raiseWithData (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:750:17)\\n    at Parser.raise (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:744:17)\\n    at Parser.unexpected (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:8834:16)\\n    at Parser.parseIdentifierName (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10877:18)\\n    at Parser.parseIdentifier (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10854:23)\\n    at Parser.parseMaybePrivateName (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10203:19)\\n    at Parser.parsePropertyName (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10674:126)\\n    at Parser.parseObjectMember (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10575:10)\\n    at Parser.parseObj (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10494:25)\\n    at Parser.parseExprAtom (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10090:28)\\n    at Parser.parseExprSubscripts (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9688:23)\\n    at Parser.parseMaybeUnary (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9668:21)\\n    at Parser.parseExprOps (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9538:23)\\n    at Parser.parseMaybeConditional (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9511:23)\\n    at Parser.parseMaybeAssign (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9466:21)\\n    at Parser.parseExportDefaultExpression (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:12412:24)\\n    at Parser.parseExport (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:12314:31)\\n    at Parser.parseStatementContent (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11314:27)\\n    at Parser.parseStatement (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11210:17)\\n    at Parser.parseBlockOrModuleBlockBody (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11785:25)\\n    at Parser.parseBlockBody (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11771:10)\\n    at Parser.parseTopLevel (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11141:10)\\n    at Parser.parse (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:12843:10)\\n    at parse (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:12896:38)\\n    at parser (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\core\\\\lib\\\\parser\\\\index.js:54:34)\\n    at parser.next (<anonymous>)\\n    at normalizeFile (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\core\\\\lib\\\\transformation\\\\normalize-file.js:93:38)\\n    at normalizeFile.next (<anonymous>)\\n    at run (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\core\\\\lib\\\\transformation\\\\index.js:31:50)\\n    at run.next (<anonymous>)\\n    at Function.transform (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\core\\\\lib\\\\transform.js:27:41)\\n    at transform.next (<anonymous>)\\n    at step (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\gensync\\\\index.js:254:32)\\n    at C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\gensync\\\\index.js:266:13\\n    at async.call.result.err.err (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\gensync\\\\index.js:216:11)\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ "./resources/js/dashboard/materials/materialNew.js":
/*!*********************************************************!*\
  !*** ./resources/js/dashboard/materials/materialNew.js ***!
  \*********************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
eval("__webpack_require__.r(__webpack_exports__);\n/* harmony import */ var _main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main */ \"./resources/js/dashboard/main.js\");\n //! EDITOR INIT\n//!============================================================\n\n$R('#summaryMaterial', {\n  minHeight: '150px'\n});\n$R('#descriptionMaterial', {\n  minHeight: '150px'\n});\n$R('#contentMaterial', {\n  minHeight: '150px'\n}); //! METHOD INIT\n//!============================================================\n\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#urlMaterial', '#urlMaterialHiden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#createAtMaterial', '#createAtMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#activeMaterial', '#activeMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#typeMaterial', '#typeMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#instructorMaterial', '#instructorMaterialHidden');\n_main__WEBPACK_IMPORTED_MODULE_0__[\"default\"].changeInputHidden('#topicMaterial', '#topicMaterialHidden'); // utilities.changeInputHidden('#coursesMaterial','#coursesMaterialHidden')\n//! SELECT2\n//!============================================================\n\n$(\"#typeMaterial\").select2({\n  minimumResultsForSearch: -1,\n  allowClear: true,\n  placeholder: 'Ολοι οι Τύποι'\n}); // $(\"#coursesMaterial\").select2({\n//     allowClear: true,\n//     placeholder: 'Ολα τα courses'\n// });\n\n$(\"#instructorMaterial\").select2({\n  allowClear: true,\n  placeholder: 'Ολοι οι Εισηγητής'\n});\n$(\"#topicMaterial\").select2({\n  allowClear: true,\n  placeholder: 'Ολα τα Τοpic'\n});\nvar dataRange = $(\"#createAtMaterial\");\ndataRange.daterangepicker({\n  locale: {\n    format: 'YY/MM/DD '\n  },\n  startDate: moment().startOf('hour'),\n  // ranges: {\n  //     'Today': [moment(), moment()],\n  //     'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],\n  //     'Last 7 Days': [moment().subtract(6, 'days'), moment()],\n  //     'Last 30 Days': [moment().subtract(29, 'days'), moment()],\n  //     'This Month': [moment().startOf('month'), moment().endOf('month')],\n  //     'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]\n  // },\n  alwaysShowCalendars: true,\n  showCustomRangeLabel: false,\n  drops: \"auto\",\n  autoUpdateInput: false,\n  opens: \"center\"\n});//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9yZXNvdXJjZXMvanMvZGFzaGJvYXJkL21hdGVyaWFscy9tYXRlcmlhbE5ldy5qcz80YTI1Il0sIm5hbWVzIjpbIiRSIiwibWluSGVpZ2h0IiwidXRpbGl0aWVzIiwiY2hhbmdlSW5wdXRIaWRkZW4iLCIkIiwic2VsZWN0MiIsIm1pbmltdW1SZXN1bHRzRm9yU2VhcmNoIiwiYWxsb3dDbGVhciIsInBsYWNlaG9sZGVyIiwiZGF0YVJhbmdlIiwiZGF0ZXJhbmdlcGlja2VyIiwibG9jYWxlIiwiZm9ybWF0Iiwic3RhcnREYXRlIiwibW9tZW50Iiwic3RhcnRPZiIsImFsd2F5c1Nob3dDYWxlbmRhcnMiLCJzaG93Q3VzdG9tUmFuZ2VMYWJlbCIsImRyb3BzIiwiYXV0b1VwZGF0ZUlucHV0Iiwib3BlbnMiXSwibWFwcGluZ3MiOiJBQUFBO0FBQUE7Q0FDQTtBQUNBOztBQUVBQSxFQUFFLENBQUMsa0JBQUQsRUFBb0I7QUFDbEJDLFdBQVMsRUFBRTtBQURPLENBQXBCLENBQUY7QUFHQUQsRUFBRSxDQUFDLHNCQUFELEVBQXdCO0FBQ3RCQyxXQUFTLEVBQUU7QUFEVyxDQUF4QixDQUFGO0FBR0FELEVBQUUsQ0FBQyxrQkFBRCxFQUFvQjtBQUNsQkMsV0FBUyxFQUFFO0FBRE8sQ0FBcEIsQ0FBRixDLENBS0E7QUFDQTs7QUFFQUMsNkNBQVMsQ0FBQ0MsaUJBQVYsQ0FBNEIsY0FBNUIsRUFBMkMsbUJBQTNDO0FBQ0FELDZDQUFTLENBQUNDLGlCQUFWLENBQTRCLG1CQUE1QixFQUFnRCx5QkFBaEQ7QUFDQUQsNkNBQVMsQ0FBQ0MsaUJBQVYsQ0FBNEIsaUJBQTVCLEVBQThDLHVCQUE5QztBQUNBRCw2Q0FBUyxDQUFDQyxpQkFBVixDQUE0QixlQUE1QixFQUE0QyxxQkFBNUM7QUFDQUQsNkNBQVMsQ0FBQ0MsaUJBQVYsQ0FBNEIscUJBQTVCLEVBQWtELDJCQUFsRDtBQUNBRCw2Q0FBUyxDQUFDQyxpQkFBVixDQUE0QixnQkFBNUIsRUFBNkMsc0JBQTdDLEUsQ0FDQTtBQUlBO0FBQ0E7O0FBQ0FDLENBQUMsQ0FBQyxlQUFELENBQUQsQ0FBbUJDLE9BQW5CLENBQTJCO0FBQ3ZCQyx5QkFBdUIsRUFBRSxDQUFDLENBREg7QUFFdkJDLFlBQVUsRUFBRSxJQUZXO0FBR3ZCQyxhQUFXLEVBQUU7QUFIVSxDQUEzQixFLENBTUE7QUFDQTtBQUNBO0FBQ0E7O0FBRUFKLENBQUMsQ0FBQyxxQkFBRCxDQUFELENBQXlCQyxPQUF6QixDQUFpQztBQUM3QkUsWUFBVSxFQUFFLElBRGlCO0FBRTdCQyxhQUFXLEVBQUU7QUFGZ0IsQ0FBakM7QUFLQUosQ0FBQyxDQUFDLGdCQUFELENBQUQsQ0FBb0JDLE9BQXBCLENBQTRCO0FBQ3hCRSxZQUFVLEVBQUUsSUFEWTtBQUV4QkMsYUFBVyxFQUFFO0FBRlcsQ0FBNUI7QUFPQSxJQUFJQyxTQUFTLEdBQUdMLENBQUMsQ0FBQyxtQkFBRCxDQUFqQjtBQUVBSyxTQUFTLENBQUNDLGVBQVYsQ0FBMEI7QUFDdEJDLFFBQU0sRUFBRTtBQUNKQyxVQUFNLEVBQUU7QUFESixHQURjO0FBSXRCQyxXQUFTLEVBQUVDLE1BQU0sR0FBR0MsT0FBVCxDQUFpQixNQUFqQixDQUpXO0FBS3RCO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQTtBQUNBO0FBQ0E7QUFDQUMscUJBQW1CLEVBQUUsSUFiQztBQWN0QkMsc0JBQW9CLEVBQUUsS0FkQTtBQWV0QkMsT0FBSyxFQUFFLE1BZmU7QUFnQnRCQyxpQkFBZSxFQUFFLEtBaEJLO0FBaUJ0QkMsT0FBSyxFQUFFO0FBakJlLENBQTFCIiwiZmlsZSI6Ii4vcmVzb3VyY2VzL2pzL2Rhc2hib2FyZC9tYXRlcmlhbHMvbWF0ZXJpYWxOZXcuanMuanMiLCJzb3VyY2VzQ29udGVudCI6WyJpbXBvcnQgdXRpbGl0aWVzIGZyb20gJy4uL21haW4nO1xuLy8hIEVESVRPUiBJTklUXG4vLyE9PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT1cblxuJFIoJyNzdW1tYXJ5TWF0ZXJpYWwnLHtcbiAgICBtaW5IZWlnaHQ6ICcxNTBweCdcbn0pO1xuJFIoJyNkZXNjcmlwdGlvbk1hdGVyaWFsJyx7XG4gICAgbWluSGVpZ2h0OiAnMTUwcHgnXG59KTtcbiRSKCcjY29udGVudE1hdGVyaWFsJyx7XG4gICAgbWluSGVpZ2h0OiAnMTUwcHgnXG59KTtcblxuXG4vLyEgTUVUSE9EIElOSVRcbi8vIT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuXG51dGlsaXRpZXMuY2hhbmdlSW5wdXRIaWRkZW4oJyN1cmxNYXRlcmlhbCcsJyN1cmxNYXRlcmlhbEhpZGVuJylcbnV0aWxpdGllcy5jaGFuZ2VJbnB1dEhpZGRlbignI2NyZWF0ZUF0TWF0ZXJpYWwnLCcjY3JlYXRlQXRNYXRlcmlhbEhpZGRlbicpXG51dGlsaXRpZXMuY2hhbmdlSW5wdXRIaWRkZW4oJyNhY3RpdmVNYXRlcmlhbCcsJyNhY3RpdmVNYXRlcmlhbEhpZGRlbicpXG51dGlsaXRpZXMuY2hhbmdlSW5wdXRIaWRkZW4oJyN0eXBlTWF0ZXJpYWwnLCcjdHlwZU1hdGVyaWFsSGlkZGVuJylcbnV0aWxpdGllcy5jaGFuZ2VJbnB1dEhpZGRlbignI2luc3RydWN0b3JNYXRlcmlhbCcsJyNpbnN0cnVjdG9yTWF0ZXJpYWxIaWRkZW4nKVxudXRpbGl0aWVzLmNoYW5nZUlucHV0SGlkZGVuKCcjdG9waWNNYXRlcmlhbCcsJyN0b3BpY01hdGVyaWFsSGlkZGVuJylcbi8vIHV0aWxpdGllcy5jaGFuZ2VJbnB1dEhpZGRlbignI2NvdXJzZXNNYXRlcmlhbCcsJyNjb3Vyc2VzTWF0ZXJpYWxIaWRkZW4nKVxuXG5cblxuLy8hIFNFTEVDVDJcbi8vIT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PT09PVxuJChcIiN0eXBlTWF0ZXJpYWxcIikuc2VsZWN0Mih7XG4gICAgbWluaW11bVJlc3VsdHNGb3JTZWFyY2g6IC0xLFxuICAgIGFsbG93Q2xlYXI6IHRydWUsXG4gICAgcGxhY2Vob2xkZXI6ICfOn867zr/OuSDOv865IM6kz43PgM6/zrknXG59KTtcblxuLy8gJChcIiNjb3Vyc2VzTWF0ZXJpYWxcIikuc2VsZWN0Mih7XG4vLyAgICAgYWxsb3dDbGVhcjogdHJ1ZSxcbi8vICAgICBwbGFjZWhvbGRlcjogJ86fzrvOsSDPhM6xIGNvdXJzZXMnXG4vLyB9KTtcblxuJChcIiNpbnN0cnVjdG9yTWF0ZXJpYWxcIikuc2VsZWN0Mih7XG4gICAgYWxsb3dDbGVhcjogdHJ1ZSxcbiAgICBwbGFjZWhvbGRlcjogJ86fzrvOv865IM6/zrkgzpXOuc+DzrfOs863z4TOrs+CJ1xufSk7XG5cbiQoXCIjdG9waWNNYXRlcmlhbFwiKS5zZWxlY3QyKHtcbiAgICBhbGxvd0NsZWFyOiB0cnVlLFxuICAgIHBsYWNlaG9sZGVyOiAnzp/Ou86xIM+EzrEgzqTOv3BpYydcbn0pO1xuXG5cblxubGV0IGRhdGFSYW5nZSA9ICQoXCIjY3JlYXRlQXRNYXRlcmlhbFwiKVxuXG5kYXRhUmFuZ2UuZGF0ZXJhbmdlcGlja2VyKHtcbiAgICBsb2NhbGU6IHtcbiAgICAgICAgZm9ybWF0OiAnWVkvTU0vREQgJ1xuICAgIH0sXG4gICAgc3RhcnREYXRlOiBtb21lbnQoKS5zdGFydE9mKCdob3VyJyksXG4gICAgLy8gcmFuZ2VzOiB7XG4gICAgLy8gICAgICdUb2RheSc6IFttb21lbnQoKSwgbW9tZW50KCldLFxuICAgIC8vICAgICAnWWVzdGVyZGF5JzogW21vbWVudCgpLnN1YnRyYWN0KDEsICdkYXlzJyksIG1vbWVudCgpLnN1YnRyYWN0KDEsICdkYXlzJyldLFxuICAgIC8vICAgICAnTGFzdCA3IERheXMnOiBbbW9tZW50KCkuc3VidHJhY3QoNiwgJ2RheXMnKSwgbW9tZW50KCldLFxuICAgIC8vICAgICAnTGFzdCAzMCBEYXlzJzogW21vbWVudCgpLnN1YnRyYWN0KDI5LCAnZGF5cycpLCBtb21lbnQoKV0sXG4gICAgLy8gICAgICdUaGlzIE1vbnRoJzogW21vbWVudCgpLnN0YXJ0T2YoJ21vbnRoJyksIG1vbWVudCgpLmVuZE9mKCdtb250aCcpXSxcbiAgICAvLyAgICAgJ0xhc3QgTW9udGgnOiBbbW9tZW50KCkuc3VidHJhY3QoMSwgJ21vbnRoJykuc3RhcnRPZignbW9udGgnKSwgbW9tZW50KCkuc3VidHJhY3QoMSwgJ21vbnRoJykuZW5kT2YoJ21vbnRoJyldXG4gICAgLy8gfSxcbiAgICBhbHdheXNTaG93Q2FsZW5kYXJzOiB0cnVlLFxuICAgIHNob3dDdXN0b21SYW5nZUxhYmVsOiBmYWxzZSxcbiAgICBkcm9wczogXCJhdXRvXCIsXG4gICAgYXV0b1VwZGF0ZUlucHV0OiBmYWxzZSxcbiAgICBvcGVuczogXCJjZW50ZXJcIixcbn0pO1xuIl0sInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/materials/materialNew.js\n");

/***/ }),

/***/ 7:
/*!***************************************************************!*\
  !*** multi ./resources/js/dashboard/materials/materialNew.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\lmsdemo\resources\js\dashboard\materials\materialNew.js */"./resources/js/dashboard/materials/materialNew.js");


/***/ })

/******/ });