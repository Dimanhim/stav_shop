<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m230123_181945_pages
 */
class m230123_181945_pages extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%pages}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'name'                  => Schema::TYPE_STRING,
            'alias'                 => Schema::TYPE_STRING,
            'type'                  => Schema::TYPE_STRING,
            'parent_id'             => Schema::TYPE_INTEGER,
            'relation_id'           => Schema::TYPE_INTEGER,
            'h1'                    => Schema::TYPE_STRING,
            'title'                 => Schema::TYPE_STRING,
            'meta_description'      => Schema::TYPE_STRING,
            'meta_keywords'         => Schema::TYPE_STRING,
            'template'              => Schema::TYPE_STRING,
            'custom_code'           => Schema::TYPE_TEXT,

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
        $this->dropTable('{{%pages}}');
    }
}
