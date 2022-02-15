var click, sort, protocol = window.location.protocol,
    domain = window.location.origin.replace(protocol, ""),
    folder_create = function() {
        var e = $("#folder_name").val();
        if ($("#folder_name").show(), !e || e.length < 3 || click) return !1;
        click = !0;
        var a = "type=folder_create&name=" + e;
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $("#folder_name").val(""), $(".folder_response").append(e.data), $(".msg-success span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-success span").html(""), $(".msg-success").hide(), window.location.replace(window.location.href)
                    }, 1e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    },
    folder_info = function(e) {
        return !e || click ? !1 : (click = !0, $("#folder_update").show(), $(".manager_info_subscene, .manager_info_embed, #manager_update").hide(), void new _request({
            method: "GET",
            url: "/dashboard/folder/" + e + "/edit",
            dataType: "json",
            onComplete: function(e) {
                if (e.status && e.folder[0]) $("#manager_info_embed").val(""), $("#manager_info_title").text(e.folder[0].name), $("#manager_info_id").val(e.folder[0].id), $("#manager_info_name").val(e.folder[0].name), $("#manager_info_password").val(e.folder[0].pass), $("#manager_info_share").val(protocol + domain + "/folder/" + e.folder[0].slug);
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg), $("#manager_info_title").html(e.msg), $("#manager_info_name, #manager_info_password, #manager_info_share, #manager_info_embed").val("");
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        }))
    },
    folder_update = function() {
        return id = $("#manager_info_id").val(), name = $("#manager_info_name").val(), password = $("#manager_info_password").val(), !id || !name || name.length < 3 || click ? flase : (click = !0, void new _request({
            method: "PUT",
            url: "/dashboard/folder/" + id,
            dataType: "json",
            data: "name=" + name + "&password=" + password,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $(".msg-success span").html(e.msg), $(".folder-title-" + id + " a").text(name), password ? $(".folder-status-" + id + " span").removeClass().css("color", "").addClass("glyphicon glyphicon-lock").attr("data-original-title", "Riêng tư") : $(".folder-status-" + id + " span").removeClass().css("color", "green").addClass("glyphicon glyphicon-ok-circle").attr("data-original-title", "Công khai");
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        }))
    },
    folder_delete = function(e) {
        return !e || click ? !1 : void(confirm("Bạn có chắc muốn xóa?") && (click = !0, new _request({
            method: "DELETE",
            url: "/dashboard/folder/" + e,
            dataType: "json",
            onComplete: function(a) {
                if (a.status) {
                    $(".msg-success").show(), $(".msg-success span").html(a.msg), $("#folder-" + e).remove();
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })))
    },
    folder_move = function() {
        var e = $("[name=listItems]");
        radio = $("[name=folder]"), id = "", listItems = [], fileIds = "";
        for (var a = 0, t = radio.length; t > a; a++) radio[a].checked && (id += radio[a].value);
        for (var a = 0, t = e.length; t > a; a++) e[a].checked && (fileIds += e[a].value + ",", listItems.push(e[a].value));
        if (click || !fileIds) return !1;
        click = !0;
        var n = "type=folder_move&folderId=" + id + "&fileIds=" + fileIds;
        new _request({
            method: "POST",
            dataType: "json",
            data: n,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $(".msg-success span").html(e.msg);
                    for (var a = 0, t = listItems.length; t > a; a++) $("#manager-" + listItems[a]).remove();
                    $(".manager_options").hide();
                    var n = setInterval(function() {
                        clearInterval(n), $(".msg-success span").html(""), $(".msg-success").hide(), window.location.replace(window.location.href)
                    }, 1e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var n = setInterval(function() {
                        clearInterval(n), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    };
$("[name=listItems]").click(function() {
    for (var e = $("[name=listItems]"), a = "", t = 0, n = e.length; n > t; t++) e[t].checked && (a += e[t].value);
    a.length > 0 ? $(".manager_options").show() : $(".manager_options").hide()
});
var folder_search = function() {
    var e = $("#folder_keyword").val();
    if (!e || e.length < 3 || click) return !1;
    start_folder = 5, click = !0;
    var a = "type=folder_search&keyword=" + e;
    new _request({
        method: "POST",
        dataType: "json",
        data: a,
        onComplete: function(e) {
            if (e.status) $(".folder nav").hide(), $("#folder_load").show(), $(".folder_response").html(e.msg);
            else {
                $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                var a = setInterval(function() {
                    clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                }, 3e3)
            }
        }
    })
};
$(function() {
    var e = $("#folder_load");
    start_folder = 5, text_folder = e.text(), folder_keyword = "", e.click(function() {
        if (folder_keyword = $("#folder_keyword").val(), !$(this).hasClass("clicked")) {
            $(this).addClass("clicked").text("Loading..."), go_to = $(".folder_response tr:last").offset().top;
            var a = "type=folder_load&keyword=" + folder_keyword + "&start=" + start_folder;
            new _request({
                method: "POST",
                dataType: "json",
                data: a,
                onComplete: function(a) {
                    if (a.status) $(".folder_response").append(a.msg), $("html, body").animate({
                        scrollTop: go_to
                    }, 800), start_folder += 5;
                    else {
                        $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                        var t = setInterval(function() {
                            clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                        }, 3e3);
                        e.hide()
                    }
                    e.removeClass("clicked").text(text_folder)
                }
            })
        }
    })
}), $("#manager-sort").click(function() {
    if ($(".fa-sort").length > 0 ? (sort = "asc", $("#manager-sort i").removeClass("fa-sort").addClass("fa-sort-alpha-asc")) : $(".fa-sort-alpha-asc").length > 0 ? (sort = "desc", $("#manager-sort i").removeClass("fa-sort-alpha-asc").addClass("fa-sort-alpha-desc")) : $(".fa-sort-alpha-desc").length > 0 && (sort = "asc", $("#manager-sort i").removeClass("fa-sort-alpha-desc").addClass("fa-sort-alpha-asc")), !sort && !click) return !1;
    var e = $("#manager_keyword").val();
    $("#manager_search_load").hide(), start_manager = 10, click = !0, new _request({
        method: "POST",
        dataType: "json",
        data: "type=manager_sort&name=" + sort + "&keyword=" + e,
        onComplete: function(e) {
            if (e.status) $(".manager nav").hide(), $("#manager_sort_load").show(), $(".manager_response").html(e.msg);
            else {
                $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                var a = setInterval(function() {
                    clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                }, 3e3)
            }
        }
    })
}), $(function() {
    var e = $("#manager_sort_load");
    start_manager = 10, text_manager = e.text(), e.click(function() {
        manager_keyword = $("#manager_keyword"), $(this).hasClass("clicked") || ($(this).addClass("clicked").text("Loading..."), go_to = $(".manager_response tr:last").offset().top, new _request({
            method: "POST",
            dataType: "json",
            data: "type=manager_sort&name=" + sort + "&keyword=" + manager_keyword.val() + "&start=" + start_manager,
            onComplete: function(a) {
                if (a.status) $(".manager_response").append(a.msg), $("html, body").animate({
                    scrollTop: go_to
                }, 800), start_manager += 10;
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3);
                    manager_keyword.val(""), e.hide()
                }
                e.removeClass("clicked").text(text_manager)
            }
        }))
    })
});
var manager_checked = function(e) {
        for (var a = document.querySelectorAll('input[type="checkbox"]'), t = 0; t < a.length; t++) a[t] != e && (a[t].checked = e.checked, e.checked ? $(".manager_options").show() : $(".manager_options").hide())
    },
    manager_search = function() {
        var e = $("#manager_keyword").val();
        if (!e || e.length < 3 || click) return !1;
        $("#manager_sort_load").hide(), start_manager = 10, click = !0;
        var a = "type=manager_search&keyword=" + e;
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) $(".manager nav").hide(), $("#manager_search_load").show(), $(".manager_response").html(e.msg);
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    };
$(function() {
    var e = $("#manager_search_load");
    start_manager = 10, text_manager = e.text(), e.click(function() {
        if (manager_keyword = $("#manager_keyword"), !manager_keyword) return !1;
        if (!$(this).hasClass("clicked")) {
            $(this).addClass("clicked").text("Loading..."), go_to = $(".manager_response tr:last").offset().top;
            var a = "type=manager_search&keyword=" + manager_keyword.val() + "&start=" + start_manager;
            new _request({
                method: "POST",
                dataType: "json",
                data: a,
                onComplete: function(a) {
                    if (a.status) $(".manager_response").append(a.msg), $("html, body").animate({
                        scrollTop: go_to
                    }, 800), start_manager += 10;
                    else {
                        $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                        var t = setInterval(function() {
                            clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                        }, 3e3);
                        manager_keyword.val(""), e.hide()
                    }
                    e.removeClass("clicked").text(text_manager)
                }
            })
        }
    })
});
var manager_info = function(e) {
        return !e || click ? !1 : (click = !0, $("#manager_update").show(), $("#folder_update").hide(), void new _request({
            method: "GET",
            url: "/dashboard/manager/" + e + "/edit",
            dataType: "json",
            onComplete: function(e) {
                if (e.status && e.manager[0]) $("#manager_info_embed").val(""), $("#manager_info_title").text(e.manager[0].name), $("#manager_info_id").val(e.manager[0].id), $("#manager_info_name").val(e.manager[0].name), $("#manager_info_password").val(e.manager[0].pass), $("#manager_info_share").val(protocol + domain + "/file/" + e.manager[0].slug), $("#manager_info_embed, .manager_info_embed, #manager_info_subscene, .manager_info_subscene").hide(), 1 == e.manager[0].type && ($("#manager_info_embed, .manager_info_embed, #manager_info_subscene, .manager_info_subscene").show(), $("#manager_info_subscene").val(e.manager[0].track), $("#manager_info_embed").val("<iframe src='" + domain + "/embed/" + e.manager[0].slug + "' width='640' height='360' frameborder='0' allowfullscreen></iframe>")), 2 == e.manager[0].type && ($("#manager_info_embed, .manager_info_embed").show(), $("#manager_info_subscene, .manager_info_subscene").hide(), $("#manager_info_embed").val(protocol + domain + "/image/" + e.manager[0].slug));
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg), $("#manager_info_title").html(e.msg), $("#manager_info_name, #manager_info_password, #manager_info_share, #manager_info_embed").val("");
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        }))
    },
    manager_update = function() {
        return id = $("#manager_info_id").val(), name = $("#manager_info_name").val(), password = $("#manager_info_password").val(), subscene = $("#manager_info_subscene").val(), !id || !name || name.length < 3 || click ? flase : (click = !0, void new _request({
            method: "PUT",
            url: "/dashboard/manager/" + id,
            dataType: "json",
            data: "type=manager_update&name=" + name + "&password=" + password + "&subscene=" + subscene,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $(".msg-success span").html(e.msg), $(".manager-title-" + id + " a").text(name), password ? $(".manager-status-" + id + " span").removeClass().css("color", "").addClass("glyphicon glyphicon-lock").attr("data-original-title", "Riêng tư") : $(".manager-status-" + id + " span").removeClass().css("color", "green").addClass("glyphicon glyphicon-ok-circle").attr("data-original-title", "Công khai");
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        }))
    },
    manager_delete = function(e) {
        return !e || click ? !1 : void(confirm("Bạn có chắc muốn xóa?") && (click = !0, new _request({
            method: "DELETE",
            url: "/dashboard/manager/" + e,
            dataType: "json",
            data: "type=manager_delete",
            onComplete: function(a) {
                if (a.status) {
                    $(".msg-success").show(), $(".msg-success span").html(a.msg), $("#manager-" + e).remove();
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })))
    },
    manager_delete_choose = function() {
        if (confirm("Bạn có muốn xóa danh sách File đã chọn?")) {
            var e = $("[name=listItems]");
            if (id = "", listItems = [], fileIds = "", click) return !1;
            click = !0;
            for (var a = 0, t = e.length; t > a; a++) e[a].checked && (fileIds += e[a].value + ",", listItems.push(e[a].value));
            new _request({
                method: "DELETE",
                url: "/dashboard/manager/4",
                dataType: "json",
                data: "type=manager_delete_all&fileIds=" + fileIds,
                onComplete: function(e) {
                    if (e.status) {
                        $(".msg-success").show(), $(".msg-success span").html(e.msg);
                        for (var a = 0, t = listItems.length; t > a; a++) $("#manager-" + listItems[a]).remove();
                        $(".manager_options").hide();
                        var n = setInterval(function() {
                            clearInterval(n), $(".msg-success span").html(""), $(".msg-success").hide(), window.location.replace(window.location.href)
                        }, 1e3)
                    } else {
                        $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                        var n = setInterval(function() {
                            clearInterval(n), $(".msg-danger span").html(""), $(".msg-danger").hide()
                        }, 3e3)
                    }
                }
            })
        }
    };
$("img.thumb").click(function() {
    var e = $(this)[0].src;
    $(".preview").html('<img src="' + e + '" width="100%">')
});
var keyup;
$(function() {
    $("#remote_links").keyup(function() {
        var e = $("#remote_links").val();
        if (!e || click) return !1;
        $("#remote_links").attr("disabled", "disabled"), keyup = click = !0;
        var a = e.split("\n");
        for ($(".msg-danger").hide(), i = 0; i < e.length; i++)
            if (a[i]) {
                check = a[i].match(/(.*):\/\/drive.google.com\/file\/d\/(.*)\/(.*)/), check || (check = a[i].match(/(.*):\/\/drive.google.com\/file\/d\/(.*)/), check || (check = a[i].match(/(.*):\/\/drive.google.com\/open\?id=(.*)/), check || (check = a[i].match(/(.*):\/\/drive.google.com\/drive\/folders\/(.*)\?(.*)/), check || (check = a[i].match(/(.*):\/\/drive.google.com\/drive\/folders\/(.*)/), check || (check = a[i].match(/(.*):\/\/fshare.vn\/file\/(.*)/), check || (check = a[i].match(/(.*):\/\/www.fshare.vn\/file\/(.*)/), check || (check = a[i].match(/(.*):\/\/onecloud.media\/file\/(.*)/), check || (check = a[i].match(/(.*):\/\/onecloud.media\/embed\/(.*)/), check || remote_changer(a, i, check))))))))), parseInt(a.length - 1) == i && (keyup = click = !1, $("#remote_links").prop("disabled", !1))
            } else keyup = click = !1, $("#remote_links").prop("disabled", !1)
    })
});
var listLink = [],
    addLinks = function(e) {
        if (e.length > 0)
            for (i = 0; i < e.length; i++) e[i] && listLink.push(e[i]), parseInt(e.length - 1) == i && remote_start(listLink, 0)
    },
    remote_config = function() {
        var e = $("#remote_links").val();
        return e && apiKey && !click ? (click = !0, $("#remote_links").attr("disabled", "disabled"), $(".remote").hide(), void addLinks(e.split("\n"))) : !1
    },
    remote_start = function(e, a) {
        e[a] || remote_next(e, a);
        var t = fs = !1;
        fileId = e[a].match(/(.*):\/\/drive.google.com\/file\/d\/(.*)\/(.*)/), fileId || (fileId = e[a].match(/(.*):\/\/drive.google.com\/file\/d\/(.*)/), fileId || (fileId = e[a].match(/(.*):\/\/drive.google.com\/open\?id=(.*)/), fileId || (fileId = e[a].match(/(.*):\/\/drive.google.com\/drive\/folders\/(.*)\?(.*)/), fileId || (fileId = e[a].match(/(.*):\/\/drive.google.com\/drive\/folders\/(.*)/), fileId || (fileId = e[a].match(/(.*):\/\/fshare.vn\/file\/(.*)/), fileId ? fs = !0 : (fileId = e[a].match(/(.*):\/\/www.fshare.vn\/file\/(.*)/), fileId ? fs = !0 : (fileId = e[a].match(/(.*):\/\/onecloud.media\/file\/(.*)/), fileId ? t = !0 : (fileId = e[a].match(/(.*):\/\/onecloud.media\/embed\/(.*)/), fileId ? t = !0 : remote_next(e, a))))))))), $(".remote-loading").show(), new _request(t || fs ? {
            method: "POST",
            dataType: "json",
            data: t ? "type=remote&fileId=" + fileId[2] : "type=remote_fshare&link=" + e[a],
            onComplete: function(t) {
                $("#response, .response").show(), t.status ? ($(".response textarea").val($(".response textarea").val() + t.msg + "\n"), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center"><a href="' + t.msg + '" target="_blank">' + t.msg + '</a></td><td class="col-md-3 middle text-center" style="color:green">Thành công</td></tr>')) : $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">' + t.msg + "</td></tr>"), remote_next(e, a)
            },
            onError: function(t) {
                $("#response, .response").show(), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">Error</td></tr>'), remote_next(e, a)
            }
        } : {
            method: "GET",
            url: "https://www.googleapis.com/drive/v3/files/" + fileId[2] + "?fields=mimeType%2Cname%2Csize%2Cparents%2Cmd5Checksum&key=" + apiKey,
            dataType: "json",
            onComplete: function(t) {
                if (fileType = t.mimeType.split("/"), "application/vnd.google-apps.folder" == t.mimeType) {
                    var n = "type=remote_folder&fileId=" + fileId[2];
                    return new _request({
                        method: "POST",
                        dataType: "json",
                        data: n,
                        onComplete: function(t) {
                            if (t.status)
                                for (l = 0; l < t.msg.length; l++) $("#remote_links").val($("#remote_links").val() + "\nhttps://drive.google.com/file/d/" + t.msg[l].id), t.msg.length == parseInt(l + 1) && remote_next(e, a);
                            else $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">' + t.msg + "</td></tr>"), remote_next(e, a)
                        },
                        onError: function() {
                            $("#response, .response").show(), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">Lỗi server</td></tr>'), remote_next(e, a)
                        }
                    }), !0
                }
                if (!t.md5Checksum) return $("#response, .response").show(), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">Tệp tin không an toàn</td></tr>'), remote_next(e, a), !1;
                var n = "type=remote_file&fileId=" + fileId[2] + "&mimeType=" + t.mimeType + "&fileName=" + t.name + "&fileSize=" + t.size + "&md5Checksum=" + t.md5Checksum;
                new _request({
                    method: "POST",
                    dataType: "json",
                    data: n,
                    onComplete: function(t) {
                        $("#response, .response").show(), t.status ? ($(".response textarea").val($(".response textarea").val() + t.msg + "\n"), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center"><a href="' + t.msg + '" target="_blank">' + t.msg + '</a></td><td class="col-md-3 middle text-center" style="color:green">Thành công</td></tr>')) : $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">' + t.msg + "</td></tr>"), remote_next(e, a)
                    },
                    onError: function() {
                        $("#response, .response").show(), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">Có lỗi xảy ra, vui lòng thử lại sau</td></tr>'), remote_next(e, a)
                    }
                })
            },
            onError: function(t) {
                var n = JSON.parse(t.responseText);
                $("#response, .response").show(), $(".remote_response").append('<tr><td class="col-md-3 middle text-center"><a href="' + e[a] + '" target="_blank">' + fileId[2] + '</a></td><td class="col-md-6 middle text-center">n/a</td><td class="col-md-3 middle text-center" style="color:red">' + n.error.message + "</td></tr>"), remote_next(e, a)
            }
        })
    },
    remote_next = function(e, a) {
        remote_changer(e, a), listLink.length || (listLink = [], $(".remote").show(), $("#remote_links").val(""), $(".remote-loading").hide(), $("#remote_links").prop("disabled", !1))
    },
    remote_changer = function(e, a, t) {
        var n = $("#remote_links").val(),
            s = n.split("\n"),
            r = "";
        for (x = 0; x < s.length; x++) s[x].replace(e[a], "") && (r += s[x] + "\n"), parseInt(s.length - 1) != x || t || ($("#remote_links").val(r), listLink = [], r && addLinks(r.split("\n")))
    },
    group_create = function() {
        var e = $("#group_name").val();
        if (group_sub = $("#group_sub").val(), !e || e.length < 3 || !group_sub || group_sub.length < 3 || group_sub.length > 11 || click) return !1;
        click = !0;
        var a = "type=group_create&group_name=" + e + "&group_sub=" + group_sub;
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $("#group_email, #group_name, #group_sub").val(""), $(".msg-success span").html(e.msg), $("tbody").html(e.group_lists);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    },
    group_search = function() {
        var e = $("#group_keyword").val();
        if (!e || e.length < 3 || click) return !1;
        click = !0;
        var a = "type=group_search&keyword=" + e;
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) $("tbody").html(e.msg);
                else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    },
    group_status = function(e, a) {
        return !e || click ? !1 : (click = !0, void new _request({
            method: "PUT",
            url: "groups/" + e,
            dataType: "json",
            data: "status=" + a,
            onComplete: function(t) {
                if (t.status) {
                    $(".msg-success").show(), $(".msg-success span").html(t.msg), a ? ($(".group-block-" + e).show(), $(".group-action-" + e).hide(), $(".group-status-" + e + " span").removeClass().css("color", "green").addClass("glyphicon glyphicon-eye-open").attr("data-original-title", "Công khai")) : ($(".group-block-" + e).hide(), $(".group-action-" + e).show(), $(".group-status-" + e + " span").removeClass().css("color", "black").addClass("glyphicon glyphicon-eye-close").attr("data-original-title", "Riêng tư"));
                    var n = setInterval(function() {
                        clearInterval(n), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(t.msg);
                    var n = setInterval(function() {
                        clearInterval(n), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        }))
    },
    group_delete = function(e) {
        return !e || click ? !1 : void(confirm("Bạn có chắc muốn xóa?") && (click = !0, new _request({
            method: "DELETE",
            url: "groups/" + e,
            dataType: "json",
            onComplete: function(a) {
                if (a.status) {
                    $(".msg-success").show(), $(".msg-success span").html(a.msg), $("#group-" + e).remove();
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })))
    },
    mmo = function() {
        var e = $("#mmo").is(":checked");
        if (click) return !1;
        var a = "type=MMO&status=" + (e ? 0 : 1);
        new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(a) {
                if (a.status) {
                    $(".msg-success").show(), $(".msg-success span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    e ? ($("#mmo").prop("checked", !0), $("div.toggle").removeClass("btn-danger off").addClass("btn-success")) : ($("#mmo").prop("checked", !1), $("div.toggle").removeClass("btn-success").addClass("btn-danger off")), $(".msg-danger").show(), $(".msg-danger span").html(a.msg);
                    var t = setInterval(function() {
                        clearInterval(t), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            },
            onError: function() {
                e ? ($("#mmo").prop("checked", !0), $("div.toggle").removeClass("btn-danger off").addClass("btn-success")) : ($("#mmo").prop("checked", !1), $("div.toggle").removeClass("btn-success").addClass("btn-danger off")), $(".msg-danger").show(), $(".msg-danger span").html("Có lỗi xảy ra, vui lòng thử lại");
                var a = setInterval(function() {
                    clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                }, 3e3)
            }
        })
    },
    withdraw = function() {
        var e = $("#note").val();
        if (choose = $("#choose-gifts").val(), mobile_network = $("#mobile-network").val(), mobile_rates = $("#mobile-rates").val(), mobile_receiver = $("#mobile-receiver").val(), game_network = $("#game-network").val(), game_rates = $("#game-rates").val(), game_receiver = $("#game-receiver").val(), paypal_email = $("#paypal-email").val(), paypal_rates = $("#paypal-rates").val(), banking_network = $("#banking-network").val(), banking_network_option = $("#banking-network-option").val(), banking_account_number = $("#banking-account-number").val(), banking_name = $("#banking-name").val(), banking_rates = $("#banking-rates").val(), !(1 != choose || mobile_network && mobile_rates)) return !1;
        if (!(2 != choose || game_network && game_rates)) return !1;
        if (!(3 != choose || paypal_email && paypal_rates)) return !1;
        if (4 == choose && (!banking_network || !banking_account_number || !banking_name || !banking_rates) || 10 == banking_network && !banking_network_option) return !1;
        if (e.length > 255) return !1;
        click = !0;
        var a = "choose-gifts=" + choose;
        a += "&note=" + e, 1 == choose ? a += "&mobile-network=" + mobile_network + "&mobile-rates=" + mobile_rates + "&mobile-receiver=" + mobile_receiver : 2 == choose ? a += "&game-network=" + game_network + "&game-rates=" + game_rates + "&game-receiver=" + game_receiver : 3 == choose ? a += "&paypal-email=" + paypal_email + "&paypal-rates=" + paypal_rates : 4 == choose && (a += "&banking-network=" + banking_network + "&banking-account-number=" + banking_account_number + "&banking-name=" + banking_name + "&banking-rates=" + banking_rates + "&banking-network-option=" + banking_network_option), new _request({
            method: "POST",
            dataType: "json",
            data: a,
            onComplete: function(e) {
                if (e.status) {
                    $(".msg-success").show(), $(".msg-success span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-success span").html(""), $(".msg-success").hide()
                    }, 3e3)
                } else {
                    $(".msg-danger").show(), $(".msg-danger span").html(e.msg);
                    var a = setInterval(function() {
                        clearInterval(a), $(".msg-danger span").html(""), $(".msg-danger").hide()
                    }, 3e3)
                }
            }
        })
    };
$("#choose-gifts").change(function() {
    var e = $("#choose-gifts").val();
    $(".mobile-card, .game-card, .paypal, .banking").hide(), 1 == e ? $(".mobile-card").show() : 2 == e ? $(".game-card").show() : 3 == e ? $(".paypal").show() : 4 == e && $(".banking").show(), e && total_point > 0 ? $("button#withdraw").removeClass("disabled") : $("button#withdraw").addClass("disabled")
}), $("#banking-network").change(function() {
    10 == $("#banking-network").val() ? $(".banking-option").show() : $(".banking-option").hide()
});
var copyToClipboard = function(e) {
        var a, t, n = "INPUT" === e.tagName || "TEXTAREA" === e.tagName;
        n && (target = e, a = e.selectionStart, t = e.selectionEnd);
        var s = document.activeElement;
        target.focus(), target.setSelectionRange(0, target.value.length);
        var r;
        try {
            r = document.execCommand("copy")
        } catch (o) {
            r = !1
        }
        return s && "function" == typeof s.focus && s.focus(), n ? e.setSelectionRange(a, t) : target.textContent = "", r
    },
    convertSize = function(e) {
        return e > 1099511627776 ? (Math.round(100 * e / 1099511627776) / 100).toString() + " Tb" : e > 1073741824 ? (Math.round(100 * e / 1073741824) / 100).toString() + " Gb" : e > 1048576 ? (Math.round(100 * e / 1048576) / 100).toString() + " Mb" : (Math.round(100 * e / 1024) / 100).toString() + " Kb"
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