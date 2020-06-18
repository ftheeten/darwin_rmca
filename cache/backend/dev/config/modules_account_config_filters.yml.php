<?php
// auto-generated by sfFilterConfigHandler
// date: 2020/06/18 14:01:01


list($class, $parameters) = (array) sfConfig::get('sf_rendering_filter', array('sfRenderingFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

// does this action require security?
if ($actionInstance->isSecure())
{
  
list($class, $parameters) = (array) sfConfig::get('sf_security_filter', array('sfBasicSecurityFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);
}

list($class, $parameters) = (array) sfConfig::get('sf_timeout_filter', array('timeoutFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_tracking_filter', array('trackingFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_db_version_filter', array('dbVersionFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_common_filter', array('sfCommonFilter', null));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

list($class, $parameters) = (array) sfConfig::get('sf_execution_filter', array('sfExecutionFilter', array (
)));
$filter = new $class(sfContext::getInstance(), $parameters);
$this->register($filter);

