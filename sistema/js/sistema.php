<script>
    let sistemaIniciado = false;
    const appSistema = {

        urlServer: "https://node1.liit.com.ar/api",
        userName: localStorage.getItem("userN"),
        userId: localStorage.getItem("userI") * 1,
        userPuesto: JSON.parse(localStorage.getItem("userPuesto")),

        tkn: localStorage.getItem("tkn"),

        dbLogisticas: [],
        dbUsuarios: [],
        dbPrioridades: [],
        dbEstadosTicket: [],
        dbTipoTicket: [],

        inicializar: async function() {
            if (sistemaIniciado) return;
            sistemaIniciado = true;
            await globalLoading.open();
            await this.activarComponentes()

            await this.cargarDatos();

            console.log("Sistema inicializado");
            await globalLoading.close();
        },


        activarComponentes: async function() {
            const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
            [...tooltipTriggerList].map(el => new bootstrap.Tooltip(el));
        },

        cargarDatos: async function() {
            try {
                const response = await fetch(`${this.urlServer}/init`, {
                    headers: {
                        "Authorization": `Bearer ${this.tkn}`
                    }
                });
                const data = await response.json();
                if (data.success) {
                    this.dbLogisticas = data.body.logisticas
                    this.dbUsuarios = data.body.usuarios
                    this.dbPrioridades = data.body.prioridades
                    this.dbEstadosTicket = data.body.estados_ticket
                    this.dbTipoTicket = data.body.tipo_ticket

                } else {
                    globalSweetalert.error(`Error: ${data.message}`)
                }
            } catch (error) {
                console.error(`Error al cargar datos iniciales:`, error);
                globalSweetalert.error("Error al cargar datos iniciales")

            }
        },

        desloguear: async function() {
            try {
                const response = await fetch("users/deslogin.php");
                const data = await response.json();

                if (data.estado === true) {
                    location.reload();
                } else {
                    console.warn("Logout fallido:", data.mensaje);
                }
            } catch (error) {
                console.error("Error al cerrar sesión:", error);
            }
        },

        get estadosTickets() {
            return this.dbEstadosTicket;
        },

        get prioridades() {
            return this.dbPrioridades;
        },

        get logisticas() {
            return this.dbLogisticas;
        },

        get usuarios() {
            return this.dbUsuarios;
        },

        get tipoTicket() {
            return this.dbTipoTicket;
        },

    };

    // document.addEventListener("DOMContentLoaded", () => {
    //     appSistema.inicializar();
    // });
</script>