<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function show(Request $request)
    {
        $hex = "H";
        $binary = pack('H', $hex);

        dd($binary);

        $report = $request->all();

        $months = [
            '01' => "январь",
            '02' => "февраль",
            '03' => "март",
            '04' => "апрель",
            '05' => "май",
            '06' => "июнь",
            '07' => "июль",
            '08' => "август",
            '09' => "сентябрь",
            '10' => "октябрь",
            '11' => "ноябрь",
            '12' => "декабрь"
        ];

        $report['month_name'] = $months[$report['month']];

        $report_obj = $this->get_random_report_object();

        return view('pages.report', compact(['report', 'report_obj']));
    }

    private function get_random_report_object()
    {
        $report_object = [
            'electricity' => [
                'tarif' => 4.55,
                'start' => mt_rand(10000, 50000),
                'diff'  => 2000 + rand(1, 4000),
                'end'   => 0
            ],
            'water' => [
                'tarif' => 27.99,
                'start' => mt_rand(10000, 50000),
                'diff'  => 500 + rand(1, 1000),
                'end'   => 0
            ],
            'heat' => [
                'tarif' => 1678.72,
                'start' => mt_rand(10000, 50000),
                'diff'  => rand(1, 100),
                'end'   => 0
            ],
            'total' => 0
        ];

        foreach ($report_object as $cons) {
            $end = $cons['start'] + $cons['diff'];



            $cons['cost'] = [];
            $cons['cost']['value'] = $cons['diff'] * $cons['tarif'];
            $cons['cost']['str'] = number_format($cons['cost']['value'], 2, ",", " ");

            $report_object['total'] += $cons['cost']['value'];
        }

        $report_object['total_str'] = number_format($report_object['total'], 0, ",", " ") . " руб. " . round(100 * fmod($total, 1)) . " коп.";

        return $report_object;
    }
}
