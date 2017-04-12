<?php

use yii\db\Migration;

class m170406_184119_discount_create_table extends Migration
{
    public function up()
    {
        $tableOptions = null;
 
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
 
        $this->createTable('discount', [
            'id' => $this->primaryKey(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),            
            'discount' => $this->decimal(10, 2)->notNull(),
            'birthdate_before' => $this->integer(),
            'birthdate_after' => $this->integer(),
            'phone_exists' => $this->integer(),
            'phone_tail' => $this->integer(),
            'gender' => $this->string(10),
            'date_start' => $this->integer(),
            'date_end' => $this->integer(),            
        ], $tableOptions);     
    }
 
    public function down()
    {
        $this->dropTable('discount');
    }
}
