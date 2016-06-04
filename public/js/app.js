$('li.disabled a').click(function (event) {
    event.preventDefault();
});

$('input[type="checkbox"]#toggleMap').click(function() {
    $('.map').toggle();
});

$('input[type="checkbox"]#togglePlayers').click(function() {
    $('.players').toggle();
});

$('input[type="checkbox"]#toggleWeather').click(function() {
    $('.weather').toggle();
});

$('input[type="checkbox"]#toggleOptions').click(function() {
    $('.options').toggle();
});

$('input[type="checkbox"]#toggleOffline').click(function() {
    $('tr.danger').toggle();
});

$(function () {
    $('input[type="checkbox"]#toggleWeather').trigger("click");
    $('input[type="checkbox"]#toggleOptions').trigger("click");
    $('input[type="checkbox"]#toggleOffline').trigger("click");
});

//# sourceMappingURL=app.js.map
