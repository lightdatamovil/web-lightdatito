<script>
    const globalValidar = (function() {

        const public = {};

        public.vacio = function(id) {
            const $elemento = $(`#${id}`);
            let value = $elemento.val();
            value = Array.isArray(value) ? value.join(', ') : value;
            const mensaje = $elemento.siblings('.invalid-feedback');

            if (value === "" || value === null) {
                $elemento.addClass('is-invalid');

                if ($elemento.is('select')) {
                    mensaje.text("Debe seleccionar al menos uno");
                } else {
                    mensaje.text("Debe completar el campo");
                }

                return true;
            } else {
                $elemento.removeClass('is-invalid');
                return false;
            }
        };


        public.sinCaracteresEspeciales = function(id) {
            let value = $(`#${id}`).val().trim();
            let mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-z0-9]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras minúsculas y números");
                return true;
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false;
            }
        };

        public.soloLetras = function(id) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-zA-Z]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras");
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.letrasYEspacios = function(id) {
            let value = $(`#${id}`).val().trim();
            let mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten letras y espacios");
                return true;
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false;
            }
        };


        public.soloNumeros = function(id) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/[^0-9]/)) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Solo se permiten números");
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.email = function(id) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.match(/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/)) {
                $(`#${id}`).removeClass('is-invalid');
                return false
            } else {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text("Ingrese un email válido");
                return true
            }
        };

        public.minCaracteres = function(id, min) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.length < min) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text(`El campo debe tener al menos ${min} caracteres`);
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.coincideContraseña = function(id, id2) {
            value = $(`#${id}`).val().trim();
            value2 = $(`#${id2}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');
            mensaje2 = $(`#${id2}`).siblings('.invalid-feedback');


            if (value !== value2) {
                $(`#${id}`).addClass('is-invalid');
                $(`#${id2}`).addClass('is-invalid');
                mensaje.text("Las contraseñas no coinciden");
                mensaje2.text("Las contraseñas no coinciden");
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                $(`#${id2}`).removeClass('is-invalid');
                return false
            }
        };


        public.formulario = function(formId) {
            return $(`#${formId} .is-invalid`).length > 0;
        };


        public.limpiarTodas = function() {
            $(".is-invalid").removeClass('is-invalid')
        }

        public.habilitarTiempoReal = function(id, validacion) {
            $(`.${id}`).each(function() {
                if ($(this).is("select")) {
                    $(this).on("change", function() {
                        validacion();
                    });
                } else {
                    $(this).on("keyup", function() {
                        validacion();
                    });
                }
            });
        }

        public.deshabilitarTiempoReal = function(id) {
            $(`.${id}`).each(function() {
                if ($(this).is("select")) {
                    $(this).off("change");
                } else {
                    $(this).off("keyup");
                }
            });
        }

        public.obligatorios = function(id) {
            let faltanCampos = false

            $(`.${id}`).each(function() {
                if (globalValidar.vacio(this["id"])) faltanCampos = true;
            });

            return faltanCampos
        }


        return public;
    })();
</script>