<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class InitialData extends AbstractMigration
{
    /**
     *  On migrate
     * @return void
     */
    public function up()
    {
        $sql = file_get_contents(__DIR__ . DS . 'initialData.sql');
        $this->query($sql);
    }

    /**
     * @return void
     */
    public function down()
    {
        $this->query('DROP TABLE IF EXISTS `countries`');
        $this->query('DROP TABLE IF EXISTS `languages`');
        $this->query('DROP TABLE IF EXISTS `continents`');
    }
}
