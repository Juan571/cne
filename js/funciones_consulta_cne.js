
$(document).ready(function() {
 $("#cedula").mask('000.000.000',{reverse: true});
    $("#botonlimpiar").on("click",function(){
        $("#form1").trigger("reset");
        $("#guardar").show();
        $(".datos").hide();

    });
    $("#cedula").focus();
    $('#cedula').keypress(function (e) {
      if (e.which == 13) {
       $("#guardar").trigger("click");
      }
    });
    $("#form1").validate({
        rules:{
            cedula:{
                required:true,
                minlength: 7,
                maxlength: 11                
            },          
        },
        messages:{
            cedula:{
                required:"Ingresa el una Cedula Válida",
                minlength: "Ingresa el una Cédula Válida 10.100.100",
                maxlength: "Maximo 11 caracteres para una cédula"
            },           
        },
        debug:true,
        submitHandler:function(){
            datosformulario1 = $("#form1").serializeArray();
            data={};
            datos={};
            $.each(datosformulario1, function (i, a) {
                if(a.value===""){
                    a.value=null;
                }
                datos[a.name]=a.value;
            });
                data["action"]="GuardarRed";
                data["data"]=datos;
                datos["cedula"]=datos["cedula"].replace(/[^0-9]/g, '')
                ajax(data);
        }
    });


});

function validate(evt) {
  var theEvent = evt || window.event;
  var key = theEvent.keyCode || theEvent.which;
  key = String.fromCharCode( key );
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}

function utf8_decode(str_data) {
 
  var tmp_arr = [],
    i = 0,
    ac = 0,
    c1 = 0,
    c2 = 0,
    c3 = 0,
    c4 = 0;

  str_data += '';

  while (i < str_data.length) {
    c1 = str_data.charCodeAt(i);
    if (c1 <= 191) {
      tmp_arr[ac++] = String.fromCharCode(c1);
      i++;
    } else if (c1 <= 223) {
      c2 = str_data.charCodeAt(i + 1);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
      i += 2;
    } else if (c1 <= 239) {
      // http://en.wikipedia.org/wiki/UTF-8#Codepage_layout
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
      i += 3;
    } else {
      c2 = str_data.charCodeAt(i + 1);
      c3 = str_data.charCodeAt(i + 2);
      c4 = str_data.charCodeAt(i + 3);
      c1 = ((c1 & 7) << 18) | ((c2 & 63) << 12) | ((c3 & 63) << 6) | (c4 & 63);
      c1 -= 0x10000;
      tmp_arr[ac++] = String.fromCharCode(0xD800 | ((c1 >> 10) & 0x3FF));
      tmp_arr[ac++] = String.fromCharCode(0xDC00 | (c1 & 0x3FF));
      i += 4;
    }
  }
  return tmp_arr.join('');
}
function ajax(data){
   
    $.ajax({
        url:"./php/test.php?n="+data.data.nacionalidad+"&c="+data.data.cedula,
        async: true,
        data: data,
        dataType: "JSON",
        type: "GET",
        beforeSend: function (data){
            $('#myModal').foundation('reveal', 'open',{
              animation: 'fadeAndPop',
              animation_speed: 300,
              close_on_background_click: false,
              close_on_esc:false,
              dismiss_modal_class: 'close-reveal-modal',
              multiple_opened: false,
              bg_class: 'reveal-modal-bg',
              root_element: 'body',
              on_ajax_error: $.noop,
              bg : $('.reveal-modal-bg'),
              css : {
                open : {
                  'opacity': 0,
                  'visibility': 'visible',
                  'display' : 'block'
                },
                close : {
                  'opacity': 1,
                  'visibility': 'hidden',
                  'display': 'none'
                }
              }
            });
        },
        error: function (err) {
            error = err;
            console.log(error);
            alert(error.responseText);
        },
        success: function (data) {
            flag = 0;

            if (data.error==0){

                if (data.modo==1){
                    //console.log(data);
                    
                    $(".datos").show();
                    $("#datos_cedula").text(data.cedula);
                    $("#datos_nombre").text(utf8_decode(data.nombre));
                    $("#datos_estado").text(utf8_decode(data.estado));
                    $("#datos_municipio").text(utf8_decode(data.municipio));                  
                    $("#datos_parroquia").text(utf8_decode(data.parroquia));
                    $("#datos_centro").text(utf8_decode(data.centro));
                    $("#datos_direccion").text(utf8_decode(data.direccion));
                    $('#myModal').foundation('reveal', 'close') 
                }  
                else  {
                    flag = 1;
                }           
            }else{
                flag = 1;
            }

            if(flag ==1 ){
                $(".datos").hide();
                $('#myModal').foundation('reveal', 'close');
                alert("Esta Cédula no esta registrada en el CNE");
            }

        }
    });
}

