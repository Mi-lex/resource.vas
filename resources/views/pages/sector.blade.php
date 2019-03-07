@extends('layouts.app')

@section('content')
    <!-- Main content -->
    <section class="content">
        <div class="row report">
            <div class="col-xs-12">
                <div class="box box-danger collapsed-box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Формирование отчётов</h3>

                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body" style="display: none">
                        <form class="form-horizontal" action="report.php" method="post">
                            <div class="form-group">
                                <label for="reportYear" class="col-sm-2 control-label">Год</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="report[year]" id="reportYear">
                                        <option value="2018">2018</option>
                                        <option value="2017">2017</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="reportMonth" class="col-sm-2 control-label">Месяц</label>
                                <div class="col-sm-10">
                                    <select class="form-control" name="report[month]" id="reportMonth">
                                        <option value="01">Январь</option>
                                        <option value="02">Февраль</option>
                                        <option value="03">Март</option>
                                        <option value="04">Апрель</option>
                                        <option value="05">Май</option>
                                        <option value="06" selected>Июнь</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-sm-offset-2 col-sm-10">
                                    <div class="checkbox">
                                        <button type="submit" class="btn btn-primary">Сформировать отчёт</button>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="report[division]" value="Военная академия связи">
                            <input type="hidden" name="report[city]" value="военный городок №123">
                        </form>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>

        <div class="row" id="city">
            @foreach ($sector->buildings as $building)
                <div class="col-md-6 col-lg-4 buildingColumn">
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <a class="buildingUrl" href="{{ url('/buildings/'.$building->id) }}">
                            <div class="panel-heading buildingName">
                                {{ $building->name }}
                            </div>
                            <div class="panel-photo buildingPicture"
                                style="background-image: url('{{ url('img/buildings/'.$building->id.'.jpg') }}');">
                                <!-- Тут картинка -->
                            </div>
                        </a>
                        <div class="panel-body">
                            <p class="buildingDescription">
                                {{ $building->description }}
                            </p>
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
                            </dl>
                        </div>
                        <!-- List group -->
                        <ul class="list-group">
                            <li class="list-group-item list-group-item-success">
                                <i class="icon fa fa-tachometer"></i> 
                                    Приборов учёта: 
                                    <span class="buildingMetersCount">
                                        {{ $building->meters()->count() }}
                                    </span>
                            </li>
                            <li class="list-group-item list-group-item-info">
                                <i class="icon fa fa-tint"></i> Расход воды: 
                                    <span class="buildingWaterConsumption">
                                        {{ $building->consumption('water') }}
                                    </span> м<sup>3</sup>
                            </li>
                            <li class="list-group-item list-group-item-danger">
                                <i class="icon fa fa-fire"></i> Расход тепла:
                                <span class="buildingHeatConsumption">
                                    - 
                                </span> ГКал
                            </li>
                            <li class="list-group-item list-group-item-warning">
                                <i class="icon fa fa-flash"></i> Расход энергии: 
                                <span class="buildingEnergyConsumption">
                                    {{ $building->consumption('electricity') }}
                                </span>
                                кВт-ч
                            </li>
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
    <!-- /.content -->
@endsection