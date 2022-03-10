<?php

dataset('schedules', function () {
    return [
        'can run backup db command is scheduled at 02 am' => ['backup:run --only-db', '0 2 * * *'],
        'can run backup clean command is scheduled at 02 am 05 minutes' => ['backup:clean', '5 2 * * *'],
        'can run backup monitor command is scheduled at 10 am 05 minutes' => ['backup:monitor', '5 10 * * *'],
    ];
});
