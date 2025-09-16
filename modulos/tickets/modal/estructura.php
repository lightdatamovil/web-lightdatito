<script>
    const appModalTickets = (function() {
        let g_did = 0;
        let g_data;
        let donde = 0;
        let opcionAnterior = 0;
        const rutaAPI = "tickets"

        const public = {};

        public.open = async function({
            mode = 0,
            did = 0
        } = {}) {
            await resetModal();
            g_did = did * 1;
            donde = mode

            await globalLlenarSelect.clientes({
                id: "cliente_mTickets",
                multiple: true
            })
            $("#cliente_mTickets").prepend('<option value="todos">Todos</option>');
            await globalLlenarSelect.prioridades({
                id: "prioridad_mTickets"
            })
            await globalLlenarSelect.desarrolladores({
                id: "asignar_mTickets"
            })

            await globalLlenarSelect.usuarios({
                id: "observadores_mTickets",
                multiple: true
            })
            await globalLlenarSelect.tiposTickets({
                id: "tipoTicket_mTickets"
            })
            await globalActivarAcciones.select2({
                className: "select2_mTickets"
            })

            if (mode == 0) {
                // NUEVO TICKET
                $("#tituloModal_mTickets").text("Nuevo ticket");
                $("#subtitulo_mTickets").text("Creacion de ticket nuevo, completar formulario");
                $('.campos_mTickets').prop('disabled', false);
                $(".containersVerTicket_mTickets").addClass("ocultar");
                $("#asignadoPor_mTickets, #estado_mTickets").text("").addClass("ocultar")
                $("#containerBtnGuardar_mTickets").removeClass("ocultar");
                $("#modal_mTickets").modal("show")
            } else {
                // VER TICKET
                await globalLoading.open()
                $("#tituloModal_mTickets").text(`Ticket N° ${did}`);
                $('.campos_mTickets').prop('disabled', true);
                $(".containersVerTicket_mTickets").removeClass("ocultar");
                $("#asignadoPor_mTickets, #estado_mTickets").text("").removeClass("ocultar")
                $("#containerBtnGuardar_mTickets").addClass("ocultar");
                if (appSistema.userPuesto.includes(1)) {
                    $(".containersDesarrollo_mTickets").removeClass("ocultar");
                    $(".containersSoporte_mTickets").addClass("ocultar");
                } else {
                    $(".containersSoporte_mTickets").removeClass("ocultar");
                    $(".containersDesarrollo_mTickets").addClass("ocultar");
                }
                await get()
            }

            globalActivarAcciones.tooltips({
                idContainer: "modal_mTickets"
            })
        }

        public.manejarSelectTodos = function(select) {
            let valores = Array.from(select.value ? $(select).val() : []);

            console.log(valores);


            if (valores.includes("todos") && valores.length > 1) {
                // Si está "todos" junto con otras, dejar solo "todos"
                $(select).val(["todos"]).trigger("change.select2");
            } else if (valores.length > 1 && valores.includes("todos")) {
                // Si elegiste otra opción, quitar "todos"
                $(select).val(valores.filter(v => v !== "todos")).trigger("change.select2");
            }
        }


        public.cerrarModal = function() {
            let huboCambios = false;
            const modalId = $("#modal_mTickets");
            const modal = bootstrap.Modal.getInstance(modalId[0]) || new bootstrap.Modal(modalId[0]);

            if (donde == 0) {
                modalId.find(".campos_mTickets").each(function() {
                    valor = $(this).val()

                    if (valor) {
                        huboCambios = true;
                        return false;
                    }
                });

                if (huboCambios) {
                    globalSweetalert.confirmar({
                        titulo: `¿Estás seguro de volver? Perderás los cambios`
                    }).then(function(confirmado) {
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

        function get() {
            globalRequest.get(`/${rutaAPI}/${g_did}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    llenarCampos()
                    globalLoading.close()
                    $("#modal_mTickets").modal("show")
                }
            });
        }

        async function llenarCampos() {
            $("#btnCopiarTitulo_mTickets").html(`<button type="button" class="btn btn-icon rounded-pill btn-text-dark ms-1" onclick="appModalTickets.copiarTexto(event, 'Ticket N° ${g_data.id}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar"><i class="tf-icons ri-file-copy-line ri-22px"></i></button>`)
            $("#subtitulo_mTickets").text(`Fecha de creacion: ${globalFuncionesJs.formatearFecha({fecha: g_data.fecha_creacion})}`);

            if (g_data.quien) {
                htmlQuien = appSistema.usuarios.find(item => item.id == g_data.quien)?.nombre || "S/D"
                $("#asignadoPor_mTickets").text(`Asignado por: ${htmlQuien}`).removeClass("ocultar");
            }

            if (g_data.estado_ticket_id) {
                estado = appSistema.estadosTickets.find(item => item.id == g_data.estado_ticket_id) || "S/D"
                htmlEstado = `<span class="fs-6 fw-bold" style="color: ${estado["color"]  || "#6d6d6dff"};">${estado["nombre"].toUpperCase() || "S/D"}</span>`
                $("#modalContent_mTickets").css("borderTop", `5px solid ${estado["color"]}`).css("borderBottom", `5px solid ${estado["color"]}`)
                $("#estado_mTickets").html(htmlEstado).removeClass("ocultar");
            }

            $("#titulo_mTickets").val(g_data.titulo);
            if (g_data.cliente_id) {
                $("#cliente_mTickets").val(g_data.cliente_id).trigger("change");
                cliente = appSistema.clientes.find(item => item.id == g_data.cliente_id)
                htmlCliente = cliente.url_sistema ? `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="appModalTickets.copiarYRedirigir(event, '${cliente.password_soporte}', '${cliente.url_sistema}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar contraseña e ir a link"><i class="tf-icons ri-external-link-line ri-15px"></i></button>` : "";
                $("#btnAbrirSistema_mTickets").html(htmlCliente).removeClass("ocultar")
            }

            $("#prioridad_mTickets").val(g_data.prioridad_ticket_id).trigger("change");

            if (g_data.prioridad_ticket_id == 5) globalLlenarSelect.boxStaff({
                id: "asignar_mTickets"
            })
            $("#asignar_mTickets").val(g_data.usuario_asignado_id).trigger("change");

            $("#fechaLimite_mTickets").val(globalFuncionesJs.formatearFechaParaDatetimeLocal({
                fecha: g_data.fecha_limite
            }));
            $("#tipoTicket_mTickets").val(g_data.tipo_ticket_id).trigger("change");
            $("#descripcion_mTickets").val(g_data.descripcion);

            appModalTickets.renderFeedback()

            globalActivarAcciones.tooltips({
                idContainer: "modal_mTickets"
            })

        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mTickets"
            })

            opcionAnterior = 0
            $(".campos_mTickets").val("")
            $("#btnCopiarTitulo_mTickets, #btnAbrirSistema_mTickets").empty()
            $("#asignadoPor_mTickets, #estado_mTickets").text("").addClass("ocultar")
            $(".containersBtnModificar_mTickets, #containerGeneralFeedback_mTickets, #containerBtnsFooter_mTickets").addClass("ocultar")
            $("#containerGeneralGeneral_mTickets").removeClass("col-lg-6").addClass("col-lg-12")
            $("#modalGeneral_mTickets").removeClass("modal-xl").addClass("modal-lg")
            $("#modalContent_mTickets").css("border", "0")


            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mTickets"
            })
            globalValidar.deshabilitarTiempoReal({
                className: "camposObliFeedback_mTickets"
            })
        };

        public.onChangePrioridad = function(opcion) {
            const opcionSeleccionada = opcion.value

            if (!appSistema.userPuesto.includes(5) && opcionSeleccionada == 5 && opcionAnterior != 5) {
                globalLlenarSelect.boxStaff({
                    id: "asignar_mTickets"
                })
                cambiarFechaLimite(48)
            } else if (opcionAnterior == 5) {
                globalLlenarSelect.desarrolladores({
                    id: "asignar_mTickets"
                })
                prioridad = appSistema.prioridades.find(item => item.id == opcionSeleccionada)
                cambiarFechaLimite(prioridad.tiempo_estimado_horas)
            } else {
                prioridad = appSistema.prioridades.find(item => item.id == opcionSeleccionada)
                cambiarFechaLimite(prioridad.tiempo_estimado_horas)
            }

            if (opcionSeleccionada == "" || opcionSeleccionada == 1) {
                $("#containerPrioridad_mTickets").removeClass("col-md-6 col-lg-6").addClass("col-md-12 col-lg-12")
                $("#containerFechaLimite_mTickets").addClass("ocultar")
                $("#fechaLimite_mTickets").val("")
            } else {
                $("#containerPrioridad_mTickets").removeClass("col-md-12 col-lg-12").addClass("col-md-6 col-lg-6")
                $("#containerFechaLimite_mTickets").removeClass("ocultar")
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

            $(`#fechaLimite_mTickets`).val(fechaFormateada);
        }


        public.renderCambioEstado = function(type) {

            $(".camposFeedback_mTickets").removeClass("camposObliFeedback_mTickets")

            buffer = ""
            buffer = `<div class="row justify-content-end g-3">`

            buffer += `<div class="col-12 col-md-12 col-lg-3">`
            buffer += `<button type="button" class="btn btn-outline-danger w-100" onclick="appModalTickets.cancelarCambioEstado()">Cancelar</button>`
            buffer += `</div>`

            switch (type) {
                case 1:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-warning waves-effect w-100" onclick="appModalTickets.cambiarEstado(2)">`
                    buffer += `<span class="tf-icons ri-delete-back-2-line ri-16px me-2"></span>Desestimar`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerDevolucion_mTickets").removeClass("ocultar")
                    $("#containerFeedback_mTickets, #containerQueHice_mTickets").addClass("ocultar")
                    $("#devolucion_mTickets").addClass("camposObliFeedback_mTickets")
                    break;
                case 2:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-success waves-effect w-100" onclick="appModalTickets.cambiarEstado(3)">`
                    buffer += `<span class="tf-icons ri-check-line ri-16px me-2"></span>Ticket resuelto`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerDevolucion_mTickets, #containerQueHice_mTickets").removeClass("ocultar")
                    $("#containerFeedback_mTickets").addClass("ocultar")
                    $("#devolucion_mTickets, #queHice_mTickets").addClass("camposObliFeedback_mTickets")
                    break;
                case 3:
                    buffer += `<div class="col-12 col-md-12 col-lg-4">`
                    buffer += `<button type="button" class="btn btn-label-info waves-effect w-100" onclick="appModalTickets.cambiarEstado(4)">`
                    buffer += `<span class="tf-icons ri-check-double-line ri-16px me-2"></span>Cerrar ticket`
                    buffer += `</button>`
                    buffer += `</div>`
                    $("#containerFeedback_mTickets").removeClass("ocultar")
                    $("#feedback_mTickets").addClass("camposObliFeedback_mTickets")
                    break;
            }

            buffer += `</div>`

            $(".containersVerTicket_mTickets").addClass("ocultar")
            $("#containerBtnsFooter_mTickets").html(buffer).removeClass("ocultar")
            $("#containerGeneralGeneral_mTickets").removeClass("col-lg-12").addClass("col-lg-6")
            $("#modalGeneral_mTickets").removeClass("modal-lg").addClass("modal-xl")
            if (g_data.estado_ticket_id == 1) {
                $("#containerGeneralFeedback_mTickets").removeClass("ocultar")
            }
        }

        public.renderFeedback = function() {
            const comentarios = g_data.comentarios || [];

            // Reset general
            $("#containerGeneralGeneral_mTickets").removeClass("col-lg-12").addClass("col-lg-6");
            $("#modalGeneral_mTickets").removeClass("modal-lg").addClass("modal-xl");
            $(".camposFeedback_mTickets").val("").prop('disabled', false);

            // ===================
            // BLOQUE SOPORTE
            // ===================
            if (vistaPorPuesto.ver("soporte")) {
                $(".containersSoporte_mTickets").removeClass("ocultar");
                $("#containerQueHice_mTickets").addClass("ocultar");

                const devolucion = comentarios.find(c => c.tipo_comentario == 2)?.contenido || "";

                switch (g_data.estado_ticket_id) {
                    case 1:
                        $("#containerBtnsFooter_mTickets, #containerGeneralFeedback_mTickets, #btnCerrarTicket_mTickets").addClass("ocultar");
                        $("#btnEliminarTicket_mTickets, #btnEditarTicket_mTickets").removeClass("ocultar");
                        $("#containerGeneralGeneral_mTickets").removeClass("col-lg-6").addClass("col-lg-12");
                        $("#modalGeneral_mTickets").removeClass("modal-xl").addClass("modal-lg");
                        break;
                    case 2:
                    case 3:
                    case 4:
                        $("#containerBtnsFooter_mTickets, #btnEliminarTicket_mTickets, #btnEditarTicket_mTickets, .containersInputFeedback_mTickets").addClass("ocultar");
                        $("#containerGeneralFeedback_mTickets, #containerDevolucion_mTickets, #btnCerrarTicket_mTickets").removeClass("ocultar");
                        $("#devolucion_mTickets").val(devolucion).prop('disabled', true);

                        if (g_data.estado_ticket_id == 4) {
                            $("#btnCerrarTicket_mTickets").addClass("ocultar")
                            $("#containerFeedback_mTickets").removeClass("ocultar")
                            const feedback = comentarios.find(c => c.tipo_comentario == 4)?.contenido || "";
                            $("#feedback_mTickets").val(feedback).prop('disabled', true);
                        }
                        break;
                }

            } else {
                $(".containersSoporte_mTickets").addClass("ocultar");
            }

            // ===================
            // BLOQUE DESARROLLO
            // ===================
            if (vistaPorPuesto.ver("desarrollo")) {
                $(".containersDesarrollo_mTickets").removeClass("ocultar");

                const devolucion = comentarios.find(c => c.tipo_comentario == 2)?.contenido || "";
                const queHice = comentarios.find(c => c.tipo_comentario == 3)?.contenido || "";

                switch (g_data.estado_ticket_id) {
                    case 1:
                        $("#containerBtnsFooter_mTickets, #containerGeneralFeedback_mTickets").addClass("ocultar");
                        $("#containerGeneralGeneral_mTickets").removeClass("col-lg-6").addClass("col-lg-12");
                        $("#modalGeneral_mTickets").removeClass("modal-xl").addClass("modal-lg");
                        break;
                    case 2:
                        $("#containerBtnsFooter_mTickets, .containersInputFeedback_mTickets, .containersVerTicket_mTickets").addClass("ocultar");
                        $("#containerGeneralFeedback_mTickets, #containerDevolucion_mTickets").removeClass("ocultar");
                        $("#devolucion_mTickets").val(devolucion).prop('disabled', true);
                        break;
                    case 3:
                        $("#containerBtnsFooter_mTickets, .containersInputFeedback_mTickets, .containersVerTicket_mTickets").addClass("ocultar");
                        $("#containerGeneralFeedback_mTickets, #containerDevolucion_mTickets, #containerQueHice_mTickets").removeClass("ocultar");
                        $("#devolucion_mTickets").val(devolucion).prop('disabled', true);
                        $("#queHice_mTickets").val(queHice).prop('disabled', true);
                        break;
                    case 4:
                        $("#containerBtnsFooter_mTickets, .containersInputFeedback_mTickets, .containersVerTicket_mTickets").addClass("ocultar");
                        $("#containerGeneralFeedback_mTickets, #containerDevolucion_mTickets").removeClass("ocultar");
                        $("#devolucion_mTickets").val(devolucion).prop('disabled', true);

                        if (queHice) {
                            $("#containerQueHice_mTickets").removeClass("ocultar");
                            $("#queHice_mTickets").val(queHice).prop('disabled', true);
                        } else {
                            $("#containerQueHice_mTickets").addClass("ocultar");
                        }
                        break;
                }

            } else {
                $(".containersDesarrollo_mTickets").addClass("ocultar");
            }
        }


        public.editarTicket = function(type = 0) {
            if (type == 0) {
                $('.campos_mTickets').prop('disabled', false);
                $(".containersVerTicket_mTickets, #btnAbrirSistema_mTickets").addClass("ocultar")
                $(".containersBtnModificar_mTickets").removeClass("ocultar")
                $("#btnCopiarTitulo_mTickets, #btnAbrirSistema_mTickets").empty()

            } else {
                if (type == 2) {
                    llenarCampos()
                    globalValidar.limpiarTodas()
                    globalValidar.deshabilitarTiempoReal({
                        className: "camposObli_mTickets"
                    })
                    $("#btnAbrirSistema_mTickets").removeClass("ocultar")
                }
                $('.campos_mTickets').prop('disabled', true);
                $(".containersBtnModificar_mTickets").addClass("ocultar")
                $(".containersSoporte_mTickets").removeClass("ocultar")
            }
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mTickets"
            })
        }

        public.guardar = function() {
            cliente = $("#cliente_mTickets").val()

            const datos = {
                titulo: $("#titulo_mTickets").val(),
                fecha_limite: $("#fechaLimite_mTickets").val() ? $("#fechaLimite_mTickets").val().replace("T", " ") + ":00" : null,
                clientes_lightdata_ids: cliente !== "todas" ? cliente : [],
                prioridad_ticket_id: $("#prioridad_mTickets").val() * 1,
                tipo_ticket_id: $("#tipoTicket_mTickets").val() * 1,
                usuario_asignado_id: $("#asignar_mTickets").val() * 1,
                descripcion: $("#descripcion_mTickets").val(),
                modo_asociacion: "",
                observadores_ids: []
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mTickets",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de guardar este ticket?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.post(`/${rutaAPI}`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mTickets").modal("hide")
                                nroTicket = result.body
                                buffer = `<button type="button" class="btn rounded-pill btn-label-success waves-effect" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar" onclick="navigator.clipboard.writeText('${nroTicket}')"><span class="tf-icons ri-file-copy-line ri-16px me-2"></span>Tiket N° ${nroTicket}</button>`
                                globalSweetalert.html({
                                    titulo: "Ticket guardado con exito!",
                                    html: buffer
                                })
                                globalActivarAcciones.tooltips({
                                    idContainer: "swal2-html-container"
                                })
                                appModuloTickets.getListado();
                            }
                        });
                    }
                });
        };

        public.editar = function() {
            const datosNuevos = {
                "titulo": $("#titulo_mTickets").val(),
                "fecha_limite": $("#fechaLimite_mTickets").val() ? $("#fechaLimite_mTickets").val().replace("T", " ") + ":00" : null,
                "cliente_id": $("#cliente_mTickets").val() * 1,
                "prioridad_ticket_id": $("#prioridad_mTickets").val() * 1,
                "tipo_ticket_id": $("#tipoTicket_mTickets").val() * 1,
                "usuario_asignado_id": $("#asignar_mTickets").val() * 1,
                "descripcion": $("#descripcion_mTickets").val(),
            };

            globalValidar.habilitarTiempoReal({
                className: "camposObli_mTickets",
                callback: validacion
            });

            if (validacion()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                });
                return;
            }

            const datosModificados = globalValidar.obtenerCambios({
                dataNueva: datosNuevos,
                dataOriginal: g_data
            });

            if (Object.keys(datosModificados).length === 0) {
                globalSweetalert.alert({
                    titulo: "No se realizaron cambios"
                });
                return;
            }

            globalSweetalert.confirmar({
                    titulo: "¿Estas seguro de modificar este ticket?"
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}`, datosModificados, {
                            onSuccess: function(result) {
                                globalSweetalert.exito({
                                    titulo: "Ticket modificado con exito!"
                                })
                                appModalTickets.editarTicket(1)
                                appModuloTickets.getListado();
                            }
                        });
                    }
                });
        };

        function validacionFeedback() {
            return globalValidar.obligatorios({
                className: "camposObliFeedback_mTickets"
            })
        }

        public.cambiarEstado = function(estado) {
            const datos = {
                "estado_ticket_id": estado,
                "comentarios": []
            };

            $(".camposObliFeedback_mTickets").each(function() {
                datos.comentarios.push({
                    "usuario_id": appSistema.userId,
                    "tipo_comentario": $(this).data("tipocomentario") * 1,
                    "contenido": $(this).val()
                });
            });

            globalValidar.habilitarTiempoReal({
                className: "camposObliFeedback_mTickets",
                callback: validacionFeedback
            })

            if (validacionFeedback()) {
                globalSweetalert.alert({
                    titulo: "Verifique los campos"
                })
                return
            }

            mensaje = estado == 2 ? "desestimado" : estado == 3 ? "resuelto" : "cerrado"

            globalSweetalert.confirmar({
                    titulo: `¿Estas seguro de marcar este ticket como ${mensaje}?`
                })
                .then(function(confirmado) {
                    if (confirmado) {
                        globalRequest.put(`/${rutaAPI}/${g_did}/estado`, datos, {
                            onSuccess: function(result) {
                                $("#modal_mTickets").modal("hide")
                                globalSweetalert.exito({
                                    titulo: `Ticket ${mensaje} con exito!`
                                })
                                appModuloTickets.getListado();
                            }
                        });
                    }
                });
        };

        public.cancelarCambioEstado = function() {
            globalValidar.limpiarTodas();
            globalValidar.deshabilitarTiempoReal({
                className: "camposObliFeedback_mTickets"
            });
            $(".camposObliFeedback_mTickets").val("");
            $(".containersInputFeedback_mTickets:has(.camposObliFeedback_mTickets), #containerBtnsFooter_mTickets").addClass("ocultar");

            if (vistaPorPuesto.ver("desarrollo")) {
                $(".containersDesarrollo_mTickets").removeClass("ocultar");
            } else {
                $(".containersDesarrollo_mTickets").addClass("ocultar");
            }

            if (vistaPorPuesto.ver("soporte")) {
                $(".containersSoporte_mTickets").removeClass("ocultar");
            } else {
                $(".containersSoporte_mTickets").addClass("ocultar");
            }

            if (g_data.estado_ticket_id == 1) {
                $("#containerGeneralFeedback_mTickets").addClass("ocultar");
                $("#containerGeneralGeneral_mTickets").removeClass("col-lg-6").addClass("col-lg-12");
                $("#modalGeneral_mTickets").removeClass("modal-xl").addClass("modal-lg");
            }
        }

        public.eliminar = function(did) {
            globalSweetalert.confirmar({
                titulo: "¿Estas seguro de eliminar este ticket?",
                color: "var(--bs-danger)"
            }).then(function(confirmado) {
                if (confirmado) {
                    globalRequest.delete(`/${rutaAPI}/${did}`, {
                        onSuccess: function(result) {
                            $("#modal_mTickets").modal("hide")
                            globalSweetalert.exito({
                                titulo: "Eliminado con exito!"
                            })
                            appModuloTickets.getListado();
                        }
                    });
                }
            });
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