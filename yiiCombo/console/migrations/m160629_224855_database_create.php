<?php

use yii\db\Migration;

class m160629_224855_database_create extends Migration
{
    public function up()
    {
        $this->createTable('auth_assignment', [
            'item_name' => $this->string()->notNull(),
            'user_id' => $this->string()->notNull(),
            'created_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('auth_item', [
            'name' => $this->string()->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string()->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('auth_item_child', [
            'parent' => $this->string()->notNull(),
            'child' => $this->string()->notNull(),
        ]);

        $this->createTable('auth_rule', [
            'name' => $this->string()->notNull(),
            'date' => $this->text(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->createTable('contributions', [
            'UID' => $this->integer()->notNull(),
            'DID' => $this->integer()->notNull(),
        ]);

        $this->createTable('credentials', [
            'UID' => $this->integer()->notNull(),
            'PID' => $this->integer()->notNull(),
            'ACL' => $this->integer()->notNull(),
        ]);

        $this->createTable('projects', [
            'PID' => $this->integer()->notNull(),
            'Name' => $this->string()->notNull(),
            'Description' => $this->text(),
        ]);

        $this->createTable('sitedata', [
            'DID' => $this->integer()->notNull(),
            'PID' => $this->integer()->notNull(),
            'Location' => $this->string()->notNull(),
        ]);

        $this->createTable('user', [
            'id' => $this->integer()->notNull(),
            'username' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string()->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->notNull()->unique(),
            'email' => $this->string()->notNull()->unique(),
            'status' => $this->integer()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey(
            'pk-auth_assignment-item_name',
            'auth_assignment',
            ['item_name', 'user_id']
        );

        $this->addPrimaryKey(
            'pk-auth_item-name',
            'auth_item',
            'name'
        );

        $this->addPrimaryKey(
            'pk-auth_item_child-parent',
            'auth_item_child',
            ['parent', 'child']
        );

        $this->addPrimaryKey(
            'pk-auth_rule-name',
            'auth_rule',
            'name'
        );

        $this->addPrimaryKey(
            'pk-contributions-UID',
            'contributions',
            ['UID', 'DID']
        );

        $this->addPrimaryKey(
            'pk-credentials-UID',
            'credentials',
            ['UID', 'PID']
        );

        $this->addPrimaryKey(
            'pk-projects-PID',
            'projects',
            'PID'
        );

        $this->addPrimaryKey(
            'pk-sitedata-DID',
            'sitedata',
            ['DID', 'PID']
        );

        $this->addPrimaryKey(
            'pk-user-id',
            'user',
            'id'
        );

        $this->addForeignKey(
            'fk-auth_assignment-item_name',
            'auth_assignment',
            'item_name',
            'auth_rule',
            'name',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-auth_item-rule_name',
            'auth_item',
            'rule_name',
            'auth_rule',
            'name',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-auth_item_child-parent',
            'auth_item_child',
            'parent',
            'auth_item',
            'name',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-auth_item_child-child',
            'auth_item_child',
            'child',
            'auth_item',
            'name',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-contributions-UID',
            'contributions',
            'UID',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-contributions-DID',
            'contributions',
            'DID',
            'sitedata',
            'DID',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-credentials-UID',
            'credentials',
            'UID',
            'user',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-credentials-PID',
            'credentials',
            'PID',
            'projects',
            'PID',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-sitedata-PID',
            'sitedata',
            'PID',
            'projects',
            'PID',
            'CASCADE'
        );

        $this->createIndex(
            'idx-auth_item-rule_name',
            'auth_item',
            'rule_name'
        );

        $this->createIndex(
            'idx-auth_item-type',
            'auth_item',
            'type'
        );

        $this->createIndex(
            'idx-auth_item_child-child',
            'auth_item_child',
            'child'
        );

        $this->createIndex(
            'idx-contributions-DID',
            'contributions',
            'DID'
        );

        $this->createIndex(
            'idx-sitedata-PID',
            'sitedata',
            'PID'
        );

    }

    public function down()
    {
      $this->dropTable('auth_assignment');
      $this->dropTable('auth_item');
      $this->dropTable('auth_item_child');
      $this->dropTable('auth_rule');
      $this->dropTable('contributions');
      $this->dropTable('credentials');
      $this->dropTable('projects');
      $this->dropTable('sitedata');
      $this->dropTable('user');
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
