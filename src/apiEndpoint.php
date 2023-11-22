<?php

http_response_code(200);
header('Content-type: application/json');
echo json_encode(['success' => true]);
