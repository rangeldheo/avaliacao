<?php

namespace App\Repository;

use App\Abstracts\RespositoryAbstract;
use App\Enums\Status;
use App\Models\Affiliation;

class AffiliationRepository extends RespositoryAbstract
{
    const DIFFERENT = '<>';

    /**
     * Decisão da empresa sobre a afiliação do profissional
     * Campo dentro da $request->('approval_affiliation')
     * @param boolean
     */
    const APPROVAL_AFFILIATION = 'approval_affiliation';

    /**
     * Verifica se já existe solicitação de filiacao
     * para essa empresa
     *
     * @param string $professional_id
     * @param string $company_id
     * @return boolean
     */
    public static function isDuplicate(
        string $professional_id,
        string $company_id
    ): bool {
        $affiliation = new Affiliation();
        $haveDuplicates = $affiliation->where([
            ['professional_id', $professional_id],
            ['company_id', $company_id],
            ['status', self::DIFFERENT, Status::CANCELED],
        ])->count();

        return $haveDuplicates ? true : false;
    }

    /**
     * Verifica se existe vinculo com qualquer outra
     * empresa
     * @param string $professional_id
     * @return boolean
     */
    public static function isAffiliated(
        string $professional_id
    ): bool {
        $affiliation = new Affiliation();
        $haveAffiliation = $affiliation->where([
            ['professional_id', $professional_id],
            ['status', Status::ACTIVE]
        ])->count();

        return $haveAffiliation ? true : false;
    }

    /**
     * @param mixed $affiliation
     * @param mixed $request
     *
     * @return bool
     */
    public static function update($affiliation, $request): bool
    {
        $isAffiliationApproved = $request->get(self::APPROVAL_AFFILIATION);
        $affiliation->status = Status::ACTIVE;

        if (!$isAffiliationApproved) {
            $affiliation->status = Status::CANCELED;
        }

        return parent::update($affiliation, $request);
    }
}
