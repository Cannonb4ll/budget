<?php

namespace App\Http\Controllers;

use App\Models\Line;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Rap2hpoutre\FastExcel\SheetCollection;

class ExportController extends Controller
{
    public function export()
    {
        $grouped = Line::groupBy('type')->select('type', DB::raw('SUM(total) as total'))->get();

        $sheets = new SheetCollection([
            'Groepen overzicht' => $grouped->map(function ($line) {
                return [
                    'Groep' => $line->type,
                    'Totaal' => $line->total
                ];
            }),
            'Totalen' => collect([
                [
                    'Totaal budget beschikbaar' => Line::sum('total'),
                    'Totaal afschrijving' => Line::where('total', '<', 0)->sum('total'),
                    'Aantal lijnen' => Line::count(['id'])
                ],
            ]),
            'Lijnen' => Line::latest()->get()->map(function($line){
                return [
                    'Type' => $line->type,
                    'Beschrijving' => $line->description,
                    'Totaal' => $line->total,
                    'Datum' => $line->created_at->format('Y-m-d H:i:s')
                ];
            })
        ]);


        return (new FastExcel($sheets))->download('kdv-export-' . date('Y-m-d') . '.xlsx');
    }
}
