<?php
if (!defined('MSVODPATH')) exit('No permission resources');
return array(
'DROP TABLE IF EXISTS `{prefix}video`;',
'DROP TABLE IF EXISTS `{prefix}video_list`;',
'DROP TABLE IF EXISTS `{prefix}video_server`;',
'DROP TABLE IF EXISTS `{prefix}video_fav`;',
'DROP TABLE IF EXISTS `{prefix}video_down`;',
'DROP TABLE IF EXISTS `{prefix}video_play`;',
'DROP TABLE IF EXISTS `{prefix}video_topic`;'
);
