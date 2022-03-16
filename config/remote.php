<?php
return [
    'api_host' => env('API_REMOTE_HOST'),
    'request_weichat_scan_login_uri' => env('REQUEST_WEICHAT_SCAN_LOGIN_URI'),
    'send_mobile_code_uri' => env('SEND_MOBILE_CODE_URI'),
    'phone_login_uri' => env('PHONE_LOGIN_URI'),
    'get_user_by_openid_uri' => env('GET_USER_BY_OPENID_URI'),
    'bound_wechat_phone_uri' => env('BOUND_WECHAT_PHONE_URI'),
    'update_username_uri' => env('UPDATE_USERNAME_URI'),
    'get_user_info_uri' => env('GET_USER_INFO_URI'),
    'phone_bound_wechat_uri' => env('PHONE_BOUND_WECHAT_URI'),
    'get_order_qr_uri' => env('GET_ORDER_QR_URI'),
    'api_pay_host' => env('API_PAY_HOST')
];