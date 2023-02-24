<?php
echo substr(preg_replace('%[=/\+]%', '-', base64_encode(random_bytes(floor(6 / 4 * 3)))), 0, 6);
?>