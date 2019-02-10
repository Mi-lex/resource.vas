<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Система учёта ресурсов</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    {{-- Bootstrap css. Font-awesome + main.css --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    {{-- Fancybox css --}}
    <link rel="stylesheet" href="/css/jquery.fancybox.min.css">
    {{-- Additional libraries or css code --}}
    @yield('libraries')
</head>
<body class="hold-transition sidebar-collapse skin-blue sidebar-mini">
    <div class="wrapper">
        @include('layouts.aside')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">

            {{-- Main content --}}
            @yield('content')

        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Версия</b> 0.0.1
            </div>
            <strong>2018 Военная Академия Связи</strong>
            <div class="callout callout-info" style="display: none;" id="hidden-content">
                <div class="center">
                    <p>Старший оператор научной роты: <b>ефрейтор Шадрин Д.М.</b></p>
                    <p>Оператор научной роты: <b>рядовой Иващенко Н.А.</b></p>
                    <p>Оператор научной роты: <b>рядовой Исаев И.А.</b></p>
                    <p>Оператор научной роты: <b>рядовой Янак А.Ф.</b></p>
                </div>
            </div>
                <a data-fancybox data-src="#hidden-content" href="javascript:;">
                    Разработчики
                </a>;
        </footer>
    </div>
    <!-- ./wrapper -->

    {{-- jQuery --}}
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    {{-- Chart js --}}
    <script src="/js/Chart.min.js"></script>
    {{-- Fancybox. Bootstrap js. AdminLTI --}}
    <script src="{{ asset('js/app.js') }}"></script>
    {{-- Additional scripts or js libraries --}}
    @yield('scripts')
</body>
</html>