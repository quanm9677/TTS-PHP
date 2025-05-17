<?php
// views/poll/result.php
require_once 'controllers/PollController.php';

$poll = new PollController();
$poll->result();
?>