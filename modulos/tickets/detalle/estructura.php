<script>
    const appTicketModal = (function() {
        let g_id = 0;
        let donde = 0;
        let g_data;
        let opcionAnterior = 0;

        const public = {};

        public.open = async function(type, id) {
            await resetModal();
            g_id = id * 1;
            donde = type

            globalLlenarSelect.logisticas("cliente_mTicket")
            globalLlenarSelect.prioridades("prioridad_mTicket")
            globalLlenarSelect.desarrolladores("asignar_mTicket")
            globalLlenarSelect.tiposTickets("tipoTicket_mTicket")
            globalActivarAcciones.select2("select2_mTicket")

            if (type == 0) {
                // NUEVO TICKET
                $("#tituloModal_mTicket").text("Nuevo ticket");
                $("#subtitulo_mTicket").text("Creacion de ticket nuevo, completar formulario");
                $('.campos_mTicket').prop('disabled', false);
                $(".containersVerTicket_mTicket").addClass("ocultar");
                $("#asignadoPor_mTicket, #estado_mTicket").text("").addClass("ocultar")
                $("#containerBtnGuardar_mTicket").removeClass("ocultar");
                $("#container_mTicket").modal("show")
            } else {
                // VER TICKET
                await globalLoading.open()
                $("#tituloModal_mTicket").text(`Ticket N° ${id}`);
                $('.campos_mTicket').prop('disabled', true);
                $(".containersVerTicket_mTicket").removeClass("ocultar");
                $("#asignadoPor_mTicket, #estado_mTicket").text("").removeClass("ocultar")
                $("#containerBtnGuardar_mTicket").addClass("ocultar");
                if (appSistema.userPuesto.includes(1)) {
                    $(".containersDesarrollo_mTicket").removeClass("ocultar");
                    $(".containersSoporte_mTicket").addClass("ocultar");
                    $("#containerCliente_mTicket").removeClass("col-md-6 col-lg-6").addClass("col-md-12 col-lg-12")
                } else {
                    $(".containersSoporte_mTicket").removeClass("ocultar");
                    $(".containersDesarrollo_mTicket").addClass("ocultar");
                    $("#containerCliente_mTicket").removeClass("col-md-12 col-lg-12").addClass("col-md-6 col-lg-6")
                }
                getTicket()
            }

            globalActivarAcciones.tooltips("container_mTicket")

        }

        public.cerrarModal = function() {
            let huboCambios = false;
            const modalId = $("#container_mTicket");
            const modal = bootstrap.Modal.getInstance(modalId[0]) || new bootstrap.Modal(modalId[0]);

            if (donde == 0) {
                modalId.find(".campos_mTicket").each(function() {
                    valor = $(this).val()

                    if (valor) {
                        huboCambios = true;
                        return false;
                    }
                });

                if (huboCambios) {
                    globalSweetalert.confirmar(`¿Estás seguro de volver? Perderás los cambios`).then(function(confirmado) {
                        if (confirmado) {
                            modal.hide();
                        }
                    });
                } else {
                    modal.hide();
                }
            } else {
                modal.hide();
            }
        }


        function getTicket() {
            $.ajax({
                url: `${appSistema.urlServer}/tickets/${g_id}`,
                type: "GET",
                headers: {
                    Authorization: `Bearer ${appSistema.tkn}`
                },
                success: async function(result) {
                    if (result.success && result.body) {
                        g_data = result.body;
                        await llenarCampos()
                        await globalLoading.close()
                        await $("#container_mTicket").modal("show")
                    }
                },
                error: function(xhr) {
                    console.log("Error", xhr.responseText);
                    globalLoading.close()
                    globalSweetalert.error()
                }
            });
        }

        async function llenarCampos() {
            $("#btnCopiarTitulo_mTicket").html(`<button type="button" class="btn btn-icon rounded-pill btn-text-dark ms-1" onclick="appTicketModal.copiarTexto(event, 'Ticket N° ${g_data.id}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar"><i class="tf-icons ri-file-copy-line ri-22px"></i></button>`)
            $("#subtitulo_mTicket").text(`Fecha de creacion: ${globalFuncionesJs.formatearFecha(g_data.fecha_creacion)}`);

            if (g_data.quien) {
                htmlQuien = appSistema.usuarios.find(item => item.id == g_data.quien)?.nombre || "S/D"
                $("#asignadoPor_mTicket").text(`Asignado por: ${htmlQuien}`).removeClass("ocultar");
            }

            if (g_data.estado_ticket_id) {
                estado = appSistema.estadosTickets.find(item => item.id == g_data.estado_ticket_id) || "S/D"
                htmlEstado = `<span class="fs-6 fw-bold" style="color: ${estado["color"]  || "#6d6d6dff"};">${estado["nombre"].toUpperCase() || "S/D"}</span>`
                $("#modalContent_mTicket").css("borderTop", `5px solid ${estado["color"]}`).css("borderBottom", `5px solid ${estado["color"]}`)
                $("#estado_mTicket").html(htmlEstado).removeClass("ocultar");
            }

            $("#titulo_mTicket").val(g_data.titulo);
            if (g_data.logistica_id) {
                $("#cliente_mTicket").val(g_data.logistica_id).trigger("change");
                logistica = appSistema.logisticas.find(item => item.id == g_data.logistica_id)
                htmlLogistica = logistica.url_sistema ? `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="appTicketModal.copiarYRedirigir(event, '${logistica.password_soporte}', '${logistica.url_sistema}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar contraseña e ir a link"><i class="tf-icons ri-external-link-line ri-15px"></i></button>` : "";
                $("#btnAbrirSistema_mTicket").html(htmlLogistica).removeClass("ocultar")
            }

            $("#prioridad_mTicket").val(g_data.prioridad_ticket_id).trigger("change");

            if (g_data.prioridad_ticket_id == 5) globalLlenarSelect.boxStaff("asignar_mTicket")
            $("#asignar_mTicket").val(g_data.usuario_asignado_id).trigger("change");

            $("#fechaLimite_mTicket").val(globalFuncionesJs.formatearFechaParaDatetimeLocal(g_data.fecha_limite));
            $("#tipoTicket_mTicket").val(g_data.tipo_ticket_id).trigger("change");
            $("#descripcion_mTicket").val(g_data.descripcion);

            appTicketModal.renderFeedback()
            globalActivarAcciones.tooltips("container_mTicket");

        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab("tabs_mTicket")

            opcionAnterior = 0
            $(".campos_mTicket").val("")
            $("#btnCopiarTitulo_mTicket, #btnAbrirSistema_mTicket").empty()
            $("#asignadoPor_mTicket, #estado_mTicket").text("").addClass("ocultar")
            $(".containersBtnModificar_mTicket, #containerGeneralFeedback_mTicket, #containerBtnsFooter_mTicket").addClass("ocultar")
            $("#containerGeneralGeneral_mTicket").removeClass("col-lg-6").addClass("col-lg-12")
            $("#modalGeneral_mTicket").removeClass("modal-xl").addClass("modal-lg")
            $("#modalContent_mTicket").css("border", "0")


            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal("camposObli_mTicket")
            globalValidar.deshabilitarTiempoReal("camposObliFeedback_mTicket")
        };

        public.onChangePrioridad = function(opcion) {
            const opcionSeleccionada = opcion.value

            if (!appSistema.userPuesto.includes(5) && opcionSeleccionada == 5 && opcionAnterior != 5) {
                globalLlenarSelect.boxStaff("asignar_mTicket")
                cambiarFechaLimite(48)
            } else if (opcionAnterior == 5) {
                globalLlenarSelect.desarrolladores("asignar_mTicket")
                prioridad = appSistema.prioridades.find(item => item.id == opcionSeleccionada)
                cambiarFechaLimite(prioridad.tiempo_estimado_horas)
            } else {
                prioridad = appSistema.prioridades.find(item => item.id == opcionSeleccionada)
                cambiarFechaLimite(prioridad.tiempo_estimado_horas)
            }

            if (opcionSeleccionada == "" || opcionSeleccionada == 1) {
                $("#containerPrioridad_mTicket").removeClass("col-md-6 col-lg-6").addClass("col-md-12 col-lg-12")
                $("#containerFechaLimite_mTicket").addClass("ocultar")
                $("#fechaLimite_mTicket").val("")
            } else {
                $("#containerPrioridad_mTicket").removeClass("col-md-12 col-lg-12").addClass("col-md-6 col-lg-6")
                $("#containerFechaLimite_mTicket").removeClass("ocultar")
            }

            opcionAnterior = opcionSeleccionada
        }

        function cambiarFechaLimite(horasSumadas) {
            let fecha = new Date();

            fecha.setHours(fecha.getHours() + horasSumadas);

            let año = fecha.getFullYear();
            let mes = String(fecha.getMonth() + 1).padStart(2, "0");
            let dia = String(fecha.getDate()).padStart(2, "0");
            let horas = String(fecha.getHours()).padStart(2, "0");
            let minutos = String(fecha.getMinutes()).padStart(2, "0");

            let fechaFormateada = `${año}-${mes}-${dia}T${horas}:${minutos}`;

            $(`#fechaLimite_mTicket`).val(fechaFormateada);
        }


        public.renderCambioEstado = function(type) {

            $(".camposFeedback_mTicket").removeClass("camposObliFeedback_mTicket")

            buffer = ""
            buffer = `<div class="row justify-content-end g-3">`

            buffer += `<div class="col-12 col-md-12 col-lg-3">`
            buffer += `<button type="button" class="btn btn-outline-danger w-100" onclick="appTicketModal.cancelarCambioEstado()">Cancelar</button>`
            buffer += `</div>`

            switch (type) {
                case 1:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-warning waves-effect w-100" onclick="appTicketModal.cambiarEstado(2)">`
                    buffer += `<span class="tf-icons ri-delete-back-2-line ri-16px me-2"></span>Desestimar`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerDevolucion_mTicket").removeClass("ocultar")
                    $("#containerFeedback_mTicket, #containerQueHice_mTicket").addClass("ocultar")
                    $("#devolucion_mTicket").addClass("camposObliFeedback_mTicket")
                    break;
                case 2:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-success waves-effect w-100" onclick="appTicketModal.cambiarEstado(3)">`
                    buffer += `<span class="tf-icons ri-check-line ri-16px me-2"></span>Ticket resuelto`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerDevolucion_mTicket, #containerQueHice_mTicket").removeClass("ocultar")
                    $("#containerFeedback_mTicket").addClass("ocultar")
                    $("#devolucion_mTicket, #queHice_mTicket").addClass("camposObliFeedback_mTicket")
                    break;
                case 3:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-info waves-effect w-100" onclick="appTicketModal.cambiarEstado(4)">`
                    buffer += `<span class="tf-icons ri-check-double-line ri-16px me-2"></span>Cerrar ticket`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerFeedback_mTicket").removeClass("ocultar")
                    $("#feedback_mTicket").addClass("camposObliFeedback_mTicket")
                    break;
            }

            buffer += `</div>`

            $(".containersVerTicket_mTicket").addClass("ocultar")
            $("#containerBtnsFooter_mTicket").html(buffer).removeClass("ocultar")
            $("#containerGeneralGeneral_mTicket").removeClass("col-lg-12").addClass("col-lg-6")
            $("#modalGeneral_mTicket").removeClass("modal-lg").addClass("modal-xl")
            if (g_data.estado_ticket_id == 1) {
                $("#containerGeneralFeedback_mTicket").removeClass("ocultar")
            }
        }

        public.renderFeedback = function() {
            const comentarios = g_data.comentarios || [];

            // Reset general
            $("#containerGeneralGeneral_mTicket").removeClass("col-lg-12").addClass("col-lg-6");
            $("#modalGeneral_mTicket").removeClass("modal-lg").addClass("modal-xl");
            $(".camposFeedback_mTicket").val("").prop('disabled', false);

            // ===================
            // BLOQUE SOPORTE
            // ===================
            if (vistaPorPuesto.ver("soporte")) {
                $(".containersSoporte_mTicket").removeClass("ocultar");
                $("#containerQueHice_mTicket").addClass("ocultar");

                const devolucion = comentarios.find(c => c.tipo_comentario == 2)?.contenido || "";

                switch (g_data.estado_ticket_id) {
                    case 1:
                        $("#containerBtnsFooter_mTicket, #containerGeneralFeedback_mTicket, #btnCerrarTicket_mTicket").addClass("ocultar");
                        $("#btnEliminarTicket_mTicket, #btnEditarTicket_mTicket").removeClass("ocultar");
                        $("#containerGeneralGeneral_mTicket").removeClass("col-lg-6").addClass("col-lg-12");
                        $("#modalGeneral_mTicket").removeClass("modal-xl").addClass("modal-lg");
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#containerBtnsFooter_mTicket, #btnEliminarTicket_mTicket, #btnEditarTicket_mTicket, .containersInputFeedback_mTicket").addClass("ocultar");
                        $("#containerGeneralFeedback_mTicket, #containerDevolucion_mTicket, #btnCerrarTicket_mTicket").removeClass("ocultar");
                        $("#devolucion_mTicket").val(devolucion).prop('disabled', true);

                        if (g_data.estado_ticket_id == 4) {
                            $("#btnCerrarTicket_mTicket").addClass("ocultar")
                            $("#containerFeedback_mTicket").removeClass("ocultar")
                            const feedback = comentarios.find(c => c.tipo_comentario == 4)?.contenido || "";
                            $("#feedback_mTicket").val(feedback).prop('disabled', true);
                        }
                        break;
                }

            } else {
                $(".containersSoporte_mTicket").addClass("ocultar");
            }

            // ===================
            // BLOQUE DESARROLLO
            // ===================
            if (vistaPorPuesto.ver("desarrollo")) {
                $(".containersDesarrollo_mTicket").removeClass("ocultar");

                const devolucion = comentarios.find(c => c.tipo_comentario == 2)?.contenido || "";
                const queHice = comentarios.find(c => c.tipo_comentario == 3)?.contenido || "";

                switch (g_data.estado_ticket_id) {
                    case 1:
                        $("#containerBtnsFooter_mTicket, #containerGeneralFeedback_mTicket").addClass("ocultar");
                        $("#containerGeneralGeneral_mTicket").removeClass("col-lg-6").addClass("col-lg-12");
                        $("#modalGeneral_mTicket").removeClass("modal-xl").addClass("modal-lg");
                        break;
                    case 2:
                        $("#containerBtnsFooter_mTicket, .containersInputFeedback_mTicket, .containersVerTicket_mTicket").addClass("ocultar");
                        $("#containerGeneralFeedback_mTicket, #containerDevolucion_mTicket").removeClass("ocultar");
                        $("#devolucion_mTicket").val(devolucion).prop('disabled', true);
                        break;
                    case 3:
                        $("#containerBtnsFooter_mTicket, .containersInputFeedback_mTicket, .containersVerTicket_mTicket").addClass("ocultar");
                        $("#containerGeneralFeedback_mTicket, #containerDevolucion_mTicket, #containerQueHice_mTicket").removeClass("ocultar");
                        $("#devolucion_mTicket").val(devolucion).prop('disabled', true);
                        $("#queHice_mTicket").val(queHice).prop('disabled', true);
                        break;
                    case 4:
                        $("#containerBtnsFooter_mTicket, .containersInputFeedback_mTicket, .containersVerTicket_mTicket").addClass("ocultar");
                        $("#containerGeneralFeedback_mTicket, #containerDevolucion_mTicket").removeClass("ocultar");
                        $("#devolucion_mTicket").val(devolucion).prop('disabled', true);

                        if (queHice) {
                            $("#containerQueHice_mTicket").removeClass("ocultar");
                            $("#queHice_mTicket").val(queHice).prop('disabled', true);
                        } else {
                            $("#containerQueHice_mTicket").addClass("ocultar");
                        }
                        break;
                }

            } else {
                $(".containersDesarrollo_mTicket").addClass("ocultar");
            }
        }


        public.editarTicket = function(type = 0) {
            if (type == 0) {
                $('.campos_mTicket').prop('disabled', false);
                $(".containersVerTicket_mTicket, #btnAbrirSistema_mTicket").addClass("ocultar")
                $(".containersBtnModificar_mTicket").removeClass("ocultar")
                $("#btnCopiarTitulo_mTicket, #btnAbrirSistema_mTicket").empty()

            } else {
                if (type == 2) {
                    llenarCampos()
                    globalValidar.limpiarTodas()
                    globalValidar.deshabilitarTiempoReal("camposObli_mTicket")
                    $("#btnAbrirSistema_mTicket").removeClass("ocultar")
                }
                $('.campos_mTicket').prop('disabled', true);
                $(".containersBtnModificar_mTicket").addClass("ocultar")
                $(".containersSoporte_mTicket").removeClass("ocultar")
            }
        }

        function validacion() {
            return globalValidar.obligatorios("camposObli_mTicket")
        }

        public.guardar = function() {
            const datos = {
                "titulo": $("#titulo_mTicket").val(),
                "fecha_limite": $("#fechaLimite_mTicket").val() ? $("#fechaLimite_mTicket").val().replace("T", " ") + ":00" : null,
                "logistica_id": $("#cliente_mTicket").val() * 1,
                "prioridad_ticket_id": $("#prioridad_mTicket").val() * 1,
                "tipo_ticket_id": $("#tipoTicket_mTicket").val() * 1,
                "usuario_asignado_id": $("#asignar_mTicket").val() * 1,
                "descripcion": $("#descripcion_mTicket").val(),
                "quien": appSistema.userId
            };

            globalValidar.habilitarTiempoReal("camposObli_mTicket", validacion)

            if (validacion()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            globalSweetalert.confirmar("¿Estas seguro de guardar este ticket?").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/tickets`,
                        type: "POST",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            globalLoading.close()
                            if (result.success) {
                                $("#container_mTicket").modal("hide")
                                nroTicket = result.body
                                buffer = `<button type="button" class="btn rounded-pill btn-label-success waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar" onclick="navigator.clipboard.writeText('${nroTicket}')"><span class="tf-icons ri-file-copy-line ri-16px me-2"></span>Tiket N° ${nroTicket}</button>`
                                globalSweetalert.html("Ticket guardado con exito!", "", buffer)
                                globalActivarAcciones.tooltips("swal2-html-container")

                                appTicketListado.getListado();
                            } else {
                                globalSweetalert.alert(result.message)
                            }
                        },
                        error: function(xhr) {
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });

                }
            })
        };

        public.editar = function() {
            const datosNuevos = {
                "titulo": $("#titulo_mTicket").val(),
                "fecha_limite": $("#fechaLimite_mTicket").val() ? $("#fechaLimite_mTicket").val().replace("T", " ") + ":00" : null,
                "logistica_id": $("#cliente_mTicket").val() * 1,
                "prioridad_ticket_id": $("#prioridad_mTicket").val() * 1,
                "tipo_ticket_id": $("#tipoTicket_mTicket").val() * 1,
                "usuario_asignado_id": $("#asignar_mTicket").val() * 1,
                "descripcion": $("#descripcion_mTicket").val(),
            };

            globalValidar.habilitarTiempoReal("camposObli_mTicket", validacion)

            if (validacion()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            const datosModificados = {};
            Object.keys(datosNuevos).forEach(key => {
                if (datosNuevos[key] != g_data[key]) {
                    datosModificados[key] = datosNuevos[key];
                }
            });

            if (Object.keys(datosModificados).length == 0) {
                globalSweetalert.alert("No se realizaron cambios")
                return;
            }

            globalSweetalert.confirmar("¿Estas seguro de modificar este ticket?").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/tickets/${g_id}`,
                        type: "PUT",
                        contentType: "application/json",
                        data: JSON.stringify(datosModificados),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            globalLoading.close()
                            if (result.success) {
                                globalSweetalert.exito()
                                appTicketModal.editarTicket(1)
                                appTicketListado.getListado();
                            } else {
                                globalSweetalert.alert(result.message)
                            }
                        },
                        error: function(xhr) {
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });
                }
            })
        };

        function validacionFeedback() {
            return globalValidar.obligatorios("camposObliFeedback_mTicket")
        }

        public.cambiarEstado = function(estado) {
            const datos = {
                "estado_ticket_id": estado,
                "comentarios": []
            };

            $(".camposObliFeedback_mTicket").each(function() {
                datos.comentarios.push({
                    "usuario_id": appSistema.userId,
                    "tipo_comentario": $(this).data("tipocomentario") * 1,
                    "contenido": $(this).val()
                });
            });

            globalValidar.habilitarTiempoReal("camposObliFeedback_mTicket", validacionFeedback)

            if (validacionFeedback()) {
                globalSweetalert.alert("Verifique los campos")
                return
            }

            mensaje = estado == 2 ? "desestimado" : estado == 3 ? "resuelto" : "cerrado"

            globalSweetalert.confirmar(`¿Estas seguro de marcar este ticket como ${mensaje}?`).then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/tickets/${g_id}/estado`,
                        type: "PUT",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            globalLoading.close()
                            if (result.success) {
                                $("#container_mTicket").modal("hide")
                                globalSweetalert.exito(`Ticket ${mensaje} con exito!`)
                                appTicketListado.getListado();
                            } else {
                                globalSweetalert.alert(result.message)
                            }
                        },
                        error: function(xhr) {
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });
                }
            })
        };

        public.cancelarCambioEstado = function() {
            globalValidar.limpiarTodas();
            globalValidar.deshabilitarTiempoReal("camposObliFeedback_mTicket");
            $(".camposObliFeedback_mTicket").val("");
            $(".containersInputFeedback_mTicket:has(.camposObliFeedback_mTicket), #containerBtnsFooter_mTicket").addClass("ocultar");

            if (vistaPorPuesto.ver("desarrollo")) {
                $(".containersDesarrollo_mTicket").removeClass("ocultar");
            } else {
                $(".containersDesarrollo_mTicket").addClass("ocultar");
            }

            if (vistaPorPuesto.ver("soporte")) {
                $(".containersSoporte_mTicket").removeClass("ocultar");
            } else {
                $(".containersSoporte_mTicket").addClass("ocultar");
            }

            if (g_data.estado_ticket_id == 1) {
                $("#containerGeneralFeedback_mTicket").addClass("ocultar");
                $("#containerGeneralGeneral_mTicket").removeClass("col-lg-6").addClass("col-lg-12");
                $("#modalGeneral_mTicket").removeClass("modal-xl").addClass("modal-lg");
            }
        }


        public.eliminar = function() {
            globalSweetalert.confirmar("¿Estas seguro de eliminar este ticket?", "var(--bs-danger)").then(function(confirmado) {
                if (confirmado) {
                    globalLoading.open()
                    $.ajax({
                        url: `${appSistema.urlServer}/tickets/${g_id}`,
                        type: "DELETE",
                        contentType: "application/json",
                        data: JSON.stringify(datos),
                        headers: {
                            Authorization: `Bearer ${appSistema.tkn}`
                        },
                        success: function(result) {
                            globalLoading.close()
                            $("#container_mTicket").modal("hide")
                            globalSweetalert.exito("Eliminado con exito!")
                            appTicketListado.getListado();
                        },
                        error: function(xhr) {
                            console.log("Error al guardar", xhr.responseText);
                            globalLoading.close()
                            globalSweetalert.error()
                        }
                    });

                }
            })
        };

        public.copiarTexto = function(e, texto) {
            e.stopPropagation();
            navigator.clipboard.writeText(texto)
        }

        public.copiarYRedirigir = function(e, password, url) {
            e.stopPropagation();
            navigator.clipboard.writeText(password)
            window.open(url, "_blank");
        }

        return public;
    })();
</script>