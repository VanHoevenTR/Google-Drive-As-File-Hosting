var click = !0,
    load = setInterval(function() {
        clearInterval(load), $(function() {
            if (parth = window.location.pathname, parth.match(/\/folder\/(.*)/)) return click = !1;
            var e = $('meta[name="csrf-token"]').attr("content");
            if (!e) return !1;
            $("#response").html('<i class="fa fa-refresh fa-spin fa-2x fa-fw pull-left"></i>'), $("a.btn-danger").addClass("disabled");
            var a = "type=file_check";
            new _request({
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": e
                },
                dataType: "json",
                data: a,
                onComplete: function(e) {
                    if (e.status) $("a.btn-danger").removeClass("disabled"), $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>');
                    else {
                        $("#response").html('<i class="fa fa-exclamation-triangle fa-2x pull-left"></i>'), $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                        var a = setInterval(function() {
                            clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                        }, 3e3)
                    }
                },
                onError: function() {
                    $("#response").html('<i class="fa fa-exclamation-triangle fa-2x pull-left"></i>')
                }
            })
        })
    }, 1e3),
    file_pass = function() {
        var e = $('meta[name="csrf-token"]').attr("content");
        if (password = $('[name="password"]').val(), !password || !e || click) return !1;
        click = !0, $("#text_link").html('<i class="fa fa-refresh fa-spin fa-2x fa-fw pull-left"></i>'), $('[name="password"]').prop("disabled", !0);
        var a = "type=file_pass&pass=" + password;
        new _request({
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": e
            },
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) window.location.replace(window.location);
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3);
                    $("#text_link").html("Gửi"), $('[name="password"]').prop("disabled", !1)
                }
            },
            onError: function() {
                $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>')
            }
        })
    },
    file_download = function() {
        var e = $('meta[name="csrf-token"]').attr("content");
        if (!e || click) return !1;
        click = !0, $("#response").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw pull-left"></i>');
        var a = "type=file_download";
        new _request({
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": e
            },
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) window.location.href = e.msg;
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
                $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>')
            },
            onError: function() {
                $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>')
            }
        })
    },
    file_share = function(e, a) {
        if (!a || !e || click) return !1;
        switch (e) {
            case "fb":
                window.open("https://www.facebook.com/sharer/sharer.php?u=" + a, "Share Facebook", "width=640,height=450");
                break;
            case "gg":
                window.open("https://plus.google.com/share?url=" + a, "Share Facebook", "width=640,height=450");
                break;
            case "tw":
                window.open("https://twitter.com/home?status=" + a, "Share Facebook", "width=640,height=450")
        }
    },
    _request = function(e) {
        var a = function() {};
        this.onComplete = e.onComplete || a, this.onError = e.onError || a, this.method = e.method, this.url = e.url || "", this.headers = e.headers || "", this.dataType = e.dataType || "", this.data = e.data || "", this._send()
    };
_request.prototype._send = function() {
    var e = this;
    $(".loading").show(), $(".loading").html('<img src="../../imgs/radio.gif">'), $.ajax({
        type: e.method,
        url: e.url,
        headers: e.headers,
        dataType: e.dataType,
        data: e.data,
        success: function(a) {
            e.onComplete(a), $(".loading").hide(), click = !1
        },
        error: function(a) {
            $(".loading").hide(), $(".msg-danger").show(), $(".msg-danger span").html("Có lỗi xảy ra, vui lòng thử lại");
            var t = setInterval(function() {
                clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
            }, 3e3);
            e.onError(a), click = !1
        }
    })
};