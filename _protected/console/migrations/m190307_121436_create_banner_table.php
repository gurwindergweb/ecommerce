<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%post}}`.
 */
class m190307_121436_create_banner_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%banner}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string(12)->notNull()->unique(),
            'offer' => $this->text(55),
            'image' => $this->text(55),
			'status' => $this->string(12)->notNull()->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%banner}}');
    }
}
