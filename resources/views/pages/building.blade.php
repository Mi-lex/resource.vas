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
                                {{ $building->meters()->count() }}шт
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
            <div class="col-xs-12">
                <div class="box box-warning box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-flash"></i> Приборы учёта электроэнергии</h3>
    
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        @if ($building->electricity_meters()->first())
                            @foreach ($building->electricity_meters as $electricity_meter)
                                <div class="col-md-6 col-lg-4">
                                    <div class="panel panel-success">
                                        <div class="panel-heading">
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
                                                <?=ceil($currentMeter['consumptionByMonth']);?> кВт-ч</li>
                                            <li class="list-group-item">Показания (день):
                                                <?=ceil($currentMeter['t1DirectActive']);?> кВт-ч</li>
                                            <li class="list-group-item">Показания (ночь):
                                                <?=ceil($currentMeter['t2DirectActive']);?> кВт-ч</li>
                                            <li class="list-group-item">Модель:
                                                <?=$currentMeter['model'];?>
                                            </li>
                                        </ul>
                                        <div class="panel-footer">Сведения получены
                                            <? echo showDate(strtotime($currentMeter['datetime']));?> назад</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{ "В выбранном здании нет подключённых счётчиков данного типа ресурсов"; }}
                        @endif
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-danger box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-fire"></i> Приборы учёта тепловой энергии</h3>
    
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php
                            if (count($heatMeters) == 0) {
                                echo "В выбранном здании нет подключённых счётчиков данного типа ресурсов";
                            } else
                                foreach ($heatMeters as $currentMeter) {
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading"><a href="test2.php">
                                        <?=$currentMeter['name'];?></a></div>
                                <div class="panel-body">
                                    <p>
                                        <?=$currentMeter['description'];?>
                                    </p>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">Расход за месяц: - ГКал</li>
                                    <li class="list-group-item">Показания: - ГКал</li>
                                    <li class="list-group-item">Модель: -</li>
                                </ul>
                                <div class="panel-footer">Состояние: неизвестно</div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
            <div class="col-xs-12">
                <div class="box box-info box-solid">
                    <div class="box-header with-border">
                        <h3 class="box-title"><i class="fa fa-tint"></i> Холодное водоснабжение</h3>
    
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                            </button>
                        </div>
                        <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <?php
                            if (count($waterMeters) == 0){
                                echo "В выбранном здании нет подключённых счётчиков данного типа ресурсов";
                            } else
                                foreach ($waterMeters as $currentMeter) {
                        ?>
                        <div class="col-md-6 col-lg-4">
                            <div class="panel panel-success">
                                <!-- Default panel contents -->
                                <div class="panel-heading"><a href="water.php?deviceId=<?=$currentMeter['deviceId'];?>">
                                        <?=$currentMeter['name'];?></a></div>
                                <div class="panel-body">
                                    <p>
                                        <?=$currentMeter['description'];?>
                                    </p>
                                </div>
                                <ul class="list-group">
                                    <li class="list-group-item">Расход за месяц:
                                        <?=ceil($currentMeter['consumptionByMonth']);?> м<sup>3</sup></li>
                                    <li class="list-group-item">Показания:
                                        <?=ceil($currentMeter['consumption']);?> м<sup>3</sup></li>
                                    <li class="list-group-item">Модель:
                                        <?=$currentMeter['model'];?>
                                    </li>
                                </ul>
                                <div class="panel-footer">Сведения получены
                                    <? echo showDate(strtotime($currentMeter['datetime']));?> назад</div>
                            </div>
                        </div>
                        <?php }?>
                    </div>
                    <!-- /.box-body -->
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
@endsection