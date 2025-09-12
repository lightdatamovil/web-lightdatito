<div class="winapp" id='container_ticketListado' style="display:none;">

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
                        <input type="text" class="form-control campos_ticketListado inputs_ticketListado" id="filtroNumero_ticketListado" placeholder="N° de reporte" />
                        <label for="filtroNumero_ticketListado">Buscar por N° de reporte</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input type="text" class="form-control campos_ticketListado inputs_ticketListado" id="filtroTitulo_ticketListado" placeholder="Titulo/Descripción" />
                        <label for="filtroTitulo_ticketListado">Buscar por titulo/descripción</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroPrioridad_ticketListado" multiple class="form-select select2_ticketListado campos_ticketListado select_ticketListado"></select>
                        <label for="filtroPrioridad_ticketListado">SLA</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroEstado_ticketListado" multiple class="form-select select2_ticketListado campos_ticketListado select_ticketListado"></select>
                        <label for="filtroEstado_ticketListado">Estado</label>
                    </div>
                </div>

            </div>

            <div class="row g-3 mb-3 align-items-center">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroCliente_ticketListado" multiple class="form-select select2_ticketListado campos_ticketListado select_ticketListado"></select>
                        <label for="filtroCliente_ticketListado">Cliente</label>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-lg-3">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroTipoTicket_ticketListado" multiple class="form-select select2_ticketListado campos_ticketListado select_ticketListado"></select>
                        <label for="filtroTipoTicket_ticketListado">Circuito/Modulo</label>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-3 containerUsuarioSoporte_ticketListado">
                    <div class="form-floating form-floating-outline">
                        <select id="filtroUsuario_ticketListado" multiple class="form-select select2_ticketListado campos_ticketListado select_ticketListado"></select>
                        <label for="filtroUsuario_ticketListado">Usuario asignado</label>
                    </div>
                </div>

                <div class="col">
                    <button type="button" class="btn btn-icon btn-primary waves-effect waves-light me-3" onclick="appTicketListado.getListado(1)" data-bs-toggle="tooltip" data-bs-placement="top" title="Filtrar">
                        <span class="tf-icons ri-filter-2-fill ri-22px"></span>
                    </button>
                    <button type="button" class="btn btn-icon btn-warning waves-effect waves-light me-3" onclick="appTicketListado.limpiarCampos()" data-bs-toggle="tooltip" data-bs-placement="top" title="Limpiar filtros">
                        <span class="tf-icons ri-eraser-fill ri-22px"></span>
                    </button>
                    <button type="button" id="btnNuevoTicket_ticketListado" class="btn btn-icon btn-label-success waves-effect waves-light w-auto px-2 containerUsuarioSoporte_ticketListado" onclick="appTicketModal.open(0, 0)" data-bs-toggle="tooltip" data-bs-placement="top" title="Nuevo ticket">
                        <span class="tf-icons ri-add-fill ri-22px"></span>
                        <span class="tf-icons ri-coupon-3-fill ri-22px"></span>
                    </button>

                </div>
            </div>

        </div>

        <div class="table-responsive text-nowrap table-container">
            <table class="table table-hover">
                <thead class="table-thead">
                    <tr>
                        <th>N°</th>
                        <th>Fecha</th>
                        <th>Cliente</th>
                        <th>Titulo</th>
                        <th>Circuito</th>
                        <th>SLA</th>
                        <th class="containerUsuarioSoporte_ticketListado">Asignado a</th>
                        <th>Asignado por</th>
                        <th>Limite</th>
                        <th>Estado</th>
                    </tr>
                </thead>
                <tbody id="tbodyListado_ticketListado"></tbody>
            </table>
        </div>

        <div class="card-footer" id="footer_ticketListado"></div>

    </div>
</div>