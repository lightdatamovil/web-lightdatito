<script>
    const appTicketNuevo = (function() {
        let g_data;

        const public = {};

        public.open = function() {
            $(".winapp").hide();
            appTicketNuevo.limpiarCampos()
            $("#container_ticketNuevo").show();
            globalLlenarSelect.logisticas("cliente_ticketNuevo")
            globalLlenarSelect.prioridades("prioridad_ticketNuevo")
            globalLlenarSelect.desarrolladores("asignar_ticketNuevo")
            globalActivarAcciones.filtrarConEnter("inputs_ticketNuevo", () => appTicketNuevo.crearTicket())
        };

        public.limpiarCampos = function() {
            $(".campos_ticketNuevo").val("")

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal("camposObli_ticketNuevo")
        };

        function validacion() {
            faltanCampos = false

            $(".camposObli_ticketNuevo").each(function() {
                if (globalValidar.vacio(this["id"])) faltanCampos = true;
            });

            return faltanCampos
        }

        public.crearTicket = function() {
            const parametros = {
                "fecha": $("#fecha_ticketNuevo").val(),
                "titulo": $("#titulo_ticketNuevo").val(),
                "cliente": $("#cliente_ticketNuevo").val(),
                "prioridad": $("#prioridad_ticketNuevo").val(),
                "asignar": $("#asignar_ticketNuevo").val(),
                "descripcion": $("#descripcion_ticketNuevo").val(),
            };

            globalValidar.habilitarTiempoReal("camposObli_ticketNuevo", validacion)

            if (validacion()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            console.log("parametros", parametros);
            globalSweetalert.confirmar("¿Estas seguro de crear este ticket?").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open();

                    // $.ajax({
                    //     url: `${appSistema.urlServer}/tickets`,
                    //     type: "POST",
                    //     data: JSON.stringify(parametros),
                    //     contentType: "application/json",
                    //     headers: {
                    //         Authorization: `Bearer ${appSistema.tkn}`
                    //     },
                    //     success: function(result) {
                    //         g_data = result;
                    setTimeout(() => {
                        globalLoading.close();
                        //         if (g_data.estado) {
                        globalSweetalert.exito("Ticket creado correctamente");
                        appTicketNuevo.limpiarCampos();
                    }, 1000);
                    // } else {
                    //     globalSweetalert.error(g_data.mensaje || "Error al crear el ticket");
                    // }
                    //     },
                    //     error: function() {
                    //         globalSweetalert.error();
                    //         globalLoading.close();
                    //     }
                    // });
                }
            })
        };

        return public;
    })();
</script>