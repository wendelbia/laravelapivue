let mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
//posso mudar essa estrutura, por exemplo criar mais um arquivo e colocalo em 'public/js/app.js'
mix.js('resources/assets/js/app.js', 'public/js')
//temos os arquivos css atribuidos a esse único arquivo, atribuído a ele
   .sass('resources/assets/sass/app.scss', 'public/css');


   //deletei na pasta public as pastas css e js e para q rode esses aquivos do laravel mis rodo o comando:npm run dev 


//atualizo automáticamente o browser usando o sync que compila o código
mix.browserSync('http://cursolaravelapi.test/');
//rodo o npm run watch que compila automaticamente a cada mudança eo browserSync atualiza o browser, se eu crio um novo component o meu sync não vai pegar ainda mas se relacioná-lo ao app.js ele compilará para sair do modo sync -> ctrl+c (S)sim