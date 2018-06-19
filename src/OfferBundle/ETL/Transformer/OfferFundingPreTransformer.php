<?php

namespace OfferBundle\ETL\Transformer;

use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;
use Doctrine\DBAL\Driver\Connection;
use Mullenlowe\EtlBundle\Row;

/**
 * Class OfferFundingPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class OfferFundingPreTransformer implements TransformerInterface
{
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
        $this->setRangeId($row);
        $this->setModelId($row);

        return $row;
    }

    /**
     * @param Row $row
     */
    private function setRangeId(Row $row)
    {
        $this->stmt = $this->conn->prepare('SELECT id FROM `range` WHERE legacy_id = :legacyId');

        $rangeIdColumn = $row->getColumn('range_id');
        $legacyId = $rangeIdColumn->getValue();
        $this->stmt->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmt->execute()) {
            $error = $this->stmt->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }
        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result['id']) {
            $rangeIdColumn->setValue($result['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No Range matching with legacyId %d', $legacyId));
        }
    }

    /**
     * @param Row $row
     */
    private function setModelId(Row $row)
    {
        $this->stmt = $this->conn->prepare('SELECT id FROM `model` WHERE legacy_id = :legacyId');

        $modelIdColumn = $row->getColumn('model_id');
        $legacyId = $modelIdColumn->getValue();
        $this->stmt->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmt->execute()) {
            $error = $this->stmt->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }
        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result['id']) {
            $modelIdColumn->setValue($result['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No Model matching with legacyId %d', $legacyId));
        }
    }
}
