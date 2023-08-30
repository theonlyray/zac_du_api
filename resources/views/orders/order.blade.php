<!DOCTYPE html>
    <html lang="es">
        <head>
            <style type="text/css" media="all">
                body {
                @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@100&family=Zen+Kaku+Gothic+New&display=swap');
                    font-family: 'Roboto', sans-serif;
                    font-family: 'Zen Kaku Gothic New', sans-serif;

                }
                table {
                    padding: 0px;
                    font-size: 12px;
                    border-spacing: 0px;
                    border:0px !important;
                }

                th{
                    padding:1px;
                    text-align: left;
                    text-indent: 10px;
                    border-bottom: 1px solid rgb(0, 0, 0);
                }
                td{
                    padding:1px;
                    text-align: left;
                    text-indent: 10px;
                    border-bottom: 1px solid rgb(0, 0, 0);
                }
                td.noborder{
                    padding:1px;
                    text-align: left;
                    text-indent: 10px;
                    border-bottom: 0px solid rgb(0, 0, 0);
                }
                .bottom {
                    border-bottom: 1px solid #ddd;
                }

                #datos{
                    font-size: 12px;
                }
                .center {
                    text-align: center;
                    }
            </style>
            {{--  <style>
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
            </style>  --}}
            <title>Orden de Cobro - {{ $license->licenseType->nombre }} - {{ $license->licenseType->nota}}</title>
        </head>
        <body>
            <table border="0" width="100%" id="datos">
                <tr>
                    <td width='30%' class="noborder">
                        {{--  <img src="{{public_path('/img/logo_a.png')}}" width="100%">  --}}
                        <img src="https://proveedores.capitaldezacatecas.gob.mx/img/oficial_vertical.png" height="130px">
                     </td>
                    <td width="50%" style="text-align: right; font-size: 12px;" class="noborder">
                        PRESIDENCIA MUNICIPAL DE ZACATECAS<br>
                        Secretaría de Finanzas y Administración<br>
                    </td>
                </tr>
            </table>
            <div style="font-size: 24px; text-align: right;">
             <span >Folio No. {{$order->folio_api ?? 000}}</span>
            </div>

            <div style="font-size: 9px; text-align: right;">
                @if (!is_null($order->folio_api))
                    <span>Fecha de Creación: <?php echo date('Y-m-d', strtotime($order->fecha_autorizacion))?></span><br>
                    <span>Fecha de Expiracion: <?php echo date('Y-m-d', strtotime($order->fecha_autorizacion. ' + 7 days'))?></span><br>
                @else
                    <span>Fecha de Creación: <?php echo date('Y-m-d', strtotime($order->fecha_actualizacion))?></span><br>
                    <span>Fecha de Expiracion: <?php echo date('Y-m-d', strtotime($order->fecha_actualizacion. ' + 7 days'))?></span><br>
                @endif
            </div>

            <br>

            <table width="100%" border="0" id="datos">
                <tr>
                    @if(!is_null($license->owner))
                        <td style="text-align: left;">Propietario: <b>{{ $license->owner->nombre_apellidos }}</b></td>
                    @endif
                </tr>
            </table>
            <br>
            <table width="100%" border="0">
                <thead>
                    <tr>
                        <th>Cantidad</th>
                        <th>Cuenta</th>
                        <th>Descripcion</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->duties as $duty)
                        <tr>
                            <td>{{number_format($duty->cantidad,2) }}</td>
                            <td>{{$duty->cuenta}}</td>
                            <td>{{$duty->descripcion}}</td>
                            <td>$ {{ number_format($duty->precio, 2)}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div style="text-align: right">
                <h8 ><b>TOTAL $ </b> {{number_format($order->total, 2, '.', '')}}</h8>
            </div>

            {{--  <header>
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
                      Orden de Pago Folio No. <span style="font-size:13px;color:rgb(175, 63, 63)">{{$order->folio_api ?? 000}}</span>
                    </b>
                  </div>
                </div>
            </header>
          <div class="row">
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
                    @if(!is_null($license->owner))
                        <td class="grande">Propietario: <b>{{ $license->owner->nombre_apellidos }}</b></td>
                    @endif
                </tr>
                <tr>
                  <td class="grande">Domicilio: <b>
                    @if(!is_null($license->property))
                        {{ $license->property->calle }} {{ $license->property->no }}, {{ $license->property->colonia }}</b></td>
                    @endif
                </tr>
              </table>
            </div>
            <div class="gray-line"></div>
          </div>
          --}}
          <div class="row">
            <div class="s12 center">
              <img src=
                "https://permisos.capitaldezacatecas.gob.mx/storage/solicitantes/{{$license->user_id}}/licencias/{{$license->id}}/pago/qr.png"
                height="140px">
            </div>
            <div class="row center bold">
                Pago en línea con tarjeta de crédito o débito
            </div>
          </div>
        </body>
    </html>
