<?php declare(strict_types=1);

namespace App\Db\Migrations;

use Doctrine\DBAL\Migrations\Version;
use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Type;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181227200146 extends AbstractMigration
{
    /**
     * Version20181227195456 constructor.
     * @param Version $version
     * @throws \Doctrine\DBAL\DBALException
     */
    public function __construct(Version $version)
    {
        parent::__construct($version);
        $this->platform->registerDoctrineTypeMapping('enum', 'string');
        $this->platform->registerDoctrineTypeMapping('bit', 'boolean');
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $table = $schema->createTable('cars');
        $table
            ->addColumn('id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setAutoincrement(true)
            ->setComment('ID');
        $table
            ->addColumn('make', Type::STRING)
            ->setLength(128)
            ->setNotnull(true)
            ->setComment('Марка');
        $table
            ->addColumn('model', Type::STRING)
            ->setLength(128)
            ->setNotnull(true)
            ->setComment('Модель');
        $table
            ->addColumn('componentry', Type::TEXT)
            ->setNotnull(true)
            ->setLength(512)
            ->setComment('Комплектация');
        $table
            ->addColumn('price', Type::INTEGER)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setComment('Цена');
        $table
            ->addColumn('vin', Type::STRING)
            ->setLength(17)
            ->setNotnull(true)
            ->setComment('VIN-номер');

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['vin'], 'UIDX_cars_vin');
        $table->addIndex(['make', 'model', 'componentry'], 'IDX_cars_mmc', [], ['lengths' => [128, 128, 512]]);

        $table = $schema->createTable('cars_at_dealers');
        $table
            ->addColumn('id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setAutoincrement(true)
            ->setComment('ID');
        $table
            ->addColumn('car_id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setComment('ID автомобиля');
        $table
            ->addColumn('dealer_id', Type::INTEGER)
            ->setLength(11)
            ->setUnsigned(true)
            ->setNotnull(true)
            ->setComment('ID дилерского центра');

        $table->setPrimaryKey(['id']);
        $table->addIndex(['car_id'], 'IDX_c_at_d_car_id');
        $table->addIndex(['dealer_id'], 'IDX_c_at_d_dealer_id');
        $table->addUniqueIndex(['dealer_id', 'car_id'], 'UIDX_c_at_d_cd');

        $table->addForeignKeyConstraint('cars', ['car_id'], ['id'], [
            'onUpdate' => 'cascade',
            'onDelete' => 'cascade'
        ], 'FK_c_at_d_car_id');
        $table->addForeignKeyConstraint('dealers', ['dealer_id'], ['id'], [
            'onUpdate' => 'cascade',
            'onDelete' => 'cascade'
        ], 'FK_c_at_d_dealer_id');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema): void
    {
        $schema->dropTable('cars_at_dealers');
        $schema->dropTable('cars');
    }
}
