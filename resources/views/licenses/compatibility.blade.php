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
  <title>Anuncios</title>

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
            @if (!is_null($license->validity))
                {{ $license->validity->fecha_autorizacion->format('d-m-Y') }}
            @else
                Zacatecas, Zac; a { Vista Previa } </td>
            @endif
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
      <b> C. SECRETARIO DE DESARROLLO URBANO <br>
        Y MEDIO AMBIENTE
      </b><br>
      <b>P R E S E N T E</b>
    </div><br>
    <div class="row justify">
      Con base en el Articulo 133 del Código Urbano vigente en el Estado, solicito expida Constancia de Compatibilidad
      Urbanística para el predio ubicado en:
    </div><br>
    <table width="100%">
      <tr>
        <td>{{ $license->property->calle }}</td>
        <td>{{ $license->property->no }}</td>
        <td>{{ $license->property->colonia }}</td>
        <td>Zacatecas</td>
      </tr>
      <tr style="border-top: black solid;">
        <td>Nombre de la calle</td>
        <td>Número</td>
        <td>Colonia</td>
        <td>Ciudad</td>
      </tr>
    </table><br><br>
    <table width="100%">
      <tr>
        <td>Con las siguientes medidas y colindancias:</td>
        <td>SUPERFICIE: {{ $compatibility->m2_ocupacion }}</td>
      </tr>
    </table><br>
    <div class="row">
      {{ $compatibility->medidas_colindancia }}
    </div>
    <br>
    <table width="100%">
      <tr>
        <td>Uso Actual del Terreno:</td>
        <td>{{ $compatibility->uso_actual }}</td>
        <td>Uso Propuesto :</td>
        <td>{{ $compatibility->uso_propuesto }}</td>
      </tr>
    </table><br><br>
    <div class="row justify">
      Datos del solicitante
    </div><br>
    <table width="100%">
      <tr>
        <td>{{ $applicant->nombre }}</td>
        <td></td>
      </tr>
      <tr>
        <td style="border-top: black solid;">Nombre</td>
        <td style="border-top: black solid;">Firma</td>
      </tr>
    </table><br><br>
    <table width="100%">
        <tr>
            <td>{{ $applicantData->calle }} {{ $applicantData->no }}. {{ $applicantData->colonia }}</td>
            <td>{{ $applicantData->celular }}</td>
          </tr>
      <tr>
        <td style="border-top: black solid;">Domicilio</td>
        <td style="border-top: black solid;">Teléfono</td>
      </tr>
    </table><br><br>
    <div>
      CROQUIS DE LOCALIZACIÓN DEL TERRENO
    </div>
    <img src="https://1.bp.blogspot.com/-QBQF-2eqS6U/UUCn5Wvfm6I/AAAAAAAAAtw/v2Z9_OQINT8/s1600/croquis+vintage.jpg"
      alt="" width="100%">
    <br>
    <div class="row justify">
      PARA USO EXCLUSIVO DE LA SECRETARÍA <br>
      Con fundamento en el Artículo 22, Fracción XXXVIII, del Código Urbano vigente, se expide Constancia para el predio
      descrito:
    </div>
    <br>
    <table width="100%">
      <tr class="border">
        <td width="25%">USOS DEL SUELO PERMITIDOS:</td>
        <td>{{ $compatibility->usos_permitidos }}</td>
      </tr>
      <tr class="border">
        <td width="25%">USOS DEL SUELO PROHIBIDOS:</td>
        <td>{{ $compatibility->usos_permitidos }}</td>
      </tr>
      <tr class="border">
        <td width="25%">USOS DEL SUELO CONDICIONADOS:</td>
        <td>{{ $compatibility->usos_permitidos }}</td>
      </tr>
    </table>
    <br>
    <table width="100%">
      <tr>
        <td>EL USO PROPUESTO ES: </td>
        <td>P E R M I T I D O</td>
      </tr>
    </table>
    <div class="row">
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
    </div>
    <div class="row">
      RESTRICCIONES:
    </div>
    <div class="row justify">
      Para cualquier acto de ocupación y/o construcción con el uso propuesto, el propietario deberá obtener autorización
      ante
      esta Presidencia Municipal presentando:
      <ul>
        <li>1. Constancia de propiedad o contrato de arrendamiento y pago del impuesto predial del año fiscal
          correspondiente. Forma
          R-1 de la Secretaría de Hacienda y Crédito Público. Factibilidad de agua potable y alcantarillado por parte de
          la
          JIAPAZ, factibilidad de energía eléctrica por parte de la CFE, ambas sin detrimento del abastecimiento de los
          predios
          contiguos. Para todo acto de construcción o la colocación de cualquier anuncio, deberá obtener la autorización
          de esta
          Secretaría, por lo que tramitará la licencia de construcción correspondiente.
        </li><br>
        <li>2.Deberá presentar dictamen positivo por parte de Protección Civil en un plazo NO mayor de 10 días a
          partir de la fecha
          de expedición y Constancia de Seguridad Estructural del inmueble para el fin propuesto.
        </li>
        <li>3. Tramitar la Licencia Ambiental Municipal ante el Departamento de Ecología Medio Ambiente, de esta
          Secretaría.
        </li>
        <li>4. PARA SU FUNCIONAMIENTO DEBERÁ OBTENER EL PADRÓN MUNICIPAL.
        </li>
        <li>5. Deberá contar con un cajón de estacionamiento por cada 40 m2 de ocupación, todos dentro de los límites de
          su
          propiedad, o presentar ante esta Secretaría en un plazo no mayor de 20 días un contrato de arrendamiento por
          el número
          de cajones solicitados en un predio cercano a 250 m. No ocupará las calles circundantes para estacionamiento
          de clientes
          ni como área de operaciones. Queda PROHIBIDO apartar lugares de estacionamiento en la vía pública, así como
          colocar
          objetos que obstaculicen el mismo. Así como impedir o estorbar, sin motivo justificado, el uso de la vía
          pública y la
          libertad de tránsito de las personas.
        </li>
        <li>6. Este permiso quedará inválido y sin vigencia al presentarse ante este Ayuntamiento queja por parte de los
          vecinos de
          la zona, conflictos viales u otros.
        </li>
        <li>7. El presente documento tiene vigencia de UN AÑO a partir de su fecha de expedición.
        </li>
      </ul>
    </div>
    <div class="row">
      OBSERVACIONES:
    </div>
    <div class="row">
      Se condiciona la presente, al estricto cumplimiento de las restricciones marcadas y a la integración del
      expediente en
      esta Secretaría en un plazo no mayor a 30 días hábiles a partir de su fecha de expedición, de lo contrario la
      Secretaría
      de Finanzas y Tesorería Municipal ejecutará las sanciones correspondientes conforme lo marca la ley para estos
      casos,
      con la REVOCACIÓN de la licencia correspondiente; y demás acciones que se estimen oportunas a efecto de dar
      cumplimiento
      con la normatividad en materia de funcionamiento y operación de giros comerciales.
    </div><br><br>
    <div class="row">
      YO, {{ $applicant->nombre }}, RESPONSABLE DEL USO DEL INMUEBLE UBICADO
      EN {{ $license->property->calle }} {{ $license->property->no }}, {{ $license->property->colonia }}, ENTIENDO LOS ALCANCES INFORMATIVOS DE ESTA CONSTANCIA Y ESTOY DE
      ACUERDO EN
      QUE CUALQUIER INCUMPLIMIENTO A LAS CONDICIONES Y/O REQUISITOS PREVISTOS EN LA PRESENTE O CUALQUIER ALTERACIÓN O
      MODIFICACIÓN AL USO O GIRO PROPUESTO DE------------------------ DEJARÁ SIN EFECTO LA VIGENCIA DEL PRESENTE
      DOCUMENTO
      GENERANDO A SU VEZ LA SANCIÓN CORRESPONDIENTE.
    </div>
    <br><br>
    <div class="row">
      FIRMA DE CONFORMIDAD
    </div>
    <div class="row center">
      <b>A T E N T A M E N T E</b>
    </div>
    <br><br><br><br>
    <div class="row center">

      “SUFRAGIO EFECTIVO, NO REELECCIÓN”<br>
      <b>LA SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE<br>
        M. ARQ. CARLA DANIELA MALDONADO RIOS<br>
      </b>
    </div>
    <br><br><br>
    <table width="100%">
      <tr>
        @if (!is_null($validity))
            <td>Zacatecas, Zacatecas; a {{ $validity->fecha_autorizacion->format('d-m-Y') }} </td>
        @else
            <td>Zacatecas, Zacatecas; a { VISTA PREVIA }.</td>
        @endif

        <td class="center">
          <span>
            LIC. MA GUADALUPE DE SANTIAGO MURILLO <br>
            JEFA DEL DPTO. DE PLANEACIÓN Y <br> DESARROLLO URBANO
          </span>
        </td>
      </tr>
    </table>
  </main>
  <footer>
    <b>Av. Héroes de Chapultepec N° 1110 Col. Lázaro Cárdenaz, Zacatecas, Zac. C.P. 98040 Tel. 92 3 94 21</b>
  </footer>
</body>

</html>
