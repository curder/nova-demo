<?php

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;

uses(\Tests\TestCase::class);

it('can run backup db command is scheduled at 02 am', function () {
    $schedule = app(Schedule::class);

    /** @var Event $event */
    $event = collect($schedule->events())
        ->filter(
            fn (Event $event) => Str::containsAll($event->command, ['backup:run --only-db']),
        )->first();

    $this->assertInstanceOf(Event::class, $event);
    $this->assertEquals('0 2 * * *', $event->expression);
});

it('can run backup clean command is scheduled at 02 am 05 minutes', function () {
    $schedule = app(Schedule::class);

    /** @var Event $event */
    $event = collect($schedule->events())
        ->filter(
            fn (Event $event) => Str::containsAll($event->command, ['backup:clean']),
        )->first();

    $this->assertInstanceOf(Event::class, $event);
    $this->assertEquals('5 2 * * *', $event->expression);
});

it('can run backup monitor command is scheduled at 10 am 05 minutes', function () {
    $schedule = app(Schedule::class);

    /** @var Event $event */
    $event = collect($schedule->events())
        ->filter(
            fn (Event $event) => Str::containsAll($event->command, ['backup:monitor']),
        )->first();

    $this->assertInstanceOf(Event::class, $event);
    $this->assertEquals('5 10 * * *', $event->expression);
});
