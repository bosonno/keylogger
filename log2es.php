<?php

$lines = file('/var/log/keystroke.log');
$index = 'keystroke';
$salt = 'oRDb9m@T2X.JCvkR';

foreach($lines as $line) {

    $content  = '';
    $content .= '{"create": {"_index": "' . $index . '", "_id": "' . hash('sha256', $line . $salt) . '"}}' . "\n";
    $content .= $line;

    echo $content;

}

$mapping = <<<EOF
PUT $index
{
  "mappings": {
    "properties": {
      "timestamp": {
        "type": "date",
        "format": "yyyy-MM-dd'T'HH:mm:ss.SSS"
      },
      "key": {
        "type": "text"
      },
      "code": {
        "type": "integer"
      },
      "type": {
        "type": "text"
      }
    }
  }
}
EOF;