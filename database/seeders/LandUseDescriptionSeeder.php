<?php

namespace Database\Seeders;

use App\Models\LandUseDescription;
use Illuminate\Database\Seeder;

class LandUseDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   //ABARROTES AL POR MENOR (TENDAJÓN MISCELÁNEA)
        LandUseDescription::create([
            'descripcion' => 'Abarrotes con venta de cerveza',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Abarrotes sin venta de cerveza',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Abarrotes y papelería',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Miel de abeja',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Miel de Abeja, Cereales y Galletas',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Productos de leche y lecherías',
            'uma'         => 4,
            'land_use_id' => 1
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refrescos y dulces',
            'uma'         => 4,
            'land_use_id' => 1
        ]);

        //ACADEMIA DE  ARTÍSTICA
        LandUseDescription::create([
            'descripcion' => 'Academia Artística',
            'uma'         => 6.405,
            'land_use_id' => 2
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ludo Teca',
            'uma'         => 6.405,
            'land_use_id' => 2
        ]);
        LandUseDescription::create([
            'descripcion' => 'Academia de Pol Fitness',
            'uma'         => 5.2,
            'land_use_id' => 2
        ]);
        LandUseDescription::create([
            'descripcion' => 'Academia de Baile',
            'uma'         => 6.405,
            'land_use_id' => 2
        ]);

        //ACCESORIOS AUTOMOTRICES  MAYORES
        LandUseDescription::create([
            'descripcion' => 'Autopartes y accesorios en Bodega',
            'uma'         => 4.62,
            'land_use_id' => 3
        ]);
        LandUseDescription::create([
            'descripcion' => 'Acumuladores en general',
            'uma'         => 6.825,
            'land_use_id' => 3
        ]);
        LandUseDescription::create([
            'descripcion' => 'Llantas y accesorios',
            'uma'         => 6.825,
            'land_use_id' => 3
        ]);
        LandUseDescription::create([
            'descripcion' => 'Instalación de Sistema de Aire Acondicionado',
            'uma'         => 6.825,
            'land_use_id' => 3
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de motores',
            'uma'         => 6.825,
            'land_use_id' => 3
        ]);

        //ACCESORIOS AUTOMOTRICES MENORES
        LandUseDescription::create([
            'descripcion' => 'Alarmas',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Autoestéreos',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Autopartes y accesorios',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Cristales y parabrisas',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Instalación de luz de neón',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Parabrisas y accesorios',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);
        LandUseDescription::create([
            'descripcion' => 'Polarizados',
            'uma'         => 4.62,
            'land_use_id' => 4
        ]);

        //ACUARIO
        LandUseDescription::create([
            'descripcion' => 'Peces',
            'uma'         => 4.1,
            'land_use_id' => 5
        ]);
        LandUseDescription::create([
            'descripcion' => 'Peces y accesorios',
            'uma'         => 4.1,
            'land_use_id' => 5
        ]);

        //AFILADOR
        LandUseDescription::create([
            'descripcion' => 'Afilador',
            'uma'         => 4,
            'land_use_id' => 6
        ]);
        LandUseDescription::create([
            'descripcion' => 'Afiladuría',
            'uma'         => 4,
            'land_use_id' => 6
        ]);

        //AGENCIA DE AUTOMÓVILES NUEVOS
        LandUseDescription::create([
            'descripcion' => 'Venta de autos nuevos',
            'uma'         => 15,
            'land_use_id' => 7
        ]);

        //LOTES DE AUTOMÓVILES SEMINUEVOS
        LandUseDescription::create([
            'descripcion' => 'Venta de autos seminuevos',
            'uma'         => 6.3,
            'land_use_id' => 8
        ]);

        //AGENCIA DE MOTOCICLETAS
        LandUseDescription::create([
            'descripcion' => 'Motocicletas y refacciones',
            'uma'         => 6.3,
            'land_use_id' => 9
        ]);

        //AGENCIA DE PUBLICIDAD Y/O TURÍSTICA
        LandUseDescription::create([
            'descripcion' => 'Agencia de publicidad',
            'uma'         => 7.35,
            'land_use_id' => 10
        ]);
        LandUseDescription::create([
            'descripcion' => 'Agencia turística',
            'uma'         => 7.35,
            'land_use_id' => 10
        ]);
        LandUseDescription::create([
            'descripcion' => 'Publicidad y señalamientos',
            'uma'         => 7.35,
            'land_use_id' => 10
        ]);

        //AGENCIA DE SEGURIDAD
        LandUseDescription::create([
            'descripcion' => 'Alarmas para casa',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);
        LandUseDescription::create([
            'descripcion' => 'Artículos de seguridad',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);
        LandUseDescription::create([
            'descripcion' => 'Bordados y art. seguridad',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);
        LandUseDescription::create([
            'descripcion' => 'Extinguidores',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);
        LandUseDescription::create([
            'descripcion' => 'Seguridad',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);
        LandUseDescription::create([
            'descripcion' => 'Servicio de seguridad y Vigilancia privada',
            'uma'         => 7.35,
            'land_use_id' => 11
        ]);

        //AGENCIA DE TELEFONÍA CELULAR
        LandUseDescription::create([
            'descripcion' => 'Accesorios para celulares',
            'uma'         => 5,
            'land_use_id' => 12
        ]);
        LandUseDescription::create([
            'descripcion' => 'Caseta telefónicas',
            'uma'         => 5,
            'land_use_id' => 12
        ]);
        LandUseDescription::create([
            'descripcion' => 'Reparación de celulares',
            'uma'         => 5,
            'land_use_id' => 12
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller de celulares',
            'uma'         => 5,
            'land_use_id' => 12
        ]);

        //ALIMENTO PARA GANADO Y/O AVES
        LandUseDescription::create([
            'descripcion' => 'Alimento para ganado',
            'uma'         => 4.2,
            'land_use_id' => 13
        ]);
        LandUseDescription::create([
            'descripcion' => 'Forrajes',
            'uma'         => 4.2,
            'land_use_id' => 13
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de alfalfa',
            'uma'         => 4.2,
            'land_use_id' => 13
        ]);

        //ALMACÉN BODEGA EN GENERAL(A)
        LandUseDescription::create([
            'descripcion' => 'Almacén, bodega',
            'uma'         => 6.93,
            'land_use_id' => 14
        ]);
        LandUseDescription::create([
            'descripcion' => 'Bodega en mercado de abastos',
            'uma'         => 6.93,
            'land_use_id' => 14
        ]);

        //ALQUILER Y/O VENTA DE INSTRUMENTOS MUSICALES, LUZ Y SONIDO
        LandUseDescription::create([
            'descripcion' => 'Equipo de Sonido y/o Accesorios Musicales',
            'uma'         => 6.4,
            'land_use_id' => 15
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de instrumentos musicales',
            'uma'         => 6.4,
            'land_use_id' => 15
        ]);

        //ALQUILER Y/O VENTA DE PRENDAS DE VESTIR
        LandUseDescription::create([
            'descripcion' => 'Trajes y/o vestidos renta, compra y venta',
            'uma'         => 4.62,
            'land_use_id' => 16
        ]);

        //APARATOS Y ARTÍCULOS ORTOPÉDICOS
        LandUseDescription::create([
            'descripcion' => 'Aparatos ortopédicos',
            'uma'         => 4.6305,
            'land_use_id' => 17
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller de Ortopedia',
            'uma'         => 4.41,
            'land_use_id' => 17
        ]);

        //ARTESANÍAS
        LandUseDescription::create([
            'descripcion' => 'Alfarería',
            'uma'         => 4,
            'land_use_id' => 18
        ]);
        LandUseDescription::create([
            'descripcion' => 'Artesanía, mármol, cerámica',
            'uma'         => 4,
            'land_use_id' => 18
        ]);
        LandUseDescription::create([
            'descripcion' => 'Artesanías y Tendejón',
            'uma'         => 4,
            'land_use_id' => 18
        ]);

        //ARTÍCULOS DE IMPORTACIÓN ORIGINALES
        LandUseDescription::create([
            'descripcion' => 'Artículos de importación originales',
            'uma'         => 5.5,
            'land_use_id' => 19
        ]);

        //ARTÍCULOS USADOS VARIOS
        LandUseDescription::create([
            'descripcion' => 'Artículos usados',
            'uma'         => 4,
            'land_use_id' => 20
        ]);
        LandUseDescription::create([
            'descripcion' => 'Herramienta nueva y usada',
            'uma'         => 4,
            'land_use_id' => 20
        ]);
        LandUseDescription::create([
            'descripcion' => 'Bazar',
            'uma'         => 4,
            'land_use_id' => 20
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ropa usada',
            'uma'         => 4,
            'land_use_id' => 20
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra venta de moneda antigua',
            'uma'         => 4,
            'land_use_id' => 20
        ]);

        //ARTÍCULOS DEPORTIVOS
        LandUseDescription::create([
            'descripcion' => 'Artículos deportivos',
            'uma'         => 6,
            'land_use_id' => 22
        ]);
        LandUseDescription::create([
            'descripcion' => 'Restauración de imágenes',
            'uma'         => 4,
            'land_use_id' => 22
        ]);

        //ARTÍCULOS VARIOS PARA EL HOGAR
        LandUseDescription::create([
            'descripcion' => 'Artículos para el hogar',
            'uma'         => 4,
            'land_use_id' => 23
        ]);
        LandUseDescription::create([
            'descripcion' => 'Limpieza hogar',
            'uma'         => 4,
            'land_use_id' => 23
        ]);
        LandUseDescription::create([
            'descripcion' => 'Loza para el hogar',
            'uma'         => 4,
            'land_use_id' => 23
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de artículos de plástico',
            'uma'         => 4,
            'land_use_id' => 23
        ]);

        //AUTO LAVADO
        LandUseDescription::create([
            'descripcion' => 'Auto lavado',
            'uma'         => 5.5,
            'land_use_id' => 24
        ]);
        LandUseDescription::create([
            'descripcion' => 'Auto lavado con maquinaria',
            'uma'         => 6.5,
            'land_use_id' => 24
        ]);

        //AUTOTRANSPORTES DE CARGA
        LandUseDescription::create([
            'descripcion' => 'Autotransportes de carga',
            'uma'         => 4.62,
            'land_use_id' => 25
        ]);

        //BAÑOS PÚBLICOS
        LandUseDescription::create([
            'descripcion' => 'Sanitario público',
            'uma'         => 4.5,
            'land_use_id' => 26
        ]);

        //REGADERAS Y VAPOR
        LandUseDescription::create([
            'descripcion' => 'Regaderas y vapor',
            'uma'         => 7.875,
            'land_use_id' => 27
        ]);

        //BÁSCULAS
        LandUseDescription::create([
            'descripcion' => 'Básculas',
            'uma'         => 5,
            'land_use_id' => 28
        ]);

        //BÁSCULAS
        LandUseDescription::create([
            'descripcion' => 'Básculas',
            'uma'         => 5,
            'land_use_id' => 28
        ]);

        //BARBERÍA
        LandUseDescription::create([
            'descripcion' => 'Barbería',
            'uma'         => 4,
            'land_use_id' => 29
        ]);

        //BLANCOS Y/O  COLCHONES
        LandUseDescription::create([
            'descripcion' => 'Blancos',
            'uma'         => 4.7,
            'land_use_id' => 30
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de Colchones',
            'uma'         => 4.7,
            'land_use_id' => 30
        ]);
        LandUseDescription::create([
            'descripcion' => 'Bodega de Colchones y Blancos',
            'uma'         => 8,
            'land_use_id' => 30
        ]);

        //BILLAR
        LandUseDescription::create([
            'descripcion' => 'Billar',
            'uma'         => 15,
            'land_use_id' => 31
        ]);

        //BONETERÍA Y/O MERCERÍA
        LandUseDescription::create([
            'descripcion' => 'Bonetería',
            'uma'         => 4,
            'land_use_id' => 32
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra y venta de estambres',
            'uma'         => 4,
            'land_use_id' => 32
        ]);
        LandUseDescription::create([
            'descripcion' => 'Mercería',
            'uma'         => 4,
            'land_use_id' => 32
        ]);

        //BORDADOS
        LandUseDescription::create([
            'descripcion' => 'Bordados en textiles',
            'uma'         => 4,
            'land_use_id' => 33
        ]);
        LandUseDescription::create([
            'descripcion' => 'Otros bordados',
            'uma'         => 4,
            'land_use_id' => 33
        ]);

        //BOUTIQUE
        LandUseDescription::create([
            'descripcion' => 'Casa de novias',
            'uma'         => 10,
            'land_use_id' => 34
        ]);
        LandUseDescription::create([
            'descripcion' => 'Boutique ropa',
            'uma'         => 10,
            'land_use_id' => 34
        ]);
        LandUseDescription::create([
            'descripcion' => 'Tienda de Ropa en centro Histórico Y CENTRO COMERCIAL',
            'uma'         => 10,
            'land_use_id' => 34
        ]);

        //CANCHAS DEPORTIVAS
        LandUseDescription::create([
            'descripcion' => 'Cancha de futbol rápido',
            'uma'         => 5.25,
            'land_use_id' => 35
        ]);

        //CARNICERÍA
        LandUseDescription::create([
            'descripcion' => 'Carnicería',
            'uma'         => 6.405,
            'land_use_id' => 36
        ]);

        //CASA DE CAMBIO
        LandUseDescription::create([
            'descripcion' => 'Divisa, casa de cambio',
            'uma'         => 5.5,
            'land_use_id' => 37
        ]);
        LandUseDescription::create([
            'descripcion' => 'Centro Cambiario',
            'uma'         => 5.5,
            'land_use_id' => 37
        ]);

        //CASA DE EMPEÑO
        LandUseDescription::create([
            'descripcion' => 'Casa de empeño',
            'uma'         => 10,
            'land_use_id' => 38
        ]);

        //CENTRO DE ACONDICIONAMIENTO FÍSICO Y ACADEMIAS ARTÍSTICAS
        LandUseDescription::create([
            'descripcion' => 'Escuela de artes marciales',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela de Yoga',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela de  futbol',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);
        LandUseDescription::create([
            'descripcion' => 'Artes marciales',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuelas de Danza',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);
        LandUseDescription::create([
            'descripcion' => 'Gimnasio',
            'uma'         => 5.46,
            'land_use_id' => 39
        ]);

        //CENTRO DE CONSULTA POR INTERNET
        LandUseDescription::create([
            'descripcion' => 'Ciber y/o Renta de Computadora',
            'uma'         => 4,
            'land_use_id' => 40
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ciber y Papelería',
            'uma'         => 4,
            'land_use_id' => 40
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ciber, Venta de Accesorios y Reparación de computadoras',
            'uma'         => 4,
            'land_use_id' => 40
        ]);

        //CENTRO DE ENTRETENIMIENTO INFANTIL Y RENTA
        LandUseDescription::create([
            'descripcion' => 'Centro de entretenimiento Infantil',
            'uma'         => 5.25,
            'land_use_id' => 41
        ]);
        LandUseDescription::create([
            'descripcion' => 'Juegos Inflables-Aparatos montables-Juegos montables',
            'uma'         => 5.25,
            'land_use_id' => 41
        ]);

        //CENTRO DE FOTOCOPIADO
        LandUseDescription::create([
            'descripcion' => 'Fotostáticas, copiadoras',
            'uma'         => 4.62,
            'land_use_id' => 42
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller de encuadernación',
            'uma'         => 4.62,
            'land_use_id' => 42
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta y renta de fotocopiadoras',
            'uma'         => 4.62,
            'land_use_id' => 42
        ]);

        //CENTRO DE REHABILITACIÓN DE ADICCIONES
        LandUseDescription::create([
            'descripcion' => 'Centro Rehabilitación de Adicciones Voluntario',
            'uma'         => 10,
            'land_use_id' => 43
        ]);
        LandUseDescription::create([
            'descripcion' => 'Centro Rehabilitación de Adicciones  de Contribución y/o Cuota',
            'uma'         => 20,
            'land_use_id' => 43
        ]);

        //CENTRO DE TATUAJES
        LandUseDescription::create([
            'descripcion' => 'Centro de tatuaje',
            'uma'         => 7,
            'land_use_id' => 44
        ]);

        //CENTRO NOCTURNO
        LandUseDescription::create([
            'descripcion' => 'Centro Nocturno',
            'uma'         => 15,
            'land_use_id' => 45
        ]);
        LandUseDescription::create([
            'descripcion' => 'Bar, Cantina',
            'uma'         => 15,
            'land_use_id' => 45
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ladies-bar',
            'uma'         => 15,
            'land_use_id' => 45
        ]);
        LandUseDescription::create([
            'descripcion' => 'Casino',
            'uma'         => 15,
            'land_use_id' => 45
        ]);

        //CERRAJERÍA
        LandUseDescription::create([
            'descripcion' => 'Cerrajería y Servicios',
            'uma'         => 4,
            'land_use_id' => 46
        ]);

        //CHATARRA
        LandUseDescription::create([
            'descripcion' => 'Chatarra',
            'uma'         => 5,
            'land_use_id' => 47
        ]);
        LandUseDescription::create([
            'descripcion' => 'Chatarra en mayoría',
            'uma'         => 5,
            'land_use_id' => 47
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra Venta de Fiero y Chatarra',
            'uma'         => 5,
            'land_use_id' => 47
        ]);

        //CLÍNICA MÉDICA
        LandUseDescription::create([
            'descripcion' => 'Clínica médica',
            'uma'         => 9.45,
            'land_use_id' => 48
        ]);

        //COCINAS INTEGRALES
        LandUseDescription::create([
            'descripcion' => 'Cocinas integrales',
            'uma'         => 4,
            'land_use_id' => 49
        ]);

        //COMERCIALIZADORA DE PRODUCTOS EXPLOSIVOS
        LandUseDescription::create([
            'descripcion' => 'Comercialización de Productos Explosivos',
            'uma'         => 8.085,
            'land_use_id' => 50
        ]);

        //COMERCIALIZADORA DE PRODUCTOS E INSUMOS
        LandUseDescription::create([
            'descripcion' => 'Comercialización de productos e insumos',
            'uma'         => 8.8,
            'land_use_id' => 51
        ]);

        //CONSTRUCTORA Y MAQUINARIA
        LandUseDescription::create([
            'descripcion' => 'Constructora y maquinaria',
            'uma'         => 15,
            'land_use_id' => 52
        ]);

        //CONSULTORÍA Y ASESORÍA
        LandUseDescription::create([
            'descripcion' => 'Asesoría para construcción',
            'uma'         => 5.775,
            'land_use_id' => 53
        ]);
        LandUseDescription::create([
            'descripcion' => 'Asesoría preparatoria abierta',
            'uma'         => 5.775,
            'land_use_id' => 53
        ]);
        LandUseDescription::create([
            'descripcion' => 'Asesoría minera',
            'uma'         => 5.775,
            'land_use_id' => 53
        ]);
        LandUseDescription::create([
            'descripcion' => 'Asesorías agrarias',
            'uma'         => 5.775,
            'land_use_id' => 53
        ]);
        LandUseDescription::create([
            'descripcion' => 'Asesoría escolar',
            'uma'         => 5.775,
            'land_use_id' => 53
        ]);

        //CONSULTORIO DE ESPECIALIDADES MÉDICAS
        LandUseDescription::create([
            'descripcion' => 'Acupuntura y Medicina Oriental',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Clínica de masaje y depilación',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Consultorio en general',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Consultorio Dental',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Quiropráctico',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Cosmetóloga y accesorios',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pedicurista',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Podólogo especialista',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Quiromasaje consultorio',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Tratamientos estéticos',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);
        LandUseDescription::create([
            'descripcion' => 'Tratamientos para cuidado personal',
            'uma'         => 7.35,
            'land_use_id' => 54
        ]);

        //CONSULTORIO GENÉRICO
        LandUseDescription::create([
            'descripcion' => 'Consultorio general Genérico',
            'uma'         => 5,
            'land_use_id' => 55
        ]);
        LandUseDescription::create([
            'descripcion' => 'Consultorio Dental Genérico',
            'uma'         => 5,
            'land_use_id' => 55
        ]);

        //CREMERÍA
        LandUseDescription::create([
            'descripcion' => 'Carnes frías y abarrotes-Carnes rojas y embutidos-Chorizo y carne adobada-Empacadora de embutidos-Expendio de vísceras-Quesos -Crema-Venta de Yogurt',
            'uma'         => 5,
            'land_use_id' => 56
        ]);

        //DISTRUBUIDORA DE LÁCTEOS
        LandUseDescription::create([
            'descripcion' => 'Queso comercio en grande',
            'uma'         => 8,
            'land_use_id' => 57
        ]);

        //DECORACIÓN DE INTERIORES Y ACCESORIOS
        LandUseDescription::create([
            'descripcion' => 'Decoración de Interiores',
            'uma'         => 4.8,
            'land_use_id' => 58
        ]);
        LandUseDescription::create([
            'descripcion' => 'Velas y cuadros',
            'uma'         => 4.8,
            'land_use_id' => 58
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de Cuadros',
            'uma'         => 4.8,
            'land_use_id' => 58
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de plantas de ornato',
            'uma'         => 4.8,
            'land_use_id' => 58
        ]);

        //DEPÓSITO DE REFRESCOS
        LandUseDescription::create([
            'descripcion' => 'Depósito y venta de refrescos',
            'uma'         => 5.5,
            'land_use_id' => 59
        ]);

        //DISCOTEQUE Y/O ANTRO
        LandUseDescription::create([
            'descripcion' => 'Discoteque y/o Antro',
            'uma'         => 15,
            'land_use_id' => 60
        ]);

        //DISEÑO GRÁFICO, SERIGRAFÍA Y RÓTULOS
        LandUseDescription::create([
            'descripcion' => 'Diseño arquitectónico',
            'uma'         => 4.62,
            'land_use_id' => 61
        ]);
        LandUseDescription::create([
            'descripcion' => 'Diseño gráfico',
            'uma'         => 4.62,
            'land_use_id' => 61
        ]);
        LandUseDescription::create([
            'descripcion' => 'Rótulos y gráficos por computadora',
            'uma'         => 4.62,
            'land_use_id' => 61
        ]);
        LandUseDescription::create([
            'descripcion' => 'Rótulos, pintores',
            'uma'         => 4.62,
            'land_use_id' => 61
        ]);
        LandUseDescription::create([
            'descripcion' => 'Serigrafía',
            'uma'         => 4.62,
            'land_use_id' => 61
        ]);

        //DULCERÍA
        LandUseDescription::create([
            'descripcion' => 'Dulcería en general',
            'uma'         => 4,
            'land_use_id' => 62
        ]);
        LandUseDescription::create([
            'descripcion' => 'Dulces Típicos',
            'uma'         => 4,
            'land_use_id' => 62
        ]);
        LandUseDescription::create([
            'descripcion' => 'Dulces en pequeño',
            'uma'         => 4,
            'land_use_id' => 62
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de Chocolates y Confitería',
            'uma'         => 4,
            'land_use_id' => 62
        ]);

        //EDUCACIÓN TÉCNICA Y DE OFICIOS
        LandUseDescription::create([
            'descripcion' => 'Cursos de computación',
            'uma'         => 5.2,
            'land_use_id' => 63
        ]);
        LandUseDescription::create([
            'descripcion' => 'Instituto de Belleza',
            'uma'         => 5.2,
            'land_use_id' => 63
        ]);
        LandUseDescription::create([
            'descripcion' => 'Otros oficios',
            'uma'         => 5.2,
            'land_use_id' => 63
        ]);

        //ELECTRÓNICA
        LandUseDescription::create([
            'descripcion' => 'Partes y accesorios para electrónica',
            'uma'         => 4,
            'land_use_id' => 64
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta y reparación de máquinas registradoras',
            'uma'         => 4,
            'land_use_id' => 64
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller de reparación de artículos electrónicos',
            'uma'         => 4,
            'land_use_id' => 64
        ]);

        //ENSERES ELÉCTRICOS Y LÍNEA BLANCA
        LandUseDescription::create([
            'descripcion' => 'Equipos, accesorios y reparación',
            'uma'         => 5,
            'land_use_id' => 65
        ]);
        LandUseDescription::create([
            'descripcion' => 'Muebles línea blanca, electrónicos',
            'uma'         => 5,
            'land_use_id' => 65
        ]);

        //EMBOTELLADORAS (B)
        LandUseDescription::create([
            'descripcion' => 'Cervezas y/o refrescos',
            'uma'         => 8,
            'land_use_id' => 66
        ]);

        //EQUIPO DE CÓMPUTO, MANTENIMIENTO, Y ACCESORIOS
        LandUseDescription::create([
            'descripcion' => 'Artículos de computación y papelería',
            'uma'         => 6.5,
            'land_use_id' => 67
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de computadoras y accesorios',
            'uma'         => 6.5,
            'land_use_id' => 67
        ]);
        LandUseDescription::create([
            'descripcion' => 'Recarga de Cartuchos',
            'uma'         => 6.5,
            'land_use_id' => 67
        ]);
        LandUseDescription::create([
            'descripcion' => 'Reparación y mantenimiento de  computadoras',
            'uma'         => 6.5,
            'land_use_id' => 67
        ]);

        //ESTACIONAMIENTO Y/O PENSIÓN
        LandUseDescription::create([
            'descripcion' => 'Estacionamientos, con independencia en lo previsto en la Ley de Estacionamientos Públicos para el Estado de Zacatecas.',
            'uma'         => 15,
            'land_use_id' => 68
        ]);
        LandUseDescription::create([
            'descripcion' => 'Estacionamiento Permiso Eventual por día',
            'uma'         => 4,
            'land_use_id' => 68
        ]);

        //ESTÉTICA / SALÓN DE BELLEZA
        LandUseDescription::create([
            'descripcion' => 'Estética',
            'uma'         => 6,
            'land_use_id' => 69
        ]);
        LandUseDescription::create([
            'descripcion' => 'Estética en Uñas',
            'uma'         => 4,
            'land_use_id' => 69
        ]);
        LandUseDescription::create([
            'descripcion' => 'Salón de belleza',
            'uma'         => 4,
            'land_use_id' => 69
        ]);
        LandUseDescription::create([
            'descripcion' => 'Estética y Venta de Productos de Belleza',
            'uma'         => 6,
            'land_use_id' => 69
        ]);

        //ESTÉTICA DE ANIMALES
        LandUseDescription::create([
            'descripcion' => 'Accesorios para mascotas',
            'uma'         => 5,
            'land_use_id' => 70
        ]);
        LandUseDescription::create([
            'descripcion' => 'Alimentos para Mascotas y Botanas',
            'uma'         => 5,
            'land_use_id' => 70
        ]);
        LandUseDescription::create([
            'descripcion' => 'Estética canina',
            'uma'         => 5,
            'land_use_id' => 70
        ]);

        //ESTUDIO FOTOGRÁFICO
        LandUseDescription::create([
            'descripcion' => 'Fotografías y artículos',
            'uma'         => 4,
            'land_use_id' => 71
        ]);

        //EXPENDIO DE CERVEZA
        LandUseDescription::create([
            'descripcion' => 'Expendio de cerveza',
            'uma'         => 8.4,
            'land_use_id' => 72
        ]);

        //FÁBRICA DE HIELO
        LandUseDescription::create([
            'descripcion' => 'Fábricas de hielo',
            'uma'         => 4,
            'land_use_id' => 73
        ]);

        //FÁBRICA Y/O REPARACIÓN DE MUEBLES
        LandUseDescription::create([
            'descripcion' => 'Reparación y venta de muebles',
            'uma'         => 5.5,
            'land_use_id' => 74
        ]);
        LandUseDescription::create([
            'descripcion' => 'Fábrica de Muebles',
            'uma'         => 5.775,
            'land_use_id' => 74
        ]);

        //FARMACIA CON MINI SÚPER
        LandUseDescription::create([
            'descripcion' => 'Farmacias con mini súper',
            'uma'         => 14,
            'land_use_id' => 75
        ]);

        //FARMACIA
        LandUseDescription::create([
            'descripcion' => 'Suplementos alimenticios y vitamínicos',
            'uma'         => 5.25,
            'land_use_id' => 76
        ]);
        LandUseDescription::create([
            'descripcion' => 'Farmacia en general',
            'uma'         => 5.25,
            'land_use_id' => 76
        ]);
        LandUseDescription::create([
            'descripcion' => 'Farmacia Homeopática',
            'uma'         => 5.25,
            'land_use_id' => 76
        ]);

        //FERRETERÍA EN GENERAL
        LandUseDescription::create([
            'descripcion' => 'Artículos solares',
            'uma'         => 5.775,
            'land_use_id' => 77
        ]);
        LandUseDescription::create([
            'descripcion' => 'Cableados',
            'uma'         => 5.775,
            'land_use_id' => 77
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ferretería en general',
            'uma'         => 5.775,
            'land_use_id' => 77
        ]);
        LandUseDescription::create([
            'descripcion' => 'Hules y mangueras',
            'uma'         => 5.775,
            'land_use_id' => 77
        ]);
        LandUseDescription::create([
            'descripcion' => 'Tlapalería',
            'uma'         => 5.775,
            'land_use_id' => 77
        ]);

        //FLORERÍA
        LandUseDescription::create([
            'descripcion' => 'Florería',
            'uma'         => 5,
            'land_use_id' => 78
        ]);
        LandUseDescription::create([
            'descripcion' => 'Florería y muebles rústicos',
            'uma'         => 5,
            'land_use_id' => 78
        ]);

        //FONTANERÍA Y/O INSTALACIONES SANITARIAS
        LandUseDescription::create([
            'descripcion' => 'Fontanería e instalaciones sanitaria',
            'uma'         => 4,
            'land_use_id' => 79
        ]);

        //PREPARACIÓN DE ALIMENTOS Y BEBIDAS
        LandUseDescription::create([
            'descripcion' => 'Venta de alimentos y bebidas preparadas',
            'uma'         => 5,
            'land_use_id' => 80
        ]);

        //FONDA-CENADURÍA-COCINA ECONÓMICA
        LandUseDescription::create([
            'descripcion' => 'Cenadurías y fondas',
            'uma'         => 4.62,
            'land_use_id' => 81
        ]);

        //FUMIGACIONES
        LandUseDescription::create([
            'descripcion' => 'Servicio de fumigaciones, venta de equipos y suplementos',
            'uma'         => 5,
            'land_use_id' => 82
        ]);

        //FUNERARIA
        LandUseDescription::create([
            'descripcion' => 'Funeraria por sala de velación',
            'uma'         => 7.5,
            'land_use_id' => 83
        ]);

        //GABINETE RADIOLÓGICO
        LandUseDescription::create([
            'descripcion' => 'Gabinete radiológico, Radiología',
            'uma'         => 6.3,
            'land_use_id' => 84
        ]);

        //GALERÍA Y/O ESTUDIO DE ARTE
        LandUseDescription::create([
            'descripcion' => 'Galerías',
            'uma'         => 6.6,
            'land_use_id' => 85
        ]);
        LandUseDescription::create([
            'descripcion' => 'Galerías de arte y enmarcados',
            'uma'         => 6.6,
            'land_use_id' => 85
        ]);

        //ENMARCADOS
        LandUseDescription::create([
            'descripcion' => 'Marcos y molduras',
            'uma'         => 4,
            'land_use_id' => 86
        ]);
        LandUseDescription::create([
            'descripcion' => 'Vidrios, marcos y molduras',
            'uma'         => 4,
            'land_use_id' => 86
        ]);

        //GASOLINERAS Y GASERAS
        LandUseDescription::create([
            'descripcion' => 'Gasolineras y gaseras',
            'uma'         => 15,
            'land_use_id' => 87
        ]);

        //GRANOS Y SEMILLAS
        LandUseDescription::create([
            'descripcion' => 'Harina y maíz',
            'uma'         => 5.25,
            'land_use_id' => 88
        ]);
        LandUseDescription::create([
            'descripcion' => 'Granos y semillas en general',
            'uma'         => 5.25,
            'land_use_id' => 88
        ]);
        LandUseDescription::create([
            'descripcion' => 'Semillas, Cereales, Chiles Secos y Abarrotes',
            'uma'         => 5.25,
            'land_use_id' => 88
        ]);

        //GRÚAS
        LandUseDescription::create([
            'descripcion' => 'Venta y/o servicio de Grúas',
            'uma'         => 10.5,
            'land_use_id' => 89
        ]);

        //GUARDERÍA
        LandUseDescription::create([
            'descripcion' => 'Guardería',
            'uma'         => 6,
            'land_use_id' => 90
        ]);

        //HIERBAS MEDICINALES
        LandUseDescription::create([
            'descripcion' => 'Hierbas Medicinales',
            'uma'         => 4,
            'land_use_id' => 91
        ]);

        //HOSPITAL
        LandUseDescription::create([
            'descripcion' => 'Hospital',
            'uma'         => 10.5,
            'land_use_id' => 92
        ]);

        //HOSTALES, CASA DE HUÉSPEDES
        LandUseDescription::create([
            'descripcion' => 'Hostales',
            'uma'         => 6.825,
            'land_use_id' => 93
        ]);
        LandUseDescription::create([
            'descripcion' => 'Casa huéspedes',
            'uma'         => 6.5,
            'land_use_id' => 93
        ]);

        //HOTEL Y/O MOTEL
        LandUseDescription::create([
            'descripcion' => 'Hotel en Pequeño',
            'uma'         => 15,
            'land_use_id' => 94
        ]);
        LandUseDescription::create([
            'descripcion' => 'Hoteles',
            'uma'         => 15,
            'land_use_id' => 94
        ]);
        LandUseDescription::create([
            'descripcion' => 'Moteles',
            'uma'         => 15,
            'land_use_id' => 94
        ]);

        //IMPLEMENTOS AGRÍCOLAS Y/O APÍCOLAS
        LandUseDescription::create([
            'descripcion' => 'Implementos agrícolas',
            'uma'         => 6.6,
            'land_use_id' => 95
        ]);
        LandUseDescription::create([
            'descripcion' => 'Implementos apícolas',
            'uma'         => 6.6,
            'land_use_id' => 95
        ]);
        LandUseDescription::create([
            'descripcion' => 'Productos agrícolas',
            'uma'         => 6.6,
            'land_use_id' => 95
        ]);

        //IMPRENTA
        LandUseDescription::create([
            'descripcion' => 'Imprenta',
            'uma'         => 4.62,
            'land_use_id' => 96
        ]);
        LandUseDescription::create([
            'descripcion' => 'Impresión de planos por computadora',
            'uma'         => 4.62,
            'land_use_id' => 96
        ]);
        LandUseDescription::create([
            'descripcion' => 'Impresiones digitales en computadora',
            'uma'         => 4.62,
            'land_use_id' => 96
        ]);
        LandUseDescription::create([
            'descripcion' => 'Productos para imprenta',
            'uma'         => 4.62,
            'land_use_id' => 96
        ]);

        // INMOBILIARIA
        LandUseDescription::create([
            'descripcion' => 'Comercializadora y arrendadora',
            'uma'         => 7.35,
            'land_use_id' => 97
        ]);
        LandUseDescription::create([
            'descripcion' => 'Inmobiliaria',
            'uma'         => 7.35,
            'land_use_id' => 97
        ]);

        //INSTITUCIONES EDUCATIVAS PRIVADAS
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel preescolar',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel primaria',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel secundaria',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel preparatoria',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel universidad',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel posgrados',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);
        LandUseDescription::create([
            'descripcion' => 'Escuela nivel técnico',
            'uma'         => 8.5,
            'land_use_id' => 98
        ]);

        //JARCERÍA
        LandUseDescription::create([
            'descripcion' => 'Jarcería-Reparación y venta de Sombreros- Artículos vaqueros- Artículos charros',
            'uma'         => 4,
            'land_use_id' => 99
        ]);

        //JOYERÍA Y/O VENTA-COMPRA ORO Y PLATA
        LandUseDescription::create([
            'descripcion' => 'Compra-venta de oro y Plata',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Joyería',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Joyería y Regalos',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pedacería de oro',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Platería',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Reparación de joyería',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra Pedacería de Oro',
            'uma'         => 5.04,
            'land_use_id' => 100
        ]);

        //JUGOS Y/O FUENTE DE SODAS
        LandUseDescription::create([
            'descripcion' => 'Fuente de sodas y/o Jugos',
            'uma'         => 4.4,
            'land_use_id' => 101
        ]);

        //JUEGOS DE AZAR
        LandUseDescription::create([
            'descripcion' => 'Billetes de lotería',
            'uma'         => 4.4,
            'land_use_id' => 102
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pronósticos',
            'uma'         => 4.4,
            'land_use_id' => 102
        ]);

        //JUGUETERÍA
        LandUseDescription::create([
            'descripcion' => 'Juguetería en pequeño',
            'uma'         => 4,
            'land_use_id' => 103
        ]);
        LandUseDescription::create([
            'descripcion' => 'Juguetería',
            'uma'         => 5.775,
            'land_use_id' => 103
        ]);

        //LABORATORIO EN GENERAL
        LandUseDescription::create([
            'descripcion' => 'Laboratorio en general',
            'uma'         => 6.1,
            'land_use_id' => 104
        ]);

        //LÁPIDAS
        LandUseDescription::create([
            'descripcion' => 'Lápidas',
            'uma'         => 4.4,
            'land_use_id' => 105
        ]);

        //LIBRERÍA ,REVISTAS, PERIODICOS Y POSTERS
        LandUseDescription::create([
            'descripcion' => 'Librería',
            'uma'         => 5,
            'land_use_id' => 106
        ]);
        LandUseDescription::create([
            'descripcion' => 'Revistas y periódicos',
            'uma'         => 5,
            'land_use_id' => 106
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de Posters',
            'uma'         => 4.4,
            'land_use_id' => 106
        ]);

        //LÍNEAS AÉREAS
        LandUseDescription::create([
            'descripcion' => 'Líneas aéreas',
            'uma'         => 9.45,
            'land_use_id' => 107
        ]);

        //LONAS Y TOLDOS
        LandUseDescription::create([
            'descripcion' => 'Venta y/o renta de Lonas y/o Toldos',
            'uma'         => 5.5,
            'land_use_id' => 108
        ]);

        //MADERERÍA Y/O CARPINTERÍA
        LandUseDescription::create([
            'descripcion' => 'Carpintería',
            'uma'         => 5.5,
            'land_use_id' => 109
        ]);
        LandUseDescription::create([
            'descripcion' => 'Maderería',
            'uma'         => 5.5,
            'land_use_id' => 109
        ]);
        LandUseDescription::create([
            'descripcion' => 'Carpintería y Pintura',
            'uma'         => 5.5,
            'land_use_id' => 109
        ]);

        //MAQUILADORA
        LandUseDescription::create([
            'descripcion' => 'Maquiladora',
            'uma'         => 9,
            'land_use_id' => 110
        ]);

        //MATERIALES PARA CONSTRUCCIÓN (A)
        LandUseDescription::create([
            'descripcion' => 'Materiales para construcción',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Elaboración de block',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra venta de tabla roca',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pisos y azulejos',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller de cantera',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Canteras y accesorios',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);
        LandUseDescription::create([
            'descripcion' => 'Material eléctrico y plomería',
            'uma'         => 6.09,
            'land_use_id' => 111
        ]);

        //MATERIALES PARA CONSTRUCCIÓN (B)
        LandUseDescription::create([
            'descripcion' => 'Cancelería, vidrio y aluminio',
            'uma'         => 6.09,
            'land_use_id' => 112
        ]);
        LandUseDescription::create([
            'descripcion' => 'Herramienta para construcción',
            'uma'         => 6.09,
            'land_use_id' => 112
        ]);
        LandUseDescription::create([
            'descripcion' => 'Boiler solares',
            'uma'         => 6.09,
            'land_use_id' => 112
        ]);

        //MATERIALES PARA CONSTRUCCIÓN (C)
        LandUseDescription::create([
            'descripcion' => 'Mallas y alambres',
            'uma'         => 7,
            'land_use_id' => 113
        ]);
        LandUseDescription::create([
            'descripcion' => 'Impermeabilizante',
            'uma'         => 7,
            'land_use_id' => 113
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pinturas y barnices',
            'uma'         => 7,
            'land_use_id' => 113
        ]);

        //MUEBLERÍA
        LandUseDescription::create([
            'descripcion' => 'Mueblería',
            'uma'         => 4.83,
            'land_use_id' => 114
        ]);
        LandUseDescription::create([
            'descripcion' => 'Muebles línea blanca',
            'uma'         => 4.83,
            'land_use_id' => 114
        ]);
        LandUseDescription::create([
            'descripcion' => 'Muebles rústicos',
            'uma'         => 4.83,
            'land_use_id' => 114
        ]);

        //MUEBLES , EQUIPO E INSTRUMENTAL MÉDICO
        LandUseDescription::create([
            'descripcion' => 'Alcohol etílico',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Artículos dentales',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Depósito Dental',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Equipo médico',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Gas medicinal e industriales',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Material de curación',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);
        LandUseDescription::create([
            'descripcion' => 'Taller dental',
            'uma'         => 5.4,
            'land_use_id' => 115
        ]);

        //OFICINAS
        LandUseDescription::create([
            'descripcion' => 'Despachos',
            'uma'         => 5,
            'land_use_id' => 116
        ]);
        LandUseDescription::create([
            'descripcion' => 'Oficinas administrativas',
            'uma'         => 5,
            'land_use_id' => 116
        ]);

        //ÓPTICA
        LandUseDescription::create([
            'descripcion' => 'Óptica médica',
            'uma'         => 4,
            'land_use_id' => 117
        ]);

        //PALETERÍA O NEVERÍA
        LandUseDescription::create([
            'descripcion' => 'Distribución de helados y paletas',
            'uma'         => 4.8,
            'land_use_id' => 118
        ]);
        LandUseDescription::create([
            'descripcion' => 'Fábricas de paletas y helados',
            'uma'         => 4.8,
            'land_use_id' => 118
        ]);
        LandUseDescription::create([
            'descripcion' => 'Nevería',
            'uma'         => 4.8,
            'land_use_id' => 118
        ]);

        //PANADERÍA
        LandUseDescription::create([
            'descripcion' => 'Panadería, elaboracion y venta',
            'uma'         => 5.565,
            'land_use_id' => 119
        ]);
        LandUseDescription::create([
            'descripcion' => 'Panadería y cafetería',
            'uma'         => 5.565,
            'land_use_id' => 119
        ]);
        LandUseDescription::create([
            'descripcion' => 'Panadería y Pastelería',
            'uma'         => 5.565,
            'land_use_id' => 119
        ]);
        LandUseDescription::create([
            'descripcion' => 'Expendios de pan',
            'uma'         => 5.3,
            'land_use_id' => 119
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de materia prima para panificadoras',
            'uma'         => 5.3,
            'land_use_id' => 119
        ]);

        // PAÑALES DESECHABLES
        LandUseDescription::create([
            'descripcion' => 'Pañales desechables',
            'uma'         => 4,
            'land_use_id' => 120
        ]);

        // PAPELERÍA
        LandUseDescription::create([
            'descripcion' => 'Papelería y centro de copiado',
            'uma'         => 5,
            'land_use_id' => 121
        ]);
        LandUseDescription::create([
            'descripcion' => 'Papelería y regalos',
            'uma'         => 5,
            'land_use_id' => 121
        ]);
        LandUseDescription::create([
            'descripcion' => 'Papelería y comercio en grande',
            'uma'         => 5,
            'land_use_id' => 121
        ]);

        //PASTELERÍA Y REPOSTERÍA
        LandUseDescription::create([
            'descripcion' => 'Pastelería',
            'uma'         => 5.67,
            'land_use_id' => 122
        ]);
        LandUseDescription::create([
            'descripcion' => 'Repostería Fina',
            'uma'         => 5.67,
            'land_use_id' => 122
        ]);

        //PELUQUERÍA
        LandUseDescription::create([
            'descripcion' => 'Peluquería',
            'uma'         => 4,
            'land_use_id' => 123
        ]);

        //PERFUMERÍA
        LandUseDescription::create([
            'descripcion' => 'Perfumería y colonias',
            'uma'         => 4.2,
            'land_use_id' => 124
        ]);

        //POLLO Y/O DERIVADOS
        LandUseDescription::create([
            'descripcion' => 'Expendio de huevo y pollo',
            'uma'         => 4.1,
            'land_use_id' => 125
        ]);
        LandUseDescription::create([
            'descripcion' => 'Expendio de huevo y pollo fresco',
            'uma'         => 4.1,
            'land_use_id' => 125
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pollo, Frutas y Legumbres',
            'uma'         => 4.1,
            'land_use_id' => 125
        ]);

        //PRODUCTOS DE BELLEZA
        LandUseDescription::create([
            'descripcion' => 'Artículos de belleza',
            'uma'         => 5.4,
            'land_use_id' => 126
        ]);
        LandUseDescription::create([
            'descripcion' => 'Compra venta de mobiliario y artículos de belleza',
            'uma'         => 5.4,
            'land_use_id' => 126
        ]);
        LandUseDescription::create([
            'descripcion' => 'Cosméticos y accesorios',
            'uma'         => 5.4,
            'land_use_id' => 126
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de productos de Belleza',
            'uma'         => 5.4,
            'land_use_id' => 126
        ]);

        //PRODUCTOS QUÍMICOS INDUSTRIALES
        LandUseDescription::create([
            'descripcion' => 'Productos químicos industriales',
            'uma'         => 5.5,
            'land_use_id' => 127
        ]);

        //MEDIOS DE COMUNICACIÓN
        LandUseDescription::create([
            'descripcion' => 'Televisoras',
            'uma'         => 15,
            'land_use_id' => 128
        ]);
        LandUseDescription::create([
            'descripcion' => 'Radiodifusoras',
            'uma'         => 15,
            'land_use_id' => 128
        ]);
        LandUseDescription::create([
            'descripcion' => 'Periódicos y/o Casas Editoriales',
            'uma'         => 15,
            'land_use_id' => 128
        ]);

        //REFACCIONARIA EN GENERAL
        LandUseDescription::create([
            'descripcion' => 'Aceites y lubricantes',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refaccionaria eléctrica',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refacciones para estufas',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refacciones  bicicletas',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refacciones para motocicletas',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta y Reparación de Escapes',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de Bombas y sensores',
            'uma'         => 5,
            'land_use_id' => 129
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refaccionaria en general y almacén',
            'uma'         => 8,
            'land_use_id' => 129
        ]);

        //REFACCIONES INDUSTRIALES
        LandUseDescription::create([
            'descripcion' => 'Refacciones industriales',
            'uma'         => 8,
            'land_use_id' => 130
        ]);

        //REFRIGERACIÓN  Y/O  ARTÍCULOS
        LandUseDescription::create([
            'descripcion' => 'Artículos de refrigeración',
            'uma'         => 4,
            'land_use_id' => 131
        ]);
        LandUseDescription::create([
            'descripcion' => 'Refrigeración comercial e industrial',
            'uma'         => 4,
            'land_use_id' => 131
        ]);

        //RELOJERÍA
        LandUseDescription::create([
            'descripcion' => 'Reparación de relojes',
            'uma'         => 4.4,
            'land_use_id' => 132
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de relojes y bisutería',
            'uma'         => 4.4,
            'land_use_id' => 132
        ]);

        //RENTA DE MAQUINAS DE VIEOJUEGOS (JUEGOS POR MAQ) c/u
        LandUseDescription::create([
            'descripcion' => 'Máquinas de video juegos',
            'uma'         => 4,
            'land_use_id' => 133
        ]);

        //RENTA DE TRANSPORTE
        LandUseDescription::create([
            'descripcion' => 'Renta de autobús',
            'uma'         => 7.89,
            'land_use_id' => 134
        ]);
        LandUseDescription::create([
            'descripcion' => 'Renta de autos',
            'uma'         => 7.89,
            'land_use_id' => 134
        ]);
        LandUseDescription::create([
            'descripcion' => 'Renta de motos',
            'uma'         => 7.89,
            'land_use_id' => 134
        ]);

        //RENTA Y VENTA DE PELÍCULAS Y VIDEOJUEGOS
        LandUseDescription::create([
            'descripcion' => 'Artículos de video juegos',
            'uma'         => 5.775,
            'land_use_id' => 135
        ]);
        LandUseDescription::create([
            'descripcion' => 'Renta y venta de películas',
            'uma'         => 5.775,
            'land_use_id' => 135
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de accesorios para video-juegos',
            'uma'         => 5.775,
            'land_use_id' => 135
        ]);

        //REPARACIÓN DE CALZADO
        LandUseDescription::create([
            'descripcion' => 'Reparación de calzado de materiales varios',
            'uma'         => 4,
            'land_use_id' => 136
        ]);

        //ROSTICERIAS
        LandUseDescription::create([
            'descripcion' => 'Rosticerías',
            'uma'         => 4.41,
            'land_use_id' => 137
        ]);
        LandUseDescription::create([
            'descripcion' => 'Pollo asado',
            'uma'         => 4.41,
            'land_use_id' => 137
        ]);

        //SALAS CINEMATOGRÁFICAS
        LandUseDescription::create([
            'descripcion' => 'Salas cinematográficas por sala',
            'uma'         => 5.775,
            'land_use_id' => 138
        ]);

        //SALÓN DE FIESTAS
        LandUseDescription::create([
            'descripcion' => 'Salón de fiestas',
            'uma'         => 14.7,
            'land_use_id' => 139
        ]);
        LandUseDescription::create([
            'descripcion' => 'Salón de fiestas infantiles',
            'uma'         => 6.3,
            'land_use_id' => 139
        ]);

        //SERVICIOS TÉCNICOS PROFESIONALES EN GENERAL
        LandUseDescription::create([
            'descripcion' => 'Prestación de Servicios Profesionales',
            'uma'         => 4,
            'land_use_id' => 140
        ]);

        //SERVICIOS DE LIMPIEZA
        LandUseDescription::create([
            'descripcion' => 'Artículos de limpieza',
            'uma'         => 4.9,
            'land_use_id' => 141
        ]);
        LandUseDescription::create([
            'descripcion' => 'Suministro personal de limpieza',
            'uma'         => 4.9,
            'land_use_id' => 141
        ]);
        LandUseDescription::create([
            'descripcion' => 'Servicio de limpieza',
            'uma'         => 7.8,
            'land_use_id' => 141
        ]);
        LandUseDescription::create([
            'descripcion' => 'Mantenimiento e higiene comercial y doméstica',
            'uma'         => 7.8,
            'land_use_id' => 141
        ]);

        //TALLER DE SOLDADURA
        LandUseDescription::create([
            'descripcion' => 'Taller de soldadura',
            'uma'         => 6,
            'land_use_id' => 142
        ]);

        //TEATROS
        LandUseDescription::create([
            'descripcion' => 'Teatros',
            'uma'         => 7.7,
            'land_use_id' => 143
        ]);

        //TELEVISIÓN POR CABLE Y/O SATELITAL
        LandUseDescription::create([
            'descripcion' => 'Televisión por cable',
            'uma'         => 11.55,
            'land_use_id' => 144
        ]);

        //TIENDA DE DISCOS
        LandUseDescription::create([
            'descripcion' => 'Discos y accesorios originales',
            'uma'         => 4,
            'land_use_id' => 145
        ]);

        //TIENDA DE ROPA
        LandUseDescription::create([
            'descripcion' => 'Accesorios y ropa para bebe',
            'uma'         => 4,
            'land_use_id' => 146
        ]);
        LandUseDescription::create([
            'descripcion' => 'Lencería y corsetería',
            'uma'         => 4,
            'land_use_id' => 146
        ]);
        LandUseDescription::create([
            'descripcion' => 'Moisés',
            'uma'         => 4,
            'land_use_id' => 146
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ropa artesanal',
            'uma'         => 4,
            'land_use_id' => 146
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ropa Infantil',
            'uma'         => 4,
            'land_use_id' => 146
        ]);
        LandUseDescription::create([
            'descripcion' => 'Ropa y accesorios',
            'uma'         => 4,
            'land_use_id' => 146
        ]);

        //TIENDAS SUPER MERCADO
        LandUseDescription::create([
            'descripcion' => 'Tiendas departamentales de Autoservicio',
            'uma'         => 15,
            'land_use_id' => 147
        ]);

        //TIENDAS DE AUTO SERVICIO
        LandUseDescription::create([
            'descripcion' => 'Autoservicio',
            'uma'         => 14,
            'land_use_id' => 148
        ]);
        LandUseDescription::create([
            'descripcion' => 'Minisúper',
            'uma'         => 4,
            'land_use_id' => 148
        ]);
        LandUseDescription::create([
            'descripcion' => 'Miscelánea',
            'uma'         => 4,
            'land_use_id' => 148
        ]);

        //TORTILLERÍA
        LandUseDescription::create([
            'descripcion' => 'Tortillerías a base de maíz o harina',
            'uma'         => 4,
            'land_use_id' => 149
        ]);

        //TORTILLERIA MENOR
        LandUseDescription::create([
            'descripcion' => 'Elaboración de tortilla de harina',
            'uma'         => 4.4,
            'land_use_id' => 150
        ]);
        LandUseDescription::create([
            'descripcion' => 'Elaboración de tostadas',
            'uma'         => 4.4,
            'land_use_id' => 150
        ]);
        LandUseDescription::create([
            'descripcion' => 'Expendio de tortillas',
            'uma'         => 4.4,
            'land_use_id' => 150
        ]);

        //TRATAMIENTOS DE BELLEZA
        LandUseDescription::create([
            'descripcion' => 'SPA',
            'uma'         => 8,
            'land_use_id' => 151
        ]);

        //LAMPARAS Y CANDILES
        LandUseDescription::create([
            'descripcion' => 'Candiles y lámparas-Lámparas y material de cerámica',
            'uma'         => 5,
            'land_use_id' => 152
        ]);

        //RESTAURANTE
        LandUseDescription::create([
            'descripcion' => 'Restaurante',
            'uma'         => 5.25,
            'land_use_id' => 153
        ]);
        LandUseDescription::create([
            'descripcion' => 'Cafetería',
            'uma'         => 5,
            'land_use_id' => 153
        ]);

        //RESTAURANTE BAR
        LandUseDescription::create([
            'descripcion' => 'Restaurante con venta de Alcohol Mayor de 10°',
            'uma'         => 10,
            'land_use_id' => 154
        ]);

        //SASTRERÍA
        LandUseDescription::create([
            'descripcion' => 'Sastrería-Taller de costura',
            'uma'         => 4,
            'land_use_id' => 155
        ]);

        //SERVICIO DE BANQUETES, EVENTOS  Y RENTA DE MOBILIARIO
        LandUseDescription::create([
            'descripcion' => 'Agencia de eventos y banquetes-Alquiler de vajillas y mobiliario-Renta de mobiliario-Servicio de banquetes-Servicios y organización p/eventos',
            'uma'         => 5,
            'land_use_id' => 156
        ]);

        //SERVICIO DE INSTALACIONES ELÉCTRICAS
        LandUseDescription::create([
            'descripcion' => 'Aparatos eléctricos-Materiales eléctricos-Servicios e instalaciones eléctricas',
            'uma'         => 5,
            'land_use_id' => 157
        ]);

        //SERVICIO DE TELECOMUNICACIONES
        LandUseDescription::create([
            'descripcion' => 'Radiocomunicaciones y Telecomunicaciones',
            'uma'         => 9,
            'land_use_id' => 158
        ]);

        //TALLER DE BICICLETAS
        LandUseDescription::create([
            'descripcion' => 'Taller de bicicletas',
            'uma'         => 4,
            'land_use_id' => 159
        ]);

        //TALLER DE AEROGRAFÍA
        LandUseDescription::create([
            'descripcion' => 'Gravados metálicos y Taller de aerografía',
            'uma'         => 4,
            'land_use_id' => 160
        ]);

        //TALLER DE HERRERÍA
        LandUseDescription::create([
            'descripcion' => 'Taller de Herrería',
            'uma'         => 5,
            'land_use_id' => 161
        ]);

        //TALLER  MECÁNICO (EN GENERAL)
        LandUseDescription::create([
            'descripcion' => 'Taller Mecánico en General- Hojalatería y pintura-Enderezado- Suspensiones-Torno-Eléctrico',
            'uma'         => 5,
            'land_use_id' => 162
        ]);

        //TALLERES DE SERVICIO  Y MANTENIMIENTO DE MÁQUINAS
        LandUseDescription::create([
            'descripcion' => 'Reparación de máquinas de escribir-de máquinas de Coser-De aparatos domésticos en general.',
            'uma'         => 4,
            'land_use_id' => 163
        ]);

        //TAPICERÍA
        LandUseDescription::create([
            'descripcion' => 'Material para tapicería-Tapicerías en general.-Tapices, hules, etc.-Telas para tapicería',
            'uma'         => 4,
            'land_use_id' => 164
        ]);

        //TARIMAS
        LandUseDescription::create([
            'descripcion' => 'Fábrica de Tarimas-Renta de andamios-Fabrica y venta de Tarimas',
            'uma'         => 5,
            'land_use_id' => 165
        ]);

        //TELAS Y SIMILARES
        LandUseDescription::create([
            'descripcion' => 'Telas-Telas almacenes',
            'uma'         => 6.825,
            'land_use_id' => 166
        ]);

        //TIENDA DE REGALOS Y/O NOVEDADES
        LandUseDescription::create([
            'descripcion' => 'Bisutería y Novedades-Fantasía-Regalos',
            'uma'         => 5,
            'land_use_id' => 167
        ]);

        //TIENDA NATURISTA
        LandUseDescription::create([
            'descripcion' => 'Naturista comercio en grande-Naturista comercio en grande',
            'uma'         => 5,
            'land_use_id' => 168
        ]);

        //TINTORERÍA Y/O PLANCHADO
        LandUseDescription::create([
            'descripcion' => 'Lavandería-Recepción y entrega de ropa de tintorería-Servicio de Planchado-Tintorería y lavandería',
            'uma'         => 6,
            'land_use_id' => 169
        ]);

        //VENTA DE UNIFORMES
        LandUseDescription::create([
            'descripcion' => 'Uniformes Para Enfermería-para seguridad-Uniformes Escolares- Uniformes en General',
            'uma'         => 5,
            'land_use_id' => 170
        ]);

        //VENTA  E INSTALACIÓN DE EQUIPOS EN GENERAL
        LandUseDescription::create([
            'descripcion' => 'Venta de maquinaria pesada-Venta de Sistemas de riego-Instalación De Aire Acondicionado-Compra venta de equipo y refacciones para tortillería-Equipo de Jardinería',
            'uma'         => 6.5,
            'land_use_id' => 171
        ]);

        //VENTA DE AGUA EMBOTELLADA
        LandUseDescription::create([
            'descripcion' => 'Aguas purificadas-Distribuidor Agua Purificada Mayoreo-Filtros y purificadores y accesorios',
            'uma'         => 5,
            'land_use_id' => 172
        ]);

        //VENTA DE ALFOMBRAS Y/O PERSIANAS
        LandUseDescription::create([
            'descripcion' => 'Alfombras-Venta de persianas',
            'uma'         => 5,
            'land_use_id' => 173
        ]);

        //ARTÍCULOS DE PIEL
        LandUseDescription::create([
            'descripcion' => 'Alfombras-Venta de persianas',
            'uma'         => 5.25,
            'land_use_id' => 174
        ]);

        //VENTA DE BOTANAS Y/O FRITURAS
        LandUseDescription::create([
            'descripcion' => 'Botanas-Elotes Preparados-Elaboración de tostadas-Frituras mixtas-Venta de papas',
            'uma'         => 5,
            'land_use_id' => 175
        ]);
        LandUseDescription::create([
            'descripcion' => 'Botanas Almacén',
            'uma'         => 7,
            'land_use_id' => 175
        ]);

        //VENTA  DE BICICLETAS
        LandUseDescription::create([
            'descripcion' => 'Bicicletas',
            'uma'         => 5,
            'land_use_id' => 176
        ]);

        //VENTA Y TALLER DE MANUALIDADES
        LandUseDescription::create([
            'descripcion' => 'Manualidades-Taller de manualidades',
            'uma'         => 5,
            'land_use_id' => 177
        ]);

        //VENTA Y/O ELABORACIÓN DE CARBÓN
        LandUseDescription::create([
            'descripcion' => 'Expendio -Venta de carbón',
            'uma'         => 4,
            'land_use_id' => 178
        ]);

        //VENTA DE BOLETOS
        LandUseDescription::create([
            'descripcion' => 'Venta de boletos varios',
            'uma'         => 6,
            'land_use_id' => 179
        ]);
        LandUseDescription::create([
            'descripcion' => 'Venta de boletos autotransporte',
            'uma'         => 6,
            'land_use_id' => 179
        ]);

        //VINATERÍAS
        LandUseDescription::create([
            'descripcion' => 'Vinos y licores',
            'uma'         => 11,
            'land_use_id' => 180
        ]);

        //VERDURAS, FRUTA
        LandUseDescription::create([
            'descripcion' => 'Frutas deshidratadas-Frutas, legumbres y verduras',
            'uma'         => 4,
            'land_use_id' => 181
        ]);

        //VETERINARIAS
        LandUseDescription::create([
            'descripcion' => 'Veterinarias-Esc. Adiestramiento Canino',
            'uma'         => 5,
            'land_use_id' => 182
        ]);

        //VIVIENDA
        LandUseDescription::create([
            'descripcion' => 'Construcción y rehabilitación de vivienda unifamiliar o plurifamiliar, Subdivisión, Desmembración, Régimen de Propiedad en Condominio.',
            'uma'         => 4,
            'land_use_id' => 183
        ]);

        //VULCANIZADORA
        LandUseDescription::create([
            'descripcion' => 'Taller de llantas-Vulcanizadora-llantera',
            'uma'         => 4,
            'land_use_id' => 184
        ]);

        //ZAPATERIA
        LandUseDescription::create([
            'descripcion' => 'Distribución de Calzado y Accesorios-Zapatería y accesorios',
            'uma'         => 6,
            'land_use_id' => 185
        ]);

        //FRACCIONAMIENTOS
        LandUseDescription::create([
            'descripcion' => 'Fraccionamientos en general.',
            'uma'         => 15,
            'land_use_id' => 186
        ]);

        //ANTENAS Y ANUNCIOS ESPECTACULARES
        LandUseDescription::create([
            'descripcion' => 'Antenas de telefonía, telecomunicaciones y anuncios espectaculares.',
            'uma'         => 15,
            'land_use_id' => 187
        ]);

        //ACTIVIDADES EXTRACTIVAS
        LandUseDescription::create([
            'descripcion' => 'Extracción minera, bancos de material, etc.',
            'uma'         => 15,
            'land_use_id' => 188
        ]);

        //ELABORACIÓN DE MATERIALES DE CONSTRUCCIÓN
        LandUseDescription::create([
            'descripcion' => 'Planta de concreto, bloquera, ladrillera, etc.',
            'uma'         => 15,
            'land_use_id' => 189
        ]);

        //ACOPIO DE RESIDUOS PELIGROSOS
        LandUseDescription::create([
            'descripcion' => 'Centro de acopio de residuos peligrosos, almacén de residuos peligrosos',
            'uma'         => 15,
            'land_use_id' => 190
        ]);

        //ACOPIO DE RESIDUOS PELIGROSOS
        LandUseDescription::create([
            'descripcion' => 'Centro de acopio de residuos peligrosos, almacén de residuos peligrosos',
            'uma'         => 15,
            'land_use_id' => 190
        ]);

        //FONDA-CENADURÍA-COCINA ECONÓMICA (CON CERVEZA)
        LandUseDescription::create([
            'descripcion' => 'Cenadurías y fondas (con cerveza)',
            'uma'         => 5.88,
            'land_use_id' => 191
        ]);

        //RESTAURANTE (CON CERVEZA)
        LandUseDescription::create([
            'descripcion' => 'Restaurante (con cerveza)',
            'uma'         => 6.51,
            'land_use_id' => 192
        ]);

        //TIENDA DE CONVENIENCIA (OXXO, EXTRA))
        LandUseDescription::create([
            'descripcion' => 'Minisúper, miscelánea',
            'uma'         => 5.26,
            'land_use_id' => 193
        ]);

        //ACTIVIDAD COMERCIAL/SERVIOCIO QUE VENDA CERVEZA
        LandUseDescription::create([
            'descripcion' => 'Las actividades comerciales o de servicios que además de su giro principal, venda cerveza tendrán un importe extra.',
            'uma'         => 1.26,
            'land_use_id' => 194
        ]);

        //ACTIVIDAD COMERCIAL/SERVIOCIOS NO LISTADOS
        LandUseDescription::create([
            'descripcion' => 'Las actividades comerciales, de servicios o trámites no comprendidos en la tabla. ',
            'uma'         => 5,
            'land_use_id' => 195
        ]);
    }
}
