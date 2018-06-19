<?php

namespace OfferBundle\ETL\Transformer;

use Doctrine\DBAL\Driver\Connection;
use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class MyaudiUserPreTransformer
 * @package OfferBundle\ETL\Transformer
 */
class MyaudiUserPreTransformer implements TransformerInterface
{
    /**
     * @var string
     */
    const QUERY = 'SELECT id FROM myaudi_user WHERE legacy_id = :legacyId';

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

        $userIdColumn = $row->getColumn('contact_id');
        $legacyId = $userIdColumn->getValue();
        $this->stmt->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmt->execute()) {
            $error = $this->stmt->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }
        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result['id']) {
            $userIdColumn->setValue($result['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No myaudi user matching with legacyId %d', $legacyId));
        }

        return $row;
    }
}