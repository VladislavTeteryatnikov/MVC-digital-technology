<?php

    //Массив, в котором храним контроллеры. У каждого контроллера есть action, который вызывается в зависимости от того, какой url вел пользователь
    $routes = array (
        'ManufacturersController' => array (
            'manufacturer/add' => 'add',
            'manufacturer/edit/([0-9]+)' => 'edit/$1',
            'manufacturer/delete/([0-9]+)' => 'delete/$1',
            'manufacturers/page=([0-9]+)' => 'index/$1',
            'manufacturers' => 'index'
        ),
        'UsersController' => array(
            'reg' => 'reg',
            'auth' => 'auth',
            'logout' => 'logout'
        ),
        'ProductsController' => array(
            'product/add' => 'add',
            'product/edit/([0-9]+)' => 'edit/$1',
            'product/delete/([0-9]+)' => 'delete/$1',
            'products/page=([0-9]+)' => 'index/$1',
            'products' => 'index'
        ),
        'CategoriesController' => array(
            'category/add' => 'add',
            'category/edit/([0-9]+)' => 'edit/$1',
            'category/delete/([0-9]+)' => 'delete/$1',
            'categories/page=([0-9]+)' => 'index/$1',
            'categories' => 'index'
        )
    );
