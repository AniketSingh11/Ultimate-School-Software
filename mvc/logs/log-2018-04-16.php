<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

ERROR - 2018-04-16 19:04:29 --> Query error: Table 'tameasy_ult_school.conversations' doesn't exist - Invalid query: SELECT DISTINCT *
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
ERROR - 2018-04-16 19:04:29 --> Severity: Error --> Call to a member function num_rows() on boolean /home/tameasy/public_html/ult_school/mvc/models/Conversation_m.php 35
ERROR - 2018-04-16 19:04:32 --> Query error: Table 'tameasy_ult_school.conversations' doesn't exist - Invalid query: SELECT DISTINCT *
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
ERROR - 2018-04-16 19:04:32 --> Severity: Error --> Call to a member function num_rows() on boolean /home/tameasy/public_html/ult_school/mvc/models/Conversation_m.php 35
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:40 --> Could not find the language line "activitiescategory_name"
ERROR - 2018-04-16 19:08:48 --> Could not find the language line "menu_activities_category"
ERROR - 2018-04-16 19:09:07 --> Could not find the language line "menu_activities_category"
