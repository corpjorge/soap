<?php

include 'nusoap/nusoap.php';


$datos_pago = array(

  "referenciaVenta" => "975710000002000987654321",
  "descripcion" => "Pago Carrera Senek 2018 Prueba",
  "valor" => "125000.00",
  "iva" => "00.00", 
  "baseDevolucionIva" => "00.00", 
  "correo" => "corpjorge@gmail.com", 
  "fondoPresupuestal" => "810481815 ",
  "moneda" => "COP",
  "nombreComprador" => "JORGE PAGO", 
  "apellidoComprador" => "JORGE PAGO", 
  "fechaInicioServicio" => "20180614",
  "fechaFinServicio" => "20180621",
  "fechaLimite" => "20180621",
  "tipoIdentificacion" => "CEDULA_CIUDADANIA",
  "numeroIdentificacion" => "987654321",
  "tipoObjetoCosto" => "ORDEN_INTERNA",
  "numeroObjetoCosto" => 97,
  "valorAdicional" => "00.00", 
  "productoId" => 2558,
  "claveProducto" => "senek2018",
  "urlError" => "https://vdepr.,uniandes.edu.co/index.php?option=com_pagosire&task=errorpago",
  "urlRespuesta" => "https://vdepr.,uniandes.edu.co/index.php?option=com_pagosire&task=respuestapago",
  "celular" => "30133335465",
  "telefono" => "3013992477",
  "direccion" => "AV 333 O BIS NORTE 222 222 222",
  "ciudad" => "001",
  "pais" => "CO",
  "region" => "11",
  "ipCliente" => "172.18.,39.11",
  "userAgentCliente" => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.87 Safari/537.36"
  );

 $token_sire =	NuSoap::Preparar_Pago($datos_pago);
define('URL_PAGOS', 'https://sireqa.uniandes.edu.co/pagos/pagar');
$urlPagos=URL_PAGOS;
echo $urlPagos.'?token='.$token_sire;