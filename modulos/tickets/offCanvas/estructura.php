<script>
    const appOffCanvasTicket = (function() {

        const public = {}

        public.open = async function({
            mode
        }) {
            await reset()
            await render(mode)
            await globalActivarAcciones.toggleOffcanvas({
                id: "offCanvas_oTickets"
            })
        }

        function reset() {
            $(".containerInput_oTickets, .btn_oTickets").addClass("ocultar")
            $(".inputs_oTickets").val("")

            globalValidar.deshabilitarTiempoReal({
                className: "camposObliFeedback_oTickets"
            })
        }

        function render(mode) {
            switch (mode) {
                case 1:
                    $("#containerDevolucion_oTickets, #containerQueHice_oTickets").removeClass("ocultar").addClass("camposObliFeedback_oTickets")
                    $("#btnResolver_oTickets").removeClass("ocultar")
                    $("#devolucion_oTickets").css("height", "250px")
                    break;
                case 2:
                    $("#containerDevolucion_oTickets").removeClass("ocultar").addClass("camposObliFeedback_oTickets")
                    $("#btnDesestimar_oTickets").removeClass("ocultar")
                    $("#devolucion_oTickets").css("height", "500px")
                    break;
                case 3:
                    $("#containerFeedback_oTickets").removeClass("ocultar").addClass("camposObliFeedback_oTickets")
                    $("#btnCerrar_oTickets").removeClass("ocultar")

                    break;
                case 4:
                    $("#containerDevolver_oTickets").removeClass("ocultar").addClass("camposObliFeedback_oTickets")
                    $("#btnDevolver_oTickets").removeClass("ocultar")
                    break;

                default:
                    break;
            }
        }

        function validacionFeedback() {
            return globalValidar.obligatorios({
                className: "camposObliFeedback_oTickets"
            })
        }

        public.cambiarEstado = function(estado) {
            const datos = {
                "estado_ticket_id": estado,
                "comentarios": []
            };

            $(".camposObliFeedback_oTickets").each(function() {
                datos.comentarios.push({
                    "usuario_id": appSistema.userId,
                    "tipo_comentario": $(this).data("tipocomentario") * 1,
                    "contenido": $(this).val()
                });
            });

            globalValidar.habilitarTiempoReal({
                className: "camposObliFeedback_oTickets",
                callback: validacionFeedback
            })

            if (validacionFeedback()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                })
                return
            }

            menseje = {
                1: "¿Estas seguro de devolver este ticket al desarrollador?",
                2: "¿Estas seguro de marcar este ticket como resuelto?",
                3: "¿Estas seguro de desestimar este ticket?",
                4: "¿Estas seguro de cerrar este ticket?"
            }

            globalSweetalert.confirmar({
                    titulo: mensaje[estado]
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}/estado`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mTickets").modal("hide")
                                globalSweetalert.exito({
                                    titulo: `Estado actualizado con exito!`
                                })
                                appModuloTickets.getListado();
                            }
                        });
                    }
                });
        };

        return public
    })()
</script>