<html>
<head>
    <title>Biblio - @yield('title')</title>
    <!-- SCRIPTS -->
    @yield('scripts')
    {!! Html::script('//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js') !!}
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
                    <a class="navbar-brand" href="#"><span class="glyphicon glyphicon glyphicon-home"></span></a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li id="menuHome"><a href="home">Acceuil <span class="sr-only">(current)</span></a></li>
                        <li id="menuBooks" class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Livres <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                                <li id="menuBooksAdd"><a href="ajoutDeLivres">Ajouter un livre</a></li>
                                <li><a href="#">Chercher un livre</a></li>
                                <li><a href="#">Liste des livres</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
    @show

    <div class="container well">
        @yield('content')
    </div>
</body>
</html>