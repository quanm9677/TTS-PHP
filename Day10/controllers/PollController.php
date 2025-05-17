<?php
// controllers/PollController.php

class PollController
{
    private $dataFile;

    public function __construct()
    {
        $this->dataFile = __DIR__ . '/../data/poll_result.json';
    }

    public function vote()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['option'])) {
            $option = $_POST['option'];
            $jsonFile = __DIR__ . '/../data/poll_result.json';

            $results = json_decode(file_get_contents($jsonFile), true);
            if (!isset($results[$option])) {
                $results[$option] = 0;
            }
            $results[$option]++;
            file_put_contents($jsonFile, json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Trả về JSON thành công cho AJAX
            echo json_encode(['success' => true]);
            exit;
        } else {
            echo json_encode(['success' => false, 'message' => 'Vui lòng chọn một tùy chọn']);
            exit;
        }
    }



    public function result()
    {
        $jsonFile = __DIR__ . '/../data/poll_result.json';
        $results = json_decode(file_get_contents($jsonFile), true);
        // Tính % hoặc trả trực tiếp để client xử lý
        echo json_encode($results);
        exit;
    }
}
