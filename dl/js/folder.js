var click;
$("img.thumb").click(function() {
    var a = $(this)[0].src;
    $(".preview").html('<img src="' + a + '" width="100%">')
}), $("#manager-sort").click(function() {
    if ($(".fa-sort").length > 0 ? (sort = "asc", $("#manager-sort i").removeClass("fa-sort").addClass("fa-sort-alpha-asc")) : $(".fa-sort-alpha-asc").length > 0 ? (sort = "desc", $("#manager-sort i").removeClass("fa-sort-alpha-asc").addClass("fa-sort-alpha-desc")) : $(".fa-sort-alpha-desc").length > 0 && (sort = "asc", $("#manager-sort i").removeClass("fa-sort-alpha-desc").addClass("fa-sort-alpha-asc")), !sort && !click) return !1;
    var a = $("#manager_keyword").val();
    $("#manager_search_load").hide(), start_manager = 10, click = !0, new _request({
        method: "POST",
        dataType: "json",
        data: "type=manager_sort&name=" + sort + "&keyword=" + a,
        onComplete: function(a) {
            if (a.status) $(".manager nav").hide(), $("#manager_sort_load").show(), $(".manager_response").html(a.msg);
            else {
                $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                var e = setInterval(function() {
                    clearInterval(e), $(".msg-danger span").html(""), $(".msg-danger").hide()
                }, 3e3)
            }
        }
    })
}), $(function() {
    var a = $("#manager_sort_load");
    start_manager = 10, text_manager = a.text(), a.click(function() {
        manager_keyword = $("#manager_keyword"), $(this).hasClass("clicked") || ($(this).addClass("clicked").text("Loading..."), go_to = $(".manager_response tr:last").offset().top, new _request({
            method: "POST",
            dataType: "json",
            data: "type=manager_sort&name=" + sort + "&keyword=" + manager_keyword.val() + "&start=" + start_manager,
            onComplete: function(e) {
                if (e.status) $(".manager_response").append(e.msg), $("html, body").animate({
                    scrollTop: go_to
                }, 800), start_manager += 10;
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3);
                    manager_keyword.val(""), a.hide()
                }
                a.removeClass("clicked").text(text_manager)
            }
        }))
    })
});
var manager_search = function() {
    var a = $("#manager_keyword").val();
    if (!a || a.length < 3 || click) return !1;
    $("#manager_sort_load").hide(), start_manager = 10, click = !0;
    var e = "type=manager_search&keyword=" + a;
    new _request({
        method: "POST",
        dataType: "json",
        data: e,
        onComplete: function(a) {
            if (a.status) $(".manager nav").hide(), $("#manager_search_load").show(), $(".manager_response").html(a.msg);
            else {
                $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                var e = setInterval(function() {
                    clearInterval(e), $(".msg-danger span").html(""), $(".msg-danger").hide()
                }, 3e3)
            }
        }
    })
};
$(function() {
    var a = $("#manager_search_load");
    start_manager = 10, text_manager = a.text(), a.click(function() {
        if (manager_keyword = $("#manager_keyword"), !manager_keyword) return !1;
        if (!$(this).hasClass("clicked")) {
            $(this).addClass("clicked").text("Loading..."), go_to = $(".manager_response tr:last").offset().top;
            var e = "type=manager_search&keyword=" + manager_keyword.val() + "&start=" + start_manager;
            new _request({
                method: "POST",
                dataType: "json",
                data: e,
                onComplete: function(e) {
                    if (e.status) $(".manager_response").append(e.msg), $("html, body").animate({
                        scrollTop: go_to
                    }, 800), start_manager += 10;
                    else {
                        $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                        var t = setInterval(function() {
                            clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                        }, 3e3);
                        manager_keyword.val(""), a.hide()
                    }
                    a.removeClass("clicked").text(text_manager)
                }
            })
        }
    })
});
var folder_pass = function() {
        var a = $('[name="password"]').val();
        if (!a || click) return !1;
        click = !0, $("#text_link").html('<i class="fa fa-refresh fa-spin fa-2x fa-fw pull-left"></i>'), $('[name="password"]').prop("disabled", !0);
        var e = "type=folder_pass&pass=" + a;
        new _request({
            method: "POST",
            dataType: "json",
            data: e,
            onComplete: function(a) {
                if (a.status) window.location.replace(window.location);
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var e = setInterval(function() {
                        clearInterval(e), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3);
                    $("#text_link").html("Gửi"), $('[name="password"]').prop("disabled", !1)
                }
            }
        })
    },
    _request = function(a) {
        var e = function() {},
            t = $('meta[name="csrf-token"]').attr("content");
        return t ? (this.onComplete = a.onComplete || e, this.onError = a.onError || e, this.method = a.method, this.url = a.url || "", this.headers = {
            "X-CSRF-TOKEN": t
        }, this.dataType = a.dataType || "", this.data = a.data || "", void this._send()) : !1
    };
_request.prototype._send = function() {
    var a = this;
    //$(".loading").show(), $(".loading").html('<img src="../imgs/radio.gif">'), $.ajax({ 
    $(".loading").show(), $(".loading").html('<img src="'+root+'/imgs/radio.gif">'), $.ajax({ 
        type: a.method,
        url: a.url,
        headers: a.headers,
        dataType: a.dataType,
        data: a.data,
        success: function(e) {
            a.onComplete(e), $(".loading").hide(), click = !1
        },
        error: function(e) {
            $(".loading").hide(), $(".msg-danger").show(), $(".msg-danger span").html("Có lỗi xảy ra, vui lòng thử lại");
            var t = setInterval(function() {
                clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
            }, 3e3);
            a.onError(e), click = !1
        }
    })
};