'use strict';

var categories_dates = document.querySelectorAll('.category-creation');

categories_dates.forEach(function (date) {
    var date_date = date.innerHTML;
    date.innerHTML = moment(date_date).fromNow();
});