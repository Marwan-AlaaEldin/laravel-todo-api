<?php

use Illuminate\Support\Facades\Schedule;

// بيشتغل كل ساعة
Schedule::command('tasks:send-reminders')->everySecond();