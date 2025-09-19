<script>
    const appModalTickets = (function() {
        let g_did = 0;
        let g_data;
        let g_historial;
        let donde = 0;
        let opcionAnterior = 0;
        let clientesSeleccionados = []
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
                id: "clientes_mTickets",
                multiple: true
            })
            $("#clientes_mTickets").prepend('<option value="todos">Todos</option>');
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

            await globalLlenarSelect.proyectos({
                id: "proyecto_mTickets",
                multiple: true
            })

            await globalLlenarSelect.tiposTickets({
                id: "tipoTicket_mTickets",
                multiple: true
            })

            if (mode == 0) {
                // NUEVO TICKET
                $("#tituloModal_mTickets").text("Nuevo ticket");
                $("#subtitulo_mTickets").text("Creacion de ticket nuevo, completar formulario");
                $('.campos_mTickets').prop('disabled', false);
                $("#containerBtn_mTickets").addClass("ocultar");
                $("#asignadoPor_mTickets, #estado_mTickets").text("").addClass("ocultar")
                $("#containerBtnGuardar_mTickets").removeClass("ocultar");
                $("#modal_mTickets").modal("show")
            } else {
                // VER TICKET
                await globalLoading.open()
                $("#tituloModal_mTickets").text(`Ticket N° ${did}`);
                $('.campos_mTickets').prop('disabled', true);
                $("#containerBtn_mTickets").removeClass("ocultar");
                $("#asignadoPor_mTickets, #estado_mTickets").text("").removeClass("ocultar")
                $("#containerBtnGuardar_mTickets").addClass("ocultar");
                await get()
            }

            await globalActivarAcciones.select2({
                className: "select2_mTickets"
            })

            await globalActivarAcciones.tooltips({
                idContainer: "modal_mTickets"
            })
        }



        public.cerrarModal = function() {
            const modalId = $("#modal_mTickets");
            const modal = bootstrap.Modal.getInstance(modalId[0]) || new bootstrap.Modal(modalId[0]);

            if (donde == 0) {
                let huboCambios = modalId.find(".campos_mTickets").toArray().some(el => {
                    const valor = $(el).val();
                    return Array.isArray(valor) ? valor.length > 0 : (valor !== null && valor !== "");
                });

                if (huboCambios) {
                    globalSweetalert.confirmar({
                        titulo: `¿Estás seguro de volver? Perderás los cambios`
                    }).then(confirmado => confirmado && modal.hide());
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
                    g_data = result.data.ticket;
                    g_historial = result.data.historial;
                    llenarCampos()
                    $("#modal_mTickets").modal("show")
                }
            });
        }

        function llenarCampos() {
            $("#btnCopiarTitulo_mTickets").html(`<button type="button" class="btn btn-icon rounded-pill btn-text-dark ms-1" onclick="globalFuncionesJs.copiarTexto({event, copiar: 'Ticket N° ${g_data.id}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar"><i class="tf-icons ri-file-copy-line ri-22px"></i></button>`)
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
                $("#clientes_mTickets").val(g_data.cliente_id).trigger("change");
                cliente = appSistema.clientes.find(item => item.id == g_data.cliente_id)
                htmlCliente = cliente.url_sistema ? `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="globalFuncionesJs.copiarYRedirigir({event, copiar: '${cliente.password_soporte}', redirigir: '${cliente.url_sistema}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar contraseña e ir a link"><i class="tf-icons ri-external-link-line ri-15px"></i></button>` : "";
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

            appModalTickets.renderAcciones()

            globalActivarAcciones.tooltips({
                idContainer: "modal_mTickets"
            })
        }

        function resetModal() {
            globalActivarAcciones.activarPrimerTab({
                tabList: "tabs_mTickets"
            })

            opcionAnterior = 0
            clientesSeleccionados = []
            $(".campos_mTickets").val("")
            $("select.select2_mTickets[multiple]").val(null).trigger("change");
            $("#btnCopiarTitulo_mTickets, #btnAbrirSistema_mTickets").empty()
            $("#asignadoPor_mTickets, #estado_mTickets").text("").addClass("ocultar")
            $(".containersBtnModificar_mTickets, #containerGeneralHistorial_mTickets, #containerBtn_mTickets, #containerFechaLimite_mTickets").addClass("ocultar")
            $("#containerPrioridad_mTickets").removeClass("col-md-6 col-lg-6").addClass("col-md-12 col-lg-12")
            $("#containerGeneralGeneral_mTickets").removeClass("col-lg-6").addClass("col-lg-12")
            $("#modalGeneral_mTickets").removeClass("modal-xl").addClass("modal-lg")
            $("#modalContent_mTickets").css("border", "0")

            globalValidar.limpiarTodas()
            globalValidar.deshabilitarTiempoReal({
                className: "camposObli_mTickets"
            })
        };

        public.onChangePrioridad = function(opcion) {
            const opcionSeleccionada = opcion.value

            if (opcionSeleccionada != "") {
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

        public.onChangeClientes = function(select) {
            let valores = Array.from(select.value ? $(select).val() : []);

            if (!clientesSeleccionados.includes("todos") && valores.includes("todos")) {
                clientesSeleccionados = valores
                $(select).val(["todos"]).trigger("change.select2");
            } else if (clientesSeleccionados.includes("todos") && valores.length > 1) {
                clientesSeleccionados = valores
                $(select).val(clientesSeleccionados.filter(v => v !== "todos")).trigger("change.select2");
            } else {
                clientesSeleccionados = valores
            }
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

        public.renderAcciones = function() {
            $("#containerGeneralGeneral_mTickets").removeClass("col-lg-12").addClass("col-lg-6");
            $("#modalGeneral_mTickets").removeClass("modal-lg").addClass("modal-xl");
            $(".btnAccionTickets_mTickets").addClass("ocultar")
            $("#containerGeneralHistorial_mTickets").removeClass("ocultar")
            $("#nuevoComentario_mTickets").val("")

            // ===================
            // BLOQUE SOPORTE
            // ===================
            if (vistaPorPuesto.ver("soporte")) {
                switch (g_data.estado_ticket_id) {
                    case 1:
                        $(".btnAlterarTickets_mTickets").removeClass("ocultar");
                        break;
                    case 2:
                    case 3:
                        $(".btnSoporteTickets_mTickets").removeClass("ocultar")
                        break;
                    case 4:
                        break;
                }
            }

            // ===================
            // BLOQUE DESARROLLO
            // ===================
            if (vistaPorPuesto.ver("desarrollo")) {
                switch (g_data.estado_ticket_id) {
                    case 1:
                        $(".btnDesarrolloTickets_mTickets").removeClass("ocultar")
                        break;
                    case 2:
                        break;
                    case 3:
                        break;
                    case 4:
                        break;
                }

            }
        }

        public.editarTicket = function(type = 0) {
            if (type == 0) {
                $('.campos_mTickets').prop('disabled', false);
                $("#containerBtn_mTickets, #btnAbrirSistema_mTickets").addClass("ocultar")
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
                $("#containerBtn_mTickets").removeClass("ocultar")
            }
        }

        function validacion() {
            return globalValidar.obligatorios({
                className: "camposObli_mTickets"
            })
        }

        public.guardar = function() {
            clientes = $("#clientes_mTickets").val()

            const datos = {
                titulo: $("#titulo_mTickets").val(),
                clientes_lightdata_ids: !clientes.includes("todos") ? clientes : [],
                prioridad_ticket_id: $("#prioridad_mTickets").val() * 1,
                fecha_limite: $("#fechaLimite_mTickets").val() ? $("#fechaLimite_mTickets").val().replace("T", " ") + ":00" : null,
                usuario_asignado_id: $("#asignar_mTickets").val() * 1,
                observadores_ids: $("#observadores_mTickets").val() || [],
                proyectos_ids: $("#proyecto_mTickets").val() || [],
                tipo_tickets_ids: $("#tipoTicket_mTickets").val() || [],
                descripcion: $("#descripcion_mTickets").val(),
                modo_asociacion: !clientes.includes("todos") ? 0 : 1
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
            clientes = $("#clientes_mTickets").val()

            const datos = {
                titulo: $("#titulo_mTickets").val(),
                clientes_lightdata_ids: !clientes.includes("todos") ? clientes : [],
                prioridad_ticket_id: $("#prioridad_mTickets").val() * 1,
                fecha_limite: $("#fechaLimite_mTickets").val() ? $("#fechaLimite_mTickets").val().replace("T", " ") + ":00" : null,
                usuario_asignado_id: $("#asignar_mTickets").val() * 1,
                observadores_ids: $("#observadores_mTickets").val() || [],
                proyectos_ids: $("#proyecto_mTickets").val() || [],
                tipo_tickets_ids: $("#tipoTicket_mTickets").val() || [],
                descripcion: $("#descripcion_mTickets").val(),
                modo_asociacion: !clientes.includes("todos") ? 0 : 1
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

        return public;
    })();
</script>