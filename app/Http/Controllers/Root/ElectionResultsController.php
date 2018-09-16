<?php

namespace App\Http\Controllers\Root;

/**
 * Application
 */
use App\Exports\{ElectionResultsExport};
use App\Repositories\ElectionRepository;
use App\Services\Notify;
use App\Election;

/**
 * Package Services
 */
use PDF;
use Maatwebsite\Excel\Facades\Excel;

/**
 * Laravel
 */
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ElectionResultsController extends Controller
{
    /**
     * Export Results.
     * @param \Illuminate\Http\Request
     * @param \App\Election
     * @return \Illuminate\Http\RedirectResponse
     */
    public function export(Request $request, Election $election)
    {
        $file_name = $request->input('file_name');
        $file_type = $request->input('file_type');

        try {
            switch (strtolower($file_type)) {
                case 'pdf':
                    $heading = "{$election->name} Results";
                    $archives = (new ElectionRepository($election))->getWinners();

                    return PDF::loadView('root.exports.elections.results', compact(
                        ['archives', 'heading']
                    ))
                    ->setPaper('a4', 'landscape')
                    ->setOptions(['dpi' => 150])
                    ->download($file_name.'.pdf');
                break;

                case 'excel':
                    return Excel::download(
                        new ElectionResultsExport($election), "{$file_name}.xlsx"
                    );
                break;

                case 'csv':
                    return Excel::download(
                        new ElectionResultsExport($election), "{$file_name}.csv"
                    );
                break;
            }

            throw new \ErrorException('Error generating results');
        } catch (Exception $e) {
            Notify::error($e->getMessage(), 'Error!');
        }

        return back();
    }
}