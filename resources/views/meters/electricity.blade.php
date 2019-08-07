@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <input type="hidden" class="meter_id" name="meter_id" value="{{ $meter->id }}">
            {{ $meter->name }}
            <small>
                <a href="{{ url("meters/$meter->id/monitoring") }}">перейти к мониторингу</a>
            </small>
        </h1>
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12 col-md-4">
                <div class="box box-solid">
                    <div class="box-header with-border">
                        <i class="fa fa-info-circle"></i>
                        <h3 class="box-title">Сведения о приборе</h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <dl class="dl-horizontal">
                            <dt>Тип прибора</dt>
                            <dd>
                                {{ $meter->full_device_name() }}
                            </dd>
                            <dt>Модель</dt>
                            <dd>
                                {{ $meter->model }}
                            </dd>
                            <dt>Серийный номер</dt>
                            <dd>
                                {{ $meter->serial_number }}
                            </dd>
                            <dt>Паспорт</dt>
                            <dd>
                                <a data-fancybox="gallery"
                                    href="{{ asset('img/passports/'.$meter->serial_number.'.jpg') }}">
                                    Открыть
                                </a>
                            </dd>
                        </dl>
                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <div class="col-md-2 hidden-xs hidden-sm">
                <div class="box box-solid">
                    <div class="box-body text-center">
                        <img src="{{ asset('img/mercury230.png') }}" alt="" style="max-height: 140px;">
                    </div>
                </div>
            </div>
            <div class="col-xs-12 col-md-6">
                <div id="statusPanel" class="alert alert-success disabled">
                    <h4 id="statusHeading"><i class="icon fa fa-info-circle"></i> Сведения об актуальности</h4>
                    <p id="statusText">Последние показания поступили <span id="timeFromSuccess"></span></p>
                    <button type="button" id="getFreshData" class="btn btn-block btn-default"><i class="fa fa-refresh"></i>
                        <span>Запросить новые показания</span></button>
                    <p><label for="autoRefresh"><input type="checkbox" id="autoRefresh"> Обновлять показания в реальном
                            времени</label></p>
                </div> <!-- alert -->
            </div> <!-- col -->
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue">А1</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Активная (тариф 1)</span>

                        <span class="info-box-number" id="a1">
                        </span>

                        <span class="info-box-comment"> кВт-ч</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
            <div class="col-sm-6 col-lg-3 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-teal">R1</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Реактивная (тариф 1)</span>

                        <span class="info-box-number" id="r1">
                        </span>

                        <span class="info-box-comment"> кВАр-ч</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
            <div class="col-sm-6 col-lg-3 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue">A2</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Активная (тариф 2)</span>

                        <span class="info-box-number" id="a2">
                        </span>

                        <span class="info-box-comment"> кВт-ч</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
            <div class="col-sm-6 col-lg-3 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-teal">R2</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Реактивная (тариф 2)</span>

                        <span class="info-box-number" id="r2">
                        </span>
                        <span class="info-box-comment"> кВАр-ч</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
        </div>

        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <i class="fa fa-flash"></i>
                <h3 class="box-title">Подробные показания по всем тарифам</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
        </div> 

        {{-- График --}}
        <div class="box">
            <div class="box-header">
                <i class="fa fa-line-chart"></i>
                <h3 class="box-title">Диаграмма расхода за месяц</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="chart">
                    <canvas id="barChart" style="height: 255px; width: 419px;" width="838" height="205"></canvas>
                </div>
            </div>
            <!-- /.box-body -->
        </div>

        {{-- Расход за месяц и История показаний за месяц --}}
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <i class="fa fa-hourglass-start"></i>
                <h3 class="box-title">Расход за месяц</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th>Дата</th>
                        <th>Расход за период</th>
                        <th>Показания начало</th>
                        <th>Показания конец</th>
                    </tr>
                    </thead>
                    <tbody class='month-consumption-table'>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

        
        {{--
        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <i class="fa fa-history"></i>
                <h3 class="box-title">История показаний за месяц</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                    </button>
                </div>
                <!-- /.box-tools -->
            </div>
            <!-- /.box-header -->
        </div> 
        --}}

    </section>
    <!-- /.content -->
@endsection


@section('scripts')
  <script src="{{ asset('js/pages/electricity.js') }}"></script>
@endsection