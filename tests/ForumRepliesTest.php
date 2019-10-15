<?php

use Obv\ObvForum\Replies\Reply;
use Obv\ObvForum\Topics\TopicNotFoundException;
use PHPUnit\Framework\TestCase;

class ForumRepliesTest extends TestCase
{
    public function testCreateReplyToTopic_existingTopic_returnsThatReply()
    {
        $app = ObvForumCreator::createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic('Getting back to PHP after 3 years', '', $category->getId());
        $reply = $app->createReplyToTopic(
            'Welcome back to PHP bro!',
            'anonymous_identifier',
            $topic->getId()
        );
        $this->assertInstanceOf(Reply::class, $reply);
    }

    public function testCreateReplyToTopic_nonExistingTopic_throwsTopicNotFoundException()
    {
        $app = ObvForumCreator::createObvForum();

        $this->expectException(TopicNotFoundException::class);
        $app->createReplyToTopic(
            'Welcome back to PHP bro!',
            'anonymous_identifier',
            'this_topic_does_not_exists'
        );
    }

    public function testGetAllRepliesForTopic_multipleRepliesExists_returnsArrayOfThoseReplies()
    {
        $app = ObvForumCreator::createObvForum();
        $category = $app->createCategory("PHP Development");
        $topic = $app->createTopic('Getting back to PHP after 3 years', '', $category->getId());
        $anotherTopic = $app->createTopic('How to download PHP?', '', $category->getId());
        $app->createReplyToTopic(
            'Welcome back to PHP bro!',
            'anonymous_identifier',
            $topic->getId()
        );
        $app->createReplyToTopic(
            'Go back java :-D kappa.',
            'anonymous_identifier',
            $topic->getId()
        );
        $app->createReplyToTopic(
            'Go to http://php.net/downloads',
            'anonymous_identifier',
            $anotherTopic->getId()
        );
        $result = $app->getRepliesForTopic($topic->getId());
        $this->assertCount(2, $result);
    }
}
