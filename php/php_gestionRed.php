<?php

####RESTART SERVICE IN PHP
//exec("sudo /etc/init.d/networking restart");


include_once("../../../clases_generales/subred.php");
$f = "/etc/dhcp/dhcpd.conf";

if(isset($_REQUEST['action'])){
    $action = $_REQUEST['action'];
} else {
    die("Ninguna Accion ha sido Definida");
}
if(isset($_REQUEST['data'])){
    $data = $_REQUEST['data'];
} else {
    $data = null;
}
        $hosts = array();
switch ($action) {

    case $action === 'obtenerRedes':

        $file = fopen($f, "rw");
        while (!feof($file)) {

            $cadena_buscada = "subnet";
            $linea = fgets($file);

            $posicion_coincidencia = strpos($linea, $cadena_buscada);

            if (!is_bool($posicion_coincidencia)) {

                preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $linea, $matches);
                $datosh['RED'] = trim($matches[0], " \t.");
                preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', substr($linea, 20, -1), $matches);
                $datosh['mascara'] = trim($matches[0], " \t.");
                $ip = fgets($file);
                preg_match('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $ip, $matches);                //   echo "IP: ".$matches[0]."<br>"."<br>";
                $datosh["puerta"] = trim($matches[0], " \t.");

                $range = fgets($file);
                $cad = "#";
                $rango = strpos($range, $cad);
                $datosh["rango"]=null;
                if (is_bool($rango)) {
                    preg_match_all('/(\d{1,3}\.\d{1,3}\.\d{1,3}\.\d{1,3})/', $range, $matches);
                    $datosh["rango"] = $matches[1][0]."->".$matches[1][1];//substr($des, $descrip, -1);
                }

                $des = fgets($file);
                $cad = "#";
                $pos = strpos($des, $cad);
                $datosh["descripción"]=null;
                if (!is_bool($pos)) {
                    $datosh["descripción"] =strtoupper(substr($des, $pos+1, -1));
                    $datosh["descripción"]=trim($datosh["descripción"], " \t.");
                }

                $datosh["netmask2cidr"]=netmask2cidr($datosh['mascara']);

                $redSubnet = $datosh["RED"]."/".$datosh["netmask2cidr"];
                $rango = getEachIpInRange ($redSubnet);
                $numRedes = count($rango);
                $datosh["rangodeipmin"]=$rango[0];
                $datosh["rangodeipmax"]=$rango[$numRedes-1];
                $hosts[] = $datosh;
            }////IF

       // print_r($datosh);
        }//whileee
        echo json_encode($hosts);
        fclose($file);
        break;
    case $action === 'GuardarRed':


        $ipred=$data['ip_red'];
        $idred=$data['id_red'];
        $mascara=$data['mask'];
        $gateway=$data['gateway'];
        $descripcion=$data['descripcionSubnet'];
        $rmax=$data['rangemax'];
        $rmin=$data['rangemin'];

        $file = fopen($f, "rw");
        $cont = 0;
        while (!feof($file)) {
            $cont++;
            $cadena_buscada = "###FINSUBNET";
            $linea = fgets($file);
            $posicion_coincidencia = strpos($linea, $cadena_buscada);
            if (!is_bool($posicion_coincidencia)) {
                break;
            }////IF
        }//whileee
        fclose($file);

        $cont=$cont-1;

        $arr = file($f);
        $arr = array_values($arr);
        $totallineas = count($arr);
        // fclose($file);
        $arr1=array_slice($arr, 0,$cont);


        $rango ="#    range ###";
        if (strlen($rmax)>0){
            $rango ="     range $rmin $rmax";
        }

        $subnetNueva[]="subnet $ipred netmask $mascara {";
        $subnetNueva[]="      option routers $gateway;";
        $subnetNueva[]=$rango;
        $subnetNueva[]="#   $descripcion";
        $subnetNueva[]="}";

        foreach($subnetNueva as $x => $value) {
            array_push($arr1,$value."\n");
        }
        $arr2=array_slice($arr, $cont,$totallineas);
        $arr=array_merge($arr1,$arr2);
        //print_r($arr);

        if (!$fp = fopen($f, 'w+'))
        {
            $resp = array();
            $resp["evento"]=$action;
            $resp["respuesta"]="no se puede abrir el archivo";
            echo json_encode($resp);
        }
        if($fp)
        {
            foreach($arr as $line) {
                fwrite($fp,$line);
            }
            fclose($fp);
        }
        $resp = array();
        $resp["evento"]=$action;
        $resp["respuesta"]="editado";
        exec("sudo /etc/init.d/isc-dhcp-server restart");
        echo json_encode($resp);

        break;
    case $action === 'EditarRedes':


        $ipred=$data['ip_red'];
        $idred=$data['id_red'];
        $mascara=$data['mask'];
        $gateway=$data['gateway'];
        $descripcion=$data['descripcionSubnet'];
        $rmax=$data['rangemax'];
        $rmin=$data['rangemin'];



        $file = fopen($f, "rw");
        $cont = 0;
        while (!feof($file)) {
            $cont++;
            $cadena_buscada = $idred;
            $linea = fgets($file);
            $posicion_coincidencia = strpos($linea, $cadena_buscada);
            if (!is_bool($posicion_coincidencia)) {
                break;
            }////IF
        }//whileee

        if (is_bool($posicion_coincidencia)){
            die ($_REQUEST['data']['id_red']);
        }
        $linea = $cont;
        //echo $linea;
        //fclose($file);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);

        if (!delLineFromFile($f,$linea)){
            $resp = array();
            $resp["evento"]=$action;
            $resp["respuesta"]="no se puede abrir el archivo";
            echo json_encode($resp);
        }

        $file = fopen($f, "rw");

        $cont = 0;

        while (!feof($file)) {
            $cont++;
            $cadena_buscada = "###FINSUBNET";
            $linea = fgets($file);
            $posicion_coincidencia = strpos($linea, $cadena_buscada);
            if (!is_bool($posicion_coincidencia)) {
                break;
            }////IF
        }//whileee
        fclose($file);

        $cont=$cont-1;

        $arr = file($f);
        $arr = array_values($arr);

       // fclose($file);
        $arr1=array_slice($arr, 0,$cont);


        $rango ="#    range ###";
        if (strlen($rmax)>0){
            $rango ="     range $rmin $rmax";
        }

        $subnetNueva[]="subnet $ipred netmask $mascara {";
        $subnetNueva[]="      option routers $gateway;";
        $subnetNueva[]=$rango;
        $subnetNueva[]="#   $descripcion";
        $subnetNueva[]="}";

        foreach($subnetNueva as $x => $value) {
            array_push($arr1,$value."\n");
        }
        $arr2=array_slice($arr, $cont,-1);
        $arr=array_merge($arr1,$arr2);
        //print_r($arr);

        if (!$fp = fopen($f, 'w+'))
        {
            $resp = array();
            $resp["evento"]=$action;
            $resp["respuesta"]="no se puede abrir el archivo";
            echo json_encode($resp);
        }
        if($fp)
        {
            foreach($arr as $line) {
                fwrite($fp,$line);
            }
            fclose($fp);
        }
        $resp = array();
        $resp["evento"]=$action;
        $resp["respuesta"]="editado";
        exec("sudo /etc/init.d/isc-dhcp-server restart");
        echo json_encode($resp);

        break;

    case $action === 'EliminarRed':

        $idred=$_REQUEST['id_red'];

        $file = fopen($f, "rw");
        $cont = 0;
        while (!feof($file)) {
            $cont++;
            $cadena_buscada = $idred;
            $linea = fgets($file);
            $posicion_coincidencia = strpos($linea, $cadena_buscada);
            if (!is_bool($posicion_coincidencia)) {
                break;
            }////IF
        }//whileee

        if (is_bool($posicion_coincidencia)){
            die ($_REQUEST['id_red']);
        }
        $linea = $cont;
        //echo $linea;
        //fclose($file);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);
        delLineFromFile($f,$linea);

        if (!delLineFromFile($f,$linea)){
            $resp = array();
            $resp["evento"]=$action;
            $resp["respuesta"]="no se puede abrir el archivo";
            echo json_encode($resp);
        }

        $resp = array();
        $resp["evento"]=$action;
        $resp["respuesta"]="eliminado";
        exec("sudo /etc/init.d/isc-dhcp-server restart");
        echo json_encode($resp);

        break;
    default :
        break;
}


?>