<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220528_120932_products
 */
class m220528_120932_products extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%products}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'catalogue_id'          => Schema::TYPE_INTEGER,
            'type'                  => Schema::TYPE_SMALLINT,
            'name'                  => Schema::TYPE_STRING . ' NOT NULL',
            'description'           => Schema::TYPE_TEXT,
            'short_description'     => Schema::TYPE_TEXT,
            'cost_full'             => Schema::TYPE_INTEGER,
            'cost_old'              => Schema::TYPE_INTEGER,
            'cost_discount'         => Schema::TYPE_INTEGER,
            'discount'              => Schema::TYPE_INTEGER,
            'attributes'             => Schema::TYPE_TEXT,

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
        $this->dropTable('{{%products}}');
    }
}
