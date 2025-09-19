 <div class="offcanvas offcanvas-end" tabindex="-1" id="offCanvas_oTickets">
     <button type="button" class="btn-close position-absolute top-0 end-0 m-5" data-bs-dismiss="offcanvas"></button>
     <div class="offcanvas-body text-center d-flex flex-column justify-content-evenly">
         <div class="d-flex flex-column gap-2">
             <i class="ri-refresh-line text-primary" style="font-size: 55px;"></i>
             <h4 class="lh-sm m-0 text-primary">Actualización de estado</h4>
         </div>
         <div>
             <form class="row g-5 align-items-baseline" onsubmit="return false">
                 <div class="col-12 col-md-12 col-lg-12 containerInput_oTickets" id="containerDevolucion_oTickets">
                     <div class="form-floating form-floating-outline">
                         <textarea class="form-control inputs_oTickets" style="height: 250px;" id="devolucion_oTickets" placeholder="Agregar un cometario..."></textarea>
                         <label for="devolucion_oTickets">Devolucion a soporte</label>
                     </div>
                 </div>

                 <div class="col-12 col-md-12 col-lg-12 containerInput_oTickets" id="containerQueHice_oTickets">
                     <div class="form-floating form-floating-outline">
                         <textarea class="form-control inputs_oTickets" style="height: 250px;" id="queHice_oTickets" placeholder="Agregar un cometario..."></textarea>
                         <label for="queHice_oTickets">Que hice</label>
                     </div>
                 </div>

                 <div class="col-12 col-md-12 col-lg-12 containerInput_oTickets" id="containerFeedback_oTickets">
                     <div class="form-floating form-floating-outline">
                         <textarea class="form-control inputs_oTickets" style="height: 500px;" id="feedback_oTickets" placeholder="Agregar un cometario..."></textarea>
                         <label for="feedback_oTickets">Feedback</label>
                     </div>
                 </div>

                 <div class="col-12 col-md-12 col-lg-12 containerInput_oTickets" id="containerDevolver_oTickets">
                     <div class="form-floating form-floating-outline">
                         <textarea class="form-control inputs_oTickets" style="height: 500px;" id="devolver_oTickets" placeholder="Agregar un cometario..."></textarea>
                         <label for="devolver_oTickets">Devolución</label>
                     </div>
                 </div>
             </form>
         </div>
         <div>
             <button id="btnResolver_oTickets" type="button" class="btn rounded-pill btn-label-success waves-effect btn_oTickets">
                 <i class="tf-icons ri-check-line ri-22px me-2"></i>Resolver ticket
             </button>
             <button id="btnDesestimar_oTickets" type="button" class="btn rounded-pill btn-label-warning waves-effect btn_oTickets">
                 <i class="tf-icons ri-delete-back-2-line ri-22px me-2"></i>Desestimar ticket
             </button>
             <button id="btnCerrar_oTickets" type="button" class="btn rounded-pill btn-label-info waves-effect btn_oTickets">
                 <i class="tf-icons ri-check-double-line ri-22px me-2"></i>Cerrar ticket
             </button>
             <button id="btnDevolver_oTickets" type="button" class="btn rounded-pill btn-label-dark waves-effect btn_oTickets">
                 <i class="tf-icons ri-arrow-go-back-line ri-18px me-2"></i>Devolver ticket a desarrollo
             </button>

         </div>
     </div>
 </div>