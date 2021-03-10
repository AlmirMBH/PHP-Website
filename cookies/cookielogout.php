<?php

setcookie('id', '1', time()-1, '/');
setcookie('username', '', time()-1, '/');            
setcookie('status', '', time()-1, '/');

echo "You are logged out";
?>