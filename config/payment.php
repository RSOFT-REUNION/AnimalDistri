<?php

use Carbon\Carbon;

return [
    'redirect_url' => 'https://paiement.systempay.fr/vads-payment/',
    'key' => [
        'TEST' =>'bVolYMzIEPhkOnsB',
        'PRODUCTION' =>'fSzAMWXVRU1KA7ZH',
        ],
    'vads_fields' => [
        /** champs obligatoires **/
        'vads_action_mode' => 'INTERACTIVE',
        'vads_ctx_mode' => env('SYSTEMPAY_TEST_OR_PROD', 'TEST'),
        'vads_currency' => '978',
        'vads_page_action' => 'PAYMENT',
        'vads_payment_config' => 'SINGLE',
        'vads_site_id' => env('SYSTEMPAY_SITE_ID', '10868856'),
        'vads_trans_date' => Carbon::now('UTC')->format('YmdHis'),
        'vads_trans_id' => '',
        'vads_version' => 'V2',

        /** champs pour la redirection vers le site marchand **/
        // voir doc https://paiement.systempay.fr/doc/fr-FR/form-payment/reference/redirection-vers-le-site-marchand.html
        'vads_redirect_error_message' => 'Votre tentative de paiement a échoué, veuillez réessayer.',
        //'vads_redirect_error_timeout' => '',
        'vads_redirect_success_message' => 'Paiement validé. Merci pour votre achat!',
        'vads_redirect_success_timeout' => '10',
        // 'vads_return_mode' => '',
        'vads_url_cancel' => '', //  route('frontend.orders.failed')
        'vads_url_error' => '', //  route('frontend.orders.failed')
        'vads_url_refused' => '', //  route('frontend.orders.failed')
        'vads_url_success' => '', // route('frontend.orders.success')
    ]
];
