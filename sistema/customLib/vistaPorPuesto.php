<script>
    const vistaPorPuesto = (function() {

        const public = {}

        public.ver = function(vista) {
            switch (vista) {
                case "soporte":
                    return (
                        !appSistema.userPuesto.includes(1) || (appSistema.userPuesto.includes(1) && appSistema.userPuesto.length > 1)
                    );
                case "desarrollo":
                    return appSistema.userPuesto.includes(1) || appSistema.userPuesto.includes(5);
                default:
                    return false;
            }
        }

        return public
    }())
</script>