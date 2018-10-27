<?php
if (!defined('MSVODPATH')) exit('No permission resources');
return array(
           'DROP TABLE IF EXISTS `{prefix}tu`;',
           'DROP TABLE IF EXISTS `{prefix}tu_list`;',
           'DROP TABLE IF EXISTS `{prefix}tu_look`;',
           'DROP TABLE IF EXISTS `{prefix}tu_topic`;'
);
