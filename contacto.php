<?php

    header('Content-Type: application/json');

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {

        $name = strip_tags($_POST['name'] ?? '');
        $email = filter_var($_POST['email'] ?? '', FILTER_SANITIZE_EMAIL);
        $phone = strip_tags($_POST['phone'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            http_response_code(400);
            echo json_encode(['message' => 'Correo electrónico no válido']);
            exit;
        }

        try {
            
            $to = 'contacto@cgmaquinaria.mx';
            $subject = 'Nuevo Lead';
            $body = "Nombre: $name\nCorreo: $email\nTeléfono: $phone";
            
            $headers = "From: contacto@cgmaquinaria.mx\r\n";
            $headers .= "Reply-To: $email\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
        
            if (mail($to, $subject, $body, $headers)) {
                http_response_code(200);
                echo json_encode(['message' => 'Correo enviado']);
            } else {
                $errorMessage = error_get_last()['message'] ?? 'Falló el envío del correo';
                http_response_code(500);
                echo json_encode(['message' => "El mensaje no se pudo enviar. Error: {$errorMessage}"]);
            }            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['message' => "El mensaje no se puedo enviar. Error: {$e->getMessage()}"]);
        }
        
    } 

    else {
        http_response_code(405);
        echo json_encode(['message' => 'Método no permitido']);
    }

?>
