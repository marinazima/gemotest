<?php

use yii\db\Migration;

class m170406_190411_discount_service_create_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('discount_service', [
            'id' => $this->primaryKey(),
            'discount_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull()
        ], $tableOptions);     
        
        $this->addForeignKey(
            'fk-discount_service-discount_id',
            'discount_service',
            'discount_id',
            'discount',
            'id',
            'CASCADE'
        );        
    }
 
    public function down()
    {
        $this->dropForeignKey(
            'fk-discount_service-discount_id',
            'discount_service'
        );
        
        $this->dropTable('discount_service');
    }
}
