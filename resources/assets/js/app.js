/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

window.$('li.disabled a').click(function (event) {
    event.preventDefault();
});

window.$('input[type="checkbox"]#toggleMap').click(function() {
    $('.map').toggle();
});

window.$('input[type="checkbox"]#togglePlayers').click(function() {
    $('.players').toggle();
});

window.$('input[type="checkbox"]#toggleWeather').click(function() {
    $('.weather').toggle();
});

window.$('input[type="checkbox"]#toggleOptions').click(function() {
    $('.options').toggle();
});

window.$('input[type="checkbox"]#toggleOffline').click(function() {
    $('tr.danger').toggle();
});

window.$(function () {
    $('input[type="checkbox"]#toggleWeather').trigger("click");
    $('input[type="checkbox"]#toggleOptions').trigger("click");
    $('input[type="checkbox"]#toggleOffline').trigger("click");
});
