<div class="winapp" id='modulo_tickets' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-coupon-line ri-30px me-2"></i>
                <h3 class="mb-0">Listado de tickets</h3>
            </div>
        </div>
    </div>

    <div class="card">

        <div class="card-header border-bottom">

            <div class="row g-3 mb-5">

                <div class="col-12 col-md-6 col-lg-2">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_tickets inputs_tickets" id="filtroNumero_tickets" placeholder="N° de reporte" />
                        <label for="filtroNumero_tickets">Buscar por N° de reporte</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_tickets inputs_tickets" id="filtroTitulo_tickets" placeholder="Titulo/Descripción" />
                        <label for="filtroTitulo_tickets">Buscar por titulo/descripción</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroPrioridad_tickets" multiple class="form-select select2_tickets campos_tickets select_tickets"></select>
                        <label for="filtroPrioridad_tickets">SLA</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_tickets" multiple class="form-select select2_tickets campos_tickets select_tickets"></select>
                        <label for="filtroEstado_tickets">Estado</label>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-3 align-items-center">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroCliente_tickets" multiple class="form-select select2_tickets campos_tickets select_tickets"></select>
                        <label for="filtroCliente_tickets">Cliente</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroTipoTicket_tickets" multiple class="form-select select2_tickets campos_tickets select_tickets"></select>
                        <label for="filtroTipoTicket_tickets">Circuito/Modulo</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 containerUsuarioSoporte_tickets">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroUsuario_tickets" multiple class="form-select select2_tickets campos_tickets select_tickets"></select>
                        <label for="filtroUsuario_tickets">Usuario asignado</label>
                    </div>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-icon btn-primary waves-effect waves-light me-3" onclick="appModuloTickets.getListado()" data-bs-toggle="tooltip" data-bs-placement="top" title="Filtrar">
                        <span class="tf-icons ri-filter-2-fill ri-22px"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-warning waves-effect waves-light me-3" onclick="appModuloTickets.limpiarCampos()" data-bs-toggle="tooltip" data-bs-placement="top" title="Limpiar filtros">
                        <span class="tf-icons ri-eraser-fill ri-22px"></span>
                    </button>
                    <button type="button" id="btnNuevoTicket_tickets" class="btn btn-icon btn-label-success waves-effect waves-light w-auto px-2 containerUsuarioSoporte_tickets" onclick="appModalTickets.open(0, 0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Nuevo ticket">
                        <span class="tf-icons ri-add-fill ri-22px"></span>
                        <span class="tf-icons ri-coupon-3-fill ri-22px"></span>
                    </button>

                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead id="theadListado_tickets" class="table-thead">
                    <tr>
                        <th data-order="id">N°</th>
                        <th data-order="fecha_creacion">Fecha</th>
                        <th data-order="logistica_id">Cliente</th>
                        <th data-order="titulo">Titulo</th>
                        <th data-order="tipo_ticket_id">Circuito</th>
                        <th data-order="prioridad_ticket_id">SLA</th>
                        <th data-order="usuario_asignado_id" class="containerUsuarioSoporte_tickets">Asignado a</th>
                        <th data-order="quien">Asignado por</th>
                        <th data-order="fecha_limite">Limite</th>
                        <th data-order="estado_ticket_id">Estado</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_tickets"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_tickets"></div>

    </div>
</div>