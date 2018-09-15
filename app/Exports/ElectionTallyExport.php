<?php

namespace App\Exports;

/**
 * Application
 */
use App\Repositories\ElectionTallyRepository;
use App\Election;

/**
 * Package Services
 */
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromCollection;

class ElectionTallyExport implements FromCollection, WithHeadings
{
    /**
     * @var \App\Election
     */
    protected $election;

    /**
     * @param \App\Election
     */
    public function __construct(Election $election)
    {
        $this->election = $election;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return (new ElectionTallyRepository)->getData($this->election);
    }

    /**
     * @return array
     */
    public function headings() : array
    {
        return [
            'Position',
            'Candidate',
            'Votes'
        ];
    }
}
