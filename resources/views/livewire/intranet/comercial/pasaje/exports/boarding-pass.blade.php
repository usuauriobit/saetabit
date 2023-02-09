<html>
    <head>
        <style>
            @page { size: 8cm 20cm portrait; }
            @font-face {
                font-family: "Jura";
                src: url("{{ storage_path('fonts/Jura/Jura-Regular.ttf') }}") format("truetype");
                font-weight: normal;
            }
            @font-face {
                font-family: "Jura";
                src: url("{{ storage_path('fonts/Jura/Jura-Bold.ttf') }}") format("truetype");
                font-weight: bold;
            }
            @page { margin: 2px; }
            body{
                font-family: "Jura", cursive;
                font-size: 10pt;
                margin: 2px;
            }
            .primary-color{
                color: #001AFF;
            }
            .w-100{
                width: 100%;
            }
            .w-90{
                width: 90%;
            }
            .w-70{
                width: 70%;
            }
            .w-60{
                width: 60%;
            }
            .w-40{
                width: 40%;
            }
            .w-30{
                width: 30%;
            }
            .text-c{
                text-align: center;
            }
            .text-r{
                text-align: right;
            }
            .text-lg{
                font-size: 13pt;
            }
            .text-sm{
                font-size: 9pt;
            }
            .text-xs{
                font-size: 7pt;
            }
            .p-1{
                padding: 0.5em;
            }
            .p-2{
                padding: 0.7em;
            }
            .p-3{
                padding: 1em;
            }
            .m-1{
                margin: 0.5em;
            }
            .m-2{
                margin: 0.7em;
            }
            .m-3{
                margin: 1em;
            }
            .mt-1{
                margin-top: 0.5em;
            }
            .mt-2{
                margin-top: 0.7em;
            }
            .mt-3{
                margin-top: 1em;
            }
            .mb-1{
                margin-bottom: 0.5em;
            }
            .mb-2{
                margin-bottom: 0.7em;
            }
            .mb-3{
                margin-bottom: 1em;
            }
        </style>
    </head>
    <body>

        <table class="w-100">
            <tr >
                {{-- @include('livewire.intranet.comercial.pasaje.exports.components.resumen-section') --}}
                @include('livewire.intranet.comercial.pasaje.exports.boarding-pass.detail-section')
            </tr>
        </table>
    </body>
</html>
