<?php
// models/Poll.php
class Poll {
    private $file = 'data/poll_result.json';

    public function getResults() {
        if (!file_exists($this->file)) {
            return [];
        }
        return json_decode(file_get_contents($this->file), true);
    }

    public function vote($option) {
        $data = $this->getResults();

        if (!isset($data[$option])) {
            return false;
        }

        $data[$option]++;
        file_put_contents($this->file, json_encode($data));
        return true;
    }
}
?>
