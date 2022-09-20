<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-04-19 16:07:12 --> Query error: Table 'tameasy_ult_school.conversations' doesn't exist - Invalid query: SELECT DISTINCT *
FROM `conversation_user` `a`
LEFT JOIN `conversations` `b` ON `a`.`conversation_id`=`b`.`id`
LEFT JOIN `conversation_msg` `c` ON `a`.`conversation_id`=`c`.`conversation_id`
WHERE `a`.`user_id` = '1'
AND `a`.`usertypeID` = '1'
AND `a`.`trash` =0
AND `c`.`start` = 1
AND `b`.`draft` =0
GROUP BY `b`.`id`
ORDER BY `b`.`id` DESC
ERROR - 2018-04-19 16:07:12 --> Severity: Error --> Call to a member function num_rows() on boolean /home/tameasy/public_html/ult_school/mvc/models/Conversation_m.php 35
