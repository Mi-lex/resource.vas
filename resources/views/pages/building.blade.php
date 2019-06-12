@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="box box-solid buildingInfo">
            <div class="box-header with-border">
                <i class="fa fa-info-circle"></i>
                <h3 class="box-title">
                    {{ $building->name }}
                </h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                <div class="row">
                    <div class="col-md-9">
                        <dl class="dl-horizontal">
                            <dt>Ввод в эксплуатацию</dt>
                            <dd>
                                <span class="buildingConstruction">
                                    {{ $building->created_at }}
                                </span>
                            </dd>

                            <dt>Реставрация</dt>
                            <dd>
                                <span class="buildingRepair">
                                    {{ 
                                        $building->updated_at ? 
                                            $building->updated_at :
                                            'Не реставрировалось' 
                                    }}
                                </span>
                            </dd>

                            <dt>Общая площадь</dt>
                            <dd>
                                <span class="buildingSpace">
                                    {{ $building->area ?? "Данные отсутствуют" }}
                                </span>
                            </dd>

                            <dt>Этажность</dt>
                            <dd>
                                <span class="buildingSpace">
                                    {{ $building->floors ?? "Данные отсутствуют" }}
                                </span>
                            </dd>

                            <dt>Приборов учёта</dt>
                            <dd>
                                {{ $building->meters()->active()->count() }}шт
                            </dd>

                            <dt>Максимальная выделенная мощность</dt>
                            <dd>
                                {{ $building->max_emit_power ?? "Данные отсутствуют" }}
                            </dd>

                            <dt>Имеющаяся резервная мощность</dt>
                            <dd>
                                {{ $building->max_reserve_power ?? "Данные отсутствуют" }}
                            </dd>
                        </dl>
                    </div>
                    <div class="col-md-3 image">
                        <img src="{{ asset('/img/buildings/'.$building->id.'.jpg') }}" alt="">
                    </div>
                </div>
            </div>
            <!-- /.box-body -->
        </div>
    </section>
    
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <!-- Custom Tabs -->
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" class="bg-yellow color-palette"><i
                                    class="fa fa-flash"></i> Приборы учёта электроэнергии</a></li>
                        <li><a href="#tab_2" data-toggle="tab" class="bg-red color-palette"><i class="fa fa-fire"></i> Приборы
                                учёта тепловой энергии</a></li>
                        <li><a href="#tab_3" data-toggle="tab" class="bg-aqua color-palette"><i class="fa fa-tint"></i> Холодное
                                водоснабжение</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active " id="tab_1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-body">
                                        @if ($building->special_meters('electricity')->active()->exists())
                                            @foreach ($building->special_meters('electricity')->active()->get() as $electricity_meter)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="box box-warning box-solid">
                                                        <div class="box-header with-border">
                                                            <a href="{{ url('/meters/'.$electricity_meter->id) }}">
                                                                {{ $electricity_meter->name }}
                                                            </a>
                                                        </div>
                                                        <div class="panel-body">
                                                            <p>
                                                                {{ $electricity_meter->description }}
                                                            </p>
                                                        </div>
                                                        <ul class="list-group">
                                                            <li class="list-group-item">Расход за месяц:
                                                                {{ $electricity_meter->diff_consumption(30) }}
                                                            <li class="list-group-item">Показания (день):
                                                                {{ $electricity_meter->last_consumption()->t1DirectActive }}
                                                            <li class="list-group-item">Показания (ночь):
                                                                {{ $electricity_meter->last_consumption()->t2DirectActive }}
                                                            <li class="list-group-item">Модель:
                                                                {{ $electricity_meter->model }}
                                                            </li>
                                                        </ul>
                                                        <div class="panel-footer">Сведения получены
                                                            {{ $electricity_meter->last_consumption()->created_at->format('h:m d-m-Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>В выбранном здании нет подключённых счётчиков данного типа ресурсов</p>
                                        @endif
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                        <!-- /.tab-pane -->
                        <div class="tab-pane" id="tab_2">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-body">
                                        @if ($building->special_meters('heat')->active()->exists())
                                            @foreach ($building->special_meters('heat')->active()->get() as $heat_meter)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="box box-danger box-solid">
                                                        <div class="box-header with-border">
                                                            <a href="{{ url('/meters/'.$heat_meter->id) }}">
                                                                {{ $heat_meter->name }}
                                                            </a>
                                                        </div>
                                                        <div class="panel-body">
                                                            <p>
                                                                {{ $heat_meter->description }}
                                                            </p>
                                                        </div>
                                                        <ul class="list-group">
                                                            <li class="list-group-item">Расход за месяц: - ГКал</li>
                                                            <li class="list-group-item">Показания: - ГКал</li>
                                                            <li class="list-group-item">Модель: -</li>
                                                        </ul>
                                                        <div class="panel-footer">Сведения получены
                                                            {{ $heat_meter->last_consumption()->created_at->format('h:m d-m-Y') }}
                                                            -
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>В выбранном здании нет подключённых счётчиков данного типа ресурсов</p>
                                        @endif
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-body">
                                        @if ($building->special_meters('water')->active()->exists())
                                            @foreach ($building->special_meters('water')->active()->get() as $water_meter)
                                                <div class="col-md-6 col-lg-4">
                                                    <div class="box box-info box-solid">
                                                        <div class="box-header with-border">
                                                            <a href="{{ url('/meters/'.$water_meter->id) }}">
                                                                {{ $water_meter->name }}
                                                            </a>
                                                        </div>
                                                        <div class="panel-body">
                                                            <p>
                                                                {{ $water_meter->description }}
                                                            </p>
                                                        </div>
                                                        <ul class="list-group">
                                                            <li class="list-group-item">Расход за месяц:
                                                                {{ $water_meter->diff_consumption(30) }}
                                                            <li class="list-group-item">Показания:
                                                                {{ $water_meter->last_consumption()['consumption_amount'] }}
                                                            <li class="list-group-item">Модель:
                                                                {{ $water_meter->model }}
                                                            </li>
                                                        </ul>
                                                        <div class="panel-footer">Сведения получены
                                                            {{ $water_meter->last_consumption()->created_at->format('h:m d-m-Y') }}
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <p>В выбранном здании нет подключённых счётчиков данного типа ресурсов</p>
                                        @endif
                                    </div>
                                    <!-- /.box-body -->
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content-->
                </div>
                <!-- nav-tabs-custom -->
            </div>
            <!-- col -->
        </div>
        <!-- /row -->
    </section>
    <!-- /.content -->
@endsection