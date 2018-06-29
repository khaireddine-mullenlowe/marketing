<?php

namespace MarketingBundle\ETL\Transformer;

use Doctrine\DBAL\Driver\Connection;
use Mullenlowe\EtlBundle\Exception\TransformerException;
use Mullenlowe\EtlBundle\Row;
use Mullenlowe\EtlBundle\Transformer\TransformerInterface;

/**
 * Class ScoreUserPreTransformer
 * @package MarketingBundle\ETL\Transformer
 */
class ScoreUserPreTransformer implements TransformerInterface
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
     * @var array
     */
    private static $cache = [];

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

        $userIdColumn = $row->getColumn('myaudi_user_id');
        $legacyId = $userIdColumn->getValue();

        if (isset(self::$cache[$legacyId])) {
            $userIdColumn->setValue(self::$cache[$legacyId]);

            return $row;
        }

        $this->stmt->bindParam(':legacyId', $legacyId, \PDO::PARAM_INT);

        if (!$this->stmt->execute()) {
            $error = $this->stmt->errorInfo();
            throw new TransformerException(sprintf('SQL query failed : %s', $error[2]));
        }
        $result = $this->stmt->fetch(\PDO::FETCH_ASSOC);

        if ($result['id']) {
            self::$cache[$legacyId] = $result['id'];
            $userIdColumn->setValue($result['id']);
        } else {
            $row->setSkipFlag(true)
                ->setSkipComment(sprintf('No myaudi user matching with legacyId %d', $legacyId));
        }

        return $row;
    }
}
