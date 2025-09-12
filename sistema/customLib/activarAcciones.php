<script>
    const globalActivarAcciones = (function() {

        const public = {}

        public.tooltips = function(id) {
            const nuevosTooltips = document.querySelectorAll(`#${id} [data-bs-toggle="tooltip"]`);
            nuevosTooltips.forEach(el => {
                if (!el.hasAttribute('data-bs-initialized')) {
                    const tooltip = new bootstrap.Tooltip(el, {
                        trigger: 'hover'
                    });

                    el.addEventListener('click', () => {
                        tooltip.hide();
                    });

                    el.setAttribute('data-bs-initialized', 'true');
                }
            });
        }

        // ASI SE USA EL TOOLTIP
        // <button type="button" class="btn btn-icon btn-label-danger" data-bs-toggle="tooltip" data-bs-placement="top" title="Texto"></button>`
        // globalActivarAcciones.tooltips("ID DEL MODULO/MODAL") 

        public.select2 = function(selector) {
            $(`.${selector}`).each(function() {
                if ($(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2('destroy');
                }

                const $modalParent = $(this).closest('.modal');

                if ($modalParent.length) {
                    $(this).select2({
                        dropdownParent: $modalParent,
                        dropdownCssClass: 'select2-inside-modal',
                        width: '100%'
                    });
                } else {
                    $(this).select2({
                        width: '100%'
                    });
                }
            });
        }


        public.activarPrimerTab = function(tab) {
            bootstrap.Tab.getInstance($(`#${tab} li:first-child button`)).show()
            $(`#${tab} .tab-slider`).css("left", "0")
        }

        public.mostrarOcultarTab = function(tab, opcion) {
            if (opcion == 0) {
                const li = document.querySelector(`li.nav-item button[data-bs-target="#${tab}"]`).parentElement;
                li.classList.add(`d-none`);
            } else {
                const li = document.querySelector(`li.nav-item button[data-bs-target="#${tab}"]`).parentElement;
                li.classList.remove(`d-none`);
            }

        }

        public.filtrarConEnter = function(selectorInputs, callback) {
            $(`.${selectorInputs}`).each(function() {
                $(this).off("keydown._enterFiltro");
                $(this).on("keydown._enterFiltro", function(e) {
                    if (e.key === "Enter") {
                        e.preventDefault();
                        if (typeof callback === "function") {
                            callback();
                        }
                    }
                });
            });
        }


        return public
    }())
</script>