<?php

require_once 'trxnidcheck.civix.php';
// phpcs:disable
use CRM_Trxnidcheck_ExtensionUtil as E;
// phpcs:enable

/**
 * Implements hook_civicrm_config().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_config/
 */
function trxnidcheck_civicrm_config(&$config): void {
  _trxnidcheck_civix_civicrm_config($config);
}

/**
 * Implements hook_civicrm_install().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_install
 */
function trxnidcheck_civicrm_install(): void {
  _trxnidcheck_civix_civicrm_install();
}

/**
 * Implements hook_civicrm_enable().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_enable
 */
function trxnidcheck_civicrm_enable(): void {
  _trxnidcheck_civix_civicrm_enable();
}

// --- Functions below this ship commented out. Uncomment as required. ---

/**
 * Implements hook_civicrm_preProcess().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_preProcess
 */
//function trxnidcheck_civicrm_preProcess($formName, &$form): void {
//
//}

/**
 * Implements hook_civicrm_navigationMenu().
 *
 * @link https://docs.civicrm.org/dev/en/latest/hooks/hook_civicrm_navigationMenu
 */
//function trxnidcheck_civicrm_navigationMenu(&$menu): void {
//  _trxnidcheck_civix_insert_navigation_menu($menu, 'Mailings', [
//    'label' => E::ts('New subliminal message'),
//    'name' => 'mailing_subliminal_message',
//    'url' => 'civicrm/mailing/subliminal',
//    'permission' => 'access CiviMail',
//    'operator' => 'OR',
//    'separator' => 0,
//  ]);
//  _trxnidcheck_civix_navigationMenu($menu);
//}

/**
 * Implementation of hook_civicrm_check
 *
 * Add a check to the status page/System.check results if $snafu is TRUE.
 */
function trxnidcheck_civicrm_check(&$messages, $statusNames, $includeDisabled) {
  // Early return if $statusNames doesn't call for our check
  if ($statusNames && !in_array('trxnidcheck', $statusNames)) {
    return;
  }

  // If performing your check is resource-intensive, consider bypassing if disabled
  if (!$includeDisabled) {
    $disabled = \Civi\Api4\StatusPreference::get()
      ->setCheckPermissions(FALSE)
      ->addWhere('is_active', '=', FALSE)
      ->addWhere('domain_id', '=', 'current_domain')
      ->addWhere('name', '=', 'trxnidcheck')
      ->execute()->count();
    if ($disabled) {
      return;
    }
  }

  // Get any recurring contributions that have a transaction id that is not in the correct PayPal format.
  $PayPalFormat = 'I-%';
  $contributionRecurs = \Civi\Api4\ContributionRecur::get(FALSE)
    ->addSelect('id', 'contact_id', 'trxn_id')
    ->addWhere('trxn_id', 'NOT LIKE', $PayPalFormat)
    ->addWhere('create_date', '>', '2023-09-22')
    ->execute()
    ->first();
  $recurId = $contributionRecurs['id'];
  $recurContact = $contributionRecurs['contact_id'];
  
  if ($contributionRecurs['trxn_id']) {
    $messages[] = new CRM_Utils_Check_Message(
      'trxnidcheck',
      ts("The transaction ID for a recurring contribution (id: $recurId) for Contact $recurContact is in the wrong format."),
      ts('Transaction ID in wrong format'),
      \Psr\Log\LogLevel::WARNING,
      'fa-flag'
    );
  }
}