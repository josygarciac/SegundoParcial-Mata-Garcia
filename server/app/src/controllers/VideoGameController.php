<?php

namespace App\Controllers;

use App\Services\LoggingService;
use App\Services\VideoGameService;
use Slim\Http\Request;

class VideoGameController {
  
  private $videoGameService;

  /**
   * VideoGameController constructor.
   */
  public function __construct() {
    $this->videoGameService = new VideoGameService();
  }

  /**
   * Register a new videogame in the system
   * @param Request $request
   *
   * @return string []
   */
  public function register($request) {
    $result = [];

    $formData = $request->getParsedBody();

    $titulo = null;
    $desarrollador = null;
    $descripcion = null;
    $consola = null;
    $fechaLanzamiento = null;
    $calificacion = null;
    $imagenURL = null;

    LoggingService::logVariable($formData, __FILE__, __LINE__);

    // Verify the entry of titulo
    if (array_key_exists("titulo", $formData)) {
      $titulo = $formData["titulo"];
    }

    // Verify the entry of desarrollador
    if (array_key_exists("desarrollador", $formData)) {
      $desarrollador = $formData["desarrollador"];
    }

    // Verify the entry of descripcion
    if (array_key_exists("descripcion", $formData)) {
      $descripcion = $formData["descripcion"];
    }

    // Verify the entry of consola
    if (array_key_exists("consola", $formData)) {
      $consola = $formData["consola"];
    }

    // Verify the entry of fechaLanzamiento
    if (array_key_exists("fechaLanzamiento", $formData)) {
      $fechaLanzamiento = $formData["fechaLanzamiento"];
    }

    // Verify the entry of calificacion
    if (array_key_exists("calificacion", $formData)) {
      $calificacion = $formData["calificacion"];
    }

    // Verify the entry of imagenURL
    if (array_key_exists("imagenURL", $formData)) {
      $imagenURL = $formData["imagenURL"];
    }

    if (isset($titulo, $desarrollador, $descripcion, $consola, $fechaLanzamiento, $calificacion, $imagenURL)) {
      $registerResult = $this->videoGameService->register($titulo, $desarrollador, $descripcion, $consola, $fechaLanzamiento, $calificacion, $imagenURL);

      if (array_key_exists("error", $registerResult)) {
        $result["error"] = $registerResult["error"];
      }

      $result["message"] = $registerResult["message"];
    } else {
      $result["error"] = true;
      $result["message"] = "No pueden existir datos vacíos.";
    }

    return $result;
  }

  /**
   * Get all the videogames
   *
   * @param Request $request
   *
   * @return []
   */
  public function getAll($request) {
    $result = [];

    $formData = $request->getParsedBody();

    $getAllResult = $this->videoGameService->getAll();

    if (array_key_exists("error", $getAllResult)) {
      $result["error"] = true;
    } else {
      $result["data"] = $getAllResult["data"];
    }

    $result["message"] = $getAllResult["message"];

    return $result;
  }

  /**
   * Delete one by Id
   * @param Request $request
   *
   * @return []
  */
  public function delete($request, $args) {
    $result = [];

    $id = $args['id'];
    
    $deleteResult = $this->videoGameService->delete($id);

    if (array_key_exists("error", $deleteResult)) {
        $result["error"] = true;
    }

    $result["message"] = $deleteResult["message"];
    
    return $result;
  }

}