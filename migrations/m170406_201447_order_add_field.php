<?php

use yii\db\Migration;

class m170406_201447_order_add_field extends Migration
{
    public function up()
    {
        $this->addColumn('order', 'discount', $this->decimal(10, 2)->defaultValue(0));
    }

    public function down()
    {
        $this->dropColumn('order', 'discount');
    }
}
