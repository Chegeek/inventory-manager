'use strict';

var categories_dates = document.querySelectorAll('.category-creation');

categories_dates.forEach(function (date) {
    date.innerHTML = moment(date).fromNow();
});