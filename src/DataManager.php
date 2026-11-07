<?php
declare (strict_types=1);
namespace BamBam;
use RuntimeException;
class DataManager{
    private string $dataPath;
    public function __construct(string $dataPath){
        $this->dataPath=rtrim($dataPath, '/');
    }
    /**
    * Lee un archivo JSON y devuelve su contenido como array asociativo.
    */
    public function getJson(string $fileName):array{
        $filePath=$this->dataPath . '/' . ltrim($fileName, '/');
        if(!file_exists($filePath)){
            throw new runtimeException("El archivo de datos '{$fileName}' no existe.");
        }
        $content=file_get_contents($filePath);
        $data=json_decode($content, true);
        if(json_last_error() !== JSON_ERROR_NONE){
            throw new runtimeException("Error al decodificar el archivo JSON '{$fileName}'.");
        }
        return $data;
    }
}
?>