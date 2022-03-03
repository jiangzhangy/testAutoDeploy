<?php
return [
    'api_host' => env('API_REMOTE_HOST'),
    'request_weichat_scan_login_uri' => env('REQUEST_WEICHAT_SCAN_LOGIN_URI'),
    'send_mobile_code_uri' => env('SEND_MOBILE_CODE_URI'),
    'phone_login_uri' => env('PHONE_LOGIN_URI'),
    'get_user_by_openid_uri' => env('GET_USER_BY_OPENID_URI'),
    'bound_wechat_phone_uri' => env('BOUND_WECHAT_PHONE_URI'),
];