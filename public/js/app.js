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
/******/ 	return __webpack_require__(__webpack_require__.s = 0);
/******/ })
/************************************************************************/
/******/ ({

/***/ "./node_modules/axios/index.js":
/*!*************************************!*\
  !*** ./node_modules/axios/index.js ***!
  \*************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

module.exports = __webpack_require__(/*! ./lib/axios */ "./node_modules/axios/lib/axios.js");

/***/ }),

/***/ "./node_modules/axios/lib/adapters/xhr.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/adapters/xhr.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var settle = __webpack_require__(/*! ./../core/settle */ "./node_modules/axios/lib/core/settle.js");
var buildURL = __webpack_require__(/*! ./../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var buildFullPath = __webpack_require__(/*! ../core/buildFullPath */ "./node_modules/axios/lib/core/buildFullPath.js");
var parseHeaders = __webpack_require__(/*! ./../helpers/parseHeaders */ "./node_modules/axios/lib/helpers/parseHeaders.js");
var isURLSameOrigin = __webpack_require__(/*! ./../helpers/isURLSameOrigin */ "./node_modules/axios/lib/helpers/isURLSameOrigin.js");
var createError = __webpack_require__(/*! ../core/createError */ "./node_modules/axios/lib/core/createError.js");

module.exports = function xhrAdapter(config) {
  return new Promise(function dispatchXhrRequest(resolve, reject) {
    var requestData = config.data;
    var requestHeaders = config.headers;

    if (utils.isFormData(requestData)) {
      delete requestHeaders['Content-Type']; // Let the browser set it
    }

    var request = new XMLHttpRequest();

    // HTTP basic authentication
    if (config.auth) {
      var username = config.auth.username || '';
      var password = config.auth.password || '';
      requestHeaders.Authorization = 'Basic ' + btoa(username + ':' + password);
    }

    var fullPath = buildFullPath(config.baseURL, config.url);
    request.open(config.method.toUpperCase(), buildURL(fullPath, config.params, config.paramsSerializer), true);

    // Set the request timeout in MS
    request.timeout = config.timeout;

    // Listen for ready state
    request.onreadystatechange = function handleLoad() {
      if (!request || request.readyState !== 4) {
        return;
      }

      // The request errored out and we didn't get a response, this will be
      // handled by onerror instead
      // With one exception: request that using file: protocol, most browsers
      // will return status as 0 even though it's a successful request
      if (request.status === 0 && !(request.responseURL && request.responseURL.indexOf('file:') === 0)) {
        return;
      }

      // Prepare the response
      var responseHeaders = 'getAllResponseHeaders' in request ? parseHeaders(request.getAllResponseHeaders()) : null;
      var responseData = !config.responseType || config.responseType === 'text' ? request.responseText : request.response;
      var response = {
        data: responseData,
        status: request.status,
        statusText: request.statusText,
        headers: responseHeaders,
        config: config,
        request: request
      };

      settle(resolve, reject, response);

      // Clean up request
      request = null;
    };

    // Handle browser request cancellation (as opposed to a manual cancellation)
    request.onabort = function handleAbort() {
      if (!request) {
        return;
      }

      reject(createError('Request aborted', config, 'ECONNABORTED', request));

      // Clean up request
      request = null;
    };

    // Handle low level network errors
    request.onerror = function handleError() {
      // Real errors are hidden from us by the browser
      // onerror should only fire if it's a network error
      reject(createError('Network Error', config, null, request));

      // Clean up request
      request = null;
    };

    // Handle timeout
    request.ontimeout = function handleTimeout() {
      var timeoutErrorMessage = 'timeout of ' + config.timeout + 'ms exceeded';
      if (config.timeoutErrorMessage) {
        timeoutErrorMessage = config.timeoutErrorMessage;
      }
      reject(createError(timeoutErrorMessage, config, 'ECONNABORTED',
        request));

      // Clean up request
      request = null;
    };

    // Add xsrf header
    // This is only done if running in a standard browser environment.
    // Specifically not if we're in a web worker, or react-native.
    if (utils.isStandardBrowserEnv()) {
      var cookies = __webpack_require__(/*! ./../helpers/cookies */ "./node_modules/axios/lib/helpers/cookies.js");

      // Add xsrf header
      var xsrfValue = (config.withCredentials || isURLSameOrigin(fullPath)) && config.xsrfCookieName ?
        cookies.read(config.xsrfCookieName) :
        undefined;

      if (xsrfValue) {
        requestHeaders[config.xsrfHeaderName] = xsrfValue;
      }
    }

    // Add headers to the request
    if ('setRequestHeader' in request) {
      utils.forEach(requestHeaders, function setRequestHeader(val, key) {
        if (typeof requestData === 'undefined' && key.toLowerCase() === 'content-type') {
          // Remove Content-Type if data is undefined
          delete requestHeaders[key];
        } else {
          // Otherwise add header to the request
          request.setRequestHeader(key, val);
        }
      });
    }

    // Add withCredentials to request if needed
    if (!utils.isUndefined(config.withCredentials)) {
      request.withCredentials = !!config.withCredentials;
    }

    // Add responseType to request if needed
    if (config.responseType) {
      try {
        request.responseType = config.responseType;
      } catch (e) {
        // Expected DOMException thrown by browsers not compatible XMLHttpRequest Level 2.
        // But, this can be suppressed for 'json' type as it can be parsed by default 'transformResponse' function.
        if (config.responseType !== 'json') {
          throw e;
        }
      }
    }

    // Handle progress if needed
    if (typeof config.onDownloadProgress === 'function') {
      request.addEventListener('progress', config.onDownloadProgress);
    }

    // Not all browsers support upload events
    if (typeof config.onUploadProgress === 'function' && request.upload) {
      request.upload.addEventListener('progress', config.onUploadProgress);
    }

    if (config.cancelToken) {
      // Handle cancellation
      config.cancelToken.promise.then(function onCanceled(cancel) {
        if (!request) {
          return;
        }

        request.abort();
        reject(cancel);
        // Clean up request
        request = null;
      });
    }

    if (requestData === undefined) {
      requestData = null;
    }

    // Send the request
    request.send(requestData);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/axios.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/axios.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");
var Axios = __webpack_require__(/*! ./core/Axios */ "./node_modules/axios/lib/core/Axios.js");
var mergeConfig = __webpack_require__(/*! ./core/mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");
var defaults = __webpack_require__(/*! ./defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Create an instance of Axios
 *
 * @param {Object} defaultConfig The default config for the instance
 * @return {Axios} A new instance of Axios
 */
function createInstance(defaultConfig) {
  var context = new Axios(defaultConfig);
  var instance = bind(Axios.prototype.request, context);

  // Copy axios.prototype to instance
  utils.extend(instance, Axios.prototype, context);

  // Copy context to instance
  utils.extend(instance, context);

  return instance;
}

// Create the default instance to be exported
var axios = createInstance(defaults);

// Expose Axios class to allow class inheritance
axios.Axios = Axios;

// Factory for creating new instances
axios.create = function create(instanceConfig) {
  return createInstance(mergeConfig(axios.defaults, instanceConfig));
};

// Expose Cancel & CancelToken
axios.Cancel = __webpack_require__(/*! ./cancel/Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");
axios.CancelToken = __webpack_require__(/*! ./cancel/CancelToken */ "./node_modules/axios/lib/cancel/CancelToken.js");
axios.isCancel = __webpack_require__(/*! ./cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");

// Expose all/spread
axios.all = function all(promises) {
  return Promise.all(promises);
};
axios.spread = __webpack_require__(/*! ./helpers/spread */ "./node_modules/axios/lib/helpers/spread.js");

module.exports = axios;

// Allow use of default import syntax in TypeScript
module.exports.default = axios;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/Cancel.js":
/*!*************************************************!*\
  !*** ./node_modules/axios/lib/cancel/Cancel.js ***!
  \*************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * A `Cancel` is an object that is thrown when an operation is canceled.
 *
 * @class
 * @param {string=} message The message.
 */
function Cancel(message) {
  this.message = message;
}

Cancel.prototype.toString = function toString() {
  return 'Cancel' + (this.message ? ': ' + this.message : '');
};

Cancel.prototype.__CANCEL__ = true;

module.exports = Cancel;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/CancelToken.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/cancel/CancelToken.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var Cancel = __webpack_require__(/*! ./Cancel */ "./node_modules/axios/lib/cancel/Cancel.js");

/**
 * A `CancelToken` is an object that can be used to request cancellation of an operation.
 *
 * @class
 * @param {Function} executor The executor function.
 */
function CancelToken(executor) {
  if (typeof executor !== 'function') {
    throw new TypeError('executor must be a function.');
  }

  var resolvePromise;
  this.promise = new Promise(function promiseExecutor(resolve) {
    resolvePromise = resolve;
  });

  var token = this;
  executor(function cancel(message) {
    if (token.reason) {
      // Cancellation has already been requested
      return;
    }

    token.reason = new Cancel(message);
    resolvePromise(token.reason);
  });
}

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
CancelToken.prototype.throwIfRequested = function throwIfRequested() {
  if (this.reason) {
    throw this.reason;
  }
};

/**
 * Returns an object that contains a new `CancelToken` and a function that, when called,
 * cancels the `CancelToken`.
 */
CancelToken.source = function source() {
  var cancel;
  var token = new CancelToken(function executor(c) {
    cancel = c;
  });
  return {
    token: token,
    cancel: cancel
  };
};

module.exports = CancelToken;


/***/ }),

/***/ "./node_modules/axios/lib/cancel/isCancel.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/cancel/isCancel.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function isCancel(value) {
  return !!(value && value.__CANCEL__);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/Axios.js":
/*!**********************************************!*\
  !*** ./node_modules/axios/lib/core/Axios.js ***!
  \**********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var buildURL = __webpack_require__(/*! ../helpers/buildURL */ "./node_modules/axios/lib/helpers/buildURL.js");
var InterceptorManager = __webpack_require__(/*! ./InterceptorManager */ "./node_modules/axios/lib/core/InterceptorManager.js");
var dispatchRequest = __webpack_require__(/*! ./dispatchRequest */ "./node_modules/axios/lib/core/dispatchRequest.js");
var mergeConfig = __webpack_require__(/*! ./mergeConfig */ "./node_modules/axios/lib/core/mergeConfig.js");

/**
 * Create a new instance of Axios
 *
 * @param {Object} instanceConfig The default config for the instance
 */
function Axios(instanceConfig) {
  this.defaults = instanceConfig;
  this.interceptors = {
    request: new InterceptorManager(),
    response: new InterceptorManager()
  };
}

/**
 * Dispatch a request
 *
 * @param {Object} config The config specific for this request (merged with this.defaults)
 */
Axios.prototype.request = function request(config) {
  /*eslint no-param-reassign:0*/
  // Allow for axios('example/url'[, config]) a la fetch API
  if (typeof config === 'string') {
    config = arguments[1] || {};
    config.url = arguments[0];
  } else {
    config = config || {};
  }

  config = mergeConfig(this.defaults, config);

  // Set config.method
  if (config.method) {
    config.method = config.method.toLowerCase();
  } else if (this.defaults.method) {
    config.method = this.defaults.method.toLowerCase();
  } else {
    config.method = 'get';
  }

  // Hook up interceptors middleware
  var chain = [dispatchRequest, undefined];
  var promise = Promise.resolve(config);

  this.interceptors.request.forEach(function unshiftRequestInterceptors(interceptor) {
    chain.unshift(interceptor.fulfilled, interceptor.rejected);
  });

  this.interceptors.response.forEach(function pushResponseInterceptors(interceptor) {
    chain.push(interceptor.fulfilled, interceptor.rejected);
  });

  while (chain.length) {
    promise = promise.then(chain.shift(), chain.shift());
  }

  return promise;
};

Axios.prototype.getUri = function getUri(config) {
  config = mergeConfig(this.defaults, config);
  return buildURL(config.url, config.params, config.paramsSerializer).replace(/^\?/, '');
};

// Provide aliases for supported request methods
utils.forEach(['delete', 'get', 'head', 'options'], function forEachMethodNoData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url
    }));
  };
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  /*eslint func-names:0*/
  Axios.prototype[method] = function(url, data, config) {
    return this.request(utils.merge(config || {}, {
      method: method,
      url: url,
      data: data
    }));
  };
});

module.exports = Axios;


/***/ }),

/***/ "./node_modules/axios/lib/core/InterceptorManager.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/core/InterceptorManager.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function InterceptorManager() {
  this.handlers = [];
}

/**
 * Add a new interceptor to the stack
 *
 * @param {Function} fulfilled The function to handle `then` for a `Promise`
 * @param {Function} rejected The function to handle `reject` for a `Promise`
 *
 * @return {Number} An ID used to remove interceptor later
 */
InterceptorManager.prototype.use = function use(fulfilled, rejected) {
  this.handlers.push({
    fulfilled: fulfilled,
    rejected: rejected
  });
  return this.handlers.length - 1;
};

/**
 * Remove an interceptor from the stack
 *
 * @param {Number} id The ID that was returned by `use`
 */
InterceptorManager.prototype.eject = function eject(id) {
  if (this.handlers[id]) {
    this.handlers[id] = null;
  }
};

/**
 * Iterate over all the registered interceptors
 *
 * This method is particularly useful for skipping over any
 * interceptors that may have become `null` calling `eject`.
 *
 * @param {Function} fn The function to call for each interceptor
 */
InterceptorManager.prototype.forEach = function forEach(fn) {
  utils.forEach(this.handlers, function forEachHandler(h) {
    if (h !== null) {
      fn(h);
    }
  });
};

module.exports = InterceptorManager;


/***/ }),

/***/ "./node_modules/axios/lib/core/buildFullPath.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/buildFullPath.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var isAbsoluteURL = __webpack_require__(/*! ../helpers/isAbsoluteURL */ "./node_modules/axios/lib/helpers/isAbsoluteURL.js");
var combineURLs = __webpack_require__(/*! ../helpers/combineURLs */ "./node_modules/axios/lib/helpers/combineURLs.js");

/**
 * Creates a new URL by combining the baseURL with the requestedURL,
 * only when the requestedURL is not already an absolute URL.
 * If the requestURL is absolute, this function returns the requestedURL untouched.
 *
 * @param {string} baseURL The base URL
 * @param {string} requestedURL Absolute or relative URL to combine
 * @returns {string} The combined full path
 */
module.exports = function buildFullPath(baseURL, requestedURL) {
  if (baseURL && !isAbsoluteURL(requestedURL)) {
    return combineURLs(baseURL, requestedURL);
  }
  return requestedURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/createError.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/createError.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var enhanceError = __webpack_require__(/*! ./enhanceError */ "./node_modules/axios/lib/core/enhanceError.js");

/**
 * Create an Error with the specified message, config, error code, request and response.
 *
 * @param {string} message The error message.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The created error.
 */
module.exports = function createError(message, config, code, request, response) {
  var error = new Error(message);
  return enhanceError(error, config, code, request, response);
};


/***/ }),

/***/ "./node_modules/axios/lib/core/dispatchRequest.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/core/dispatchRequest.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");
var transformData = __webpack_require__(/*! ./transformData */ "./node_modules/axios/lib/core/transformData.js");
var isCancel = __webpack_require__(/*! ../cancel/isCancel */ "./node_modules/axios/lib/cancel/isCancel.js");
var defaults = __webpack_require__(/*! ../defaults */ "./node_modules/axios/lib/defaults.js");

/**
 * Throws a `Cancel` if cancellation has been requested.
 */
function throwIfCancellationRequested(config) {
  if (config.cancelToken) {
    config.cancelToken.throwIfRequested();
  }
}

/**
 * Dispatch a request to the server using the configured adapter.
 *
 * @param {object} config The config that is to be used for the request
 * @returns {Promise} The Promise to be fulfilled
 */
module.exports = function dispatchRequest(config) {
  throwIfCancellationRequested(config);

  // Ensure headers exist
  config.headers = config.headers || {};

  // Transform request data
  config.data = transformData(
    config.data,
    config.headers,
    config.transformRequest
  );

  // Flatten headers
  config.headers = utils.merge(
    config.headers.common || {},
    config.headers[config.method] || {},
    config.headers
  );

  utils.forEach(
    ['delete', 'get', 'head', 'post', 'put', 'patch', 'common'],
    function cleanHeaderConfig(method) {
      delete config.headers[method];
    }
  );

  var adapter = config.adapter || defaults.adapter;

  return adapter(config).then(function onAdapterResolution(response) {
    throwIfCancellationRequested(config);

    // Transform response data
    response.data = transformData(
      response.data,
      response.headers,
      config.transformResponse
    );

    return response;
  }, function onAdapterRejection(reason) {
    if (!isCancel(reason)) {
      throwIfCancellationRequested(config);

      // Transform response data
      if (reason && reason.response) {
        reason.response.data = transformData(
          reason.response.data,
          reason.response.headers,
          config.transformResponse
        );
      }
    }

    return Promise.reject(reason);
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/core/enhanceError.js":
/*!*****************************************************!*\
  !*** ./node_modules/axios/lib/core/enhanceError.js ***!
  \*****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Update an Error with the specified config, error code, and response.
 *
 * @param {Error} error The error to update.
 * @param {Object} config The config.
 * @param {string} [code] The error code (for example, 'ECONNABORTED').
 * @param {Object} [request] The request.
 * @param {Object} [response] The response.
 * @returns {Error} The error.
 */
module.exports = function enhanceError(error, config, code, request, response) {
  error.config = config;
  if (code) {
    error.code = code;
  }

  error.request = request;
  error.response = response;
  error.isAxiosError = true;

  error.toJSON = function() {
    return {
      // Standard
      message: this.message,
      name: this.name,
      // Microsoft
      description: this.description,
      number: this.number,
      // Mozilla
      fileName: this.fileName,
      lineNumber: this.lineNumber,
      columnNumber: this.columnNumber,
      stack: this.stack,
      // Axios
      config: this.config,
      code: this.code
    };
  };
  return error;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/mergeConfig.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/core/mergeConfig.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Config-specific merge-function which creates a new config-object
 * by merging two configuration objects together.
 *
 * @param {Object} config1
 * @param {Object} config2
 * @returns {Object} New object resulting from merging config2 to config1
 */
module.exports = function mergeConfig(config1, config2) {
  // eslint-disable-next-line no-param-reassign
  config2 = config2 || {};
  var config = {};

  var valueFromConfig2Keys = ['url', 'method', 'params', 'data'];
  var mergeDeepPropertiesKeys = ['headers', 'auth', 'proxy'];
  var defaultToConfig2Keys = [
    'baseURL', 'url', 'transformRequest', 'transformResponse', 'paramsSerializer',
    'timeout', 'withCredentials', 'adapter', 'responseType', 'xsrfCookieName',
    'xsrfHeaderName', 'onUploadProgress', 'onDownloadProgress',
    'maxContentLength', 'validateStatus', 'maxRedirects', 'httpAgent',
    'httpsAgent', 'cancelToken', 'socketPath'
  ];

  utils.forEach(valueFromConfig2Keys, function valueFromConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    }
  });

  utils.forEach(mergeDeepPropertiesKeys, function mergeDeepProperties(prop) {
    if (utils.isObject(config2[prop])) {
      config[prop] = utils.deepMerge(config1[prop], config2[prop]);
    } else if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (utils.isObject(config1[prop])) {
      config[prop] = utils.deepMerge(config1[prop]);
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  utils.forEach(defaultToConfig2Keys, function defaultToConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  var axiosKeys = valueFromConfig2Keys
    .concat(mergeDeepPropertiesKeys)
    .concat(defaultToConfig2Keys);

  var otherKeys = Object
    .keys(config2)
    .filter(function filterAxiosKeys(key) {
      return axiosKeys.indexOf(key) === -1;
    });

  utils.forEach(otherKeys, function otherKeysDefaultToConfig2(prop) {
    if (typeof config2[prop] !== 'undefined') {
      config[prop] = config2[prop];
    } else if (typeof config1[prop] !== 'undefined') {
      config[prop] = config1[prop];
    }
  });

  return config;
};


/***/ }),

/***/ "./node_modules/axios/lib/core/settle.js":
/*!***********************************************!*\
  !*** ./node_modules/axios/lib/core/settle.js ***!
  \***********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var createError = __webpack_require__(/*! ./createError */ "./node_modules/axios/lib/core/createError.js");

/**
 * Resolve or reject a Promise based on response status.
 *
 * @param {Function} resolve A function that resolves the promise.
 * @param {Function} reject A function that rejects the promise.
 * @param {object} response The response.
 */
module.exports = function settle(resolve, reject, response) {
  var validateStatus = response.config.validateStatus;
  if (!validateStatus || validateStatus(response.status)) {
    resolve(response);
  } else {
    reject(createError(
      'Request failed with status code ' + response.status,
      response.config,
      null,
      response.request,
      response
    ));
  }
};


/***/ }),

/***/ "./node_modules/axios/lib/core/transformData.js":
/*!******************************************************!*\
  !*** ./node_modules/axios/lib/core/transformData.js ***!
  \******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

/**
 * Transform the data for a request or a response
 *
 * @param {Object|String} data The data to be transformed
 * @param {Array} headers The headers for the request or response
 * @param {Array|Function} fns A single function or Array of functions
 * @returns {*} The resulting transformed data
 */
module.exports = function transformData(data, headers, fns) {
  /*eslint no-param-reassign:0*/
  utils.forEach(fns, function transform(fn) {
    data = fn(data, headers);
  });

  return data;
};


/***/ }),

/***/ "./node_modules/axios/lib/defaults.js":
/*!********************************************!*\
  !*** ./node_modules/axios/lib/defaults.js ***!
  \********************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";
/* WEBPACK VAR INJECTION */(function(process) {

var utils = __webpack_require__(/*! ./utils */ "./node_modules/axios/lib/utils.js");
var normalizeHeaderName = __webpack_require__(/*! ./helpers/normalizeHeaderName */ "./node_modules/axios/lib/helpers/normalizeHeaderName.js");

var DEFAULT_CONTENT_TYPE = {
  'Content-Type': 'application/x-www-form-urlencoded'
};

function setContentTypeIfUnset(headers, value) {
  if (!utils.isUndefined(headers) && utils.isUndefined(headers['Content-Type'])) {
    headers['Content-Type'] = value;
  }
}

function getDefaultAdapter() {
  var adapter;
  if (typeof XMLHttpRequest !== 'undefined') {
    // For browsers use XHR adapter
    adapter = __webpack_require__(/*! ./adapters/xhr */ "./node_modules/axios/lib/adapters/xhr.js");
  } else if (typeof process !== 'undefined' && Object.prototype.toString.call(process) === '[object process]') {
    // For node use HTTP adapter
    adapter = __webpack_require__(/*! ./adapters/http */ "./node_modules/axios/lib/adapters/xhr.js");
  }
  return adapter;
}

var defaults = {
  adapter: getDefaultAdapter(),

  transformRequest: [function transformRequest(data, headers) {
    normalizeHeaderName(headers, 'Accept');
    normalizeHeaderName(headers, 'Content-Type');
    if (utils.isFormData(data) ||
      utils.isArrayBuffer(data) ||
      utils.isBuffer(data) ||
      utils.isStream(data) ||
      utils.isFile(data) ||
      utils.isBlob(data)
    ) {
      return data;
    }
    if (utils.isArrayBufferView(data)) {
      return data.buffer;
    }
    if (utils.isURLSearchParams(data)) {
      setContentTypeIfUnset(headers, 'application/x-www-form-urlencoded;charset=utf-8');
      return data.toString();
    }
    if (utils.isObject(data)) {
      setContentTypeIfUnset(headers, 'application/json;charset=utf-8');
      return JSON.stringify(data);
    }
    return data;
  }],

  transformResponse: [function transformResponse(data) {
    /*eslint no-param-reassign:0*/
    if (typeof data === 'string') {
      try {
        data = JSON.parse(data);
      } catch (e) { /* Ignore */ }
    }
    return data;
  }],

  /**
   * A timeout in milliseconds to abort a request. If set to 0 (default) a
   * timeout is not created.
   */
  timeout: 0,

  xsrfCookieName: 'XSRF-TOKEN',
  xsrfHeaderName: 'X-XSRF-TOKEN',

  maxContentLength: -1,

  validateStatus: function validateStatus(status) {
    return status >= 200 && status < 300;
  }
};

defaults.headers = {
  common: {
    'Accept': 'application/json, text/plain, */*'
  }
};

utils.forEach(['delete', 'get', 'head'], function forEachMethodNoData(method) {
  defaults.headers[method] = {};
});

utils.forEach(['post', 'put', 'patch'], function forEachMethodWithData(method) {
  defaults.headers[method] = utils.merge(DEFAULT_CONTENT_TYPE);
});

module.exports = defaults;

/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../process/browser.js */ "./node_modules/process/browser.js")))

/***/ }),

/***/ "./node_modules/axios/lib/helpers/bind.js":
/*!************************************************!*\
  !*** ./node_modules/axios/lib/helpers/bind.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


module.exports = function bind(fn, thisArg) {
  return function wrap() {
    var args = new Array(arguments.length);
    for (var i = 0; i < args.length; i++) {
      args[i] = arguments[i];
    }
    return fn.apply(thisArg, args);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/buildURL.js":
/*!****************************************************!*\
  !*** ./node_modules/axios/lib/helpers/buildURL.js ***!
  \****************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

function encode(val) {
  return encodeURIComponent(val).
    replace(/%40/gi, '@').
    replace(/%3A/gi, ':').
    replace(/%24/g, '$').
    replace(/%2C/gi, ',').
    replace(/%20/g, '+').
    replace(/%5B/gi, '[').
    replace(/%5D/gi, ']');
}

/**
 * Build a URL by appending params to the end
 *
 * @param {string} url The base of the url (e.g., http://www.google.com)
 * @param {object} [params] The params to be appended
 * @returns {string} The formatted url
 */
module.exports = function buildURL(url, params, paramsSerializer) {
  /*eslint no-param-reassign:0*/
  if (!params) {
    return url;
  }

  var serializedParams;
  if (paramsSerializer) {
    serializedParams = paramsSerializer(params);
  } else if (utils.isURLSearchParams(params)) {
    serializedParams = params.toString();
  } else {
    var parts = [];

    utils.forEach(params, function serialize(val, key) {
      if (val === null || typeof val === 'undefined') {
        return;
      }

      if (utils.isArray(val)) {
        key = key + '[]';
      } else {
        val = [val];
      }

      utils.forEach(val, function parseValue(v) {
        if (utils.isDate(v)) {
          v = v.toISOString();
        } else if (utils.isObject(v)) {
          v = JSON.stringify(v);
        }
        parts.push(encode(key) + '=' + encode(v));
      });
    });

    serializedParams = parts.join('&');
  }

  if (serializedParams) {
    var hashmarkIndex = url.indexOf('#');
    if (hashmarkIndex !== -1) {
      url = url.slice(0, hashmarkIndex);
    }

    url += (url.indexOf('?') === -1 ? '?' : '&') + serializedParams;
  }

  return url;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/combineURLs.js":
/*!*******************************************************!*\
  !*** ./node_modules/axios/lib/helpers/combineURLs.js ***!
  \*******************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Creates a new URL by combining the specified URLs
 *
 * @param {string} baseURL The base URL
 * @param {string} relativeURL The relative URL
 * @returns {string} The combined URL
 */
module.exports = function combineURLs(baseURL, relativeURL) {
  return relativeURL
    ? baseURL.replace(/\/+$/, '') + '/' + relativeURL.replace(/^\/+/, '')
    : baseURL;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/cookies.js":
/*!***************************************************!*\
  !*** ./node_modules/axios/lib/helpers/cookies.js ***!
  \***************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs support document.cookie
    (function standardBrowserEnv() {
      return {
        write: function write(name, value, expires, path, domain, secure) {
          var cookie = [];
          cookie.push(name + '=' + encodeURIComponent(value));

          if (utils.isNumber(expires)) {
            cookie.push('expires=' + new Date(expires).toGMTString());
          }

          if (utils.isString(path)) {
            cookie.push('path=' + path);
          }

          if (utils.isString(domain)) {
            cookie.push('domain=' + domain);
          }

          if (secure === true) {
            cookie.push('secure');
          }

          document.cookie = cookie.join('; ');
        },

        read: function read(name) {
          var match = document.cookie.match(new RegExp('(^|;\\s*)(' + name + ')=([^;]*)'));
          return (match ? decodeURIComponent(match[3]) : null);
        },

        remove: function remove(name) {
          this.write(name, '', Date.now() - 86400000);
        }
      };
    })() :

  // Non standard browser env (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return {
        write: function write() {},
        read: function read() { return null; },
        remove: function remove() {}
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isAbsoluteURL.js":
/*!*********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isAbsoluteURL.js ***!
  \*********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Determines whether the specified URL is absolute
 *
 * @param {string} url The URL to test
 * @returns {boolean} True if the specified URL is absolute, otherwise false
 */
module.exports = function isAbsoluteURL(url) {
  // A URL is considered absolute if it begins with "<scheme>://" or "//" (protocol-relative URL).
  // RFC 3986 defines scheme name as a sequence of characters beginning with a letter and followed
  // by any combination of letters, digits, plus, period, or hyphen.
  return /^([a-z][a-z\d\+\-\.]*:)?\/\//i.test(url);
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/isURLSameOrigin.js":
/*!***********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/isURLSameOrigin.js ***!
  \***********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

module.exports = (
  utils.isStandardBrowserEnv() ?

  // Standard browser envs have full support of the APIs needed to test
  // whether the request URL is of the same origin as current location.
    (function standardBrowserEnv() {
      var msie = /(msie|trident)/i.test(navigator.userAgent);
      var urlParsingNode = document.createElement('a');
      var originURL;

      /**
    * Parse a URL to discover it's components
    *
    * @param {String} url The URL to be parsed
    * @returns {Object}
    */
      function resolveURL(url) {
        var href = url;

        if (msie) {
        // IE needs attribute set twice to normalize properties
          urlParsingNode.setAttribute('href', href);
          href = urlParsingNode.href;
        }

        urlParsingNode.setAttribute('href', href);

        // urlParsingNode provides the UrlUtils interface - http://url.spec.whatwg.org/#urlutils
        return {
          href: urlParsingNode.href,
          protocol: urlParsingNode.protocol ? urlParsingNode.protocol.replace(/:$/, '') : '',
          host: urlParsingNode.host,
          search: urlParsingNode.search ? urlParsingNode.search.replace(/^\?/, '') : '',
          hash: urlParsingNode.hash ? urlParsingNode.hash.replace(/^#/, '') : '',
          hostname: urlParsingNode.hostname,
          port: urlParsingNode.port,
          pathname: (urlParsingNode.pathname.charAt(0) === '/') ?
            urlParsingNode.pathname :
            '/' + urlParsingNode.pathname
        };
      }

      originURL = resolveURL(window.location.href);

      /**
    * Determine if a URL shares the same origin as the current location
    *
    * @param {String} requestURL The URL to test
    * @returns {boolean} True if URL shares the same origin, otherwise false
    */
      return function isURLSameOrigin(requestURL) {
        var parsed = (utils.isString(requestURL)) ? resolveURL(requestURL) : requestURL;
        return (parsed.protocol === originURL.protocol &&
            parsed.host === originURL.host);
      };
    })() :

  // Non standard browser envs (web workers, react-native) lack needed support.
    (function nonStandardBrowserEnv() {
      return function isURLSameOrigin() {
        return true;
      };
    })()
);


/***/ }),

/***/ "./node_modules/axios/lib/helpers/normalizeHeaderName.js":
/*!***************************************************************!*\
  !*** ./node_modules/axios/lib/helpers/normalizeHeaderName.js ***!
  \***************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ../utils */ "./node_modules/axios/lib/utils.js");

module.exports = function normalizeHeaderName(headers, normalizedName) {
  utils.forEach(headers, function processHeader(value, name) {
    if (name !== normalizedName && name.toUpperCase() === normalizedName.toUpperCase()) {
      headers[normalizedName] = value;
      delete headers[name];
    }
  });
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/parseHeaders.js":
/*!********************************************************!*\
  !*** ./node_modules/axios/lib/helpers/parseHeaders.js ***!
  \********************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var utils = __webpack_require__(/*! ./../utils */ "./node_modules/axios/lib/utils.js");

// Headers whose duplicates are ignored by node
// c.f. https://nodejs.org/api/http.html#http_message_headers
var ignoreDuplicateOf = [
  'age', 'authorization', 'content-length', 'content-type', 'etag',
  'expires', 'from', 'host', 'if-modified-since', 'if-unmodified-since',
  'last-modified', 'location', 'max-forwards', 'proxy-authorization',
  'referer', 'retry-after', 'user-agent'
];

/**
 * Parse headers into an object
 *
 * ```
 * Date: Wed, 27 Aug 2014 08:58:49 GMT
 * Content-Type: application/json
 * Connection: keep-alive
 * Transfer-Encoding: chunked
 * ```
 *
 * @param {String} headers Headers needing to be parsed
 * @returns {Object} Headers parsed into an object
 */
module.exports = function parseHeaders(headers) {
  var parsed = {};
  var key;
  var val;
  var i;

  if (!headers) { return parsed; }

  utils.forEach(headers.split('\n'), function parser(line) {
    i = line.indexOf(':');
    key = utils.trim(line.substr(0, i)).toLowerCase();
    val = utils.trim(line.substr(i + 1));

    if (key) {
      if (parsed[key] && ignoreDuplicateOf.indexOf(key) >= 0) {
        return;
      }
      if (key === 'set-cookie') {
        parsed[key] = (parsed[key] ? parsed[key] : []).concat([val]);
      } else {
        parsed[key] = parsed[key] ? parsed[key] + ', ' + val : val;
      }
    }
  });

  return parsed;
};


/***/ }),

/***/ "./node_modules/axios/lib/helpers/spread.js":
/*!**************************************************!*\
  !*** ./node_modules/axios/lib/helpers/spread.js ***!
  \**************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


/**
 * Syntactic sugar for invoking a function and expanding an array for arguments.
 *
 * Common use case would be to use `Function.prototype.apply`.
 *
 *  ```js
 *  function f(x, y, z) {}
 *  var args = [1, 2, 3];
 *  f.apply(null, args);
 *  ```
 *
 * With `spread` this example can be re-written.
 *
 *  ```js
 *  spread(function(x, y, z) {})([1, 2, 3]);
 *  ```
 *
 * @param {Function} callback
 * @returns {Function}
 */
module.exports = function spread(callback) {
  return function wrap(arr) {
    return callback.apply(null, arr);
  };
};


/***/ }),

/***/ "./node_modules/axios/lib/utils.js":
/*!*****************************************!*\
  !*** ./node_modules/axios/lib/utils.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

"use strict";


var bind = __webpack_require__(/*! ./helpers/bind */ "./node_modules/axios/lib/helpers/bind.js");

/*global toString:true*/

// utils is a library of generic helper functions non-specific to axios

var toString = Object.prototype.toString;

/**
 * Determine if a value is an Array
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Array, otherwise false
 */
function isArray(val) {
  return toString.call(val) === '[object Array]';
}

/**
 * Determine if a value is undefined
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if the value is undefined, otherwise false
 */
function isUndefined(val) {
  return typeof val === 'undefined';
}

/**
 * Determine if a value is a Buffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Buffer, otherwise false
 */
function isBuffer(val) {
  return val !== null && !isUndefined(val) && val.constructor !== null && !isUndefined(val.constructor)
    && typeof val.constructor.isBuffer === 'function' && val.constructor.isBuffer(val);
}

/**
 * Determine if a value is an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an ArrayBuffer, otherwise false
 */
function isArrayBuffer(val) {
  return toString.call(val) === '[object ArrayBuffer]';
}

/**
 * Determine if a value is a FormData
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an FormData, otherwise false
 */
function isFormData(val) {
  return (typeof FormData !== 'undefined') && (val instanceof FormData);
}

/**
 * Determine if a value is a view on an ArrayBuffer
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a view on an ArrayBuffer, otherwise false
 */
function isArrayBufferView(val) {
  var result;
  if ((typeof ArrayBuffer !== 'undefined') && (ArrayBuffer.isView)) {
    result = ArrayBuffer.isView(val);
  } else {
    result = (val) && (val.buffer) && (val.buffer instanceof ArrayBuffer);
  }
  return result;
}

/**
 * Determine if a value is a String
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a String, otherwise false
 */
function isString(val) {
  return typeof val === 'string';
}

/**
 * Determine if a value is a Number
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Number, otherwise false
 */
function isNumber(val) {
  return typeof val === 'number';
}

/**
 * Determine if a value is an Object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is an Object, otherwise false
 */
function isObject(val) {
  return val !== null && typeof val === 'object';
}

/**
 * Determine if a value is a Date
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Date, otherwise false
 */
function isDate(val) {
  return toString.call(val) === '[object Date]';
}

/**
 * Determine if a value is a File
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a File, otherwise false
 */
function isFile(val) {
  return toString.call(val) === '[object File]';
}

/**
 * Determine if a value is a Blob
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Blob, otherwise false
 */
function isBlob(val) {
  return toString.call(val) === '[object Blob]';
}

/**
 * Determine if a value is a Function
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Function, otherwise false
 */
function isFunction(val) {
  return toString.call(val) === '[object Function]';
}

/**
 * Determine if a value is a Stream
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a Stream, otherwise false
 */
function isStream(val) {
  return isObject(val) && isFunction(val.pipe);
}

/**
 * Determine if a value is a URLSearchParams object
 *
 * @param {Object} val The value to test
 * @returns {boolean} True if value is a URLSearchParams object, otherwise false
 */
function isURLSearchParams(val) {
  return typeof URLSearchParams !== 'undefined' && val instanceof URLSearchParams;
}

/**
 * Trim excess whitespace off the beginning and end of a string
 *
 * @param {String} str The String to trim
 * @returns {String} The String freed of excess whitespace
 */
function trim(str) {
  return str.replace(/^\s*/, '').replace(/\s*$/, '');
}

/**
 * Determine if we're running in a standard browser environment
 *
 * This allows axios to run in a web worker, and react-native.
 * Both environments support XMLHttpRequest, but not fully standard globals.
 *
 * web workers:
 *  typeof window -> undefined
 *  typeof document -> undefined
 *
 * react-native:
 *  navigator.product -> 'ReactNative'
 * nativescript
 *  navigator.product -> 'NativeScript' or 'NS'
 */
function isStandardBrowserEnv() {
  if (typeof navigator !== 'undefined' && (navigator.product === 'ReactNative' ||
                                           navigator.product === 'NativeScript' ||
                                           navigator.product === 'NS')) {
    return false;
  }
  return (
    typeof window !== 'undefined' &&
    typeof document !== 'undefined'
  );
}

/**
 * Iterate over an Array or an Object invoking a function for each item.
 *
 * If `obj` is an Array callback will be called passing
 * the value, index, and complete array for each item.
 *
 * If 'obj' is an Object callback will be called passing
 * the value, key, and complete object for each property.
 *
 * @param {Object|Array} obj The object to iterate
 * @param {Function} fn The callback to invoke for each item
 */
function forEach(obj, fn) {
  // Don't bother if no value provided
  if (obj === null || typeof obj === 'undefined') {
    return;
  }

  // Force an array if not already something iterable
  if (typeof obj !== 'object') {
    /*eslint no-param-reassign:0*/
    obj = [obj];
  }

  if (isArray(obj)) {
    // Iterate over array values
    for (var i = 0, l = obj.length; i < l; i++) {
      fn.call(null, obj[i], i, obj);
    }
  } else {
    // Iterate over object keys
    for (var key in obj) {
      if (Object.prototype.hasOwnProperty.call(obj, key)) {
        fn.call(null, obj[key], key, obj);
      }
    }
  }
}

/**
 * Accepts varargs expecting each argument to be an object, then
 * immutably merges the properties of each object and returns result.
 *
 * When multiple objects contain the same key the later object in
 * the arguments list will take precedence.
 *
 * Example:
 *
 * ```js
 * var result = merge({foo: 123}, {foo: 456});
 * console.log(result.foo); // outputs 456
 * ```
 *
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function merge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = merge(result[key], val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Function equal to merge with the difference being that no reference
 * to original objects is kept.
 *
 * @see merge
 * @param {Object} obj1 Object to merge
 * @returns {Object} Result of all merge properties
 */
function deepMerge(/* obj1, obj2, obj3, ... */) {
  var result = {};
  function assignValue(val, key) {
    if (typeof result[key] === 'object' && typeof val === 'object') {
      result[key] = deepMerge(result[key], val);
    } else if (typeof val === 'object') {
      result[key] = deepMerge({}, val);
    } else {
      result[key] = val;
    }
  }

  for (var i = 0, l = arguments.length; i < l; i++) {
    forEach(arguments[i], assignValue);
  }
  return result;
}

/**
 * Extends object a by mutably adding to it the properties of object b.
 *
 * @param {Object} a The object to be extended
 * @param {Object} b The object to copy properties from
 * @param {Object} thisArg The object to bind function to
 * @return {Object} The resulting value of object a
 */
function extend(a, b, thisArg) {
  forEach(b, function assignValue(val, key) {
    if (thisArg && typeof val === 'function') {
      a[key] = bind(val, thisArg);
    } else {
      a[key] = val;
    }
  });
  return a;
}

module.exports = {
  isArray: isArray,
  isArrayBuffer: isArrayBuffer,
  isBuffer: isBuffer,
  isFormData: isFormData,
  isArrayBufferView: isArrayBufferView,
  isString: isString,
  isNumber: isNumber,
  isObject: isObject,
  isUndefined: isUndefined,
  isDate: isDate,
  isFile: isFile,
  isBlob: isBlob,
  isFunction: isFunction,
  isStream: isStream,
  isURLSearchParams: isURLSearchParams,
  isStandardBrowserEnv: isStandardBrowserEnv,
  forEach: forEach,
  merge: merge,
  deepMerge: deepMerge,
  extend: extend,
  trim: trim
};


/***/ }),

/***/ "./node_modules/process/browser.js":
/*!*****************************************!*\
  !*** ./node_modules/process/browser.js ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// shim for using process in browser
var process = module.exports = {};

// cached from whatever global is present so that test runners that stub it
// don't break things.  But we need to wrap it in a try catch in case it is
// wrapped in strict mode code which doesn't define any globals.  It's inside a
// function because try/catches deoptimize in certain engines.

var cachedSetTimeout;
var cachedClearTimeout;

function defaultSetTimout() {
    throw new Error('setTimeout has not been defined');
}
function defaultClearTimeout () {
    throw new Error('clearTimeout has not been defined');
}
(function () {
    try {
        if (typeof setTimeout === 'function') {
            cachedSetTimeout = setTimeout;
        } else {
            cachedSetTimeout = defaultSetTimout;
        }
    } catch (e) {
        cachedSetTimeout = defaultSetTimout;
    }
    try {
        if (typeof clearTimeout === 'function') {
            cachedClearTimeout = clearTimeout;
        } else {
            cachedClearTimeout = defaultClearTimeout;
        }
    } catch (e) {
        cachedClearTimeout = defaultClearTimeout;
    }
} ())
function runTimeout(fun) {
    if (cachedSetTimeout === setTimeout) {
        //normal enviroments in sane situations
        return setTimeout(fun, 0);
    }
    // if setTimeout wasn't available but was latter defined
    if ((cachedSetTimeout === defaultSetTimout || !cachedSetTimeout) && setTimeout) {
        cachedSetTimeout = setTimeout;
        return setTimeout(fun, 0);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedSetTimeout(fun, 0);
    } catch(e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't trust the global object when called normally
            return cachedSetTimeout.call(null, fun, 0);
        } catch(e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error
            return cachedSetTimeout.call(this, fun, 0);
        }
    }


}
function runClearTimeout(marker) {
    if (cachedClearTimeout === clearTimeout) {
        //normal enviroments in sane situations
        return clearTimeout(marker);
    }
    // if clearTimeout wasn't available but was latter defined
    if ((cachedClearTimeout === defaultClearTimeout || !cachedClearTimeout) && clearTimeout) {
        cachedClearTimeout = clearTimeout;
        return clearTimeout(marker);
    }
    try {
        // when when somebody has screwed with setTimeout but no I.E. maddness
        return cachedClearTimeout(marker);
    } catch (e){
        try {
            // When we are in I.E. but the script has been evaled so I.E. doesn't  trust the global object when called normally
            return cachedClearTimeout.call(null, marker);
        } catch (e){
            // same as above but when it's a version of I.E. that must have the global object for 'this', hopfully our context correct otherwise it will throw a global error.
            // Some versions of I.E. have different rules for clearTimeout vs setTimeout
            return cachedClearTimeout.call(this, marker);
        }
    }



}
var queue = [];
var draining = false;
var currentQueue;
var queueIndex = -1;

function cleanUpNextTick() {
    if (!draining || !currentQueue) {
        return;
    }
    draining = false;
    if (currentQueue.length) {
        queue = currentQueue.concat(queue);
    } else {
        queueIndex = -1;
    }
    if (queue.length) {
        drainQueue();
    }
}

function drainQueue() {
    if (draining) {
        return;
    }
    var timeout = runTimeout(cleanUpNextTick);
    draining = true;

    var len = queue.length;
    while(len) {
        currentQueue = queue;
        queue = [];
        while (++queueIndex < len) {
            if (currentQueue) {
                currentQueue[queueIndex].run();
            }
        }
        queueIndex = -1;
        len = queue.length;
    }
    currentQueue = null;
    draining = false;
    runClearTimeout(timeout);
}

process.nextTick = function (fun) {
    var args = new Array(arguments.length - 1);
    if (arguments.length > 1) {
        for (var i = 1; i < arguments.length; i++) {
            args[i - 1] = arguments[i];
        }
    }
    queue.push(new Item(fun, args));
    if (queue.length === 1 && !draining) {
        runTimeout(drainQueue);
    }
};

// v8 likes predictible objects
function Item(fun, array) {
    this.fun = fun;
    this.array = array;
}
Item.prototype.run = function () {
    this.fun.apply(null, this.array);
};
process.title = 'browser';
process.browser = true;
process.env = {};
process.argv = [];
process.version = ''; // empty string to avoid regexp issues
process.versions = {};

function noop() {}

process.on = noop;
process.addListener = noop;
process.once = noop;
process.off = noop;
process.removeListener = noop;
process.removeAllListeners = noop;
process.emit = noop;
process.prependListener = noop;
process.prependOnceListener = noop;

process.listeners = function (name) { return [] }

process.binding = function (name) {
    throw new Error('process.binding is not supported');
};

process.cwd = function () { return '/' };
process.chdir = function (dir) {
    throw new Error('process.chdir is not supported');
};
process.umask = function() { return 0; };


/***/ }),

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

/***/ "./resources/js/app.js":
/*!*****************************!*\
  !*** ./resources/js/app.js ***!
  \*****************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

window.axios = __webpack_require__(/*! axios */ "./node_modules/axios/index.js");
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.Swal = __webpack_require__(/*! sweetalert2 */ "./node_modules/sweetalert2/dist/sweetalert2.all.js");
window.$R = __webpack_require__(/*! ../plugins/redactor/redactor */ "./resources/plugins/redactor/redactor.js");

__webpack_require__(/*! ../plugins/redactor/plugins/alignment/alignment */ "./resources/plugins/redactor/plugins/alignment/alignment.js"); //


__webpack_require__(/*! ../theme/js/app */ "./resources/theme/js/app.js"); // require('../theme/js/vendor');

/***/ }),

/***/ "./resources/plugins/redactor/plugins/alignment/alignment.js":
/*!*******************************************************************!*\
  !*** ./resources/plugins/redactor/plugins/alignment/alignment.js ***!
  \*******************************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

(function ($R) {
  $R.add('plugin', 'alignment', {
    translations: {
      en: {
        "align": "Align",
        "align-left": "Align Left",
        "align-center": "Align Center",
        "align-right": "Align Right",
        "align-justify": "Align Justify"
      }
    },
    init: function init(app) {
      this.app = app;
      this.opts = app.opts;
      this.lang = app.lang;
      this.block = app.block;
      this.toolbar = app.toolbar;
    },
    // public
    start: function start() {
      var dropdown = {};
      dropdown.left = {
        title: this.lang.get('align-left'),
        api: 'plugin.alignment.set',
        args: 'left'
      };
      dropdown.center = {
        title: this.lang.get('align-center'),
        api: 'plugin.alignment.set',
        args: 'center'
      };
      dropdown.right = {
        title: this.lang.get('align-right'),
        api: 'plugin.alignment.set',
        args: 'right'
      };
      dropdown.justify = {
        title: this.lang.get('align-justify'),
        api: 'plugin.alignment.set',
        args: 'justify'
      };
      var $button = this.toolbar.addButton('alignment', {
        title: this.lang.get('align')
      });
      $button.setIcon('<i class="re-icon-alignment"></i>');
      $button.setDropdown(dropdown);
    },
    set: function set(type) {
      if (type === 'left' && this.opts.direction === 'ltr') {
        return this._remove();
      }

      var args = {
        style: {
          'text-align': type
        }
      };
      this.block.toggle(args);
    },
    // private
    _remove: function _remove() {
      this.block.remove({
        style: 'text-align'
      });
    }
  });
})(Redactor);

/***/ }),

/***/ "./resources/plugins/redactor/redactor.js":
/*!************************************************!*\
  !*** ./resources/plugins/redactor/redactor.js ***!
  \************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

/* WEBPACK VAR INJECTION */(function(module) {function _typeof(obj){"@babel/helpers - typeof";if(typeof Symbol==="function"&&typeof Symbol.iterator==="symbol"){_typeof=function _typeof(obj){return typeof obj;};}else{_typeof=function _typeof(obj){return obj&&typeof Symbol==="function"&&obj.constructor===Symbol&&obj!==Symbol.prototype?"symbol":typeof obj;};}return _typeof(obj);}/*
    Redactor
    Version 3.4.6
    Updated: November 17, 2020

    http://imperavi.com/redactor/

    Copyright (c) 2009-2020, Imperavi Ltd.
    License: http://imperavi.com/redactor/license/
*/if(typeof CodeMirror==='undefined'){var CodeMirror=undefined;}if(typeof jQuery==='undefined'){var jQuery=undefined;}(function(){var Ajax={};Ajax.settings={};Ajax.post=function(options){return new AjaxRequest('post',options);};Ajax.get=function(options){return new AjaxRequest('get',options);};var AjaxRequest=function AjaxRequest(method,options){var defaults={method:method,url:'',before:function before(){},success:function success(){},error:function error(){},data:false,async:true,headers:{}};this.p=this.extend(defaults,options);this.p=this.extend(this.p,Ajax.settings);this.p.method=this.p.method.toUpperCase();this.prepareData();this.xhr=new XMLHttpRequest();this.xhr.open(this.p.method,this.p.url,this.p.async);this.setHeaders();var before=typeof this.p.before==='function'?this.p.before(this.xhr):true;if(before!==false){this.send();}};AjaxRequest.prototype={extend:function extend(obj1,obj2){if(obj2)for(var name in obj2){obj1[name]=obj2[name];}return obj1;},prepareData:function prepareData(){if(this.p.method==='POST'&&!this.isFormData())this.p.headers['Content-Type']='application/x-www-form-urlencoded';if(_typeof(this.p.data)==='object'&&!this.isFormData())this.p.data=this.toParams(this.p.data);if(this.p.method==='GET')this.p.url=this.p.data?this.p.url+'?'+this.p.data:this.p.url;},setHeaders:function setHeaders(){this.xhr.setRequestHeader('X-Requested-With',this.p.headers['X-Requested-With']||'XMLHttpRequest');for(var name in this.p.headers){this.xhr.setRequestHeader(name,this.p.headers[name]);}},isFormData:function isFormData(){return typeof window.FormData!=='undefined'&&this.p.data instanceof window.FormData;},isComplete:function isComplete(){return!(this.xhr.status<200||this.xhr.status>=300&&this.xhr.status!==304);},send:function send(){if(this.p.async){this.xhr.onload=this.loaded.bind(this);this.xhr.send(this.p.data);}else{this.xhr.send(this.p.data);this.loaded.call(this);}},loaded:function loaded(){if(this.isComplete()){var response=this.xhr.response;var json=this.parseJson(response);response=json?json:response;if(typeof this.p.success==='function')this.p.success(response,this.xhr);}else{if(typeof this.p.error==='function')this.p.error(this.xhr.statusText);}},parseJson:function parseJson(str){try{var o=JSON.parse(str);if(o&&_typeof(o)==='object'){return o;}}catch(e){}return false;},toParams:function toParams(obj){return Object.keys(obj).map(function(k){return encodeURIComponent(k)+'='+encodeURIComponent(obj[k]);}).join('&');}};var DomCache=[0];var DomExpando='data'+new Date().getTime();var DomHClass='is-hidden';var DomHMClass='is-hidden-mobile';var Dom=function Dom(selector,context){return this.parse(selector,context);};Dom.ready=function(fn){if(document.readyState!=='loading')fn();else document.addEventListener('DOMContentLoaded',fn);};Dom.prototype={get sdom(){return true;},get length(){return this.nodes.length;},parse:function parse(selector,context){var nodes;var reHtmlTest=/^\s*<(\w+|!)[^>]*>/;if(!selector){nodes=[];}else if(selector.sdom){this.nodes=selector.nodes;return selector;}else if(typeof selector!=='string'){if(selector.nodeType&&selector.nodeType===11){nodes=selector.childNodes;}else{nodes=selector.nodeType||selector===window?[selector]:selector;}}else if(reHtmlTest.test(selector)){nodes=this.create(selector);}else{nodes=this._query(selector,context);}this.nodes=this._slice(nodes);},create:function create(html){if(/^<(\w+)\s*\/?>(?:<\/\1>|)$/.test(html)){return[document.createElement(RegExp.$1)];}var elements=[];var container=document.createElement('div');var children=container.childNodes;container.innerHTML=html;for(var i=0,l=children.length;i<l;i++){elements.push(children[i]);}return elements;},// add
add:function add(nodes){this.nodes=this.nodes.concat(this._toArray(nodes));},// get
get:function get(index){return this.nodes[index||0]||false;},getAll:function getAll(){return this.nodes;},eq:function eq(index){return new Dom(this.nodes[index]);},first:function first(){return new Dom(this.nodes[0]);},last:function last(){return new Dom(this.nodes[this.nodes.length-1]);},contents:function contents(){return this.get().childNodes;},// loop
each:function each(callback){var len=this.nodes.length;for(var i=0;i<len;i++){callback.call(this,this.nodes[i].sdom?this.nodes[i].get():this.nodes[i],i);}return this;},// traversing
is:function is(selector){return this.filter(selector).length>0;},filter:function filter(selector){var callback;if(selector===undefined){return this;}else if(typeof selector==='function'){callback=selector;}else{callback=function callback(node){if(selector instanceof Node){return selector===node;}else if(selector&&selector.sdom){return selector.nodes.indexOf(node)!==-1;}else{node.matches=node.matches||node.msMatchesSelector||node.webkitMatchesSelector;return node.nodeType===1?node.matches(selector||'*'):false;}};}return new Dom(this.nodes.filter(callback));},not:function not(filter){return this.filter(function(node){return!new Dom(node).is(filter||true);});},find:function find(selector){var nodes=[];this.each(function(node){var ns=this._query(selector||'*',node);for(var i=0;i<ns.length;i++){nodes.push(ns[i]);}});return new Dom(nodes);},children:function children(selector){var nodes=[];this.each(function(node){if(node.children){var ns=node.children;for(var i=0;i<ns.length;i++){nodes.push(ns[i]);}}});return new Dom(nodes).filter(selector);},parent:function parent(selector){var nodes=[];this.each(function(node){if(node.parentNode)nodes.push(node.parentNode);});return new Dom(nodes).filter(selector);},parents:function parents(selector,context){context=this._getContext(context);var nodes=[];this.each(function(node){var parent=node.parentNode;while(parent&&parent!==context){if(selector){if(new Dom(parent).is(selector)){nodes.push(parent);}}else{nodes.push(parent);}parent=parent.parentNode;}});return new Dom(nodes);},closest:function closest(selector,context){context=this._getContext(context);selector=selector.sdom?selector.get():selector;var nodes=[];var isNode=selector&&selector.nodeType;this.each(function(node){do{if(isNode&&node===selector||new Dom(node).is(selector))return nodes.push(node);}while((node=node.parentNode)&&node!==context);});return new Dom(nodes);},next:function next(selector){return this._getSibling(selector,'nextSibling');},nextElement:function nextElement(selector){return this._getSibling(selector,'nextElementSibling');},prev:function prev(selector){return this._getSibling(selector,'previousSibling');},prevElement:function prevElement(selector){return this._getSibling(selector,'previousElementSibling');},// css
css:function css(name,value){if(value===undefined&&_typeof(name)!=='object'){var node=this.get();if(name==='width'||name==='height'){return node.style?this._getHeightOrWidth(name,node,false)+'px':undefined;}else{return node.style?getComputedStyle(node,null)[name]:undefined;}}// set
return this.each(function(node){var obj={};if(_typeof(name)==='object')obj=name;else obj[name]=value;for(var key in obj){if(node.style)node.style[key]=obj[key];}});},// attr
attr:function attr(name,value,data){data=data?'data-':'';if(value===undefined&&_typeof(name)!=='object'){var node=this.get();if(node&&node.nodeType!==3){return name==='checked'?node.checked:this._getBooleanFromStr(node.getAttribute(data+name));}else return;}// set
return this.each(function(node){var obj={};if(_typeof(name)==='object')obj=name;else obj[name]=value;for(var key in obj){if(node.nodeType!==3){if(key==='checked')node.checked=obj[key];else node.setAttribute(data+key,obj[key]);}}});},data:function data(name,value){if(name===undefined){var reDataAttr=/^data-(.+)$/;var attrs=this.get().attributes;var data={};var replacer=function replacer(g){return g[1].toUpperCase();};for(var key in attrs){if(attrs[key]&&reDataAttr.test(attrs[key].nodeName)){var dataName=attrs[key].nodeName.match(reDataAttr)[1];var val=attrs[key].value;dataName=dataName.replace(/-([a-z])/g,replacer);if(this._isObjectString(val))val=this._toObject(val);else val=this._isNumber(val)?parseFloat(val):this._getBooleanFromStr(val);data[dataName]=val;}}return data;}return this.attr(name,value,true);},val:function val(value){if(value===undefined){var el=this.get();if(el.type&&el.type==='checkbox')return el.checked;else return el.value;}return this.each(function(node){node.value=value;});},removeAttr:function removeAttr(value){return this.each(function(node){var rmAttr=function rmAttr(name){if(node.nodeType!==3)node.removeAttribute(name);};value.split(' ').forEach(rmAttr);});},removeData:function removeData(value){return this.each(function(node){var rmData=function rmData(name){if(node.nodeType!==3)node.removeAttribute('data-'+name);};value.split(' ').forEach(rmData);});},// dataset/dataget
dataset:function dataset(key,value){return this.each(function(node){DomCache[this.dataindex(node)][key]=value;});},dataget:function dataget(key){return DomCache[this.dataindex(this.get())][key];},dataindex:function dataindex(el){var cacheIndex=el[DomExpando];var nextCacheIndex=DomCache.length;if(!cacheIndex){cacheIndex=el[DomExpando]=nextCacheIndex;DomCache[cacheIndex]={};}return cacheIndex;},// class
addClass:function addClass(value){return this._eachClass(value,'add');},removeClass:function removeClass(value){return this._eachClass(value,'remove');},toggleClass:function toggleClass(value){return this._eachClass(value,'toggle');},hasClass:function hasClass(value){return this.nodes.some(function(node){return node.classList?node.classList.contains(value):false;});},// html & text
empty:function empty(){return this.each(function(node){node.innerHTML='';});},html:function html(_html){return _html===undefined?this.get().innerHTML||'':this.empty().append(_html);},text:function text(_text){return _text===undefined?this.get().textContent||'':this.each(function(node){node.textContent=_text;});},// manipulation
after:function after(html){return this._inject(html,function(frag,node){if(typeof frag==='string'){node.insertAdjacentHTML('afterend',frag);}else{if(node.parentNode!==null){for(var i=frag instanceof Node?[frag]:this._toArray(frag).reverse(),s=0;s<i.length;s++){node.parentNode.insertBefore(i[s],node.nextSibling);}}}return node;});},before:function before(html){return this._inject(html,function(frag,node){if(typeof frag==='string'){node.insertAdjacentHTML('beforebegin',frag);}else{var elms=frag instanceof Node?[frag]:this._toArray(frag);for(var i=0;i<elms.length;i++){node.parentNode.insertBefore(elms[i],node);}}return node;});},append:function append(html){return this._inject(html,function(frag,node){if(typeof frag==='string'||typeof frag==='number'){node.insertAdjacentHTML('beforeend',frag);}else{var elms=frag instanceof Node?[frag]:this._toArray(frag);for(var i=0;i<elms.length;i++){node.appendChild(elms[i]);}}return node;});},prepend:function prepend(html){return this._inject(html,function(frag,node){if(typeof frag==='string'||typeof frag==='number'){node.insertAdjacentHTML('afterbegin',frag);}else{var elms=frag instanceof Node?[frag]:this._toArray(frag).reverse();for(var i=0;i<elms.length;i++){node.insertBefore(elms[i],node.firstChild);}}return node;});},wrap:function wrap(html){return this._inject(html,function(frag,node){var wrapper=typeof frag==='string'||typeof frag==='number'?this.create(frag)[0]:frag instanceof Node?frag:this._toArray(frag)[0];if(node.parentNode){node.parentNode.insertBefore(wrapper,node);}wrapper.appendChild(node);return new Dom(wrapper);});},unwrap:function unwrap(){return this.each(function(node){var $node=new Dom(node);return $node.replaceWith($node.contents());});},replaceWith:function replaceWith(html){return this._inject(html,function(frag,node){var docFrag=document.createDocumentFragment();var elms=typeof frag==='string'||typeof frag==='number'?this.create(frag):frag instanceof Node?[frag]:this._toArray(frag);for(var i=0;i<elms.length;i++){docFrag.appendChild(elms[i]);}var result=docFrag.childNodes[0];if(node.parentNode){node.parentNode.replaceChild(docFrag,node);}return result;});},remove:function remove(){return this.each(function(node){if(node.parentNode)node.parentNode.removeChild(node);});},clone:function clone(events){var nodes=[];this.each(function(node){var copy=this._clone(node);if(events)copy=this._cloneEvents(node,copy);nodes.push(copy);});return new Dom(nodes);},// show/hide
show:function show(){return this.each(function(node){if(!node.style||!this._hasDisplayNone(node))return;var target=node.getAttribute('domTargetShow');var isHidden=node.classList?node.classList.contains(DomHClass):false;var isHiddenMobile=node.classList?node.classList.contains(DomHMClass):false;var type;if(isHidden){type=DomHClass;node.classList.remove(DomHClass);}else if(isHiddenMobile){type=DomHMClass;node.classList.remove(DomHMClass);}else{node.style.display=target?target:'block';}if(type)node.setAttribute('domTargetHide',type);node.removeAttribute('domTargetShow');}.bind(this));},hide:function hide(){return this.each(function(node){if(!node.style||this._hasDisplayNone(node))return;var display=node.style.display;var target=node.getAttribute('domTargetHide');if(target===DomHClass){node.classList.add(DomHClass);}else if(target===DomHMClass){node.classList.add(DomHMClass);}else{if(display!=='block')node.setAttribute('domTargetShow',display);node.style.display='none';}node.removeAttribute('domTargetHide');});},// dimensions
scrollTop:function scrollTop(value){var node=this.get();var isWindow=node===window;var isDocument=node.nodeType===9;var el=isDocument?document.scrollingElement||document.body.parentNode||document.body||document.documentElement:node;if(value!==undefined){if(isWindow)window.scrollTo(0,value);else el.scrollTop=value;return;}if(isDocument){return typeof window.pageYOffset!='undefined'?window.pageYOffset:document.documentElement.scrollTop?document.documentElement.scrollTop:document.body.scrollTop?document.body.scrollTop:0;}else{return isWindow?window.pageYOffset:el.scrollTop;}},offset:function offset(){return this._getDim('Offset');},position:function position(){return this._getDim('Position');},width:function width(value,adjust){return this._getSize('width','Width',value,adjust);},height:function height(value,adjust){return this._getSize('height','Height',value,adjust);},outerWidth:function outerWidth(){return this._getInnerOrOuter('width','outer');},outerHeight:function outerHeight(){return this._getInnerOrOuter('height','outer');},innerWidth:function innerWidth(){return this._getInnerOrOuter('width','inner');},innerHeight:function innerHeight(){return this._getInnerOrOuter('height','inner');},// events
click:function click(){return this._triggerEvent('click');},focus:function focus(){return this._triggerEvent('focus');},trigger:function trigger(names){return this.each(function(node){var events=names.split(' ');for(var i=0;i<events.length;i++){var ev;var opts={bubbles:true,cancelable:true};try{ev=new window.CustomEvent(events[i],opts);}catch(e){ev=document.createEvent('CustomEvent');ev.initCustomEvent(events[i],true,true);}node.dispatchEvent(ev);}});},on:function on(names,handler,one){return this.each(function(node){var events=names.split(' ');for(var i=0;i<events.length;i++){var event=this._getEventName(events[i]);var namespace=this._getEventNamespace(events[i]);handler=one?this._getOneHandler(handler,names):handler;node.addEventListener(event,handler);node._e=node._e||{};node._e[namespace]=node._e[namespace]||{};node._e[namespace][event]=node._e[namespace][event]||[];node._e[namespace][event].push(handler);}});},one:function one(events,handler){return this.on(events,handler,true);},off:function off(names,handler){var testEvent=function testEvent(name,key,event){return name===event;};var testNamespace=function testNamespace(name,key,event,namespace){return key===namespace;};var testEventNamespace=function testEventNamespace(name,key,event,namespace){return name===event&&key===namespace;};var testPositive=function testPositive(){return true;};if(names===undefined){// ALL
return this.each(function(node){this._offEvent(node,false,false,handler,testPositive);});}return this.each(function(node){var events=names.split(' ');for(var i=0;i<events.length;i++){var event=this._getEventName(events[i]);var namespace=this._getEventNamespace(events[i]);// 1) event without namespace
if(namespace==='_events')this._offEvent(node,event,namespace,handler,testEvent);// 2) only namespace
else if(!event&&namespace!=='_events')this._offEvent(node,event,namespace,handler,testNamespace);// 3) event + namespace
else this._offEvent(node,event,namespace,handler,testEventNamespace);}});},// form
serialize:function serialize(asObject){var obj={};var elms=this.get().elements;for(var i=0;i<elms.length;i++){var el=elms[i];if(/(checkbox|radio)/.test(el.type)&&!el.checked)continue;if(!el.name||el.disabled||el.type==='file')continue;if(el.type==='select-multiple'){for(var z=0;z<el.options.length;z++){var opt=el.options[z];if(opt.selected)obj[el.name]=opt.value;}}obj[el.name]=this._isNumber(el.value)?parseFloat(el.value):this._getBooleanFromStr(el.value);}return asObject?obj:this._toParams(obj);},ajax:function ajax(success,error){if(typeof AjaxRequest!=='undefined'){var method=this.attr('method')||'post';var options={url:this.attr('action'),data:this.serialize(),success:success,error:error};return new AjaxRequest(method,options);}},// private
_queryContext:function _queryContext(selector,context){context=this._getContext(context);return context.nodeType!==3&&typeof context.querySelectorAll==='function'?context.querySelectorAll(selector):[];},_query:function _query(selector,context){if(context){return this._queryContext(selector,context);}else if(/^[.#]?[\w-]*$/.test(selector)){if(selector[0]==='#'){var element=document.getElementById(selector.slice(1));return element?[element]:[];}if(selector[0]==='.'){return document.getElementsByClassName(selector.slice(1));}return document.getElementsByTagName(selector);}return document.querySelectorAll(selector);},_getContext:function _getContext(context){context=typeof context==='string'?document.querySelector(context):context;return context&&context.sdom?context.get():context||document;},_inject:function _inject(html,fn){var len=this.nodes.length;var nodes=[];while(len--){var res=typeof html==='function'?html.call(this,this.nodes[len]):html;var el=len===0?res:this._clone(res);var node=fn.call(this,el,this.nodes[len]);if(node){if(node.sdom)nodes.push(node.get());else nodes.push(node);}}return new Dom(nodes);},_cloneEvents:function _cloneEvents(node,copy){var events=node._e;if(events){copy._e=events;for(var name in events._events){for(var i=0;i<events._events[name].length;i++){copy.addEventListener(name,events._events[name][i]);}}}return copy;},_clone:function _clone(node){if(typeof node==='undefined')return;if(typeof node==='string')return node;else if(node instanceof Node||node.nodeType)return node.cloneNode(true);else if('length'in node){return[].map.call(this._toArray(node),function(el){return el.cloneNode(true);});}},_slice:function _slice(obj){return!obj||obj.length===0?[]:obj.length?[].slice.call(obj.nodes||obj):[obj];},_eachClass:function _eachClass(value,type){return this.each(function(node){if(value){var setClass=function setClass(name){if(node.classList)node.classList[type](name);};value.split(' ').forEach(setClass);}});},_triggerEvent:function _triggerEvent(name){var node=this.get();if(node&&node.nodeType!==3)node[name]();return this;},_getOneHandler:function _getOneHandler(handler,events){var self=this;return function(){handler.apply(this,arguments);self.off(events);};},_getEventNamespace:function _getEventNamespace(event){var arr=event.split('.');var namespace=arr[1]?arr[1]:'_events';return arr[2]?namespace+arr[2]:namespace;},_getEventName:function _getEventName(event){return event.split('.')[0];},_offEvent:function _offEvent(node,event,namespace,handler,condition){for(var key in node._e){for(var name in node._e[key]){if(condition(name,key,event,namespace)){var handlers=node._e[key][name];for(var i=0;i<handlers.length;i++){if(typeof handler!=='undefined'&&handlers[i].toString()!==handler.toString()){continue;}node.removeEventListener(name,handlers[i]);node._e[key][name].splice(i,1);if(node._e[key][name].length===0)delete node._e[key][name];if(Object.keys(node._e[key]).length===0)delete node._e[key];}}}}},_getInnerOrOuter:function _getInnerOrOuter(method,type){return this[method](undefined,type);},_getDocSize:function _getDocSize(node,type){var body=node.body,html=node.documentElement;return Math.max(body['scroll'+type],body['offset'+type],html['client'+type],html['scroll'+type],html['offset'+type]);},_getSize:function _getSize(type,captype,value,adjust){if(value===undefined){var el=this.get();if(el.nodeType===3)value=0;else if(el.nodeType===9)value=this._getDocSize(el,captype);else if(el===window)value=window['inner'+captype];else value=this._getHeightOrWidth(type,el,adjust||'normal');return Math.round(value);}return this.each(function(node){value=parseFloat(value);value=value+this._adjustResultHeightOrWidth(type,node,adjust||'normal');new Dom(node).css(type,value+'px');}.bind(this));},_getHeightOrWidth:function _getHeightOrWidth(type,el,adjust){if(!el)return 0;var name=type.charAt(0).toUpperCase()+type.slice(1);var result=0;var style=getComputedStyle(el,null);var $el=new Dom(el);var $targets=$el.parents().filter(function(node){return node.nodeType===1&&getComputedStyle(node,null).display==='none'?node:false;});if(style.display==='none')$targets.add(el);if($targets.length!==0){var fixStyle='visibility: hidden !important; display: block !important;';var tmp=[];$targets.each(function(node){var $node=new Dom(node);var thisStyle=$node.attr('style');if(thisStyle!==null)tmp.push(thisStyle);$node.attr('style',thisStyle!==null?thisStyle+';'+fixStyle:fixStyle);});result=$el.get()['offset'+name]-this._adjustResultHeightOrWidth(type,el,adjust);$targets.each(function(node,i){var $node=new Dom(node);if(tmp[i]===undefined)$node.removeAttr('style');else $node.attr('style',tmp[i]);});}else{result=el['offset'+name]-this._adjustResultHeightOrWidth(type,el,adjust);}return result;},_adjustResultHeightOrWidth:function _adjustResultHeightOrWidth(type,el,adjust){if(!el||adjust===false)return 0;var fix=0;var style=getComputedStyle(el,null);var isBorderBox=style.boxSizing==="border-box";if(type==='height'){if(adjust==='inner'||adjust==='normal'&&isBorderBox){fix+=(parseFloat(style.borderTopWidth)||0)+(parseFloat(style.borderBottomWidth)||0);}if(adjust==='outer')fix-=(parseFloat(style.marginTop)||0)+(parseFloat(style.marginBottom)||0);}else{if(adjust==='inner'||adjust==='normal'&&isBorderBox){fix+=(parseFloat(style.borderLeftWidth)||0)+(parseFloat(style.borderRightWidth)||0);}if(adjust==='outer')fix-=(parseFloat(style.marginLeft)||0)+(parseFloat(style.marginRight)||0);}return fix;},_getDim:function _getDim(type){var node=this.get();return node.nodeType===3?{top:0,left:0}:this['_get'+type](node);},_getPosition:function _getPosition(node){return{top:node.offsetTop,left:node.offsetLeft};},_getOffset:function _getOffset(node){var rect=node.getBoundingClientRect();var doc=node.ownerDocument;var docElem=doc.documentElement;var win=doc.defaultView;return{top:rect.top+win.pageYOffset-docElem.clientTop,left:rect.left+win.pageXOffset-docElem.clientLeft};},_getSibling:function _getSibling(selector,method){selector=selector&&selector.sdom?selector.get():selector;var isNode=selector&&selector.nodeType;var sibling;this.each(function(node){while(node=node[method]){if(isNode&&node===selector||new Dom(node).is(selector)){sibling=node;return;}}});return new Dom(sibling);},_toArray:function _toArray(obj){if(obj instanceof NodeList){var arr=[];for(var i=0;i<obj.length;i++){arr[i]=obj[i];}return arr;}else if(obj===undefined)return[];else{return obj.sdom?obj.nodes:obj;}},_toParams:function _toParams(obj){var params='';for(var key in obj){params+='&'+this._encodeUri(key)+'='+this._encodeUri(obj[key]);}return params.replace(/^&/,'');},_toObject:function _toObject(str){return new Function("return "+str)();},_encodeUri:function _encodeUri(str){return encodeURIComponent(str).replace(/!/g,'%21').replace(/'/g,'%27').replace(/\(/g,'%28').replace(/\)/g,'%29').replace(/\*/g,'%2A').replace(/%20/g,'+');},_isNumber:function _isNumber(str){return!isNaN(str)&&!isNaN(parseFloat(str));},_isObjectString:function _isObjectString(str){return str.search(/^{/)!==-1;},_getBooleanFromStr:function _getBooleanFromStr(str){if(str==='true')return true;else if(str==='false')return false;return str;},_hasDisplayNone:function _hasDisplayNone(el){return el.style.display==='none'||(el.currentStyle?el.currentStyle.display:getComputedStyle(el,null).display)==='none';}};// Unique ID
var uuid=0;// Wrapper
var $R=function $R(selector,options){return RedactorApp(selector,options,[].slice.call(arguments,2));};// Globals
$R.app=[];$R.version='3.4.6';$R.options={};$R.modules={};$R.services={};$R.classes={};$R.plugins={};$R.mixins={};$R.modals={};$R.lang={};$R.dom=function(selector,context){return new Dom(selector,context);};$R.ajax=Ajax;$R.Dom=Dom;$R.keycodes={BACKSPACE:8,DELETE:46,UP:38,DOWN:40,ENTER:13,SPACE:32,ESC:27,TAB:9,CTRL:17,META:91,SHIFT:16,ALT:18,RIGHT:39,LEFT:37};$R.env={'plugin':'plugins','module':'modules','service':'services','class':'classes','mixin':'mixins'};// jQuery Wrapper
/*eslint-env jquery*/if(typeof jQuery!=='undefined'){(function($){$.fn.redactor=function(options){return RedactorApp(this.toArray(),options,[].slice.call(arguments,1));};})(jQuery);}// Class
var RedactorApp=function RedactorApp(selector,options,args){var namespace='redactor';var nodes=Array.isArray(selector)?selector:selector&&selector.nodeType?[selector]:document.querySelectorAll(selector);var isApi=typeof options==='string'||typeof options==='function';var value=[];var instance;for(var i=0;i<nodes.length;i++){var el=nodes[i];var $el=$R.dom(el);instance=$el.dataget(namespace);if(!instance&&!isApi){// Initialization
instance=new App(el,options,uuid);$el.dataset(namespace,instance);$R.app[uuid]=instance;uuid++;}// API
if(instance&&isApi){var isDestroy=options==='destroy';options=isDestroy?'stop':options;var methodValue;if(typeof options==='function'){methodValue=options.apply(instance,args);}else{args.unshift(options);methodValue=instance.api.apply(instance,args);}if(methodValue!==undefined)value.push(methodValue);if(isDestroy)$el.dataset(namespace,false);}}return value.length===0||value.length===1?value.length===0?instance:value[0]:value;};// add
$R.add=function(type,name,obj){if(typeof $R.env[type]==='undefined')return;// translations
if(obj.translations){$R.lang=$R.extend(true,{},$R.lang,obj.translations);}// modals
if(obj.modals){$R.modals=$R.extend(true,{},$R.modals,obj.modals);}// mixin
if(type==='mixin'){$R[$R.env[type]][name]=obj;}else{// prototype
var F=function F(){};F.prototype=obj;// mixins
if(obj.mixins){for(var i=0;i<obj.mixins.length;i++){$R.inherit(F,$R.mixins[obj.mixins[i]]);}}$R[$R.env[type]][name]=F;}};// add lang
$R.addLang=function(lang,obj){if(typeof $R.lang[lang]==='undefined'){$R.lang[lang]={};}$R.lang[lang]=$R.extend($R.lang[lang],obj);};// create
$R.create=function(name){var arr=name.split('.');var args=[].slice.call(arguments,1);var type='classes';if(typeof $R.env[arr[0]]!=='undefined'){type=$R.env[arr[0]];name=arr.slice(1).join('.');}// construct
var instance=new $R[type][name]();// init
if(instance.init){var res=instance.init.apply(instance,args);return res?res:instance;}return instance;};// inherit
$R.inherit=function(current,parent){var F=function F(){};F.prototype=parent;var f=new F();for(var prop in current.prototype){if(current.prototype.__lookupGetter__(prop))f.__defineGetter__(prop,current.prototype.__lookupGetter__(prop));else f[prop]=current.prototype[prop];}current.prototype=f;current.prototype["super"]=parent;return current;};// error
$R.error=function(exception){throw exception;};// extend
$R.extend=function(){var extended={};var deep=false;var i=0;var length=arguments.length;if(Object.prototype.toString.call(arguments[0])==='[object Boolean]'){deep=arguments[0];i++;}var merge=function merge(obj){for(var prop in obj){if(Object.prototype.hasOwnProperty.call(obj,prop)){if(deep&&Object.prototype.toString.call(obj[prop])==='[object Object]')extended[prop]=$R.extend(true,extended[prop],obj[prop]);else extended[prop]=obj[prop];}}};for(;i<length;i++){var obj=arguments[i];merge(obj);}return extended;};$R.opts={animation:true,lang:'en',direction:'ltr',spellcheck:true,structure:false,scrollTarget:false,styles:true,stylesClass:'redactor-styles',placeholder:false,source:true,showSource:false,inline:false,breakline:false,markup:'p',enterKey:true,clickToEdit:false,clickToSave:false,clickToCancel:false,focus:false,focusEnd:false,minHeight:false,// string, '100px'
maxHeight:false,// string, '100px'
maxWidth:false,// string, '700px'
plugins:[],// array
callbacks:{},// pre & tab
preClass:false,// string
preSpaces:4,// or false
tabindex:false,// int
tabAsSpaces:false,// true or number of spaces
tabKey:true,// autosave
autosave:false,// false or url
autosaveName:false,autosaveData:false,// toolbar
toolbar:true,toolbarFixed:true,toolbarFixedTarget:document,toolbarFixedTopOffset:0,// pixels
toolbarExternal:false,// ID selector
toolbarContext:true,// air
air:false,// formatting
formatting:['p','blockquote','pre','h1','h2','h3','h4','h5','h6'],formattingAdd:false,formattingHide:false,// buttons
buttons:['html','format','bold','italic','deleted','lists','image','file','link'],// + 'line', 'redo', 'undo', 'underline', 'ol', 'ul', 'indent', 'outdent'
buttonsTextLabeled:false,buttonsAdd:[],buttonsAddFirst:[],buttonsAddAfter:false,buttonsAddBefore:false,buttonsHide:[],buttonsHideOnMobile:[],// image
imageUpload:false,imageUploadParam:'file',imageData:false,imageEditable:true,imageCaption:true,imageLink:true,imagePosition:false,imageResizable:false,imageFloatMargin:'10px',imageFigure:true,imageObserve:true,imageSrcData:false,// file
fileUpload:false,fileUploadParam:'file',fileData:false,fileAttachment:false,// upload opts
uploadData:false,dragUpload:true,multipleUpload:true,clipboardUpload:true,uploadBase64:false,// link
linkTarget:false,linkTitle:false,linkNewTab:true,linkNofollow:false,linkSize:30,linkValidation:true,// clean
cleanOnEnter:true,cleanInlineOnEnter:false,paragraphize:true,removeScript:true,removeNewLines:false,removeComments:true,replaceTags:{'b':'strong','i':'em','strike':'del'},// paste
pastePlainText:false,pasteLinkTarget:false,pasteImages:true,pasteLinks:true,pasteClean:true,pasteKeepStyle:[],pasteKeepClass:[],pasteKeepAttrs:['td','th'],pasteBlockTags:['pre','h1','h2','h3','h4','h5','h6','table','tbody','thead','tfoot','th','tr','td','ul','ol','li','blockquote','p','figure','figcaption'],pasteInlineTags:['a','img','br','strong','ins','code','del','span','samp','kbd','sup','sub','mark','var','cite','small','b','u','em','i','abbr'],// active buttons
activeButtons:{b:'bold',strong:'bold',i:'italic',em:'italic',del:'deleted',strike:'deleted',u:'underline'},activeButtonsAdd:{},activeButtonsObservers:{},// autoparser
autoparse:true,autoparseStart:true,autoparsePaste:true,autoparseLinks:true,autoparseImages:true,autoparseVideo:true,// shortcodes
shortcodes:{'p.':{format:'p'},'quote.':{format:'blockquote'},'pre.':{format:'pre'},'h1.':{format:'h1'},'h2.':{format:'h2'},'h3.':{format:'h3'},'h4.':{format:'h4'},'h5.':{format:'h5'},'h6.':{format:'h6'},//'1.': { format: 'ol' },
'*.':{format:'ul'}},shortcodesAdd:false,// object
// shortcuts
shortcuts:{'ctrl+shift+m, meta+shift+m':{api:'module.inline.clearformat'},'ctrl+b, meta+b':{api:'module.inline.format',args:'b'},'ctrl+i, meta+i':{api:'module.inline.format',args:'i'},'ctrl+u, meta+u':{api:'module.inline.format',args:'u'},'ctrl+h, meta+h':{api:'module.inline.format',args:'sup'},'ctrl+l, meta+l':{api:'module.inline.format',args:'sub'},'ctrl+k, meta+k':{api:'module.link.open'},'ctrl+alt+0, meta+alt+0':{api:'module.block.format',args:'p'},'ctrl+alt+1, meta+alt+1':{api:'module.block.format',args:'h1'},'ctrl+alt+2, meta+alt+2':{api:'module.block.format',args:'h2'},'ctrl+alt+3, meta+alt+3':{api:'module.block.format',args:'h3'},'ctrl+alt+4, meta+alt+4':{api:'module.block.format',args:'h4'},'ctrl+alt+5, meta+alt+5':{api:'module.block.format',args:'h5'},'ctrl+alt+6, meta+alt+6':{api:'module.block.format',args:'h6'},'ctrl+shift+7, meta+shift+7':{api:'module.list.toggle',args:'ol'},'ctrl+shift+8, meta+shift+8':{api:'module.list.toggle',args:'ul'}},shortcutsAdd:false,// object
// misc
grammarly:true,notranslate:false,// private
bufferLimit:100,emptyHtml:'<p></p>',markerChar:"\uFEFF",imageTypes:['image/png','image/jpeg','image/gif'],imageAttrs:['alt','title','src','class','width','height','srcset'],inlineTags:['a','span','strong','strike','b','u','em','i','code','del','ins','samp','kbd','sup','sub','mark','var','cite','small','abbr'],blockTags:['pre','ul','ol','li','p','h1','h2','h3','h4','h5','h6','dl','dt','dd','div','table','tbody','thead','tfoot','tr','th','td','blockquote','output','figcaption','figure','address','section','header','footer','aside','article','iframe'],regex:{youtube:/https?:\/\/(?:[0-9A-Z-]+\.)?(?:youtu\.be\/|youtube\.com\S*[^\w-\s])([\w-]{11})(?=[^\w-]|$)(?![?=&+%\w.-]*(?:['"][^<>]*>|<\/a>))[?=&+%\w.-]*/gi,vimeo:/(http|https)?:\/\/(?:www.|player.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/(?:[^/]*)\/videos\/|album\/(?:\d+)\/video\/|video\/|)(\d+)(?:\/[a-zA-Z0-9_-]+)?/gi,imageurl:/((https?|www)[^\s]+\.)(jpe?g|png|gif)(\?[^\s-]+)?/gi,url:/https?:\/\/(www\.)?[-a-zA-Z0-9@:%._+~#=]{1,256}\.[a-zA-Z0-9()]{1,6}\b([-a-zA-Z0-9()@:%_+.~#?&//=]*)/gi},input:true,zindex:false,modes:{"inline":{pastePlainText:true,pasteImages:false,enterKey:false,toolbar:false,autoparse:false,source:false,showSource:false,styles:false,air:false},"original":{styles:false}}};$R.lang['en']={"format":"Format","image":"Image","file":"File","link":"Link","bold":"Bold","italic":"Italic","deleted":"Strikethrough","underline":"Underline","superscript":"Superscript","subscript":"Subscript","bold-abbr":"B","italic-abbr":"I","deleted-abbr":"S","underline-abbr":"U","superscript-abbr":"Sup","subscript-abbr":"Sub","lists":"Lists","link-insert":"Insert Link","link-edit":"Edit Link","link-in-new-tab":"Open link in new tab","unlink":"Unlink","cancel":"Cancel","close":"Close","insert":"Insert","save":"Save","delete":"Delete","text":"Text","edit":"Edit","title":"Alt","paragraph":"Normal text","quote":"Quote","code":"Code","heading1":"Heading 1","heading2":"Heading 2","heading3":"Heading 3","heading4":"Heading 4","heading5":"Heading 5","heading6":"Heading 6","filename":"Name","optional":"optional","unorderedlist":"Unordered List","orderedlist":"Ordered List","outdent":"Outdent","indent":"Indent","horizontalrule":"Line","upload":"Upload","upload-label":"Drop files here or click to upload","accessibility-help-label":"Rich text editor","caption":"Caption","bulletslist":"Bullets","numberslist":"Numbers","image-position":"Position","none":"None","left":"Left","right":"Right","center":"Center","undo":"Undo","redo":"Redo"};$R.buttons={html:{title:'HTML',icon:true,api:'module.source.toggle'},undo:{title:'## undo ##',icon:true,api:'module.buffer.undo'},redo:{title:'## redo ##',icon:true,api:'module.buffer.redo'},format:{title:'## format ##',icon:true,dropdown:{p:{title:'## paragraph ##',api:'module.block.format',args:{tag:'p'}},blockquote:{title:'## quote ##',api:'module.block.format',args:{tag:'blockquote'}},pre:{title:'## code ##',api:'module.block.format',args:{tag:'pre'}},h1:{title:'## heading1 ##',api:'module.block.format',args:{tag:'h1'}},h2:{title:'## heading2 ##',api:'module.block.format',args:{tag:'h2'}},h3:{title:'## heading3 ##',api:'module.block.format',args:{tag:'h3'}},h4:{title:'## heading4 ##',api:'module.block.format',args:{tag:'h4'}},h5:{title:'## heading5 ##',api:'module.block.format',args:{tag:'h5'}},h6:{title:'## heading6 ##',api:'module.block.format',args:{tag:'h6'}}}},bold:{title:'## bold-abbr ##',icon:true,tooltip:'## bold ##',api:'module.inline.format',args:{tag:'b'}},italic:{title:'## italic-abbr ##',icon:true,tooltip:'## italic ##',api:'module.inline.format',args:{tag:'i'}},deleted:{title:'## deleted-abbr ##',icon:true,tooltip:'## deleted ##',api:'module.inline.format',args:{tag:'del'}},underline:{title:'## underline-abbr ##',icon:true,tooltip:'## underline ##',api:'module.inline.format',args:{tag:'u'}},sup:{title:'## superscript-abbr ##',icon:true,tooltip:'## superscript ##',api:'module.inline.format',args:{tag:'sup'}},sub:{title:'## subscript-abbr ##',icon:true,tooltip:'## subscript ##',api:'module.inline.format',args:{tag:'sub'}},lists:{title:'## lists ##',icon:true,observe:'list',dropdown:{observe:'list',unorderedlist:{title:'&bull; ## unorderedlist ##',api:'module.list.toggle',args:'ul'},orderedlist:{title:'1. ## orderedlist ##',api:'module.list.toggle',args:'ol'},outdent:{title:'< ## outdent ##',api:'module.list.outdent'},indent:{title:'> ## indent ##',api:'module.list.indent'}}},ul:{title:'&bull; ## bulletslist ##',icon:true,api:'module.list.toggle',observe:'list',args:'ul'},ol:{title:'1. ## numberslist ##',icon:true,api:'module.list.toggle',observe:'list',args:'ol'},outdent:{title:'## outdent ##',icon:true,api:'module.list.outdent',observe:'list'},indent:{title:'## indent ##',icon:true,api:'module.list.indent',observe:'list'},image:{title:'## image ##',icon:true,api:'module.image.open'},file:{title:'## file ##',icon:true,api:'module.file.open'},link:{title:'## link ##',icon:true,observe:'link',dropdown:{observe:'link',link:{title:'## link-insert ##',api:'module.link.open'},unlink:{title:'## unlink ##',api:'module.link.unlink'}}},line:{title:'## horizontalrule ##',icon:true,api:'module.line.insert'}};var App=function App(element,options,uuid){this.module={};this.plugin={};this.instances={};// start/stop
this.started=false;this.stopped=false;// environment
this.uuid=uuid;this.rootElement=element;this.rootOpts=options;this.dragInside=false;this.dragComponentInside=false;this.keycodes=$R.keycodes;this.namespace='redactor';this.$win=$R.dom(window);this.$doc=$R.dom(document);this.$body=$R.dom('body');this.editorReadOnly=false;// core services
this.opts=$R.create('service.options',options,element);this.lang=$R.create('service.lang',this);// build
this.buildServices();this.buildModules();this.buildPlugins();// start
this.start();};App.prototype={start:function start(){// start
this.stopped=false;this.broadcast('start');this.broadcast('startcode');if(this.opts.clickToEdit){this.broadcast('startclicktoedit');}else{this.broadcast('enable');if(this.opts.showSource)this.broadcast('startcodeshow');this.broadcast('enablefocus');}// started
this.broadcast('started');this.started=true;},stop:function stop(){this.started=false;this.stopped=true;this.broadcast('stop');this.broadcast('disable');this.broadcast('stopped');},// started & stopped
isStarted:function isStarted(){return this.started;},isStopped:function isStopped(){return this.stopped;},// build
buildServices:function buildServices(){var core=['options','lang'];var bindable=['uuid','keycodes','opts','lang','$win','$doc','$body'];var services=[];for(var name in $R.services){if(core.indexOf(name)===-1){this[name]=$R.create('service.'+name,this);services.push(name);bindable.push(name);}}// binding
for(var i=0;i<services.length;i++){var service=services[i];for(var z=0;z<bindable.length;z++){var inj=bindable[z];if(service!==inj){this[service][inj]=this[inj];}}}},buildModules:function buildModules(){for(var name in $R.modules){this.module[name]=$R.create('module.'+name,this);this.instances[name]=this.module[name];}},buildPlugins:function buildPlugins(){var plugins=this.opts.plugins;for(var i=0;i<plugins.length;i++){var name=plugins[i];if(typeof $R.plugins[name]!=='undefined'){this.plugin[name]=$R.create('plugin.'+name,this);this.instances[name]=this.plugin[name];}}},// draginside
isDragInside:function isDragInside(){return this.dragInside;},setDragInside:function setDragInside(dragInside){this.dragInside=dragInside;},isDragComponentInside:function isDragComponentInside(){return this.dragComponentInside;},setDragComponentInside:function setDragComponentInside(dragInside){this.dragComponentInside=dragInside;},getDragComponentInside:function getDragComponentInside(){return this.dragComponentInside;},// readonly
isReadOnly:function isReadOnly(){return this.editorReadOnly;},enableReadOnly:function enableReadOnly(){this.editorReadOnly=true;this.broadcast('enablereadonly');this.component.clearActive();this.toolbar.disableButtons();},disableReadOnly:function disableReadOnly(){this.editorReadOnly=false;this.broadcast('disablereadonly');this.toolbar.enableButtons();},// messaging
callMessageHandler:function callMessageHandler(instance,name,args){var arr=name.split('.');var value;if(arr.length===1){if(typeof instance['on'+name]==='function'){value=instance['on'+name].apply(instance,args);}}else{arr[0]='on'+arr[0];var func=this.utils.checkProperty(instance,arr);if(typeof func==='function'){value=func.apply(instance,args);}}return value;},broadcast:function broadcast(name){var args=[].slice.call(arguments,1);var returned;for(var moduleName in this.instances){var value=this.callMessageHandler(this.instances[moduleName],name,args);if(typeof value!=='undefined'){returned=value;}}// callback
var cval=this.callback.trigger(name,args);return typeof returned!=='undefined'?returned:cval;},// callback
on:function on(name,func){this.callback.add(name,func);},off:function off(name,func){this.callback.remove(name,func);},// api
api:function api(name){if(!this.isStarted()&&name!=='start')return;if(this.isReadOnly()&&name!=='disableReadOnly')return;this.broadcast('state');var args=[].slice.call(arguments,1);var arr=name.split('.');var isApp=arr.length===1;var isCallback=arr[0]==='on'||arr[0]==='off';var isService=!isCallback&&arr.length===2;var isPlugin=arr[0]==='plugin';var isModule=arr[0]==='module';// app
if(isApp){if(typeof this[arr[0]]==='function'){return this.callInstanceMethod(this,arr[0],args);}}// callback
else if(isCallback){return arr[0]==='on'?this.on(arr[1],args[0]):this.off(arr[1],args[0]||undefined);}// service
else if(isService){if(this.isInstanceExists(this,arr[0])){return this.callInstanceMethod(this[arr[0]],arr[1],args);}else{$R.error(new Error('Service "'+arr[0]+'" not found'));}}// plugin
else if(isPlugin){if(this.isInstanceExists(this.plugin,arr[1])){return this.callInstanceMethod(this.plugin[arr[1]],arr[2],args);}else{$R.error(new Error('Plugin "'+arr[1]+'" not found'));}}// module
else if(isModule){if(this.isInstanceExists(this.module,arr[1])){return this.callInstanceMethod(this.module[arr[1]],arr[2],args);}else{$R.error(new Error('Module "'+arr[1]+'" not found'));}}},isInstanceExists:function isInstanceExists(obj,name){return typeof obj[name]!=='undefined';},callInstanceMethod:function callInstanceMethod(instance,method,args){if(typeof instance[method]==='function'){return instance[method].apply(instance,args);}}};$R.add('mixin','formatter',{// public
buildArgs:function buildArgs(args){this.args={'class':args['class']||false,'style':args['style']||false,'attr':args['attr']||false};if(!this.args['class']&&!this.args['style']&&!this.args['attr']){this.args=false;}},applyArgs:function applyArgs(nodes,selection){if(this.args){nodes=this[this.type](this.args,false,nodes,selection);}else{nodes=this._clearAll(nodes,selection);}return nodes;},clearClass:function clearClass(tags,nodes){this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags,true);$elements.removeAttr('class');nodes=this._unwrapSpanWithoutAttr($elements.getAll());this.selection.restore();return nodes;},clearStyle:function clearStyle(tags,nodes){this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags,true);$elements.removeAttr('style');nodes=this._unwrapSpanWithoutAttr($elements.getAll());this.selection.restore();return nodes;},clearAttr:function clearAttr(tags,nodes){this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags,true);this._removeAllAttr($elements);nodes=this._unwrapSpanWithoutAttr($elements.getAll());this.selection.restore();return nodes;},set:function set(args,tags,nodes,selection){if(selection!==false)this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags);if(args['class']){$elements.removeAttr('class');$elements.addClass(args['class']);}if(args['style']){$elements.removeAttr('style');$elements.css(args['style']);$elements.each(function(node){var $node=$R.dom(node);$node.attr('data-redactor-style-cache',$node.attr('style'));});}if(args['attr']){this._removeAllAttr($elements);$elements.attr(args['attr']);}if(selection!==false)this.selection.restore();return $elements.getAll();},toggle:function toggle(args,tags,nodes,selection){if(selection!==false)this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags);if(args['class']){$elements.toggleClass(args['class']);$elements.each(function(node){if(node.className==='')node.removeAttribute('class');});}var params;if(args['style']){params=args['style'];$elements.each(function(node){var $node=$R.dom(node);for(var key in params){var newVal=params[key];var oldVal=$node.css(key);oldVal=this.utils.isRgb(oldVal)?this.utils.rgb2hex(oldVal):oldVal.replace(/"/g,'');newVal=this.utils.isRgb(newVal)?this.utils.rgb2hex(newVal):newVal.replace(/"/g,'');oldVal=this.utils.hex2long(oldVal);newVal=this.utils.hex2long(newVal);var compareNew=typeof newVal==='string'?newVal.toLowerCase():newVal;var compareOld=typeof oldVal==='string'?oldVal.toLowerCase():oldVal;if(compareNew===compareOld)$node.css(key,'');else $node.css(key,newVal);}this._convertStyleQuotes($node);if(this.utils.removeEmptyAttr(node,'style')){$node.removeAttr('data-redactor-style-cache');}else{$node.attr('data-redactor-style-cache',$node.attr('style'));}}.bind(this));}if(args['attr']){params=args['attr'];$elements.each(function(node){var $node=$R.dom(node);for(var key in params){if($node.attr(key))$node.removeAttr(key);else $node.attr(key,params[key]);}});}if(selection!==false)this.selection.restore();return $elements.getAll();},add:function add(args,tags,nodes,selection){if(selection!==false)this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags);if(args['class']){$elements.addClass(args['class']);}if(args['style']){var params=args['style'];$elements.each(function(node){var $node=$R.dom(node);$node.css(params);$node.attr('data-redactor-style-cache',$node.attr('style'));this._convertStyleQuotes($node);}.bind(this));}if(args['attr']){$elements.attr(args['attr']);}if(selection!==false)this.selection.restore();return $elements.getAll();},remove:function remove(args,tags,nodes,selection){if(selection!==false)this.selection.save();var $elements=nodes?$R.dom(nodes):this.getElements(tags);if(args['class']){$elements.removeClass(args['class']);$elements.each(function(node){if(node.className==='')node.removeAttribute('class');});}if(args['style']){var name=args['style'];$elements.each(function(node){var $node=$R.dom(node);$node.css(name,'');if(this.utils.removeEmptyAttr(node,'style')){$node.removeAttr('data-redactor-style-cache');}else{$node.attr('data-redactor-style-cache',$node.attr('style'));}}.bind(this));}if(args['attr']){$elements.removeAttr(args['attr']);}nodes=this._unwrapSpanWithoutAttr($elements.getAll());if(selection!==false)this.selection.restore();return nodes;},// private
_removeAllAttr:function _removeAllAttr($elements){$elements.each(function(node){for(var i=node.attributes.length;i-->0;){var nodeAttr=node.attributes[i];var name=nodeAttr.name;if(name!=='style'&&name!=='class'){node.removeAttributeNode(nodeAttr);}}});},_convertStyleQuotes:function _convertStyleQuotes($node){var style=$node.attr('style');if(style)$node.attr('style',style.replace(/"/g,'\''));},_clearAll:function _clearAll(nodes,selection){if(selection!==false)this.selection.save();for(var i=0;i<nodes.length;i++){var node=nodes[i];while(node.attributes.length>0){node.removeAttribute(node.attributes[0].name);}}nodes=this._unwrapSpanWithoutAttr(nodes);if(selection!==false)this.selection.restore();return nodes;},_unwrapSpanWithoutAttr:function _unwrapSpanWithoutAttr(nodes){var finalNodes=[];for(var i=0;i<nodes.length;i++){var node=nodes[i];var len=node.attributes.length;if(len<=0&&node.nodeType!==3&&node.tagName==='SPAN'){$R.dom(node).unwrap();}else{finalNodes.push(node);}}return finalNodes;}});$R.add('mixin','dom',$R.Dom.prototype);$R.add('mixin','component',{get cmnt(){return true;}});$R.add('service','options',{init:function init(options,element){var $el=$R.dom(element);var opts=$R.extend({},$R.opts,element?$el.data():{},$R.options);opts=$R.extend(true,opts,options);return opts;}});$R.add('service','lang',{init:function init(app){this.app=app;this.opts=app.opts;// build
this.vars=this._build(this.opts.lang);},// public
rebuild:function rebuild(lang){this.opts.lang=lang;this.vars=this._build(lang);},extend:function extend(obj){this.vars=$R.extend(this.vars,obj);},parse:function parse(str){if(str===undefined){return'';}var matches=str.match(/## (.*?) ##/g);if(matches){for(var i=0;i<matches.length;i++){var key=matches[i].replace(/^##\s/g,'').replace(/\s##$/g,'');str=str.replace(matches[i],this.get(key));}}return str;},get:function get(name){var str='';if(typeof this.vars[name]!=='undefined'){str=this.vars[name];}else if(this.opts.lang!=='en'&&typeof $R.lang['en'][name]!=='undefined'){str=$R.lang['en'][name];}return str;},// private
_build:function _build(lang){var vars=$R.lang['en'];if(lang!=='en'){vars=$R.lang[lang]!==undefined?$R.lang[lang]:vars;}return vars;}});$R.add('service','callback',{init:function init(app){this.app=app;this.opts=app.opts;// local
this.callbacks={};// build
if(this.opts.callbacks){this._set(this.opts.callbacks,'');}},stop:function stop(){this.callbacks={};},add:function add(name,handler){if(!this.callbacks[name])this.callbacks[name]=[];this.callbacks[name].push(handler);},remove:function remove(name,handler){if(handler===undefined){delete this.callbacks[name];}else{for(var i=0;i<this.callbacks[name].length;i++){this.callbacks[name].splice(i,1);}if(Object.keys(this.callbacks[name]).length===0)delete this.callbacks[name];}},trigger:function trigger(name,args){var value=this._loop(name,args,this.callbacks);return typeof value==='undefined'&&args&&args[0]!==false?args[0]:value;},// private
_set:function _set(obj,name){for(var key in obj){var path=name===''?key:name+'.'+key;if(_typeof(obj[key])==='object'){this._set(obj[key],path);}else{this.callbacks[path]=[];this.callbacks[path].push(obj[key]);}}},_loop:function _loop(name,args,obj){var value;for(var key in obj){if(name===key){for(var i=0;i<obj[key].length;i++){value=obj[key][i].apply(this.app,args);}}}return value;}});$R.add('service','animate',{init:function init(app){this.animationOpt=app.opts.animation;},start:function start(element,animation,options,callback){var defaults={duration:false,iterate:false,delay:false,timing:false,prefix:'redactor-'};defaults=typeof options==='function'?defaults:$R.extend(defaults,options);callback=typeof options==='function'?options:callback;// play
return new $R.AnimatePlay(element,animation,defaults,callback,this.animationOpt);},stop:function stop(element){this.$el=$R.dom(element);this.$el.removeClass('redactor-animated');var effect=this.$el.attr('redactor-animate-effect');this.$el.removeClass(effect);this.$el.removeAttr('redactor-animate-effect');var hide=this.$el.attr('redactor-animate-hide');if(hide){this.$el.addClass(hide).removeAttr('redactor-animate-hide');}this.$el.off('animationend webkitAnimationEnd');}});$R.AnimatePlay=function(element,animation,defaults,callback,animationOpt){this.hidableEffects=['fadeOut','flipOut','slideUp','zoomOut','slideOutUp','slideOutRight','slideOutLeft'];this.prefixes=['','-webkit-'];this.$el=$R.dom(element);this.$body=$R.dom('body');this.callback=callback;this.animation=!animationOpt?this.buildAnimationOff(animation):animation;this.defaults=defaults;if(this.animation==='slideUp'){this.$el.height(this.$el.height());}// animate
return this.isInanimate()?this.inanimate():this.animate();};$R.AnimatePlay.prototype={buildAnimationOff:function buildAnimationOff(animation){return this.isHidable(animation)?'hide':'show';},buildHideClass:function buildHideClass(){return'redactor-animate-hide';},isInanimate:function isInanimate(){return this.animation==='show'||this.animation==='hide';},isAnimated:function isAnimated(){return this.$el.hasClass('redactor-animated');},isHidable:function isHidable(effect){return this.hidableEffects.indexOf(effect)!==-1;},inanimate:function inanimate(){this.defaults.timing='linear';var hide;if(this.animation==='show'){hide=this.buildHideClass();this.$el.attr('redactor-animate-hide',hide);this.$el.removeClass(hide);}else{hide=this.$el.attr('redactor-animate-hide');this.$el.addClass(hide).removeAttr('redactor-animate-hide');}if(typeof this.callback==='function')this.callback(this);return this;},animate:function animate(){var delay=this.defaults.delay?this.defaults.delay:0;setTimeout(function(){this.$body.addClass('no-scroll-x');this.$el.addClass('redactor-animated');if(!this.$el.attr('redactor-animate-hide')){var hide=this.buildHideClass();this.$el.attr('redactor-animate-hide',hide);this.$el.removeClass(hide);}this.$el.addClass(this.defaults.prefix+this.animation);this.$el.attr('redactor-animate-effect',this.defaults.prefix+this.animation);this.set(this.defaults.duration+'s',this.defaults.iterate,this.defaults.timing);this.complete();}.bind(this),delay*1000);return this;},set:function set(duration,iterate,timing){var len=this.prefixes.length;while(len--){if(duration!==false||duration==='')this.$el.css(this.prefixes[len]+'animation-duration',duration);if(iterate!==false||iterate==='')this.$el.css(this.prefixes[len]+'animation-iteration-count',iterate);if(timing!==false||timing==='')this.$el.css(this.prefixes[len]+'animation-timing-function',timing);}},clean:function clean(){this.$body.removeClass('no-scroll-x');this.$el.removeClass('redactor-animated');this.$el.removeClass(this.defaults.prefix+this.animation);this.$el.removeAttr('redactor-animate-effect');this.set('','','');},complete:function complete(){this.$el.one('animationend webkitAnimationEnd',function(){if(this.$el.hasClass(this.defaults.prefix+this.animation))this.clean();if(this.isHidable(this.animation)){var hide=this.$el.attr('redactor-animate-hide');this.$el.addClass(hide).removeAttr('redactor-animate-hide');}if(this.animation==='slideUp')this.$el.height('');if(typeof this.callback==='function')this.callback(this.$el);}.bind(this));}};$R.add('service','caret',{init:function init(app){this.app=app;},// set
setStart:function setStart(el){this._setCaret('Start',el);},setEnd:function setEnd(el){this._setCaret('End',el);},setBefore:function setBefore(el){this._setCaret('Before',el);},setAfter:function setAfter(el){this._setCaret('After',el);},// is
isStart:function isStart(el){return this._isStartOrEnd(el,'First');},isEnd:function isEnd(el){return this._isStartOrEnd(el,'Last');},// set side
setAtEnd:function setAtEnd(node){var data=this.inspector.parse(node);var tag=data.getTag();var range=document.createRange();if(this._isInPage(node)){if(tag==='a'){var textNode=this.utils.createInvisibleChar();$R.dom(node).after(textNode);range.selectNodeContents(textNode);range.collapse(true);}else{range.selectNodeContents(node);range.collapse(false);}this.selection.setRange(range);}},setAtStart:function setAtStart(node){var range=document.createRange();var data=this.inspector.parse(node);if(this._isInPage(node)){range.setStart(node,0);range.collapse(true);if(data.isInline()||this.utils.isEmpty(node)){var textNode=this.utils.createInvisibleChar();range.insertNode(textNode);range.selectNodeContents(textNode);range.collapse(false);}this.selection.setRange(range);}},setAtBefore:function setAtBefore(node){var data=this.inspector.parse(node);var range=document.createRange();if(this._isInPage(node)){range.setStartBefore(node);range.collapse(true);if(data.isInline()){var textNode=this.utils.createInvisibleChar();node.parentNode.insertBefore(textNode,node);range.selectNodeContents(textNode);range.collapse(false);}this.selection.setRange(range);}},setAtAfter:function setAtAfter(node){var range=document.createRange();if(this._isInPage(node)){range.setStartAfter(node);range.collapse(true);var textNode=this.utils.createInvisibleChar();range.insertNode(textNode);range.selectNodeContents(textNode);range.collapse(false);this.selection.setRange(range);}},setAtPrev:function setAtPrev(node){var prev=node.previousSibling;if(prev){prev=prev.nodeType===3&&this._isEmptyTextNode(prev)?prev.previousElementSibling:prev;if(prev)this.setEnd(prev);}},setAtNext:function setAtNext(node){var next=node.nextSibling;if(next){next=next.nodeType===3&&this._isEmptyTextNode(next)?next.nextElementSibling:next;if(next)this.setStart(next);}},// private
_setCaret:function _setCaret(type,el){var data=this.inspector.parse(el);var node=data.getNode();if(node){this.component.clearActive();this['_set'+type](node,data,data.getTag());}},_setStart:function _setStart(node,data,tag){// 1. text
if(data.isText()){this.editor.focus();return this.setAtStart(node);}// 2. ul, ol
else if(tag==='ul'||tag==='ol'){node=data.findFirstNode('li');var item=this.utils.getFirstElement(node);var dataItem=this.inspector.parse(item);if(item&&dataItem.isComponent()){return this.setStart(dataItem.getComponent());}}// 3. dl
else if(tag==='dl'){node=data.findFirstNode('dt');}// 4. br / hr
else if(tag==='br'||tag==='hr'){return this.setBefore(node);}// 5. th, td
else if(tag==='td'||tag==='th'){var el=data.getFirstElement(node);if(el){return this.setStart(el);}}// 6. table
else if(tag==='table'||tag==='tr'){return this.setStart(data.findFirstNode('th, td'));}// 7. figure code
else if(data.isComponentType('code')&&!data.isFigcaption()){var code=data.findLastNode('pre, code');this.editor.focus();return this.setAtStart(code);}// 8. table component
else if(tag==='figure'&&data.isComponentType('table')){var table=data.getTable();var tableData=this.inspector.parse(table);return this.setStart(tableData.findFirstNode('th, td'));}// 9. non editable components
else if(!data.isComponentType('table')&&data.isComponent()&&!data.isFigcaption()){return this.component.setActive(node);}this.editor.focus();// set
if(!this._setInline(node,'Start')){this.setAtStart(node);}},_setEnd:function _setEnd(node,data,tag){// 1. text
if(data.isText()){this.editor.focus();return this.setAtEnd(node);}// 2. ul, ol
else if(tag==='ul'||tag==='ol'){node=data.findLastNode('li');var item=this.utils.getLastElement(node);var dataItem=this.inspector.parse(item);if(item&&dataItem.isComponent()){return this.setEnd(dataItem.getComponent());}}// 3. dl
else if(tag==='dl'){node=data.findLastNode('dd');}// 4. br / hr
else if(tag==='br'||tag==='hr'){return this.setAfter(node);}// 5. th, td
else if(tag==='td'||tag==='th'){var el=data.getLastElement();if(el){return this.setEnd(el);}}// 6. table
else if(tag==='table'||tag==='tr'){return this.setEnd(data.findLastNode('th, td'));}// 7. figure code
else if(data.isComponentType('code')&&!data.isFigcaption()){var code=data.findLastNode('pre, code');this.editor.focus();return this.setAtEnd(code);}// 8. table component
else if(tag==='figure'&&data.isComponentType('table')){var table=data.getTable();var tableData=this.inspector.parse(table);return this.setEnd(tableData.findLastNode('th, td'));}// 9. non editable components
else if(!data.isComponentType('table')&&data.isComponent()&&!data.isFigcaption()){return this.component.setActive(node);}this.editor.focus();// set
if(!this._setInline(node,'End')){// is element empty
if(this.utils.isEmpty(node)){return this.setStart(node);}this.setAtEnd(node);}},_setBefore:function _setBefore(node,data,tag){// text
if(node.nodeType===3){return this.setAtBefore(node);}// inline
else if(data.isInline()){return this.setAtBefore(node);}// td / th
else if(data.isFirstTableCell()){return this.setAtPrev(data.getComponent());}else if(tag==='td'||tag==='th'){return this.setAtPrev(node);}// li
else if(data.isFirstListItem()){return this.setAtPrev(data.getList());}// figcaption
else if(data.isFigcaption()){return this.setStart(data.getComponent());}// component
else if(!data.isComponentType('table')&&data.isComponent()){return this.setAtPrev(data.getComponent());}// block
else if(data.isBlock()){return this.setAtPrev(node);}this.editor.focus();this.setAtBefore(node);},_setAfter:function _setAfter(node,data,tag){// text
if(node.nodeType===3){return this.setAtAfter(node);}// inline
else if(data.isInline()){return this.setAtAfter(node);}// td / th
else if(data.isLastTableCell()){return this.setAtNext(data.getComponent());}else if(tag==='td'||tag==='th'){return this.setAtNext(node);}// li
else if(data.isFirstListItem()){return this.setAtNext(data.getList());}// component
else if(!data.isComponentType('table')&&data.isComponent()){return this.setAtNext(data.getComponent());}// block
else if(data.isBlock()){return this.setAtNext(node);}this.editor.focus();this.setAtAfter(node);},_setInline:function _setInline(node,type){// is first element inline (FF only)
var inline=this._hasInlineChild(node,type==='Start'?'first':'last');if(inline){if(type==='Start'){this.setStart(inline);}else{this.setEnd(inline);}return true;}},_isStartOrEnd:function _isStartOrEnd(el,type){var node=this.utils.getNode(el);if(!node)return false;var data=this.inspector.parse(node);node=this._getStartEndNode(node,data,type);if(node&&node.nodeType!==3&&node.tagName!=='LI'){var html=node.nodeType===3?node.textContent:node.innerHTML;html=this.utils.trimSpaces(html);if(html==='')return true;}if(!data.isFigcaption()&&data.isComponent()&&!data.isComponentEditable()){return true;}var offset=this.offset.get(node,true);if(offset){return type==='First'?offset.start===0:offset.end===this.offset.size(node,true);}else{return false;}},_isInPage:function _isInPage(node){if(node&&node.nodeType){return node===document.body?false:document.body.contains(node);}else{return false;}},_hasInlineChild:function _hasInlineChild(el,pos){var data=this.inspector.parse(el);var node=pos==='first'?data.getFirstNode():data.getLastNode();var $node=$R.dom(node);if(node&&node.nodeType!==3&&this.inspector.isInlineTag(node.tagName)&&!$node.hasClass('redactor-component')&&!$node.hasClass('non-editable')){return node;}},_isEmptyTextNode:function _isEmptyTextNode(node){var text=node.textContent.trim().replace(/\n/,'');text=this.utils.removeInvisibleChars(text);return text==='';},_getStartEndNode:function _getStartEndNode(node,data,type){if(data.isFigcaption()){node=data.getFigcaption();}else if(data.isTable()){node=data['find'+type+'Node']('th, td');}else if(data.isList()){node=data['find'+type+'Node']('li');}else if(data.isComponentType('code')){node=data.findLastNode('pre, code');}return node;}});var containsNode=function containsNode(node){return document.getSelection().containsNode(node,true);};var containsNodePolyfill=function polyfill(node){var selection=document.getSelection();var start=selection.anchorNode.parentNode;var finalnode=selection.focusNode.parentNode;var rectSelection=selection.getRangeAt(0).getBoundingClientRect();var rectBlock=node.getBoundingClientRect();if($R.dom(start).closest(node).length){return true;}if($R.dom(finalnode).closest(node).length){return true;}if(rectSelection.top<rectBlock.top&&rectSelection.height>rectBlock.height){return true;}return false;};if(!('containsNode'in Selection.prototype)){containsNode=containsNodePolyfill;}$R.add('service','selection',{init:function init(app){this.app=app;},// is
is:function is(){var sel=this.get();if(sel){var node=sel.anchorNode;var data=this.inspector.parse(node);return data.isInEditor()||data.isEditor();}return false;},isCollapsed:function isCollapsed(){var sel=this.get();var range=this.getRange();if(sel&&sel.isCollapsed)return true;else if(range&&range.toString().length===0)return true;return false;},isBackwards:function isBackwards(){var backwards=false;var sel=this.get();if(sel&&!sel.isCollapsed){var range=document.createRange();range.setStart(sel.anchorNode,sel.anchorOffset);range.setEnd(sel.focusNode,sel.focusOffset);backwards=range.collapsed;range.detach();}return backwards;},isIn:function isIn(el){var node=$R.dom(el).get();var current=this.getCurrent();return current&&node?node.contains(current):false;},isText:function isText(){var sel=this.get();if(sel){var el=sel.anchorNode;var block=this.getBlock(el);var blocks=this.getBlocks();// td, th or hasn't block
if(block&&this.inspector.isTableCellTag(block.tagName)||block===false&&blocks.length===0){return true;}}return false;},isAll:function isAll(el){var node=this.utils.getNode(el);if(!node)return false;var isEditor=this.editor.isEditor(node);var data=this.inspector.parse(node);// component
if(!data.isFigcaption()&&this.component.isNonEditable(node)&&this.component.isActive(node)){return true;}if(isEditor){var $editor=this.editor.getElement();var output=$editor.html().replace(/<p><\/p>$/i,'');var htmlLen=this.getHtml(false).length;var outputLen=output.length;if(htmlLen!==outputLen){return false;}}// editor empty or collapsed
if(isEditor&&this.editor.isEmpty()||this.isCollapsed()){return false;}// all
var offset=this.offset.get(node,true);var size=this.offset.size(node,true);// pre, table, or pre/code in figure
if(!isEditor&&data.isComponentType('code')){size=this.getText().trim().length;}if(offset&&offset.start===0&&offset.end===size){return true;}return false;},// has
hasNonEditable:function hasNonEditable(){var selected=this.getHtml();var $wrapper=$R.dom('<div>').html(selected);return!this.isCollapsed()&&$wrapper.find('.non-editable').length!==0;},// set
setRange:function setRange(range){var sel=window.getSelection();sel.removeAllRanges();sel.addRange(range);},setAll:function setAll(el){var node=this.utils.getNode(el);if(!node)return;var data=this.inspector.parse(node);this.component.clearActive();this.editor.focus();this.editor.saveScroll();this.editor.disableNonEditables();if(node&&node.tagName==='TABLE'){var first=data.findFirstNode('td, th');var last=data.findLastNode('td, th');$R.dom(first).prepend(this.marker.build('start'));$R.dom(last).append(this.marker.build('end'));this.restoreMarkers();}else if(!data.isFigcaption()&&this.component.isNonEditable(node)){this.component.setActive(node);}else{if(data.isComponentType('code')){node=data.getComponentCodeElement();node.focus();}var range=document.createRange();range.selectNodeContents(node);this.setRange(range);}this.editor.enableNonEditables();this.editor.restoreScroll();},// get
get:function get(){var sel=window.getSelection();return sel.rangeCount>0?sel:null;},getRange:function getRange(){var sel=this.get();return sel?sel.getRangeAt(0)?sel.getRangeAt(0):null:null;},getTextBeforeCaret:function getTextBeforeCaret(num){num=typeof num==='undefined'?1:num;var el=this.editor.getElement().get();var range=this.getRange();var text=false;if(range){range=range.cloneRange();range.collapse(true);range.setStart(el,0);text=range.toString().slice(-num);}return text;},getTextAfterCaret:function getTextAfterCaret(num){num=typeof num==='undefined'?1:num;var el=this.editor.getElement().get();var range=this.getRange();var text=false;if(range){var clonedRange=range.cloneRange();clonedRange.selectNodeContents(el);clonedRange.setStart(range.endContainer,range.endOffset);text=clonedRange.toString().slice(0,num);}return text;},getPosition:function getPosition(){var range=this.getRange();var pos={top:0,left:0,width:0,height:0};if(window.getSelection&&range.getBoundingClientRect){range=range.cloneRange();var offset=range.startOffset-1;range.setStart(range.startContainer,offset<0?0:offset);var rect=range.getBoundingClientRect();pos={top:rect.top,left:rect.left,width:rect.right-rect.left,height:rect.bottom-rect.top};}return pos;},getCurrent:function getCurrent(){var node=false;var sel=this.get();var component=this.component.getActive();if(component){node=component;}else if(sel&&this.is()){var data=this.inspector.parse(sel.anchorNode);node=!data.isEditor()?sel.anchorNode:false;}return node;},getParent:function getParent(){var node=false;var current=this.getCurrent();if(current){var parent=current.parentNode;var data=this.inspector.parse(parent);node=!data.isEditor()?parent:false;}return node;},getElement:function getElement(el){var node=el||this.getCurrent();while(node){var data=this.inspector.parse(node);if(data.isElement()&&data.isInEditor()){return node;}node=node.parentNode;}return false;},getInline:function getInline(el){var node=el||this.getCurrent();var inline=false;while(node){if(this._isInlineNode(node)){inline=node;}node=node.parentNode;}return inline;},getInlineFirst:function getInlineFirst(el){var node=el||this.getCurrent();while(node){if(this._isInlineNode(node)){return node;}node=node.parentNode;}return false;},getInlineAll:function getInlineAll(el){var node=el||this.getCurrent();var inlines=[];while(node){if(this._isInlineNode(node)){inlines.push(node);}node=node.parentNode;}return inlines;},getBlock:function getBlock(el){var node=el||this.getCurrent();while(node){var data=this.inspector.parse(node);var isBlock=this.inspector.isBlockTag(node.tagName);if(isBlock&&data.isInEditor(node)){return node;}node=node.parentNode;}return false;},getInlinesAllSelected:function getInlinesAllSelected(options){if(this.isAll())return[];var inlines=this.getInlines({all:true});var textNodes=this.getNodes({textnodes:true,inline:false});var selected=this.getText().replace(/[-[\]/{}()*+?.\\^$|]/g,"\\$&");var finalNodes=[];if(textNodes.length!==0){return finalNodes;}if(selected===''){finalNodes=inlines;}else if(inlines.length>1){for(var i=0;i<inlines.length;i++){if(this._isTextSelected(inlines[i],selected)){finalNodes.push(inlines[i]);}}}else if(inlines.length===1){if(this._isTextSelected(inlines[0],selected)){finalNodes=inlines;}}finalNodes=options&&options.tags?this._filterNodesByTags(finalNodes,options.tags):finalNodes;return finalNodes;},getInlines:function getInlines(options){var nodes=this.getNodes();var filteredNodes=[];for(var i=0;i<nodes.length;i++){var node;if(options&&options.all){node=nodes[i];while(node){if(this._isInlineNode(node)&&!this._isInNodesArray(filteredNodes,node)){filteredNodes.push(node);}node=node.parentNode;}}else{node=this.getInline(nodes[i]);if(node&&!this._isInNodesArray(filteredNodes,node)){filteredNodes.push(node);}}}// filter
filteredNodes=options&&options.tags?this._filterNodesByTags(filteredNodes,options.tags):filteredNodes;filteredNodes=options&&options.inside?this._filterInlinesInside(filteredNodes,options):filteredNodes;return filteredNodes;},getBlocks:function getBlocks(options){var nodes=this.getNodes();var block=this.getBlock();nodes=nodes.length===0&&block?[block]:nodes;var filteredNodes=[];for(var i=0;i<nodes.length;i++){var node=this.getBlock(nodes[i]);var $node=$R.dom(node);if($node.hasClass('non-editable'))continue;if(node&&!this._isInNodesArray(filteredNodes,node)){filteredNodes.push(node);}}// filter
filteredNodes=options&&options.tags?this._filterNodesByTags(filteredNodes,options.tags):filteredNodes;filteredNodes=options&&options.first?this._filterBlocksFirst(filteredNodes,options):filteredNodes;return filteredNodes;},getElements:function getElements(options){var nodes=this.getNodes({textnodes:false});var block=this.getBlock();nodes=nodes.length===0&&block?[block]:nodes;var filteredNodes=[];for(var i=0;i<nodes.length;i++){if(!this._isInNodesArray(filteredNodes,nodes[i])){filteredNodes.push(nodes[i]);}}// filter
filteredNodes=options&&options.tags?this._filterNodesByTags(filteredNodes,options.tags):filteredNodes;return filteredNodes;},getNodes:function getNodes(options){var nodes=[];var activeComponent=this.component.getActive();if(activeComponent){nodes=this._getNodesComponent(activeComponent);}else if(this.isCollapsed()){var current=this.getCurrent();nodes=current?[current]:[];}else if(this.is()&&!activeComponent){nodes=this._getRangeSelectedNodes();}// filter
nodes=this._filterServicesNodes(nodes);nodes=this._filterEditor(nodes);// options
nodes=options&&options.tags?this._filterNodesByTags(nodes,options.tags):nodes;nodes=options&&options.textnodes?this._filterNodesTexts(nodes,options):nodes;nodes=options&&!options.textnodes?this._filterNodesElements(nodes):nodes;return nodes;},// text & html
getText:function getText(){var sel=this.get();return sel?this.utils.removeInvisibleChars(sel.toString()):'';},getHtml:function getHtml(clean){var html='';var sel=this.get();if(sel){var container=document.createElement('div');var len=sel.rangeCount;for(var i=0;i<len;++i){container.appendChild(sel.getRangeAt(i).cloneContents());}html=container.innerHTML;html=clean!==false?this.cleaner.output(html):html;html=html.replace(/<p><\/p>$/i,'');}return html;},// clear
clear:function clear(){this.component.clearActive();this.get().removeAllRanges();},// collapse
collapseToStart:function collapseToStart(){var sel=this.get();if(sel&&!sel.isCollapsed)sel.collapseToStart();},collapseToEnd:function collapseToEnd(){var sel=this.get();if(sel&&!sel.isCollapsed)sel.collapseToEnd();},// save
saveActiveComponent:function saveActiveComponent(){var activeComponent=this.component.getActive();if(activeComponent){this.savedComponent=activeComponent;return true;}return false;},restoreActiveComponent:function restoreActiveComponent(){if(this.savedComponent){this.component.setActive(this.savedComponent);return true;}return false;},save:function save(){this._clearSaved();var el=this.getElement();var tags=['TD','TH','P','DIV','PRE','H1','H2','H3','H4','H5','H6','LI','BLOCKQUOTE'];if(el&&tags.indexOf(el.tagName)!==-1&&(el.innerHTML===''||el.innerHTML==='<br>')){this.savedElement=el;}else if(!this.saveActiveComponent()){this.saved=this.offset.get();}},restore:function restore(){if(!this.saved&&!this.savedComponent&&!this.savedElement)return;this.editor.saveScroll();if(this.savedElement){this.caret.setStart(this.savedElement);}else if(!this.restoreActiveComponent()){this.offset.set(this.saved);}this._clearSaved();this.editor.restoreScroll();},saveMarkers:function saveMarkers(){this._clearSaved();if(!this.saveActiveComponent()){this.marker.insert();}},restoreMarkers:function restoreMarkers(){this.editor.saveScroll();if(!this.restoreActiveComponent()){this.marker.restore();}this._clearSaved();this.editor.restoreScroll();},// private
_getNextNode:function _getNextNode(node){if(node.hasChildNodes())return node.firstChild;while(node&&!node.nextSibling){node=node.parentNode;}if(!node)return null;return node.nextSibling;},_getNodesComponent:function _getNodesComponent(component){var current=this.getCurrent();var data=this.inspector.parse(current);return data.isFigcaption()?[data.getFigcaption()]:[component];},_getRangeSelectedNodes:function _getRangeSelectedNodes(){var nodes=[];var range=this.getRange();var node=range.startContainer;var startNode=range.startContainer;var endNode=range.endContainer;var $editor=this.editor.getElement();// editor
if(startNode===$editor.get()&&this.isAll()){nodes=this.utils.getChildNodes($editor);}// single node
else if(node===endNode){nodes=[node];}else{while(node&&node!==endNode){nodes.push(node=this._getNextNode(node));}node=range.startContainer;while(node&&node!==range.commonAncestorContainer){nodes.unshift(node);node=node.parentNode;}}return nodes;},_isInNodesArray:function _isInNodesArray(nodes,node){return nodes.indexOf(node)!==-1;},_filterEditor:function _filterEditor(nodes){var filteredNodes=[];for(var i=0;i<nodes.length;i++){var data=this.inspector.parse(nodes[i]);if(data.isInEditor()){filteredNodes.push(nodes[i]);}}return filteredNodes;},_filterServicesNodes:function _filterServicesNodes(nodes){var filteredNodes=[];for(var i=0;i<nodes.length;i++){var $el=$R.dom(nodes[i]);var skip=false;if(nodes[i]&&nodes[i].nodeType===3&&this.utils.isEmpty(nodes[i]))skip=true;if($el.hasClass('redactor-script-tag')||$el.hasClass('redactor-component-caret')||$el.hasClass('redactor-selection-marker')||$el.hasClass('non-editable'))skip=true;if(!skip){filteredNodes.push(nodes[i]);}}return filteredNodes;},_filterNodesTexts:function _filterNodesTexts(nodes,options){var filteredNodes=[];for(var i=0;i<nodes.length;i++){if(nodes[i].nodeType===3||options.keepbr&&nodes[i].tagName==='BR'){var inline=this.getInline(nodes[i]);var isInline=inline&&options&&options.inline===false;if(!isInline){filteredNodes.push(nodes[i]);}}}return filteredNodes;},_filterNodesElements:function _filterNodesElements(nodes){var filteredNodes=[];for(var i=0;i<nodes.length;i++){if(nodes[i].nodeType!==3){filteredNodes.push(nodes[i]);}}return filteredNodes;},_filterNodesByTags:function _filterNodesByTags(nodes,tags,passtexts){var filteredNodes=[];for(var i=0;i<nodes.length;i++){if(passtexts&&nodes[i].nodeType===3){filteredNodes.push(nodes[i]);}else if(nodes[i].nodeType!==3){var nodeTag=nodes[i].tagName.toLowerCase();if(tags.indexOf(nodeTag.toLowerCase())!==-1){filteredNodes.push(nodes[i]);}}}return filteredNodes;},_filterBlocksFirst:function _filterBlocksFirst(nodes){var filteredNodes=[];for(var i=0;i<nodes.length;i++){var $node=$R.dom(nodes[i]);var parent=$node.parent().get();var isFirst=$node.parent().hasClass('redactor-in');var isCellParent=parent&&(parent.tagName==='TD'||parent.tagName==='TH');if(isFirst||isCellParent){filteredNodes.push(nodes[i]);}}return filteredNodes;},_filterInlinesInside:function _filterInlinesInside(nodes){var filteredNodes=[];for(var i=0;i<nodes.length;i++){if(containsNode(nodes[i],true)){filteredNodes.push(nodes[i]);}}return filteredNodes;},_isTextSelected:function _isTextSelected(node,selected){var text=this.utils.removeInvisibleChars(node.textContent);return selected===text||text.search(selected)!==-1||selected.search(new RegExp('^'+this.utils.escapeRegExp(text)))!==-1||selected.search(new RegExp(this.utils.escapeRegExp(text)+'$'))!==-1;},_isInlineNode:function _isInlineNode(node){var data=this.inspector.parse(node);return this.inspector.isInlineTag(node.tagName)&&data.isInEditor();},_clearSaved:function _clearSaved(){this.saved=false;this.savedComponent=false;this.savedElement=false;}});$R.add('service','element',{init:function init(app){this.app=app;this.rootElement=app.rootElement;// local
this.$element={};this.type='inline';},start:function start(){this._build();this._buildType();},// public
isType:function isType(type){return type===this.type;},getType:function getType(){return this.type;},getElement:function getElement(){return this.$element;},// private
_build:function _build(){this.$element=$R.dom(this.rootElement);},_buildType:function _buildType(){var tag=this.$element.get().tagName;this.type=tag==='TEXTAREA'?'textarea':this.type;this.type=tag==='DIV'?'div':this.type;this.type=this.opts.inline?'inline':this.type;}});$R.add('service','editor',{init:function init(app){this.app=app;// local
this.scrolltop=false;this.pasting=false;},// start
start:function start(){this._build();},// focus
focus:function focus(){if(!this.isFocus()&&!this._isContenteditableFocus()){this.saveScroll();this.$editor.focus();this.restoreScroll();}},startFocus:function startFocus(){this.caret.setStart(this.getFirstNode());},endFocus:function endFocus(){this.caret.setEnd(this.getLastNode());},// pasting
isPasting:function isPasting(){return this.pasting;},enablePasting:function enablePasting(){this.pasting=true;},disablePasting:function disablePasting(){this.pasting=false;},// scroll
saveScroll:function saveScroll(){this.scrolltop=this._getScrollTarget().scrollTop();if(this.opts.maxHeight){this.scrolltopin=this.$editor.scrollTop();}},restoreScroll:function restoreScroll(){if(this.scrolltop!==false){this._getScrollTarget().scrollTop(this.scrolltop);this.scrolltop=false;}if(this.scrolltopin){this.$editor.scrollTop(this.scrolltopin);this.scrolltopin=false;}},// non editables
disableNonEditables:function disableNonEditables(){this.$noneditables=this.$editor.find('[contenteditable=false]');this.$noneditables.attr('contenteditable',true);},enableNonEditables:function enableNonEditables(){if(this.$noneditables){setTimeout(function(){this.$noneditables.attr('contenteditable',false);}.bind(this),1);}},// nodes
getFirstNode:function getFirstNode(){return this.$editor.contents()[0];},getLastNode:function getLastNode(){var nodes=this.$editor.contents();return nodes[nodes.length-1];},// utils
isSourceMode:function isSourceMode(){var $source=this.source.getElement();return $source.hasClass('redactor-source-open');},isEditor:function isEditor(el){var node=$R.dom(el).get();return node===this.$editor.get();},isEmpty:function isEmpty(keeplists){return this.utils.isEmptyHtml(this.$editor.html(),false,keeplists);},isFocus:function isFocus(){var $active=$R.dom(document.activeElement);var isComponentSelected=this.$editor.find('.redactor-component-active').length!==0;return isComponentSelected||$active.closest('.redactor-in-'+this.uuid).length!==0;},setEmpty:function setEmpty(){this.$editor.html(this.opts.emptyHtml);},// element
getElement:function getElement(){return this.$editor;},// private
_build:function _build(){var $element=this.element.getElement();var editableElement=this.element.isType('textarea')?'<div>':$element.get();this.$editor=$R.dom(editableElement);},_getScrollTarget:function _getScrollTarget(){var $target=this.$doc;if(this.opts.toolbarFixedTarget!==document){$target=$R.dom(this.opts.toolbarFixedTarget);}else{$target=this.opts.scrollTarget?$R.dom(this.opts.scrollTarget):$target;}return $target;},_isContenteditableFocus:function _isContenteditableFocus(){var block=this.selection.getBlock();var $blockParent=block?$R.dom(block).closest('[contenteditable=true]').not('.redactor-in'):[];return $blockParent.length!==0;}});$R.add('service','container',{init:function init(app){this.app=app;},// public
start:function start(){this._build();},getElement:function getElement(){return this.$container;},// private
_build:function _build(){var tag=this.element.isType('inline')?'<span>':'<div>';this.$container=$R.dom(tag);}});$R.add('service','source',{init:function init(app){this.app=app;// local
this.$source={};this.content='';},// public
start:function start(){this._build();this._buildName();this._buildStartedContent();},getElement:function getElement(){return this.$source;},getCode:function getCode(){return this.$source.val();},getName:function getName(){return this.$source.attr('name');},getStartedContent:function getStartedContent(){return this.content;},setCode:function setCode(html){return this.insertion.set(html,true,false);},isNameGenerated:function isNameGenerated(){return this.name;},rebuildStartedContent:function rebuildStartedContent(){this._buildStartedContent();},// private
_build:function _build(){var $element=this.element.getElement();var isTextarea=this.element.isType('textarea');var sourceElement=isTextarea?$element.get():'<textarea>';this.$source=$R.dom(sourceElement);},_buildName:function _buildName(){var $element=this.element.getElement();this.name=$element.attr('name');this.$source.attr('name',this.name?this.name:'content-'+this.uuid);},_buildStartedContent:function _buildStartedContent(){var $element=this.element.getElement();var content=this.element.isType('textarea')?$element.val():$element.html();this.content=content.trim();}});$R.add('service','statusbar',{init:function init(app){this.app=app;// local
this.$statusbar={};this.items=[];},// public
start:function start(){this.$statusbar=$R.dom('<ul>');this.$statusbar.attr('dir',this.opts.direction);},add:function add(name,html){return this.update(name,html);},update:function update(name,html){var $item;if(typeof this.items[name]!=='undefined'){$item=this.items[name];}else{$item=$R.dom('<li>');this.$statusbar.append($item);this.items[name]=$item;}return $item.html(html);},get:function get(name){return this.items[name]?this.items[name]:false;},remove:function remove(name){if(this.items[name]){this.items[name].remove();delete this.items[name];}},getItems:function getItems(){return this.items;},removeItems:function removeItems(){this.items={};this.$statusbar.html('');},getElement:function getElement(){return this.$statusbar;}});$R.add('service','toolbar',{init:function init(app){this.app=app;// local
this.buttons=[];this.dropdownOpened=false;this.buttonsObservers={};},// public
start:function start(){if(this.is()){this.opts.activeButtons=this.opts.activeButtonsAdd?this._extendActiveButtons():this.opts.activeButtons;this.create();}},stopObservers:function stopObservers(){this.buttonsObservers={};},create:function create(){this.$wrapper=$R.dom('<div>');this.$toolbar=$R.dom('<div>');},observe:function observe(){if(!this.is())return;this.setButtonsInactive();var button,observer;// observers
for(var name in this.buttonsObservers){observer=this.buttonsObservers[name];button=this.getButton(name);this.app.broadcast('button.'+observer+'.observe',button);}// inline buttons
var buttons=this.opts.activeButtons;var inlines=this.selection.getInlinesAllSelected();var current=this.selection.getInline();if(this.selection.isCollapsed()&&current){inlines.push(current);}var tags=this._inlinesToTags(inlines);for(var key in buttons){if(tags.indexOf(key)!==-1){button=this.getButton(buttons[key]);if(button){button.setActive();}}}},// is
is:function is(){return!(!this.opts.toolbar||this.detector.isMobile()&&this.opts.air);},isAir:function isAir(){return this.is()?this.$toolbar.hasClass('redactor-air'):false;},isFixed:function isFixed(){return this.is()?this.$toolbar.hasClass('redactor-toolbar-fixed'):false;},isContextBar:function isContextBar(){var $bar=this.$body.find('#redactor-context-toolbar-'+this.uuid);return $bar.hasClass('open');},isTarget:function isTarget(){return this.opts.toolbarFixedTarget!==document;},// get
getElement:function getElement(){return this.$toolbar;},getWrapper:function getWrapper(){return this.$wrapper;},getDropdown:function getDropdown(){return this.dropdownOpened;},getTargetElement:function getTargetElement(){return $R.dom(this.opts.toolbarFixedTarget);},getButton:function getButton(name){var $btn=this._findButton('.re-'+name);return $btn.length!==0?$btn.dataget('data-button-instance'):false;},getButtons:function getButtons(){var buttons=[];this._findButtons().each(function(node){var $node=$R.dom(node);buttons.push($node.dataget('data-button-instance'));});return buttons;},getButtonsKeys:function getButtonsKeys(){var keys=[];this._findButtons().each(function(node){var $node=$R.dom(node);keys.push($node.attr('data-re-name'));});return keys;},// add
addButton:function addButton(name,btnObj,position,$el,start){position=position||'end';var $button=$R.create('toolbar.button',this.app,name,btnObj);if(btnObj.observe){this.opts.activeButtonsObservers[name]={observe:btnObj.observe,button:$button};}if(this.is()){if(position==='first')this.$toolbar.prepend($button);else if(position==='after')$el.after($button);else if(position==='before')$el.before($button);else{var index=this.opts.buttons.indexOf(name);if(start!==true&&index!==-1){if(index===0){this.$toolbar.prepend($button);}else{var $btns=this._findButtons();var $btn=$btns.eq(index-1);$btn.after($button);}}else{this.$toolbar.append($button);}}}return $button;},addButtonFirst:function addButtonFirst(name,btnObj){return this.addButton(name,btnObj,'first');},addButtonAfter:function addButtonAfter(after,name,btnObj){var $btn=this.getButton(after);return $btn?this.addButton(name,btnObj,'after',$btn):this.addButton(name,btnObj);},addButtonBefore:function addButtonBefore(before,name,btnObj){var $btn=this.getButton(before);return $btn?this.addButton(name,btnObj,'before',$btn):this.addButton(name,btnObj);},addButtonObserver:function addButtonObserver(name,observer){this.buttonsObservers[name]=observer;},// set
setButtons:function setButtons(buttons){this.buttons=buttons;},setDropdown:function setDropdown(dropdown){this.dropdownOpened=dropdown;},setButtonsInactive:function setButtonsInactive(){var $buttons=this.getButtons();for(var i=0;i<$buttons.length;i++){$buttons[i].setInactive();}},setButtonsActive:function setButtonsActive(){var $buttons=this.getButtons();for(var i=0;i<$buttons.length;i++){$buttons[i].setActive();}},// disable & enable
disableButtons:function disableButtons(){var $buttons=this.getButtons();for(var i=0;i<$buttons.length;i++){$buttons[i].disable();}},enableButtons:function enableButtons(){var $buttons=this.getButtons();for(var i=0;i<$buttons.length;i++){$buttons[i].enable();}},// private
_findButton:function _findButton(selector){return this.is()?this.$toolbar.find(selector):$R.dom();},_findButtons:function _findButtons(){return this.is()?this.$toolbar.find('.re-button'):$R.dom();},_extendActiveButtons:function _extendActiveButtons(){return $R.extend({},this.opts.activeButtons,this.opts.activeButtonsAdd);},_inlinesToTags:function _inlinesToTags(inlines){var tags=[];for(var i=0;i<inlines.length;i++){tags.push(inlines[i].tagName.toLowerCase());}return tags;}});$R.add('class','toolbar.button',{mixins:['dom'],init:function init(app,name,btnObj){this.app=app;this.opts=app.opts;this.lang=app.lang;this.$body=app.$body;this.toolbar=app.toolbar;this.detector=app.detector;// local
this.obj=btnObj;this.name=name;this.dropdown=false;this.tooltip=false;// init
this._init();},// is
isActive:function isActive(){return this.hasClass('redactor-button-active');},isDisabled:function isDisabled(){return this.hasClass('redactor-button-disabled');},// has
hasIcon:function hasIcon(){return this.obj.icon&&!this.opts.buttonsTextLabeled;},// set
setDropdown:function setDropdown(dropdown){this.obj.dropdown=dropdown;this.obj.message=false;this.dropdown=$R.create('toolbar.dropdown',this.app,this.name,this.obj.dropdown);this.attr('data-dropdown',true);},setMessage:function setMessage(message,args){this.obj.message=message;this.obj.args=args;this.obj.dropdown=false;},setApi:function setApi(api,args){this.obj.api=api;this.obj.args=args;this.obj.dropdown=false;},setTitle:function setTitle(title){this.obj.title=this.lang.parse(title);this.obj.tooltip=this.obj.title;this.attr({'alt':this.obj.tooltip,'aria-label':this.obj.tooltip});if(!this.attr('data-re-icon'))this.html(this.obj.title);},setTooltip:function setTooltip(tooltip){this.obj.tooltip=this.lang.parse(tooltip);this.attr({'alt':this.obj.tooltip,'aria-label':this.obj.tooltip});},setIcon:function setIcon(icon){if(this.opts.buttonsTextLabeled)return;this.obj.icon=true;this.$icon=$R.dom(icon);this.html('');this.append(this.$icon);this.attr('data-re-icon',true);this.addClass('re-button-icon');this.setTooltip(this.obj.title);this._buildTooltip();},setActive:function setActive(){this.addClass('redactor-button-active');},setInactive:function setInactive(){this.removeClass('redactor-button-active');},// hide
hideTooltip:function hideTooltip(){this.$body.find('.re-button-tooltip').remove();},// get
getDropdown:function getDropdown(){return this.dropdown;},// enable & disable
disable:function disable(){this.addClass('redactor-button-disabled');},enable:function enable(){this.removeClass('redactor-button-disabled');},// toggle
toggle:function toggle(e){if(e)e.preventDefault();if(this.isDisabled())return;if(this.obj.dropdown){this.dropdown.toggle(e);}else if(this.obj.api){// broadcast
this.app.api(this.obj.api,this.obj.args,this.name);}else if(this.obj.message){// broadcast
this.app.broadcast(this.obj.message,this.obj.args,this.name);}this.hideTooltip();},// private
_init:function _init(){// parse
this._parseTitle();this._parseTooltip();// build
this._build();this._buildCallback();this._buildAttributes();this._buildObserver();if(this.hasIcon()){this._buildIcon();this._buildTooltip();}else{this.html(this.obj.title);}},_parseTooltip:function _parseTooltip(){this.obj.tooltip=this.obj.tooltip?this.lang.parse(this.obj.tooltip):this.obj.title;},_parseTitle:function _parseTitle(){this.obj.title=this.lang.parse(this.obj.title);},_build:function _build(){this.parse('<a>');this.addClass('re-button re-'+this.name);this.attr('data-re-name',this.name);this.dataset('data-button-instance',this);if(this.obj.dropdown)this.setDropdown(this.obj.dropdown);},_buildCallback:function _buildCallback(){this.on('click',this.toggle.bind(this));},_buildAttributes:function _buildAttributes(){var attrs={'href':'#','alt':this.obj.tooltip,'rel':this.name,'role':'button','aria-label':this.obj.tooltip,'tabindex':'-1'};this.attr(attrs);},_buildObserver:function _buildObserver(){if(typeof this.obj.observe!=='undefined'){this.toolbar.addButtonObserver(this.name,this.obj.observe);}},_buildIcon:function _buildIcon(){var icon=this.obj.icon;var isHtml=/(<([^>]+)>)/ig.test(icon);this.$icon=isHtml?$R.dom(icon):$R.dom('<i>');if(!isHtml)this.$icon.addClass('re-icon-'+this.name);this.append(this.$icon);this.attr('data-re-icon',true);this.addClass('re-button-icon');},_buildTooltip:function _buildTooltip(){if(this.detector.isDesktop()){this.tooltip=$R.create('toolbar.button.tooltip',this.app,this);}}});$R.add('class','toolbar.button.tooltip',{mixins:['dom'],init:function init(app,$button){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.$body=app.$body;this.toolbar=app.toolbar;// local
this.$button=$button;this.created=false;// init
this._init();},open:function open(){if(this.$button.hasClass('redactor-button-disabled')||this.$button.hasClass('redactor-button-active'))return;this.created=true;this.parse('<span>');this.addClass('re-button-tooltip re-button-tooltip-'+this.uuid);this.$body.append(this);this.html(this.$button.attr('alt'));var offset=this.$button.offset();var position='absolute';var height=this.$button.height();var width=this.$button.width();var arrowOffset=4;this.css({top:offset.top+height+arrowOffset+'px',left:offset.left+width/2-this.width()/2+'px',position:position});this.show();},close:function close(){if(!this.created||this.$button.hasClass('redactor-button-disabled'))return;this.remove();this.created=false;},// private
_init:function _init(){this.$button.on('mouseover',this.open.bind(this));this.$button.on('mouseout',this.close.bind(this));}});$R.add('class','toolbar.dropdown',{mixins:['dom'],init:function init(app,name,items){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.$win=app.$win;this.$doc=app.$doc;this.$body=app.$body;this.animate=app.animate;this.toolbar=app.toolbar;// local
this.name=name;this.started=false;this.items=name==='format'?$R.extend({},true,items):items;this.$items=[];},// public
toggle:function toggle(e){if(!this.started){this._build();}// toggle
if(this.isOpened()&&this.isActive()){this.close(false);}else{this.open(e);}},isOpened:function isOpened(){var $dropdown=this.$body.find('.redactor-dropdown-'+this.uuid+'.open');return $dropdown.length!==0&&$dropdown.attr('data-re-name')===this.name;},isActive:function isActive(){var $dropdown=this.$body.find('#redactor-dropdown-'+this.uuid+'-'+this.name+'.open');return $dropdown.length!==0;},getName:function getName(){return this.attr('data-re-name');},getItem:function getItem(name){return this.$items[name];},getItemsByClass:function getItemsByClass(classname){var result=[];for(var key in this.$items){var item=this.$items[key];if(_typeof(item)==='object'&&item.attr('data-re-name')&&item.hasClass(classname)){result.push(item);}}return result;},open:function open(e){this._closeAll();this.$btn=this.toolbar.getButton(this.name);this.app.broadcast('dropdown.open',e,this,this.$btn);this.toolbar.setDropdown(this);this.show();this.removeClass('redactor-animate-hide');this.addClass('open');this._observe();this.$btn.hideTooltip();this.$btn.setActive();this.$doc.on('keyup.redactor.dropdown-'+this.uuid,this._handleKeyboard.bind(this));this.$doc.on('click.redactor.dropdown-'+this.uuid,this.close.bind(this));this.updatePosition();this.app.broadcast('dropdown.opened',e,this,this.$btn);},close:function close(e,animate){if(e){var $el=$R.dom(e.target);if(this._isButton(e)||$el.hasClass('redactor-dropdown-not-close')||$el.hasClass('redactor-dropdown-item-disabled')){e.preventDefault();return;}}this.app.broadcast('dropdown.close',this,this.$btn);this.toolbar.setDropdown(false);this.$btn.setInactive();if(animate===false){this._close();}else{this.animate.start(this,'fadeOut',this._close.bind(this));}},updatePosition:function updatePosition(){var isFixed=this.toolbar.isFixed();var isTarget=this.toolbar.isTarget();var btnHeight=this.$btn.height();var btnWidth=this.$btn.width();var pos=this.$btn.offset();var position='absolute';var topOffset=2;if(isFixed){//pos.top = (isTarget) ? this.$btn.offset().top : this.$btn.position().top;
//position = 'fixed';
//topOffset = topOffset + this.opts.toolbarFixedTopOffset;
}var leftOffset=0;var left=pos.left+leftOffset;var width=parseFloat(this.css('width'));var winWidth=this.$win.width();var leftFix=winWidth<left+width?width-btnWidth:0;var leftPos=left-leftFix;var top=pos.top+btnHeight+topOffset;leftPos=leftPos<0?4:leftPos;this.css({maxHeight:'',position:position,top:top+'px',left:leftPos+'px'});// height adaptive
var heightTolerance=10;var winHeight=this.$win.height();var scrollTop=this.$doc.scrollTop();var cropHeight=winHeight-(top-scrollTop)-heightTolerance;this.css('max-height',cropHeight+'px');},// private
_build:function _build(){this.parse('<div>');this.attr('dir',this.opts.direction);this.attr('id','redactor-dropdown-'+this.uuid+'-'+this.name);this.attr('data-re-name',this.name);this.addClass('redactor-dropdown redactor-dropdown-'+this.uuid+' redactor-dropdown-'+this.name);this.dataset('data-dropdown-instance',this);var isDom=this.items.sdom||typeof this.items==='string';if(isDom)this._buildDom();else this._buildItems();this.$body.append(this);this.started=true;},_buildDom:function _buildDom(){this.html('').append($R.dom(this.items));},_buildItems:function _buildItems(){this.items=this.name==='format'?this._buildFormattingItems():this.items;for(var key in this.items){var obj=this.items[key];if(key==='observe'){this.attr('data-observe',this.items[key]);}else{var $item=$R.create('toolbar.dropdown.item',this.app,key,obj,this);this.$items[key]=$item;this.append($item);}}},_buildFormattingItems:function _buildFormattingItems(){// build the format set
for(var key in this.items){if(this.opts.formatting.indexOf(key)===-1)delete this.items[key];}// remove from the format set
if(this.opts.formattingHide){for(var key in this.items){if(this.opts.formattingHide.indexOf(key)!==-1)delete this.items[key];}}// add to the format set
if(this.opts.formattingAdd){for(var key in this.opts.formattingAdd){this.items[key]=this.opts.formattingAdd[key];}}return this.items;},_handleKeyboard:function _handleKeyboard(e){if(e.which===27)this.close();},_isButton:function _isButton(e){var $el=$R.dom(e.target);var $btn=$el.closest('.re-button');return $btn.get()===this.$btn.get();},_close:function _close(){this.$btn.setInactive();this.$doc.off('.redactor.dropdown-'+this.uuid);this.removeClass('open');this.addClass('redactor-animate-hide');this.app.broadcast('dropdown.closed',this,this.$btn);},_closeAll:function _closeAll(){this.$body.find('.redactor-dropdown-'+this.uuid+'.open').each(function(node){var $node=$R.dom(node);var instance=$node.dataget('data-dropdown-instance');instance._close();});},_observe:function _observe(){var observer=this.attr('data-observe');if(observer){this.app.broadcast('dropdown.'+observer+'.observe',this);}}});$R.add('class','toolbar.dropdown.item',{mixins:['dom'],init:function init(app,name,obj,dropdown){this.app=app;this.lang=app.lang;// local
this.dropdown=dropdown;this.name=name;this.obj=obj;// init
this._init();},setTitle:function setTitle(html){this.$span.html(html);},getTitle:function getTitle(){return this.$span.html();},enable:function enable(){this.removeClass('redactor-dropdown-item-disabled');},disable:function disable(){this.addClass('redactor-dropdown-item-disabled');},toggle:function toggle(e){if(e)e.preventDefault();if(this.hasClass('redactor-dropdown-item-disabled'))return;if(this.obj.message){// broadcast
this.app.broadcast(this.obj.message,this.obj.args,this.name);}else if(this.obj.api){this.app.api(this.obj.api,this.obj.args,this.name);}},// private
_init:function _init(){this.parse('<a>');this.attr('href','#');this.addClass('redactor-dropdown-item-'+this.name);if(this.obj.classname){this.addClass(this.obj.classname);}this.attr('data-re-name',this.name);this.on('click',this.toggle.bind(this));this.$span=$R.dom('<span>');this.append(this.$span);this.setTitle(this.lang.parse(this.obj.title));}});$R.add('service','cleaner',{init:function init(app){this.app=app;this.opts=app.opts;// local
this.storedComponents=[];this.storedComments=[];this.storedImages=[];this.storedLinks=[];this.deniedTags=['font','html','head','link','title','body','meta','applet'];this.convertRules={};this.unconvertRules={};// regex
this.reComments=/<!--[\s\S]*?-->\n?/g;this.reSpacedEmpty=/^(||\s||<br\s?\/?>||&nbsp;)$/i;this.reScriptTag=/<script(.*?[^>]?)>([\w\W]*?)<\/script>/gi;},// public
addConvertRules:function addConvertRules(name,func){this.convertRules[name]=func;},addUnconvertRules:function addUnconvertRules(name,func){this.unconvertRules[name]=func;},input:function input(html,paragraphize,started){// store
var storedComments=[];html=this.storeComments(html,storedComments);// pre/code
html=this.encodeCode(html);// sanitize
var $wrapper=this.utils.buildWrapper(html);$wrapper.find('a, b, i, img, svg, details').removeAttr('onload onerror ontoggle onwheel onmouseover oncopy');$wrapper.find('a').each(function(node){var $node=$R.dom(node);var href=$node.attr('href');if(href&&href.search(/^data|javascript:/i)!==-1){$node.attr('href','');}});var imageattrs=['alt','title','src','class','width','height','srcset','style','usemap'];$wrapper.find('img').each(function(node){if(node.attributes.length>0){var attrs=node.attributes;for(var i=attrs.length-1;i>=0;i--){var removeAttrs=attrs[i].name.search(/^data-/)===-1&&imageattrs.indexOf(attrs[i].name)===-1;var removeDataSrc=attrs[i].name==='src'&&attrs[i].value.search(/^data|javascript:/i)!==-1;if(this.opts.imageSrcData)removeDataSrc=false;if(removeAttrs||removeDataSrc){node.removeAttribute(attrs[i].name);}}}}.bind(this));// get wrapper html
html=this.utils.getWrapperHtml($wrapper);// converting entity
html=html.replace(/\$/g,'&#36;');html=html.replace(/&amp;/g,'&');// convert to figure
var converter=$R.create('cleaner.figure',this.app);html=converter.convert(html,this.convertRules);// store components
html=this.storeComponents(html);// clean
html=this.replaceTags(html,this.opts.replaceTags);html=this._setSpanAttr(html);html=this._setStyleCache(html);html=this.removeTags(html,this.deniedTags);html=this.opts.removeScript?this._removeScriptTag(html):this._replaceScriptTag(html);//html = (this.opts.removeScript) ? this._removeScriptTag(html) : html;
html=this.opts.removeComments?this.removeComments(html):html;html=this._isSpacedEmpty(html)?this.opts.emptyHtml:html;// restore components
html=this.restoreComponents(html);// clear wrapped components
html=this._cleanWrapped(html);// restore comments
html=this.restoreComments(html,storedComments);// paragraphize
html=paragraphize?this.paragraphize(html):html;return html;},output:function output(html,removeMarkers){html=this.removeInvisibleSpaces(html);if(this.opts.breakline){html=html.replace(/<\/(span|strong|b|i|em)><br\s?\/?><\/div>/gi,"</$1></div>");html=html.replace(/<br\s?\/?><\/(span|strong|b|i|em)><\/div>/gi,"</$1></div>");}html=html.replace(/&#36;/g,'$');// empty
if(this._isSpacedEmpty(html))return'';if(this._isParagraphEmpty(html))return'';html=this.removeServiceTagsAndAttrs(html,removeMarkers);// store components
html=this.storeComponents(html);html=this.removeSpanWithoutAttributes(html);html=this.removeFirstBlockBreaklineInHtml(html);html=this.opts.removeScript?html:this._unreplaceScriptTag(html);html=this.opts.preClass?this._setPreClass(html):html;html=this.opts.linkNofollow?this._setLinkNofollow(html):html;html=this.opts.removeNewLines?this.cleanNewLines(html):html;// restore components
html=this.restoreComponents(html);// convert to figure
var converter=$R.create('cleaner.figure',this.app);html=converter.unconvert(html,this.unconvertRules);// final clean up
html=this.removeEmptyAttributes(html,['style','class','rel','alt','title']);html=this.cleanSpacesInPre(html);html=this.tidy(html);// converting entity
html=html.replace(/&amp;/g,'&');// breakline tidy
if(this.opts.breakline){html=html.replace(/<br\s?\/?>/gi,"<br>\n");html=html.replace(/<br\s?\/?>\n+/gi,"<br>\n");}// check whitespaces
html=html.replace(/\n/g,'')===''?'':html;return html;},paste:function paste(html){// store components
html=this.storeComponents(html);// remove comments
html=html.replace(/<!--[\s\S]*?-->/g,'');// remove tags
var deniedTags=this.deniedTags.concat(['iframe']);html=this.removeTags(html,deniedTags);// remove doctype tag
html=html.replace(new RegExp("<!doctype([\\s\\S]+?)>",'gi'),'');// remove style tag
html=html.replace(new RegExp("<style([\\s\\S]+?)</style>",'gi'),'');// remove br between
html=html.replace(new RegExp("</p><br /><p",'gi'),'</p><p');// gdocs & word
var isMsWord=this._isHtmlMsWord(html);html=this._cleanGDocs(html);html=isMsWord?this._cleanMsWord(html):html;// do not clean
if(!this.opts.pasteClean){// restore components
html=this.restoreComponents(html);return html;}// plain text
if(this.opts.pastePlainText){// restore components
html=this.restoreComponents(html);return this.pastePlainText(html);}// unconvert data redactor tag
var $wrapper=this.utils.buildWrapper(html);$wrapper.find('*').removeAttr('style');$wrapper.find('[data-redactor-tag]').each(function(node){var $node=$R.dom(node);$node.removeAttr('data-redactor-tag');if(this.utils.isEmptyHtml($node.html())){$node.html('<br>').unwrap();}else if(node.lastChild&&node.lastChild.tagName==='BR'){$node.unwrap();}else{$node.append('<br>').unwrap();}}.bind(this));html=this.utils.getWrapperHtml($wrapper);html=html.replace(/<br\s?\/?>$/,'');html=html.replace(/<br\s?\/?><\/(td|th)>/,'</$1>');// remove tags
var exceptedTags=this.opts.pasteBlockTags.concat(this.opts.pasteInlineTags);html=this.removeTagsExcept(html,exceptedTags);// links & images
html=this.opts.pasteLinks?html:this.removeTags(html,['a']);html=this.opts.pasteImages?html:this.removeTags(html,['img']);// build wrapper
var $wrapper=this.utils.buildWrapper(html);// clean attrs
var $elms=$wrapper.find('*');// remove style
var filterStyle=this.opts.pasteKeepStyle.length!==0?','+this.opts.pasteKeepStyle.join(','):'';$elms.not('[data-redactor-style-cache]'+filterStyle).removeAttr('style');// remove class
var filterClass=this.opts.pasteKeepClass.length!==0?','+this.opts.pasteKeepClass.join(','):'';$elms.not('[data-redactor-style-cache], span.redactor-component'+filterClass).removeAttr('class');// remove attrs
var filterAttrs=this.opts.pasteKeepAttrs.length!==0?','+this.opts.pasteKeepAttrs.join(','):'';$elms.not('img, a, span.redactor-component, [data-redactor-style-cache]'+filterAttrs).each(function(node){var attrs=node.attributes;for(var i=attrs.length-1;i>=0;i--){if(node.attributes[i].name!=='class'&&node.attributes[i].name!=='dir'){node.removeAttribute(attrs[i].name);}}});// paste link target
if(this.opts.pasteLinks&&this.opts.pasteLinkTarget!==false){$wrapper.find('a').attr('target',this.opts.pasteLinkTarget);}// keep style
$wrapper.find('[data-redactor-style-cache]').each(function(node){var style=node.getAttribute('data-redactor-style-cache');node.setAttribute('style',style);});// remove image attributes
var imageattrs=this.opts.imageAttrs;$wrapper.find('img').each(function(node){if(node.attributes.length>0){var attrs=node.attributes;for(var i=attrs.length-1;i>=0;i--){if(imageattrs.indexOf(attrs[i].name)===-1){node.removeAttribute(attrs[i].name);}}}});// remove empty span
$wrapper.find('span').each(function(node){if(node.attributes.length===0){$R.dom(node).unwrap();}});// remove empty inline
$wrapper.find(this.opts.inlineTags.join(',')).each(function(node){if(node.attributes.length===0&&this.utils.isEmptyHtml(node.innerHTML)){$R.dom(node).unwrap();}}.bind(this));// place ul/ol into li
$wrapper.find('ul, ol').each(function(node){var prev=node.previousSibling;if(prev&&prev.tagName==='LI'){var $li=$R.dom(prev);$li.find('p').unwrap();$li.append(node);}});// get wrapper
html=this.utils.getWrapperHtml($wrapper);// remove paragraphs form lists (google docs bug)
html=html.replace(/<li><p>/gi,'<li>');html=html.replace(/<\/p><\/li>/gi,'</li>');// gmail list paste
html=html.replace(/^<li/gi,'<ul><li');html=html.replace(/<\/li>$/gi,'</li></ul>');// convert lines to br
if(this.opts.breakline){html=html.replace(/\n/g,'<br>');}// clean empty p
html=html.replace(/<p>&nbsp;<\/p>/gi,'<p></p>');html=html.replace(/<p><br\s?\/?><\/p>/gi,'<p></p>');if(isMsWord){html=html.replace(/<p><\/p>/gi,'');html=html.replace(/<p>\s<\/p>/gi,'');}// restore components
html=this.restoreComponents(html);return html;},pastePlainText:function pastePlainText(html){html=this.opts.pasteLinks?this.storeLinks(html):html;html=this.opts.pasteImages?this.storeImages(html):html;html=this.getPlainText(html);html=this._replaceNlToBr(html);html=this.opts.pasteLinks?this.restoreLinks(html):html;html=this.opts.pasteImages?this.restoreImages(html):html;return html;},tidy:function tidy(html){return html;},paragraphize:function paragraphize(html){var paragraphize=$R.create('cleaner.paragraphize',this.app);html=paragraphize.convert(html);return html;},storeComments:function storeComments(html,storedComments){var comments=html.match(new RegExp('<!--([\\w\\W]*?)-->','gi'));if(comments!==null){for(var i=0;i<comments.length;i++){html=html.replace(comments[i],'#####xstarthtmlcommentzz'+i+'xendhtmlcommentzz#####');storedComments.push(comments[i]);}}return html;},restoreComments:function restoreComments(html,storedComments){for(var i=0;i<storedComments.length;i++){html=html.replace('#####xstarthtmlcommentzz'+i+'xendhtmlcommentzz#####',storedComments[i]);}return html;},// get
getFlatText:function getFlatText(html){var $div=$R.dom('<div>');if(!html.nodeType&&!html.dom){html=html.toString();html=html.trim();$div.html(html);}else{$div.append(html);}html=$div.get().textContent||$div.get().innerText||'';return html===undefined?'':html;},getPlainText:function getPlainText(html){html=html.replace(/<!--[\s\S]*?-->/gi,'');html=html.replace(/<style[\s\S]*?style>/gi,'');html=html.replace(/<p><\/p>/g,'');html=html.replace(/<\/div>|<\/li>|<\/td>/gi,'\n');html=html.replace(/<\/p>/gi,'\n\n');html=html.replace(/<\/H[1-6]>/gi,'\n\n');var tmp=document.createElement('div');tmp.innerHTML=html;html=tmp.textContent||tmp.innerText;return html.trim();},// replace
replaceTags:function replaceTags(html,tags){if(tags){var self=this;var keys=Object.keys(tags);var $wrapper=this.utils.buildWrapper(html);$wrapper.find(keys.join(',')).each(function(node){self.utils.replaceToTag(node,tags[node.tagName.toLowerCase()]);});html=this.utils.getWrapperHtml($wrapper);}return html;},replaceNbspToSpaces:function replaceNbspToSpaces(html){return html.replace('&nbsp;',' ');},replaceBlocksToBr:function replaceBlocksToBr(html){html=html.replace(/<\/div>|<\/li>|<\/td>|<\/p>|<\/H[1-6]>/gi,'<br>');return html;},// clean
cleanNewLines:function cleanNewLines(html){return html.replace(/\r?\n/g,"");},cleanSpacesInPre:function cleanSpacesInPre(html){return html.replace('&nbsp;&nbsp;&nbsp;&nbsp;','    ');},// remove
removeInvisibleSpaces:function removeInvisibleSpaces(html){html=this.utils.removeInvisibleChars(html);html=html.replace(/&#65279;/gi,'');return html;},removeNl:function removeNl(html){html=html.replace(/\n/g," ");html=html.replace(/\s+/g,"\s");return html;},removeBrAtEnd:function removeBrAtEnd(html){html=html.replace(/<br\s?\/?>$/gi,' ');html=html.replace(/<br\s?\/?><li/gi,'<li');return html;},removeTags:function removeTags(input,denied){var re=denied?/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi:/(<([^>]+)>)/gi;var replacer=!denied?'':function($0,$1){return denied.indexOf($1.toLowerCase())===-1?$0:'';};return input.replace(re,replacer);},removeTagsExcept:function removeTagsExcept(input,except){if(except===undefined)return input.replace(/(<([^>]+)>)/gi,'');var tags=/<\/?([a-z][a-z0-9]*)\b[^>]*>/gi;return input.replace(tags,function($0,$1){return except.indexOf($1.toLowerCase())===-1?'':$0;});},removeComments:function removeComments(html){return html.replace(this.reComments,'');},removeServiceTagsAndAttrs:function removeServiceTagsAndAttrs(html,removeMarkers){var $wrapper=this.utils.buildWrapper(html);var self=this;if(removeMarkers!==false){$wrapper.find('.redactor-selection-marker').each(function(node){var $el=$R.dom(node);var text=self.utils.removeInvisibleChars($el.text());return text===''?$el.remove():$el.unwrap();});}$wrapper.find('[data-redactor-style-cache]').removeAttr('data-redactor-style-cache');return this.utils.getWrapperHtml($wrapper);},removeSpanWithoutAttributes:function removeSpanWithoutAttributes(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('span').removeAttr('data-redactor-span data-redactor-style-cache').each(function(node){if(node.attributes.length===0)$R.dom(node).unwrap();});return this.utils.getWrapperHtml($wrapper);},removeFirstBlockBreaklineInHtml:function removeFirstBlockBreaklineInHtml(html){return html.replace(new RegExp('</li><br\\s?/?>','gi'),'</li>');},removeEmptyAttributes:function removeEmptyAttributes(html,attrs){var $wrapper=this.utils.buildWrapper(html);for(var i=0;i<attrs.length;i++){$wrapper.find('['+attrs[i]+'=""]').removeAttr(attrs[i]);}return this.utils.getWrapperHtml($wrapper);},// encode / decode
encodeHtml:function encodeHtml(html){html=html.replace(/<br\s?\/?>/g,"\n");html=html.replace(/&nbsp;/g,' ');html=html.replace(/”/g,'"');html=html.replace(/“/g,'"');html=html.replace(/‘/g,'\'');html=html.replace(/’/g,'\'');html=this.encodeEntities(html);html=html.replace(/\$/g,'&#36;');if(this.opts.preSpaces){html=html.replace(/\t/g,new Array(this.opts.preSpaces+1).join(' '));}return html;},encodeCode:function encodeCode(html){// replace all tags
html=html.replace(/<(.*?)>/gi,'xtagstartz$1xtagendz');// revert pre / code
html=html.replace(/xtagstartzpre(.*?)xtagendz/g,'<pre$1>');html=html.replace(/xtagstartzcode(.*?)xtagendz/g,'<code$1>');html=html.replace(/xtagstartz\/codextagendz/g,'</code>');html=html.replace(/xtagstartz\/prextagendz/g,'</pre>');// encode
html=this._encodeCode(html);// revert all tags
html=html.replace(/xtagstartz(.*?)xtagendz/g,'<$1>');html=html.replace(/xtagstartz\/(.*?)xtagendz/g,'</$1>');return html;},_encodeCode:function _encodeCode(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('pre code, pre, code').each(this._encodeNode.bind(this));return this.utils.getWrapperHtml($wrapper);},_encodeNode:function _encodeNode(node){var first=node.firstChild;var html=node.innerHTML;if(node.tagName==='PRE'&&first&&first.tagName==='CODE'){return;}html=html.replace(/xtagstartz/g,'<');html=html.replace(/xtagendz/g,'>');var encoded=this.decodeEntities(html);node.textContent=this._encodeNodeHtml(encoded);},_encodeNodeHtml:function _encodeNodeHtml(html){html=html.replace(/&nbsp;/g,' ').replace(/<br\s?\/?>/g,'\n');html=this.opts.preSpaces?html.replace(/\t/g,new Array(this.opts.preSpaces+1).join(' ')):html;return html;},encodeEntities:function encodeEntities(str){str=this.decodeEntities(str);str=str.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');return str;},encodePhpCode:function encodePhpCode(html){html=html.replace('<?php','&lt;?php');html=html.replace('<?','&lt;?');html=html.replace('?>','?&gt;');return html;},decodeEntities:function decodeEntities(str){return String(str).replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&quot;/g,'"').replace(/&amp;/g,'&');},// store / restore
storeComponents:function storeComponents(html){var matched=this.utils.getElementsFromHtml(html,'figure','table');return this._storeMatched(html,matched,'Components','figure');},restoreComponents:function restoreComponents(html){return this._restoreMatched(html,'Components','figure');},storeLinks:function storeLinks(html){var matched=this.utils.getElementsFromHtml(html,'a');return this._storeMatched(html,matched,'Links','a');},storeImages:function storeImages(html){var matched=this.utils.getElementsFromHtml(html,'img');return this._storeMatched(html,matched,'Images','img');},restoreLinks:function restoreLinks(html){return this._restoreMatched(html,'Links','a');},restoreImages:function restoreImages(html){return this._restoreMatched(html,'Images','img');},// PRIVATE
// clean
_cleanWrapped:function _cleanWrapped(html){html=html.replace(new RegExp('<p><figure([\\w\\W]*?)</figure></p>','gi'),'<figure$1</figure>');return html;},_cleanGDocs:function _cleanGDocs(html){// remove google docs markers
html=html.replace(/<b\sid="internal-source-marker(.*?)">([\w\W]*?)<\/b>/gi,"$2");html=html.replace(/<b(.*?)id="docs-internal-guid(.*?)">([\w\W]*?)<\/b>/gi,"$3");html=html.replace(/<span[^>]*(font-style:\s?italic;\s?font-weight:\s?bold|font-weight:\s?bold;\s?font-style:\s?italic)[^>]*>([\w\W]*?)<\/span>/gi,'<b><i>$2</i></b>');html=html.replace(/<span[^>]*(font-style:\s?italic;\s?font-weight:\s?600|font-weight:\s?600;\s?font-style:\s?italic)[^>]*>([\w\W]*?)<\/span>/gi,'<b><i>$2</i></b>');html=html.replace(/<span[^>]*(font-style:\s?italic;\s?font-weight:\s?700|font-weight:\s?700;\s?font-style:\s?italic)[^>]*>([\w\W]*?)<\/span>/gi,'<b><i>$2</i></b>');html=html.replace(/<span[^>]*font-style:\s?italic[^>]*>([\w\W]*?)<\/span>/gi,'<i>$1</i>');html=html.replace(/<span[^>]*font-weight:\s?bold[^>]*>([\w\W]*?)<\/span>/gi,'<b>$1</b>');html=html.replace(/<span[^>]*font-weight:\s?700[^>]*>([\w\W]*?)<\/span>/gi,'<b>$1</b>');html=html.replace(/<span[^>]*font-weight:\s?600[^>]*>([\w\W]*?)<\/span>/gi,'<b>$1</b>');return html;},_cleanMsWord:function _cleanMsWord(html){html=html.replace(/<!--[\s\S]+?-->/gi,'');html=html.replace(/<(!|script[^>]*>.*?<\/script(?=[>\s])|\/?(\?xml(:\w+)?|img|meta|link|style|\w:\w+)(?=[\s\/>]))[^>]*>/gi,'');html=html.replace(/<(\/?)s>/gi,"<$1strike>");html=html.replace(/&nbsp;/gi,' ');html=html.replace(/<span\s+style\s*=\s*"\s*mso-spacerun\s*:\s*yes\s*;?\s*"\s*>([\s\u00a0]*)<\/span>/gi,function(str,spaces){return spaces.length>0?spaces.replace(/./," ").slice(Math.floor(spaces.length/2)).split("").join("\xA0"):'';});// build wrapper
var $wrapper=this.utils.buildWrapper(html);// footnote fix
$wrapper.find('.MsoFootnoteText').each(function(node){var $node=$R.dom(node);var $parent=$node.parent();if($parent.length!==0&&$parent.attr('style').search(/mso-element:footnote/)!==-1){$node.find('a').attr('id','_'+$parent.attr('id'));}});$wrapper.find('.MsoFootnoteReference').each(function(node){var $node=$R.dom(node);var $parent=$node.parent();if($parent.length!==0&&$parent.get().tagName==='A'){$parent.attr('id',$parent.attr('name'));}});// build lists
$wrapper.find('p').each(function(node){var $node=$R.dom(node);var str=$node.attr('style');var matches=/mso-list:\w+ \w+([0-9]+)/.exec(str);if(matches){$node.attr('data-listLevel',parseInt(matches[1],10));}});// parse Lists
this._parseWordLists($wrapper);$wrapper.find('[align]').removeAttr('align');$wrapper.find('[name]').removeAttr('name');$wrapper.find('span').each(function(node){var $node=$R.dom(node);var str=$node.attr('style');var matches=/mso-list:Ignore/.exec(str);if(matches)$node.remove();else $node.unwrap();});$wrapper.find('[style]').removeAttr('style');$wrapper.find("[class^='Mso']").removeAttr('class');$wrapper.find('a').filter(function(node){return!node.hasAttribute('href');}).unwrap();// get wrapper
html=this.utils.getWrapperHtml($wrapper);html=html.replace(/<p[^>]*><\/p>/gi,'');html=html.replace(/<li>·/gi,'<li>');html=html.trim();// remove spaces between
html=html.replace(/\/(p|ul|ol|h1|h2|h3|h4|h5|h6|blockquote)>\s+<(p|ul|ol|h1|h2|h3|h4|h5|h6|blockquote)/gi,'/$1>\n<$2');var result='';var lines=html.split(/\n/);for(var i=0;i<lines.length;i++){var space=lines[i]!==''&&lines[i].search(/>$/)===-1?' ':'\n';result+=lines[i]+space;}return result;},_parseWordLists:function _parseWordLists($wrapper){var lastLevel=0;var $item=null;var $list=null;var $listChild=null;$wrapper.find('p').each(function(node){var $node=$R.dom(node);var level=$node.attr('data-listLevel');if(level===null&&$node.hasClass('MsoListParagraphCxSpMiddle')){level=1;}if(level!==null){var txt=$node.text();var listTag=/^\s*\w+\./.test(txt)?'<ol></ol>':'<ul></ul>';// new parent list
if($node.hasClass('MsoListParagraphCxSpFirst')||$node.hasClass('MsoNormal')){$list=$R.dom(listTag);$node.before($list);}// new child list
else if(level>lastLevel&&lastLevel!==0){$listChild=$R.dom(listTag);$item.append($listChild);$list=$listChild;}// level up
if(level<lastLevel){var len=lastLevel-level+1;for(var i=0;i<len;i++){$list=$list.parent();}}// create item
$node.find('span').first().unwrap();$item=$R.dom('<li>'+$node.html().trim()+'</li>');if($list===null){$node.before(listTag);$list=$node.prev();}// append
$list.append($item);$node.remove();lastLevel=level;}else{$list=null;lastLevel=0;}});},// is
_isSpacedEmpty:function _isSpacedEmpty(html){return html.search(this.reSpacedEmpty)!==-1;},_isParagraphEmpty:function _isParagraphEmpty(html){return html.search(/^<p><\/p>$/i)!==-1;},_isHtmlMsWord:function _isHtmlMsWord(html){return html.match(/class="?Mso|style="[^"]*\bmso-|style='[^'']*\bmso-|w:WordDocument/i);},// set
_setSpanAttr:function _setSpanAttr(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('span').attr('data-redactor-span',true);return this.utils.getWrapperHtml($wrapper);},_setStyleCache:function _setStyleCache(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('[style]').each(function(node){var $el=$R.dom(node);$el.attr('data-redactor-style-cache',$el.attr('style'));});return this.utils.getWrapperHtml($wrapper);},_setPreClass:function _setPreClass(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('pre').addClass(this.opts.preClass);return this.utils.getWrapperHtml($wrapper);},_setLinkNofollow:function _setLinkNofollow(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('a').attr('rel','nofollow');return this.utils.getWrapperHtml($wrapper);},// replace
_replaceScriptTag:function _replaceScriptTag(html){return html.replace(this.reScriptTag,'<script class="redactor-script-tag" $1>$2</script>');},_unreplaceScriptTag:function _unreplaceScriptTag(html){return html.replace(/<script class="redactor-script-tag"(.*?[^>]?)>([\w\W]*?)<\/script>/gi,'<script$1>$2</script>');},_replaceNlToBr:function _replaceNlToBr(html){return html.replace(/\n/g,'<br />');},// remove
_removeScriptTag:function _removeScriptTag(html){return html.replace(this.reScriptTag,'');},// private
_storeMatched:function _storeMatched(html,matched,stored,name){this['stored'+stored]=[];if(matched){for(var i=0;i<matched.length;i++){this['stored'+stored][i]=matched[i];html=html.replace(matched[i],'####'+name+i+'####');}}return html;},_restoreMatched:function _restoreMatched(html,stored,name){if(this['stored'+stored]){for(var i=0;i<this['stored'+stored].length;i++){html=html.replace('####'+name+i+'####',this['stored'+stored][i]);}}return html;}});$R.add('class','cleaner.figure',{init:function init(app){this.app=app;this.opts=app.opts;this.utils=app.utils;this.detector=app.detector;},// public
convert:function convert(html,rules){var $wrapper=this.utils.buildWrapper(html);// convert
$wrapper.find('img').each(this._convertImage.bind(this));$wrapper.find('hr').each(this._convertLine.bind(this));$wrapper.find('iframe').each(this._convertIframe.bind(this));$wrapper.find('table').each(this._convertTable.bind(this));$wrapper.find('form').each(this._convertForm.bind(this));$wrapper.find('figure pre').each(this._convertCode.bind(this));// variables
$wrapper.find('[data-redactor-type=variable]').addClass('redactor-component');// widgets
$wrapper.find('figure').not('.redactor-component, .redactor-figure-code').each(this._convertWidget.bind(this));// contenteditable
$wrapper.find('figure pre').each(this._setContenteditableCode.bind(this));$wrapper.find('.redactor-component, .non-editable').attr('contenteditable',false);if(this.detector.isIe()){$wrapper.find('[data-redactor-type=table]').removeAttr('contenteditable');}$wrapper.find('figcaption, td, th').attr('contenteditable',true);$wrapper.find('.redactor-component, figcaption').attr('tabindex','-1');// extra rules
this._acceptExtraRules($wrapper,rules);return this.utils.getWrapperHtml($wrapper);},unconvert:function unconvert(html,rules){html=html.replace(/<\/([^>]+)><div data-redactor-tag/g,'</$1>\n<div data-redactor-tag');html=html.replace(/<\/([^>]+)><p/g,'</$1>\n<p');var $wrapper=this.utils.buildWrapper(html);// contenteditable
$wrapper.find('th, td, figcaption, figure, pre, code, .redactor-component').removeAttr('contenteditable tabindex');// remove class
$wrapper.find('figure').removeClass('redactor-component redactor-component-active redactor-uploaded-figure');// unconvert
$wrapper.find('[data-redactor-type=variable]').removeClass('redactor-component redactor-component-active');$wrapper.find('figure[data-redactor-type=line]').unwrap();$wrapper.find('figure[data-redactor-type=widget]').each(this._unconvertWidget.bind(this));$wrapper.find('figure[data-redactor-type=form]').each(this._unconvertForm.bind(this));$wrapper.find('figure[data-redactor-type=table]').each(this._unconvertTable.bind(this));$wrapper.find('figure[data-redactor-type=image]').removeAttr('rel').each(this._unconvertImages.bind(this));$wrapper.find('img').removeAttr('data-redactor-type').removeClass('redactor-component');$wrapper.find('.non-editable').removeAttr('contenteditable');// remove types
$wrapper.find('figure').each(this._removeTypes.bind(this));// remove caret
$wrapper.find('span.redactor-component-caret').remove();// break div
$wrapper=this._unconvertBreakTag($wrapper);// extra rules
this._acceptExtraRules($wrapper,rules);html=this.utils.getWrapperHtml($wrapper);html=html.replace(/<br\s?\/?>$/,'');html=html.replace(/<br\s?\/?><\/(td|th)>/,'</$1>');return html;},// private
_convertImage:function _convertImage(node){var $node=$R.dom(node);if(this._isNonEditable($node))return;// set id
if(this.opts.imageObserve&&!$node.attr('data-image')){$node.attr('data-image',this.utils.getRandomId());}var $link=$node.closest('a');var $figure=$node.closest('figure');var isImage=$figure.children().not('a, img, br, figcaption').length===0;if(!isImage)return;if($figure.length===0){var $parent=$link.length!==0?$link.closest('p'):$node.closest('p');if(this.opts.imageFigure===false&&$parent.length!==0){var $el=this.utils.replaceToTag($parent,'figure');$figure=$el;$figure.addClass('redactor-replace-figure');}else{if($parent.length!==0){$parent.unwrap();}$figure=$link.length!==0?$link.wrap('<figure>'):$node.wrap('<figure>');}}else{if($figure.hasClass('redactor-uploaded-figure')){$figure.removeClass('redactor-uploaded-figure');}else{$figure.addClass('redactor-keep-figure');}}this._setFigure($figure,'image');},_convertTable:function _convertTable(node){if(this._isNonEditable(node))return;var $figure=this._wrapFigure(node);this._setFigure($figure,'table');},_convertLine:function _convertLine(node){if(this._isNonEditable(node))return;var $figure=this._wrapFigure(node);this._setFigure($figure,'line');},_convertForm:function _convertForm(node){if(this._isNonEditable(node))return;var $figure=this.utils.replaceToTag(node,'figure');this._setFigure($figure,'form');},_convertIframe:function _convertIframe(node){if(this._isNonEditable(node))return;var $node=$R.dom(node);if($node.closest('.redactor-component').length!==0)return;var src=node.getAttribute('src');var isVideo=src&&(src.match(this.opts.regex.youtube)||src.match(this.opts.regex.vimeo));var $figure=this._wrapFigure(node);if(isVideo){this._setFigure($figure,'video');}},_convertCode:function _convertCode(node){if(this._isNonEditable(node))return;var $figure=this._wrapFigure(node);this._setFigure($figure,'code');},_convertWidget:function _convertWidget(node){if(this._isNonEditable(node))return;var $node=$R.dom(node);$node.addClass('redactor-component');$node.attr('data-redactor-type','widget');$node.attr('data-widget-code',encodeURI(node.innerHTML.trim()));},// unconvert
_unconvertBreakTag:function _unconvertBreakTag($wrapper){$wrapper.find('[data-redactor-tag]').each(function(node){var $node=$R.dom(node);$node.removeAttr('data-redactor-tag');if(node.attributes.length!==0){if(node.lastChild&&node.lastChild.tagName==='BR')$R.dom(node.lastChild).remove();return;}if(node.lastChild&&node.lastChild.tagName==='BR'){$node.unwrap();}else{var $next=$node.nextElement();if($next.length!==0&&$next.attr('data-redactor-tag')){node.appendChild(document.createElement('br'));}$node.unwrap();}}.bind(this));return $wrapper;},_unconvertForm:function _unconvertForm(node){this.utils.replaceToTag(node,'form');},_unconvertTable:function _unconvertTable(node){var $node=$R.dom(node);$node.unwrap();},_unconvertWidget:function _unconvertWidget(node){var $node=$R.dom(node);$node.html(decodeURI($node.attr('data-widget-code')));$node.removeAttr('data-widget-code');},_unconvertImages:function _unconvertImages(node){var $node=$R.dom(node);$node.removeClass('redactor-component');var isList=$node.closest('li').length!==0;var isTable=$node.closest('table').length!==0;var hasFigcaption=$node.find('figcaption').length!==0;var style=$node.attr('style');var hasStyle=!(style===null||style==='');var hasClass=$node.attr('class')!=='';if(isList||isTable&&!hasFigcaption&&!hasStyle&&!hasClass){$node.unwrap();}},_removeTypes:function _removeTypes(node){var $node=$R.dom(node);var type=$node.attr('data-redactor-type');var removed=['image','widget','line','video','code','form','table'];if(type&&removed.indexOf(type)!==-1){$node.removeAttr('data-redactor-type');}// keep figure
if($node.hasClass('redactor-keep-figure')){$node.removeClass('redactor-keep-figure');}// unwrap figure
else if(type==='image'&&this.opts.imageFigure===false){var hasFigcaption=$node.find('figcaption').length!==0;if(!hasFigcaption){// replace
if($node.hasClass('redactor-replace-figure')){$node.removeClass('redactor-replace-figure');this.utils.replaceToTag($node,'p');}else{this.utils.replaceToTag($node,'p');}}}$node.removeClass('redactor-replace-figure');},// wrap
_wrapFigure:function _wrapFigure(node){var $node=$R.dom(node);var $figure=$node.closest('figure');return $figure.length===0?$node.wrap('<figure>'):$figure;},// set
_setFigure:function _setFigure($figure,type){$figure.addClass('redactor-component');$figure.attr('data-redactor-type',type);},_setContenteditableCode:function _setContenteditableCode(node){if(this._isNonEditable(node))return;var $node=$R.dom(node);var $code=$node.children('code').first();var $el=$code.length!==0?$code:$node;$el.attr('contenteditable',true).attr('tabindex','-1');},// utils
_acceptExtraRules:function _acceptExtraRules($wrapper,rules){for(var key in rules){if(typeof rules[key]==='function'){rules[key]($wrapper);}}},_isNonEditable:function _isNonEditable(node){return $R.dom(node).closest('.non-editable').length!==0;}});$R.add('class','cleaner.paragraphize',{init:function init(app){this.app=app;this.opts=app.opts;this.utils=app.utils;this.cleaner=app.cleaner;this.element=app.element;// local
this.stored=[];this.remStart='#####replace';this.remEnd='#####';this.paragraphizeTags=['table','div','pre','form','ul','ol','h1','h2','h3','h4','h5','h6','dl','blockquote','figcaption','address','section','header','footer','aside','article','object','style','script','iframe','select','input','textarea','button','option','map','area','math','hr','fieldset','legend','hgroup','nav','figure','details','menu','summary','p'];},// public
convert:function convert(html){var value=this._isConverted(html);value=value===true?this._convert(html):value;value=this._convertTable(value);return value;},// private
_convert:function _convert(html,tablemarkup){// build markup tag
var tag=this.opts.breakline||tablemarkup?'sdivtag':this.opts.markup;var attr=tablemarkup?'tbr':'br';// store
html=this._storeTags(html);var storedComments=[];html=this.cleaner.storeComments(html,storedComments);// trim
html=html.trim();html=this._trimLinks(html);// trim new line in inline
var inlines=this.opts.inlineTags.join('|');html=html.replace(new RegExp('<('+inlines+')(.*?[^>]?)>\n</('+inlines+')>','gi'),'<$1$2></$3>');// replace new lines
html=html.replace(/xparagraphmarkerz(?:\r\n|\r|\n)$/g,'');html=html.replace(/xparagraphmarkerz$/g,'');html=html.replace(/xparagraphmarkerz(?:\r\n|\r|\n)/g,'\n');html=html.replace(/xparagraphmarkerz/g,'\n');if(this.opts.breakline){html=html.replace(/<br\s?\/?>(?:\r\n|\r|\n)/gi,'xbreakmarkerz\n');html=html.replace(/<br\s?\/?>/gi,'xbreakmarkerz\n');html=html.replace(/xbreakmarkerz\n<\//gi,'xbreakmarkerz</');}else{html=html.replace(/[\n]+/g,"\n");}// wrap to tag
var str='';var arr=html.split("\n");for(var i=0;i<arr.length;i++){str+='<'+tag+'>'+arr[i]+'</'+tag+'>\n';}html=str.replace(/\n$/,'');// clean
html=html.replace(new RegExp('<'+tag+'>\\s+#####','gi'),'#####');html=html.replace(new RegExp('<'+tag+'>#####','gi'),'#####');html=html.replace(new RegExp('#####</'+tag+'>','gi'),'#####');// replace marker
html=this.opts.breakline?html.replace(/xbreakmarkerz/gi,"<br>"):html;// restore
html=this._restoreTags(html);html=this.cleaner.restoreComments(html,storedComments);// remove empty
if(this.opts.breakline){html=html.replace(new RegExp('<'+tag+'></'+tag+'>','gi'),'<'+tag+'><br></'+tag+'>');}else{//html = html.replace(new RegExp('<' + tag + '><br\\s?/?></' + tag + '>', 'gi'), '');
//html = html.replace(new RegExp('<' + tag + '></' + tag + '>', 'gi'), '');
}// clean restored
html=html.replace(new RegExp('<sdivtag>','gi'),'<div data-redactor-tag="'+attr+'">');html=html.replace(new RegExp('sdivtag','gi'),'div');html=html.replace(/<\/([^>]+)><div data-redactor-tag/g,'</$1>\n<div data-redactor-tag');return html;},_convertTable:function _convertTable(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('td, th').each(this._convertCell.bind(this));html=this.utils.getWrapperHtml($wrapper);return html;},_convertCell:function _convertCell(node){var $node=$R.dom(node);this.stored=[];var code=this._convert($node.html(),true);$node.html(code);},_storeTags:function _storeTags(html){var self=this;var $wrapper=this.utils.buildWrapper(html);$wrapper.find(this.paragraphizeTags.join(', ')).each(function(node,i){var replacement=document.createTextNode(self.remStart+i+self.remEnd+'xparagraphmarkerz');//  + "\n"
self.stored.push(node.outerHTML);node.parentNode.replaceChild(replacement,node);});return this.utils.getWrapperHtml($wrapper);},_restoreTags:function _restoreTags(html){for(var i=0;i<this.stored.length;i++){this.stored[i]=this.stored[i].replace(/\$/g,'&#36;');html=html.replace(this.remStart+i+this.remEnd,this.stored[i]);}return html;},_trimLinks:function _trimLinks(html){var $wrapper=this.utils.buildWrapper(html);$wrapper.find('a').each(this._trimLink.bind(this));html=this.utils.getWrapperHtml($wrapper);return html;},_trimLink:function _trimLink(node){var $node=$R.dom(node);$node.html($node.html().trim());},_isConverted:function _isConverted(html){if(this._isDisabled(html))return html;else if(this._isEmptyHtml(html))return this.opts.emptyHtml;else return true;},_isDisabled:function _isDisabled(){return this.opts.paragraphize===false||this.element.isType('inline');},_isEmptyHtml:function _isEmptyHtml(html){return html===''||html==='<p></p>'||html==='<div></div>';}});$R.add('service','detector',{init:function init(app){this.app=app;// local
this.userAgent=navigator.userAgent.toLowerCase();},isWebkit:function isWebkit(){return /webkit/.test(this.userAgent);},isFirefox:function isFirefox(){return this.userAgent.indexOf('firefox')>-1;},isIe:function isIe(v){if(document.documentMode||/Edge/.test(navigator.userAgent))return'edge';var ie;ie=RegExp('msie'+(!isNaN(v)?'\\s'+v:''),'i').test(navigator.userAgent);if(!ie)ie=!!navigator.userAgent.match(/Trident.*rv[ :]*11\./);return ie;},isMobile:function isMobile(){return /(iPhone|iPod|Android)/.test(navigator.userAgent);},isDesktop:function isDesktop(){return!/(iPhone|iPod|iPad|Android)/.test(navigator.userAgent);},isIpad:function isIpad(){return /iPad/.test(navigator.userAgent);}});$R.add('service','offset',{init:function init(app){this.app=app;},get:function get(el,trimmed){var offset={start:0,end:0};var node=this.utils.getNode(el);if(!node)return false;var isEditor=this.editor.isEditor(node);var isIn=isEditor?true:this.selection.isIn(node);var range=this.selection.getRange();if(!isEditor&&!isIn){offset=false;}else if(this.selection.is()&&isIn){var $startNode=$R.dom(range.startContainer);var fix=$startNode.hasClass('redactor-component')?range.startOffset:0;var clonedRange=range.cloneRange();clonedRange.selectNodeContents(node);clonedRange.setEnd(range.startContainer,range.startOffset);var selection=this._getString(range,trimmed);offset.start=this._getString(clonedRange,trimmed).length-fix;offset.end=offset.start+selection.length+fix;}return offset;},set:function set(offset,el){if(this._setComponentOffset(el))return;this.component.clearActive();var node=this.utils.getNode(el);if(!node)return;var size=this.size(node);var charIndex=0,range=document.createRange();offset.end=offset.end>size?size:offset.end;range.setStart(node,0);range.collapse(true);var nodeStack=[node],foundStart=false,stop=false;while(!stop&&(node=nodeStack.pop())){if(node.nodeType===3){var nextCharIndex=charIndex+node.length;if(!foundStart&&!this._isFigcaptionNext(node)&&offset.start>=charIndex&&offset.start<=nextCharIndex){range.setStart(node,offset.start-charIndex);foundStart=true;}if(foundStart&&offset.end>=charIndex&&offset.end<=nextCharIndex){range.setEnd(node,offset.end-charIndex);stop=true;}charIndex=nextCharIndex;}else{var i=node.childNodes.length;while(i--){nodeStack.push(node.childNodes[i]);}}}this.selection.setRange(range);},size:function size(el,trimmed){var node=this.utils.getNode(el);if(node){var range=document.createRange();var clonedRange=range.cloneRange();clonedRange.selectNodeContents(node);return this._getString(clonedRange,trimmed).length;}return 0;},// private
_getString:function _getString(obj,trimmed){var str=obj.toString();str=this.editor.isEmpty()?str.replace(/\uFEFF/g,''):str;str=trimmed?str.trim():str;return str;},_setComponentOffset:function _setComponentOffset(el){return this.component.isNonEditable(el)?this.component.setActive(el):false;},_isFigcaptionNext:function _isFigcaptionNext(node){var next=node.nextSibling;return node.nodeValue.trim()===''&&next&&next.tagName==='FIGCAPTION';}});$R.add('service','inspector',{init:function init(app){this.app=app;},// parse
parse:function parse(el){return $R.create('inspector.parser',this.app,this,el);},// text detection
isText:function isText(el){if(typeof el==='string'&&!/^\s*<(\w+|!)[^>]*>/.test(el)){return true;}var node=$R.dom(el).get();return node&&node.nodeType===3;//  && !this.selection.getBlock(el)
},// tag detection
isInlineTag:function isInlineTag(tag,extend){var tags=this._extendTags(this.opts.inlineTags,extend);return this._isTag(tag)&&tags.indexOf(tag.toLowerCase())!==-1;},isBlockTag:function isBlockTag(tag,extend){var tags=this._extendTags(this.opts.blockTags,extend);return this._isTag(tag)&&tags.indexOf(tag.toLowerCase())!==-1;},isTableCellTag:function isTableCellTag(tag){return['td','th'].indexOf(tag.toLowerCase())!==-1;},isHeadingTag:function isHeadingTag(tag){return['h1','h2','h3','h4','h5','h6'].indexOf(tag.toLowerCase())!==-1;},_isTag:function _isTag(tag){return tag!==undefined&&tag;},_extendTags:function _extendTags(tags,extend){tags=tags.concat(tags);if(extend){for(var i=0;i<extend.length;i++){tags.push(extend[i]);}}return tags;}});$R.add('class','inspector.parser',{init:function init(app,inspector,el){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.utils=app.utils;this.editor=app.editor;this.selection=app.selection;this.inspector=inspector;// local
this.el=el;this.$el=$R.dom(this.el,'.redactor-in-'+this.uuid);this.node=this.$el.get();// comment node
if(this.node&&this.node.nodeType===8){this.node=false;}this.$component=this.$el.closest('.redactor-component','.redactor-in');},// is
isEditor:function isEditor(){return this.node===this.editor.getElement().get();},isInEditor:function isInEditor(){return this.$el.parents('.redactor-in-'+this.uuid).length!==0;},isComponent:function isComponent(){return this.$component.length!==0;},isComponentType:function isComponentType(type){return this.getComponentType()===type;},isComponentActive:function isComponentActive(){return this.isComponent()&&this.$component.hasClass('redactor-component-active');},isComponentEditable:function isComponentEditable(){var types=['code','table'];var type=this.getComponentType();return this.isComponent()&&types.indexOf(type)!==-1;},isFigcaption:function isFigcaption(){return this.getFigcaption();},isPre:function isPre(){return this.getPre();},isCode:function isCode(){var $code=this.$el.closest('code');var $parent=$code.parent('pre');return $code.length!==0&&$parent.length===0;},isList:function isList(){return this.getList();},isFirstListItem:function isFirstListItem(){return this._getLastOrFirstListItem('first');},isLastListItem:function isLastListItem(){return this._getLastOrFirstListItem('last');},isFirstTableCell:function isFirstTableCell(){return this._getLastOrFirstTableCell('first');},isLastTableCell:function isLastTableCell(){return this._getLastOrFirstTableCell('last');},isTable:function isTable(){return this.isComponentType('table')||this.getTable();},isHeading:function isHeading(){return this.getHeading();},isBlockquote:function isBlockquote(){return this.getBlockquote();},isDl:function isDl(){return this.getDl();},isParagraph:function isParagraph(){return this.getParagraph();},isLink:function isLink(){return this.getLink();},isFile:function isFile(){return this.getFile();},isText:function isText(){return this.inspector.isText(this.el);},isInline:function isInline(){var tags=this.opts.inlineTags;return this.isElement()?tags.indexOf(this.node.tagName.toLowerCase())!==-1:false;},isBlock:function isBlock(){var tags=this.opts.blockTags;return this.isElement()?tags.indexOf(this.node.tagName.toLowerCase())!==-1:false;},isElement:function isElement(){return this.node&&this.node.nodeType&&this.node.nodeType!==3;},// has
hasParent:function hasParent(tags){return this.$el.closest(tags.join(',')).length!==0;},// get
getNode:function getNode(){return this.node;},getTag:function getTag(){return this.isElement()?this.node.tagName.toLowerCase():false;},getComponent:function getComponent(){return this.isComponent()?this.$component.get():false;},getComponentType:function getComponentType(){return this.isComponent()?this.$component.attr('data-redactor-type'):false;},getFirstNode:function getFirstNode(){return this.utils.getFirstNode(this.node);},getLastNode:function getLastNode(){return this.utils.getLastNode(this.node);},getFirstElement:function getFirstElement(){return this.utils.getFirstElement(this.node);},getLastElement:function getLastElement(){return this.utils.getLastElement(this.node);},getFigcaption:function getFigcaption(){return this._getClosestNode('figcaption');},getPre:function getPre(){return this._getClosestNode('pre');},getCode:function getCode(){return this._getClosestNode('code');},getList:function getList(){return this._getClosestNode('ul, ol');},getParentList:function getParentList(){return this._getClosestUpNode('ul, ol');},getListItem:function getListItem(){return this._getClosestNode('li');},getTable:function getTable(){if(this.getComponentType('table')){return this.$component.find('table').get();}else{return this._getClosestNode('table');}},getTableCell:function getTableCell(){var $td=this.$el.closest('td, th');return $td.length!==0?$td.get():false;},getComponentCodeElement:function getComponentCodeElement(){return this.isComponentType('code')?this.$component.find('pre code, pre').last().get():false;},getImageElement:function getImageElement(){return this.isComponentType('image')?this.$component.find('img').get():false;},getParagraph:function getParagraph(){return this._getClosestNode('p');},getHeading:function getHeading(){return this._getClosestNode('h1, h2, h3, h4, h5, h6');},getDl:function getDl(){return this._getClosestNode('dl');},getBlockquote:function getBlockquote(){return this._getClosestNode('blockquote');},getLink:function getLink(){var isComponent=this.isComponent()&&!this.isFigcaption();var isTable=this.isComponentType('table');if(isTable||!isComponent){var $el=this._getClosestElement('a');return $el&&!$el.attr('data-file')?$el.get():false;}return false;},getFile:function getFile(){var isComponent=this.isComponent();var isTable=this.isComponentType('table');if(isTable||!isComponent){var $el=this._getClosestElement('a');return $el&&$el.attr('data-file')?$el.get():false;}return false;},// find
findFirstNode:function findFirstNode(selector){return this.$el.find(selector).first().get();},findLastNode:function findLastNode(selector){return this.$el.find(selector).last().get();},// private
_getLastOrFirstListItem:function _getLastOrFirstListItem(type){var list=this.getList();var tag=this.getTag();if(list&&tag==='li'){var item=$R.dom(list).find('li')[type]().get();if(item&&this.node===item){return true;}}return false;},_getLastOrFirstTableCell:function _getLastOrFirstTableCell(type){var table=this.getTable();var tag=this.getTag();if(table&&(tag==='td'||tag==='th')){var item=$R.dom(table).find('td, th')[type]().get();if(item&&this.node===item){return true;}}return false;},_getClosestUpNode:function _getClosestUpNode(selector){var $el=this.$el.parents(selector,'.redactor-in-'+this.uuid).last();return $el.length!==0?$el.get():false;},_getClosestNode:function _getClosestNode(selector){var $el=this.$el.closest(selector,'.redactor-in-'+this.uuid);return $el.length!==0?$el.get():false;},_getClosestElement:function _getClosestElement(selector){var $el=this.$el.closest(selector,'.redactor-in-'+this.uuid);return $el.length!==0?$el:false;}});$R.add('service','marker',{init:function init(app){this.app=app;},build:function build(pos,html){var marker=document.createElement('span');marker.id='selection-marker-'+this._getPos(pos);marker.className='redactor-selection-marker';marker.innerHTML=this.opts.markerChar;return html?marker.outerHTML:marker;},buildHtml:function buildHtml(pos){return this.build(pos,true);},insert:function insert(side){this.remove();var atStart=side!=='both'&&(side==='start'||this.selection.isCollapsed());if(!this.selection.is())this.editor.focus();var range=this.selection.getRange();if(range){var start=this.build('start');var end=this.build('end');var cloned=range.cloneRange();if(!atStart){cloned.collapse(false);cloned.insertNode(end);}cloned.setStart(range.startContainer,range.startOffset);cloned.collapse(true);cloned.insertNode(start);range.setStartAfter(start);if(!atStart){range.setEndBefore(end);}this.selection.setRange(range);return start;}},find:function find(pos,$context){var $editor=this.editor.getElement();var $marker=($context||$editor).find('span#selection-marker-'+this._getPos(pos));return $marker.length!==0?$marker.get():false;},restore:function restore(){var start=this.find('start');var end=this.find('end');var range=this.selection.getRange();if(!range||!this.selection.is()){this.editor.focus();range=document.createRange();}if(start){var prev=end?end.previousSibling:false;var next=start.nextSibling;next=next&&next.nodeType===3&&next.textContent.replace(/[\n\t]/g,'')===''?false:next;if(!end){if(next){range.selectNodeContents(next);range.collapse(true);}else{this._restoreInject(range,start);}}else if(next&&next.id==='selection-marker-end'){this._restoreInject(range,start);}else{if(prev&&next){range.selectNodeContents(prev);range.collapse(false);range.setStart(next,0);}else if(prev&&!next){range.selectNodeContents(prev);range.collapse(false);range.setStartAfter(start);}else{range.setStartAfter(start);range.setEndBefore(end);}}this.selection.setRange(range);if(start)start.parentNode.removeChild(start);if(end)end.parentNode.removeChild(end);}},remove:function remove(){var start=this.find('start');var end=this.find('end');if(start)start.parentNode.removeChild(start);if(end)end.parentNode.removeChild(end);},// private
_getPos:function _getPos(pos){return pos===undefined?'start':pos;},_restoreInject:function _restoreInject(range,start){var textNode=this.utils.createInvisibleChar();$R.dom(start).after(textNode);range.selectNodeContents(textNode);range.collapse(false);}});$R.add('service','component',{init:function init(app){this.app=app;// local
this.activeClass='redactor-component-active';},create:function create(type,el){return $R.create(type+'.component',this.app,el);},build:function build(el){var $el=$R.dom(el);var component;var type=$el.attr('data-redactor-type');if(type){component=this.create(type,el);}return component?component:el;},remove:function remove(el,caret){var $component=$R.dom(el).closest('.redactor-component');var type=$component.attr('data-redactor-type');var current=$component.parent();var data=this.inspector.parse(current);var prev=this.utils.findSiblings($component,'prev');var next=this.utils.findSiblings($component,'next');var stop=this.app.broadcast(type+'.delete',$component);if(stop!==false){$component.remove();// callback
this.app.broadcast(type+'.deleted',$component);this.app.broadcast('contextbar.close');this.app.broadcast('imageresizer.stop');if(caret!==false){var cell=data.getTableCell();if(cell&&this.utils.isEmptyHtml(cell.innerHTML)){this.caret.setStart(cell);}else if(next)this.caret.setStart(next);else if(prev)this.caret.setEnd(prev);else{this.editor.startFocus();}}// is empty
if(this.editor.isEmpty()){this.editor.setEmpty();this.editor.startFocus();this.app.broadcast('empty');}}},isNonEditable:function isNonEditable(el){var data=this.inspector.parse(el);return data.isComponent()&&!data.isComponentEditable();},isActive:function isActive(el){var $component;if(el){var data=this.inspector.parse(el);$component=$R.dom(data.getComponent());return $component.hasClass(this.activeClass);}else{$component=this._find();return $component.length!==0;}},getActive:function getActive(dom){var $component=this._find();return $component.length!==0?dom?$component:$component.get():false;},setActive:function setActive(el){this.clearActive();this.editor.focus();var data=this.inspector.parse(el);var component=data.getComponent();var $component=$R.dom(component);if(!data.isFigcaption()){var $caret=$component.find('.redactor-component-caret');if($caret.length===0){$caret=this._buildCaret();$component.prepend($caret);}this.caret.setAtStart($caret.get());}$component.addClass(this.activeClass);},clearActive:function clearActive(){var $component=this._find();$component.removeClass(this.activeClass);$component.find('.redactor-component-caret').remove();this.app.broadcast('imageresizer.stop');},setOnEvent:function setOnEvent(e,contextmenu){this.clearActive();var data=this.inspector.parse(e.target);if(data.isFigcaption()||data.isComponentEditable()){return;}// component
if(data.isComponent()){this.setActive(e.target);if(contextmenu!==true)e.preventDefault();}},executeScripts:function executeScripts(scripts){if(scripts===undefined){var $editor=this.editor.getElement();var scripts=$editor.find('[data-redactor-type]').find("script").getAll();this.executeScripts.call(this,scripts);}else{for(var i=0;i<scripts.length;i++){if(scripts[i].src!==''){var src=scripts[i].src;this.$doc.find('head script[src="'+src+'"]').remove();var $script=$R.dom('<script>');$script.attr('src',src);$script.attr('async defer');$script.get().onload=function(){if(src.search('instagram')!==-1)window.instgrm.Embeds.process();this.executeScripts(scripts.slice(i+1));}.bind(this);var head=document.getElementsByTagName('head')[0];if(head)head.appendChild($script.get());break;}else{try{eval(scripts[i].innerHTML);}catch(e){}}}}},// private
_find:function _find(){return this.editor.getElement().find('.'+this.activeClass);},_buildCaret:function _buildCaret(){var $caret=$R.dom('<span>');$caret.addClass('redactor-component-caret');$caret.attr('contenteditable',true);return $caret;}});$R.add('service','insertion',{init:function init(app){this.app=app;},set:function set(html,clean,focus){if(html===null){html='';}html=clean!==false?this.cleaner.input(html):html;html=clean!==false?this.cleaner.paragraphize(html):html;// set html
var $editor=this.editor.getElement();$editor.html(html);// set focus at the end
if(focus!==false)this.editor.endFocus();return html;},insertNode:function insertNode(node,caret){this.editor.focus();var fragment=this.utils.isFragment(node)?node:this.utils.createFragment(node);this._collapseSelection();this._insertFragment(fragment);this._setCaret(caret,fragment);return this._sendNodes(fragment.nodes);},insertBreakLine:function insertBreakLine(){return this.insertNode(document.createElement('br'),'after');},insertNewline:function insertNewline(){return this.insertNode(document.createTextNode('\n'),'after');},insertText:function insertText(text){return this.insertHtml(this.cleaner.getFlatText(text));},insertChar:function insertChar(charhtml){return this.insertNode(charhtml,'after');},insertRaw:function insertRaw(html){return this.insertHtml(html,false);},insertToEnd:function insertToEnd(lastNode,type){if(!lastNode)return;if(lastNode.nodeType===3&&lastNode.nodeValue.search(/^\n/)!==-1){lastNode=lastNode.previousElementSibling;}var $lastNode=$R.dom(lastNode);if($lastNode.attr('data-redactor-type')===type){var tag=this.opts.breakline?'<br>':'<p>';var $newNode=$R.dom(tag);$lastNode.after($newNode);this.caret.setStart($newNode);}},insertPoint:function insertPoint(e){var range,data;var marker=this.marker.build('start');var markerInserted=false;var x=e.clientX,y=e.clientY;if(document.caretPositionFromPoint){var pos=document.caretPositionFromPoint(x,y);var sel=document.getSelection();data=this.inspector.parse(pos.offsetNode);if(data.isInEditor()){range=sel.getRangeAt(0);range.setStart(pos.offsetNode,pos.offset);range.collapse(true);range.insertNode(marker);markerInserted=true;}}else if(document.caretRangeFromPoint){range=document.caretRangeFromPoint(x,y);data=this.inspector.parse(range.startContainer);if(data.isInEditor()){range.insertNode(marker);markerInserted=true;}}return markerInserted;},insertToPoint:function insertToPoint(e,html,point,clean){var pointInserted=point===true?true:this.insertPoint(e);if(!pointInserted){var lastNode=this.editor.getLastNode();$R.dom(lastNode).after(this.marker.build('start'));}this.component.clearActive();this.selection.restoreMarkers();return this.insertHtml(html,clean);},insertToOffset:function insertToOffset(start,html){this.offset.set({start:start,end:start});return this.insertHtml(html);},insertHtml:function insertHtml(html,clean){if(!this.opts.input)return;// parse
var parsedInput=this.utils.parseHtml(html);// all selection
if(this.selection.isAll()){return this._insertToAllSelected(parsedInput);}// there is no selection
if(!this.selection.is()){var $el=$R.dom('<p>');var $editor=this.editor.getElement();$editor.append($el);this.caret.setStart($el);}// environment
var isCollapsed=this.selection.isCollapsed();var isText=this.selection.isText();var current=this.selection.getCurrent();var block=this.selection.getBlock();var dataCurrent=this.inspector.parse(current);// collapse air
this._collapseSelection();// clean
parsedInput=this._getCleanedInput(parsedInput,dataCurrent,clean);// input is figure or component span
var isFigure=this._isFigure(parsedInput.html);var isComponentSpan=this._isComponentSpan(parsedInput.html);var isInsertedText=this.inspector.isText(parsedInput.html);var fragment,except;// multiple selection
//var blocks = this.selection.getBlocks();
//if (blocks && blocks.length > 1) {
//    parsedInput.html = (clean !== false) ? this.cleaner.paragraphize(parsedInput.html) : parsedInput.html;
//}
// empty editor
if(this.editor.isEmpty()){return this._insertToEmptyEditor(parsedInput.html);}// to component
else if(dataCurrent.isComponent()&&!dataCurrent.isComponentEditable()){return this._insertToWidget(current,dataCurrent,parsedInput.html);}// component span
else if(isComponentSpan){return this.insertNode(parsedInput.nodes,'end');}// inserting figure & split node
else if(isFigure&&!isText&&!dataCurrent.isList()){if(dataCurrent.isInline()){return this._insertToInline(current,parsedInput);}fragment=this.utils.createFragment(parsedInput.html);this.utils.splitNode(current,fragment);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);}// to code
else if(dataCurrent.isCode()){return this._insertToCode(parsedInput,current,clean);}// to pre
else if(dataCurrent.isPre()){return this._insertToPre(parsedInput,clean);}// to h1-h6 & figcaption
else if(dataCurrent.isHeading()||dataCurrent.isFigcaption()){parsedInput.html=clean!==false?this.cleaner.removeTagsExcept(parsedInput.html,['a']):parsedInput.html;parsedInput.html=clean!==false?this.cleaner.replaceNbspToSpaces(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);return this.insertNode(fragment,'end');}// breakline div
else if(this.opts.breakline&&block&&block.tagName==='DIV'){parsedInput.html=clean!==false?this.cleaner.paragraphize(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);var range=this.selection.getRange();if(range&&!this.selection.isCollapsed()){range.deleteContents();}this.utils.splitNode(current,fragment);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);}// text inserting
else if(isInsertedText){if(!isText&&this.opts.markup!=='br'&&this._hasBlocksAndImages(parsedInput.nodes)){parsedInput.html=clean!==false?this.cleaner.paragraphize(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);this.utils.splitNode(current,fragment);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);}parsedInput.html=clean!==false?parsedInput.html.replace(/\n/g,'<br>'):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);return this.insertNode(fragment.nodes,'end');}// uncollapsed
else if(!isCollapsed&&!isFigure){if(this._isPlainHtml(parsedInput.html)){return this.insertNode(parsedInput.nodes,'end');}parsedInput.html=clean!==false?this.cleaner.paragraphize(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);return this.insertNode(fragment,'end');}// to inline tag
else if(dataCurrent.isInline()&&!this._isPlainHtml(parsedInput.html)){return this._insertToInline(current,parsedInput);}// to blockquote or dt, dd
else if(dataCurrent.isBlockquote()||dataCurrent.isDl()){except=this.opts.inlineTags;except.concat(['br']);parsedInput.html=clean!==false?this.cleaner.replaceBlocksToBr(parsedInput.html):parsedInput.html;parsedInput.html=clean!==false?this.cleaner.removeTagsExcept(parsedInput.html,except):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);return this.insertNode(fragment,'end');}// to p
else if(dataCurrent.isParagraph()){if(this._isPlainHtml(parsedInput.html)){return this.insertNode(parsedInput.nodes,'end');}parsedInput.html=clean!==false?this.cleaner.paragraphize(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);this.utils.splitNode(current,fragment);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);}// to li
else if(dataCurrent.isList()){except=this.opts.inlineTags;except=except.concat(['br','li','ul','ol','img']);parsedInput.html=clean!==false?this.cleaner.replaceBlocksToBr(parsedInput.html):parsedInput.html;parsedInput.html=clean!==false?this.cleaner.removeTagsExcept(parsedInput.html,except):parsedInput.html;parsedInput.html=clean!==false?this.cleaner.removeBrAtEnd(parsedInput.html):parsedInput.html;fragment=this.utils.createFragment(parsedInput.html);parsedInput.nodes=fragment.nodes;if(this._containsTags(parsedInput.html,['ul','ol','li'])){var element=this.selection.getElement(current);if(element&&element.tagName==='LI'&&this.caret.isStart(element)){parsedInput.nodes=$R.dom(fragment.nodes).unwrap('ul, ol').getAll();$R.dom(element).before(parsedInput.nodes);var lastNode=parsedInput.nodes[parsedInput.nodes.length-1];this.caret.setEnd(lastNode);return this._sendNodes(parsedInput.nodes);}else if(this._isPlainHtml(parsedInput.html)){return this.insertNode(fragment,'end');}else{fragment=this._buildList(parsedInput,element,fragment);this.utils.splitNode(current,fragment,true);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);}}}// other cases
return this.insertNode(parsedInput.nodes,'end');},// private
_insertToAllSelected:function _insertToAllSelected(parsedInput){var insertedHtml=this.set(parsedInput.html);var dataInserted=this.utils.parseHtml(insertedHtml);return this._sendNodes(dataInserted.nodes);},_insertToEmptyEditor:function _insertToEmptyEditor(html){html=this.cleaner.paragraphize(html);var fragment=this.utils.createFragment(html);var $editor=this.editor.getElement();$editor.html('');$editor.append(fragment.frag);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);},_insertToInline:function _insertToInline(current,parsedInput){var fragment=this.utils.createFragment(parsedInput.html);this.utils.splitNode(current,fragment,false,true);this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);},_insertToCode:function _insertToCode(parsedInput,current,clean){parsedInput.html=clean!==false?this.cleaner.encodeHtml(parsedInput.html):parsedInput.html;parsedInput.html=clean!==false?this.cleaner.removeNl(parsedInput.html):parsedInput.html;var fragment=this.utils.createFragment(parsedInput.html);var nodes=this.insertNode(fragment,'end');this.utils.normalizeTextNodes(current);return nodes;},_insertToPre:function _insertToPre(parsedInput,clean){parsedInput.html=clean!==false?this.cleaner.encodeHtml(parsedInput.html):parsedInput.html;var fragment=this.utils.createFragment(parsedInput.html);return this.insertNode(fragment,'end');},_insertToWidget:function _insertToWidget(current,dataCurrent,html){html=this._isComponentSpan(html)?html:this.cleaner.paragraphize(html);var fragment=this.utils.createFragment(html);var component=dataCurrent.getComponent();var $component=$R.dom(component);$component.after(fragment.frag);$component.remove();this.caret.setEnd(fragment.last);return this._sendNodes(fragment.nodes);},_insertFragment:function _insertFragment(fragment){var range=this.selection.getRange();if(range){if(this.selection.isCollapsed()){var startNode=range.startContainer;if(startNode.nodeType!==3&&startNode.tagName==='BR'){this.caret.setAfter(startNode);startNode.parentNode.removeChild(startNode);}}else{range.deleteContents();}range.insertNode(fragment.frag);}},_sendNodes:function _sendNodes(nodes){for(var i=0;i<nodes.length;i++){var el=nodes[i];var type=el.nodeType!==3&&typeof el.getAttribute==='function'?el.getAttribute('data-redactor-type'):false;if(type){this.app.broadcast(type+'.inserted',this.component.build(el));}}if(this.detector.isIe()){this.editor.getElement().find('[data-redactor-type=table]').attr('contenteditable',true);}// callback
this.app.broadcast('inserted',nodes);// widget's scripts
this.component.executeScripts();return nodes;},_setCaret:function _setCaret(caret,fragment){var isLastInline=this._isLastInline(fragment);if(caret){caret=isLastInline&&caret==='end'?'after':caret;this.caret['set'+this.utils.ucfirst(caret)](fragment.last);}else if(caret!==false){if(isLastInline)this.caret.setAfter(fragment.last);}},_isLastInline:function _isLastInline(fragment){if(fragment.last){var data=this.inspector.parse(fragment.last);return data.isInline();}return false;},_getCleanedInput:function _getCleanedInput(parsedInput,dataCurrent,clean){var isPreformatted=dataCurrent.isCode()||dataCurrent.isPre();parsedInput.html=parsedInput.html.replace(/&nbsp;/g,' ');parsedInput.html=!isPreformatted&&clean!==false?this.cleaner.input(parsedInput.html):parsedInput.html;parsedInput=!isPreformatted&&clean!==false?this.utils.parseHtml(parsedInput.html):parsedInput;return parsedInput;},_getContainer:function _getContainer(nodes){return $R.dom(this.utils.createTmpContainer(nodes));},_buildList:function _buildList(parsedInput,list,fragment){var nodes=parsedInput.nodes;var first=nodes[0];if(first&&first.nodeType!==3&&first.tagName==='li'){var $parent=$R.dom(list);var parentListTag=$parent.get().tagName.toLowerCase();var $list=$R.dom('<'+parentListTag+' />');$list.append(fragment.nodes);return this.utils.createFragment($list.get().outerHTML);}return fragment;},_containsTags:function _containsTags(html,tags){return this._getContainer(html).find(tags.join(',')).length!==0;},_collapseSelection:function _collapseSelection(){//if (this.app.isAirToolbar()) this.selection.collapseToEnd();
},_hasFigureOrTable:function _hasFigureOrTable(nodes){return this._getContainer(nodes).find('figure, table').length!==0;},_hasBlocks:function _hasBlocks(nodes){return this._getContainer(nodes).find(this.opts.blockTags.join(',')).length!==0;},_hasBlocksAndImages:function _hasBlocksAndImages(nodes){return this._getContainer(nodes).find(this.opts.blockTags.join(',')+',img').length!==0;},_isPlainHtml:function _isPlainHtml(html){return this._getContainer(html).find(this.opts.blockTags.join(',')+', img').length===0;},_isFigure:function _isFigure(html){if(this._isHtmlString(html)){return $R.dom(html).closest('figure').length!==0;}},_isComponentSpan:function _isComponentSpan(html){if(this._isHtmlString(html)){return $R.dom(html).closest('span.redactor-component').length!==0;}},_isHtmlString:function _isHtmlString(html){return!(typeof html==='string'&&!/^\s*<(\w+|!)[^>]*>/.test(html));}});$R.add('service','block',{init:function init(app){this.app=app;this.tags=['p','div','blockquote','pre','h1','h2','h3','h4','h5','h6'];},// format
format:function format(args){// params
this.params={args:false};// type of applying styles and attributes
this.params.type=args.type?args.type:'set';// add, remove, toggle
// tag
this.params.tag=typeof args==='string'?args:args.tag||this.opts.markup;this.params.tag=this.params.tag.toLowerCase();// args
this.params.args={'class':args['class']||false,'style':args['style']||false,'attr':args['attr']||false};if(!args['class']&&!args['style']&&!args['attr']){this.params.args=false;}// format
return this._format();},// funcs
add:function add(args,tags,el){return this._apply('add',args,tags,true,el);},set:function set(args,tags){return this._apply('set',args,tags);},toggle:function toggle(args,tags){return this._apply('toggle',args,tags);},remove:function remove(args,tags){return this._apply('remove',args,tags);},// clear
clearFormat:function clearFormat(tags){return this._clear(tags,'all');},clearStyle:function clearStyle(tags){return this._clear(tags,'style');},clearClass:function clearClass(tags){return this._clear(tags,'class');},clearAttr:function clearAttr(tags){return this._clear(tags,'attr');},// format
_format:function _format(){var nodes=[];// collapsed
this.collapsed=this.selection.isCollapsed();// save selection
this.selection.save();// blocks
var block=this.selection.getBlock();var blocks=this._getBlocks();var type=this._isToggleFormatType(blocks)?'toggle':'set';var replacedTag=this._getReplacedTag(type);nodes=this._replaceBlocks(blocks,replacedTag);// apply args & clean
nodes=this._buildNodes(nodes);// restore selection
this._restoreSelection(nodes);return nodes;},// clear
_clear:function _clear(tags,type,selection,nodes){// save selection
if(selection!==false){this.selection.save();}// get elements
var $elements=this._getElements(tags,nodes);// remove all format
if(type==='all'){this._removeAllAttr($elements,false);}// remove style
else if(type==='style'){$elements.removeAttr('style');$elements.removeAttr('data-redactor-style-cache');}// remove class
else if(type==='class'){$elements.removeAttr('class');}// remove attrs
else if(type==='attr'){this._removeAllAttr($elements);}// get nodes
nodes=$elements.getAll();// restore selection
if(selection!==false){this._restoreSelection(nodes);}return nodes;},// get
_getElements:function _getElements(tags,nodes){return nodes?$R.dom(nodes):$R.dom(this._getBlocks(tags));},_getBlocks:function _getBlocks(tags){var blocks=this.selection.getBlocks({tags:tags||this.tags});var finalBlocks=[];for(var i=0;i<blocks.length;i++){if(blocks[i].tagName==='DIV'&&!blocks[i].getAttribute('data-redactor-tag')){continue;}else{finalBlocks.push(blocks[i]);}}return finalBlocks;},_getReplacedTag:function _getReplacedTag(type){if(this.opts.breakline){return type==='toggle'?'div':this.params.tag==='p'?'div':this.params.tag;}else{return type==='toggle'?this.opts.markup:this.params.tag;}},// is
_isStandardParagraph:function _isStandardParagraph(){return!this.opts.breakline&&this.opts.markup==='p';},_isStandardDiv:function _isStandardDiv(){return!this.opts.breakline&&this.opts.markup==='div';},_isBreaklineBlock:function _isBreaklineBlock(block){return block&&block.tagName==='DIV'&&block.getAttribute('data-redactor-tag')==='br';},_isToggleFormatType:function _isToggleFormatType(blocks){var count=0;var len=blocks.length;for(var i=0;i<len;i++){if(blocks[i]&&this.params.tag===blocks[i].tagName.toLowerCase())count++;}return count===len;},_isCurrentBlockOneAndEmpty:function _isCurrentBlockOneAndEmpty(nodes){return this.collapsed&&nodes.length===1&&this.utils.isEmpty(nodes[0]);},// build
_buildNodes:function _buildNodes(nodes){if(nodes.length>0){// clean & appliyng styles and attributes
nodes=this._applyArgs(nodes,false);nodes=this._combinePre(nodes);nodes=this._cleanBlocks(nodes);}return nodes;},// replace
_replaceBlocks:function _replaceBlocks(blocks,replacedTag){var nodes=[];for(var i=0;i<blocks.length;i++){var $node=this.utils.replaceToTag(blocks[i],replacedTag);nodes.push($node.get());}return nodes;},// combine
_combinePre:function _combinePre(nodes){var combinedNodes=[];for(var i=0;i<nodes.length;i++){var next=nodes[i].nextElementSibling;if(next&&nodes[i].tagName==='PRE'&&next.tagName==='PRE'){var $current=$R.dom(nodes[i]);var $next=$R.dom(next);var newline=document.createTextNode('\n');$current.append(newline);$current.append($next);$next.unwrap('pre');}combinedNodes.push(nodes[i]);}return combinedNodes;},// clean
_cleanBlocks:function _cleanBlocks(nodes){var headings=['h1','h2','h3','h4','h5','h6'];var tags=this.opts.inlineTags;for(var i=0;i<nodes.length;i++){var tag=nodes[i].tagName.toLowerCase();var $node=$R.dom(nodes[i]);// remove all spans in headings
if(headings.indexOf(tag)!==-1){$node.find('span').not('.redactor-component, .non-editable, .redactor-selection-marker').unwrap();}// remove all inlines in pre
else if(tag==='pre'){$node.find(tags.join(',')).not('.redactor-selection-marker').unwrap();}if(this.params.args===false&&this.params.tag==='p'){$node.removeAttr('class');}// breakline attr
if(this.opts.breakline&&tag==='div'){$node.attr('data-redactor-tag','br');}else{$node.removeAttr('data-redactor-tag');}// normalize
this.utils.normalizeTextNodes(nodes[i]);}return nodes;},_cleanEmptyClass:function _cleanEmptyClass($elements){$elements.each(function(node){if(node.className==='')node.removeAttribute('class');});},_cleanEmptyStyle:function _cleanEmptyStyle($node){if(this.utils.removeEmptyAttr($node.get(),'style')){$node.removeAttr('data-redactor-style-cache');}else{$node.attr('data-redactor-style-cache',$node.attr('style'));}},// apply
_apply:function _apply(type,args,tags,selection,nodes){// save selection
if(selection!==false){this.selection.save();}// get elements
var $elements=this._getElements(tags,nodes);// class
if(args['class']){if(type==='set'){$elements.removeAttr('class');$elements.addClass(args['class']);}else if(type==='add'){$elements.addClass(args['class']);}else if(type==='toggle'){$elements.toggleClass(args['class']);}else if(type==='remove'){$elements.removeClass(args['class']);}this._cleanEmptyClass($elements);}// attr
if(args['attr']){if(type==='set'){this._removeAllAttr($elements);$elements.attr(args['attr']);}else if(type==='add'){$elements.attr(args['attr']);}else if(type==='toggle'){params=args['attr'];$elements.each(function(node){var $node=$R.dom(node);for(var key in params){if($node.attr(key))$node.removeAttr(key);else $node.attr(key,params[key]);}});}else if(type==='remove'){$elements.removeAttr(args['attr']);}}// style
if(args['style']){if(type==='set'){$elements.removeAttr('style');$elements.css(args['style']);$elements.each(function(node){var $node=$R.dom(node);$node.attr('data-redactor-style-cache',$node.attr('style'));});}else if(type==='add'){var params=args['style'];$elements.each(function(node){var $node=$R.dom(node);$node.css(params);$node.attr('data-redactor-style-cache',$node.attr('style'));this._convertStyleQuotes($node);}.bind(this));}else if(type==='toggle'){var params=args['style'];$elements.each(function(node){var $node=$R.dom(node);for(var key in params){var newVal=params[key];var oldVal=$node.css(key);oldVal=this.utils.isRgb(oldVal)?this.utils.rgb2hex(oldVal):oldVal.replace(/"/g,'');newVal=this.utils.isRgb(newVal)?this.utils.rgb2hex(newVal):newVal.replace(/"/g,'');oldVal=this.utils.hex2long(oldVal);newVal=this.utils.hex2long(newVal);var compareNew=typeof newVal==='string'?newVal.toLowerCase():newVal;var compareOld=typeof oldVal==='string'?oldVal.toLowerCase():oldVal;if(compareNew===compareOld)$node.css(key,'');else $node.css(key,newVal);}this._convertStyleQuotes($node);this._cleanEmptyStyle($node);}.bind(this));}else if(type==='remove'){var name=args['style'];$elements.each(function(node){var $node=$R.dom(node);$node.css(name,'');this._cleanEmptyStyle($node);}.bind(this));}}// get nodes
nodes=$elements.getAll();// restore selection
if(selection!==false){this._restoreSelection(nodes);}return nodes;},_applyArgs:function _applyArgs(nodes){if(this.params.args){nodes=this._apply(this.params.type,this.params.args,false,false,nodes);}else{nodes=this._clear(false,'all',false,nodes);}return nodes;},// remove
_removeAllAttr:function _removeAllAttr($elements,keepStyleAndClass){$elements.each(function(node){var keepAttrs=['data-redactor-tag','data-redactor-style-cache'];if(keepStyleAndClass===false){keepAttrs.push('style');keepAttrs.push('class');}for(var i=node.attributes.length;i-->0;){var nodeAttr=node.attributes[i];var name=nodeAttr.name;if(keepAttrs.indexOf(name)===-1){node.removeAttributeNode(nodeAttr);}}});},// selection
_restoreSelection:function _restoreSelection(nodes){if(this._isCurrentBlockOneAndEmpty(nodes)){this.caret.setStart(nodes[0]);}else{setTimeout(function(){this.selection.restore();}.bind(this),1);}},// convert
_convertStyleQuotes:function _convertStyleQuotes($node){var style=$node.attr('style');if(style)$node.attr('style',style.replace(/"/g,'\''));}});$R.add('service','inline',{mixins:['formatter'],init:function init(app){this.app=app;this.count=0;},// public
format:function format(args){if(!this._isFormat())return[];// type of applying styles and attributes
this.type=args.type?args.type:'set';// add, remove, toggle
// tag
this.tag=typeof args==='string'?args:args.tag;this.tag=this.tag.toLowerCase();this.tag=this.arrangeTag(this.tag);if(typeof args==='string')this.args=false;else this.buildArgs(args);if(!this.detector.isIe()){this.editor.disableNonEditables();}// format
var nodes=this.selection.isCollapsed()?this.formatCollapsed():this.formatUncollapsed();if(!this.detector.isIe()){this.editor.enableNonEditables();}return nodes;},// private
_isFormat:function _isFormat(){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var isComponent=data.isComponent()&&!data.isComponentType('table')&&!data.isFigcaption();if(current===false&&this.selection.isAll()){return true;}else if(!current||data.isPre()||data.isCode()||isComponent){return false;}return true;},arrangeTag:function arrangeTag(tag){var replaced=this.opts.replaceTags;for(var key in replaced){if(tag===key)tag=replaced[key];}return tag;},formatCollapsed:function formatCollapsed(){var nodes=[];var inline=this.selection.getInlineFirst();var inlines=this.selection.getInlines({all:true});var $inline=$R.dom(inline);var $parent,parent,$secondPart,extractedContent;// 1) not inline
if(!inline){nodes=this.insertInline(nodes);}else{var dataInline=this.inspector.parse(inline);var isEmpty=this.utils.isEmptyHtml(inline.innerHTML);// 2) inline is empty
if(isEmpty){// 2.1) has same tag
if(inline.tagName.toLowerCase()===this.tag){// 2.1.1) has same args or hasn't args
if(this.hasSameArgs(inline)){this.caret.setAfter(inline);$inline.remove();var el=this.selection.getElement();this.utils.normalizeTextNodes(el);}// 2.1.2) has different args and it is span tag
else if(this.tag==='span'){nodes=this.applyArgs([inline],false);this.caret.setStart(inline);}// 2.1.3) has different args and it is not span tag
else{nodes=this.insertInline(nodes);}}// 2.2) has another tag
else{// 2.2.1) has parent
if(dataInline.hasParent([this.tag])){$parent=$inline.closest(this.tag);parent=$parent.get();if(this.hasSameArgs(parent)){$parent.unwrap();this.caret.setStart(inline);}else{nodes=this.insertInline(nodes);}}// 2.2.2) hasn't parent
else{nodes=this.insertInline(nodes);}}}// 3) inline isn't empty
else{// 3.1) has same tag
if(inline.tagName.toLowerCase()===this.tag){// 3.1.1) has same args or hasn't args
if(this.hasSameArgs(inline)){// insert break
extractedContent=this.utils.extractHtmlFromCaret(inline);$secondPart=$R.dom('<'+this.tag+' />');$secondPart=this.utils.cloneAttributes(inline,$secondPart);$inline.after($secondPart.append(extractedContent));if($secondPart.html().trim()===''){$secondPart.remove();}this.caret.setAfter(inline);}else{nodes=this.insertInline(nodes);}}// 3.2) has another tag
else{// 3.2.1) has parent
if(dataInline.hasParent([this.tag])){$parent=$inline.closest(this.tag);parent=$parent.get();if(this.hasSameArgs(parent)){// insert break
extractedContent=this.utils.extractHtmlFromCaret(parent,parent);$secondPart=$R.dom('<'+this.tag+' />');$secondPart=this.utils.cloneAttributes(parent,$secondPart);var $breaked,$last;var z=0;inlines=inlines.reverse();for(var i=0;i<inlines.length;i++){if(inlines[i]!==parent){$last=$R.dom('<'+inlines[i].tagName.toLowerCase()+'>');if(z===0){$breaked=$last;}else{$breaked.append($last);}z++;}}$parent.after($secondPart.append(extractedContent));$parent.after($breaked);this.caret.setStart($last);}else{nodes=this.insertInline(nodes);}}// 3.2.2) hasn't parent
else{nodes=this.insertInline(nodes);}}}}return nodes;},insertInline:function insertInline(nodes){var node=document.createElement(this.tag);nodes=this.insertion.insertNode(node,'start');return this.applyArgs(nodes,false);},hasSameArgs:function hasSameArgs(inline){if(inline.attributes.length===0&&this.args===false){return true;}else{var same=true;if(this.args){var count=0;for(var key in this.args){var $node=$R.dom(inline);var args=this.args[key];var value=this.utils.toParams(args);var nodeAttrValue=$node.attr(key);if(args){if(key==='style'){value=value.trim().replace(/;$/,'');var origRules=this.utils.styleToObj($node.attr('style'));var rules=value.split(';');var innerCount=0;for(var i=0;i<rules.length;i++){var arr=rules[i].split(':');var ruleName=arr[0].trim();var ruleValue=arr[1].trim();if(ruleName.search(/color/)!==-1){var val=$node.css(ruleName);if(val&&(val===ruleValue||this.utils.rgb2hex(val)===ruleValue)){innerCount++;}}else if($node.css(ruleName)===ruleValue){innerCount++;}}if(innerCount===rules.length&&Object.keys(origRules).length===rules.length){count++;}}else{if(nodeAttrValue===value){count++;}}}else{if(!nodeAttrValue||nodeAttrValue===''){count++;}}}same=count===Object.keys(this.args).length;}return same;}},formatUncollapsed:function formatUncollapsed(){var inlines=this.selection.getInlines({all:true,inside:true});if(this.detector.isIe())this.selection.saveMarkers();else this.selection.save();// convert del / u
this._convertTags('u');this._convertTags('del');// convert target tags
this._convertToStrike(inlines);if(this.detector.isIe())this.selection.restoreMarkers();else this.selection.restore();// apply strike
document.execCommand('strikethrough');// clear decoration
this._clearDecoration();this.selection.save();// revert and set style
var nodes=this._revertToInlines();nodes=this.applyArgs(nodes,false);// unwrap if attributes was removed
for(var i=0;i<nodes.length;i++){var node=nodes[i];var tag=node.tagName.toLowerCase();var len=node.attributes.length;if(tag===this.tag&&len===0&&this.args){$R.dom(node).unwrap();nodes.splice(i,1);}}this.selection.restore();// clear and normalize
this._clearEmptyStyle();nodes=this._normalizeBlocks(nodes);return nodes;},_convertTags:function _convertTags(tag){if(this.tag!==tag){var $editor=this.editor.getElement();$editor.find(tag).each(function(node){var $el=this.utils.replaceToTag(node,'span');$el.addClass('redactor-convertable-'+tag);}.bind(this));}},_revertTags:function _revertTags(tag){var $editor=this.editor.getElement();$editor.find('span.redactor-convertable-'+tag).each(function(node){var $el=this.utils.replaceToTag(node,tag);$el.removeClass('redactor-convertable-'+tag);if(this.utils.removeEmptyAttr($el,'class'))$el.removeAttr('class');}.bind(this));},_convertToStrike:function _convertToStrike(inlines){var selected=this.selection.getText().replace(/[-[\]/{}()*+?.\\^$|]/g,"\\$&");for(var i=0;i<inlines.length;i++){var tag=this.arrangeTag(inlines[i].tagName.toLowerCase());var inline=inlines[i];var $inline=$R.dom(inline);var hasSameArgs=this.hasSameArgs(inline);if(tag===this.tag){if(this.tag==='span'&&this._isTextSelected(inline,selected)){$inline.addClass('redactor-convertable-apply');}else if(hasSameArgs&&this.tag!=='a'){this._replaceToStrike($inline);}else if(this.tag==='span'){$inline.addClass('redactor-unconvertable-apply');}else if(!hasSameArgs){$inline.addClass('redactor-convertable-apply');}}}},_replaceToStrike:function _replaceToStrike($el){$el.replaceWith(function(){return $R.dom('<strike>').append($el.contents());});},_revertToInlines:function _revertToInlines(){var nodes=[];var $editor=this.editor.getElement();if(this.tag!=='u')$editor.find('u').unwrap();$editor.find('.redactor-convertable-u').each(function(node){nodes.push(node);});// span convertable
$editor.find('.redactor-convertable-apply').each(function(node){var $node=$R.dom(node);$node.find('strike').unwrap();this._forceRemoveClass($node,'redactor-convertable-apply');nodes.push(node);}.bind(this));// span unconvertable
$editor.find('span.redactor-unconvertable-apply').each(function(node){var $node=$R.dom(node);this._forceRemoveClass($node,'redactor-unconvertable-apply');}.bind(this));// strike
$editor.find('strike').each(function(node){var $node=this.utils.replaceToTag(node,this.tag);nodes.push($node.get());}.bind(this));this._revertTags('u');this._revertTags('del');return nodes;},_normalizeBlocks:function _normalizeBlocks(nodes){var tags=this.opts.inlineTags;var blocks=this.selection.getBlocks();if(blocks){for(var i=0;i<blocks.length;i++){if(blocks[i].tagName==='PRE'){var $node=$R.dom(blocks[i]);$node.find(tags.join(',')).not('.redactor-selection-marker').each(function(inline){if(nodes.indexOf(inline)!==-1){nodes=this.utils.removeFromArrayByValue(nodes,inline);}$R.dom(inline).unwrap();}.bind(this));}}}return nodes;},_clearDecoration:function _clearDecoration(){var $editor=this.editor.getElement();$editor.find(this.opts.inlineTags.join(',')).each(function(node){if(node.style.textDecoration==='line-through'||node.style.textDecorationLine==='line-through'){var $el=$R.dom(node);$el.css('textDecorationLine','');$el.css('textDecoration','');$el.wrap('<strike>');}});},_clearEmptyStyle:function _clearEmptyStyle(){var inlines=this.getInlines();for(var i=0;i<inlines.length;i++){this._clearEmptyStyleAttr(inlines[i]);var childNodes=inlines[i].childNodes;if(childNodes){for(var z=0;z<childNodes.length;z++){this._clearEmptyStyleAttr(childNodes[z]);}}}},_clearEmptyStyleAttr:function _clearEmptyStyleAttr(node){if(node.nodeType!==3&&this.utils.removeEmptyAttr(node,'style')){node.removeAttribute('style');node.removeAttribute('data-redactor-style-cache');}},_forceRemoveClass:function _forceRemoveClass($node,classname){$node.removeClass(classname);if(this.utils.removeEmptyAttr($node,'class'))$node.removeAttr('class');},_isTextSelected:function _isTextSelected(node,selected){var text=this.utils.removeInvisibleChars(node.textContent);return selected===text||selected.search(new RegExp('^'+this.utils.escapeRegExp(text)+'$'))!==-1;},getInlines:function getInlines(tags){return tags?this.selection.getInlines({tags:tags,all:true}):this.selection.getInlines({all:true});},getElements:function getElements(tags){return $R.dom(this.getInlines(tags));},clearFormat:function clearFormat(){this.selection.save();var nodes=this.selection.getInlines({all:true});for(var i=0;i<nodes.length;i++){var $el=$R.dom(nodes[i]);var inline=this.selection.getInline(nodes[i]);if(inline){$el.unwrap();}}this.selection.restore();}});$R.add('service','autoparser',{init:function init(app){this.app=app;this.cleaner=this.app.cleaner;},observe:function observe(){var $editor=this.editor.getElement();var $objects=$editor.find('.redactor-autoparser-object').each(function(node){var $node=$R.dom(node);$node.removeClass('redactor-autoparser-object');if($node.attr('class')==='')$node.removeAttr('class');});if($objects.length>0){$objects.each(function(node){var type;var $object=false;var tag=node.tagName;if(tag==='A')type='link';else if(tag==='IMG')type='image';else if(tag==='IFRAME')type='video';if(type){$object=$R.create(type+'.component',this.app,node);this.app.broadcast(type+'.inserted',$object);this.app.broadcast('autoparse',type,$object);}}.bind(this));}},format:function format(e,key){if(this._isKey(key)){this._format(key===this.keycodes.ENTER);}},parse:function parse(html){var tags=['figure','form','pre','iframe','code','a','img'];var stored=[];var z=0;// store
var storedComments=[];html=this.cleaner.storeComments(html,storedComments);// encode
html=this.cleaner.encodeCode(html);// converting entity
html=html.replace(/\$/g,'&#36;');html=html.replace(/&amp;/g,'&');// store tags
for(var i=0;i<tags.length;i++){var reTags=tags[i]==='img'?'<'+tags[i]+'[^>]*>':'<'+tags[i]+'([\\w\\W]*?)</'+tags[i]+'>';var matched=html.match(new RegExp(reTags,'gi'));if(matched!==null){for(var y=0;y<matched.length;y++){html=html.replace(matched[y],'#####replaceparse'+z+'#####');stored.push(matched[y]);z++;}}}// images
if(this.opts.autoparseImages&&html.match(this.opts.regex.imageurl)){var imagesMatches=html.match(this.opts.regex.imageurl);for(var i=0;i<imagesMatches.length;i++){html=html.replace(imagesMatches[i],'<img class="redactor-autoparser-object" src="'+imagesMatches[i]+'">');}}// video
if(this.opts.autoparseVideo&&(html.match(this.opts.regex.youtube)||html.match(this.opts.regex.vimeo))){var iframeStart='<iframe width="500" height="281" src="';var iframeEnd='" frameborder="0" allowfullscreen></iframe>';var str,re;if(html.match(this.opts.regex.youtube)){str='//www.youtube.com/embed/$1';re=this.opts.regex.youtube;}else if(html.match(this.opts.regex.vimeo)){str='//player.vimeo.com/video/$2';re=this.opts.regex.vimeo;}var $video=this.component.create('video',iframeStart+str+iframeEnd);html=html.replace(re,$video.get().outerHTML);}// store tags
for(var i=0;i<tags.length;i++){var reTags=tags[i]==='img'?'<'+tags[i]+'[^>]*>':'<'+tags[i]+'([\\w\\W]*?)</'+tags[i]+'>';var matched=html.match(new RegExp(reTags,'gi'));if(matched!==null){for(var y=0;y<matched.length;y++){html=html.replace(matched[y],'#####replaceparse'+z+'#####');stored.push(matched[y]);z++;}}}// links
if(this.opts.autoparseLinks&&html.match(this.opts.regex.url)){html=this._formatLinks(html);}// restore
html=this._restoreReplaced(stored,html);// repeat for nested tags
html=this._restoreReplaced(stored,html);// restore comments
html=this.cleaner.restoreComments(html,storedComments);return html;},// private
_isKey:function _isKey(key){return key===this.keycodes.ENTER||key===this.keycodes.SPACE;},_format:function _format(enter){var parent=this.selection.getParent();var $parent=$R.dom(parent);var isNotFormatted=parent&&$parent.closest('figure, pre, code, img, a, iframe').length!==0;if(isNotFormatted||!this.selection.isCollapsed()){return;}// add split marker
var marker=this.utils.createInvisibleChar();var range=this.selection.getRange();range.insertNode(marker);var current=this.selection.getCurrent();var data=this.inspector.parse(current);var $current=$R.dom(current);// remove split marker
marker.parentNode.removeChild(marker);if(current&&current.nodeType===3){var content=current.textContent;var type;// images
if(this.opts.autoparseImages&&content.match(this._convertToRegExp(this.opts.regex.imageurl))){var isList=data.isList();var matches=content.match(this.opts.regex.imageurl);var el=isList?undefined:'<figure><img></figure>';var $img=this.component.create('image',el);$img.setSrc(matches[0]);$img.addClass('redactor-autoparser-object');content=content.replace(matches[0],$img.get().outerHTML);type='image';}// video
else if(this.opts.autoparseVideo&&(content.match(this._convertToRegExp(this.opts.regex.youtube))||content.match(this._convertToRegExp(this.opts.regex.vimeo)))){var iframeStart='<iframe width="500" height="281" src="';var iframeEnd='" frameborder="0" allowfullscreen></iframe>';var str,re;if(content.match(this.opts.regex.youtube)){str='//www.youtube.com/embed/$1';re=this.opts.regex.youtube;}else if(content.match(this.opts.regex.vimeo)){str='//player.vimeo.com/video/$2';re=this.opts.regex.vimeo;}var $video=this.component.create('video',iframeStart+str+iframeEnd);$video.addClass('redactor-autoparser-object');content=content.replace(re,$video.get().outerHTML);type='video';}// links
else if(this.opts.autoparseLinks&&content.match(this._convertToRegExp(this.opts.regex.url))){content=this._formatLinks(content,enter);type='link';}// replace
if(type){if(enter){this.selection.save();$current.replaceWith(content);this.selection.restore();}else{$current.replaceWith(content);}// object
var $editor=this.editor.getElement();var $object=$editor.find('.redactor-autoparser-object').removeClass('redactor-autoparser-object');$object=type==='link'?$R.create('link.component',this.app,$object):$object;// caret
if(type==='link'){if(!enter)this.caret.setAfter($object);this.app.broadcast('link.inserted',$object);}else{this.caret.setAfter($object);var $cloned=$object.clone();$object.remove();$object=this.insertion.insertHtml($cloned);$object=this.component.build($object);}// callback
this.app.broadcast('autoparse',type,$object);}}},_formatLinks:function _formatLinks(content,enter){var matches=content.match(this.opts.regex.url);var obj={};for(var i=0;i<matches.length;i++){if(enter&&matches[i].search(/\.$/)!==-1){matches[i]=matches[i].replace(/\.$/,'');}var href=matches[i],text=href;var linkProtocol=href.match(/(https?|ftp):\/\//i)!==null?'':'http://';var regexB=["/","&","="].indexOf(href.slice(-1))!==-1?"":"\\b";var target=this.opts.pasteLinkTarget!==false?' target="'+this.opts.pasteLinkTarget+'"':'';text=text.length>this.opts.linkSize?text.substring(0,this.opts.linkSize)+'...':text;text=text.search('%')===-1?decodeURIComponent(text):text;// escaping url
var regexp='('+href.replace(/[-[\]/{}()*+?.\\^$|]/g,"\\$&")+regexB+')';var classstr=' class="redactor-autoparser-object"';obj[regexp]='<a href="'+linkProtocol+href.trim()+'"'+target+classstr+'>'+text.trim()+'</a>';}// replace
for(var key in obj){content=content.replace(new RegExp(key,'g'),obj[key]);}return content;},_restoreReplaced:function _restoreReplaced(stored,html){for(var i=0;i<stored.length;i++){html=html.replace('#####replaceparse'+i+'#####',stored[i]);}return html;},_convertToRegExp:function _convertToRegExp(str){return new RegExp(String(str).replace(/^\//,'').replace(/\/ig$/,'').replace(/\/gi$/,'')+'$','gi');}});$R.add('service','storage',{init:function init(app){this.app=app;// local
this.data=[];},// public
observeImages:function observeImages(){if(this.opts.imageObserve){var $editor=this.editor.getElement();var $images=$editor.find('[data-image]');$images.each(this._addImage.bind(this));}},observeFiles:function observeFiles(){var $editor=this.editor.getElement();var $files=$editor.find('[data-file]');$files.each(this._addFile.bind(this));},setStatus:function setStatus(url,status){this.data[url].status=status;},getChanges:function getChanges(){var $editor=this.editor.getElement();// check status
for(var key in this.data){var data=this.data[key];var $el=$editor.find('[data-'+data.type+'="'+data.id+'"]');this.setStatus(data.id,$el.length===0?false:true);}return this.data;},add:function add(type,node){var $node=$R.dom(node);var id=$node.attr('data-'+type);this.data[id]={type:type,status:true,node:$node.get(),id:$node.attr('data-'+type)};},// private
_addImage:function _addImage(node){this.add('image',node);},_addFile:function _addFile(node){this.add('file',node);}});$R.add('service','utils',{init:function init(app){this.app=app;},// empty
isEmpty:function isEmpty(el){var isEmpty=false;el=$R.dom(el).get();if(el){isEmpty=el.nodeType===3?el.textContent.trim().replace(/\n/,'')==='':el.innerHTML==='';}return isEmpty;},isEmptyHtml:function isEmptyHtml(html,keepbr,keeplists){html=this.removeInvisibleChars(html);html=html.replace(/&nbsp;/gi,'');html=html.replace(/<\/?br\s?\/?>/g,keepbr?'br':'');html=html.replace(/\s/g,'');html=html.replace(/^<p>[^\W\w\D\d]*?<\/p>$/i,'');html=html.replace(/^<div>[^\W\w\D\d]*?<\/div>$/i,'');if(keeplists){html=html.replace(/<ul(.*?[^>])>$/i,'ul');html=html.replace(/<ol(.*?[^>])>$/i,'ol');}html=html.replace(/<hr(.*?[^>])>$/i,'hr');html=html.replace(/<iframe(.*?[^>])>$/i,'iframe');html=html.replace(/<source(.*?[^>])>$/i,'source');// remove empty tags
html=html.replace(/<[^\/>][^>]*><\/[^>]+>/gi,'');html=html.replace(/<[^\/>][^>]*><\/[^>]+>/gi,'');// trim
html=html.trim();return html==='';},trimSpaces:function trimSpaces(html){return html=this.removeInvisibleChars(html.trim());},// invisible chars
createInvisibleChar:function createInvisibleChar(){return document.createTextNode(this.opts.markerChar);},searchInvisibleChars:function searchInvisibleChars(str){return str.search(/^\uFEFF$/g);},removeInvisibleChars:function removeInvisibleChars(html){return html.replace(/\uFEFF/g,'');},trimInvisibleChars:function trimInvisibleChars(direction){if(!this.selection.isCollapsed())return;var current=this.selection.getCurrent();var side=direction==='left'?this.selection.getTextBeforeCaret():this.selection.getTextAfterCaret();var isSpace=current&&current.nodeType===3&&this.searchInvisibleChars(side)===0;if(isSpace){if(direction==='left'){$R.dom(current).replaceWith(current.textContent.trim());}else{var offset=this.offset.get();this.offset.set({start:offset.start+1,end:offset.end+1});}}},// wrapper
buildWrapper:function buildWrapper(html){return $R.dom('<div>').html(html);},getWrapperHtml:function getWrapperHtml($wrapper){var html=$wrapper.html();$wrapper.remove();return html;},// fragment
createTmpContainer:function createTmpContainer(html){var $div=$R.dom('<div>');if(typeof html==='string'){$div.html(html);}else{$div.append($R.dom(html).clone(true));}return $div.get();},createFragment:function createFragment(html){var el=this.createTmpContainer(html);var frag=document.createDocumentFragment(),node,firstNode,lastNode;var nodes=[];var i=0;while(node=el.firstChild){i++;var n=frag.appendChild(node);if(i===1)firstNode=n;nodes.push(n);lastNode=n;}return{frag:frag,first:firstNode,last:lastNode,nodes:nodes};},isFragment:function isFragment(obj){return _typeof(obj)==='object'&&obj.frag;},parseHtml:function parseHtml(html){var div=this.createTmpContainer(html);return{html:div.innerHTML,nodes:div.childNodes};},splitNode:function splitNode(current,nodes,isList,inline){nodes=this.isFragment(nodes)?nodes.frag:nodes;var element;if(inline){element=this.inspector.isInlineTag(current.tagName)?current:this.selection.getInline(current);}else{element=this.inspector.isBlockTag(current.tagName)?current:this.selection.getBlock(current);}var $element=$R.dom(element);// replace is empty
if(!inline&&this.isEmptyHtml(element.innerHTML,true)){$element.after(nodes);$element.remove();return nodes;}var tag=$element.get().tagName.toLowerCase();var isEnd=this.caret.isEnd(element);var isStart=this.caret.isStart(element);if(!isEnd&&!isStart){var extractedContent=this.extractHtmlFromCaret(inline);var $secondPart=$R.dom('<'+tag+' />');$secondPart=this.cloneAttributes(element,$secondPart);$element.after($secondPart.append(extractedContent));}if(isStart){return $element.before(nodes);}else{if(isList){return $element.append(nodes);}else{nodes=$element.after(nodes);var html=$element.html();html=this.removeInvisibleChars(html);html=html.replace(/&nbsp;/gi,'');if(html==='')$element.remove();return nodes;}}},extractHtmlFromCaret:function extractHtmlFromCaret(inline,element){var range=this.selection.getRange();if(range){element=element?element:inline?this.selection.getInline():this.selection.getBlock();if(element){var clonedRange=range.cloneRange();clonedRange.selectNodeContents(element);clonedRange.setStart(range.endContainer,range.endOffset);return clonedRange.extractContents();}}},createMarkup:function createMarkup(el){var markup=document.createElement(this.opts.markup);if(this.opts.breakline)markup.setAttribute('data-redactor-tag','br');var $el=$R.dom(el);$el.after(markup);this.caret.setStart(markup);},createMarkupBefore:function createMarkupBefore(el){var markup=document.createElement(this.opts.markup);if(this.opts.breakline)markup.setAttribute('data-redactor-tag','br');var $el=$R.dom(el);$el.before(markup);this.caret.setEnd(markup);},getNode:function getNode(el){var node=$R.dom(el).get();var editor=this.editor.getElement().get();return typeof el==='undefined'?editor:node?node:false;},findSiblings:function findSiblings(node,type){node=$R.dom(node).get();type=type==='next'?'nextSibling':'previousSibling';while(node=node[type]){if(node.nodeType===3&&node.textContent.trim()===''||node.tagName==='BR'){continue;}return node;}return false;},getElementsFromHtml:function getElementsFromHtml(html,selector,exclude){var div=document.createElement("div");div.innerHTML=html;var elems=div.querySelectorAll(selector);// array map polyfill
var mapping=function mapping(callback,thisArg){if(typeof this.length!=='number')return;if(typeof callback!=='function')return;var newArr=[];if(_typeof(this)=='object'){for(var i=0;i<this.length;i++){if(i in this)newArr[i]=callback.call(thisArg||this,this[i],i,this);else return;}}return newArr;};return mapping.call(elems,function(el){var type=el.getAttribute('data-redactor-type');if(exclude&&type&&type===exclude){}else return el.outerHTML;});},// childnodes
getChildNodes:function getChildNodes(el,recursive,elements){el=el&&el.nodeType&&el.nodeType===11?el:$R.dom(el).get();var nodes=el.childNodes;var result=[];if(nodes){for(var i=0;i<nodes.length;i++){if(elements===true&&nodes[i].nodeType===3)continue;else if(nodes[i].nodeType===3&&this.isEmpty(nodes[i]))continue;result.push(nodes[i]);if(recursive!==false){var nestedNodes=this.getChildNodes(nodes[i],elements);if(nestedNodes.length>0){result=result.concat(nestedNodes);}}}}return result;},getChildElements:function getChildElements(el){return this.getChildNodes(el,true,true);},getFirstNode:function getFirstNode(el){return this._getFirst(this.getChildNodes(el,false));},getLastNode:function getLastNode(el){return this._getLast(this.getChildNodes(el,false));},getFirstElement:function getFirstElement(el){return this._getFirst(this.getChildNodes(el,false,true));},getLastElement:function getLastElement(el){return this._getLast(this.getChildNodes(el,false,true));},// replace
replaceToTag:function replaceToTag(node,tag){var $node=$R.dom(node);return $node.replaceWith(function(node){var $replaced=$R.dom('<'+tag+'>').append($R.dom(node).contents());if(node.attributes){var attrs=node.attributes;for(var i=0;i<attrs.length;i++){$replaced.attr(attrs[i].nodeName,attrs[i].value);}}return $replaced;});},// string
ucfirst:function ucfirst(str){return str.charAt(0).toUpperCase()+str.slice(1);},// array
removeFromArrayByValue:function removeFromArrayByValue(arr,value){var a=arguments,len=a.length,ax;while(len>1&&arr.length){value=a[--len];while((ax=arr.indexOf(value))!==-1){arr.splice(ax,1);}}return arr;},// attributes
removeEmptyAttr:function removeEmptyAttr(el,attr){var $el=$R.dom(el);if(typeof $el.attr(attr)==='undefined'||$el.attr(attr)===null)return true;else if($el.attr(attr)===''){$el.removeAttr(attr);return true;}return false;},cloneAttributes:function cloneAttributes(elFrom,elTo){elFrom=$R.dom(elFrom).get();elTo=$R.dom(elTo);var attrs=elFrom.attributes;var len=attrs.length;while(len--){var attr=attrs[len];elTo.attr(attr.name,attr.value);}return elTo;},// object
toParams:function toParams(obj){if(_typeof(obj)!=='object')return obj;var keys=Object.keys(obj);if(!keys.length)return'';var result='';for(var i=0;i<keys.length;i++){var key=keys[i];result+=key+':'+obj[key]+';';}return result;},styleToObj:function styleToObj(str){var obj={};if(str){var style=str.replace(/;$/,'').split(';');for(var i=0;i<style.length;i++){var rule=style[i].split(':');obj[rule[0].trim()]=rule[1].trim();}}return obj;},checkProperty:function checkProperty(obj){var args=arguments[1]&&Array.isArray(arguments[1])?arguments[1]:[].slice.call(arguments,1);for(var i=0;i<args.length;i++){if(!obj||typeof obj[args[i]]==='undefined'){return false;}obj=obj[args[i]];}return obj;},// data
extendData:function extendData(data,obj){for(var key in obj){if(key==='elements'){var $elms=$R.dom(obj[key]);$elms.each(function(node){var $node=$R.dom(node);if(node.tagName==='FORM'){var serializedData=$node.serialize(true);for(var z in serializedData){data=this._setData(data,z,serializedData[z]);}}else{var name=$node.attr('name')?$node.attr('name'):$node.attr('id');data=this._setData(data,name,$node.val());}}.bind(this));}else{data=this._setData(data,key,obj[key]);}}return data;},_setData:function _setData(data,name,value){if(data instanceof FormData)data.append(name,value);else data[name]=value;return data;},// normalize
normalizeTextNodes:function normalizeTextNodes(el){el=$R.dom(el).get();if(el)el.normalize();},// color
isRgb:function isRgb(str){return str.search(/^rgb/i)===0;},rgb2hex:function rgb2hex(rgb){rgb=rgb.match(/^rgba?[\s+]?\([\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?,[\s+]?(\d+)[\s+]?/i);return rgb&&rgb.length===4?"#"+("0"+parseInt(rgb[1],10).toString(16)).slice(-2)+("0"+parseInt(rgb[2],10).toString(16)).slice(-2)+("0"+parseInt(rgb[3],10).toString(16)).slice(-2):'';},hex2long:function hex2long(val){if(val.search(/^#/)!==-1&&val.length===4){val='#'+val[1]+val[1]+val[2]+val[2]+val[3]+val[3];}return val;},// escape
escapeRegExp:function escapeRegExp(s){return s.replace(/[-\/\\^$*~+?.()|[\]{}]/g,'\\$&');},// random
getRandomId:function getRandomId(){var id='';var possible='abcdefghijklmnopqrstuvwxyz0123456789';for(var i=0;i<12;i++){id+=possible.charAt(Math.floor(Math.random()*possible.length));}return id;},// private
_getFirst:function _getFirst(nodes){return nodes.length!==0?nodes[0]:false;},_getLast:function _getLast(nodes){return nodes.length!==0?nodes[nodes.length-1]:false;}});$R.add('service','progress',{init:function init(app){this.app=app;// local
this.$box=null;this.$bar=null;},// public
show:function show(){if(!this._is())this._build();this.$box.show();},hide:function hide(){if(this._is()){this.animate.start(this.$box,'fadeOut',this._destroy.bind(this));}},update:function update(value){this.show();this.$bar.css('width',value+'%');},// private
_is:function _is(){return this.$box!==null;},_build:function _build(){this.$bar=$R.dom('<span />');this.$box=$R.dom('<div id="redactor-progress" />');this.$box.append(this.$bar);this.$body.append(this.$box);},_destroy:function _destroy(){if(this._is())this.$box.remove();this.$box=null;this.$bar=null;}});$R.add('module','starter',{init:function init(app){this.app=app;this.opts=app.opts;this.plugin=app.plugin;this.module=app.module;},// messages
onstart:function onstart(){var services=['element','container','source','editor','statusbar','toolbar'];var modules=['element','container','source','editor','statusbar','contextbar','input'];this._startStop('start',this.app,services);this._startStop('start',this.module,modules);},onstop:function onstop(){var modules=['observer','element','container','source','editor','contextbar'];this._startStop('stop',this.module,modules);},onenable:function onenable(){var modules=['observer','toolbar'];var plugins=this.opts.plugins;this._startStop('start',this.module,modules);this._startStop('start',this.plugin,plugins);},ondisable:function ondisable(){var modules=['observer','toolbar'];var plugins=this.opts.plugins;this._startStop('stop',this.module,modules);this._startStop('stop',this.plugin,plugins);},// private
_startStop:function _startStop(type,obj,arr){for(var i=0;i<arr.length;i++){if(typeof obj[arr[i]]!=='undefined'){this.app.callInstanceMethod(obj[arr[i]],type);}}}});$R.add('module','element',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.namespace=app.namespace;this.element=app.element;this.rootOpts=$R.extend({},true,$R.options,app.rootOpts);},// public
start:function start(){this._build();this._buildModes();this._buildMarkup();},stop:function stop(){var $element=this.element.getElement();$element.removeData(this.namespace+'-uuid');},// private
_build:function _build(){var $element=this.element.getElement();$element.data(this.namespace+'-uuid',this.uuid);},_buildModes:function _buildModes(){var type=this.element.getType();if(type==='inline')this._redefineOptions(this.opts.modes['inline']);if(type==='div')this._redefineOptions(this.opts.modes['original']);if(type!=='inline'){if(this._isRootOption('styles')&&this.rootOpts.styles)this.opts.styles=true;if(this._isRootOption('source')&&!this.rootOpts.source)this.opts.showSource=false;}},_buildMarkup:function _buildMarkup(){var type=this.element.getType();if(type==='inline'){this.opts.emptyHtml='';}else if(this.opts.breakline){this.opts.markup='div';this.opts.emptyHtml='<div data-redactor-tag="br">'+this.opts.markerChar+'</div>';}else{this.opts.emptyHtml='<'+this.opts.markup+'></'+this.opts.markup+'>';}},_redefineOptions:function _redefineOptions(opts){for(var key in opts){this.opts[key]=opts[key];}},_isRootOption:function _isRootOption(){return typeof this.rootOpts['styles']!=='undefined';}});$R.add('module','editor',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.editor=app.editor;this.source=app.source;this.element=app.element;this.component=app.component;this.container=app.container;this.inspector=app.inspector;this.autoparser=app.autoparser;// local
this.placeholder=false;this.events=false;},// messages
onenable:function onenable(){this.enable();},ondisable:function ondisable(){this.disable();},onenablefocus:function onenablefocus(){this._enableFocus();},oncontextmenu:function oncontextmenu(e){this.component.setOnEvent(e,true);},onclick:function onclick(e){this.component.setOnEvent(e);},onkeyup:function onkeyup(e){var data=this.inspector.parse(e.target);if(!data.isComponent()){this.component.clearActive();}},onenablereadonly:function onenablereadonly(){this._enableReadOnly();},ondisablereadonly:function ondisablereadonly(){this._disableReadOnly();},onautoparseobserve:function onautoparseobserve(){this.autoparser.observe();},onplaceholder:{build:function build(){this._buildPlaceholder();},toggle:function toggle(){this._togglePlacehodler();}},// public
start:function start(){this._build();this._buildEvents();this._buildOptions();this._buildAccesibility();},stop:function stop(){var $editor=this.editor.getElement();var $container=this.container.getElement();var classesEditor=['redactor-in','redactor-in-'+this.uuid,'redactor-structure','redactor-placeholder','notranslate'];if(this.opts.stylesClass!==''){classesEditor.push(this.opts.stylesClass);}var classesContainer=['redactor-focus','redactor-blur','redactor-over','redactor-styles-on','redactor-styles-off','redactor-toolbar-on','redactor-text-labeled-on','redactor-source-view'];$editor.removeAttr('spellcheck');$editor.removeAttr('dir');$editor.removeAttr('contenteditable');$editor.removeAttr('placeholder');$editor.removeAttr('data-gramm_editor');$editor.removeClass(classesEditor.join(' '));$container.removeClass(classesContainer.join(' '));this._destroyEvents();if($editor.get().classList.length===0)$editor.removeAttr('class');},enable:function enable(){var $editor=this.editor.getElement();var $container=this.container.getElement();$editor.addClass('redactor-in redactor-in-'+this.uuid);$editor.attr({'contenteditable':true});if(this.opts.structure){$editor.addClass('redactor-structure');}if(this.opts.toolbar&&!this.opts.air&&!this.opts.toolbarExternal){$container.addClass('redactor-toolbar-on');}// prevent editing
this._disableBrowsersEditing();},disable:function disable(){var $editor=this.editor.getElement();var $container=this.container.getElement();$editor.removeClass('redactor-in redactor-in-'+this.uuid);$editor.removeClass('redactor-structure');$editor.removeAttr('contenteditable');$container.addClass('redactor-toolbar-on');},// private
_build:function _build(){var $editor=this.editor.getElement();var $element=this.element.getElement();var $container=this.container.getElement();$container.addClass('redactor-blur');if(!this.opts.grammarly){$editor.attr('data-gramm_editor',false);}if(this.opts.notranslate){$editor.addClass('notranslate');}if(this.opts.styles){$editor.addClass(this.opts.stylesClass);$container.addClass('redactor-styles-on');}else{$container.addClass('redactor-styles-off');}if(this.opts.buttonsTextLabeled){$container.addClass('redactor-text-labeled-on');}if(this.element.isType('textarea'))$element.before($editor);},_buildEvents:function _buildEvents(){this.events=$R.create('editor.events',this.app);},_buildOptions:function _buildOptions(){var $editor=this.editor.getElement();$editor.attr('dir',this.opts.direction);if(!this.opts.spellcheck)$editor.attr('spellcheck',false);if(this.opts.tabindex)$editor.attr('tabindex',this.opts.tabindex);if(this.opts.minHeight)$editor.css('min-height',this.opts.minHeight);if(this.opts.maxHeight)$editor.css('max-height',this.opts.maxHeight);if(this.opts.maxWidth)$editor.css({'max-width':this.opts.maxWidth,'margin':'auto'});},_buildAccesibility:function _buildAccesibility(){var $editor=this.editor.getElement();$editor.attr({'aria-labelledby':'redactor-voice-'+this.uuid,'role':'presentation'});},_buildPlaceholder:function _buildPlaceholder(){this.placeholder=$R.create('editor.placeholder',this.app);},_enableFocus:function _enableFocus(){if(this.opts.showSource)this._enableFocusSource();else this._enableFocusEditor();},_enableFocusSource:function _enableFocusSource(){var $source=this.source.getElement();if(this.opts.focus){$source.focus();$source.get().setSelectionRange(0,0);}else if(this.opts.focusEnd){$source.focus();}},_enableFocusEditor:function _enableFocusEditor(){if(this.opts.focus){setTimeout(this.editor.startFocus.bind(this.editor),100);}else if(this.opts.focusEnd){setTimeout(this.editor.endFocus.bind(this.editor),100);}},_togglePlacehodler:function _togglePlacehodler(){if(this.placeholder)this.placeholder.toggle();},_disableBrowsersEditing:function _disableBrowsersEditing(){try{// FF fix
document.execCommand('enableObjectResizing',false,false);document.execCommand('enableInlineTableEditing',false,false);// IE prevent converting links
document.execCommand("AutoUrlDetect",false,false);// IE disable image resizing
var $editor=this.editor.getElement();var el=$editor.get();if(el.addEventListener)el.addEventListener('mscontrolselect',function(e){e.preventDefault();});else el.attachEvent('oncontrolselect',function(e){e.returnValue=false;});}catch(e){}},_destroyEvents:function _destroyEvents(){if(this.events){this.events.destroy();}},_enableReadOnly:function _enableReadOnly(){var $editor=this.editor.getElement();this._getEditables($editor).removeAttr('contenteditable');$editor.removeAttr('contenteditable');$editor.addClass('redactor-read-only');if(this.events)this.events.destroy();},_disableReadOnly:function _disableReadOnly(){var $editor=this.editor.getElement();this._getEditables($editor).attr({'contenteditable':true});$editor.removeClass('redactor-read-only');$editor.attr({'contenteditable':true});this._buildEvents();},_getEditables:function _getEditables($editor){return $editor.find('figcaption, td, th');}});$R.add('class','editor.placeholder',{init:function init(app){this.app=app;this.opts=app.opts;this.editor=app.editor;this.element=app.element;// build
this.build();},build:function build(){var $element=this.element.getElement();var $editor=this.editor.getElement();if(this.opts.placeholder!==false||$element.attr('placeholder')){var text=this.opts.placeholder!==false?this.opts.placeholder:$element.attr('placeholder');$editor.attr('placeholder',text);this.toggle();}},toggle:function toggle(){return this.editor.isEmpty(true)?this.show():this.hide();},show:function show(){var $editor=this.editor.getElement();$editor.addClass('redactor-placeholder');},hide:function hide(){var $editor=this.editor.getElement();$editor.removeClass('redactor-placeholder');}});$R.add('class','editor.events',{init:function init(app){this.app=app;this.opts=app.opts;this.$doc=app.$doc;this.uuid=app.uuid;this.source=app.source;this.editor=app.editor;this.cleaner=app.cleaner;this.container=app.container;this.insertion=app.insertion;this.inspector=app.inspector;this.selection=app.selection;this.component=app.component;// local
this.blurNamespace='.redactor-blur.'+this.uuid;this.eventsList=['paste','click','contextmenu','keydown','keyup','mouseup','touchstart','cut','copy','dragenter','dragstart','drop','dragover','dragleave'];// init
this._init();},destroy:function destroy(){var $editor=this.editor.getElement();$editor.off('.redactor-focus');this.$doc.off('keyup'+this.blurNamespace+' mousedown'+this.blurNamespace);// all events
this._loop('off');},focus:function focus(e){var $container=this.container.getElement();if(this.editor.isPasting()||$container.hasClass('redactor-focus'))return;$container.addClass('redactor-focus');$container.removeClass('redactor-blur');this.app.broadcast('observe',e);this.app.broadcast('focus',e);this.isFocused=true;this.isBlured=false;},blur:function blur(e){var $container=this.container.getElement();var $target=$R.dom(e.target);var targets=['.redactor-in-'+this.uuid,'.redactor-toolbar','.redactor-dropdown','.redactor-context-toolbar','.redactor-modal-box','#redactor-image-resizer'];this.app.broadcast('originalblur',e);if(this.app.stopBlur)return;if(!this.app.isStarted()||this.editor.isPasting())return;if($target.closest(targets.join(',')).length!==0)return;if(!this.isBlured&&!$container.hasClass('redactor-blur')){$container.removeClass('redactor-focus');$container.addClass('redactor-blur');this.app.broadcast('blur',e);this.isFocused=false;this.isBlured=true;}},cut:function cut(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);this.app.broadcast('state',e);if(this.component.isNonEditable(current)){this._passSelectionToClipboard(e,data,true);e.preventDefault();}},copy:function copy(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);this.app.broadcast('state',e);if(this.component.isNonEditable(current)){this._passSelectionToClipboard(e,data,false);e.preventDefault();}},drop:function drop(e){e=e.originalEvent||e;e.stopPropagation();this._removeOverClass();if(this.opts.dragUpload===false){e.preventDefault();return;}if(this.app.isDragComponentInside()){var $dragComponent=$R.dom(this.app.getDragComponentInside());var $component=$dragComponent.clone(true);this.insertion.insertToPoint(e,$component);$dragComponent.remove();this.app.setDragComponentInside(false);this.app.broadcast('state',e);this.app.broadcast('drop',e);this.app.broadcast('image.observe',e);e.preventDefault();return;}else if(this.app.isDragInside()&&this.opts.input){this.insertion.insertPoint(e);var dt=e.dataTransfer;var html=dt.getData('text/html');// clear selected
var range=this.selection.getRange();if(range){var blocks=this.selection.getBlocks();range.deleteContents();// remove empty blocks
for(var i=0;i<blocks.length;i++){if(blocks[i].innerHTML==='')$R.dom(blocks[i]).remove();}}// paste
$R.create('input.paste',this.app,e,true,html,true);this.app.broadcast('state',e);this.app.broadcast('drop',e);this.app.setDragInside(false);e.preventDefault();return;}this.app.broadcast('state',e);this.app.broadcast('paste',e,e.dataTransfer);this.app.broadcast('drop',e);},dragenter:function dragenter(e){e.preventDefault();},dragstart:function dragstart(e){this.app.setDragComponentInside(false);this.app.setDragInside(false);var data=this.inspector.parse(e.target);if(data.isComponent()&&!data.isComponentEditable()&&!data.isFigcaption()){this.app.setDragComponentInside(data.getComponent());}else if(this.selection.is()&&!this.selection.isCollapsed()){// drag starts inside editor
this.app.setDragInside(true);this._setDragData(e);}this.app.broadcast('dragstart',e);},dragover:function dragover(e){this.app.broadcast('dragover',e);},dragleave:function dragleave(e){this.app.broadcast('dragleave',e);},paste:function paste(e){this.app.broadcast('paste',e);},contextmenu:function contextmenu(e){// chrome crashes fix
//this.editor.disableNonEditables();
//setTimeout(function()
//{
//  this.editor.enableNonEditables();
// this.app.broadcast('contextmenu', e);
//}.bind(this), 0);
},click:function click(e){// triple click selection
if(e.detail===3){e.preventDefault();var block=this.selection.getBlock();if(block){var range=document.createRange();range.selectNodeContents(block);this.selection.setRange(range);}}// observe bottom click & start click & outside click
var $target=$R.dom(e.target);if($target.hasClass('redactor-in')){var top=$target.offset().top;var pad=parseFloat($target.css('padding-bottom'));var height=$target.height();var posHeight=top+height-pad*2;if(posHeight<e.pageY){this.app.broadcast('bottomclick',e);}else if($target.hasClass('redactor-placeholder')){this.editor.startFocus(this.editor);}}this.app.broadcast('state',e);this.app.broadcast('click',e);},keydown:function keydown(e){this.app.broadcast('state',e);var stop=this.app.broadcast('keydown',e);if(stop===false){return e.preventDefault();}},keyup:function keyup(e){this.app.broadcast('keyup',e);},mouseup:function mouseup(e){this.app.broadcast('observe',e);this.app.broadcast('state',e);},touchstart:function touchstart(e){this.app.broadcast('observe',e);this.app.broadcast('state',e);},// private
_init:function _init(){var $editor=this.editor.getElement();$editor.on('focus.redactor-focus click.redactor-focus',this.focus.bind(this));this.$doc.on('keyup'+this.blurNamespace+' mousedown'+this.blurNamespace,this.blur.bind(this));// all events
this._loop('on');},_removeOverClass:function _removeOverClass(){var $editor=this.editor.getElement();$editor.removeClass('over');},_loop:function _loop(func){var $editor=this.editor.getElement();for(var i=0;i<this.eventsList.length;i++){var event=this.eventsList[i]+'.redactor-events';var method=this.eventsList[i];$editor[func](event,this[method].bind(this));}},_passAllToClipboard:function _passAllToClipboard(e){var clipboard=e.clipboardData;var content=this.source.getCode();clipboard.setData('text/html',content);clipboard.setData('text/plain',content.toString().replace(/\n$/,""));},_passSelectionToClipboard:function _passSelectionToClipboard(e,data,remove){var clipboard=e.clipboardData;var node=data.getComponent();var $node=$R.dom(node);var $cloned=$node.clone();// clean
$cloned.find('.redactor-component-caret').remove();$cloned.removeClass('redactor-component-active');$cloned.removeAttr('contenteditable');$cloned.removeAttr('tabindex');// html
var content=$cloned.get().outerHTML;if(remove)this.component.remove(node);clipboard.setData('text/html',content);clipboard.setData('text/plain',content.toString().replace(/\n$/,""));},_setDragData:function _setDragData(e){e=e.originalEvent||e;var dt=e.dataTransfer;dt.effectAllowed='move';dt.setData('text/Html',this.selection.getHtml());}});$R.add('module','container',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.lang=app.lang;this.element=app.element;this.container=app.container;},// public
start:function start(){this._build();this._buildAccesibility();},stop:function stop(){var $element=this.element.getElement();var $container=this.container.getElement();$container.after($element);$container.remove();$element.show();},// private
_build:function _build(){var $element=this.element.getElement();var $container=this.container.getElement();$container.addClass('redactor-box');$container.attr('dir',this.opts.direction);if(this.element.isType('inline'))$container.addClass('redactor-inline');$element.after($container);$container.append($element);},_buildAccesibility:function _buildAccesibility(){var $container=this.container.getElement();var $label=$R.dom('<span />');$label.addClass('redactor-voice-label');$label.attr({'id':'redactor-voice-'+this.uuid,'aria-hidden':false});$label.html(this.lang.get('accessibility-help-label'));$container.prepend($label);}});$R.add('module','source',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.utils=app.utils;this.element=app.element;this.source=app.source;this.editor=app.editor;this.toolbar=app.toolbar;this.cleaner=app.cleaner;this.component=app.component;this.container=app.container;this.autoparser=app.autoparser;this.selection=app.selection;// local
this.syncedHtml='';},// messages
onstartcode:function onstartcode(){var sourceContent=this.source.getStartedContent();var $editor=this.editor.getElement();var $source=this.source.getElement();// autoparse
if(this.opts.autoparse&&this.opts.autoparseStart){sourceContent=this.autoparser.parse(sourceContent);}// started content
var startContent=this.cleaner.input(sourceContent,true,true);var syncContent=this.cleaner.output(startContent);// set content
$editor.html(startContent);$source.val(syncContent);this.syncedHtml=syncContent;this.app.broadcast('placeholder.build');this.app.broadcast('autoparseobserve');// widget's scripts
this.component.executeScripts();},onstartcodeshow:function onstartcodeshow(){this.show();},ontrytosync:function ontrytosync(){this.sync();},onhardsync:function onhardsync(){var $editor=this.editor.getElement();var html=$editor.html();html=this.app.broadcast('syncBefore',html);html=this.cleaner.output(html);this._syncing(html);},// public
start:function start(){this._build();this._buildClasses();},stop:function stop(){var $element=this.element.getElement();var $source=this.source.getElement();$element.removeClass('redactor-source redactor-source-open');$source.off('input.redactor-source');$source.removeAttr('data-gramm_editor');if($source.get().classList.length===0)$source.removeAttr('class');if(!this.source.isNameGenerated())$element.removeAttr('name');if(!this.element.isType('textarea'))$source.remove();},getCode:function getCode(){return this.source.getCode();},// public
toggle:function toggle(){if(!this.opts.source)return;var $source=this.source.getElement();return $source.hasClass('redactor-source-open')?this.hide():this.show();},show:function show(){if(!this.opts.source)return;var $editor=this.editor.getElement();var $source=this.source.getElement();var $container=this.container.getElement();var html=$source.val();if(this.app.isStarted())html=this.app.broadcast('source.open',html);// get height
var editorHeight=$editor.height();$editor.hide();$source.height(editorHeight);$source.val(html.trim());$source.show();$source.addClass('redactor-source-open');$source.on('input.redactor-source-events',this._onChangedSource.bind(this));$source.on('keydown.redactor-source-events',this._onTabKey.bind(this));$source.on('focus.redactor-source-events',this._onFocus.bind(this));if(this.opts.source.hasOwnProperty('codemirror')){var opts=_typeof(this.opts.source.codemirror)==='object'?this.opts.source.codemirror:{};var codemirrorSrc=typeof this.opts.source.codemirrorSrc!=='undefined'?this.opts.source.codemirrorSrc:CodeMirror;this.codemirror=codemirrorSrc.fromTextArea($source.get(),opts);this.codemirror.setSize(null,editorHeight);this.codemirror.on('change',function(cm,changeObj){cm.save();});this.codemirror.on('change',this._onChangedSource.bind(this));}else{$container.addClass('redactor-source-view');}// buttons
setTimeout(function(){this._disableButtons();this._setActiveSourceButton();}.bind(this),100);if(this.app.isStarted())this.app.broadcast('source.opened');},hide:function hide(){if(!this.opts.source)return;var $editor=this.editor.getElement();var $source=this.source.getElement();var $container=this.container.getElement();var html=$source.val();if(this.opts.source.hasOwnProperty('codemirror')){html=this.codemirror.getValue();this.codemirror.toTextArea();}// clean
html=this.cleaner.input(html,true);html=this.utils.isEmptyHtml(html)?this.opts.emptyHtml:html;html=this.app.broadcast('source.close',html);// buttons
this._enableButtons();this._setInactiveSourceButton();$source.hide();$source.removeClass('redactor-source-open');$source.off('.redactor-source-events');$editor.show();$editor.html(html);$container.removeClass('redactor-source-view');setTimeout(function(){this.editor.startFocus();// widget's scripts
this.component.executeScripts();}.bind(this),0);this.app.broadcast('source.closed');},sync:function sync(){var self=this;var $editor=this.editor.getElement();var html=$editor.html();html=this.app.broadcast('syncBefore',html);html=this.cleaner.output(html);if(this._isSync(html)){if(this.timeout)clearTimeout(this.timeout);this.timeout=setTimeout(function(){self._syncing(html);},200);}},// private
_build:function _build(){var $source=this.source.getElement();var $element=this.element.getElement();$source.hide();if(!this.opts.grammarly){$source.attr('data-gramm_editor',false);}if(!this.element.isType('textarea')){$element.after($source);}},_buildClasses:function _buildClasses(){var $source=this.source.getElement();$source.addClass('redactor-source');},_syncing:function _syncing(html){html=this.app.broadcast('syncing',html);var $source=this.source.getElement();$source.val(html);this.app.broadcast('synced',html);this.app.broadcast('changed',html);},_isSync:function _isSync(html){if(this.syncedHtml!==html){this.syncedHtml=html;return true;}return false;},_onChangedSource:function _onChangedSource(){var $source=this.source.getElement();var html=$source.val();this.app.broadcast('changed',html);this.app.broadcast('source.changed',html);},_onTabKey:function _onTabKey(e){if(e.keyCode!==9)return true;e.preventDefault();var $source=this.source.getElement();var el=$source.get();var start=el.selectionStart;$source.val($source.val().substring(0,start)+"    "+$source.val().substring(el.selectionEnd));el.selectionStart=el.selectionEnd=start+4;},_onFocus:function _onFocus(){this.app.broadcast('sourcefocus');},_disableButtons:function _disableButtons(){this.toolbar.disableButtons();},_enableButtons:function _enableButtons(){this.toolbar.enableButtons();},_setActiveSourceButton:function _setActiveSourceButton(){var $btn=this.toolbar.getButton('html');$btn.enable();$btn.setActive();},_setInactiveSourceButton:function _setInactiveSourceButton(){var $btn=this.toolbar.getButton('html');$btn.setInactive();}});$R.add('module','observer',{init:function init(app){this.app=app;this.editor=app.editor;// local
this.observerUnit=false;},// public
start:function start(){if(window.MutationObserver){var $editor=this.editor.getElement();var el=$editor.get();this.observerUnit=this._build(el);this.observerUnit.observe(el,{attributes:true,subtree:true,childList:true,characterData:true,characterDataOldValue:true});}},stop:function stop(){if(this.observerUnit)this.observerUnit.disconnect();},// private
_build:function _build(el){var self=this;return new MutationObserver(function(mutations){self._observe(mutations[mutations.length-1],el);});},_observe:function _observe(mutation,el){if(this.app.isReadOnly()||mutation.type==='attributes'&&mutation.target===el){return;}this.app.broadcast('observe');this.app.broadcast('trytosync');this.app.broadcast('placeholder.toggle');}});$R.add('module','clicktoedit',{init:function init(app){this.app=app;this.opts=app.opts;this.source=app.source;this.editor=app.editor;this.container=app.container;this.selection=app.selection;},// messages
onstartclicktoedit:function onstartclicktoedit(){this.start();},onenablereadonly:function onenablereadonly(){if(!this.opts.clickToEdit)return;if(!this._isEnabled())this.stop();},ondisablereadonly:function ondisablereadonly(){if(!this.opts.clickToEdit)return;if(!this._isEnabled())this.start();},onstop:function onstop(){this.stop();},// public
start:function start(){this._build();},stop:function stop(){if(this.buttonSave)this.buttonSave.stop();if(this.buttonCancel)this.buttonCancel.stop();this._destroy();this.app.broadcast('disable');},enable:function enable(){this.app.broadcast('clickStart');var isEmpty=this.editor.isEmpty();if(!isEmpty)this.selection.saveMarkers();this._setFocus();this._destroy();this.app.broadcast('enable');this.buttonSave.enable();this.buttonCancel.enable();if(!isEmpty)this.selection.restoreMarkers();if(isEmpty)this.editor.focus();var $container=this.container.getElement();$container.addClass('redactor-clicktoedit-enabled');this.source.rebuildStartedContent();this.app.broadcast('startcode');this.app.broadcast('image.observe');},save:function save(e){if(e)e.preventDefault();var html=this.source.getCode();this.app.broadcast('disable');this.app.broadcast('clickSave',html);this.app.broadcast('clickStop');this.app.broadcast('toolbar.removeexternal');this._build();},cancel:function cancel(e){if(e)e.preventDefault();var html=this.saved;var $editor=this.editor.getElement();$editor.html(html);this.saved='';this.app.broadcast('disable');this.app.broadcast('clickCancel',html);this.app.broadcast('clickStop');this.app.broadcast('toolbar.removeexternal');this._build();},// private
_build:function _build(){// buttons
this.buttonSave=$R.create('clicktoedit.button','save',this.app,this);this.buttonCancel=$R.create('clicktoedit.button','cancel',this.app,this);this.buttonSave.stop();this.buttonCancel.stop();var $editor=this.editor.getElement();var $container=this.container.getElement();$editor.on('click.redactor-click-to-edit mouseup.redactor-click-to-edit',this.enable.bind(this));$container.addClass('redactor-over');$container.removeClass('redactor-clicktoedit-enabled');},_isEnabled:function _isEnabled(){return this.container.getElement().hasClass('redactor-clicktoedit-enabled');},_destroy:function _destroy(){var $editor=this.editor.getElement();var $container=this.container.getElement();$editor.off('.redactor-click-to-edit');$container.removeClass('redactor-over redactor-clicktoedit-enabled');},_setFocus:function _setFocus(){this.saved=this.source.getCode();this.buttonSave.start();this.buttonCancel.start();}});$R.add('class','clicktoedit.button',{init:function init(type,app,context){this.app=app;this.opts=app.opts;this.toolbar=app.toolbar;this.context=context;// local
this.type=type;this.name=type==='save'?'clickToSave':'clickToCancel';this.objected=false;this.enabled=false;this.namespace='.redactor-click-to-edit';// build
this._build();},enable:function enable(){if(!this.objected)return;var data=this.opts[this.name];data.api='module.clicktoedit.'+this.type;this.toolbar.addButton(this.type,data);this.enabled=true;},start:function start(){if(this.objected)return;this.$button.off(this.namespace);this.$button.show();this.$button.on('click'+this.namespace,this.context[this.type].bind(this.context));},stop:function stop(){if(this.objected||!this.enabled)return;this.$button.hide();},// private
_build:function _build(){this.objected=_typeof(this.opts[this.name])==='object';if(!this.objected){this.$button=$R.dom(this.opts[this.name]);this.enabled=true;}}});$R.add('module','statusbar',{init:function init(app){this.app=app;this.opts=app.opts;this.element=app.element;this.statusbar=app.statusbar;this.container=app.container;},// public
start:function start(){if(!this.element.isType('inline')){var $statusbar=this.statusbar.getElement();var $container=this.container.getElement();$statusbar.addClass('redactor-statusbar');$container.append($statusbar);}}});$R.add('module','contextbar',{init:function init(app){this.app=app;this.opts=app.opts;this.uuid=app.uuid;this.$win=app.$win;this.$doc=app.$doc;this.$body=app.$body;this.editor=app.editor;this.toolbar=app.toolbar;this.detector=app.detector;// local
this.$target=this.toolbar.isTarget()?this.toolbar.getTargetElement():this.$body;},// messages
onstop:function onstop(){this.stop();},onenablereadonly:function onenablereadonly(){this.stop();},ondisablereadonly:function ondisablereadonly(){this.start();},oncontextbar:{close:function close(){this.close();}},// public
start:function start(){if(this.opts.toolbarContext){var $editor=this.editor.getElement();this._build();$editor.on('click.redactor-context mouseup.redactor-context',this.open.bind(this));if(this.opts.scrollTarget){$R.dom(this.opts.scrollTarget).on('scroll.redactor-context',this.close.bind(this));}else if(this.opts.maxHeight!==false){$editor.on('scroll.redactor-context',this.close.bind(this));}}},stop:function stop(){var $editor=this.editor.getElement();$editor.off('.redactor-context');this.$doc.off('.redactor-context');this.$win.off('.redactor-context');if(this.$contextbar)this.$contextbar.remove();if(this.opts.scrollTarget){$R.dom(this.opts.scrollTarget).off('.redactor-context');}},is:function is(){return this.$contextbar&&this.$contextbar.hasClass('open');},set:function set(e,node,buttons,position){this.$contextbar.html('');this.$el=$R.dom(node);// buttons
for(var key in buttons){var $btn=$R.create('contextbar.button',this.app,buttons[key]);if($btn.html()!==''){this.$contextbar.append($btn);}}// show
var pos=this._buildPosition(e,this.$el,position);this.$contextbar.css(pos);this.$contextbar.show();this.$contextbar.addClass('open');this.$doc.on('click.redactor-context mouseup.redactor-context',this.close.bind(this));this.$win.on('resize.redactor-context',this.close.bind(this));},open:function open(e){setTimeout(function(){this.app.broadcast('contextbar',e,this);}.bind(this),0);},close:function close(e){if(!this.$contextbar)return;if(e){var $target=$R.dom(e.target);if(this.$el&&$target.closest(this.$el).length!==0){return;}}this.$contextbar.hide();this.$contextbar.removeClass('open');this.$doc.off('.redactor.context');},// private
_build:function _build(){this.$contextbar=$R.dom('<div>');this.$contextbar.attr('id','redactor-context-toolbar-'+this.uuid);this.$contextbar.attr('dir',this.opts.direction);this.$contextbar.addClass('redactor-context-toolbar');this.$contextbar.hide();this.$target.append(this.$contextbar);},_buildPosition:function _buildPosition(e,$el,position){var top,left;var isTarget=this.toolbar.isTarget();var offset=isTarget?$el.position():$el.offset();var width=$el.width();var height=$el.height();var barWidth=this.$contextbar.width();var barHeight=this.$contextbar.height();var docScrollTop=isTarget?this.$target.scrollTop()+this.$doc.scrollTop():this.$doc.scrollTop();var targetOffset=this.$target.offset();var leftFix=isTarget?targetOffset.left:0;var topFix=isTarget?targetOffset.top:0;if(!position){top=e.clientY+docScrollTop-barHeight;left=e.clientX-barWidth/2;}else if(position==='top'){top=offset.top-barHeight;left=offset.left+width/2-barWidth/2;}else if(position==='bottom'){top=offset.top+height;left=offset.left+width/2-barWidth/2;}if(left<0)left=0;return{top:top-topFix+'px',left:left-leftFix+'px'};}});$R.add('class','contextbar.button',{mixins:['dom'],init:function init(app,obj){this.app=app;// local
this.obj=obj;// init
this._init();},// private
_init:function _init(){this.parse('<a>');if(typeof this.obj.title!=='string'){var url=this.obj.title.attr('href');this.attr('href',url);if(url.search(/^#/)===-1){this.attr('target','_blank');}this.text(this.obj.html||url);}else{this.attr('href','#');this._buildTitle();this._buildMessage();}},_buildTitle:function _buildTitle(){this.html(this.obj.title);},_buildMessage:function _buildMessage(){if(typeof this.obj.message!=='undefined'||typeof this.obj.api!=='undefined'){this.on('click',this._toggle.bind(this));}},_toggle:function _toggle(e){e.preventDefault();if(this.obj.message){this.app.broadcast(this.obj.message,this.obj.args);}else if(this.obj.api){this.app.api(this.obj.api,this.obj.args);}}});$R.add('module','toolbar',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.utils=app.utils;this.toolbar=app.toolbar;this.detector=app.detector;// local
this.buttons=[];this.toolbarModule=false;},// messages
onsource:{open:function open(){if(!this.toolbar.isAir()&&this.toolbar.isFixed()){this.toolbarModule.resetPosition();}},opened:function opened(){if(this.toolbar.isAir()&&this.toolbarModule){this.toolbarModule.createSourceHelper();}// hide tooltips
setTimeout(function(){$R.dom('.re-button-tooltip-'+this.uuid).remove();}.bind(this),100);},close:function close(){if(this.toolbar.isAir()&&this.toolbarModule){this.toolbarModule.destroySourceHelper();}},closed:function closed(){if(this.toolbar.is()&&this.opts.air){this.toolbarModule.openSelected();}}},ontoolbar:{removeexternal:function removeexternal(){if(!this.opts.air&&this.opts.toolbarExternal&&this.opts.clickToEdit){$R.dom(this.opts.toolbarExternal).html('');}}},onobserve:function onobserve(){if(this.toolbar.is()){this.toolbar.observe();}},onfocus:function onfocus(){this._setExternalOnFocus();},onsourcefocus:function onsourcefocus(){this._setExternalOnFocus();},onempty:function onempty(){if(this.toolbar.isFixed()){this.toolbarModule.resetPosition();}},onenablereadonly:function onenablereadonly(){if(this.toolbar.isAir()){this.toolbarModule.close();}},// public
start:function start(){if(this.toolbar.is()){this._buildButtons();this._initToolbar();this._initButtons();}},stop:function stop(){if(this.toolbarModule){this.toolbarModule.stop();}// stop dropdowns & tooltips
$R.dom('.re-button-tooltip-'+this.uuid).remove();$R.dom('.redactor-dropdown-'+this.uuid).remove();},// private
_buildButtons:function _buildButtons(){this.buttons=this.opts.buttons.concat();this._buildImageButton();this._buildFileButton();this._buildSourceButton();this._buildAdditionalButtons();this._buildHiddenButtons();},_buildImageButton:function _buildImageButton(){if(!this.opts.imageUpload&&!this.opts.imageManagerJson)this.utils.removeFromArrayByValue(this.buttons,'image');},_buildFileButton:function _buildFileButton(){if(!this.opts.fileUpload)this.utils.removeFromArrayByValue(this.buttons,'file');},_buildSourceButton:function _buildSourceButton(){if(!this.opts.source)this.utils.removeFromArrayByValue(this.buttons,'html');},_buildAdditionalButtons:function _buildAdditionalButtons(){// end
if(this.opts.buttonsAdd.length!==0){this.opts.buttonsAdd=this._removeExistButtons(this.opts.buttonsAdd);this.buttons=this.buttons.concat(this.opts.buttonsAdd);}// beginning
if(this.opts.buttonsAddFirst.length!==0){this.opts.buttonsAddFirst=this._removeExistButtons(this.opts.buttonsAddFirst);this.buttons.unshift(this.opts.buttonsAddFirst);}var index,btns;// after
if(this.opts.buttonsAddAfter!==false){index=this.buttons.indexOf(this.opts.buttonsAddAfter.after)+1;btns=this.opts.buttonsAddAfter.buttons;for(var i=0;i<btns.length;i++){this.buttons.splice(index+i,0,btns[i]);}}// before
if(this.opts.buttonsAddBefore!==false){index=this.buttons.indexOf(this.opts.buttonsAddBefore.before)+1;btns=this.opts.buttonsAddBefore.buttons;for(var i=0;i<btns.length;i++){this.buttons.splice(index-(1-i),0,btns[i]);}}},_buildHiddenButtons:function _buildHiddenButtons(){if(this.opts.buttonsHide.length!==0){var buttons=this.opts.buttonsHide;for(var i=0;i<buttons.length;i++){this.utils.removeFromArrayByValue(this.buttons,buttons[i]);}}if(this.detector.isMobile()&&this.opts.buttonsHideOnMobile.length!==0){var buttons=this.opts.buttonsHideOnMobile;for(var i=0;i<buttons.length;i++){this.utils.removeFromArrayByValue(this.buttons,buttons[i]);}}},_removeExistButtons:function _removeExistButtons(buttons){for(var i=0;i<buttons.length;i++){if(this.opts.buttons.indexOf(buttons[i])!==-1){this.utils.removeFromArrayByValue(buttons,buttons[i]);}}return buttons;},_setExternalOnFocus:function _setExternalOnFocus(){if(!this.opts.air&&this.opts.toolbarExternal){this.toolbarModule.setExternal();}},_initToolbar:function _initToolbar(){this.toolbarModule=this.opts.air?$R.create('toolbar.air',this.app):$R.create('toolbar.standard',this.app);},_initButtons:function _initButtons(){this.toolbar.setButtons(this.buttons);for(var i=0;i<this.buttons.length;i++){var name=this.buttons[i];if($R.buttons[name]){this.toolbar.addButton(name,$R.extend(true,{},$R.buttons[name]),false,false,true);}}}});$R.add('class','toolbar.air',{init:function init(app){this.app=app;this.uuid=app.uuid;this.$doc=app.$doc;this.$win=app.$win;this.utils=app.utils;this.editor=app.editor;this.animate=app.animate;this.toolbar=app.toolbar;this.container=app.container;this.inspector=app.inspector;this.selection=app.selection;// local
this.clicks=0;// init
this._init();},// public
stop:function stop(){var $wrapper=this.toolbar.getWrapper();$wrapper.remove();var $editor=this.editor.getElement();$editor.off('.redactor-air-trigger-'+this.uuid);this.$doc.off('.redactor-air-'+this.uuid);this.$doc.off('.redactor-air-trigger-'+this.uuid);this.toolbar.stopObservers();},createSourceHelper:function createSourceHelper(){this.$airHelper=$R.dom('<span>');this.$airHelper.addClass('redactor-air-helper');this.$airHelper.html('<i class="re-icon-html"></i>');this.$airHelper.on('click',function(e){e.preventDefault();this.app.api('module.source.hide');}.bind(this));var $container=this.container.getElement();$container.append(this.$airHelper);},destroySourceHelper:function destroySourceHelper(){if(this.$airHelper)this.$airHelper.remove();},openSelected:function openSelected(){setTimeout(function(){if(this._isSelection())this._open(false);}.bind(this),0);},close:function close(){this.$doc.off('.redactor-air-'+this.uuid);var $toolbar=this.toolbar.getElement();$toolbar.removeClass('open');$toolbar.hide();},// private
_init:function _init(){this.toolbar.create();var $wrapper=this.toolbar.getWrapper();var $toolbar=this.toolbar.getElement();var $editor=this.editor.getElement();var $container=this.container.getElement();$wrapper.addClass('redactor-toolbar-wrapper-air');$toolbar.addClass('redactor-air');//$toolbar.addClass('redactor-animate-hide');
$toolbar.hide();$wrapper.append($toolbar);$container.prepend($wrapper);// open selected
this.openSelected();// events
this.$doc.on('mouseup.redactor-air-trigger-'+this.uuid,this._open.bind(this));$editor.on('keyup.redactor-air-trigger-'+this.uuid,this._openCmd.bind(this));},_isSelection:function _isSelection(){return this.selection.is()&&!this.selection.isCollapsed();},_isOpened:function _isOpened(){var $toolbar=this.toolbar.getElement();return $toolbar.hasClass('open');},_open:function _open(e){var target=e?e.target:false;var $el=e?$R.dom(e.target):false;var dataTarget=this.inspector.parse(target);var isComponent=dataTarget.isComponent()&&!dataTarget.isComponentType('table');var isFigcaption=dataTarget.isFigcaption();var isModalTarget=$el&&$el.closest('.redactor-modal').length!==0;var isButtonCall=e&&$el.closest('.re-button').length!==0;var isDropdownCall=e&&$el.closest('.redactor-dropdown').length!==0;if(isDropdownCall||isButtonCall||isModalTarget||isFigcaption||isComponent||this.toolbar.isContextBar()||!this._isSelection()){return;}var pos=this.selection.getPosition();setTimeout(function(){if(this.app.isReadOnly())return;if(this._isSelection())this._doOpen(pos);}.bind(this),1);},_openCmd:function _openCmd(){if(this.selection.isAll()){var $toolbar=this.toolbar.getElement();var pos=this.selection.getPosition();pos.top=pos.top<20?0:pos.top-$toolbar.height();pos.height=0;this._doOpen(pos);}},_doOpen:function _doOpen(pos){var $wrapper=this.toolbar.getWrapper();var $toolbar=this.toolbar.getElement();var $container=this.container.getElement();var containerOffset=$container.offset();var leftFix=0;var winWidth=this.$win.width();var toolbarWidth=$toolbar.width();if(winWidth<pos.left+toolbarWidth){var selPos=this.selection.getPosition();leftFix=toolbarWidth-selPos.width;}$wrapper.css({left:pos.left-containerOffset.left-leftFix+'px',top:pos.top-containerOffset.top+pos.height+this.$doc.scrollTop()+'px'});this.app.broadcast('airOpen');$toolbar.addClass('open');$toolbar.show();this.$doc.on('click.redactor-air-'+this.uuid,this._close.bind(this));this.$doc.on('keydown.redactor-air-'+this.uuid,this._close.bind(this));this.app.broadcast('airOpened');},_close:function _close(e){var $el=e?$R.dom(e.target):false;var isDropdownCall=e&&$el.closest('[data-dropdown], .redactor-dropdown-not-close').length!==0;var isButtonCall=!isDropdownCall&&e&&$el.closest('.re-button').length!==0;if(!isButtonCall&&(isDropdownCall||!this._isOpened())){return;}// close
this.app.broadcast('airClose');this.close();this.app.broadcast('airClosed');}});$R.add('class','toolbar.fixed',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.$doc=app.$doc;this.$win=app.$win;this.editor=app.editor;this.toolbar=app.toolbar;this.detector=app.detector;this.container=app.container;// init
this._init();},// public
stop:function stop(){this.$fixedTarget.off('.redactor-toolbar-'+this.uuid);this.$win.off('.redactor-toolbar-'+this.uuid);},reset:function reset(){var $toolbar=this.toolbar.getElement();var $wrapper=this.toolbar.getWrapper();$wrapper.css('height','');$toolbar.removeClass('redactor-toolbar-fixed');$toolbar.css({position:'',top:'',left:'',width:''});var dropdown=this.toolbar.getDropdown();if(dropdown)dropdown.updatePosition();},// private
_init:function _init(){this.$fixedTarget=this.toolbar.isTarget()?this.toolbar.getTargetElement():this.$win;this._doFixed();if(this.toolbar.isTarget()){this.$win.on('scroll.redactor-toolbar-'+this.uuid,this._doFixed.bind(this));this.$win.on('resize.redactor-toolbar-'+this.uuid,this._doFixed.bind(this));}this.$fixedTarget.on('scroll.redactor-toolbar-'+this.uuid,this._doFixed.bind(this));this.$fixedTarget.on('resize.redactor-toolbar-'+this.uuid,this._doFixed.bind(this));},_doFixed:function _doFixed(){var $editor=this.editor.getElement();var $container=this.container.getElement();var $toolbar=this.toolbar.getElement();var $wrapper=this.toolbar.getWrapper();if(this.editor.isSourceMode()){return;}var $targets=$container.parents().filter(function(node){return getComputedStyle(node,null).display==='none'?node:false;});// has hidden parent
if($targets.length!==0)return;var isHeight=$editor.height()<100;var isEmpty=this.editor.isEmpty();if(isHeight||isEmpty){this.reset();return;}if(this.editor.isSourceMode()){return;}var toolbarHeight=$toolbar.height();var toleranceEnd=60;var containerOffset=this.toolbar.isTarget()?$container.position():$container.offset();var boxOffset=containerOffset.top;var boxEnd=boxOffset+$container.height()-toleranceEnd;var scrollOffset=this.$fixedTarget.scrollTop()+this.opts.toolbarFixedTopOffset;var top=!this.toolbar.isTarget()?0:this.$fixedTarget.offset().top-this.$win.scrollTop();if(this.toolbar.isTarget()&&this.$fixedTarget.css('position')==='fixed'){var bs=this.$fixedTarget.hasClass('modal')&&this.$fixedTarget.hasClass('fade');var bsFix=bs?$container.closest('.modal-dialog').position().top:0;top=this.$fixedTarget.scrollTop()-bsFix;}if(scrollOffset>boxOffset&&scrollOffset<boxEnd){var position=this.detector.isDesktop()?'fixed':'absolute';top=this.detector.isDesktop()?top:scrollOffset-boxOffset;if(this.detector.isMobile()){if(this.fixedScrollTimeout){clearTimeout(this.fixedScrollTimeout);}$toolbar.hide();this.fixedScrollTimeout=setTimeout(function(){$toolbar.show();},250);}$wrapper.height(toolbarHeight);$toolbar.addClass('redactor-toolbar-fixed');if($container.hasClass('redactor-box-fullscreen')){$toolbar.css({position:position,top:'0px',width:$container.width()+'px'});}else{$toolbar.css({position:position,top:top+this.opts.toolbarFixedTopOffset+'px',width:$container.width()+'px'});}var dropdown=this.toolbar.getDropdown();if(dropdown)dropdown.updatePosition();this.app.broadcast('toolbar.fixed');}else{this.reset();this.app.broadcast('toolbar.unfixed');}}});$R.add('class','toolbar.standard',{init:function init(app){this.app=app;this.opts=app.opts;this.uuid=app.uuid;this.$body=app.$body;this.toolbar=app.toolbar;this.container=app.container;// local
this.isExternalMultiple=false;this.toolbarFixed=false;// init
this._init();},// public
stop:function stop(){var $wrapper=this.toolbar.getWrapper();$wrapper.remove();if(this.toolbarFixed)this.toolbarFixed.stop();if(this.opts.toolbarExternal)this._findToolbars();this.toolbar.stopObservers();this.$body.find('.re-button-tooltip-'+this.uuid).remove();},setExternal:function setExternal(){this._findToolbars();if(this.isExternalMultiple){this.$toolbars.hide();var $current=this.$external.find('.redactor-toolbar-external-'+this.uuid);$current.show();}},resetPosition:function resetPosition(){if(this.toolbarFixed)this.toolbarFixed.reset();},// private
_init:function _init(){this._build();if(this.opts.toolbarExternal){this._buildExternal();}else{this._buildFixed();var $toolbar=this.toolbar.getElement();$toolbar.show();}},_build:function _build(){this.toolbar.create();var $wrapper=this.toolbar.getWrapper();var $toolbar=this.toolbar.getElement();$wrapper.addClass('redactor-toolbar-wrapper');$toolbar.addClass('redactor-toolbar');$toolbar.hide();$wrapper.append($toolbar);if(!this.opts.toolbarExternal){var $container=this.container.getElement();$container.prepend($wrapper);}},_buildExternal:function _buildExternal(){this._initExternal();this._findToolbars();if(this.isExternalMultiple){this._hideToolbarsExceptFirst();}else{var $toolbar=this.toolbar.getElement();$toolbar.show();}},_buildFixed:function _buildFixed(){if(this.opts.toolbarFixed){this.toolbarFixed=$R.create('toolbar.fixed',this.app);}},_initExternal:function _initExternal(){var $toolbar=this.toolbar.getElement();var $wrapper=this.toolbar.getElement();$toolbar.addClass('redactor-toolbar-external redactor-toolbar-external-'+this.uuid);this.$external=$R.dom(this.opts.toolbarExternal);this.$external.append($wrapper);},_findToolbars:function _findToolbars(){this.$toolbars=this.$external.find('.redactor-toolbar-external');this.isExternalMultiple=this.$toolbars.length>1;},_hideToolbarsExceptFirst:function _hideToolbarsExceptFirst(){this.$toolbars.hide();var $first=this.$toolbars.first();$first.show();}});$R.add('module','line',{init:function init(app){this.app=app;this.lang=app.lang;this.component=app.component;this.inspector=app.inspector;this.insertion=app.insertion;},// messages
oncontextbar:function oncontextbar(e,contextbar){var data=this.inspector.parse(e.target);if(data.isComponentType('line')){var node=data.getComponent();var buttons={"remove":{title:this.lang.get('delete'),api:'module.line.remove',args:node}};contextbar.set(e,node,buttons,'bottom');}},// public
insert:function insert(){var line=this.component.create('line');this.insertion.insertRaw(line);},remove:function remove(node){this.component.remove(node);}});$R.add('class','line.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;// init
return el&&el.cmnt!==undefined?el:this._init(el);},// private
_init:function _init(el){var wrapper,element;if(typeof el!=='undefined'){var $node=$R.dom(el);var node=$node.get();if(node.tagName==='HR')element=node;else if(node.tagName==='FIGURE'){wrapper=node;element=$node.find('hr').get();}}this._buildWrapper(wrapper);this._buildElement(element);this._initWrapper();},_buildElement:function _buildElement(node){if(node){this.$element=$R.dom(node);}else{this.$element=$R.dom('<hr>');this.append(this.$element);}},_buildWrapper:function _buildWrapper(node){node=node||'<figure>';this.parse(node);},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'line','tabindex':'-1','contenteditable':false});}});$R.add('module','link',{modals:{'link':'<form action=""> \
                <div class="form-item"> \
                    <label for="modal-link-url">URL <span class="req">*</span></label> \
                    <input type="text" id="modal-link-url" name="url"> \
                </div> \
                <div class="form-item"> \
                    <label for="modal-link-text">## text ##</label> \
                    <input type="text" id="modal-link-text" name="text"> \
                </div> \
                <div class="form-item form-item-title"> \
                    <label for="modal-link-title">## title ##</label> \
                    <input type="text" id="modal-link-title" name="title"> \
                </div> \
                <div class="form-item form-item-target"> \
                    <label class="checkbox"> \
                        <input type="checkbox" name="target"> ## link-in-new-tab ## \
                    </label> \
                </div> \
            </form>'},init:function init(app){this.app=app;this.opts=app.opts;this.lang=app.lang;this.caret=app.caret;this.utils=app.utils;this.inline=app.inline;this.editor=app.editor;this.inspector=app.inspector;this.insertion=app.insertion;this.selection=app.selection;// local
this.isCurrentLink=false;this.currentText=false;},// messages
onmodal:{link:{open:function open($modal,$form){this._setFormData($form,$modal);},opened:function opened($modal,$form){this._setFormFocus($form);},update:function update($modal,$form){var data=$form.getData();if(this._validateData($form,data)){this._update(data);}},insert:function insert($modal,$form){var data=$form.getData();if(this._validateData($form,data)){this._insert(data);}},unlink:function unlink(){this._unlink();}}},onbutton:{link:{observe:function observe(button){this._observeButton(button);}}},ondropdown:{link:{observe:function observe(dropdown){this._observeUnlink(dropdown);this._observeEdit(dropdown);}}},oncontextbar:function oncontextbar(e,contextbar){var current=this._getCurrent();var data=this.inspector.parse(current);if(data.isLink()||data.isFile()){var node=data.isFile()?data.getFile():data.getLink();var $el=$R.dom(node);var $point=$R.dom('<a>');var url=$el.attr('href');$point.text(this._truncateText(url));$point.attr('href',url);$point.attr('target','_blank');var buttons={"link":{title:$point,html:this._truncateText(url)},"edit":{title:this.lang.get('edit'),api:'module.link.open'},"unlink":{title:this.lang.get('unlink'),api:'module.link.unlink'}};contextbar.set(e,node,buttons,'bottom');}},// public
open:function open(){this.$link=this._buildCurrent();this.app.api('module.modal.build',this._getModalData());},insert:function insert(data){this._insert(data);},update:function update(data){this._update(data);},unlink:function unlink(){this._unlink();},// private
_observeButton:function _observeButton(button){var current=this.selection.getCurrent();var data=this.inspector.parse(current);if(data.isPre()||data.isCode()){button.disable();}else{button.enable();}},_observeUnlink:function _observeUnlink(dropdown){var $item=dropdown.getItem('unlink');var links=this._getLinks();if(links.length===0)$item.disable();else $item.enable();},_observeEdit:function _observeEdit(dropdown){var current=this._getCurrent();var $item=dropdown.getItem('link');var data=this.inspector.parse(current);var title=data.isLink()||data.isFile()?this.lang.get('link-edit'):this.lang.get('link-insert');$item.setTitle(title);},_unlink:function _unlink(){this.app.api('module.modal.close');var elms=[];var nodes=this._getLinks();this.selection.save();for(var i=0;i<nodes.length;i++){var $link=$R.create('link.component',this.app,nodes[i]);elms.push(this.selection.getElement(nodes[i]));$link.unwrap();// callback
this.app.broadcast('link.deleted',$link);}this.selection.restore();// normalize
for(var i=0;i<elms.length;i++){var el=elms[i]?elms[i]:this.editor.getElement();this.utils.normalizeTextNodes(el);}this._resetCurrent();},_update:function _update(data){this.app.api('module.modal.close');var nodes=this._getLinks();this._setLinkData(nodes,data,'updated');this._resetCurrent();// callback
this.app.broadcast('link.changed',nodes);},_insert:function _insert(data){this.app.api('module.modal.close');var links=this._getLinks();if(!this._insertSingle(links,data)){this._removeInSelection(links);this._insertMultiple(data);}this._resetCurrent();},_removeInSelection:function _removeInSelection(links){this.selection.save();for(var i=0;i<links.length;i++){var $link=$R.create('link.component',this.app,links[i]);var $clonedLink=$link.clone();$link.unwrap();// callback
this.app.broadcast('link.deleted',$clonedLink);}this.selection.restore();},_insertMultiple:function _insertMultiple(data){var range=this.selection.getRange();if(range&&this._isCurrentTextChanged(data)){this._deleteContents(range);}var nodes=this.inline.format({tag:'a'});this._setLinkData(nodes,data,'inserted');},_insertSingle:function _insertSingle(links,data){var inline=this.selection.getInline();if(links.length===1&&(links[0].textContext===this.selection.getText()||inline&&inline.tagName==='A')){var $link=$R.create('link.component',this.app,links[0]);$link.setData(data);this.caret.setAfter($link);// callback
this.app.broadcast('link.inserted',$link);return true;}return false;},_setLinkData:function _setLinkData(nodes,data,type){data.text=data.text.trim()===''?this._truncateText(data.url):data.text;var isTextChanged=!this.currentText||this.currentText!==data.text;this.selection.save();for(var i=0;i<nodes.length;i++){var $link=$R.create('link.component',this.app,nodes[i]);var linkData={};if(data.text&&isTextChanged)linkData.text=data.text;if(data.url)linkData.url=data.url;if(data.title!==undefined)linkData.title=data.title;if(data.target!==undefined)linkData.target=data.target;$link.setData(linkData);// callback
this.app.broadcast('link.'+type,$link);}setTimeout(this.selection.restore.bind(this.selection),0);},_deleteContents:function _deleteContents(range){var html=this.selection.getHtml();var parsed=this.utils.parseHtml(html);var first=parsed.nodes[0];if(first&&first.nodeType!==3){var tag=first.tagName.toLowerCase();var container=document.createElement(tag);this.insertion.insertNode(container,'start');}else{range.deleteContents();}},_getModalData:function _getModalData(){var commands;if(this._isLink()){commands={update:{title:this.lang.get('save')},unlink:{title:this.lang.get('unlink'),type:'danger'},cancel:{title:this.lang.get('cancel')}};}else{commands={insert:{title:this.lang.get('insert')},cancel:{title:this.lang.get('cancel')}};}var modalData={name:'link',title:this._isLink()?this.lang.get('link-edit'):this.lang.get('link-insert'),handle:this._isLink()?'update':'insert',commands:commands};return modalData;},_isLink:function _isLink(){return this.currentLink;},_isCurrentTextChanged:function _isCurrentTextChanged(data){return this.currentText&&this.currentText!==data.text;},_buildCurrent:function _buildCurrent(){var current=this._getCurrent();var data=this.inspector.parse(current);var $link;if(data.isLink()||data.isFile()){this.currentLink=true;$link=data.isFile()?data.getFile():data.getLink();$link=$R.create('link.component',this.app,$link);}else{this.currentLink=false;$link=$R.create('link.component',this.app);var linkData={text:this.selection.getText()};$link.setData(linkData);}return $link;},_getCurrent:function _getCurrent(){return this.selection.getInlinesAllSelected({tags:['a']})[0];},_getLinks:function _getLinks(){var links=this.selection.getInlines({all:true,tags:['a']});var arr=[];for(var i=0;i<links.length;i++){var data=this.inspector.parse(links[i]);if(data.isLink()||data.isFile()){arr.push(links[i]);}}return arr;},_resetCurrent:function _resetCurrent(){this.isCurrentLink=false;this.currentText=false;},_truncateText:function _truncateText(url){return url&&url.length>this.opts.linkSize?url.substring(0,this.opts.linkSize)+'...':url;},_validateData:function _validateData($form,data){return data.url.trim()===''?$form.setError('url'):true;},_setFormFocus:function _setFormFocus($form){$form.getField('url').focus();},_setFormData:function _setFormData($form,$modal){var linkData=this.$link.getData();var data={url:linkData.url,text:linkData.text,title:linkData.title,target:this.opts.linkTarget||linkData.target};if(!this.opts.linkNewTab)$modal.find('.form-item-target').hide();if(!this.opts.linkTitle)$modal.find('.form-item-title').hide();$form.setData(data);this.currentText=$form.getField('text').val();}});$R.add('class','link.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;this.opts=app.opts;// local
this.reUrl=/^(?:(?:(?:https?|ftp):)?\/\/)?(?:\S+(?::\S*)?@)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:[/?#]\S*)?$/i;// init
return el&&el.cmnt!==undefined?el:this._init(el);},// public
setData:function setData(data){for(var name in data){this._set(name,data[name]);}},getData:function getData(){var names=['url','text','target','title'];var data={};for(var i=0;i<names.length;i++){data[names[i]]=this._get(names[i]);}return data;},// private
_init:function _init(el){var $el=$R.dom(el);if(el===undefined){this.parse('<a>');}else{this.parse($el);}},_set:function _set(name,value){this['_set_'+name](value);},_get:function _get(name){return this['_get_'+name]();},_get_target:function _get_target(){return this.attr('target')?this.attr('target'):false;},_get_url:function _get_url(){return this.attr('href');},_get_title:function _get_title(){return this.attr('title');},_get_text:function _get_text(){return this._getContext().text();},_getContext:function _getContext(){return this._findDeepestChild(this).element;},_set_target:function _set_target(target){if(target===false)this.removeAttr('target');else if(target){this.attr('target',target===true?'_blank':target);}},_set_text:function _set_text(text){this._getContext().html(text);},_set_title:function _set_title(title){if(!title||title==='')this.removeAttr('title');else this.attr('title',title);},_set_url:function _set_url(url){if(this.opts.linkValidation){url=this._cleanUrl(url);if(this._isMailto(url)){url='mailto:'+url.replace('mailto:','');}else if(this._isUrl(url)&&url.search(/^(ftp|https?)/i)===-1){url='http://'+url.replace(/(ftp|https?):\/\//i,'');}}this.attr('href',url);},_isMailto:function _isMailto(url){return url.search('@')!==-1&&/(ftp|https?):\/\//i.test(url)===false;},_isUrl:function _isUrl(url){return this.reUrl.test(url);},_cleanUrl:function _cleanUrl(url){url=url.replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/'/g,"&#039;");return url.trim().replace(/[^\W\w\D\d+&\'@#/%?=~_|!:,.;\(\)]/gi,'');},_findDeepestChild:function _findDeepestChild(parent){var result={depth:0,element:parent};parent.children().each(function(node){var child=$R.dom(node);if(node.outerHTML!==parent.html()){return;}else{var childResult=this._findDeepestChild(child);if(childResult.depth+1>result.depth){result={depth:1+childResult.depth,element:childResult.element};}}}.bind(this));return result;}});$R.add('module','modal',{init:function init(app){this.app=app;this.uuid=app.uuid;this.lang=app.lang;this.$doc=app.$doc;this.$win=app.$win;this.$body=app.$body;this.utils=app.utils;this.editor=app.editor;this.animate=app.animate;this.detector=app.detector;this.selection=app.selection;// local
this.$box=false;this.$modal=false;this.selectionMarkers=false;// defaults
this.defaults={name:false,url:false,title:false,width:'600px',height:false,handle:false,commands:false};},// public
build:function build(data){this._open(data);},close:function close(){this._close();},onstop:function onstop(){this.$body.find('#redactor-modal-'+this.uuid).remove();this.$body.find('#redactor-overlay-'+this.uuid).remove();},stop:function stop(){if(this.$box){this.$box.remove();this.$box=false;this.$modal=false;}if(this.$overlay){this.$overlay.remove();}this.$doc.off('.redactor.modal');this.$win.off('.redactor.modal');},resize:function resize(){this.$modal.setWidth(this.p.width);this.$modal.updatePosition();},// private
_isOpened:function _isOpened(){return this.$modal&&this.$modal.hasClass('open');},_open:function _open(data){this._buildDefaults(data);if(this.p.url)this._openUrl();else this._openTemplate();},_openUrl:function _openUrl(){$R.ajax.post({url:this.p.url,success:this._doOpen.bind(this)});},_openTemplate:function _openTemplate(){if(typeof $R.modals[this.p.name]!=='undefined'){var template=this.lang.parse($R.modals[this.p.name]);this._doOpen(template);}},_doOpen:function _doOpen(template){this.stop();if(this.selection.isCollapsed()){this.selection.save();this.selectionMarkers=false;}else{this.selection.saveMarkers();this.selectionMarkers=true;}if(!this.detector.isDesktop()){document.activeElement.blur();}this._createModal(template);this._buildModalBox();this._buildOverlay();this._buildModal();this._buildModalForm();this._buildModalCommands();this._broadcast('open');this.$modal.updatePosition();this._buildModalTabs();this.animate.start(this.$box,'fadeIn',this._opened.bind(this));this.animate.start(this.$overlay,'fadeIn');},_opened:function _opened(){this.$modal.addClass('open');this.$box.on('mousedown.redactor.modal',this._close.bind(this));this.$doc.on('keyup.redactor.modal',this._handleEscape.bind(this));this.$win.on('resize.redactor.modal',this.resize.bind(this));this.$modal.getBody().find('input[type=text],input[type=url],input[type=email]').on('keydown.redactor.modal',this._handleEnter.bind(this));// fix bootstrap modal focus
if(window.jQuery)window.jQuery(document).off('focusin.modal');this._broadcast('opened');},_close:function _close(e){if(!this.$box||!this._isOpened())return;if(e){if(!this._needToClose(e.target)){return;}e.stopPropagation();e.preventDefault();}if(this.selectionMarkers)this.selection.restoreMarkers();else this.selection.restore();this.selectionMarkers=false;this._broadcast('close');this.animate.start(this.$box,'fadeOut',this._closed.bind(this));this.animate.start(this.$overlay,'fadeOut');},_closed:function _closed(){this.$modal.removeClass('open');this.$box.off('.redactor.modal');this.$doc.off('.redactor.modal');this.$win.off('.redactor.modal');this._broadcast('closed');},_createModal:function _createModal(template){this.$modal=$R.create('modal.element',this.app,template);},_broadcast:function _broadcast(message){this.app.broadcast('modal.'+message,this.$modal,this.$modalForm);this.app.broadcast('modal.'+this.p.name+'.'+message,this.$modal,this.$modalForm);},_buildDefaults:function _buildDefaults(data){this.p=$R.extend({},this.defaults,data);},_buildModalBox:function _buildModalBox(){this.$box=$R.dom('<div>');this.$box.attr('id','redactor-modal-'+this.uuid);this.$box.addClass('redactor-modal-box redactor-animate-hide');this.$box.html('');this.$body.append(this.$box);},_buildOverlay:function _buildOverlay(){this.$overlay=$R.dom('#redactor-overlay-'+this.uuid);if(this.$overlay.length===0){this.$overlay=$R.dom('<div>');this.$overlay.attr('id','redactor-overlay-'+this.uuid);this.$overlay.addClass('redactor-overlay redactor-animate-hide');this.$body.prepend(this.$overlay);}},_buildModal:function _buildModal(){this.$box.append(this.$modal);this.$modal.setTitle(this.p.title);this.$modal.setHeight(this.p.height);this.$modal.setWidth(this.p.width);},_buildModalCommands:function _buildModalCommands(){if(this.p.commands){var commands=this.p.commands;var $footer=this.$modal.getFooter();for(var key in commands){var $btn=$R.dom('<button>');$btn.html(commands[key].title);$btn.attr('data-command',key);// cancel
if(key==='cancel'){$btn.attr('data-action','close');$btn.addClass('redactor-button-unstyled');}// danger
if(typeof commands[key].type!=='undefined'&&commands[key].type==='danger'){$btn.addClass('redactor-button-danger');}$btn.on('click',this._handleCommand.bind(this));$footer.append($btn);}}},_buildModalTabs:function _buildModalTabs(){var $body=this.$modal.getBody();var $tabs=$body.find('.redactor-modal-tab');var $box=$body.find('.redactor-modal-tabs');if($tabs.length>1){$box=$box.length===0?$R.dom('<div>'):$box.html('');$box.addClass('redactor-modal-tabs');$tabs.each(function(node,i){var $node=$R.dom(node);var $item=$R.dom('<a>');$item.attr('href','#');$item.attr('rel',i);$item.text($node.attr('data-title'));$item.on('click',this._showTab.bind(this));if(i===0){$item.addClass('active');}$box.append($item);}.bind(this));$body.prepend($box);}if($tabs.length===1){$tabs.show();}},_buildModalForm:function _buildModalForm(){this.$modalForm=$R.create('modal.form',this.app,this.$modal.getForm());},_showTab:function _showTab(e){e.preventDefault();var $el=$R.dom(e.target);var index=$el.attr('rel');var $body=this.$modal.getBody();var $tabs=$body.find('.redactor-modal-tab');$tabs.hide();$tabs.eq(index).show();$body.find('.redactor-modal-tabs a').removeClass('active');$el.addClass('active');},_needToClose:function _needToClose(el){var $target=$R.dom(el);if($target.attr('data-action')==='close'||this.$modal.isCloseNode(el)||$target.closest('.redactor-modal').length===0){return true;}return false;},_handleCommand:function _handleCommand(e){var $btn=$R.dom(e.target).closest('button');var command=$btn.attr('data-command');if(command!=='cancel')e.preventDefault();this._broadcast(command);},_handleEnter:function _handleEnter(e){if(e.which===13){if(this.p.handle){e.preventDefault();this._broadcast(this.p.handle);}}},_handleEscape:function _handleEscape(e){if(e.which===27)this._close();}});$R.add('class','modal.element',{mixins:['dom'],init:function init(app,template){this.app=app;this.opts=app.opts;this.$win=app.$win;// init
this._init(template);},// get
getForm:function getForm(){return this.find('form');},getHeader:function getHeader(){return this.$modalHeader;},getBody:function getBody(){return this.$modalBody;},getFooter:function getFooter(){return this.$modalFooter;},// set
setTitle:function setTitle(title){if(title)this.$modalHeader.html(title);},setWidth:function setWidth(width){width=parseInt(width)>=this.$win.width()?'96%':width;this.css('max-width',width);},setHeight:function setHeight(height){if(height!==false)this.$modalBody.css('height',height);},// update
updatePosition:function updatePosition(){var width=this.width();this.css({'left':'50%','margin-left':'-'+width/2+'px'});var windowHeight=this.$win.height();var height=this.height();var marginTop=windowHeight/2-height/2;if(height<windowHeight&&marginTop!==0){this.css('margin-top',marginTop+'px');}},// is
isCloseNode:function isCloseNode(el){return el===this.$modalClose.get();},// private
_init:function _init(template){this._build();this._buildClose();this._buildHeader();this._buildBody();this._buildFooter();this._buildTemplate(template);},_build:function _build(){this.parse('<div>');this.addClass('redactor-modal');this.attr('dir',this.opts.direction);},_buildClose:function _buildClose(){this.$modalClose=$R.dom('<span>');this.$modalClose.addClass('redactor-close');this.append(this.$modalClose);},_buildHeader:function _buildHeader(){this.$modalHeader=$R.dom('<div>');this.$modalHeader.addClass('redactor-modal-header');this.append(this.$modalHeader);},_buildBody:function _buildBody(){this.$modalBody=$R.dom('<div>');this.$modalBody.addClass('redactor-modal-body');this.append(this.$modalBody);},_buildFooter:function _buildFooter(){this.$modalFooter=$R.dom('<div>');this.$modalFooter.addClass('redactor-modal-footer');this.append(this.$modalFooter);},_buildTemplate:function _buildTemplate(template){this.$modalBody.html(template);}});$R.add('class','modal.form',{mixins:['dom'],init:function init(app,element){this.app=app;// build
this.build(element);},// public
build:function build(element){this.parse(element);},getData:function getData(){var data={};this.find('[name]').each(function(node){var $node=$R.dom(node);data[$node.attr('name')]=$node.val();});return data;},setData:function setData(data){this.find('[name]').each(function(node){var $node=$R.dom(node);var name=$node.attr('name');if(data.hasOwnProperty(name)){if(node.type&&node.type==='checkbox')node.checked=data[name];else $node.val(data[name]);}});},getField:function getField(name){return this.find('[name='+name+']');},setError:function setError(name){var $el=this.getField(name);$el.addClass('error');$el.one(this._getFieldEventName($el.get()),this._clearError);return false;},// private
_clearError:function _clearError(){return $R.dom(this).removeClass('error');},_getFieldEventName:function _getFieldEventName(el){return el.tagName==='SELECT'||el.type==='checkbox'||el.type==='radio'?'change':'keyup';}});$R.add('module','block',{init:function init(app){this.app=app;this.block=app.block;},// public
format:function format(args){var nodes=this.block.format(args);// callback
this.app.broadcast('format','block',nodes);},clearformat:function clearformat(){this.block.clearFormat();},clearstyle:function clearstyle(){this.block.clearStyle();},clearclass:function clearclass(){this.block.clearClass();},clearattr:function clearattr(){this.block.clearAttr();},add:function add(args,tags){this.block.add(args,tags);},toggle:function toggle(args,tags){this.block.toggle(args,tags);},set:function set(args,tags){this.block.set(args,tags);},remove:function remove(args,tags){this.block.remove(args,tags);}});$R.add('module','inline',{init:function init(app){this.app=app;this.inline=app.inline;},format:function format(args){var nodes=this.inline.format(args);// callback
this.app.broadcast('format','inline',nodes);},clearformat:function clearformat(){this.inline.clearFormat();},clearstyle:function clearstyle(){this.inline.clearStyle();},clearclass:function clearclass(){this.inline.clearClass();},clearattr:function clearattr(){this.inline.clearAttr();},add:function add(args,tags){this.inline.add(args,tags);},toggle:function toggle(args,tags){this.inline.toggle(args,tags);},set:function set(args,tags){this.inline.set(args,tags);},remove:function remove(args,tags){this.inline.remove(args,tags);}});$R.add('module','autosave',{init:function init(app){this.app=app;this.opts=app.opts;this.utils=app.utils;this.source=app.source;},// messages
onsynced:function onsynced(){if(this.opts.autosave){this._send();}},// private
_send:function _send(){var name=this.opts.autosaveName?this.opts.autosaveName:this.source.getName();var data={};data[name]=this.source.getCode();data=this.utils.extendData(data,this.opts.autosaveData);$R.ajax.post({url:this.opts.autosave,data:data,success:function(response){this._complete(response,name,data);}.bind(this)});},_complete:function _complete(response,name,data){var callback=response&&response.error?'autosaveError':'autosave';this.app.broadcast(callback,name,data,response);}});$R.add('module','input',{init:function init(app){this.app=app;this.opts=app.opts;this.utils=app.utils;this.editor=app.editor;this.keycodes=app.keycodes;this.element=app.element;this.selection=app.selection;this.insertion=app.insertion;this.inspector=app.inspector;this.autoparser=app.autoparser;// local
this.lastShiftKey=false;},// messages
onpaste:function onpaste(e,dataTransfer){if(!this.opts.input)return;return $R.create('input.paste',this.app,e,dataTransfer);},onkeydown:function onkeydown(e){if(!this.opts.input)return;// key
var key=e.which;// shortcuts
var shortcut=$R.create('input.shortcut',this.app,e);if(shortcut.is())return;// select all
if((e.ctrlKey||e.metaKey)&&!e.altKey&&key===65){e.preventDefault();return this._selectAll();}// set empty if all selected
var keys=[this.keycodes.ENTER,this.keycodes.SPACE,this.keycodes.BACKSPACE,this.keycodes.DELETE];var arrowKeys=[this.keycodes.UP,this.keycodes.DOWN,this.keycodes.LEFT,this.keycodes.RIGHT];var isKeys=keys.indexOf(key)!==-1;var isArrowKeys=arrowKeys.indexOf(key)!==-1;var isXKey=(e.ctrlKey||e.metaKey)&&key===88;// x
var isAlphaKeys=!e.ctrlKey&&!e.metaKey&&(key>=48&&key<=57||key>=65&&key<=90);if(this.selection.isAll()&&isArrowKeys&&(isXKey||!e.ctrlKey&&!e.metaKey&&!e.altKey&&!e.shiftKey)){if(isXKey){this.editor.disableNonEditables();this.app.broadcast('empty');return;}if(this._isArrowKey(key))return true;if(isKeys)e.preventDefault();if(this.element.isType('inline')){var $editor=this.editor.getElement();$editor.html('');this.editor.startFocus();}else{this.insertion.set(this.opts.emptyHtml);}if(isKeys)return;else this.app.broadcast('empty');}// autoparse
if(this.opts.autoparse){this.autoparser.format(e,key);}// a-z, 0-9 - non editable
if(isAlphaKeys){// has non-editable
if(this.selection.hasNonEditable()){e.preventDefault();return;}}// enter, shift/ctrl + enter
if(key===this.keycodes.ENTER){return $R.create('input.enter',this.app,e,key);}// cmd + [
else if(e.metaKey&&key===219){e.preventDefault();this.app.api('module.list.outdent');return;}// tab or cmd + ]
else if(key===this.keycodes.TAB||e.metaKey&&key===221){return $R.create('input.tab',this.app,e,key);}// space
else if(key===this.keycodes.SPACE){return $R.create('input.space',this.app,e,key,this.lastShiftKey);}// backspace or delete
else if(this._isDeleteKey(key)){return $R.create('input.delete',this.app,e,key);}else if(this._isArrowKey(key)){return $R.create('input.arrow',this.app,e,key);}},onkeyup:function onkeyup(e){if(!this.opts.input)return;// key
var key=e.which;// shift key
this.lastShiftKey=e.shiftKey;// hide context toolbar
this.app.broadcast('contextbar.close');// shortcode
var shortcode=$R.create('input.shortcode',this.app,e,key);if(shortcode.is())return;// is empty
if(key===this.keycodes.BACKSPACE){var $editor=this.editor.getElement();var html=this.utils.trimSpaces($editor.html());html=html.replace(/<br\s?\/?>/g,'');html=html.replace(/<div><\/div>/,'');if(html===''){e.preventDefault();this.editor.setEmpty();this.editor.startFocus();return;}}if(this.editor.isEmpty()){this.app.broadcast('empty');}},// public
start:function start(){// extend shortcuts
if(this.opts.shortcutsAdd){this.opts.shortcuts=$R.extend({},true,this.opts.shortcuts,this.opts.shortcutsAdd);}},// private
_selectAll:function _selectAll(){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var el;if(data.isComponentType('table')){el=data.getTable();this.selection.setAll(el);return;}else if(data.isComponentType('code')){el=data.getComponentCodeElement();this.selection.setAll(el);return;}this.selection.setAll();},_isArrowKey:function _isArrowKey(key){return[this.keycodes.UP,this.keycodes.DOWN,this.keycodes.RIGHT,this.keycodes.LEFT].indexOf(key)!==-1;},_isDeleteKey:function _isDeleteKey(key){return key===this.keycodes.BACKSPACE||key===this.keycodes.DELETE;}});$R.add('class','input.arrow',{init:function init(app,e,key){this.app=app;this.opts=app.opts;this.utils=app.utils;this.caret=app.caret;this.offset=app.offset;this.marker=app.marker;this.editor=app.editor;this.keycodes=app.keycodes;this.component=app.component;this.inspector=app.inspector;this.selection=app.selection;// local
this.key=key;// init
this._init(e);},// private
_init:function _init(e){if(this._isRightLeftKey()&&this._isExitVariable(e))return;if(this._isRightDownKey()){if(this._isExitOnDownRight(e))return;if(this._selectComponent(e,'End','next'))return;}if(this._isLeftUpKey()){if(this._isExitOnUpLeft(e))return;if(this._selectComponent(e,'Start','prev'))return;}if(this.key===this.keycodes.LEFT)this.utils.trimInvisibleChars('left');else if(this.key===this.keycodes.RIGHT)this.utils.trimInvisibleChars('right');},_isRightDownKey:function _isRightDownKey(){return[this.keycodes.DOWN,this.keycodes.RIGHT].indexOf(this.key)!==-1;},_isLeftUpKey:function _isLeftUpKey(){return[this.keycodes.UP,this.keycodes.LEFT].indexOf(this.key)!==-1;},_isRightLeftKey:function _isRightLeftKey(){return[this.keycodes.RIGHT,this.keycodes.LEFT].indexOf(this.key)!==-1;},_isExitVariable:function _isExitVariable(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var component=data.getComponent();if(data.isComponentType('variable')&&data.isComponentActive()){e.preventDefault();var func=this.key===this.keycodes.LEFT?'setBefore':'setAfter';this.caret[func](component);return;}},_isExitOnUpLeft:function _isExitOnUpLeft(e){var current=this.selection.getCurrent();var block=this.selection.getBlock(current);var data=this.inspector.parse(current);var prev=block.previousElementSibling;var isStart=this.caret.isStart(block);// prev table
if(isStart&&prev&&prev.tagName==='TABLE'){e.preventDefault();this.caret.setEnd(prev);return true;}// figcaption
else if(data.isFigcaption()){block=data.getFigcaption();isStart=this.caret.isStart(block);var $component=$R.dom(block).closest('.redactor-component');if(isStart&&$component.length!==0){e.preventDefault();this.caret.setEnd($component);return true;}}// exit table
else if(data.isTable()&&isStart){e.preventDefault();this.caret.setEnd(block.previousElementSibling);return true;}// component
else if(!data.isComponentEditable()&&data.isComponent()&&!data.isComponentType('variable')){var component=data.getComponent();if(!component.previousElementSibling){e.preventDefault();this.component.clearActive();return this._exitPrevElement(e,data.getComponent());}else if(component.previousElementSibling){e.preventDefault();this.component.clearActive();this.caret.setEnd(component.previousElementSibling);return true;}}},_isExitOnDownRight:function _isExitOnDownRight(e){var $editor=this.editor.getElement();var current=this.selection.getCurrent();var data=this.inspector.parse(current);var isEndEditor=this.caret.isEnd();var block,isEnd;// table
if(data.isTable()){block=data.getTable();isEnd=this.caret.isEnd(block);if(isEnd||isEndEditor){return this._exitNextElement(e,data.getComponent());}}// figcaption
else if(data.isFigcaption()){block=data.getFigcaption();isEnd=this.caret.isEnd(block);if(isEnd||isEndEditor){return this._exitNextElement(e,data.getComponent());}}// figure/code
else if(data.isComponentType('code')){var component=data.getComponent();var pre=$R.dom(data.getComponentCodeElement()).closest('pre');isEnd=this.caret.isEnd(block);var isNext=pre&&pre.get().nextElementSibling;if(isEnd&&!isNext){return this._exitNextElement(e,component);}}// pre & blockquote & dl
else if(data.isPre()||data.isBlockquote()||data.isDl()){if(isEndEditor){if(data.isPre())return this._exitNextElement(e,data.getPre());else if(data.isBlockquote())return this._exitNextElement(e,data.getBlockquote());else if(data.isDl())return this._exitNextElement(e,data.getDl());}}// li
else if(data.isList()){var $list=$R.dom(current).parents('ul, ol',$editor).last();isEnd=this.caret.isEnd($list);if(isEnd||isEndEditor){return this._exitNextElement(e,$list.get());}}// component
else if(data.isComponent()&&!data.isComponentType('variable')&&data.getTag()!=='span'){this.component.clearActive();return this._exitNextElement(e,data.getComponent());}},_exitPrevElement:function _exitPrevElement(e,node){e.preventDefault();if(node.previousElementSibling)this.caret.setEnd(node.previousElementSibling);else this.utils.createMarkupBefore(node);return true;},_exitNextElement:function _exitNextElement(e,node){e.preventDefault();if(node.nextElementSibling)this.caret.setStart(node.nextElementSibling);else this.utils.createMarkup(node);return true;},_selectComponent:function _selectComponent(e,caret,type){var current=this.selection.getCurrent();var block=this.selection.getBlock(current);var sibling=this.utils.findSiblings(current,type);var siblingBlock=this.utils.findSiblings(block,type);if(sibling&&this.caret['is'+caret](current)){this._selectComponentItem(e,sibling,caret);}else if(siblingBlock&&this.caret['is'+caret](block)){this._selectComponentItem(e,siblingBlock,caret);}},_selectComponentItem:function _selectComponentItem(e,item,caret){if(this.component.isNonEditable(item)){e.preventDefault();this.caret['set'+caret](item);return true;}}});$R.add('class','input.delete',{init:function init(app,e,key){this.app=app;this.opts=app.opts;this.caret=app.caret;this.utils=app.utils;this.editor=app.editor;this.marker=app.marker;this.keycodes=app.keycodes;this.component=app.component;this.inspector=app.inspector;this.selection=app.selection;this.insertion=app.insertion;// local
this.key=key;// init
this._init(e);},// private
_init:function _init(e){if(this._removeActiveComponent(e))return;if(this._removeAllSelectedTable(e))return;// is empty
if(this.key===this.keycodes.BACKSPACE){var $editor=this.editor.getElement();var html=this.utils.trimSpaces($editor.html());if(html===this.opts.emptyHtml){e.preventDefault();return;}}// variable or non editable prev/next or selection
if(this._detectVariableOrNonEditable()||this.selection.hasNonEditable()){e.preventDefault();return;}// all selected
if(this.selection.isAll()){e.preventDefault();this.insertion.set(this.opts.emptyHtml);return;}// collapsed
if(this.selection.isCollapsed()){// next / prev
if(this.key===this.keycodes.BACKSPACE)this._traverseBackspace(e);else if(this.key===this.keycodes.DELETE)this._traverseDelete(e);}if(this.key===this.keycodes.BACKSPACE)this.utils.trimInvisibleChars('left');this._removeUnwantedStyles();this._removeEmptySpans();this._removeSpanTagsInHeadings();this._removeInlineTagsInPre();},_detectVariableOrNonEditable:function _detectVariableOrNonEditable(){var block=this.selection.getBlock();var isBlockStart=this.caret.isStart(block);var isBlockEnd=this.caret.isEnd(block);var el;// backspace
if(this.key===this.keycodes.BACKSPACE&&isBlockStart){el=block.previousSibling;if(this._isNonEditable(el))return true;}// delete
else if(this.key===this.keycodes.DELETE&&isBlockEnd){el=block.nextSibling;if(this._isNonEditable(el))return true;}var current=this.selection.getCurrent();var isCurrentStart=this.caret.isStart(current);var isCurrentEnd=this.caret.isEnd(current);var isCurrentStartSpace=this.selection.getTextBeforeCaret().trim()==='';var isCurrentEndSpace=this.selection.getTextAfterCaret().trim()==='';// backspace
if(this.key===this.keycodes.BACKSPACE&&isCurrentStart&&!isCurrentStartSpace){el=current.previousSibling;if(this._isVariable(el)){this.caret.setEnd(el);return true;}else if(this._isNonEditable(el))return true;}// delete
else if(this.key===this.keycodes.DELETE&&isCurrentEnd&&!isCurrentEndSpace){el=current.nextSibling;if(this._isVariable(el)){this.caret.setStart(el);return true;}else if(this._isNonEditable(el))return true;}},_isVariable:function _isVariable(node){return $R.dom(node).closest('[data-redactor-type="variable"]').length!==0;},_isNonEditable:function _isNonEditable(node){return $R.dom(node).closest('.non-editable').length!==0;},_getBlock:function _getBlock(){var $editor=this.editor.getElement();var block=this.selection.getBlock();var data=this.inspector.parse(block);block=data.isList()?$R.dom(block).parents('ul, ol',$editor).last().get():block;block=data.isDl()?data.getDl():block;block=data.isTable()?data.getTable():block;return block;},_traverseDelete:function _traverseDelete(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var block,isEnd,$next;// figcaption
if(data.isFigcaption()){block=data.getFigcaption();isEnd=this.caret.isEnd(block);if(isEnd){e.preventDefault();return;}}// figure/code
else if(data.isComponentType('code')){block=data.getComponent();isEnd=this.caret.isEnd(block);if(isEnd){e.preventDefault();return;}}// next
block=this._getBlock();var next=this.utils.findSiblings(block,'next');if(!next)return;isEnd=this.caret.isEnd(block);var dataNext=this.inspector.parse(next);var isNextBlock=next.tagName==='P'||next.tagName==='DIV';// table
if(isEnd&&dataNext.isComponentType('table')){e.preventDefault();this.caret.setStart(next);return;}// figure/code
else if(isEnd&&dataNext.isComponentEditable()){e.preventDefault();this.component.remove(next,false);return;}// component
else if(isEnd&&dataNext.isComponent()){e.preventDefault();// select component
this.caret.setStart(next);// remove current if empty
if(this.utils.isEmptyHtml(block.innerHTML)){$R.dom(block).remove();}return;}// combine list
else if(isEnd&&dataNext.isList()){var $currentList=$R.dom(block);$next=$R.dom(next);// current list
if(data.isList()){e.preventDefault();$currentList.append($next);$next.unwrap();return;}else{var $first=$next.children('li').first();var $lists=$first.find('ul, ol');if($lists.length!==0){e.preventDefault();$next.prepend($lists);$lists.unwrap();$currentList.append($first);$first.unwrap();return;}}}// block
else if(isEnd&&!data.isList()&&!data.isTable()&&isNextBlock&&!this.utils.isEmptyHtml(block.innerHTML)){e.preventDefault();var $current=$R.dom(block);$next=$R.dom(next);$current.append($next);$next.unwrap();return;}},_traverseBackspace:function _traverseBackspace(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var block,isStart,$prev,$currentList;// figcaption
if(data.isFigcaption()){block=data.getFigcaption();isStart=this.caret.isStart(block);if(isStart){e.preventDefault();return;}}// figure/code
else if(data.isComponentType('code')){block=data.getComponent();isStart=this.caret.isStart(block);if(isStart&&block.previousElementSibling){e.preventDefault();this.caret.setEnd(block.previousElementSibling);return true;}}// prev
block=this._getBlock();var prev=this.utils.findSiblings(block,'prev');if(!prev){setTimeout(this._replaceBlock.bind(this),1);return;}isStart=this.caret.isStart(block);var dataPrev=this.inspector.parse(prev);var isPrevBlock=prev.tagName==='P'||prev.tagName==='DIV';// figure/code
if(isStart&&dataPrev.isComponentType('code')){e.preventDefault();this.component.remove(prev,false);return;}// table
else if(isStart&&dataPrev.isComponentType('table')){e.preventDefault();this.caret.setEnd(prev);return;}// component
else if(isStart&&dataPrev.isComponent()){e.preventDefault();// select component
this.caret.setStart(prev);// remove current if empty
if(this.utils.isEmptyHtml(block.innerHTML)){$R.dom(block).remove();}return;}// lists
else if(isStart&&data.isList()){e.preventDefault();$currentList=$R.dom(block);$prev=$R.dom(prev);if(dataPrev.isList()){$currentList.children('li').first().prepend(this.marker.build('start'));$prev.append($currentList);$currentList.unwrap();this.selection.restoreMarkers();}else{var $first=$currentList.children('li').first();var first=$first.get();var $lists=$first.find('ul, ol');var $newnode=this.utils.replaceToTag(first,this.opts.markup);if(this.opts.breakline)$newnode.attr('data-redactor-tag','br');$currentList.before($newnode);this.caret.setStart($newnode);if($lists.length!==0){$currentList.prepend($lists);$lists.unwrap();}}return;}// block
else if(isStart&&isPrevBlock){e.preventDefault();if(this.utils.isEmpty(prev)){$prev=$R.dom(prev);$prev.remove();return;}var textNode=this.utils.createInvisibleChar();var $current=$R.dom(block);$prev=$R.dom(prev);this.caret.setEnd($prev);$current.prepend(textNode);$prev.append($current.contents());$current.remove();return;}},_replaceBlock:function _replaceBlock(){var block=this.selection.getBlock();var $block=$R.dom(block);if(this.opts.markup==='p'&&block&&this._isNeedToReplaceBlock(block)){var markup=document.createElement(this.opts.markup);$block.replaceWith(markup);this.caret.setStart(markup);}if(this.opts.breakline&&block&&block.tagName==='DIV'){$block.attr('data-redactor-tag','br');}},_isNeedToReplaceBlock:function _isNeedToReplaceBlock(block){return block.tagName==='DIV'&&this.utils.isEmptyHtml(block.innerHTML);},_removeActiveComponent:function _removeActiveComponent(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var component=data.getComponent();if(data.isComponent()&&this.component.isActive(component)){e.preventDefault();this.component.remove(component);return true;}},_removeAllSelectedTable:function _removeAllSelectedTable(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var table=data.getTable();if(table&&this.selection.isAll(table)){e.preventDefault();this.component.remove(table);return true;}},_removeUnwantedStyles:function _removeUnwantedStyles(){var $editor=this.editor.getElement();setTimeout(function(){var $tags=$editor.find('*[style]');$tags.not('img, figure, iframe, [data-redactor-style-cache], [data-redactor-span]').removeAttr('style');},0);},_removeEmptySpans:function _removeEmptySpans(){var $editor=this.editor.getElement();setTimeout(function(){$editor.find('span').each(function(node){if(node.attributes.length===0){$R.dom(node).replaceWith(node.childNodes);}});},0);},_removeSpanTagsInHeadings:function _removeSpanTagsInHeadings(){var $editor=this.editor.getElement();setTimeout(function(){$editor.find('h1, h2, h3, h4, h5, h6').each(function(node){var $node=$R.dom(node);if($node.closest('figure').length===0){$node.find('span').not('.redactor-component, .non-editable, .redactor-selection-marker, [data-redactor-style-cache], [data-redactor-span]').unwrap();}});},1);},_removeInlineTagsInPre:function _removeInlineTagsInPre(){var $editor=this.editor.getElement();var tags=this.opts.inlineTags;setTimeout(function(){$editor.find('pre').each(function(node){var $node=$R.dom(node);if($node.closest('figure').length===0){$node.find(tags.join(',')).not('code, .redactor-selection-marker').unwrap();}});},1);}});$R.add('class','input.enter',{init:function init(app,e){this.app=app;this.opts=app.opts;this.utils=app.utils;this.caret=app.caret;this.editor=app.editor;this.insertion=app.insertion;this.selection=app.selection;this.inspector=app.inspector;// init
this._init(e);},// private
_init:function _init(e){// turn off
if(!this.opts.enterKey)return this._disable(e);// callback
var stop=this.app.broadcast('enter',e);if(stop===false)return e.preventDefault();// has non-editable
if(this.selection.hasNonEditable()){e.preventDefault();return;}// shift enter
if(e.ctrlKey||e.shiftKey)return this._insertBreak(e);// enter & exit
if(this._isExit(e))return;// traverse
this._traverse(e);},_disable:function _disable(e){e.preventDefault();var range=this.selection.getRange();if(range&&!range.collapsed)range.deleteContents();},_insertBreak:function _insertBreak(e){e.preventDefault();var current=this.selection.getCurrent();var data=this.inspector.parse(current);if(data.isComponent()&&!data.isComponentEditable()||data.isCode())return;else if(data.isPre())this.insertion.insertNewline();else this.insertion.insertBreakLine();},_isExit:function _isExit(e){var $editor=this.editor.getElement();var block=this.selection.getBlock();var data=this.inspector.parse(block);var isEnd=this.caret.isEnd(block);var current=this.selection.getCurrent();var prev=current.previousSibling;// blockquote
if(data.isBlockquote()){var isParagraphExit=isEnd&&this._isExitableBlock(block,'P');var isBreaklineExit=isEnd&&this._isExitableDblBreak(prev);if(isParagraphExit||isBreaklineExit){return this._exitFromElement(e,isBreaklineExit?prev:block,data.getBlockquote());}}// pre
else if(!data.isComponentType('code')&&data.isPre()){if(isEnd){var html=block.innerHTML;html=this.utils.removeInvisibleChars(html);if(html.match(/(\n\n\n)$/)!==null){$R.dom(prev.previousSibling.previousSibling).remove();return this._exitFromElement(e,prev,block);}}}// dl
else if(data.isDl()){if(isEnd&&this._isExitableBlock(block,'DT')){return this._exitFromElement(e,block,data.getDl());}}// li
else if(data.isList()){var list=$R.dom(current).parents('ul, ol',$editor).last();isEnd=this.caret.isEnd(list);if(isEnd&&this._isExitableBlock(block,'LI')){return this._exitFromElement(e,block,list);}}else if(data.isComponent()&&data.isComponentActive()&&!data.isFigcaption()&&!data.isComponentEditable()){return this._exitFromElement(e,false,data.getComponent());}},_isExitableDblBreak:function _isExitableDblBreak(prev){var next=prev?prev.nextSibling:false;if(next){var text=this.utils.removeInvisibleChars(next.textContent);return next.nodeType===3&&text.trim()==='';}},_isExitableBlock:function _isExitableBlock(block,tag){return block&&block.tagName===tag&&this.utils.isEmptyHtml(block.innerHTML);},_exitFromElement:function _exitFromElement(e,prev,el){e.preventDefault();if(prev)$R.dom(prev).remove();this.utils.createMarkup(el);return true;},_exitNextElement:function _exitNextElement(e,node){e.preventDefault();if(node.nextSibling)this.caret.setStart(node.nextSibling);else this.utils.createMarkup(node);return true;},_traverse:function _traverse(e){var current=this.selection.getCurrent();var isText=this.selection.isText();var block=this.selection.getBlock();var data=this.inspector.parse(current);var blockTag=block?block.tagName.toLowerCase():false;var $variable=$R.dom(current).closest('[data-redactor-type=variable]');// variable parent
if($variable.length!==0){this.caret.setAfter($variable);}// pre
if(data.isPre()){e.preventDefault();return this.insertion.insertNewline();}// blockquote
else if(data.isBlockquote()){block=this.selection.getBlock(current);if(block&&block.tagName==='BLOCKQUOTE'){e.preventDefault();return this.insertion.insertBreakLine();}}// figcaption
else if(data.isFigcaption()){block=data.getFigcaption();var isEnd=this.caret.isEnd(block);var isEndEditor=this.caret.isEnd();if(isEnd||isEndEditor){return this._exitNextElement(e,data.getComponent());}else{e.preventDefault();return;}}// dl
else if(data.isDl()){e.preventDefault();return this._traverseDl(current);}// breakline
else if(this.opts.breakline&&blockTag==='div'){setTimeout(this._replaceBlock.bind(this),1);return;}// text
else if(isText){e.preventDefault();return this.insertion.insertBreakLine();}// list
else if(data.isList()){return;}// div / p
else{setTimeout(this._replaceBlock.bind(this),1);return;}},_traverseDl:function _traverseDl(current){var block=this.selection.getBlock(current);var data=this.inspector.parse(block);var tag=data.getTag();var $el=$R.dom(block);var next=$el.get().nextSibling||false;var $next=$R.dom(next);var nextDd=next&&$next.is('dd');var nextDt=next&&$next.is('dt');var isEnd=this.caret.isEnd(block);if(tag==='dt'&&!nextDd&&isEnd){var dd=document.createElement('dd');$el.after(dd);this.caret.setStart(dd);return;}else if(tag==='dd'&&!nextDt&&isEnd){var dt=document.createElement('dt');$el.after(dt);this.caret.setStart(dt);return;}return this.insertion.insertBreakLine();},_replaceBlock:function _replaceBlock(){var block=this.selection.getBlock();var $block=$R.dom(block);if(this.opts.markup==='p'&&block&&this._isNeedToReplaceBlock(block)){var markup=document.createElement(this.opts.markup);$block.replaceWith(markup);this.caret.setStart(markup);}else{if(block){if(this.utils.isEmptyHtml(block.innerHTML)){this._clearBlock($block,block);}else{var first=this.utils.getFirstNode(block);if(first&&first.tagName==='BR'){$R.dom(first).remove();this.caret.setStart(block);}}}}if(block&&this._isNeedToCleanBlockStyle(block)&&this.opts.cleanOnEnter){$block.removeAttr('class style');}if(this.opts.breakline&&block&&block.tagName==='DIV'){//$block.append(document.createElement('br'));
//$block.attr('data-redactor-tag', 'br');
}},_clearBlock:function _clearBlock($block,block){if(block.tagName==='DIV'){$block.find('br').remove();}if(this.opts.cleanInlineOnEnter||block.innerHTML==='<br>'){$block.html('');}this.caret.setStart(block);},_isNeedToReplaceBlock:function _isNeedToReplaceBlock(block){return block.tagName==='DIV'&&this.utils.isEmptyHtml(block.innerHTML);},_isNeedToCleanBlockStyle:function _isNeedToCleanBlockStyle(block){return block.tagName==='P'&&this.utils.isEmptyHtml(block.innerHTML);}});$R.add('class','input.paste',{init:function init(app,e,dataTransfer,html,point){this.app=app;this.opts=app.opts;this.editor=app.editor;this.cleaner=app.cleaner;this.container=app.container;this.inspector=app.inspector;this.insertion=app.insertion;this.selection=app.selection;this.autoparser=app.autoparser;// local
this.pasteHtml=html;this.pointInserted=point;this.dataTransfer=dataTransfer;// init
this._init(e);},// private
_init:function _init(e){var clipboard=this.dataTransfer||e.clipboardData;var current=this.selection.getCurrent();var dataCurrent=this.inspector.parse(current);this.dropPasted=this.dataTransfer;//this.isRawCode = (this.dropPasted) ? (dataCurrent.isPre() || dataCurrent.isCode()) : this._isPlainText(clipboard);
this.isRawCode=dataCurrent.isPre()||dataCurrent.isCode();this.editor.enablePasting();this.editor.saveScroll();if(!this.dropPasted){this.selection.saveMarkers();}if(this.isRawCode||!clipboard){var text;if(!this.isRawCode&&!clipboard&&window.clipboardData){text=window.clipboardData.getData("text");}else{text=clipboard.getData("text/plain");}e.preventDefault();this._insert(e,text);return;}else if(this.pasteHtml){e.preventDefault();this._insert(e,this.pasteHtml);}else{// html / text
var url=clipboard.getData('URL');var html=this._isPlainText(clipboard)?this.cleaner.encodeEntities(clipboard.getData("text/plain")):clipboard.getData("text/html");// safari anchor links
html=!url||url===''?html:url;// file
if(clipboard.files!==null&&clipboard.files.length>0&&html===''){var files=[];for(var i=0;i<clipboard.files.length;i++){var file=clipboard.files[i]||clipboard.items[i].getAsFile();if(file)files.push(file);}if(files.length>0){e.preventDefault();this._insertFiles(e,files);return;}}e.preventDefault();this._insert(e,html);}},_isPlainText:function _isPlainText(clipboard){var text=clipboard.getData("text/plain");var html=clipboard.getData("text/html");if(text&&html){var element=document.createElement("div");element.innerHTML=html;if(element.textContent===text){return!element.querySelector(":not(meta)");}}else{return text!==null;}},_restoreSelection:function _restoreSelection(){this.editor.restoreScroll();this.editor.disablePasting();if(!this.dropPasted){this.selection.restoreMarkers();}},_insert:function _insert(e,html){// pasteBefore callback
var returned=this.app.broadcast('pasteBefore',html);html=returned===undefined?html:returned;// clean
html=html.trim();html=this.isRawCode?html:this.cleaner.paste(html);html=html.trim();html=this.isRawCode?this.cleaner.encodePhpCode(html):html;// paste callback
returned=this.app.broadcast('pasting',html);html=returned===undefined?html:returned;this._restoreSelection();// stop input
if(!this.opts.input)return;this.app.broadcast('state',false);// insert
var nodes=[];if(this.isRawCode){html=html.replace('&lt;?php','<?php');var textNode=document.createTextNode(html);nodes=this.insertion.insertNode(textNode,'after');this.app.broadcast('pasted',nodes);}else{// autoparse
if(this.opts.autoparse&&this.opts.autoparsePaste){html=this.autoparser.parse(html);}nodes=this.dropPasted?this.insertion.insertToPoint(e,html,this.pointInserted):this.insertion.insertHtml(html);// pasted callback
this.app.broadcast('pasted',nodes);this.app.broadcast('autoparseobserve');}},_insertFiles:function _insertFiles(e,files){this._restoreSelection();// drop or clipboard
var isImage=this.opts.imageTypes.indexOf(files[0].type)!==-1;var isClipboard=typeof this.dropPasted==='undefined';if(isImage)this.app.broadcast('dropimage',e,files,isClipboard);else this.app.broadcast('dropfile',e,files,isClipboard);}});$R.add('class','input.shortcode',{init:function init(app,e,key){this.app=app;this.opts=app.opts;this.utils=app.utils;this.marker=app.marker;this.keycodes=app.keycodes;this.selection=app.selection;// local
this.worked=false;// init
if(key===this.keycodes.SPACE)this._init();},// public
is:function is(){return this.worked;},// private
_init:function _init(){var current=this.selection.getCurrent();if(current&&current.nodeType===3){var text=this.utils.removeInvisibleChars(current.textContent);var shortcodes=this.opts.shortcodes;for(var name in shortcodes){var re=new RegExp('^'+this.utils.escapeRegExp(name));var match=text.match(re);if(match!==null){if(typeof shortcodes[name].format!=='undefined'){return this._format(shortcodes[name].format,current,re);}}}}},_format:function _format(tag,current,re){var marker=this.marker.insert('start');current=marker.previousSibling;var text=current.textContent;text=this.utils.trimSpaces(text);text=text.replace(re,'');current.textContent=text;var api=tag==='ul'||tag==='ol'?'module.list.toggle':'module.block.format';this.app.api(api,tag);this.selection.restoreMarkers();this.worked=true;}});$R.add('class','input.shortcut',{init:function init(app,e){this.app=app;this.opts=app.opts;// local
this.worked=false;// based on https://github.com/jeresig/jquery.hotkeys
this.hotkeys={8:"backspace",9:"tab",10:"return",13:"return",16:"shift",17:"ctrl",18:"alt",19:"pause",20:"capslock",27:"esc",32:"space",33:"pageup",34:"pagedown",35:"end",36:"home",37:"left",38:"up",39:"right",40:"down",45:"insert",46:"del",59:";",61:"=",96:"0",97:"1",98:"2",99:"3",100:"4",101:"5",102:"6",103:"7",104:"8",105:"9",106:"*",107:"+",109:"-",110:".",111:"/",112:"f1",113:"f2",114:"f3",115:"f4",116:"f5",117:"f6",118:"f7",119:"f8",120:"f9",121:"f10",122:"f11",123:"f12",144:"numlock",145:"scroll",173:"-",186:";",187:"=",188:",",189:"-",190:".",191:"/",192:"`",219:"[",220:"\\",221:"]",222:"'"};this.hotkeysShiftNums={"`":"~","1":"!","2":"@","3":"#","4":"$","5":"%","6":"^","7":"&","8":"*","9":"(","0":")","-":"_","=":"+",";":": ","'":"\"",",":"<",".":">","/":"?","\\":"|"};// init
this._init(e);},// public
is:function is(){return this.worked;},// private
_init:function _init(e){// disable browser's hot keys for bold and italic if shortcuts off
if(this.opts.shortcuts===false){if((e.ctrlKey||e.metaKey)&&(e.which===66||e.which===73))e.preventDefault();return;}// build
for(var key in this.opts.shortcuts){this._build(e,key,this.opts.shortcuts[key]);}},_build:function _build(e,str,command){var keys=str.split(',');var len=keys.length;for(var i=0;i<len;i++){if(typeof keys[i]==='string'){this._handler(e,keys[i].trim(),command);}}},_handler:function _handler(e,keys,command){keys=keys.toLowerCase().split(" ");var special=this.hotkeys[e.keyCode];var character=String.fromCharCode(e.which).toLowerCase();var modif="",possible={};var cmdKeys=["meta","ctrl","alt","shift"];for(var i=0;i<cmdKeys.length;i++){var specialKey=cmdKeys[i];if(e[specialKey+'Key']&&special!==specialKey){modif+=specialKey+'+';}}if(special)possible[modif+special]=true;if(character){possible[modif+character]=true;possible[modif+this.hotkeysShiftNums[character]]=true;// "$" can be triggered as "Shift+4" or "Shift+$" or just "$"
if(modif==="shift+"){possible[this.hotkeysShiftNums[character]]=true;}}var len=keys.length;for(var i=0;i<len;i++){if(possible[keys[i]]){e.preventDefault();this.worked=true;if(command.message){this.app.broadcast(command.message,command.args);this.app.broadcast('buffer.trigger');}else if(command.api){this.app.api(command.api,command.args);this.app.broadcast('buffer.trigger');}return;}}}});$R.add('class','input.space',{init:function init(app,e,key,lastShiftKey){this.app=app;this.keycodes=app.keycodes;this.insertion=app.insertion;this.selection=app.selection;// local
this.key=key;this.lastShiftKey=lastShiftKey;// init
this._init(e);},// private
_init:function _init(e){// has non-editable
if(this.selection.hasNonEditable()){e.preventDefault();return;}// shift/ctrl + space
if(!this.lastShiftKey&&this.key===this.keycodes.SPACE&&(e.ctrlKey||e.shiftKey)&&!e.metaKey){e.preventDefault();this.insertion.insertChar('&nbsp;');return;}}});$R.add('class','input.tab',{init:function init(app,e){this.app=app;this.opts=app.opts;this.inspector=app.inspector;this.insertion=app.insertion;this.selection=app.selection;// init
this._init(e);},// private
_init:function _init(e){// turn off tab
if(!this.opts.tabKey)return;// callback
var stop=this.app.broadcast('tab',e);if(stop===false)return e.preventDefault();// traverse
this._traverse(e);},_traverse:function _traverse(e){var current=this.selection.getCurrent();var data=this.inspector.parse(current);// hard tab
if(!data.isComponent()&&e.shiftKey){return this._insertHardTab(e,4);}// list
if(data.isList()){e.preventDefault();return this.app.api('module.list.indent');}// pre
if(data.isPre()||data.isComponentType('code')&&!data.isFigcaption()){return this._tabCode(e);}// tab as spaces
if(this.opts.tabAsSpaces!==false){return this._insertHardTab(e,this.opts.tabAsSpaces);}},_insertHardTab:function _insertHardTab(e,num){e.preventDefault();var node=document.createTextNode(Array(num+1).join("\xA0"));return this.insertion.insertNode(node,'end');},_tabCode:function _tabCode(e){e.preventDefault();var node=this.opts.preSpaces?document.createTextNode(Array(this.opts.preSpaces+1).join("\xA0")):document.createTextNode('\t');return this.insertion.insertNode(node,'end');}});$R.add('module','upload',{init:function init(app){this.app=app;this.opts=app.opts;this.lang=app.lang;this.utils=app.utils;this.editor=app.editor;this.progress=app.progress;// local
this.defaults={event:false,element:false,name:false,files:false,url:false,data:false,paramName:false};},// public
build:function build(options){this.p=$R.extend(this.defaults,options);this.$el=$R.dom(this.p.element);if(this.$el.get().tagName==='INPUT')this._buildInput();else this._buildBox();},send:function send(options){this.p=$R.extend(this.defaults,options);this.$uploadbox=this.editor.getElement();this._send(this.p.event,this.p.files);},complete:function complete(response,e){this._complete(response,e);},// private
_buildInput:function _buildInput(){this.box=false;this.prefix='';this.$uploadbox=$R.dom('<div class="upload-redactor-box" />');this.$el.hide();this.$el.after(this.$uploadbox);if(this.opts.multipleUpload)this.$el.attr('multiple','multiple');else this.$el.removeAttr('multiple');if(this.p.name!=='file'){this.$el.attr('accept','image/*');}this._buildPlaceholder();this._buildEvents();},_buildBox:function _buildBox(){this.box=true;this.prefix='box-';this.$uploadbox=this.$el;this.$uploadbox.attr('ondragstart','return false;');// events
this.$uploadbox.on('drop.redactor.upload',this._onDropBox.bind(this));this.$uploadbox.on('dragover.redactor.upload',this._onDragOver.bind(this));this.$uploadbox.on('dragleave.redactor.upload',this._onDragLeave.bind(this));},_buildPlaceholder:function _buildPlaceholder(){this.$placeholder=$R.dom('<div class="upload-redactor-placeholder" />');this.$placeholder.html(this.lang.get('upload-label'));this.$uploadbox.append(this.$placeholder);},_buildEvents:function _buildEvents(){this.$el.on('change.redactor.upload',this._onChange.bind(this));this.$uploadbox.on('click.redactor.upload',this._onClick.bind(this));this.$uploadbox.on('drop.redactor.upload',this._onDrop.bind(this));this.$uploadbox.on('dragover.redactor.upload',this._onDragOver.bind(this));this.$uploadbox.on('dragleave.redactor.upload',this._onDragLeave.bind(this));},_onClick:function _onClick(e){e.preventDefault();this.$el.click();},_onChange:function _onChange(e){this._send(e,this.$el.get().files);},_onDrop:function _onDrop(e){e.preventDefault();this._clear();this._setStatusDrop();this._send(e);},_onDragOver:function _onDragOver(e){e.preventDefault();this._setStatusHover();return false;},_onDragLeave:function _onDragLeave(e){e.preventDefault();this._removeStatusHover();return false;},_onDropBox:function _onDropBox(e){e.preventDefault();this._clear();this._setStatusDrop();this._send(e);},_removeStatusHover:function _removeStatusHover(){this.$uploadbox.removeClass('upload-redactor-'+this.prefix+'hover');},_setStatusDrop:function _setStatusDrop(){this.$uploadbox.addClass('upload-redactor-'+this.prefix+'drop');},_setStatusHover:function _setStatusHover(){this.$uploadbox.addClass('upload-redactor-'+this.prefix+'hover');},_setStatusError:function _setStatusError(){this.$uploadbox.addClass('upload-redactor-'+this.prefix+'error');},_setStatusSuccess:function _setStatusSuccess(){this.$uploadbox.addClass('upload-redactor-'+this.prefix+'success');},_clear:function _clear(){var classes=['drop','hover','error','success'];for(var i=0;i<classes.length;i++){this.$uploadbox.removeClass('upload-redactor-'+this.prefix+classes[i]);}this.$uploadbox.removeAttr('ondragstart');},_send:function _send(e,files){e=e.originalEvent||e;files=files?files:e.dataTransfer.files;var data=new FormData();var name=this._getUploadParam();data=this._buildData(name,files,data);data=this.utils.extendData(data,this.p.data);var stop=this.app.broadcast('upload.start',e,data,files);if(stop!==false){this._sendData(data,files,e);}},_sendData:function _sendData(data,files,e){this.progress.show();if(typeof this.p.url==='function'){var res=this.p.url(data,files,e,this);if(!(res instanceof Promise)){this._complete(res,e);}}else{$R.ajax.post({url:this.p.url,data:data,before:function(xhr){return this.app.broadcast('upload.beforeSend',xhr);}.bind(this),success:function(response){this._complete(response,e);}.bind(this)});}},_getUploadParam:function _getUploadParam(){return this.p.paramName?this.p.paramName:'file';},_buildData:function _buildData(name,files,data){if(files.length===1){data.append(name+'[]',files[0]);}else if(files.length>1&&this.opts.multipleUpload!==false){for(var i=0;i<files.length;i++){data.append(name+'[]',files[i]);}}return data;},_complete:function _complete(response,e){this._clear();this.progress.hide();if(response&&response.error){this._setStatusError();this.app.broadcast('upload.'+this.p.name+'.error',response,e);this.app.broadcast('upload.error',response);}else{this._setStatusSuccess();this.app.broadcast('upload.'+this.p.name+'.complete',response,e);this.app.broadcast('upload.complete',response);setTimeout(this._clear.bind(this),500);}}});$R.add('class','code.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;// init
return el&&el.cmnt!==undefined?el:this._init(el);},// private
_init:function _init(el){var $pre;if(typeof el!=='undefined'){var $node=$R.dom(el);var $wrapper=$node.closest('figure');if($wrapper.length!==0){this.parse($wrapper);}else{this.parse('<figure>');this.append(el);}$pre=this.find('pre code, pre').last();}else{$pre=$R.dom('<pre>');this.parse('<figure>');this.append($pre);}this._initElement($pre);this._initWrapper();},_initElement:function _initElement($pre){$pre.attr({'tabindex':'-1','contenteditable':true});},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'code','tabindex':'-1','contenteditable':false});}});$R.add('module','form',{init:function init(app){this.app=app;this.lang=app.lang;this.component=app.component;this.inspector=app.inspector;},// messages
onform:{remove:function remove(node){this._remove(node);}},oncontextbar:function oncontextbar(e,contextbar){var data=this.inspector.parse(e.target);if(data.isComponentType('form')){var node=data.getComponent();var buttons={"remove":{title:this.lang.get('delete'),api:'module.form.remove',args:node}};contextbar.set(e,node,buttons,'top');}},// private
_remove:function _remove(node){this.component.remove(node);}});$R.add('class','form.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;this.utils=app.utils;// init
return el&&el.cmnt!==undefined?el:this._init(el);},// private
_init:function _init(el){if(typeof el!=='undefined'){var $node=$R.dom(el);var $wrapper=$node.closest('form');if($wrapper.length!==0){var $figure=this.utils.replaceToTag(el,'figure');this.parse($figure);}else{this.parse('<figure>');this.append(el);}}else{this.parse('<figure>');}this._initWrapper();},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'form','tabindex':'-1','contenteditable':false});}});$R.add('module','image',{modals:{'image':'<div class="redactor-modal-tab redactor-modal-tab-upload" data-title="## upload ##"><form action=""> \
                <input type="file" name="file"> \
            </form></div>','imageedit':'<div class="redactor-modal-group"> \
                <div id="redactor-modal-image-preview" class="redactor-modal-side"></div> \
                <form action="" class="redactor-modal-area"> \
                    <div class="form-item"> \
                        <label for="modal-image-title"> ## title ##</label> \
                        <input type="text" id="modal-image-title" name="title" /> \
                    </div> \
                    <div class="form-item form-item-caption"> \
                        <label for="modal-image-caption">## caption ##</label> \
                        <input type="text" id="modal-image-caption" name="caption" aria-label="## caption ##" /> \
                    </div> \
                    <div class="form-item form-item-align"> \
                        <label>## image-position ##</label> \
                        <select name="align" aria-label="## image-position ##"> \
                            <option value="none">## none ##</option> \
                            <option value="left">## left ##</option> \
                            <option value="center">## center ##</option> \
                            <option value="right">## right ##</option> \
                        </select> \
                    </div> \
                    <div class="form-item form-item-link"> \
                        <label for="modal-image-url">## link ##</label> \
                        <input type="text" id="modal-image-url" name="url" aria-label="## link ##" /> \
                    </div> \
                    <div class="form-item form-item-link"> \
                        <label class="checkbox"><input type="checkbox" name="target" aria-label="## link-in-new-tab ##"> ## link-in-new-tab ##</label> \
                    </div> \
                </form> \
            </div>'},init:function init(app){this.app=app;this.opts=app.opts;this.lang=app.lang;this.caret=app.caret;this.utils=app.utils;this.editor=app.editor;this.storage=app.storage;this.component=app.component;this.inspector=app.inspector;this.insertion=app.insertion;this.selection=app.selection;// local
this.justResized=false;},// messages
oninsert:function oninsert(){this._observeImages();},onstarted:function onstarted(){// storage observe
this.storage.observeImages();// resize
if(this.opts.imageResizable){this.resizer=$R.create('image.resize',this.app);}// observe
this._observeImages();},ondropimage:function ondropimage(e,files,clipboard){if(!this.opts.imageUpload)return;var options={url:this.opts.imageUpload,event:clipboard?false:e,files:files,name:'imagedrop',data:this.opts.imageData,paramName:this.opts.imageUploadParam};this.app.api('module.upload.send',options);},onstop:function onstop(){if(this.resizer)this.resizer.stop();},onbottomclick:function onbottomclick(){this.insertion.insertToEnd(this.editor.getLastNode(),'image');},onimageresizer:{stop:function stop(){if(this.resizer)this.resizer.hide();}},onsource:{open:function open(){if(this.resizer)this.resizer.hide();},closed:function closed(){this._observeImages();if(this.resizer)this.resizer.rebuild();}},onupload:{complete:function complete(){this._observeImages();},image:{complete:function complete(response){this._insert(response);},error:function error(response){this._uploadError(response);}},imageedit:{complete:function complete(response){this._change(response);},error:function error(response){this._uploadError(response);}},imagedrop:{complete:function complete(response,e){this._insert(response,e);},error:function error(response){this._uploadError(response);}},imagereplace:{complete:function complete(response){this._change(response,false);},error:function error(response){this._uploadError(response);}}},onmodal:{image:{open:function open($modal,$form){this._setUpload($modal,$form);}},imageedit:{open:function open($modal,$form){this._setFormData($modal,$form);},opened:function opened($modal,$form){this._setFormFocus($form);},remove:function remove(){this._remove(this.$image);},save:function save($modal,$form){this._save($modal,$form);}}},onimage:{observe:function observe(){this._observeImages();},resized:function resized(){this.justResized=true;}},oncontextbar:function oncontextbar(e,contextbar){if(this.justResized){this.justResized=false;return;}var current=this.selection.getCurrent();var data=this.inspector.parse(current);var $img=$R.dom(current).closest('img');if(!data.isFigcaption()&&data.isComponentType('image')||$img.length!==0){var node=$img.length!==0?$img.get():data.getComponent();var buttons={"edit":{title:this.lang.get('edit'),api:'module.image.open'},"remove":{title:this.lang.get('delete'),api:'module.image.remove',args:node}};contextbar.set(e,node,buttons);}},// public
open:function open(){this.$image=this._getCurrent();this.app.api('module.modal.build',this._getModalData());},insert:function insert(data){this._insert(data);},remove:function remove(node){this._remove(node);},// private
_getModalData:function _getModalData(){var modalData;if(this._isImage()&&this.opts.imageEditable){modalData={name:'imageedit',width:'800px',title:this.lang.get('edit'),handle:'save',commands:{save:{title:this.lang.get('save')},remove:{title:this.lang.get('delete'),type:'danger'},cancel:{title:this.lang.get('cancel')}}};}else{modalData={name:'image',title:this.lang.get('image')};}return modalData;},_isImage:function _isImage(){return this.$image;},_getCurrent:function _getCurrent(){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var $img=$R.dom(current).closest('img');if($img.length!==0){return this.component.create('image',$img);}else{return data.isComponentType('image')&&data.isComponentActive()?this.component.create('image',data.getComponent()):false;}},_insert:function _insert(response,e){this.app.api('module.modal.close');if(Array.isArray(response)){var obj={};for(var i=0;i<response.length;i++){obj=$R.extend(obj,response[i]);}response=obj;}else if(typeof response==='string'){response={"file":{url:response}};}if(_typeof(response)==='object'){var multiple=0;for(var key in response){if(_typeof(response[key])==='object')multiple++;}if(multiple>1){this._insertMultiple(response,e);}else{this._insertSingle(response,e);}}},_insertSingle:function _insertSingle(response,e){for(var key in response){if(_typeof(response[key])==='object'){var $img=this._createImageAndStore(response[key]);var inserted=e?this.insertion.insertToPoint(e,$img,false,false):this.insertion.insertHtml($img,false);this._removeSpaceBeforeFigure(inserted[0]);// set is active
this.component.setActive(inserted[0]);this.app.broadcast('image.uploaded',inserted[0],response);}}},_insertMultiple:function _insertMultiple(response,e){var z=0;var inserted=[];var last;for(var key in response){if(_typeof(response[key])==='object'){z++;var $img=this._createImageAndStore(response[key]);if(z===1){inserted=e?this.insertion.insertToPoint(e,$img,false,false):this.insertion.insertHtml($img,false);}else{var $inserted=$R.dom(inserted[0]);$inserted.after($img);inserted=[$img.get()];this.app.broadcast('image.inserted',$img);}last=inserted[0];this._removeSpaceBeforeFigure(inserted[0]);this.app.broadcast('image.uploaded',inserted[0],response);}}// set last is active
this.component.setActive(last);},_createImageAndStore:function _createImageAndStore(item){var $img=this.component.create('image');$img.addClass('redactor-uploaded-figure');$img.setData({src:item.url,id:item.id?item.id:this.utils.getRandomId()});// add to storage
this.storage.add('image',$img.getElement());return $img;},_removeSpaceBeforeFigure:function _removeSpaceBeforeFigure(img){if(!img)return;var prev=img.previousSibling;var next=img.nextSibling;var $prev=$R.dom(prev);var $next=$R.dom(next);if(this.opts.breakline){if(next&&$next.attr('data-redactor-tag')==='br'){$next.find('br').first().remove();}if(prev&&$prev.attr('data-redactor-tag')==='br'){$prev.find('br').last().remove();}}if(prev){this._removeInvisibleSpace(prev);this._removeInvisibleSpace(prev.previousSibling);}},_removeInvisibleSpace:function _removeInvisibleSpace(el){if(el&&el.nodeType===3&&this.utils.searchInvisibleChars(el.textContent)!==-1){el.parentNode.removeChild(el);}},_save:function _save($modal,$form){var data=$form.getData();var imageData={title:data.title};if(this.opts.imageLink)imageData.link={url:data.url,target:data.target};if(this.opts.imageCaption)imageData.caption=data.caption;if(this.opts.imagePosition)imageData.align=data.align;this.$image.setData(imageData);if(this.resizer)this.resizer.rebuild();this.app.broadcast('image.changed',this.$image);this.app.api('module.modal.close');},_change:function _change(response,modal){if(typeof response==='string'){response={"file":{url:response}};}if(_typeof(response)==='object'){var $img;for(var key in response){if(_typeof(response[key])==='object'){$img=$R.dom('<img>');$img.attr('src',response[key].url);this.$image.changeImage(response[key]);this.app.broadcast('image.changed',this.$image,response);this.app.broadcast('image.uploaded',this.$image,response);this.app.broadcast('hardsync');break;}}if(modal!==false){$img.on('load',function(){this.$previewBox.html($img);}.bind(this));}}},_uploadError:function _uploadError(response){this.app.broadcast('image.uploadError',response);},_remove:function _remove(node){this.app.api('module.modal.close');this.component.remove(node);},_observeImages:function _observeImages(){var $editor=this.editor.getElement();var self=this;$editor.find('img').each(function(node){var $node=$R.dom(node);$node.off('.drop-to-replace');$node.on('dragover.drop-to-replace dragenter.drop-to-replace',function(e){e.preventDefault();return;});$node.on('drop.drop-to-replace',function(e){if(!self.app.isDragComponentInside()){return self._setReplaceUpload(e,$node);}});});},_setFormData:function _setFormData($modal,$form){this._buildPreview($modal);this._buildPreviewUpload();var imageData=this.$image.getData();var data={title:imageData.title};// caption
if(this.opts.imageCaption)data.caption=imageData.caption;else $modal.find('.form-item-caption').hide();// position
if(this.opts.imagePosition)data.align=imageData.align;else $modal.find('.form-item-align').hide();// link
if(this.opts.imageLink){if(imageData.link){data.url=imageData.link.url;if(imageData.link.target)data.target=true;}}else $modal.find('.form-item-link').hide();$form.setData(data);},_setFormFocus:function _setFormFocus($form){$form.getField('title').focus();},_setReplaceUpload:function _setReplaceUpload(e,$node){e=e.originalEvent||e;e.stopPropagation();e.preventDefault();if(!this.opts.imageUpload)return;this.$image=this.component.create('image',$node);var options={url:this.opts.imageUpload,files:e.dataTransfer.files,name:'imagereplace',data:this.opts.imageData,paramName:this.opts.imageUploadParam};this.app.api('module.upload.send',options);return;},_setUpload:function _setUpload($modal,$form){if(!this.opts.imageUpload){var $body=$modal.getBody();var $tab=$body.find('.redactor-modal-tab-upload');$tab.remove();}var options={url:this.opts.imageUpload,element:$form.getField('file'),name:'image',data:this.opts.imageData,paramName:this.opts.imageUploadParam};this.app.api('module.upload.build',options);},_buildPreview:function _buildPreview($modal){this.$preview=$modal.find('#redactor-modal-image-preview');var imageData=this.$image.getData();var $previewImg=$R.dom('<img>');$previewImg.attr('src',imageData.src);this.$previewBox=$R.dom('<div>');this.$previewBox.append($previewImg);this.$preview.html('');this.$preview.append(this.$previewBox);},_buildPreviewUpload:function _buildPreviewUpload(){if(!this.opts.imageUpload)return;var $desc=$R.dom('<div class="desc">');$desc.html(this.lang.get('upload-change-label'));this.$preview.append($desc);var options={url:this.opts.imageUpload,element:this.$previewBox,name:'imageedit',data:this.opts.imageData,paramName:this.opts.imageUploadParam};this.app.api('module.upload.build',options);}});$R.add('class','image.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;this.opts=app.opts;this.selection=app.selection;// init
return el&&el.cmnt!==undefined?el:this._init(el);},setData:function setData(data){for(var name in data){this._set(name,data[name]);}},getData:function getData(){var names=['src','title','caption','align','link','id'];var data={};for(var i=0;i<names.length;i++){data[names[i]]=this._get(names[i]);}return data;},getElement:function getElement(){return this.$element;},changeImage:function changeImage(data){this.$element.attr('src',data.url);},// private
_init:function _init(el){var $el=$R.dom(el);var $figure=$el.closest('figure');if(el===undefined){this.$element=$R.dom('<img>');this.parse('<figure>');this.append(this.$element);}else if($figure.length===0){this.parse('<figure>');this.$element=$el;this.$element.wrap(this);}else{this.parse($figure);this.$element=this.find('img');}this._initWrapper();},_set:function _set(name,value){this['_set_'+name](value);},_get:function _get(name){return this['_get_'+name]();},_set_src:function _set_src(src){this.$element.attr('src',src);},_set_id:function _set_id(id){if(this.opts.imageObserve){this.$element.attr('data-image',id);}},_set_title:function _set_title(title){title=title.trim().replace(/(<([^>]+)>)/ig,"");if(title===''){this.$element.removeAttr('alt');}else{this.$element.attr('alt',title);}},_set_caption:function _set_caption(caption){var $figcaption=this.find('figcaption');if($figcaption.length===0){$figcaption=$R.dom('<figcaption>');$figcaption.attr('contenteditable','true');this.append($figcaption);}if(caption==='')$figcaption.remove();else $figcaption.html(caption);return $figcaption;},_set_align:function _set_align(align){var imageFloat='';var imageMargin='';var textAlign='';var $el=this;var $img=this.find('img');var $figcaption=this.find('figcaption');if(_typeof(this.opts.imagePosition)==='object'){var positions=this.opts.imagePosition;for(var key in positions){$el.removeClass(positions[key]);}var alignClass=typeof positions[align]!=='undefined'?positions[align]:false;if(alignClass){$el.addClass(alignClass);}}else{var width=$img.width();switch(align){case'left':imageFloat='left';imageMargin='0 '+this.opts.imageFloatMargin+' '+this.opts.imageFloatMargin+' 0';break;case'right':imageFloat='right';imageMargin='0 0 '+this.opts.imageFloatMargin+' '+this.opts.imageFloatMargin;break;case'center':textAlign='center';imageMargin='auto';break;}$el.css({'float':imageFloat,width:width+'px',maxWidth:width+'px','margin':imageMargin,'text-align':textAlign});$el.attr('rel',$el.attr('style'));if(align==='none'){$el.css('max-width','');$el.css('width','');}if(align==='center'){$el.css('max-width','');$el.css('width','');$figcaption.css('text-align','center');}else{$figcaption.css('text-align','');}}},_set_link:function _set_link(data){var $link=this._findLink();if(data.url===''){if($link)$link.unwrap();return;}if(!$link){$link=$R.dom('<a>');this.$element.wrap($link);}$link.attr('href',data.url);if(data.target)$link.attr('target',data.target===true?'_blank':data.target);else $link.removeAttr('target');return $link;},_get_src:function _get_src(){return this.$element.attr('src');},_get_id:function _get_id(){return this.$element.attr('data-image');},_get_title:function _get_title(){var alt=this.$element.attr('alt');return alt?alt:'';},_get_caption:function _get_caption(){var $figcaption=this.find('figcaption');if($figcaption.length===0){return'';}else{return $figcaption.html();}},_get_align:function _get_align(){var align='';if(_typeof(this.opts.imagePosition)==='object'){align='none';var positions=this.opts.imagePosition;for(var key in positions){if(this.hasClass(positions[key])){align=key;break;}}}else{align=this.css('text-align')==='center'?'center':this.css('float');}return align;},_get_link:function _get_link(){var $link=this._findLink();if($link){var target=$link.attr('target')?true:false;return{url:$link.attr('href'),target:target};}},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'image','tabindex':'-1','contenteditable':false});},_findLink:function _findLink(){var $link=this.find('a').filter(function(node){return $R.dom(node).closest('figcaption').length===0;});if($link.length!==0){return $link;}return false;}});$R.add('class','image.resize',{init:function init(app){this.app=app;this.$doc=app.$doc;this.$win=app.$win;this.$body=app.$body;this.editor=app.editor;this.toolbar=app.toolbar;this.inspector=app.inspector;// init
this.$target=this.toolbar.isTarget()?this.toolbar.getTargetElement():this.$body;this._init();},// public
rebuild:function rebuild(){this._setResizerPosition();},hide:function hide(){this.$target.find('#redactor-image-resizer').remove();},stop:function stop(){var $editor=this.editor.getElement();$editor.off('.redactor.image-resize');this.$doc.off('.redactor.image-resize');this.$win.off('resize.redactor.image-resize');this.hide();},// private
_init:function _init(){var $editor=this.editor.getElement();$editor.on('click.redactor.image-resize',this._build.bind(this));this.$win.on('resize.redactor.image-resize',this._setResizerPosition.bind(this));},_build:function _build(e){this.$target.find('#redactor-image-resizer').remove();if(this.app.isReadOnly())return;var data=this.inspector.parse(e.target);var $editor=this.editor.getElement();if(data.isComponentType('image')){this.$resizableBox=$editor;this.$resizableImage=$R.dom(data.getImageElement());this.$resizer=$R.dom('<span>');this.$resizer.attr('id','redactor-image-resizer');this.$target.append(this.$resizer);this._setResizerPosition();this.$resizer.on('mousedown touchstart',this._set.bind(this));}},_setResizerPosition:function _setResizerPosition(){if(this.$resizer){var isTarget=this.toolbar.isTarget();var targetOffset=this.$target.offset();var offsetFix=7;var topOffset=isTarget?offsetFix-targetOffset.top+this.$target.scrollTop():offsetFix;var leftOffset=isTarget?offsetFix-targetOffset.left:offsetFix;var pos=this.$resizableImage.offset();var width=this.$resizableImage.width();var height=this.$resizableImage.height();var resizerWidth=this.$resizer.width();var resizerHeight=this.$resizer.height();this.$resizer.css({top:Math.round(pos.top+height-resizerHeight+topOffset)+'px',left:Math.round(pos.left+width-resizerWidth+leftOffset)+'px'});}},_set:function _set(e){e.preventDefault();this.resizeHandle={x:e.pageX,y:e.pageY,el:this.$resizableImage,$figure:this.$resizableImage.closest('figure'),ratio:this.$resizableImage.width()/this.$resizableImage.height(),h:this.$resizableImage.height()};e=e.originalEvent||e;if(e.targetTouches){this.resizeHandle.x=e.targetTouches[0].pageX;this.resizeHandle.y=e.targetTouches[0].pageY;}this.app.broadcast('contextbar.close');this.app.broadcast('image.resize',this.$resizableImage);this._start();},_start:function _start(){this.$doc.on('mousemove.redactor.image-resize touchmove.redactor.image-resize',this._move.bind(this));this.$doc.on('mouseup.redactor.image-resize touchend.redactor.image-resize',this._stop.bind(this));},_stop:function _stop(){this.$doc.off('.redactor.image-resize');this.app.broadcast('image.resized',this.$resizableImage);},_move:function _move(e){e.preventDefault();e=e.originalEvent||e;var height=this.resizeHandle.h;if(e.targetTouches)height+=e.targetTouches[0].pageY-this.resizeHandle.y;else height+=e.pageY-this.resizeHandle.y;var width=height*this.resizeHandle.ratio;width=Math.round(width);height=Math.round(height);if(height<20||width<100)return;if(this._getResizableBoxWidth()<=width)return;if(this.resizeHandle.$figure.length!==0&&this.resizeHandle.$figure.css('max-width')!==''){this.resizeHandle.$figure.css('max-width',width+'px');}this.resizeHandle.el.attr({width:width,height:height});this.resizeHandle.el.width(width);this.resizeHandle.el.css('max-width',width+'px');this.resizeHandle.el.height(height);this._setResizerPosition();},_getResizableBoxWidth:function _getResizableBoxWidth(){var width=this.$resizableBox.width();return width-parseInt(this.$resizableBox.css('padding-left'))-parseInt(this.$resizableBox.css('padding-right'));}});$R.add('module','file',{modals:{'file':'<div class="redactor-modal-tab" data-title="## upload ##"><form action=""> \
                <div class="form-item form-item-title"> \
                    <label for="modal-file-title"> ## filename ## <span class="desc">(## optional ##)</span></label> \
                    <input type="text" id="modal-file-title" name="title" /> \
                </div> \
                <input type="file" name="file"> \
            </form></div>'},init:function init(app){this.app=app;this.opts=app.opts;this.lang=app.lang;this.caret=app.caret;this.utils=app.utils;this.storage=app.storage;this.component=app.component;this.inspector=app.inspector;this.insertion=app.insertion;this.selection=app.selection;},// messages
onstarted:function onstarted(){// storage observe
this.storage.observeFiles();},ondropfile:function ondropfile(e,files,clipboard){if(!this.opts.fileUpload)return;var options={url:this.opts.fileUpload,event:clipboard?false:e,files:files,name:'filedrop',data:this.opts.fileData};this.app.api('module.upload.send',options);},onmodal:{file:{open:function open($modal,$form){this._setFormData($modal,$form);this._setUpload($form);},opened:function opened($modal,$form){this._setFormFocus($form);this.$form=$form;}}},onupload:{file:{complete:function complete(response){this._insert(response);},error:function error(response){this._uploadError(response);}},filedrop:{complete:function complete(response,e){this._insert(response,e);},error:function error(response){this._uploadError(response);}}},// public
open:function open(){this._open();},insert:function insert(data){this._insert(data);},remove:function remove(node){this._remove(node);},// private
_open:function _open(){this.app.api('module.modal.build',this._getModalData());},_getModalData:function _getModalData(){var modalData={name:'file',title:this.lang.get('file')};return modalData;},_insert:function _insert(response,e){this.app.api('module.modal.close');if(_typeof(response)!=='object')return;if(Array.isArray(response)){var obj={};for(var i=0;i<response.length;i++){obj=$R.extend(obj,response[i]);}response=obj;}var multiple=Object.keys(response).length>1;if(multiple){this._insertMultiple(response,e);}else{this._insertSingle(response,e);}this.$form=false;},_insertSingle:function _insertSingle(response,e){var inserted=[];for(var key in response){var $file=this._createFileAndStore(response[key]);if(this.opts.fileAttachment){inserted=this._insertAsAttachment($file);}else{inserted=e?this.insertion.insertToPoint(e,$file):this.insertion.insertRaw($file);}this.app.broadcast('file.uploaded',inserted[0],response);}},_insertMultiple:function _insertMultiple(response,e){var z=0;var inserted=[];var $last;for(var key in response){z++;var $file=this._createFileAndStore(response[key]);if(this.opts.fileAttachment){inserted=this._insertAsAttachment($file,response);}else{if(z===1){inserted=e?this.insertion.insertToPoint(e,$file):this.insertion.insertRaw($file);}else{var $inserted=$R.dom(inserted[0]);$inserted.after($file).after(' ');inserted=[$file.get()];this.app.broadcast('file.inserted',$file);}}$last=$file;this.app.broadcast('file.uploaded',inserted[0],response);}// set caret after last
if(!this.opts.fileAttachment){this.caret.setAfter($last);}},_insertAsAttachment:function _insertAsAttachment($file,response){var $box=$R.dom(this.opts.fileAttachment);var $wrapper=$file.wrapAttachment();$box.append($wrapper);var inserted=[$wrapper.get()];this.app.broadcast('file.appended',inserted[0],response);return inserted;},_createFileAndStore:function _createFileAndStore(item){var modalFormData=this.$form?this.$form.getData():false;var name=item.name?item.name:item.url;var title=!this.opts.fileAttachment&&modalFormData&&modalFormData.title!==''?modalFormData.title:this._truncateUrl(name);var $file=this.component.create('file');$file.attr('href',item.url);$file.attr('data-file',item.id?item.id:this.utils.getRandomId());$file.attr('data-name',item.name);$file.html(title);// add to storage
this.storage.add('file',$file);return $file;},_remove:function _remove(node){this.selection.save();var $file=this.component.create('file',node);var stop=this.app.broadcast('file.delete',$file);if(stop!==false){$file.unwrap();this.selection.restore();// callback
this.app.broadcast('file.deleted',$file);}else{this.selection.restore();}},_truncateUrl:function _truncateUrl(url){return url.search(/^http/)!==-1&&url.length>20?url.substring(0,20)+'...':url;},_setUpload:function _setUpload($form){var options={url:this.opts.fileUpload,element:$form.getField('file'),name:'file',data:this.opts.fileData,paramName:this.opts.fileUploadParam};this.app.api('module.upload.build',options);},_setFormData:function _setFormData($modal,$form){if(this.opts.fileAttachment){$modal.find('.form-item-title').hide();}else{$form.setData({title:this.selection.getText()});}},_setFormFocus:function _setFormFocus($form){$form.getField('title').focus();},_uploadError:function _uploadError(response){this.app.broadcast('file.uploadError',response);}});$R.add('class','file.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;this.opts=app.opts;// init
return el&&el.cmnt!==undefined?el:this._init(el);},wrapAttachment:function wrapAttachment(){this.$wrapper=$R.dom('<span class="redactor-file-item">');this.$remover=$R.dom('<span class="redactor-file-remover">');this.$remover.html('&times;');this.$remover.on('click',this.removeAttachment.bind(this));this.$wrapper.append(this);this.$wrapper.append(this.$remover);return this.$wrapper;},removeAttachment:function removeAttachment(e){e.preventDefault();var stop=this.app.broadcast('file.delete',this,this.$wrapper);if(stop!==false){this.$wrapper.remove();this.app.broadcast('file.deleted',this);this.app.broadcast('file.removeAttachment',this);}},// private
_init:function _init(el){if(el===undefined){this.parse('<a>');}else{var $a=$R.dom(el).closest('a');this.parse($a);}}});$R.add('module','buffer',{init:function init(app){this.app=app;this.opts=app.opts;this.editor=app.editor;this.offset=app.offset;this.keycodes=app.keycodes;this.selection=app.selection;// local
this.state=false;this.passed=false;this.keyPressed=false;this.undoStorage=[];this.redoStorage=[];},// messages
onkeydown:function onkeydown(e){this._listen(e);},onsyncing:function onsyncing(){if(!this.keyPressed){this.trigger();}this.keyPressed=false;},onbuffer:{trigger:function trigger(){this.trigger();}},onstate:function onstate(e,html,offset){if(e&&(e.ctrlKey||e.metaKey)||e&&(this._isUndo(e)||this._isRedo(e))){return;}this.passed=false;this._saveState(html,offset);if(e===false){this._setUndo();}},onenable:function onenable(){this.clear();},// public
clear:function clear(){this.state=false;this.undoStorage=[];this.redoStorage=[];},undo:function undo(){this._getUndo();},redo:function redo(){this._getRedo();},trigger:function trigger(){if(this.state&&this.passed===false)this._setUndo();},// private
_saveState:function _saveState(html,offset){var $editor=this.editor.getElement();this.state={html:html||$editor.html(),offset:offset||this.offset.get()};},_listen:function _listen(e){var key=e.which;var ctrl=e.ctrlKey||e.metaKey;var cmd=ctrl||e.shiftKey||e.altKey;var keys=[this.keycodes.SPACE,this.keycodes.ENTER,this.keycodes.BACKSPACE,this.keycodes.DELETE,this.keycodes.TAB,this.keycodes.LEFT,this.keycodes.RIGHT,this.keycodes.UP,this.keycodes.DOWN];// undo
if(this._isUndo(e))// z key
{e.preventDefault();this.undo();return;}// redo
else if(this._isRedo(e)){e.preventDefault();this.redo();return;}// spec keys
else if(!ctrl&&keys.indexOf(key)!==-1){cmd=true;this.trigger();}// cut & copy
else if(ctrl&&(key===88||key===67)){cmd=true;this.trigger();}// empty buffer
if(!cmd&&!this._hasUndo()){this.trigger();}this.keyPressed=true;},_isUndo:function _isUndo(e){var key=e.which;var ctrl=e.ctrlKey||e.metaKey;return ctrl&&key===90&&!e.shiftKey&&!e.altKey;},_isRedo:function _isRedo(e){var key=e.which;var ctrl=e.ctrlKey||e.metaKey;return ctrl&&(key===90&&e.shiftKey||key===89&&!e.shiftKey)&&!e.altKey;},_setUndo:function _setUndo(){var last=this.undoStorage[this.undoStorage.length-1];if(typeof last==='undefined'||last[0]!==this.state.html){this.undoStorage.push([this.state.html,this.state.offset]);this._removeOverStorage();}},_setRedo:function _setRedo(){var $editor=this.editor.getElement();var offset=this.offset.get();var html=$editor.html();this.redoStorage.push([html,offset]);this.redoStorage=this.redoStorage.slice(0,this.opts.bufferLimit);},_getUndo:function _getUndo(){if(!this._hasUndo())return;this.passed=true;var $editor=this.editor.getElement();var buffer=this.undoStorage.pop();this._setRedo();$editor.html(buffer[0]);this.offset.set(buffer[1]);this._saveState(buffer[0],buffer[1]);this.selection.restore();this.app.broadcast('undo',buffer[0],buffer[1]);},_getRedo:function _getRedo(){if(!this._hasRedo())return;this.passed=true;var $editor=this.editor.getElement();var buffer=this.redoStorage.pop();this._setUndo();$editor.html(buffer[0]);this.offset.set(buffer[1]);this._saveState(buffer[0],buffer[1]);this.app.broadcast('redo',buffer[0],buffer[1]);},_removeOverStorage:function _removeOverStorage(){if(this.undoStorage.length>this.opts.bufferLimit){this.undoStorage=this.undoStorage.slice(0,this.undoStorage.length-this.opts.bufferLimit);}},_hasUndo:function _hasUndo(){return this.undoStorage.length!==0;},_hasRedo:function _hasRedo(){return this.redoStorage.length!==0;}});$R.add('module','list',{init:function init(app){this.app=app;this.uuid=app.uuid;this.opts=app.opts;this.utils=app.utils;this.block=app.block;this.toolbar=app.toolbar;this.inspector=app.inspector;this.selection=app.selection;},// messages
onbutton:{list:{observe:function observe(button){this._observeButton(button);}}},ondropdown:{list:{observe:function observe(dropdown){this._observeDropdown(dropdown);}}},// public
toggle:function toggle(type){var nodes=this._getBlocks();var block=this.selection.getBlock();var $list=$R.dom(block).parents('ul, ol','.redactor-in-'+this.uuid).last();if(nodes.length===0&&$list.length!==0){nodes=[$list.get()];}if(block&&(block.tagName==='TD'||block.tagName==='TH')){nodes=this.block.format('div');}this.selection.saveMarkers();nodes=nodes.length!==0&&this._isUnformat(type,nodes)?this._unformat(type,nodes):this._format(type,nodes);this.selection.restoreMarkers();return nodes;},indent:function indent(){var isCollapsed=this.selection.isCollapsed();var current=this.selection.getCurrent();var data=this.inspector.parse(current);var item=data.isList()?data.getListItem():false;var $item=$R.dom(item);var $prev=$item.prevElement();var prev=$prev.get();var isIndent=isCollapsed&&item&&prev&&prev.tagName==='LI';if(isIndent){this.selection.saveMarkers();$prev=$R.dom(prev);var $prevChild=$prev.children('ul, ol');var $list=$item.closest('ul, ol');if($prevChild.length!==0){$prevChild.append($item);}else{var listTag=$list.get().tagName.toLowerCase();var $newList=$R.dom('<'+listTag+'>');$newList.append($item);$prev.append($newList);}this.selection.restoreMarkers();}},outdent:function outdent(){var isCollapsed=this.selection.isCollapsed();var current=this.selection.getCurrent();var data=this.inspector.parse(current);var item=data.isList()?data.getListItem():false;var $item=$R.dom(item);if(isCollapsed&&item){var $listItem=$item.parent();var $liItem=$listItem.closest('li','.redactor-in-'+this.uuid);var $prev=$item.prevElement();var $next=$item.nextElement();var prev=$prev.get();var next=$next.get();var nextItems,nextList,$newList,$nextList;var isTop=prev===false;var isMiddle=prev!==false&&next!==false;var isBottom=!isTop&&next===false;this.selection.saveMarkers();// out
if($liItem.length!==0){if(isMiddle){nextItems=this._getAllNext($item.get());$newList=$R.dom('<'+$listItem.get().tagName.toLowerCase()+'>');for(var i=0;i<nextItems.length;i++){$newList.append(nextItems[i]);}$liItem.after($item);$item.append($newList);}else{$liItem.after($item);if($listItem.children().length===0){$listItem.remove();}else{if(isTop)$item.append($listItem);}}}// unformat
else{var $container=this._createUnformatContainer($item);var $childList=$container.find('ul, ol').first();if(isTop)$listItem.before($container);else if(isBottom)$listItem.after($container);else if(isMiddle){$newList=$R.dom('<'+$listItem.get().tagName.toLowerCase()+'>');nextItems=this._getAllNext($item.get());for(var i=0;i<nextItems.length;i++){$newList.append(nextItems[i]);}$listItem.after($container);$container.after($newList);}if($childList.length!==0){$nextList=$container.nextElement();nextList=$nextList.get();if(nextList&&nextList.tagName===$listItem.get().tagName){$R.dom(nextList).prepend($childList);$childList.unwrap();}else{$container.after($childList);}}$item.remove();}this.selection.restoreMarkers();}},// private
_getAllNext:function _getAllNext(next){var nodes=[];while(next){var $next=$R.dom(next).nextElement();next=$next.get();if(next)nodes.push(next);else return nodes;}return nodes;},_isUnformat:function _isUnformat(type,nodes){var countLists=0;for(var i=0;i<nodes.length;i++){if(nodes[i].nodeType!==3){var tag=nodes[i].tagName.toLowerCase();if(tag===type||tag==='figure'){countLists++;}}}return countLists===nodes.length;},_format:function _format(type,nodes){var tags=['p','div','blockquote','pre','h1','h2','h3','h4','h5','h6','ul','ol'];var blocks=this._uniteBlocks(nodes,tags);var lists=[];for(var key in blocks){var items=blocks[key];var $list=this._createList(type,blocks[key]);for(var i=0;i<items.length;i++){var $item;// lists
if(items[i].nodeType!==3&&(items[i].tagName==='UL'||items[i].tagName==='OL')){var $oldList=$R.dom(items[i]);$item=$oldList.contents();$list.append($item);// old is empty
if(this.utils.isEmpty($oldList))$oldList.remove();}// other blocks or texts
else{$item=this._createListItem(items[i]);var last=$item.get().lastChild;if(last&&last.tagName==='BR'){$R.dom(last).remove();}this.utils.normalizeTextNodes($item);$list.append($item);}}lists.push($list.get());}return lists;},_uniteBlocks:function _uniteBlocks(nodes,tags){var z=0;var blocks={0:[]};var lastcell=false;for(var i=0;i<nodes.length;i++){var $node=$R.dom(nodes[i]);var $cell=$node.closest('th, td');if($cell.length!==0){if($cell.get()!==lastcell){// create block
z++;blocks[z]=[];}if(this._isUniteBlock(nodes[i],tags)){blocks[z].push(nodes[i]);}}else{if(this._isUniteBlock(nodes[i],tags)){blocks[z].push(nodes[i]);}else{// create block
z++;blocks[z]=[];}}lastcell=$cell.get();}return blocks;},_isUniteBlock:function _isUniteBlock(node,tags){return node.nodeType===3||tags.indexOf(node.tagName.toLowerCase())!==-1;},_createList:function _createList(type,blocks){var last=blocks[blocks.length-1];var $last=$R.dom(last);var $list=$R.dom('<'+type+'>');$last.after($list);return $list;},_createListItem:function _createListItem(item){var $item=$R.dom('<li>');if(item.nodeType===3){$item.append(item);}else{var $el=$R.dom(item);$item.append($el.contents());$el.remove();}return $item;},_unformat:function _unformat(type,nodes){if(nodes.length===1){// one list
var $list=$R.dom(nodes[0]);var $items=$list.find('li');var selectedItems=this.selection.getNodes({tags:['li']});var block=this.selection.getBlock();var $li=$R.dom(block).closest('li');if(selectedItems.length===0&&$li.length!==0){selectedItems=[$li.get()];}// 1) entire
if(selectedItems.length===$items.length){return this._unformatEntire(nodes[0]);}var pos=this._getItemsPosition($items,selectedItems);// 2) top
if(pos==='Top'){return this._unformatAtSide('before',selectedItems,$list);}// 3) bottom
else if(pos==='Bottom'){selectedItems.reverse();return this._unformatAtSide('after',selectedItems,$list);}// 4) middle
else if(pos==='Middle'){var $last=$R.dom(selectedItems[selectedItems.length-1]);var ci=false;var $parent=false;var $secondList=$R.dom('<'+$list.get().tagName.toLowerCase()+'>');$items.each(function(node){if(ci){var $node=$R.dom(node);if($node.closest('.redactor-split-item').length===0&&($parent===false||$node.closest($parent).length===0)){$node.addClass('redactor-split-item');}$parent=$node;}if(node===$last.get()){ci=true;}});$items.filter('.redactor-split-item').each(function(node){var $node=$R.dom(node);$node.removeClass('redactor-split-item');$secondList.append(node);});$list.after($secondList);selectedItems.reverse();for(var i=0;i<selectedItems.length;i++){var $item=$R.dom(selectedItems[i]);var $container=this._createUnformatContainer($item);$list.after($container);$container.find('ul, ol').remove();$item.remove();}return;}}else{// unformat all
for(var i=0;i<nodes.length;i++){if(nodes[i].nodeType!==3&&nodes[i].tagName.toLowerCase()===type){this._unformatEntire(nodes[i]);}}}},_unformatEntire:function _unformatEntire(list){var $list=$R.dom(list);var $items=$list.find('li');$items.each(function(node){var $item=$R.dom(node);var $container=this._createUnformatContainer($item);$item.remove();$list.before($container);}.bind(this));$list.remove();},_unformatAtSide:function _unformatAtSide(type,selectedItems,$list){for(var i=0;i<selectedItems.length;i++){var $item=$R.dom(selectedItems[i]);var $container=this._createUnformatContainer($item);$list[type]($container);var $innerLists=$container.find('ul, ol').first();$item.append($innerLists);$innerLists.each(function(node){var $node=$R.dom(node);var $parent=$node.closest('li');if($parent.get()===selectedItems[i]){$node.unwrap();$parent.addClass('r-unwrapped');}});if(this.utils.isEmptyHtml($item.html()))$item.remove();}// clear empty
$list.find('.r-unwrapped').each(function(node){var $node=$R.dom(node);if($node.html().trim()==='')$node.remove();else $node.removeClass('r-unwrapped');});},_getItemsPosition:function _getItemsPosition($items,selectedItems){var pos='Middle';var sFirst=selectedItems[0];var sLast=selectedItems[selectedItems.length-1];var first=$items.first().get();var last=$items.last().get();if(first===sFirst&&last!==sLast){pos='Top';}else if(first!==sFirst&&last===sLast){pos='Bottom';}return pos;},_createUnformatContainer:function _createUnformatContainer($item){var $container=$R.dom('<'+this.opts.markup+'>');if(this.opts.breakline)$container.attr('data-redactor-tag','br');$container.append($item.contents());return $container;},_getBlocks:function _getBlocks(){return this.selection.getBlocks({first:true});},_observeButton:function _observeButton(){var current=this.selection.getCurrent();var data=this.inspector.parse(current);var isDisabled=data.isPre()||data.isCode()||data.isFigcaption();this._observeButtonsList(isDisabled,['lists','ul','ol','outdent','indent']);var itemOutdent=this.toolbar.getButton('outdent');var itemIndent=this.toolbar.getButton('indent');this._observeIndent(itemIndent,itemOutdent);},_observeDropdown:function _observeDropdown(dropdown){var itemOutdent=dropdown.getItem('outdent');var itemIndent=dropdown.getItem('indent');this._observeIndent(itemIndent,itemOutdent);},_observeIndent:function _observeIndent(itemIndent,itemOutdent){var isCollapsed=this.selection.isCollapsed();var current=this.selection.getCurrent();var data=this.inspector.parse(current);var item=data.isList()?data.getListItem():false;var $item=$R.dom(item);var $prev=$item.prevElement();var prev=$prev.get();var isIndent=isCollapsed&&item&&prev&&prev.tagName==='LI';if(itemOutdent){if(item&&isCollapsed)itemOutdent.enable();else itemOutdent.disable();}if(itemIndent){if(item&&isIndent)itemIndent.enable();else itemIndent.disable();}},_observeButtonsList:function _observeButtonsList(param,buttons){for(var i=0;i<buttons.length;i++){var button=this.toolbar.getButton(buttons[i]);if(button){if(param)button.disable();else button.enable();}}}});$R.add('class','video.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;// init
return el&&el.cmnt!==undefined?el:this._init(el);},// private
_init:function _init(el){if(typeof el!=='undefined'){var $node=$R.dom(el);var $wrapper=$node.closest('figure');if($wrapper.length!==0){this.parse($wrapper);}else{this.parse('<figure>');this.append(el);}}else{this.parse('<figure>');}this._initWrapper();},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'video','tabindex':'-1','contenteditable':false});}});$R.add('class','widget.component',{mixins:['dom','component'],init:function init(app,el){this.app=app;// init
return el&&el.cmnt!==undefined?el:this._init(el);},getData:function getData(){return{html:this._getHtml()};},// private
_init:function _init(el){if(typeof el!=='undefined'){var $node=$R.dom(el);var $figure=$node.closest('figure');if($figure.length!==0){this.parse($figure);}else{this.parse('<figure>');this.html(el);}}else{this.parse('<figure>');}this._initWrapper();},_getHtml:function _getHtml(){var $wrapper=$R.dom('<div>');$wrapper.html(this.html());$wrapper.find('.redactor-component-caret').remove();return $wrapper.html();},_initWrapper:function _initWrapper(){this.addClass('redactor-component');this.attr({'data-redactor-type':'widget','tabindex':'-1','contenteditable':false});}});var Redactor=$R;window.Redactor=window.$R=$R;// Data attribute load
window.addEventListener('load',function(){$R('[data-redactor]');});// Export for webpack
if(( false?undefined:_typeof(module))==='object'&&module.exports){module.exports=Redactor;module.exports.Redactor=Redactor;}})();
/* WEBPACK VAR INJECTION */}.call(this, __webpack_require__(/*! ./../../../node_modules/webpack/buildin/module.js */ "./node_modules/webpack/buildin/module.js")(module)))

/***/ }),

/***/ "./resources/sass/dashboard/app.scss":
/*!*******************************************!*\
  !*** ./resources/sass/dashboard/app.scss ***!
  \*******************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/dashboard/customArticleStyle.scss":
/*!**********************************************************!*\
  !*** ./resources/sass/dashboard/customArticleStyle.scss ***!
  \**********************************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/index/logIn.scss":
/*!*****************************************!*\
  !*** ./resources/sass/index/logIn.scss ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/sass/index/theme.scss":
/*!*****************************************!*\
  !*** ./resources/sass/index/theme.scss ***!
  \*****************************************/
/*! no static exports found */
/***/ (function(module, exports) {

// removed by extract-text-webpack-plugin

/***/ }),

/***/ "./resources/theme/js/app.js":
/*!***********************************!*\
  !*** ./resources/theme/js/app.js ***!
  \***********************************/
/*! no static exports found */
/***/ (function(module, exports) {

/**
 * Theme: Hyper - Responsive Bootstrap 4 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Layout Js
 */

/**
 * LeftSidebar
 * @param {*} $ 
 */
!function ($) {
  'use strict';

  var LeftSidebar = function LeftSidebar() {
    this.body = $('body'), this.window = $(window), this.menuContainer = $('#left-side-menu-container');
  };
  /**
   * Reset the theme
   */


  LeftSidebar.prototype._reset = function () {
    this.body.removeAttr('data-leftbar-theme');
  },
  /**
   * Activates the condensed side bar
   */
  LeftSidebar.prototype.activateCondensedSidebar = function () {
    this.body.attr('data-leftbar-compact-mode', 'condensed');
  },
  /**
   * Deactivates the condensed side bar
   */
  LeftSidebar.prototype.deactivateCondensedSidebar = function () {
    this.body.removeAttr('data-leftbar-compact-mode');
  },
  /**
   * Activates the scrollable sidenar
   */
  LeftSidebar.prototype.activateScrollableSidebar = function () {
    this.body.attr('data-leftbar-compact-mode', 'scrollable');
  },
  /**
   * Deactivates the scrollbar
   */
  LeftSidebar.prototype.deactivateScrollableSidebar = function () {
    this.body.removeAttr('data-leftbar-compact-mode');
  },
  /**
   * Activates the default theme
   */
  LeftSidebar.prototype.activateDefaultTheme = function () {
    this._reset();
  },
  /**
   * Activates the light theme
   */
  LeftSidebar.prototype.activateLightTheme = function () {
    this._reset();

    this.body.attr('data-leftbar-theme', 'light');
  },
  /**
   * Activates the dark theme
   */
  LeftSidebar.prototype.activateDarkTheme = function () {
    this._reset();

    this.body.attr('data-leftbar-theme', 'dark');
  },
  /**
   * Initilizes the menu
   */
  LeftSidebar.prototype.initMenu = function () {
    var self = this; // resets everything

    this._reset(); // sidebar - main menu


    $('.side-nav').metisMenu(); // click events
    // Left menu collapse

    $(document).on('click', '.button-menu-mobile', function (e) {
      e.preventDefault();
      self.body.toggleClass('sidebar-enable'); // if (self.window.width() >= 768) {
      //   self.body.toggleClass('enlarged');
      // } else {
      //   self.body.removeClass('enlarged');
      // }
    }); // activate the menu in left side bar based on url

    $('.side-nav a').each(function () {
      var pageUrl = window.location.href.split(/[?#]/)[0];

      if (this.href == pageUrl) {
        $(this).addClass('active');
        $(this).parent().addClass('mm-active'); // add active to li of the current link

        $(this).parent().parent().addClass('mm-show');
        $(this).parent().parent().prev().addClass('active'); // add active class to an anchor

        $(this).parent().parent().parent().addClass('mm-active');
        $(this).parent().parent().parent().parent().addClass('mm-show'); // add active to li of the current link

        $(this).parent().parent().parent().parent().parent().addClass('mm-active');
        $(this).parent().parent().parent().parent().parent().parent().addClass('mm-show');
        $(this).parent().parent().parent().parent().parent().parent().parent().addClass('mm-active'); // add active to li of the current link
      }
    });
  },
  /**
   * Initilizes the menu
   */
  LeftSidebar.prototype.init = function () {
    this.initMenu();
  }, $.LeftSidebar = new LeftSidebar(), $.LeftSidebar.Constructor = LeftSidebar;
}(window.jQuery),
/**
 * Topbar
 * @param {*} $ 
 */
function ($) {
  'use strict';

  var Topbar = function Topbar() {
    this.$body = $('body'), this.$window = $(window);
  };
  /**
   * Initilizes the menu
   */


  Topbar.prototype.initMenu = function () {
    if ($('.topnav-menu').length) {
      $('.topnav-menu li a').each(function () {
        var pageUrl = window.location.href.split(/[?#]/)[0];

        if (this.href == pageUrl) {
          $(this).addClass('active');
          $(this).parent().parent().addClass('active'); // add active to li of the current link

          $(this).parent().parent().parent().parent().addClass('active');
          $(this).parent().parent().parent().parent().parent().parent().addClass('active');
        }
      }); // Topbar - main menu

      $('.navbar-toggle').on('click', function () {
        $(this).toggleClass('open');
        $('#navigation').slideToggle(400);
      });
    }
  }, // init search
  Topbar.prototype.initSearch = function () {
    // Serach Toggle
    var navDropdowns = $('.navbar-custom .dropdown:not(.app-search)'); // hide on other click

    $(document).on('click', function (e) {
      if ($(e.target).closest('#search-dropdown').length === 0) {
        $('#search-dropdown').removeClass('d-block');
      }

      return true;
    }); // Serach Toggle

    $('#top-search').on('click', function (e) {
      e.preventDefault();
      navDropdowns.children('.dropdown-menu.show').removeClass('show');
      $('#search-dropdown').addClass('d-block');
      return false;
    }); // hide search on opening other dropdown

    navDropdowns.on('show.bs.dropdown', function () {
      $('#search-dropdown').removeClass('d-block');
    });
  },
  /**
   * Initilizes the menu
   */
  Topbar.prototype.init = function () {
    this.initMenu();
    this.initSearch();
  }, $.Topbar = new Topbar(), $.Topbar.Constructor = Topbar;
}(window.jQuery),
/**
 * RightBar
 * @param {*} $ 
 */
function ($) {
  'use strict';

  var RightBar = function RightBar() {
    this.body = $('body'), this.window = $(window);
  };
  /** 
   * Select the option based on saved config
  */


  RightBar.prototype._selectOptionsFromConfig = function () {
    var config = $.App.getLayoutConfig();

    if (config) {
      // sideBarTheme
      switch (config.sideBarTheme) {
        case 'default':
          $('#default-check').prop('checked', true);
          break;

        case 'light':
          $('#light-check').prop('checked', true);
          break;

        case 'dark':
          $('#dark-check').prop('checked', true);
          break;
      }

      if (config.isBoxed) {
        $('#boxed-check').prop('checked', true);
      } else {
        $('#fluid-check').prop('checked', true);
      }

      if (config.isCondensed) $('#condensed-check').prop('checked', true);
      if (config.isScrollable) $('#scrollable-check').prop('checked', true);
      if (!config.isScrollable && !config.isCondensed) $('#fixed-check').prop('checked', true); // overall color scheme

      if (!config.isDarkModeEnabled) {
        $('#light-mode-check').prop('checked', true);
        if (config.layout === 'vertical') $('input[type=radio][name=theme]').prop('disabled', false);
      }

      if (config.isDarkModeEnabled) {
        $('#dark-mode-check').prop('checked', true);
        if (config.layout === 'vertical') $('input[type=radio][name=theme]').prop('disabled', false);
      }
    }
  },
  /**
   * Toggles the right sidebar
   */
  RightBar.prototype.toggleRightSideBar = function () {
    var self = this;
    self.body.toggleClass('right-bar-enabled');

    self._selectOptionsFromConfig();
  },
  /**
   * Initilizes the right side bar
   */
  RightBar.prototype.init = function () {
    var self = this; // right side-bar toggle

    $(document).on('click', '.right-bar-toggle', function () {
      self.toggleRightSideBar();
    });
    $(document).on('click', 'body', function (e) {
      if ($(e.target).closest('.right-bar-toggle, .right-bar').length > 0) {
        return;
      }

      if ($(e.target).closest('.left-side-menu, .side-nav').length > 0 || $(e.target).hasClass('button-menu-mobile') || $(e.target).closest('.button-menu-mobile').length > 0) {
        return;
      }

      $('body').removeClass('right-bar-enabled');
      $('body').removeClass('sidebar-enable');
      return;
    }); // width mode

    $('input[type=radio][name=width]').change(function () {
      switch ($(this).val()) {
        case 'fluid':
          $.App.activateFluid();
          break;

        case 'boxed':
          $.App.activateBoxed();
          break;
      }
    }); // theme

    $('input[type=radio][name=theme]').change(function () {
      switch ($(this).val()) {
        case 'default':
          $.App.activateDefaultSidebarTheme();
          break;

        case 'light':
          $.App.activateLightSidebarTheme();
          break;

        case 'dark':
          $.App.activateDarkSidebarTheme();
          break;
      }
    }); // compact

    $('input[type=radio][name=compact]').change(function () {
      switch ($(this).val()) {
        case 'fixed':
          $.App.deactivateCondensedSidebar();
          $.App.deactivateScrollableSidebar();
          break;

        case 'scrollable':
          $.App.activateScrollableSidebar();
          break;

        case 'condensed':
          $.App.activateCondensedSidebar();
          break;
      }
    }); // overall color scheme

    $('input[type=radio][name=color-scheme-mode]').change(function () {
      switch ($(this).val()) {
        case 'light':
          $.App.deactivateDarkMode();
          $.App.activateDefaultSidebarTheme();
          $('#default-check').prop('checked', true);
          $('input[type=radio][name=theme]').prop('disabled', false);
          break;

        case 'dark':
          $.App.activateDarkMode();
          $('#dark-check').prop('checked', true); // $('input[type=radio][name=theme]').prop('disabled', true);

          break;
      }
    }); // reset

    $('#resetBtn').on('click', function (e) {
      e.preventDefault(); // reset to default

      $.App.resetLayout(function () {
        self._selectOptionsFromConfig();
      });
    });
  }, $.RightBar = new RightBar(), $.RightBar.Constructor = RightBar;
}(window.jQuery),
/**
 * Layout and theme manager
 * @param {*} $ 
 */
function ($) {
  'use strict'; // Layout and theme manager

  var SIDEBAR_THEME_DEFAULT = 'default';
  var SIDEBAR_THEME_LIGHT = 'light';
  var SIDEBAR_THEME_DARK = 'dark';
  var DEFAULT_CONFIG = {
    sideBarTheme: SIDEBAR_THEME_DEFAULT,
    isBoxed: false,
    isCondensed: false,
    isScrollable: false,
    isDarkModeEnabled: false
  };

  var LayoutThemeApp = function LayoutThemeApp() {
    this.body = $('body'), this.window = $(window), this._config = {};
    this.defaultSelectedStyle = null;
  };
  /**
  * Preserves the config
  */


  LayoutThemeApp.prototype._saveConfig = function (newConfig) {
    $.extend(this._config, newConfig); // sessionStorage.setItem('_HYPER_CONFIG_', JSON.stringify(this._config));
  },
  /**
   * Get the stored config
   */
  LayoutThemeApp.prototype._getStoredConfig = function () {
    var bodyConfig = this.body.data('layoutConfig');
    var config = DEFAULT_CONFIG;

    if (bodyConfig) {
      config['sideBarTheme'] = bodyConfig['leftSideBarTheme'];
      config['isBoxed'] = bodyConfig['layoutBoxed'];
      config['isCondensed'] = bodyConfig['leftSidebarCondensed'];
      config['isScrollable'] = bodyConfig['leftSidebarScrollable'];
      config['isDarkModeEnabled'] = bodyConfig['darkMode'];
    }

    return config;
  },
  /**
  * Apply the given config and sets the layout and theme
  */
  LayoutThemeApp.prototype._applyConfig = function () {
    var self = this; // getting the saved config if available

    this._config = this._getStoredConfig(); // activate menus

    $.LeftSidebar.init(); // sets the theme

    switch (self._config.sideBarTheme) {
      case SIDEBAR_THEME_DARK:
        {
          self.activateDarkSidebarTheme();
          break;
        }

      case SIDEBAR_THEME_LIGHT:
        {
          self.activateLightSidebarTheme();
          break;
        }
    } // enable or disable the dark mode


    if (self._config.isDarkModeEnabled) self.activateDarkMode();else self.deactivateDarkMode(); // sets the boxed

    if (self._config.isBoxed) self.activateBoxed(); // sets condensed view

    if (self._config.isCondensed) self.activateCondensedSidebar(); // sets scrollable navbar

    if (self._config.isScrollable) self.activateScrollableSidebar();
  },
  /**
   * Initilizes the layout
   */
  LayoutThemeApp.prototype._adjustLayout = function () {
    // in case of small size, add class enlarge to have minimal menu
    if (this.window.width() >= 750 && this.window.width() <= 1028) {
      this.activateCondensedSidebar(true);
    } else {
      var config = this._getStoredConfig();

      if (!config.isCondensed && !config.isScrollable) this.deactivateCondensedSidebar();
    }
  },
  /**
   * Activate fluid mode
   */
  LayoutThemeApp.prototype.activateFluid = function () {
    this._saveConfig({
      isBoxed: false
    });

    this.body.attr('data-layout-mode', 'fluid');
  },
  /**
   * Activate boxed mode
   */
  LayoutThemeApp.prototype.activateBoxed = function () {
    this._saveConfig({
      isBoxed: true
    });

    this.body.attr('data-layout-mode', 'boxed');
  },
  /**
   * Activates the condensed side bar
   */
  LayoutThemeApp.prototype.activateCondensedSidebar = function (ignoreToStore) {
    if (!ignoreToStore) {
      this._saveConfig({
        isCondensed: true,
        isScrollable: false
      });
    }

    $.LeftSidebar.activateCondensedSidebar();
  },
  /**
   * Deactivates the condensed side bar
   */
  LayoutThemeApp.prototype.deactivateCondensedSidebar = function () {
    this._saveConfig({
      isCondensed: false
    });

    $.LeftSidebar.deactivateCondensedSidebar();
  };
  /**
   * Activates the scrollable sidenar
   */

  LayoutThemeApp.prototype.activateScrollableSidebar = function () {
    this._saveConfig({
      isScrollable: true,
      isCondensed: false
    });

    $.LeftSidebar.activateScrollableSidebar();
  },
  /**
   * Deactivates the scrollable sidenar
   */
  LayoutThemeApp.prototype.deactivateScrollableSidebar = function () {
    this._saveConfig({
      isScrollable: false
    });

    $.LeftSidebar.deactivateScrollableSidebar();
  },
  /**
   * Activates the default theme
   */
  LayoutThemeApp.prototype.activateDefaultSidebarTheme = function () {
    $.LeftSidebar.activateDefaultTheme();

    this._saveConfig({
      sideBarTheme: SIDEBAR_THEME_DEFAULT
    });
  },
  /**
   * Activates the light theme
   */
  LayoutThemeApp.prototype.activateLightSidebarTheme = function () {
    // this._resetLayout();
    $.LeftSidebar.activateLightTheme();

    this._saveConfig({
      sideBarTheme: SIDEBAR_THEME_LIGHT
    });
  },
  /**
   * Activates the dark theme
   */
  LayoutThemeApp.prototype.activateDarkSidebarTheme = function () {
    // this._resetLayout();
    $.LeftSidebar.activateDarkTheme();

    this._saveConfig({
      sideBarTheme: SIDEBAR_THEME_DARK
    });
  },
  /**
   * toggle the dark mode
   */
  LayoutThemeApp.prototype.activateDarkMode = function () {
    $("#light-style").attr("disabled", true);
    $("#dark-style").attr("disabled", false);
    $.LeftSidebar.activateDarkTheme();

    this._saveConfig({
      isDarkModeEnabled: true,
      sideBarTheme: SIDEBAR_THEME_DARK
    });
  };
  /**
   * Deactivate the dark mode
   */

  LayoutThemeApp.prototype.deactivateDarkMode = function () {
    $("#light-style").attr("disabled", false);
    $("#dark-style").attr("disabled", true);

    this._saveConfig({
      isDarkModeEnabled: false
    });
  };
  /**
   * Clear out the saved config
   */


  LayoutThemeApp.prototype.clearSavedConfig = function () {
    this._config = DEFAULT_CONFIG;
  },
  /**
   * Gets the config
   */
  LayoutThemeApp.prototype.getConfig = function () {
    return this._config;
  },
  /**
   * Reset to default
   */
  LayoutThemeApp.prototype.reset = function (callback) {
    this.clearSavedConfig();
    var self = this;

    if ($("#main-style-container").length) {
      self.defaultSelectedStyle = $("#main-style-container").attr('href');
    }

    self.deactivateCondensedSidebar();
    self.deactivateDarkMode();
    self.activateDefaultSidebarTheme();
    self.activateFluid(); // calling the call back to let the caller know that it's done

    callback();
  },
  /**
   * 
   */
  LayoutThemeApp.prototype.init = function () {
    var self = this;

    if ($("#main-style-container").length) {
      self.defaultSelectedStyle = $("#main-style-container").attr('href');
    } // initilize the menu


    this._applyConfig(); // adjust layout based on width


    this._adjustLayout(); // on window resize, make menu flipped automatically


    this.window.on('resize', function (e) {
      e.preventDefault();

      self._adjustLayout();
    }); // topbar

    $.Topbar.init();
  }, $.LayoutThemeApp = new LayoutThemeApp(), $.LayoutThemeApp.Constructor = LayoutThemeApp;
}(window.jQuery);
/**
 * Theme: Hyper - Responsive Bootstrap 4 Admin Dashboard
 * Author: Coderthemes
 * Module/App: Main Js
 */

!function ($) {
  "use strict";
  /**
  Portlet Widget
  */

  var Portlet = function Portlet() {
    this.$body = $("body"), this.$portletIdentifier = ".card", this.$portletCloser = '.card a[data-toggle="remove"]', this.$portletRefresher = '.card a[data-toggle="reload"]';
  }; //on init


  Portlet.prototype.init = function () {
    // Panel closest
    var $this = this;
    $(document).on("click", this.$portletCloser, function (ev) {
      ev.preventDefault();
      var $portlet = $(this).closest($this.$portletIdentifier);
      var $portlet_parent = $portlet.parent();
      $portlet.remove();

      if ($portlet_parent.children().length == 0) {
        $portlet_parent.remove();
      }
    }); // Panel Reload

    $(document).on("click", this.$portletRefresher, function (ev) {
      ev.preventDefault();
      var $portlet = $(this).closest($this.$portletIdentifier); // This is just a simulation, nothing is going to be reloaded

      $portlet.append('<div class="card-disabled"><div class="card-portlets-loader"></div></div>');
      var $pd = $portlet.find('.card-disabled');
      setTimeout(function () {
        $pd.fadeOut('fast', function () {
          $pd.remove();
        });
      }, 500 + 300 * (Math.random() * 5));
    });
  }, //
  $.Portlet = new Portlet(), $.Portlet.Constructor = Portlet;
}(window.jQuery), function ($) {
  'use strict';

  var AdvanceFormApp = function AdvanceFormApp() {
    this.$body = $('body'), this.$window = $(window);
  };
  /** 
   * Initlizes the select2
  */


  AdvanceFormApp.prototype.initSelect2 = function () {
    // Select2
    $('[data-toggle="select2"]').select2();
  },
  /** 
   * Initlized mask
  */
  AdvanceFormApp.prototype.initMask = function () {
    $('[data-toggle="input-mask"]').each(function (idx, obj) {
      var maskFormat = $(obj).data("maskFormat");
      var reverse = $(obj).data("reverse");
      if (reverse != null) $(obj).mask(maskFormat, {
        'reverse': reverse
      });else $(obj).mask(maskFormat);
    });
  }, // Datetime and date range picker
  AdvanceFormApp.prototype.initDateRange = function () {
    var defaultOptions = {
      "cancelClass": "btn-light",
      "applyButtonClasses": "btn-success"
    }; // date pickers

    $('[data-toggle="date-picker"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultOptions, $(obj).data());
      $(obj).daterangepicker(objOptions);
    }); //date pickers ranges only

    var start = moment().subtract(29, 'days');
    var end = moment();
    var defaultRangeOptions = {
      startDate: start,
      endDate: end,
      ranges: {
        'Today': [moment(), moment()],
        'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Last 7 Days': [moment().subtract(6, 'days'), moment()],
        'Last 30 Days': [moment().subtract(29, 'days'), moment()],
        'This Month': [moment().startOf('month'), moment().endOf('month')],
        'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
      }
    };
    $('[data-toggle="date-picker-range"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultRangeOptions, $(obj).data());
      var target = objOptions["targetDisplay"]; //rendering

      $(obj).daterangepicker(objOptions, function (start, end) {
        if (target) $(target).html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
      });
    });
  }, // time picker
  AdvanceFormApp.prototype.initTimePicker = function () {
    var defaultOptions = {
      "showSeconds": true,
      "icons": {
        "up": "mdi mdi-chevron-up",
        "down": "mdi mdi-chevron-down"
      }
    }; // time picker

    $('[data-toggle="timepicker"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultOptions, $(obj).data());
      $(obj).timepicker(objOptions);
    });
  }, // touchspin
  AdvanceFormApp.prototype.initTouchspin = function () {
    var defaultOptions = {}; // touchspin

    $('[data-toggle="touchspin"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultOptions, $(obj).data());
      $(obj).TouchSpin(objOptions);
    });
  }, // maxlength
  AdvanceFormApp.prototype.initMaxlength = function () {
    var defaultOptions = {
      warningClass: "badge badge-success",
      limitReachedClass: "badge badge-danger",
      separator: ' out of ',
      preText: 'You typed ',
      postText: ' chars available.',
      placement: 'bottom'
    }; // maxlength

    $('[data-toggle="maxlength"]').each(function (idx, obj) {
      var objOptions = $.extend({}, defaultOptions, $(obj).data());
      $(obj).maxlength(objOptions);
    });
  },
  /** 
   * Initilize
  */
  AdvanceFormApp.prototype.init = function () {
    this.initSelect2();
    this.initMask();
    this.initDateRange();
    this.initTimePicker();
    this.initTouchspin();
    this.initMaxlength();
  }, $.AdvanceFormApp = new AdvanceFormApp(), $.AdvanceFormApp.Constructor = AdvanceFormApp;
}(window.jQuery), function ($) {
  'use strict';

  var NotificationApp = function NotificationApp() {};
  /**
   * Send Notification
   * @param {*} heading heading text
   * @param {*} body body text
   * @param {*} position position e.g top-right, top-left, bottom-left, etc
   * @param {*} loaderBgColor loader background color
   * @param {*} icon icon which needs to be displayed
   * @param {*} hideAfter automatically hide after seconds
   * @param {*} stack 
   */


  NotificationApp.prototype.send = function (heading, body, position, loaderBgColor, icon, hideAfter, stack, showHideTransition) {
    // default      
    if (!hideAfter) hideAfter = 3000;
    if (!stack) stack = 1;
    var options = {
      heading: heading,
      text: body,
      position: position,
      loaderBg: loaderBgColor,
      icon: icon,
      hideAfter: hideAfter,
      stack: stack
    };
    if (showHideTransition) options.showHideTransition = showHideTransition;else options.showHideTransition = 'fade';
    $.toast().reset('all');
    $.toast(options);
  }, $.NotificationApp = new NotificationApp(), $.NotificationApp.Constructor = NotificationApp;
}(window.jQuery), function ($) {
  "use strict";

  var Components = function Components() {}; //initializing tooltip


  Components.prototype.initTooltipPlugin = function () {
    $.fn.tooltip && $('[data-toggle="tooltip"]').tooltip();
  }, //initializing popover
  Components.prototype.initPopoverPlugin = function () {
    $.fn.popover && $('[data-toggle="popover"]').popover();
  }, //initializing toast
  Components.prototype.initToastPlugin = function () {
    $.fn.toast && $('[data-toggle="toast"]').toast();
  }, //initializing form validation
  Components.prototype.initFormValidation = function () {
    $(".needs-validation").on('submit', function (event) {
      $(this).addClass('was-validated');

      if ($(this)[0].checkValidity() === false) {
        event.preventDefault();
        event.stopPropagation();
        return false;
      }

      return true;
    });
  }, Components.prototype.initShowHidePassword = function () {
    $("[data-password]").on('click', function () {
      if ($(this).attr('data-password') == "false") {
        $(this).siblings("input").attr("type", "text");
        $(this).attr('data-password', 'true');
        $(this).addClass("show-password");
      } else {
        $(this).siblings("input").attr("type", "password");
        $(this).attr('data-password', 'false');
        $(this).removeClass("show-password");
      }
    });
  }, Components.prototype.initMultiDropdown = function () {
    $('.dropdown-menu a.dropdown-toggle').on('click', function () {
      if (!$(this).next().hasClass('show')) {
        $(this).parents('.dropdown-menu').first().find('.show').removeClass('show');
      }

      var $subMenu = $(this).next('.dropdown-menu');
      $subMenu.toggleClass('show');
      return false;
    });
  }, Components.prototype.initSyntaxHighlight = function () {
    //syntax
    var entityMap = {
      "&": "&amp;",
      "<": "&lt;",
      ">": "&gt;",
      '"': '&quot;',
      "'": '&#39;',
      "/": '&#x2F;'
    };

    function escapeHtml(string) {
      return String(string).replace(/[&<>"'\/]/g, function (s) {
        return entityMap[s];
      });
    }

    $(document).ready(function (e) {
      document.querySelectorAll("pre span.escape").forEach(function (element, n) {
        if (element.classList.contains("escape")) {
          var text = element.innerText;
        } else {
          var text = element.innerText;
        }

        text = text.replace(/^\n/, '').trimRight(); // goodbye starting whitespace

        var to_kill = Infinity;
        var lines = text.split("\n");

        for (var i = 0; i < lines.length; i++) {
          if (!lines[i].trim()) {
            continue;
          }

          to_kill = Math.min(lines[i].search(/\S/), to_kill);
        }

        var out = [];

        for (var i = 0; i < lines.length; i++) {
          out.push(lines[i].replace(new RegExp("^ {" + to_kill + "}", "g"), ""));
        }

        element.innerText = out.join("\n");
      });
      document.querySelectorAll('pre span.escape').forEach(function (block) {
        hljs.highlightBlock(block);
      });
    });
  }, //initilizing
  Components.prototype.init = function () {
    this.initTooltipPlugin(), this.initPopoverPlugin(), this.initToastPlugin(), this.initFormValidation(), this.initShowHidePassword(), this.initMultiDropdown(), this.initSyntaxHighlight();
  }, $.Components = new Components(), $.Components.Constructor = Components;
}(window.jQuery), function ($) {
  'use strict';

  var App = function App() {
    this.$body = $('body'), this.$window = $(window);
  };
  /**
   * Activates the default theme
   */


  App.prototype.activateDefaultSidebarTheme = function () {
    $.LayoutThemeApp.activateDefaultSidebarTheme();
  },
  /**
   * Activates the light theme
   */
  App.prototype.activateLightSidebarTheme = function () {
    $.LayoutThemeApp.activateLightSidebarTheme();
  },
  /**
   * Activates the dark theme
   */
  App.prototype.activateDarkSidebarTheme = function () {
    $.LayoutThemeApp.activateDarkSidebarTheme();
  },
  /**
   * Activates the condensed sidebar
   */
  App.prototype.activateCondensedSidebar = function () {
    $.LayoutThemeApp.activateCondensedSidebar();
  },
  /**
   * Deactivates the condensed sidebar
   */
  App.prototype.deactivateCondensedSidebar = function () {
    $.LayoutThemeApp.deactivateCondensedSidebar();
  },
  /**
   * Activates the scrollable sidebar
   */
  App.prototype.activateScrollableSidebar = function () {
    $.LayoutThemeApp.activateScrollableSidebar();
  },
  /**
   * Deactivates the scrollable
   */
  App.prototype.deactivateScrollableSidebar = function () {
    $.LayoutThemeApp.deactivateScrollableSidebar();
  },
  /**
   * Activates the boxed mode
   */
  App.prototype.activateBoxed = function () {
    $.LayoutThemeApp.activateBoxed();
  },
  /**
   * Activate the fluid mode
   */
  App.prototype.activateFluid = function () {
    $.LayoutThemeApp.activateFluid();
  },
  /**
   * Toggle the dark mode
   */
  App.prototype.activateDarkMode = function () {
    $.LayoutThemeApp.activateDarkMode();
  },
  /**
   * Deactivate the dark mode
   */
  App.prototype.deactivateDarkMode = function () {
    $.LayoutThemeApp.deactivateDarkMode();
  },
  /**
   * clear the saved layout related settings
   */
  App.prototype.clearSavedConfig = function () {
    $.LayoutThemeApp.clearSavedConfig();
  },
  /**
   * Gets the layout config
   */
  App.prototype.getLayoutConfig = function () {
    return $.LayoutThemeApp.getConfig();
  };
  /**
   * Reset the layout
   */

  App.prototype.resetLayout = function (callback) {
    $.LayoutThemeApp.reset(callback);
  },
  /**
   * initilizing
   */
  App.prototype.init = function () {
    $.LayoutThemeApp.init(); // remove loading

    setTimeout(function () {
      document.body.classList.remove('loading');
    }, 400);
    $.RightBar.init(); // showing the sidebar on load if user is visiting the page first time only

    var bodyConfig = this.$body.data('layoutConfig');

    if (window.sessionStorage && bodyConfig && bodyConfig.hasOwnProperty('showRightSidebarOnStart') && bodyConfig['showRightSidebarOnStart']) {
      var alreadyVisited = sessionStorage.getItem("_HYPER_VISITED_");

      if (!alreadyVisited) {
        $.RightBar.toggleRightSideBar();
        sessionStorage.setItem("_HYPER_VISITED_", true);
      }
    } //creating portles


    $.Portlet.init();
    $.AdvanceFormApp.init();
    $.Components.init(); // loader - Preloader

    $(window).on('load', function () {
      $('#status').fadeOut();
      $('#preloader').delay(350).fadeOut('slow');
    });
  }, $.App = new App(), $.App.Constructor = App;
}(window.jQuery), //initializing main application module
function ($) {
  "use strict";

  $.App.init();
}(window.jQuery);

/***/ }),

/***/ 0:
/*!**********************************************************************************************************************************************************************************************!*\
  !*** multi ./resources/js/app.js ./resources/sass/dashboard/customArticleStyle.scss ./resources/sass/dashboard/app.scss ./resources/sass/index/theme.scss ./resources/sass/index/logIn.scss ***!
  \**********************************************************************************************************************************************************************************************/
/*! no static exports found */
/***/ (function(module, exports, __webpack_require__) {

__webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\js\app.js */"./resources/js/app.js");
__webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\sass\dashboard\customArticleStyle.scss */"./resources/sass/dashboard/customArticleStyle.scss");
__webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\sass\dashboard\app.scss */"./resources/sass/dashboard/app.scss");
__webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\sass\index\theme.scss */"./resources/sass/index/theme.scss");
module.exports = __webpack_require__(/*! C:\Users\arxi-\OneDrive\Υπολογιστής\lmsdemo-master\resources\sass\index\logIn.scss */"./resources/sass/index/logIn.scss");


/***/ })

/******/ });