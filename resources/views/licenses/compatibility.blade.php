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
      font-size: 10x;
      margin-bottom: 2cm;
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
      font-size: 13px;
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
            <img src="https://permisos.capitaldezacatecas.gob.mx/img/logo/logo-clear-v.png" height="100px">
        </div>
        <div class="s6 right" style="padding:5px;">
            <span style="font-size:11px;">
                Ciudad de Zacatecas, Zac.; a {{ $validity_date }}
            </span><br>
            <span class="right" style="font-size:10px;"> DEPARTAMENTO DE PLANEACIÓN Y DESARROLLO URBANO </span><br>
            <b style="font-size:11px;">
                CONSTANCIA DE COMPATIBILIDAD URBANISTICA NO. {{ $license->folio }}
            </b><br>
            <b style="font-size:11px;">
                Referencia. {{ $license->referencia }}
            </b><br>
        </div>
    </div>
  </header>
  <main>
    <div class="row grande">
        <br>
      <b> C. SECRETARIO DE DESARROLLO URBANO
        Y MEDIO AMBIENTE<br>
      </b><br>
      <b>P R E S E N T E</b>
    </div><br>
    <div class="row justify grande">
      Con base en el Articulo 119 del Código Territorial y Urbano para el Estado de Zacatecas y sus Municipios, solicito expida Constancia de Compatibilidad
      Urbanística para el predio ubicado en:
    </div><br>
    <table width="100%" class="grande">
      <tr>
        <td>{{ $license->property->calle }}</td>
        <td>{{ $license->property->no }}</td>
        <td>{{ $license->property->colonia }}</td>
        <td>Zacatecas</td>
      </tr>
      <tr style="border-top: black solid; font-size: 13px;">
        <td>Nombre de la calle</td>
        <td>Número</td>
        <td>Colonia</td>
        <td>Ciudad</td>
      </tr>
    </table>
    <table width="100%" class="grande">
      <tr class="grande">
        <td>Con las siguientes medidas y colindancias:</td>
        <td>SUPERFICIE: {{ $compatibility->m2_ocupacion }}</td>
      </tr>
    </table>
    <div class="row grande">
        @php
            echo nl2br($compatibility->medidas_colindancia);
        @endphp
    </div>
    <table width="100%" class="grande">
      <tr>
        <td>Uso Actual del Terreno:</td>
        <td>{{ $compatibility->uso_actual }}</td>
        <td>Uso Propuesto :</td>
        <td>{{ $compatibility->uso_propuesto }}</td>
      </tr>
    </table>
    <div class="row justify grande">
      Datos del solicitante
    </div><br>
    <table width="100%" class="grande">
      <tr>
        <td>{{ $applicant->nombre }}</td>
      </tr>
      <tr>
        <td style="border-top: black solid;">Nombre</td>
      </tr>
    </table>
    <table width="100%" class="grande">
        <tr>
            <td>{{ $applicantData->calle }} {{ $applicantData->no }}. {{ $applicantData->colonia }}</td>
            <td>{{ $applicantData->celular }}</td>
          </tr>
      <tr>
        <td style="border-top: black solid;">Domicilio</td>
        <td style="border-top: black solid;">Teléfono</td>
      </tr>
    </table>
    <div class="grande">
      CROQUIS DE LOCALIZACIÓN DEL TERRENO
    </div>
    <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->property->mapa_url}}"
      alt="" width="100%">
    <div class="row justify grande">
      PARA USO EXCLUSIVO DE LA SECRETARÍA <br>
      Con fundamento en el Artículo 14, Fracción XXXVIII del Código Territorial y Urbano para el Estado de Zacatecas y sus Municipios, se expide Constancia para el predio
      descrito:
    </div>
    <br>
    <table width="100%" class="grande">
      <tr class="border">
        <td width="25%">USOS DEL SUELO PERMITIDOS:</td>
        <td>
            @php
                echo nl2br($compatibility->usos_permitidos);
            @endphp
        </td>
      </tr>
      <tr class="border">
        <td width="25%">USOS DEL SUELO PROHIBIDOS:</td>
        <td>
            @php
                echo nl2br($compatibility->usos_prohibidos);
            @endphp
        </td>
      </tr>
      <tr class="border">
        <td width="25%">USOS DEL SUELO CONDICIONADOS:</td>
        <td>
            @php
                echo nl2br($compatibility->usos_condicionales);
            @endphp
        </td>
      </tr>
    </table>
    <br>
    <div class="row justify grande">
        <b>
            <i>
                <u>
                    @php
                        echo nl2br($compatibility->programa);
                    @endphp
                </u>
            </i>
        </b>
    </div><br>
    <table width="100%">
      <tr>
        <td>EL USO PROPUESTO ES: </td>
        <td><b>{{$compatibility->resolucion}}</b></td>
      </tr>
    </table>
    <div class="row grande">
        <ul>
          <li>1. El presente documento tiene vigencia de 1 (un) año a partir de la fecha de expedición
          </li><br>
          <li>2. No es constancia de propiedad, ni licencia de construcción y será nulo si carece de la parte
            complementaria al reverso
          </li>
          <li>3. El uso de suelo propuesto estará sujeto, a las restricciones y observaciones que en su caso se mencionen
            al reverso de
            esta Constancia.
          </li>
        </ul>
    </div><br>
    {{--  salto de pagina  --}}
    <div class="page-break"></div>
    {{--  salto de pagina  --}}
    <div class="row justify grande">
        <b>
            <u>
                ESTE DOCUMENTO ES UNA CONSTANCIA, NO UN PERMISO DE CONSTRUCCIÓN NI UNA LICENCIA DE FUNCIONAMIENTO. ES
                EXCLUSIVAMENTE INFORMATIVO SOBRE EL POSIBLE USO DEL INMUEBLE QUE TRATA, ASÍ MISMO, NO ES UN PERMISO
                PARA OPERAR PROVISIONALMENTE
            </u>
        </b>
    </div><br>
    <div class="row grande">
      RESTRICCIONES:
    </div><br>
    <div class="row justify grande">
      Para cualquier acto de ocupación y/o construcción con el uso propuesto, el propietario deberá obtener autorización
      ante
      esta Presidencia Municipal presentando:
      <br>
        @php
            echo nl2br($compatibility->resticciones);
        @endphp
    </div><br>
    <div class="row grande">
      OBSERVACIONES:
    </div><br>
    <div class="row grande">
      @php
          echo nl2br($compatibility->observaciones);
      @endphp
    </div><br>
    <div class="row uppercase justify grande">
      YO, {{ $applicant->nombre }}, RESPONSABLE DEL USO DEL INMUEBLE UBICADO
      EN {{ $license->property->calle }} {{ $license->property->no }}, {{ $license->property->colonia }}, ENTIENDO LOS ALCANCES INFORMATIVOS DE ESTA CONSTANCIA Y ESTOY DE
      ACUERDO EN
      QUE CUALQUIER INCUMPLIMIENTO A LAS CONDICIONES Y/O REQUISITOS PREVISTOS EN LA PRESENTE O CUALQUIER ALTERACIÓN O
      MODIFICACIÓN AL USO O GIRO PROPUESTO DE {{ $compatibility->uso_propuesto }} DEJARÁ SIN EFECTO LA VIGENCIA DEL PRESENTE
      DOCUMENTO
      GENERANDO A SU VEZ LA SANCIÓN CORRESPONDIENTE.
    </div>
    <br>
    <div class="row justify grande">
        El presente acto administrativo cuenta con firma electrónica del servidor público competente,
        amparada por un certificado vigente a la fecha de la elaboración
        y es valido de conformidad con lo dispuesto en la ley de firma electrónica del estado de Zacatecas.
    </div><br>

    <div class="row center">
        @if ($license->qr_code)
            <b class="grande">Para verificar la autenticidad de este documento, escanee el siguiente código QR</b><br>
            <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->qr_code}}" height="100px"><br>
        @endif
    </div>
    <div class="row justify chica2">
        <i>
            El H. Ayuntamiento de Zacatecas con domicilio en Av. Héroes de Chapultepec N° 1110,  Col. Lázaro Cárdenas,
            de la ciudad de Zacatecas es el responsable del uso, tratamiento y destino de sus datos personales.
            Los datos proporcionados serán utilizados para la expedición de este documento. Si desea conocer nuestro aviso
            de privacidad completo, o tiene alguna duda o aclaración, favor de consultar la siguiente dirección
            <u>"http://capitaldezacatecas.gob.mx"</u> o comunicarse al tel. 4929239421 ext. 174
        </i>
  </main>
  {{--  <footer>
    <b>Av. Héroes de Chapultepec N° 1110 Col. Lázaro Cárdenaz, Zacatecas, Zac. C.P. 98040 Tel. 92 3 94 21</b>
  </footer>  --}}
</body>

</html>
