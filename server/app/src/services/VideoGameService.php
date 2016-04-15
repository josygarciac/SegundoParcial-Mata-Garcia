<?php

/**
 * VideoGameService.php
 */

namespace App\Services;

class VideoGameService {

  private $storage;

  /**
   * PurchaseService constructor.
   */
  public function __construct() {
    /* Database verification */
    $this->storage = new StorageService();
  }

  /**
  * Register a video game in the system
  * @param varchar titulo
  * @param varchar desarrollador
  * @param varchar descripcion
  * @param varchar consola
  * @param date fechaLanzamiento
  * @param float calificacion
  * @param varchar imagenURL
  */

  public function register($titulo, $desarrollador, $descripcion, $consola, $fechaLanzamiento, $calificacion, $imagenURL) {
    $result = [];
    //Verify that titulo has at least one character, no spaces
    if (strlen(trim($titulo)) > 0) {
      //Verify that desarrollador has at least one character, no spaces
      if (strlen(trim($desarrollador)) > 0) {
        //Verify that descripcion has at least one character, no spaces
        if (strlen(trim($descripcion)) > 0) {
          //Verify that consola has at least one character, no spaces
          if (strlen(trim($consola)) > 0) {
            //Verify that fechaLanzamiento has at least one character, no spaces
            if (strlen(trim($fechaLanzamiento)) > 0) {
              //Verify that calificacion has at least one character, no spaces
              if (strlen(trim($calificacion)) > 0) {
                //Verify that calificacion has at least one character, no spaces
                if (is_numeric($calificacion)) {
                  //Verify that imagenURL has at least one character, no spaces
                  if (strlen(trim($imagenURL)) > 0) {
                    //If everything is ok, we proceed to insert on database
                     $query = "INSERT INTO games (titulo, desarrollador, descripcion, consola, fechaLanzamiento, calificacion, imagenURL)
                               VALUES(:titulo, :desarrollador, :descripcion, :consola, :fechaLanzamiento, :calificacion, :imagenURL)";

                                // Parameters of queryInsert
                                $params = [":titulo" => $titulo, ":desarrollador" => $desarrollador, ":descripcion" => $descripcion, ":consola" => $consola, ":fechaLanzamiento" => $fechaLanzamiento, ":calificacion" => $calificacion, ":imagenURL" => $imagenURL];

                                $createVideogameResult = $this->storage->query($query, $params);

                                LoggingService::logVariable($formData, __FILE__, __LINE__);

                                if ($createVideogameResult["data"]["count"] == 1) {
                                  $result["message"] = "Videojuego registrado exitosamente.";
                                } else {
                                  $result["error"] = true;
                                  $result["message"] = "Hubo un error al registrar el videojuego, por favor intenta de nuevo";
                                }
                  } else {
                    // imagenURL is blank
                    $result["message"] = "La URL de la imagen del videojuego es requerida.";
                    $result["error"] = true;
                  }
                } else {
                  // calificacion isn't numeric
                  $result["message"] = "La calificación del videojuego es inválida.";
                  $result["error"] = true;
                }
              } else {
                // calificacion is blank
                $result["message"] = "La calificación del videojuego es requerida.";
                $result["error"] = true;
              }
            } else {
              // fechaLanzamiento is blank
              $result["message"] = "La fecha de lanzamiento del videojuego es requerida.";
              $result["error"] = true;
            }
          } else {
            // consola is blank
            $result["message"] = "La consola del videojuego es requerida.";
            $result["error"] = true;
          }
        } else {
          // descripcion is blank
          $result["message"] = "La descripción del videojuego es requerida.";
          $result["error"] = true;
        }
      } else {
        // desarrollador is blank
        $result["message"] = "El desarrollador del videojuego es requerido.";
        $result["error"] = true;
      }
    } else {
      // Título is blank
      $result["message"] = "El título del videojuego es requerido.";
      $result["error"] = true;
    }

    return $result;
  }

  /**
   * Get all videogames
   * @return array
   */
  public function getAll() {
    $result = [];

    // Current query
    $query = "SELECT * FROM games";

    // Query params
    $params = [];

    $getAllResult = $this->storage->query($query, $params);

    // Success
    if (count($getAllResult["data"]) > 0) {
      $games = $getAllResult["data"];

      $result["message"] = "Videojuegos obtenidos satisfactoriamente.";

      $result["data"] = $games;
    } else {
      $result["error"] = true;
      $result["message"] = "Error en la petición";
    }

    return $result;
  }

  /**
   * Delete one videogame by Id
   * @param int $id
   * @return array
   */
  public function delete($id) {
    $result = [];

    // Verify if the id is numeric
    if (is_numeric($id)) { 

      // Current query
      $query = "DELETE FROM games WHERE id = :id";

      // Query params
      $params = [":id" => $id];

      $deleteResult = $this->storage->query($query, $params);

      // Success
      if (count($deleteResult["data"]["count"]) == 1) {

        $result["message"] = "Videojuego eliminado correctamente.";

      } else {
        $result["error"] = true;
        $result["message"] = "Error al borrar el videojuego.";
      }

    } else {
        // Invalid id_user
        $result["message"] = "El id es inválido.";
        $result["error"] = true;
    }
    return $result;
  }

  /**
    * Update a videogame in the system
    * @param varchar titulo
    * @param varchar desarrollador
    * @param varchar descripcion
    * @param varchar consola
    * @param date fechaLanzamiento
    * @param float calificacion
    * @param varchar imagenURL
  */

  public function update($id, $titulo, $desarrollador, $descripcion, $consola, $fechaLanzamiento, $calificacion, $imagenURL) {
    $result = [];
    $action = "update";
    //Verify that id has at least one character, no spaces
    if (is_numeric($id)) {
      //Verify that titulo has at least one character, no spaces
      if (strlen(trim($titulo)) > 0) {
        //Verify that desarrollador has at least one character, no spaces
        if (strlen(trim($desarrollador)) > 0) {
          //Verify that descripcion has at least one character, no spaces
          if (strlen(trim($descripcion)) > 0) {
            //Verify that consola has at least one character, no spaces
            if (strlen(trim($consola)) > 0) {
              //Verify that fechaLanzamiento has at least one character, no spaces
              if (strlen(trim($fechaLanzamiento)) > 0) {
                //Verify that calificacion has at least one character, no spaces
                if (strlen(trim($calificacion)) > 0) {
                  //Verify that calificacion has at least one character, no spaces
                  if (is_numeric($calificacion)) {
                    //Verify that imagenURL has at least one character, no spaces
                    if (strlen(trim($imagenURL)) > 0) {
                      //If everything is ok, we proceed to insert on database
                      $query = "UPDATE games SET titulo = :titulo, desarrollador = :desarrollador, descripcion = :descripcion, consola = :consola, fechaLanzamiento = :fechaLanzamiento, calificacion = :calificacion, imagenURL = :imagenURL WHERE id = :id";

                        // Parameters of queryInsert
                        $params = [":id" => $id, ":titulo" => $titulo, ":desarrollador" => $desarrollador, ":descripcion" => $descripcion, ":consola" => $consola, ":fechaLanzamiento" => $fechaLanzamiento, ":calificacion" => $calificacion, ":imagenURL" => $imagenURL];

                        LoggingService::logVariable($formData, __FILE__, __LINE__);

                        $updateResult = $this->storage->query($query, $params);

                        if ($updateResult["data"]["count"] == 1) {
                          $result["message"] = "Videojuego actualizado exitosamente.";
                        } else {
                          $result["error"] = true;
                          $result["message"] = "Hubo un error al actualizar el videojuego, por favor intente de nuevo";
                        }
                    } else {
                      // imagenURL is blank
                      $result["message"] = "La URL de la imagen del videojuego es requerida.";
                      $result["error"] = true;
                    }
                  } else {
                    // calificacion isn't numeric
                    $result["message"] = "La calificación del videojuego es inválida.";
                    $result["error"] = true;
                  }
                } else {
                  // calificacion is blank
                  $result["message"] = "La calificación del videojuego es requerida.";
                  $result["error"] = true;
                }
              } else {
                // fechaLanzamiento is blank
                $result["message"] = "La fecha de lanzamiento del videojuego es requerida.";
                $result["error"] = true;
              }
            } else {
              // consola is blank
              $result["message"] = "La consola del videojuego es requerida.";
              $result["error"] = true;
            }
          } else {
            // descripcion is blank
            $result["message"] = "La descripción del videojuego es requerida.";
            $result["error"] = true;
          }
        } else {
          // desarrollador is blank
          $result["message"] = "El desarrollador del videojuego es requerido.";
          $result["error"] = true;
        }
      } else {
        // Título is blank
        $result["message"] = "El título del videojuego es requerido.";
        $result["error"] = true;
      }
    } else {
      // Id isn't numeric
      $result["message"] = "El id del videojuego es inválido.";
      $result["error"] = true;
    }

    return $result;
  }
}
