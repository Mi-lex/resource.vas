<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ReportController extends Controller
{
    private $months = [
        '1' => "январь",
        '2' => "февраль",
        '3' => "март",
        '4' => "апрель",
        '5' => "май",
        '6' => "июнь",
        '7' => "июль",
        '8' => "август",
        '9' => "сентябрь",
        '10' => "октябрь",
        '11' => "ноябрь",
        '12' => "декабрь"
    ];

    public function show(Request $request)
    {
        $report = $request->all();

        $report['monthName'] = $this->months[$report['month']];

        $report_obj = $this->get_random_report_object();

        return view('pages.report', compact(['report', 'report_obj']));
    }

    public function show_object(Request $request)
    {
        $report = $request->all();

        $report['monthName'] = $this->months[$report['month']];

        $object = \App\Models\MiltaryObject::find($report['object_id']);

        $total = 0;

        foreach ($object->sectors as $sector) {
            $sector->report = $this->get_random_report_object();

            $total += $sector->report['total'];
        }

        $total_str = number_format($total, 0, ",", " ") . " руб. " . round(100 * fmod($total, 1)) . " коп.";

        return view('pages.report_object', compact(['object', 'report', 'total_str']));
    }

    private function get_random_report_object()
    {
        $electricity = [
            'tarif' => 4.55,
            'start' => mt_rand(10000, 50000),
            'diff'  => 2000 + rand(1, 4000),
            'end'   => 0,
            'cost_value'  => 0,
            'cost_str' => ''
        ];
        $water = [
            'tarif' => 27.99,
            'start' => mt_rand(10000, 50000),
            'diff'  => 500 + rand(1, 1000),
            'end'   => 0,
            'cost_value'  => 0,
            'cost_str' => ''
        ];
        $heat = [
            'tarif' => 1678.72,
            'start' => mt_rand(10000, 50000),
            'diff'  => rand(1, 100),
            'end'   => 0,
            'cost_value'  => 0,
            'cost_str'    => ''
        ];

        $electricity['end'] = $electricity['start'] + $electricity['diff'];
        $electricity['cost_value'] = $electricity['diff'] * $electricity['tarif'];
        $electricity['cost_str'] = number_format($electricity['cost_value'], 2, ",", " ");

        $water['end'] = $water['start'] + $water['diff'];
        $water['cost_value'] = $water['diff'] * $water['tarif'];
        $water['cost_str'] = number_format($water['cost_value'], 2, ",", " ");

        $heat['end'] = $heat['start'] + $heat['diff'];
        $heat['cost_value'] = $heat['diff'] * $heat['tarif'];
        $heat['cost_str'] = number_format($heat['cost_value'], 2, ",", " ");

        $total = $heat['cost_value'] + $water['cost_value'] + $electricity['cost_value'];

        $total_str = number_format($total, 0, ",", " ") . " руб. " . round(100 * fmod($total, 1)) . " коп.";

        return [
            'electricity' => $electricity,
            'water'       => $water,
            'heat'        => $heat,
            'total'       => $total,
            'total_str'   => $total_str
        ];
    }
}
