<?php

/**
 * StorageService.php
 * Interaction with de database
 */

namespace App\Services;

use \PDO;
use \PDOException;

class StorageService {

    // Database instance conecction
    private $pdo;

    public function __construct() {
        // Conecction info
        require("bd-credentials.php");

        //Connection
        $this->pdo = new PDO(
            "mysql:host={$config['db_host']};dbname={$config['db_name']}",
            $config['db_user'], $config['db_pass']
        );

        // Errors notifications
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo->exec('set names utf8');
    }

    /**
     * Exectute SQL queries
     *
     * @param string $query
     * @param array $params
     *
     * @return array
     */

    public function query($query, $params=[]) {

        //Data array
        $result = [
            'data' => null
        ];

        // Verify is the query modify the table
        $isInsert = substr_count(strtoupper($query), "INSERT", 0, 7) > 0;
        $isDelete = substr_count(strtoupper($query), "DELETE", 0, 7) > 0;
        $isUpdate = substr_count(strtoupper($query), "UPDATE", 0, 7) > 0;

        try {
            $stmt = $this->pdo->prepare($query);

            if ($isDelete) {
                $finalQuery = $query;

                foreach ($params as $key => $value) {
                    if (is_int($value)) {
                        $finalQuery = str_replace($key, $value, $finalQuery);
                    } else {
                        $finalQuery = str_replace($key, "'$value'", $finalQuery);
                    }
                }

                $result["data"]["count"] = $this->pdo->exec($finalQuery);
            } else {
                $stmt->execute($params);
            }


            if ($isInsert) {
                $result["data"]["count"] = $stmt->rowCount();
                $result["data"]["id"] = $this->pdo->lastInsertId();
            } elseif ($isInsert || $isUpdate) {
                $result["data"]["count"] = $stmt->rowCount();
            }else {
                while ($content = $stmt->fetch(PDO::FETCH_ASSOC | PDO::FETCH_GROUP)) {
                    $result['data'][] = $content;
                }
            }
            
        } catch (PDOException $e) {
            //Error
            $result['error'] = true;
            $result['message'] = $e->getMessage();
        }

        // Returning the result
        return $result;
    }

}
