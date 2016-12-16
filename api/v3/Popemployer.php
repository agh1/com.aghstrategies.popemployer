<?php

/**
 * Wrapper around Contact.getvalue for getting employer name given an email
 *
 * @param array $params
 *   Must contain an `email` key.
 *
 * @return mixed
 *   The employer name, or TRUE if nothing found
 */
function civicrm_api3_popemployer_get($params) {
  if (array_key_exists('email', $params)) {
    try {
      return civicrm_api3('Contact', 'getvalue', array(
        'return' => "current_employer",
        'email' => $params['email'],
        'contact_type' => 'Individual',
        'employer_id' => array('IS NOT NULL' => 1),
        'options' => array('limit' => 1),
      ));
    }
    catch (CiviCRM_API3_Exception $e) {
      // Probably no big deal, just no contact found.
      return TRUE;
    }
  }
  return TRUE;
}
