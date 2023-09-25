# Transaction Id Check
A CiviCRM extension that checks the Transaction ID of recurring payments and returns a warning if they are not in the correct format (for PayPal)

## Requirements

* PHP v7.4+
* (developed on) CiviCRM 5.63.2

## Installation (Web UI)

Learn more about installing CiviCRM extensions in the [CiviCRM Sysadmin Guide](https://docs.civicrm.org/sysadmin/en/latest/customize/extensions/).

## Installation (CLI, Zip)

Sysadmins and developers may download the `.zip` file for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
cd <extension-dir>
cv dl trxnidcheck@https://github.com/FIXME/trxnidcheck/archive/master.zip
```
or
```bash
cd <extension-dir>
cv dl trxnidcheck@https://lab.civicrm.org/extensions/trxnidcheck/-/archive/main/trxnidcheck-main.zip
```

## Installation (CLI, Git)

Sysadmins and developers may clone the [Git](https://en.wikipedia.org/wiki/Git) repo for this extension and
install it with the command-line tool [cv](https://github.com/civicrm/cv).

```bash
git clone https://github.com/FIXME/trxnidcheck.git
cv en trxnidcheck
```
or
```bash
git clone https://lab.civicrm.org/extensions/trxnidcheck.git
cv en trxnidcheck
```
