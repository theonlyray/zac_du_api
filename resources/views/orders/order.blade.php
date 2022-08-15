<!DOCTYPE html>
    <html lang="es">
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
            <title>Orden de Cobro - {{ $license->licenseType->nombre }} - {{ $license->licenseType->nota}}</title>
        </head>
        <body>
            <header>
                <div class="row">
                  <div class="s6 center">
                    <img src="https://www.zacatecas.gob.mx/wp-content/uploads/2021/11/horizontal-justo-300x106.png" height="70px">
                  </div>
                  <div class="s6 right" style="padding:5px;">
                    <b style="font-size:18px;">
                        SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE
                    </b>
                    <span style="font-size:11px;">
                      TESORERIA MUNICIPAL<br>
                      PRESENTE.
                    </span><br>
                    <b style="font-size:13px;">
                      Orden de Pago Folio No. <span style="font-size:13px;color:rgb(175, 63, 63)">OC-{{ $license->folio }}</span>
                    </b>
                  </div>
                </div>
            </header>
          <div class="row">
            <br>
            <b>DATOS DEL PERITO RESPONSABLE</b>
            <table width="100%" class="border">
            <tr>
                <td class="border"> {{ $applicant->nombre }} </td>
                <td class="border"> {{ $applicantData->calle }} {{ $applicantData->no }}. {{ $applicantData->colonia }} </td>
            </tr>
            <tr>
                <td style="text-align: center;color: white;background-color: rgb(147, 0, 0); font-weight: bold;">NOMBRE Y APELLIDOS</td>
                <td style="text-align: center;color: white;background-color: rgb(147, 0, 0);font-weight: bold;">DOMICILIO</td>
            </tr>
            </table>
            <table width="100%" class="border">
            <tr>
                <td class="border"> {{ $applicantData->no_registro }}</td>
                <td class="border"> {{ $applicantData->rfc }}</td>
                <td class="border"> {{ $applicantData->celular }}</td>
            </tr>
            <tr>
                <td style="text-align: center;color: white;background-color: rgb(147, 0, 0);font-weight: bold;">No. DE REGISTRO</td>
                <td style="text-align: center;color: white;background-color: rgb(147, 0, 0);font-weight: bold;">R.F.C</td>
                <td style="text-align: center;color: white;background-color: rgb(147, 0, 0);font-weight: bold;">TELÉFONO</td>
            </tr>
            </table>
            <br>
            <br>
            <div class="gray-line center white-text grande bold">
            REFERENCIA DEL PAGO
            </div>
            <br>
            <table width="100%">
            <tr>
                <td class="grande border"><b>CONCEPTO</b></td>
                <td class="grande center border"><b>CUENTA</b></td>
                <td class="grande center border"><b>TARIFA</b></td>
                <td class="grande center border"><b>CANTIDAD</b></td>
                <td class="grande center border"><b>SUBTOTAL</b></td>
            </tr>
            @foreach($order->duties as $duty)
            <tr>
                <td width="50%" class="grande border">{{ $duty->descripcion }}</td>
                <td class="grande center border">{{ $duty->cuenta }}</td>
                <td class="grande center border">{{ number_format($duty->precio,2) }}</td>
                <td class="grande center border">{{ number_format($duty->cantidad,2) }}</td>
                <td class="grande center border">{{ number_format($duty->total,2) }}</td>
            </tr>
            @endforeach
            </table>
              <div class="row">
                <b>Pago de derechos con base a lo dispuesto en:</b>
                ... Ley de ... para el Municipio de Zacatecas, ejercicio fiscal 2022
              </div>
              <div class="row right">
                TOTAL: <b>${{ number_format($order->total,2) }}</b>
              </div>
            </div>
            <div class="row">
              <div class="row medio center white-text grande bold">
                DATOS DEL PREDIO
              </div>
              <table width="100%">
                <tr>
                  <td class="grande">Propietario: <b>{{ $license->owner->nombre_apellidos }}</b></td>
                </tr>
                <tr>
                  <td class="grande">Domicilio: <b>
                    {{ $license->property->calle }} {{ $license->property->no }}, {{ $license->property->colonia }}</b></td>
                </tr>
              </table>
            </div>
            <div class="gray-line"></div>
            <table width="100%">
              <tr>
                <td width="25%" class="right">
                  {{--  <barcode code="{{ make_hash($license) }}" size="1.5" type="QR" error="M" class="barcode" />  --}}
                </td>
              </tr>
            </table>
            @if($order->validada)
            <div class="row medio center white-text grande bold">
              DATOS PARA REALIZAR EL PAGO EN EL BANCO AUTORIZADO
            </div>
            <table width="100%">
              <tr>
                <td width="20%">
                  {{--  <img height="100px" src="https://ventanillavirtualguanajuato.net/img/bb001203.png">  --}}
                </td>
                <td width="80%">
                  <table width="100%">
                    <tr>
                      <td class="grande center" width="30%">
                        <b>PAGO EN SUCURSAL</b>
                        <table width="100%">
                          <tr>
                            <td width="100%" class="grande center">
                              NÚMERO DE SERVICIO:<br><br>
                              <b>0000</b> <br><br>
                            </td>
                          </tr>
                        </table>
                      </td>
                      <td class="grande center" width="70%" style="border-left: 1px solid black;">
                        <b>TRANSFERENCIA BANCARIA</b>
                        <table width="100%">
                          <tr>
                            <td width="50%" class="grande center">
                              REFERENCIA / CONCEPTO:<br><br>
                              {{--  <b>{{ make_hash($license) }}</b>  --}}
                            </td>
                            <td width="50%" class="grande center">
                              CLABE PARA PAGO SPEI:<br><br>
                              <b>000000000000000000</b><br><br>
                            </td>
                          </tr>
                        </table>
                      </td>
                    </tr>
                  </table>
                </td>
              </tr>
            </table>
            @endif
          </div>
          {{--  @if($license->orden['validate'])
          <div class="chica"> Sello Digital:<br> {{ $sello_digital }}</div><br>
          <div class="chica"> Sello Original:<br> {{ $sello }}</div>
          @endif  --}}
        </body>
    </html>
