<script>
    const globalSweetalert = (function() {

        const public = {};

        public.confirmar = function(titulo, color, btnConfirmar, btnCancelar) {
            return Swal.fire({
                title: titulo || "¿Estás seguro?",
                icon: "warning",
                iconColor: color || "var(--bs-primary)",
                showConfirmButton: true,
                showCancelButton: true,
                showDenyButton: false,
                confirmButtonText: btnConfirmar || "Sí",
                cancelButtonText: btnCancelar || "Volver",
                customClass: {
                    confirmButton: "btn btn-primary",
                    cancelButton: "btn btn-secondary"
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    return true;
                }
            })
        }

        public.alert = function(titulo, color, time) {
            Swal.fire({
                title: titulo || "Completar proceso",
                icon: "warning",
                iconColor: color || "var(--bs-primary)",
                showConfirmButton: false,
                timer: time || 1500,
            })
        }

        public.error = function(titulo, color, time) {
            Swal.fire({
                title: titulo || "Error al actualizar",
                icon: "error",
                iconColor: color || "var(--bs-danger)",
                showConfirmButton: false,
                timer: time || 1500,
            })
        }

        public.exito = function(titulo, color, time) {
            Swal.fire({
                title: titulo || "Guardado con exito!",
                icon: "success",
                iconColor: color || "var(--bs-success)",
                showConfirmButton: false,
                timer: 1500,
            })
        }

        public.notificacion = function(titulo, color, time) {
            const Toast = Swal.mixin({
                toast: true,
                position: "bottom-end",
                showConfirmButton: false,
                timer: time || 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.onmouseenter = Swal.stopTimer
                    toast.onmouseleave = Swal.resumeTimer
                },
            })
            Toast.fire({
                icon: "warning",
                title: titulo || `Alerta!`,
                iconColor: color || "var(--bs-warning)",
            })
        }

        public.redireccion = function(titulo, color, subtitulo, boton, accion) {
            Swal.fire({
                icon: "success",
                title: titulo || "Realizado con exito!",
                text: subtitulo || "",
                footer: `<a style="cursor: pointer;font-weight: bolder;color: ${color || "var(--bs-primary)"};font-size: 16px;" onclick="Swal.close(); ${accion || ""}">${boton || "Redirigir"}</a>`,
                iconColor: color || "var(--bs-primary)",
                confirmButtonText: "Volver",
                showDenyButton: false,
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false
            });
        }

        public.redireccionObligada = function(titulo, color, boton, accion) {
            Swal.fire({
                icon: "warning",
                title: titulo || "Realizado con éxito!",
                html: `<a style="cursor: pointer; font-weight: bolder; color: ${color || "var(--bs-primary)"}; font-size: 16px;" onclick="Swal.close(); ${accion || ""}">${boton || "Redirigir"}</a>`,
                iconColor: color || "var(--bs-primary)",
                showConfirmButton: false,
                showDenyButton: false,
                showCancelButton: false,
                buttonsStyling: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false
            });
        };

        public.html = function(titulo, color, html) {
            Swal.fire({
                icon: "success",
                title: titulo || "Realizado con exito!",
                html: html || "",
                iconColor: color || "var(--bs-success)",
                confirmButtonText: "Volver",
                showDenyButton: false,
                showCancelButton: false,
                customClass: {
                    confirmButton: "btn btn-primary",
                },
                buttonsStyling: false
            });
        }


        return public;
    })();
</script>

<style>
    .swal2-popup.swal2-toast {
        background: #30334e;
        padding: 5px 20px;
    }
</style>