<?php

function civicrm_api3_popemployer_get($params) {
  if (array_key_exists('email', $params)) {
    $matches = civicrm_api("Contact","get", array ('version' => '3','sequential' =>'1', 'return' =>'current_employer,email', 'email' =>$params['email'], 'contact_type' => 'Individual'));
    if (!$matches['is_error'] && is_array($matches['values'])) {
      require_once 'CRM/Utils/Array.php';
      foreach ($matches['values'] as $match) {
        if ($match['email'] != $params['email']) { continue; }
        return CRM_Utils_Array::value('current_employer',$match);
      }
    }
  }
  return true;
}
