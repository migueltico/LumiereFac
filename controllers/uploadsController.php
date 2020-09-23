<?php

namespace controllers;
// manda a llamar al controlador de vistas
use config\view;
//Funciones de ayuda
use config\helper as help;
// la clase debe llamarse igual que el controlador respetando mayusculas
class uploadsController extends view

{

    public static function uploads()
    {
        $result = true;
        $data = '';
        $urls['urls'] = [];

        for ($i = 0; $i < count($_FILES['file']['name']); $i++) {
            $data = help::uploadImage($i);
            if ($data['ok']) {
                array_push($urls['urls'], ltrim($data['url'], "."));
            } else {
                array_push($urls['error'], $data);
            }
        }
        return $urls;
        // header('Content-Type: application/json');
        // echo json_encode($result);
    }
    public static function removeImgAdd($urls)
    {
        $fullResult = true;
        if ($urls !== '') {

            $urls = explode(",", $urls);
            foreach ($urls as $key => $key) {

                $result = unlink("." . $urls[$key]);
                if ($result == false) {
                    $fullResult = false;
                }
            }
        }
        return array("data" => $fullResult, "error" => $urls, "msg" => "Registros ingresados correctamente");
    }
}
