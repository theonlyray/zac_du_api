<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $superAdmin     = Role::create([
                'name' => 'super-admin',
                'description' => 'Super Admin'
            ]);
            $directorDpt    = Role::create([
                'name' => 'directorDpt',
                'description' => 'Director de Departamento'
            ]);
            $subDirectorDpt    = Role::create([
                'name' => 'subDirectorDpt',
                'description' => 'Subdirector de Departamento'
            ]);
            $jefeUnidadDpt    = Role::create([
                'name' => 'jefeUnidadDpt',
                'description' => 'Jefe de Unidad de Departamento'
            ]);
            $colaboradorDpt    = Role::create([
                'name' => 'colaboradorDpt',
                'description' => 'Colaborador de Departamento'
            ]);
            $directorCol        = Role::create([
                'name' => 'directorCol',
                'description' => 'Director de Colegio'
            ]);
            $subDirectorCol    = Role::create([
                'name' => 'subDirectorCol',
                'description' => 'Subdirector de Colegio'
            ]);
            $colaboradorCol    = Role::create([
                'name' => 'colaboradorCol',
                'description' => 'Colaborador de Colegio'
            ]);
            $dro            = Role::create([
                'name' => 'dro',
                'description' => 'DRO'
            ]);
            $particular     = Role::create([
                'name' => 'particular',
                'description' => 'Particular'
            ]);
            $jefeSDUMA     = Role::create([
                'name' => 'jefeSDUMA',
                'description' => 'JEFE DE SECRETARIA DE DESARROLLO URBANO Y MEDIO AMBIENTE'
            ]);

            $allRoles    = [ $jefeSDUMA, $directorDpt, $subDirectorDpt, $colaboradorDpt, $jefeUnidadDpt, $directorCol, $subDirectorCol, $colaboradorCol, $dro, $particular ];
            $allMpi      = [ $jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $colaboradorDpt ];
            $allCol      = [ $directorCol, $subDirectorCol, $colaboradorCol ];
            $rolesMpiApp = [ $jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $colaboradorDpt, $dro, $particular ];
            $rolesColApp = [ $directorCol, $subDirectorCol, $colaboradorCol, $dro, $particular ];
            $applicants  = [ $dro, $particular ];

            /**
             * departments
             */
            Permission::create([
                    'name' => 'role.index',
                    'description' => 'Listar Roles'
                ])->assignRole($jefeSDUMA, $directorDpt, $subDirectorDpt, $directorCol, $subDirectorCol,);
            Permission::create([
                    'name' => 'role.update',
                    'description' => 'Actualizar Permisos de un Rol'
                ])->assignRole($jefeSDUMA, $directorDpt, $subDirectorDpt, $directorCol, $subDirectorCol,);
            Permission::create([
                    'name' => 'permission.index',
                    'description' => 'Listar Permisos'
                ])->assignRole($jefeSDUMA, $directorDpt, $subDirectorDpt, $directorCol, $subDirectorCol,);


            /**
             * Properties
             */
            Permission::create([
                'name' => 'activities.index',
                'description' => 'Listar registro de actividades'
            ])->assignRole($jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt);
            /**
             * departments
             */
            Permission::create([
                    'name' => 'department.index',
                    'description' => 'Listar Departamentos'
                ])->assignRole($applicants);
            Permission::create([
                    'name' => 'department.show',
                    'description' => 'Ver detalles de Departamentos'
                ])->assignRole($rolesMpiApp);
            Permission::create([
                    'name' => 'department.store',
                    'description' => 'Crear Departamentos'
                ]);//?only to super-admin
            Permission::create([
                    'name' => 'department.update',
                    'description' => 'Editar Departamentos'
                ])->assignRole([$jefeSDUMA, $directorDpt]);
            Permission::create([
                    'name' => 'department.destroy',
                    'description' => 'Eliminar Departamentos'
                ]);//?only to super-admin

            /**
             * files
             */
            Permission::create([
                    'name' => 'file.index',
                    'description' => 'Listar Archivos'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'file.show',
                    'description' => 'Ver detalles de un Archivos'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'file.store',
                    'description' => 'Cargar Archivos'
                ])->assignRole([
                    $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $colaboradorDpt,
                    $directorCol, $subDirectorCol, $colaboradorCol
                ]);
            Permission::create([
                    'name' => 'file.update',
                    'description' => 'Editar Archivos'
                ])->assignRole([
                    $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $colaboradorDpt,
                    $directorCol, $subDirectorCol, $colaboradorCol
                ]);
            Permission::create([
                    'name' => 'file.destroy',
                    'description' => 'Eliminar Archivos'
                ])->assignRole([
                    $directorDpt, $subDirectorDpt, $jefeUnidadDpt,
                    $directorCol, $subDirectorCol,
                ]);

            /**
             * Colleges
             */
            Permission::create([
                    'name' => 'college.index',
                    'description' => 'Listar Colegios'
                ])->assignRole($applicants);
            Permission::create([
                    'name' => 'college.show',
                    'description' => 'Ver detalles de Colegios'
                ])->assignRole($rolesColApp);
            Permission::create([
                    'name' => 'college.store',
                    'description' => 'Crear Colegios'
                ]);//?only to super-admin
            Permission::create([
                    'name' => 'college.update',
                    'description' => 'Editar Colegios'
                ])->assignRole([$directorCol, $subDirectorCol]);
            Permission::create([
                    'name' => 'college.destroy',
                    'description' => 'Eliminar Colegios'
                ]);//?only to super-admin

            /**
             * units
             */
            Permission::create([
                    'name' => 'unit.index',
                    'description' => 'Listar Unidades'
                ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'unit.show',
                    'description' => 'Ver detalles de una Unidad'
                ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'unit.store',
                    'description' => 'Crear Unidad'
                ])->assignRole([$directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'unit.update',
                    'description' => 'Editar Unidad'
                ])->assignRole([$directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'unit.destroy',
                    'description' => 'Eliminar Unidad'
                ])->assignRole([$directorDpt, $subDirectorDpt]);

            /**
             * Users
             */
            Permission::create([
                    'name' => 'user.index',
                    'description' => 'Listar Usuarios'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'user.show',
                    'description' => 'Ver detalles de un Usuario'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'user.store',
                    'description' => 'Crear Usuarios (Colaboradores)'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $directorCol, $subDirectorCol]);
            Permission::create([
                    'name' => 'user.update',
                    'description' => 'Editar Usuarios'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt, $directorCol, $subDirectorCol]);
            Permission::create([
                    'name' => 'user.destroy',
                    'description' => 'Eliminar Usuarios'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'user.permissions',
                    'description' => 'Administrar Permisos de Usuarios'
                ])->assignRole([$jefeSDUMA, $directorDpt, $directorCol]);

            /**
             * License Types
             */
            Permission::create([
                    'name' => 'licenseType.index',
                    'description' => 'Listar Tipos de Licencias'
                ])->assignRole($rolesMpiApp);
            Permission::create([
                    'name' => 'licenseType.show',
                    'description' => 'Ver detalles de un Tipos de Licencias'
                ])->assignRole($rolesMpiApp);
            Permission::create([
                    'name' => 'licenseType.store',
                    'description' => 'Crear Tipos de Licencias'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt,]);
            Permission::create([
                    'name' => 'licenseType.update',
                    'description' => 'Editar Tipos de Licencias'
                ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'licenseType.destroy',
                    'description' => 'Eliminar Tipos de Licencias'
                ])->assignRole([$jefeSDUMA, $directorDpt]);

            /**
             * Requirements
             */
            Permission::create([
                    'name' => 'requirement.index',
                    'description' => 'Listar Requisitos'
                ])->assignRole($jefeSDUMA, $rolesMpiApp);
            Permission::create([
                    'name' => 'requirement.show',
                    'description' => 'Ver detalles de un Requisito'
                ])->assignRole($jefeSDUMA, $rolesMpiApp);
            Permission::create([
                    'name' => 'requirement.store',
                    'description' => 'Crear Requisitos'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt]);
            Permission::create([
                    'name' => 'requirement.update',
                    'description' => 'Editar Requisitos'
                ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'requirement.destroy',
                    'description' => 'Eliminar Requisitos'
                ])->assignRole([$jefeSDUMA, $directorDpt]);

            /**
             * Properties
             */
            Permission::create([
                    'name' => 'property.index',
                    'description' => 'Listar Predios'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'property.show',
                    'description' => 'Ver detalles de una Predios'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'property.store',
                    'description' => 'Crear Predios'
                ])->assignRole($applicants);
            Permission::create([
                    'name' => 'property.update',
                    'description' => 'Editar Predios'
                ])->assignRole($rolesMpiApp);
            Permission::create([
                    'name' => 'property.delete',
                    'description' => 'Eliminar Predios'
                ])->assignRole($rolesMpiApp);

                /**
             * Licenses
             */
            Permission::create([
                    'name' => 'license.index',
                    'description' => 'Listar Licencias / Solicitudes'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'license.show',
                    'description' => 'Ver detalles de una Licencia / Solicitudes'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'license.store',
                    'description' => 'Crear Solicitud'
                ])->assignRole($applicants);
            Permission::create([
                    'name' => 'license.update',
                    'description' => 'Editar Solicitud'
                ])->assignRole($rolesMpiApp);
            Permission::create([
                    'name' => 'license.requirements',
                    'description' => 'Revisar y Editar Requisitos de una Solicitud'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'license.pdf',
                    'description' => 'Consultar PDF de una Solicitud'
                ])->assignRole($allRoles);
            Permission::create([
                    'name' => 'license.validateEntry',
                    'description' => 'Validar un Ingreso de una Solicitud'
                ])->assignRole([$allMpi]);
            Permission::create([
                    'name' => 'license.validateDocsPlans',
                    'description' => 'Validar Planos y Documentos'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt]);
            Permission::create([
                    'name' => 'license.observations',
                    'description' => 'Generar un Observacion para Solicitud'
                ])->assignRole([$jefeSDUMA, $rolesMpiApp]);
            Permission::create([
                    'name' => 'license.sign',
                    'description' => 'Firmar una Solicitud'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'license.authorize',
                    'description' => 'Autorizar una Licencia'
                ])->assignRole([$jefeSDUMA, $directorDpt]);
            Permission::create([
                    'name' => 'license.rejection',
                    'description' => 'Rechazar Solicitud'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt]);
            Permission::create([
                    'name' => 'license.completionApproval',
                    'description' => 'Visto bueno de una Terminación de Obra'
                ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt, $jefeUnidadDpt]);
            Permission::create([
                'name' => 'license.signCompletionApproval',
                'description' => 'Firmar una Terminación de Obra'
            ])->assignRole([$jefeSDUMA, $directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'license.authorizeCompletionApproval',
                    'description' => 'Autorizar una Terminación de Obra'
                ])->assignRole([$jefeSDUMA, $directorDpt]);

            /**
             * Duties
             */
            Permission::create([
                'name' => 'duty.index',
                'description' => 'Listar Derechos'
            ])->assignRole($rolesMpiApp);
            Permission::create([
                'name' => 'duty.show',
                'description' => 'Ver detalles de un Derechos'
            ])->assignRole($rolesMpiApp);
            Permission::create([
                'name' => 'duty.store',
                'description' => 'Crear un Derechos'
            ])->assignRole($allMpi);

            Permission::create([
                'name' => 'duty.update',
                'description' => 'Editar un Derechos'
            ])->assignRole($allMpi);

            Permission::create([
                'name' => 'duty.destroy',
                'description' => 'Eliminar un Derechos'
            ])->assignRole([$directorDpt]);

            /**
             * Pay order
             */
            Permission::create([
                'name' => 'order.index',
                'description' => 'Listar Ordenes de pago'
            ])->assignRole($rolesMpiApp);
            Permission::create([
                'name' => 'order.show',
                'description' => 'Ver detalles de una Ordene de pago'
            ])->assignRole($rolesMpiApp);
            Permission::create([
                'name' => 'order.store',
                'description' => 'Crear una Ordene de pago'
            ])->assignRole([$jefeSDUMA, $directorDpt]);

            Permission::create([
                'name' => 'order.update',
                'description' => 'Editar una Ordene de pago (Validar, actualizar ref. de pago)'
            ])->assignRole($rolesMpiApp);

            Permission::create([
                'name' => 'order.validate',
                'description' => 'Validar una Ordene de pago (actualizar ref. de pago)'
            ])->assignRole($jefeSDUMA);

            Permission::create([
                'name' => 'order.destroy',
                'description' => 'Eliminar una Ordene de pago'
            ])->assignRole([$jefeSDUMA, $directorDpt]);

            /**
             * land uses
             */
            Permission::create([
                'name' => 'landUse.index',
                'description' => 'Listar Usos de Suelo'
            ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'landUse.show',
                    'description' => 'Ver detalles de un Uso de Suelo'
                ])->assignRole($allMpi);
            Permission::create([
                    'name' => 'landUse.store',
                    'description' => 'Crear Uso de Suelo'
                ])->assignRole([$directorDpt, $subDirectorDpt]);
            Permission::create([
                    'name' => 'landUse.update',
                    'description' => 'Editar Uso de Suelo'
                ])->assignRole([$directorDpt, $subDirectorDpt]);
        }
    }
}
