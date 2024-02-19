<?php
use DaveJamesMiller\Breadcrumbs\Facades\Breadcrumbs;


Breadcrumbs::register('home_ad',function ($breadcrumbs){
    $breadcrumbs->push('Home',route('adminMain'));
});

Breadcrumbs::register('home_st',function ($breadcrumbs){
    $breadcrumbs->push('Home',route('studentMain'));
});

Breadcrumbs::register('department',function ($breadcrumbs){
    $breadcrumbs->parent('home_ad');
    $breadcrumbs->push('Department',route('department.index'));
});

Breadcrumbs::register('department_st',function ($breadcrumbs){
    $breadcrumbs->parent('home_st');
    $breadcrumbs->push('Department',route('department.index'));
});

Breadcrumbs::register('departmentCreate',function ($breadcrumbs){
    $breadcrumbs->parent('department');
    $breadcrumbs->push('Create',route('department.create'));
});

Breadcrumbs::register('departmentEdit', function ($breadcrumbs, $department) {
    $breadcrumbs->parent('department');
    $breadcrumbs->push('Edit', route('department.edit', $department));
});

