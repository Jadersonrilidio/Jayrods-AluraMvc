<?php

namespace Jayrods\AluraMvc\Repository;

use Jayrods\AluraMvc\Repository\Repository;
use Jayrods\AluraMvc\Entity\Video;
use PDO;
use PDOStatement;

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
        $query = "INSERT INTO videos (url, title, image) VALUES (:url, :title, :image);";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $video->url(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title(), PDO::PARAM_STR);
        $stmt->bindValue(':image', $video->filePath(), PDO::PARAM_STR);

        $stmt->execute();

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

        $video = $this->find($id);

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $result = $stmt->execute();

        if ($result and $video->filePath() !== null) {
            $path = dirname(dirname(__DIR__)) . '/public/img/uploads/';
            $fileName = $video->filePath();
            unlink($path . $fileName);
        }

        return $result;
    }

    /**
     * 
     * @param  Video  $video
     * 
     * @return Video
     */
    public function update(Video $video): Video
    {
        $query = "UPDATE videos SET url = :url, title = :title ";
        if ($video->filePath() !== null) {
            $query .= ", image = :image ";
        }
        $query .= " WHERE id = :id";

        $oldImage = $this->find($video->id())->filePath();

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $video->url(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $video->id(), PDO::PARAM_INT);

        if ($video->filePath() !== null) {
            $stmt->bindValue(':image', $video->filePath(), PDO::PARAM_STR);
        }

        if ($oldImage !== null) {
            unlink(dirname(dirname(__DIR__)) . '/public/img/uploads/' . $oldImage);
        }

        $stmt->execute();

        return $video;
    }

    /**
     * 
     * @param  int  $id
     * 
     * @return Video
     */
    public function removeImage(int $id): bool
    {
        $video = $this->find($id);

        $query = "UPDATE videos SET url = :url, title = :title, image = :image WHERE id = :id";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindValue(':url', $video->url(), PDO::PARAM_STR);
        $stmt->bindValue(':title', $video->title(), PDO::PARAM_STR);
        $stmt->bindValue(':id', $video->id(), PDO::PARAM_INT);
        $stmt->bindValue(':image', null, PDO::PARAM_STR);

        unlink(dirname(dirname(__DIR__)) . '/public/img/uploads/' . $video->filePath());

        return $stmt->execute();
    }

    /**
     * 
     * @return array
     */
    public function all(): array
    {
        $query = "SELECT * FROM videos";

        $stmt = $this->pdo->query($query);

        return $this->hydrateVideo($stmt);
    }

    /**
     * @param  int  $id
     * 
     * @return Video
     */
    public function find(int $id): Video
    {
        $query = "SELECT * FROM videos WHERE id = :id;";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindValue(':id', intval($id), PDO::PARAM_INT);
        $stmt->execute();

        return array_values($this->hydrateVideo($stmt))[0];
    }

    /**
     * @param  PDOStatement  $stmt
     * 
     * @return Video[]
     */
    public function hydrateVideo(PDOStatement $stmt): array
    {
        $videoCollection = array();

        while ($videoData = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $video = new Video(
                (int) $videoData['id'],
                $videoData['url'],
                $videoData['title']
            );

            if ($videoData['image'] !== null) {
                $video->setFilePath($videoData['image']);
            }

            $videoCollection[] = $video;
        }

        return $videoCollection;
    }
}
