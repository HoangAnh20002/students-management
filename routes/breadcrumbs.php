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

Breadcrumbs::register('course',function ($breadcrumbs){
    $breadcrumbs->parent('home_ad');
    $breadcrumbs->push('Course',route('course.index'));
});

Breadcrumbs::register('course_st',function ($breadcrumbs){
    $breadcrumbs->parent('home_st');
    $breadcrumbs->push('Course',route('course.index'));
});

Breadcrumbs::register('courseCreate',function ($breadcrumbs){
    $breadcrumbs->parent('course');
    $breadcrumbs->push('Create',route('course.create'));
});

Breadcrumbs::register('courseEdit', function ($breadcrumbs, $course) {
    $breadcrumbs->parent('course');
    $breadcrumbs->push('Edit', route('course.edit', $course));
});
Breadcrumbs::register('student',function ($breadcrumbs){
    $breadcrumbs->parent('home_ad');
    $breadcrumbs->push('Student',route('student.index'));
});
Breadcrumbs::register('studentCreate',function ($breadcrumbs){
    $breadcrumbs->parent('student');
    $breadcrumbs->push('Create',route('student.create'));
});
Breadcrumbs::register('studentEdit',function ($breadcrumbs, $student){
    $breadcrumbs->parent('student');
    $breadcrumbs->push('Edit',route('student.edit',$student));
});
Breadcrumbs::register('courseRegister',function ($breadcrumbs){
    $breadcrumbs->parent('home_st');
    $breadcrumbs->push('Course register',route('courses.register'));
});
Breadcrumbs::register('resultDetail',function ($breadcrumbs,$student){
    $breadcrumbs->parent('student');
    $breadcrumbs->push('Result Detail',route('result.show', $student));
});
Breadcrumbs::register('detail',function ($breadcrumbs,$student){
    $breadcrumbs->parent('home_st');
    $breadcrumbs->push('Result Detail',route('result.show', $student));
});

