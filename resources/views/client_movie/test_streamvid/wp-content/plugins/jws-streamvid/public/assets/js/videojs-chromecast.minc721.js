/*! @silvermine/videojs-chromecast 2023-11-07 v1.4.1-14-g08060f4 */

(function() {
    function r(e, n, t) {
        function o(i, f) {
            if (!n[i]) {
                if (!e[i]) {
                    var c = "function" == typeof require && require;
                    if (!f && c) return c(i, !0);
                    if (u) return u(i, !0);
                    var a = new Error("Cannot find module '" + i + "'");
                    throw a.code = "MODULE_NOT_FOUND", a;
                }
                var p = n[i] = {
                    exports: {}
                };
                e[i][0].call(p.exports, function(r) {
                    var n = e[i][1][r];
                    return o(n || r);
                }, p, p.exports, r, e, n, t);
            }
            return n[i].exports;
        }
        for (var u = "function" == typeof require && require, i = 0; i < t.length; i++) o(t[i]);
        return o;
    }
    return r;
})()({
    1: [ function(require, module, exports) {
        module.exports = function(it) {
            if (typeof it != "function") {
                throw TypeError(String(it) + " is not a function");
            }
            return it;
        };
    }, {} ],
    2: [ function(require, module, exports) {
        var isObject = require("../internals/is-object");
        module.exports = function(it) {
            if (!isObject(it)) {
                throw TypeError(String(it) + " is not an object");
            }
            return it;
        };
    }, {
        "../internals/is-object": 36
    } ],
    3: [ function(require, module, exports) {
        var toIndexedObject = require("../internals/to-indexed-object");
        var toLength = require("../internals/to-length");
        var toAbsoluteIndex = require("../internals/to-absolute-index");
        var createMethod = function(IS_INCLUDES) {
            return function($this, el, fromIndex) {
                var O = toIndexedObject($this);
                var length = toLength(O.length);
                var index = toAbsoluteIndex(fromIndex, length);
                var value;
                if (IS_INCLUDES && el != el) while (length > index) {
                    value = O[index++];
                    if (value != value) return true;
                } else for (;length > index; index++) {
                    if ((IS_INCLUDES || index in O) && O[index] === el) return IS_INCLUDES || index || 0;
                }
                return !IS_INCLUDES && -1;
            };
        };
        module.exports = {
            includes: createMethod(true),
            indexOf: createMethod(false)
        };
    }, {
        "../internals/to-absolute-index": 60,
        "../internals/to-indexed-object": 61,
        "../internals/to-length": 63
    } ],
    4: [ function(require, module, exports) {
        var bind = require("../internals/function-bind-context");
        var IndexedObject = require("../internals/indexed-object");
        var toObject = require("../internals/to-object");
        var toLength = require("../internals/to-length");
        var arraySpeciesCreate = require("../internals/array-species-create");
        var push = [].push;
        var createMethod = function(TYPE) {
            var IS_MAP = TYPE == 1;
            var IS_FILTER = TYPE == 2;
            var IS_SOME = TYPE == 3;
            var IS_EVERY = TYPE == 4;
            var IS_FIND_INDEX = TYPE == 6;
            var IS_FILTER_OUT = TYPE == 7;
            var NO_HOLES = TYPE == 5 || IS_FIND_INDEX;
            return function($this, callbackfn, that, specificCreate) {
                var O = toObject($this);
                var self = IndexedObject(O);
                var boundFunction = bind(callbackfn, that, 3);
                var length = toLength(self.length);
                var index = 0;
                var create = specificCreate || arraySpeciesCreate;
                var target = IS_MAP ? create($this, length) : IS_FILTER || IS_FILTER_OUT ? create($this, 0) : undefined;
                var value, result;
                for (;length > index; index++) if (NO_HOLES || index in self) {
                    value = self[index];
                    result = boundFunction(value, index, O);
                    if (TYPE) {
                        if (IS_MAP) target[index] = result; else if (result) switch (TYPE) {
                          case 3:
                            return true;

                          case 5:
                            return value;

                          case 6:
                            return index;

                          case 2:
                            push.call(target, value);
                        } else switch (TYPE) {
                          case 4:
                            return false;

                          case 7:
                            push.call(target, value);
                        }
                    }
                }
                return IS_FIND_INDEX ? -1 : IS_SOME || IS_EVERY ? IS_EVERY : target;
            };
        };
        module.exports = {
            forEach: createMethod(0),
            map: createMethod(1),
            filter: createMethod(2),
            some: createMethod(3),
            every: createMethod(4),
            find: createMethod(5),
            findIndex: createMethod(6),
            filterOut: createMethod(7)
        };
    }, {
        "../internals/array-species-create": 6,
        "../internals/function-bind-context": 23,
        "../internals/indexed-object": 31,
        "../internals/to-length": 63,
        "../internals/to-object": 64
    } ],
    5: [ function(require, module, exports) {
        var fails = require("../internals/fails");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var V8_VERSION = require("../internals/engine-v8-version");
        var SPECIES = wellKnownSymbol("species");
        module.exports = function(METHOD_NAME) {
            return V8_VERSION >= 51 || !fails(function() {
                var array = [];
                var constructor = array.constructor = {};
                constructor[SPECIES] = function() {
                    return {
                        foo: 1
                    };
                };
                return array[METHOD_NAME](Boolean).foo !== 1;
            });
        };
    }, {
        "../internals/engine-v8-version": 19,
        "../internals/fails": 22,
        "../internals/well-known-symbol": 70
    } ],
    6: [ function(require, module, exports) {
        var isObject = require("../internals/is-object");
        var isArray = require("../internals/is-array");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var SPECIES = wellKnownSymbol("species");
        module.exports = function(originalArray, length) {
            var C;
            if (isArray(originalArray)) {
                C = originalArray.constructor;
                if (typeof C == "function" && (C === Array || isArray(C.prototype))) C = undefined; else if (isObject(C)) {
                    C = C[SPECIES];
                    if (C === null) C = undefined;
                }
            }
            return new (C === undefined ? Array : C)(length === 0 ? 0 : length);
        };
    }, {
        "../internals/is-array": 34,
        "../internals/is-object": 36,
        "../internals/well-known-symbol": 70
    } ],
    7: [ function(require, module, exports) {
        var toString = {}.toString;
        module.exports = function(it) {
            return toString.call(it).slice(8, -1);
        };
    }, {} ],
    8: [ function(require, module, exports) {
        var TO_STRING_TAG_SUPPORT = require("../internals/to-string-tag-support");
        var classofRaw = require("../internals/classof-raw");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var TO_STRING_TAG = wellKnownSymbol("toStringTag");
        var CORRECT_ARGUMENTS = classofRaw(function() {
            return arguments;
        }()) == "Arguments";
        var tryGet = function(it, key) {
            try {
                return it[key];
            } catch (error) {}
        };
        module.exports = TO_STRING_TAG_SUPPORT ? classofRaw : function(it) {
            var O, tag, result;
            return it === undefined ? "Undefined" : it === null ? "Null" : typeof (tag = tryGet(O = Object(it), TO_STRING_TAG)) == "string" ? tag : CORRECT_ARGUMENTS ? classofRaw(O) : (result = classofRaw(O)) == "Object" && typeof O.callee == "function" ? "Arguments" : result;
        };
    }, {
        "../internals/classof-raw": 7,
        "../internals/to-string-tag-support": 66,
        "../internals/well-known-symbol": 70
    } ],
    9: [ function(require, module, exports) {
        var has = require("../internals/has");
        var ownKeys = require("../internals/own-keys");
        var getOwnPropertyDescriptorModule = require("../internals/object-get-own-property-descriptor");
        var definePropertyModule = require("../internals/object-define-property");
        module.exports = function(target, source) {
            var keys = ownKeys(source);
            var defineProperty = definePropertyModule.f;
            var getOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
            for (var i = 0; i < keys.length; i++) {
                var key = keys[i];
                if (!has(target, key)) defineProperty(target, key, getOwnPropertyDescriptor(source, key));
            }
        };
    }, {
        "../internals/has": 27,
        "../internals/object-define-property": 42,
        "../internals/object-get-own-property-descriptor": 43,
        "../internals/own-keys": 51
    } ],
    10: [ function(require, module, exports) {
        var DESCRIPTORS = require("../internals/descriptors");
        var definePropertyModule = require("../internals/object-define-property");
        var createPropertyDescriptor = require("../internals/create-property-descriptor");
        module.exports = DESCRIPTORS ? function(object, key, value) {
            return definePropertyModule.f(object, key, createPropertyDescriptor(1, value));
        } : function(object, key, value) {
            object[key] = value;
            return object;
        };
    }, {
        "../internals/create-property-descriptor": 11,
        "../internals/descriptors": 15,
        "../internals/object-define-property": 42
    } ],
    11: [ function(require, module, exports) {
        module.exports = function(bitmap, value) {
            return {
                enumerable: !(bitmap & 1),
                configurable: !(bitmap & 2),
                writable: !(bitmap & 4),
                value: value
            };
        };
    }, {} ],
    12: [ function(require, module, exports) {
        "use strict";
        var toPrimitive = require("../internals/to-primitive");
        var definePropertyModule = require("../internals/object-define-property");
        var createPropertyDescriptor = require("../internals/create-property-descriptor");
        module.exports = function(object, key, value) {
            var propertyKey = toPrimitive(key);
            if (propertyKey in object) definePropertyModule.f(object, propertyKey, createPropertyDescriptor(0, value)); else object[propertyKey] = value;
        };
    }, {
        "../internals/create-property-descriptor": 11,
        "../internals/object-define-property": 42,
        "../internals/to-primitive": 65
    } ],
    13: [ function(require, module, exports) {
        "use strict";
        var anObject = require("../internals/an-object");
        var toPrimitive = require("../internals/to-primitive");
        module.exports = function(hint) {
            if (hint !== "string" && hint !== "number" && hint !== "default") {
                throw TypeError("Incorrect hint");
            }
            return toPrimitive(anObject(this), hint !== "number");
        };
    }, {
        "../internals/an-object": 2,
        "../internals/to-primitive": 65
    } ],
    14: [ function(require, module, exports) {
        var path = require("../internals/path");
        var has = require("../internals/has");
        var wrappedWellKnownSymbolModule = require("../internals/well-known-symbol-wrapped");
        var defineProperty = require("../internals/object-define-property").f;
        module.exports = function(NAME) {
            var Symbol = path.Symbol || (path.Symbol = {});
            if (!has(Symbol, NAME)) defineProperty(Symbol, NAME, {
                value: wrappedWellKnownSymbolModule.f(NAME)
            });
        };
    }, {
        "../internals/has": 27,
        "../internals/object-define-property": 42,
        "../internals/path": 52,
        "../internals/well-known-symbol-wrapped": 69
    } ],
    15: [ function(require, module, exports) {
        var fails = require("../internals/fails");
        module.exports = !fails(function() {
            return Object.defineProperty({}, 1, {
                get: function() {
                    return 7;
                }
            })[1] != 7;
        });
    }, {
        "../internals/fails": 22
    } ],
    16: [ function(require, module, exports) {
        var global = require("../internals/global");
        var isObject = require("../internals/is-object");
        var document = global.document;
        var EXISTS = isObject(document) && isObject(document.createElement);
        module.exports = function(it) {
            return EXISTS ? document.createElement(it) : {};
        };
    }, {
        "../internals/global": 26,
        "../internals/is-object": 36
    } ],
    17: [ function(require, module, exports) {
        var classof = require("../internals/classof-raw");
        var global = require("../internals/global");
        module.exports = classof(global.process) == "process";
    }, {
        "../internals/classof-raw": 7,
        "../internals/global": 26
    } ],
    18: [ function(require, module, exports) {
        var getBuiltIn = require("../internals/get-built-in");
        module.exports = getBuiltIn("navigator", "userAgent") || "";
    }, {
        "../internals/get-built-in": 25
    } ],
    19: [ function(require, module, exports) {
        var global = require("../internals/global");
        var userAgent = require("../internals/engine-user-agent");
        var process = global.process;
        var versions = process && process.versions;
        var v8 = versions && versions.v8;
        var match, version;
        if (v8) {
            match = v8.split(".");
            version = match[0] + match[1];
        } else if (userAgent) {
            match = userAgent.match(/Edge\/(\d+)/);
            if (!match || match[1] >= 74) {
                match = userAgent.match(/Chrome\/(\d+)/);
                if (match) version = match[1];
            }
        }
        module.exports = version && +version;
    }, {
        "../internals/engine-user-agent": 18,
        "../internals/global": 26
    } ],
    20: [ function(require, module, exports) {
        module.exports = [ "constructor", "hasOwnProperty", "isPrototypeOf", "propertyIsEnumerable", "toLocaleString", "toString", "valueOf" ];
    }, {} ],
    21: [ function(require, module, exports) {
        var global = require("../internals/global");
        var getOwnPropertyDescriptor = require("../internals/object-get-own-property-descriptor").f;
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        var redefine = require("../internals/redefine");
        var setGlobal = require("../internals/set-global");
        var copyConstructorProperties = require("../internals/copy-constructor-properties");
        var isForced = require("../internals/is-forced");
        module.exports = function(options, source) {
            var TARGET = options.target;
            var GLOBAL = options.global;
            var STATIC = options.stat;
            var FORCED, target, key, targetProperty, sourceProperty, descriptor;
            if (GLOBAL) {
                target = global;
            } else if (STATIC) {
                target = global[TARGET] || setGlobal(TARGET, {});
            } else {
                target = (global[TARGET] || {}).prototype;
            }
            if (target) for (key in source) {
                sourceProperty = source[key];
                if (options.noTargetGet) {
                    descriptor = getOwnPropertyDescriptor(target, key);
                    targetProperty = descriptor && descriptor.value;
                } else targetProperty = target[key];
                FORCED = isForced(GLOBAL ? key : TARGET + (STATIC ? "." : "#") + key, options.forced);
                if (!FORCED && targetProperty !== undefined) {
                    if (typeof sourceProperty === typeof targetProperty) continue;
                    copyConstructorProperties(sourceProperty, targetProperty);
                }
                if (options.sham || targetProperty && targetProperty.sham) {
                    createNonEnumerableProperty(sourceProperty, "sham", true);
                }
                redefine(target, key, sourceProperty, options);
            }
        };
    }, {
        "../internals/copy-constructor-properties": 9,
        "../internals/create-non-enumerable-property": 10,
        "../internals/global": 26,
        "../internals/is-forced": 35,
        "../internals/object-get-own-property-descriptor": 43,
        "../internals/redefine": 53,
        "../internals/set-global": 55
    } ],
    22: [ function(require, module, exports) {
        module.exports = function(exec) {
            try {
                return !!exec();
            } catch (error) {
                return true;
            }
        };
    }, {} ],
    23: [ function(require, module, exports) {
        var aFunction = require("../internals/a-function");
        module.exports = function(fn, that, length) {
            aFunction(fn);
            if (that === undefined) return fn;
            switch (length) {
              case 0:
                return function() {
                    return fn.call(that);
                };

              case 1:
                return function(a) {
                    return fn.call(that, a);
                };

              case 2:
                return function(a, b) {
                    return fn.call(that, a, b);
                };

              case 3:
                return function(a, b, c) {
                    return fn.call(that, a, b, c);
                };
            }
            return function() {
                return fn.apply(that, arguments);
            };
        };
    }, {
        "../internals/a-function": 1
    } ],
    24: [ function(require, module, exports) {
        "use strict";
        var aFunction = require("../internals/a-function");
        var isObject = require("../internals/is-object");
        var slice = [].slice;
        var factories = {};
        var construct = function(C, argsLength, args) {
            if (!(argsLength in factories)) {
                for (var list = [], i = 0; i < argsLength; i++) list[i] = "a[" + i + "]";
                factories[argsLength] = Function("C,a", "return new C(" + list.join(",") + ")");
            }
            return factories[argsLength](C, args);
        };
        module.exports = Function.bind || function bind(that) {
            var fn = aFunction(this);
            var partArgs = slice.call(arguments, 1);
            var boundFunction = function bound() {
                var args = partArgs.concat(slice.call(arguments));
                return this instanceof boundFunction ? construct(fn, args.length, args) : fn.apply(that, args);
            };
            if (isObject(fn.prototype)) boundFunction.prototype = fn.prototype;
            return boundFunction;
        };
    }, {
        "../internals/a-function": 1,
        "../internals/is-object": 36
    } ],
    25: [ function(require, module, exports) {
        var path = require("../internals/path");
        var global = require("../internals/global");
        var aFunction = function(variable) {
            return typeof variable == "function" ? variable : undefined;
        };
        module.exports = function(namespace, method) {
            return arguments.length < 2 ? aFunction(path[namespace]) || aFunction(global[namespace]) : path[namespace] && path[namespace][method] || global[namespace] && global[namespace][method];
        };
    }, {
        "../internals/global": 26,
        "../internals/path": 52
    } ],
    26: [ function(require, module, exports) {
        (function(global) {
            (function() {
                var check = function(it) {
                    return it && it.Math == Math && it;
                };
                module.exports = check(typeof globalThis == "object" && globalThis) || check(typeof window == "object" && window) || check(typeof self == "object" && self) || check(typeof global == "object" && global) || function() {
                    return this;
                }() || Function("return this")();
            }).call(this);
        }).call(this, typeof global !== "undefined" ? global : typeof self !== "undefined" ? self : typeof window !== "undefined" ? window : {});
    }, {} ],
    27: [ function(require, module, exports) {
        var toObject = require("../internals/to-object");
        var hasOwnProperty = {}.hasOwnProperty;
        module.exports = function hasOwn(it, key) {
            return hasOwnProperty.call(toObject(it), key);
        };
    }, {
        "../internals/to-object": 64
    } ],
    28: [ function(require, module, exports) {
        module.exports = {};
    }, {} ],
    29: [ function(require, module, exports) {
        var getBuiltIn = require("../internals/get-built-in");
        module.exports = getBuiltIn("document", "documentElement");
    }, {
        "../internals/get-built-in": 25
    } ],
    30: [ function(require, module, exports) {
        var DESCRIPTORS = require("../internals/descriptors");
        var fails = require("../internals/fails");
        var createElement = require("../internals/document-create-element");
        module.exports = !DESCRIPTORS && !fails(function() {
            return Object.defineProperty(createElement("div"), "a", {
                get: function() {
                    return 7;
                }
            }).a != 7;
        });
    }, {
        "../internals/descriptors": 15,
        "../internals/document-create-element": 16,
        "../internals/fails": 22
    } ],
    31: [ function(require, module, exports) {
        var fails = require("../internals/fails");
        var classof = require("../internals/classof-raw");
        var split = "".split;
        module.exports = fails(function() {
            return !Object("z").propertyIsEnumerable(0);
        }) ? function(it) {
            return classof(it) == "String" ? split.call(it, "") : Object(it);
        } : Object;
    }, {
        "../internals/classof-raw": 7,
        "../internals/fails": 22
    } ],
    32: [ function(require, module, exports) {
        var store = require("../internals/shared-store");
        var functionToString = Function.toString;
        if (typeof store.inspectSource != "function") {
            store.inspectSource = function(it) {
                return functionToString.call(it);
            };
        }
        module.exports = store.inspectSource;
    }, {
        "../internals/shared-store": 58
    } ],
    33: [ function(require, module, exports) {
        var NATIVE_WEAK_MAP = require("../internals/native-weak-map");
        var global = require("../internals/global");
        var isObject = require("../internals/is-object");
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        var objectHas = require("../internals/has");
        var shared = require("../internals/shared-store");
        var sharedKey = require("../internals/shared-key");
        var hiddenKeys = require("../internals/hidden-keys");
        var OBJECT_ALREADY_INITIALIZED = "Object already initialized";
        var WeakMap = global.WeakMap;
        var set, get, has;
        var enforce = function(it) {
            return has(it) ? get(it) : set(it, {});
        };
        var getterFor = function(TYPE) {
            return function(it) {
                var state;
                if (!isObject(it) || (state = get(it)).type !== TYPE) {
                    throw TypeError("Incompatible receiver, " + TYPE + " required");
                }
                return state;
            };
        };
        if (NATIVE_WEAK_MAP) {
            var store = shared.state || (shared.state = new WeakMap());
            var wmget = store.get;
            var wmhas = store.has;
            var wmset = store.set;
            set = function(it, metadata) {
                if (wmhas.call(store, it)) throw new TypeError(OBJECT_ALREADY_INITIALIZED);
                metadata.facade = it;
                wmset.call(store, it, metadata);
                return metadata;
            };
            get = function(it) {
                return wmget.call(store, it) || {};
            };
            has = function(it) {
                return wmhas.call(store, it);
            };
        } else {
            var STATE = sharedKey("state");
            hiddenKeys[STATE] = true;
            set = function(it, metadata) {
                if (objectHas(it, STATE)) throw new TypeError(OBJECT_ALREADY_INITIALIZED);
                metadata.facade = it;
                createNonEnumerableProperty(it, STATE, metadata);
                return metadata;
            };
            get = function(it) {
                return objectHas(it, STATE) ? it[STATE] : {};
            };
            has = function(it) {
                return objectHas(it, STATE);
            };
        }
        module.exports = {
            set: set,
            get: get,
            has: has,
            enforce: enforce,
            getterFor: getterFor
        };
    }, {
        "../internals/create-non-enumerable-property": 10,
        "../internals/global": 26,
        "../internals/has": 27,
        "../internals/hidden-keys": 28,
        "../internals/is-object": 36,
        "../internals/native-weak-map": 39,
        "../internals/shared-key": 57,
        "../internals/shared-store": 58
    } ],
    34: [ function(require, module, exports) {
        var classof = require("../internals/classof-raw");
        module.exports = Array.isArray || function isArray(arg) {
            return classof(arg) == "Array";
        };
    }, {
        "../internals/classof-raw": 7
    } ],
    35: [ function(require, module, exports) {
        var fails = require("../internals/fails");
        var replacement = /#|\.prototype\./;
        var isForced = function(feature, detection) {
            var value = data[normalize(feature)];
            return value == POLYFILL ? true : value == NATIVE ? false : typeof detection == "function" ? fails(detection) : !!detection;
        };
        var normalize = isForced.normalize = function(string) {
            return String(string).replace(replacement, ".").toLowerCase();
        };
        var data = isForced.data = {};
        var NATIVE = isForced.NATIVE = "N";
        var POLYFILL = isForced.POLYFILL = "P";
        module.exports = isForced;
    }, {
        "../internals/fails": 22
    } ],
    36: [ function(require, module, exports) {
        module.exports = function(it) {
            return typeof it === "object" ? it !== null : typeof it === "function";
        };
    }, {} ],
    37: [ function(require, module, exports) {
        module.exports = false;
    }, {} ],
    38: [ function(require, module, exports) {
        var IS_NODE = require("../internals/engine-is-node");
        var V8_VERSION = require("../internals/engine-v8-version");
        var fails = require("../internals/fails");
        module.exports = !!Object.getOwnPropertySymbols && !fails(function() {
            return !Symbol.sham && (IS_NODE ? V8_VERSION === 38 : V8_VERSION > 37 && V8_VERSION < 41);
        });
    }, {
        "../internals/engine-is-node": 17,
        "../internals/engine-v8-version": 19,
        "../internals/fails": 22
    } ],
    39: [ function(require, module, exports) {
        var global = require("../internals/global");
        var inspectSource = require("../internals/inspect-source");
        var WeakMap = global.WeakMap;
        module.exports = typeof WeakMap === "function" && /native code/.test(inspectSource(WeakMap));
    }, {
        "../internals/global": 26,
        "../internals/inspect-source": 32
    } ],
    40: [ function(require, module, exports) {
        var anObject = require("../internals/an-object");
        var defineProperties = require("../internals/object-define-properties");
        var enumBugKeys = require("../internals/enum-bug-keys");
        var hiddenKeys = require("../internals/hidden-keys");
        var html = require("../internals/html");
        var documentCreateElement = require("../internals/document-create-element");
        var sharedKey = require("../internals/shared-key");
        var GT = ">";
        var LT = "<";
        var PROTOTYPE = "prototype";
        var SCRIPT = "script";
        var IE_PROTO = sharedKey("IE_PROTO");
        var EmptyConstructor = function() {};
        var scriptTag = function(content) {
            return LT + SCRIPT + GT + content + LT + "/" + SCRIPT + GT;
        };
        var NullProtoObjectViaActiveX = function(activeXDocument) {
            activeXDocument.write(scriptTag(""));
            activeXDocument.close();
            var temp = activeXDocument.parentWindow.Object;
            activeXDocument = null;
            return temp;
        };
        var NullProtoObjectViaIFrame = function() {
            var iframe = documentCreateElement("iframe");
            var JS = "java" + SCRIPT + ":";
            var iframeDocument;
            iframe.style.display = "none";
            html.appendChild(iframe);
            iframe.src = String(JS);
            iframeDocument = iframe.contentWindow.document;
            iframeDocument.open();
            iframeDocument.write(scriptTag("document.F=Object"));
            iframeDocument.close();
            return iframeDocument.F;
        };
        var activeXDocument;
        var NullProtoObject = function() {
            try {
                activeXDocument = document.domain && new ActiveXObject("htmlfile");
            } catch (error) {}
            NullProtoObject = activeXDocument ? NullProtoObjectViaActiveX(activeXDocument) : NullProtoObjectViaIFrame();
            var length = enumBugKeys.length;
            while (length--) delete NullProtoObject[PROTOTYPE][enumBugKeys[length]];
            return NullProtoObject();
        };
        hiddenKeys[IE_PROTO] = true;
        module.exports = Object.create || function create(O, Properties) {
            var result;
            if (O !== null) {
                EmptyConstructor[PROTOTYPE] = anObject(O);
                result = new EmptyConstructor();
                EmptyConstructor[PROTOTYPE] = null;
                result[IE_PROTO] = O;
            } else result = NullProtoObject();
            return Properties === undefined ? result : defineProperties(result, Properties);
        };
    }, {
        "../internals/an-object": 2,
        "../internals/document-create-element": 16,
        "../internals/enum-bug-keys": 20,
        "../internals/hidden-keys": 28,
        "../internals/html": 29,
        "../internals/object-define-properties": 41,
        "../internals/shared-key": 57
    } ],
    41: [ function(require, module, exports) {
        var DESCRIPTORS = require("../internals/descriptors");
        var definePropertyModule = require("../internals/object-define-property");
        var anObject = require("../internals/an-object");
        var objectKeys = require("../internals/object-keys");
        module.exports = DESCRIPTORS ? Object.defineProperties : function defineProperties(O, Properties) {
            anObject(O);
            var keys = objectKeys(Properties);
            var length = keys.length;
            var index = 0;
            var key;
            while (length > index) definePropertyModule.f(O, key = keys[index++], Properties[key]);
            return O;
        };
    }, {
        "../internals/an-object": 2,
        "../internals/descriptors": 15,
        "../internals/object-define-property": 42,
        "../internals/object-keys": 48
    } ],
    42: [ function(require, module, exports) {
        var DESCRIPTORS = require("../internals/descriptors");
        var IE8_DOM_DEFINE = require("../internals/ie8-dom-define");
        var anObject = require("../internals/an-object");
        var toPrimitive = require("../internals/to-primitive");
        var $defineProperty = Object.defineProperty;
        exports.f = DESCRIPTORS ? $defineProperty : function defineProperty(O, P, Attributes) {
            anObject(O);
            P = toPrimitive(P, true);
            anObject(Attributes);
            if (IE8_DOM_DEFINE) try {
                return $defineProperty(O, P, Attributes);
            } catch (error) {}
            if ("get" in Attributes || "set" in Attributes) throw TypeError("Accessors not supported");
            if ("value" in Attributes) O[P] = Attributes.value;
            return O;
        };
    }, {
        "../internals/an-object": 2,
        "../internals/descriptors": 15,
        "../internals/ie8-dom-define": 30,
        "../internals/to-primitive": 65
    } ],
    43: [ function(require, module, exports) {
        var DESCRIPTORS = require("../internals/descriptors");
        var propertyIsEnumerableModule = require("../internals/object-property-is-enumerable");
        var createPropertyDescriptor = require("../internals/create-property-descriptor");
        var toIndexedObject = require("../internals/to-indexed-object");
        var toPrimitive = require("../internals/to-primitive");
        var has = require("../internals/has");
        var IE8_DOM_DEFINE = require("../internals/ie8-dom-define");
        var $getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;
        exports.f = DESCRIPTORS ? $getOwnPropertyDescriptor : function getOwnPropertyDescriptor(O, P) {
            O = toIndexedObject(O);
            P = toPrimitive(P, true);
            if (IE8_DOM_DEFINE) try {
                return $getOwnPropertyDescriptor(O, P);
            } catch (error) {}
            if (has(O, P)) return createPropertyDescriptor(!propertyIsEnumerableModule.f.call(O, P), O[P]);
        };
    }, {
        "../internals/create-property-descriptor": 11,
        "../internals/descriptors": 15,
        "../internals/has": 27,
        "../internals/ie8-dom-define": 30,
        "../internals/object-property-is-enumerable": 49,
        "../internals/to-indexed-object": 61,
        "../internals/to-primitive": 65
    } ],
    44: [ function(require, module, exports) {
        var toIndexedObject = require("../internals/to-indexed-object");
        var $getOwnPropertyNames = require("../internals/object-get-own-property-names").f;
        var toString = {}.toString;
        var windowNames = typeof window == "object" && window && Object.getOwnPropertyNames ? Object.getOwnPropertyNames(window) : [];
        var getWindowNames = function(it) {
            try {
                return $getOwnPropertyNames(it);
            } catch (error) {
                return windowNames.slice();
            }
        };
        module.exports.f = function getOwnPropertyNames(it) {
            return windowNames && toString.call(it) == "[object Window]" ? getWindowNames(it) : $getOwnPropertyNames(toIndexedObject(it));
        };
    }, {
        "../internals/object-get-own-property-names": 45,
        "../internals/to-indexed-object": 61
    } ],
    45: [ function(require, module, exports) {
        var internalObjectKeys = require("../internals/object-keys-internal");
        var enumBugKeys = require("../internals/enum-bug-keys");
        var hiddenKeys = enumBugKeys.concat("length", "prototype");
        exports.f = Object.getOwnPropertyNames || function getOwnPropertyNames(O) {
            return internalObjectKeys(O, hiddenKeys);
        };
    }, {
        "../internals/enum-bug-keys": 20,
        "../internals/object-keys-internal": 47
    } ],
    46: [ function(require, module, exports) {
        exports.f = Object.getOwnPropertySymbols;
    }, {} ],
    47: [ function(require, module, exports) {
        var has = require("../internals/has");
        var toIndexedObject = require("../internals/to-indexed-object");
        var indexOf = require("../internals/array-includes").indexOf;
        var hiddenKeys = require("../internals/hidden-keys");
        module.exports = function(object, names) {
            var O = toIndexedObject(object);
            var i = 0;
            var result = [];
            var key;
            for (key in O) !has(hiddenKeys, key) && has(O, key) && result.push(key);
            while (names.length > i) if (has(O, key = names[i++])) {
                ~indexOf(result, key) || result.push(key);
            }
            return result;
        };
    }, {
        "../internals/array-includes": 3,
        "../internals/has": 27,
        "../internals/hidden-keys": 28,
        "../internals/to-indexed-object": 61
    } ],
    48: [ function(require, module, exports) {
        var internalObjectKeys = require("../internals/object-keys-internal");
        var enumBugKeys = require("../internals/enum-bug-keys");
        module.exports = Object.keys || function keys(O) {
            return internalObjectKeys(O, enumBugKeys);
        };
    }, {
        "../internals/enum-bug-keys": 20,
        "../internals/object-keys-internal": 47
    } ],
    49: [ function(require, module, exports) {
        "use strict";
        var $propertyIsEnumerable = {}.propertyIsEnumerable;
        var getOwnPropertyDescriptor = Object.getOwnPropertyDescriptor;
        var NASHORN_BUG = getOwnPropertyDescriptor && !$propertyIsEnumerable.call({
            1: 2
        }, 1);
        exports.f = NASHORN_BUG ? function propertyIsEnumerable(V) {
            var descriptor = getOwnPropertyDescriptor(this, V);
            return !!descriptor && descriptor.enumerable;
        } : $propertyIsEnumerable;
    }, {} ],
    50: [ function(require, module, exports) {
        "use strict";
        var TO_STRING_TAG_SUPPORT = require("../internals/to-string-tag-support");
        var classof = require("../internals/classof");
        module.exports = TO_STRING_TAG_SUPPORT ? {}.toString : function toString() {
            return "[object " + classof(this) + "]";
        };
    }, {
        "../internals/classof": 8,
        "../internals/to-string-tag-support": 66
    } ],
    51: [ function(require, module, exports) {
        var getBuiltIn = require("../internals/get-built-in");
        var getOwnPropertyNamesModule = require("../internals/object-get-own-property-names");
        var getOwnPropertySymbolsModule = require("../internals/object-get-own-property-symbols");
        var anObject = require("../internals/an-object");
        module.exports = getBuiltIn("Reflect", "ownKeys") || function ownKeys(it) {
            var keys = getOwnPropertyNamesModule.f(anObject(it));
            var getOwnPropertySymbols = getOwnPropertySymbolsModule.f;
            return getOwnPropertySymbols ? keys.concat(getOwnPropertySymbols(it)) : keys;
        };
    }, {
        "../internals/an-object": 2,
        "../internals/get-built-in": 25,
        "../internals/object-get-own-property-names": 45,
        "../internals/object-get-own-property-symbols": 46
    } ],
    52: [ function(require, module, exports) {
        var global = require("../internals/global");
        module.exports = global;
    }, {
        "../internals/global": 26
    } ],
    53: [ function(require, module, exports) {
        var global = require("../internals/global");
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        var has = require("../internals/has");
        var setGlobal = require("../internals/set-global");
        var inspectSource = require("../internals/inspect-source");
        var InternalStateModule = require("../internals/internal-state");
        var getInternalState = InternalStateModule.get;
        var enforceInternalState = InternalStateModule.enforce;
        var TEMPLATE = String(String).split("String");
        (module.exports = function(O, key, value, options) {
            var unsafe = options ? !!options.unsafe : false;
            var simple = options ? !!options.enumerable : false;
            var noTargetGet = options ? !!options.noTargetGet : false;
            var state;
            if (typeof value == "function") {
                if (typeof key == "string" && !has(value, "name")) {
                    createNonEnumerableProperty(value, "name", key);
                }
                state = enforceInternalState(value);
                if (!state.source) {
                    state.source = TEMPLATE.join(typeof key == "string" ? key : "");
                }
            }
            if (O === global) {
                if (simple) O[key] = value; else setGlobal(key, value);
                return;
            } else if (!unsafe) {
                delete O[key];
            } else if (!noTargetGet && O[key]) {
                simple = true;
            }
            if (simple) O[key] = value; else createNonEnumerableProperty(O, key, value);
        })(Function.prototype, "toString", function toString() {
            return typeof this == "function" && getInternalState(this).source || inspectSource(this);
        });
    }, {
        "../internals/create-non-enumerable-property": 10,
        "../internals/global": 26,
        "../internals/has": 27,
        "../internals/inspect-source": 32,
        "../internals/internal-state": 33,
        "../internals/set-global": 55
    } ],
    54: [ function(require, module, exports) {
        module.exports = function(it) {
            if (it == undefined) throw TypeError("Can't call method on " + it);
            return it;
        };
    }, {} ],
    55: [ function(require, module, exports) {
        var global = require("../internals/global");
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        module.exports = function(key, value) {
            try {
                createNonEnumerableProperty(global, key, value);
            } catch (error) {
                global[key] = value;
            }
            return value;
        };
    }, {
        "../internals/create-non-enumerable-property": 10,
        "../internals/global": 26
    } ],
    56: [ function(require, module, exports) {
        var defineProperty = require("../internals/object-define-property").f;
        var has = require("../internals/has");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var TO_STRING_TAG = wellKnownSymbol("toStringTag");
        module.exports = function(it, TAG, STATIC) {
            if (it && !has(it = STATIC ? it : it.prototype, TO_STRING_TAG)) {
                defineProperty(it, TO_STRING_TAG, {
                    configurable: true,
                    value: TAG
                });
            }
        };
    }, {
        "../internals/has": 27,
        "../internals/object-define-property": 42,
        "../internals/well-known-symbol": 70
    } ],
    57: [ function(require, module, exports) {
        var shared = require("../internals/shared");
        var uid = require("../internals/uid");
        var keys = shared("keys");
        module.exports = function(key) {
            return keys[key] || (keys[key] = uid(key));
        };
    }, {
        "../internals/shared": 59,
        "../internals/uid": 67
    } ],
    58: [ function(require, module, exports) {
        var global = require("../internals/global");
        var setGlobal = require("../internals/set-global");
        var SHARED = "__core-js_shared__";
        var store = global[SHARED] || setGlobal(SHARED, {});
        module.exports = store;
    }, {
        "../internals/global": 26,
        "../internals/set-global": 55
    } ],
    59: [ function(require, module, exports) {
        var IS_PURE = require("../internals/is-pure");
        var store = require("../internals/shared-store");
        (module.exports = function(key, value) {
            return store[key] || (store[key] = value !== undefined ? value : {});
        })("versions", []).push({
            version: "3.11.0",
            mode: IS_PURE ? "pure" : "global",
            copyright: "� 2021 Denis Pushkarev (zloirock.ru)"
        });
    }, {
        "../internals/is-pure": 37,
        "../internals/shared-store": 58
    } ],
    60: [ function(require, module, exports) {
        var toInteger = require("../internals/to-integer");
        var max = Math.max;
        var min = Math.min;
        module.exports = function(index, length) {
            var integer = toInteger(index);
            return integer < 0 ? max(integer + length, 0) : min(integer, length);
        };
    }, {
        "../internals/to-integer": 62
    } ],
    61: [ function(require, module, exports) {
        var IndexedObject = require("../internals/indexed-object");
        var requireObjectCoercible = require("../internals/require-object-coercible");
        module.exports = function(it) {
            return IndexedObject(requireObjectCoercible(it));
        };
    }, {
        "../internals/indexed-object": 31,
        "../internals/require-object-coercible": 54
    } ],
    62: [ function(require, module, exports) {
        var ceil = Math.ceil;
        var floor = Math.floor;
        module.exports = function(argument) {
            return isNaN(argument = +argument) ? 0 : (argument > 0 ? floor : ceil)(argument);
        };
    }, {} ],
    63: [ function(require, module, exports) {
        var toInteger = require("../internals/to-integer");
        var min = Math.min;
        module.exports = function(argument) {
            return argument > 0 ? min(toInteger(argument), 9007199254740991) : 0;
        };
    }, {
        "../internals/to-integer": 62
    } ],
    64: [ function(require, module, exports) {
        var requireObjectCoercible = require("../internals/require-object-coercible");
        module.exports = function(argument) {
            return Object(requireObjectCoercible(argument));
        };
    }, {
        "../internals/require-object-coercible": 54
    } ],
    65: [ function(require, module, exports) {
        var isObject = require("../internals/is-object");
        module.exports = function(input, PREFERRED_STRING) {
            if (!isObject(input)) return input;
            var fn, val;
            if (PREFERRED_STRING && typeof (fn = input.toString) == "function" && !isObject(val = fn.call(input))) return val;
            if (typeof (fn = input.valueOf) == "function" && !isObject(val = fn.call(input))) return val;
            if (!PREFERRED_STRING && typeof (fn = input.toString) == "function" && !isObject(val = fn.call(input))) return val;
            throw TypeError("Can't convert object to primitive value");
        };
    }, {
        "../internals/is-object": 36
    } ],
    66: [ function(require, module, exports) {
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var TO_STRING_TAG = wellKnownSymbol("toStringTag");
        var test = {};
        test[TO_STRING_TAG] = "z";
        module.exports = String(test) === "[object z]";
    }, {
        "../internals/well-known-symbol": 70
    } ],
    67: [ function(require, module, exports) {
        var id = 0;
        var postfix = Math.random();
        module.exports = function(key) {
            return "Symbol(" + String(key === undefined ? "" : key) + ")_" + (++id + postfix).toString(36);
        };
    }, {} ],
    68: [ function(require, module, exports) {
        var NATIVE_SYMBOL = require("../internals/native-symbol");
        module.exports = NATIVE_SYMBOL && !Symbol.sham && typeof Symbol.iterator == "symbol";
    }, {
        "../internals/native-symbol": 38
    } ],
    69: [ function(require, module, exports) {
        var wellKnownSymbol = require("../internals/well-known-symbol");
        exports.f = wellKnownSymbol;
    }, {
        "../internals/well-known-symbol": 70
    } ],
    70: [ function(require, module, exports) {
        var global = require("../internals/global");
        var shared = require("../internals/shared");
        var has = require("../internals/has");
        var uid = require("../internals/uid");
        var NATIVE_SYMBOL = require("../internals/native-symbol");
        var USE_SYMBOL_AS_UID = require("../internals/use-symbol-as-uid");
        var WellKnownSymbolsStore = shared("wks");
        var Symbol = global.Symbol;
        var createWellKnownSymbol = USE_SYMBOL_AS_UID ? Symbol : Symbol && Symbol.withoutSetter || uid;
        module.exports = function(name) {
            if (!has(WellKnownSymbolsStore, name) || !(NATIVE_SYMBOL || typeof WellKnownSymbolsStore[name] == "string")) {
                if (NATIVE_SYMBOL && has(Symbol, name)) {
                    WellKnownSymbolsStore[name] = Symbol[name];
                } else {
                    WellKnownSymbolsStore[name] = createWellKnownSymbol("Symbol." + name);
                }
            }
            return WellKnownSymbolsStore[name];
        };
    }, {
        "../internals/global": 26,
        "../internals/has": 27,
        "../internals/native-symbol": 38,
        "../internals/shared": 59,
        "../internals/uid": 67,
        "../internals/use-symbol-as-uid": 68
    } ],
    71: [ function(require, module, exports) {
        "use strict";
        var $ = require("../internals/export");
        var toAbsoluteIndex = require("../internals/to-absolute-index");
        var toInteger = require("../internals/to-integer");
        var toLength = require("../internals/to-length");
        var toObject = require("../internals/to-object");
        var arraySpeciesCreate = require("../internals/array-species-create");
        var createProperty = require("../internals/create-property");
        var arrayMethodHasSpeciesSupport = require("../internals/array-method-has-species-support");
        var HAS_SPECIES_SUPPORT = arrayMethodHasSpeciesSupport("splice");
        var max = Math.max;
        var min = Math.min;
        var MAX_SAFE_INTEGER = 9007199254740991;
        var MAXIMUM_ALLOWED_LENGTH_EXCEEDED = "Maximum allowed length exceeded";
        $({
            target: "Array",
            proto: true,
            forced: !HAS_SPECIES_SUPPORT
        }, {
            splice: function splice(start, deleteCount) {
                var O = toObject(this);
                var len = toLength(O.length);
                var actualStart = toAbsoluteIndex(start, len);
                var argumentsLength = arguments.length;
                var insertCount, actualDeleteCount, A, k, from, to;
                if (argumentsLength === 0) {
                    insertCount = actualDeleteCount = 0;
                } else if (argumentsLength === 1) {
                    insertCount = 0;
                    actualDeleteCount = len - actualStart;
                } else {
                    insertCount = argumentsLength - 2;
                    actualDeleteCount = min(max(toInteger(deleteCount), 0), len - actualStart);
                }
                if (len + insertCount - actualDeleteCount > MAX_SAFE_INTEGER) {
                    throw TypeError(MAXIMUM_ALLOWED_LENGTH_EXCEEDED);
                }
                A = arraySpeciesCreate(O, actualDeleteCount);
                for (k = 0; k < actualDeleteCount; k++) {
                    from = actualStart + k;
                    if (from in O) createProperty(A, k, O[from]);
                }
                A.length = actualDeleteCount;
                if (insertCount < actualDeleteCount) {
                    for (k = actualStart; k < len - actualDeleteCount; k++) {
                        from = k + actualDeleteCount;
                        to = k + insertCount;
                        if (from in O) O[to] = O[from]; else delete O[to];
                    }
                    for (k = len; k > len - actualDeleteCount + insertCount; k--) delete O[k - 1];
                } else if (insertCount > actualDeleteCount) {
                    for (k = len - actualDeleteCount; k > actualStart; k--) {
                        from = k + actualDeleteCount - 1;
                        to = k + insertCount - 1;
                        if (from in O) O[to] = O[from]; else delete O[to];
                    }
                }
                for (k = 0; k < insertCount; k++) {
                    O[k + actualStart] = arguments[k + 2];
                }
                O.length = len - actualDeleteCount + insertCount;
                return A;
            }
        });
    }, {
        "../internals/array-method-has-species-support": 5,
        "../internals/array-species-create": 6,
        "../internals/create-property": 12,
        "../internals/export": 21,
        "../internals/to-absolute-index": 60,
        "../internals/to-integer": 62,
        "../internals/to-length": 63,
        "../internals/to-object": 64
    } ],
    72: [ function(require, module, exports) {
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        var dateToPrimitive = require("../internals/date-to-primitive");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var TO_PRIMITIVE = wellKnownSymbol("toPrimitive");
        var DatePrototype = Date.prototype;
        if (!(TO_PRIMITIVE in DatePrototype)) {
            createNonEnumerableProperty(DatePrototype, TO_PRIMITIVE, dateToPrimitive);
        }
    }, {
        "../internals/create-non-enumerable-property": 10,
        "../internals/date-to-primitive": 13,
        "../internals/well-known-symbol": 70
    } ],
    73: [ function(require, module, exports) {
        var TO_STRING_TAG_SUPPORT = require("../internals/to-string-tag-support");
        var redefine = require("../internals/redefine");
        var toString = require("../internals/object-to-string");
        if (!TO_STRING_TAG_SUPPORT) {
            redefine(Object.prototype, "toString", toString, {
                unsafe: true
            });
        }
    }, {
        "../internals/object-to-string": 50,
        "../internals/redefine": 53,
        "../internals/to-string-tag-support": 66
    } ],
    74: [ function(require, module, exports) {
        var $ = require("../internals/export");
        var getBuiltIn = require("../internals/get-built-in");
        var aFunction = require("../internals/a-function");
        var anObject = require("../internals/an-object");
        var isObject = require("../internals/is-object");
        var create = require("../internals/object-create");
        var bind = require("../internals/function-bind");
        var fails = require("../internals/fails");
        var nativeConstruct = getBuiltIn("Reflect", "construct");
        var NEW_TARGET_BUG = fails(function() {
            function F() {}
            return !(nativeConstruct(function() {}, [], F) instanceof F);
        });
        var ARGS_BUG = !fails(function() {
            nativeConstruct(function() {});
        });
        var FORCED = NEW_TARGET_BUG || ARGS_BUG;
        $({
            target: "Reflect",
            stat: true,
            forced: FORCED,
            sham: FORCED
        }, {
            construct: function construct(Target, args) {
                aFunction(Target);
                anObject(args);
                var newTarget = arguments.length < 3 ? Target : aFunction(arguments[2]);
                if (ARGS_BUG && !NEW_TARGET_BUG) return nativeConstruct(Target, args, newTarget);
                if (Target == newTarget) {
                    switch (args.length) {
                      case 0:
                        return new Target();

                      case 1:
                        return new Target(args[0]);

                      case 2:
                        return new Target(args[0], args[1]);

                      case 3:
                        return new Target(args[0], args[1], args[2]);

                      case 4:
                        return new Target(args[0], args[1], args[2], args[3]);
                    }
                    var $args = [ null ];
                    $args.push.apply($args, args);
                    return new (bind.apply(Target, $args))();
                }
                var proto = newTarget.prototype;
                var instance = create(isObject(proto) ? proto : Object.prototype);
                var result = Function.apply.call(Target, instance, args);
                return isObject(result) ? result : instance;
            }
        });
    }, {
        "../internals/a-function": 1,
        "../internals/an-object": 2,
        "../internals/export": 21,
        "../internals/fails": 22,
        "../internals/function-bind": 24,
        "../internals/get-built-in": 25,
        "../internals/is-object": 36,
        "../internals/object-create": 40
    } ],
    75: [ function(require, module, exports) {
        "use strict";
        var $ = require("../internals/export");
        var DESCRIPTORS = require("../internals/descriptors");
        var global = require("../internals/global");
        var has = require("../internals/has");
        var isObject = require("../internals/is-object");
        var defineProperty = require("../internals/object-define-property").f;
        var copyConstructorProperties = require("../internals/copy-constructor-properties");
        var NativeSymbol = global.Symbol;
        if (DESCRIPTORS && typeof NativeSymbol == "function" && (!("description" in NativeSymbol.prototype) || NativeSymbol().description !== undefined)) {
            var EmptyStringDescriptionStore = {};
            var SymbolWrapper = function Symbol() {
                var description = arguments.length < 1 || arguments[0] === undefined ? undefined : String(arguments[0]);
                var result = this instanceof SymbolWrapper ? new NativeSymbol(description) : description === undefined ? NativeSymbol() : NativeSymbol(description);
                if (description === "") EmptyStringDescriptionStore[result] = true;
                return result;
            };
            copyConstructorProperties(SymbolWrapper, NativeSymbol);
            var symbolPrototype = SymbolWrapper.prototype = NativeSymbol.prototype;
            symbolPrototype.constructor = SymbolWrapper;
            var symbolToString = symbolPrototype.toString;
            var native = String(NativeSymbol("test")) == "Symbol(test)";
            var regexp = /^Symbol\((.*)\)[^)]+$/;
            defineProperty(symbolPrototype, "description", {
                configurable: true,
                get: function description() {
                    var symbol = isObject(this) ? this.valueOf() : this;
                    var string = symbolToString.call(symbol);
                    if (has(EmptyStringDescriptionStore, symbol)) return "";
                    var desc = native ? string.slice(7, -1) : string.replace(regexp, "$1");
                    return desc === "" ? undefined : desc;
                }
            });
            $({
                global: true,
                forced: true
            }, {
                Symbol: SymbolWrapper
            });
        }
    }, {
        "../internals/copy-constructor-properties": 9,
        "../internals/descriptors": 15,
        "../internals/export": 21,
        "../internals/global": 26,
        "../internals/has": 27,
        "../internals/is-object": 36,
        "../internals/object-define-property": 42
    } ],
    76: [ function(require, module, exports) {
        "use strict";
        var $ = require("../internals/export");
        var global = require("../internals/global");
        var getBuiltIn = require("../internals/get-built-in");
        var IS_PURE = require("../internals/is-pure");
        var DESCRIPTORS = require("../internals/descriptors");
        var NATIVE_SYMBOL = require("../internals/native-symbol");
        var USE_SYMBOL_AS_UID = require("../internals/use-symbol-as-uid");
        var fails = require("../internals/fails");
        var has = require("../internals/has");
        var isArray = require("../internals/is-array");
        var isObject = require("../internals/is-object");
        var anObject = require("../internals/an-object");
        var toObject = require("../internals/to-object");
        var toIndexedObject = require("../internals/to-indexed-object");
        var toPrimitive = require("../internals/to-primitive");
        var createPropertyDescriptor = require("../internals/create-property-descriptor");
        var nativeObjectCreate = require("../internals/object-create");
        var objectKeys = require("../internals/object-keys");
        var getOwnPropertyNamesModule = require("../internals/object-get-own-property-names");
        var getOwnPropertyNamesExternal = require("../internals/object-get-own-property-names-external");
        var getOwnPropertySymbolsModule = require("../internals/object-get-own-property-symbols");
        var getOwnPropertyDescriptorModule = require("../internals/object-get-own-property-descriptor");
        var definePropertyModule = require("../internals/object-define-property");
        var propertyIsEnumerableModule = require("../internals/object-property-is-enumerable");
        var createNonEnumerableProperty = require("../internals/create-non-enumerable-property");
        var redefine = require("../internals/redefine");
        var shared = require("../internals/shared");
        var sharedKey = require("../internals/shared-key");
        var hiddenKeys = require("../internals/hidden-keys");
        var uid = require("../internals/uid");
        var wellKnownSymbol = require("../internals/well-known-symbol");
        var wrappedWellKnownSymbolModule = require("../internals/well-known-symbol-wrapped");
        var defineWellKnownSymbol = require("../internals/define-well-known-symbol");
        var setToStringTag = require("../internals/set-to-string-tag");
        var InternalStateModule = require("../internals/internal-state");
        var $forEach = require("../internals/array-iteration").forEach;
        var HIDDEN = sharedKey("hidden");
        var SYMBOL = "Symbol";
        var PROTOTYPE = "prototype";
        var TO_PRIMITIVE = wellKnownSymbol("toPrimitive");
        var setInternalState = InternalStateModule.set;
        var getInternalState = InternalStateModule.getterFor(SYMBOL);
        var ObjectPrototype = Object[PROTOTYPE];
        var $Symbol = global.Symbol;
        var $stringify = getBuiltIn("JSON", "stringify");
        var nativeGetOwnPropertyDescriptor = getOwnPropertyDescriptorModule.f;
        var nativeDefineProperty = definePropertyModule.f;
        var nativeGetOwnPropertyNames = getOwnPropertyNamesExternal.f;
        var nativePropertyIsEnumerable = propertyIsEnumerableModule.f;
        var AllSymbols = shared("symbols");
        var ObjectPrototypeSymbols = shared("op-symbols");
        var StringToSymbolRegistry = shared("string-to-symbol-registry");
        var SymbolToStringRegistry = shared("symbol-to-string-registry");
        var WellKnownSymbolsStore = shared("wks");
        var QObject = global.QObject;
        var USE_SETTER = !QObject || !QObject[PROTOTYPE] || !QObject[PROTOTYPE].findChild;
        var setSymbolDescriptor = DESCRIPTORS && fails(function() {
            return nativeObjectCreate(nativeDefineProperty({}, "a", {
                get: function() {
                    return nativeDefineProperty(this, "a", {
                        value: 7
                    }).a;
                }
            })).a != 7;
        }) ? function(O, P, Attributes) {
            var ObjectPrototypeDescriptor = nativeGetOwnPropertyDescriptor(ObjectPrototype, P);
            if (ObjectPrototypeDescriptor) delete ObjectPrototype[P];
            nativeDefineProperty(O, P, Attributes);
            if (ObjectPrototypeDescriptor && O !== ObjectPrototype) {
                nativeDefineProperty(ObjectPrototype, P, ObjectPrototypeDescriptor);
            }
        } : nativeDefineProperty;
        var wrap = function(tag, description) {
            var symbol = AllSymbols[tag] = nativeObjectCreate($Symbol[PROTOTYPE]);
            setInternalState(symbol, {
                type: SYMBOL,
                tag: tag,
                description: description
            });
            if (!DESCRIPTORS) symbol.description = description;
            return symbol;
        };
        var isSymbol = USE_SYMBOL_AS_UID ? function(it) {
            return typeof it == "symbol";
        } : function(it) {
            return Object(it) instanceof $Symbol;
        };
        var $defineProperty = function defineProperty(O, P, Attributes) {
            if (O === ObjectPrototype) $defineProperty(ObjectPrototypeSymbols, P, Attributes);
            anObject(O);
            var key = toPrimitive(P, true);
            anObject(Attributes);
            if (has(AllSymbols, key)) {
                if (!Attributes.enumerable) {
                    if (!has(O, HIDDEN)) nativeDefineProperty(O, HIDDEN, createPropertyDescriptor(1, {}));
                    O[HIDDEN][key] = true;
                } else {
                    if (has(O, HIDDEN) && O[HIDDEN][key]) O[HIDDEN][key] = false;
                    Attributes = nativeObjectCreate(Attributes, {
                        enumerable: createPropertyDescriptor(0, false)
                    });
                }
                return setSymbolDescriptor(O, key, Attributes);
            }
            return nativeDefineProperty(O, key, Attributes);
        };
        var $defineProperties = function defineProperties(O, Properties) {
            anObject(O);
            var properties = toIndexedObject(Properties);
            var keys = objectKeys(properties).concat($getOwnPropertySymbols(properties));
            $forEach(keys, function(key) {
                if (!DESCRIPTORS || $propertyIsEnumerable.call(properties, key)) $defineProperty(O, key, properties[key]);
            });
            return O;
        };
        var $create = function create(O, Properties) {
            return Properties === undefined ? nativeObjectCreate(O) : $defineProperties(nativeObjectCreate(O), Properties);
        };
        var $propertyIsEnumerable = function propertyIsEnumerable(V) {
            var P = toPrimitive(V, true);
            var enumerable = nativePropertyIsEnumerable.call(this, P);
            if (this === ObjectPrototype && has(AllSymbols, P) && !has(ObjectPrototypeSymbols, P)) return false;
            return enumerable || !has(this, P) || !has(AllSymbols, P) || has(this, HIDDEN) && this[HIDDEN][P] ? enumerable : true;
        };
        var $getOwnPropertyDescriptor = function getOwnPropertyDescriptor(O, P) {
            var it = toIndexedObject(O);
            var key = toPrimitive(P, true);
            if (it === ObjectPrototype && has(AllSymbols, key) && !has(ObjectPrototypeSymbols, key)) return;
            var descriptor = nativeGetOwnPropertyDescriptor(it, key);
            if (descriptor && has(AllSymbols, key) && !(has(it, HIDDEN) && it[HIDDEN][key])) {
                descriptor.enumerable = true;
            }
            return descriptor;
        };
        var $getOwnPropertyNames = function getOwnPropertyNames(O) {
            var names = nativeGetOwnPropertyNames(toIndexedObject(O));
            var result = [];
            $forEach(names, function(key) {
                if (!has(AllSymbols, key) && !has(hiddenKeys, key)) result.push(key);
            });
            return result;
        };
        var $getOwnPropertySymbols = function getOwnPropertySymbols(O) {
            var IS_OBJECT_PROTOTYPE = O === ObjectPrototype;
            var names = nativeGetOwnPropertyNames(IS_OBJECT_PROTOTYPE ? ObjectPrototypeSymbols : toIndexedObject(O));
            var result = [];
            $forEach(names, function(key) {
                if (has(AllSymbols, key) && (!IS_OBJECT_PROTOTYPE || has(ObjectPrototype, key))) {
                    result.push(AllSymbols[key]);
                }
            });
            return result;
        };
        if (!NATIVE_SYMBOL) {
            $Symbol = function Symbol() {
                if (this instanceof $Symbol) throw TypeError("Symbol is not a constructor");
                var description = !arguments.length || arguments[0] === undefined ? undefined : String(arguments[0]);
                var tag = uid(description);
                var setter = function(value) {
                    if (this === ObjectPrototype) setter.call(ObjectPrototypeSymbols, value);
                    if (has(this, HIDDEN) && has(this[HIDDEN], tag)) this[HIDDEN][tag] = false;
                    setSymbolDescriptor(this, tag, createPropertyDescriptor(1, value));
                };
                if (DESCRIPTORS && USE_SETTER) setSymbolDescriptor(ObjectPrototype, tag, {
                    configurable: true,
                    set: setter
                });
                return wrap(tag, description);
            };
            redefine($Symbol[PROTOTYPE], "toString", function toString() {
                return getInternalState(this).tag;
            });
            redefine($Symbol, "withoutSetter", function(description) {
                return wrap(uid(description), description);
            });
            propertyIsEnumerableModule.f = $propertyIsEnumerable;
            definePropertyModule.f = $defineProperty;
            getOwnPropertyDescriptorModule.f = $getOwnPropertyDescriptor;
            getOwnPropertyNamesModule.f = getOwnPropertyNamesExternal.f = $getOwnPropertyNames;
            getOwnPropertySymbolsModule.f = $getOwnPropertySymbols;
            wrappedWellKnownSymbolModule.f = function(name) {
                return wrap(wellKnownSymbol(name), name);
            };
            if (DESCRIPTORS) {
                nativeDefineProperty($Symbol[PROTOTYPE], "description", {
                    configurable: true,
                    get: function description() {
                        return getInternalState(this).description;
                    }
                });
                if (!IS_PURE) {
                    redefine(ObjectPrototype, "propertyIsEnumerable", $propertyIsEnumerable, {
                        unsafe: true
                    });
                }
            }
        }
        $({
            global: true,
            wrap: true,
            forced: !NATIVE_SYMBOL,
            sham: !NATIVE_SYMBOL
        }, {
            Symbol: $Symbol
        });
        $forEach(objectKeys(WellKnownSymbolsStore), function(name) {
            defineWellKnownSymbol(name);
        });
        $({
            target: SYMBOL,
            stat: true,
            forced: !NATIVE_SYMBOL
        }, {
            for: function(key) {
                var string = String(key);
                if (has(StringToSymbolRegistry, string)) return StringToSymbolRegistry[string];
                var symbol = $Symbol(string);
                StringToSymbolRegistry[string] = symbol;
                SymbolToStringRegistry[symbol] = string;
                return symbol;
            },
            keyFor: function keyFor(sym) {
                if (!isSymbol(sym)) throw TypeError(sym + " is not a symbol");
                if (has(SymbolToStringRegistry, sym)) return SymbolToStringRegistry[sym];
            },
            useSetter: function() {
                USE_SETTER = true;
            },
            useSimple: function() {
                USE_SETTER = false;
            }
        });
        $({
            target: "Object",
            stat: true,
            forced: !NATIVE_SYMBOL,
            sham: !DESCRIPTORS
        }, {
            create: $create,
            defineProperty: $defineProperty,
            defineProperties: $defineProperties,
            getOwnPropertyDescriptor: $getOwnPropertyDescriptor
        });
        $({
            target: "Object",
            stat: true,
            forced: !NATIVE_SYMBOL
        }, {
            getOwnPropertyNames: $getOwnPropertyNames,
            getOwnPropertySymbols: $getOwnPropertySymbols
        });
        $({
            target: "Object",
            stat: true,
            forced: fails(function() {
                getOwnPropertySymbolsModule.f(1);
            })
        }, {
            getOwnPropertySymbols: function getOwnPropertySymbols(it) {
                return getOwnPropertySymbolsModule.f(toObject(it));
            }
        });
        if ($stringify) {
            var FORCED_JSON_STRINGIFY = !NATIVE_SYMBOL || fails(function() {
                var symbol = $Symbol();
                return $stringify([ symbol ]) != "[null]" || $stringify({
                    a: symbol
                }) != "{}" || $stringify(Object(symbol)) != "{}";
            });
            $({
                target: "JSON",
                stat: true,
                forced: FORCED_JSON_STRINGIFY
            }, {
                stringify: function stringify(it, replacer, space) {
                    var args = [ it ];
                    var index = 1;
                    var $replacer;
                    while (arguments.length > index) args.push(arguments[index++]);
                    $replacer = replacer;
                    if (!isObject(replacer) && it === undefined || isSymbol(it)) return;
                    if (!isArray(replacer)) replacer = function(key, value) {
                        if (typeof $replacer == "function") value = $replacer.call(this, key, value);
                        if (!isSymbol(value)) return value;
                    };
                    args[1] = replacer;
                    return $stringify.apply(null, args);
                }
            });
        }
        if (!$Symbol[PROTOTYPE][TO_PRIMITIVE]) {
            createNonEnumerableProperty($Symbol[PROTOTYPE], TO_PRIMITIVE, $Symbol[PROTOTYPE].valueOf);
        }
        setToStringTag($Symbol, SYMBOL);
        hiddenKeys[HIDDEN] = true;
    }, {
        "../internals/an-object": 2,
        "../internals/array-iteration": 4,
        "../internals/create-non-enumerable-property": 10,
        "../internals/create-property-descriptor": 11,
        "../internals/define-well-known-symbol": 14,
        "../internals/descriptors": 15,
        "../internals/export": 21,
        "../internals/fails": 22,
        "../internals/get-built-in": 25,
        "../internals/global": 26,
        "../internals/has": 27,
        "../internals/hidden-keys": 28,
        "../internals/internal-state": 33,
        "../internals/is-array": 34,
        "../internals/is-object": 36,
        "../internals/is-pure": 37,
        "../internals/native-symbol": 38,
        "../internals/object-create": 40,
        "../internals/object-define-property": 42,
        "../internals/object-get-own-property-descriptor": 43,
        "../internals/object-get-own-property-names": 45,
        "../internals/object-get-own-property-names-external": 44,
        "../internals/object-get-own-property-symbols": 46,
        "../internals/object-keys": 48,
        "../internals/object-property-is-enumerable": 49,
        "../internals/redefine": 53,
        "../internals/set-to-string-tag": 56,
        "../internals/shared": 59,
        "../internals/shared-key": 57,
        "../internals/to-indexed-object": 61,
        "../internals/to-object": 64,
        "../internals/to-primitive": 65,
        "../internals/uid": 67,
        "../internals/use-symbol-as-uid": 68,
        "../internals/well-known-symbol": 70,
        "../internals/well-known-symbol-wrapped": 69
    } ],
    77: [ function(require, module, exports) {
        var defineWellKnownSymbol = require("../internals/define-well-known-symbol");
        defineWellKnownSymbol("toPrimitive");
    }, {
        "../internals/define-well-known-symbol": 14
    } ],
    78: [ function(require, module, exports) {
        (function() {
            window.WebComponents = window.WebComponents || {
                flags: {}
            };
            var file = "webcomponents-lite.js";
            var script = document.querySelector('script[src*="' + file + '"]');
            var flags = {};
            if (!flags.noOpts) {
                location.search.slice(1).split("&").forEach(function(option) {
                    var parts = option.split("=");
                    var match;
                    if (parts[0] && (match = parts[0].match(/wc-(.+)/))) {
                        flags[match[1]] = parts[1] || true;
                    }
                });
                if (script) {
                    for (var i = 0, a; a = script.attributes[i]; i++) {
                        if (a.name !== "src") {
                            flags[a.name] = a.value || true;
                        }
                    }
                }
                if (flags.log && flags.log.split) {
                    var parts = flags.log.split(",");
                    flags.log = {};
                    parts.forEach(function(f) {
                        flags.log[f] = true;
                    });
                } else {
                    flags.log = {};
                }
            }
            if (flags.register) {
                window.CustomElements = window.CustomElements || {
                    flags: {}
                };
                window.CustomElements.flags.register = flags.register;
            }
            WebComponents.flags = flags;
        })();
        (function(scope) {
            "use strict";
            var hasWorkingUrl = false;
            if (!scope.forceJURL) {
                try {
                    var u = new URL("b", "http://a");
                    u.pathname = "c%20d";
                    hasWorkingUrl = u.href === "http://a/c%20d";
                } catch (e) {}
            }
            if (hasWorkingUrl) return;
            var relative = Object.create(null);
            relative["ftp"] = 21;
            relative["file"] = 0;
            relative["gopher"] = 70;
            relative["http"] = 80;
            relative["https"] = 443;
            relative["ws"] = 80;
            relative["wss"] = 443;
            var relativePathDotMapping = Object.create(null);
            relativePathDotMapping["%2e"] = ".";
            relativePathDotMapping[".%2e"] = "..";
            relativePathDotMapping["%2e."] = "..";
            relativePathDotMapping["%2e%2e"] = "..";
            function isRelativeScheme(scheme) {
                return relative[scheme] !== undefined;
            }
            function invalid() {
                clear.call(this);
                this._isInvalid = true;
            }
            function IDNAToASCII(h) {
                if ("" == h) {
                    invalid.call(this);
                }
                return h.toLowerCase();
            }
            function percentEscape(c) {
                var unicode = c.charCodeAt(0);
                if (unicode > 32 && unicode < 127 && [ 34, 35, 60, 62, 63, 96 ].indexOf(unicode) == -1) {
                    return c;
                }
                return encodeURIComponent(c);
            }
            function percentEscapeQuery(c) {
                var unicode = c.charCodeAt(0);
                if (unicode > 32 && unicode < 127 && [ 34, 35, 60, 62, 96 ].indexOf(unicode) == -1) {
                    return c;
                }
                return encodeURIComponent(c);
            }
            var EOF = undefined, ALPHA = /[a-zA-Z]/, ALPHANUMERIC = /[a-zA-Z0-9\+\-\.]/;
            function parse(input, stateOverride, base) {
                function err(message) {
                    errors.push(message);
                }
                var state = stateOverride || "scheme start", cursor = 0, buffer = "", seenAt = false, seenBracket = false, errors = [];
                loop: while ((input[cursor - 1] != EOF || cursor == 0) && !this._isInvalid) {
                    var c = input[cursor];
                    switch (state) {
                      case "scheme start":
                        if (c && ALPHA.test(c)) {
                            buffer += c.toLowerCase();
                            state = "scheme";
                        } else if (!stateOverride) {
                            buffer = "";
                            state = "no scheme";
                            continue;
                        } else {
                            err("Invalid scheme.");
                            break loop;
                        }
                        break;

                      case "scheme":
                        if (c && ALPHANUMERIC.test(c)) {
                            buffer += c.toLowerCase();
                        } else if (":" == c) {
                            this._scheme = buffer;
                            buffer = "";
                            if (stateOverride) {
                                break loop;
                            }
                            if (isRelativeScheme(this._scheme)) {
                                this._isRelative = true;
                            }
                            if ("file" == this._scheme) {
                                state = "relative";
                            } else if (this._isRelative && base && base._scheme == this._scheme) {
                                state = "relative or authority";
                            } else if (this._isRelative) {
                                state = "authority first slash";
                            } else {
                                state = "scheme data";
                            }
                        } else if (!stateOverride) {
                            buffer = "";
                            cursor = 0;
                            state = "no scheme";
                            continue;
                        } else if (EOF == c) {
                            break loop;
                        } else {
                            err("Code point not allowed in scheme: " + c);
                            break loop;
                        }
                        break;

                      case "scheme data":
                        if ("?" == c) {
                            this._query = "?";
                            state = "query";
                        } else if ("#" == c) {
                            this._fragment = "#";
                            state = "fragment";
                        } else {
                            if (EOF != c && "\t" != c && "\n" != c && "\r" != c) {
                                this._schemeData += percentEscape(c);
                            }
                        }
                        break;

                      case "no scheme":
                        if (!base || !isRelativeScheme(base._scheme)) {
                            err("Missing scheme.");
                            invalid.call(this);
                        } else {
                            state = "relative";
                            continue;
                        }
                        break;

                      case "relative or authority":
                        if ("/" == c && "/" == input[cursor + 1]) {
                            state = "authority ignore slashes";
                        } else {
                            err("Expected /, got: " + c);
                            state = "relative";
                            continue;
                        }
                        break;

                      case "relative":
                        this._isRelative = true;
                        if ("file" != this._scheme) this._scheme = base._scheme;
                        if (EOF == c) {
                            this._host = base._host;
                            this._port = base._port;
                            this._path = base._path.slice();
                            this._query = base._query;
                            this._username = base._username;
                            this._password = base._password;
                            break loop;
                        } else if ("/" == c || "\\" == c) {
                            if ("\\" == c) err("\\ is an invalid code point.");
                            state = "relative slash";
                        } else if ("?" == c) {
                            this._host = base._host;
                            this._port = base._port;
                            this._path = base._path.slice();
                            this._query = "?";
                            this._username = base._username;
                            this._password = base._password;
                            state = "query";
                        } else if ("#" == c) {
                            this._host = base._host;
                            this._port = base._port;
                            this._path = base._path.slice();
                            this._query = base._query;
                            this._fragment = "#";
                            this._username = base._username;
                            this._password = base._password;
                            state = "fragment";
                        } else {
                            var nextC = input[cursor + 1];
                            var nextNextC = input[cursor + 2];
                            if ("file" != this._scheme || !ALPHA.test(c) || nextC != ":" && nextC != "|" || EOF != nextNextC && "/" != nextNextC && "\\" != nextNextC && "?" != nextNextC && "#" != nextNextC) {
                                this._host = base._host;
                                this._port = base._port;
                                this._username = base._username;
                                this._password = base._password;
                                this._path = base._path.slice();
                                this._path.pop();
                            }
                            state = "relative path";
                            continue;
                        }
                        break;

                      case "relative slash":
                        if ("/" == c || "\\" == c) {
                            if ("\\" == c) {
                                err("\\ is an invalid code point.");
                            }
                            if ("file" == this._scheme) {
                                state = "file host";
                            } else {
                                state = "authority ignore slashes";
                            }
                        } else {
                            if ("file" != this._scheme) {
                                this._host = base._host;
                                this._port = base._port;
                                this._username = base._username;
                                this._password = base._password;
                            }
                            state = "relative path";
                            continue;
                        }
                        break;

                      case "authority first slash":
                        if ("/" == c) {
                            state = "authority second slash";
                        } else {
                            err("Expected '/', got: " + c);
                            state = "authority ignore slashes";
                            continue;
                        }
                        break;

                      case "authority second slash":
                        state = "authority ignore slashes";
                        if ("/" != c) {
                            err("Expected '/', got: " + c);
                            continue;
                        }
                        break;

                      case "authority ignore slashes":
                        if ("/" != c && "\\" != c) {
                            state = "authority";
                            continue;
                        } else {
                            err("Expected authority, got: " + c);
                        }
                        break;

                      case "authority":
                        if ("@" == c) {
                            if (seenAt) {
                                err("@ already seen.");
                                buffer += "%40";
                            }
                            seenAt = true;
                            for (var i = 0; i < buffer.length; i++) {
                                var cp = buffer[i];
                                if ("\t" == cp || "\n" == cp || "\r" == cp) {
                                    err("Invalid whitespace in authority.");
                                    continue;
                                }
                                if (":" == cp && null === this._password) {
                                    this._password = "";
                                    continue;
                                }
                                var tempC = percentEscape(cp);
                                null !== this._password ? this._password += tempC : this._username += tempC;
                            }
                            buffer = "";
                        } else if (EOF == c || "/" == c || "\\" == c || "?" == c || "#" == c) {
                            cursor -= buffer.length;
                            buffer = "";
                            state = "host";
                            continue;
                        } else {
                            buffer += c;
                        }
                        break;

                      case "file host":
                        if (EOF == c || "/" == c || "\\" == c || "?" == c || "#" == c) {
                            if (buffer.length == 2 && ALPHA.test(buffer[0]) && (buffer[1] == ":" || buffer[1] == "|")) {
                                state = "relative path";
                            } else if (buffer.length == 0) {
                                state = "relative path start";
                            } else {
                                this._host = IDNAToASCII.call(this, buffer);
                                buffer = "";
                                state = "relative path start";
                            }
                            continue;
                        } else if ("\t" == c || "\n" == c || "\r" == c) {
                            err("Invalid whitespace in file host.");
                        } else {
                            buffer += c;
                        }
                        break;

                      case "host":
                      case "hostname":
                        if (":" == c && !seenBracket) {
                            this._host = IDNAToASCII.call(this, buffer);
                            buffer = "";
                            state = "port";
                            if ("hostname" == stateOverride) {
                                break loop;
                            }
                        } else if (EOF == c || "/" == c || "\\" == c || "?" == c || "#" == c) {
                            this._host = IDNAToASCII.call(this, buffer);
                            buffer = "";
                            state = "relative path start";
                            if (stateOverride) {
                                break loop;
                            }
                            continue;
                        } else if ("\t" != c && "\n" != c && "\r" != c) {
                            if ("[" == c) {
                                seenBracket = true;
                            } else if ("]" == c) {
                                seenBracket = false;
                            }
                            buffer += c;
                        } else {
                            err("Invalid code point in host/hostname: " + c);
                        }
                        break;

                      case "port":
                        if (/[0-9]/.test(c)) {
                            buffer += c;
                        } else if (EOF == c || "/" == c || "\\" == c || "?" == c || "#" == c || stateOverride) {
                            if ("" != buffer) {
                                var temp = parseInt(buffer, 10);
                                if (temp != relative[this._scheme]) {
                                    this._port = temp + "";
                                }
                                buffer = "";
                            }
                            if (stateOverride) {
                                break loop;
                            }
                            state = "relative path start";
                            continue;
                        } else if ("\t" == c || "\n" == c || "\r" == c) {
                            err("Invalid code point in port: " + c);
                        } else {
                            invalid.call(this);
                        }
                        break;

                      case "relative path start":
                        if ("\\" == c) err("'\\' not allowed in path.");
                        state = "relative path";
                        if ("/" != c && "\\" != c) {
                            continue;
                        }
                        break;

                      case "relative path":
                        if (EOF == c || "/" == c || "\\" == c || !stateOverride && ("?" == c || "#" == c)) {
                            if ("\\" == c) {
                                err("\\ not allowed in relative path.");
                            }
                            var tmp;
                            if (tmp = relativePathDotMapping[buffer.toLowerCase()]) {
                                buffer = tmp;
                            }
                            if (".." == buffer) {
                                this._path.pop();
                                if ("/" != c && "\\" != c) {
                                    this._path.push("");
                                }
                            } else if ("." == buffer && "/" != c && "\\" != c) {
                                this._path.push("");
                            } else if ("." != buffer) {
                                if ("file" == this._scheme && this._path.length == 0 && buffer.length == 2 && ALPHA.test(buffer[0]) && buffer[1] == "|") {
                                    buffer = buffer[0] + ":";
                                }
                                this._path.push(buffer);
                            }
                            buffer = "";
                            if ("?" == c) {
                                this._query = "?";
                                state = "query";
                            } else if ("#" == c) {
                                this._fragment = "#";
                                state = "fragment";
                            }
                        } else if ("\t" != c && "\n" != c && "\r" != c) {
                            buffer += percentEscape(c);
                        }
                        break;

                      case "query":
                        if (!stateOverride && "#" == c) {
                            this._fragment = "#";
                            state = "fragment";
                        } else if (EOF != c && "\t" != c && "\n" != c && "\r" != c) {
                            this._query += percentEscapeQuery(c);
                        }
                        break;

                      case "fragment":
                        if (EOF != c && "\t" != c && "\n" != c && "\r" != c) {
                            this._fragment += c;
                        }
                        break;
                    }
                    cursor++;
                }
            }
            function clear() {
                this._scheme = "";
                this._schemeData = "";
                this._username = "";
                this._password = null;
                this._host = "";
                this._port = "";
                this._path = [];
                this._query = "";
                this._fragment = "";
                this._isInvalid = false;
                this._isRelative = false;
            }
            function jURL(url, base) {
                if (base !== undefined && !(base instanceof jURL)) base = new jURL(String(base));
                this._url = url;
                clear.call(this);
                var input = url.replace(/^[ \t\r\n\f]+|[ \t\r\n\f]+$/g, "");
                parse.call(this, input, null, base);
            }
            jURL.prototype = {
                toString: function() {
                    return this.href;
                },
                get href() {
                    if (this._isInvalid) return this._url;
                    var authority = "";
                    if ("" != this._username || null != this._password) {
                        authority = this._username + (null != this._password ? ":" + this._password : "") + "@";
                    }
                    return this.protocol + (this._isRelative ? "//" + authority + this.host : "") + this.pathname + this._query + this._fragment;
                },
                set href(href) {
                    clear.call(this);
                    parse.call(this, href);
                },
                get protocol() {
                    return this._scheme + ":";
                },
                set protocol(protocol) {
                    if (this._isInvalid) return;
                    parse.call(this, protocol + ":", "scheme start");
                },
                get host() {
                    return this._isInvalid ? "" : this._port ? this._host + ":" + this._port : this._host;
                },
                set host(host) {
                    if (this._isInvalid || !this._isRelative) return;
                    parse.call(this, host, "host");
                },
                get hostname() {
                    return this._host;
                },
                set hostname(hostname) {
                    if (this._isInvalid || !this._isRelative) return;
                    parse.call(this, hostname, "hostname");
                },
                get port() {
                    return this._port;
                },
                set port(port) {
                    if (this._isInvalid || !this._isRelative) return;
                    parse.call(this, port, "port");
                },
                get pathname() {
                    return this._isInvalid ? "" : this._isRelative ? "/" + this._path.join("/") : this._schemeData;
                },
                set pathname(pathname) {
                    if (this._isInvalid || !this._isRelative) return;
                    this._path = [];
                    parse.call(this, pathname, "relative path start");
                },
                get search() {
                    return this._isInvalid || !this._query || "?" == this._query ? "" : this._query;
                },
                set search(search) {
                    if (this._isInvalid || !this._isRelative) return;
                    this._query = "?";
                    if ("?" == search[0]) search = search.slice(1);
                    parse.call(this, search, "query");
                },
                get hash() {
                    return this._isInvalid || !this._fragment || "#" == this._fragment ? "" : this._fragment;
                },
                set hash(hash) {
                    if (this._isInvalid) return;
                    this._fragment = "#";
                    if ("#" == hash[0]) hash = hash.slice(1);
                    parse.call(this, hash, "fragment");
                },
                get origin() {
                    var host;
                    if (this._isInvalid || !this._scheme) {
                        return "";
                    }
                    switch (this._scheme) {
                      case "data":
                      case "file":
                      case "javascript":
                      case "mailto":
                        return "null";
                    }
                    host = this.host;
                    if (!host) {
                        return "";
                    }
                    return this._scheme + "://" + host;
                }
            };
            var OriginalURL = scope.URL;
            if (OriginalURL) {
                jURL.createObjectURL = function(blob) {
                    return OriginalURL.createObjectURL.apply(OriginalURL, arguments);
                };
                jURL.revokeObjectURL = function(url) {
                    OriginalURL.revokeObjectURL(url);
                };
            }
            scope.URL = jURL;
        })(self);
        if (typeof WeakMap === "undefined") {
            (function() {
                var defineProperty = Object.defineProperty;
                var counter = Date.now() % 1e9;
                var WeakMap = function() {
                    this.name = "__st" + (Math.random() * 1e9 >>> 0) + (counter++ + "__");
                };
                WeakMap.prototype = {
                    set: function(key, value) {
                        var entry = key[this.name];
                        if (entry && entry[0] === key) entry[1] = value; else defineProperty(key, this.name, {
                            value: [ key, value ],
                            writable: true
                        });
                        return this;
                    },
                    get: function(key) {
                        var entry;
                        return (entry = key[this.name]) && entry[0] === key ? entry[1] : undefined;
                    },
                    delete: function(key) {
                        var entry = key[this.name];
                        if (!entry || entry[0] !== key) return false;
                        entry[0] = entry[1] = undefined;
                        return true;
                    },
                    has: function(key) {
                        var entry = key[this.name];
                        if (!entry) return false;
                        return entry[0] === key;
                    }
                };
                window.WeakMap = WeakMap;
            })();
        }
        (function(global) {
            if (global.JsMutationObserver) {
                return;
            }
            var registrationsTable = new WeakMap();
            var setImmediate;
            if (/Trident|Edge/.test(navigator.userAgent)) {
                setImmediate = setTimeout;
            } else if (window.setImmediate) {
                setImmediate = window.setImmediate;
            } else {
                var setImmediateQueue = [];
                var sentinel = String(Math.random());
                window.addEventListener("message", function(e) {
                    if (e.data === sentinel) {
                        var queue = setImmediateQueue;
                        setImmediateQueue = [];
                        queue.forEach(function(func) {
                            func();
                        });
                    }
                });
                setImmediate = function(func) {
                    setImmediateQueue.push(func);
                    window.postMessage(sentinel, "*");
                };
            }
            var isScheduled = false;
            var scheduledObservers = [];
            function scheduleCallback(observer) {
                scheduledObservers.push(observer);
                if (!isScheduled) {
                    isScheduled = true;
                    setImmediate(dispatchCallbacks);
                }
            }
            function wrapIfNeeded(node) {
                return window.ShadowDOMPolyfill && window.ShadowDOMPolyfill.wrapIfNeeded(node) || node;
            }
            function dispatchCallbacks() {
                isScheduled = false;
                var observers = scheduledObservers;
                scheduledObservers = [];
                observers.sort(function(o1, o2) {
                    return o1.uid_ - o2.uid_;
                });
                var anyNonEmpty = false;
                observers.forEach(function(observer) {
                    var queue = observer.takeRecords();
                    removeTransientObserversFor(observer);
                    if (queue.length) {
                        observer.callback_(queue, observer);
                        anyNonEmpty = true;
                    }
                });
                if (anyNonEmpty) dispatchCallbacks();
            }
            function removeTransientObserversFor(observer) {
                observer.nodes_.forEach(function(node) {
                    var registrations = registrationsTable.get(node);
                    if (!registrations) return;
                    registrations.forEach(function(registration) {
                        if (registration.observer === observer) registration.removeTransientObservers();
                    });
                });
            }
            function forEachAncestorAndObserverEnqueueRecord(target, callback) {
                for (var node = target; node; node = node.parentNode) {
                    var registrations = registrationsTable.get(node);
                    if (registrations) {
                        for (var j = 0; j < registrations.length; j++) {
                            var registration = registrations[j];
                            var options = registration.options;
                            if (node !== target && !options.subtree) continue;
                            var record = callback(options);
                            if (record) registration.enqueue(record);
                        }
                    }
                }
            }
            var uidCounter = 0;
            function JsMutationObserver(callback) {
                this.callback_ = callback;
                this.nodes_ = [];
                this.records_ = [];
                this.uid_ = ++uidCounter;
            }
            JsMutationObserver.prototype = {
                observe: function(target, options) {
                    target = wrapIfNeeded(target);
                    if (!options.childList && !options.attributes && !options.characterData || options.attributeOldValue && !options.attributes || options.attributeFilter && options.attributeFilter.length && !options.attributes || options.characterDataOldValue && !options.characterData) {
                        throw new SyntaxError();
                    }
                    var registrations = registrationsTable.get(target);
                    if (!registrations) registrationsTable.set(target, registrations = []);
                    var registration;
                    for (var i = 0; i < registrations.length; i++) {
                        if (registrations[i].observer === this) {
                            registration = registrations[i];
                            registration.removeListeners();
                            registration.options = options;
                            break;
                        }
                    }
                    if (!registration) {
                        registration = new Registration(this, target, options);
                        registrations.push(registration);
                        this.nodes_.push(target);
                    }
                    registration.addListeners();
                },
                disconnect: function() {
                    this.nodes_.forEach(function(node) {
                        var registrations = registrationsTable.get(node);
                        for (var i = 0; i < registrations.length; i++) {
                            var registration = registrations[i];
                            if (registration.observer === this) {
                                registration.removeListeners();
                                registrations.splice(i, 1);
                                break;
                            }
                        }
                    }, this);
                    this.records_ = [];
                },
                takeRecords: function() {
                    var copyOfRecords = this.records_;
                    this.records_ = [];
                    return copyOfRecords;
                }
            };
            function MutationRecord(type, target) {
                this.type = type;
                this.target = target;
                this.addedNodes = [];
                this.removedNodes = [];
                this.previousSibling = null;
                this.nextSibling = null;
                this.attributeName = null;
                this.attributeNamespace = null;
                this.oldValue = null;
            }
            function copyMutationRecord(original) {
                var record = new MutationRecord(original.type, original.target);
                record.addedNodes = original.addedNodes.slice();
                record.removedNodes = original.removedNodes.slice();
                record.previousSibling = original.previousSibling;
                record.nextSibling = original.nextSibling;
                record.attributeName = original.attributeName;
                record.attributeNamespace = original.attributeNamespace;
                record.oldValue = original.oldValue;
                return record;
            }
            var currentRecord, recordWithOldValue;
            function getRecord(type, target) {
                return currentRecord = new MutationRecord(type, target);
            }
            function getRecordWithOldValue(oldValue) {
                if (recordWithOldValue) return recordWithOldValue;
                recordWithOldValue = copyMutationRecord(currentRecord);
                recordWithOldValue.oldValue = oldValue;
                return recordWithOldValue;
            }
            function clearRecords() {
                currentRecord = recordWithOldValue = undefined;
            }
            function recordRepresentsCurrentMutation(record) {
                return record === recordWithOldValue || record === currentRecord;
            }
            function selectRecord(lastRecord, newRecord) {
                if (lastRecord === newRecord) return lastRecord;
                if (recordWithOldValue && recordRepresentsCurrentMutation(lastRecord)) return recordWithOldValue;
                return null;
            }
            function Registration(observer, target, options) {
                this.observer = observer;
                this.target = target;
                this.options = options;
                this.transientObservedNodes = [];
            }
            Registration.prototype = {
                enqueue: function(record) {
                    var records = this.observer.records_;
                    var length = records.length;
                    if (records.length > 0) {
                        var lastRecord = records[length - 1];
                        var recordToReplaceLast = selectRecord(lastRecord, record);
                        if (recordToReplaceLast) {
                            records[length - 1] = recordToReplaceLast;
                            return;
                        }
                    } else {
                        scheduleCallback(this.observer);
                    }
                    records[length] = record;
                },
                addListeners: function() {
                    this.addListeners_(this.target);
                },
                addListeners_: function(node) {
                    var options = this.options;
                    if (options.attributes) node.addEventListener("DOMAttrModified", this, true);
                    if (options.characterData) node.addEventListener("DOMCharacterDataModified", this, true);
                    if (options.childList) node.addEventListener("DOMNodeInserted", this, true);
                    if (options.childList || options.subtree) node.addEventListener("DOMNodeRemoved", this, true);
                },
                removeListeners: function() {
                    this.removeListeners_(this.target);
                },
                removeListeners_: function(node) {
                    var options = this.options;
                    if (options.attributes) node.removeEventListener("DOMAttrModified", this, true);
                    if (options.characterData) node.removeEventListener("DOMCharacterDataModified", this, true);
                    if (options.childList) node.removeEventListener("DOMNodeInserted", this, true);
                    if (options.childList || options.subtree) node.removeEventListener("DOMNodeRemoved", this, true);
                },
                addTransientObserver: function(node) {
                    if (node === this.target) return;
                    this.addListeners_(node);
                    this.transientObservedNodes.push(node);
                    var registrations = registrationsTable.get(node);
                    if (!registrations) registrationsTable.set(node, registrations = []);
                    registrations.push(this);
                },
                removeTransientObservers: function() {
                    var transientObservedNodes = this.transientObservedNodes;
                    this.transientObservedNodes = [];
                    transientObservedNodes.forEach(function(node) {
                        this.removeListeners_(node);
                        var registrations = registrationsTable.get(node);
                        for (var i = 0; i < registrations.length; i++) {
                            if (registrations[i] === this) {
                                registrations.splice(i, 1);
                                break;
                            }
                        }
                    }, this);
                },
                handleEvent: function(e) {
                    e.stopImmediatePropagation();
                    switch (e.type) {
                      case "DOMAttrModified":
                        var name = e.attrName;
                        var namespace = e.relatedNode.namespaceURI;
                        var target = e.target;
                        var record = new getRecord("attributes", target);
                        record.attributeName = name;
                        record.attributeNamespace = namespace;
                        var oldValue = e.attrChange === MutationEvent.ADDITION ? null : e.prevValue;
                        forEachAncestorAndObserverEnqueueRecord(target, function(options) {
                            if (!options.attributes) return;
                            if (options.attributeFilter && options.attributeFilter.length && options.attributeFilter.indexOf(name) === -1 && options.attributeFilter.indexOf(namespace) === -1) {
                                return;
                            }
                            if (options.attributeOldValue) return getRecordWithOldValue(oldValue);
                            return record;
                        });
                        break;

                      case "DOMCharacterDataModified":
                        var target = e.target;
                        var record = getRecord("characterData", target);
                        var oldValue = e.prevValue;
                        forEachAncestorAndObserverEnqueueRecord(target, function(options) {
                            if (!options.characterData) return;
                            if (options.characterDataOldValue) return getRecordWithOldValue(oldValue);
                            return record;
                        });
                        break;

                      case "DOMNodeRemoved":
                        this.addTransientObserver(e.target);

                      case "DOMNodeInserted":
                        var changedNode = e.target;
                        var addedNodes, removedNodes;
                        if (e.type === "DOMNodeInserted") {
                            addedNodes = [ changedNode ];
                            removedNodes = [];
                        } else {
                            addedNodes = [];
                            removedNodes = [ changedNode ];
                        }
                        var previousSibling = changedNode.previousSibling;
                        var nextSibling = changedNode.nextSibling;
                        var record = getRecord("childList", e.target.parentNode);
                        record.addedNodes = addedNodes;
                        record.removedNodes = removedNodes;
                        record.previousSibling = previousSibling;
                        record.nextSibling = nextSibling;
                        forEachAncestorAndObserverEnqueueRecord(e.relatedNode, function(options) {
                            if (!options.childList) return;
                            return record;
                        });
                    }
                    clearRecords();
                }
            };
            global.JsMutationObserver = JsMutationObserver;
            if (!global.MutationObserver) {
                global.MutationObserver = JsMutationObserver;
                JsMutationObserver._isPolyfilled = true;
            }
        })(self);
        (function() {
            var needsTemplate = typeof HTMLTemplateElement === "undefined";
            if (/Trident/.test(navigator.userAgent)) {
                (function() {
                    var importNode = document.importNode;
                    document.importNode = function() {
                        var n = importNode.apply(document, arguments);
                        if (n.nodeType === Node.DOCUMENT_FRAGMENT_NODE) {
                            var f = document.createDocumentFragment();
                            f.appendChild(n);
                            return f;
                        } else {
                            return n;
                        }
                    };
                })();
            }
            var needsCloning = function() {
                if (!needsTemplate) {
                    var t = document.createElement("template");
                    var t2 = document.createElement("template");
                    t2.content.appendChild(document.createElement("div"));
                    t.content.appendChild(t2);
                    var clone = t.cloneNode(true);
                    return clone.content.childNodes.length === 0 || clone.content.firstChild.content.childNodes.length === 0;
                }
            }();
            var TEMPLATE_TAG = "template";
            var TemplateImpl = function() {};
            if (needsTemplate) {
                var contentDoc = document.implementation.createHTMLDocument("template");
                var canDecorate = true;
                var templateStyle = document.createElement("style");
                templateStyle.textContent = TEMPLATE_TAG + "{display:none;}";
                var head = document.head;
                head.insertBefore(templateStyle, head.firstElementChild);
                TemplateImpl.prototype = Object.create(HTMLElement.prototype);
                TemplateImpl.decorate = function(template) {
                    if (template.content) {
                        return;
                    }
                    template.content = contentDoc.createDocumentFragment();
                    var child;
                    while (child = template.firstChild) {
                        template.content.appendChild(child);
                    }
                    template.cloneNode = function(deep) {
                        return TemplateImpl.cloneNode(this, deep);
                    };
                    if (canDecorate) {
                        try {
                            Object.defineProperty(template, "innerHTML", {
                                get: function() {
                                    var o = "";
                                    for (var e = this.content.firstChild; e; e = e.nextSibling) {
                                        o += e.outerHTML || escapeData(e.data);
                                    }
                                    return o;
                                },
                                set: function(text) {
                                    contentDoc.body.innerHTML = text;
                                    TemplateImpl.bootstrap(contentDoc);
                                    while (this.content.firstChild) {
                                        this.content.removeChild(this.content.firstChild);
                                    }
                                    while (contentDoc.body.firstChild) {
                                        this.content.appendChild(contentDoc.body.firstChild);
                                    }
                                },
                                configurable: true
                            });
                        } catch (err) {
                            canDecorate = false;
                        }
                    }
                    TemplateImpl.bootstrap(template.content);
                };
                TemplateImpl.bootstrap = function(doc) {
                    var templates = doc.querySelectorAll(TEMPLATE_TAG);
                    for (var i = 0, l = templates.length, t; i < l && (t = templates[i]); i++) {
                        TemplateImpl.decorate(t);
                    }
                };
                document.addEventListener("DOMContentLoaded", function() {
                    TemplateImpl.bootstrap(document);
                });
                var createElement = document.createElement;
                document.createElement = function() {
                    "use strict";
                    var el = createElement.apply(document, arguments);
                    if (el.localName === "template") {
                        TemplateImpl.decorate(el);
                    }
                    return el;
                };
                var escapeDataRegExp = /[&\u00A0<>]/g;
                function escapeReplace(c) {
                    switch (c) {
                      case "&":
                        return "&amp;";

                      case "<":
                        return "&lt;";

                      case ">":
                        return "&gt;";

                      case " ":
                        return "&nbsp;";
                    }
                }
                function escapeData(s) {
                    return s.replace(escapeDataRegExp, escapeReplace);
                }
            }
            if (needsTemplate || needsCloning) {
                var nativeCloneNode = Node.prototype.cloneNode;
                TemplateImpl.cloneNode = function(template, deep) {
                    var clone = nativeCloneNode.call(template, false);
                    if (this.decorate) {
                        this.decorate(clone);
                    }
                    if (deep) {
                        clone.content.appendChild(nativeCloneNode.call(template.content, true));
                        this.fixClonedDom(clone.content, template.content);
                    }
                    return clone;
                };
                TemplateImpl.fixClonedDom = function(clone, source) {
                    if (!source.querySelectorAll) return;
                    var s$ = source.querySelectorAll(TEMPLATE_TAG);
                    var t$ = clone.querySelectorAll(TEMPLATE_TAG);
                    for (var i = 0, l = t$.length, t, s; i < l; i++) {
                        s = s$[i];
                        t = t$[i];
                        if (this.decorate) {
                            this.decorate(s);
                        }
                        t.parentNode.replaceChild(s.cloneNode(true), t);
                    }
                };
                var originalImportNode = document.importNode;
                Node.prototype.cloneNode = function(deep) {
                    var dom = nativeCloneNode.call(this, deep);
                    if (deep) {
                        TemplateImpl.fixClonedDom(dom, this);
                    }
                    return dom;
                };
                document.importNode = function(element, deep) {
                    if (element.localName === TEMPLATE_TAG) {
                        return TemplateImpl.cloneNode(element, deep);
                    } else {
                        var dom = originalImportNode.call(document, element, deep);
                        if (deep) {
                            TemplateImpl.fixClonedDom(dom, element);
                        }
                        return dom;
                    }
                };
                if (needsCloning) {
                    HTMLTemplateElement.prototype.cloneNode = function(deep) {
                        return TemplateImpl.cloneNode(this, deep);
                    };
                }
            }
            if (needsTemplate) {
                window.HTMLTemplateElement = TemplateImpl;
            }
        })();
        (function(scope) {
            "use strict";
            if (!(window.performance && window.performance.now)) {
                var start = Date.now();
                window.performance = {
                    now: function() {
                        return Date.now() - start;
                    }
                };
            }
            if (!window.requestAnimationFrame) {
                window.requestAnimationFrame = function() {
                    var nativeRaf = window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame;
                    return nativeRaf ? function(callback) {
                        return nativeRaf(function() {
                            callback(performance.now());
                        });
                    } : function(callback) {
                        return window.setTimeout(callback, 1e3 / 60);
                    };
                }();
            }
            if (!window.cancelAnimationFrame) {
                window.cancelAnimationFrame = function() {
                    return window.webkitCancelAnimationFrame || window.mozCancelAnimationFrame || function(id) {
                        clearTimeout(id);
                    };
                }();
            }
            var workingDefaultPrevented = function() {
                var e = document.createEvent("Event");
                e.initEvent("foo", true, true);
                e.preventDefault();
                return e.defaultPrevented;
            }();
            if (!workingDefaultPrevented) {
                var origPreventDefault = Event.prototype.preventDefault;
                Event.prototype.preventDefault = function() {
                    if (!this.cancelable) {
                        return;
                    }
                    origPreventDefault.call(this);
                    Object.defineProperty(this, "defaultPrevented", {
                        get: function() {
                            return true;
                        },
                        configurable: true
                    });
                };
            }
            var isIE = /Trident/.test(navigator.userAgent);
            if (!window.CustomEvent || isIE && typeof window.CustomEvent !== "function") {
                window.CustomEvent = function(inType, params) {
                    params = params || {};
                    var e = document.createEvent("CustomEvent");
                    e.initCustomEvent(inType, Boolean(params.bubbles), Boolean(params.cancelable), params.detail);
                    return e;
                };
                window.CustomEvent.prototype = window.Event.prototype;
            }
            if (!window.Event || isIE && typeof window.Event !== "function") {
                var origEvent = window.Event;
                window.Event = function(inType, params) {
                    params = params || {};
                    var e = document.createEvent("Event");
                    e.initEvent(inType, Boolean(params.bubbles), Boolean(params.cancelable));
                    return e;
                };
                window.Event.prototype = origEvent.prototype;
            }
        })(window.WebComponents);
        window.HTMLImports = window.HTMLImports || {
            flags: {}
        };
        (function(scope) {
            var IMPORT_LINK_TYPE = "import";
            var useNative = Boolean(IMPORT_LINK_TYPE in document.createElement("link"));
            var hasShadowDOMPolyfill = Boolean(window.ShadowDOMPolyfill);
            var wrap = function(node) {
                return hasShadowDOMPolyfill ? window.ShadowDOMPolyfill.wrapIfNeeded(node) : node;
            };
            var rootDocument = wrap(document);
            var currentScriptDescriptor = {
                get: function() {
                    var script = window.HTMLImports.currentScript || document.currentScript || (document.readyState !== "complete" ? document.scripts[document.scripts.length - 1] : null);
                    return wrap(script);
                },
                configurable: true
            };
            Object.defineProperty(document, "_currentScript", currentScriptDescriptor);
            Object.defineProperty(rootDocument, "_currentScript", currentScriptDescriptor);
            var isIE = /Trident/.test(navigator.userAgent);
            function whenReady(callback, doc) {
                doc = doc || rootDocument;
                whenDocumentReady(function() {
                    watchImportsLoad(callback, doc);
                }, doc);
            }
            var requiredReadyState = isIE ? "complete" : "interactive";
            var READY_EVENT = "readystatechange";
            function isDocumentReady(doc) {
                return doc.readyState === "complete" || doc.readyState === requiredReadyState;
            }
            function whenDocumentReady(callback, doc) {
                if (!isDocumentReady(doc)) {
                    var checkReady = function() {
                        if (doc.readyState === "complete" || doc.readyState === requiredReadyState) {
                            doc.removeEventListener(READY_EVENT, checkReady);
                            whenDocumentReady(callback, doc);
                        }
                    };
                    doc.addEventListener(READY_EVENT, checkReady);
                } else if (callback) {
                    callback();
                }
            }
            function markTargetLoaded(event) {
                event.target.__loaded = true;
            }
            function watchImportsLoad(callback, doc) {
                var imports = doc.querySelectorAll("link[rel=import]");
                var parsedCount = 0, importCount = imports.length, newImports = [], errorImports = [];
                function checkDone() {
                    if (parsedCount == importCount && callback) {
                        callback({
                            allImports: imports,
                            loadedImports: newImports,
                            errorImports: errorImports
                        });
                    }
                }
                function loadedImport(e) {
                    markTargetLoaded(e);
                    newImports.push(this);
                    parsedCount++;
                    checkDone();
                }
                function errorLoadingImport(e) {
                    errorImports.push(this);
                    parsedCount++;
                    checkDone();
                }
                if (importCount) {
                    for (var i = 0, imp; i < importCount && (imp = imports[i]); i++) {
                        if (isImportLoaded(imp)) {
                            newImports.push(this);
                            parsedCount++;
                            checkDone();
                        } else {
                            imp.addEventListener("load", loadedImport);
                            imp.addEventListener("error", errorLoadingImport);
                        }
                    }
                } else {
                    checkDone();
                }
            }
            function isImportLoaded(link) {
                return useNative ? link.__loaded || link.import && link.import.readyState !== "loading" : link.__importParsed;
            }
            if (useNative) {
                new MutationObserver(function(mxns) {
                    for (var i = 0, l = mxns.length, m; i < l && (m = mxns[i]); i++) {
                        if (m.addedNodes) {
                            handleImports(m.addedNodes);
                        }
                    }
                }).observe(document.head, {
                    childList: true
                });
                function handleImports(nodes) {
                    for (var i = 0, l = nodes.length, n; i < l && (n = nodes[i]); i++) {
                        if (isImport(n)) {
                            handleImport(n);
                        }
                    }
                }
                function isImport(element) {
                    return element.localName === "link" && element.rel === "import";
                }
                function handleImport(element) {
                    var loaded = element.import;
                    if (loaded) {
                        markTargetLoaded({
                            target: element
                        });
                    } else {
                        element.addEventListener("load", markTargetLoaded);
                        element.addEventListener("error", markTargetLoaded);
                    }
                }
                (function() {
                    if (document.readyState === "loading") {
                        var imports = document.querySelectorAll("link[rel=import]");
                        for (var i = 0, l = imports.length, imp; i < l && (imp = imports[i]); i++) {
                            handleImport(imp);
                        }
                    }
                })();
            }
            whenReady(function(detail) {
                window.HTMLImports.ready = true;
                window.HTMLImports.readyTime = new Date().getTime();
                var evt = rootDocument.createEvent("CustomEvent");
                evt.initCustomEvent("HTMLImportsLoaded", true, true, detail);
                rootDocument.dispatchEvent(evt);
            });
            scope.IMPORT_LINK_TYPE = IMPORT_LINK_TYPE;
            scope.useNative = useNative;
            scope.rootDocument = rootDocument;
            scope.whenReady = whenReady;
            scope.isIE = isIE;
        })(window.HTMLImports);
        (function(scope) {
            var modules = [];
            var addModule = function(module) {
                modules.push(module);
            };
            var initializeModules = function() {
                modules.forEach(function(module) {
                    module(scope);
                });
            };
            scope.addModule = addModule;
            scope.initializeModules = initializeModules;
        })(window.HTMLImports);
        window.HTMLImports.addModule(function(scope) {
            var CSS_URL_REGEXP = /(url\()([^)]*)(\))/g;
            var CSS_IMPORT_REGEXP = /(@import[\s]+(?!url\())([^;]*)(;)/g;
            var path = {
                resolveUrlsInStyle: function(style, linkUrl) {
                    var doc = style.ownerDocument;
                    var resolver = doc.createElement("a");
                    style.textContent = this.resolveUrlsInCssText(style.textContent, linkUrl, resolver);
                    return style;
                },
                resolveUrlsInCssText: function(cssText, linkUrl, urlObj) {
                    var r = this.replaceUrls(cssText, urlObj, linkUrl, CSS_URL_REGEXP);
                    r = this.replaceUrls(r, urlObj, linkUrl, CSS_IMPORT_REGEXP);
                    return r;
                },
                replaceUrls: function(text, urlObj, linkUrl, regexp) {
                    return text.replace(regexp, function(m, pre, url, post) {
                        var urlPath = url.replace(/["']/g, "");
                        if (linkUrl) {
                            urlPath = new URL(urlPath, linkUrl).href;
                        }
                        urlObj.href = urlPath;
                        urlPath = urlObj.href;
                        return pre + "'" + urlPath + "'" + post;
                    });
                }
            };
            scope.path = path;
        });
        window.HTMLImports.addModule(function(scope) {
            var xhr = {
                async: true,
                ok: function(request) {
                    return request.status >= 200 && request.status < 300 || request.status === 304 || request.status === 0;
                },
                load: function(url, next, nextContext) {
                    var request = new XMLHttpRequest();
                    if (scope.flags.debug || scope.flags.bust) {
                        url += "?" + Math.random();
                    }
                    request.open("GET", url, xhr.async);
                    request.addEventListener("readystatechange", function(e) {
                        if (request.readyState === 4) {
                            var redirectedUrl = null;
                            try {
                                var locationHeader = request.getResponseHeader("Location");
                                if (locationHeader) {
                                    redirectedUrl = locationHeader.substr(0, 1) === "/" ? location.origin + locationHeader : locationHeader;
                                }
                            } catch (e) {
                                console.error(e.message);
                            }
                            next.call(nextContext, !xhr.ok(request) && request, request.response || request.responseText, redirectedUrl);
                        }
                    });
                    request.send();
                    return request;
                },
                loadDocument: function(url, next, nextContext) {
                    this.load(url, next, nextContext).responseType = "document";
                }
            };
            scope.xhr = xhr;
        });
        window.HTMLImports.addModule(function(scope) {
            var xhr = scope.xhr;
            var flags = scope.flags;
            var Loader = function(onLoad, onComplete) {
                this.cache = {};
                this.onload = onLoad;
                this.oncomplete = onComplete;
                this.inflight = 0;
                this.pending = {};
            };
            Loader.prototype = {
                addNodes: function(nodes) {
                    this.inflight += nodes.length;
                    for (var i = 0, l = nodes.length, n; i < l && (n = nodes[i]); i++) {
                        this.require(n);
                    }
                    this.checkDone();
                },
                addNode: function(node) {
                    this.inflight++;
                    this.require(node);
                    this.checkDone();
                },
                require: function(elt) {
                    var url = elt.src || elt.href;
                    elt.__nodeUrl = url;
                    if (!this.dedupe(url, elt)) {
                        this.fetch(url, elt);
                    }
                },
                dedupe: function(url, elt) {
                    if (this.pending[url]) {
                        this.pending[url].push(elt);
                        return true;
                    }
                    var resource;
                    if (this.cache[url]) {
                        this.onload(url, elt, this.cache[url]);
                        this.tail();
                        return true;
                    }
                    this.pending[url] = [ elt ];
                    return false;
                },
                fetch: function(url, elt) {
                    flags.load && console.log("fetch", url, elt);
                    if (!url) {
                        setTimeout(function() {
                            this.receive(url, elt, {
                                error: "href must be specified"
                            }, null);
                        }.bind(this), 0);
                    } else if (url.match(/^data:/)) {
                        var pieces = url.split(",");
                        var header = pieces[0];
                        var body = pieces[1];
                        if (header.indexOf(";base64") > -1) {
                            body = atob(body);
                        } else {
                            body = decodeURIComponent(body);
                        }
                        setTimeout(function() {
                            this.receive(url, elt, null, body);
                        }.bind(this), 0);
                    } else {
                        var receiveXhr = function(err, resource, redirectedUrl) {
                            this.receive(url, elt, err, resource, redirectedUrl);
                        }.bind(this);
                        xhr.load(url, receiveXhr);
                    }
                },
                receive: function(url, elt, err, resource, redirectedUrl) {
                    this.cache[url] = resource;
                    var $p = this.pending[url];
                    for (var i = 0, l = $p.length, p; i < l && (p = $p[i]); i++) {
                        this.onload(url, p, resource, err, redirectedUrl);
                        this.tail();
                    }
                    this.pending[url] = null;
                },
                tail: function() {
                    --this.inflight;
                    this.checkDone();
                },
                checkDone: function() {
                    if (!this.inflight) {
                        this.oncomplete();
                    }
                }
            };
            scope.Loader = Loader;
        });
        window.HTMLImports.addModule(function(scope) {
            var Observer = function(addCallback) {
                this.addCallback = addCallback;
                this.mo = new MutationObserver(this.handler.bind(this));
            };
            Observer.prototype = {
                handler: function(mutations) {
                    for (var i = 0, l = mutations.length, m; i < l && (m = mutations[i]); i++) {
                        if (m.type === "childList" && m.addedNodes.length) {
                            this.addedNodes(m.addedNodes);
                        }
                    }
                },
                addedNodes: function(nodes) {
                    if (this.addCallback) {
                        this.addCallback(nodes);
                    }
                    for (var i = 0, l = nodes.length, n, loading; i < l && (n = nodes[i]); i++) {
                        if (n.children && n.children.length) {
                            this.addedNodes(n.children);
                        }
                    }
                },
                observe: function(root) {
                    this.mo.observe(root, {
                        childList: true,
                        subtree: true
                    });
                }
            };
            scope.Observer = Observer;
        });
        window.HTMLImports.addModule(function(scope) {
            var path = scope.path;
            var rootDocument = scope.rootDocument;
            var flags = scope.flags;
            var isIE = scope.isIE;
            var IMPORT_LINK_TYPE = scope.IMPORT_LINK_TYPE;
            var IMPORT_SELECTOR = "link[rel=" + IMPORT_LINK_TYPE + "]";
            var importParser = {
                documentSelectors: IMPORT_SELECTOR,
                importsSelectors: [ IMPORT_SELECTOR, "link[rel=stylesheet]:not([type])", "style:not([type])", "script:not([type])", 'script[type="application/javascript"]', 'script[type="text/javascript"]' ].join(","),
                map: {
                    link: "parseLink",
                    script: "parseScript",
                    style: "parseStyle"
                },
                dynamicElements: [],
                parseNext: function() {
                    var next = this.nextToParse();
                    if (next) {
                        this.parse(next);
                    }
                },
                parse: function(elt) {
                    if (this.isParsed(elt)) {
                        flags.parse && console.log("[%s] is already parsed", elt.localName);
                        return;
                    }
                    var fn = this[this.map[elt.localName]];
                    if (fn) {
                        this.markParsing(elt);
                        fn.call(this, elt);
                    }
                },
                parseDynamic: function(elt, quiet) {
                    this.dynamicElements.push(elt);
                    if (!quiet) {
                        this.parseNext();
                    }
                },
                markParsing: function(elt) {
                    flags.parse && console.log("parsing", elt);
                    this.parsingElement = elt;
                },
                markParsingComplete: function(elt) {
                    elt.__importParsed = true;
                    this.markDynamicParsingComplete(elt);
                    if (elt.__importElement) {
                        elt.__importElement.__importParsed = true;
                        this.markDynamicParsingComplete(elt.__importElement);
                    }
                    this.parsingElement = null;
                    flags.parse && console.log("completed", elt);
                },
                markDynamicParsingComplete: function(elt) {
                    var i = this.dynamicElements.indexOf(elt);
                    if (i >= 0) {
                        this.dynamicElements.splice(i, 1);
                    }
                },
                parseImport: function(elt) {
                    elt.import = elt.__doc;
                    if (window.HTMLImports.__importsParsingHook) {
                        window.HTMLImports.__importsParsingHook(elt);
                    }
                    if (elt.import) {
                        elt.import.__importParsed = true;
                    }
                    this.markParsingComplete(elt);
                    if (elt.__resource && !elt.__error) {
                        elt.dispatchEvent(new CustomEvent("load", {
                            bubbles: false
                        }));
                    } else {
                        elt.dispatchEvent(new CustomEvent("error", {
                            bubbles: false
                        }));
                    }
                    if (elt.__pending) {
                        var fn;
                        while (elt.__pending.length) {
                            fn = elt.__pending.shift();
                            if (fn) {
                                fn({
                                    target: elt
                                });
                            }
                        }
                    }
                    this.parseNext();
                },
                parseLink: function(linkElt) {
                    if (nodeIsImport(linkElt)) {
                        this.parseImport(linkElt);
                    } else {
                        linkElt.href = linkElt.href;
                        this.parseGeneric(linkElt);
                    }
                },
                parseStyle: function(elt) {
                    var src = elt;
                    elt = cloneStyle(elt);
                    src.__appliedElement = elt;
                    elt.__importElement = src;
                    this.parseGeneric(elt);
                },
                parseGeneric: function(elt) {
                    this.trackElement(elt);
                    this.addElementToDocument(elt);
                },
                rootImportForElement: function(elt) {
                    var n = elt;
                    while (n.ownerDocument.__importLink) {
                        n = n.ownerDocument.__importLink;
                    }
                    return n;
                },
                addElementToDocument: function(elt) {
                    var port = this.rootImportForElement(elt.__importElement || elt);
                    port.parentNode.insertBefore(elt, port);
                },
                trackElement: function(elt, callback) {
                    var self = this;
                    var done = function(e) {
                        elt.removeEventListener("load", done);
                        elt.removeEventListener("error", done);
                        if (callback) {
                            callback(e);
                        }
                        self.markParsingComplete(elt);
                        self.parseNext();
                    };
                    elt.addEventListener("load", done);
                    elt.addEventListener("error", done);
                    if (isIE && elt.localName === "style") {
                        var fakeLoad = false;
                        if (elt.textContent.indexOf("@import") == -1) {
                            fakeLoad = true;
                        } else if (elt.sheet) {
                            fakeLoad = true;
                            var csr = elt.sheet.cssRules;
                            var len = csr ? csr.length : 0;
                            for (var i = 0, r; i < len && (r = csr[i]); i++) {
                                if (r.type === CSSRule.IMPORT_RULE) {
                                    fakeLoad = fakeLoad && Boolean(r.styleSheet);
                                }
                            }
                        }
                        if (fakeLoad) {
                            setTimeout(function() {
                                elt.dispatchEvent(new CustomEvent("load", {
                                    bubbles: false
                                }));
                            });
                        }
                    }
                },
                parseScript: function(scriptElt) {
                    var script = document.createElement("script");
                    script.__importElement = scriptElt;
                    script.src = scriptElt.src ? scriptElt.src : generateScriptDataUrl(scriptElt);
                    scope.currentScript = scriptElt;
                    this.trackElement(script, function(e) {
                        if (script.parentNode) {
                            script.parentNode.removeChild(script);
                        }
                        scope.currentScript = null;
                    });
                    this.addElementToDocument(script);
                },
                nextToParse: function() {
                    this._mayParse = [];
                    return !this.parsingElement && (this.nextToParseInDoc(rootDocument) || this.nextToParseDynamic());
                },
                nextToParseInDoc: function(doc, link) {
                    if (doc && this._mayParse.indexOf(doc) < 0) {
                        this._mayParse.push(doc);
                        var nodes = doc.querySelectorAll(this.parseSelectorsForNode(doc));
                        for (var i = 0, l = nodes.length, n; i < l && (n = nodes[i]); i++) {
                            if (!this.isParsed(n)) {
                                if (this.hasResource(n)) {
                                    return nodeIsImport(n) ? this.nextToParseInDoc(n.__doc, n) : n;
                                } else {
                                    return;
                                }
                            }
                        }
                    }
                    return link;
                },
                nextToParseDynamic: function() {
                    return this.dynamicElements[0];
                },
                parseSelectorsForNode: function(node) {
                    var doc = node.ownerDocument || node;
                    return doc === rootDocument ? this.documentSelectors : this.importsSelectors;
                },
                isParsed: function(node) {
                    return node.__importParsed;
                },
                needsDynamicParsing: function(elt) {
                    return this.dynamicElements.indexOf(elt) >= 0;
                },
                hasResource: function(node) {
                    if (nodeIsImport(node) && node.__doc === undefined) {
                        return false;
                    }
                    return true;
                }
            };
            function nodeIsImport(elt) {
                return elt.localName === "link" && elt.rel === IMPORT_LINK_TYPE;
            }
            function generateScriptDataUrl(script) {
                var scriptContent = generateScriptContent(script);
                return "data:text/javascript;charset=utf-8," + encodeURIComponent(scriptContent);
            }
            function generateScriptContent(script) {
                return script.textContent + generateSourceMapHint(script);
            }
            function generateSourceMapHint(script) {
                var owner = script.ownerDocument;
                owner.__importedScripts = owner.__importedScripts || 0;
                var moniker = script.ownerDocument.baseURI;
                var num = owner.__importedScripts ? "-" + owner.__importedScripts : "";
                owner.__importedScripts++;
                return "\n//# sourceURL=" + moniker + num + ".js\n";
            }
            function cloneStyle(style) {
                var clone = style.ownerDocument.createElement("style");
                clone.textContent = style.textContent;
                path.resolveUrlsInStyle(clone);
                return clone;
            }
            scope.parser = importParser;
            scope.IMPORT_SELECTOR = IMPORT_SELECTOR;
        });
        window.HTMLImports.addModule(function(scope) {
            var flags = scope.flags;
            var IMPORT_LINK_TYPE = scope.IMPORT_LINK_TYPE;
            var IMPORT_SELECTOR = scope.IMPORT_SELECTOR;
            var rootDocument = scope.rootDocument;
            var Loader = scope.Loader;
            var Observer = scope.Observer;
            var parser = scope.parser;
            var importer = {
                documents: {},
                documentPreloadSelectors: IMPORT_SELECTOR,
                importsPreloadSelectors: [ IMPORT_SELECTOR ].join(","),
                loadNode: function(node) {
                    importLoader.addNode(node);
                },
                loadSubtree: function(parent) {
                    var nodes = this.marshalNodes(parent);
                    importLoader.addNodes(nodes);
                },
                marshalNodes: function(parent) {
                    return parent.querySelectorAll(this.loadSelectorsForNode(parent));
                },
                loadSelectorsForNode: function(node) {
                    var doc = node.ownerDocument || node;
                    return doc === rootDocument ? this.documentPreloadSelectors : this.importsPreloadSelectors;
                },
                loaded: function(url, elt, resource, err, redirectedUrl) {
                    flags.load && console.log("loaded", url, elt);
                    elt.__resource = resource;
                    elt.__error = err;
                    if (isImportLink(elt)) {
                        var doc = this.documents[url];
                        if (doc === undefined) {
                            doc = err ? null : makeDocument(resource, redirectedUrl || url);
                            if (doc) {
                                doc.__importLink = elt;
                                this.bootDocument(doc);
                            }
                            this.documents[url] = doc;
                        }
                        elt.__doc = doc;
                    }
                    parser.parseNext();
                },
                bootDocument: function(doc) {
                    this.loadSubtree(doc);
                    this.observer.observe(doc);
                    parser.parseNext();
                },
                loadedAll: function() {
                    parser.parseNext();
                }
            };
            var importLoader = new Loader(importer.loaded.bind(importer), importer.loadedAll.bind(importer));
            importer.observer = new Observer();
            function isImportLink(elt) {
                return isLinkRel(elt, IMPORT_LINK_TYPE);
            }
            function isLinkRel(elt, rel) {
                return elt.localName === "link" && elt.getAttribute("rel") === rel;
            }
            function hasBaseURIAccessor(doc) {
                return !!Object.getOwnPropertyDescriptor(doc, "baseURI");
            }
            function makeDocument(resource, url) {
                var doc = document.implementation.createHTMLDocument(IMPORT_LINK_TYPE);
                doc._URL = url;
                var base = doc.createElement("base");
                base.setAttribute("href", url);
                if (!doc.baseURI && !hasBaseURIAccessor(doc)) {
                    Object.defineProperty(doc, "baseURI", {
                        value: url
                    });
                }
                var meta = doc.createElement("meta");
                meta.setAttribute("charset", "utf-8");
                doc.head.appendChild(meta);
                doc.head.appendChild(base);
                doc.body.innerHTML = resource;
                if (window.HTMLTemplateElement && HTMLTemplateElement.bootstrap) {
                    HTMLTemplateElement.bootstrap(doc);
                }
                return doc;
            }
            if (!document.baseURI) {
                var baseURIDescriptor = {
                    get: function() {
                        var base = document.querySelector("base");
                        return base ? base.href : window.location.href;
                    },
                    configurable: true
                };
                Object.defineProperty(document, "baseURI", baseURIDescriptor);
                Object.defineProperty(rootDocument, "baseURI", baseURIDescriptor);
            }
            scope.importer = importer;
            scope.importLoader = importLoader;
        });
        window.HTMLImports.addModule(function(scope) {
            var parser = scope.parser;
            var importer = scope.importer;
            var dynamic = {
                added: function(nodes) {
                    var owner, parsed, loading;
                    for (var i = 0, l = nodes.length, n; i < l && (n = nodes[i]); i++) {
                        if (!owner) {
                            owner = n.ownerDocument;
                            parsed = parser.isParsed(owner);
                        }
                        loading = this.shouldLoadNode(n);
                        if (loading) {
                            importer.loadNode(n);
                        }
                        if (this.shouldParseNode(n) && parsed) {
                            parser.parseDynamic(n, loading);
                        }
                    }
                },
                shouldLoadNode: function(node) {
                    return node.nodeType === 1 && matches.call(node, importer.loadSelectorsForNode(node));
                },
                shouldParseNode: function(node) {
                    return node.nodeType === 1 && matches.call(node, parser.parseSelectorsForNode(node));
                }
            };
            importer.observer.addCallback = dynamic.added.bind(dynamic);
            var matches = HTMLElement.prototype.matches || HTMLElement.prototype.matchesSelector || HTMLElement.prototype.webkitMatchesSelector || HTMLElement.prototype.mozMatchesSelector || HTMLElement.prototype.msMatchesSelector;
        });
        (function(scope) {
            var initializeModules = scope.initializeModules;
            var isIE = scope.isIE;
            if (scope.useNative) {
                return;
            }
            initializeModules();
            var rootDocument = scope.rootDocument;
            function bootstrap() {
                window.HTMLImports.importer.bootDocument(rootDocument);
            }
            if (document.readyState === "complete" || document.readyState === "interactive" && !window.attachEvent) {
                bootstrap();
            } else {
                document.addEventListener("DOMContentLoaded", bootstrap);
            }
        })(window.HTMLImports);
        window.CustomElements = window.CustomElements || {
            flags: {}
        };
        (function(scope) {
            var flags = scope.flags;
            var modules = [];
            var addModule = function(module) {
                modules.push(module);
            };
            var initializeModules = function() {
                modules.forEach(function(module) {
                    module(scope);
                });
            };
            scope.addModule = addModule;
            scope.initializeModules = initializeModules;
            scope.hasNative = Boolean(document.registerElement);
            scope.isIE = /Trident/.test(navigator.userAgent);
            scope.useNative = !flags.register && scope.hasNative && !window.ShadowDOMPolyfill && (!window.HTMLImports || window.HTMLImports.useNative);
        })(window.CustomElements);
        window.CustomElements.addModule(function(scope) {
            var IMPORT_LINK_TYPE = window.HTMLImports ? window.HTMLImports.IMPORT_LINK_TYPE : "none";
            function forSubtree(node, cb) {
                findAllElements(node, function(e) {
                    if (cb(e)) {
                        return true;
                    }
                    forRoots(e, cb);
                });
                forRoots(node, cb);
            }
            function findAllElements(node, find, data) {
                var e = node.firstElementChild;
                if (!e) {
                    e = node.firstChild;
                    while (e && e.nodeType !== Node.ELEMENT_NODE) {
                        e = e.nextSibling;
                    }
                }
                while (e) {
                    if (find(e, data) !== true) {
                        findAllElements(e, find, data);
                    }
                    e = e.nextElementSibling;
                }
                return null;
            }
            function forRoots(node, cb) {
                var root = node.shadowRoot;
                while (root) {
                    forSubtree(root, cb);
                    root = root.olderShadowRoot;
                }
            }
            function forDocumentTree(doc, cb) {
                _forDocumentTree(doc, cb, []);
            }
            function _forDocumentTree(doc, cb, processingDocuments) {
                doc = window.wrap(doc);
                if (processingDocuments.indexOf(doc) >= 0) {
                    return;
                }
                processingDocuments.push(doc);
                var imports = doc.querySelectorAll("link[rel=" + IMPORT_LINK_TYPE + "]");
                for (var i = 0, l = imports.length, n; i < l && (n = imports[i]); i++) {
                    if (n.import) {
                        _forDocumentTree(n.import, cb, processingDocuments);
                    }
                }
                cb(doc);
            }
            scope.forDocumentTree = forDocumentTree;
            scope.forSubtree = forSubtree;
        });
        window.CustomElements.addModule(function(scope) {
            var flags = scope.flags;
            var forSubtree = scope.forSubtree;
            var forDocumentTree = scope.forDocumentTree;
            function addedNode(node, isAttached) {
                return added(node, isAttached) || addedSubtree(node, isAttached);
            }
            function added(node, isAttached) {
                if (scope.upgrade(node, isAttached)) {
                    return true;
                }
                if (isAttached) {
                    attached(node);
                }
            }
            function addedSubtree(node, isAttached) {
                forSubtree(node, function(e) {
                    if (added(e, isAttached)) {
                        return true;
                    }
                });
            }
            var hasThrottledAttached = window.MutationObserver._isPolyfilled && flags["throttle-attached"];
            scope.hasPolyfillMutations = hasThrottledAttached;
            scope.hasThrottledAttached = hasThrottledAttached;
            var isPendingMutations = false;
            var pendingMutations = [];
            function deferMutation(fn) {
                pendingMutations.push(fn);
                if (!isPendingMutations) {
                    isPendingMutations = true;
                    setTimeout(takeMutations);
                }
            }
            function takeMutations() {
                isPendingMutations = false;
                var $p = pendingMutations;
                for (var i = 0, l = $p.length, p; i < l && (p = $p[i]); i++) {
                    p();
                }
                pendingMutations = [];
            }
            function attached(element) {
                if (hasThrottledAttached) {
                    deferMutation(function() {
                        _attached(element);
                    });
                } else {
                    _attached(element);
                }
            }
            function _attached(element) {
                if (element.__upgraded__ && !element.__attached) {
                    element.__attached = true;
                    if (element.attachedCallback) {
                        element.attachedCallback();
                    }
                }
            }
            function detachedNode(node) {
                detached(node);
                forSubtree(node, function(e) {
                    detached(e);
                });
            }
            function detached(element) {
                if (hasThrottledAttached) {
                    deferMutation(function() {
                        _detached(element);
                    });
                } else {
                    _detached(element);
                }
            }
            function _detached(element) {
                if (element.__upgraded__ && element.__attached) {
                    element.__attached = false;
                    if (element.detachedCallback) {
                        element.detachedCallback();
                    }
                }
            }
            function inDocument(element) {
                var p = element;
                var doc = window.wrap(document);
                while (p) {
                    if (p == doc) {
                        return true;
                    }
                    p = p.parentNode || p.nodeType === Node.DOCUMENT_FRAGMENT_NODE && p.host;
                }
            }
            function watchShadow(node) {
                if (node.shadowRoot && !node.shadowRoot.__watched) {
                    flags.dom && console.log("watching shadow-root for: ", node.localName);
                    var root = node.shadowRoot;
                    while (root) {
                        observe(root);
                        root = root.olderShadowRoot;
                    }
                }
            }
            function handler(root, mutations) {
                if (flags.dom) {
                    var mx = mutations[0];
                    if (mx && mx.type === "childList" && mx.addedNodes) {
                        if (mx.addedNodes) {
                            var d = mx.addedNodes[0];
                            while (d && d !== document && !d.host) {
                                d = d.parentNode;
                            }
                            var u = d && (d.URL || d._URL || d.host && d.host.localName) || "";
                            u = u.split("/?").shift().split("/").pop();
                        }
                    }
                    console.group("mutations (%d) [%s]", mutations.length, u || "");
                }
                var isAttached = inDocument(root);
                mutations.forEach(function(mx) {
                    if (mx.type === "childList") {
                        forEach(mx.addedNodes, function(n) {
                            if (!n.localName) {
                                return;
                            }
                            addedNode(n, isAttached);
                        });
                        forEach(mx.removedNodes, function(n) {
                            if (!n.localName) {
                                return;
                            }
                            detachedNode(n);
                        });
                    }
                });
                flags.dom && console.groupEnd();
            }
            function takeRecords(node) {
                node = window.wrap(node);
                if (!node) {
                    node = window.wrap(document);
                }
                while (node.parentNode) {
                    node = node.parentNode;
                }
                var observer = node.__observer;
                if (observer) {
                    handler(node, observer.takeRecords());
                    takeMutations();
                }
            }
            var forEach = Array.prototype.forEach.call.bind(Array.prototype.forEach);
            function observe(inRoot) {
                if (inRoot.__observer) {
                    return;
                }
                var observer = new MutationObserver(handler.bind(this, inRoot));
                observer.observe(inRoot, {
                    childList: true,
                    subtree: true
                });
                inRoot.__observer = observer;
            }
            function upgradeDocument(doc) {
                doc = window.wrap(doc);
                flags.dom && console.group("upgradeDocument: ", doc.baseURI.split("/").pop());
                var isMainDocument = doc === window.wrap(document);
                addedNode(doc, isMainDocument);
                observe(doc);
                flags.dom && console.groupEnd();
            }
            function upgradeDocumentTree(doc) {
                forDocumentTree(doc, upgradeDocument);
            }
            var originalCreateShadowRoot = Element.prototype.createShadowRoot;
            if (originalCreateShadowRoot) {
                Element.prototype.createShadowRoot = function() {
                    var root = originalCreateShadowRoot.call(this);
                    window.CustomElements.watchShadow(this);
                    return root;
                };
            }
            scope.watchShadow = watchShadow;
            scope.upgradeDocumentTree = upgradeDocumentTree;
            scope.upgradeDocument = upgradeDocument;
            scope.upgradeSubtree = addedSubtree;
            scope.upgradeAll = addedNode;
            scope.attached = attached;
            scope.takeRecords = takeRecords;
        });
        window.CustomElements.addModule(function(scope) {
            var flags = scope.flags;
            function upgrade(node, isAttached) {
                if (node.localName === "template") {
                    if (window.HTMLTemplateElement && HTMLTemplateElement.decorate) {
                        HTMLTemplateElement.decorate(node);
                    }
                }
                if (!node.__upgraded__ && node.nodeType === Node.ELEMENT_NODE) {
                    var is = node.getAttribute("is");
                    var definition = scope.getRegisteredDefinition(node.localName) || scope.getRegisteredDefinition(is);
                    if (definition) {
                        if (is && definition.tag == node.localName || !is && !definition.extends) {
                            return upgradeWithDefinition(node, definition, isAttached);
                        }
                    }
                }
            }
            function upgradeWithDefinition(element, definition, isAttached) {
                flags.upgrade && console.group("upgrade:", element.localName);
                if (definition.is) {
                    element.setAttribute("is", definition.is);
                }
                implementPrototype(element, definition);
                element.__upgraded__ = true;
                created(element);
                if (isAttached) {
                    scope.attached(element);
                }
                scope.upgradeSubtree(element, isAttached);
                flags.upgrade && console.groupEnd();
                return element;
            }
            function implementPrototype(element, definition) {
                if (Object.__proto__) {
                    element.__proto__ = definition.prototype;
                } else {
                    customMixin(element, definition.prototype, definition.native);
                    element.__proto__ = definition.prototype;
                }
            }
            function customMixin(inTarget, inSrc, inNative) {
                var used = {};
                var p = inSrc;
                while (p !== inNative && p !== HTMLElement.prototype) {
                    var keys = Object.getOwnPropertyNames(p);
                    for (var i = 0, k; k = keys[i]; i++) {
                        if (!used[k]) {
                            Object.defineProperty(inTarget, k, Object.getOwnPropertyDescriptor(p, k));
                            used[k] = 1;
                        }
                    }
                    p = Object.getPrototypeOf(p);
                }
            }
            function created(element) {
                if (element.createdCallback) {
                    element.createdCallback();
                }
            }
            scope.upgrade = upgrade;
            scope.upgradeWithDefinition = upgradeWithDefinition;
            scope.implementPrototype = implementPrototype;
        });
        window.CustomElements.addModule(function(scope) {
            var isIE = scope.isIE;
            var upgradeDocumentTree = scope.upgradeDocumentTree;
            var upgradeAll = scope.upgradeAll;
            var upgradeWithDefinition = scope.upgradeWithDefinition;
            var implementPrototype = scope.implementPrototype;
            var useNative = scope.useNative;
            function register(name, options) {
                var definition = options || {};
                if (!name) {
                    throw new Error("document.registerElement: first argument `name` must not be empty");
                }
                if (name.indexOf("-") < 0) {
                    throw new Error("document.registerElement: first argument ('name') must contain a dash ('-'). Argument provided was '" + String(name) + "'.");
                }
                if (isReservedTag(name)) {
                    throw new Error("Failed to execute 'registerElement' on 'Document': Registration failed for type '" + String(name) + "'. The type name is invalid.");
                }
                if (getRegisteredDefinition(name)) {
                    throw new Error("DuplicateDefinitionError: a type with name '" + String(name) + "' is already registered");
                }
                if (!definition.prototype) {
                    definition.prototype = Object.create(HTMLElement.prototype);
                }
                definition.__name = name.toLowerCase();
                if (definition.extends) {
                    definition.extends = definition.extends.toLowerCase();
                }
                definition.lifecycle = definition.lifecycle || {};
                definition.ancestry = ancestry(definition.extends);
                resolveTagName(definition);
                resolvePrototypeChain(definition);
                overrideAttributeApi(definition.prototype);
                registerDefinition(definition.__name, definition);
                definition.ctor = generateConstructor(definition);
                definition.ctor.prototype = definition.prototype;
                definition.prototype.constructor = definition.ctor;
                if (scope.ready) {
                    upgradeDocumentTree(document);
                }
                return definition.ctor;
            }
            function overrideAttributeApi(prototype) {
                if (prototype.setAttribute._polyfilled) {
                    return;
                }
                var setAttribute = prototype.setAttribute;
                prototype.setAttribute = function(name, value) {
                    changeAttribute.call(this, name, value, setAttribute);
                };
                var removeAttribute = prototype.removeAttribute;
                prototype.removeAttribute = function(name) {
                    changeAttribute.call(this, name, null, removeAttribute);
                };
                prototype.setAttribute._polyfilled = true;
            }
            function changeAttribute(name, value, operation) {
                name = name.toLowerCase();
                var oldValue = this.getAttribute(name);
                operation.apply(this, arguments);
                var newValue = this.getAttribute(name);
                if (this.attributeChangedCallback && newValue !== oldValue) {
                    this.attributeChangedCallback(name, oldValue, newValue);
                }
            }
            function isReservedTag(name) {
                for (var i = 0; i < reservedTagList.length; i++) {
                    if (name === reservedTagList[i]) {
                        return true;
                    }
                }
            }
            var reservedTagList = [ "annotation-xml", "color-profile", "font-face", "font-face-src", "font-face-uri", "font-face-format", "font-face-name", "missing-glyph" ];
            function ancestry(extnds) {
                var extendee = getRegisteredDefinition(extnds);
                if (extendee) {
                    return ancestry(extendee.extends).concat([ extendee ]);
                }
                return [];
            }
            function resolveTagName(definition) {
                var baseTag = definition.extends;
                for (var i = 0, a; a = definition.ancestry[i]; i++) {
                    baseTag = a.is && a.tag;
                }
                definition.tag = baseTag || definition.__name;
                if (baseTag) {
                    definition.is = definition.__name;
                }
            }
            function resolvePrototypeChain(definition) {
                if (!Object.__proto__) {
                    var nativePrototype = HTMLElement.prototype;
                    if (definition.is) {
                        var inst = document.createElement(definition.tag);
                        nativePrototype = Object.getPrototypeOf(inst);
                    }
                    var proto = definition.prototype, ancestor;
                    var foundPrototype = false;
                    while (proto) {
                        if (proto == nativePrototype) {
                            foundPrototype = true;
                        }
                        ancestor = Object.getPrototypeOf(proto);
                        if (ancestor) {
                            proto.__proto__ = ancestor;
                        }
                        proto = ancestor;
                    }
                    if (!foundPrototype) {
                        console.warn(definition.tag + " prototype not found in prototype chain for " + definition.is);
                    }
                    definition.native = nativePrototype;
                }
            }
            function instantiate(definition) {
                return upgradeWithDefinition(domCreateElement(definition.tag), definition);
            }
            var registry = {};
            function getRegisteredDefinition(name) {
                if (name) {
                    return registry[name.toLowerCase()];
                }
            }
            function registerDefinition(name, definition) {
                registry[name] = definition;
            }
            function generateConstructor(definition) {
                return function() {
                    return instantiate(definition);
                };
            }
            var HTML_NAMESPACE = "http://www.w3.org/1999/xhtml";
            function createElementNS(namespace, tag, typeExtension) {
                if (namespace === HTML_NAMESPACE) {
                    return createElement(tag, typeExtension);
                } else {
                    return domCreateElementNS(namespace, tag);
                }
            }
            function createElement(tag, typeExtension) {
                if (tag) {
                    tag = tag.toLowerCase();
                }
                if (typeExtension) {
                    typeExtension = typeExtension.toLowerCase();
                }
                var definition = getRegisteredDefinition(typeExtension || tag);
                if (definition) {
                    if (tag == definition.tag && typeExtension == definition.is) {
                        return new definition.ctor();
                    }
                    if (!typeExtension && !definition.is) {
                        return new definition.ctor();
                    }
                }
                var element;
                if (typeExtension) {
                    element = createElement(tag);
                    element.setAttribute("is", typeExtension);
                    return element;
                }
                element = domCreateElement(tag);
                if (tag.indexOf("-") >= 0) {
                    implementPrototype(element, HTMLElement);
                }
                return element;
            }
            var domCreateElement = document.createElement.bind(document);
            var domCreateElementNS = document.createElementNS.bind(document);
            var isInstance;
            if (!Object.__proto__ && !useNative) {
                isInstance = function(obj, ctor) {
                    if (obj instanceof ctor) {
                        return true;
                    }
                    var p = obj;
                    while (p) {
                        if (p === ctor.prototype) {
                            return true;
                        }
                        p = p.__proto__;
                    }
                    return false;
                };
            } else {
                isInstance = function(obj, base) {
                    return obj instanceof base;
                };
            }
            function wrapDomMethodToForceUpgrade(obj, methodName) {
                var orig = obj[methodName];
                obj[methodName] = function() {
                    var n = orig.apply(this, arguments);
                    upgradeAll(n);
                    return n;
                };
            }
            wrapDomMethodToForceUpgrade(Node.prototype, "cloneNode");
            wrapDomMethodToForceUpgrade(document, "importNode");
            document.registerElement = register;
            document.createElement = createElement;
            document.createElementNS = createElementNS;
            scope.registry = registry;
            scope.instanceof = isInstance;
            scope.reservedTagList = reservedTagList;
            scope.getRegisteredDefinition = getRegisteredDefinition;
            document.register = document.registerElement;
        });
        (function(scope) {
            var useNative = scope.useNative;
            var initializeModules = scope.initializeModules;
            var isIE = scope.isIE;
            if (useNative) {
                var nop = function() {};
                scope.watchShadow = nop;
                scope.upgrade = nop;
                scope.upgradeAll = nop;
                scope.upgradeDocumentTree = nop;
                scope.upgradeSubtree = nop;
                scope.takeRecords = nop;
                scope.instanceof = function(obj, base) {
                    return obj instanceof base;
                };
            } else {
                initializeModules();
            }
            var upgradeDocumentTree = scope.upgradeDocumentTree;
            var upgradeDocument = scope.upgradeDocument;
            if (!window.wrap) {
                if (window.ShadowDOMPolyfill) {
                    window.wrap = window.ShadowDOMPolyfill.wrapIfNeeded;
                    window.unwrap = window.ShadowDOMPolyfill.unwrapIfNeeded;
                } else {
                    window.wrap = window.unwrap = function(node) {
                        return node;
                    };
                }
            }
            if (window.HTMLImports) {
                window.HTMLImports.__importsParsingHook = function(elt) {
                    if (elt.import) {
                        upgradeDocument(wrap(elt.import));
                    }
                };
            }
            function bootstrap() {
                upgradeDocumentTree(window.wrap(document));
                window.CustomElements.ready = true;
                var requestAnimationFrame = window.requestAnimationFrame || function(f) {
                    setTimeout(f, 16);
                };
                requestAnimationFrame(function() {
                    setTimeout(function() {
                        window.CustomElements.readyTime = Date.now();
                        if (window.HTMLImports) {
                            window.CustomElements.elapsed = window.CustomElements.readyTime - window.HTMLImports.readyTime;
                        }
                        document.dispatchEvent(new CustomEvent("WebComponentsReady", {
                            bubbles: true
                        }));
                    });
                });
            }
            if (document.readyState === "complete" || scope.flags.eager) {
                bootstrap();
            } else if (document.readyState === "interactive" && !window.attachEvent && (!window.HTMLImports || window.HTMLImports.ready)) {
                bootstrap();
            } else {
                var loadEvent = window.HTMLImports && !window.HTMLImports.ready ? "HTMLImportsLoaded" : "DOMContentLoaded";
                window.addEventListener(loadEvent, bootstrap);
            }
        })(window.CustomElements);
        (function(scope) {
            var style = document.createElement("style");
            style.textContent = "" + "body {" + "transition: opacity ease-in 0.2s;" + " } \n" + "body[unresolved] {" + "opacity: 0; display: block; overflow: hidden; position: relative;" + " } \n";
            var head = document.querySelector("head");
            head.insertBefore(style, head.firstChild);
        })(window.WebComponents);
    }, {} ],
    79: [ function(require, module, exports) {
        "use strict";
        require("core-js/modules/es.symbol.to-primitive.js");
        require("core-js/modules/es.date.to-primitive.js");
        require("core-js/modules/es.symbol.js");
        require("core-js/modules/es.symbol.description.js");
        require("core-js/modules/es.object.to-string.js");
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
                Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
            }
        }
        function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, "prototype", {
                writable: false
            });
            return Constructor;
        }
        function _defineProperty(obj, key, value) {
            key = _toPropertyKey(key);
            if (key in obj) {
                Object.defineProperty(obj, key, {
                    value: value,
                    enumerable: true,
                    configurable: true,
                    writable: true
                });
            } else {
                obj[key] = value;
            }
            return obj;
        }
        function _toPropertyKey(arg) {
            var key = _toPrimitive(arg, "string");
            return typeof key === "symbol" ? key : String(key);
        }
        function _toPrimitive(input, hint) {
            if (typeof input !== "object" || input === null) return input;
            var prim = input[Symbol.toPrimitive];
            if (prim !== undefined) {
                var res = prim.call(input, hint || "default");
                if (typeof res !== "object") return res;
                throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return (hint === "string" ? String : Number)(input);
        }
        var ChromecastSessionManager = function() {
            function ChromecastSessionManager(player) {
                _classCallCheck(this, ChromecastSessionManager);
                this.player = player;
                this._sessionListener = this._onSessionStateChange.bind(this);
                this._castListener = this._onCastStateChange.bind(this);
                this._addCastContextEventListeners();
                this.player.on("dispose", this._removeCastContextEventListeners.bind(this));
                this._notifyPlayerOfDevicesAvailabilityChange(this.getCastContext().getCastState());
                this.remotePlayer = new cast.framework.RemotePlayer();
                this.remotePlayerController = new cast.framework.RemotePlayerController(this.remotePlayer);
            }
            _createClass(ChromecastSessionManager, [ {
                key: "_addCastContextEventListeners",
                value: function _addCastContextEventListeners() {
                    var sessionStateChangedEvt = cast.framework.CastContextEventType.SESSION_STATE_CHANGED, castStateChangedEvt = cast.framework.CastContextEventType.CAST_STATE_CHANGED;
                    this.getCastContext().addEventListener(sessionStateChangedEvt, this._sessionListener);
                    this.getCastContext().addEventListener(castStateChangedEvt, this._castListener);
                }
            }, {
                key: "_removeCastContextEventListeners",
                value: function _removeCastContextEventListeners() {
                    var sessionStateChangedEvt = cast.framework.CastContextEventType.SESSION_STATE_CHANGED, castStateChangedEvt = cast.framework.CastContextEventType.CAST_STATE_CHANGED;
                    this.getCastContext().removeEventListener(sessionStateChangedEvt, this._sessionListener);
                    this.getCastContext().removeEventListener(castStateChangedEvt, this._castListener);
                }
            }, {
                key: "_onSessionStateChange",
                value: function _onSessionStateChange(event) {
                    if (event.sessionState === cast.framework.SessionState.SESSION_ENDED) {
                        this.player.trigger("chromecastDisconnected");
                        this._reloadTech();
                    }
                }
            }, {
                key: "_onCastStateChange",
                value: function _onCastStateChange(event) {
                    this._notifyPlayerOfDevicesAvailabilityChange(event.castState);
                }
            }, {
                key: "_notifyPlayerOfDevicesAvailabilityChange",
                value: function _notifyPlayerOfDevicesAvailabilityChange(castState) {
                    if (this.hasAvailableDevices(castState)) {
                        this.player.trigger("chromecastDevicesAvailable");
                    } else {
                        this.player.trigger("chromecastDevicesUnavailable");
                    }
                }
            }, {
                key: "hasAvailableDevices",
                value: function hasAvailableDevices(castState) {
                    castState = castState || this.getCastContext().getCastState();
                    return castState === cast.framework.CastState.NOT_CONNECTED || castState === cast.framework.CastState.CONNECTING || castState === cast.framework.CastState.CONNECTED;
                }
            }, {
                key: "openCastMenu",
                value: function openCastMenu() {
                    var onSessionSuccess;
                    if (!this.player.currentSource()) {
                        return;
                    }
                    onSessionSuccess = function() {
                        ChromecastSessionManager.hasConnected = true;
                        this.player.trigger("chromecastConnected");
                        this._reloadTech();
                    }.bind(this);
                    this.getCastContext().requestSession().then(onSessionSuccess, function() {});
                }
            }, {
                key: "_reloadTech",
                value: function _reloadTech() {
                    var player = this.player, currentTime = player.currentTime(), wasPaused = player.paused(), sources = player.currentSources();
                    player.src(sources);
                    player.ready(function() {
                        if (wasPaused) {
                            player.pause();
                        } else {
                            player.play();
                        }
                        player.currentTime(currentTime || 0);
                    });
                }
            }, {
                key: "getCastContext",
                value: function getCastContext() {
                    return cast.framework.CastContext.getInstance();
                }
            }, {
                key: "getRemotePlayer",
                value: function getRemotePlayer() {
                    return this.remotePlayer;
                }
            }, {
                key: "getRemotePlayerController",
                value: function getRemotePlayerController() {
                    return this.remotePlayerController;
                }
            } ], [ {
                key: "isChromecastAPIAvailable",
                value: function isChromecastAPIAvailable() {
                    return window.chrome && window.chrome.cast && window.cast;
                }
            }, {
                key: "isChromecastConnected",
                value: function isChromecastConnected() {
                    return ChromecastSessionManager.isChromecastAPIAvailable() && cast.framework.CastContext.getInstance().getCastState() === cast.framework.CastState.CONNECTED && ChromecastSessionManager.hasConnected;
                }
            } ]);
            return ChromecastSessionManager;
        }();
        _defineProperty(ChromecastSessionManager, "hasConnected", false);
        module.exports = ChromecastSessionManager;
    }, {
        "core-js/modules/es.date.to-primitive.js": 72,
        "core-js/modules/es.object.to-string.js": 73,
        "core-js/modules/es.symbol.description.js": 75,
        "core-js/modules/es.symbol.js": 76,
        "core-js/modules/es.symbol.to-primitive.js": 77
    } ],
    80: [ function(require, module, exports) {
        "use strict";
        require("core-js/modules/es.object.to-string.js");
        require("core-js/modules/es.reflect.construct.js");
        require("core-js/modules/es.symbol.to-primitive.js");
        require("core-js/modules/es.date.to-primitive.js");
        require("core-js/modules/es.symbol.js");
        require("core-js/modules/es.symbol.description.js");
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
                Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
            }
        }
        function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, "prototype", {
                writable: false
            });
            return Constructor;
        }
        function _toPropertyKey(arg) {
            var key = _toPrimitive(arg, "string");
            return typeof key === "symbol" ? key : String(key);
        }
        function _toPrimitive(input, hint) {
            if (typeof input !== "object" || input === null) return input;
            var prim = input[Symbol.toPrimitive];
            if (prim !== undefined) {
                var res = prim.call(input, hint || "default");
                if (typeof res !== "object") return res;
                throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return (hint === "string" ? String : Number)(input);
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
            Object.defineProperty(subClass, "prototype", {
                writable: false
            });
            if (superClass) _setPrototypeOf(subClass, superClass);
        }
        function _setPrototypeOf(o, p) {
            _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
                o.__proto__ = p;
                return o;
            };
            return _setPrototypeOf(o, p);
        }
        function _createSuper(Derived) {
            var hasNativeReflectConstruct = _isNativeReflectConstruct();
            return function _createSuperInternal() {
                var Super = _getPrototypeOf(Derived), result;
                if (hasNativeReflectConstruct) {
                    var NewTarget = _getPrototypeOf(this).constructor;
                    result = Reflect.construct(Super, arguments, NewTarget);
                } else {
                    result = Super.apply(this, arguments);
                }
                return _possibleConstructorReturn(this, result);
            };
        }
        function _possibleConstructorReturn(self, call) {
            if (call && (typeof call === "object" || typeof call === "function")) {
                return call;
            } else if (call !== void 0) {
                throw new TypeError("Derived constructors may only return object or undefined");
            }
            return _assertThisInitialized(self);
        }
        function _assertThisInitialized(self) {
            if (self === void 0) {
                throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            }
            return self;
        }
        function _isNativeReflectConstruct() {
            if (typeof Reflect === "undefined" || !Reflect.construct) return false;
            if (Reflect.construct.sham) return false;
            if (typeof Proxy === "function") return true;
            try {
                Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function() {}));
                return true;
            } catch (e) {
                return false;
            }
        }
        function _getPrototypeOf(o) {
            _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
                return o.__proto__ || Object.getPrototypeOf(o);
            };
            return _getPrototypeOf(o);
        }
        module.exports = function(videojs) {
            var ButtonComponent = videojs.getComponent("Button");
            var ChromecastButton = function(_ButtonComponent) {
                _inherits(ChromecastButton, _ButtonComponent);
                var _super = _createSuper(ChromecastButton);
                function ChromecastButton(player, options) {
                    var _this;
                    _classCallCheck(this, ChromecastButton);
                    _this = _super.call(this, player, options);
                    player.on("chromecastConnected", _this._onChromecastConnected.bind(_assertThisInitialized(_this)));
                    player.on("chromecastDisconnected", _this._onChromecastDisconnected.bind(_assertThisInitialized(_this)));
                    player.on("chromecastDevicesAvailable", _this._onChromecastDevicesAvailable.bind(_assertThisInitialized(_this)));
                    player.on("chromecastDevicesUnavailable", _this._onChromecastDevicesUnavailable.bind(_assertThisInitialized(_this)));
                    if (player.chromecastSessionManager && player.chromecastSessionManager.hasAvailableDevices()) {
                        _this._onChromecastDevicesAvailable();
                    } else {
                        _this._onChromecastDevicesUnavailable();
                    }
                    if (options.addCastLabelToButton) {
                        _this.el().classList.add("vjs-chromecast-button-lg");
                        _this._labelEl = document.createElement("span");
                        _this._labelEl.classList.add("vjs-chromecast-button-label");
                        _this._updateCastLabelText();
                        _this.el().appendChild(_this._labelEl);
                    } else {
                        _this.controlText("Open Chromecast menu");
                    }
                    return _this;
                }
                _createClass(ChromecastButton, [ {
                    key: "buildCSSClass",
                    value: function buildCSSClass() {
                        return "vjs-chromecast-button " + (this._isChromecastConnected ? "vjs-chromecast-casting-state " : "") + (this.options_.addCastLabelToButton ? "vjs-chromecast-button-lg " : "") + ButtonComponent.prototype.buildCSSClass();
                    }
                }, {
                    key: "handleClick",
                    value: function handleClick() {
                        this.player().trigger("chromecastRequested");
                    }
                }, {
                    key: "_onChromecastConnected",
                    value: function _onChromecastConnected() {
                        this._isChromecastConnected = true;
                        this._reloadCSSClasses();
                        this._updateCastLabelText();
                    }
                }, {
                    key: "_onChromecastDisconnected",
                    value: function _onChromecastDisconnected() {
                        this._isChromecastConnected = false;
                        this._reloadCSSClasses();
                        this._updateCastLabelText();
                    }
                }, {
                    key: "_onChromecastDevicesAvailable",
                    value: function _onChromecastDevicesAvailable() {
                        this.show();
                    }
                }, {
                    key: "_onChromecastDevicesUnavailable",
                    value: function _onChromecastDevicesUnavailable() {
                        this.hide();
                    }
                }, {
                    key: "_reloadCSSClasses",
                    value: function _reloadCSSClasses() {
                        if (!this.el_) {
                            return;
                        }
                        this.el_.className = this.buildCSSClass();
                    }
                }, {
                    key: "_updateCastLabelText",
                    value: function _updateCastLabelText() {
                        if (!this._labelEl) {
                            return;
                        }
                        this._labelEl.textContent = this._isChromecastConnected ? this.localize("Disconnect Cast") : this.localize("Cast");
                    }
                } ]);
                return ChromecastButton;
            }(ButtonComponent);
            videojs.registerComponent("chromecastButton", ChromecastButton);
        };
    }, {
        "core-js/modules/es.date.to-primitive.js": 72,
        "core-js/modules/es.object.to-string.js": 73,
        "core-js/modules/es.reflect.construct.js": 74,
        "core-js/modules/es.symbol.description.js": 75,
        "core-js/modules/es.symbol.js": 76,
        "core-js/modules/es.symbol.to-primitive.js": 77
    } ],
    81: [ function(require, module, exports) {
        "use strict";
        var ChromecastSessionManager = require("./chromecast/ChromecastSessionManager"), CHECK_AVAILABILITY_INTERVAL = 1e3, CHECK_AVAILABILITY_TIMEOUT = 30 * 1e3;
        function configureCastContext(options) {
            var context = cast.framework.CastContext.getInstance();
            context.setOptions({
                receiverApplicationId: options.receiverAppID || chrome.cast.media.DEFAULT_MEDIA_RECEIVER_APP_ID,
                autoJoinPolicy: chrome.cast.AutoJoinPolicy.ORIGIN_SCOPED
            });
        }
        function onChromecastRequested(player) {
            player.chromecastSessionManager.openCastMenu();
        }
        function setUpChromecastButton(player, options) {
            var indexOpt;
            if (options.addButtonToControlBar && !player.controlBar.getChild("chromecastButton")) {
                indexOpt = player.controlBar.children().length;
                if (typeof options.buttonPositionIndex !== "undefined") {
                    indexOpt = options.buttonPositionIndex >= 0 ? options.buttonPositionIndex : player.controlBar.children().length + options.buttonPositionIndex;
                }
                player.controlBar.addChild("chromecastButton", options, indexOpt);
            }
            player.on("chromecastRequested", onChromecastRequested.bind(null, player));
        }
        function createSessionManager(player) {
            if (!player.chromecastSessionManager) {
                player.chromecastSessionManager = new ChromecastSessionManager(player);
            }
        }
        function enableChromecast(player, options) {
            configureCastContext(options);
            createSessionManager(player);
            setUpChromecastButton(player, options);
        }
        function waitUntilChromecastAPIsAreAvailable(player, options) {
            var maxTries = CHECK_AVAILABILITY_TIMEOUT / CHECK_AVAILABILITY_INTERVAL, tries = 1, intervalID;
            intervalID = setInterval(function() {
                if (tries > maxTries) {
                    clearInterval(intervalID);
                    return;
                }
                if (ChromecastSessionManager.isChromecastAPIAvailable()) {
                    clearInterval(intervalID);
                    enableChromecast(player, options);
                }
                tries = tries + 1;
            }, CHECK_AVAILABILITY_INTERVAL);
        }
        module.exports = function(videojs) {
            videojs.registerPlugin("chromecast", function(options) {
                var pluginOptions = Object.assign({
                    addButtonToControlBar: true
                }, options || {});
                this.ready(function() {
                    if (!this.controlBar) {
                        return;
                    }
                    if (ChromecastSessionManager.isChromecastAPIAvailable()) {
                        enableChromecast(this, pluginOptions);
                    } else {
                        waitUntilChromecastAPIsAreAvailable(this, pluginOptions);
                    }
                }.bind(this));
            });
        };
    }, {
        "./chromecast/ChromecastSessionManager": 79
    } ],
    82: [ function(require, module, exports) {
        "use strict";
        var preloadWebComponents = require("./preloadWebComponents"), createChromecastButton = require("./components/ChromecastButton"), createChromecastTech = require("./tech/ChromecastTech"), enableChromecast = require("./enableChromecast");
        module.exports = function(videojs, userOpts) {
            var options = Object.assign({
                preloadWebComponents: false
            }, userOpts);
            if (options.preloadWebComponents) {
                preloadWebComponents();
            }
            videojs = videojs || window.videojs;
            createChromecastButton(videojs);
            createChromecastTech(videojs);
            enableChromecast(videojs);
        };
    }, {
        "./components/ChromecastButton": 80,
        "./enableChromecast": 81,
        "./preloadWebComponents": 83,
        "./tech/ChromecastTech": 85
    } ],
    83: [ function(require, module, exports) {
        "use strict";
        function doesUserAgentContainString(str) {
            return typeof window.navigator.userAgent === "string" && window.navigator.userAgent.indexOf(str) >= 0;
        }
        module.exports = function() {
            var needsWebComponents = !document.registerElement, iosChrome = doesUserAgentContainString("CriOS"), androidChrome;
            androidChrome = doesUserAgentContainString("Android") && doesUserAgentContainString("Chrome/") && window.navigator.presentation;
            if ((androidChrome || iosChrome) && needsWebComponents) {
                require("webcomponents.js/webcomponents-lite.js");
            }
        };
    }, {
        "webcomponents.js/webcomponents-lite.js": 78
    } ],
    84: [ function(require, module, exports) {
        "use strict";
        require("./index")(undefined, window.SILVERMINE_VIDEOJS_CHROMECAST_CONFIG);
    }, {
        "./index": 82
    } ],
    85: [ function(require, module, exports) {
        "use strict";
        require("core-js/modules/es.object.to-string.js");
        require("core-js/modules/es.reflect.construct.js");
        require("core-js/modules/es.symbol.to-primitive.js");
        require("core-js/modules/es.date.to-primitive.js");
        require("core-js/modules/es.symbol.js");
        require("core-js/modules/es.symbol.description.js");
        require("core-js/modules/es.array.splice.js");
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
                Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
            }
        }
        function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, "prototype", {
                writable: false
            });
            return Constructor;
        }
        function _toPropertyKey(arg) {
            var key = _toPrimitive(arg, "string");
            return typeof key === "symbol" ? key : String(key);
        }
        function _toPrimitive(input, hint) {
            if (typeof input !== "object" || input === null) return input;
            var prim = input[Symbol.toPrimitive];
            if (prim !== undefined) {
                var res = prim.call(input, hint || "default");
                if (typeof res !== "object") return res;
                throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return (hint === "string" ? String : Number)(input);
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
            Object.defineProperty(subClass, "prototype", {
                writable: false
            });
            if (superClass) _setPrototypeOf(subClass, superClass);
        }
        function _setPrototypeOf(o, p) {
            _setPrototypeOf = Object.setPrototypeOf ? Object.setPrototypeOf.bind() : function _setPrototypeOf(o, p) {
                o.__proto__ = p;
                return o;
            };
            return _setPrototypeOf(o, p);
        }
        function _createSuper(Derived) {
            var hasNativeReflectConstruct = _isNativeReflectConstruct();
            return function _createSuperInternal() {
                var Super = _getPrototypeOf(Derived), result;
                if (hasNativeReflectConstruct) {
                    var NewTarget = _getPrototypeOf(this).constructor;
                    result = Reflect.construct(Super, arguments, NewTarget);
                } else {
                    result = Super.apply(this, arguments);
                }
                return _possibleConstructorReturn(this, result);
            };
        }
        function _possibleConstructorReturn(self, call) {
            if (call && (typeof call === "object" || typeof call === "function")) {
                return call;
            } else if (call !== void 0) {
                throw new TypeError("Derived constructors may only return object or undefined");
            }
            return _assertThisInitialized(self);
        }
        function _assertThisInitialized(self) {
            if (self === void 0) {
                throw new ReferenceError("this hasn't been initialised - super() hasn't been called");
            }
            return self;
        }
        function _isNativeReflectConstruct() {
            if (typeof Reflect === "undefined" || !Reflect.construct) return false;
            if (Reflect.construct.sham) return false;
            if (typeof Proxy === "function") return true;
            try {
                Boolean.prototype.valueOf.call(Reflect.construct(Boolean, [], function() {}));
                return true;
            } catch (e) {
                return false;
            }
        }
        function _getPrototypeOf(o) {
            _getPrototypeOf = Object.setPrototypeOf ? Object.getPrototypeOf.bind() : function _getPrototypeOf(o) {
                return o.__proto__ || Object.getPrototypeOf(o);
            };
            return _getPrototypeOf(o);
        }
        var ChromecastSessionManager = require("../chromecast/ChromecastSessionManager"), ChromecastTechUI = require("./ChromecastTechUI");
        module.exports = function(videojs) {
            var Tech = videojs.getComponent("Tech"), SESSION_TIMEOUT = 10 * 1e3;
            var ChromecastTech = function(_Tech) {
                _inherits(ChromecastTech, _Tech);
                var _super = _createSuper(ChromecastTech);
                function ChromecastTech(options) {
                    var _this;
                    _classCallCheck(this, ChromecastTech);
                    _this = _super.call(this, options);
                    _this.featuresVolumeControl = true;
                    _this.featuresPlaybackRate = false;
                    _this.movingMediaElementInDOM = false;
                    _this.featuresFullscreenResize = true;
                    _this.featuresTimeupdateEvents = true;
                    _this.featuresProgressEvents = false;
                    _this.featuresNativeTextTracks = false;
                    _this.featuresNativeAudioTracks = false;
                    _this.featuresNativeVideoTracks = false;
                    _this.videojs = videojs;
                    _this._eventListeners = [];
                    _this.videojsPlayer = _this.videojs(options.playerId);
                    _this._chromecastSessionManager = _this.videojsPlayer.chromecastSessionManager;
                    _this._ui.updatePoster(_this.videojsPlayer.poster());
                    _this._remotePlayer = _this._chromecastSessionManager.getRemotePlayer();
                    _this._remotePlayerController = _this._chromecastSessionManager.getRemotePlayerController();
                    _this._listenToPlayerControllerEvents();
                    _this.on("dispose", _this._removeAllEventListeners.bind(_assertThisInitialized(_this)));
                    _this._hasPlayedAnyItem = false;
                    _this._requestTitle = options.requestTitleFn || function() {};
                    _this._requestSubtitle = options.requestSubtitleFn || function() {};
                    _this._requestCustomData = options.requestCustomDataFn || function() {};
                    _this._modifyLoadRequestFn = options.modifyLoadRequestFn || function(request) {
                        return request;
                    };
                    _this._initialStartTime = options.startTime || 0;
                    _this._playSource(options.source, _this._initialStartTime);
                    _this.ready(function() {
                        this.setMuted(options.muted);
                    }.bind(_assertThisInitialized(_this)));
                    return _this;
                }
                _createClass(ChromecastTech, [ {
                    key: "createEl",
                    value: function createEl() {
                        this._ui = this._ui || new ChromecastTechUI();
                        return this._ui.getDOMElement();
                    }
                }, {
                    key: "play",
                    value: function play() {
                        if (!this.paused()) {
                            return;
                        }
                        if (this.ended() && !this._isMediaLoading) {
                            this._playSource({
                                src: this.videojsPlayer.src()
                            }, 0);
                        } else {
                            this._remotePlayerController.playOrPause();
                        }
                    }
                }, {
                    key: "pause",
                    value: function pause() {
                        if (!this.paused() && this._remotePlayer.canPause) {
                            this._remotePlayerController.playOrPause();
                        }
                    }
                }, {
                    key: "paused",
                    value: function paused() {
                        return this._remotePlayer.isPaused || this.ended() || this._remotePlayer.playerState === null;
                    }
                }, {
                    key: "setSource",
                    value: function setSource(source) {
                        if (this._currentSource && this._currentSource.src === source.src && this._currentSource.type === source.type) {
                            return;
                        }
                        this._currentSource = source;
                        this._playSource(source, 0);
                    }
                }, {
                    key: "_playSource",
                    value: function _playSource(source, startTime) {
                        var castSession = this._getCastSession(), mediaInfo = new chrome.cast.media.MediaInfo(source.src, source.type), title = this._requestTitle(source), subtitle = this._requestSubtitle(source), poster = this.poster(), customData = this._requestCustomData(source), request;
                        this.trigger("waiting");
                        this._clearSessionTimeout();
                        mediaInfo.metadata = new chrome.cast.media.GenericMediaMetadata();
                        mediaInfo.metadata.metadataType = chrome.cast.media.MetadataType.GENERIC;
                        mediaInfo.metadata.title = title;
                        mediaInfo.metadata.subtitle = subtitle;
                        mediaInfo.streamType = this.videojsPlayer.liveTracker && this.videojsPlayer.liveTracker.isLive() ? chrome.cast.media.StreamType.LIVE : chrome.cast.media.StreamType.BUFFERED;
                        if (poster) {
                            mediaInfo.metadata.images = [ {
                                url: poster
                            } ];
                        }
                        if (customData) {
                            mediaInfo.customData = customData;
                        }
                        this._ui.updateTitle(title);
                        this._ui.updateSubtitle(subtitle);
                        request = new chrome.cast.media.LoadRequest(mediaInfo);
                        request.autoplay = true;
                        request.currentTime = startTime;
                        request = this._modifyLoadRequestFn(request);
                        this._isMediaLoading = true;
                        this._hasPlayedCurrentItem = false;
                        castSession.loadMedia(request).then(function() {
                            this._clearSessionTimeout();
                            if (!this._hasPlayedAnyItem) {
                                this.triggerReady();
                            }
                            this.trigger("loadstart");
                            this.trigger("loadeddata");
                            this.trigger("play");
                            this.trigger("playing");
                            this._hasPlayedAnyItem = true;
                            this._isMediaLoading = false;
                            this._getMediaSession().addUpdateListener(this._onMediaSessionStatusChanged.bind(this));
                        }.bind(this), this._triggerErrorEvent.bind(this));
                    }
                }, {
                    key: "setCurrentTime",
                    value: function setCurrentTime(time) {
                        var duration = this.duration();
                        if (time > duration || !this._remotePlayer.canSeek) {
                            return;
                        }
                        this._remotePlayer.currentTime = Math.min(duration - 1, time);
                        this._remotePlayerController.seek();
                        this._triggerTimeUpdateEvent();
                    }
                }, {
                    key: "currentTime",
                    value: function currentTime() {
                        if (!this._hasPlayedAnyItem) {
                            return this._initialStartTime;
                        }
                        return this._remotePlayer.currentTime;
                    }
                }, {
                    key: "duration",
                    value: function duration() {
                        if (!this._hasPlayedAnyItem) {
                            return this.videojsPlayer.duration();
                        }
                        return this._remotePlayer.duration;
                    }
                }, {
                    key: "ended",
                    value: function ended() {
                        var mediaSession = this._getMediaSession();
                        if (!mediaSession && this._hasMediaSessionEnded) {
                            return true;
                        }
                        return mediaSession ? mediaSession.idleReason === chrome.cast.media.IdleReason.FINISHED : false;
                    }
                }, {
                    key: "volume",
                    value: function volume() {
                        return this._remotePlayer.volumeLevel;
                    }
                }, {
                    key: "setVolume",
                    value: function setVolume(volumeLevel) {
                        this._remotePlayer.volumeLevel = volumeLevel;
                        this._remotePlayerController.setVolumeLevel();
                        this._triggerVolumeChangeEvent();
                    }
                }, {
                    key: "muted",
                    value: function muted() {
                        return this._remotePlayer.isMuted;
                    }
                }, {
                    key: "setMuted",
                    value: function setMuted(isMuted) {
                        if (this._remotePlayer.isMuted && !isMuted || !this._remotePlayer.isMuted && isMuted) {
                            this._remotePlayerController.muteOrUnmute();
                        }
                    }
                }, {
                    key: "poster",
                    value: function poster() {
                        return this._ui.getPoster();
                    }
                }, {
                    key: "setPoster",
                    value: function setPoster(poster) {
                        this._ui.updatePoster(poster);
                    }
                }, {
                    key: "buffered",
                    value: function buffered() {
                        return undefined;
                    }
                }, {
                    key: "seekable",
                    value: function seekable() {
                        return this.videojs.createTimeRange(0, this.duration());
                    }
                }, {
                    key: "controls",
                    value: function controls() {
                        return false;
                    }
                }, {
                    key: "playsinline",
                    value: function playsinline() {
                        return true;
                    }
                }, {
                    key: "supportsFullScreen",
                    value: function supportsFullScreen() {
                        return true;
                    }
                }, {
                    key: "setAutoplay",
                    value: function setAutoplay() {}
                }, {
                    key: "playbackRate",
                    value: function playbackRate() {
                        var mediaSession = this._getMediaSession();
                        return mediaSession ? mediaSession.playbackRate : 1;
                    }
                }, {
                    key: "setPlaybackRate",
                    value: function setPlaybackRate() {}
                }, {
                    key: "preload",
                    value: function preload() {}
                }, {
                    key: "load",
                    value: function load() {}
                }, {
                    key: "readyState",
                    value: function readyState() {
                        if (this._remotePlayer.playerState === "IDLE" || this._remotePlayer.playerState === "BUFFERING") {
                            return 0;
                        }
                        return 4;
                    }
                }, {
                    key: "_listenToPlayerControllerEvents",
                    value: function _listenToPlayerControllerEvents() {
                        var eventTypes = cast.framework.RemotePlayerEventType;
                        this._addEventListener(this._remotePlayerController, eventTypes.PLAYER_STATE_CHANGED, this._onPlayerStateChanged, this);
                        this._addEventListener(this._remotePlayerController, eventTypes.VOLUME_LEVEL_CHANGED, this._triggerVolumeChangeEvent, this);
                        this._addEventListener(this._remotePlayerController, eventTypes.IS_MUTED_CHANGED, this._triggerVolumeChangeEvent, this);
                        this._addEventListener(this._remotePlayerController, eventTypes.CURRENT_TIME_CHANGED, this._triggerTimeUpdateEvent, this);
                        this._addEventListener(this._remotePlayerController, eventTypes.DURATION_CHANGED, this._triggerDurationChangeEvent, this);
                    }
                }, {
                    key: "_addEventListener",
                    value: function _addEventListener(target, type, callback, context) {
                        var listener;
                        listener = {
                            target: target,
                            type: type,
                            callback: callback,
                            context: context,
                            listener: callback.bind(context)
                        };
                        target.addEventListener(type, listener.listener);
                        this._eventListeners.push(listener);
                    }
                }, {
                    key: "_removeAllEventListeners",
                    value: function _removeAllEventListeners() {
                        while (this._eventListeners.length > 0) {
                            this._removeEventListener(this._eventListeners[0]);
                        }
                        this._eventListeners = [];
                    }
                }, {
                    key: "_removeEventListener",
                    value: function _removeEventListener(listener) {
                        var index = -1, pass = false, i;
                        listener.target.removeEventListener(listener.type, listener.listener);
                        for (i = 0; i < this._eventListeners.length; i++) {
                            pass = this._eventListeners[i].target === listener.target && this._eventListeners[i].type === listener.type && this._eventListeners[i].callback === listener.callback && this._eventListeners[i].context === listener.context;
                            if (pass) {
                                index = i;
                                break;
                            }
                        }
                        if (index !== -1) {
                            this._eventListeners.splice(index, 1);
                        }
                    }
                }, {
                    key: "_onPlayerStateChanged",
                    value: function _onPlayerStateChanged() {
                        var states = chrome.cast.media.PlayerState, playerState = this._remotePlayer.playerState;
                        if (playerState === states.PLAYING) {
                            this._hasPlayedCurrentItem = true;
                            this.trigger("play");
                            this.trigger("playing");
                        } else if (playerState === states.PAUSED) {
                            this.trigger("pause");
                        } else if (playerState === states.IDLE && this.ended() || playerState === null && this._hasPlayedCurrentItem) {
                            this._hasPlayedCurrentItem = false;
                            this._closeSessionOnTimeout();
                            this.trigger("ended");
                            this._triggerTimeUpdateEvent();
                        } else if (playerState === states.BUFFERING) {
                            this.trigger("waiting");
                        }
                    }
                }, {
                    key: "_onMediaSessionStatusChanged",
                    value: function _onMediaSessionStatusChanged(isAlive) {
                        this._hasMediaSessionEnded = !!isAlive;
                    }
                }, {
                    key: "_closeSessionOnTimeout",
                    value: function _closeSessionOnTimeout() {
                        this._clearSessionTimeout();
                        this._sessionTimeoutID = setTimeout(function() {
                            var castSession = this._getCastSession();
                            if (castSession) {
                                castSession.endSession(true);
                            }
                            this._clearSessionTimeout();
                        }.bind(this), SESSION_TIMEOUT);
                    }
                }, {
                    key: "_clearSessionTimeout",
                    value: function _clearSessionTimeout() {
                        if (this._sessionTimeoutID) {
                            clearTimeout(this._sessionTimeoutID);
                            this._sessionTimeoutID = false;
                        }
                    }
                }, {
                    key: "_getCastContext",
                    value: function _getCastContext() {
                        return this._chromecastSessionManager.getCastContext();
                    }
                }, {
                    key: "_getCastSession",
                    value: function _getCastSession() {
                        return this._getCastContext().getCurrentSession();
                    }
                }, {
                    key: "_getMediaSession",
                    value: function _getMediaSession() {
                        var castSession = this._getCastSession();
                        return castSession ? castSession.getMediaSession() : null;
                    }
                }, {
                    key: "_triggerVolumeChangeEvent",
                    value: function _triggerVolumeChangeEvent() {
                        this.trigger("volumechange");
                    }
                }, {
                    key: "_triggerTimeUpdateEvent",
                    value: function _triggerTimeUpdateEvent() {
                        this.trigger("timeupdate");
                    }
                }, {
                    key: "_triggerDurationChangeEvent",
                    value: function _triggerDurationChangeEvent() {
                        this.trigger("durationchange");
                    }
                }, {
                    key: "_triggerErrorEvent",
                    value: function _triggerErrorEvent() {
                        this.trigger("error");
                    }
                } ]);
                return ChromecastTech;
            }(Tech);
            ChromecastTech.canPlaySource = function() {
                return ChromecastSessionManager.isChromecastConnected();
            };
            ChromecastTech.isSupported = function() {
                return ChromecastSessionManager.isChromecastConnected();
            };
            videojs.registerTech("chromecast", ChromecastTech);
        };
    }, {
        "../chromecast/ChromecastSessionManager": 79,
        "./ChromecastTechUI": 86,
        "core-js/modules/es.array.splice.js": 71,
        "core-js/modules/es.date.to-primitive.js": 72,
        "core-js/modules/es.object.to-string.js": 73,
        "core-js/modules/es.reflect.construct.js": 74,
        "core-js/modules/es.symbol.description.js": 75,
        "core-js/modules/es.symbol.js": 76,
        "core-js/modules/es.symbol.to-primitive.js": 77
    } ],
    86: [ function(require, module, exports) {
        "use strict";
        require("core-js/modules/es.symbol.to-primitive.js");
        require("core-js/modules/es.date.to-primitive.js");
        require("core-js/modules/es.symbol.js");
        require("core-js/modules/es.symbol.description.js");
        require("core-js/modules/es.object.to-string.js");
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
                Object.defineProperty(target, _toPropertyKey(descriptor.key), descriptor);
            }
        }
        function _createClass(Constructor, protoProps, staticProps) {
            if (protoProps) _defineProperties(Constructor.prototype, protoProps);
            if (staticProps) _defineProperties(Constructor, staticProps);
            Object.defineProperty(Constructor, "prototype", {
                writable: false
            });
            return Constructor;
        }
        function _toPropertyKey(arg) {
            var key = _toPrimitive(arg, "string");
            return typeof key === "symbol" ? key : String(key);
        }
        function _toPrimitive(input, hint) {
            if (typeof input !== "object" || input === null) return input;
            var prim = input[Symbol.toPrimitive];
            if (prim !== undefined) {
                var res = prim.call(input, hint || "default");
                if (typeof res !== "object") return res;
                throw new TypeError("@@toPrimitive must return a primitive value.");
            }
            return (hint === "string" ? String : Number)(input);
        }
        var ChromecastTechUI = function() {
            function ChromecastTechUI() {
                _classCallCheck(this, ChromecastTechUI);
                this._el = this._createDOMElement();
            }
            _createClass(ChromecastTechUI, [ {
                key: "_createDOMElement",
                value: function _createDOMElement() {
                    var el = this._createElement("div", "vjs-tech vjs-tech-chromecast"), posterContainerEl = this._createElement("div", "vjs-tech-chromecast-poster"), posterImageEl = this._createElement("img", "vjs-tech-chromecast-poster-img"), titleEl = this._createElement("div", "vjs-tech-chromecast-title"), subtitleEl = this._createElement("div", "vjs-tech-chromecast-subtitle"), titleContainer = this._createElement("div", "vjs-tech-chromecast-title-container");
                    posterContainerEl.appendChild(posterImageEl);
                    titleContainer.appendChild(titleEl);
                    titleContainer.appendChild(subtitleEl);
                    el.appendChild(titleContainer);
                    el.appendChild(posterContainerEl);
                    return el;
                }
            }, {
                key: "_createElement",
                value: function _createElement(type, className) {
                    var el = document.createElement(type);
                    el.className = className;
                    return el;
                }
            }, {
                key: "getDOMElement",
                value: function getDOMElement() {
                    return this._el;
                }
            }, {
                key: "_findPosterEl",
                value: function _findPosterEl() {
                    return this._el.querySelector(".vjs-tech-chromecast-poster");
                }
            }, {
                key: "_findPosterImageEl",
                value: function _findPosterImageEl() {
                    return this._el.querySelector(".vjs-tech-chromecast-poster-img");
                }
            }, {
                key: "_findTitleEl",
                value: function _findTitleEl() {
                    return this._el.querySelector(".vjs-tech-chromecast-title");
                }
            }, {
                key: "_findSubtitleEl",
                value: function _findSubtitleEl() {
                    return this._el.querySelector(".vjs-tech-chromecast-subtitle");
                }
            }, {
                key: "updatePoster",
                value: function updatePoster(poster) {
                    var posterImageEl = this._findPosterImageEl();
                    this._poster = poster ? poster : null;
                    if (poster) {
                        posterImageEl.setAttribute("src", poster);
                        posterImageEl.classList.remove("vjs-tech-chromecast-poster-img-empty");
                    } else {
                        posterImageEl.removeAttribute("src");
                        posterImageEl.classList.add("vjs-tech-chromecast-poster-img-empty");
                    }
                }
            }, {
                key: "getPoster",
                value: function getPoster() {
                    return this._poster;
                }
            }, {
                key: "updateTitle",
                value: function updateTitle(title) {
                    var titleEl = this._findTitleEl();
                    this._title = title;
                    if (title) {
                        titleEl.innerHTML = title;
                        titleEl.classList.remove("vjs-tech-chromecast-title-empty");
                    } else {
                        titleEl.classList.add("vjs-tech-chromecast-title-empty");
                    }
                }
            }, {
                key: "updateSubtitle",
                value: function updateSubtitle(subtitle) {
                    var subtitleEl = this._findSubtitleEl();
                    this._subtitle = subtitle;
                    if (subtitle) {
                        subtitleEl.innerHTML = subtitle;
                        subtitleEl.classList.remove("vjs-tech-chromecast-subtitle-empty");
                    } else {
                        subtitleEl.classList.add("vjs-tech-chromecast-subtitle-empty");
                    }
                }
            } ]);
            return ChromecastTechUI;
        }();
        module.exports = ChromecastTechUI;
    }, {
        "core-js/modules/es.date.to-primitive.js": 72,
        "core-js/modules/es.object.to-string.js": 73,
        "core-js/modules/es.symbol.description.js": 75,
        "core-js/modules/es.symbol.js": 76,
        "core-js/modules/es.symbol.to-primitive.js": 77
    } ]
}, {}, [ 84 ]);