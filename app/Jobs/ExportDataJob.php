<?php

namespace App\Jobs;

use App\Models\Courses;
use App\Models\SendDownloadLinkJob;

use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Exports\CoursesExport;

use App\Jobs\SendDownloadLinkEmail;

class ExportDataJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public $ids;
    public $format;
    public $mode;
    public $email;

    public function __construct($ids, $format, $mode, $email)
    {
        $this->ids = $ids;
        $this->format = $format;
        $this->mode = $mode;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle()
    {
        if ($this->format == 'excel') {
            $this->exportExcel();
        } elseif ($this->format == 'pdf') {
            $this->exportPdf();
        }
    }

    private function exportExcel()
    { 
        Log::info('Iniciando exportação de dados. Formato: Excel');

        try {
            $courses = $this->ids ? Courses::whereIn('id', $this->ids)->get() : Courses::all();
            
            $fileName = 'courses_export_' . time() . '.xlsx';
            $filePath = 'excel/' . $fileName;

            Excel::store(new CoursesExport($courses), $filePath, 'public_excel');
            Log::info('Exportação Excel finalizada e arquivo armazenado: ' . $fileName);

            $this->saveSendDownloadLinkJob($filePath, 'download_link');

        } catch (\Exception $e) {
            Log::error('Erro durante a exportação Excel: ' . $e->getMessage());
            throw $e;
        }
    }

    private function exportPdf()
    {
        try {
            Log::info('Exportando dados para PDF...');

            $courses = $this->ids ? Courses::whereIn('id', $this->ids)->get() : Courses::all();
            $fileName = 'courses_export_' . time() . '.pdf';
            $filePath = 'pdf/' . $fileName;

            $pdf = Pdf::loadView('exports.courses', compact('courses'));
            Storage::disk('public_pdf')->put($filePath, $pdf->output());
            Log::info('Exportação PDF finalizada e arquivo armazenado: ' . $fileName);

            $this->saveSendDownloadLinkJob($filePath, 'download_link');

        } catch (\Exception $e) {
            Log::error('Erro durante a exportação PDF: ' . $e->getMessage());
            throw $e;
        }
    }

    private function saveSendDownloadLinkJob($filePath, $emailTemplate)
    {   
        $fileUrl = "";
        if ($this->format == 'excel') {
            $fileUrl = Storage::disk('public_excel')->url($filePath);
        } else {
            $fileUrl = Storage::disk('public_pdf')->url($filePath);
        }

        SendDownloadLinkJob::create([
            'email' => $this->email,
            'file_path' => $fileUrl,
            'status' => 'pending',
            'date_process' => now(),
            'send_type' => $this->format,
            'email_template' => $emailTemplate
        ]);

        dispatch(new SendDownloadLinkEmail())->delay(now()->addSeconds(5));

    }

}
