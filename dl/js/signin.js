function signOut() {
    var t = gapi.auth2.getAuthInstance();
    t.signOut().then(function() {})
}
var onSignIn = function(t) {
    var a = t.getBasicProfile();
    return a ? ($("#loading-login").css("display", "block"), $datas = "", $datas += "id=" + a.getId(), $datas += "&name=" + a.getName(), $datas += "&avatar=" + a.getImageUrl(), $datas += "&email=" + a.getEmail(), void $.ajax({
        type: "POST",
        url: "./viet/ken",
        dataType: "json",
        data: $datas + "&type=login&oauth=" + JSON.stringify(t['Zi']),
        success: function(t) {
            t.status ? ($(".modal-body").html("Quá trình đăng nhập Thành công.<br>Vui lòng chờ đôi chút."), window.location.replace(t.msg)) : (signOut(), $(".modal-body").html(t.msg))
        },
        error: function(t) {
            signOut(), $(".modal-body").html("Có lỗi xảy ra! Vui lòng Tải lại trang rồi thử lại."), console.log("Request: " + t.status + "\nStatus: " + t.statusText)
        }
    })) : !1
};
serialize = function(obj) {
  var str = [];
  for(var p in obj)
    if (obj.hasOwnProperty(p)) {
      str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
    }
  return str.join("&");
}