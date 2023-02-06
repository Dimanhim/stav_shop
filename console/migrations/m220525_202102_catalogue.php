<?php

use yii\db\Migration;
use yii\db\Schema;

/**
 * Class m220525_202102_catalogue
 */
class m220525_202102_catalogue extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%catalogue}}', [
            'id'                    => Schema::TYPE_PK,
            'unique_id'             => Schema::TYPE_STRING . ' NOT NULL',

            'parent_id'             => Schema::TYPE_INTEGER,
            'name'                  => Schema::TYPE_STRING . ' NOT NULL',
            'alias'                 => Schema::TYPE_STRING . ' NOT NULL',
            'description'           => Schema::TYPE_TEXT,
            'short_description'     => Schema::TYPE_TEXT,
            'meta_description'      => Schema::TYPE_STRING,
            'meta_keywords'         => Schema::TYPE_STRING,

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
        echo "m220525_202102_catalogue cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m220525_202102_catalogue cannot be reverted.\n";

        return false;
    }
    */
}
