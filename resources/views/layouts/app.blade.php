<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->


    <!-- Fonts -->


    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" integrity="sha256-MeSf8Rmg3b5qLFlijnpxk6l+IJkiR91//YGPCrCmogU=" crossorigin="anonymous" />
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    {{--<script src="{{ asset('js/app.js') }}" defer></script>--}}
</head>
<body>
<div id="app">
    <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                {{ config('app.name', 'Laravel') }}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Left Side Of Navbar -->
                <ul class="navbar-nav mr-auto">
                    @if(auth()->check() && auth()->user()->client_access)
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('client')}}">Client</a>
                        </li>
                    @endif
                    @if(auth()->check() && auth()->user()->branch_access)
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('branch')}}">Branch</a>
                        </li>
                    @endif
                    @if(auth()->check() && auth()->user()->employee_access)
                        <li class="nav-item">
                            <a class="nav-link" href="{{url('employee')}}">Employee</a>
                        </li>
                    @endif
                </ul>

                <form class="form-inline" id="combo" action="{{ route('sbbranch') }}">
                    <div class="branch-area">
                        <div class="form-group branch-area">
                            <label for="parent_brance">{{trans('header.branch')}}<span class="red">*</span> </label>

                            <select id="parent_brance_all" class="form-control" name="branch_id" required change_url="changes" url={{ route('sbbranch') }}>

                                <option @if(session()->get('parent_branch') == "all"){{ "selected" }}@endif value="">{{trans('header.all')}}</option>

                                @forelse($branch as $branchs)
                                    <option @if(session()->get('parent_branch') == $branchs->id){{ "selected" }}@endif value="{{$branchs['id']}}">{{ $branchs['branch_name'] }}</option>
                                @empty
                                    <option value="">No branches created yet</option>
                                @endforelse
                            </select>
                        </div>

                        @if(session()->has('sub_branch'))

                            <div class="form-group sub-branch-area">

                                <label for="sbranch">{{trans('header.sub_branch')}}</label>
                                <select id="sbranch" name="subbranch" class="form-control sbranch" url="{{url('getSub_subBranch')}}">

                                    @if(session()->has('sub_branch'))

                                        <option value="">{{trans('header.all')}}</option>

                                        @forelse(session()->get('sub_branch') as $sb_branch_key=>$value)
                                            <option  @if(session()->get('subbranch') == $sb_branch_key) selected @endif value="{{ $sb_branch_key }}">{{ $value }}</option>
                                        @empty
                                        @endforelse

                                    @endif


                                </select>

                            </div>
                        @endif
                        <div class="form-group sub-sub-branch-area">
                            <div id="sbbbracnch">

                                @if(session()->has('gc_branch'))

                                    <select class="form-control" name="sub_sub_branch" id="sub_sub_branch">
                                        <option value="">{{trans('header.all')}}</option>
                                        @forelse(session()->get('gc_branch') as $sb_branch_key=>$value)
                                            <option @if(session()->get('gcbranch') == $sb_branch_key) selected @endif value="{{ $sb_branch_key }}">{{ $value }}</option>
                                        @empty

                                        @endforelse
                                    </select>
                                @endif


                            </div>
                        </div>
                    </div>


                </form>

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                        {{--@if (Route::has('register'))--}}
                        {{--<li class="nav-item">--}}
                        {{--<a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>--}}
                        {{--</li>--}}
                        {{--@endif--}}
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    <main class="py-4">
        @yield('content')
    </main>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function () {
            $.ajax({
                url: "{{url('default_branch')}}",
                type: 'GET',
                data: {
                    defaultbranch: $("#parent_brance_all").val(),

                },
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $(document).on('change', '#parent_brance_all', function(event) {
                $('#combo').submit();
            })
            $(document).on('change', '#sbranch', function(event) {
                $('#combo').submit();
            });
            $(document).on('change', '#sub_sub_branch', function(event) {
                $('#combo').submit();
            });
        })
    </script>
    @yield("script")
</div>
</body>
</html>
