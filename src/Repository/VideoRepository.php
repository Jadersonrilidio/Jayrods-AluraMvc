<?php

namespace Jayrods\AluraMvc\Repository;

use Jayrods\AluraMvc\Repository\Repository;
use Jayrods\AluraMvc\Entity\Video;
use PDO;

class VideoRepository implements Repository
{
    /**
     * @var PDO
     */
    private PDO $pdo;

    /**
     * 
     * @param  PDO  $pdo
     * 
     * @return void
     */
    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * 
     * @param  Video  $video
     * 
     * @return Video
     */
    public function add(Video $video): Video
    {
        $query = "INSERT INTO videos (url, title) VALUES (:url, :title);";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $video->url(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title(), PDO::PARAM_STR);

        $result = $stmt->execute();

        $id = $this->pdo->lastInsertId();

        $video->identify(intval($id));

        return $video;
    }

    /**
     * @param  int  $id
     * 
     * @return bool
     */
    public function remove(int $id): bool
    {
        $query = "DELETE FROM videos WHERE id = :id;";

        $id = filter_var($id, FILTER_VALIDATE_INT);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        return $stmt->execute();
    }

    /**
     * 
     * @param  Video  $video
     * 
     * @return Video
     */
    public function update(Video $video): Video
    {
        $query = "UPDATE videos SET url = :url, title = :title WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $video->url(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $video->id(), PDO::PARAM_INT);

        $result = $stmt->execute();

        return $video;
    }

    /**
     * 
     * @return Video[]
     */
    public function all(): array
    {
        $query = "SELECT * FROM videos;";

        $videos = array_map(function ($videoData) {
            return new Video(
                $videoData['id'],
                $videoData['url'],
                $videoData['title']
            );
        }, $this->pdo
            ->query($query)
            ->fetchAll(PDO::FETCH_ASSOC));

        return $videos;
    }

    /**
     * @param  int  $id
     * 
     * @return Video[]
     */
    public function get(int $id): Video
    {
        $query = "SELECT * FROM videos WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->execute();
        $videoData = $stmt->fetch(PDO::FETCH_ASSOC);

        return new Video(
            $videoData['id'],
            $videoData['url'],
            $videoData['title']
        );
    }
}
