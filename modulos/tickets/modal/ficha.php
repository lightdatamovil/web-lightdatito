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

                                        <div class="col-12 col-md-12 col-lg-12 position-relative" id="containerclientes_mTickets">
                                            <div id="btnAbrirSistema_mTickets" class="position-absolute" style="top: 5px; right: 2rem; z-index: 10;"></div>
                                            <div class="form-floating form-floating-outline">
                                                <select id="clientes_mTickets" class="form-select select2_mTickets campos_mTickets camposObli_mTickets" multiple onchange="appModalTickets.manejarSelectTodos(this)"></select>
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
                                                <select id="asignar_mTickets" class="form-select select2_mTickets campos_mTickets"></select>
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
                        <div class="col-12 col-md-12 col-lg-6 ocultar" id="containerGeneralFeedback_mTickets">
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
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-feedback-line me-2"></i>Acciones</span>
                                            <i class="ri-feedback-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mTickets" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false">

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control" style="height: 120px;" id="nuevoComentario_mTickets" placeholder="Agregar un cometario..."></textarea>
                                                <label for="nuevoComentario_mTickets">Nuevo comentario</label>
                                            </div>
                                        </div>

                                    </form>
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

                                <div class="containersDesarrollo_mTickets containersVerTicket_mTickets d-flex justify-content-end">
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-warning me-3" onclick="appModalTickets.renderCambioEstado(1)" data-bs-toggle="tooltip" data-bs-placement="top" title="Desestimar">
                                        <i class="tf-icons ri-delete-back-2-line ri-22px"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-success" onclick="appModalTickets.renderCambioEstado(2)" data-bs-toggle="tooltip" data-bs-placement="top" title="Resolver">
                                        <i class="tf-icons ri-check-line ri-22px"></i>
                                    </button>
                                </div>

                                <div class="containersSoporte_mTickets containersVerTicket_mTickets d-flex justify-content-end">
                                    <button id="btnEditarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-success me-3" onclick="appModalTickets.editarTicket()" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar ticket">
                                        <i class="tf-icons ri-edit-line ri-22px"></i>
                                    </button>
                                    <button id="btnEliminarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-danger" onclick="appModalTickets.eliminar()" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                        <i class="tf-icons ri-delete-bin-6-line ri-22px"></i>
                                    </button>
                                    <button id="btnCerrarTicket_mTickets" type="button" class="btn btn-icon rounded-pill btn-label-info ms-3" onclick="appOffCanvasTicket.open()" data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar">
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

                                <div class="col-12 col-md-12 col-lg-12" id="containerBtnsFooter_mTickets"></div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php include("modulos/tickets/offCanvas/ficha.php"); ?>

</div>