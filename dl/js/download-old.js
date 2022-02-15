function adBlockDetected() {
    adblock = "&adblock=true"
}
var click = !0,
    clickDownload, adblock = "";
"undefined" == typeof fuckAdBlock ? adBlockDetected() : fuckAdBlock.onDetected(adBlockDetected);
var load = setInterval(function() {
        clearInterval(load), $(function() {
            if (parth = window.location.pathname, parth.match(/\/folder\/(.*)/)) return click = !1;
            $("#response").html('<i class="fa fa-refresh fa-spin fa-2x fa-fw pull-left"></i>'), $("a.btn-danger").addClass("disabled");
            var e = "type=file_check";
            new _request({
                method: "POST",
                dataType: "json",
                data: e,
                onComplete: function(e) {
                    if (e.status) {
						$("a.btn-danger").removeClass("disabled"), $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>');
						$("#filename").append(e.info.file_name);
						$("#filesize").append(formatBytes(e.info.file_size));
						$("#urlembed").attr('href',e.info.file_embed);
						if(e.info.file_mime.match(/video/i)) $("#urlembed").removeAttr('disabled').removeClass('disabled');
                    } else {
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
        var e = $('[name="password"]').val();
        if (!e || click) return !1;
        click = !0, $("#text_link").html('<i class="fa fa-refresh fa-spin fa-2x fa-fw pull-left"></i>'), $('[name="password"]').prop("disabled", !0);
        var a = "type=file_pass&pass=" + e;
        new _request({
            method: "POST",
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
    file_download = function(e) {
        if (click) return !1;
        click = !0, $("#response").html('<i class="fa fa-circle-o-notch fa-spin fa-2x fa-fw pull-left"></i>');
        var a = "type=file_download";
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(a) {
                if (a.status) window.location.href = a.msg;
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
                return $("#response").html('<i class="fa fa-cloud-download fa-2x pull-left"></i>'), clickDownload ? !1 : (clickDownload = !0, void new _request({
                    method: "POST",
                    data: "type=point&profile=" + e + adblock
                }))
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
        var a = function() {},
            t = $('meta[name="csrf-token"]').attr("content");
        return t ? (this.onComplete = e.onComplete || a, this.onError = e.onError || a, this.method = e.method, this.url = e.url || "", this.headers = {
            "X-CSRF-TOKEN": t
        }, this.dataType = e.dataType || "", this.data = e.data || "", void this._send()) : !1
    };
_request.prototype._send = function() {
    var e = this;
    $(".loading").show(), $(".loading").html('<img src="../imgs/radio.gif">'), $.ajax({
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

function formatBytes(bytes, si) {
    var thresh = si ? 1000 : 1024;
    if(Math.abs(bytes) < thresh) {
        return bytes + ' B';
    }
    var units = si
        ? ['KiB','MiB','GiB','TiB','PiB','EiB','ZiB','YiB']
        : ['KB','MB','GB','TB','PB','EB','ZB','YB'];
    var u = -1;
    do {
        bytes /= thresh;
        ++u;
    } while(Math.abs(bytes) >= thresh && u < units.length - 1);
    return bytes.toFixed(1)+' '+units[u];
}