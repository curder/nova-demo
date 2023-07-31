<?php

it('welcome page has the correct index URL')
    ->expect(fn () => route('index'))
    ->toBe('http://localhost');

it('has welcome page')
    ->get('/')
    ->assertRedirect('/cp/dashboards/main');
