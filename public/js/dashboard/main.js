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
/******/ 	return __webpack_require__(__webpack_require__.s = 11);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./resources/js/dashboard/main.js":
/*!****************************************!*\
  !*** ./resources/js/dashboard/main.js ***!
  \****************************************/
/*! exports provided: default */
/***/ (function(module, exports) {

eval("throw new Error(\"Module build failed (from ./node_modules/babel-loader/lib/index.js):\\nSyntaxError: C:\\\\laragon\\\\www\\\\lmsdemo\\\\resources\\\\js\\\\dashboard\\\\main.js: Unexpected token (371:0)\\n\\n\\u001b[0m \\u001b[90m 369 | \\u001b[39m\\t\\tlet gallery \\u001b[33m=\\u001b[39m $(\\u001b[32m\\\"#gallery-content\\\"\\u001b[39m)[\\u001b[35m0\\u001b[39m]\\u001b[0m\\n\\u001b[0m \\u001b[90m 370 | \\u001b[39m\\t\\tgallery\\u001b[33m.\\u001b[39minnerHTML \\u001b[33m=\\u001b[39m res\\u001b[33m.\\u001b[39mdata\\u001b[33m;\\u001b[39m\\u001b[0m\\n\\u001b[0m\\u001b[31m\\u001b[1m>\\u001b[22m\\u001b[39m\\u001b[90m 371 | \\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<<\\u001b[39m\\u001b[33m<\\u001b[39m \\u001b[33mHEAD\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m     | \\u001b[39m\\u001b[31m\\u001b[1m^\\u001b[22m\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 372 | \\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 373 | \\u001b[39m\\u001b[33m===\\u001b[39m\\u001b[33m===\\u001b[39m\\u001b[33m=\\u001b[39m\\u001b[0m\\n\\u001b[0m \\u001b[90m 374 | \\u001b[39m\\u001b[33m>>>\\u001b[39m\\u001b[33m>>>\\u001b[39m\\u001b[33m>\\u001b[39m \\u001b[35m9\\u001b[39meac7c4dab779e0515e88422f7b50cc98500da9a\\u001b[0m\\n    at Parser._raise (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:757:17)\\n    at Parser.raiseWithData (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:750:17)\\n    at Parser.raise (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:744:17)\\n    at Parser.unexpected (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:8834:16)\\n    at Parser.parseExprAtom (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10176:20)\\n    at Parser.parseExprSubscripts (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9688:23)\\n    at Parser.parseMaybeUnary (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9668:21)\\n    at Parser.parseExprOps (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9538:23)\\n    at Parser.parseMaybeConditional (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9511:23)\\n    at Parser.parseMaybeAssign (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9466:21)\\n    at Parser.parseExpression (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9418:23)\\n    at Parser.parseStatementContent (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11339:23)\\n    at Parser.parseStatement (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11210:17)\\n    at Parser.parseBlockOrModuleBlockBody (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11785:25)\\n    at Parser.parseBlockBody (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11771:10)\\n    at Parser.parseBlock (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11755:10)\\n    at Parser.parseFunctionBody (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10758:24)\\n    at Parser.parseArrowExpression (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10727:10)\\n    at Parser.parseParenAndDistinguishExpression (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10341:12)\\n    at Parser.parseExprAtom (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10042:21)\\n    at Parser.parseExprSubscripts (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9688:23)\\n    at Parser.parseMaybeUnary (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9668:21)\\n    at Parser.parseExprOps (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9538:23)\\n    at Parser.parseMaybeConditional (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9511:23)\\n    at Parser.parseMaybeAssign (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9466:21)\\n    at Parser.parseExprListItem (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:10846:18)\\n    at Parser.parseCallExpressionArguments (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9885:22)\\n    at Parser.parseSubscript (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9785:31)\\n    at Parser.parseSubscripts (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9711:19)\\n    at Parser.parseExprSubscripts (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9694:17)\\n    at Parser.parseMaybeUnary (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9668:21)\\n    at Parser.parseExprOps (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9538:23)\\n    at Parser.parseMaybeConditional (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9511:23)\\n    at Parser.parseMaybeAssign (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9466:21)\\n    at Parser.parseExpression (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:9418:23)\\n    at Parser.parseStatementContent (C:\\\\laragon\\\\www\\\\lmsdemo\\\\node_modules\\\\@babel\\\\parser\\\\lib\\\\index.js:11339:23)\");//# sourceURL=[module]\n//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbXSwibmFtZXMiOltdLCJtYXBwaW5ncyI6IiIsImZpbGUiOiIuL3Jlc291cmNlcy9qcy9kYXNoYm9hcmQvbWFpbi5qcy5qcyIsInNvdXJjZVJvb3QiOiIifQ==\n//# sourceURL=webpack-internal:///./resources/js/dashboard/main.js\n");

/***/ }),

/***/ 11:
/*!**********************************************!*\
  !*** multi ./resources/js/dashboard/main.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\laragon\www\lmsdemo\resources\js\dashboard\main.js */"./resources/js/dashboard/main.js");


/***/ })

/******/ });