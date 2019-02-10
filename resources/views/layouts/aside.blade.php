<header class="main-header">
<!-- Logo -->
<a href="home" class="logo">
    <!-- mini logo for sidebar mini 50x50 pixels -->
    <span class="logo-mini"><img src="./img/icons/favicon-white.svg" style="height: 30px;" alt=""></span>
    <!-- logo for regular state and mobile devices -->
    <span class="logo-lg"><img src="./img/icons/favicon-white.svg" style="height: 30px;" alt=""> Ресурс</span>
</a>
<!-- Header Navbar: style can be found in header.less -->
<nav class="navbar navbar-static-top">
    <!-- Sidebar toggle button-->
    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Переключатель навигации</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
    </a>

    <a href="javascript: history.back()" style="float: left;  padding: 15px 15px; color: white">
        <span class="fa fa-backward"></span>
    </a>

    <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
            <li>
                <a href="/" title="Ресурс-РФ">
                    <i class="fa fa-star"></i>
                </a>
            </li>
            <li>
                <a href="/district" title="Ресурс-Округ">
                    <i class="fa fa-bank"></i>
                </a>
            </li>
            <li>
                <a href="/academy" title="Ресурс-ВЧ">
                    <i class="fa fa-flag"></i>
                </a>
            </li>
            <li>
                <a href="/city" title="Ресурс-ВГ">
                    <i class="fa fa-sitemap"></i>
                </a>
            </li>
            <li>
                <a href="/building/1" title="Ресурс-ГП">
                    <i class="fa fa-industry"></i>
                </a>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="Ресурс-Прибор">
                    <i class="icon fa fa-tachometer"></i>
                </a>
                <ul class="dropdown-menu">
                    <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                        <li>
                            <a href="/heat/1">
                                <i class="fa fa-fire text-blue"></i>Счётчик тепла
                            </a>
                        </li>
                        <li>
                            <a href="/electricity/2">
                                <i class="fa fa-flash text-blue"></i>Счётчик электроэнергии
                            </a>
                        </li>
                        <li>
                            <a href="/mercury/2">
                                <i class="fa fa-flash text-blue"></i>Счётчик электроэнергии (мониторинг)
                            </a>
                        </li>
                        <li>
                        <a href="/water/1">
                            <i class="fa fa-flash text-blue"></i>Счётчик ХВС
                        </a>
                        </li>
                    </ul>
                    </li>
                </ul>
            </li>

            <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="./img/avatar5.png" class="user-image" alt="User Image">
                    <span class="hidden-xs">Пользователь</span>
                </a>
                <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                    <img src="./img/avatar5.png" class="img-circle" alt="User Image">

                    <p>
                        Пользователь Иван Иванович
                        <small>Заместитель начальника академии по МТО</small>
                    </p>
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                        <div class="pull-left">
                            <a href="training" class="btn btn-default btn-flat">Профиль</a>
                        </div>
                        <div class="pull-right">
                            <a href="training" class="btn btn-default btn-flat">Выйти</a>
                        </div>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>
</header>

<!-- =============================================== -->

<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
        <li class="header">Главное меню</li>
        <li>
            <a href="/">
                <i class="fa fa-files-o"></i> <span>Общая сводка</span>
            </a>
        </li>
        <li class="treeview">
            <a href="#">
                <i class="fa fa-dashboard"></i>
                <span>Приборы учёта</span>
                <span class="pull-right-container">
                    <span class="label label-primary pull-right">186</span>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="electricity/2"><i class="fa fa-flash"></i> Электроэнергия</a></li>
                <li><a href="water/1"><i class="fa fa-tint"></i> Холодная вода</a></li>
                <li><a href="heat/1"><i class="fa fa-fire"></i> Тепловая энергия</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="construction">
                <i class="fa fa-edit"></i> <span>Отчёты</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li><a href="/electricity/2"><i class="fa fa-flash"></i> Электроэнергия</a></li>
                <li><a href="/water/1"><i class="fa fa-tint"></i> Холодная вода</a></li>
                <li><a href="/heat/1"><i class="fa fa-fire"></i> Тепловая энергия</a></li>
            </ul>
        </li>
        <li class="treeview">
            <a href="academy">
                <i class="fa  fa-code-fork"></i> <span>Подразделения</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>

            <ul class="treeview-menu">
                <li class="treeview">
                    <a href="city"><i class="fa fa-bank"></i> в/г №123
                        <span class="pull-right-container">
                            <i class="fa fa-angle-left pull-right"></i>
                        </span>
                    </a>
                    <ul class="treeview-menu">
                        <li class="treeview">
                            <a href="#"><i class="fa fa-building-o"></i> ГП-1
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="building/1"><i class="fa fa-circle-o"></i> Сводка по зданию</a></li>
                                <li><a href="building/1"><i class="fa fa-circle-o"></i> Отчёт по зданию</a></li>
                            </ul>
                        </li>
                        <li class="treeview">
                            <a href="#"><i class="fa fa-building-o"></i> ГП-2
                                <span class="pull-right-container">
                                    <i class="fa fa-angle-left pull-right"></i>
                                </span>
                            </a>
                            <ul class="treeview-menu">
                                <li><a href="building/1"><i class="fa fa-circle-o"></i> Сводка по зданию</a></li>
                                <li><a href="building/1"><i class="fa fa-circle-o"></i> Отчёт по зданию</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </li>
        <li>
            <a href="construction">
                <i class="fa fa-book"></i> 
                <span>О системе</span>
            </a>
        </li>
        <li class="treeview">
            <a href="construction">
                <i class="fa  fa-gear"></i> <span>Служебные модули</span>
                <span class="pull-right-container">
                    <i class="fa fa-angle-left pull-right"></i>
                </span>
            </a>
            <ul class="treeview-menu">
                <li>
                    <a href="../../backend/logika-spt-943">
                    <i class="fa fa-fire text-blue"></i>Логика СПТ941
                    </a>
                </li>
                <li>
                    <a href="../../backend/logika-spt-941">
                    <i class="fa fa-fire text-blue"></i>Логика СПТ943
                    </a>
                </li>
                <li>
                    <a href="../../backend/mercury-230">
                    <i class="fa fa-flash text-blue"></i>Меркурий 230
                    </a>
                </li>
                <li>
                    <a href="../../backend/mercury-230-monitoring">
                    <i class="fa fa-flash text-blue"></i>Меркурий 230 мониторинг
                    </a>
                </li>
                <li>
                    <a href="../../backend/oven-si8">
                    <i class="fa fa-tint text-blue"></i>Овен СИ8
                    </a>
                </li>
                <li>
                    <a href="../../backend/pulsar-2m">
                    <i class="fa fa-tint text-blue"></i>Пульсар 2М
                    </a>
                </li>
            </ul>
        </li>
    </ul>
</section>
<!-- /.sidebar -->
</aside>