<!doctype html>
<!-- colocando o seletor id="app" já posso trabalhar com vue.js -->
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>
        

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!--insiro o caminho do css
            posso tirar o background e formatar outras coisa indo em resources/assets/sass/variable.scss em body-bg:...
            vamos em template melhorar mais indo em AdminComponent e colocando router-view em um conteiner-->

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    </head>
    <body ><!--vamos incluir antes do </body> o a meta-tag-->
        <div id="app">
            <!--component para carregamento de página de forma global-->
            <preloader-component></preloader-component>
            <!--A7
            <test-component></test-component>-->
            <!--<app-component></app-component> uso agora:
            Mudo para <router-view> para não dê duplicado a listagem
                <admin-component></admin-component>-->
                <router-view></router-view>
            
        </div>
        <!--podemos incluir o helper src="{url, asset ou o mix que mostro q estou utilizando o laravelmix}-->
        <script src="{{ mix('/js/app.js') }}"></script><!--e atualizo -->
    </body>
</html>
