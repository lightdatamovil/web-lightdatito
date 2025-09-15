<script>
    const globalValidar = (function() {

        const public = {};

        public.vacio = function({
            id
        }) {
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


        public.sinCaracteresEspeciales = function({
            id
        }) {
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

        public.soloLetras = function({
            id
        }) {
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

        public.letrasYEspacios = function({
            id
        }) {
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


        public.soloNumeros = function({
            id
        }) {
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

        public.email = function({
            id
        }) {
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

        public.carecteresMinimos = function({
            id,
            minimo
        }) {
            value = $(`#${id}`).val().trim();
            mensaje = $(`#${id}`).siblings('.invalid-feedback');

            if (value.length < minimo) {
                $(`#${id}`).addClass('is-invalid');
                mensaje.text(`El campo debe tener al menos ${minimo} caracteres`);
                return true
            } else {
                $(`#${id}`).removeClass('is-invalid');
                return false
            }
        };

        public.coincideContraseña = function({
            idOriginal,
            idCopia
        }) {
            value = $(`#${idOriginal}`).val().trim();
            value2 = $(`#${idCopia}`).val().trim();
            mensaje = $(`#${idOriginal}`).siblings('.invalid-feedback');
            mensaje2 = $(`#${idCopia}`).siblings('.invalid-feedback');


            if (value !== value2) {
                $(`#${idOriginal}, #${idCopia}`).addClass('is-invalid');
                mensaje.text("Las contraseñas no coinciden");
                mensaje2.text("Las contraseñas no coinciden");
                return true
            } else {
                $(`#${idOriginal}, #${idCopia}`).removeClass('is-invalid');
                return false
            }
        };


        public.formulario = function({
            idForm
        }) {
            return $(`#${idForm} .is-invalid`).length > 0;
        };


        public.limpiarTodas = function() {
            $(".is-invalid").removeClass('is-invalid')
        }

        public.habilitarTiempoReal = function({
            className,
            callback
        }) {
            $(`.${className}`).each(function() {
                if ($(this).is("select")) {
                    $(this).on("change", function() {
                        callback();
                    });
                } else {
                    $(this).on("keyup", function() {
                        callback();
                    });
                }
            });
        }

        public.deshabilitarTiempoReal = function({
            className
        }) {
            $(`.${className}`).each(function() {
                if ($(this).is("select")) {
                    $(this).off("change");
                } else {
                    $(this).off("keyup");
                }
            });
        }

        public.obligatorios = function({
            className
        }) {
            let faltanCampos = false

            $(`.${className}`).each(function() {
                if (globalValidar.vacio({
                        id: this["id"]
                    })) faltanCampos = true;
            });

            return faltanCampos
        }


        public.obtenerCambios = function({
            dataNueva,
            dataOriginal
        }) {
            const cambios = {};
            Object.keys(dataNueva).forEach(key => {
                const nuevo = dataNueva[key];
                const original = dataOriginal[key];

                if (!_.isEqual(nuevo, original)) {
                    cambios[key] = nuevo;
                }
            });
            return cambios;
        }


        return public;
    })();
</script>