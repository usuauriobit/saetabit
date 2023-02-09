<style>
    @page { size: 5cm 50mm landscape; }
    body{
        margin: -0.5cm;
        font-size: 9.5pt;
        text-align: center;
    }
</style>

<body>
    N° <strong>{{ $guia_despacho->codigo }}</strong>
    <div>
        {!! DNS1D::getBarcodeHTML($guia_despacho->codigo, 'CODABAR') !!}
    </div>
    <strong>{{ $guia_despacho->fecha->format('d-m-Y') }}</strong>
    <br>
    Origen: <strong>{{ $guia_despacho->origen->ubigeo->distrito }}</strong>
    <br>
    Destino: <strong>{{ $guia_despacho->destino->ubigeo->distrito }}</strong>
</body>
