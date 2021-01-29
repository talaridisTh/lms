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
/******/ 	return __webpack_require__(__webpack_require__.s = 20);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/sweetalert2/dist/sweetalert2.all.js":
/*!**********************************************************!*\
  !*** ./node_modules/sweetalert2/dist/sweetalert2.all.js ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/*!
* sweetalert2 v9.17.2
* Released under the MIT License.
*/
(function (global, factory) {
   true ? module.exports = factory() :
  undefined;
}(this, function () { 'use strict';

  function _typeof(obj) {
    "@babel/helpers - typeof";

    if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") {
      _typeof = function (obj) {
        return typeof obj;
      };
    } else {
      _typeof = function (obj) {
        return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj;
      };
    }

    return _typeof(obj);
  }

  function _classCallCheck(instance, Constructor) {
    if (!(instance instanceof Constructor)) {
      throw new TypeError("Cannot call a class as a function");
    }
  }

  function _defineProperties(target, props) {
    for (var i = 0; i < props.length; i++) {
      var descriptor = props[i];
      descriptor.enumerable = descriptor.enumerable || false;
      descriptor.configurable = true;
      if ("value" in descriptor) descriptor.writable = true;
      Object.defineProperty(target, descriptor.key, descriptor);
    }
  }

  function _createClass(Constructor, protoProps, staticProps) {
    if (protoProps) _defineProperties(Constructor.prototype, protoProps);
    if (staticProps) _defineProperties(Constructor, staticProps);
    return Constructor;
  }

  function _extends() {
    _extends = Object.assign || function (target) {
      for (var i = 1; i < arguments.length; i++) {
        var source = arguments[i];

        for (var key in source) {
          if (Object.prototype.hasOwnProperty.call(source, key)) {
            target[key] = source[key];
          }
        }
      }

      return target;
    };

    return _extends.apply(this, arguments);
  }

  function _inherits(subClass, superClass) {
    if (typeof superClass !== "function" && superClass !== null) {
      throw new TypeError("Super expression must either be null or a function");
    }

    subClass.prototype = Object.create(superClass && superClass.prototype, {
      constructor: {
        value: subClass,
        writable: true,
        configurable: true
      }
    });
    if (superClass) _setPrototypeOf(subClass, superClass);
  }

  function _getPrototypeOf(o) {
    _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function _getPrototypeOf(o) {
      return o.__proto__ || Object.getPrototypeOf(o);
    };
    return _getPrototypeOf(o);
  }

  function _setPrototypeOf(o, p) {
    _setPrototypeOf = Object.setPrototypeOf || function _setPrototypeOf(o, p) {
      o.__proto__ = p;
      return o;
    };

    return _setPrototypeOf(o, p);
  }

  function _isNativeReflectConstruct() {
    if (typeof Reflect === "undefined" || !Reflect.construct) return false;
    if (Reflect.construct.sham) return false;
    if (typeof Proxy === "function") return true;

    try {
      Date.prototype.toString.call(Reflect.construct(Date, [], function () {}));
      return true;
    } catch (e) {
      return false;
    }
  }

  function _construct(Parent, args, Class) {
    if (_isNativeReflectConstruct()) {
      _construct = Reflect.construct;
    } else {
      _construct = function _construct(Parent, args, Class) {
        var a = [null];
        a.push.apply(a, args);
        var Constructor = Function.bind.apply(Parent, a);
        var instance = new Constructor();
        if (Class) _setPrototypeOf(instance, Class.prototype);
        return instance;
      };
    }

    return _construct.apply(null, arguments);
  }

  function _assertThisInitialized(self) {
    if (self === void 0) {
      throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
    }

    return self;
  }

  function _possibleConstructorReturn(self, call) {
    if (call && (typeof call === "object" || typeof call === "function")) {
      return call;
    }

    return _assertThisInitialized(self);
  }

  function _createSuper(Derived) {
    var hasNativeReflectConstruct = _isNativeReflectConstruct();

    return function _createSuperInternal() {
      var Super = _getPrototypeOf(Derived),
          result;

      if (hasNativeReflectConstruct) {
        var NewTarget = _getPrototypeOf(this).constructor;

        result = Reflect.construct(Super, arguments, NewTarget);
      } else {
        result = Super.apply(this, arguments);
      }

      return _possibleConstructorReturn(this, result);
    };
  }

  function _superPropBase(object, property) {
    while (!Object.prototype.hasOwnProperty.call(object, property)) {
      object = _getPrototypeOf(object);
      if (object === null) break;
    }

    return object;
  }

  function _get(target, property, receiver) {
    if (typeof Reflect !== "undefined" && Reflect.get) {
      _get = Reflect.get;
    } else {
      _get = function _get(target, property, receiver) {
        var base = _superPropBase(target, property);

        if (!base) return;
        var desc = Object.getOwnPropertyDescriptor(base, property);

        if (desc.get) {
          return desc.get.call(receiver);
        }

        return desc.value;
      };
    }

    return _get(target, property, receiver || target);
  }

  var consolePrefix = 'SweetAlert2:';
  /**
   * Filter the unique values into a new array
   * @param arr
   */

  var uniqueArray = function uniqueArray(arr) {
    var result = [];

    for (var i = 0; i < arr.length; i++) {
      if (result.indexOf(arr[i]) === -1) {
        result.push(arr[i]);
      }
    }

    return result;
  };
  /**
   * Capitalize the first letter of a string
   * @param str
   */

  var capitalizeFirstLetter = function capitalizeFirstLetter(str) {
    return str.charAt(0).toUpperCase() + str.slice(1);
  };
  /**
   * Returns the array of object values (Object.values isn't supported in IE11)
   * @param obj
   */

  var objectValues = function objectValues(obj) {
    return Object.keys(obj).map(function (key) {
      return obj[key];
    });
  };
  /**
   * Convert NodeList to Array
   * @param nodeList
   */

  var toArray = function toArray(nodeList) {
    return Array.prototype.slice.call(nodeList);
  };
  /**
   * Standardise console warnings
   * @param message
   */

  var warn = function warn(message) {
    console.warn("".concat(consolePrefix, " ").concat(message));
  };
  /**
   * Standardise console errors
   * @param message
   */

  var error = function error(message) {
    console.error("".concat(consolePrefix, " ").concat(message));
  };
  /**
   * Private global state for `warnOnce`
   * @type {Array}
   * @private
   */

  var previousWarnOnceMessages = [];
  /**
   * Show a console warning, but only if it hasn't already been shown
   * @param message
   */

  var warnOnce = function warnOnce(message) {
    if (!(previousWarnOnceMessages.indexOf(message) !== -1)) {
      previousWarnOnceMessages.push(message);
      warn(message);
    }
  };
  /**
   * Show a one-time console warning about deprecated params/methods
   */

  var warnAboutDepreation = function warnAboutDepreation(deprecatedParam, useInstead) {
    warnOnce("\"".concat(deprecatedParam, "\" is deprecated and will be removed in the next major release. Please use \"").concat(useInstead, "\" instead."));
  };
  /**
   * If `arg` is a function, call it (with no arguments or context) and return the result.
   * Otherwise, just pass the value through
   * @param arg
   */

  var callIfFunction = function callIfFunction(arg) {
    return typeof arg === 'function' ? arg() : arg;
  };
  var hasToPromiseFn = function hasToPromiseFn(arg) {
    return arg && typeof arg.toPromise === 'function';
  };
  var asPromise = function asPromise(arg) {
    return hasToPromiseFn(arg) ? arg.toPromise() : Promise.resolve(arg);
  };
  var isPromise = function isPromise(arg) {
    return arg && Promise.resolve(arg) === arg;
  };

  var DismissReason = Object.freeze({
    cancel: 'cancel',
    backdrop: 'backdrop',
    close: 'close',
    esc: 'esc',
    timer: 'timer'
  });

  var isJqueryElement = function isJqueryElement(elem) {
    return _typeof(elem) === 'object' && elem.jquery;
  };

  var isElement = function isElement(elem) {
    return elem instanceof Element || isJqueryElement(elem);
  };

  var argsToParams = function argsToParams(args) {
    var params = {};

    if (_typeof(args[0]) === 'object' && !isElement(args[0])) {
      _extends(params, args[0]);
    } else {
      ['title', 'html', 'icon'].forEach(function (name, index) {
        var arg = args[index];

        if (typeof arg === 'string' || isElement(arg)) {
          params[name] = arg;
        } else if (arg !== undefined) {
          error("Unexpected type of ".concat(name, "! Expected \"string\" or \"Element\", got ").concat(_typeof(arg)));
        }
      });
    }

    return params;
  };

  var swalPrefix = 'swal2-';
  var prefix = function prefix(items) {
    var result = {};

    for (var i in items) {
      result[items[i]] = swalPrefix + items[i];
    }

    return result;
  };
  var swalClasses = prefix(['container', 'shown', 'height-auto', 'iosfix', 'popup', 'modal', 'no-backdrop', 'no-transition', 'toast', 'toast-shown', 'toast-column', 'show', 'hide', 'close', 'title', 'header', 'content', 'html-container', 'actions', 'confirm', 'cancel', 'footer', 'icon', 'icon-content', 'image', 'input', 'file', 'range', 'select', 'radio', 'checkbox', 'label', 'textarea', 'inputerror', 'validation-message', 'progress-steps', 'active-progress-step', 'progress-step', 'progress-step-line', 'loading', 'styled', 'top', 'top-start', 'top-end', 'top-left', 'top-right', 'center', 'center-start', 'center-end', 'center-left', 'center-right', 'bottom', 'bottom-start', 'bottom-end', 'bottom-left', 'bottom-right', 'grow-row', 'grow-column', 'grow-fullscreen', 'rtl', 'timer-progress-bar', 'timer-progress-bar-container', 'scrollbar-measure', 'icon-success', 'icon-warning', 'icon-info', 'icon-question', 'icon-error']);
  var iconTypes = prefix(['success', 'warning', 'info', 'question', 'error']);

  var getContainer = function getContainer() {
    return document.body.querySelector(".".concat(swalClasses.container));
  };
  var elementBySelector = function elementBySelector(selectorString) {
    var container = getContainer();
    return container ? container.querySelector(selectorString) : null;
  };

  var elementByClass = function elementByClass(className) {
    return elementBySelector(".".concat(className));
  };

  var getPopup = function getPopup() {
    return elementByClass(swalClasses.popup);
  };
  var getIcons = function getIcons() {
    var popup = getPopup();
    return toArray(popup.querySelectorAll(".".concat(swalClasses.icon)));
  };
  var getIcon = function getIcon() {
    var visibleIcon = getIcons().filter(function (icon) {
      return isVisible(icon);
    });
    return visibleIcon.length ? visibleIcon[0] : null;
  };
  var getTitle = function getTitle() {
    return elementByClass(swalClasses.title);
  };
  var getContent = function getContent() {
    return elementByClass(swalClasses.content);
  };
  var getHtmlContainer = function getHtmlContainer() {
    return elementByClass(swalClasses['html-container']);
  };
  var getImage = function getImage() {
    return elementByClass(swalClasses.image);
  };
  var getProgressSteps = function getProgressSteps() {
    return elementByClass(swalClasses['progress-steps']);
  };
  var getValidationMessage = function getValidationMessage() {
    return elementByClass(swalClasses['validation-message']);
  };
  var getConfirmButton = function getConfirmButton() {
    return elementBySelector(".".concat(swalClasses.actions, " .").concat(swalClasses.confirm));
  };
  var getCancelButton = function getCancelButton() {
    return elementBySelector(".".concat(swalClasses.actions, " .").concat(swalClasses.cancel));
  };
  var getActions = function getActions() {
    return elementByClass(swalClasses.actions);
  };
  var getHeader = function getHeader() {
    return elementByClass(swalClasses.header);
  };
  var getFooter = function getFooter() {
    return elementByClass(swalClasses.footer);
  };
  var getTimerProgressBar = function getTimerProgressBar() {
    return elementByClass(swalClasses['timer-progress-bar']);
  };
  var getCloseButton = function getCloseButton() {
    return elementByClass(swalClasses.close);
  }; // https://github.com/jkup/focusable/blob/master/index.js

  var focusable = "\n  a[href],\n  area[href],\n  input:not([disabled]),\n  select:not([disabled]),\n  textarea:not([disabled]),\n  button:not([disabled]),\n  iframe,\n  object,\n  embed,\n  [tabindex=\"0\"],\n  [contenteditable],\n  audio[controls],\n  video[controls],\n  summary\n";
  var getFocusableElements = function getFocusableElements() {
    var focusableElementsWithTabindex = toArray(getPopup().querySelectorAll('[tabindex]:not([tabindex="-1"]):not([tabindex="0"])')) // sort according to tabindex
    .sort(function (a, b) {
      a = parseInt(a.getAttribute('tabindex'));
      b = parseInt(b.getAttribute('tabindex'));

      if (a > b) {
        return 1;
      } else if (a < b) {
        return -1;
      }

      return 0;
    });
    var otherFocusableElements = toArray(getPopup().querySelectorAll(focusable)).filter(function (el) {
      return el.getAttribute('tabindex') !== '-1';
    });
    return uniqueArray(focusableElementsWithTabindex.concat(otherFocusableElements)).filter(function (el) {
      return isVisible(el);
    });
  };
  var isModal = function isModal() {
    return !isToast() && !document.body.classList.contains(swalClasses['no-backdrop']);
  };
  var isToast = function isToast() {
    return document.body.classList.contains(swalClasses['toast-shown']);
  };
  var isLoading = function isLoading() {
    return getPopup().hasAttribute('data-loading');
  };

  var states = {
    previousBodyPadding: null
  };
  var setInnerHtml = function setInnerHtml(elem, html) {
    // #1926
    elem.textContent = '';

    if (html) {
      var parser = new DOMParser();
      var parsed = parser.parseFromString(html, "text/html");
      toArray(parsed.querySelector('head').childNodes).forEach(function (child) {
        elem.appendChild(child);
      });
      toArray(parsed.querySelector('body').childNodes).forEach(function (child) {
        elem.appendChild(child);
      });
    }
  };
  var hasClass = function hasClass(elem, className) {
    if (!className) {
      return false;
    }

    var classList = className.split(/\s+/);

    for (var i = 0; i < classList.length; i++) {
      if (!elem.classList.contains(classList[i])) {
        return false;
      }
    }

    return true;
  };

  var removeCustomClasses = function removeCustomClasses(elem, params) {
    toArray(elem.classList).forEach(function (className) {
      if (!(objectValues(swalClasses).indexOf(className) !== -1) && !(objectValues(iconTypes).indexOf(className) !== -1) && !(objectValues(params.showClass).indexOf(className) !== -1)) {
        elem.classList.remove(className);
      }
    });
  };

  var applyCustomClass = function applyCustomClass(elem, params, className) {
    removeCustomClasses(elem, params);

    if (params.customClass && params.customClass[className]) {
      if (typeof params.customClass[className] !== 'string' && !params.customClass[className].forEach) {
        return warn("Invalid type of customClass.".concat(className, "! Expected string or iterable object, got \"").concat(_typeof(params.customClass[className]), "\""));
      }

      addClass(elem, params.customClass[className]);
    }
  };
  function getInput(content, inputType) {
    if (!inputType) {
      return null;
    }

    switch (inputType) {
      case 'select':
      case 'textarea':
      case 'file':
        return getChildByClass(content, swalClasses[inputType]);

      case 'checkbox':
        return content.querySelector(".".concat(swalClasses.checkbox, " input"));

      case 'radio':
        return content.querySelector(".".concat(swalClasses.radio, " input:checked")) || content.querySelector(".".concat(swalClasses.radio, " input:first-child"));

      case 'range':
        return content.querySelector(".".concat(swalClasses.range, " input"));

      default:
        return getChildByClass(content, swalClasses.input);
    }
  }
  var focusInput = function focusInput(input) {
    input.focus(); // place cursor at end of text in text input

    if (input.type !== 'file') {
      // http://stackoverflow.com/a/2345915
      var val = input.value;
      input.value = '';
      input.value = val;
    }
  };
  var toggleClass = function toggleClass(target, classList, condition) {
    if (!target || !classList) {
      return;
    }

    if (typeof classList === 'string') {
      classList = classList.split(/\s+/).filter(Boolean);
    }

    classList.forEach(function (className) {
      if (target.forEach) {
        target.forEach(function (elem) {
          condition ? elem.classList.add(className) : elem.classList.remove(className);
        });
      } else {
        condition ? target.classList.add(className) : target.classList.remove(className);
      }
    });
  };
  var addClass = function addClass(target, classList) {
    toggleClass(target, classList, true);
  };
  var removeClass = function removeClass(target, classList) {
    toggleClass(target, classList, false);
  };
  var getChildByClass = function getChildByClass(elem, className) {
    for (var i = 0; i < elem.childNodes.length; i++) {
      if (hasClass(elem.childNodes[i], className)) {
        return elem.childNodes[i];
      }
    }
  };
  var applyNumericalStyle = function applyNumericalStyle(elem, property, value) {
    if (value || parseInt(value) === 0) {
      elem.style[property] = typeof value === 'number' ? "".concat(value, "px") : value;
    } else {
      elem.style.removeProperty(property);
    }
  };
  var show = function show(elem) {
    var display = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 'flex';
    elem.style.opacity = '';
    elem.style.display = display;
  };
  var hide = function hide(elem) {
    elem.style.opacity = '';
    elem.style.display = 'none';
  };
  var toggle = function toggle(elem, condition, display) {
    condition ? show(elem, display) : hide(elem);
  }; // borrowed from jquery $(elem).is(':visible') implementation

  var isVisible = function isVisible(elem) {
    return !!(elem && (elem.offsetWidth || elem.offsetHeight || elem.getClientRects().length));
  };
  /* istanbul ignore next */

  var isScrollable = function isScrollable(elem) {
    return !!(elem.scrollHeight > elem.clientHeight);
  }; // borrowed from https://stackoverflow.com/a/46352119

  var hasCssAnimation = function hasCssAnimation(elem) {
    var style = window.getComputedStyle(elem);
    var animDuration = parseFloat(style.getPropertyValue('animation-duration') || '0');
    var transDuration = parseFloat(style.getPropertyValue('transition-duration') || '0');
    return animDuration > 0 || transDuration > 0;
  };
  var contains = function contains(haystack, needle) {
    if (typeof haystack.contains === 'function') {
      return haystack.contains(needle);
    }
  };
  var animateTimerProgressBar = function animateTimerProgressBar(timer) {
    var reset = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : false;
    var timerProgressBar = getTimerProgressBar();

    if (isVisible(timerProgressBar)) {
      if (reset) {
        timerProgressBar.style.transition = 'none';
        timerProgressBar.style.width = '100%';
      }

      setTimeout(function () {
        timerProgressBar.style.transition = "width ".concat(timer / 1000, "s linear");
        timerProgressBar.style.width = '0%';
      }, 10);
    }
  };
  var stopTimerProgressBar = function stopTimerProgressBar() {
    var timerProgressBar = getTimerProgressBar();
    var timerProgressBarWidth = parseInt(window.getComputedStyle(timerProgressBar).width);
    timerProgressBar.style.removeProperty('transition');
    timerProgressBar.style.width = '100%';
    var timerProgressBarFullWidth = parseInt(window.getComputedStyle(timerProgressBar).width);
    var timerProgressBarPercent = parseInt(timerProgressBarWidth / timerProgressBarFullWidth * 100);
    timerProgressBar.style.removeProperty('transition');
    timerProgressBar.style.width = "".concat(timerProgressBarPercent, "%");
  };

  // Detect Node env
  var isNodeEnv = function isNodeEnv() {
    return typeof window === 'undefined' || typeof document === 'undefined';
  };

  var sweetHTML = "\n <div aria-labelledby=\"".concat(swalClasses.title, "\" aria-describedby=\"").concat(swalClasses.content, "\" class=\"").concat(swalClasses.popup, "\" tabindex=\"-1\">\n   <div class=\"").concat(swalClasses.header, "\">\n     <ul class=\"").concat(swalClasses['progress-steps'], "\"></ul>\n     <div class=\"").concat(swalClasses.icon, " ").concat(iconTypes.error, "\"></div>\n     <div class=\"").concat(swalClasses.icon, " ").concat(iconTypes.question, "\"></div>\n     <div class=\"").concat(swalClasses.icon, " ").concat(iconTypes.warning, "\"></div>\n     <div class=\"").concat(swalClasses.icon, " ").concat(iconTypes.info, "\"></div>\n     <div class=\"").concat(swalClasses.icon, " ").concat(iconTypes.success, "\"></div>\n     <img class=\"").concat(swalClasses.image, "\" />\n     <h2 class=\"").concat(swalClasses.title, "\" id=\"").concat(swalClasses.title, "\"></h2>\n     <button type=\"button\" class=\"").concat(swalClasses.close, "\"></button>\n   </div>\n   <div class=\"").concat(swalClasses.content, "\">\n     <div id=\"").concat(swalClasses.content, "\" class=\"").concat(swalClasses['html-container'], "\"></div>\n     <input class=\"").concat(swalClasses.input, "\" />\n     <input type=\"file\" class=\"").concat(swalClasses.file, "\" />\n     <div class=\"").concat(swalClasses.range, "\">\n       <input type=\"range\" />\n       <output></output>\n     </div>\n     <select class=\"").concat(swalClasses.select, "\"></select>\n     <div class=\"").concat(swalClasses.radio, "\"></div>\n     <label for=\"").concat(swalClasses.checkbox, "\" class=\"").concat(swalClasses.checkbox, "\">\n       <input type=\"checkbox\" />\n       <span class=\"").concat(swalClasses.label, "\"></span>\n     </label>\n     <textarea class=\"").concat(swalClasses.textarea, "\"></textarea>\n     <div class=\"").concat(swalClasses['validation-message'], "\" id=\"").concat(swalClasses['validation-message'], "\"></div>\n   </div>\n   <div class=\"").concat(swalClasses.actions, "\">\n     <button type=\"button\" class=\"").concat(swalClasses.confirm, "\">OK</button>\n     <button type=\"button\" class=\"").concat(swalClasses.cancel, "\">Cancel</button>\n   </div>\n   <div class=\"").concat(swalClasses.footer, "\"></div>\n   <div class=\"").concat(swalClasses['timer-progress-bar-container'], "\">\n     <div class=\"").concat(swalClasses['timer-progress-bar'], "\"></div>\n   </div>\n </div>\n").replace(/(^|\n)\s*/g, '');

  var resetOldContainer = function resetOldContainer() {
    var oldContainer = getContainer();

    if (!oldContainer) {
      return false;
    }

    oldContainer.parentNode.removeChild(oldContainer);
    removeClass([document.documentElement, document.body], [swalClasses['no-backdrop'], swalClasses['toast-shown'], swalClasses['has-column']]);
    return true;
  };

  var oldInputVal; // IE11 workaround, see #1109 for details

  var resetValidationMessage = function resetValidationMessage(e) {
    if (Swal.isVisible() && oldInputVal !== e.target.value) {
      Swal.resetValidationMessage();
    }

    oldInputVal = e.target.value;
  };

  var addInputChangeListeners = function addInputChangeListeners() {
    var content = getContent();
    var input = getChildByClass(content, swalClasses.input);
    var file = getChildByClass(content, swalClasses.file);
    var range = content.querySelector(".".concat(swalClasses.range, " input"));
    var rangeOutput = content.querySelector(".".concat(swalClasses.range, " output"));
    var select = getChildByClass(content, swalClasses.select);
    var checkbox = content.querySelector(".".concat(swalClasses.checkbox, " input"));
    var textarea = getChildByClass(content, swalClasses.textarea);
    input.oninput = resetValidationMessage;
    file.onchange = resetValidationMessage;
    select.onchange = resetValidationMessage;
    checkbox.onchange = resetValidationMessage;
    textarea.oninput = resetValidationMessage;

    range.oninput = function (e) {
      resetValidationMessage(e);
      rangeOutput.value = range.value;
    };

    range.onchange = function (e) {
      resetValidationMessage(e);
      range.nextSibling.value = range.value;
    };
  };

  var getTarget = function getTarget(target) {
    return typeof target === 'string' ? document.querySelector(target) : target;
  };

  var setupAccessibility = function setupAccessibility(params) {
    var popup = getPopup();
    popup.setAttribute('role', params.toast ? 'alert' : 'dialog');
    popup.setAttribute('aria-live', params.toast ? 'polite' : 'assertive');

    if (!params.toast) {
      popup.setAttribute('aria-modal', 'true');
    }
  };

  var setupRTL = function setupRTL(targetElement) {
    if (window.getComputedStyle(targetElement).direction === 'rtl') {
      addClass(getContainer(), swalClasses.rtl);
    }
  };
  /*
   * Add modal + backdrop to DOM
   */


  var init = function init(params) {
    // Clean up the old popup container if it exists
    var oldContainerExisted = resetOldContainer();
    /* istanbul ignore if */

    if (isNodeEnv()) {
      error('SweetAlert2 requires document to initialize');
      return;
    }

    var container = document.createElement('div');
    container.className = swalClasses.container;

    if (oldContainerExisted) {
      addClass(container, swalClasses['no-transition']);
    }

    setInnerHtml(container, sweetHTML);
    var targetElement = getTarget(params.target);
    targetElement.appendChild(container);
    setupAccessibility(params);
    setupRTL(targetElement);
    addInputChangeListeners();
  };

  var parseHtmlToContainer = function parseHtmlToContainer(param, target) {
    // DOM element
    if (param instanceof HTMLElement) {
      target.appendChild(param); // Object
    } else if (_typeof(param) === 'object') {
      handleObject(param, target); // Plain string
    } else if (param) {
      setInnerHtml(target, param);
    }
  };

  var handleObject = function handleObject(param, target) {
    // JQuery element(s)
    if (param.jquery) {
      handleJqueryElem(target, param); // For other objects use their string representation
    } else {
      setInnerHtml(target, param.toString());
    }
  };

  var handleJqueryElem = function handleJqueryElem(target, elem) {
    target.textContent = '';

    if (0 in elem) {
      for (var i = 0; (i in elem); i++) {
        target.appendChild(elem[i].cloneNode(true));
      }
    } else {
      target.appendChild(elem.cloneNode(true));
    }
  };

  var animationEndEvent = function () {
    // Prevent run in Node env

    /* istanbul ignore if */
    if (isNodeEnv()) {
      return false;
    }

    var testEl = document.createElement('div');
    var transEndEventNames = {
      WebkitAnimation: 'webkitAnimationEnd',
      OAnimation: 'oAnimationEnd oanimationend',
      animation: 'animationend'
    };

    for (var i in transEndEventNames) {
      if (Object.prototype.hasOwnProperty.call(transEndEventNames, i) && typeof testEl.style[i] !== 'undefined') {
        return transEndEventNames[i];
      }
    }

    return false;
  }();

  // https://github.com/twbs/bootstrap/blob/master/js/src/modal.js

  var measureScrollbar = function measureScrollbar() {
    var scrollDiv = document.createElement('div');
    scrollDiv.className = swalClasses['scrollbar-measure'];
    document.body.appendChild(scrollDiv);
    var scrollbarWidth = scrollDiv.getBoundingClientRect().width - scrollDiv.clientWidth;
    document.body.removeChild(scrollDiv);
    return scrollbarWidth;
  };

  var renderActions = function renderActions(instance, params) {
    var actions = getActions();
    var confirmButton = getConfirmButton();
    var cancelButton = getCancelButton(); // Actions (buttons) wrapper

    if (!params.showConfirmButton && !params.showCancelButton) {
      hide(actions);
    } // Custom class


    applyCustomClass(actions, params, 'actions'); // Render confirm button

    renderButton(confirmButton, 'confirm', params); // render Cancel Button

    renderButton(cancelButton, 'cancel', params);

    if (params.buttonsStyling) {
      handleButtonsStyling(confirmButton, cancelButton, params);
    } else {
      removeClass([confirmButton, cancelButton], swalClasses.styled);
      confirmButton.style.backgroundColor = confirmButton.style.borderLeftColor = confirmButton.style.borderRightColor = '';
      cancelButton.style.backgroundColor = cancelButton.style.borderLeftColor = cancelButton.style.borderRightColor = '';
    }

    if (params.reverseButtons) {
      confirmButton.parentNode.insertBefore(cancelButton, confirmButton);
    }
  };

  function handleButtonsStyling(confirmButton, cancelButton, params) {
    addClass([confirmButton, cancelButton], swalClasses.styled); // Buttons background colors

    if (params.confirmButtonColor) {
      confirmButton.style.backgroundColor = params.confirmButtonColor;
    }

    if (params.cancelButtonColor) {
      cancelButton.style.backgroundColor = params.cancelButtonColor;
    } // Loading state


    if (!isLoading()) {
      var confirmButtonBackgroundColor = window.getComputedStyle(confirmButton).getPropertyValue('background-color');
      confirmButton.style.borderLeftColor = confirmButtonBackgroundColor;
      confirmButton.style.borderRightColor = confirmButtonBackgroundColor;
    }
  }

  function renderButton(button, buttonType, params) {
    toggle(button, params["show".concat(capitalizeFirstLetter(buttonType), "Button")], 'inline-block');
    setInnerHtml(button, params["".concat(buttonType, "ButtonText")]); // Set caption text

    button.setAttribute('aria-label', params["".concat(buttonType, "ButtonAriaLabel")]); // ARIA label
    // Add buttons custom classes

    button.className = swalClasses[buttonType];
    applyCustomClass(button, params, "".concat(buttonType, "Button"));
    addClass(button, params["".concat(buttonType, "ButtonClass")]);
  }

  function handleBackdropParam(container, backdrop) {
    if (typeof backdrop === 'string') {
      container.style.background = backdrop;
    } else if (!backdrop) {
      addClass([document.documentElement, document.body], swalClasses['no-backdrop']);
    }
  }

  function handlePositionParam(container, position) {
    if (position in swalClasses) {
      addClass(container, swalClasses[position]);
    } else {
      warn('The "position" parameter is not valid, defaulting to "center"');
      addClass(container, swalClasses.center);
    }
  }

  function handleGrowParam(container, grow) {
    if (grow && typeof grow === 'string') {
      var growClass = "grow-".concat(grow);

      if (growClass in swalClasses) {
        addClass(container, swalClasses[growClass]);
      }
    }
  }

  var renderContainer = function renderContainer(instance, params) {
    var container = getContainer();

    if (!container) {
      return;
    }

    handleBackdropParam(container, params.backdrop);

    if (!params.backdrop && params.allowOutsideClick) {
      warn('"allowOutsideClick" parameter requires `backdrop` parameter to be set to `true`');
    }

    handlePositionParam(container, params.position);
    handleGrowParam(container, params.grow); // Custom class

    applyCustomClass(container, params, 'container'); // Set queue step attribute for getQueueStep() method

    var queueStep = document.body.getAttribute('data-swal2-queue-step');

    if (queueStep) {
      container.setAttribute('data-queue-step', queueStep);
      document.body.removeAttribute('data-swal2-queue-step');
    }
  };

  /**
   * This module containts `WeakMap`s for each effectively-"private  property" that a `Swal` has.
   * For example, to set the private property "foo" of `this` to "bar", you can `privateProps.foo.set(this, 'bar')`
   * This is the approach that Babel will probably take to implement private methods/fields
   *   https://github.com/tc39/proposal-private-methods
   *   https://github.com/babel/babel/pull/7555
   * Once we have the changes from that PR in Babel, and our core class fits reasonable in *one module*
   *   then we can use that language feature.
   */
  var privateProps = {
    promise: new WeakMap(),
    innerParams: new WeakMap(),
    domCache: new WeakMap()
  };

  var inputTypes = ['input', 'file', 'range', 'select', 'radio', 'checkbox', 'textarea'];
  var renderInput = function renderInput(instance, params) {
    var content = getContent();
    var innerParams = privateProps.innerParams.get(instance);
    var rerender = !innerParams || params.input !== innerParams.input;
    inputTypes.forEach(function (inputType) {
      var inputClass = swalClasses[inputType];
      var inputContainer = getChildByClass(content, inputClass); // set attributes

      setAttributes(inputType, params.inputAttributes); // set class

      inputContainer.className = inputClass;

      if (rerender) {
        hide(inputContainer);
      }
    });

    if (params.input) {
      if (rerender) {
        showInput(params);
      } // set custom class


      setCustomClass(params);
    }
  };

  var showInput = function showInput(params) {
    if (!renderInputType[params.input]) {
      return error("Unexpected type of input! Expected \"text\", \"email\", \"password\", \"number\", \"tel\", \"select\", \"radio\", \"checkbox\", \"textarea\", \"file\" or \"url\", got \"".concat(params.input, "\""));
    }

    var inputContainer = getInputContainer(params.input);
    var input = renderInputType[params.input](inputContainer, params);
    show(input); // input autofocus

    setTimeout(function () {
      focusInput(input);
    });
  };

  var removeAttributes = function removeAttributes(input) {
    for (var i = 0; i < input.attributes.length; i++) {
      var attrName = input.attributes[i].name;

      if (!(['type', 'value', 'style'].indexOf(attrName) !== -1)) {
        input.removeAttribute(attrName);
      }
    }
  };

  var setAttributes = function setAttributes(inputType, inputAttributes) {
    var input = getInput(getContent(), inputType);

    if (!input) {
      return;
    }

    removeAttributes(input);

    for (var attr in inputAttributes) {
      // Do not set a placeholder for <input type="range">
      // it'll crash Edge, #1298
      if (inputType === 'range' && attr === 'placeholder') {
        continue;
      }

      input.setAttribute(attr, inputAttributes[attr]);
    }
  };

  var setCustomClass = function setCustomClass(params) {
    var inputContainer = getInputContainer(params.input);

    if (params.customClass) {
      addClass(inputContainer, params.customClass.input);
    }
  };

  var setInputPlaceholder = function setInputPlaceholder(input, params) {
    if (!input.placeholder || params.inputPlaceholder) {
      input.placeholder = params.inputPlaceholder;
    }
  };

  var getInputContainer = function getInputContainer(inputType) {
    var inputClass = swalClasses[inputType] ? swalClasses[inputType] : swalClasses.input;
    return getChildByClass(getContent(), inputClass);
  };

  var renderInputType = {};

  renderInputType.text = renderInputType.email = renderInputType.password = renderInputType.number = renderInputType.tel = renderInputType.url = function (input, params) {
    if (typeof params.inputValue === 'string' || typeof params.inputValue === 'number') {
      input.value = params.inputValue;
    } else if (!isPromise(params.inputValue)) {
      warn("Unexpected type of inputValue! Expected \"string\", \"number\" or \"Promise\", got \"".concat(_typeof(params.inputValue), "\""));
    }

    setInputPlaceholder(input, params);
    input.type = params.input;
    return input;
  };

  renderInputType.file = function (input, params) {
    setInputPlaceholder(input, params);
    return input;
  };

  renderInputType.range = function (range, params) {
    var rangeInput = range.querySelector('input');
    var rangeOutput = range.querySelector('output');
    rangeInput.value = params.inputValue;
    rangeInput.type = params.input;
    rangeOutput.value = params.inputValue;
    return range;
  };

  renderInputType.select = function (select, params) {
    select.textContent = '';

    if (params.inputPlaceholder) {
      var placeholder = document.createElement('option');
      setInnerHtml(placeholder, params.inputPlaceholder);
      placeholder.value = '';
      placeholder.disabled = true;
      placeholder.selected = true;
      select.appendChild(placeholder);
    }

    return select;
  };

  renderInputType.radio = function (radio) {
    radio.textContent = '';
    return radio;
  };

  renderInputType.checkbox = function (checkboxContainer, params) {
    var checkbox = getInput(getContent(), 'checkbox');
    checkbox.value = 1;
    checkbox.id = swalClasses.checkbox;
    checkbox.checked = Boolean(params.inputValue);
    var label = checkboxContainer.querySelector('span');
    setInnerHtml(label, params.inputPlaceholder);
    return checkboxContainer;
  };

  renderInputType.textarea = function (textarea, params) {
    textarea.value = params.inputValue;
    setInputPlaceholder(textarea, params);

    if ('MutationObserver' in window) {
      // #1699
      var initialPopupWidth = parseInt(window.getComputedStyle(getPopup()).width);
      var popupPadding = parseInt(window.getComputedStyle(getPopup()).paddingLeft) + parseInt(window.getComputedStyle(getPopup()).paddingRight);

      var outputsize = function outputsize() {
        var contentWidth = textarea.offsetWidth + popupPadding;

        if (contentWidth > initialPopupWidth) {
          getPopup().style.width = "".concat(contentWidth, "px");
        } else {
          getPopup().style.width = null;
        }
      };

      new MutationObserver(outputsize).observe(textarea, {
        attributes: true,
        attributeFilter: ['style']
      });
    }

    return textarea;
  };

  var renderContent = function renderContent(instance, params) {
    var content = getContent().querySelector("#".concat(swalClasses.content)); // Content as HTML

    if (params.html) {
      parseHtmlToContainer(params.html, content);
      show(content, 'block'); // Content as plain text
    } else if (params.text) {
      content.textContent = params.text;
      show(content, 'block'); // No content
    } else {
      hide(content);
    }

    renderInput(instance, params); // Custom class

    applyCustomClass(getContent(), params, 'content');
  };

  var renderFooter = function renderFooter(instance, params) {
    var footer = getFooter();
    toggle(footer, params.footer);

    if (params.footer) {
      parseHtmlToContainer(params.footer, footer);
    } // Custom class


    applyCustomClass(footer, params, 'footer');
  };

  var renderCloseButton = function renderCloseButton(instance, params) {
    var closeButton = getCloseButton();
    setInnerHtml(closeButton, params.closeButtonHtml); // Custom class

    applyCustomClass(closeButton, params, 'closeButton');
    toggle(closeButton, params.showCloseButton);
    closeButton.setAttribute('aria-label', params.closeButtonAriaLabel);
  };

  var renderIcon = function renderIcon(instance, params) {
    var innerParams = privateProps.innerParams.get(instance); // if the give icon already rendered, apply the custom class without re-rendering the icon

    if (innerParams && params.icon === innerParams.icon && getIcon()) {
      applyCustomClass(getIcon(), params, 'icon');
      return;
    }

    hideAllIcons();

    if (!params.icon) {
      return;
    }

    if (Object.keys(iconTypes).indexOf(params.icon) !== -1) {
      var icon = elementBySelector(".".concat(swalClasses.icon, ".").concat(iconTypes[params.icon]));
      show(icon); // Custom or default content

      setContent(icon, params);
      adjustSuccessIconBackgoundColor(); // Custom class

      applyCustomClass(icon, params, 'icon'); // Animate icon

      addClass(icon, params.showClass.icon);
    } else {
      error("Unknown icon! Expected \"success\", \"error\", \"warning\", \"info\" or \"question\", got \"".concat(params.icon, "\""));
    }
  };

  var hideAllIcons = function hideAllIcons() {
    var icons = getIcons();

    for (var i = 0; i < icons.length; i++) {
      hide(icons[i]);
    }
  }; // Adjust success icon background color to match the popup background color


  var adjustSuccessIconBackgoundColor = function adjustSuccessIconBackgoundColor() {
    var popup = getPopup();
    var popupBackgroundColor = window.getComputedStyle(popup).getPropertyValue('background-color');
    var successIconParts = popup.querySelectorAll('[class^=swal2-success-circular-line], .swal2-success-fix');

    for (var i = 0; i < successIconParts.length; i++) {
      successIconParts[i].style.backgroundColor = popupBackgroundColor;
    }
  };

  var setContent = function setContent(icon, params) {
    icon.textContent = '';

    if (params.iconHtml) {
      setInnerHtml(icon, iconContent(params.iconHtml));
    } else if (params.icon === 'success') {
      setInnerHtml(icon, "\n      <div class=\"swal2-success-circular-line-left\"></div>\n      <span class=\"swal2-success-line-tip\"></span> <span class=\"swal2-success-line-long\"></span>\n      <div class=\"swal2-success-ring\"></div> <div class=\"swal2-success-fix\"></div>\n      <div class=\"swal2-success-circular-line-right\"></div>\n    ");
    } else if (params.icon === 'error') {
      setInnerHtml(icon, "\n      <span class=\"swal2-x-mark\">\n        <span class=\"swal2-x-mark-line-left\"></span>\n        <span class=\"swal2-x-mark-line-right\"></span>\n      </span>\n    ");
    } else {
      var defaultIconHtml = {
        question: '?',
        warning: '!',
        info: 'i'
      };
      setInnerHtml(icon, iconContent(defaultIconHtml[params.icon]));
    }
  };

  var iconContent = function iconContent(content) {
    return "<div class=\"".concat(swalClasses['icon-content'], "\">").concat(content, "</div>");
  };

  var renderImage = function renderImage(instance, params) {
    var image = getImage();

    if (!params.imageUrl) {
      return hide(image);
    }

    show(image, ''); // Src, alt

    image.setAttribute('src', params.imageUrl);
    image.setAttribute('alt', params.imageAlt); // Width, height

    applyNumericalStyle(image, 'width', params.imageWidth);
    applyNumericalStyle(image, 'height', params.imageHeight); // Class

    image.className = swalClasses.image;
    applyCustomClass(image, params, 'image');
  };

  var currentSteps = [];
  /*
   * Global function for chaining sweetAlert popups
   */

  var queue = function queue(steps) {
    var Swal = this;
    currentSteps = steps;

    var resetAndResolve = function resetAndResolve(resolve, value) {
      currentSteps = [];
      resolve(value);
    };

    var queueResult = [];
    return new Promise(function (resolve) {
      (function step(i, callback) {
        if (i < currentSteps.length) {
          document.body.setAttribute('data-swal2-queue-step', i);
          Swal.fire(currentSteps[i]).then(function (result) {
            if (typeof result.value !== 'undefined') {
              queueResult.push(result.value);
              step(i + 1, callback);
            } else {
              resetAndResolve(resolve, {
                dismiss: result.dismiss
              });
            }
          });
        } else {
          resetAndResolve(resolve, {
            value: queueResult
          });
        }
      })(0);
    });
  };
  /*
   * Global function for getting the index of current popup in queue
   */

  var getQueueStep = function getQueueStep() {
    return getContainer() && getContainer().getAttribute('data-queue-step');
  };
  /*
   * Global function for inserting a popup to the queue
   */

  var insertQueueStep = function insertQueueStep(step, index) {
    if (index && index < currentSteps.length) {
      return currentSteps.splice(index, 0, step);
    }

    return currentSteps.push(step);
  };
  /*
   * Global function for deleting a popup from the queue
   */

  var deleteQueueStep = function deleteQueueStep(index) {
    if (typeof currentSteps[index] !== 'undefined') {
      currentSteps.splice(index, 1);
    }
  };

  var createStepElement = function createStepElement(step) {
    var stepEl = document.createElement('li');
    addClass(stepEl, swalClasses['progress-step']);
    setInnerHtml(stepEl, step);
    return stepEl;
  };

  var createLineElement = function createLineElement(params) {
    var lineEl = document.createElement('li');
    addClass(lineEl, swalClasses['progress-step-line']);

    if (params.progressStepsDistance) {
      lineEl.style.width = params.progressStepsDistance;
    }

    return lineEl;
  };

  var renderProgressSteps = function renderProgressSteps(instance, params) {
    var progressStepsContainer = getProgressSteps();

    if (!params.progressSteps || params.progressSteps.length === 0) {
      return hide(progressStepsContainer);
    }

    show(progressStepsContainer);
    progressStepsContainer.textContent = '';
    var currentProgressStep = parseInt(params.currentProgressStep === undefined ? getQueueStep() : params.currentProgressStep);

    if (currentProgressStep >= params.progressSteps.length) {
      warn('Invalid currentProgressStep parameter, it should be less than progressSteps.length ' + '(currentProgressStep like JS arrays starts from 0)');
    }

    params.progressSteps.forEach(function (step, index) {
      var stepEl = createStepElement(step);
      progressStepsContainer.appendChild(stepEl);

      if (index === currentProgressStep) {
        addClass(stepEl, swalClasses['active-progress-step']);
      }

      if (index !== params.progressSteps.length - 1) {
        var lineEl = createLineElement(params);
        progressStepsContainer.appendChild(lineEl);
      }
    });
  };

  var renderTitle = function renderTitle(instance, params) {
    var title = getTitle();
    toggle(title, params.title || params.titleText);

    if (params.title) {
      parseHtmlToContainer(params.title, title);
    }

    if (params.titleText) {
      title.innerText = params.titleText;
    } // Custom class


    applyCustomClass(title, params, 'title');
  };

  var renderHeader = function renderHeader(instance, params) {
    var header = getHeader(); // Custom class

    applyCustomClass(header, params, 'header'); // Progress steps

    renderProgressSteps(instance, params); // Icon

    renderIcon(instance, params); // Image

    renderImage(instance, params); // Title

    renderTitle(instance, params); // Close button

    renderCloseButton(instance, params);
  };

  var renderPopup = function renderPopup(instance, params) {
    var popup = getPopup(); // Width

    applyNumericalStyle(popup, 'width', params.width); // Padding

    applyNumericalStyle(popup, 'padding', params.padding); // Background

    if (params.background) {
      popup.style.background = params.background;
    } // Classes


    addClasses(popup, params);
  };

  var addClasses = function addClasses(popup, params) {
    // Default Class + showClass when updating Swal.update({})
    popup.className = "".concat(swalClasses.popup, " ").concat(isVisible(popup) ? params.showClass.popup : '');

    if (params.toast) {
      addClass([document.documentElement, document.body], swalClasses['toast-shown']);
      addClass(popup, swalClasses.toast);
    } else {
      addClass(popup, swalClasses.modal);
    } // Custom class


    applyCustomClass(popup, params, 'popup');

    if (typeof params.customClass === 'string') {
      addClass(popup, params.customClass);
    } // Icon class (#1842)


    if (params.icon) {
      addClass(popup, swalClasses["icon-".concat(params.icon)]);
    }
  };

  var render = function render(instance, params) {
    renderPopup(instance, params);
    renderContainer(instance, params);
    renderHeader(instance, params);
    renderContent(instance, params);
    renderActions(instance, params);
    renderFooter(instance, params);

    if (typeof params.onRender === 'function') {
      params.onRender(getPopup());
    }
  };

  /*
   * Global function to determine if SweetAlert2 popup is shown
   */

  var isVisible$1 = function isVisible$$1() {
    return isVisible(getPopup());
  };
  /*
   * Global function to click 'Confirm' button
   */

  var clickConfirm = function clickConfirm() {
    return getConfirmButton() && getConfirmButton().click();
  };
  /*
   * Global function to click 'Cancel' button
   */

  var clickCancel = function clickCancel() {
    return getCancelButton() && getCancelButton().click();
  };

  function fire() {
    var Swal = this;

    for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
      args[_key] = arguments[_key];
    }

    return _construct(Swal, args);
  }

  /**
   * Returns an extended version of `Swal` containing `params` as defaults.
   * Useful for reusing Swal configuration.
   *
   * For example:
   *
   * Before:
   * const textPromptOptions = { input: 'text', showCancelButton: true }
   * const {value: firstName} = await Swal.fire({ ...textPromptOptions, title: 'What is your first name?' })
   * const {value: lastName} = await Swal.fire({ ...textPromptOptions, title: 'What is your last name?' })
   *
   * After:
   * const TextPrompt = Swal.mixin({ input: 'text', showCancelButton: true })
   * const {value: firstName} = await TextPrompt('What is your first name?')
   * const {value: lastName} = await TextPrompt('What is your last name?')
   *
   * @param mixinParams
   */
  function mixin(mixinParams) {
    var MixinSwal = /*#__PURE__*/function (_this) {
      _inherits(MixinSwal, _this);

      var _super = _createSuper(MixinSwal);

      function MixinSwal() {
        _classCallCheck(this, MixinSwal);

        return _super.apply(this, arguments);
      }

      _createClass(MixinSwal, [{
        key: "_main",
        value: function _main(params) {
          return _get(_getPrototypeOf(MixinSwal.prototype), "_main", this).call(this, _extends({}, mixinParams, params));
        }
      }]);

      return MixinSwal;
    }(this);

    return MixinSwal;
  }

  /**
   * Show spinner instead of Confirm button
   */

  var showLoading = function showLoading() {
    var popup = getPopup();

    if (!popup) {
      Swal.fire();
    }

    popup = getPopup();
    var actions = getActions();
    var confirmButton = getConfirmButton();
    show(actions);
    show(confirmButton, 'inline-block');
    addClass([popup, actions], swalClasses.loading);
    confirmButton.disabled = true;
    popup.setAttribute('data-loading', true);
    popup.setAttribute('aria-busy', true);
    popup.focus();
  };

  var RESTORE_FOCUS_TIMEOUT = 100;

  var globalState = {};

  var focusPreviousActiveElement = function focusPreviousActiveElement() {
    if (globalState.previousActiveElement && globalState.previousActiveElement.focus) {
      globalState.previousActiveElement.focus();
      globalState.previousActiveElement = null;
    } else if (document.body) {
      document.body.focus();
    }
  }; // Restore previous active (focused) element


  var restoreActiveElement = function restoreActiveElement() {
    return new Promise(function (resolve) {
      var x = window.scrollX;
      var y = window.scrollY;
      globalState.restoreFocusTimeout = setTimeout(function () {
        focusPreviousActiveElement();
        resolve();
      }, RESTORE_FOCUS_TIMEOUT); // issues/900

      /* istanbul ignore if */

      if (typeof x !== 'undefined' && typeof y !== 'undefined') {
        // IE doesn't have scrollX/scrollY support
        window.scrollTo(x, y);
      }
    });
  };

  /**
   * If `timer` parameter is set, returns number of milliseconds of timer remained.
   * Otherwise, returns undefined.
   */

  var getTimerLeft = function getTimerLeft() {
    return globalState.timeout && globalState.timeout.getTimerLeft();
  };
  /**
   * Stop timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   */

  var stopTimer = function stopTimer() {
    if (globalState.timeout) {
      stopTimerProgressBar();
      return globalState.timeout.stop();
    }
  };
  /**
   * Resume timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   */

  var resumeTimer = function resumeTimer() {
    if (globalState.timeout) {
      var remaining = globalState.timeout.start();
      animateTimerProgressBar(remaining);
      return remaining;
    }
  };
  /**
   * Resume timer. Returns number of milliseconds of timer remained.
   * If `timer` parameter isn't set, returns undefined.
   */

  var toggleTimer = function toggleTimer() {
    var timer = globalState.timeout;
    return timer && (timer.running ? stopTimer() : resumeTimer());
  };
  /**
   * Increase timer. Returns number of milliseconds of an updated timer.
   * If `timer` parameter isn't set, returns undefined.
   */

  var increaseTimer = function increaseTimer(n) {
    if (globalState.timeout) {
      var remaining = globalState.timeout.increase(n);
      animateTimerProgressBar(remaining, true);
      return remaining;
    }
  };
  /**
   * Check if timer is running. Returns true if timer is running
   * or false if timer is paused or stopped.
   * If `timer` parameter isn't set, returns undefined
   */

  var isTimerRunning = function isTimerRunning() {
    return globalState.timeout && globalState.timeout.isRunning();
  };

  var defaultParams = {
    title: '',
    titleText: '',
    text: '',
    html: '',
    footer: '',
    icon: undefined,
    iconHtml: undefined,
    toast: false,
    animation: true,
    showClass: {
      popup: 'swal2-show',
      backdrop: 'swal2-backdrop-show',
      icon: 'swal2-icon-show'
    },
    hideClass: {
      popup: 'swal2-hide',
      backdrop: 'swal2-backdrop-hide',
      icon: 'swal2-icon-hide'
    },
    customClass: undefined,
    target: 'body',
    backdrop: true,
    heightAuto: true,
    allowOutsideClick: true,
    allowEscapeKey: true,
    allowEnterKey: true,
    stopKeydownPropagation: true,
    keydownListenerCapture: false,
    showConfirmButton: true,
    showCancelButton: false,
    preConfirm: undefined,
    confirmButtonText: 'OK',
    confirmButtonAriaLabel: '',
    confirmButtonColor: undefined,
    cancelButtonText: 'Cancel',
    cancelButtonAriaLabel: '',
    cancelButtonColor: undefined,
    buttonsStyling: true,
    reverseButtons: false,
    focusConfirm: true,
    focusCancel: false,
    showCloseButton: false,
    closeButtonHtml: '&times;',
    closeButtonAriaLabel: 'Close this dialog',
    showLoaderOnConfirm: false,
    imageUrl: undefined,
    imageWidth: undefined,
    imageHeight: undefined,
    imageAlt: '',
    timer: undefined,
    timerProgressBar: false,
    width: undefined,
    padding: undefined,
    background: undefined,
    input: undefined,
    inputPlaceholder: '',
    inputValue: '',
    inputOptions: {},
    inputAutoTrim: true,
    inputAttributes: {},
    inputValidator: undefined,
    validationMessage: undefined,
    grow: false,
    position: 'center',
    progressSteps: [],
    currentProgressStep: undefined,
    progressStepsDistance: undefined,
    onBeforeOpen: undefined,
    onOpen: undefined,
    onRender: undefined,
    onClose: undefined,
    onAfterClose: undefined,
    onDestroy: undefined,
    scrollbarPadding: true
  };
  var updatableParams = ['allowEscapeKey', 'allowOutsideClick', 'buttonsStyling', 'cancelButtonAriaLabel', 'cancelButtonColor', 'cancelButtonText', 'closeButtonAriaLabel', 'closeButtonHtml', 'confirmButtonAriaLabel', 'confirmButtonColor', 'confirmButtonText', 'currentProgressStep', 'customClass', 'footer', 'hideClass', 'html', 'icon', 'imageAlt', 'imageHeight', 'imageUrl', 'imageWidth', 'onAfterClose', 'onClose', 'onDestroy', 'progressSteps', 'reverseButtons', 'showCancelButton', 'showCloseButton', 'showConfirmButton', 'text', 'title', 'titleText'];
  var deprecatedParams = {
    animation: 'showClass" and "hideClass'
  };
  var toastIncompatibleParams = ['allowOutsideClick', 'allowEnterKey', 'backdrop', 'focusConfirm', 'focusCancel', 'heightAuto', 'keydownListenerCapture'];
  /**
   * Is valid parameter
   * @param {String} paramName
   */

  var isValidParameter = function isValidParameter(paramName) {
    return Object.prototype.hasOwnProperty.call(defaultParams, paramName);
  };
  /**
   * Is valid parameter for Swal.update() method
   * @param {String} paramName
   */

  var isUpdatableParameter = function isUpdatableParameter(paramName) {
    return updatableParams.indexOf(paramName) !== -1;
  };
  /**
   * Is deprecated parameter
   * @param {String} paramName
   */

  var isDeprecatedParameter = function isDeprecatedParameter(paramName) {
    return deprecatedParams[paramName];
  };

  var checkIfParamIsValid = function checkIfParamIsValid(param) {
    if (!isValidParameter(param)) {
      warn("Unknown parameter \"".concat(param, "\""));
    }
  };

  var checkIfToastParamIsValid = function checkIfToastParamIsValid(param) {
    if (toastIncompatibleParams.indexOf(param) !== -1) {
      warn("The parameter \"".concat(param, "\" is incompatible with toasts"));
    }
  };

  var checkIfParamIsDeprecated = function checkIfParamIsDeprecated(param) {
    if (isDeprecatedParameter(param)) {
      warnAboutDepreation(param, isDeprecatedParameter(param));
    }
  };
  /**
   * Show relevant warnings for given params
   *
   * @param params
   */


  var showWarningsForParams = function showWarningsForParams(params) {
    for (var param in params) {
      checkIfParamIsValid(param);

      if (params.toast) {
        checkIfToastParamIsValid(param);
      }

      checkIfParamIsDeprecated(param);
    }
  };



  var staticMethods = /*#__PURE__*/Object.freeze({
    isValidParameter: isValidParameter,
    isUpdatableParameter: isUpdatableParameter,
    isDeprecatedParameter: isDeprecatedParameter,
    argsToParams: argsToParams,
    isVisible: isVisible$1,
    clickConfirm: clickConfirm,
    clickCancel: clickCancel,
    getContainer: getContainer,
    getPopup: getPopup,
    getTitle: getTitle,
    getContent: getContent,
    getHtmlContainer: getHtmlContainer,
    getImage: getImage,
    getIcon: getIcon,
    getIcons: getIcons,
    getCloseButton: getCloseButton,
    getActions: getActions,
    getConfirmButton: getConfirmButton,
    getCancelButton: getCancelButton,
    getHeader: getHeader,
    getFooter: getFooter,
    getTimerProgressBar: getTimerProgressBar,
    getFocusableElements: getFocusableElements,
    getValidationMessage: getValidationMessage,
    isLoading: isLoading,
    fire: fire,
    mixin: mixin,
    queue: queue,
    getQueueStep: getQueueStep,
    insertQueueStep: insertQueueStep,
    deleteQueueStep: deleteQueueStep,
    showLoading: showLoading,
    enableLoading: showLoading,
    getTimerLeft: getTimerLeft,
    stopTimer: stopTimer,
    resumeTimer: resumeTimer,
    toggleTimer: toggleTimer,
    increaseTimer: increaseTimer,
    isTimerRunning: isTimerRunning
  });

  /**
   * Enables buttons and hide loader.
   */

  function hideLoading() {
    // do nothing if popup is closed
    var innerParams = privateProps.innerParams.get(this);

    if (!innerParams) {
      return;
    }

    var domCache = privateProps.domCache.get(this);

    if (!innerParams.showConfirmButton) {
      hide(domCache.confirmButton);

      if (!innerParams.showCancelButton) {
        hide(domCache.actions);
      }
    }

    removeClass([domCache.popup, domCache.actions], swalClasses.loading);
    domCache.popup.removeAttribute('aria-busy');
    domCache.popup.removeAttribute('data-loading');
    domCache.confirmButton.disabled = false;
    domCache.cancelButton.disabled = false;
  }

  function getInput$1(instance) {
    var innerParams = privateProps.innerParams.get(instance || this);
    var domCache = privateProps.domCache.get(instance || this);

    if (!domCache) {
      return null;
    }

    return getInput(domCache.content, innerParams.input);
  }

  var fixScrollbar = function fixScrollbar() {
    // for queues, do not do this more than once
    if (states.previousBodyPadding !== null) {
      return;
    } // if the body has overflow


    if (document.body.scrollHeight > window.innerHeight) {
      // add padding so the content doesn't shift after removal of scrollbar
      states.previousBodyPadding = parseInt(window.getComputedStyle(document.body).getPropertyValue('padding-right'));
      document.body.style.paddingRight = "".concat(states.previousBodyPadding + measureScrollbar(), "px");
    }
  };
  var undoScrollbar = function undoScrollbar() {
    if (states.previousBodyPadding !== null) {
      document.body.style.paddingRight = "".concat(states.previousBodyPadding, "px");
      states.previousBodyPadding = null;
    }
  };

  /* istanbul ignore file */

  var iOSfix = function iOSfix() {
    var iOS = /iPad|iPhone|iPod/.test(navigator.userAgent) && !window.MSStream || navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1;

    if (iOS && !hasClass(document.body, swalClasses.iosfix)) {
      var offset = document.body.scrollTop;
      document.body.style.top = "".concat(offset * -1, "px");
      addClass(document.body, swalClasses.iosfix);
      lockBodyScroll();
      addBottomPaddingForTallPopups(); // #1948
    }
  };

  var addBottomPaddingForTallPopups = function addBottomPaddingForTallPopups() {
    var safari = !navigator.userAgent.match(/(CriOS|FxiOS|EdgiOS|YaBrowser|UCBrowser)/i);

    if (safari) {
      var bottomPanelHeight = 44;

      if (getPopup().scrollHeight > window.innerHeight - bottomPanelHeight) {
        getContainer().style.paddingBottom = "".concat(bottomPanelHeight, "px");
      }
    }
  };

  var lockBodyScroll = function lockBodyScroll() {
    // #1246
    var container = getContainer();
    var preventTouchMove;

    container.ontouchstart = function (e) {
      preventTouchMove = shouldPreventTouchMove(e.target);
    };

    container.ontouchmove = function (e) {
      if (preventTouchMove) {
        e.preventDefault();
        e.stopPropagation();
      }
    };
  };

  var shouldPreventTouchMove = function shouldPreventTouchMove(target) {
    var container = getContainer();

    if (target === container) {
      return true;
    }

    if (!isScrollable(container) && target.tagName !== 'INPUT' && // #1603
    !(isScrollable(getContent()) && // #1944
    getContent().contains(target))) {
      return true;
    }

    return false;
  };

  var undoIOSfix = function undoIOSfix() {
    if (hasClass(document.body, swalClasses.iosfix)) {
      var offset = parseInt(document.body.style.top, 10);
      removeClass(document.body, swalClasses.iosfix);
      document.body.style.top = '';
      document.body.scrollTop = offset * -1;
    }
  };

  /* istanbul ignore file */

  var isIE11 = function isIE11() {
    return !!window.MSInputMethodContext && !!document.documentMode;
  }; // Fix IE11 centering sweetalert2/issues/933


  var fixVerticalPositionIE = function fixVerticalPositionIE() {
    var container = getContainer();
    var popup = getPopup();
    container.style.removeProperty('align-items');

    if (popup.offsetTop < 0) {
      container.style.alignItems = 'flex-start';
    }
  };

  var IEfix = function IEfix() {
    if (typeof window !== 'undefined' && isIE11()) {
      fixVerticalPositionIE();
      window.addEventListener('resize', fixVerticalPositionIE);
    }
  };
  var undoIEfix = function undoIEfix() {
    if (typeof window !== 'undefined' && isIE11()) {
      window.removeEventListener('resize', fixVerticalPositionIE);
    }
  };

  // Adding aria-hidden="true" to elements outside of the active modal dialog ensures that
  // elements not within the active modal dialog will not be surfaced if a user opens a screen
  // reader’s list of elements (headings, form controls, landmarks, etc.) in the document.

  var setAriaHidden = function setAriaHidden() {
    var bodyChildren = toArray(document.body.children);
    bodyChildren.forEach(function (el) {
      if (el === getContainer() || contains(el, getContainer())) {
        return;
      }

      if (el.hasAttribute('aria-hidden')) {
        el.setAttribute('data-previous-aria-hidden', el.getAttribute('aria-hidden'));
      }

      el.setAttribute('aria-hidden', 'true');
    });
  };
  var unsetAriaHidden = function unsetAriaHidden() {
    var bodyChildren = toArray(document.body.children);
    bodyChildren.forEach(function (el) {
      if (el.hasAttribute('data-previous-aria-hidden')) {
        el.setAttribute('aria-hidden', el.getAttribute('data-previous-aria-hidden'));
        el.removeAttribute('data-previous-aria-hidden');
      } else {
        el.removeAttribute('aria-hidden');
      }
    });
  };

  /**
   * This module containts `WeakMap`s for each effectively-"private  property" that a `Swal` has.
   * For example, to set the private property "foo" of `this` to "bar", you can `privateProps.foo.set(this, 'bar')`
   * This is the approach that Babel will probably take to implement private methods/fields
   *   https://github.com/tc39/proposal-private-methods
   *   https://github.com/babel/babel/pull/7555
   * Once we have the changes from that PR in Babel, and our core class fits reasonable in *one module*
   *   then we can use that language feature.
   */
  var privateMethods = {
    swalPromiseResolve: new WeakMap()
  };

  /*
   * Instance method to close sweetAlert
   */

  function removePopupAndResetState(instance, container, isToast$$1, onAfterClose) {
    if (isToast$$1) {
      triggerOnAfterCloseAndDispose(instance, onAfterClose);
    } else {
      restoreActiveElement().then(function () {
        return triggerOnAfterCloseAndDispose(instance, onAfterClose);
      });
      globalState.keydownTarget.removeEventListener('keydown', globalState.keydownHandler, {
        capture: globalState.keydownListenerCapture
      });
      globalState.keydownHandlerAdded = false;
    }

    if (container.parentNode && !document.body.getAttribute('data-swal2-queue-step')) {
      container.parentNode.removeChild(container);
    }

    if (isModal()) {
      undoScrollbar();
      undoIOSfix();
      undoIEfix();
      unsetAriaHidden();
    }

    removeBodyClasses();
  }

  function removeBodyClasses() {
    removeClass([document.documentElement, document.body], [swalClasses.shown, swalClasses['height-auto'], swalClasses['no-backdrop'], swalClasses['toast-shown'], swalClasses['toast-column']]);
  }

  function close(resolveValue) {
    var popup = getPopup();

    if (!popup) {
      return;
    }

    var innerParams = privateProps.innerParams.get(this);

    if (!innerParams || hasClass(popup, innerParams.hideClass.popup)) {
      return;
    }

    var swalPromiseResolve = privateMethods.swalPromiseResolve.get(this);
    removeClass(popup, innerParams.showClass.popup);
    addClass(popup, innerParams.hideClass.popup);
    var backdrop = getContainer();
    removeClass(backdrop, innerParams.showClass.backdrop);
    addClass(backdrop, innerParams.hideClass.backdrop);
    handlePopupAnimation(this, popup, innerParams);

    if (typeof resolveValue !== 'undefined') {
      resolveValue.isDismissed = typeof resolveValue.dismiss !== 'undefined';
      resolveValue.isConfirmed = typeof resolveValue.dismiss === 'undefined';
    } else {
      resolveValue = {
        isDismissed: true,
        isConfirmed: false
      };
    } // Resolve Swal promise


    swalPromiseResolve(resolveValue || {});
  }

  var handlePopupAnimation = function handlePopupAnimation(instance, popup, innerParams) {
    var container = getContainer(); // If animation is supported, animate

    var animationIsSupported = animationEndEvent && hasCssAnimation(popup);
    var onClose = innerParams.onClose,
        onAfterClose = innerParams.onAfterClose;

    if (onClose !== null && typeof onClose === 'function') {
      onClose(popup);
    }

    if (animationIsSupported) {
      animatePopup(instance, popup, container, onAfterClose);
    } else {
      // Otherwise, remove immediately
      removePopupAndResetState(instance, container, isToast(), onAfterClose);
    }
  };

  var animatePopup = function animatePopup(instance, popup, container, onAfterClose) {
    globalState.swalCloseEventFinishedCallback = removePopupAndResetState.bind(null, instance, container, isToast(), onAfterClose);
    popup.addEventListener(animationEndEvent, function (e) {
      if (e.target === popup) {
        globalState.swalCloseEventFinishedCallback();
        delete globalState.swalCloseEventFinishedCallback;
      }
    });
  };

  var triggerOnAfterCloseAndDispose = function triggerOnAfterCloseAndDispose(instance, onAfterClose) {
    setTimeout(function () {
      if (typeof onAfterClose === 'function') {
        onAfterClose();
      }

      instance._destroy();
    });
  };

  function setButtonsDisabled(instance, buttons, disabled) {
    var domCache = privateProps.domCache.get(instance);
    buttons.forEach(function (button) {
      domCache[button].disabled = disabled;
    });
  }

  function setInputDisabled(input, disabled) {
    if (!input) {
      return false;
    }

    if (input.type === 'radio') {
      var radiosContainer = input.parentNode.parentNode;
      var radios = radiosContainer.querySelectorAll('input');

      for (var i = 0; i < radios.length; i++) {
        radios[i].disabled = disabled;
      }
    } else {
      input.disabled = disabled;
    }
  }

  function enableButtons() {
    setButtonsDisabled(this, ['confirmButton', 'cancelButton'], false);
  }
  function disableButtons() {
    setButtonsDisabled(this, ['confirmButton', 'cancelButton'], true);
  }
  function enableInput() {
    return setInputDisabled(this.getInput(), false);
  }
  function disableInput() {
    return setInputDisabled(this.getInput(), true);
  }

  function showValidationMessage(error) {
    var domCache = privateProps.domCache.get(this);
    setInnerHtml(domCache.validationMessage, error);
    var popupComputedStyle = window.getComputedStyle(domCache.popup);
    domCache.validationMessage.style.marginLeft = "-".concat(popupComputedStyle.getPropertyValue('padding-left'));
    domCache.validationMessage.style.marginRight = "-".concat(popupComputedStyle.getPropertyValue('padding-right'));
    show(domCache.validationMessage);
    var input = this.getInput();

    if (input) {
      input.setAttribute('aria-invalid', true);
      input.setAttribute('aria-describedBy', swalClasses['validation-message']);
      focusInput(input);
      addClass(input, swalClasses.inputerror);
    }
  } // Hide block with validation message

  function resetValidationMessage$1() {
    var domCache = privateProps.domCache.get(this);

    if (domCache.validationMessage) {
      hide(domCache.validationMessage);
    }

    var input = this.getInput();

    if (input) {
      input.removeAttribute('aria-invalid');
      input.removeAttribute('aria-describedBy');
      removeClass(input, swalClasses.inputerror);
    }
  }

  function getProgressSteps$1() {
    var domCache = privateProps.domCache.get(this);
    return domCache.progressSteps;
  }

  var Timer = /*#__PURE__*/function () {
    function Timer(callback, delay) {
      _classCallCheck(this, Timer);

      this.callback = callback;
      this.remaining = delay;
      this.running = false;
      this.start();
    }

    _createClass(Timer, [{
      key: "start",
      value: function start() {
        if (!this.running) {
          this.running = true;
          this.started = new Date();
          this.id = setTimeout(this.callback, this.remaining);
        }

        return this.remaining;
      }
    }, {
      key: "stop",
      value: function stop() {
        if (this.running) {
          this.running = false;
          clearTimeout(this.id);
          this.remaining -= new Date() - this.started;
        }

        return this.remaining;
      }
    }, {
      key: "increase",
      value: function increase(n) {
        var running = this.running;

        if (running) {
          this.stop();
        }

        this.remaining += n;

        if (running) {
          this.start();
        }

        return this.remaining;
      }
    }, {
      key: "getTimerLeft",
      value: function getTimerLeft() {
        if (this.running) {
          this.stop();
          this.start();
        }

        return this.remaining;
      }
    }, {
      key: "isRunning",
      value: function isRunning() {
        return this.running;
      }
    }]);

    return Timer;
  }();

  var defaultInputValidators = {
    email: function email(string, validationMessage) {
      return /^[a-zA-Z0-9.+_-]+@[a-zA-Z0-9.-]+\.[a-zA-Z0-9-]{2,24}$/.test(string) ? Promise.resolve() : Promise.resolve(validationMessage || 'Invalid email address');
    },
    url: function url(string, validationMessage) {
      // taken from https://stackoverflow.com/a/3809435 with a small change from #1306 and #2013
      return /^https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-z]{2,63}\b([-a-zA-Z0-9@:%_+.~#?&/=]*)$/.test(string) ? Promise.resolve() : Promise.resolve(validationMessage || 'Invalid URL');
    }
  };

  function setDefaultInputValidators(params) {
    // Use default `inputValidator` for supported input types if not provided
    if (!params.inputValidator) {
      Object.keys(defaultInputValidators).forEach(function (key) {
        if (params.input === key) {
          params.inputValidator = defaultInputValidators[key];
        }
      });
    }
  }

  function validateCustomTargetElement(params) {
    // Determine if the custom target element is valid
    if (!params.target || typeof params.target === 'string' && !document.querySelector(params.target) || typeof params.target !== 'string' && !params.target.appendChild) {
      warn('Target parameter is not valid, defaulting to "body"');
      params.target = 'body';
    }
  }
  /**
   * Set type, text and actions on popup
   *
   * @param params
   * @returns {boolean}
   */


  function setParameters(params) {
    setDefaultInputValidators(params); // showLoaderOnConfirm && preConfirm

    if (params.showLoaderOnConfirm && !params.preConfirm) {
      warn('showLoaderOnConfirm is set to true, but preConfirm is not defined.\n' + 'showLoaderOnConfirm should be used together with preConfirm, see usage example:\n' + 'https://sweetalert2.github.io/#ajax-request');
    } // params.animation will be actually used in renderPopup.js
    // but in case when params.animation is a function, we need to call that function
    // before popup (re)initialization, so it'll be possible to check Swal.isVisible()
    // inside the params.animation function


    params.animation = callIfFunction(params.animation);
    validateCustomTargetElement(params); // Replace newlines with <br> in title

    if (typeof params.title === 'string') {
      params.title = params.title.split('\n').join('<br />');
    }

    init(params);
  }

  /**
   * Open popup, add necessary classes and styles, fix scrollbar
   *
   * @param {Array} params
   */

  var openPopup = function openPopup(params) {
    var container = getContainer();
    var popup = getPopup();

    if (typeof params.onBeforeOpen === 'function') {
      params.onBeforeOpen(popup);
    }

    var bodyStyles = window.getComputedStyle(document.body);
    var initialBodyOverflow = bodyStyles.overflowY;
    addClasses$1(container, popup, params); // scrolling is 'hidden' until animation is done, after that 'auto'

    setScrollingVisibility(container, popup);

    if (isModal()) {
      fixScrollContainer(container, params.scrollbarPadding, initialBodyOverflow);
      setAriaHidden();
    }

    if (!isToast() && !globalState.previousActiveElement) {
      globalState.previousActiveElement = document.activeElement;
    }

    if (typeof params.onOpen === 'function') {
      setTimeout(function () {
        return params.onOpen(popup);
      });
    }

    removeClass(container, swalClasses['no-transition']);
  };

  function swalOpenAnimationFinished(event) {
    var popup = getPopup();

    if (event.target !== popup) {
      return;
    }

    var container = getContainer();
    popup.removeEventListener(animationEndEvent, swalOpenAnimationFinished);
    container.style.overflowY = 'auto';
  }

  var setScrollingVisibility = function setScrollingVisibility(container, popup) {
    if (animationEndEvent && hasCssAnimation(popup)) {
      container.style.overflowY = 'hidden';
      popup.addEventListener(animationEndEvent, swalOpenAnimationFinished);
    } else {
      container.style.overflowY = 'auto';
    }
  };

  var fixScrollContainer = function fixScrollContainer(container, scrollbarPadding, initialBodyOverflow) {
    iOSfix();
    IEfix();

    if (scrollbarPadding && initialBodyOverflow !== 'hidden') {
      fixScrollbar();
    } // sweetalert2/issues/1247


    setTimeout(function () {
      container.scrollTop = 0;
    });
  };

  var addClasses$1 = function addClasses(container, popup, params) {
    addClass(container, params.showClass.backdrop);
    show(popup); // Animate popup right after showing it

    addClass(popup, params.showClass.popup);
    addClass([document.documentElement, document.body], swalClasses.shown);

    if (params.heightAuto && params.backdrop && !params.toast) {
      addClass([document.documentElement, document.body], swalClasses['height-auto']);
    }
  };

  var handleInputOptionsAndValue = function handleInputOptionsAndValue(instance, params) {
    if (params.input === 'select' || params.input === 'radio') {
      handleInputOptions(instance, params);
    } else if (['text', 'email', 'number', 'tel', 'textarea'].indexOf(params.input) !== -1 && (hasToPromiseFn(params.inputValue) || isPromise(params.inputValue))) {
      handleInputValue(instance, params);
    }
  };
  var getInputValue = function getInputValue(instance, innerParams) {
    var input = instance.getInput();

    if (!input) {
      return null;
    }

    switch (innerParams.input) {
      case 'checkbox':
        return getCheckboxValue(input);

      case 'radio':
        return getRadioValue(input);

      case 'file':
        return getFileValue(input);

      default:
        return innerParams.inputAutoTrim ? input.value.trim() : input.value;
    }
  };

  var getCheckboxValue = function getCheckboxValue(input) {
    return input.checked ? 1 : 0;
  };

  var getRadioValue = function getRadioValue(input) {
    return input.checked ? input.value : null;
  };

  var getFileValue = function getFileValue(input) {
    return input.files.length ? input.getAttribute('multiple') !== null ? input.files : input.files[0] : null;
  };

  var handleInputOptions = function handleInputOptions(instance, params) {
    var content = getContent();

    var processInputOptions = function processInputOptions(inputOptions) {
      return populateInputOptions[params.input](content, formatInputOptions(inputOptions), params);
    };

    if (hasToPromiseFn(params.inputOptions) || isPromise(params.inputOptions)) {
      showLoading();
      asPromise(params.inputOptions).then(function (inputOptions) {
        instance.hideLoading();
        processInputOptions(inputOptions);
      });
    } else if (_typeof(params.inputOptions) === 'object') {
      processInputOptions(params.inputOptions);
    } else {
      error("Unexpected type of inputOptions! Expected object, Map or Promise, got ".concat(_typeof(params.inputOptions)));
    }
  };

  var handleInputValue = function handleInputValue(instance, params) {
    var input = instance.getInput();
    hide(input);
    asPromise(params.inputValue).then(function (inputValue) {
      input.value = params.input === 'number' ? parseFloat(inputValue) || 0 : "".concat(inputValue);
      show(input);
      input.focus();
      instance.hideLoading();
    })["catch"](function (err) {
      error("Error in inputValue promise: ".concat(err));
      input.value = '';
      show(input);
      input.focus();
      instance.hideLoading();
    });
  };

  var populateInputOptions = {
    select: function select(content, inputOptions, params) {
      var select = getChildByClass(content, swalClasses.select);

      var renderOption = function renderOption(parent, optionLabel, optionValue) {
        var option = document.createElement('option');
        option.value = optionValue;
        setInnerHtml(option, optionLabel);

        if (params.inputValue.toString() === optionValue.toString()) {
          option.selected = true;
        }

        parent.appendChild(option);
      };

      inputOptions.forEach(function (inputOption) {
        var optionValue = inputOption[0];
        var optionLabel = inputOption[1]; // <optgroup> spec:
        // https://www.w3.org/TR/html401/interact/forms.html#h-17.6
        // "...all OPTGROUP elements must be specified directly within a SELECT element (i.e., groups may not be nested)..."
        // check whether this is a <optgroup>

        if (Array.isArray(optionLabel)) {
          // if it is an array, then it is an <optgroup>
          var optgroup = document.createElement('optgroup');
          optgroup.label = optionValue;
          optgroup.disabled = false; // not configurable for now

          select.appendChild(optgroup);
          optionLabel.forEach(function (o) {
            return renderOption(optgroup, o[1], o[0]);
          });
        } else {
          // case of <option>
          renderOption(select, optionLabel, optionValue);
        }
      });
      select.focus();
    },
    radio: function radio(content, inputOptions, params) {
      var radio = getChildByClass(content, swalClasses.radio);
      inputOptions.forEach(function (inputOption) {
        var radioValue = inputOption[0];
        var radioLabel = inputOption[1];
        var radioInput = document.createElement('input');
        var radioLabelElement = document.createElement('label');
        radioInput.type = 'radio';
        radioInput.name = swalClasses.radio;
        radioInput.value = radioValue;

        if (params.inputValue.toString() === radioValue.toString()) {
          radioInput.checked = true;
        }

        var label = document.createElement('span');
        setInnerHtml(label, radioLabel);
        label.className = swalClasses.label;
        radioLabelElement.appendChild(radioInput);
        radioLabelElement.appendChild(label);
        radio.appendChild(radioLabelElement);
      });
      var radios = radio.querySelectorAll('input');

      if (radios.length) {
        radios[0].focus();
      }
    }
  };
  /**
   * Converts `inputOptions` into an array of `[value, label]`s
   * @param inputOptions
   */

  var formatInputOptions = function formatInputOptions(inputOptions) {
    var result = [];

    if (typeof Map !== 'undefined' && inputOptions instanceof Map) {
      inputOptions.forEach(function (value, key) {
        var valueFormatted = value;

        if (_typeof(valueFormatted) === 'object') {
          // case of <optgroup>
          valueFormatted = formatInputOptions(valueFormatted);
        }

        result.push([key, valueFormatted]);
      });
    } else {
      Object.keys(inputOptions).forEach(function (key) {
        var valueFormatted = inputOptions[key];

        if (_typeof(valueFormatted) === 'object') {
          // case of <optgroup>
          valueFormatted = formatInputOptions(valueFormatted);
        }

        result.push([key, valueFormatted]);
      });
    }

    return result;
  };

  var handleConfirmButtonClick = function handleConfirmButtonClick(instance, innerParams) {
    instance.disableButtons();

    if (innerParams.input) {
      handleConfirmWithInput(instance, innerParams);
    } else {
      confirm(instance, innerParams, true);
    }
  };
  var handleCancelButtonClick = function handleCancelButtonClick(instance, dismissWith) {
    instance.disableButtons();
    dismissWith(DismissReason.cancel);
  };

  var handleConfirmWithInput = function handleConfirmWithInput(instance, innerParams) {
    var inputValue = getInputValue(instance, innerParams);

    if (innerParams.inputValidator) {
      instance.disableInput();
      var validationPromise = Promise.resolve().then(function () {
        return asPromise(innerParams.inputValidator(inputValue, innerParams.validationMessage));
      });
      validationPromise.then(function (validationMessage) {
        instance.enableButtons();
        instance.enableInput();

        if (validationMessage) {
          instance.showValidationMessage(validationMessage);
        } else {
          confirm(instance, innerParams, inputValue);
        }
      });
    } else if (!instance.getInput().checkValidity()) {
      instance.enableButtons();
      instance.showValidationMessage(innerParams.validationMessage);
    } else {
      confirm(instance, innerParams, inputValue);
    }
  };

  var succeedWith = function succeedWith(instance, value) {
    instance.closePopup({
      value: value
    });
  };

  var confirm = function confirm(instance, innerParams, value) {
    if (innerParams.showLoaderOnConfirm) {
      showLoading(); // TODO: make showLoading an *instance* method
    }

    if (innerParams.preConfirm) {
      instance.resetValidationMessage();
      var preConfirmPromise = Promise.resolve().then(function () {
        return asPromise(innerParams.preConfirm(value, innerParams.validationMessage));
      });
      preConfirmPromise.then(function (preConfirmValue) {
        if (isVisible(getValidationMessage()) || preConfirmValue === false) {
          instance.hideLoading();
        } else {
          succeedWith(instance, typeof preConfirmValue === 'undefined' ? value : preConfirmValue);
        }
      });
    } else {
      succeedWith(instance, value);
    }
  };

  var addKeydownHandler = function addKeydownHandler(instance, globalState, innerParams, dismissWith) {
    if (globalState.keydownTarget && globalState.keydownHandlerAdded) {
      globalState.keydownTarget.removeEventListener('keydown', globalState.keydownHandler, {
        capture: globalState.keydownListenerCapture
      });
      globalState.keydownHandlerAdded = false;
    }

    if (!innerParams.toast) {
      globalState.keydownHandler = function (e) {
        return keydownHandler(instance, e, dismissWith);
      };

      globalState.keydownTarget = innerParams.keydownListenerCapture ? window : getPopup();
      globalState.keydownListenerCapture = innerParams.keydownListenerCapture;
      globalState.keydownTarget.addEventListener('keydown', globalState.keydownHandler, {
        capture: globalState.keydownListenerCapture
      });
      globalState.keydownHandlerAdded = true;
    }
  }; // Focus handling

  var setFocus = function setFocus(innerParams, index, increment) {
    var focusableElements = getFocusableElements(); // search for visible elements and select the next possible match

    for (var i = 0; i < focusableElements.length; i++) {
      index = index + increment; // rollover to first item

      if (index === focusableElements.length) {
        index = 0; // go to last item
      } else if (index === -1) {
        index = focusableElements.length - 1;
      }

      return focusableElements[index].focus();
    } // no visible focusable elements, focus the popup


    getPopup().focus();
  };
  var arrowKeys = ['ArrowLeft', 'ArrowRight', 'ArrowUp', 'ArrowDown', 'Left', 'Right', 'Up', 'Down' // IE11
  ];
  var escKeys = ['Escape', 'Esc' // IE11
  ];

  var keydownHandler = function keydownHandler(instance, e, dismissWith) {
    var innerParams = privateProps.innerParams.get(instance);

    if (innerParams.stopKeydownPropagation) {
      e.stopPropagation();
    } // ENTER


    if (e.key === 'Enter') {
      handleEnter(instance, e, innerParams); // TAB
    } else if (e.key === 'Tab') {
      handleTab(e, innerParams); // ARROWS - switch focus between buttons
    } else if (arrowKeys.indexOf(e.key) !== -1) {
      handleArrows(); // ESC
    } else if (escKeys.indexOf(e.key) !== -1) {
      handleEsc(e, innerParams, dismissWith);
    }
  };

  var handleEnter = function handleEnter(instance, e, innerParams) {
    // #720 #721
    if (e.isComposing) {
      return;
    }

    if (e.target && instance.getInput() && e.target.outerHTML === instance.getInput().outerHTML) {
      if (['textarea', 'file'].indexOf(innerParams.input) !== -1) {
        return; // do not submit
      }

      clickConfirm();
      e.preventDefault();
    }
  };

  var handleTab = function handleTab(e, innerParams) {
    var targetElement = e.target;
    var focusableElements = getFocusableElements();
    var btnIndex = -1;

    for (var i = 0; i < focusableElements.length; i++) {
      if (targetElement === focusableElements[i]) {
        btnIndex = i;
        break;
      }
    }

    if (!e.shiftKey) {
      // Cycle to the next button
      setFocus(innerParams, btnIndex, 1);
    } else {
      // Cycle to the prev button
      setFocus(innerParams, btnIndex, -1);
    }

    e.stopPropagation();
    e.preventDefault();
  };

  var handleArrows = function handleArrows() {
    var confirmButton = getConfirmButton();
    var cancelButton = getCancelButton(); // focus Cancel button if Confirm button is currently focused

    if (document.activeElement === confirmButton && isVisible(cancelButton)) {
      cancelButton.focus(); // and vice versa
    } else if (document.activeElement === cancelButton && isVisible(confirmButton)) {
      confirmButton.focus();
    }
  };

  var handleEsc = function handleEsc(e, innerParams, dismissWith) {
    if (callIfFunction(innerParams.allowEscapeKey)) {
      e.preventDefault();
      dismissWith(DismissReason.esc);
    }
  };

  var handlePopupClick = function handlePopupClick(instance, domCache, dismissWith) {
    var innerParams = privateProps.innerParams.get(instance);

    if (innerParams.toast) {
      handleToastClick(instance, domCache, dismissWith);
    } else {
      // Ignore click events that had mousedown on the popup but mouseup on the container
      // This can happen when the user drags a slider
      handleModalMousedown(domCache); // Ignore click events that had mousedown on the container but mouseup on the popup

      handleContainerMousedown(domCache);
      handleModalClick(instance, domCache, dismissWith);
    }
  };

  var handleToastClick = function handleToastClick(instance, domCache, dismissWith) {
    // Closing toast by internal click
    domCache.popup.onclick = function () {
      var innerParams = privateProps.innerParams.get(instance);

      if (innerParams.showConfirmButton || innerParams.showCancelButton || innerParams.showCloseButton || innerParams.input) {
        return;
      }

      dismissWith(DismissReason.close);
    };
  };

  var ignoreOutsideClick = false;

  var handleModalMousedown = function handleModalMousedown(domCache) {
    domCache.popup.onmousedown = function () {
      domCache.container.onmouseup = function (e) {
        domCache.container.onmouseup = undefined; // We only check if the mouseup target is the container because usually it doesn't
        // have any other direct children aside of the popup

        if (e.target === domCache.container) {
          ignoreOutsideClick = true;
        }
      };
    };
  };

  var handleContainerMousedown = function handleContainerMousedown(domCache) {
    domCache.container.onmousedown = function () {
      domCache.popup.onmouseup = function (e) {
        domCache.popup.onmouseup = undefined; // We also need to check if the mouseup target is a child of the popup

        if (e.target === domCache.popup || domCache.popup.contains(e.target)) {
          ignoreOutsideClick = true;
        }
      };
    };
  };

  var handleModalClick = function handleModalClick(instance, domCache, dismissWith) {
    domCache.container.onclick = function (e) {
      var innerParams = privateProps.innerParams.get(instance);

      if (ignoreOutsideClick) {
        ignoreOutsideClick = false;
        return;
      }

      if (e.target === domCache.container && callIfFunction(innerParams.allowOutsideClick)) {
        dismissWith(DismissReason.backdrop);
      }
    };
  };

  function _main(userParams) {
    showWarningsForParams(userParams);

    if (globalState.currentInstance) {
      globalState.currentInstance._destroy();
    }

    globalState.currentInstance = this;
    var innerParams = prepareParams(userParams);
    setParameters(innerParams);
    Object.freeze(innerParams); // clear the previous timer

    if (globalState.timeout) {
      globalState.timeout.stop();
      delete globalState.timeout;
    } // clear the restore focus timeout


    clearTimeout(globalState.restoreFocusTimeout);
    var domCache = populateDomCache(this);
    render(this, innerParams);
    privateProps.innerParams.set(this, innerParams);
    return swalPromise(this, domCache, innerParams);
  }

  var prepareParams = function prepareParams(userParams) {
    var showClass = _extends({}, defaultParams.showClass, userParams.showClass);

    var hideClass = _extends({}, defaultParams.hideClass, userParams.hideClass);

    var params = _extends({}, defaultParams, userParams);

    params.showClass = showClass;
    params.hideClass = hideClass; // @deprecated

    if (userParams.animation === false) {
      params.showClass = {
        popup: 'swal2-noanimation',
        backdrop: 'swal2-noanimation'
      };
      params.hideClass = {};
    }

    return params;
  };

  var swalPromise = function swalPromise(instance, domCache, innerParams) {
    return new Promise(function (resolve) {
      // functions to handle all closings/dismissals
      var dismissWith = function dismissWith(dismiss) {
        instance.closePopup({
          dismiss: dismiss
        });
      };

      privateMethods.swalPromiseResolve.set(instance, resolve);

      domCache.confirmButton.onclick = function () {
        return handleConfirmButtonClick(instance, innerParams);
      };

      domCache.cancelButton.onclick = function () {
        return handleCancelButtonClick(instance, dismissWith);
      };

      domCache.closeButton.onclick = function () {
        return dismissWith(DismissReason.close);
      };

      handlePopupClick(instance, domCache, dismissWith);
      addKeydownHandler(instance, globalState, innerParams, dismissWith);

      if (innerParams.toast && (innerParams.input || innerParams.footer || innerParams.showCloseButton)) {
        addClass(document.body, swalClasses['toast-column']);
      } else {
        removeClass(document.body, swalClasses['toast-column']);
      }

      handleInputOptionsAndValue(instance, innerParams);
      openPopup(innerParams);
      setupTimer(globalState, innerParams, dismissWith);
      initFocus(domCache, innerParams); // Scroll container to top on open (#1247, #1946)

      setTimeout(function () {
        domCache.container.scrollTop = 0;
      });
    });
  };

  var populateDomCache = function populateDomCache(instance) {
    var domCache = {
      popup: getPopup(),
      container: getContainer(),
      content: getContent(),
      actions: getActions(),
      confirmButton: getConfirmButton(),
      cancelButton: getCancelButton(),
      closeButton: getCloseButton(),
      validationMessage: getValidationMessage(),
      progressSteps: getProgressSteps()
    };
    privateProps.domCache.set(instance, domCache);
    return domCache;
  };

  var setupTimer = function setupTimer(globalState$$1, innerParams, dismissWith) {
    var timerProgressBar = getTimerProgressBar();
    hide(timerProgressBar);

    if (innerParams.timer) {
      globalState$$1.timeout = new Timer(function () {
        dismissWith('timer');
        delete globalState$$1.timeout;
      }, innerParams.timer);

      if (innerParams.timerProgressBar) {
        show(timerProgressBar);
        setTimeout(function () {
          if (globalState$$1.timeout.running) {
            // timer can be already stopped at this point
            animateTimerProgressBar(innerParams.timer);
          }
        });
      }
    }
  };

  var initFocus = function initFocus(domCache, innerParams) {
    if (innerParams.toast) {
      return;
    }

    if (!callIfFunction(innerParams.allowEnterKey)) {
      return blurActiveElement();
    }

    if (innerParams.focusCancel && isVisible(domCache.cancelButton)) {
      return domCache.cancelButton.focus();
    }

    if (innerParams.focusConfirm && isVisible(domCache.confirmButton)) {
      return domCache.confirmButton.focus();
    }

    setFocus(innerParams, -1, 1);
  };

  var blurActiveElement = function blurActiveElement() {
    if (document.activeElement && typeof document.activeElement.blur === 'function') {
      document.activeElement.blur();
    }
  };

  /**
   * Updates popup parameters.
   */

  function update(params) {
    var popup = getPopup();
    var innerParams = privateProps.innerParams.get(this);

    if (!popup || hasClass(popup, innerParams.hideClass.popup)) {
      return warn("You're trying to update the closed or closing popup, that won't work. Use the update() method in preConfirm parameter or show a new popup.");
    }

    var validUpdatableParams = {}; // assign valid params from `params` to `defaults`

    Object.keys(params).forEach(function (param) {
      if (Swal.isUpdatableParameter(param)) {
        validUpdatableParams[param] = params[param];
      } else {
        warn("Invalid parameter to update: \"".concat(param, "\". Updatable params are listed here: https://github.com/sweetalert2/sweetalert2/blob/master/src/utils/params.js"));
      }
    });

    var updatedParams = _extends({}, innerParams, validUpdatableParams);

    render(this, updatedParams);
    privateProps.innerParams.set(this, updatedParams);
    Object.defineProperties(this, {
      params: {
        value: _extends({}, this.params, params),
        writable: false,
        enumerable: true
      }
    });
  }

  function _destroy() {
    var domCache = privateProps.domCache.get(this);
    var innerParams = privateProps.innerParams.get(this);

    if (!innerParams) {
      return; // This instance has already been destroyed
    } // Check if there is another Swal closing


    if (domCache.popup && globalState.swalCloseEventFinishedCallback) {
      globalState.swalCloseEventFinishedCallback();
      delete globalState.swalCloseEventFinishedCallback;
    } // Check if there is a swal disposal defer timer


    if (globalState.deferDisposalTimer) {
      clearTimeout(globalState.deferDisposalTimer);
      delete globalState.deferDisposalTimer;
    }

    if (typeof innerParams.onDestroy === 'function') {
      innerParams.onDestroy();
    }

    disposeSwal(this);
  }

  var disposeSwal = function disposeSwal(instance) {
    // Unset this.params so GC will dispose it (#1569)
    delete instance.params; // Unset globalState props so GC will dispose globalState (#1569)

    delete globalState.keydownHandler;
    delete globalState.keydownTarget; // Unset WeakMaps so GC will be able to dispose them (#1569)

    unsetWeakMaps(privateProps);
    unsetWeakMaps(privateMethods);
  };

  var unsetWeakMaps = function unsetWeakMaps(obj) {
    for (var i in obj) {
      obj[i] = new WeakMap();
    }
  };



  var instanceMethods = /*#__PURE__*/Object.freeze({
    hideLoading: hideLoading,
    disableLoading: hideLoading,
    getInput: getInput$1,
    close: close,
    closePopup: close,
    closeModal: close,
    closeToast: close,
    enableButtons: enableButtons,
    disableButtons: disableButtons,
    enableInput: enableInput,
    disableInput: disableInput,
    showValidationMessage: showValidationMessage,
    resetValidationMessage: resetValidationMessage$1,
    getProgressSteps: getProgressSteps$1,
    _main: _main,
    update: update,
    _destroy: _destroy
  });

  var currentInstance;

  var SweetAlert = /*#__PURE__*/function () {
    function SweetAlert() {
      _classCallCheck(this, SweetAlert);

      // Prevent run in Node env
      if (typeof window === 'undefined') {
        return;
      } // Check for the existence of Promise


      if (typeof Promise === 'undefined') {
        error('This package requires a Promise library, please include a shim to enable it in this browser (See: https://github.com/sweetalert2/sweetalert2/wiki/Migration-from-SweetAlert-to-SweetAlert2#1-ie-support)');
      }

      currentInstance = this;

      for (var _len = arguments.length, args = new Array(_len), _key = 0; _key < _len; _key++) {
        args[_key] = arguments[_key];
      }

      var outerParams = Object.freeze(this.constructor.argsToParams(args));
      Object.defineProperties(this, {
        params: {
          value: outerParams,
          writable: false,
          enumerable: true,
          configurable: true
        }
      });

      var promise = this._main(this.params);

      privateProps.promise.set(this, promise);
    } // `catch` cannot be the name of a module export, so we define our thenable methods here instead


    _createClass(SweetAlert, [{
      key: "then",
      value: function then(onFulfilled) {
        var promise = privateProps.promise.get(this);
        return promise.then(onFulfilled);
      }
    }, {
      key: "finally",
      value: function _finally(onFinally) {
        var promise = privateProps.promise.get(this);
        return promise["finally"](onFinally);
      }
    }]);

    return SweetAlert;
  }(); // Assign instance methods from src/instanceMethods/*.js to prototype


  _extends(SweetAlert.prototype, instanceMethods); // Assign static methods from src/staticMethods/*.js to constructor


  _extends(SweetAlert, staticMethods); // Proxy to instance methods to constructor, for now, for backwards compatibility


  Object.keys(instanceMethods).forEach(function (key) {
    SweetAlert[key] = function () {
      if (currentInstance) {
        var _currentInstance;

        return (_currentInstance = currentInstance)[key].apply(_currentInstance, arguments);
      }
    };
  });
  SweetAlert.DismissReason = DismissReason;
  SweetAlert.version = '9.17.2';

  var Swal = SweetAlert;
  Swal["default"] = Swal;

  return Swal;

}));
if (typeof this !== 'undefined' && this.Sweetalert2){  this.swal = this.sweetAlert = this.Swal = this.SweetAlert = this.Sweetalert2}

"undefined"!=typeof document&&function(e,t){var n=e.createElement("style");if(e.getElementsByTagName("head")[0].appendChild(n),n.styleSheet)n.styleSheet.disabled||(n.styleSheet.cssText=t);else try{n.innerHTML=t}catch(e){n.innerText=t}}(document,".swal2-popup.swal2-toast{flex-direction:row;align-items:center;width:auto;padding:.625em;overflow-y:hidden;background:#fff;box-shadow:0 0 .625em #d9d9d9}.swal2-popup.swal2-toast .swal2-header{flex-direction:row;padding:0}.swal2-popup.swal2-toast .swal2-title{flex-grow:1;justify-content:flex-start;margin:0 .6em;font-size:1em}.swal2-popup.swal2-toast .swal2-footer{margin:.5em 0 0;padding:.5em 0 0;font-size:.8em}.swal2-popup.swal2-toast .swal2-close{position:static;width:.8em;height:.8em;line-height:.8}.swal2-popup.swal2-toast .swal2-content{justify-content:flex-start;padding:0;font-size:1em}.swal2-popup.swal2-toast .swal2-icon{width:2em;min-width:2em;height:2em;margin:0}.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:1.8em;font-weight:700}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-popup.swal2-toast .swal2-icon .swal2-icon-content{font-size:.25em}}.swal2-popup.swal2-toast .swal2-icon.swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line]{top:.875em;width:1.375em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:.3125em}.swal2-popup.swal2-toast .swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:.3125em}.swal2-popup.swal2-toast .swal2-actions{flex-basis:auto!important;width:auto;height:auto;margin:0 .3125em}.swal2-popup.swal2-toast .swal2-styled{margin:0 .3125em;padding:.3125em .625em;font-size:1em}.swal2-popup.swal2-toast .swal2-styled:focus{box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-popup.swal2-toast .swal2-success{border-color:#a5dc86}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line]{position:absolute;width:1.6em;height:3em;transform:rotate(45deg);border-radius:50%}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.8em;left:-.5em;transform:rotate(-45deg);transform-origin:2em 2em;border-radius:4em 0 0 4em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.25em;left:.9375em;transform-origin:0 1.5em;border-radius:0 4em 4em 0}.swal2-popup.swal2-toast .swal2-success .swal2-success-ring{width:2em;height:2em}.swal2-popup.swal2-toast .swal2-success .swal2-success-fix{top:0;left:.4375em;width:.4375em;height:2.6875em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line]{height:.3125em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=tip]{top:1.125em;left:.1875em;width:.75em}.swal2-popup.swal2-toast .swal2-success [class^=swal2-success-line][class$=long]{top:.9375em;right:.1875em;width:1.375em}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-toast-animate-success-line-tip .75s;animation:swal2-toast-animate-success-line-tip .75s}.swal2-popup.swal2-toast .swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-toast-animate-success-line-long .75s;animation:swal2-toast-animate-success-line-long .75s}.swal2-popup.swal2-toast.swal2-show{-webkit-animation:swal2-toast-show .5s;animation:swal2-toast-show .5s}.swal2-popup.swal2-toast.swal2-hide{-webkit-animation:swal2-toast-hide .1s forwards;animation:swal2-toast-hide .1s forwards}.swal2-container{display:flex;position:fixed;z-index:1060;top:0;right:0;bottom:0;left:0;flex-direction:row;align-items:center;justify-content:center;padding:.625em;overflow-x:hidden;transition:background-color .1s;-webkit-overflow-scrolling:touch}.swal2-container.swal2-backdrop-show,.swal2-container.swal2-noanimation{background:rgba(0,0,0,.4)}.swal2-container.swal2-backdrop-hide{background:0 0!important}.swal2-container.swal2-top{align-items:flex-start}.swal2-container.swal2-top-left,.swal2-container.swal2-top-start{align-items:flex-start;justify-content:flex-start}.swal2-container.swal2-top-end,.swal2-container.swal2-top-right{align-items:flex-start;justify-content:flex-end}.swal2-container.swal2-center{align-items:center}.swal2-container.swal2-center-left,.swal2-container.swal2-center-start{align-items:center;justify-content:flex-start}.swal2-container.swal2-center-end,.swal2-container.swal2-center-right{align-items:center;justify-content:flex-end}.swal2-container.swal2-bottom{align-items:flex-end}.swal2-container.swal2-bottom-left,.swal2-container.swal2-bottom-start{align-items:flex-end;justify-content:flex-start}.swal2-container.swal2-bottom-end,.swal2-container.swal2-bottom-right{align-items:flex-end;justify-content:flex-end}.swal2-container.swal2-bottom-end>:first-child,.swal2-container.swal2-bottom-left>:first-child,.swal2-container.swal2-bottom-right>:first-child,.swal2-container.swal2-bottom-start>:first-child,.swal2-container.swal2-bottom>:first-child{margin-top:auto}.swal2-container.swal2-grow-fullscreen>.swal2-modal{display:flex!important;flex:1;align-self:stretch;justify-content:center}.swal2-container.swal2-grow-row>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-grow-column{flex:1;flex-direction:column}.swal2-container.swal2-grow-column.swal2-bottom,.swal2-container.swal2-grow-column.swal2-center,.swal2-container.swal2-grow-column.swal2-top{align-items:center}.swal2-container.swal2-grow-column.swal2-bottom-left,.swal2-container.swal2-grow-column.swal2-bottom-start,.swal2-container.swal2-grow-column.swal2-center-left,.swal2-container.swal2-grow-column.swal2-center-start,.swal2-container.swal2-grow-column.swal2-top-left,.swal2-container.swal2-grow-column.swal2-top-start{align-items:flex-start}.swal2-container.swal2-grow-column.swal2-bottom-end,.swal2-container.swal2-grow-column.swal2-bottom-right,.swal2-container.swal2-grow-column.swal2-center-end,.swal2-container.swal2-grow-column.swal2-center-right,.swal2-container.swal2-grow-column.swal2-top-end,.swal2-container.swal2-grow-column.swal2-top-right{align-items:flex-end}.swal2-container.swal2-grow-column>.swal2-modal{display:flex!important;flex:1;align-content:center;justify-content:center}.swal2-container.swal2-no-transition{transition:none!important}.swal2-container:not(.swal2-top):not(.swal2-top-start):not(.swal2-top-end):not(.swal2-top-left):not(.swal2-top-right):not(.swal2-center-start):not(.swal2-center-end):not(.swal2-center-left):not(.swal2-center-right):not(.swal2-bottom):not(.swal2-bottom-start):not(.swal2-bottom-end):not(.swal2-bottom-left):not(.swal2-bottom-right):not(.swal2-grow-fullscreen)>.swal2-modal{margin:auto}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-container .swal2-modal{margin:0!important}}.swal2-popup{display:none;position:relative;box-sizing:border-box;flex-direction:column;justify-content:center;width:32em;max-width:100%;padding:1.25em;border:none;border-radius:.3125em;background:#fff;font-family:inherit;font-size:1rem}.swal2-popup:focus{outline:0}.swal2-popup.swal2-loading{overflow-y:hidden}.swal2-header{display:flex;flex-direction:column;align-items:center;padding:0 1.8em}.swal2-title{position:relative;max-width:100%;margin:0 0 .4em;padding:0;color:#595959;font-size:1.875em;font-weight:600;text-align:center;text-transform:none;word-wrap:break-word}.swal2-actions{display:flex;z-index:1;flex-wrap:wrap;align-items:center;justify-content:center;width:100%;margin:1.25em auto 0}.swal2-actions:not(.swal2-loading) .swal2-styled[disabled]{opacity:.4}.swal2-actions:not(.swal2-loading) .swal2-styled:hover{background-image:linear-gradient(rgba(0,0,0,.1),rgba(0,0,0,.1))}.swal2-actions:not(.swal2-loading) .swal2-styled:active{background-image:linear-gradient(rgba(0,0,0,.2),rgba(0,0,0,.2))}.swal2-actions.swal2-loading .swal2-styled.swal2-confirm{box-sizing:border-box;width:2.5em;height:2.5em;margin:.46875em;padding:0;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:.25em solid transparent;border-radius:100%;border-color:transparent;background-color:transparent!important;color:transparent!important;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-actions.swal2-loading .swal2-styled.swal2-cancel{margin-right:30px;margin-left:30px}.swal2-actions.swal2-loading :not(.swal2-styled).swal2-confirm::after{content:\"\";display:inline-block;width:15px;height:15px;margin-left:5px;-webkit-animation:swal2-rotate-loading 1.5s linear 0s infinite normal;animation:swal2-rotate-loading 1.5s linear 0s infinite normal;border:3px solid #999;border-radius:50%;border-right-color:transparent;box-shadow:1px 1px 1px #fff}.swal2-styled{margin:.3125em;padding:.625em 2em;box-shadow:none;font-weight:500}.swal2-styled:not([disabled]){cursor:pointer}.swal2-styled.swal2-confirm{border:0;border-radius:.25em;background:initial;background-color:#3085d6;color:#fff;font-size:1.0625em}.swal2-styled.swal2-cancel{border:0;border-radius:.25em;background:initial;background-color:#aaa;color:#fff;font-size:1.0625em}.swal2-styled:focus{outline:0;box-shadow:0 0 0 1px #fff,0 0 0 3px rgba(50,100,150,.4)}.swal2-styled::-moz-focus-inner{border:0}.swal2-footer{justify-content:center;margin:1.25em 0 0;padding:1em 0 0;border-top:1px solid #eee;color:#545454;font-size:1em}.swal2-timer-progress-bar-container{position:absolute;right:0;bottom:0;left:0;height:.25em;overflow:hidden;border-bottom-right-radius:.3125em;border-bottom-left-radius:.3125em}.swal2-timer-progress-bar{width:100%;height:.25em;background:rgba(0,0,0,.2)}.swal2-image{max-width:100%;margin:1.25em auto}.swal2-close{position:absolute;z-index:2;top:0;right:0;align-items:center;justify-content:center;width:1.2em;height:1.2em;padding:0;overflow:hidden;transition:color .1s ease-out;border:none;border-radius:0;background:0 0;color:#ccc;font-family:serif;font-size:2.5em;line-height:1.2;cursor:pointer}.swal2-close:hover{transform:none;background:0 0;color:#f27474}.swal2-close::-moz-focus-inner{border:0}.swal2-content{z-index:1;justify-content:center;margin:0;padding:0 1.6em;color:#545454;font-size:1.125em;font-weight:400;line-height:normal;text-align:center;word-wrap:break-word}.swal2-checkbox,.swal2-file,.swal2-input,.swal2-radio,.swal2-select,.swal2-textarea{margin:1em auto}.swal2-file,.swal2-input,.swal2-textarea{box-sizing:border-box;width:100%;transition:border-color .3s,box-shadow .3s;border:1px solid #d9d9d9;border-radius:.1875em;background:inherit;box-shadow:inset 0 1px 1px rgba(0,0,0,.06);color:inherit;font-size:1.125em}.swal2-file.swal2-inputerror,.swal2-input.swal2-inputerror,.swal2-textarea.swal2-inputerror{border-color:#f27474!important;box-shadow:0 0 2px #f27474!important}.swal2-file:focus,.swal2-input:focus,.swal2-textarea:focus{border:1px solid #b4dbed;outline:0;box-shadow:0 0 3px #c4e6f5}.swal2-file::-moz-placeholder,.swal2-input::-moz-placeholder,.swal2-textarea::-moz-placeholder{color:#ccc}.swal2-file:-ms-input-placeholder,.swal2-input:-ms-input-placeholder,.swal2-textarea:-ms-input-placeholder{color:#ccc}.swal2-file::-ms-input-placeholder,.swal2-input::-ms-input-placeholder,.swal2-textarea::-ms-input-placeholder{color:#ccc}.swal2-file::placeholder,.swal2-input::placeholder,.swal2-textarea::placeholder{color:#ccc}.swal2-range{margin:1em auto;background:#fff}.swal2-range input{width:80%}.swal2-range output{width:20%;color:inherit;font-weight:600;text-align:center}.swal2-range input,.swal2-range output{height:2.625em;padding:0;font-size:1.125em;line-height:2.625em}.swal2-input{height:2.625em;padding:0 .75em}.swal2-input[type=number]{max-width:10em}.swal2-file{background:inherit;font-size:1.125em}.swal2-textarea{height:6.75em;padding:.75em}.swal2-select{min-width:50%;max-width:100%;padding:.375em .625em;background:inherit;color:inherit;font-size:1.125em}.swal2-checkbox,.swal2-radio{align-items:center;justify-content:center;background:#fff;color:inherit}.swal2-checkbox label,.swal2-radio label{margin:0 .6em;font-size:1.125em}.swal2-checkbox input,.swal2-radio input{margin:0 .4em}.swal2-validation-message{display:none;align-items:center;justify-content:center;padding:.625em;overflow:hidden;background:#f0f0f0;color:#666;font-size:1em;font-weight:300}.swal2-validation-message::before{content:\"!\";display:inline-block;width:1.5em;min-width:1.5em;height:1.5em;margin:0 .625em;border-radius:50%;background-color:#f27474;color:#fff;font-weight:600;line-height:1.5em;text-align:center}.swal2-icon{position:relative;box-sizing:content-box;justify-content:center;width:5em;height:5em;margin:1.25em auto 1.875em;border:.25em solid transparent;border-radius:50%;font-family:inherit;line-height:5em;cursor:default;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none}.swal2-icon .swal2-icon-content{display:flex;align-items:center;font-size:3.75em}.swal2-icon.swal2-error{border-color:#f27474;color:#f27474}.swal2-icon.swal2-error .swal2-x-mark{position:relative;flex-grow:1}.swal2-icon.swal2-error [class^=swal2-x-mark-line]{display:block;position:absolute;top:2.3125em;width:2.9375em;height:.3125em;border-radius:.125em;background-color:#f27474}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=left]{left:1.0625em;transform:rotate(45deg)}.swal2-icon.swal2-error [class^=swal2-x-mark-line][class$=right]{right:1em;transform:rotate(-45deg)}.swal2-icon.swal2-error.swal2-icon-show{-webkit-animation:swal2-animate-error-icon .5s;animation:swal2-animate-error-icon .5s}.swal2-icon.swal2-error.swal2-icon-show .swal2-x-mark{-webkit-animation:swal2-animate-error-x-mark .5s;animation:swal2-animate-error-x-mark .5s}.swal2-icon.swal2-warning{border-color:#facea8;color:#f8bb86}.swal2-icon.swal2-info{border-color:#9de0f6;color:#3fc3ee}.swal2-icon.swal2-question{border-color:#c9dae1;color:#87adbd}.swal2-icon.swal2-success{border-color:#a5dc86;color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-circular-line]{position:absolute;width:3.75em;height:7.5em;transform:rotate(45deg);border-radius:50%}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=left]{top:-.4375em;left:-2.0635em;transform:rotate(-45deg);transform-origin:3.75em 3.75em;border-radius:7.5em 0 0 7.5em}.swal2-icon.swal2-success [class^=swal2-success-circular-line][class$=right]{top:-.6875em;left:1.875em;transform:rotate(-45deg);transform-origin:0 3.75em;border-radius:0 7.5em 7.5em 0}.swal2-icon.swal2-success .swal2-success-ring{position:absolute;z-index:2;top:-.25em;left:-.25em;box-sizing:content-box;width:100%;height:100%;border:.25em solid rgba(165,220,134,.3);border-radius:50%}.swal2-icon.swal2-success .swal2-success-fix{position:absolute;z-index:1;top:.5em;left:1.625em;width:.4375em;height:5.625em;transform:rotate(-45deg)}.swal2-icon.swal2-success [class^=swal2-success-line]{display:block;position:absolute;z-index:2;height:.3125em;border-radius:.125em;background-color:#a5dc86}.swal2-icon.swal2-success [class^=swal2-success-line][class$=tip]{top:2.875em;left:.8125em;width:1.5625em;transform:rotate(45deg)}.swal2-icon.swal2-success [class^=swal2-success-line][class$=long]{top:2.375em;right:.5em;width:2.9375em;transform:rotate(-45deg)}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-tip{-webkit-animation:swal2-animate-success-line-tip .75s;animation:swal2-animate-success-line-tip .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-line-long{-webkit-animation:swal2-animate-success-line-long .75s;animation:swal2-animate-success-line-long .75s}.swal2-icon.swal2-success.swal2-icon-show .swal2-success-circular-line-right{-webkit-animation:swal2-rotate-success-circular-line 4.25s ease-in;animation:swal2-rotate-success-circular-line 4.25s ease-in}.swal2-progress-steps{align-items:center;margin:0 0 1.25em;padding:0;background:inherit;font-weight:600}.swal2-progress-steps li{display:inline-block;position:relative}.swal2-progress-steps .swal2-progress-step{z-index:20;width:2em;height:2em;border-radius:2em;background:#3085d6;color:#fff;line-height:2em;text-align:center}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step{background:#3085d6}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step{background:#add8e6;color:#fff}.swal2-progress-steps .swal2-progress-step.swal2-active-progress-step~.swal2-progress-step-line{background:#add8e6}.swal2-progress-steps .swal2-progress-step-line{z-index:10;width:2.5em;height:.4em;margin:0 -1px;background:#3085d6}[class^=swal2]{-webkit-tap-highlight-color:transparent}.swal2-show{-webkit-animation:swal2-show .3s;animation:swal2-show .3s}.swal2-hide{-webkit-animation:swal2-hide .15s forwards;animation:swal2-hide .15s forwards}.swal2-noanimation{transition:none}.swal2-scrollbar-measure{position:absolute;top:-9999px;width:50px;height:50px;overflow:scroll}.swal2-rtl .swal2-close{right:auto;left:0}.swal2-rtl .swal2-timer-progress-bar{right:0;left:auto}@supports (-ms-accelerator:true){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@media all and (-ms-high-contrast:none),(-ms-high-contrast:active){.swal2-range input{width:100%!important}.swal2-range output{display:none}}@-moz-document url-prefix(){.swal2-close:focus{outline:2px solid rgba(50,100,150,.4)}}@-webkit-keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@keyframes swal2-toast-show{0%{transform:translateY(-.625em) rotateZ(2deg)}33%{transform:translateY(0) rotateZ(-2deg)}66%{transform:translateY(.3125em) rotateZ(2deg)}100%{transform:translateY(0) rotateZ(0)}}@-webkit-keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@keyframes swal2-toast-hide{100%{transform:rotateZ(1deg);opacity:0}}@-webkit-keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@keyframes swal2-toast-animate-success-line-tip{0%{top:.5625em;left:.0625em;width:0}54%{top:.125em;left:.125em;width:0}70%{top:.625em;left:-.25em;width:1.625em}84%{top:1.0625em;left:.75em;width:.5em}100%{top:1.125em;left:.1875em;width:.75em}}@-webkit-keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@keyframes swal2-toast-animate-success-line-long{0%{top:1.625em;right:1.375em;width:0}65%{top:1.25em;right:.9375em;width:0}84%{top:.9375em;right:0;width:1.125em}100%{top:.9375em;right:.1875em;width:1.375em}}@-webkit-keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@keyframes swal2-show{0%{transform:scale(.7)}45%{transform:scale(1.05)}80%{transform:scale(.95)}100%{transform:scale(1)}}@-webkit-keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@keyframes swal2-hide{0%{transform:scale(1);opacity:1}100%{transform:scale(.5);opacity:0}}@-webkit-keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@keyframes swal2-animate-success-line-tip{0%{top:1.1875em;left:.0625em;width:0}54%{top:1.0625em;left:.125em;width:0}70%{top:2.1875em;left:-.375em;width:3.125em}84%{top:3em;left:1.3125em;width:1.0625em}100%{top:2.8125em;left:.8125em;width:1.5625em}}@-webkit-keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@keyframes swal2-animate-success-line-long{0%{top:3.375em;right:2.875em;width:0}65%{top:3.375em;right:2.875em;width:0}84%{top:2.1875em;right:0;width:3.4375em}100%{top:2.375em;right:.5em;width:2.9375em}}@-webkit-keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@keyframes swal2-rotate-success-circular-line{0%{transform:rotate(-45deg)}5%{transform:rotate(-45deg)}12%{transform:rotate(-405deg)}100%{transform:rotate(-405deg)}}@-webkit-keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@keyframes swal2-animate-error-x-mark{0%{margin-top:1.625em;transform:scale(.4);opacity:0}50%{margin-top:1.625em;transform:scale(.4);opacity:0}80%{margin-top:-.375em;transform:scale(1.15)}100%{margin-top:0;transform:scale(1);opacity:1}}@-webkit-keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@keyframes swal2-animate-error-icon{0%{transform:rotateX(100deg);opacity:0}100%{transform:rotateX(0);opacity:1}}@-webkit-keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}@keyframes swal2-rotate-loading{0%{transform:rotate(0)}100%{transform:rotate(360deg)}}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow:hidden}body.swal2-height-auto{height:auto!important}body.swal2-no-backdrop .swal2-container{top:auto;right:auto;bottom:auto;left:auto;max-width:calc(100% - .625em * 2);background-color:transparent!important}body.swal2-no-backdrop .swal2-container>.swal2-modal{box-shadow:0 0 10px rgba(0,0,0,.4)}body.swal2-no-backdrop .swal2-container.swal2-top{top:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-top-left,body.swal2-no-backdrop .swal2-container.swal2-top-start{top:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-top-end,body.swal2-no-backdrop .swal2-container.swal2-top-right{top:0;right:0}body.swal2-no-backdrop .swal2-container.swal2-center{top:50%;left:50%;transform:translate(-50%,-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-left,body.swal2-no-backdrop .swal2-container.swal2-center-start{top:50%;left:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-center-end,body.swal2-no-backdrop .swal2-container.swal2-center-right{top:50%;right:0;transform:translateY(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom{bottom:0;left:50%;transform:translateX(-50%)}body.swal2-no-backdrop .swal2-container.swal2-bottom-left,body.swal2-no-backdrop .swal2-container.swal2-bottom-start{bottom:0;left:0}body.swal2-no-backdrop .swal2-container.swal2-bottom-end,body.swal2-no-backdrop .swal2-container.swal2-bottom-right{right:0;bottom:0}@media print{body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown){overflow-y:scroll!important}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown)>[aria-hidden=true]{display:none}body.swal2-shown:not(.swal2-no-backdrop):not(.swal2-toast-shown) .swal2-container{position:static!important}}body.swal2-toast-shown .swal2-container{background-color:transparent}body.swal2-toast-shown .swal2-container.swal2-top{top:0;right:auto;bottom:auto;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-top-end,body.swal2-toast-shown .swal2-container.swal2-top-right{top:0;right:0;bottom:auto;left:auto}body.swal2-toast-shown .swal2-container.swal2-top-left,body.swal2-toast-shown .swal2-container.swal2-top-start{top:0;right:auto;bottom:auto;left:0}body.swal2-toast-shown .swal2-container.swal2-center-left,body.swal2-toast-shown .swal2-container.swal2-center-start{top:50%;right:auto;bottom:auto;left:0;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-center{top:50%;right:auto;bottom:auto;left:50%;transform:translate(-50%,-50%)}body.swal2-toast-shown .swal2-container.swal2-center-end,body.swal2-toast-shown .swal2-container.swal2-center-right{top:50%;right:0;bottom:auto;left:auto;transform:translateY(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-left,body.swal2-toast-shown .swal2-container.swal2-bottom-start{top:auto;right:auto;bottom:0;left:0}body.swal2-toast-shown .swal2-container.swal2-bottom{top:auto;right:auto;bottom:0;left:50%;transform:translateX(-50%)}body.swal2-toast-shown .swal2-container.swal2-bottom-end,body.swal2-toast-shown .swal2-container.swal2-bottom-right{top:auto;right:0;bottom:0;left:auto}body.swal2-toast-column .swal2-toast{flex-direction:column;align-items:stretch}body.swal2-toast-column .swal2-toast .swal2-actions{flex:1;align-self:stretch;height:2.2em;margin-top:.3125em}body.swal2-toast-column .swal2-toast .swal2-loading{justify-content:center}body.swal2-toast-column .swal2-toast .swal2-input{height:2em;margin:.3125em auto;font-size:1em}body.swal2-toast-column .swal2-toast .swal2-validation-message{font-size:1em}");

/***/ }),

/***/ "./node_modules/webpack/buildin/module.js":
/*!***********************************!*\
  !*** (webpack)/buildin/module.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

module.exports = function(module) {
	if (!module.webpackPolyfill) {
		module.deprecate = function() {};
		module.paths = [];
		// module.parent = undefined by default
		if (!module.children) module.children = [];
		Object.defineProperty(module, "loaded", {
			enumerable: true,
			get: function() {
				return module.l;
			}
		});
		Object.defineProperty(module, "id", {
			enumerable: true,
			get: function() {
				return module.i;
			}
		});
		module.webpackPolyfill = 1;
	}
	return module;
};


/***/ }),

/***/ "./resources/js/dashboard/mail/compose-email.js":
/*!******************************************************!*\
  !*** ./resources/js/dashboard/mail/compose-email.js ***!
  \******************************************************/
/*! no exports provided */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony import */ var _main__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! ../main */ "./resources/js/dashboard/main.js");
/* harmony import */ var _theme_js_vendor_dropzone_min_js__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! ../../../theme/js/vendor/dropzone.min.js */ "./resources/theme/js/vendor/dropzone.min.js");
/* harmony import */ var _theme_js_vendor_dropzone_min_js__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(_theme_js_vendor_dropzone_min_js__WEBPACK_IMPORTED_MODULE_1__);

 //! Global Variables

var baseUrl = window.location.origin; //!====================================

_main__WEBPACK_IMPORTED_MODULE_0__["default"].redactorConfig.minHeight = "300px";
$R("#editor", _main__WEBPACK_IMPORTED_MODULE_0__["default"].redactorConfig);
sessionStorage.removeItem("recipients");
_main__WEBPACK_IMPORTED_MODULE_0__["default"].tableLocale.emptyTable = "Δεν ορίστικαν παραλήπτες";
_main__WEBPACK_IMPORTED_MODULE_0__["default"].tableLocale.zeroRecords = "Δεν βρέθηκαν παραλήπτες";
var usersDatatable = $("#users-datatable").DataTable({
  order: [1, "asc"],
  autoWidth: false,
  columnDefs: [{
    targets: 0,
    width: "50px"
  }, {
    targets: 2,
    width: "130px"
  }, {
    targets: 3,
    width: "100px"
  }],
  searchDelay: "1000",
  processing: true,
  serverSide: true,
  ajax: {
    url: "/email/select-users",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "post",
    data: function data(d) {
      return $.extend({}, d, {
        recipients: sessionStorage.getItem("recipients")
      });
    }
  },
  columns: [{
    data: 'action',
    name: 'action',
    className: "align-middle text-center",
    orderable: false
  }, {
    data: 'name',
    name: 'users.last_name',
    className: "align-middle"
  }, {
    data: 'role',
    name: 'roles.name',
    className: "align-middle text-center text-wrap"
  }, {
    data: 'btn',
    className: "align-middle text-center text-wrap",
    orderable: false,
    searchable: false
  }, {
    data: 'courses',
    name: 'courses.title',
    className: "align-middle text-center text-wrap",
    visible: false
  }, {
    data: 'first_name',
    name: "first_name",
    visible: false
  }, {
    data: 'last_name',
    name: "last_name",
    visible: false
  }],
  language: _main__WEBPACK_IMPORTED_MODULE_0__["default"].tableLocale,
  fnInitComplete: function fnInitComplete(oSettings, json) {
    var lenthSelection = $("select[name='users-datatable_length']");
    lenthSelection.select2({
      minimumResultsForSearch: -1
    });
  },
  drawCallback: function drawCallback() {
    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    $(".dataTables_wrapper > .row:first-child > div").removeClass("col-sm-12 col-md-6");
    $(".dataTables_wrapper > .row:first-child > div").addClass("col-lg-12 col-xl-6 d-md-flex justify-content-md-center d-xl-block");
    $(".js-add-recipient").on("click", addRecipientHandler);
    $(".js-user-checkbox").on("change", addUserCheckboxHandler);
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].resetAddButton($("#add-recipients-blk"), $("#select-all-users"));
  }
});
var recipientsDatatable = $("#recipients-datatable").DataTable({
  order: [1, "asc"],
  autoWidth: false,
  columnDefs: [{
    targets: [0, 3],
    width: "50px"
  }, {
    targets: 2,
    width: "200px"
  }],
  searchDelay: "1000",
  processing: true,
  serverSide: true,
  ajax: {
    url: "/email/recipients-data-table",
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    type: "post",
    data: function data(d) {
      return $.extend({}, d, {
        recipients: sessionStorage.getItem("recipients")
      });
    }
  },
  columns: [{
    data: 'action',
    name: 'action',
    className: "align-middle text-center",
    orderable: false
  }, {
    data: 'name',
    name: 'users.last_name',
    className: "align-middle"
  }, {
    data: 'role',
    name: 'roles.name',
    className: "align-middle text-center text-wrap"
  }, {
    data: 'btn',
    className: "align-middle text-center text-wrap",
    orderable: false,
    searchable: false
  }, {
    data: 'courses',
    name: 'courses.title',
    className: "align-middle text-center text-wrap",
    visible: false
  }, {
    data: 'first_name',
    name: "first_name",
    visible: false
  }, {
    data: 'last_name',
    name: "last_name",
    visible: false
  }],
  language: _main__WEBPACK_IMPORTED_MODULE_0__["default"].tableLocale,
  fnInitComplete: function fnInitComplete(oSettings, json) {
    var lenthSelection = $("select[name='recipients-datatable_length']");
    lenthSelection.select2({
      minimumResultsForSearch: -1
    });
  },
  drawCallback: function drawCallback() {
    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
    $(".js-remove-recipient").on("click", removeRecipientHandler);
    $(".js-recipient-checkbox").on("change", removeRecipientsCheckboxHandler);
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].resetBulk($("#remove-recipients-btn"), $("#select-all-recipients"), "Αφαίρεση (0)");
  }
});

function removeRecipientsCheckboxHandler() {
  var mainCheckbox = $("#select-all-recipients")[0];
  var minorCheckboxes = $(".js-recipient-checkbox");
  var bulkBtn = $("#remove-recipients-btn")[0];
  _main__WEBPACK_IMPORTED_MODULE_0__["default"].mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn);
}

function addUserCheckboxHandler() {
  var mainCheckbox = $("#select-all-users")[0];
  var minorCheckboxes = $(".js-user-checkbox");
  var bulkBtn = $("#add-recipients-blk")[0];
  _main__WEBPACK_IMPORTED_MODULE_0__["default"].mainCheckboxSwitcher(mainCheckbox, minorCheckboxes, bulkBtn);
}

function addRecipientHandler() {
  $(".js-add-recipient").prop("disabled", true);
  var id = this.dataset.userId;
  var recipients = sessionStorage.getItem("recipients");

  if (recipients === null) {
    recipients = "".concat(id);
  } else {
    recipients += ",".concat(id);
  }

  userTablesUpdate(recipients);
}

function removeRecipientHandler() {
  var id = this.dataset.userId;
  var recipients = sessionStorage.getItem("recipients").split(",");
  var index = recipients.indexOf(id);
  recipients.splice(index, 1);
  userTablesUpdate(recipients);
}

function userTablesUpdate(recipients) {
  sessionStorage.removeItem("recipients");
  sessionStorage.setItem("recipients", recipients);
  usersDatatable.ajax.reload(null, false);
  recipientsDatatable.ajax.reload(null, false);
}

function createSelect(id) {
  var select = document.createElement("select");
  select.classList.add("select2", "form-control", "select2-multiple");
  select.id = id;
  return select;
} //! Users table filters


(function coursesFilter() {
  var lengthCnt = document.getElementById("users-datatable_length");
  var select = createSelect("course-user-filter");
  lengthCnt.append(select);
  $(select).select2({
    placeholder: "Όλα τα Courses",
    width: "150px",
    ajax: {
      url: "/courses/json-search",
      delay: 1000,
      dataType: "json",
      data: function data(params) {
        return {
          search: params.term,
          page: params.page || 1
        };
      }
    }
  });
  $(select).on("change", function () {
    var label = $('#select2-course-user-filter-container')[0];
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].filterStyle(label, this.value.trim());
    usersDatatable.column(4).search(this.value).draw();
  });
})();

(function rolesFilter() {
  var lengthCnt = document.getElementById("users-datatable_length");
  var select = createSelect("user-role-filter");
  select.innerHTML = "\n\t\t<option value=\"\">\u038C\u03BB\u03BF\u03B9 \u03BF\u03B9 \u03A1\u03CC\u03BB\u03BF\u03B9</option>\n\t\t<option value=\"admin\">Admin</option>\n\t\t<option value=\"instructor\">\u0395\u03B9\u03C3\u03B7\u03B3\u03B7\u03C4\u03AD\u03C2</option>\n\t\t<option value=\"partner\">Partners</option>\n\t\t<option value=\"student\">\u039C\u03B1\u03B8\u03B7\u03C4\u03AD\u03C2</option>\n\t";
  lengthCnt.append(select);
  $(select).select2({
    width: "150px"
  });
  $(select).on("change", function () {
    var label = $('#select2-user-role-filter-container')[0];
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].filterStyle(label, this.value);
    usersDatatable.column(2).search(this.value).draw();
  });
})(); //! Recipients table filters


(function coursesRecipientFilter() {
  var lengthCnt = document.getElementById("recipients-datatable_length");
  var select = createSelect("course-recipients-filter");
  lengthCnt.append(select);
  $(select).select2({
    placeholder: "Όλα τα Courses",
    width: "150px",
    ajax: {
      url: "/courses/json-search",
      delay: 1000,
      dataType: "json",
      data: function data(params) {
        return {
          search: params.term,
          page: params.page || 1
        };
      }
    }
  });
  $(select).on("change", function () {
    var label = $('#select2-course-recipients-filter-container')[0];
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].filterStyle(label, this.value.trim());
    recipientsDatatable.column(4).search(this.value).draw();
  });
})();

(function rolesFilter() {
  var lengthCnt = document.getElementById("recipients-datatable_length");
  var select = createSelect("recipient-role-filter");
  select.innerHTML = "\n\t\t<option value=\"\">\u038C\u03BB\u03BF\u03B9 \u03BF\u03B9 \u03A1\u03CC\u03BB\u03BF\u03B9</option>\n\t\t<option value=\"admin\">Admin</option>\n\t\t<option value=\"instructor\">\u0395\u03B9\u03C3\u03B7\u03B3\u03B7\u03C4\u03AD\u03C2</option>\n\t\t<option value=\"partner\">Partners</option>\n\t\t<option value=\"student\">\u039C\u03B1\u03B8\u03B7\u03C4\u03AD\u03C2</option>\n\t";
  lengthCnt.append(select);
  $(select).select2({
    width: "150px"
  });
  $(select).on("change", function () {
    var label = $('#select2-recipient-role-filter-container')[0];
    _main__WEBPACK_IMPORTED_MODULE_0__["default"].filterStyle(label, this.value);
    recipientsDatatable.column(2).search(this.value).draw();
  });
})();

$("#select-all-users").on("change", function () {
  var checkboxes = $('.js-user-checkbox');
  var bulkBtn = $("#add-recipients-blk")[0];
  _main__WEBPACK_IMPORTED_MODULE_0__["default"].minorCheckboxSwitcher(this, checkboxes, bulkBtn);
});
$("#select-all-recipients").on("change", function () {
  var checkboxes = $('.js-recipient-checkbox');
  var bulkBtn = $("#remove-recipients-btn")[0];
  _main__WEBPACK_IMPORTED_MODULE_0__["default"].minorCheckboxSwitcher(this, checkboxes, bulkBtn);
});
$("#remove-recipients-btn").on("click", function () {
  var recipients = sessionStorage.getItem("recipients").split(",");
  var unwanted = $(".js-recipient-checkbox:checked");
  var index;

  for (var i = 0; i < unwanted.length; i++) {
    index = recipients.indexOf(unwanted[i].dataset.userId);
    recipients.splice(index, 1);
  }

  userTablesUpdate(recipients.toString());
});
$("#add-recipients-blk").on("click", function () {
  var recipients = sessionStorage.getItem("recipients") === null ? [] : sessionStorage.getItem("recipients").split(",");
  var users = $(".js-user-checkbox:checked");

  for (var i = 0; i < users.length; i++) {
    recipients.push(users[i].dataset.userId);
  }

  userTablesUpdate(recipients.toString());
  $("#users-table-modal").modal("hide");
});

function dzCancelHandler() {
  var fileName = this.findParent(3).querySelector(".dz-filename > span").textContent;
  var files = attachmentDropzone.getAcceptedFiles();

  for (var i = 0; i < files.length; i++) {
    if (files[i].name === fileName) {
      attachmentDropzone.removeFile(files[i]);
    }
  }
}

_main__WEBPACK_IMPORTED_MODULE_0__["default"].ALLOWEDTYPES.push("image/jpeg");
_main__WEBPACK_IMPORTED_MODULE_0__["default"].ALLOWEDTYPES.push("image/png");
var filePreviewTemplate = document.getElementById("file-preview-template").innerHTML;
var bannerDropzoneCnt = document.getElementById("my-awesome-dropzone");
var attachmentDropzone = new _theme_js_vendor_dropzone_min_js__WEBPACK_IMPORTED_MODULE_1___default.a(bannerDropzoneCnt, {
  url: "/dashboard/email",
  headers: {
    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
  },
  autoProcessQueue: false,
  parallelUploads: 10,
  uploadMultiple: true,
  previewTemplate: filePreviewTemplate,
  previewsContainer: "#previews",
  acceptedFiles: _main__WEBPACK_IMPORTED_MODULE_0__["default"].ALLOWEDTYPES.join(),
  dictInvalidFileType: "Μη υποστηριζόμενος τύπος αρχείου."
});
attachmentDropzone.on("addedfile", function (file) {
  file.cancelBtn = file.previewTemplate.getElementsByClassName("js-cancel-btn")[0];
  file.cancelBtn.addEventListener("click", dzCancelHandler);
});
attachmentDropzone.on("complete", function (file) {
  var accepted = file.accepted;

  if (!accepted) {
    this.removeFile(file); //! invalid type

    _main__WEBPACK_IMPORTED_MODULE_0__["default"].toastAlert("info", "Ο τύπος αρχείου δεν υποστηρίζεται...");
    return;
  }
});
attachmentDropzone.on("sendingmultiple", function (file, xhr, formData) {
  var subject = $("#subject").val();
  var content = $R('#editor', 'source.getCode');
  var recipients = sessionStorage.getItem("recipients") == null ? "" : sessionStorage.getItem("recipients");
  formData.append("subject", subject);
  formData.append("content", content);
  formData.append("recipients", recipients);
});
attachmentDropzone.on("successmultiple", function (file, res) {
  if (res === "Successful") {
    window.location.href = "".concat(baseUrl, "/dashboard/email");
  }
});
attachmentDropzone.on("errormultiple", function (files, res) {
  for (var i = 0; i < files.length; i++) {
    files[i].status = "queued";
  }

  $("#subject-error").addClass("d-none");
  $("#content-error").addClass("d-none");

  for (var error in res.errors) {
    if (error !== "recipients") {
      $("#".concat(error, "-error")).removeClass("d-none");
    } else {
      _main__WEBPACK_IMPORTED_MODULE_0__["default"].toastAlert("info", "Δεν ορίστηκαν παραλήπτες...");
    }
  }
});
$(".js-submit-btn").on("click", function () {
  var files = attachmentDropzone.getAcceptedFiles();

  if (files.length > 0) {
    attachmentDropzone.processQueue();
    return;
  }

  var form = document.getElementById("email-form");
  var recipients = sessionStorage.getItem("recipients");
  $("#recipients-input").val(recipients);
  form.submit();
});

/***/ }),

/***/ "./resources/js/dashboard/main.js":
/*!****************************************!*\
  !*** ./resources/js/dashboard/main.js ***!
  \****************************************/
/*! exports provided: ALLOWEDTYPES, default */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "ALLOWEDTYPES", function() { return ALLOWEDTYPES; });
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
/* harmony import */ var sweetalert2__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(sweetalert2__WEBPACK_IMPORTED_MODULE_0__);

Element.prototype.findParent = function (loops) {
  var parent = this;

  for (var i = 0; i < loops; i++) {
    parent = parent.parentElement;
  }

  return parent;
}, false;
Element.prototype.appendBefore = function (element) {
  element.parentNode.insertBefore(this, element);
}, false;
Element.prototype.appendAfter = function (element) {
  element.parentNode.insertBefore(this, element.nextSibling);
}, false; //!##########################################
//!				Global Variables		F	#
//!##########################################

var baseUrl = window.location.origin;
var timer = 0;
var ALLOWEDTYPES = ["application/octet-stream", "application/x-zip-compressed", "application/pdf", "application/msword", "application/vnd.openxmlformats-officedocument.wordprocessingml.document", "application/vnd.openxmlformats-officedocument.wordprocessingml.template", "application/vnd.ms-word.document.macroEnabled.12", "application/vnd.ms-word.template.macroEnabled.12", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.ms-excel", "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", "application/vnd.openxmlformats-officedocument.spreadsheetml.template", "application/vnd.ms-excel.sheet.macroEnabled.12", "application/vnd.ms-excel.template.macroEnabled.12", "application/vnd.ms-excel.addin.macroEnabled.12", "application/vnd.ms-excel.sheet.binary.macroEnabled.12", "application/vnd.ms-powerpoint", "application/vnd.openxmlformats-officedocument.presentationml.presentation", "application/vnd.openxmlformats-officedocument.presentationml.template", "application/vnd.openxmlformats-officedocument.presentationml.slideshow", "application/vnd.ms-powerpoint.addin.macroEnabled.12", "application/vnd.ms-powerpoint.presentation.macroEnabled.12", "application/vnd.ms-powerpoint.template.macroEnabled.12", "application/vnd.ms-powerpoint.slideshow.macroEnabled.12", "application/vnd.ms-access", "audio/mpeg", "application/vnd.oasis.opendocument.presentation", "application/vnd.oasis.opendocument.spreadsheet", "application/vnd.oasis.opendocument.text", "application/rtf", "application/vnd.oasis.opendocument.graphics", "text/html"]; //!##########################################
//!				Configurations				#
//!##########################################
//!ALERT
//!============================================================

function toastAlert(icon, message) {
  sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    toast: 'true',
    position: 'top-end',
    icon: icon,
    title: message,
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true
  });
}

function toastAlertDelete(text) {
  var icon = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "warning";
  return sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    title: 'Είστε σίγουρος/η;',
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonColor: '#ff5b5b',
    confirmButtonText: 'Ναί, διαγραφή!',
    cancelButtonText: 'Άκυρο'
  });
}

function removeAlert(text) {
  var icon = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : "warning";
  return sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    title: 'Είστε σίγουρος/η;',
    text: text,
    icon: icon,
    showCancelButton: true,
    confirmButtonColor: '#536de6',
    confirmButtonText: 'Ναί, αφαίρεση!',
    cancelButtonText: 'Άκυρο'
  });
} //!CONFIG
//!============================================================


var articleConfig = {
  css: "/css/",
  custom: {
    css: ["/css/bootstrap.min.css", "/css/customArticleStyle.css"]
  },
  // plugins: ['mediaLibrary', 'reorder'],
  classes: {
    img: 'img-fluid',
    p: 'text-wrap'
  },
  grid: {
    classname: 'row',
    columns: 12,
    gutter: '1px',
    offset: {
      left: '15px',
      right: '15px'
    },
    patterns: {
      '6|6': 'col-6|col-6',
      '4|4|4': 'col-4|col-4|col-4',
      '3|3|3|3': 'col-3|col-3|col-3|col-3',
      '2|2|2|2|2|2': 'col-2|col-2|col-2|col-2|col-2|col-2',
      '3|6|3': 'col-3|col-6|col-3',
      '2|8|2': 'col-2|col-8|col-2',
      '5|7': 'col-5|col-7',
      '7|5': 'col-7|col-5',
      '4|8': 'col-4|col-8',
      '8|4': 'col-8|col-4',
      '3|9': 'col-3|col-9',
      '9|3': 'col-9|col-3',
      '2|10': 'col-2|col-10',
      '10|2': 'col-10|col-2',
      '12': 'col-12'
    }
  },
  align: {
    left: "text-left",
    center: "text-center",
    right: "text-right"
  },
  editor: {
    minHeight: "300px"
  },
  image: {
    upload: "/media/upload-images",
    data: {
      "_token": $('meta[name="csrf-token"]').attr('content')
    }
  }
};
var redactorConfig = {
  buttons: ['html', 'undo', 'redo', 'format', 'bold', 'underline', 'italic', 'deleted', 'sup', 'sub', 'lists', 'file', 'link', 'image'],
  style: false,
  plugins: ['alignment'],
  minHeight: '150px'
};
var datePickerConfig = {
  ranges: {
    'Today': [moment(), moment()],
    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
    'This Month': [moment().startOf('month'), moment().endOf('month')],
    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
    'This Year': [moment().startOf('year'), moment().endOf('year')],
    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1, 'year').endOf('year')]
  },
  alwaysShowCalendars: true,
  showCustomRangeLabel: false,
  drops: "auto",
  autoUpdateInput: false,
  opens: "center",
  locale: {
    format: "DD/MM/YYYY"
  }
};
var tableLocale = {
  emptyTable: "Δεν υπάρχουν εγγραφές",
  info: "_START_ έως _END_ απο τα _TOTAL_ αποτελέσματα",
  infoEmpty: "0 απο 0 τα 0 αποτελέσματα",
  lengthMenu: "_MENU_",
  loadingRecords: "Φόρτωση ...",
  processing: "Επεξεργασία ...",
  search: "",
  searchPlaceholder: "Αναζήτηση... ",
  zeroRecords: "Δεν βρέθηκαν αποτελέσματα",
  paginate: {
    previous: "<i class='mdi mdi-chevron-left'>",
    next: "<i class='mdi mdi-chevron-right'>"
  },
  infoFiltered: "(Φιλτραρισμένα απο τις _MAX_ εγγραφές)"
}; //!GLOBAL FUNCTION
//!============================================================

function mainCheckboxSwitcher(main, minor) {
  var bulkBtn = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
  var status = true;
  var counter = 0;
  main.checked = true;

  for (var i = 0; i < minor.length; i++) {
    if (!minor[i].checked) {
      minor[i].findParent(3).classList.remove("bg-selected");
      main.checked = false;
    } else {
      minor[i].findParent(3).classList.add("bg-selected");
      counter++;
      status = false;
    }
  }

  if (bulkBtn) {
    bulkModifier(bulkBtn, status, counter);
  }
}

function minorCheckboxSwitcher(main, minor) {
  var bulkBtn = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : false;
  var counter = 0;
  var status = true;

  if (main.checked && minor.length > 0) {
    counter = minor.length;
    status = false;

    for (var i = 0; i < minor.length; i++) {
      minor[i].checked = true;
      minor[i].findParent(3).classList.add("bg-selected");
    }
  } else {
    for (var i = 0; i < minor.length; i++) {
      minor[i].checked = false;
      minor[i].findParent(3).classList.remove("bg-selected");
    }
  }

  if (bulkBtn) {
    bulkModifier(bulkBtn, status, counter);
  }
}

function bulkModifier(bulkBtn, status, sum) {
  var text = bulkBtn.dataset.text ? bulkBtn.dataset.text : "Επιλογές";
  var enabledColor = bulkBtn.dataset.enabledColor ? bulkBtn.dataset.enabledColor : "btn-warning";
  var disabledColor = bulkBtn.dataset.disabledColor ? bulkBtn.dataset.disabledColor : "btn-secondary";

  if (status) {
    bulkBtn.classList.remove(enabledColor);
    bulkBtn.classList.add(disabledColor);
    bulkBtn.textContent = "".concat(text, " (0)  ");
    bulkBtn.disabled = true;
  } else {
    bulkBtn.classList.remove(disabledColor);
    bulkBtn.classList.add(enabledColor);
    bulkBtn.textContent = "".concat(text, "  (").concat(sum, ")  ");
    bulkBtn.disabled = false;
  }
}

function filterStyle(input, value) {
  if (value == "") {
    input.classList.remove("select2-selected");
  } else {
    input.classList.add("select2-selected");
  }
}

var filterButton = function filterButton(attr, column, table, tableId) {
  $(attr).detach().appendTo(tableId);
  $(attr).on('change', function () {
    table.columns(column).search(this.value).draw();
  });
};

var changeInputHidden = function changeInputHidden(attr, hiddenAttr) {
  $(attr).change(function () {
    if (attr == "#activeMaterial") {
      this.value = $(this).prop('checked') == true ? 1 : 0;
    }

    var hiddenValue = $(hiddenAttr)[0].value = this.value;
  });
};

function createStateSelect() {
  var id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var selectElm = document.createElement("select");
  selectElm.classList.add("ml-1", "select2");
  selectElm.id = id;
  selectElm.innerHTML = "\n\t\t<option value=\"\">\u038C\u03BB\u03B5\u03C2 \u03BF\u03B9 \u039A\u03B1\u03C4\u03B1\u03C3\u03C4\u03AC\u03C3\u03B5\u03B9\u03C2</option>\n\t\t<option value=\"1\">\u0395\u03BD\u03B5\u03C1\u03B3\u03AC</option>\n\t\t<option value=\"0\">\u0391\u03BD\u03B5\u03BD\u03B5\u03C1\u03B3\u03AC</option>\n\t";
  return selectElm;
}

function createDateElm(id) {
  var input = document.createElement("input");
  input.classList.add("form-control", "date", "d-inline-block", "ml-1", "js-date-search");
  input.id = id;
  input.dataset.toggle = "date-picker";
  input.dataset.cancelClass = "btn-secondary";
  input.style.height = "31.96px";
  input.style.width = "195px";
  input.placeholder = "Επιλέξτε ημερομηνίες...";
  return input;
}

function createCourseTypeSelect() {
  var id = arguments.length > 0 && arguments[0] !== undefined ? arguments[0] : "";
  var selectElm = document.createElement("select");
  selectElm.classList.add("ml-1", "select2");
  selectElm.id = id;
  selectElm.innerHTML = "\n\t\t<option value=\"\">\u038C\u03BB\u03B5\u03C2 \u03BF\u03B9 \u0395\u03BA\u03B4\u03CC\u03C3\u03B5\u03B9\u03C2</option>\n\t\t<option value=\"Normal\">Normal</option>\n\t\t<option value=\"Trial\">Trial</option>\n\t";
  return selectElm;
}

function startDate(input) {
  var dateInput = input;

  if (!dateInput || dateInput.value == "") {
    return "";
  }

  var dateInputValue = dateInput.value.split(" - ");
  var firstDate = dateInputValue[0].split("/").reverse().join("-");
  return firstDate;
}

function endDate(input) {
  var dateInput = input;

  if (!dateInput || dateInput.value == "") {
    return "";
  }

  var dateInputValue = dateInput.value.split(" - ");
  var secondDate = dateInputValue[1].split("/").reverse().join("-");
  return secondDate;
}

function resetBulk(bulkBtn, checkbox) {
  var text = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : "Επιλογές  (0)";
  bulkBtn.text(text);
  bulkBtn.addClass("btn-secondary");
  bulkBtn.removeClass("btn-warning btn-danger");
  bulkBtn.prop("disabled", true);
  checkbox.prop("checked", false);
}

function resetAddButton(addBtn, checkbox) {
  addBtn.text("Προσθήκη Επιλογών (0)");
  addBtn.addClass("btn-secondary");
  addBtn.removeClass("btn-primary");
  addBtn.prop("disabled", true);
  checkbox.prop("checked", false);
}

function passwordValidation() {
  return sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    title: "Παρακαλώ εισάγεται Κωδικό",
    input: "password",
    showCancelButton: true,
    confirmButtonColor: "#536de6",
    showLoaderOnConfirm: true,
    preConfirm: function preConfirm(password) {
      return axios.post("/users-ajax/confirm-password", {
        password: password
      }).then(function (res) {
        return res.status;
      })["catch"](function (err) {
        sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.showValidationMessage(err.response.data);
      });
    }
  });
} //!##############################################
//!				Media Library Functions			#
//!##############################################


function paginationHandler(event) {
  event.preventDefault();
  var activePage = this.href.split("page=")[1];
  var search = $("#image-search").val();
  paginationRequest(activePage, search);
}

function searchHandler() {
  clearTimeout(timer);

  if (this.value.length < 3 || this.value == "") {
    timer = setTimeout(paginationRequest, 800, 1, "");
  } else {
    timer = setTimeout(paginationRequest, 800, 1, this.value);
  }
}

function imageHandler() {
  var modal = $("#gallery-content")[0];
  var model = modal.dataset.model;
  var modelId = modal.dataset.id;
  var editorId = modal.dataset.editorId;
  var type = modal.dataset.type;
  var image = {
    'img': {
      url: "".concat(this.dataset.imageSource)
    }
  };

  if (type == "article") {
    ArticleEditor(editorId).image.insert(image);
  } else if (type == "redactor") {
    $R(editorId, 'insertion.insertHtml', "<img class=\"img-fluid\" src=\"".concat(this.dataset.imageSource, "\" alt=\"").concat(this.dataset.name, "\" />"));
  } else if (type == "gallery") {
    $("#remove-all-images-btn").removeClass("d-none");
    addToGallery(model, modelId, this.dataset.imageId);
    return;
  } else {
    changeCoverRequest(model, modelId, this.dataset.imageSource);
  }

  $("#gallery-modal").modal('hide');
}

function paginationRequest(activePage, search) {
  axios.get("/media/images", {
    params: {
      page: activePage,
      search: search
    }
  }).then(function (res) {
    var gallery = $("#gallery-content")[0];
    gallery.innerHTML = res.data;
    var pagination = gallery.getElementsByClassName("js-gallery-page-btn");
    var addBtns = gallery.getElementsByClassName("js-add-image");

    for (var i = 0; i < addBtns.length; i++) {
      addBtns[i].removeEventListener("click", imageHandler);
      addBtns[i].addEventListener("click", imageHandler);
    }

    for (var _i = 0; _i < pagination.length; _i++) {
      pagination[_i].removeEventListener("click", paginationHandler);

      pagination[_i].addEventListener("click", paginationHandler);
    }
  });
}

function changeCoverRequest(namespace, id, url) {
  if (typeof id === "undefined" && namespace == "App\\Models\\User") {
    var img = $("#cover-image")[0];
    var removeBtnCnt = $("#remove-cover-btn").parent();
    img.src = "".concat(url);
    img.classList.remove("d-none");
    removeBtnCnt.removeClass("d-none");
    removeBtnCnt.addClass("d-flex");
    $("#custom-file")[0].value = "".concat(url);
  } else {
    axios.patch("/media/cover/replace", {
      namespace: namespace,
      id: id,
      url: url
    }).then(function (res) {
      var img = $("#cover-image")[0];
      var removeBtnCnt = $("#remove-cover-btn").parent();
      img.src = res.data.imgUrl;
      img.classList.remove("d-none");
      $("#change-cover-btn").text("Αλλαγή");
      $("#cover-status").addClass("d-none");
      removeBtnCnt.removeClass("d-none");
      removeBtnCnt.addClass("d-flex");
      toastAlert("success", "Το Cover άλλαξε!");
    })["catch"](function (err) {
      console.log(err);
      toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα ...");
    });
  }
}

function addToGallery(namespace, id, imageId) {
  axios.post("/media/gallery", {
    namespace: namespace,
    modelId: id,
    ids: [imageId]
  }).then(function (res) {
    var gallery = $("#gallery-cnt");
    gallery.html(res.data);
    var closeBtns = gallery.find(".js-remove-image");
    closeBtns.on("click", removeImageHandler);
    toastAlert("success", "Η εικόνα προστέθηκε.");
    gallery.modal("hide");
    var bulk = $("#gallery-bulk-action-btn");
    var checkboxes = $(".js-gallery-checkbox");
    resetGalleryBtns(bulk, checkboxes);
  })["catch"](function (err) {
    console.log(err);
    toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα ...");
  });
}

function removeImageHandler() {
  var _this = this;

  sweetalert2__WEBPACK_IMPORTED_MODULE_0___default.a.fire({
    icon: 'info',
    title: 'Προσοχή!',
    text: 'Η εικόνα θα αφαιρεθεί απο το Gallery.',
    showCancelButton: true,
    confirmButtonColor: '#536de6',
    confirmButtonText: "\u039D\u03B1\u03B9, \u03B1\u03C6\u03B1\u03AF\u03C1\u03B5\u03C3\u03B7!",
    cancelButtonText: "Άκυρο"
  }).then(function (result) {
    if (result.isConfirmed) {
      removeImages([_this.dataset.imageId]);
    }
  });
}

function removeImages(ids) {
  var gallery = $("#gallery-cnt")[0];
  var namespace = gallery.dataset.namespace;
  var modelId = gallery.dataset.modelId;
  axios.post("/media/gallery-remove", {
    namespace: namespace,
    modelId: modelId,
    ids: ids
  }).then(function (res) {
    var gallery = $("#gallery-cnt");
    gallery.html(res.data);
    var closeBtns = gallery.find(".js-remove-image");
    closeBtns.on("click", removeImageHandler);

    if (closeBtns.length == 0) {
      $("#remove-all-images-btn").addClass("d-none");
    }
  })["catch"](function (err) {
    console.log(err);
    utilities.toastAlert('error', "Παρουσιάστηκε κάποιο πρόβλημα ...");
  });
}

function resetGalleryBtns(bulk, checkboxes) {
  bulk.text("Επιλογές (0)");
  bulk.prop("disabled", true);
  bulk.removeClass("btn-warning");
  bulk.addClass("btn-secondary");

  for (var i = 0; i < checkboxes.length; i++) {
    checkboxes[i].checked = false;
  }
} //!######################################################
//!				Media Library Functions End				#
//!######################################################


/* harmony default export */ __webpack_exports__["default"] = ({
  toastAlert: toastAlert,
  mainCheckboxSwitcher: mainCheckboxSwitcher,
  minorCheckboxSwitcher: minorCheckboxSwitcher,
  filterButton: filterButton,
  tableLocale: tableLocale,
  changeInputHidden: changeInputHidden,
  redactorConfig: redactorConfig,
  createStateSelect: createStateSelect,
  datePickerConfig: datePickerConfig,
  toastAlertDelete: toastAlertDelete,
  filterStyle: filterStyle,
  createDateElm: createDateElm,
  startDate: startDate,
  endDate: endDate,
  resetBulk: resetBulk,
  resetAddButton: resetAddButton,
  createCourseTypeSelect: createCourseTypeSelect,
  paginationHandler: paginationHandler,
  searchHandler: searchHandler,
  imageHandler: imageHandler,
  paginationRequest: paginationRequest,
  resetGalleryBtns: resetGalleryBtns,
  removeImageHandler: removeImageHandler,
  removeImages: removeImages,
  articleConfig: articleConfig,
  ALLOWEDTYPES: ALLOWEDTYPES,
  passwordValidation: passwordValidation,
  removeAlert: removeAlert
});

/***/ }),

/***/ "./resources/theme/js/vendor/dropzone.min.js":
/*!***************************************************!*\
  !*** ./resources/theme/js/vendor/dropzone.min.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(module) {

function _typeof2(obj) { "@babel/helpers - typeof"; if (typeof Symbol === "function" && typeof Symbol.iterator === "symbol") { _typeof2 = function _typeof2(obj) { return typeof obj; }; } else { _typeof2 = function _typeof2(obj) { return obj && typeof Symbol === "function" && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }; } return _typeof2(obj); }

function _typeof(e) {
  return (_typeof = "function" == typeof Symbol && "symbol" == _typeof2(Symbol.iterator) ? function (e) {
    return _typeof2(e);
  } : function (e) {
    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : _typeof2(e);
  })(e);
}

function _inherits(e, t) {
  if ("function" != typeof t && null !== t) throw new TypeError("Super expression must either be null or a function");
  e.prototype = Object.create(t && t.prototype, {
    constructor: {
      value: e,
      writable: !0,
      configurable: !0
    }
  }), t && _setPrototypeOf(e, t);
}

function _setPrototypeOf(e, t) {
  return (_setPrototypeOf = Object.setPrototypeOf || function (e, t) {
    return e.__proto__ = t, e;
  })(e, t);
}

function _createSuper(i) {
  var r = _isNativeReflectConstruct();

  return function () {
    var e,
        t = _getPrototypeOf(i);

    if (r) {
      var n = _getPrototypeOf(this).constructor;

      e = Reflect.construct(t, arguments, n);
    } else e = t.apply(this, arguments);

    return _possibleConstructorReturn(this, e);
  };
}

function _possibleConstructorReturn(e, t) {
  return !t || "object" !== _typeof(t) && "function" != typeof t ? _assertThisInitialized(e) : t;
}

function _assertThisInitialized(e) {
  if (void 0 === e) throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
  return e;
}

function _isNativeReflectConstruct() {
  if ("undefined" == typeof Reflect || !Reflect.construct) return !1;
  if (Reflect.construct.sham) return !1;
  if ("function" == typeof Proxy) return !0;

  try {
    return Date.prototype.toString.call(Reflect.construct(Date, [], function () {})), !0;
  } catch (e) {
    return !1;
  }
}

function _getPrototypeOf(e) {
  return (_getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf : function (e) {
    return e.__proto__ || Object.getPrototypeOf(e);
  })(e);
}

function _createForOfIteratorHelper(e, t) {
  var _n;

  if ("undefined" == typeof Symbol || null == e[Symbol.iterator]) {
    if (Array.isArray(e) || (_n = _unsupportedIterableToArray(e)) || t && e && "number" == typeof e.length) {
      _n && (e = _n);

      var i = 0,
          r = function r() {};

      return {
        s: r,
        n: function n() {
          return i >= e.length ? {
            done: !0
          } : {
            done: !1,
            value: e[i++]
          };
        },
        e: function e(_e) {
          throw _e;
        },
        f: r
      };
    }

    throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.");
  }

  var o,
      a = !0,
      l = !1;
  return {
    s: function s() {
      _n = e[Symbol.iterator]();
    },
    n: function n() {
      var e = _n.next();

      return a = e.done, e;
    },
    e: function e(_e2) {
      l = !0, o = _e2;
    },
    f: function f() {
      try {
        a || null == _n["return"] || _n["return"]();
      } finally {
        if (l) throw o;
      }
    }
  };
}

function _unsupportedIterableToArray(e, t) {
  if (e) {
    if ("string" == typeof e) return _arrayLikeToArray(e, t);
    var n = Object.prototype.toString.call(e).slice(8, -1);
    return "Object" === n && e.constructor && (n = e.constructor.name), "Map" === n || "Set" === n ? Array.from(e) : "Arguments" === n || /^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(n) ? _arrayLikeToArray(e, t) : void 0;
  }
}

function _arrayLikeToArray(e, t) {
  (null == t || t > e.length) && (t = e.length);

  for (var n = 0, i = new Array(t); n < t; n++) {
    i[n] = e[n];
  }

  return i;
}

function _classCallCheck(e, t) {
  if (!(e instanceof t)) throw new TypeError("Cannot call a class as a function");
}

function _defineProperties(e, t) {
  for (var n = 0; n < t.length; n++) {
    var i = t[n];
    i.enumerable = i.enumerable || !1, i.configurable = !0, "value" in i && (i.writable = !0), Object.defineProperty(e, i.key, i);
  }
}

function _createClass(e, t, n) {
  return t && _defineProperties(e.prototype, t), n && _defineProperties(e, n), e;
}

var Emitter = function () {
  function e() {
    _classCallCheck(this, e);
  }

  return _createClass(e, [{
    key: "on",
    value: function value(e, t) {
      return this._callbacks = this._callbacks || {}, this._callbacks[e] || (this._callbacks[e] = []), this._callbacks[e].push(t), this;
    }
  }, {
    key: "emit",
    value: function value(e) {
      this._callbacks = this._callbacks || {};
      var t = this._callbacks[e];

      if (t) {
        for (var n = arguments.length, i = new Array(1 < n ? n - 1 : 0), r = 1; r < n; r++) {
          i[r - 1] = arguments[r];
        }

        var o,
            a = _createForOfIteratorHelper(t);

        try {
          for (a.s(); !(o = a.n()).done;) {
            o.value.apply(this, i);
          }
        } catch (e) {
          a.e(e);
        } finally {
          a.f();
        }
      }

      return this;
    }
  }, {
    key: "off",
    value: function value(e, t) {
      if (!this._callbacks || 0 === arguments.length) return this._callbacks = {}, this;
      var n = this._callbacks[e];
      if (!n) return this;
      if (1 === arguments.length) return delete this._callbacks[e], this;

      for (var i = 0; i < n.length; i++) {
        if (n[i] === t) {
          n.splice(i, 1);
          break;
        }
      }

      return this;
    }
  }]), e;
}(),
    Dropzone = function () {
  _inherits(b, Emitter);

  var a = _createSuper(b);

  function b(e, t) {
    var n, i, r;
    if (_classCallCheck(this, b), (n = a.call(this)).element = e, n.version = b.version, n.defaultOptions.previewTemplate = n.defaultOptions.previewTemplate.replace(/\n*/g, ""), n.clickableElements = [], n.listeners = [], n.files = [], "string" == typeof n.element && (n.element = document.querySelector(n.element)), !n.element || null == n.element.nodeType) throw new Error("Invalid dropzone element.");
    if (n.element.dropzone) throw new Error("Dropzone already attached.");
    b.instances.push(_assertThisInitialized(n)), n.element.dropzone = _assertThisInitialized(n);
    var o = null != (r = b.optionsForElement(n.element)) ? r : {};
    if (n.options = b.extend({}, n.defaultOptions, o, null != t ? t : {}), n.options.forceFallback || !b.isBrowserSupported()) return _possibleConstructorReturn(n, n.options.fallback.call(_assertThisInitialized(n)));
    if (null == n.options.url && (n.options.url = n.element.getAttribute("action")), !n.options.url) throw new Error("No URL provided.");
    if (n.options.acceptedFiles && n.options.acceptedMimeTypes) throw new Error("You can't provide both 'acceptedFiles' and 'acceptedMimeTypes'. 'acceptedMimeTypes' is deprecated.");
    if (n.options.uploadMultiple && n.options.chunking) throw new Error("You cannot set both: uploadMultiple and chunking.");
    return n.options.acceptedMimeTypes && (n.options.acceptedFiles = n.options.acceptedMimeTypes, delete n.options.acceptedMimeTypes), null != n.options.renameFilename && (n.options.renameFile = function (e) {
      return n.options.renameFilename.call(_assertThisInitialized(n), e.name, e);
    }), "string" == typeof n.options.method && (n.options.method = n.options.method.toUpperCase()), (i = n.getExistingFallback()) && i.parentNode && i.parentNode.removeChild(i), !1 !== n.options.previewsContainer && (n.options.previewsContainer ? n.previewsContainer = b.getElement(n.options.previewsContainer, "previewsContainer") : n.previewsContainer = n.element), n.options.clickable && (!0 === n.options.clickable ? n.clickableElements = [n.element] : n.clickableElements = b.getElements(n.options.clickable, "clickable")), n.init(), n;
  }

  return _createClass(b, null, [{
    key: "initClass",
    value: function value() {
      this.prototype.Emitter = Emitter, this.prototype.events = ["drop", "dragstart", "dragend", "dragenter", "dragover", "dragleave", "addedfile", "addedfiles", "removedfile", "thumbnail", "error", "errormultiple", "processing", "processingmultiple", "uploadprogress", "totaluploadprogress", "sending", "sendingmultiple", "success", "successmultiple", "canceled", "canceledmultiple", "complete", "completemultiple", "reset", "maxfilesexceeded", "maxfilesreached", "queuecomplete"], this.prototype.defaultOptions = {
        url: null,
        method: "post",
        withCredentials: !1,
        timeout: 3e4,
        parallelUploads: 2,
        uploadMultiple: !1,
        chunking: !1,
        forceChunking: !1,
        chunkSize: 2e6,
        parallelChunkUploads: !1,
        retryChunks: !1,
        retryChunksLimit: 3,
        maxFilesize: 256,
        paramName: "file",
        createImageThumbnails: !0,
        maxThumbnailFilesize: 10,
        thumbnailWidth: 120,
        thumbnailHeight: 120,
        thumbnailMethod: "crop",
        resizeWidth: null,
        resizeHeight: null,
        resizeMimeType: null,
        resizeQuality: .8,
        resizeMethod: "contain",
        filesizeBase: 1e3,
        maxFiles: null,
        headers: null,
        clickable: !0,
        ignoreHiddenFiles: !0,
        acceptedFiles: null,
        acceptedMimeTypes: null,
        autoProcessQueue: !0,
        autoQueue: !0,
        addRemoveLinks: !1,
        previewsContainer: null,
        hiddenInputContainer: "body",
        capture: null,
        renameFilename: null,
        renameFile: null,
        forceFallback: !1,
        dictDefaultMessage: "Drop files here to upload",
        dictFallbackMessage: "Your browser does not support drag'n'drop file uploads.",
        dictFallbackText: "Please use the fallback form below to upload your files like in the olden days.",
        dictFileTooBig: "File is too big ({{filesize}}MiB). Max filesize: {{maxFilesize}}MiB.",
        dictInvalidFileType: "You can't upload files of this type.",
        dictResponseError: "Server responded with {{statusCode}} code.",
        dictCancelUpload: "Cancel upload",
        dictUploadCanceled: "Upload canceled.",
        dictCancelUploadConfirmation: "Are you sure you want to cancel this upload?",
        dictRemoveFile: "Remove file",
        dictRemoveFileConfirmation: null,
        dictMaxFilesExceeded: "You can not upload any more files.",
        dictFileSizeUnits: {
          tb: "TB",
          gb: "GB",
          mb: "MB",
          kb: "KB",
          b: "b"
        },
        init: function init() {},
        params: function params(e, t, n) {
          if (n) return {
            dzuuid: n.file.upload.uuid,
            dzchunkindex: n.index,
            dztotalfilesize: n.file.size,
            dzchunksize: this.options.chunkSize,
            dztotalchunkcount: n.file.upload.totalChunkCount,
            dzchunkbyteoffset: n.index * this.options.chunkSize
          };
        },
        accept: function accept(e, t) {
          return t();
        },
        chunksUploaded: function chunksUploaded(e, t) {
          t();
        },
        fallback: function fallback() {
          var e;
          this.element.className = "".concat(this.element.className, " dz-browser-not-supported");

          var t,
              n = _createForOfIteratorHelper(this.element.getElementsByTagName("div"));

          try {
            for (n.s(); !(t = n.n()).done;) {
              var i = t.value;

              if (/(^| )dz-message($| )/.test(i.className)) {
                (e = i).className = "dz-message";
                break;
              }
            }
          } catch (e) {
            n.e(e);
          } finally {
            n.f();
          }

          e || (e = b.createElement('<div class="dz-message"><span></span></div>'), this.element.appendChild(e));
          var r = e.getElementsByTagName("span")[0];
          return r && (null != r.textContent ? r.textContent = this.options.dictFallbackMessage : null != r.innerText && (r.innerText = this.options.dictFallbackMessage)), this.element.appendChild(this.getFallbackForm());
        },
        resize: function resize(e, t, n, i) {
          var r = {
            srcX: 0,
            srcY: 0,
            srcWidth: e.width,
            srcHeight: e.height
          },
              o = e.width / e.height;
          null == t && null == n ? (t = r.srcWidth, n = r.srcHeight) : null == t ? t = n * o : null == n && (n = t / o);
          var a = (t = Math.min(t, r.srcWidth)) / (n = Math.min(n, r.srcHeight));
          if (r.srcWidth > t || r.srcHeight > n) if ("crop" === i) a < o ? (r.srcHeight = e.height, r.srcWidth = r.srcHeight * a) : (r.srcWidth = e.width, r.srcHeight = r.srcWidth / a);else {
            if ("contain" !== i) throw new Error("Unknown resizeMethod '".concat(i, "'"));
            a < o ? n = t / o : t = n * o;
          }
          return r.srcX = (e.width - r.srcWidth) / 2, r.srcY = (e.height - r.srcHeight) / 2, r.trgWidth = t, r.trgHeight = n, r;
        },
        transformFile: function transformFile(e, t) {
          return (this.options.resizeWidth || this.options.resizeHeight) && e.type.match(/image.*/) ? this.resizeImage(e, this.options.resizeWidth, this.options.resizeHeight, this.options.resizeMethod, t) : t(e);
        },
        previewTemplate: '<div class="dz-preview dz-file-preview">\n  <div class="dz-image"><img data-dz-thumbnail /></div>\n  <div class="dz-details">\n    <div class="dz-size"><span data-dz-size></span></div>\n    <div class="dz-filename"><span data-dz-name></span></div>\n  </div>\n  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress></span></div>\n  <div class="dz-error-message"><span data-dz-errormessage></span></div>\n  <div class="dz-success-mark">\n    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n      <title>Check</title>\n      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF"></path>\n      </g>\n    </svg>\n  </div>\n  <div class="dz-error-mark">\n    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">\n      <title>Error</title>\n      <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">\n        <g stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">\n          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z"></path>\n        </g>\n      </g>\n    </svg>\n  </div>\n</div>',
        drop: function drop() {
          return this.element.classList.remove("dz-drag-hover");
        },
        dragstart: function dragstart() {},
        dragend: function dragend() {
          return this.element.classList.remove("dz-drag-hover");
        },
        dragenter: function dragenter() {
          return this.element.classList.add("dz-drag-hover");
        },
        dragover: function dragover() {
          return this.element.classList.add("dz-drag-hover");
        },
        dragleave: function dragleave() {
          return this.element.classList.remove("dz-drag-hover");
        },
        paste: function paste() {},
        reset: function reset() {
          return this.element.classList.remove("dz-started");
        },
        addedfile: function addedfile(t) {
          var n = this;

          if (this.element === this.previewsContainer && this.element.classList.add("dz-started"), this.previewsContainer) {
            t.previewElement = b.createElement(this.options.previewTemplate.trim()), t.previewTemplate = t.previewElement, this.previewsContainer.appendChild(t.previewElement);

            var e,
                i = _createForOfIteratorHelper(t.previewElement.querySelectorAll("[data-dz-name]"));

            try {
              for (i.s(); !(e = i.n()).done;) {
                var r = e.value;
                r.textContent = t.name;
              }
            } catch (e) {
              i.e(e);
            } finally {
              i.f();
            }

            var o,
                a = _createForOfIteratorHelper(t.previewElement.querySelectorAll("[data-dz-size]"));

            try {
              for (a.s(); !(o = a.n()).done;) {
                (r = o.value).innerHTML = this.filesize(t.size);
              }
            } catch (e) {
              a.e(e);
            } finally {
              a.f();
            }

            this.options.addRemoveLinks && (t._removeLink = b.createElement('<a class="dz-remove" href="javascript:undefined;" data-dz-remove>'.concat(this.options.dictRemoveFile, "</a>")), t.previewElement.appendChild(t._removeLink));

            var l,
                s = function s(e) {
              return e.preventDefault(), e.stopPropagation(), t.status === b.UPLOADING ? b.confirm(n.options.dictCancelUploadConfirmation, function () {
                return n.removeFile(t);
              }) : n.options.dictRemoveFileConfirmation ? b.confirm(n.options.dictRemoveFileConfirmation, function () {
                return n.removeFile(t);
              }) : n.removeFile(t);
            },
                u = _createForOfIteratorHelper(t.previewElement.querySelectorAll("[data-dz-remove]"));

            try {
              for (u.s(); !(l = u.n()).done;) {
                l.value.addEventListener("click", s);
              }
            } catch (e) {
              u.e(e);
            } finally {
              u.f();
            }
          }
        },
        removedfile: function removedfile(e) {
          return null != e.previewElement && null != e.previewElement.parentNode && e.previewElement.parentNode.removeChild(e.previewElement), this._updateMaxFilesReachedClass();
        },
        thumbnail: function thumbnail(e, t) {
          if (e.previewElement) {
            e.previewElement.classList.remove("dz-file-preview");

            var n,
                i = _createForOfIteratorHelper(e.previewElement.querySelectorAll("[data-dz-thumbnail]"));

            try {
              for (i.s(); !(n = i.n()).done;) {
                var r = n.value;
                r.alt = e.name, r.src = t;
              }
            } catch (e) {
              i.e(e);
            } finally {
              i.f();
            }

            return setTimeout(function () {
              return e.previewElement.classList.add("dz-image-preview");
            }, 1);
          }
        },
        error: function error(e, t) {
          if (e.previewElement) {
            e.previewElement.classList.add("dz-error"), "string" != typeof t && t.error && (t = t.error);

            var n,
                i = _createForOfIteratorHelper(e.previewElement.querySelectorAll("[data-dz-errormessage]"));

            try {
              for (i.s(); !(n = i.n()).done;) {
                n.value.textContent = t;
              }
            } catch (e) {
              i.e(e);
            } finally {
              i.f();
            }
          }
        },
        errormultiple: function errormultiple() {},
        processing: function processing(e) {
          if (e.previewElement && (e.previewElement.classList.add("dz-processing"), e._removeLink)) return e._removeLink.innerHTML = this.options.dictCancelUpload;
        },
        processingmultiple: function processingmultiple() {},
        uploadprogress: function uploadprogress(e, t) {
          if (e.previewElement) {
            var n,
                i = _createForOfIteratorHelper(e.previewElement.querySelectorAll("[data-dz-uploadprogress]"));

            try {
              for (i.s(); !(n = i.n()).done;) {
                var r = n.value;
                "PROGRESS" === r.nodeName ? r.value = t : r.style.width = "".concat(t, "%");
              }
            } catch (e) {
              i.e(e);
            } finally {
              i.f();
            }
          }
        },
        totaluploadprogress: function totaluploadprogress() {},
        sending: function sending() {},
        sendingmultiple: function sendingmultiple() {},
        success: function success(e) {
          if (e.previewElement) return e.previewElement.classList.add("dz-success");
        },
        successmultiple: function successmultiple() {},
        canceled: function canceled(e) {
          return this.emit("error", e, this.options.dictUploadCanceled);
        },
        canceledmultiple: function canceledmultiple() {},
        complete: function complete(e) {
          if (e._removeLink && (e._removeLink.innerHTML = this.options.dictRemoveFile), e.previewElement) return e.previewElement.classList.add("dz-complete");
        },
        completemultiple: function completemultiple() {},
        maxfilesexceeded: function maxfilesexceeded() {},
        maxfilesreached: function maxfilesreached() {},
        queuecomplete: function queuecomplete() {},
        addedfiles: function addedfiles() {}
      }, this.prototype._thumbnailQueue = [], this.prototype._processingThumbnail = !1;
    }
  }, {
    key: "extend",
    value: function value(e) {
      for (var t = arguments.length, n = new Array(1 < t ? t - 1 : 0), i = 1; i < t; i++) {
        n[i - 1] = arguments[i];
      }

      for (var r = 0, o = n; r < o.length; r++) {
        var a = o[r];

        for (var l in a) {
          var s = a[l];
          e[l] = s;
        }
      }

      return e;
    }
  }]), _createClass(b, [{
    key: "getAcceptedFiles",
    value: function value() {
      return this.files.filter(function (e) {
        return e.accepted;
      }).map(function (e) {
        return e;
      });
    }
  }, {
    key: "getRejectedFiles",
    value: function value() {
      return this.files.filter(function (e) {
        return !e.accepted;
      }).map(function (e) {
        return e;
      });
    }
  }, {
    key: "getFilesWithStatus",
    value: function value(t) {
      return this.files.filter(function (e) {
        return e.status === t;
      }).map(function (e) {
        return e;
      });
    }
  }, {
    key: "getQueuedFiles",
    value: function value() {
      return this.getFilesWithStatus(b.QUEUED);
    }
  }, {
    key: "getUploadingFiles",
    value: function value() {
      return this.getFilesWithStatus(b.UPLOADING);
    }
  }, {
    key: "getAddedFiles",
    value: function value() {
      return this.getFilesWithStatus(b.ADDED);
    }
  }, {
    key: "getActiveFiles",
    value: function value() {
      return this.files.filter(function (e) {
        return e.status === b.UPLOADING || e.status === b.QUEUED;
      }).map(function (e) {
        return e;
      });
    }
  }, {
    key: "init",
    value: function value() {
      var o = this;

      if ("form" === this.element.tagName && this.element.setAttribute("enctype", "multipart/form-data"), this.element.classList.contains("dropzone") && !this.element.querySelector(".dz-message") && this.element.appendChild(b.createElement('<div class="dz-default dz-message"><button class="dz-button" type="button">'.concat(this.options.dictDefaultMessage, "</button></div>"))), this.clickableElements.length) {
        !function r() {
          return o.hiddenFileInput && o.hiddenFileInput.parentNode.removeChild(o.hiddenFileInput), o.hiddenFileInput = document.createElement("input"), o.hiddenFileInput.setAttribute("type", "file"), (null === o.options.maxFiles || 1 < o.options.maxFiles) && o.hiddenFileInput.setAttribute("multiple", "multiple"), o.hiddenFileInput.className = "dz-hidden-input", null !== o.options.acceptedFiles && o.hiddenFileInput.setAttribute("accept", o.options.acceptedFiles), null !== o.options.capture && o.hiddenFileInput.setAttribute("capture", o.options.capture), o.hiddenFileInput.style.visibility = "hidden", o.hiddenFileInput.style.position = "absolute", o.hiddenFileInput.style.top = "0", o.hiddenFileInput.style.left = "0", o.hiddenFileInput.style.height = "0", o.hiddenFileInput.style.width = "0", b.getElement(o.options.hiddenInputContainer, "hiddenInputContainer").appendChild(o.hiddenFileInput), o.hiddenFileInput.addEventListener("change", function () {
            var e = o.hiddenFileInput.files;

            if (e.length) {
              var t,
                  n = _createForOfIteratorHelper(e);

              try {
                for (n.s(); !(t = n.n()).done;) {
                  var i = t.value;
                  o.addFile(i);
                }
              } catch (e) {
                n.e(e);
              } finally {
                n.f();
              }
            }

            return o.emit("addedfiles", e), r();
          });
        }();
      }

      this.URL = null !== window.URL ? window.URL : window.webkitURL;

      var e,
          t = _createForOfIteratorHelper(this.events);

      try {
        for (t.s(); !(e = t.n()).done;) {
          var n = e.value;
          this.on(n, this.options[n]);
        }
      } catch (e) {
        t.e(e);
      } finally {
        t.f();
      }

      this.on("uploadprogress", function () {
        return o.updateTotalUploadProgress();
      }), this.on("removedfile", function () {
        return o.updateTotalUploadProgress();
      }), this.on("canceled", function (e) {
        return o.emit("complete", e);
      }), this.on("complete", function (e) {
        if (0 === o.getAddedFiles().length && 0 === o.getUploadingFiles().length && 0 === o.getQueuedFiles().length) return setTimeout(function () {
          return o.emit("queuecomplete");
        }, 0);
      });

      function i(e) {
        return function (e) {
          if (e.dataTransfer.types) for (var t = 0; t < e.dataTransfer.types.length; t++) {
            if ("Files" === e.dataTransfer.types[t]) return !0;
          }
          return !1;
        }(e) && (e.stopPropagation(), e.preventDefault ? e.preventDefault() : e.returnValue = !1);
      }

      return this.listeners = [{
        element: this.element,
        events: {
          dragstart: function dragstart(e) {
            return o.emit("dragstart", e);
          },
          dragenter: function dragenter(e) {
            return i(e), o.emit("dragenter", e);
          },
          dragover: function dragover(e) {
            var t;

            try {
              t = e.dataTransfer.effectAllowed;
            } catch (e) {}

            return e.dataTransfer.dropEffect = "move" === t || "linkMove" === t ? "move" : "copy", i(e), o.emit("dragover", e);
          },
          dragleave: function dragleave(e) {
            return o.emit("dragleave", e);
          },
          drop: function drop(e) {
            return i(e), o.drop(e);
          },
          dragend: function dragend(e) {
            return o.emit("dragend", e);
          }
        }
      }], this.clickableElements.forEach(function (t) {
        return o.listeners.push({
          element: t,
          events: {
            click: function click(e) {
              return t === o.element && e.target !== o.element && !b.elementInside(e.target, o.element.querySelector(".dz-message")) || o.hiddenFileInput.click(), !0;
            }
          }
        });
      }), this.enable(), this.options.init.call(this);
    }
  }, {
    key: "destroy",
    value: function value() {
      return this.disable(), this.removeAllFiles(!0), null != this.hiddenFileInput && this.hiddenFileInput.parentNode && (this.hiddenFileInput.parentNode.removeChild(this.hiddenFileInput), this.hiddenFileInput = null), delete this.element.dropzone, b.instances.splice(b.instances.indexOf(this), 1);
    }
  }, {
    key: "updateTotalUploadProgress",
    value: function value() {
      var e,
          t = 0,
          n = 0;

      if (this.getActiveFiles().length) {
        var i,
            r = _createForOfIteratorHelper(this.getActiveFiles());

        try {
          for (r.s(); !(i = r.n()).done;) {
            var o = i.value;
            t += o.upload.bytesSent, n += o.upload.total;
          }
        } catch (e) {
          r.e(e);
        } finally {
          r.f();
        }

        e = 100 * t / n;
      } else e = 100;

      return this.emit("totaluploadprogress", e, n, t);
    }
  }, {
    key: "_getParamName",
    value: function value(e) {
      return "function" == typeof this.options.paramName ? this.options.paramName(e) : "".concat(this.options.paramName).concat(this.options.uploadMultiple ? "[".concat(e, "]") : "");
    }
  }, {
    key: "_renameFile",
    value: function value(e) {
      return "function" != typeof this.options.renameFile ? e.name : this.options.renameFile(e);
    }
  }, {
    key: "getFallbackForm",
    value: function value() {
      var e, t;
      if (e = this.getExistingFallback()) return e;
      var n = '<div class="dz-fallback">';
      this.options.dictFallbackText && (n += "<p>".concat(this.options.dictFallbackText, "</p>")), n += '<input type="file" name="'.concat(this._getParamName(0), '" ').concat(this.options.uploadMultiple ? 'multiple="multiple"' : void 0, ' /><input type="submit" value="Upload!"></div>');
      var i = b.createElement(n);
      return "FORM" !== this.element.tagName ? (t = b.createElement('<form action="'.concat(this.options.url, '" enctype="multipart/form-data" method="').concat(this.options.method, '"></form>'))).appendChild(i) : (this.element.setAttribute("enctype", "multipart/form-data"), this.element.setAttribute("method", this.options.method)), null != t ? t : i;
    }
  }, {
    key: "getExistingFallback",
    value: function value() {
      for (var e = function e(_e3) {
        var t,
            n = _createForOfIteratorHelper(_e3);

        try {
          for (n.s(); !(t = n.n()).done;) {
            var i = t.value;
            if (/(^| )fallback($| )/.test(i.className)) return i;
          }
        } catch (e) {
          n.e(e);
        } finally {
          n.f();
        }
      }, t = 0, n = ["div", "form"]; t < n.length; t++) {
        var i,
            r = n[t];
        if (i = e(this.element.getElementsByTagName(r))) return i;
      }
    }
  }, {
    key: "setupEventListeners",
    value: function value() {
      return this.listeners.map(function (i) {
        return function () {
          var e = [];

          for (var t in i.events) {
            var n = i.events[t];
            e.push(i.element.addEventListener(t, n, !1));
          }

          return e;
        }();
      });
    }
  }, {
    key: "removeEventListeners",
    value: function value() {
      return this.listeners.map(function (i) {
        return function () {
          var e = [];

          for (var t in i.events) {
            var n = i.events[t];
            e.push(i.element.removeEventListener(t, n, !1));
          }

          return e;
        }();
      });
    }
  }, {
    key: "disable",
    value: function value() {
      var t = this;
      return this.clickableElements.forEach(function (e) {
        return e.classList.remove("dz-clickable");
      }), this.removeEventListeners(), this.disabled = !0, this.files.map(function (e) {
        return t.cancelUpload(e);
      });
    }
  }, {
    key: "enable",
    value: function value() {
      return delete this.disabled, this.clickableElements.forEach(function (e) {
        return e.classList.add("dz-clickable");
      }), this.setupEventListeners();
    }
  }, {
    key: "filesize",
    value: function value(e) {
      var t = 0,
          n = "b";

      if (0 < e) {
        for (var i = ["tb", "gb", "mb", "kb", "b"], r = 0; r < i.length; r++) {
          var o = i[r];

          if (Math.pow(this.options.filesizeBase, 4 - r) / 10 <= e) {
            t = e / Math.pow(this.options.filesizeBase, 4 - r), n = o;
            break;
          }
        }

        t = Math.round(10 * t) / 10;
      }

      return "<strong>".concat(t, "</strong> ").concat(this.options.dictFileSizeUnits[n]);
    }
  }, {
    key: "_updateMaxFilesReachedClass",
    value: function value() {
      return null != this.options.maxFiles && this.getAcceptedFiles().length >= this.options.maxFiles ? (this.getAcceptedFiles().length === this.options.maxFiles && this.emit("maxfilesreached", this.files), this.element.classList.add("dz-max-files-reached")) : this.element.classList.remove("dz-max-files-reached");
    }
  }, {
    key: "drop",
    value: function value(e) {
      if (e.dataTransfer) {
        this.emit("drop", e);

        for (var t = [], n = 0; n < e.dataTransfer.files.length; n++) {
          t[n] = e.dataTransfer.files[n];
        }

        if (t.length) {
          var i = e.dataTransfer.items;
          i && i.length && null != i[0].webkitGetAsEntry ? this._addFilesFromItems(i) : this.handleFiles(t);
        }

        this.emit("addedfiles", t);
      }
    }
  }, {
    key: "paste",
    value: function value(e) {
      if (null != __guard__(null != e ? e.clipboardData : void 0, function (e) {
        return e.items;
      })) {
        this.emit("paste", e);
        var t = e.clipboardData.items;
        return t.length ? this._addFilesFromItems(t) : void 0;
      }
    }
  }, {
    key: "handleFiles",
    value: function value(e) {
      var t,
          n = _createForOfIteratorHelper(e);

      try {
        for (n.s(); !(t = n.n()).done;) {
          var i = t.value;
          this.addFile(i);
        }
      } catch (e) {
        n.e(e);
      } finally {
        n.f();
      }
    }
  }, {
    key: "_addFilesFromItems",
    value: function value(o) {
      var a = this;
      return function () {
        var e,
            t = [],
            n = _createForOfIteratorHelper(o);

        try {
          for (n.s(); !(e = n.n()).done;) {
            var i,
                r = e.value;
            null != r.webkitGetAsEntry && (i = r.webkitGetAsEntry()) ? i.isFile ? t.push(a.addFile(r.getAsFile())) : i.isDirectory ? t.push(a._addFilesFromDirectory(i, i.name)) : t.push(void 0) : null != r.getAsFile && (null == r.kind || "file" === r.kind) ? t.push(a.addFile(r.getAsFile())) : t.push(void 0);
          }
        } catch (e) {
          n.e(e);
        } finally {
          n.f();
        }

        return t;
      }();
    }
  }, {
    key: "_addFilesFromDirectory",
    value: function value(e, o) {
      function t(t) {
        return __guardMethod__(console, "log", function (e) {
          return e.log(t);
        });
      }

      var a = this,
          n = e.createReader();
      return function r() {
        return n.readEntries(function (e) {
          if (0 < e.length) {
            var t,
                n = _createForOfIteratorHelper(e);

            try {
              for (n.s(); !(t = n.n()).done;) {
                var i = t.value;
                i.isFile ? i.file(function (e) {
                  if (!a.options.ignoreHiddenFiles || "." !== e.name.substring(0, 1)) return e.fullPath = "".concat(o, "/").concat(e.name), a.addFile(e);
                }) : i.isDirectory && a._addFilesFromDirectory(i, "".concat(o, "/").concat(i.name));
              }
            } catch (e) {
              n.e(e);
            } finally {
              n.f();
            }

            r();
          }

          return null;
        }, t);
      }();
    }
  }, {
    key: "accept",
    value: function value(e, t) {
      this.options.maxFilesize && e.size > 1024 * this.options.maxFilesize * 1024 ? t(this.options.dictFileTooBig.replace("{{filesize}}", Math.round(e.size / 1024 / 10.24) / 100).replace("{{maxFilesize}}", this.options.maxFilesize)) : b.isValidFile(e, this.options.acceptedFiles) ? null != this.options.maxFiles && this.getAcceptedFiles().length >= this.options.maxFiles ? (t(this.options.dictMaxFilesExceeded.replace("{{maxFiles}}", this.options.maxFiles)), this.emit("maxfilesexceeded", e)) : this.options.accept.call(this, e, t) : t(this.options.dictInvalidFileType);
    }
  }, {
    key: "addFile",
    value: function value(t) {
      var n = this;
      t.upload = {
        uuid: b.uuidv4(),
        progress: 0,
        total: t.size,
        bytesSent: 0,
        filename: this._renameFile(t)
      }, this.files.push(t), t.status = b.ADDED, this.emit("addedfile", t), this._enqueueThumbnail(t), this.accept(t, function (e) {
        e ? (t.accepted = !1, n._errorProcessing([t], e)) : (t.accepted = !0, n.options.autoQueue && n.enqueueFile(t)), n._updateMaxFilesReachedClass();
      });
    }
  }, {
    key: "enqueueFiles",
    value: function value(e) {
      var t,
          n = _createForOfIteratorHelper(e);

      try {
        for (n.s(); !(t = n.n()).done;) {
          var i = t.value;
          this.enqueueFile(i);
        }
      } catch (e) {
        n.e(e);
      } finally {
        n.f();
      }

      return null;
    }
  }, {
    key: "enqueueFile",
    value: function value(e) {
      var t = this;
      if (e.status !== b.ADDED || !0 !== e.accepted) throw new Error("This file can't be queued because it has already been processed or was rejected.");
      if (e.status = b.QUEUED, this.options.autoProcessQueue) return setTimeout(function () {
        return t.processQueue();
      }, 0);
    }
  }, {
    key: "_enqueueThumbnail",
    value: function value(e) {
      var t = this;
      if (this.options.createImageThumbnails && e.type.match(/image.*/) && e.size <= 1024 * this.options.maxThumbnailFilesize * 1024) return this._thumbnailQueue.push(e), setTimeout(function () {
        return t._processThumbnailQueue();
      }, 0);
    }
  }, {
    key: "_processThumbnailQueue",
    value: function value() {
      var t = this;

      if (!this._processingThumbnail && 0 !== this._thumbnailQueue.length) {
        this._processingThumbnail = !0;

        var n = this._thumbnailQueue.shift();

        return this.createThumbnail(n, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.thumbnailMethod, !0, function (e) {
          return t.emit("thumbnail", n, e), t._processingThumbnail = !1, t._processThumbnailQueue();
        });
      }
    }
  }, {
    key: "removeFile",
    value: function value(e) {
      if (e.status === b.UPLOADING && this.cancelUpload(e), this.files = without(this.files, e), this.emit("removedfile", e), 0 === this.files.length) return this.emit("reset");
    }
  }, {
    key: "removeAllFiles",
    value: function value(e) {
      null == e && (e = !1);

      var t,
          n = _createForOfIteratorHelper(this.files.slice());

      try {
        for (n.s(); !(t = n.n()).done;) {
          var i = t.value;
          i.status === b.UPLOADING && !e || this.removeFile(i);
        }
      } catch (e) {
        n.e(e);
      } finally {
        n.f();
      }

      return null;
    }
  }, {
    key: "resizeImage",
    value: function value(r, e, t, n, o) {
      var a = this;
      return this.createThumbnail(r, e, t, n, !0, function (e, t) {
        if (null == t) return o(r);
        var n = a.options.resizeMimeType;
        null == n && (n = r.type);
        var i = t.toDataURL(n, a.options.resizeQuality);
        return "image/jpeg" !== n && "image/jpg" !== n || (i = ExifRestore.restore(r.dataURL, i)), o(b.dataURItoBlob(i));
      });
    }
  }, {
    key: "createThumbnail",
    value: function value(e, t, n, i, r, o) {
      var a = this,
          l = new FileReader();
      l.onload = function () {
        e.dataURL = l.result, "image/svg+xml" !== e.type ? a.createThumbnailFromUrl(e, t, n, i, r, o) : null != o && o(l.result);
      }, l.readAsDataURL(e);
    }
  }, {
    key: "displayExistingFile",
    value: function value(t, e, n, i, r) {
      var o = this,
          a = !(4 < arguments.length && void 0 !== r) || r;

      if (this.emit("addedfile", t), this.emit("complete", t), a) {
        t.dataURL = e, this.createThumbnailFromUrl(t, this.options.thumbnailWidth, this.options.thumbnailHeight, this.options.resizeMethod, this.options.fixOrientation, function (e) {
          o.emit("thumbnail", t, e), n && n();
        }, i);
      } else this.emit("thumbnail", t, e), n && n();
    }
  }, {
    key: "createThumbnailFromUrl",
    value: function value(o, a, l, s, t, u, e) {
      var c = this,
          d = document.createElement("img");
      return e && (d.crossOrigin = e), t = "from-image" != getComputedStyle(document.body).imageOrientation && t, d.onload = function () {
        var e = function e(_e4) {
          return _e4(1);
        };

        return "undefined" != typeof EXIF && null !== EXIF && t && (e = function e(_e5) {
          return EXIF.getData(d, function () {
            return _e5(EXIF.getTag(this, "Orientation"));
          });
        }), e(function (e) {
          o.width = d.width, o.height = d.height;
          var t = c.options.resize.call(c, o, a, l, s),
              n = document.createElement("canvas"),
              i = n.getContext("2d");

          switch (n.width = t.trgWidth, n.height = t.trgHeight, 4 < e && (n.width = t.trgHeight, n.height = t.trgWidth), e) {
            case 2:
              i.translate(n.width, 0), i.scale(-1, 1);
              break;

            case 3:
              i.translate(n.width, n.height), i.rotate(Math.PI);
              break;

            case 4:
              i.translate(0, n.height), i.scale(1, -1);
              break;

            case 5:
              i.rotate(.5 * Math.PI), i.scale(1, -1);
              break;

            case 6:
              i.rotate(.5 * Math.PI), i.translate(0, -n.width);
              break;

            case 7:
              i.rotate(.5 * Math.PI), i.translate(n.height, -n.width), i.scale(-1, 1);
              break;

            case 8:
              i.rotate(-.5 * Math.PI), i.translate(-n.height, 0);
          }

          drawImageIOSFix(i, d, null != t.srcX ? t.srcX : 0, null != t.srcY ? t.srcY : 0, t.srcWidth, t.srcHeight, null != t.trgX ? t.trgX : 0, null != t.trgY ? t.trgY : 0, t.trgWidth, t.trgHeight);
          var r = n.toDataURL("image/png");
          if (null != u) return u(r, n);
        });
      }, null != u && (d.onerror = u), d.src = o.dataURL;
    }
  }, {
    key: "processQueue",
    value: function value() {
      var e = this.options.parallelUploads,
          t = this.getUploadingFiles().length,
          n = t;

      if (!(e <= t)) {
        var i = this.getQueuedFiles();

        if (0 < i.length) {
          if (this.options.uploadMultiple) return this.processFiles(i.slice(0, e - t));

          for (; n < e;) {
            if (!i.length) return;
            this.processFile(i.shift()), n++;
          }
        }
      }
    }
  }, {
    key: "processFile",
    value: function value(e) {
      return this.processFiles([e]);
    }
  }, {
    key: "processFiles",
    value: function value(e) {
      var t,
          n = _createForOfIteratorHelper(e);

      try {
        for (n.s(); !(t = n.n()).done;) {
          var i = t.value;
          i.processing = !0, i.status = b.UPLOADING, this.emit("processing", i);
        }
      } catch (e) {
        n.e(e);
      } finally {
        n.f();
      }

      return this.options.uploadMultiple && this.emit("processingmultiple", e), this.uploadFiles(e);
    }
  }, {
    key: "_getFilesWithXhr",
    value: function value(t) {
      return this.files.filter(function (e) {
        return e.xhr === t;
      }).map(function (e) {
        return e;
      });
    }
  }, {
    key: "cancelUpload",
    value: function value(e) {
      if (e.status === b.UPLOADING) {
        var t,
            n = this._getFilesWithXhr(e.xhr),
            i = _createForOfIteratorHelper(n);

        try {
          for (i.s(); !(t = i.n()).done;) {
            t.value.status = b.CANCELED;
          }
        } catch (e) {
          i.e(e);
        } finally {
          i.f();
        }

        void 0 !== e.xhr && e.xhr.abort();

        var r,
            o = _createForOfIteratorHelper(n);

        try {
          for (o.s(); !(r = o.n()).done;) {
            var a = r.value;
            this.emit("canceled", a);
          }
        } catch (e) {
          o.e(e);
        } finally {
          o.f();
        }

        this.options.uploadMultiple && this.emit("canceledmultiple", n);
      } else e.status !== b.ADDED && e.status !== b.QUEUED || (e.status = b.CANCELED, this.emit("canceled", e), this.options.uploadMultiple && this.emit("canceledmultiple", [e]));

      if (this.options.autoProcessQueue) return this.processQueue();
    }
  }, {
    key: "resolveOption",
    value: function value(e) {
      if ("function" != typeof e) return e;

      for (var t = arguments.length, n = new Array(1 < t ? t - 1 : 0), i = 1; i < t; i++) {
        n[i - 1] = arguments[i];
      }

      return e.apply(this, n);
    }
  }, {
    key: "uploadFile",
    value: function value(e) {
      return this.uploadFiles([e]);
    }
  }, {
    key: "uploadFiles",
    value: function value(s) {
      var u = this;

      this._transformFiles(s, function (e) {
        if (u.options.chunking) {
          var t = e[0];
          s[0].upload.chunked = u.options.chunking && (u.options.forceChunking || t.size > u.options.chunkSize), s[0].upload.totalChunkCount = Math.ceil(t.size / u.options.chunkSize);
        }

        if (s[0].upload.chunked) {
          var r = s[0],
              o = e[0];
          r.upload.chunks = [];

          var i = function i() {
            for (var e = 0; void 0 !== r.upload.chunks[e];) {
              e++;
            }

            if (!(e >= r.upload.totalChunkCount)) {
              0;
              var t = e * u.options.chunkSize,
                  n = Math.min(t + u.options.chunkSize, o.size),
                  i = {
                name: u._getParamName(0),
                data: o.webkitSlice ? o.webkitSlice(t, n) : o.slice(t, n),
                filename: r.upload.filename,
                chunkIndex: e
              };
              r.upload.chunks[e] = {
                file: r,
                index: e,
                dataBlock: i,
                status: b.UPLOADING,
                progress: 0,
                retries: 0
              }, u._uploadData(s, [i]);
            }
          };

          if (r.upload.finishedChunkUpload = function (e) {
            var t = !0;
            e.status = b.SUCCESS, e.dataBlock = null, e.xhr = null;

            for (var n = 0; n < r.upload.totalChunkCount; n++) {
              if (void 0 === r.upload.chunks[n]) return i();
              r.upload.chunks[n].status !== b.SUCCESS && (t = !1);
            }

            t && u.options.chunksUploaded(r, function () {
              u._finished(s, "", null);
            });
          }, u.options.parallelChunkUploads) for (var n = 0; n < r.upload.totalChunkCount; n++) {
            i();
          } else i();
        } else {
          for (var a = [], l = 0; l < s.length; l++) {
            a[l] = {
              name: u._getParamName(l),
              data: e[l],
              filename: s[l].upload.filename
            };
          }

          u._uploadData(s, a);
        }
      });
    }
  }, {
    key: "_getChunk",
    value: function value(e, t) {
      for (var n = 0; n < e.upload.totalChunkCount; n++) {
        if (void 0 !== e.upload.chunks[n] && e.upload.chunks[n].xhr === t) return e.upload.chunks[n];
      }
    }
  }, {
    key: "_uploadData",
    value: function value(t, e) {
      var n,
          i = this,
          r = new XMLHttpRequest(),
          o = _createForOfIteratorHelper(t);

      try {
        for (o.s(); !(n = o.n()).done;) {
          n.value.xhr = r;
        }
      } catch (e) {
        o.e(e);
      } finally {
        o.f();
      }

      t[0].upload.chunked && (t[0].upload.chunks[e[0].chunkIndex].xhr = r);
      var a = this.resolveOption(this.options.method, t),
          l = this.resolveOption(this.options.url, t);
      r.open(a, l, !0), r.timeout = this.resolveOption(this.options.timeout, t), r.withCredentials = !!this.options.withCredentials, r.onload = function (e) {
        i._finishedUploading(t, r, e);
      }, r.ontimeout = function () {
        i._handleUploadError(t, r, "Request timedout after ".concat(i.options.timeout / 1e3, " seconds"));
      }, r.onerror = function () {
        i._handleUploadError(t, r);
      }, (null != r.upload ? r.upload : r).onprogress = function (e) {
        return i._updateFilesUploadProgress(t, r, e);
      };
      var s = {
        Accept: "application/json",
        "Cache-Control": "no-cache",
        "X-Requested-With": "XMLHttpRequest"
      };

      for (var u in this.options.headers && b.extend(s, this.options.headers), s) {
        var c = s[u];
        c && r.setRequestHeader(u, c);
      }

      var d = new FormData();

      if (this.options.params) {
        var p = this.options.params;

        for (var h in "function" == typeof p && (p = p.call(this, t, r, t[0].upload.chunked ? this._getChunk(t[0], r) : null)), p) {
          var f = p[h];
          if (Array.isArray(f)) for (var m = 0; m < f.length; m++) {
            d.append(h, f[m]);
          } else d.append(h, f);
        }
      }

      var v,
          g = _createForOfIteratorHelper(t);

      try {
        for (g.s(); !(v = g.n()).done;) {
          var y = v.value;
          this.emit("sending", y, r, d);
        }
      } catch (e) {
        g.e(e);
      } finally {
        g.f();
      }

      this.options.uploadMultiple && this.emit("sendingmultiple", t, r, d), this._addFormElementData(d);

      for (var F = 0; F < e.length; F++) {
        var k = e[F];
        d.append(k.name, k.data, k.filename);
      }

      this.submitRequest(r, d, t);
    }
  }, {
    key: "_transformFiles",
    value: function value(n, i) {
      for (var e = this, r = [], o = 0, t = function t(_t) {
        e.options.transformFile.call(e, n[_t], function (e) {
          r[_t] = e, ++o === n.length && i(r);
        });
      }, a = 0; a < n.length; a++) {
        t(a);
      }
    }
  }, {
    key: "_addFormElementData",
    value: function value(e) {
      if ("FORM" === this.element.tagName) {
        var t,
            n = _createForOfIteratorHelper(this.element.querySelectorAll("input, textarea, select, button"));

        try {
          for (n.s(); !(t = n.n()).done;) {
            var i = t.value,
                r = i.getAttribute("name"),
                o = i.getAttribute("type");
            if (o = o && o.toLowerCase(), null != r) if ("SELECT" === i.tagName && i.hasAttribute("multiple")) {
              var a,
                  l = _createForOfIteratorHelper(i.options);

              try {
                for (l.s(); !(a = l.n()).done;) {
                  var s = a.value;
                  s.selected && e.append(r, s.value);
                }
              } catch (e) {
                l.e(e);
              } finally {
                l.f();
              }
            } else (!o || "checkbox" !== o && "radio" !== o || i.checked) && e.append(r, i.value);
          }
        } catch (e) {
          n.e(e);
        } finally {
          n.f();
        }
      }
    }
  }, {
    key: "_updateFilesUploadProgress",
    value: function value(e, t, n) {
      var i;

      if (void 0 !== n) {
        if (i = 100 * n.loaded / n.total, e[0].upload.chunked) {
          var r = e[0],
              o = this._getChunk(r, t);

          o.progress = i, o.total = n.total, o.bytesSent = n.loaded;
          r.upload.progress = 0, r.upload.total = 0;

          for (var a = r.upload.bytesSent = 0; a < r.upload.totalChunkCount; a++) {
            void 0 !== r.upload.chunks[a] && void 0 !== r.upload.chunks[a].progress && (r.upload.progress += r.upload.chunks[a].progress, r.upload.total += r.upload.chunks[a].total, r.upload.bytesSent += r.upload.chunks[a].bytesSent);
          }

          r.upload.progress = r.upload.progress / r.upload.totalChunkCount;
        } else {
          var l,
              s = _createForOfIteratorHelper(e);

          try {
            for (s.s(); !(l = s.n()).done;) {
              var u = l.value;
              u.upload.progress = i, u.upload.total = n.total, u.upload.bytesSent = n.loaded;
            }
          } catch (e) {
            s.e(e);
          } finally {
            s.f();
          }
        }

        var c,
            d = _createForOfIteratorHelper(e);

        try {
          for (d.s(); !(c = d.n()).done;) {
            var p = c.value;
            this.emit("uploadprogress", p, p.upload.progress, p.upload.bytesSent);
          }
        } catch (e) {
          d.e(e);
        } finally {
          d.f();
        }
      } else {
        var h = !0;
        i = 100;

        var f,
            m = _createForOfIteratorHelper(e);

        try {
          for (m.s(); !(f = m.n()).done;) {
            var v = f.value;
            100 === v.upload.progress && v.upload.bytesSent === v.upload.total || (h = !1), v.upload.progress = i, v.upload.bytesSent = v.upload.total;
          }
        } catch (e) {
          m.e(e);
        } finally {
          m.f();
        }

        if (h) return;

        var g,
            y = _createForOfIteratorHelper(e);

        try {
          for (y.s(); !(g = y.n()).done;) {
            var F = g.value;
            this.emit("uploadprogress", F, i, F.upload.bytesSent);
          }
        } catch (e) {
          y.e(e);
        } finally {
          y.f();
        }
      }
    }
  }, {
    key: "_finishedUploading",
    value: function value(e, t, n) {
      var i;

      if (e[0].status !== b.CANCELED && 4 === t.readyState) {
        if ("arraybuffer" !== t.responseType && "blob" !== t.responseType && (i = t.responseText, t.getResponseHeader("content-type") && ~t.getResponseHeader("content-type").indexOf("application/json"))) try {
          i = JSON.parse(i);
        } catch (e) {
          n = e, i = "Invalid JSON response from server.";
        }
        this._updateFilesUploadProgress(e), 200 <= t.status && t.status < 300 ? e[0].upload.chunked ? e[0].upload.finishedChunkUpload(this._getChunk(e[0], t)) : this._finished(e, i, n) : this._handleUploadError(e, t, i);
      }
    }
  }, {
    key: "_handleUploadError",
    value: function value(e, t, n) {
      if (e[0].status !== b.CANCELED) {
        if (e[0].upload.chunked && this.options.retryChunks) {
          var i = this._getChunk(e[0], t);

          if (i.retries++ < this.options.retryChunksLimit) return void this._uploadData(e, [i.dataBlock]);
          console.warn("Retried this chunk too often. Giving up.");
        }

        this._errorProcessing(e, n || this.options.dictResponseError.replace("{{statusCode}}", t.status), t);
      }
    }
  }, {
    key: "submitRequest",
    value: function value(e, t) {
      e.send(t);
    }
  }, {
    key: "_finished",
    value: function value(e, t, n) {
      var i,
          r = _createForOfIteratorHelper(e);

      try {
        for (r.s(); !(i = r.n()).done;) {
          var o = i.value;
          o.status = b.SUCCESS, this.emit("success", o, t, n), this.emit("complete", o);
        }
      } catch (e) {
        r.e(e);
      } finally {
        r.f();
      }

      if (this.options.uploadMultiple && (this.emit("successmultiple", e, t, n), this.emit("completemultiple", e)), this.options.autoProcessQueue) return this.processQueue();
    }
  }, {
    key: "_errorProcessing",
    value: function value(e, t, n) {
      var i,
          r = _createForOfIteratorHelper(e);

      try {
        for (r.s(); !(i = r.n()).done;) {
          var o = i.value;
          o.status = b.ERROR, this.emit("error", o, t, n), this.emit("complete", o);
        }
      } catch (e) {
        r.e(e);
      } finally {
        r.f();
      }

      if (this.options.uploadMultiple && (this.emit("errormultiple", e, t, n), this.emit("completemultiple", e)), this.options.autoProcessQueue) return this.processQueue();
    }
  }], [{
    key: "uuidv4",
    value: function value() {
      return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (e) {
        var t = 16 * Math.random() | 0;
        return ("x" === e ? t : 3 & t | 8).toString(16);
      });
    }
  }]), b;
}();

Dropzone.initClass(), Dropzone.version = "5.7.2", Dropzone.options = {}, Dropzone.optionsForElement = function (e) {
  return e.getAttribute("id") ? Dropzone.options[camelize(e.getAttribute("id"))] : void 0;
}, Dropzone.instances = [], Dropzone.forElement = function (e) {
  if ("string" == typeof e && (e = document.querySelector(e)), null == (null != e ? e.dropzone : void 0)) throw new Error("No Dropzone found for given element. This is probably because you're trying to access it before Dropzone had the time to initialize. Use the `init` option to setup any additional observers on your Dropzone.");
  return e.dropzone;
}, Dropzone.autoDiscover = !0, Dropzone.discover = function () {
  var o;
  if (document.querySelectorAll) o = document.querySelectorAll(".dropzone");else {
    o = [];

    var e = function e(r) {
      return function () {
        var e,
            t = [],
            n = _createForOfIteratorHelper(r);

        try {
          for (n.s(); !(e = n.n()).done;) {
            var i = e.value;
            /(^| )dropzone($| )/.test(i.className) ? t.push(o.push(i)) : t.push(void 0);
          }
        } catch (e) {
          n.e(e);
        } finally {
          n.f();
        }

        return t;
      }();
    };

    e(document.getElementsByTagName("div")), e(document.getElementsByTagName("form"));
  }
  return function () {
    var e,
        t = [],
        n = _createForOfIteratorHelper(o);

    try {
      for (n.s(); !(e = n.n()).done;) {
        var i = e.value;
        !1 !== Dropzone.optionsForElement(i) ? t.push(new Dropzone(i)) : t.push(void 0);
      }
    } catch (e) {
      n.e(e);
    } finally {
      n.f();
    }

    return t;
  }();
}, Dropzone.blacklistedBrowsers = [/opera.*(Macintosh|Windows Phone).*version\/12/i], Dropzone.isBrowserSupported = function () {
  var e = !0;
  if (window.File && window.FileReader && window.FileList && window.Blob && window.FormData && document.querySelector) {
    if ("classList" in document.createElement("a")) {
      var t,
          n = _createForOfIteratorHelper(Dropzone.blacklistedBrowsers);

      try {
        for (n.s(); !(t = n.n()).done;) {
          t.value.test(navigator.userAgent) && (e = !1);
        }
      } catch (e) {
        n.e(e);
      } finally {
        n.f();
      }
    } else e = !1;
  } else e = !1;
  return e;
}, Dropzone.dataURItoBlob = function (e) {
  for (var t = atob(e.split(",")[1]), n = e.split(",")[0].split(":")[1].split(";")[0], i = new ArrayBuffer(t.length), r = new Uint8Array(i), o = 0, a = t.length, l = 0 <= a; l ? o <= a : a <= o; l ? o++ : o--) {
    r[o] = t.charCodeAt(o);
  }

  return new Blob([i], {
    type: n
  });
};

var without = function without(e, t) {
  return e.filter(function (e) {
    return e !== t;
  }).map(function (e) {
    return e;
  });
},
    camelize = function camelize(e) {
  return e.replace(/[\-_](\w)/g, function (e) {
    return e.charAt(1).toUpperCase();
  });
};

Dropzone.createElement = function (e) {
  var t = document.createElement("div");
  return t.innerHTML = e, t.childNodes[0];
}, Dropzone.elementInside = function (e, t) {
  if (e === t) return !0;

  for (; e = e.parentNode;) {
    if (e === t) return !0;
  }

  return !1;
}, Dropzone.getElement = function (e, t) {
  var n;
  if ("string" == typeof e ? n = document.querySelector(e) : null != e.nodeType && (n = e), null == n) throw new Error("Invalid `".concat(t, "` option provided. Please provide a CSS selector or a plain HTML element."));
  return n;
}, Dropzone.getElements = function (e, t) {
  var n, i;

  if (e instanceof Array) {
    i = [];

    try {
      var r,
          o = _createForOfIteratorHelper(e);

      try {
        for (o.s(); !(r = o.n()).done;) {
          n = r.value, i.push(this.getElement(n, t));
        }
      } catch (e) {
        o.e(e);
      } finally {
        o.f();
      }
    } catch (e) {
      i = null;
    }
  } else if ("string" == typeof e) {
    i = [];

    var a,
        l = _createForOfIteratorHelper(document.querySelectorAll(e));

    try {
      for (l.s(); !(a = l.n()).done;) {
        n = a.value, i.push(n);
      }
    } catch (e) {
      l.e(e);
    } finally {
      l.f();
    }
  } else null != e.nodeType && (i = [e]);

  if (null == i || !i.length) throw new Error("Invalid `".concat(t, "` option provided. Please provide a CSS selector, a plain HTML element or a list of those."));
  return i;
}, Dropzone.confirm = function (e, t, n) {
  return window.confirm(e) ? t() : null != n ? n() : void 0;
}, Dropzone.isValidFile = function (e, t) {
  if (!t) return !0;
  t = t.split(",");

  var n,
      i = e.type,
      r = i.replace(/\/.*$/, ""),
      o = _createForOfIteratorHelper(t);

  try {
    for (o.s(); !(n = o.n()).done;) {
      var a = n.value;

      if ("." === (a = a.trim()).charAt(0)) {
        if (-1 !== e.name.toLowerCase().indexOf(a.toLowerCase(), e.name.length - a.length)) return !0;
      } else if (/\/\*$/.test(a)) {
        if (r === a.replace(/\/.*$/, "")) return !0;
      } else if (i === a) return !0;
    }
  } catch (e) {
    o.e(e);
  } finally {
    o.f();
  }

  return !1;
}, "undefined" != typeof jQuery && null !== jQuery && (jQuery.fn.dropzone = function (e) {
  return this.each(function () {
    return new Dropzone(this, e);
  });
}),  true && null !== module ? module.exports = Dropzone : window.Dropzone = Dropzone, Dropzone.ADDED = "added", Dropzone.QUEUED = "queued", Dropzone.ACCEPTED = Dropzone.QUEUED, Dropzone.UPLOADING = "uploading", Dropzone.PROCESSING = Dropzone.UPLOADING, Dropzone.CANCELED = "canceled", Dropzone.ERROR = "error", Dropzone.SUCCESS = "success";

var detectVerticalSquash = function detectVerticalSquash(e) {
  e.naturalWidth;
  var t = e.naturalHeight,
      n = document.createElement("canvas");
  n.width = 1, n.height = t;
  var i = n.getContext("2d");
  i.drawImage(e, 0, 0);

  for (var r = i.getImageData(1, 0, 1, t).data, o = 0, a = t, l = t; o < l;) {
    0 === r[4 * (l - 1) + 3] ? a = l : o = l, l = a + o >> 1;
  }

  var s = l / t;
  return 0 == s ? 1 : s;
},
    drawImageIOSFix = function drawImageIOSFix(e, t, n, i, r, o, a, l, s, u) {
  var c = detectVerticalSquash(t);
  return e.drawImage(t, n, i, r, o, a, l, s, u / c);
},
    ExifRestore = function () {
  function e() {
    _classCallCheck(this, e);
  }

  return _createClass(e, null, [{
    key: "initClass",
    value: function value() {
      this.KEY_STR = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    }
  }, {
    key: "encode64",
    value: function value(e) {
      for (var t = "", n = void 0, i = void 0, r = "", o = void 0, a = void 0, l = void 0, s = "", u = 0; o = (n = e[u++]) >> 2, a = (3 & n) << 4 | (i = e[u++]) >> 4, l = (15 & i) << 2 | (r = e[u++]) >> 6, s = 63 & r, isNaN(i) ? l = s = 64 : isNaN(r) && (s = 64), t = t + this.KEY_STR.charAt(o) + this.KEY_STR.charAt(a) + this.KEY_STR.charAt(l) + this.KEY_STR.charAt(s), n = i = r = "", o = a = l = s = "", u < e.length;) {
        ;
      }

      return t;
    }
  }, {
    key: "restore",
    value: function value(e, t) {
      if (!e.match("data:image/jpeg;base64,")) return t;
      var n = this.decode64(e.replace("data:image/jpeg;base64,", "")),
          i = this.slice2Segments(n),
          r = this.exifManipulation(t, i);
      return "data:image/jpeg;base64,".concat(this.encode64(r));
    }
  }, {
    key: "exifManipulation",
    value: function value(e, t) {
      var n = this.getExifArray(t),
          i = this.insertExif(e, n);
      return new Uint8Array(i);
    }
  }, {
    key: "getExifArray",
    value: function value(e) {
      for (var t = void 0, n = 0; n < e.length;) {
        if (255 === (t = e[n])[0] & 225 === t[1]) return t;
        n++;
      }

      return [];
    }
  }, {
    key: "insertExif",
    value: function value(e, t) {
      var n = e.replace("data:image/jpeg;base64,", ""),
          i = this.decode64(n),
          r = i.indexOf(255, 3),
          o = i.slice(0, r),
          a = i.slice(r),
          l = o;
      return l = (l = l.concat(t)).concat(a);
    }
  }, {
    key: "slice2Segments",
    value: function value(e) {
      for (var t = 0, n = [];;) {
        if (255 === e[t] & 218 === e[t + 1]) break;
        if (255 === e[t] & 216 === e[t + 1]) t += 2;else {
          var i = t + (256 * e[t + 2] + e[t + 3]) + 2,
              r = e.slice(t, i);
          n.push(r), t = i;
        }
        if (t > e.length) break;
      }

      return n;
    }
  }, {
    key: "decode64",
    value: function value(e) {
      var t = void 0,
          n = void 0,
          i = "",
          r = void 0,
          o = void 0,
          a = "",
          l = 0,
          s = [];

      for (/[^A-Za-z0-9\+\/\=]/g.exec(e) && console.warn("There were invalid base64 characters in the input text.\nValid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\nExpect errors in decoding."), e = e.replace(/[^A-Za-z0-9\+\/\=]/g, ""); t = this.KEY_STR.indexOf(e.charAt(l++)) << 2 | (r = this.KEY_STR.indexOf(e.charAt(l++))) >> 4, n = (15 & r) << 4 | (o = this.KEY_STR.indexOf(e.charAt(l++))) >> 2, i = (3 & o) << 6 | (a = this.KEY_STR.indexOf(e.charAt(l++))), s.push(t), 64 !== o && s.push(n), 64 !== a && s.push(i), t = n = i = "", r = o = a = "", l < e.length;) {
        ;
      }

      return s;
    }
  }]), e;
}();

ExifRestore.initClass();

var contentLoaded = function contentLoaded(t, n) {
  function i(e) {
    if ("readystatechange" !== e.type || "complete" === o.readyState) return ("load" === e.type ? t : o)[s](u + e.type, i, !1), !r && (r = !0) ? n.call(t, e.type || e) : void 0;
  }

  var r = !1,
      e = !0,
      o = t.document,
      a = o.documentElement,
      l = o.addEventListener ? "addEventListener" : "attachEvent",
      s = o.addEventListener ? "removeEventListener" : "detachEvent",
      u = o.addEventListener ? "" : "on";

  if ("complete" !== o.readyState) {
    if (o.createEventObject && a.doScroll) {
      try {
        e = !t.frameElement;
      } catch (e) {}

      e && !function t() {
        try {
          a.doScroll("left");
        } catch (e) {
          return void setTimeout(t, 50);
        }

        return i("poll");
      }();
    }

    return o[l](u + "DOMContentLoaded", i, !1), o[l](u + "readystatechange", i, !1), t[l](u + "load", i, !1);
  }
};

function __guard__(e, t) {
  return null != e ? t(e) : void 0;
}

function __guardMethod__(e, t, n) {
  return null != e && "function" == typeof e[t] ? n(e, t) : void 0;
}

Dropzone._autoDiscoverFunction = function () {
  if (Dropzone.autoDiscover) return Dropzone.discover();
}, contentLoaded(window, Dropzone._autoDiscoverFunction);
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../../node_modules/webpack/buildin/module.js */ "./node_modules/webpack/buildin/module.js")(module)))

/***/ }),

/***/ 20:
/*!************************************************************!*\
  !*** multi ./resources/js/dashboard/mail/compose-email.js ***!
  \************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\js\dashboard\mail\compose-email.js */"./resources/js/dashboard/mail/compose-email.js");


/***/ })

/******/ });