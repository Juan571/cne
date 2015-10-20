<!DOCTYPE html>

<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="http://rec.vtelca.gob.ve/img/favicon.ico" />
    <script src="http://rec.vtelca.gob.ve/jquery/2.1.1/jquery.min.js"></script>
    <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap/3.2.0/css/bootstrap-theme.min.css">
    <script src="http://rec.vtelca.gob.ve/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="./js/jquery.mask.js"></script>
    <script type="text/javascript" src="./js/jquery.validate.js"></script>

  
    
    <script type="text/javascript" src="./js/foundation/js/foundation.min.js"></script>
    <script type="text/javascript" src="./js/funciones_consulta_cne.js"></script>
    <link rel="stylesheet" href="./js/foundation/css/foundation.css">
    <link rel="stylesheet" href="./js/foundation/css/foundation.min.css">
    <link rel="stylesheet" type="text/css" href="./css/pnotify.custom.min.css">
    <script type="text/javascript" src="./js/pnotify.custom.min.js"></script>
    
    <script src="http://rec.vtelca.gob.ve/bootstrap-select/1.6.0/dist/js/bootstrap-select.min.js"></script>
    <link rel="stylesheet" href="http://rec.vtelca.gob.ve/bootstrap-select/1.6.0/dist/css/bootstrap-select.min.css">
  
    <link rel="stylesheet" type="text/css" href="./css/estilos_personales.css" />


    <title>Consuta Datos CNE</title>
</head>
<header>
    <script>

    </script>
</header>
<body>


    
    <div id="" class="container" style="">
        

                        <form id="form1" name="formulario" enctype="application/x-www-form-urlencoded">

                            <fieldset style="border: none" >
                                <div style="text-align: center;" class="" align="center">                                    
                                    <h2 style="color: black; ">Consulta Datos CNE</h2>                                     
                                    <div class="col-md-3" style="text-align: center;">
                                    </div>
                                    <div class="col-md-6" style="text-align: center;display: flex;">
                                           <div class="col-md-2">
                                           </div>
                                           <div style="display: -webkit-box;" class="col-md-4">
                                           <b style="color: black;">NACIONALIDAD (V / E)</b>
                                           <select name="nacionalidad" style="color: Black;width: 22%;font-size: large;" class="selectpicker">
                                            <option>V</option>
                                            <option>E</option>
                                           </select>
                                           </div>
                                           <div style="display: -webkit-box;" class="col-md-4">
                                           <b style="color: black;">Cédula</b>
                                           <input  style='text-transform:uppercase;width:75%;font-size:x-large;' maxlength="10" minlength="7" id="cedula" name="cedula" class="cedula" ="cedula" onkeypress='validate(event)' onpaste="return false;" class="form-control" value=""  placeholder="Ej: 10.100.140" >
                                           </div>
                                            <div class="col-md-2">
                                           </div>
                                    </div>                                            
                                    <div class="col-md-3" style="text-align: center;">
                                    </div>
                                    <div class="col-md-12" style="text-align: center;">
                                        <div style="margin-top: 2%">
                                            <input class="btn btn-info submit"  id="guardar" type="submit" value="BUSCAR">
                                            <input type="reset" value="LIMPIAR " title="Limpiar Campos" id="botonlimpiar" class="btn botonlimpiar btn-danger">
                                        </div>
                                    </div>
                                    
                                </div>
                            </fieldset>
                        </form>
                            <div class="col-md-2">
                            </div>
                            <div id"datos" class="datos col-md-8" style="text-align: center;display:none">
                                <h2 style="color: black;">Datos del Elector</h2>
                                <div  class="col-md-4" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Cédula:</h4>
                                    <h3 style="color: white;" id="datos_cedula"></h3>
                                </div>
                                <div class="col-md-8" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Nombre:</h4>
                                    <h3 style="color: white;" id="datos_nombre"></h3>
                                </div>
                                <div class="col-md-4" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Estado:</h4>
                                    <h4 style="color: white;" id="datos_estado"></h4>
                                </div>


                                <div  class="col-md-4" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Municipio:</h4>
                                    <h4 style="color: white;" id="datos_municipio"></h4>
                                </div>
                                <div class="col-md-4" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Parroquia:</h4>
                                    <h4 style="color: white;" id="datos_parroquia"></h4>
                                </div>
                                <div class="col-md-12" style="text-align: left;display: flex;">
                                    <h4 style="color: black;"> Centro:</h4>
                                    <h4 style="color: white;" id="datos_centro"></h4>

                                </div>

                                <div class="col-md-12" style="text-align: left;">
                                    <h4 style="color: black;"> Dirección:</h4>
                                    <h3 style="color: white;" id="datos_direccion"></h3>

                                </div>
                            </div>
                            <div class="col-md-2">
                            </div>
                    
    </div><!-- /container -->
    <div id="myModal" class="reveal-modal" data-reveal aria-labelledby="firstModalTitle" aria-hidden="true" role="dialog">
      <h2 id="myModaltitulo">Obteniendo Datos...</h2>
      <h3> Por Favor Espere</h3>
      <img src="http://rec.vtelca.gob.ve/img/loader-128.gif" style="margin-left: 50%;" alt="Cargando" height="60" width="60">
    </div>


</body>


</html>