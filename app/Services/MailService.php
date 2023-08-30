<?php

namespace App\Services;

use Illuminate\Support\Facades\Mail;

class MailService
{
    /**
     * Send email to currently registered user
     * @param String $name
     * @param String $email
     * @param array $data
     * @return void
     */
    public function registerMail($name, $email, $data)
    {
        Mail::send('emails/registro', $data, function ($message) use ($email, $name) {
            $message->to($email, $name)
                ->subject('Bienvenido a Permisos Desarrollo Urbano');
        });
    }

    /**
     * Send email when an user request a new password
     * @param string $name
     * @param string $email
     * @param string $username
     * @param string $newPassword
     * @return void
     */
    public function restorePassword(string $name, string $email, string $username, string $newPassword)
    {
        $data = array('name' => $name, "user" => $username, "contrasenia" => $newPassword);

        Mail::send('emails/renovar_password', $data, function ($message) use ($name, $email) {
            $message->to($email, $name)
                ->subject('Recuperación de contraseña');
        });
    }

    // /**
    //  * Send email when an user generate a ticket
    //  * @param string $user
    //  * @param string $email
    //  * @param string $problem
    //  * @param string $details
    //  */
    // public function generatedTicket(string $user, string $email, string $problem, string $details)
    // {
    //     $to_name = 'Soporte Bitácora Digital';
    //     $to_email = 'bitacoradigital.mx@gmail.com';
    //     $data = array('user' => $user, "email" => $email, "problem" => $problem, "details" => $details);

    //     Mail::send('emails/ticket_generado', $data, function ($message) use ($to_name, $to_email) {
    //         $message->to($to_email, $to_name)
    //             ->subject('Nuevo ticket generado');
    //     });
    // }

    /**
    //  * Send email when an user generate a ticket
    //  * @param string $user
    //  * @param string $email
    //  * @param string $problem
    //  * @param string $details
    //  */
    // public function ticketMessageSent(string $user, string $email, string $problem, string $details)
    // {
    //     $to_name = 'Soporte Bitácora Digital';
    //     $to_email = 'bitacoradigital.mx@gmail.com';
    //     $data = array('user' => $user, "email" => $email, "problem" => $problem, "details" => $details);

    //     Mail::send('emails/nuevo_mensaje_ticket', $data, function ($message) use ($to_name, $to_email) {
    //         $message->to($to_email, $to_name)
    //             ->subject('Nuevo mensaje en un ticket');
    //     });
    // }
}
