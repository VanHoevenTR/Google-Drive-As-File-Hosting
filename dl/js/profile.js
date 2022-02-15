
$('input[name=email]').val(user_email);
$('input[name=user]').val(user_nickname);
$('input[name=avatar]').val(user_avatar);
$('input[name=logo]').val(user_player_logo);
$('input[name=created]').text(user_created);
user_gender=='male' ? $('input[name=gender][value=male]').prop("checked", true) : (user_gender=='female' ? $('input[name=gender][value=male]').prop("checked", true) : '');
