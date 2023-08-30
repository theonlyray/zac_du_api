<html>
<head>
  <style>
    @page {
      margin-top: 1cm;
      margin-bottom: 0cm;
      margin-left: 0cm;
      margin-right: 0cm;
    }
    header {
      position: fixed;
      top: 0cm;
      left: 2cm;
      right: 2cm;
      height: 100px;
      text-align: center;
    }
    footer {
      position: fixed;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 2cm;
      background-color: #008538;
      color: white;
      text-align: center;
      line-height: 1.5cm;
    }
    body {
      margin-left: 2cm;
      margin-right: 2cm;
      font-family: Arial, Helvetica, sans-serif;
      margin-top: 120px;
      font-size: 15px;
    }
    .img-contain {
      width: 70px;
      height: 70px;
      object-fit: contain;
    }
    .col {
      float: left;
    }
    .row {
      width: 100%;
    }
    .s1 {
      width: 8.3333333333%;
      float: left;
    }
    .s2 {
      width: 16.6666666667%;
      float: left;
    }
    .s3 {
      width: 25%;
      float: left;
    }
    .s4 {
      width: 33.3333333333%;
      float: left;
    }
    .s42 {
      width: 33%;
      float: left;
    }
    .s5 {
      width: 41.6666666667%;
      float: left;
    }
    .s6 {
      width: 50%;
      float: left;
    }
    .row .col.s7 {
      width: 58.3333333333%;
      float: left;
    }
    .s8 {
      width: 66.6666666667%;
      float: left;
    }
    .s9 {
      width: 75%;
      float: left;
    }
    .s10 {
      width: 83.3333333333%;
      float: left;
    }
    .s11 {
      width: 91.6666666667%;
      float: left;
    }
    .s12 {
      width: 100%;
      float: left;
    }
    .center {
      text-align: center;
    }
    .left {
      text-align: left;
    }
    .right {
      text-align: right;
    }
    .justify {
      text-align: justify;
    }
    .bold {
      font-weight: bold;
    }
    .uppercase {
      text-transform: uppercase;
    }
    .textSty {
      text-decoration: underline;
    }
    .mm {
      margin-top: -25px;
    }
    .rowfoot {
      width: 100%;
    }
    .rojoosc {
      background: #b71c1c;
    }
    .rojocla {
      background: #e53935;
    }
    .medio {
      background-color: #A52A2A;
      color: white;
      font-size: 15px;
      font-weight: bold;
    }
    .chica {
      font-size: 11px;
    }
    .chica2 {
      font-size: 9px;
    }
    .grande {
      font-size: 13px;
    }
    .grande2 {
      font-size: 15px;
    }
    .titulo {
      font-size: 18px;
    }
    .nota {
      font-size: 8px;
    }
    .direccion {
      color: rgb(11, 83, 131);
      font-size: 12px;
      font-weight: bold;
    }
    .cursiva {
      font-style: italic;
    }
    .line-blue {
      width: 100%;
      height: 12px;
      background-color: #01579b;
    }
    .gray-line {
      width: 100%;
      height: 5px;
      background-color: gray;
    }
    .gray-fat {
      width: 100%;
      height: 10px;
      background-color: gray;
    }
    .card {
      height: 200px;
      max-height: 200px;
      background-color: #fff;
      /*border: 0.3px solid grey;
       box-shadow: 0px 2px 10px 0px rgba(135, 135, 135, 1);
            height: 15%; */
    }
    .card-image {
      text-align: center;
      background-color: whitesmoke;
      height: 200px;
      width: 100%;
    }
    .photo {
      max-height: 9rem;
    }
    .card-content {
      height: 120px;
      padding: 0.3rem 0.5rem;
      margin: 10px;
      font-size: 0.8rem;
      vertical-align: middle;
    }
    .secuential {
      color: red;
      font-weight: bold;
    }
    .user {
      font-weight: bold;
      text-align: left;
    }
    .comment {
      text-align: justify;
    }
    .card-footer {
      height: 50px;
      padding: 0.3rem;
      background-color: lightgray;
      font-size: 0.8rem;
      text-align: center;
    }
    table {
      border-collapse: collapse;
    }
    tr {
      padding-top: 10px;
      margin-bottom: 0px;
    }
    .m {
      margin-top: 5px;
      margin-bottom: 5px;
    }
    .border {
      border: black solid 1px;
    }
    .page-break {
      page-break-after: always;
    }
    .pagenum:before {
      content: counter(page);
    }
    #watermark {
      position: fixed;
      bottom: 10cm;
      left: 5.5cm;
      width: 8cm;
      height: 8cm;
      z-index: -1000;
    }
    .ribbon {
      width: 0px;
      border-left: 50px solid #d9534f;
      border-right: 50px solid #d9534f;
      border-bottom: 35px solid transparent;
    }
  </style>
  <title>{{ $license->licenseType->nombre }} - {{ $license->licenseType->nota}}</title>

</head>

<body>

  <header>
    <div class="row">
        <div class="s6 left">
            <img src="https://permisos.capitaldezacatecas.gob.mx/img/logo/logo-clear-v.png" height="130px">
        </div>
        <div class="s6 right" style="padding:5px;">
            <b style="font-size:18px;">Presidencia Municipal de Zacatecas</b>
            <span style="font-size:11px;">
            Secretaría de Desarrollo Urbano y Medio Ambiente</span><br>
            <span style="font-size:11px;">
                Departamento de Permisos y Licencias para la Construcción</span>
            <b style="font-size:13px;">
            <div class="row right">
            <b style="font-size:11px;">
                {{ $validity_date}}
            </b><br>
            <b style="font-size:11px;">
                NÚMERO DE OFICIO {{ $license->folio }}
            </b><br>
            </div>
        </div>
    </div>
  </header>
  <main>
    <br><br><br><br><br>
    <div class="row center">
        <b> ASUNTO: CONSTANCIA DE NÚMERO OFICIAL<br><br>
        </b>
    </div><br>
    <div class="row justify">
        <b>A QUIEN CORRESPONSA: </b> <br><br>
        <b>NOMBRE DEL PROPIETARIO: </b> {{ $license->owner->nombre_apellidos }}<br><br>
        <b>COLONIA O FRACCIONAMIENTO: </b> {{ $license->property->colonia }}<br><br>
        <b>CALLE: </b> {{ $license->property->calle }} <br><br>
        <b>NÚMERO OFICIAL: </b> {{ $license->property->no }} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>ZONA: </b> {{ $license->property->zona }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>SECCIÓN: </b> {{ $license->property->seccion }}<br><br>
        <b>CUARTEL: </b> {{ $license->property->cuartel }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>MANZANA: </b> {{ $license->property->manzana }}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        <b>LOTE: </b> {{ $license->property->lote }}<br><br>
        @if (!is_null($license->order))
            <b>SERVICIOS:</b> ${{ number_format($license->order->total,2) }}
        @endif
    </div>
    <br>
    <div class="row justify grande">
        El presente acto administrativo cuenta con firma electrónica del servidor público competente,
        amparada por un certificado vigente a la fecha de la elaboración
        y es valido de conformidad con lo dispuesto en la le de firma electrónica del estado de Zacatecas.
    </div><br><br>
    @if ($license->qr_code)
        <div class="row">
            <div class="center">
                <b class="grande">Para verificar la autenticidad de este documento, escanee el siguiente código QR</b><br>
                <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->qr_code}}" height="140px">
            </div>
        </div>
    @endif
  </main>
  <footer>
    <b>Av. Héroes de Chapultepec N° 1110 Col. Lázaro Cárdenaz, Zacatecas, Zac. C.P. 98040 Tel. 92 3 94 21</b>

  </footer>
</body>

</html>
