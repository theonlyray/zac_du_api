<style>
    .store-link {
        margin: 10px 10px;
    }

    .store-link img {
        width: 128px;
    }
</style>

@component('mail::message')
# Estimado {{ $name }}

## Ha solicitado la recuperación de su contraseña.

Sus credenciales para el acceso, incluyendo la nueva contraseña son:

@component('mail::panel')
Usuario: **{{ $email }}**
<br>
Contraseña: **{{ $contrasenia }}**
@endcomponent

*Le envíamos un cordial saludo.*

@component('mail::subcopy')
@endcomponent

@endcomponent
