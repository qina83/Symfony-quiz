<?php


namespace App\Service;


interface TopicServiceInterface
{
    public function getTopics(): array;
    public function addTopic(Topic $topic): Topic;
    public function deleteTopic(int $id);
    public function updateTopic(Topic $topic): Topic;
}