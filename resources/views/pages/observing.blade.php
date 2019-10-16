@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Мониторинг работоспособности приборов учета</h1>
    </section>
    <section class="obs-controll-panel">
        <form action="" class="obs-sorting" method="get">
            <label class="obs-sorting__item obs-sorting__item--green">
                Активные
                <input type="checkbox" data-filtertype="active" checked><span></span></label>
            <label class="obs-sorting__item obs-sorting__item--grey">
                Неактивные
                <input type="checkbox" checked data-filtertype="inactive"><span></span></label>
            <label class="obs-sorting__item obs-sorting__item--red">
                Ошибка соединения
                <input type="checkbox" checked data-filtertype="broken"><span></span></label>
        </form>
        <button class="obs-start-monitoring-btn">Начать мониторинг</button>
    </section>
    <div class="obs-alert-popup__overlay" style="display: none;">
        <div class="obs-alert-popup__container">
            <section class="obs-alert-popup">
                <div class="obs-alert-popup__upper-part">
                    <button class="obs-alert-popup__close-btn">
                        ✕
                    </button>
                </div>
                
                <div class="obs-alert-popup__body">
                    <strong class="obs-alert-popup__message">Внимание!</strong>
                    <p class="obs-alert-popup__text">
                        Обнаружено подозрительное потребление в приборе учета 
                        <a href="/meters/3">Цод основной ввод</a>, 
                        расположенном в <a href="/buildings/4">ГП-4</a>.
                    </p>
                </div>
            </section>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/observing.js') }}"></script>
@endsection