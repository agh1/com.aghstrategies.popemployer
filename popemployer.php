<?php

require_once 'popemployer.civix.php';

/**
 * Implementation of hook_civicrm_alterContent
 */
function popemployer_civicrm_alterContent(  &$content, $context, $tplName, &$object ) {
  if ($context != 'form') { return; }

  // only do this for anonymous users
  require_once 'CRM/Utils/System.php';
  if (CRM_Utils_System::isUserLoggedIn()) { return; }

  // find appropriate AJAX API function
  $version = CRM_Core_BAO_Domain::version();
  $version = explode('.',$version);
  $version = $version[0] . '.' . $version[1];
  $crmfunc = (floatval($version) <= 4.2) ? 'cj().crmAPI' :  'CRM.api';
  
  $content .= '
    <script type="text/javascript">
      if( cj(\'input#current_employer\').length > 0) {
        waitToSearch=setTimeout(function(){ runSearch(cj(\'#crm-container input[name^="email-"]\').val()) },750);
        cj(\'#crm-container input[name^="email-"]\').each( function() {
          cj(this).change( function() { prepSearch(cj(this).val()) });
          cj(this).keyup( function() { prepSearch(cj(this).val()) });
        });
        cj(\'span.popemployer-hidden-edit\').click( function() {

        });
      }
      
      function prepSearch(email) {
        clearTimeout(waitToSearch);
        waitToSearch=setTimeout(function(){ runSearch(email) },750);
      }
      
      function runSearch(email) {
        if (email.search("@") >= 0 && email.lastIndexOf(".") > email.search("@")) {
          ' . $crmfunc . '(\'Popemployer\', \'get\', {\'q\': \'civicrm/ajax/rest\', \'sequential\': 1, \'email\': email, "customcontext": "popemployer"},
            {success: function(data) {
                if (data.result.length > 0) {
                  cj(\'input#current_employer\').val(data.result);
                  cj(\'span.popemployer-hidden-edit\').remove();
                  cj(\'input#current_employer\').addClass(\'popemployer-hidden\').hide().after(\'<span class="popemployer-hidden-edit" style="cursor: pointer" onClick="employerEdit(this)">\'+data.result+\' (click to edit)</span>\');
                }
              }
            }
          );
        }
      }
      
      function employerEdit(obj) {
        cj(\'input#current_employer.popemployer-hidden\').show();
        cj(obj).remove();
      }
    </script>
  ';
}

/**
 * Implementation of hook_civicrm_alterAPIPermissions
 */
function popemployer_civicrm_alterAPIPermissions($entity, $action, &$params, &$permissions) {
    if ($entity == 'popemployer' && $action == 'get' && $params['email']) {
        $permissions['popemployer']['get'] = array();
    }
}

/**
 * Implementation of hook_civicrm_config
 */
function popemployer_civicrm_config(&$config) {
  _popemployer_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function popemployer_civicrm_xmlMenu(&$files) {
  _popemployer_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_install
 */
function popemployer_civicrm_install() {
  return _popemployer_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function popemployer_civicrm_uninstall() {
  return _popemployer_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function popemployer_civicrm_enable() {
  return _popemployer_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function popemployer_civicrm_disable() {
  return _popemployer_civix_civicrm_disable();
}

/**
 * Implementation of hook_civicrm_upgrade
 *
 * @param $op string, the type of operation being performed; 'check' or 'enqueue'
 * @param $queue CRM_Queue_Queue, (for 'enqueue') the modifiable list of pending up upgrade tasks
 *
 * @return mixed  based on op. for 'check', returns array(boolean) (TRUE if upgrades are pending)
 *                for 'enqueue', returns void
 */
function popemployer_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _popemployer_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function popemployer_civicrm_managed(&$entities) {
  return _popemployer_civix_civicrm_managed($entities);
}
