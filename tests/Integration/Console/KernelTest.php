<?php
namespace Tests\Integration\Console;

use App\Console\Kernel;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Support\Str;
use Tests\TestCase;

/**
 * @see Kernel
 */
class KernelTest extends TestCase
{

    /** @test */
    public function it_can_run_backup_db_command_is_scheduled_at_02am(): void
    {
        $schedule = app(Schedule::class);

        /** @var Event $event */
        $event = collect($schedule->events())
            ->filter(
                fn (Event $event) =>  Str::containsAll($event->command, ['backup:run --only-db']),
            )->first();

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('0 2 * * *', $event->expression);
    }

    /** @test */
    public function it_can_run_backup_clean_command_is_scheduled_at_02am_05minutes(): void
    {
        $schedule = app(Schedule::class);

        /** @var Event $event */
        $event = collect($schedule->events())
            ->filter(
                fn (Event $event) =>  Str::containsAll($event->command, ['backup:clean']),
            )->first();

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('5 2 * * *', $event->expression);
    }

    /** @test */
    public function it_can_run_backup_monitor_command_is_scheduled_at_10am_05minutes(): void
    {
        $schedule = app(Schedule::class);

        /** @var Event $event */
        $event = collect($schedule->events())
            ->filter(
                fn (Event $event) =>  Str::containsAll($event->command, ['backup:monitor']),
            )->first();

        $this->assertInstanceOf(Event::class, $event);
        $this->assertEquals('5 10 * * *', $event->expression);
    }

}
