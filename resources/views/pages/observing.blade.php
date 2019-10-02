@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>Мониторинг работоспособности приборов учета</h1>
    </section>
    <section class="obs-controll-panel">
        <form action="" class="obs-sorting" method="get">
            <label class="obs-sorting__item obs-sorting__item--green">
                Активные
                <input type="checkbox"><span></span></label>
            <label class="obs-sorting__item obs-sorting__item--grey">
                Неактивные
                <input type="checkbox"><span></span></label>
            <label class="obs-sorting__item obs-sorting__item--red">
                Ошибка соединения
                <input type="checkbox"><span></span></label>
        </form>
        <button class="obs-start-monitoring-btn">Начать мониторинг</button>
    </section>
@endsection

@section('scripts')
    <script src="{{ asset('js/pages/observing.js') }}"></script>
@endsection