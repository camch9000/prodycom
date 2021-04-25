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

    $scope.enviarMensaje = function(e)
    {
        e.preventDefault();

        if($scope.mensaje != null && 
            $scope.mensaje.mensaje != null && $scope.mensaje.mensaje.trim() != "" &&
            $scope.mensaje.nombre != null && $scope.mensaje.nombre.trim() != "" &&
            (
                ($scope.mensaje.email != null && $scope.mensaje.email.trim() != "" && $scope.isValidEmailAddress($scope.mensaje.email)) || 
                ($scope.mensaje.telefono != null && $scope.mensaje.telefono.trim() != "" && $scope.mensaje.telefono.length >= 8 && $scope.mensaje.telefono.length <= 12)
            )
        )
        {
            if($scope.mensaje.email == null || $scope.mensaje.email.trim() == "")
                email = ""
            else
                email = $scope.mensaje.email;

            if($scope.mensaje.telefono == null || $scope.mensaje.telefono.trim() == "")
                telefono = ""
            else
                telefono = $scope.mensaje.telefono;

            $.ajax({
                url: "https://venus.softlab.uc3m.es/prodycom_web/server/control.php",
                data: {
                        NOMBRE: $scope.mensaje.nombre,
                        EMAIL: email,
                        TELEFONO: telefono,
                        MENSAJE: $scope.mensaje.mensaje,
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
                        console.log("Enviando mensaje --> " + xhr.status + ": " + xhr.responseText);
                    }
                });
            }
            else
            {
                swal("Formulario incompleto", "Debe ingresar todos los datos para poder enviar el mensaje", "warning");
            }
    };

    $scope.isValidEmailAddress = function(emailAddress)
    {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    }
});