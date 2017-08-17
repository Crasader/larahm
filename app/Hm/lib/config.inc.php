<?php

/*
 * This file is part of the entimm/hm.
 *
 * (c) entimm <entimm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

use Illuminate\Support\Facades\Cookie;

ini_set('error_reporting', 'E_ALL & ~E_NOTICE & ~E_DEPRECATED');

require 'function.inc.php';

if (!extension_loaded('gd')) {
    $prefix = (PHP_SHLIB_SUFFIX == 'dll' ? 'php_' : '');
    dl($prefix.'gd.'.PHP_SHLIB_SUFFIX);
}

app('data')->frm = request()->toArray();

app('data')->env = array_merge($_ENV, $_SERVER);
app('data')->env['HTTP_HOST'] = preg_replace('/^www\./', '', app('data')->env['HTTP_HOST']);

$referer = isset(app('data')->env['HTTP_REFERER']) ? app('data')->env['HTTP_REFERER'] : null;
$host = app('data')->env['HTTP_HOST'];
if (!strpos($referer, '//'.$host)) {
    Cookie::queue('came_from', $referer, 43200);
}

$transtype = [
    'withdraw_pending'             => 'Withdrawal request',
    'add_funds'                    => 'Transfer from external processings',
    'deposit'                      => 'Deposit',
    'bonus'                        => 'Bonus',
    'penality'                     => 'Penalty',
    'earning'                      => 'Earning',
    'withdrawal'                   => 'Withdrawal',
    'commissions'                  => 'Referral commission',
    'early_deposit_release'        => 'Deposit release',
    'early_deposit_charge'         => 'Commission for an early deposit release',
    'release_deposit'              => 'Deposit returned to user account',
    'exchange_out'                 => ' Received on exchange',
    'exchange_in'                  => 'Spent on exchange',
    'exchange'                     => 'Exchange',
    'internal_transaction_spend'   => 'Spent on Internal Transaction',
    'internal_transaction_receive' => 'Received from Internal Transaction',
];
app('data')->exchange_systems = [
    0  => ['name' => 'e-gold', 'sfx' => 'egold'],
    2  => ['name' => 'INTGold', 'sfx' => 'intgold'],
    3  => ['name' => 'PerfectMoney', 'sfx' => 'perfectmoney'],
    4  => ['name' => 'StormPay', 'sfx' => 'stormpay'],
    5  => ['name' => 'e-Bullion', 'sfx' => 'ebullion'],
    6  => ['name' => 'PayPal', 'sfx' => 'paypal'],
    7  => ['name' => 'GoldMoney', 'sfx' => 'goldmoney'],
    8  => ['name' => 'eeeCurrency', 'sfx' => 'eeecurrency'],
    9  => ['name' => 'Pecunix', 'sfx' => 'pecunix'],
    10 => ['name' => 'Payeer', 'sfx' => 'payeer'],
    11 => ['name' => 'BitCoin', 'sfx' => 'bitcoin'],
];

app('data')->settings = get_settings();
foreach (app('data')->exchange_systems as $id => $data) {
    if (isset(app('data')->settings['def_payee_account_'.$data['sfx']]) and app('data')->settings['def_payee_account_'.$data['sfx']] != '' and app('data')->settings['def_payee_account_'.$data['sfx']] != '0') {
        app('data')->exchange_systems[$id]['status'] = 1;
        continue;
    } else {
        app('data')->exchange_systems[$id]['status'] = 0;
        continue;
    }
}
app('data')->settings['site_url'] = (is_SSL() ? 'https://' : 'http://').$_SERVER['HTTP_HOST'];

$ip = app('data')->env['REMOTE_ADDR'];
$time = time();
$url = app('data')->env['REQUEST_URI'];
$agent = app('data')->env['HTTP_USER_AGENT'];
$ret = db_query("insert hm2_visit (`ip`, `time`, `url`, `agent`) values('$ip', '$time', '$url', '$agent')");
