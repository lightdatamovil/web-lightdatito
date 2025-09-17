<script>
    const appOffCanvasTicket = (function() {
        const public = {}

        public.open = function() {
            globalActivarAcciones.toggleOffcanvas({
                id: "offcanvasEnd"
            })
        }

        return public
    })()
</script>