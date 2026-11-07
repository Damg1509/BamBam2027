<?php
declare(strict_types=1);
namespace BamBam;
use InvalidArgumentException;
class View{
    private string $templatesPath;
    public function __construct(string $templatesPath){
        $this->templatesPath=rtrim($templatesPath, '/\\');
    }
    /**
     * Renderiza una vista inyectando variables en su propio ámbito y envolviéndola en el layout global.
     *
     * @param string $viewName Nombre del archivo de vista sin extensión (ej: 'inicio', 'proyecto-educativo')
     * @param array<string, mixed> $data Datos que estarán disponibles en las plantillas PHP
     */
    public function render(string $viewName, array $data=[]):void{
        $viewFile=$this->templatesPath . '/views/' . ltrim($viewName, '/\\') . '.php';
        /* Manejo de vistas no encontradas (Fallback a 404) */
        if(!file_exists($viewFile)){
            http_response_code(404);
            $viewFile=$this->templatesPath . '/views/404.php';
            if(!file_exists($viewFile)){
                throw new InvalidArgumentException("La vista '{$viewName}' y la plantilla 404.php no existen");
            }
        }
        // Extrae las claves del array como variables aisladas ($title, $description, etc.
        extract($data, EXTR_SKIP);

        // Renderizado secuencial de la estructura global
        require $this->templatesPath . '/layouts/head.php';
        require $this->templatesPath . '/layouts/header.php';
        require $viewFile;
        require $this->templatesPath . '/layouts/footer.php';
    }
}
?>