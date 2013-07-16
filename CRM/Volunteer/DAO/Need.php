<?php
/*
+--------------------------------------------------------------------+
| CiviCRM version 4.3                                                |
+--------------------------------------------------------------------+
| Copyright CiviCRM LLC (c) 2004-2013                                |
+--------------------------------------------------------------------+
| This file is a part of CiviCRM.                                    |
|                                                                    |
| CiviCRM is free software; you can copy, modify, and distribute it  |
| under the terms of the GNU Affero General Public License           |
| Version 3, 19 November 2007 and the CiviCRM Licensing Exception.   |
|                                                                    |
| CiviCRM is distributed in the hope that it will be useful, but     |
| WITHOUT ANY WARRANTY; without even the implied warranty of         |
| MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.               |
| See the GNU Affero General Public License for more details.        |
|                                                                    |
| You should have received a copy of the GNU Affero General Public   |
| License and the CiviCRM Licensing Exception along                  |
| with this program; if not, contact CiviCRM LLC                     |
| at info[AT]civicrm[DOT]org. If you have questions about the        |
| GNU Affero General Public License or the licensing of CiviCRM,     |
| see the CiviCRM license FAQ at http://civicrm.org/licensing        |
+--------------------------------------------------------------------+
*/
/**
 *
 * @package CRM
 * @copyright CiviCRM LLC (c) 2004-2013
 *
 * Generated from xml/schema/CRM/Volunteer/Need.xml
 * DO NOT EDIT.  Generated by GenCode.php
 */
require_once 'CRM/Core/DAO.php';
require_once 'CRM/Utils/Type.php';
class CRM_Volunteer_DAO_Need extends CRM_Core_DAO
{
  /**
   * static instance to hold the table name
   *
   * @var string
   * @static
   */
  static $_tableName = 'civicrm_volunteer_need';
  /**
   * static instance to hold the field values
   *
   * @var array
   * @static
   */
  static $_fields = null;
  /**
   * static instance to hold the keys used in $_fields for each field.
   *
   * @var array
   * @static
   */
  static $_fieldKeys = null;
  /**
   * static instance to hold the FK relationships
   *
   * @var string
   * @static
   */
  static $_links = null;
  /**
   * static instance to hold the values that can
   * be imported
   *
   * @var array
   * @static
   */
  static $_import = null;
  /**
   * static instance to hold the values that can
   * be exported
   *
   * @var array
   * @static
   */
  static $_export = null;
  /**
   * static value to see if we should log any modifications to
   * this table in the civicrm_log table
   *
   * @var boolean
   * @static
   */
  static $_log = true;
  /**
   * Need Id
   *
   * @var int unsigned
   */
  public $id;
  /**
   * FK to civicrm_volunteer_project table which contains entity_table + entity for each volunteer project (initially civicrm_event + eventID).
   *
   * @var int unsigned
   */
  public $project_id;
  /**
   *
   * @var datetime
   */
  public $start_time;
  /**
   * Length in minutes of this volunteer time slot.
   *
   * @var int
   */
  public $duration;
  /**
   * Boolean indicating whether or not the time and role are flexible. Activities linked to a flexible need indicate that the volunteer is generally available.
   *
   * @var boolean
   */
  public $is_flexible;
  /**
   * The number of volunteers needed for this need.
   *
   * @var int
   */
  public $quantity;
  /**
   *  Indicates whether this need is offered on public volunteer signup forms. Implicit FK to option_value row in visibility option_group.
   *
   * @var int unsigned
   */
  public $visibility_id;
  /**
   * The role associated with this need. Implicit FK to option_value row in volunteer_role option_group.
   *
   * @var int unsigned
   */
  public $role_id;
  /**
   * Is this need enabled?
   *
   * @var boolean
   */
  public $is_active;
  /**
   * class constructor
   *
   * @access public
   * @return civicrm_volunteer_need
   */
  function __construct()
  {
    $this->__table = 'civicrm_volunteer_need';
    parent::__construct();
  }
  /**
   * return foreign keys and entity references
   *
   * @static
   * @access public
   * @return array of CRM_Core_EntityReference
   */
  static function getReferenceColumns()
  {
    if (!self::$_links) {
      self::$_links = array(
        new CRM_Core_EntityReference(self::getTableName() , 'project_id', 'civicrm_volunteer_project', 'id') ,
      );
    }
    return self::$_links;
  }
  /**
   * returns all the column names of this table
   *
   * @access public
   * @return array
   */
  static function &fields()
  {
    if (!(self::$_fields)) {
      self::$_fields = array(
        'volunteer_need_id' => array(
          'name' => 'id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('CiviVolunteer Need ID') ,
          'required' => true,
        ) ,
        'volunteer_need_project_id' => array(
          'name' => 'project_id',
          'type' => CRM_Utils_Type::T_INT,
          'required' => true,
          'FKClassName' => 'CRM_Volunteer_DAO_Project',
        ) ,
        'start_time' => array(
          'name' => 'start_time',
          'type' => CRM_Utils_Type::T_DATE + CRM_Utils_Type::T_TIME,
          'title' => ts('Start Date and Time') ,
        ) ,
        'duration' => array(
          'name' => 'duration',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Duration') ,
        ) ,
        'is_flexible' => array(
          'name' => 'is_flexible',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Flexible') ,
          'required' => true,
        ) ,
        'quantity' => array(
          'name' => 'quantity',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Quantity') ,
          'default' => 'UL',
        ) ,
        'visibility_id' => array(
          'name' => 'visibility_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Visibility') ,
          'default' => 'UL',
        ) ,
        'role_id' => array(
          'name' => 'role_id',
          'type' => CRM_Utils_Type::T_INT,
          'title' => ts('Role') ,
          'default' => 'UL',
          'pseudoconstant' => array(
            'optionGroupName' => 'volunteer_role',
          )
        ) ,
        'is_active' => array(
          'name' => 'is_active',
          'type' => CRM_Utils_Type::T_BOOLEAN,
          'title' => ts('Enabled') ,
          'required' => true,
          'default' => '',
        ) ,
      );
    }
    return self::$_fields;
  }
  /**
   * Returns an array containing, for each field, the arary key used for that
   * field in self::$_fields.
   *
   * @access public
   * @return array
   */
  static function &fieldKeys()
  {
    if (!(self::$_fieldKeys)) {
      self::$_fieldKeys = array(
        'id' => 'volunteer_need_id',
        'project_id' => 'volunteer_need_project_id',
        'start_time' => 'start_time',
        'duration' => 'duration',
        'is_flexible' => 'is_flexible',
        'quantity' => 'quantity',
        'visibility_id' => 'visibility_id',
        'role_id' => 'role_id',
        'is_active' => 'is_active',
      );
    }
    return self::$_fieldKeys;
  }
  /**
   * returns the names of this table
   *
   * @access public
   * @static
   * @return string
   */
  static function getTableName()
  {
    return self::$_tableName;
  }
  /**
   * returns if this table needs to be logged
   *
   * @access public
   * @return boolean
   */
  function getLog()
  {
    return self::$_log;
  }
  /**
   * returns the list of fields that can be imported
   *
   * @access public
   * return array
   * @static
   */
  static function &import($prefix = false)
  {
    if (!(self::$_import)) {
      self::$_import = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('import', $field)) {
          if ($prefix) {
            self::$_import['volunteer_need'] = & $fields[$name];
          } else {
            self::$_import[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_import;
  }
  /**
   * returns the list of fields that can be exported
   *
   * @access public
   * return array
   * @static
   */
  static function &export($prefix = false)
  {
    if (!(self::$_export)) {
      self::$_export = array();
      $fields = self::fields();
      foreach($fields as $name => $field) {
        if (CRM_Utils_Array::value('export', $field)) {
          if ($prefix) {
            self::$_export['volunteer_need'] = & $fields[$name];
          } else {
            self::$_export[$name] = & $fields[$name];
          }
        }
      }
    }
    return self::$_export;
  }
}
