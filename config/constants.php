<?php

define('ADMIN_EMAIL', 'abhiburk@gmail.com');
define('ADMIN_EMAILS', ['abhiburk@gmail.com', 'anbhagat1997@gmail.com']);
define('TELESCOPES_RIGHTS', [8446458443, 8308888056]);
define('ADMIN_MOBILE', 8446458443);
define('INR', '₹');

define('CALL_SERVICE', true);

define('MAX_WALLET_USAGE', 20);
define('REFERRAL_COMMISION', 15);
define('GENERATE_QR_ZIP', false);
define('RESELLER_COMMISION', 20);
define('MIN_RESELLER_QTY', 20);

// SHIPPING
define('IS_SHIPPING_APPLICABLE', true);
define('SHIPPING_CHARGE', +50);


// GST
define('IS_GST_APPLICABLE', true);
define('GST_CHARGE', '18%');

define('WHATSAPP_LINK', 'https://api.whatsapp.com/send?phone=+918669102959');
define('INSTAGRAM_LINK', 'https://www.instagram.com/ezesticker');
define('FACEBOOK_LINK', 'https://www.facebook.com/ezesticker');

// KALEYRA APIs
define('KALEYRA_API_KEY', 'Aee91d010456ce1578a68351734f39120');
define('BRIDGE_1', '2063116111');
define('CALL_PREFIX', 91);
define('CALL_RATE_LIMIT', 2); // for https://github.com/danharrin/livewire-rate-limiting
define('CALL_WALLET_DEPOSIT_AMT', 10);
define('CALL_MIN_BALANCE', 2); // must have minimum Rs2 in wallet to make a call
define('MIN_WALLET_TOPUP', 50);
define('IN_CALL_CHARGE', 0.66); // incoming call charges from kaleyra