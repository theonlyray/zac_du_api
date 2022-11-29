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
      background-color: #a31831;
      color: white;
      text-align: center;
      line-height: 1.5cm;
    }
    body {
      margin-left: 2cm;
      margin-right: 2cm;
      font-family: Arial, Helvetica, sans-serif;
      margin-top: 120px;
      font-size: 12px;
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
        <img src="https://www.zacatecas.gob.mx/wp-content/uploads/2021/11/horizontal-justo-300x106.png" height="70px">
      </div>
      <div class="s6 center" style="padding:5px;">
        <b style="font-size:13px;">Secretaría de Desarrollo Urbano y Medio Ambiente</b>

        <div class="row right">
          <b style="font-size:11px;">
            Zacatecas, Zac; a {{ $license->fecha_actualizacion->format('d-m-Y') }}
          </b><br>
          <b style="font-size:11px;">
            EXPEDIENTE {expediente}
          </b><br>
          <b style="font-size:11px;">
            NÚMERO DE OFICIO {{ $license->folio }}
          </b><br>
          <b style="font-size:11px;">
            RECIBO: {recibo}
          </b>
          <b style="font-size:11px;">Página <span class=" pagenum" style="font-size:11px;"></span></b>
        </div>
      </div>
    </div>
  </header>
  <main>
    <div class="row">
      <b> C. APODERADO LEGARL </b> <br>
      {{ $applicant->nombre }} <br>
      {{ $applicantData->calle }} {{ $applicantData->no }} <br>
      {{ $applicantData->colonia }} <br>
      <b>P R E S E N T E</b>
    </div><br>
    <div class="row justify">
      Por este conducto y en respuesta a su atento escrito en el que solicita la autorización correspondiente para
      {{ $license->ad->colonia }} la licencia de {$adsNumber} {{$license->ad->cantidad > 1 ? 'Anuncio' : 'Anuncios'}} {$logotipos} de {$tienda} que Usted
      representa en el domicilio arriba citado de esta Ciudad, informamos a Usted que esta Secretaría, actuando de
      conformidad con las disposiciones contenidas en los Artículos 1,2,3,40 y 53 del Reglamento de Imagen Urbana
      vigente en este Municipio, los Artículos 1,2,3,6,12 y 16 del Reglamento de Publicidad en el Municipio de
      Zacatecas, así como las contenidad en la ley de Ingreso del Municipio para el Ejercicio Físcal 2022, ha decidido
      otorgal la autorización bajo las siguientes condiciones:
      <br>
    </div>
    <div class="row">
      <ul>
        <li>1. ANUNCIO TIPO: {$LOGOTIPO LUMUNISI ADOSADO A FACHADA (TRES)} <br>
          INFORMAIÓN: "{$LOGOTIPO LIVERPOOL}" <br>
          Dimensiones: {$2.06M DE LARGO x 2.90 DE ANCHO} <br>
          Refrendo 2022: $ {$18,069.00}
        </li><br>
        <li>2. ANUNCIO TIPO: {$LOGOTIPO LUMUNISI ADOSADO A FACHADA (TRES)} <br>
          INFORMAIÓN: "{$LOGOTIPO LIVERPOOL}" <br>
          Dimensiones: {$2.06M DE LARGO x 2.90 DE ANCHO} <br>
          Refrendo 2022: $ {$18,069.00}
        </li><br>
      </ul>
    </div>
    <div class="row">
      Total: $ {$18,562.00} ({$DIESCIOCHO MIL QUINIENTOS SESENTA Y DOS PESOS } 00/100 M.N)
    </div>
    <br>
    <div class="row justify">
      El titular de la licencia tendrá la obligación de mantener en óptimas condiciones el funcionamiento y la presencia
      de los anuncios, así como prpoporcionar y dar mantenimiento permanente para conservarlo en buen estado. Cualquier
      modificación deberá ser notificada a esta Secretaría.
    </div>
    <br>
    <div class="row justify">
      La licencia tiene vigencia hasta el {$31 de marzo del 2023}, al término de la cual deberá ser renovada en caso de
      no hacerlo se le sancionará conforme lo marca la ley para los casos.
    </div>
    <br>
    <div class="row justify">
      Sin mas por el momento gradezco atención a la presente.
    </div>
    <br><br>
    <div class="row center">
      <b>A T E N T A M E N T E</b>
    </div>
    <br><br><br><br>
    <div class="row center">
      <b>
        M. {{ $dirSDUMA->nombre }}<br>
        SECRETARÍA DE DESARROLLO URBANO Y MEDIO AMBIENTE
      </b>
    </div>
    <br><br><br>
    <div class="row right">
      <span>
        LIC. {{ $dirDep->nombre }} <br>
        JEFA DEL DPTO. DE PLANEACIÓN Y <br> DESARROLLO URBANO
      </span>
    </div>
  </main>
  <footer>
    <b>Av. Héroes de Chapultepec N° 1110 Col. Lázaro Cárdenaz, Zacatecas, Zac. C.P. 98040 Tel. 92 3 94 21</b>

  </footer>
</body>

</html>
