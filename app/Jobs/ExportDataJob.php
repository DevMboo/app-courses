<?php

namespace App\Jobs;

use App\Models\Courses;
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

class ExportDataJob implements ShouldQueue
{
    use Queueable, InteractsWithQueue, SerializesModels, Dispatchable;

    public $ids;
    public $format;
    public $mode;

    /**
     * Create a new job instance.
     */
    public function __construct($ids, $format, $mode)
    {
        $this->ids = $ids;
        $this->format = $format;
        $this->mode = $mode;
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
            $filePath = 'public/' . $fileName;

            // Salva o arquivo Excel no disco público
            Excel::store(new CoursesExport($courses), $filePath, 'public');
            Log::info('Exportação Excel finalizada e arquivo armazenado: ' . $fileName);

            // Notificação ou evento para informar que o arquivo está pronto pode ser incluído aqui

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
            $filePath = 'public/' . $fileName;

            $pdf = Pdf::loadView('exports.courses', compact('courses'));

            // Salva o arquivo PDF no disco público
            Storage::disk('public')->put($fileName, $pdf->output());
            Log::info('Exportação PDF finalizada e arquivo armazenado: ' . $fileName);

            // Notificação ou evento para informar que o arquivo está pronto pode ser incluído aqui

        } catch (\Exception $e) {
            Log::error('Erro durante a exportação PDF: ' . $e->getMessage());
            throw $e;
        }
    }
}
