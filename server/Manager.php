<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require_once (DATA::PATH .'/PHPMailer/vendor/phpmailer/phpmailer/src/Exception.php');
    require_once (DATA::PATH .'/PHPMailer/vendor/phpmailer/phpmailer/src/PHPMailer.php');
    require_once (DATA::PATH .'/PHPMailer/vendor/phpmailer/phpmailer/src/SMTP.php');

    class Manager
    {
        function __construct(){}

        /**
         * 1
         * Envio de mensajes desde la web al email.
         * 
         * @param [string] $nombre nombre de la persona que envia el mensaje
         * @param [string] $email email de la persona que envia el mensaje
         * @param [string] $telefono número de télefono de la persona que envia el mensaje
         * @param [string] $mensaje mensaje a enviar
         * @return array resultado de la operación
         */
        function enviarMensaje($nombre,$email,$telefono,$mensaje)
        {
            $hoy = date("Y-m-d H:i:s.v");
            try
            {
                // $myLog = fopen("log_enviarMensaje.log", "w") or die("LOG_ERROR enviarMensaje");

                if(isset($nombre) && isset($email) && isset($telefono) && isset($mensaje))
                {
                    $mail = new PHPMailer(true); // Passing `true` enables exceptions 
                    $mail->CharSet = "UTF-8";

                    // fwrite($myLog,"Instancio\n");

                    $mail->isSMTP(); //Set mailer to use SMTP
                    $mail->Mailer = "smtp";
                    $mail->SMTPDebug = 0; //Esto sirve para modo debug. Si esta en 0 esta desactivado
                    $mail->SMTPAuth = true;
                    // $mail->Host = 'smtp.gmail.com'; // Specify main and backup SMTP servers
                    $mail->Host = 'smtp.office365.com'; // Specify main and backup SMTP servers
                    $mail->Username = "cprodycom@outlook.com"; // SMTP username
                    $mail->Password = "cHTq2Uvp^@wYRjI0m6v*Y@Zt#BUe*9"; // SMTP password  
                    $mail->SMTPSecure = "STARTTLS";
                    $mail->Port       = 587;

                    // fwrite($myLog,"Conecto\n");

                    $mail->isHTML(true); // Set email format to HTML  
                    $mail->setFrom('cprodycom@outlook.com', '(CPRODYCOM) - NUEVA MENSAJE WEB');
                    $mail->AddReplyTo('cprodycom@outlook.com', 'Reply to name');
                    // $mail->addAddress('jalexrg1992@gmail.com'); //Aqui se agrega para que te llegue el correo 
                    $mail->addAddress('camch9000@gmail.com'); // El email del usurio online
                    //$mail->addAddress($email);//Este es el mail segundo (En caso de enviar a otro)
                    $mail->addCC('jalexrg1992@gmail.com');
                    $mail->addCC('cprodycom@hotmail.com');
                    $mail->addCC('cprodycomca@gmail.com');
                    
                    if($email != NULL) { $identity = explode("@", $email, 2); }
                    else { $identity = explode("@", $telefono, 2); }

                    $mail->Subject ="(CPRODYCOM) - NUEVA MENSAJE WEB - " . $identity[0]; // Subject of the email

                    // fwrite($myLog,"Datos\n");

                    // if ($is_path) {
                    //     $mail->addAttachment($filePath, $fileName); //(Este se usa para el pathFile y  fileName)
                    // } else {
                    //     $mail->AddStringAttachment($filePath, $fileName); //aquie el filePath es un string
                    // }
                    
                    $contenido = '<!DOCTYPE html>
                    <html>
                        <head>
                            <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
                            
                            <!--FONT-->
                            <link href="https://fonts.googleapis.com/css?family=Advent+Pro:700|Open+Sans" rel="stylesheet">
                    
                            <style type="text/css">
                                body
                                {
                                    margin: 0;
                                    background-color: #e7ecf2;
                                    color: #333;
                                    font-family: "Open Sans2", sans-serif;
                                }
                                .encabezado
                                {
                                    border-bottom: 7px solid #ffcc00;
                                    background-color: #FFDD55;
                                }
                                
                                .logo_accede
                                {
                                    width: 250px;
                                    margin-top: 1.2em;
                                }
                    
                                .logoAccedePosition
                                {
                                    margin: 0;
                                    text-align: center;
                                }           
                    
                                .formulario
                                {
                                    margin-top: 20px;
                                    padding: 0 40px 20px;
                                    background-color: #F0EEEE;
                                    border:2px solid #ffcc00;
                                }
                    
                                .titulo_pantalla
                                {
                                    margin-bottom: 30px;
                                    color: #747474;
                                    font-family: "Advent Pro", sans-serif;
                                    font-size: 1.6em;
                                    font-weight: 500;
                                    text-transform: uppercase;
                                }
                    
                                .text-right
                                {
                                    text-align: right;
                                    margin-right: 1em;
                                }
                    
                                .justi
                                {
                                    text-align: justify;
                                }
                    
                            </style>
                        </head>
                    
                        <body>
                                <header class="container-fluid encabezado">
                                    <div class="logoAccedePosition">
                                        <img src="https://venus.softlab.uc3m.es/prodycom_web/images/cp_logo_fill.png" alt="logo constructora Prodycom" class="logo_accede">
                                    </div>                
                                </header>
                            <div class="container">
                                <div class="formulario">
                                    <h2 class="titulo_pantalla">Nuevo mensaje web</h2>
                                    <p>Se ha enviado un mensaje desde la web con los siguientes datos:</p>
                                    <p>Fecha: <strong>'.$hoy.'</strong></p>
                                    <p>Nombre: <strong>'.$nombre.'</strong></p>
                                    <p>Email: <strong>'.$email.'</strong></p>
                                    <p>Télefono: <strong>'.$telefono.'</strong></p>
                                    <p>Mensaje: <strong>'.$mensaje.'</strong></p>
                                    <br>
                                </div>
                    
                                <br>
                                <div class="text-right">
                                    <p><strong>Constructora Prodycom c.a.</strong></p>
                                </div>
                            </div>
                    
                        </body>
                    </html>';

                    $mail->Body = $contenido;
                    
                    // fwrite($myLog,"contenido: ".$contenido."\n");

                    $res = $mail->send();
                    // fwrite($myLog, "res: " .$res . "\n");
                    if($res != 1) { return array("status" => -1, "MENSAJE" => "EMAIL NO PUDO SER ENVIADO");}

                    return array("status" => 0);
                } 
                else { return array ("status"=>-1, "ERROR"=>"MG 1"); }
            }
            catch (Throwable $t)
            {
                $myLog = fopen("Log_ServerError.log", "a+") or die("ERROR LogServerError");
                fwrite($myLog, "->(" . $hoy . ")(Manager/Manager.php)(enviarMensaje)->" . $t->getMessage() . PHP_EOL);
                return  array("status" => -1, "MENSAJE" => "EMAIL NO PUDO SER ENVIADO");
            }
        }
    }
?>