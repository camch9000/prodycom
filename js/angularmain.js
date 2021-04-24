var cprodycom = angular.module('prodycomApp',[]);

cprodycom.controller('web_controller', function($scope)
{
    $scope.safeApply = function(fn) 
    {
        var phase = this.$root.$$phase;
        if(phase == '$apply' || phase == '$digest') {
          if(fn && (typeof(fn) === 'function')) {
            fn();
          }
        } else {
          this.$apply(fn);
		}
    };

    $scope.init = function()
    {
        $scope.mensaje = {
            nombre: "",
            email: "",
            telefono: "",
            mensaje: ""
        };

        $scope.safeApply(function(){});
    };

    $scope.enviarMensaje = function(mensaje)
    {
        if(mensaje != undefined && 
            mensaje.mensaje != undefined && mensaje.mensaje != "" &&
            mensaje.nombre != undefined && mensaje.nombre != "" &&
            (
                (mensaje.email != undefined && mensaje.email != "" && $scope.isValidEmailAddress(mensaje.email)) || 
                (mensaje.telefono != undefined && mensaje.telefono != "" && mensaje.telefono.length >= 8 && mensaje.telefono.length <= 12)
            )
        )
        {
            if(mensaje.email == undefined || mensaje.email == "")
                email = ""
            else
                email = mensaje.email;

            if(mensaje.telefono == undefined || mensaje.telefono == "")
                telefono = ""
            else
                telefono = mensaje.telefono;

            $.ajax({
                url: configuration["serverLink"],
                data: {
                    NOMBRE: mensaje.nombre,
                    EMAIL: email,
                    TELEFONO: telefono,
                    MENSAJE: mensaje.mensaje,
                    OPTION: "1"
                        },
                    type: 'POST',                                
                    success: function(response)
                    {
                        if(response.status == 0)
                        {        
                            $scope.mensaje = {
                                nombre: "",
                                email: "",
                                telefono: "",
                                mensaje: ""
                            };

                            swal("MENSAJE ENVIADO", "Su mensaje ha sido enviado, nos pondremos en contacto contigo lo antes posible.", "success");

                            $scope.safeApply(function(){});
                        }
                        else
                        {
                            swal("Mensaje no enviado", "Ha habido un problema, vuelve a intentarlo o contacta con nosotros a través de nuestros télefonos o email", "error");
                            $scope.safeApply(function(){});
                        }
                    },
                    error: function(xhr, status, error) 
                    {
                        console.log("GET DATA FROM LOGIN --> " + xhr.status + ": " + xhr.responseText);
                    }
                });
            }
            else
            {
                swal("Formulario incompleto", "Debe ingresar todos los datos para poder enviar el mensaje", "warning");
            }
    };
});