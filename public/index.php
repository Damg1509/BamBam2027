<?php
declare(strict_types=1);

// Cargar helper globalde sanitización
require_once __DIR__ . '/../src/helpers.php';

// 1. Autoload Nativo para clases en el namespace 'BamBam'
spl_autoload_register(function(string $class): void{
    $prefix='BamBam\\';
    $baseDir=__DIR__ . '/../src/';

    $len=strlen($prefix);
    if(strncmp($prefix, $class, $len) !== 0){
        return;
    }

    $relativeClass=substr($class, $len);
    $file=$baseDir . str_replace('\\', '/', $relativeClass) . '.php';

    if(file_exists($file)){
        require $file;
    }
});

use BamBam\Router;
use BamBam\View;
use BamBam\DataManager;

// 2. Definición de rutas base de archivos
define('BASE_PATH', dirname(__DIR__));

// 3. Inicializar Servicios
$view=new View(BASE_PATH . '/templates');
$data=new DataManager(BASE_PATH . '/data');
$router=new Router();

// Cargar ajuste globales del sitio (Teléfono, email, redes sociales, etc..)
$siteSettings   =$data->getJson('setting.json');
$navigation     =$data->getJson('navigation.json');

// 4. Definición de rutas del sitio web
$router->add('GET', '/', function() use ($view, $data, $siteSettings, $navigation){
    $view->render('inicio', [
        'pageTitle'     => 'Inicio - Jardín Infantil BamBam',
        'description'   => 'Bienvenidos al Jardín Infantil BamBam en Las Codnes, donde la educación y el juego se combinan para crear un entorno de aprendizaje único y estimulante para los niños.',
        'settings'      => $siteSettings,
        'navigation'    => $navigation,
        'salas'         => $data->getJson('salas.json')
    ]);
});

$router->add('GET', '/proyecto-educativo', function() use ($view, $siteSettings, $navigation){
    $view->render('proyecto-educativo', [
        'pageTitle'     => 'Proyecto Educativo - Jardín Infantil BamBam',
        'description'   => 'Descubre nuestro proyecto educativo en el Jardín Infantil BamBam, donde fomentamos el desarrollo integral de los niños a través de experiencias de aprendizaje significativas y divertidas.',
        'settings'      => $siteSettings,
        'navigation'    => $navigation
    ]);
});

$router->add('GET', '/niveles-educativos', function() use ($view, $data, $siteSettings, $navigation){
    $view->render('niveles-educativos', [
        'pageTitle'     => 'Niveles Educativos - Jardín Infantil BamBam',
        'description'   => 'Explora los diferentes niveles educativos que ofrecemos en el Jardín Infantil BamBam, diseñados para apoyar el crecimiento y desarrollo de cada niño en un ambiente seguro y estimulante.',
        'settings'      => $siteSettings,
        'navigation'    => $navigation,
        'salas'         => $data->getJson('salas.json')
    ]);
});

// Ruta de fallback 404
$router->add('GET', '/404', function() use ($view, $siteSettings, $navigation){
    $view->render('404', [
        'pageTitle'     => 'Página no encontrada - Jardín Infantil BamBam',
        'settings'      => $siteSettings,
        'navigation'    => $navigation
    ]);
});

// 5. Despachar la solicitud actual
$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
?>