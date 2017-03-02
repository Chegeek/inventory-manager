let categories_dates = document.querySelectorAll('.category-creation')

categories_dates.forEach((date) => {
    date.innerHTML = moment(date).fromNow()
})
