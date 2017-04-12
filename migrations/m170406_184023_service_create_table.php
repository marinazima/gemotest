<?php

use yii\db\Migration;

class m170406_184023_service_create_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('service', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),            
            'name' => $this->string(500)->notNull(),
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('service');
    }
}
