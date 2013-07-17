<?php

require_once 'volunteer.civix.php';

/**
 * Implementation of hook_civicrm_config
 */
function volunteer_civicrm_config(&$config) {
  _volunteer_civix_civicrm_config($config);
}

/**
 * Implementation of hook_civicrm_xmlMenu
 *
 * @param $files array(string)
 */
function volunteer_civicrm_xmlMenu(&$files) {
  _volunteer_civix_civicrm_xmlMenu($files);
}

/**
 * Implementation of hook_civicrm_tabset
 *
 * Insert the "Volunteer" tab into the event edit workflow
 */
function volunteer_civicrm_tabset($tabsetName, &$tabs, $context) {
  if ($tabsetName == 'civicrm/event/manage') {
    if (!empty($context)) {
      $eventID = $context['event_id'];
      $url = CRM_Utils_System::url( 'civicrm/event/manage/volunteer',
        "reset=1&snippet=5&force=1&id=$eventID&action=update&component=event" );

      $tab['volunteer'] = array(
        'title' => ts('Volunteers'),
        'link' => $url,
        'valid' => 1,
        'active' => 1,
        'current' => false,
      );
      // If volunteer mngmt is enabled, add necessary UI elements
      if (CRM_Volunteer_BAO_Project::isActive($eventID, CRM_Event_DAO_Event::$_tableName)) {
        CRM_Volunteer_Form_Manage::addResources();
      }
    }
    else {
      $tab['volunteer'] = array(
        'title' => ts('Volunteers'),
        'url' => 'civicrm/event/manage/volunteer',
      );
    }
    // Insert this tab into position 4
    $tabs = array_merge(
      array_slice($tabs, 0, 4),
      $tab,
      array_slice($tabs, 4)
    );
  }

}

/**
 * Implementation of hook_civicrm_install
 */
function volunteer_civicrm_install() {
  return _volunteer_civix_civicrm_install();
}

/**
 * Implementation of hook_civicrm_uninstall
 */
function volunteer_civicrm_uninstall() {
  return _volunteer_civix_civicrm_uninstall();
}

/**
 * Implementation of hook_civicrm_enable
 */
function volunteer_civicrm_enable() {
  return _volunteer_civix_civicrm_enable();
}

/**
 * Implementation of hook_civicrm_disable
 */
function volunteer_civicrm_disable() {
  return _volunteer_civix_civicrm_disable();
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
function volunteer_civicrm_upgrade($op, CRM_Queue_Queue $queue = NULL) {
  return _volunteer_civix_civicrm_upgrade($op, $queue);
}

/**
 * Implementation of hook_civicrm_managed
 *
 * Generate a list of entities to create/deactivate/delete when this module
 * is installed, disabled, uninstalled.
 */
function volunteer_civicrm_managed(&$entities) {
  return _volunteer_civix_civicrm_managed($entities);
}

/**
 * Implementation of hook_civicrm_entityTypes
 */
function volunteer_civicrm_entityTypes(&$entityTypes) {
  $entityTypes[] = array(
    'name'  => 'VolunteerNeed',
    'class' => 'CRM_Volunteer_DAO_Need',
    'table' => 'civicrm_volunteer_need',
  );
  $entityTypes[] = array(
    'name'  => 'VolunteerProject',
    'class' => 'CRM_Volunteer_DAO_Project',
    'table' => 'civicrm_volunteer_project',
  );
}

/**
 * Implementation of hook_civicrm_alterContent
 *
 * Handler for alterContent hook.
 */
function volunteer_civicrm_alterContent(&$content, $context, $tplName, &$object) {
  $f = '_volunteer_civicrm_alterContent_' . get_class($object);
  if (function_exists($f)) {
    $f($content, $context, $tplName, $object);
  }
}

/**
 * Callback for event info page
 *
 * Wires up JS for inserting "Volunteer Now" button if a project is associated
 * with the event.
 */
function _volunteer_civicrm_alterContent_CRM_Event_Page_EventInfo(&$content, $context, $tplName, &$object) {
  $params = array(
    'entity_id' => $object->_id,
    'entity_table' => 'civicrm_event',
    'is_active' => 1,
  );
  $projects = CRM_Volunteer_BAO_Project::retrieve($params);

  // only show volunteer button if this event has an active project
  if (count($projects)) {
    $project = current($projects);
    $ccr = CRM_Core_Resources::singleton();
    $ccr->addSetting(array('volunteer' => array(
      'project_id' => $project->id,
      'button_text' => ts('Volunteer Now'),
    )));

    $ccr->addScriptFile('org.civicrm.volunteer',
      'templates/CRM/Event/Page/EventInfo.js',
      $ccr::DEFAULT_WEIGHT, 'html-header');
  }
}