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
    <ul class="obs-building__list">
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--inactive">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--inactive">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--broken">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
        <li class="obs-building__item">
            <header class="obs-building__item-header">
                <h2 class="obs-building__item-title">
                    ГП-1
                </h2>
                <svg width="31" height="31" class="page-header__icon page-header__icon--search">
                    <use xlink:href="img/icons/sprite.svg#building-icon"></use>
                </svg>
            </header>
            <div class="obs-building__item-body">
                <ul class="obs-devices__list">
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #84DBFF;"
                                class="fa fa-tint"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #FEC524;"
                                class="fa fa-flash"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>
                    <li class="obs-devices__item obs-devices__item--active">
                        <span class="obs-devices__item-icon"><i style="color: #DA1108;"
                                class="fa fa-fire"></i></span>
                    </li>

                </ul>
            </div>
        </li>
    </ul>
@endsection