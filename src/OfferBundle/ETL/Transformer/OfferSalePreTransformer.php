<?php

namespace OfferBundle\ETL\Transformer;

use Doctrine\DBAL\Driver\Connection;
use Doctrine\DBAL\Schema\Constraint;
use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class OfferAftersaleTermsPropertyPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferSalePreTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    const QUERY_MODEL = 'SELECT id FROM model WHERE legacy_id = :legacyId';
    /**
     * @var string
     */
    const QUERY_PARTNER = 'SELECT id FROM partner WHERE legacy_id = :legacyId';

    const RANGES = [
        'A1',
        'A3',
        'A4',
        'A5',
        'A6',
        'A7',
        'Q2',
        'Q3',
        'Q5',
        'Q7',
        'TT',
    ];

    /**
     * @var Connection
     */
    private $connPartner;

    /**
     * @var Connection
     */
    private $connVehicle;

    /**
     * @var \PDOStatement
     */
    private $stmtPartner = null;

    /**
     * @var \PDOStatement
     */
    private $stmtVehicle = null;

    /**
     * @param Connection $connPartner
     * @param Connection $connVehicle
     */
    public function setConnection(Connection $connPartner, Connection $connVehicle)
    {
        $this->connPartner = $connPartner;
        $this->connVehicle = $connVehicle;
    }

    /**
     * Transforms current data row by inner and/or custom mechanisms.
     *
     * @param Row $row
     *
     * @return Row
     */
    public function transform(Row $row): Row
    {
        //Partner
        if (is_null($this->stmtPartner)) {
            $this->stmtPartner = $this->connPartner->prepare(static::QUERY_PARTNER);
        }

        $partnerIdColumn = $row->getColumn('partner_id');
        $legacyId = $partnerIdColumn->getValue();
        $this->stmtPartner->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmtPartner->execute()) {
            $error = $this->stmtPartner->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }

        $partner = $this->stmtPartner->fetch(\PDO::FETCH_ASSOC);

        if ($partner['id']) {
            $partnerIdColumn->setValue($partner['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No partner matching with legacyId %d', $legacyId));
        }

        //Vehicle
        $this->stmtVehicle = $this->connVehicle->prepare(static::QUERY_MODEL);

        $vehicleIdColumn = $row->getColumn('model_id');
        $legacyId = $vehicleIdColumn->getValue();
        $this->stmtVehicle->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmtVehicle->execute()) {
            $error = $this->stmtVehicle->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }

        $model = $this->stmtVehicle->fetch(\PDO::FETCH_ASSOC);

        if ($model['id']) {
            $vehicleIdColumn->setValue($model['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No model matching with legacyId %d', $legacyId));
        }

        //Subtype
        $subtypeColumn = $row->getColumn('offer_subtype');
        $subtype = explode('-', $subtypeColumn->getValue());

        $pos = array_search($subtype[1], static::RANGES);

        $isSecondCarType = $subtype[0] === 'VO'; //VN or VO

        $subtypeColumn->setValue(17 + (11 * $isSecondCarType) + $pos);

        return $row;
    }
}
