<?php

use Illuminate\Console\Scheduling\Schedule;

app(Schedule::class)->command('attendance:fetch')->everyMinute();