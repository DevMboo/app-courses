<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\ExportDataJob;

class ExportController extends Controller
{
    //
    public function export(Request $request)
    {
        try {
            //code...
            $ids = $request->input('ids', []);
            $format = $request->input('format');
            $mode = $request->input('mode');
            
            ExportDataJob::dispatch($ids, $format, $mode);
    
            return response()->json(['status' => 'Exportação iniciada.'], 200);
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
    }
}
