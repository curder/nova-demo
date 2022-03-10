<?php

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;

it('has some schedules', function (string $command, $expression) {
    $schedule = app(Schedule::class);

    /** @var Event $event */
    $event = collect($schedule->events())
        ->filter(
            fn (Event $event) => Str::containsAll($event->command, [$command]),
        )->first();

    expect($event)->toBeInstanceOf(Event::class);
    expect($event->expression)->toEqual($expression);
})->with('schedules');
