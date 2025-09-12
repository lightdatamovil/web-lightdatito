<style>
    .ocultar {
        display: none !important;
    }

    .containerSvg svg {
        width: 100%;
        height: auto;
        display: block;
    }

    /* SCROLL */
    *::-webkit-scrollbar {
        height: 7px;
        width: 7px;
    }

    *::-webkit-scrollbar-track {
        border-radius: 0px;
        background-color: transparent;
    }

    *::-webkit-scrollbar-track:hover {
        background-color: transparent;
    }

    *::-webkit-scrollbar-track:active {
        background-color: transparent;
    }

    *::-webkit-scrollbar-thumb {
        border-radius: 20px;
        background-color: #B2B3CA;
    }

    *::-webkit-scrollbar-thumb:hover {
        background-color: #999abf;
    }

    *::-webkit-scrollbar-thumb:active {
        background-color: #7B7DA9;
    }

    /* /SCROLL */

    /* TABLA */
    .table-container {
        height: 500px;
        overflow-y: auto;
    }

    .table-thead {
        position: sticky;
        top: 0;
    }

    /* /TABLA */

    /* SELECT2 EN MODAL */
    .select2-inside-modal {
        z-index: 9999 !important;
        position: relative;
    }

    /* /SELECT2 EN MODAL */

    /* HOME */
    .containerTituloHome {
        animation: fadeInRight 1.2s ease-out forwards;
    }

    @keyframes fadeInRight {
        from {
            opacity: 0;
            transform: translateX(50px);
            /* se mueve desde la derecha */
        }

        to {
            opacity: 1;
            transform: translateX(0);
            /* vuelve a su posición */
        }
    }


    .imagenHome {
        animation: fadeInLeft 1.2s ease-out forwards;
    }

    @keyframes fadeInLeft {
        from {
            opacity: 0;
            transform: translateX(-50px);
            /* se mueve desde la izquierda */
        }

        to {
            opacity: 1;
            transform: translateX(0);
            /* vuelve a su posición */
        }
    }

    .tituloHome {
        letter-spacing: 20px;
        font-size: clamp(1rem, 5vw, 2.5rem);
    }

    .subtituloHome {
        letter-spacing: 20px;
        font-size: clamp(0.5rem, 3vw, 1.2rem);
    }

    /* /HOME */
</style>