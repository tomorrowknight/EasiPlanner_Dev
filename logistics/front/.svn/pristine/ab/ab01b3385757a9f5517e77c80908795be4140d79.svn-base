<?php

use yii\db\Schema;
use yii\db\Migration;

class m150306_090443_setting extends Migration
{
	public function up()
	{
		$this->createTable('setting', [
				'id' => 'pk',
				'title' => Schema::TYPE_STRING . ' NOT NULL',
				'content' => Schema::TYPE_TEXT,
				]);
		$this->createTable('image', [
				'id' => 'pk',
				'node_id' => Schema::TYPE_INTEGER,
				]);
	}

	public function down()
	{
		$this->dropTable('setting');
		$this->dropTable('image');
	}

	/*
	 // Use safeUp/safeDown to run migration code within a transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
