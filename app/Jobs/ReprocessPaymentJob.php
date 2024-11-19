<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Http;

use App\Models\Buying;
use App\Models\Courses;

class ReprocessPaymentJob implements ShouldQueue
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
    public function handle(): void
    {
        //
        $reprocessPayments = Buying::where('status', 'reprocess_payment')->get();

        foreach ($reprocessPayments as $payment) {
            $response = Http::withHeaders(
                [
                    'access_token' => $this->token,
                    'content-Type' => 'application/json',
                    'accept' => 'application/json',
                ]
            )->put($this->apiUrl."/payments/{$payment->payment_id}", [
                'cpf' => $payment->cpf,
                'phone' => $payment->phone,
                'email' => $payment->email,
                'value' => $payment->price
            ]);

            if($response->successful()) {
                $payment->update(['status' => 'payment_created']);
            }
        }
    }
}
