<html>

<head>
  <style>
    @page {
      margin-top: 1cm;
      margin-bottom: 1cm;
      margin-left: 2cm;
      margin-right: 2cm;
    }
    header {
      position: fixed;
      top: 0cm;
      left: 0cm;
      right: 0cm;
      height: 100px;
      text-align: center;
    }
    footer {
      position: fixed;
      bottom: 0cm;
      left: 0cm;
      right: 0cm;
      height: 2cm;
      background-color: black;
      color: white;
      text-align: center;
      line-height: 1.5cm;
    }
    body {
      font-family: Arial, Helvetica, sans-serif;
      margin-top: 120px;
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
      border: rgb(185, 184, 184) solid 1px;
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
          Secretaría de Desarrollo Urbano y Medio Ambiente<br>
          Departamento de Permisos y Licencias para la Construcción
        </span>
        <b style="font-size:13px;">
          LICENCIA DE CONSTRUCCIÓN<br> Folio No. <span style="font-size:13px;color:rgb(00, 133, 56)">{{ $license->folio }}</span>
        </b><br>
        <b style="font-size:13px;">Página <span class=" pagenum" style="font-size:13px;"></span></b>
      </div>
    </div>
  </header>
  <main><br>
    <b>I) UBICACIÓN</b>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->property->calle }} {{ $license->property->no }}</td>
        <td class="border"> {{ $license->property->colonia }}</td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">UBICACIÓN (NÚMERO
          OFICIAL)</td>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">COLONIA</td>
      </tr>
      <tr>
        <td class="border"> {{ $license->property->seccion }} - {{ $license->property->manzana }} - {{ $license->property->lote }}</td>
        <td class="border"> {{ $license->property->no_predial }} </td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">SECCIÓN MANZANA LOTE</td>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">BOLETA DE IMPUESTO
          PREDIAL NO.</td>
      </tr>
    </table>
    <br>
    <b>II) DATOS DEL PERITO RESPONSABLE</b>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->license_type_id == 2 ? $applicant->nombre : '' }} </td>
        <td class="border"> {{ $license->license_type_id == 2 ? $applicantData->calle : '' }}
            {{ $license->license_type_id == 2 ? $applicantData->no : '' }}.
            {{ $license->license_type_id == 2 ? $applicantData->colonia : '' }} </td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">NOMBRE Y APELLIDOS</td>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">DOMICILIO</td>
      </tr>
    </table>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->license_type_id == 2 ? $applicantData->no_registro : '' }}</td>
        <td class="border"> {{ $license->license_type_id == 2 ? $applicantData->rfc : '' }}</td>
        <td class="border"> {{ $license->license_type_id == 2 ? $applicantData->celular : '' }}</td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">No. DE REGISTRO</td>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">R.F.C</td>
        <td style="text-align: center;color: white;background-color: #008538;font-weight: bold; font-size:11px;">TELÉFONO</td>
      </tr>
    </table>
    <br>
    <b>III) DESCRIPCIÓN DE LA OBRA</b>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->property->sup_terreno }}</td>
        <td class="border"> {{ $license->property->sup_construida }}</td>
        <td class="border"> {{ $license->property->sup_no_construida }}</td>
        <td class="border"> {{ $license->construction->sup_total_amp_reg_const }}</td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">SUP. DEL
          TERRENO</td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">SUP.
          CONSTRUIDA</td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">SUP. NO
          CONSTRUIDA</td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">SUP.
          CUBIERTA POR AMPLIA.
          CONS. O REGULARIZACIÓN</td>
      </tr>
    </table>
    <table width="100%" class="border">
        <tr>
            <td>
            {{$license->construction->descripcion}}
            </td>
        </tr>
    </table>
    <br>
    <b>IV) ANTECEDENTES</b>
        @if (count($license->backgrounds) == 0)
            <table width="100%" class="border">
                <tr>
                    <td class="border"></td>
                    <td class="border"></td>
                    <td class="border"></td>
                </tr>
                <tr>
                    <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                    No. LICENCIA ANTERIOR FECHA
                    </td>
                    <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                    No. LICENCIA ANTERIOR FECHA
                    </td>
                    <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                    No. LICENCIA ANTERIOR FECHA
                    </td>
                </tr>
            </table>
        @else
            @php $index = 0;@endphp
            @foreach ($backgrounds as $background)
            {{--  physical license  --}}
                @if (!is_null($background->physical_prior_license_id))
                    <table width="100%" class="border">

                        <tr>
                            <td class="border"> {{ $background->physical_prior_license_id }} </td>
                            <td class="border"> {{ $background->fecha->format('d-m-Y') }} </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                                No. LICENCIA ANTERIOR
                            </td>
                            <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                                FECHA
                            </td>
                        </tr>
                </table>
                @else
                {{--  digital license  --}}
                    <table width="100%" class="border">
                        <tr>
                            <td class="border"> {{ $priorLicenses[$index]->folio }} </td>
                            <td class="border"> {{ $priorLicenses[$index]->fecha_actualizacion->format('d-m-Y') }} </td>
                        </tr>
                        <tr>
                            <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                                No. LICENCIA ANTERIOR
                            </td>
                            <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
                                FECHA
                            </td>
                        </tr>
                    </table>
                @php $index++;@endphp
                @endif
            @endforeach
        @endif
    <br>
    <b>IV) DATOS DEL PROPIETARIO</b>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->owner->nombre_apellidos }} </td>
        <td class="border"> {{ $license->owner->rfc }} </td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          NOMBRE Y APELLIDOS
        </td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          R.F.C
        </td>
      </tr>
    </table>
    <table width="100%" class="border">
      <tr>
        <td class="border"> {{ $license->owner->domicilio }} </td>
        <td class="border"> {{ $license->owner->ocupacion }} </td>
        <td class="border"> {{ $license->owner->telefono }} </td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          DOMICILIO
        </td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          OCUPACIÓN
        </td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          TELÉFONO
        </td>
      </tr>
    </table>
    <table width="100%" class="border">
      <tr>
        <td class="border"><br></td>
        <td class="border"><br></td>
      </tr>
      <tr>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          FIRMA DEL PERITO
        </td>
        <td style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">
          FIRMA DEL SOLICITANTE
        </td>
      </tr>
    </table>
    <br>
    <b>VI) VIGENCIA DE LA LICENCIA </b>
    <table width="100%" class="border">
      <tr>
        @if (!is_null($license->validity))
            <td class="border center" width="70%"> Del {{ $validity->auth_date }} </td>
        @else
            <td class="border center" width="70%"> {{ 'Vista Previa' }} </td>
        @endif
        <td class="border center"> TOTAL DE DÍAS</td>
      </tr>
      <tr>
        @if (!is_null($license->validity))
            <td class="border center" width="70%"> Al {{ $validity->end_date }} </td>
        @else
            <td class="border center" width="70%"> {{ 'Vista Previa' }} </td>
        @endif

        @if (!is_null($license->validity))
            <td class="border center"> {{ $license->validity->dias_total }} </td>
        @else
            <td class="border center" width="70%"> {{ 'Vista Previa' }} </td>
        @endif
      </tr>
    </table>
    <div class="row center">
      <b style="font-size:11px;"> ESTA LICENCIA DEBERÁ PERMANECER EN LA OBRA Y MOSTRARSE A LOS INSPECTORES QUE LA
        SOLICITEN </b>
    </div>
    <br>
    {{--  <div class="row center">
      <b> AUTORIZACIÓN</b>
    </div>
    <br><br><br><br>
    <table width="100%">
      <tr>
        <td class="center" style="font-size:11px;" width="50%">SELLO Y FIRMA
          <hr>
        </td>
        <td class="center" style="font-size:11px;" width="50%">SELLO Y FIRMA
          <hr>
        </td>
      </tr>
      <tr>
        <td class="center" style="font-size:11px;" width="50%">JUNTA DE PROTECCIÓN Y CONSERVACIÓN <br>
          DE MONUMENTOS</td>
        <td class="center" style="font-size:11px;" width="50%">{{ $dirSDUMA->nombre }} <br>
          SCRETARIO DE DESARROLLO URBANO Y MEDIO AMBIENTE</td>
      </tr>
    </table>  --}}
    <div class="page-break"></div>
    <br>
    <div class="row center">
      <b>SUPERFICIE POR CONSTRUIR O REGULARIZAR M2</b>
    </div>
    <table width="100%">
      <tr>
        <td width="50%" style=" font-size:11px;">
          <table>
            <tr>
                <td>SÓTANO</td>
                <td>
                  {{ $license->construction->sotano }}
                </td>
            </tr>
            <tr>
                <td>PLANTA BAJA</td>
                <td>
                  {{ $license->construction->planta_baja }}
                </td>
            </tr>
            <tr>
                <td>MEZZANINE</td>
                <td>
                  {{ $license->construction->mezzanine }}
                </td>
            </tr>
            <tr>
                <td>PRIMER PISO</td>
                <td>
                  {{ $license->construction->primer_piso }}
                </td>
            </tr>
            <tr>
                <td>SEGUNDO PISO</td>
                <td>
                  {{ $license->construction->segundo_piso }}
                </td>
            </tr>
            <tr>
                <td>TERCER PISO</td>
                <td>
                  {{ $license->construction->tercer_piso }}
                </td>
            </tr>
          </table>
        </td>
        <td width="50%">
          <table style=" font-size:11px;">
            <tr>
                <td>CUARTO PISO</td>
                <td>
                  {{ $license->construction->cuarto_piso }}
                </td>
            </tr>
            <tr>
                <td>QUINTO PISO</td>
                <td>
                  {{ $license->construction->quinto_piso }}
                </td>
            </tr>
            <tr>
                <td>SEXTO PISO</td>
                <td>
                  {{ $license->construction->sexto_piso }}
                </td>
            </tr>
            <tr>
                <td>DESUBIERTA EN</td>
                <td>
                  {{ $license->construction->descubierta }}
                </td>
            </tr>
            <tr>
                <td>TOTAL CONSTRUIDO</td>
                <td>
                  {{ $license->construction->sup_total_amp_reg_const ?? 0}}
                </td>
            </tr>
            <tr>
                <td>SUPERFICIE TOTAL DEL TERRENO</td>
                <td>
                  {{ $license->property->sup_terreno }}
                </td>
            </tr>
          </table>
        </td>
      </tr>
    </table>
    <br>
    <table width="100%">
      <tr>
        <td class="border"
          style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">TIPO</td>
        <td class="border"
          style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">VALOR POR
          M2</td>
        <td class="border"
          style="text-align: center;color: white;background-color: #008538; font-weight: bold; font-size:11px;">CUOTA
          IMPORTE TOTAL</td>
      </tr>
        @if (!is_null($license->order))

            @foreach($license->order->duties as $duty)
                <tr>
                    <td class="grande center border">{{ $duty->cuenta }}</td>
                    <td class="grande center border">{{ number_format($duty->precio,2) }}</td>
                    {{--  <td class="grande center border">{{ number_format($duty->cantidad,2) }}</td>  --}}
                    <td class="grande center border">{{ number_format($duty->total,2) }}</td>
                </tr>
            @endforeach
        @endif
    </table>
    <br>
    <div class="row center">CROQUIS</div>
    <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->property->mapa_url}}"
      alt="" width="100%">
    <div class="row center">DATOS QUE DEBE CONTENER EL CROQUIS</div><br>
    <div class="row center" style="font-size: 11px;">NOMBRE DE LA CALLE QUE LIMITA LA MANZANA, DISTANCIA DE LAS 2
      ESQUINAS A LOS LNDEROS DEL
      PREDIO, MEDIDAS DEL FRENTE Y FONDO DEL PREDIO, ANCHO DE LA CALLE Y BANQUETA.</div>
    <br>
    <div class="row justify grande">
        El presente acto administrativo cuenta con firma electrónica del servidor público competente,
        amparada por un certificado vigente a la fecha de la elaboración
        y es valido de conformidad con lo dispuesto en la le de firma electrónica del estado de Zacatecas.
    </div><br><br>
    @if ($license->qr_code)
        <div class="row">
            <div class="s12 center">
                <b class="grande">Para verificar la autenticidad de este documento, escanee el siguiente código QR</b><br>
                <img src="https://permisos.capitaldezacatecas.gob.mx{{$license->qr_code}}" height="140px">
            </div>
        </div>
    @endif
  </main>
</body>

</html>
