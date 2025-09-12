<div class="winapp" id='container_ticketNuevo' style="display:none;">

    <div class="card mb-6">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <i class="ri-coupon-3-line ri-30px me-2"></i>
                <h3 class="mb-0">Nuevo ticket</h3>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="row g-6">

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <input class="form-control campos_ticketNuevo camposObli_ticketNuevo" type="date" id="fecha_ticketNuevo">
                        <label for="fecha_ticketNuevo">Fecha</label>
                        <div class="invalid-feedback">Debe completar el campo</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-8">
                    <div class="form-floating form-floating-outline">
                        <input type="text" id="titulo_ticketNuevo" class="form-control campos_ticketNuevo camposObli_ticketNuevo inputs_ticketNuevo" placeholder="Titulo" />
                        <label for="titulo_ticketNuevo">Titulo</label>
                        <div class="invalid-feedback">Debe completar el campo</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="cliente_ticketNuevo" class="form-select campos_ticketNuevo camposObli_ticketNuevo" data-allow-clear="true"></select>
                        <label for="cliente_ticketNuevo">Logistica</label>
                        <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="prioridad_ticketNuevo" class="form-select campos_ticketNuevo camposObli_ticketNuevo" data-allow-clear="true"></select>
                        <label for="prioridad_ticketNuevo">SLA</label>
                        <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-4">
                    <div class="form-floating form-floating-outline">
                        <select id="asignar_ticketNuevo" class="form-select campos_ticketNuevo camposObli_ticketNuevo" data-allow-clear="true"></select>
                        <label for="asignar_ticketNuevo">Asignar a</label>
                        <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-12">
                    <div class="form-floating form-floating-outline">
                        <textarea class="form-control campos_ticketNuevo camposObli_ticketNuevo inputs_ticketNuevo h-px-100" id="descripcion_ticketNuevo" placeholder="Descipción"></textarea>
                        <label for="descripcion_ticketNuevo">Descipción</label>
                        <div class="invalid-feedback">Debe completar el campo</div>
                    </div>
                </div>


            </div>
        </div>

        <div class="card-footer">
            <div class="col-12 mt-3">
                <div class="row g-6 pt-0 justify-content-end">
                    <div class="col-12 col-md-6 col-lg-2">
                        <button type="reset" class="btn btn-outline-danger w-100" onclick="appTicketNuevo.limpiarCampos()"><span class="tf-icons ri-close-circle-fill ri-19px me-2"></span>Cancelar</button>
                    </div>
                    <div class="col-12 col-md-6 col-lg-3">
                        <button type="submit" class="btn btn-success w-100" onclick="appTicketNuevo.crearTicket()"><span class="tf-icons ri-sticky-note-add-fill ri-19px me-2"></span>Crear</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>