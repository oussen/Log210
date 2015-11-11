<html>
<head>
    <meta charset="utf-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}"/>

    <title>Biblio - @yield('title')</title>
    <!-- SCRIPTS -->
    {!! Html::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') !!}
    @yield('scripts')
    {!! Html::script('//netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js') !!}
    {!! Html::script('js/books.js') !!}
    {!! Html::script('js/typeahead.js') !!}
    @yield('css')
    {!! Html::style('//netdna.bootstrapcdn.com/bootstrap/3.1.1/css/bootstrap.min.css') !!}
    {!! Html::style('css/master.css') !!}
</head>

<body>
    @section('titlebar')
        <nav class="navbar navbar-default">
            <div class="container-fluid" id="topMenu">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="{!! URL::route('home') !!}"><span class="glyphicon glyphicon glyphicon-home"></span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        @if(Auth::check())
                            @if(Auth::user()->idCOOP != 0)
                                <li id="menuBooks" class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Livres <span class="caret"></span></a>
                                    <ul class="dropdown-menu">
                                        <li id="menuBooksAdd"><a href="{!! URL::route('ajoutDeLivres') !!}">Ajouter un livre</a></li>
                                        @if(Auth::user()->isManager == 1)
                                            <li><a href="{!! URL::route('receptionLivres') !!}">Reception de livre</a></li>
                                        @endif
                                    </ul>
                                </li>
                            @endif
                        @endif

                        @if(Auth::check())
                            @if(Auth::user()->idCOOP == 0)
                                <li><a href="{!! URL::route('coopManagement') !!}">Coop</a></li>
                            @endif
                            @if(Auth::user()->idCOOP != 0)
                                <li><a href="{!! URL::route('bookReservation') !!}">Réservation d'un livre</a></li>
                            @endif
                        @endif
                    </ul>
                    @if(Auth::check())
                        <p class="navbar-text navbar-right">Bienvenue {{$user}}  (<a href="{{ URL::route('auth/logout') }}">Log out</a>)</p>
                    @else
                        <p class="navbar-text navbar-right">Pas de login</p>
                    @endif
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    @show

    <div class="container well">
        @yield('content')
    </div>
</body>
</html>