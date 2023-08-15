<?php

test('globals')
    ->expect(['dd', 'dump', 'ray'])
    ->not->toBeUsed();

test('nova')
    ->expect('App\Nova')
    ->toExtend('Laravel\Nova\Resource');

test('provider')
    ->expect('App\Providers')
    ->toHaveSuffix('ServiceProvider')
    ->toExtend('Illuminate\Support\ServiceProvider');

test('models')
    ->expect('App\Models')
    ->toExtend('Illuminate\Database\Eloquent\Model');

test('controllers')
    ->expect('App\Http\Controllers')
    ->toHaveSuffix('Controller')
    ->toBeClass();

test('enums')
    ->expect('App\Enums')
    ->toBeEnums();

test('traits')
    ->expect('App\Traits')
    ->toBeTraits();


