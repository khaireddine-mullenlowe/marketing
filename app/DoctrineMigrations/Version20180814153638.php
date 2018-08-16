<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180814153638 extends AbstractMigration
{
    const UNIQ_INDEX_NAME = 'UNIQ_myaudi_user_marketing_objective';

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return 'Adds an identifier to table "myaudi_user_marketing_objective"';
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function up(Schema $schema)
    {
        $this->addSql('ALTER TABLE myaudi_user_marketing_objective DROP PRIMARY KEY;');
        $this->addSql('ALTER TABLE myaudi_user_marketing_objective ADD id INT AUTO_INCREMENT NOT NULL, ADD PRIMARY KEY (id);');

        $table = $schema->getTable('myaudi_user_marketing_objective');
        $table->addUniqueIndex(['myaudi_user_id', 'marketing_objective_id'], self::UNIQ_INDEX_NAME);
    }

    /**
     * @param Schema $schema
     *
     * @throws \Doctrine\DBAL\Schema\SchemaException
     */
    public function down(Schema $schema)
    {
        $table = $schema->getTable('myaudi_user_marketing_objective');

        $table->dropIndex(self::UNIQ_INDEX_NAME);

        $table->dropPrimaryKey();

        $table->dropColumn('id');

        $table->setPrimaryKey(['myaudi_user_id', 'marketing_objective_id']);
    }
}
