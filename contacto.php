<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = $_POST['name'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';

    try {

        $to = 'contacto@cgmaquinaria.mx'; // Replace with your actual cPanel email
        $subject = 'Nuevo Lead';
        $body = "Nombre: $name\nCorreo: $email\nTeléfono: $phone";
        
        $headers = "From: contacto@cgmaquinaria.mx\r\n"; // Replace with a valid "From" email
        $headers .= "Reply-To: $email\r\n";
        $headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
    
        if (mail($to, $subject, $body, $headers)) {
            http_response_code(200);
            echo json_encode(['message' => 'Correo enviado']);
        } else {
            throw new Exception('Falló el envío del correo');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['message' => "El mensaje no se puedo enviar. Error: {$e->getMessage()}"]);
    }
    

} else {
    http_response_code(405);
    echo json_encode(['message' => 'Método no permitido']);
}
?>