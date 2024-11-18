<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

use App\Models\Buying;
use App\Models\Courses;

class CheckPaymentStatusJob implements ShouldQueue
{
    use Queueable;

    protected string $token = "";

    protected string $apiUrl = "";

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
        $this->token = config('services.asaas.token');
        $this->apiUrl = config('services.asaas.url');
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        $pendingPayments = Buying::where('status', 'payment_created')->get();

        foreach ($pendingPayments as $payment) {
            $response = Http::get($this->apiUrl."/payments/{$payment->payment_id}", [
                'access_token' => $this->token,
                'content-Type' => 'application/json',
                'accept' => 'application/json',
            ]);

            if ($response->successful()) {
                $paymentStatus = $response->json('status');

                if ($paymentStatus === 'RECEIVED') {
                    $payment->update([
                        'status' => 'payment_confirmed',
                    ]);

                    $course = Courses::find($payment->course_id);
                    if ($course && $course->vacancies > 0) {
                        $course->decrement('vacancies', 1);
                    }
                }
            } else {
                logger()->error("Erro ao verificar pagamento ID {$payment->id}");
            }
        }
    }
}
