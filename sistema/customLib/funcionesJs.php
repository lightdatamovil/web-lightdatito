<script>
    const globalFuncionesJs = (function() {

        const public = {}

        public.compararDosObjetos = function(a, b) {
            if (a === b) return true;

            if (typeof a !== 'object' || typeof b !== 'object' || a == null || b == null) {
                return false;
            }

            const keysA = Object.keys(a);
            const keysB = Object.keys(b);

            if (keysA.length !== keysB.length) return false;

            for (let key of keysA) {
                if (!keysB.includes(key)) return false;
                if (!globalFuncionesJs.compararDosObjetos(a[key], b[key])) return false;
            }

            return true;
        }

        public.convertirPrecio = function(precio) {
            if (!precio) return "$0"

            return new Intl.NumberFormat('es-AR', {
                style: 'currency',
                currency: 'ARS',
                minimumFractionDigits: 2,
            }).format(precio);
        }

        public.formatearFecha = function({
            fecha
        }) {
            if (!fecha) return fecha
            const fechaMod = new Date(fecha);

            const dia = String(fechaMod.getDate()).padStart(2, '0');
            const mes = String(fechaMod.getMonth() + 1).padStart(2, '0');
            const anio = fechaMod.getFullYear();

            const horas = String(fechaMod.getHours()).padStart(2, '0');
            const minutos = String(fechaMod.getMinutes()).padStart(2, '0');

            return `${dia}/${mes}/${anio} ${horas}:${minutos}`;
        }

        public.formatearFechaParaDatetimeLocal = function(fechaUTC) {
            if (!fechaUTC) return fechaUTC
            const fecha = new Date(fechaUTC);

            const year = fecha.getFullYear();
            const month = String(fecha.getMonth() + 1).padStart(2, "0");
            const day = String(fecha.getDate()).padStart(2, "0");
            const hours = String(fecha.getHours()).padStart(2, "0");
            const minutes = String(fecha.getMinutes()).padStart(2, "0");

            return `${year}-${month}-${day}T${hours}:${minutes}`;
        }

        public.copiarTexto = function({
            event,
            copiar
        }) {
            event.stopPropagation();
            navigator.clipboard.writeText(copiar)
        }

        public.copiarYRedirigir = function({
            event,
            copiar,
            redirigir
        }) {
            event.stopPropagation();
            navigator.clipboard.writeText(copiar)
            window.open(redirigir, "_blank");
        }

        return public;

    }())
</script>