<?php

namespace OfferBundle\ETL\Transformer;

use Doctrine\DBAL\Driver\Connection;
use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class OfferAftersaleTermsPropertyPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferAftersalePreTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    const QUERY = 'SELECT id FROM partner WHERE legacy_id = :legacyId';

    /**
     * @var Connection
     */
    private $conn;

    /**
     * @var \PDOStatement
     */
    private $stmt = null;

    /**
     * @param Connection $conn
     */
    public function setConnection(Connection $conn)
    {
        $this->conn = $conn;
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
        if (is_null($this->stmt)) {
            $this->stmt = $this->conn->prepare(static::QUERY);
        }

        $partnerIdColumn = $row->getColumn('partner_id');
        $legacyId = $partnerIdColumn->getValue();
        $this->stmt->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmt->execute()) {
            $error = $this->stmt->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }
        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result['id']) {
            $partnerIdColumn->setValue($result['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No partner matching with legacyId %d', $legacyId));
        }

        return $row;
    }
}
