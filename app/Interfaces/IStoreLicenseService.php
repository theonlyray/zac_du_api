<?php

namespace App\Interfaces;

use App\Models\License;
use App\Models\User;
use Illuminate\Http\Request;


interface IStoreLicenseService
{
    /**
     * save property information
     * @param Request $request
     * @param License $license
     * @return Property
     */
    public function saveProperty(Request $request, License $license);

    /**
     * save backgrounds information
     * @param Request $request
     * @param License $license
     * @return Background
     */
    public function saveBackgrounds(Request $request, License $license);

    /**
     * save construction description information
     * @param Request $request
     * @param License $license
     * @return ConstructionDescription
     */
    public function saveConstructionDescriptions(Request $request, License $license);

    /**
     * save Construction Owner information
     * @param Request $request
     * @param License $license
     * @param User $user
     * @return ConstructionOwner
     */
    public function saveConstructionOwner(Request $request, License $license, User $user);

    /**
     * save safety information
     * @param Request $request
     * @param License $license
     * @return Safety
     */
    public function saveSafety(Request $request, License $license);


    /**
     * save conpatibility information
     * @param Request $request
     * @param License $license
     * @return CompatibilityCertificate
     */
    public function saveCompatibilityCertificate(Request $request, License $license);

    /**
     * save SFD information
     * @param Request $request
     * @param License $license
     * @return SFD
     */
    public function saveSFD(Request $request, License $license);

    /**
     * update self build information
     * @param Request $request
     * @param License $license
     * @return SFD
     */
    public function updateSFD(Request $request, License $license);


    /**
     * save validity information
     * @param Request $request
     * @param License $license
     * @return LicenseValidity
     */
    public function saveValidity(Request $request, License $license);

    /**
     * save ad description information
     * @param Request $request
     * @param License $license
     * @return AdDescription
     */
    public function saveAdDescription(Request $request, License $license);

    /**
     * save requirement information
     * @param Request $request
     * @param License $license
     * @return Requirement
     */
    public function saveRequirements(Request $request, License $license);

    /**
     * update backgroudns information
     * @param Request $request
     * @param License $license
     * @return ConstructionBackground
     */
    public function updateBackgrounds(Request $request, License $license);
}
