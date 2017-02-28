let grid_button = document.querySelector('.products-actions-template-option-grid')
let list_button = document.querySelector('.products-actions-template-option-list')
let grid = document.querySelector('.products-grid')

grid_button.addEventListener('click', (e) => {
    e.preventDefault()
    grid.classList.add('products-grid-cards')
    list_button.classList.remove('products-actions-template-option-active')
    grid_button.classList.add('products-actions-template-option-active')
})

list_button.addEventListener('click', (e) => {
    e.preventDefault()
    grid.classList.remove('products-grid-cards')
    list_button.classList.add('products-actions-template-option-active')
    grid_button.classList.remove('products-actions-template-option-active')
})
