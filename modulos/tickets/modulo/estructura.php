<script>
    const appModuloTickets = (function() {

        let g_data = []
        let g_meta = {}
        let order = "";
        let direction = "";
        let openModulo = 0
        const rutaAPI = "tickets"
        let puestosVistaDesarrollador = [1, 5]

        const public = {};

        public.paginaActual = 1;
        public.limitePorPagina = 10;

        public.open = async function() {
            $(".winapp").hide();
            $("#modulo_tickets").show();

            if (vistaPorPuesto.ver("soporte")) {
                $(".containerUsuarioDesarrollo_tickets").addClass("ocultar");
                $(".containerUsuarioSoporte_tickets").removeClass("ocultar");
            } else {
                $(".containerUsuarioSoporte_tickets").addClass("ocultar");
                $(".containerUsuarioDesarrollo_tickets").removeClass("ocultar");
            }

            if (vistaPorPuesto.ver("soporte")) {
                $("#btnNuevoTicket_tickets").removeClass("ocultar");
            }

            await globalLlenarSelect.estadosTickets({
                id: "filtroEstado_tickets",
                multiple: true
            });
            await globalLlenarSelect.prioridades({
                id: "filtroPrioridad_tickets",
                multiple: true
            });
            await globalLlenarSelect.clientes({
                id: "filtroCliente_tickets",
                multiple: true
            });
            await globalLlenarSelect.tiposTickets({
                id: "filtroTipoTicket_tickets",
                multiple: true
            });
            await globalLlenarSelect.usuariosAsignables({
                id: "filtroUsuario_tickets",
                multiple: true
            });

            if (vistaPorPuesto.ver("desarrollo")) {
                $("#filtroEstado_tickets").val("1").change();
            } else {
                $("#filtroEstado_tickets").val([1, 2, 3]).change();
            }

            await appModuloTickets.getListado();

            await globalActivarAcciones.filtrarConEnter({
                className: "inputs_tickets",
                callback: appModuloTickets.getListado
            });
            await globalOrdenTablas.activar({
                idThead: "theadListado_tickets",
                callback: appModuloTickets.getListado,
                defaultOrder: "id"
            })
            await globalActivarAcciones.select2({
                className: "select2_tickets"
            })
            await globalActivarAcciones.tooltips({
                idContainer: "modulo_tickets"
            });
        };

        public.limpiarCampos = function() {
            $(".campos_tickets").val(null).change()
            $(".inputs_tickets").val("")

            if (vistaPorPuesto.ver("desarrollo")) {
                $("#filtroEstado_tickets").val("1").change()
            } else {
                $("#filtroEstado_tickets").val([1, 2, 3]).change()
            }
        };

        function renderListado() {
            $("#tbodyListado_tickets").empty()
            buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias({
                    idTbody: "tbodyListado_tickets",
                    open: openModulo,
                    element: "tickets"
                })
                return
            };

            g_data.forEach(reporte => {

                htmlNroReporte = "S/D"
                if (reporte.id) {
                    htmlNroReporte = reporte.id
                    htmlNroReporte += `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="globalFuncionesJs.copiarTexto({event, copiar: '${reporte.id}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar"><i class="tf-icons ri-file-copy-line ri-15px"></i></button>`
                }

                htmlTipoTicket = "S/D"
                if (reporte.tipo_ticket_id) {
                    htmlTipoTicket = appSistema.tipoTicket.find(item => item.id == reporte.tipo_ticket_id)?.nombre || "S/D"
                }

                htmlPrioridad = "S/D"
                if (reporte.prioridad_ticket_id) {
                    prioridad = appSistema.prioridades.find(item => item.id == reporte.prioridad_ticket_id) || "S/D"
                    htmlPrioridad = `<span class="badge rounded-pill" style="color: white; background-color: ${prioridad["color"] || "#6d6d6dff"};">${prioridad["nombre"] || "S/D"}</span>`
                }

                htmlEstado = "S/D"
                if (reporte.estado_ticket_id) {
                    estado = appSistema.estadosTickets.find(item => item.id == reporte.estado_ticket_id) || "S/D"
                    htmlEstado = `<span class="badge rounded-pill" style="color: white; background-color: ${estado["color"]  || "#6d6d6dff"};">${estado["nombre"] || "S/D"}</span>`
                }

                htmlCliente = "S/D"
                if (reporte.cliente_id) {
                    cliente = appSistema.clientes.find(item => item.id == reporte.cliente_id)
                    htmlCliente = cliente?.nombre || "S/D"
                    htmlCliente += cliente.url_sistema ? `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="globalFuncionesJs.copiarYRedirigir({event, copiar: '${cliente.password_soporte}', redirigir: '${cliente.url_sistema}'})" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar contraseña e ir a link"><i class="tf-icons ri-external-link-line ri-15px"></i></button>` : "";
                }

                htmlUsuario = "S/D"
                if (reporte.usuario_asignado_id) {
                    htmlUsuario = appSistema.usuarios.find(item => item.id == reporte.usuario_asignado_id)?.nombre || "S/D"
                }

                htmlQuien = "S/D"
                if (reporte.quien) {
                    htmlQuien = appSistema.usuarios.find(item => item.id == reporte.quien)?.nombre || "S/D"
                }

                htmlLimite = "S/D";
                if (reporte.fecha_limite) {
                    const horas = horasRestantes(reporte.fecha_limite);
                    if (reporte.estado_ticket_id == 4) {
                        htmlLimite = globalFuncionesJs.formatearFecha({
                            fecha: reporte.fecha_limite
                        });
                    } else if (reporte.prioridad_ticket_id == 1) {
                        htmlLimite = `<span class="badge rounded-pill bg-label-info"><i class="ri-alarm-warning-line me-1"></i>Lo antes posible</span>`;
                    } else if (horas <= 24 && horas > 0) {
                        htmlLimite = `${globalFuncionesJs.formatearFecha({fecha: reporte.fecha_limite})}<span class="badge text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Por vencer"><i class="ri-timer-line"></i></span>`;
                    } else if (horas <= 0) {
                        htmlLimite = `${globalFuncionesJs.formatearFecha({fecha: reporte.fecha_limite})}<span class="badge text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Vencido"><i class="ri-alert-line"></i></span>`;
                    } else {
                        htmlLimite = globalFuncionesJs.formatearFecha({
                            fecha: reporte.fecha_limite
                        });
                    }
                }


                buffer += `<tr style="cursor: pointer;" onclick="appModalTickets.open({mode: 1, did: '${reporte.id}'})">`
                buffer += `<td>${htmlNroReporte}</td>`
                buffer += `<td>${globalFuncionesJs.formatearFecha({fecha: reporte.fecha_creacion}) || "S/D"}</td>`
                buffer += `<td class="text-wrap">${htmlCliente}</td>`
                buffer += `<td class="text-wrap">${reporte.titulo || "S/D"}</td>`
                buffer += `<td class="text-wrap">${htmlTipoTicket}</td>`
                buffer += `<td>${htmlPrioridad}</td>`
                if (vistaPorPuesto.ver("soporte")) {
                    buffer += `<td>${htmlUsuario}</td>`
                }
                buffer += `<td>${htmlQuien}</td>`
                buffer += `<td>${htmlLimite}</td>`
                buffer += `<td>${htmlEstado}</td>`

                buffer += `</tr>`
            });

            $("#tbodyListado_tickets").html(buffer)
            $("#totalRegistros_tickets").text(g_meta.totalItems)
            $("#totalPaginas_tickets").text(g_meta.totalPages)
            globalActivarAcciones.tooltips({
                idContainer: "modulo_tickets"
            })

        }

        function horasRestantes(fechaISO) {
            const ahora = new Date();
            const destino = new Date(fechaISO);
            const diferenciaMs = destino - ahora;

            const diferenciaHoras = Math.round(diferenciaMs / (1000 * 60 * 60));

            return diferenciaHoras < 0 ? 0 : diferenciaHoras;
        }

        public.getListado = function({
            type = 0,
            orderBy = "",
            orderDir = ""
        } = {}) {
            openModulo = type;
            order = orderBy || order;
            direction = orderDir || direction;

            usuarioAsigando = appSistema.userId;
            if (vistaPorPuesto.ver("soporte")) {
                usuarioAsigando = $("#filtroUsuario_tickets").val().join(",")
            }

            const parametros = {
                page: type === 1 ? 1 : public.paginaActual,
                page_size: public.limitePorPagina,
                sort_by: order,
                sort_dir: direction,
                usuario_asignado_id: usuarioAsigando,
                id: $("#filtroNumero_tickets").val(),
                proyecto_id: "",
                tipo_ticket_id: $("#filtroTipoTicket_tickets").val().join(","),
                estado_ticket_id: $("#filtroEstado_tickets").val().join(","),
                prioridad_ticket_id: $("#filtroPrioridad_tickets").val().join(","),
                cliente_id: $("#filtroCliente_tickets").val().join(","),
                observador: "",
                fecha_creacion_desde: "",
                fecha_creacion_hasta: "",
                fecha_desde: "",
                fecha_hasta: "",
                q: $("#filtroTitulo_tickets").val(),
            };

            const queryString = $.param(parametros);

            globalRequest.get(`/${rutaAPI}?${queryString}`, {
                onSuccess: function(result) {
                    g_data = result.data;
                    g_meta = result.meta;
                    public.paginaActual = parseInt(g_meta.page);
                    renderListado();
                    globalPaginado.generar({
                        idBase: "_tickets",
                        meta: g_meta,
                        estructura: appModuloTickets
                    });
                },
            });
        };

        return public;
    })();
</script>