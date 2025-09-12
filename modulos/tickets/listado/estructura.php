<script>
    const appTicketListado = (function() {

        let g_data = []
        let g_meta = {}
        let paginaActual = 1;
        let totalPaginas = 1;
        let limitePorPagina = 10;
        let openModulo = 0
        let puestosVistaDesarrollador = [1, 5]

        const public = {};

        public.open = async function() {
            $(".winapp").hide();
            appTicketListado.limpiarCampos();

            if (vistaPorPuesto.ver("soporte")) {
                $(".containerUsuarioDesarrollo_ticketListado").addClass("ocultar");
                $(".containerUsuarioSoporte_ticketListado").removeClass("ocultar");
            } else {
                $(".containerUsuarioSoporte_ticketListado").addClass("ocultar");
                $(".containerUsuarioDesarrollo_ticketListado").removeClass("ocultar");
            }

            if (vistaPorPuesto.ver("soporte")) {
                $("#btnNuevoTicket_ticketListado").removeClass("ocultar");
            }

            $("#container_ticketListado").show();

            await globalLlenarSelect.estadosTickets("filtroEstado_ticketListado", true);
            await globalLlenarSelect.prioridades("filtroPrioridad_ticketListado", true);
            await globalLlenarSelect.logisticas("filtroCliente_ticketListado", true);
            await globalLlenarSelect.tiposTickets("filtroTipoTicket_ticketListado", true);
            await globalLlenarSelect.usuariosAsignables("filtroUsuario_ticketListado", true);
            await globalActivarAcciones.select2("select2_ticketListado");

            if (vistaPorPuesto.ver("desarrollo")) {
                $("#filtroEstado_ticketListado").val("1").change();
            } else {
                $("#filtroEstado_ticketListado").val([1, 2, 3]).change();
            }

            await appTicketListado.getListado();

            globalActivarAcciones.filtrarConEnter("inputs_ticketListado", () => appTicketListado.getListado());
            globalActivarAcciones.tooltips("container_ticketListado");
        };



        public.limpiarCampos = function() {
            $(".campos_ticketListado").val("")
            $(".campos_ticketListado").val(null).change()

            if (vistaPorPuesto.ver("desarrollo")) {
                $("#filtroEstado_ticketListado").val("1").change()
            } else {
                $("#filtroEstado_ticketListado").val([1, 2, 3]).change()
            }
        };


        public.getListado = async function(type = 0, auto = 0) {
            openModulo = type;

            usuarioAsigando = appSistema.userId;
            if (vistaPorPuesto.ver("soporte")) {
                usuarioAsigando = $("#filtroUsuario_ticketListado").val().join(",")
            }

            const parametros = {
                usuario_asignado_id: usuarioAsigando,
                page: type == 1 ? 1 : paginaActual,
                page_size: limitePorPagina,
                sort_by: "vence",
                sort_dir: "desc",
                id: $("#filtroNumero_ticketListado").val(),
                proyecto_id: "",
                tipo_ticket_id: $("#filtroTipoTicket_ticketListado").val().join(","),
                estado_ticket_id: $("#filtroEstado_ticketListado").val().join(","),
                prioridad_ticket_id: $("#filtroPrioridad_ticketListado").val().join(","),
                logistica_id: $("#filtroCliente_ticketListado").val().join(","),
                observador: "",
                fecha_creacion_desde: "",
                fecha_creacion_hasta: "",
                fecha_desde: "",
                fecha_hasta: "",
                q: $("#filtroTitulo_ticketListado").val(),
            };

            const queryString = $.param(parametros);

            if (auto == 0) {
                await globalLoading.open();
            }
            await $.ajax({
                url: `${appSistema.urlServer}/tickets?${queryString}`,
                type: "GET",
                contentType: "application/json",
                headers: {
                    Authorization: `Bearer ${appSistema.tkn}`
                },
                success: async function(result) {
                    if (result.success && result.body.data) {
                        g_data = result.body.data;
                        g_meta = result.body.meta;
                        paginaActual = parseInt(g_meta.page);
                        totalPaginas = parseInt(g_meta.total_pages);
                        await renderListado();

                        globalPaginado.generarFooter({
                            idBase: "_ticketListado",
                            totalRegistros: g_meta.total,
                            totalPaginas: g_meta.total_pages,
                            paginaActual: g_meta.page,
                            limitePorPagina: g_meta.page_size,
                            onPageChange: (pagina) => {
                                paginaActual = pagina;
                                public.getListado();
                            },
                            onLimiteChange: (nuevoLimite) => {
                                limitePorPagina = nuevoLimite;
                                paginaActual = 1;
                                public.getListado();
                            }
                        });
                    } else {
                        g_data = [];
                        g_meta = {};
                        renderListado();
                        globalSweetalert.error("Hubo un error al buscar tickets");
                    }
                    globalLoading.close();
                },
                error: function() {
                    globalLoading.close();
                    globalSweetalert.error();
                },
                complete: function() {
                    globalLoading.close();
                }
            });
        };


        function renderListado() {
            $("#tbodyListado_ticketListado").empty()
            buffer = ""

            if (!g_data || g_data.length < 1) {
                globalSinInformacion.tablasVacias("tbodyListado_ticketListado", openModulo, "tickets")
                return
            };

            g_data.forEach(reporte => {

                htmlNroReporte = "S/D"
                if (reporte.id) {
                    htmlNroReporte = reporte.id
                    htmlNroReporte += `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="appTicketListado.copiarTexto(event, '${reporte.id}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar"><i class="tf-icons ri-file-copy-line ri-15px"></i></button>`
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

                htmlLogistica = "S/D"
                if (reporte.logistica_id) {
                    logistica = appSistema.logisticas.find(item => item.id == reporte.logistica_id)
                    htmlLogistica = logistica?.nombre || "S/D"
                    htmlLogistica += logistica.url_sistema ? `<button type="button" class="btn btn-icon rounded-pill btn-text-secondary ms-1" onclick="appTicketListado.copiarYRedirigir(event, '${logistica.password_soporte}', '${logistica.url_sistema}')" data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar contraseña e ir a link"><i class="tf-icons ri-external-link-line ri-15px"></i></button>` : "";
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
                        htmlLimite = globalFuncionesJs.formatearFecha(reporte.fecha_limite);
                    } else if (reporte.prioridad_ticket_id == 1) {
                        htmlLimite = `<span class="badge rounded-pill bg-label-info"><i class="ri-alarm-warning-line me-1"></i>Lo antes posible</span>`;
                    } else if (horas <= 24 && horas > 0) {
                        htmlLimite = `${globalFuncionesJs.formatearFecha(reporte.fecha_limite)}<span class="badge text-warning" data-bs-toggle="tooltip" data-bs-placement="top" title="Por vencer"><i class="ri-timer-line"></i></span>`;
                    } else if (horas <= 0) {
                        htmlLimite = `${globalFuncionesJs.formatearFecha(reporte.fecha_limite)}<span class="badge text-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Vencido"><i class="ri-alert-line"></i></span>`;
                    } else {
                        htmlLimite = globalFuncionesJs.formatearFecha(reporte.fecha_limite);
                    }
                }


                buffer += `<tr style="cursor: pointer;" onclick="appTicketModal.open(1, '${reporte.id}')">`
                buffer += `<td>${htmlNroReporte}</td>`
                buffer += `<td>${globalFuncionesJs.formatearFecha(reporte.fecha_creacion) || "S/D"}</td>`
                buffer += `<td class="text-wrap">${htmlLogistica}</td>`
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

            $("#tbodyListado_ticketListado").html(buffer)
            globalActivarAcciones.tooltips("container_ticketListado");

        }

        public.copiarTexto = function(e, texto) {
            e.stopPropagation();
            navigator.clipboard.writeText(texto)
        }

        public.copiarYRedirigir = function(e, password, url) {
            e.stopPropagation();
            navigator.clipboard.writeText(password)
            window.open(url, "_blank");
        }

        function horasRestantes(fechaISO) {
            const ahora = new Date();
            const destino = new Date(fechaISO);
            const diferenciaMs = destino - ahora;

            const diferenciaHoras = Math.round(diferenciaMs / (1000 * 60 * 60));

            return diferenciaHoras < 0 ? 0 : diferenciaHoras;
        }

        return public;
    })();
</script>