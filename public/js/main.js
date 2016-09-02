var user = null;

var ajaxLogin = function () {

  var loginCallback = function(data, status, jqXhr) {
    console.log(data);
  };
  var username = $('#inputUsername').val();
  var password = $('#inputPassword').val();

  $.post('/login', {username: username, password: password}, loginCallback, 'json');
  return false;
};

var ajaxReport = function () {
 return false;
};

var getReport = function() {
  var getReportCallback = function(data, status, jqXhr) {
    console.log(data);

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

  $('#button-report').on('click', ajaxReport());

  getReport();
});
