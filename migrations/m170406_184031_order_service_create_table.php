<?php

use yii\db\Migration;

class m170406_184031_order_service_create_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('order_service', [
            'id' => $this->primaryKey(),
            'order_id' => $this->integer()->notNull(),
            'service_id' => $this->integer()->notNull()
        ], $tableOptions);     
        
        $this->addForeignKey(
            'fk-order_service-order_id',
            'order_service',
            'order_id',
            'order',
            'id',
            'CASCADE'
        );        
    }
 
    public function down()
    {
        $this->dropForeignKey(
            'fk-order_service-order_id',
            'order_service'
        );
        
        $this->dropTable('order_service');
    }
}
