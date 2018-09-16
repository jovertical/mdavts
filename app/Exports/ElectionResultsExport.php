<?php

namespace App\Exports;

/**
 * Application
 */
use App\Repositories\ElectionRepository;
use App\Election;

/**
 * Package Services
 */
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ElectionResultsExport
    implements FromCollection, WithMapping, WithHeadings, ShouldAutoSize
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
        return (new ElectionRepository($this->election))->getWinners();
    }

    /**
     * @param array
     * @return array
     */
    public function map($winners): array
    {
        return [
            $winners->position->name,
            $winners->user->full_name_formal,
            $winners->votes,
        ];
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
