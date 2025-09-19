<script>
    const globalLlenarSelect = (function() {

        const public = {}

        public.estadosTickets = function({
            id,
            multiple = false
        }) {
            if (appSistema.estadosTickets.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin estados</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar estados</option>`
            }

            for (estado of appSistema.estadosTickets) {
                buffer += `<option value="${estado["id"]}">${estado["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.prioridades = function({
            id,
            multiple = false
        }) {
            if (appSistema.prioridades.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin SLA</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar SLA</option>`
            }

            for (prioridad of appSistema.prioridades) {
                buffer += `<option value="${prioridad["id"]}">${prioridad["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }


        public.paises = function({
            id,
            multiple = false
        }) {
            if (appSistema.paises.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin paises</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar pais</option>`
            }

            for (pais of appSistema.paises) {
                buffer += `<option value="${pais["id"]}">${pais["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.planes = function({
            id,
            multiple = false
        }) {
            if (appSistema.planes.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin planes</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar plan</option>`
            }

            for (plan of appSistema.planes) {
                buffer += `<option value="${plan["id"]}">${plan["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.proyectos = function({
            id,
            multiple = false
        }) {
            if (appSistema.proyectos.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin proyectos</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar proyecto</option>`
            }

            for (proyecto of appSistema.proyectos) {
                buffer += `<option value="${proyecto["id"]}">${proyecto["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }


        public.clientes = function({
            id,
            multiple = false
        }) {
            if (appSistema.clientes.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin clientes</option>`)
                return
            }

            let buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar cliente</option>`
            }

            const listaOrdenada = [...appSistema.clientes].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (const cliente of listaOrdenada) {
                buffer += `<option value="${cliente.id}">${cliente.nombre || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.usuarios = function({
            id,
            multiple = false
        }) {
            if (appSistema.usuarios.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin usuarios</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar usuario</option>`
            }

            const listaOrdenada = [...appSistema.usuarios].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (usuario of listaOrdenada) {
                buffer += `<option value="${usuario["id"]}">${usuario["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }


        public.desarrolladores = function({
            id,
            multiple = false
        }) {
            desarrolladores = appSistema.usuarios.filter(user => user.puestos.find((puesto) => puesto.id == 1))

            if (desarrolladores.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin desarrolladores</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar desarrollador</option>`
            }

            const listaOrdenada = [...desarrolladores].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (desarrollador of listaOrdenada) {
                buffer += `<option value="${desarrollador["id"]}">${desarrollador["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.boxStaff = function({
            id,
            multiple = false
        }) {
            boxStaff = appSistema.usuarios.filter(user => user.puestos.find((puesto) => puesto.id == 5))

            if (boxStaff.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin boxStaff</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar box staff</option>`
            }

            const listaOrdenada = [...boxStaff].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (staff of boxStaff) {
                buffer += `<option value="${staff["id"]}">${staff["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.usuariosAsignables = function({
            id,
            multiple = false
        }) {
            usuariosAsignables = appSistema.usuarios.filter(user => user.puestos.find((puesto) => puesto.id == 1 || puesto.id == 5))

            if (usuariosAsignables.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin usuarios</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar usuario</option>`
            }

            const listaOrdenada = [...usuariosAsignables].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (usuario of usuariosAsignables) {
                buffer += `<option value="${usuario["id"]}">${usuario["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        public.tiposTickets = function({
            id,
            multiple = false
        }) {
            if (appSistema.tipoTicket.length == 0) {
                $(`#${id}`).html(`<option value="" ${multiple ? "" : "selected"} disabled>Sin opciones</option>`)
                return
            }

            buffer = ""
            if (!multiple) {
                buffer = `<option value="" selected>Seleccionar</option>`
            }

            const listaOrdenada = [...appSistema.tipoTicket].sort((a, b) => {
                const nombreA = (a.nombre || "").toLowerCase()
                const nombreB = (b.nombre || "").toLowerCase()
                return nombreA.localeCompare(nombreB)
            })

            for (estado of listaOrdenada) {
                buffer += `<option value="${estado["id"]}">${estado["nombre"] || "Sin nombre"}</option>`
            }

            $(`#${id}`).html(buffer)
        }

        return public
    }())
</script>