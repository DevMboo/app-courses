<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Jobs\ExportDataJob;

class ExportController extends Controller
{
    //
    public function export(Request $request)
    {
        $ids = $request->input('ids', []);
        $format = $request->input('format');
        $model = $request->input('mode');
        
        ExportDataJob::dispatch($ids, $format, auth()->user()->email, $model);
        
        session()->flash('message', 'Verifique seu e-mail para validar se recebeu o link de download, lembre-se de olhar a caixa de spam e a lixeira.');

        return response()->json(['status' => 'Exportação iniciada.'], 200);
    }
}
