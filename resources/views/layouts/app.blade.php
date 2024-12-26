<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }} zxx" class="js">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/images/logo.png">
    <link rel="stylesheet" href="/vendor/assets/css/dashlite.css?ver=3.0.3">
    <link id="skin-default" rel="stylesheet" href="/vendor/assets/css/theme.css?ver=3.0.3">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .form-control,
        .dual-listbox .dual-listbox__search,
        div.dataTables_wrapper div.dataTables_filter input {
            display: block;
            width: 100%;
            padding: 0.4375rem 1rem;
            font-size: 0.8125rem;
            font-weight: 400;
            line-height: 1.25rem;
            color: #3c4d62;
            background-color: #fff;
            background-clip: padding-box;
            border: 1px solid #dbdfea;
            appearance: none;
            border-radius: 4px;
            transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
        }

        .is-dark .nk-menu-link:hover,
        .is-dark .active>.nk-menu-link {
            background: #E85347;
            color: #eee;
        }

        .nk-menu-link:hover .nk-menu-icon,
        .nk-menu-item.active>.nk-menu-link .nk-menu-icon,
        .nk-menu-item.current-menu>.nk-menu-link .nk-menu-icon {
            color: #eee;
        }

        .is-dark .nk-menu-link {
            color: #b6b6b6;
        }

        .nk-menu-icon {
            color: #b6b6b6;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: #E85347;
            border-color: #f15b50;
        }
    </style>
    <script src="/vendor/assets/js/bundle.js?ver=3.0.3"></script>
    <script src="/vendor/assets/js/scripts.js?ver=3.0.3"></script>
    <script src="/vendor/assets/js/libs/datatable-btns.js?ver=3.0.3"></script>

    <script src="/vendor/assets/js/example-sweetalert.js?ver=3.0.3"></script>
    @livewireStyles
</head>

<body class="nk-body bg-lighter npc-general has-sidebar font-sans antialiased ">
    <div class="nk-app-root">
        <div class="nk-main ">
            <x-navbar-sidemenu />
            <div class="nk-wrap ">
                <x-navbar-topmenu />
                <div class="nk-content ">
                    <div class="container-fluid">
                        <div class="nk-content-inner">
                            <div class="nk-content-body">

                                <!-- Page Header -->
                                @if (isset($header))
                                    <div class="nk-block-head nk-block-head-sm">

                                        @if ($back)
                                            {{ $back }}
                                        @endif

                                        <div class="nk-block-between">
                                            <div class="nk-block-head-content">
                                                <h3 class="nk-block-title page-title mb-1"> {{ $header }}</h3>
                                                @if (isset($subHeader))
                                                    <p>{{ $subHeader }}</p>
                                                @endif
                                            </div>

                                            @if ($btn)
                                                {{ $btn }}
                                            @endif

                                        </div>
                                    </div>
                                @endif

                                <!-- Page Content -->
                                <main>
                                    {{ $slot }}
                                </main>

                            </div>
                        </div>

                        @stack('modals')
                        @livewireScripts
                    </div>
                </div>
                <x-footer />
            </div>
        </div>
    </div>

    <script>
        function go_to(uri) {
            window.location.href = uri;
        }
    </script>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Saved Successfully',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK'
            });
        </script>
    @endif

</body>

</html>
