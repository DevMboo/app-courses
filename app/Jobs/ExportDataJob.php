<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\CoursesExport;
use App\Exports\BuyingExport;

use App\Models\SendDownloadLinkJob;
use App\Models\Courses;
use App\Models\Buying;

use App\Jobs\SendDownloadLinkEmail;

class ExportDataJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public $ids;

    public $format;

    public $email;
    
    public $model;

    public function __construct($ids, $format, $email, $model)
    {
        $this->ids = $ids;
        $this->format = $format;
        $this->email = $email;
        $this->model = $model;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->format === 'excel') {
            $this->exportExcel();
        } elseif ($this->format === 'pdf') {
            $this->exportPdf();
        }
    }

    private function exportExcel()
    {
        try {
            Log::info('Iniciando exportação de dados. Formato: Excel');

            $data = $this->getData();
            $export = $this->getExporter($data);

            $fileName = "{$this->model}_export_" . time() . ".xlsx";
            $filePath = "excel/{$fileName}";

            Excel::store($export, $filePath, 'public_excel');
            Log::info("Exportação Excel finalizada e arquivo armazenado: {$fileName}");

            $this->saveSendDownloadLinkJob($filePath);

        } catch (\Exception $e) {
            Log::error('Erro durante a exportação Excel: ' . $e->getMessage());
            throw $e;
        }
    }

    private function exportPdf()
    {
        try {
            Log::info('Exportando dados para PDF...');

            $data = $this->getData();
            $fileName = "{$this->model}_export_" . time() . ".pdf";
            $filePath = "pdf/{$fileName}";

            $pdf = Pdf::loadView("exports.{$this->model}", ['datas' => $data]);
            Storage::disk("public_pdf")->put($filePath, $pdf->output());
            Log::info("Exportação PDF finalizada e arquivo armazenado: {$fileName}");

            $this->saveSendDownloadLinkJob($filePath);

        } catch (\Exception $e) {
            Log::error('Erro durante a exportação PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    private function getData()
    {
        $modelClass = $this->getModelClass();

        return $this->ids 
            ? $modelClass::whereIn('id', $this->ids)->get()
            : $modelClass::all();
    }

    private function getExporter($data)
    {
        return match ($this->model) {
            'courses' => new CoursesExport($data),
            'buying' => new BuyingExport($data),
            default => throw new \Exception("Exportador para {$this->model} não encontrado."),
        };
    }

    public function getModelClass()
    {
        $modelClass = 'App\\Models\\' . ucfirst($this->model);
        
        if (!class_exists($modelClass)) {
            throw new Exception("Modelo {$this->model} não encontrado.");
        }
        
        return $modelClass;
    }


    private function saveSendDownloadLinkJob($filePath)
    {
        $disk = $this->format === 'excel' ? 'public_excel' : 'public_pdf';
        $fileUrl = Storage::disk($disk)->url($filePath);

        SendDownloadLinkJob::create([
            'email' => $this->email,
            'file_path' => $fileUrl,
            'status' => 'pending',
            'date_process' => now(),
            'send_type' => $this->format,
            'email_template' => 'download_link',
        ]);

        dispatch(new SendDownloadLinkEmail())->delay(now()->addSeconds(5));
    }
}
