<?php
    //LOG (ONLY TEST)
    // $myLog = fopen("log_Control.log", "w") or die("LOG_ERROR Control");

    require_once "data.php";

    /*Importaciones de clases*/
    $path_manager = DATA::PATH . '/Manager.php';
    if (file_exists($path_manager)) { require_once $path_manager; } else { return array("status" => -1, "ERROR" => "Control_path_1"); }

    $option = $_POST["OPTION"];

    // fwrite($myLog,"Option:".print_r($option,true)."\n");

    if(isset($option))
    {
        switch($option)
        {
            /**
             * 1
             * Enviar mensaje
             */
            case "1":   $nombre = $_POST["NOMBRE"];
                        $email = $_POST["EMAIL"];
                        $telefono = $_POST["TELEFONO"];
                        $mensaje = $_POST["MENSAJE"];

                        // fwrite($myLog,"nombre:".print_r($nombre,true)."\n");
                        // fwrite($myLog,"email:".print_r($email,true)."\n");
                        // fwrite($myLog,"telefono:".print_r($telefono,true)."\n");
                        // fwrite($myLog,"mensaje:".print_r($mensaje,true)."\n");

                        if(isset($nombre) && isset($email) && isset($telefono) && isset($mensaje))
                        {
                            $manager = new Manager();

                            $json_return = $manager->enviarMensaje($nombre,$email,$telefono,$mensaje);
                        }
                        else { $json_return = array("ERROR"=>"C-1"); }

                        break;           
            

            /*NINGUNA DE LAS ANTERIORES*/
            default:    $json_return = array("status"=>-1,"ERROR"=>"C-Default"); break;
        }
    }
    else { $json_return = array("status"=>-1,"ERROR"=>"C-O"); }

    if(!isset($json_return) || is_null($json_return)) { $json_return = array("status"=>-1,"ERROR"=>"C-1"); }
    
    header('Content-Type: application/json');
    echo json_encode($json_return);
?>