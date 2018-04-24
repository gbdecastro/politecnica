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

mix.js('resources/assets/js/app.js', 'public/js/app.js')
   .js('resources/assets/js/grupos.js', 'public/js/grupos.js')
   .js('resources/assets/js/projetos.js', 'public/js/projetos.js')
   .js('resources/assets/js/funcionarios.js', 'public/js/funcionarios.js')
   .js('resources/assets/js/projetos_jquery.js', 'public/js/projetos_jquery.js')
   .js('resources/assets/js/perfil.js', 'public/js/perfil.js')
   .js('resources/assets/js/contabil_grupos.js', 'public/js/contabil_grupos.js')
   .js('resources/assets/js/contabil_projetos.js', 'public/js/contabil_projetos.js')
   .scripts(['resources/assets/js/moment.js'], 'public/js/moment.js')
   .scripts(['resources/assets/js/fullcalendar.js'], 'public/js/fullcalendar.js')  
   .scripts(['resources/assets/js/pt_br.js'], 'public/js/fullcalendar_lang.js')  
   .scripts(['resources/assets/js/calendario_horas.js'],'public/js/calendario_horas.js') 
   .scripts(['resources/assets/js/select2.js'],'public/js/select2.js') 
   .scripts(['resources/assets/js/toastr.js'],'public/js/toastr.js')
   .scripts(['resources/assets/js/datatables.js'],'public/js/datatables.js') 
   .scripts(['resources/assets/js/datatables_bootstrap.js'],'public/js/datatables_bootstrap.js') 
   .scripts(['resources/assets/js/chart.min.js'],'public/js/chart.min.js') 
   .styles(['resources/assets/css/fullcalendar.css'], 'public/css/fullcalendar.css')
   .styles(['resources/assets/css/select2.css'], 'public/css/select2.css')
   .styles(['resources/assets/css/toastr.css'], 'public/css/toastr.css')
   .styles(['resources/assets/css/datatables.css'],'public/css/datatables.css');
