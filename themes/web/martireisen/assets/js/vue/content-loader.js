(function (global, factory) {
  typeof exports === 'object' && typeof module !== 'undefined' ? factory(exports) :
  typeof define === 'function' && define.amd ? define(['exports'], factory) :
  (factory((global.contentLoaders = {})));
}(this, (function (exports) { 'use strict';

  var nestRE = /^(attrs|props|on|nativeOn|class|style|hook)$/;

  var babelHelperVueJsxMergeProps = function mergeJSXProps (objs) {
    return objs.reduce(function (a, b) {
      var aa, bb, key, nestedKey, temp;
      for (key in b) {
        aa = a[key];
        bb = b[key];
        if (aa && nestRE.test(key)) {
          // normalize class
          if (key === 'class') {
            if (typeof aa === 'string') {
              temp = aa;
              a[key] = aa = {};
              aa[temp] = true;
            }
            if (typeof bb === 'string') {
              temp = bb;
              b[key] = bb = {};
              bb[temp] = true;
            }
          }
          if (key === 'on' || key === 'nativeOn' || key === 'hook') {
            // merge functions
            for (nestedKey in bb) {
              aa[nestedKey] = mergeFn(aa[nestedKey], bb[nestedKey]);
            }
          } else if (Array.isArray(aa)) {
            a[key] = aa.concat(bb);
          } else if (Array.isArray(bb)) {
            a[key] = [aa].concat(bb);
          } else {
            for (nestedKey in bb) {
              aa[nestedKey] = bb[nestedKey];
            }
          }
        } else {
          a[key] = b[key];
        }
      }
      return a
    }, {})
  };

  function mergeFn (a, b) {
    return function () {
      a && a.apply(this, arguments);
      b && b.apply(this, arguments);
    }
  }

  var uid = (function () {
    return Math.random().toString(36).substring(2);
  });

  var ContentLoader = {
    name: 'ContentLoader',
    functional: true,
    props: {
      width: {
        type: Number,
        default: 400
      },
      height: {
        type: Number,
        default: 130
      },
      speed: {
        type: Number,
        default: 2
      },
      preserveAspectRatio: {
        type: String,
        default: 'xMidYMid meet'
      },
      primaryColor: {
        type: String,
        default: '#f9f9f9'
      },
      secondaryColor: {
        type: String,
        default: '#ecebeb'
      },
      uniqueKey: {
        type: String
      },
      animate: {
        type: Boolean,
        default: true
      }
    },
    render: function render(h, _ref) {
      var props = _ref.props,
          data = _ref.data,
          children = _ref.children;
      var idClip = props.uniqueKey ? "".concat(props.uniqueKey, "-idClip") : uid();
      var idGradient = props.uniqueKey ? "".concat(props.uniqueKey, "-idGradient") : uid();
      return h("svg", babelHelperVueJsxMergeProps([data, {
        attrs: {
          viewBox: "0 0 ".concat(props.width, " ").concat(props.height),
          version: "1.1",
          preserveAspectRatio: props.preserveAspectRatio
        }
      }]), [h("rect", {
        style: {
          fill: "url(#".concat(idGradient, ")")
        },
        attrs: {
          "clip-path": "url(#".concat(idClip, ")"),
          x: "0",
          y: "0",
          width: props.width,
          height: props.height
        }
      }), h("defs", [h("clipPath", {
        attrs: {
          id: idClip
        }
      }, [children || h("rect", {
        attrs: {
          x: "0",
          y: "0",
          rx: "5",
          ry: "5",
          width: props.width,
          height: props.height
        }
      })]), h("linearGradient", {
        attrs: {
          id: idGradient
        }
      }, [h("stop", {
        attrs: {
          offset: "0%",
          "stop-color": props.primaryColor
        }
      }, [props.animate ? h("animate", {
        attrs: {
          attributeName: "offset",
          values: "-2; 1",
          dur: "".concat(props.speed, "s"),
          repeatCount: "indefinite"
        }
      }) : null]), h("stop", {
        attrs: {
          offset: "50%",
          "stop-color": props.secondaryColor
        }
      }, [props.animate ? h("animate", {
        attrs: {
          attributeName: "offset",
          values: "-1.5; 1.5",
          dur: "".concat(props.speed, "s"),
          repeatCount: "indefinite"
        }
      }) : null]), h("stop", {
        attrs: {
          offset: "100%",
          "stop-color": props.primaryColor
        }
      }, [props.animate ? h("animate", {
        attrs: {
          attributeName: "offset",
          values: "-1; 2",
          dur: "".concat(props.speed, "s"),
          repeatCount: "indefinite"
        }
      }) : null])])])]);
    }
  };

  var BulletListLoader = {
    name: 'BulletListLoader',
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data;
      return h(ContentLoader, data, [h("circle", {
        attrs: {
          cx: "10",
          cy: "20",
          r: "8"
        }
      }), h("rect", {
        attrs: {
          x: "25",
          y: "15",
          rx: "5",
          ry: "5",
          width: "220",
          height: "10"
        }
      }), h("circle", {
        attrs: {
          cx: "10",
          cy: "50",
          r: "8"
        }
      }), h("rect", {
        attrs: {
          x: "25",
          y: "45",
          rx: "5",
          ry: "5",
          width: "220",
          height: "10"
        }
      }), h("circle", {
        attrs: {
          cx: "10",
          cy: "80",
          r: "8"
        }
      }), h("rect", {
        attrs: {
          x: "25",
          y: "75",
          rx: "5",
          ry: "5",
          width: "220",
          height: "10"
        }
      }), h("circle", {
        attrs: {
          cx: "10",
          cy: "110",
          r: "8"
        }
      }), h("rect", {
        attrs: {
          x: "25",
          y: "105",
          rx: "5",
          ry: "5",
          width: "220",
          height: "10"
        }
      })]);
    }
  };
  
  var ListLoader = {
    name: 'ListLoader',
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data;
      return h(ContentLoader, data, [h("rect", {
        attrs: {
          x: "0",
          y: "0",
          rx: "3",
          ry: "3",
          width: "480",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "20",
          rx: "3",
          ry: "3",
          width: "220",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "40",
          rx: "3",
          ry: "3",
          width: "320",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "0",
          y: "60",
          rx: "3",
          ry: "3",
          width: "480",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "80",
          rx: "3",
          ry: "3",
          width: "380",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "100",
          rx: "3",
          ry: "3",
          width: "140",
          height: "10"
        }
        }), h("rect", {
         attrs: {
          x: "0",
          y: "120",
          rx: "3",
          ry: "3",
          width: "480",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "140",
          rx: "3",
          ry: "3",
          width: "220",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "160",
          rx: "3",
          ry: "3",
          width: "320",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "0",
          y: "60",
          rx: "3",
          ry: "3",
          width: "480",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "180",
          rx: "3",
          ry: "3",
          width: "380",
          height: "10"
        }
      }), h("rect", {
        attrs: {
          x: "20",
          y: "200",
          rx: "3",
          ry: "3",
          width: "140",
          height: "10"
        }
      })]);
    }
  };

  var HotelLoader = {
    name: 'HotelLoader',
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data;
      return h(ContentLoader, babelHelperVueJsxMergeProps([data, {
        attrs: {
          height: 480
        }
      }]), [h("rect", {
        attrs: {
          x: "0",
          y: "0",
          width: "495",
          height: "358"
        }
      }), h("rect", {
        attrs: {
          x: "520",
          y: "0",
          width: "320",
          height: "15"
        }
      }), h("rect", {
        attrs: {
          x: "520",
          y: "30",
          width: "250",
          height: "15"
        }
      }),h("rect", {
        attrs: {
          x: "520",
          y: "60",
          width: "50",
          height: "15"
        }
      }),h("rect", {
        attrs: {
          x: "520",
          y: "90",
          width: "65",
          height: "15"
        }
      }),h("rect", {
        attrs: {
          x: "520",
          rx : "5",
          ry : "5",
          y: "125",
          width: "320",
          height: "50"
        }
      })]);
    }
  };
  
var HotelOfferLoader = {
    name: 'HotelOfferLoader',
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data;
      return h(ContentLoader, babelHelperVueJsxMergeProps([data, {
        attrs: {
          height: 480
        }
      }]), [h("rect", {
        attrs: {
          x: "10",
          y: "15.27",
          width: "159",
          height: "120"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "21.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "36.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "52.27",
          width: "269",
          height: "9"
        }
      }),h("rect", {
        attrs: {
          x: "507.5",
          y: "21.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "507.5",
          y: "36.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "507.5",
          y: "52.27",
          width: "269",
          height: "9"
        }
      }),h("rect", {
        attrs: {
          x: "10",
          y: "170.27",
          width: "159",
          height: "120"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "185.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "198.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "216.5",
          y: "213.27",
          width: "269",
          height: "9"
        }
      }),h("rect", {
        attrs: {
          x: "507.5",
          y: "213.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "507.5",
          y: "183.27",
          width: "269",
          height: "9"
        }
      }), h("rect", {
        attrs: {
          x: "507.5",
          y: "198.27",
          width: "269",
          height: "9"
        }
      })]);
    }
  };
  
   
var HotelLandingLoader = {
    name: 'HotelLandingLoader',
    functional: true,
    render: function render(h, _ref) {
      var data = _ref.data;
      return h(ContentLoader, babelHelperVueJsxMergeProps([data, {
        attrs: {
          height: 450,
          width:350,
          
        }
      }]), [h("rect", {
        attrs: {
          x: "18",
          y: "270",
          width: "313",
          height: "13",
          rx :"4",
          ry : "5"
        }
      }),h("rect", {
        attrs: {
          x: "4",
          y: "-2",
          width: "400",
          height: "250",
          rx :"5",
          ry : "5"
        }
      }), h("rect", {
        attrs: {
          x: "18",
          y: "300.08",
          width: "143.98",
          height: "16.38",
          rx :"4",
          ry : "4"
        }
      }), h("rect", {
        attrs: {
          x: "18",
          y: "360.08",
          width: "313",
          height: "36.79",
          rx :"4",
          ry : "4"
        }
      }),  
  
        ]);
    }
  };

  exports.ContentLoader = ContentLoader;
  exports.BulletListLoader = BulletListLoader;
  exports.HotelLoader = HotelLoader;
  exports.ListLoader = ListLoader;
  exports.HotelOfferLoader = HotelOfferLoader;  
  exports.HotelLandingLoader = HotelLandingLoader;  


  Object.defineProperty(exports, '__esModule', { value: true });

})));