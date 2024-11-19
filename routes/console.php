<?php

use App\Jobs\CheckPaymentStatusJob;
use App\Jobs\ReprocessPaymentJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CheckPaymentStatusJob)->everyTwentySeconds();
Schedule::job(new ReprocessPaymentJob)->everyThirtySeconds();