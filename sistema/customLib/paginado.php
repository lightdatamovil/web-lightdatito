<script>
    const globalPaginado = (function() {

        const public = {}

        public.generarPaginado = function({
            contenedorId,
            paginaActual,
            totalPaginas,
            onPageChange,
        }) {

            maxPaginasVisibles = 5
            const contenedor = document.getElementById(contenedorId);

            if (!contenedor) return;

            contenedor.innerHTML = "";

            if (totalPaginas < 2) return

            const ul = document.createElement("ul");
            ul.className = "pagination pagination-rounded m-0 p-0 d-flex justify-content-center align-items-center gap-2 flex-wrap";

            function crearItem(pagina, label, disabled = false, active = false) {
                const li = document.createElement("li");
                li.className = `page-item ${active ? "active" : ""} ${disabled ? "disabled" : ""}`;

                const a = document.createElement("a");
                a.className = "page-link m-0";
                a.href = "javascript:void(0);";
                a.innerHTML = label;

                if (!disabled && !active) {
                    a.addEventListener("click", () => {
                        if (pagina >= 1 && pagina <= totalPaginas) {
                            onPageChange(pagina);
                        }
                    });
                }

                li.appendChild(a);
                return li;
            }

            // Botones de navegación
            ul.appendChild(crearItem(1, `<i class="tf-icon ri-skip-back-mini-line ri-20px"></i>`, paginaActual === 1));
            ul.appendChild(crearItem(paginaActual - 1, `<i class="tf-icon ri-arrow-left-s-line ri-20px"></i>`, paginaActual === 1));

            // Lógica para limitar cantidad de páginas visibles
            let mitad = Math.floor(maxPaginasVisibles / 2);
            let inicio = Math.max(1, paginaActual - mitad);
            let fin = Math.min(totalPaginas, inicio + maxPaginasVisibles - 1);

            // Ajustar si estamos al final
            if (fin - inicio + 1 < maxPaginasVisibles) {
                inicio = Math.max(1, fin - maxPaginasVisibles + 1);
            }

            for (let i = inicio; i <= fin; i++) {
                ul.appendChild(crearItem(i, i, false, i === paginaActual));
            }

            ul.appendChild(crearItem(paginaActual + 1, `<i class="tf-icon ri-arrow-right-s-line ri-20px"></i>`, paginaActual === totalPaginas));
            ul.appendChild(crearItem(totalPaginas, `<i class="tf-icon ri-skip-forward-mini-line ri-20px"></i>`, paginaActual === totalPaginas));

            contenedor.appendChild(ul);
        }

        public.generarFooter = function({
            idBase,
            totalRegistros,
            totalPaginas,
            paginaActual,
            limitePorPagina,
            onPageChange,
            onLimiteChange,
        }) {
            if (!$(`#footer${idBase}`)) return;

            buffer = ""
            buffer += `<div class="col-12">`
            buffer += `<div class="row">`

            buffer += `<div class="col-12 col-md-3 col-lg-4 mb-3 mb-md-0">`
            buffer += `<div class="row">`
            buffer += `<div class="d-flex flex-column gap-1">`
            buffer += `<p class="m-0" style="color: #7b7c95;">`
            buffer += `Total de registros: <span id="totalRegistros${idBase}" class="badge badge-center rounded-pill bg-label-primary" style="width: auto;min-width: 1.5rem;">${totalRegistros || 0}</span>`
            buffer += `</p>`
            buffer += `<p class="m-0" style="color: #7b7c95;">`
            buffer += `Total de páginas: <span id="totalPaginas${idBase}" class="badge badge-center rounded-pill bg-label-primary" style="width: auto;min-width: 1.5rem;">${totalPaginas || 0}</span>`
            buffer += `</p>`
            buffer += `</div>`
            buffer += `</div>`
            buffer += `</div>`


            buffer += `<div class="col-12 col-md-6 col-lg-4 mb-3 mb-md-0">`
            buffer += `<div class="row align-items-center h-100 justify-content-center" id="paginacion${idBase}"></div>`
            buffer += `</div>`


            buffer += `<div class="col-12 col-md-3 col-lg-4">`
            buffer += `<div class="row align-items-center h-100 justify-content-end">`
            if (totalRegistros > 5) {
                buffer += `<div class="col-12 col-md-12 col-lg-4 form-floating form-floating-outline">`
                buffer += `<select id="filtroMostrar${idBase}" class="form-select">`
                buffer += `<option value="5">5</option>`
                if (totalRegistros > 10) {
                    buffer += `<option vaxlue="10" ${limitePorPagina == 10 ? "selected" : ""}>10</option>`
                }
                if (totalRegistros > 25) {
                    buffer += `<option value="25" ${limitePorPagina == 25 ? "selected" : ""}>25</option>`
                }
                if (totalRegistros > 50) {
                    buffer += `<option value="50" ${limitePorPagina == 50 ? "selected" : ""}>50</option>`
                }
                if (totalRegistros > 100) {
                    buffer += `<option value="100" ${limitePorPagina == 100 ? "selected" : ""}>100</option>`
                }
                if (totalRegistros < 100) {
                    buffer += `<option value="${totalRegistros}" ${limitePorPagina == totalRegistros ? "selected" : ""}>Todos</option>`
                }

                buffer += `</select>`
                buffer += `<label for="filtroMostrar${idBase}">Mostrar</label>`
                buffer += `</div>`
            }
            buffer += `</div>`
            buffer += `</div>`

            buffer += `</div></div>`

            $(`#footer${idBase}`).html(buffer)

            globalPaginado.generarPaginado({
                contenedorId: `paginacion${idBase}`,
                paginaActual,
                totalPaginas,
                onPageChange
            });

            $(`#filtroMostrar${idBase}`).change(function() {
                nuevoLimite = parseInt($(this).val());
                onLimiteChange(nuevoLimite);
            });
        };


        return public;

    })();
</script>