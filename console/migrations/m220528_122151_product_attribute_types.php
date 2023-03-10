<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220528_122151_product_attribute_types
 */
class m220528_122151_product_attribute_types extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product_attribute_types}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'attribute_type_id'     => Schema::TYPE_INTEGER . ' NOT NULL',
            'product_id'            => Schema::TYPE_INTEGER . ' NOT NULL',

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
        $this->dropTable('{{%product_attribute_types}}');
    }
}
