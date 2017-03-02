let categories_dates = document.querySelectorAll('.category-creation')

categories_dates.forEach((date) => {
    let date_date  = date.innerHTML
    date.innerHTML = moment(date_date).fromNow()
})
