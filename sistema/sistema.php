<script>
    let sistemaIniciado = false;
    const appSistema = {

        urlServer: "https://node1.liit.com.ar/api",
        userName: localStorage.getItem("userName"),
        userId: localStorage.getItem("userId") * 1,
        userPuesto: JSON.parse(localStorage.getItem("userPuesto")),
        authToken: localStorage.getItem("authToken"),
        logisticas: [],
        usuarios: [],
        prioridades: [],
        estadosTickets: [],
        tipoTicket: [],

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
            await globalRequest.get(`/init`, {
                onSuccess: (result) => {
                    this.logisticas = result.body.logisticas
                    this.usuarios = result.body.usuarios
                    this.prioridades = result.body.prioridades
                    this.estadosTickets = result.body.estados_ticket
                    this.tipoTicket = result.body.tipo_ticket
                },
            });
        },

        logout: async function() {
            try {
                const response = await fetch("login/logout.php");
                const data = await response.json();

                if (data.estado === true) {
                    localStorage.removeItem("horaInicioSesion");
                    location.reload();
                } else {
                    console.warn("Logout fallido:", data.mensaje);
                }
            } catch (error) {
                console.error("Error al cerrar sesión:", error);
            }
        },

        expirarSesion: async function() {
            const ahora = Date.now();
            let horaInicio = localStorage.getItem("horaInicioSesion");

            if (!horaInicio) {
                localStorage.setItem("horaInicioSesion", ahora);
                horaInicio = ahora;
            }

            const tiempoTranscurrido = ahora - horaInicio;
            const ochoHoras = 8 * 60 * 60 * 1000;

            const tiempoRestante = Math.max(ochoHoras - tiempoTranscurrido, 0);

            const redirigirYLimpiar = "appSistema.logout();"

            if (tiempoTranscurrido >= ochoHoras) {
                globalSweetalert.redireccionObligada({
                    titulo: "Su sesión ha expirado, por favor vuelva a iniciar sesión",
                    boton: "Ir a login",
                    accion: redirigirYLimpiar
                });
            } else {
                setTimeout(() => {
                    globalSweetalert.redireccionObligada({
                        titulo: "Su sesión ha expirado, por favor vuelva a iniciar sesión",
                        boton: "Ir a login",
                        accion: redirigirYLimpiar
                    });
                }, tiempoRestante);
            }
        },
    };

    // document.addEventListener("DOMContentLoaded", () => {
    //     appSistema.inicializar();
    // });
</script>