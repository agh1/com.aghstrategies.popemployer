<?php

require_once 'popemployer.civix.php';

/**
 * Implements hook_civicrm_buildForm().
 *
 * Add the Javascript to forms for anonymous visitors.
 */
function popemployer_civicrm_buildForm($formName, &$form) {
  if (CRM_Utils_System::isUserLoggedIn()) {
    return;
  }

  CRM_Core_Resources::singleton()->addScriptFile('com.aghstrategies.popemployer', 'js/popemployer.js');
}

/**
 * Implements hook_civicrm_alterAPIPermissions().
 *
 * Allow anyone to run Popemployer.get API so long as they provide an email.
 */
function popemployer_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions) {
  if ($entity == 'popemployer' && $action == 'get' && $params['email']) {
    $permissions['popemployer']['get'] = array();
  }
}

/**
 * Implements hook_civicrm_config().
 */
function popemployer_civicrm_config(&$config) {
  _popemployer_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_xmlMenu().
 */
function popemployer_civicrm_xmlMenu(&$files) {
  _popemployer_civix_civicrm_xmlMenu($files);
}

/**
 * Implements hook_civicrm_install().
 */
function popemployer_civicrm_install() {
  return _popemployer_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_uninstall().
 */
function popemployer_civicrm_uninstall() {
  return _popemployer_civix_civicrm_uninstall();
}

/**
 * Implements hook_civicrm_enable().
 */
function popemployer_civicrm_enable() {
  return _popemployer_civix_civicrm_enable();
}

/**
 * Implements hook_civicrm_disable().
 */
function popemployer_civicrm_disable() {
  return _popemployer_civix_civicrm_disable();
}

/**
 * Implements hook_civicrm_upgrade().
 */
function popemployer_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _popemployer_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implements hook_civicrm_managed().
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function popemployer_civicrm_managed(&$entities) {
  return _popemployer_civix_civicrm_managed($entities);
}
