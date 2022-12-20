<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220528_125418_orders
 */
class m220528_125418_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%orders}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'status_id'             => Schema::TYPE_INTEGER,
            'client_id'             => Schema::TYPE_INTEGER,
            'user_id'               => Schema::TYPE_INTEGER,
            'cost'                  => Schema::TYPE_INTEGER,
            'discount'              => Schema::TYPE_INTEGER,
            'term'                  => Schema::TYPE_INTEGER,

            'is_active'             => Schema::TYPE_SMALLINT . ' DEFAULT 1',
            'deleted'               => Schema::TYPE_SMALLINT,
            'position'              => Schema::TYPE_INTEGER,
            'created_at'            => Schema::TYPE_INTEGER,
            'updated_at'            => Schema::TYPE_INTEGER,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%orders}}');
    }
}
