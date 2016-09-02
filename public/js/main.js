var user = null;

var ajaxLogin = function () {

  var loginCallback = function(data, status, jqXhr) {
    user = data;
    $('#loginModal').modal('hide');
    $('#loginContainer').addClass('hidden');
    $('#logoutContainer').removeClass('hidden');
    $('#showReportModal').show();

  };
  var username = $('#inputUsername').val();
  var password = $('#inputPassword').val();

  $.post('/login', {username: username, password: password}, loginCallback, 'json');
  return false;
};

var ajaxReport = function () {
  var reportCallback = function(data, status, jqXhr) {
    $('#reportModal').modal('hide');
    getReport();
  };

  var params = {
    yesterday: $('#inputYesterday').val(),
    today: $('#inputToday').val(),
    blockers: $('#inputBlockers').val(),
  };

  if (user == null) {
    $('#reportModal').modal('hide');
    alert('Please login first');
    $('#loginModal').modal('show');
    return false;
  }

  $.ajax({
    url: '/my-report',
    type: 'post',
    data: params,
    headers: {
      token: user.token
    },
    datatype: 'json',
    success: reportCallback
  });
  return false;
};

var getReport = function() {
  var getReportCallback = function(data, status, jqXhr) {

    var html = '';

    for (var i in data) {
      var row = data[i];
      html += '<tr><td>' + row.name + '</td><td>' + row.yesterday + '</td><td>' + row.today + '</td><td>' + row.blockers + '</td></tr>';
    }

    $('#reportTable tbody').html(html);
  };

  $.get('/report', getReportCallback);
};

$(window).on("load", function() {
  $('#button-signin').on('click', ajaxLogin);

  $('#button-report').on('click', ajaxReport);

  getReport();
});
