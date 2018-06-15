<?php
// No direct access to this file
//defined('_JEXEC') or die('Restricted access');

//jimport('nusoap.nusoap.nusoap');
include 'nusoap/nusoap.php';
/**/
define('DB_USER', 'deposito');
//define ('DB_PWD', 'sOH6J4BkDf');
define('DB_PWD', 'uTqsKWIP');
define('DB_SID', 'UNIC.UNIANDES.EDU.CO');
define('DB_SERVER', 'beoratst02-scan.uniandes.edu.co');
define('DB_PORT', '1521');

// Modo de pruebas
define('MODO_PRUEBAS', false);
define('MODO_PRUEBAS_CORREO', true);
define('CORREO_PRUEBAS', 'soporte@ifactum.com');

define('EGRECONM', 'EGRECONM');
define('EGRESADO', 'EGRESINM');
define('EGRESINM', 'EGRESINM');
define('EGRECONMBD', 'EGRECONMBD');
define('EGRESINMBD', 'EGRESINMBD');


//Constantes SITIO SIRE
define('SITIO', 'BIBLIOTECAS');
define('CODSERVICIO', '95');
define('IDSITIO', '520');
define('IDPRODUCTO	', 'idProducto');
define('WSDL_PAGOS', 'C:\xampp\htdocs\soap\wsdl\PagosService.wsdl');
define('WSDL_CONSULTAS', 'C:\xampp\htdocs\soap\wsdl\PagosSitiosExternosService.wsdl');
// define ('WSDL_PI','https://pidev.uniandes.edu.co/dir/wsdl?p=ic/662b0785b61b32ea81c5deb3c5228012');
// define ('USER_PI','BIBLIOTECA');
// define ('PSWD_PI','KiMGogeNF6');
define('WSDL_PI', '/datos/hypertext/vde.uniandes.edu.co/wsdl/datos_deudor_qa.wsdl');
define('USER_PI', 'BIBLIOTECA');
define('PSWD_PI', 'wFL3G3DRfC');
// define ('PSWD_PI','wFL3G3DRfC');
//define ('URL_PAGOS','https://sireqa.uniandes.edu.co/pagos/pagar');
/**/

class NuSoap
{
    public static function Preparar_Pago($params)
    {
        $proxyhost 		= 	isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport 		= 	isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername 	= 	isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword 	= 	isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
        $useCURL 		= 	isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $soapClientArray = array(
          'encoding' => 'utf-8',
          'trace' => 1,
          'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
          'stream_context'=> stream_context_create(
              array('ssl'=> array(
          'verify_peer'=>false,
          'verify_peer_name'=>false,
          'allow_self_signed' => true //can fiddle with this one.
            )
            )
            )
        );


        $result;
        $client = new SoapClient(WSDL_PAGOS, $soapClientArray);

        try {

    //                echo '<pre>Valor arreglo: '.print_r($params,true).'</pre>';
            //                die();
            $result = $client->prepararPago($params);

        } catch (Exception $e) {
            echo 'Excepción capturada: ',  $e->getMessage(), "\n";

        }

        return $result;
    }
    //Funcion para obtener los datos de las transacciones en SIre

    public static function Obtener_Datos_Transaccion_Sire($ref_venta =  "", $productoId = "")
    {
        // $ref_venta	=	"684850000257000079952550";
        $parametros = array(
            'productoId' 	  => $productoId,
            'referenciaVenta' => $ref_venta
        );

        $proxyhost 		= 	isset($_POST['proxyhost']) ? $_POST['proxyhost'] : '';
        $proxyport 		= 	isset($_POST['proxyport']) ? $_POST['proxyport'] : '';
        $proxyusername 	= 	isset($_POST['proxyusername']) ? $_POST['proxyusername'] : '';
        $proxypassword 	= 	isset($_POST['proxypassword']) ? $_POST['proxypassword'] : '';
        $useCURL 		= 	isset($_POST['usecurl']) ? $_POST['usecurl'] : '0';
        $soapClientArray = array(
          'encoding' => 'utf-8',
          'trace' => 1,
          'compression' => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP,
          'stream_context'=> stream_context_create(
              array('ssl'=> array(
          'verify_peer'=>false,
          'verify_peer_name'=>false,
          'allow_self_signed' => true //can fiddle with this one.
            )
            )
            )
        );
        $client = new SoapClient(WSDL_CONSULTAS, $soapClientArray);

        $result = $client->pagosPendientes($parametros);

        return $result;
    }
    //Funcion que obtiene datos del usuario del sistema PI
    public static function Obtener_Datos_Usuario($doc)
    {
        $parametros = array(
        'DOCUMENTO' => $doc
    );
        $client = new nusoap_client(WSDL_PI, 'wsdl', '', '', '', '');
        $err = $client->getError();
        $client->setCredentials(USER_PI, PSWD_PI, "basic");
        $proxy = $client->getProxy();
        $Datos_Usuario = $proxy->CONSULTAR_DEUDOR($parametros);
        if ($Datos_Usuario[OUTPUT][PAIS] != "" && $Datos_Usuario[OUTPUT][DOCUMENTO] != "" && $Datos_Usuario[OUTPUT][TIPO_DOC] != "" && $Datos_Usuario[OUTPUT][REGION] != "") {
            return $Datos_Usuario[OUTPUT];
        } else {
            return false;
        }
    }
}
