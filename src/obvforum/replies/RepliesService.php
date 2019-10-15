<?php

namespace Obv\ObvForum\Replies;

use Obv\ObvForum\Topics\TopicNotFoundException;
use Obv\ObvForum\Topics\TopicsService;
use Obv\Storage\DataMapper;
use Obv\Storage\Storage;

class RepliesService
{
    private $storage;
    private $dataMapper;
    private $topicsService;

    public function __construct(Storage $storage, DataMapper $dataMapper, TopicsService $topicsService)
    {
        $this->storage = $storage;
        $this->dataMapper = $dataMapper;
        $this->topicsService = $topicsService;
    }

    public function createReply(string $contents, string $userId, string $topicId)
    {
        if (!$this->topicsService->exists($topicId))
        {
            throw new TopicNotFoundException("Could not find topic: " . $topicId);
        }

        $reply = new Reply(
            uniqid(),
            $contents,
            $userId,
            new \DateTime(),
            $topicId
        );

        $this->storage->store(array(
            '_id' => $reply->getId(),
            '_contents' => $contents,
            '_createdBy' => $userId,
            '_topic' => $topicId,
            '_createdAt' => $reply->getCreatedAt(),
        ));

        return $reply;
    }

    /**
     * @param string $topicId
     * @return Reply[]
     */
    public function getAllForTopic(string $topicId) : array
    {
        return $this->storage->load()
            ->filter(array(
                '_topic' => $topicId,
            ))->orderBy(array(
                '_createdAt' => 'desc',
            ))->map(function (array $data){
                return new Reply(
                    $data['_id'],
                    $data['_contents'],
                    $data['_createdBy'],
                    $this->dataMapper->asDate($data['_createdAt']),
                    $data['_topic']
                );
            })->findAll();
    }
}