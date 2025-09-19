<div class="modal fade" id="modal_mTickets" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div id="modalGeneral_mTickets" class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div id="modalContent_mTickets" class="modal-content">

            <button type="button" class="btn-close" onclick="appModalTickets.cerrarModal()"></button>
            <div class="d-flex position-absolute ocultar" id="estado_mTickets" style="top: 1.4rem; left: 1.4rem;"></div>
            <div class="modal-body p-0">
                <div class="col-12 text-center mb-6">
                    <h4 class="mb-2 d-flex justify-content-center align-items-center"><span id="tituloModal_mTickets">Nuevo ticket</span><span id="btnCopiarTitulo_mTickets"></span></h4>
                    <p class="mb-1" id="subtitulo_mTickets">Creacion de ticket nuevo, completar formulario</p>
                    <p class="m-0 ocultar" id="asignadoPor_mTickets"></p>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" id="containerGeneralGeneral_mTickets">
                            <div class="nav-align-top col-12 mb-6">
                                <ul id="tabs_mTickets" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabGeneral_mTickets"
                                            aria-controls="tabGeneral_mTickets"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
                                            <i class="ri-survey-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mTickets" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false">

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="titulo_mTickets" class="form-control campos_mTickets camposObli_mTickets" placeholder="Titulo" />
                                                <label for="titulo_mTickets">Titulo</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 position-relative">
                                            <div id="btnAbrirSistema_mTickets" class="position-absolute" style="top: 5px; right: 2rem; z-index: 10;"></div>
                                            <div class="form-floating form-floating-outline">
                                                <select id="clientes_mTickets" class="form-select select2_mTickets campos_mTickets camposObli_mTickets" multiple onchange="appModalTickets.onChangeClientes(this)"></select>
                                                <label for="clientes_mTickets">Clientes</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12" id="containerPrioridad_mTickets">
                                            <div class="form-floating form-floating-outline">
                                                <select id="prioridad_mTickets" class="form-select select2_mTickets campos_mTickets camposObli_mTickets" onchange="appModalTickets.onChangePrioridad(this)"></select>
                                                <label for="prioridad_mTickets">SLA</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6 ocultar" id="containerFechaLimite_mTickets">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control campos_mTickets" type="datetime-local" id="fechaLimite_mTickets">
                                                <label for="fechaLimite_mTickets">Fecha limite</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline">
                                                <select id="asignar_mTickets" class="form-select campos_mTickets"></select>
                                                <label for="asignar_mTickets">Asignado a</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline">
                                                <select id="observadores_mTickets" class="form-select select2_mTickets campos_mTickets" multiple></select>
                                                <label for="observadores_mTickets">Observadores</label>
                                            </div>
                                        </div>


                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline">
                                                <select id="proyecto_mTickets" class="form-select select2_mTickets campos_mTickets camposObli_mTickets" multiple></select>
                                                <label for="proyecto_mTickets">Proyecto</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6">
                                            <div class="form-floating form-floating-outline">
                                                <select id="tipoTicket_mTickets" class="form-select select2_mTickets campos_mTickets camposObli_mTickets" multiple></select>
                                                <label for="tipoTicket_mTickets">Modulo/Circuito</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control campos_mTickets camposObli_mTickets h-px-100" id="descripcion_mTickets" placeholder="Descipción"></textarea>
                                                <label for="descripcion_mTickets">Descipción</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-12 col-lg-6 ocultar" id="containerGeneralHistorial_mTickets">
                            <div class="nav-align-top col-12 mb-6">
                                <ul id="tabs_mTickets" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabGeneral_mTickets"
                                            aria-controls="tabGeneral_mTickets"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-history-line me-2"></i>Historial</span>
                                            <i class="ri-history-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mTickets" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false">

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control" style="height: 70px;" id="nuevoComentario_mTickets" placeholder="Agregar un cometario..."></textarea>
                                                <label for="nuevoComentario_mTickets">Nuevo comentario</label>
                                            </div>
                                        </div>

                                    </form>
                                    <div class="w-100 p-3 mt-3" style="height: 355px;overflow-y: auto;">
                                        <ul class="timeline mb-0 pb-5">
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Joaquin T. - COMENTARIO</h6>
                                                        <small class="text-muted">23/02/2025 13:08 hs</small>
                                                    </div>
                                                    <div class="bg-body p-3 rounded">
                                                        <p class="m-0">orem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>

                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Joaquin T. - CAMBIO ESTADO</h6>
                                                        <small class="text-muted">23/02/2025 13:08 hs</small>
                                                    </div>
                                                    <div class="mb-2">
                                                        <span class="badge rounded-pill me-2" style="color: white; background-color: #FFC107;">pendiente</span>>
                                                        <span class="badge rounded-pill" style="color: white; background-color: #72e128;">resuelto</span>
                                                    </div>
                                                    <div class="bg-body p-3 mb-2 rounded">
                                                        <p class="mb-1 fw-bold">Devolucion a soporte</p>
                                                        <p class="m-0">orem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                                    </div>
                                                    <div class="bg-body p-3 rounded">
                                                        <p class="mb-1 fw-bold">Que hice</p>
                                                        <p class="m-0">orem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim </p>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-primary"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">12 Invoices have been paid</h6>
                                                        <small class="text-muted">12 min ago</small>
                                                    </div>
                                                    <p class="mb-2">Invoices have been paid to the company</p>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <div class="badge bg-lighter rounded-3 mb-1_5">
                                                            <img src="../../assets//img/icons/misc/pdf.png" alt="img" width="15" class="me-2" />
                                                            <span class="h6 mb-0 text-body">invoices.pdf</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-success"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Client Meeting</h6>
                                                        <small class="text-muted">45 min ago</small>
                                                    </div>
                                                    <p class="mb-2">Project meeting with john @10:15am</p>
                                                    <div class="d-flex justify-content-between flex-wrap gap-2 mb-1_5">
                                                        <div class="d-flex flex-wrap align-items-center">
                                                            <div class="avatar avatar-sm me-2">
                                                                <img src="../../assets/img/avatars/1.png" alt="Avatar" class="rounded-circle" />
                                                            </div>
                                                            <div>
                                                                <p class="mb-0 small fw-medium">Lester McCarthy (Client)</p>
                                                                <small>CEO of Pixinvent</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="timeline-item timeline-item-transparent">
                                                <span class="timeline-point timeline-point-info"></span>
                                                <div class="timeline-event">
                                                    <div class="timeline-header mb-3">
                                                        <h6 class="mb-0">Create a new project for client</h6>
                                                        <small class="text-muted">2 Day Ago</small>
                                                    </div>
                                                    <p class="mb-2">6 team members in a project</p>
                                                    <ul class="list-group list-group-flush">
                                                        <li
                                                            class="list-group-item d-flex justify-content-between align-items-center flex-wrap border-top-0 p-0">
                                                            <div class="d-flex flex-wrap align-items-center">
                                                                <ul class="list-unstyled users-list d-flex align-items-center avatar-group m-0 me-2">
                                                                    <li
                                                                        data-bs-toggle="tooltip"
                                                                        data-popup="tooltip-custom"
                                                                        data-bs-placement="top"
                                                                        title="Vinnie Mostowy"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar" />
                                                                    </li>
                                                                    <li
                                                                        data-bs-toggle="tooltip"
                                                                        data-popup="tooltip-custom"
                                                                        data-bs-placement="top"
                                                                        title="Allen Rieske"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar" />
                                                                    </li>
                                                                    <li
                                                                        data-bs-toggle="tooltip"
                                                                        data-popup="tooltip-custom"
                                                                        data-bs-placement="top"
                                                                        title="Julee Rossignol"
                                                                        class="avatar pull-up">
                                                                        <img class="rounded-circle" src="../../assets/img/avatars/1.png" alt="Avatar" />
                                                                    </li>
                                                                    <li class="avatar">
                                                                        <span
                                                                            class="avatar-initial rounded-circle pull-up text-heading"
                                                                            data-bs-toggle="tooltip"
                                                                            data-bs-placement="bottom"
                                                                            title="3 more">+3</span>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-12 mt-7">
                    <div class="row g-3">
                        <div class="col-12 col-md-12 col-lg-2">
                            <button type="button" class="btn btn-outline-dark w-100" onclick="appModalTickets.cerrarModal()">Volver</button>
                        </div>
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="row justify-content-end g-3">

                                <div class="d-flex justify-content-end gap-3" id="containerBtn_mTickets">
                                    <button id="btnEditarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-success btnAlterarTickets_mTickets btnAccionTickets_mTickets" onclick="appModalTickets.editarTicket()" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar ticket">
                                        <i class="tf-icons ri-edit-line ri-22px"></i>
                                    </button>
                                    <button id="btnEliminarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-danger btnAlterarTickets_mTickets btnAccionTickets_mTickets" onclick="appModalTickets.eliminar()" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                        <i class="tf-icons ri-delete-bin-6-line ri-22px"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-warning btnDesarrolloTickets_mTickets btnAccionTickets_mTickets" onclick="appOffCanvasTicket.open({mode: 2})" data-bs-toggle="tooltip" data-bs-placement="top" title="Desestimar">
                                        <i class="tf-icons ri-delete-back-2-line ri-22px"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-success btnDesarrolloTickets_mTickets btnAccionTickets_mTickets" onclick="appOffCanvasTicket.open({mode: 1})" data-bs-toggle="tooltip" data-bs-placement="top" title="Resolver">
                                        <i class="tf-icons ri-check-line ri-22px"></i>
                                    </button>
                                    <button id="btnDevolverTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-dark btnSoporteTickets_mTickets btnAccionTickets_mTickets" onclick="appOffCanvasTicket.open({mode: 4})" data-bs-toggle="tooltip" data-bs-placement="top" title="Devolver a desarrollo">
                                        <i class="tf-icons ri-arrow-go-back-line ri-18px"></i>
                                    </button>
                                    <button id="btnCerrarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-info btnSoporteTickets_mTickets btnAccionTickets_mTickets" onclick="appOffCanvasTicket.open({mode: 3})" data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar">
                                        <i class="tf-icons ri-check-double-line ri-22px"></i>
                                    </button>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3" id="containerBtnGuardar_mTickets">
                                    <button type="button" class="btn btn-success w-100" onclick="appModalTickets.guardar()">Guardar</button>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3 ocultar containersBtnModificar_mTickets">
                                    <button type="button" class="btn btn-outline-danger w-100" onclick="appModalTickets.editarTicket(2)">Cancelar</button>
                                </div>

                                <div class="col-12 col-md-12 col-lg-4 ocultar containersBtnModificar_mTickets">
                                    <button type="button" class="btn btn-success w-100" onclick="appModalTickets.editar()">Modificar</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include("modulos/tickets/offCanvas/ficha.php"); ?>

</div>