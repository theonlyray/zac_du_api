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
      bottom: 1cm;
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
      text-align: left;
      line-height: 1.3cm;
    }
    body {
      margin-left: 3.5cm;
      margin-right: 3.5cm;
      margin-bottom: 2cm;
      margin-top: 120px;
      font-family: Arial, Helvetica, sans-serif;
      margin-top: 120px;
      font-size: 14px;
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
                <img src="https://permisos.capitaldezacatecas.gob.mx/img/logo/logo-clear-v.png" height="100px">
            </div>
            <div class="s6 right" style="padding:5px;">
                <span style="font-size:11px;">
                    Ciudad de Zacatecas, Zac.; a {{ $validity_date }}
                </span><br>
                <span class="right" style="font-size:10px;"> DEPARTAMENTO DE PLANEACIÓN Y DESARROLLO URBANO </span><br>
                <b style="font-size:11px;">
                    NÚMERO DE OFICIO {{ $license->folio }}
                </b><br>
                <b style="font-size:11px;">
                    {{ $license->referencia }}
                </b><br>
                <b style="font-size:13px;">
                    ASUNTO. SE AUTORIZA {{ $actividad }}
                </b><br>
            </div>
        </div>
    </header>
    <main>
        <br><br>
        <div class="row">
            @php
                echo nl2br("<b>". $license->owner->nombre_apellidos."</b><br>");
            @endphp
            <b>
                {{ $license->owner->domicilio }}<br>
                ZACATECAS, ZAC.
            </b><br>
            <b>P R E S E N T E</b>
        </div>
        <br><br>
        <div class="row justify">
            @if (count($license->sfd) == 1)
                Con relación a su solicitud y con fundamento en los Artículos 5, {{$license->SFD[0]->sustento}},
                Art.9 Fr. IV, Art. 14 Fr. XXXIX, Art. 165, 167, 229, 232, 234,
                del Código Territorial y Urbano para el Estado de Zacatecas y sus Municipios Vigente,
                le comunico se <b>AUTORIZA</b> la <b>{{$license->sfd[0]->actividad}}</b>
                de un Lote de su propiedad identificado como Lote {{$license->property->lote}},
                de la Manzana {{$license->property->manazan}}, de la Zona {{$license->property->zona}},
                ubicado en {{$license->property->colonia}} de esta cabecera municipal,
                con una  superficie de <b>{{$license->property->sup_terreno}} m&sup2; </b>, del que es objeto la presente,
                con clave catastral {{$license->property->clave_catastral}}
                lo anterior sobre la base que hemos recibido la copia del pago de los Derechos que causa esta autorización y
                en virtud de que se cumplieron los requisitos del Art. 243 del mismo Código y el Art. 84 de la ley de ingresos
                del Municipio de Zacatecas para el ejercicio fiscal {{Carbon\Carbon::now()->year}}

            @else
                Con relación a su solicitud y con fundamento en los Artículos 5,
                @foreach ($license->sfd as $sfd)
                    @if ($sfd->sustento != 'N/A')
                        {{$sfd->sustento}}
                    @endif
                @endforeach
                Art.9 Fr. IV, Art. 14 Fr. XXXIX, Art. 165, 167, 229, 232, 234,
                del Código Territorial y Urbano para el Estado de Zacatecas y sus Municipios Vigente,
                le conunico que éste Municipio <b>AUTORIZA</b> la <b>{{$actividad}}</b> de los bienes de su propiedad
                @if (in_array('FUSIÓN', array_column($license->sfd->toArray(), 'actividad')))
                marcados como:
                    <br><br>
                    <ul>
                        @foreach ($license->sfd as $sfd)
                            @foreach ($sfd->lots as $lot)
                            <li>
                                Lote {{$lot->lote}}, de la manzana {{$lot->manzana}},
                                de la Colonia/Fraccionamiento denominada {{$lot->colonia}}, de esta ciudad capital,
                                con una superficie de {{$lot->sup_terreno}} m&sup2;.
                                Con clave catastral {{$lot->clave_catastral}}.
                                @if ($lot->propietario != 'N/A')
                                    Propiedad de {{$lot->propietario}}.
                                @endif
                            </li>
                            @endforeach
                        @endforeach
                    </ul>
                @else
                .
                @endif


            @endif
        </div>
        <br>
        {{--  list of sfd  --}}
        @foreach ($license->sfd as $sfd)
            <div class="center">
                <b class="uppercase">{{$sfd->actividad}}</b><br><br>
            </div>
            <div class="justify">
                @php
                    echo nl2br($sfd->descripcion);
                @endphp
                <br><br>
                @php
                    echo nl2br($sfd->medidas_colindancia);
                @endphp
                <br><br>
                @php
                    if($sfd->observaciones != 'N/A'){
                        echo nl2br($sfd->observaciones);
                    }
                @endphp
            </div><br>
        @endforeach
        <div class="row justify">
            {{--  La presente autorización se acompaña de los planos generales e individuales de la {{$actividad}} y fracción restante anexos al presente,
            por lo que se emite un total de 5 (cinco) fojas útiles y tiene vigencia de UN AÑO a partir de la fecha de su recepción.<br>  --}}
            Este permiso tiene vigencia de UN AÑO a partir de la fecha de su pago.<br><br>
            Sin otro particular, quedamos de usted.<br>
        </div><br><br>
        <div class="row justify grande">
            El presente acto administrativo cuenta con firma electrónica del servidor público competente,
            amparada por un certificado vigente a la fecha de la elaboración
            y es valido de conformidad con lo dispuesto en la ley de firma electrónica del estado de Zacatecas.
        </div><br><br>

        <div class="row center">
            @if ($license->qr_code)
                <b class="grande">Para verificar la autenticidad de este documento, escanee el siguiente código QR</b><br>
                <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->qr_code}}" height="100px"><br>
            @endif
        </div>
        <div class="s6 center">
            <b>REVISO</b><br>
            <label class="uppercase">{{$dirDep->nombre}}</label><br>
            Encargada del Departamento de Planeación y Desarrollo urbano<br><br><br>
        </div>
        <div class="s6 center">
            <b>ATENTAMENTE</b><br>
            <label class="uppercase">{{$dirSDUMA->nombre}}</label><br>
            Secretaria de Desarrollo Urbano y Medio Ambiente<br>
            <div class="row left grande" style="font-size:6"><br<br>
                c.c.p.- Dirección de Catastro Registro Público - Ciudad.<br>
                c.c.p.- Secretaria de Desarrollo Urbano, Vivienda y Ordenamiento Territorial - Ciudad.<br>
                c.c.p.- Dirección de Catastro Público Municipal - Edición.<br>
                c.c.p.- Departamento de Permisos y Licencias para la Construcción.<br>
            </div>
        </div>
        <div class="s12">
            <br>
        </div>

    </main>
    {{--  <footer>
        <b>Av. Héroes de Chapultepec N° 1110 Col. Lázaro Cárdenaz, Zacatecas, Zac. C.P. 98040 Tel. 92 3 94 21</b>
    </footer>  --}}
</body>
</html>
