@extends('layouts.app')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            {{ $meter->name }}

            <small>
                <a href="meter/{{ $meter->id }}/monitoring">перейти к мониторингу</a>
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
                                {{ $meter->type->name }}
                            </dd>
                            <dt>Модель</dt>
                            <dd>
                                {{ $meter->model }}
                            </dd>
                            <dt>Серийный номер</dt>
                            <dd>
                                {{ $meter->serial_number }}
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
            <div class="col-sm-6 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-red">V</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Общее потребление</span>
                        <span class="info-box-number" id="totalConsumption">-</span>
                        <span class="info-box-comment"> м<sup>3</sup></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
    
            <div class="col-sm-6 consumption-hightlights">
                <div class="info-box">
                    <span class="info-box-icon bg-light-blue">S</span>
                    <div class="info-box-content">
                        <span class="info-box-text">Текущий расход</span>
                        <span class="info-box-number" id="currentConsumption">-</span>
                        <span class="info-box-comment"> м<sup>3</sup>/час</span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
            </div> <!-- col -->
        </div>

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
                    <tbody>

                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>

        <div class="box box-default collapsed-box">
            <div class="box-header with-border">
                <i class="fa fa-history"></i>
                <h3 class="box-title">История показаний</h3>

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
                            <th>Дата и время</th>
                            <th>Потреблённый объём</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
@endsection

@section('scripts')
  <script src="{{ asset('js/pages/water.js') }}"></script>
@endsection