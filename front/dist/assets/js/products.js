'use strict';

var grid_button = document.querySelector('.products-actions-template-option-grid');
var list_button = document.querySelector('.products-actions-template-option-list');
var grid = document.querySelector('.products-grid');

grid_button.addEventListener('click', function (e) {
    e.preventDefault();
    grid.classList.add('products-grid-cards');
    list_button.classList.remove('products-actions-template-option-active');
    grid_button.classList.add('products-actions-template-option-active');
});

list_button.addEventListener('click', function (e) {
    e.preventDefault();
    grid.classList.remove('products-grid-cards');
    list_button.classList.add('products-actions-template-option-active');
    grid_button.classList.remove('products-actions-template-option-active');
});