<?php

it('welcome page has the correct index URL')
    ->expect(fn () => route('welcome'))
    ->toBe('http://localhost');

it('has welcome page')
    ->get('/')
    ->assertOk()
    ->assertSee('Nova Demo');
