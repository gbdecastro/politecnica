<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */

    'title' => 'Politécnica Engenharia LTDA',

    'title_prefix' => '',

    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */

    'logo' => 'Politécnica Engenharia LTDA',

    'logo_mini' => '<b>P</b>Eng',

    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */

    'skin' => 'green',

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */

    'layout' => null,

    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */

    'collapse_sidebar' => false,

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */

    'dashboard_url' => 'painel/calendario',

    'logout_url' => 'logout',

    'logout_method' => 'post',

    'login_url' => 'login',

    'register_url' => 'register',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */

    'menu' => [
        'CALENDÁRIO',
        [
            'text'      =>  'Calendário',
            'url'       =>  '/painel/calendario',
            'icon'      =>  'calendar',
            'active'      => ['/painel/calendario'],
            'permission'  => 'yes',
        ],
        'USUÁRIO',
        [
            'text'      =>  'Perfil',
            'url'       =>  '/perfil',
            'icon'      =>  'vcard-o',
            'active'      => ['/perfil'],
            'permission'  => 'yes',            
        ],
        'PAINEL',
        [
            'text'        => 'Painel',
            'url'         => '/painel',
            'icon'        => 'dashboard',
            'active'      => ['/painel','/painel/*'],
            'permission'  => 'no',
            'submenu'     =>[
                [
                    'text'        => 'Principal',
                    'url'         => '/painel',
                    'icon'        => 'dashboard',
                    'active'      => ['/painel'],
                    'permission'  => 'yes',
                ],
                [
                    'text'        => 'Banco de Horas',
                    'url'         => '/painel/bancohoras',
                    'icon'        => 'database',
                    'active'      => ['/painel/bancohoras','/painel/bancohoras/*'],
                    'permission'  => 'yes',                    
                ],
                [
                    'text'        => 'Lotação',
                    'url'         => '/painel/lotacao',
                    'icon'        => 'map',
                    'active'      => ['/painel/lotacao','/painel/lotacao/*'],
                    'permission'  => 'yes',                    
                ],
                [
                    'text'        => 'Avaliação',
                    'url'         => '/painel/aval',
                    'icon'        => 'thumbs-up',
                    'active'      => ['/painel/aval','/painel/aval/*'],
                    'permission'  => 'yes',                    
                ],
                [
                    'text'        => 'Organograma',
                    'url'         => '/painel/ranking',
                    'icon'        => 'sitemap',
                    'active'      => ['/painel/ranking','/painel/ranking/*'],
                    'permission'  => 'yes',                    
                ],
                [
                    'text'        => 'Mensagens',
                    'url'         => '/painel/chat',
                    'icon'        => 'envelope-o',
                    'active'      => ['/painel/chat','/painel/chat/*'],
                    'permission'  => 'yes',                    
                ],
                [                
                    'text'      =>   'Relatórios',
                    'url'       =>   '/painel/relatorios',
                    'icon'      =>   'file-excel-o',
                    'active'      => ['/painel/relatorios','/painel/relatorios/*'],
                    'permission'  => 'yes'               
                ],
            ],

        ],        
        'VISÃO GERAL',
        [
            'text'        => 'Grupos',
            'url'         => '/grupos',
            'icon'        => 'tags',
            'active'      => ['grupos', 'grupos', 'grupos/*'],
            'permission'  => 'no',
        ],        
        [
            'text'        => 'Projetos',
            'url'         => '/projetos',
            'icon'        => 'object-group',
            'active'      => ['projetos', 'projetos', 'projetos/*'],
            'permission'  => 'no',
        ],
        [
            'text'        => 'Colaboradores',
            'url'         => '/funcionarios',
            'icon'        => 'users',
            'active'      => ['funcionarios', 'funcionarios', 'funcionarios/*'],
            'permission'  => 'no', 
        ],
        'AVALIAÇÃO MENSAL',
        [
            'text'        => 'Avaliação',
            'url'         => '/aval',
            'icon'        => 'thumbs-o-up',
            'active'      => ['aval','aval', 'aval/*'],
            'permission'  => 'no',
        ],
        'CANAL DE COMUNICAÇÃO',
        [
            'text'        => 'Box de Sugestões',
            'url'         => '/chat',
            'icon'        => 'comments-o',
            'active'      => ['chat','chat', 'chat/*'],
            'permission'  => 'no',
        ],
    ],
    

    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */

    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'   =>  true,
    ],
];
