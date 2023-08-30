(function () {
    'use strict';

    function reqController($scope, $window, appService, appFactory) {
      const vm = this;
      vm.touch = false;

      vm.docType = false; //?filter byt req type
      // vm.docs = [];
      vm.init = async () => {
        const licId = $window.sessionStorage.getItem('__licId');

        const response  = await appService.axios('get', `licencias/${licId}`);

        if (response.status == 200) vm.license = response.data;
        else toastr.error(response.data.message);

        $scope.$digest();
      };

        vm.sendFile = async (file, req) => {
        if (vm.touch === false) {
          vm.touch = true;

          const validation = await appFactory.docValidation(file);
          console.log(validation);
          if (validation.status === true) {
            const licId = $window.sessionStorage.getItem('__licId');
            const payload = {
              archivo: file.base64,
              estatus: req.archivo_ubicacion == null ? 1 : 3, //?if the path exists it is the correction if not insertion
              nombre: file.filename,
              comentario: req.comentario,
            };

            const response = await appService.axios('patch',`licencias/${licId}/requisitos/${req.id}`, payload);

            if (response.status == 200){
               vm.license = response.data;
               toastr.success("Documento cargado con éxito");
            }else toastr.error(response.data.message);

            $scope.$digest();
          } else toastr.error(validation.msg);
          vm.touch = false
        } else {
          toastr.warning('El proceso a comenzado, espera un momento')
        }
      };

      vm.validation = async flag => {
        if (vm.touch === false) {
            vm.touch = true;
            const licId = $window.sessionStorage.getItem('__licId');

            vm.license.estatus = flag;

            const response = await appService.axios('patch',`licencias/${licId}/validaciones`, vm.license);
            if (response.status === 200) {
                toastr.success('Actualizado con exito');
                $scope.$digest();
              }else toastr.error(response.data.message);
              vm.init();
            vm.touch = false;
        } else toastr.warning('Proceso en ejecución, espera un momento');
      };

      vm.observations = async flag => {
        if (vm.touch === false) {
            vm.touch = true;
            const licId = $window.sessionStorage.getItem('__licId');

            vm.license.estatus = flag;

            const response = await appService.axios('patch',`licencias/${licId}/observaciones`, vm.license);
            if (response.status === 200) {
                toastr.success('Actualizado con exito');
                vm.license = response.data;
                $scope.$digest();
            }else toastr.error(response.data.message);
            vm.touch = false;
        } else toastr.warning('Proceso en ejecución, espera un momento');
      };
    }

    angular
      .module('app')
      .controller('reqController', reqController)
  })();
