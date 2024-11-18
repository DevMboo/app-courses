<?php

use App\Jobs\CheckPaymentStatusJob;
use Illuminate\Support\Facades\Schedule;

Schedule::job(new CheckPaymentStatusJob)->everyTwentySeconds();