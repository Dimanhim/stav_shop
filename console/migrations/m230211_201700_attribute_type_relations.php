<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m230211_201700_attribute_type_relations
 */
class m230211_201700_attribute_type_relations extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%attribute_type_relations}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'attribute_id'          => Schema::TYPE_INTEGER . ' NOT NULL',
            'attribute_type_id'     => Schema::TYPE_INTEGER . ' NOT NULL',

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
        $this->dropTable('{{%attribute_type_relations}}');
    }
}
