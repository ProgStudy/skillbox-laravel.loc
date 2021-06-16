<html lang="ru">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="icon" href="/docs/4.1/assets/img/favicons/favicon.ico">

        <title>Skillbox Laravel - @yield('title')</title>

        <!-- Bootstrap core CSS -->
        <link href="https://getbootstrap.com/docs/4.1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="https://fonts.googleapis.com/css?family=Playfair+Display:700,900" rel="stylesheet">
        <link href="https://getbootstrap.com/docs/4.1/examples/blog/blog.css" rel="stylesheet">
    </head>

    <body>
        <div class="container">
            <header class="blog-header py-3">
                <div class="row flex-nowrap justify-content-between align-items-center">
                    <div class="col-4 pt-1"></div>
                    <div class="col-4 text-center">
                    <a class="blog-header-logo text-dark" href="/">Skillbox-Laravel</a>
                    </div>
                    <div class="col-4 d-flex justify-content-end align-items-center">
                    <a class="text-muted" href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mx-3"><circle cx="10.5" cy="10.5" r="7.5"></circle><line x1="21" y1="21" x2="15.8" y2="15.8"></line></svg>
                    </a>
                    <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a>
                    </div>
                </div>
            </header>

            <div class="nav-scroller py-1 mb-2">
                <nav class="nav d-flex justify-content-between">
                    <a class="p-2 text-muted" href="/">Главная</a>
                    <a class="p-2 text-muted" href="/about">О нас</a>
                    <a class="p-2 text-muted" href="/contacts">Контакты</a>
                    <a class="p-2 text-muted" href="/articles/create">Создать статью</a>
                    <a class="p-2 text-muted" href="/admin">Админ. раздел</a>
                </nav>
            </div>
        </div>

        <main role="main" class="container">
            @yield('content')
        </main><!-- /.container -->

        <footer class="blog-footer">
        </footer>

        <!-- Bootstrap core JavaScript
        ================================================== -->
        <!-- Placed at the end of the document so the pages load faster -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/popper.min.js"></script>
        <script src="https://getbootstrap.com/docs/4.1/dist/js/bootstrap.min.js"></script>
        <script src="https://getbootstrap.com/docs/4.1/assets/js/vendor/holder.min.js"></script>
        <script src="{{asset('/vendor/notify/notify.min.js')}}"></script>
        <script src="{{asset('/js/common/ajax.js')}}"></script>
        <script src="{{asset('/js/common/form.js')}}"></script>
        <script>
        Holder.addTheme('thumb', {
            bg: '#55595c',
            fg: '#eceeef',
            text: 'Thumbnail'
        });
        </script>
        @yield('scripts')
    </body>
</html>