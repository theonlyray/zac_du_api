<?php

namespace App\Services;

class CheckLicenseType
{
    /**
     *  check if license is a construction
     * @param Int  $license
     * @return boolean
     */
    public function isConstruction(Int $license_type_id)
    {
        //? numbers in db, id license type
        return $license_type_id >= 1 && $license_type_id <= 6 ||
        ($license_type_id >= 8 && $license_type_id <= 11) ||
        ($license_type_id == 15) ||
        ($license_type_id >= 25 && $license_type_id <= 28);
    }

    /**
     * check if license is an ad
     * * @param License  $license
     * @return boolean
     */
    public function isAd(Int $license_type_id)
    {
        return $license_type_id >= 17 && $license_type_id <= 20;
    }

    public function checkLicenseType(Int $license_type_id)
    {
        if ($license_type_id >= 1 && $license_type_id <= 6 ||
        ($license_type_id >= 8 && $license_type_id <= 11) ||
        ($license_type_id == 15) ||
        ($license_type_id >= 25 && $license_type_id <= 28)) {
            return 'construction';
        }elseif($license_type_id == 7){
            return 'oficial_number';
        }elseif($license_type_id == 12){
            return 'urban_services';
        }elseif ($license_type_id == 13) {
            return 'self-build';
        }elseif ($license_type_id == 14) {
            return 'safety';
        }elseif ($license_type_id == 16) {
            return 'compatibility';
        }elseif($license_type_id >= 17 && $license_type_id <= 19) {
            return 'ad';
        }elseif ($license_type_id == 20) {
            return 'vehicle_ad';
        }elseif ($license_type_id == 21) {
            return 'safety_antennas';
        }elseif ($license_type_id == 22) {
            return 'sfd';
        }elseif ($license_type_id == 23) {
            return 'completion';
        }elseif ($license_type_id == 24) {
            return 'break_pavement';
        }
    }
}
