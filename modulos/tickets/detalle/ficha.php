<div class="modal fade" id="container_mTicket" tabindex="-1" aria-hidden="true" data-bs-backdrop="static">
    <div id="modalGeneral_mTicket" class="modal-dialog modal-dialog-centered modal-lg modal-simple">
        <div id="modalContent_mTicket" class="modal-content">

            <button type="button" class="btn-close" onclick="appTicketModal.cerrarModal()"></button>
            <div class="d-flex position-absolute ocultar" id="estado_mTicket" style="top: 1.4rem; left: 1.4rem;"></div>
            <div class="modal-body p-0">
                <div class="col-12 text-center mb-6">
                    <h4 class="mb-2 d-flex justify-content-center align-items-center"><span id="tituloModal_mTicket">Nuevo ticket</span><span id="btnCopiarTitulo_mTicket"></span></h4>
                    <p class="mb-1" id="subtitulo_mTicket">Creacion de ticket nuevo, completar formulario</p>
                    <p class="m-0 ocultar" id="asignadoPor_mTicket"></p>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-md-12 col-lg-12" id="containerGeneralGeneral_mTicket">
                            <div class="nav-align-top col-12 mb-6">
                                <ul id="tabs_mTicket" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabGeneral_mTicket"
                                            aria-controls="tabGeneral_mTicket"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-survey-line me-2"></i> General</span>
                                            <i class="ri-survey-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mTicket" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false">

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <input type="text" id="titulo_mTicket" class="form-control campos_mTicket camposObli_mTicket" placeholder="Titulo" />
                                                <label for="titulo_mTicket">Titulo</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6 position-relative" id="containerCliente_mTicket">
                                            <div id="btnAbrirSistema_mTicket" class="position-absolute" style="top: 5px; right: 2rem; z-index: 10;"></div>
                                            <div class="form-floating form-floating-outline">
                                                <select id="cliente_mTicket" class="form-select select2_mTicket campos_mTicket camposObli_mTicket"></select>
                                                <label for="cliente_mTicket">Cliente</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6 containersSoporte_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <select id="asignar_mTicket" class="form-select select2_mTicket campos_mTicket"></select>
                                                <label for="asignar_mTicket">Asignado a</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12" id="containerPrioridad_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <select id="prioridad_mTicket" class="form-select select2_mTicket campos_mTicket camposObli_mTicket" onchange="appTicketModal.onChangePrioridad(this)"></select>
                                                <label for="prioridad_mTicket">SLA</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-6 col-lg-6 ocultar" id="containerFechaLimite_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <input class="form-control campos_mTicket" type="datetime-local" id="fechaLimite_mTicket">
                                                <label for="fechaLimite_mTicket">Fecha limite</label>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <select id="tipoTicket_mTicket" class="form-select select2_mTicket campos_mTicket camposObli_mTicket"></select>
                                                <label for="tipoTicket_mTicket">Modulo/Circuito</label>
                                                <div class="invalid-feedback">Debe seleccionar al menos uno</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control campos_mTicket camposObli_mTicket h-px-100" id="descripcion_mTicket" placeholder="Descipción"></textarea>
                                                <label for="descripcion_mTicket">Descipción</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            </div>

                        </div>
                        <div class="col-12 col-md-12 col-lg-6 ocultar" id="containerGeneralFeedback_mTicket">
                            <div class="nav-align-top col-12 mb-6">
                                <ul id="tabs_mTicket" class="nav nav-tabs nav-fill" role="tablist">
                                    <li class="nav-item">
                                        <button
                                            type="button"
                                            class="nav-link active"
                                            role="tab"
                                            data-bs-toggle="tab"
                                            data-bs-target="#tabGeneral_mTicket"
                                            aria-controls="tabGeneral_mTicket"
                                            aria-selected="true">
                                            <span class="d-none d-sm-block"><i class="tf-icons ri-feedback-line me-2"></i>Feedback</span>
                                            <i class="ri-feedback-line ri-20px d-sm-none"></i>
                                        </button>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content p-0">
                                <div class="tab-pane fade show active" id="tabGeneral_mTicket" role="tabpanel">
                                    <form class="row g-5 align-items-baseline" onsubmit="return false" id="containerGeneralInputsFeedback_mTicket">

                                        <div class="col-12 col-md-12 col-lg-12 containersInputFeedback_mTicket" id="containerDevolucion_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control camposFeedback_mTicket" style="height: 176px;" data-tipoComentario="2" id="devolucion_mTicket" placeholder="Completar"></textarea>
                                                <label for="devolucion_mTicket">Devolucion a soporte</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 containersInputFeedback_mTicket" id="containerQueHice_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control camposFeedback_mTicket" style="height: 176px;" data-tipoComentario="3" id="queHice_mTicket" placeholder="Completar"></textarea>
                                                <label for="queHice_mTicket">Que se hizo</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
                                            </div>
                                        </div>

                                        <div class="col-12 col-md-12 col-lg-12 containersInputFeedback_mTicket" id="containerFeedback_mTicket">
                                            <div class="form-floating form-floating-outline">
                                                <textarea class="form-control camposFeedback_mTicket" style="height: 176px;" data-tipoComentario="4" id="feedback_mTicket" placeholder="Completar"></textarea>
                                                <label for="feedback_mTicket">Feedback</label>
                                                <div class="invalid-feedback">Debe completar el campo</div>
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
                            <button type="button" class="btn btn-outline-dark w-100" onclick="appTicketModal.cerrarModal()">Volver</button>
                        </div>
                        <div class="col-12 col-md-12 col-lg-10">
                            <div class="row justify-content-end g-3">

                                <div class="containersDesarrollo_mTicket containersVerTicket_mTicket d-flex justify-content-end">
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-warning me-3" onclick="appTicketModal.renderCambioEstado(1)" data-bs-toggle="tooltip" data-bs-placement="top" title="Desestimar">
                                        <i class="tf-icons ri-delete-back-2-line ri-22px"></i>
                                    </button>
                                    <button type="button" class="btn btn-icon rounded-pill btn-label-success" onclick="appTicketModal.renderCambioEstado(2)" data-bs-toggle="tooltip" data-bs-placement="top" title="Resolver">
                                        <i class="tf-icons ri-check-line ri-22px"></i>
                                    </button>
                                </div>

                                <div class="containersSoporte_mTicket containersVerTicket_mTicket d-flex justify-content-end">
                                    <button id="btnEditarTicket_mTicket" type="button" class="btn btn-icon rounded-pill btn-label-success me-3" onclick="appTicketModal.editarTicket()" data-bs-toggle="tooltip" data-bs-placement="top" title="Editar ticket">
                                        <i class="tf-icons ri-edit-line ri-22px"></i>
                                    </button>
                                    <button id="btnEliminarTicket_mTicket" type="button" class="btn btn-icon rounded-pill btn-label-danger" onclick="appTicketModal.eliminar()" data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                        <i class="tf-icons ri-delete-bin-6-line ri-22px"></i>
                                    </button>
                                    <button id="btnCerrarTicket_mTicket" type="button" class="btn btn-icon rounded-pill btn-label-info ms-3" onclick="appTicketModal.renderCambioEstado(3)" data-bs-toggle="tooltip" data-bs-placement="top" title="Cerrar">
                                        <i class="tf-icons ri-check-double-line ri-22px"></i>
                                    </button>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3" id="containerBtnGuardar_mTicket">
                                    <button type="button" class="btn btn-success w-100" onclick="appTicketModal.guardar()">Guardar</button>
                                </div>

                                <div class="col-12 col-md-6 col-lg-3 ocultar containersBtnModificar_mTicket">
                                    <button type="button" class="btn btn-outline-danger w-100" onclick="appTicketModal.editarTicket(2)">Cancelar</button>
                                </div>

                                <div class="col-12 col-md-12 col-lg-4 ocultar containersBtnModificar_mTicket">
                                    <button type="button" class="btn btn-success w-100" onclick="appTicketModal.editar()">Modificar</button>
                                </div>

                                <div class="col-12 col-md-12 col-lg-12" id="containerBtnsFooter_mTicket"></div>

                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>