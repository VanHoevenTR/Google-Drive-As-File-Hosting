var click, origin = document.location.origin,
    dropzone = $("#dropzone"),
    btnUpload = $("#submitUpload"),
    xhr_arr = [],
    allItems = [],
    myStart = "",
    uploadChange = function() {
        var e = $("#myfile").prop("files");
        checkItems(), addFiles(e), addItems(e)
    },
    checkItems = function() {
        xhr_arr.length || btnUpload.css("display", "inline-table"), allItems.length || dropzone.html("")
    },
    addFiles = function(e) {
        var t;
        for (dropzone.css("overflow", "auto"), checkItems(), x = 0; x < e.length; x += 1) {
            var r, o = x + allItems.length,
                n = document.createElement("div");
            n.className = "row box-items", n.id = "cancel-" + o, r = 100 < e[x].name.length ? "..." : "", t = "", t += '<div class="col-md-12" style="padding-bottom:5px;">', t += '<p class="fileName"><span class="glyphicon glyphicon-cloud-upload"></span> ' + e[x].name.substr(0, 100) + r + "</p>", t += '<span id="cancel-button-' + o + '" style="float: right" onclick="myRemove(' + o + ')"><button class="btn btn-xs btn-danger">Remove</button></span>', t += "</div>", t += '<div class="clearfix"></div>', t += '<div class="col-md-12" style="margin: 0;">', t += '<span id="storage-' + o + '" class="storage">' + _convertSize(e[x].size) + "</span>", t += '<div class="speed" id="speed-' + o + '"></div>', t += '<div class="progress">', t += '<div id="progress-bar-' + o + '" class="progress-bar progress-bar-striped active"></div>', t += "</div>", t += "</div>", n.innerHTML = t, dropzone.append(n), t = ""
        }
    },
    addItems = function(e) {
        if (0 < e.length)
            for (x = 0; x < e.length; x += 1) allItems.push(e[x])
    },
    submitUpload = function() {
        btnUpload.css("display", "none"), 0 != allItems.length && uploadFile(allItems, 0)
    },
    myRemove = function(e) {
        if (console.log(e), $("#cancel-" + e).remove(), allItems.splice(e, 1), "string" != typeof myStart && myStart == e)
            for (i = 0; i < xhr_arr.length; i++) xhr_arr[i].abort();
        for (t = e; t < allItems.length; t++) $("#cancel-" + (t + 1)).attr("id", "cancel-" + t), $("#cancel-button-" + (t + 1)).attr("onClick", "myRemove(" + t + ");"), $("#cancel-button-" + (t + 1)).attr("id", "cancel-button-" + t), $("#speed-" + (t + 1)).attr("id", "speed-" + t), $("#progress-bar-" + (t + 1)).attr("id", "progress-bar-" + t), $("#storage-" + (t + 1)).attr("id", "storage-" + t);
        (xhr_arr.length = 0) == allItems.length && btnUpload.css("display", "none"), "number" == typeof myStart && e + 1 <= allItems.length && myStart == e && uploadFile(allItems, e)
    };
myPause = function(e) {
    $("#pause-button-" + e).remove(), $('<span id="resume-button-' + e + '" style="float: right" onclick="myResume(' + e + ')"><button class="btn btn-xs btn-success">Resume</button></span>').insertBefore("#cancel-button-" + e), $("#progress-bar-" + e).removeClass("progress-bar-striped active progress-bar-warning").addClass("progress-bar-info")
}, myResume = function(e) {
    $("#resume-button-" + e).remove(), $('<span id="pause-button-' + e + '" style="float: right" onclick="myPause(' + e + ')"><button class="btn btn-xs btn-primary">Pause</button></span>').insertBefore("#cancel-button-" + e)
}, dropzone.on("drop", function(e) {
    e.preventDefault(), this.className = "dropzone", dropzone.css("lineHeight", "inherit"), addFiles(e.originalEvent.dataTransfer.files), addItems(e.originalEvent.dataTransfer.files), checkItems()
}), dropzone.on("dragover", function() {
    return !(this.className = "dropzone dragover")
}), dropzone.on("dragleave", function() {
    return !(this.className = "dropzone")
});
var _convertSize = function(e) {
    return 1073741824 < e ? (Math.round(100 * e / 1073741824) / 100).toString() + " Gb" : 1048576 < e ? (Math.round(100 * e / 1048576) / 100).toString() + " Mb" : (Math.round(100 * e / 1024) / 100).toString() + " Kb"
};
window.addEventListener("beforeunload", function(e) {
    if ("number" == typeof myStart) {
        var t = "Want to leave the page?";
        return (e || window.event).returnValue = t
    }
});
var RetryHandler = function() {
    this.interval = 1e3, this.maxInterval = 6e4
};
RetryHandler.prototype.retry = function(e) {
    setTimeout(e, this.interval), this.interval = this.nextInterval_()
}, RetryHandler.prototype.reset = function() {
    this.interval = 1e3
}, RetryHandler.prototype.nextInterval_ = function() {
    var e = 2 * this.interval + this.getRandomInt_(0, 1e3);
    return Math.min(e, this.maxInterval)
}, RetryHandler.prototype.getRandomInt_ = function(e, t) {
    return Math.floor(Math.random() * (t - e + 1) + e)
};
var multiUpload = function(e) {
    var t = function() {};
    if (this.file = e.file, this.contentType = e.contentType || this.file.type || "application/octet-stream", this.metadata = e.metadata || {
            name: this.file.name,
            mimeType: this.contentType
        }, this.access = e.access, this.onComplete = e.onComplete || t, this.onProgress = e.onProgress || t, this.onError = e.onError || t, this.offset = e.offset || 0, this.chunkSize = e.chunkSize || 0, this.retryHandler = new RetryHandler, this.url = e.url, !this.url) {
        var r = e.params || {};
        r.uploadType = "resumable", this.url = this.buildUrl_(e.fileId, r, e.baseUrl)
    }
    this.httpMethod = e.fileId ? "PUT" : "POST"
};
multiUpload.prototype.upload = function() {
    var r = this;
    new _request({
        method: r.httpMethod,
        url: r.url,
        headers: {
            Authorization: "Bearer " + r.access,
            "Content-Type": "application/json",
            "X-Upload-Content-Length": r.file.size,
            "X-Upload-Content-Type": r.contentType
        },
        data: JSON.stringify(r.metadata),
        onComplete: function(e) {
            if (e.status < 400) {
                var t = e.getResponseHeader("Location");
                r.url = t, r.sendFile_()
            } else r.onUploadError_(e)
        },
        onError: function(e) {
            r.onUploadError_.bind(r)
        }
    })
}, multiUpload.prototype.sendFile_ = function() {
    var e = this,
        t = e.file,
        r = t.size,
        s = 0;
    (e.offset || e.chunkSize) && (e.chunkSize && (s = e.offset + e.chunkSize, r = Math.min(s, e.file.size)), t = t.slice(e.offset, r));
    var o = new XMLHttpRequest;
    xhr_arr.push(o), o.open("PUT", this.url, !0), o.setRequestHeader("Content-Type", this.contentType), o.setRequestHeader("Content-Range", "bytes " + this.offset + "-" + (r - 1) + "/" + this.file.size), o.setRequestHeader("X-Upload-Content-Type", this.file.type);
    var a = 0;
    o.upload.addEventListener("progress", function(e) {
        0 == a && (a = e.timeStamp);
        var t = e.loaded,
            r = e.total,
            o = parseInt((t + s) / r * 100) || 0,
            n = speedRate(a, e.timeStamp, 0, t);
        $("#progress-bar-" + myStart).html(o + "%"), $("#progress-bar-" + myStart).css("width", o + "%"), $("#speed-" + myStart).html(n), 100 == o && $("#progress-bar-" + myStart).addClass("progress-bar-warning").html("Waiting...")
    }, !1), o.onload = this.onContentUploadSuccess_.bind(this), o.onerror = this.onContentUploadError_.bind(this), o.send(t)
}, multiUpload.prototype.resume_ = function() {
    var t = this;
    new _request({
        method: "PUT",
        url: t.url,
        headers: {
            "Content-Range": "bytes " + t.file.size,
            "X-Upload-Content-Type": t.file.type
        },
        beforeSend: function(e) {
            e.upload.addEventListener("progress", t.onProgress)
        },
        onComplete: function(e) {
            t.onContentUploadSuccess_.bind(t)
        },
        onError: function() {
            console.log("multiUpload.prototype.resume"), t.onContentUploadError_.bind(t)
        }
    })
}, multiUpload.prototype.extractRange_ = function(e) {
    var t = e.getResponseHeader("Range");
    t && (this.offset = parseInt(t.match(/\d+/g).pop(), 10) + 1)
}, multiUpload.prototype.onContentUploadSuccess_ = function(e) {
    var t = this;
    if (200 == e.target.status || 201 == e.target.status) {
        var r = JSON.parse(e.target.response),
            o = "type=savefile&fileId=" + r.id + "&fileName=" + r.name + "&fileType=" + r.mimeType + "&fileSize=" + this.file.size;
        new _request({
            method: "POST",
            url: "./remote.php",
            data: o,
            dataType: "json",
            onSuccess: function(e) {
                1 == e.status ? ($("#progress-bar-" + myStart).removeClass("progress-bar-striped active progress-bar-warning").addClass("progress-bar-success").html("Complete"), $("#at-file-complete").show().append(e.file_content)) : $("#progress-bar-" + myStart).removeClass("progress-bar-striped active progress-bar-warning").addClass("progress-bar-danger").html(e.msg), xhr_arr.length = 0, t.onComplete()
            },
            onError: function(e) {
                $("#progress-bar-" + myStart).removeClass("progress-bar-striped active progress-bar-warning").addClass("progress-bar-danger").html("An error occurred, please try again."), xhr_arr.length = 0, t.onComplete()
            }
        })
    } else 308 == e.target.status ? (this.extractRange_(e.target), this.retryHandler.reset(), this.sendFile_()) : this.onContentUploadError_(e)
}, multiUpload.prototype.onContentUploadError_ = function(e) {
    console.log("onContentUploadError"), e.target.status && e.target.status < 500 ? this.onError(e.target.response) : this.retryHandler.retry(this.resume_.bind(this)), sendError("onContentUploadError", e.target.response)
}, multiUpload.prototype.onUploadError_ = function(e) {
    console.log("onUploadError:\n" + e.target.response), sendError("onUploadError", e.target.response), this.onError(e.target.response)
}, multiUpload.prototype.buildQuery_ = function(t) {
    return t = t || {}, Object.keys(t).map(function(e) {
        return encodeURIComponent(e) + "=" + encodeURIComponent(t[e])
    }).join("&")
}, multiUpload.prototype.buildUrl_ = function(e, t, r) {
    var o = r || "https://www.googleapis.com/upload/drive/v3/files/";
    e && (o += e);
    var n = this.buildQuery_(t);
    return n && (o += "?" + n), o
};
var mediaUpload = function(e, t) {
        var r = new multiUpload({
            file: e[t],
            access: getCookie("access"),
            onComplete: function() {
                return t + 1 < e.length ? uploadFile(e, t + 1) : allItems.splice(0, allItems.length)
            }
        });
        myStart = t, r.upload()
    },
    uploadFile = function(e, t) {
        if (null != typeof e[t]) {
            if (107374182400 < e[t].size) return $("#progress-bar-" + t + ", #cancel-button-" + t).remove(), $("#storage-" + t).html('<strong style="color:red">Error: File lớn hơn 100gb</strong>'), t + 1 < e.length ? uploadFile(e, t + 1) : allItems.splice(0, allItems.length);
            if (e[t].size < 1) return $("#progress-bar-" + t + ", #cancel-button-" + t).remove(), $("#storage-" + t).html('<strong style="color:red">Error: Tệp tin trống</strong>'), t + 1 < e.length ? uploadFile(e, t + 1) : allItems.splice(0, allItems.length);
            _checkUpload(e, t)
        }
    },
    _checkUpload = function(r, o) {
        var e = "type=checkfileupload&fileName=" + encodeURIComponent(r[o].name) + "&fileType=" + encodeURIComponent(r[o].type) + "&fileSize=" + r[o].size;
        xhr = new XMLHttpRequest, xhr.open("POST", "./upload", !0), xhr.setRequestHeader("X-Requested-With", "XMLHttpRequest"), xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded"), xhr.send(e), xhr.onreadystatechange = function() {
            if (4 == xhr.readyState && 200 == xhr.status) {
                var e = JSON.parse(xhr.responseText);
                if (e.status)
                    if (getCookie("access")) mediaUpload(r, o);
                    else {
                        var t;
                        _checkUpload(r, o), t = setInterval(function() {
                            getCookie("access") && (clearInterval(t), mediaUpload(r, o))
                        }, 100)
                    }
                else document.cookie = "access=;expires=Thu, 01 Jan 1970 00:00:00 GMT", alert(e.msg)
            }
        }
    },
    getCookie = function(e) {
        for (var t = e + "=", r = document.cookie.split(";"), o = 0; o < r.length; o++) {
            for (var n = r[o];
                " " == n.charAt(0);) n = n.substring(1);
            if (0 == n.indexOf(t)) return n.substring(t.length, n.length)
        }
        return ""
    },
    speedRate = function(e, t, r, o) {
        var n = t - e,
            s = 0;
        if (0 != n) {
            var a = (o - r) / n;
            return s = -1 < navigator.userAgent.toLowerCase().indexOf("firefox") ? parseInt(1e3 * a * 1e3) : parseInt(1e3 * a), _convertSize(s) + "/s"
        }
        return s = -1 < navigator.userAgent.toLowerCase().indexOf("firefox") ? parseInt(1e3 * o) : parseInt(o), _convertSize(s) + "/s"
    },
    _request = function(e) {
        var t = function() {};
        this.beforeSend = e.beforeSend || t, this.onComplete = e.onComplete || t, this.onSuccess = e.onSuccess || t, this.onError = e.onError || t, this.method = e.method, this.url = e.url || "", this.headers = e.headers || "", this.dataType = e.dataType || "", this.data = e.data || "", this._send()
    };
_request.prototype._send = function() {
    var t = this;
    $.ajax({
        type: t.method,
        url: t.url,
        headers: t.headers,
        dataType: t.dataType,
        data: t.data,
        contentType: t.contentType,
        success: function(e) {
            t.onSuccess(e)
        },
        complete: function(e) {
            t.onComplete(e)
        },
        error: function(e) {
            t.onError(e)
        }
    })
}, sendError = function(e, t) {
    $("#progress-bar-" + myStart).removeClass("progress-bar-striped active progress-bar-warning").addClass("progress-bar-danger").html("Có lỗi xảy ra."), new _request({
        method: "POST",
        url: "./upload",
        data: {
            type: "report",
            error: e,
            data: t
        },
        dataType: "json",
        onSuccess: function(e) {}
    })
};
