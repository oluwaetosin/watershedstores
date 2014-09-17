<?php

$constants = array(
                   'DB_USER' => 'root',
                   'DB_HOST' => 'localhost',
				   'DB_PWD' => 'mike', 
				   'DB_NAME' => 'watershed'
				   );

foreach ($constants as $key => $value) {
		defined($key)? NULL : define($key, $value);
}
?>