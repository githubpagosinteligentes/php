<?php
#se definen parametros.
$parameters = [
    
        "generateTransaction" => [
            [
                "security" => [
                    "accountId" => 30336,
                    "token" => "bflMObSMSnyvysHpC72*",
                ],
                "infoPayment" => [
                    "amount" => 1000,
                    "tax" => 0,
                    "description" => "Prueba php",
                    "toolId" => 5,
                    "registryToolId" => 0,
                    "currency" => "COP",
                ],
                "infoClient" => [
                    "name" => "Pagos Inteligentes",
                    "idType" => "CC",
                    "idNumber" => "123456789",
                    "email" => "comprobantes@pagosinteligentes.com",
                    "phone" => "573213285290",
                ],
                "infoAdditional" => [
                    "disabledPaymentMethod" => "20,21,24",
                    "infoAdditional" => 0,
                    "urlResponseOk" => "https://sag.pagosinteligentes.com:8140/",
                    "urlResponseFail" => "https://sag.pagosinteligentes.com:8140/",
                    "urlResponsePending" => "https://sag.pagosinteligentes.com:8140/",
                    "urlNotificationPost" => "https://sag.pagosinteligentes.com:8140/",
                    "photo" => "https://dl.dropboxusercontent.com/s/jghrtm678do5fts/carrito.jpg?dl=0",
                    "cashDiscount" => 100,
                    "expiredCashDiscount" => "2021/12/31",
                    "deliveryAddres" => True,
                    "ammountShipping" => 0,
                    ],                
            ],
        ]
    ];


// Se codifica a formato Json
$datosCodificados = json_encode($parameters);

// Comenzar a crear el objeto de curl
# Url donde se hace la petición...
$url = "https://apiecommerce.pagosinteligentes.com:8070/CheckOut/MethodGenerateTransaction";
$ch = curl_init($url);

# Ahora le ponemos todas las opciones
curl_setopt_array($ch, array(
    // Indicar que vamos a hacer una petición POST
    CURLOPT_CUSTOMREQUEST => "POST",
    // Justo aquí ponemos los datos dentro del cuerpo
    CURLOPT_POSTFIELDS => $datosCodificados,
    // Encabezados
    //CURLOPT_HEADER => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($datosCodificados), // Abajo podríamos agregar más encabezados        
    ),
    # indicar que regrese los datos, no que los imprima directamente
    CURLOPT_RETURNTRANSFER => true,
));
# Se realiza la peticion
$resultado = curl_exec($ch);
# Si el código es 200, es decir, HTTP_OK
$codigoRespuesta = curl_getinfo($ch, CURLINFO_HTTP_CODE);
if($codigoRespuesta === 200){
    # Decodificar JSON porque esa es la respuesta
    $respuestaDecodificada = json_decode($resultado);
    # Simplemente los imprimimos
    echo "<strong>Peticion: </strong>" . $respuestaDecodificada->respuestaDecodificada;
}else{
    # Error
    echo "Error consultando. Código de respuesta: $codigoRespuesta";
}
curl_close($ch);
