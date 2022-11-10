<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_lesson}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 * - `{{%lesson}}`
 */
class m221110_162349_createUserLessonTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%userLesson}}', [
            'userLessonId' => $this->primaryKey(),
            'userId' => $this->integer(),
            'lessonId' => $this->integer(),
            'createdAt' => $this->integer(),
            'updatedAt' => $this->integer(),
        ]);

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-user_lesson-userId}}',
            '{{%userLesson}}',
            'userId',
            '{{%user}}',
            'userId',
            'SET NULL'
        );

        // add foreign key for table `{{%lesson}}`
        $this->addForeignKey(
            '{{%fk-user_lesson-lessonId}}',
            '{{%userLesson}}',
            'lessonId',
            '{{%lesson}}',
            'lessonId',
            'SET NULL'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-user_lesson-userId}}',
            '{{%userLesson}}'
        );

        // drops foreign key for table `{{%lesson}}`
        $this->dropForeignKey(
            '{{%fk-user_lesson-lessonId}}',
            '{{%userLesson}}'
        );

        $this->dropTable('{{%userLesson}}');
    }
}
