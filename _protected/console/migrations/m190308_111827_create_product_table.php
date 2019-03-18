<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%product}}`.
 */
class m190308_111827_create_product_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%product}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'status' => $this->string(12),
            'category' => $this->string(255),
            'image' => $this->string(12),
            'actual_price' => $this->string(55),
            'offer_price' => $this->string(55),
            'stock' => $this->integer(55),
            'description' => $this->string(255),
            'features' => $this->string(255),
            'sub_category' => $this->string(255),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%product}}');
    }
}
