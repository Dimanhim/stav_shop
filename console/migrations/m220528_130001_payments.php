<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220528_130001_payments
 */
class m220528_130001_payments extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%payments}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'payment_type'          => Schema::TYPE_INTEGER,
            'order_id'              => Schema::TYPE_INTEGER,
            'status_id'             => Schema::TYPE_INTEGER,
            'client_id'             => Schema::TYPE_INTEGER,
            'user_id'               => Schema::TYPE_INTEGER,
            'amount'                => Schema::TYPE_INTEGER,

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
        $this->dropTable('{{%payments}}');
    }
}
