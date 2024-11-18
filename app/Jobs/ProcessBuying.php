<?php

namespace App\Jobs;

use App\Models\Buying;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use Illuminate\Support\Facades\Http;

class ProcessBuying implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Buying $buying;

    protected string $token = "";

    protected string $apiUrl = "";

    /**
     * Create a new job instance.
     */
    public function __construct(Buying $buying)
    {
        $this->buying = $buying;
        $this->token = config('services.asaas.token');
        $this->apiUrl = config('services.asaas.url');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        if (empty($this->token)) {
            logger()->error('Token de autenticação ausente ou inválido.');
            return; 
        }

        $payload = [
            'name' => $this->buying->user->name,
            'cpfCnpj' => $this->buying->cpf,
            'mobilePhone' => $this->buying->phone,
            'email' => $this->buying->email
        ];

        try {
            $response = Http::withHeaders([
                'access_token' => $this->token,
                'content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->post($this->apiUrl.'customers', $payload);

            if ($response->successful()) {
                $customerData = $response->json();

                $this->buying->update([
                    'customer_id' =>  $customerData['id'],
                    'status' => 'sent',
                    'request' => json_encode($payload),
                    'error_reponse' => null,
                ]);

                $this->createPayment($customerData['id']);
            } else {
                $this->handleApiError($response, $payload);
            }
        } catch (\Exception $e) {
            logger()->error('Erro na requisição API Asaas', [
                'exception' => $e->getMessage(),
                'payload' => $payload,
            ]);
        }
    }

    private function handleApiError($response, $payload)
    {
        $errorResponse = [
            'message' => 'Falha ao criar cliente Asaas',
            'response_body' => $response->getBody(),
            'status_code' => $response->status(),
            'headers' => $response->headers(),
            'token' => $this->token,
            'payload' => $payload,
        ];

        $this->buying->update([
            'status' => 'failed',
            'error_reponse' => json_encode($errorResponse),
        ]);

        logger()->error('Falha ao criar cliente Asaas', [
            'payload' => $payload,
            'response' => $response->getBody(),
        ]);
    }

    private function createPayment(string $customerId): void
    {
        $paymentPayload = [
            'customer' => $customerId,
            'value' => $this->buying->price,
            'billingType' => "PIX",
            'dueDate' => now()->addDays(1)->toDateString(),
            'description' => "Pagamento relacionado à compra #{$this->buying->id}",
        ];

        $response = Http::withHeaders([
            'access_token' => $this->token,
            'content-Type' => 'application/json',
            'accept' => 'application/json',
        ])->post($this->apiUrl . "payments", $paymentPayload);

        if ($response->successful()) {
            $paymentData = $response->json();

            $paymentId = $paymentData['id'];

            $qrCodeResponse = Http::withHeaders([
                'access_token' => $this->token,
                'content-Type' => 'application/json',
                'accept' => 'application/json',
            ])->get($this->apiUrl . "payments/{$paymentId}/pixQrCode");

            if ($qrCodeResponse->successful()) {
                $qrCodeData = $qrCodeResponse->json();

                $this->buying->update([
                    'status' => 'payment_created',
                    'payment_id' => $paymentId,
                    'pix_qr_code' => $qrCodeData['payload'],
                    'pix_qr_code_url' => $qrCodeData['encodedImage'],
                ]);
            } else {
                logger()->error('Falha ao obter QR Code Asaas', [
                    'paymentId' => $paymentId,
                    'response' => $qrCodeResponse->getBody(),
                ]);
            }
        } else {
            logger()->error('Falha ao criar pagamento Asaas', [
                'paymentPayload' => $paymentPayload,
                'response' => $response->getBody(),
            ]);
        }
    }

}
