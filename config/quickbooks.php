<?php

return [
    'client_id' => env('QUICKBOOKS_CLIENT_ID'),
    'client_secret' => env('QUICKBOOKS_CLIENT_SECRET'),
    'redirect_uri' => env('QUICKBOOKS_REDIRECT_URI', env('APP_URL') . '/quickbooks/callback'),
    'baseUrl' => env('QUICKBOOKS_BASE_URL', 'https://appcenter.intuit.com/connect/oauth2'),
    'tokenUrl' => env('QUICKBOOKS_TOKEN_URL', 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer'),
    'scope' => 'com.intuit.quickbooks.accounting',
];
