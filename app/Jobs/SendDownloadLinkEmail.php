<?php

namespace App\Jobs;

use App\Models\SendDownloadLinkJob;

use App\Mail\DownloadLinkMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

use Carbon\Carbon;

class SendDownloadLinkEmail implements ShouldQueue
{
    use Queueable;

    public function handle()
    {
        $jobs = SendDownloadLinkJob::where('status', 'pending')->get();

        foreach ($jobs as $job) {
            try {
            
                Mail::to($job->email)->send(new DownloadLinkMail($job->file_path));

                $job->update([
                    'status' => 'sent',
                    'date_process' => Carbon::now(),
                ]);

                Log::info('Link email para download enviado: '. $job->email);
            } catch (\Exception $e) {
                $job->update(['status' => 'failed', 'error_message' => json_decode($e->getMessage())]);
                Log::info('Error: '.$e->getMessage());
            }
        }

    }

}
