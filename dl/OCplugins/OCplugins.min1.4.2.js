
function OCplugins(_0xeec3x2) {
    this.i = window.location.href, 
	this.b = localStorage.getItem(this.i), 
	this.a = "OCplugins-" + Math.floor(9999999 * Math.random()), 
	this.C = "./OCplugins/js/jwplayer.min.js", 
	this.A = "./OCplugins/js/resize.min.js", 
	this.l = _0xeec3x2.l || "OCplugins", 
	this.g = _0xeec3x2.g || "", 
	this.F = _0xeec3x2.sub || "", 
	this.w = _0xeec3x2.skin || "seven", 
	this.u = _0xeec3x2.autostart || !1, 
	this.s = _0xeec3x2.aspectratio || "", 
	this.L = _0xeec3x2.logo || "", 
	this.D = _0xeec3x2.ads || 0, 
	this.m = _0xeec3x2.width || 0, 
	this.h = _0xeec3x2.height || 0, 
	this.v = [], 
	this.j = this.c = !1, 
	this.M = _0xeec3x2.private || !1, 
	this.K = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=", 
	this.J = this.i.split("/")[4], 
	this.G = _0xeec3x2.url || "", 
	$("#" + this.l).append("<style type='text/css'>#oc-ac,#oc-bch{font-weight:700;background:#0C885A;color:#fff}#overlay,#oc-a,#oc-ab,#oc-bc{position:absolute}#overlay{background:rgba(0,0,0,.61);top:0;left:0;right:0;bottom:0;width:100%;height:100%;z-index:9999}#oc-bch{font-size:1.1em;padding:10px}#oc-bc{z-index:999999999;color:#000;width:345px;height:166px;background:#fff;border-radius:0 0 5px 5px}#oc-bcb{background:#fff;font-size:12px;text-align:center;padding:10px;line-height:30px;border-bottom:2px solid #f1f1f1}#oc-bcf{padding:10px;text-align:right}#oc-cc,#oc-co{padding:6px;border-radius:3px;cursor:pointer;opacity:.9}#oc-co{background:#337ab7;border:#2e6da4;color:#fff;margin-right:5px}#oc-cc:hover,#oc-co:hover{opacity:1}#oc-cc{background:#c9302c;border:#ac2925;color:#fff}#oc-ab{z-index:99999999;left:50%}#oc-ac{font-size:16px;cursor:pointer;right:0;padding:5px 8px;position:absolute;border-radius:0 0 0 10px}</style>"), 
	this.M || m(this, {
        method: "POST",
        url: window.location.href + this.G,
        dataType: "json",
        data: "type=directLink"
    }, this.f)
}

function n(_0xeec3x2, x) {
    $("#" + _0xeec3x2.l).append("<div id='" + _0xeec3x2.a + "'></div>");
    var _0xeec3x5;
    "undefined" != typeof jwplayer && jwplayer ? p(_0xeec3x2, x) : ($("#" + _0xeec3x2.a).append("<script src='" + _0xeec3x2.C + "'></script>"), _0xeec3x5 = setInterval(function() {
        "undefined" != typeof jwplayer && jwplayer && (clearInterval(_0xeec3x5), p(_0xeec3x2, x))
    }, 100))
}

function p(_0xeec3x2, x) {
    var _0xeec3x5 = {
        width: "100%",
        height: "100%"
    };
    _0xeec3x5.aspectratio = _0xeec3x2.s, _0xeec3x5.skin = _0xeec3x2.w, _0xeec3x5.autostart = _0xeec3x2.u, _0xeec3x5.logo = {
        file: _0xeec3x2.L,
        hide: !0,
        position: "top-left",
        margin: 8
    };
    for (var _0xeec3x7 = [], _0xeec3x8 = x.list, n = 0; n < _0xeec3x8.length; n++) {
        var _0xeec3x9 = "";
        _0xeec3x9 = "undefined" != _0xeec3x8[n].private && _0xeec3x8[n].private ? d(_0xeec3x8[n].file) : _0xeec3x8[n].file, _0xeec3x7[n] = {
            file: _0xeec3x9,
            label: _0xeec3x8[n].label,
            type: "video/mp4",
            ca: "metadata",
            "default": "360p" === _0xeec3x8[n].label ? !0 : !1
        }
    };
    _0xeec3x5.playlist = [{
        title: x.title,
        image: _0xeec3x2.g ? _0xeec3x2.g : x.image,
        sources: _0xeec3x7,
        tracks: [{
            file: _0xeec3x2.F,
            "default": !0
        }]
    }], _0xeec3x5.events = r(_0xeec3x2), _0xeec3x5.captions = {
        color: "#fff",
        fontSize: 16,
        backgroundOpacity: 50
    }, jwplayer(_0xeec3x2.a).setup(_0xeec3x5), _0xeec3x2.v = _0xeec3x5.playlist, t(_0xeec3x2), u(_0xeec3x2)
}

function r(_0xeec3x2) {
    return {
        onTime: function() {
            time = jwplayer(_0xeec3x2.a).getPosition(), localStorage.setItem(_0xeec3x2.i, parseInt(time))
        },
        onPause: function() {
            _0xeec3x2.D && ("undefined" == typeof resize && $("#" + _0xeec3x2.a).append("<script src='" + _0xeec3x2.A + "'></script>"), w(_0xeec3x2, jwplayer(_0xeec3x2.a).getWidth(), jwplayer(_0xeec3x2.a).getHeight()))
        },
        onSeek: function(_0xeec3x2) {
            timeToSeek = _0xeec3x2.offset
        },
        onError: function() {
            _0xeec3x2.c += 1, 3 >= _0xeec3x2.c ? x(_0xeec3x2, _0xeec3x2.v) : _0xeec3x2.f("Vui l??ng ki???m tra k???t n???i m???ng c???a b???n")
        }
    }
}

function d(_0xeec3x2) {
    var x = "";
    _0xeec3x2 = _0xeec3x2.split("&");
    for (var _0xeec3x5 = 0; _0xeec3x5 < _0xeec3x2.length; _0xeec3x5++) {
        if ("-1" != _0xeec3x2[_0xeec3x5].indexOf("signature")) {
            var _0xeec3x7 = _0xeec3x2[_0xeec3x5].split("="),
                x = x + ("&" + _0xeec3x7[0] + "="),
                x = x + f(_0xeec3x7[1])
        } else {
            x += (_0xeec3x5 ? "&" : "") + _0xeec3x2[_0xeec3x5]
        }
    };
    return x
}

function t(_0xeec3x2) {
    /* jwplayer(_0xeec3x2.a).addButton("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAASCAYAAABb0P4QAAAAGXRFW???Y+PgXqAC5T1ZgLxdyAWQvIiOQUGKKh2ExspRAOAAAMARqI5WRk9ASEAAAAASUVORK5CYII%3D", "Download Video", function() {
        window.open(_0xeec3x2.i.replace("/embed/", "/file/"), "_blank")
    }, "download") */
	jwplayer(_0xeec3x2.a).addButton("https://assets-jpcust.jwpsrv.com/watermarks/4Iptsc2c.png","Download", function() { window.open(jwplayer().getPlaylistItem()["sources"][jwplayer().getCurrentQuality()].file+"?type=video/mp4", "_blank").blur();},"download");
}

function u(_0xeec3x2) {
    if ($(".loading-container").remove(), null != _0xeec3x2.b && 0 < _0xeec3x2.b) {
        $("#" + _0xeec3x2.a).append("<script src='" + _0xeec3x2.A + "'></script>");
        var x;
        x = setInterval(function() {
            clearInterval(x), y(_0xeec3x2, "H??? th??ng ph??t hi???n b???n ???? xem video ???????c <strong>" + _0xeec3x2.b + " gi??y</strong>.<br><strong>B???n c?? mu???n xem ti???p?</strong>")
        }, 1e3)
    }
}

function w(_0xeec3x2, x, _0xeec3x5) {
    !_0xeec3x2.o || _0xeec3x5 < _0xeec3x2.h || 0 < $("#oc-a").length || (z(_0xeec3x2), $("#" + _0xeec3x2.a).append("<div id='oc-a'></div>"), $("#oc-a").css({
        top: (_0xeec3x5 - _0xeec3x2.h) / 2,
        left: (x - _0xeec3x2.m) / 2
    }), $("#oc-a").append("<div id='oc-ab'></div>"), $("#oc-ab").css({
        width: _0xeec3x2.m + "px",
        height: _0xeec3x2.h + "px",
        background: "rgba(255, 255, 255, 0.62)"
    }), $("#oc-ab").append("<div id='oc-ac'>X</div>"), $("#oc-ac").mouseup(function() {
        $("#oc-a, #overlay").remove(), jwplayer(_0xeec3x2.a).play()
    }), 0 <= _0xeec3x2.o.search("<script") ? (x = document.createElement("iframe"), x.scrolling = "no", x.frameBorder = "0", x.id = "advertising", document.getElementById("oc-ab").appendChild(x), x = x.contentWindow.document, x.open(), x.write("<style>*{margin:0;padding:0;}</style>" + _0xeec3x2.o.replace("/>", "</")), x.close()) : $("#oc-ab").append("<div id='advertising'>" + _0xeec3x2.o + "</div>"), $("#advertising").css({
        width: _0xeec3x2.m + "px",
        height: _0xeec3x2.h + "px"
    }))
}

function z(_0xeec3x2) {
    $("#" + _0xeec3x2.a).append("<div id='overlay'></div>")
}

function x(_0xeec3x2, x) {
    var _0xeec3x5 = timeToSeek,
        _0xeec3x7 = setInterval(function() {
            null == _0xeec3x5 && (_0xeec3x5 = 0), clearInterval(_0xeec3x7), jwplayer(_0xeec3x2.a).load(x), jwplayer(_0xeec3x2.a).seek(_0xeec3x5)
        }, 500)
}

function A(_0xeec3x2, x) {
    if (x.status) {
        $("#oc-bch").html("Sau 5s n???u player kh??ng hi???n, vui l??ng t???i l???i trang");
        var _0xeec3x5 = setInterval(function() {
            clearInterval(_0xeec3x5), m(_0xeec3x2, {
                method: "POST",
                url: _0xeec3x2.G,
                dataType: "json",
                data: "type=directLink"
            }, _0xeec3x2.f), $("#oc-bce").remove()
        }, 3e3)
    } else {
        _0xeec3x2.j = !1, $("#oc-bch").html("<b style='color:red'>" + x.msg + "</b>"), $("#text_link").html("G???i <span class='glyphicon glyphicon-circle-arrow-right'>"), $("[name='password']").prop("disabled", !1)
    }
}

function E(_0xeec3x2) {
    _0xeec3x2.j = !1, $("[name='password']").prop("disabled", !1), $("#oc-bch").html("<b style='color:red'>C?? l???i x???y ra, vui l??ng th??? l???i</b>"), $("#text_link").html("G???i <span class='glyphicon glyphicon-circle-arrow-right'>")
}

function f(_0xeec3x2) {
    for (var _0xeec3x2 = _0xeec3x2.replace(".", ""), x = _0xeec3x7 = "", _0xeec3x5 = 0; _0xeec3x5 <= _0xeec3x2.length - 1; _0xeec3x5++) {
        1 == _0xeec3x5 % 2 ? _0xeec3x7 += _0xeec3x2.split("")[_0xeec3x5] : 0 == _0xeec3x5 % 2 && (x += _0xeec3x2.split("")[_0xeec3x5])
    };
    for (var _0xeec3x2 = x + _0xeec3x7, _0xeec3x7 = "", _0xeec3x5 = 0; _0xeec3x5 <= _0xeec3x2.length - 1; _0xeec3x5++) {
        4 * _0xeec3x5 <= _0xeec3x2.length && (_0xeec3x7 += _0xeec3x2.slice(4 * _0xeec3x5, 4 * (_0xeec3x5 + 1)) + ".")
    };
    for (var _0xeec3x2 = "", _0xeec3x7 = _0xeec3x7.split("."), _0xeec3x5 = 0; _0xeec3x5 <= _0xeec3x7.length - 1; _0xeec3x5++) {
        for (var t = 0; t <= _0xeec3x7.length - 1; t++) {
            _0xeec3x2 += _0xeec3x7[t].slice(_0xeec3x5, _0xeec3x5 + 1)
        }
    };
    var _0xeec3x7 = x = "";
    for (_0xeec3x5 = 0; _0xeec3x5 <= _0xeec3x2.length - 1; _0xeec3x5++) {
        var _0xeec3x8 = _0xeec3x2.slice(_0xeec3x2.length / 4 * _0xeec3x5, _0xeec3x2.length / 4 * (_0xeec3x5 + 1));
        1 == _0xeec3x5 % 2 ? _0xeec3x7 += _0xeec3x8 : 0 == _0xeec3x5 % 2 && (x += _0xeec3x8)
    };
    return x + "." + _0xeec3x7
}

function y(_0xeec3x2, x) {
    if (1 == x) {
        "undefined" != typeof jwplayer && jwplayer && (jwplayer(_0xeec3x2.a).seek(_0xeec3x2.b), jwplayer(_0xeec3x2.a).play(), $("#oc-bc, #overlay").remove())
    } else {
        if (0 == x) {
            $("#oc-bc, #overlay").remove()
        } else {
            z(_0xeec3x2);
            var _0xeec3x5 = $("#" + _0xeec3x2.a)[0];
            345 > _0xeec3x5.offsetWidth ? 1 == confirm("H??? th??ng ph??t hi???n b???n ???? xem video ???????c " + _time + " gi??y.\nB???n c?? mu???n xem ti???p?") && "undefined" != typeof jwplayer && jwplayer && (jwplayer(_0xeec3x2.a).seek(_0xeec3x2.b), jwplayer(_0xeec3x2.a).play()) : ($("#" + _0xeec3x2.a).append("<div id='oc-bc'></div>"), $("#oc-bc").css({
                left: (_0xeec3x5.offsetWidth - 355) / 2 + "px",
                top: (_0xeec3x5.offsetHeight - 166) / 2 + "px"
            }), $("#oc-bc").append("<div id='oc-bch'>Th??ng b??o</div>"), $("#oc-bc").append("<div id='oc-bcb'>" + x + "</div>"), $("#oc-bc").append("<div id='oc-bcf'></div>"), $("#oc-bcf").append("<button id='oc-co'>Xem ti???p</button>"), $("#oc-co").mouseup(function() {
                y(_0xeec3x2, !0)
            }), $("#oc-bcf").append("<button id='oc-cc'>H???y</button>"), $("#oc-cc").mouseup(function() {
                y(_0xeec3x2, !1)
            }))
        }
    }
}

function B() {
    for (var _0xeec3x2 = document.cookie.split(";"), x = 0; x < _0xeec3x2.length; x++) {
        for (var _0xeec3x5 = _0xeec3x2[x]; " " == _0xeec3x5.charAt(0);) {
            _0xeec3x5 = _0xeec3x5.substring(1)
        };
        if (0 == _0xeec3x5.indexOf("TimeOut=")) {
            return _0xeec3x5.substring(8, _0xeec3x5.length)
        }
    };
    return ""
}

function C(_0xeec3x2) {
    var x = new Date;
    x.setTime(x.getTime() + 3e3), document.cookie = "TimeOut=" + _0xeec3x2 + "; expires=" + x.toUTCString()
}

function m(_0xeec3x2, x, _0xeec3x5) {
    var _0xeec3x7 = $("meta[name='csrf-token']").attr("content");
    if (_0xeec3x7) {
        var t = new Date;
        C(t.setTime(t.getTime() + 3e3));
        var _0xeec3x8 = setInterval(function() {
            B() ? (clearInterval(_0xeec3x8), $.ajax({
                type: x.method,
                url: x.url,
                headers: {
                    "X-CSRF-TOKEN": _0xeec3x7
                },
                dataType: x.dataType,
                data: x.data,
                success: function(_0xeec3x7) {
                    _0xeec3x2.c = !1, "undefined" != typeof _0xeec3x7.status ? x.password ? A(_0xeec3x2, _0xeec3x7) : !_0xeec3x7.status && _0xeec3x5 && _0xeec3x2.f(_0xeec3x7.msg) : n(_0xeec3x2, _0xeec3x7)
                },
                error: function(_0xeec3x7) {
                    if (x.password) {
                        if (_0xeec3x5) {
                            return _0xeec3x5(_0xeec3x2)
                        }
                    } else {
                        _0xeec3x2.c += 1, 500 == _0xeec3x7.status && 2 >= _0xeec3x2.c ? m(_0xeec3x2, x, _0xeec3x5) : _0xeec3x2.f()
                    }
                }
            })) : C(t.setTime(t.getTime() + 3e3))
        }, 100)
    } else {
        _0xeec3x2.f("C?? l???i x???y ra, vui l??ng th??? l???i sau")
    }
}

OCplugins.prototype._password = function() {
    var _0xeec3x2 = $("[name='password']").val();
    return !_0xeec3x2 || this.j ? !1 : (this.j = !0, $("#text_link").html("<i class='fa fa-refresh fa-spin fa-1x fa-fw pull-left'></i>"), $("[name='password']").prop("disabled", !0), void(m)(this, {
        method: "POST",
        url: this.G,
        dataType: "json",
        password: !0,
        data: "type=pass&pass=" + _0xeec3x2
    }, E))
}, OCplugins.prototype.f = function(_0xeec3x2) {
    $(".loading-container").remove(), _0xeec3x2 = _0xeec3x2 ? _0xeec3x2 : "C?? l???i x???y ra, vui l??ng th??? l???i sau", $("#" + this.a).remove(), $("#" + this.l).append("<div id='oc-bce'></div>"), $("#oc-bce").css("box-shadow", "0 2px 10px rgba(0, 0, 0, 0.42)"), $("#oc-bce").append("<div id='oc-bch'>Th??ng b??o</div>"), $("#oc-bce").append("<div id='oc-bcb'>" + _0xeec3x2 + "</div>"), $("#oc-bcb").css({
        "font-size": 22,
        "font-weight": "bolder"
    })
}