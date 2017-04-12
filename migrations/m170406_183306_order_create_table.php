<?php

use yii\db\Migration;

class m170406_183306_order_create_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('order', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),            
            'customer' => $this->string(500)->notNull(),
            'birthdate' => $this->integer()->notNull(),
            'phone' => $this->string(12),
            'gender' => $this->string(10)->notNull(),
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('order');
    }
}
