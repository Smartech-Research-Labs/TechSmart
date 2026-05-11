<?php

app('router')->setCompiledRoutes(
    array (
  'compiled' => 
  array (
    0 => false,
    1 => 
    array (
      '/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'login.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'logout',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/forgot-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.request',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.email',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/reset-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.update',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'register',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'register.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.notice',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/email/verification-notification' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.send',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/confirm-password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirm.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/confirmed-password-status' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.confirmation',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/two-factor-challenge' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.login',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.login.store',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/two-factor-authentication' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.enable',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.disable',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/confirmed-two-factor-authentication' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.confirm',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/two-factor-qr-code' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.qr-code',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/two-factor-secret-key' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.secret-key',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/user/two-factor-recovery-codes' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.recovery-codes',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'two-factor.regenerate-recovery-codes',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/sanctum/csrf-cookie' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'sanctum.csrf-cookie',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/login' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AiNJ8N9NsaBUv53M',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/register' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gnf52wX69QF16z5m',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/2fa/verify' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::q4vNupmhMBvX6jsm',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/2fa/resend' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VWN1WdJWIO8Hvm2c',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/google/redirect' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::H1RWxaYvEVEYTj2b',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/google/callback' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fSnGUEWFvuwzE8o2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/user' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NxdKe4KGg9Ykq2cZ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/logout' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::RCCS46wbg7RGyKZi',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/auth/2fa/toggle' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::w4FQNjy5uv8mRnHi',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/home' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::aNpfjHsvwEBIHvfI',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/home/faqs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::74JE9JP3G89hk5sh',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/home/team' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AQgQ1Gh9nwvG1BtK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/home/map-data' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::rIxiBYyNbQiJduSC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/services' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1FJ29GxxqAgIIzpx',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::S4vEGiEQxgoE1Pfi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/products/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::JN17JGfaKip923Mw',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/bundles' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::82ujxFuEEr0TkcVO',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/faqs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cC7sSlQsj0D2Wvbp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/faqs/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5ouiuNrLgwACb0dX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::mOvYYCQkciMc6a0I',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/enquiries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::n4fEKhzHQiFHUa8U',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/newsletter/subscribe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EZk6HkIC1j0ueKgU',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/newsletter/unsubscribe' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yGoejLChQ2FRfyb8',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/blogs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::a340kwA0axGR8Q1X',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/blogs/categories' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hzj1q064maK2pDWY',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/case-studies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2ns3Wx6hOQCPAjcP',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/industries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::R3xSCMOvVQ2vc49O',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::E8r1NnnCB3qaIoSF',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/dashboard' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tYXWGs2N3xTT6Cf9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/enquiries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tXB8A1K9ngeyt2Hi',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::r9rkeN9xmlsJwl5R',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/profile' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MWE6ptHo5xwbb1bd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lLkKrU2Z1qs19MST',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/password' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::61OFbdYUFlyLWQYV',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/profile/full' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::z86sBh1LIPfFApCC',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Z7uIovKi4wPtH8mf',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/profile/avatar' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3Q01HXoxOXMntL4o',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::e5p4VWIQrYy09Kjx',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/profile/sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vWNn3k0l4AkPUKH6',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/profile/activity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qdLwSPKFnMqTie2E',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/wishlist' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WSEktYrUG4fkJhlu',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qfJuk8XZRcKe3DlP',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/chat/sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wVD8knukEWbdDO8o',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/chat/messages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::cFdbLOC7uRwYblBw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/dm/conversations' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qWQgnuIsk9MvoVvd',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/dm/send' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5hxhPh6K691D1cuL',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/dm/users/online' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MNKpexYmUAxHQUkQ',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/user/dm/presence' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fiuGs0k1gdTROm8l',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/generate-content' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Gc97NXWozsNOruV7',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/generate-seo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YpFawI42fM53gtds',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/analyze-sentiment' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dKr8i64ubWtHuJ2d',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/chatbot' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gDA3crbA4vH6GDnQ',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/generate-steps' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::pbAIBXVAnKwe3OMM',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/ai/improve-text' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::KjqWswrHg1Xuud9H',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/sliders' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hnSdlXH46b3QXa4p',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::CdSRvj2ALIPoAZ81',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/cms/services' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8cShwgz5afd4oyWa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::wAnSaHHrEP7OGXHz',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/cms/products' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nZj6N7CaxEa3negc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nsaoaaMBrJWyXnf5',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/cms/clients' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::m5lBdsjYNhjRbuyV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ptyp83zEDbhoQdnu',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/cms/counters' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::l8tMa7nPQlkDhpgK',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lXHx1XZo4Omh91NP',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/settings' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NweVDwoQEvr4FFqc',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::olM92cEoLQfcxmmj',
          ),
          1 => NULL,
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/settings/logo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::whUtJcHJAfPhPxBw',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/settings/footer-logo' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iKONPGVZbTQfne89',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/settings/favicon' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x9Jm5uhT50z24WZv',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/media' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::TH8YnJ0qNLyTlTHf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::oiGS8lDvOOvoIOdi',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/media/upload' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::WTmXng16AS1eYaao',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/media/upload-multiple' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ceO5re9ARZGVv6nq',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/media/delete-multiple' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::j3vptzmf0KeBDPBx',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/blogs' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GvbwT3iAfoTRRrKs',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::iztBwE9Qnb3lLKDt',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/pages' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2sgknKsskcHQWR8B',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x8LmfIBWlzQrhKlO',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/dashboard/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::EN29NpjGWmJlClJL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/dashboard/activity' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Wz55xjvwJQKhqWLX',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/dashboard/overview' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::XdSsYEybxzBWzedk',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/search' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2GHeI5yugXEJ36tN',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/search/suggestions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hga0vItbLodc62mp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/notifications' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::c3mTLLV6ZMGhBLG5',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::R5bCW0PqXRSzOIw8',
          ),
          1 => NULL,
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/notifications/read-all' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::FkcRpSnApfEBEhuW',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/reviews' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ta1sdt8GskYVoKEa',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/reviews/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::QpVqvV7x6U9lNPY9',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/enquiries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MzOiKbnYgvld6kOp',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/enquiries/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ubWH5q7pdqwJvSXL',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/bundles' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PyKuX5ajYd5RNog8',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::lUAlOPwqkFSw0vkC',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/chat/sessions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dzo7FoRwLgw3iA8h',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/chat/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::gSRhDdgywAgBhFxH',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/chat/metrics' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::x2vWTCpWUE8jaGz2',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/case-studies' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::fCluwzHHIaWFPp7P',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::YtxcAZBUteTJ4XR0',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/industries' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2y2Q5alMI0kWHP1a',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ViM76e8xDEWyenMD',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/users' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kgE1jwttqnMUdogV',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NjPO6RlLu6nq0081',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/users/stats' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::3GyDAEkbWfFwrPv4',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/roles' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::qPaulECJRlNan6az',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::f8fo6vk1DYt1Wkd0',
          ),
          1 => NULL,
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/api/v1/admin/permissions' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8ZboI2DRnvXdKQ82',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      '/up' => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::xWjzfKYvlzTKoXYf',
          ),
          1 => NULL,
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
    ),
    2 => 
    array (
      0 => '{^(?|/reset\\-password/([^/]++)(*:32)|/email/verify/([^/]++)/([^/]++)(*:70)|/api/v1/(?|services/(?|category/([^/]++)(*:117)|([^/]++)(*:133))|p(?|roducts/([^/]++)(*:162)|ages/([^/]++)(*:183))|b(?|undles/([^/]++)(*:211)|logs/([^/]++)(*:232))|reviews/([^/]++)/([^/]++)(*:266)|case\\-studies/([^/]++)(*:296)|industries/([^/]++)(*:323)|user/(?|wishlist/([^/]++)(*:356)|chat/sessions/([^/]++)/messages(*:395)|dm/conversations/([^/]++)/(?|messages(*:440)|read(*:452)))|admin/(?|s(?|liders/([^/]++)(?|(*:493))|ections/([^/]++)(?|(*:521)))|c(?|ms/(?|services/([^/]++)(?|(*:561))|products/([^/]++)(?|(*:590))|c(?|lients/([^/]++)(?|(*:621))|ounters/([^/]++)(?|(*:649))))|hat/sessions/([^/]++)/(?|messages(*:693)|reply(*:706)|close(*:719))|ase\\-studies/([^/]++)(?|(*:752)))|b(?|logs/([^/]++)(?|(*:782))|undles/([^/]++)(?|(*:809)))|pages/([^/]++)(?|(*:836)|/(?|sections(*:856)|reorder(*:871)))|notifications/([^/]++)(?|/(?|read(*:914)|unread(*:928))|(*:937))|r(?|eviews/([^/]++)(?|(*:968)|/(?|approve(*:987)|reject(*:1001))|(*:1011))|oles/([^/]++)(?|(*:1037)))|enquiries/([^/]++)(?|(*:1069)|/reply(*:1084)|(*:1093))|industries/([^/]++)(?|(*:1125))|users/([^/]++)(?|(*:1152))|trash/([^/]++)(?|(*:1179)|/(?|([^/]++)(?|/restore(*:1211)|(*:1220))|restore\\-all(*:1242)))))|/(.*)(*:1260)|/storage/(.*)(?|(*:1285)))/?$}sDu',
    ),
    3 => 
    array (
      32 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'password.reset',
          ),
          1 => 
          array (
            0 => 'token',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      70 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'verification.verify',
          ),
          1 => 
          array (
            0 => 'id',
            1 => 'hash',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      117 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::eN9IsRPDv8wIJpiy',
          ),
          1 => 
          array (
            0 => 'category',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      133 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::txvANsOvLfVxZl6V',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      162 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Lx8F3BGyptRqFtBU',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      183 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Q3jGMAA7c3vtLhHH',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      211 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::vv9O4MHU02nlmgP8',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      232 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::F8FtkrVXUyTa2xf7',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      266 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::azR9FifgDEmrsfit',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      296 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NeqhhZ8QUWO0wfK8',
          ),
          1 => 
          array (
            0 => 'slug',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      323 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::IjnGxR8AkhXLS38S',
          ),
          1 => 
          array (
            0 => 'industry',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      356 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Z9FUSo9w0CiVnMCc',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      395 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::8Wq3ty9ss4yXJY4n',
          ),
          1 => 
          array (
            0 => 'sessionId',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      440 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::7qK3hUFWHVfKUT2U',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      452 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PL3fZ0gEutHEqcvK',
          ),
          1 => 
          array (
            0 => 'conversation',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      493 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dbT2t1V4ZZREiTgy',
          ),
          1 => 
          array (
            0 => 'slider',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::yKZxcbtFwTHYpPUj',
          ),
          1 => 
          array (
            0 => 'slider',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      521 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HQquHIrDwKRh6oAw',
          ),
          1 => 
          array (
            0 => 'section',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Uh87KoeEmnTsPF1B',
          ),
          1 => 
          array (
            0 => 'section',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      561 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::D7PeosZV4Zl8hP2F',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::s8SBqWoBVqRypSdK',
          ),
          1 => 
          array (
            0 => 'service',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      590 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::kUoxeQiN7X1mGhjL',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HIKfQuDRjDmWYGm7',
          ),
          1 => 
          array (
            0 => 'product',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      621 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jyoHN5wb5nhm8R0t',
          ),
          1 => 
          array (
            0 => 'client',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::J0BBqsgWTM91Qnm3',
          ),
          1 => 
          array (
            0 => 'client',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      649 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tXjCKWKbXIUZduFq',
          ),
          1 => 
          array (
            0 => 'counter',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::o2bzW336unlgv4Dp',
          ),
          1 => 
          array (
            0 => 'counter',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      693 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1F3LrH1Y6OZj1qP0',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      706 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::E3Pa7jko6XdtGeyc',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      719 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::o4Hb72SHCd2yMyTR',
          ),
          1 => 
          array (
            0 => 'session',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      752 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Gp7X547q8MLtkgBy',
          ),
          1 => 
          array (
            0 => 'caseStudy',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NCsDvcl6IXIMsqYm',
          ),
          1 => 
          array (
            0 => 'caseStudy',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DM5oEK1892S7bs4N',
          ),
          1 => 
          array (
            0 => 'caseStudy',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      782 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::Fb704TCJp4FzTIYI',
          ),
          1 => 
          array (
            0 => 'blog',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::jXtQhhOmNrSO1KQo',
          ),
          1 => 
          array (
            0 => 'blog',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::5iDHgmPlvarpoVcT',
          ),
          1 => 
          array (
            0 => 'blog',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      809 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::v3qNwyXiJpXLk4ZU',
          ),
          1 => 
          array (
            0 => 'bundle',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::2VYuAR9x0yiYRJku',
          ),
          1 => 
          array (
            0 => 'bundle',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      836 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nHVOLIWUoD7Xkxyr',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::6WeeM223l73ygtKb',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::NnMEyss0BwbnbqdH',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      856 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::R0gRR0IIoWQhH1cq',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      871 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::1vvZzmmtHOAne6W9',
          ),
          1 => 
          array (
            0 => 'page',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      914 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::tQ6OyiqU2eeaT78s',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      928 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::96VgNKJkRPCyF5Qd',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      937 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::hWbwDcVP6IM2VUQY',
          ),
          1 => 
          array (
            0 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      968 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bClaKsrojGhOjEc4',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      987 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::DaxcgF8xE1JWCHEr',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1001 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::PNKDIGcFBV9ZZcg0',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1011 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GY9lweiILB9fcZqU',
          ),
          1 => 
          array (
            0 => 'review',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1037 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::bktTnX4v8tyYUk3X',
          ),
          1 => 
          array (
            0 => 'role',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::58QDnPbk6FQiOyE0',
          ),
          1 => 
          array (
            0 => 'role',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1069 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::w1cc2L7uGq8xHdbZ',
          ),
          1 => 
          array (
            0 => 'enquiry',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::ttJsF9N9M9OOETqt',
          ),
          1 => 
          array (
            0 => 'enquiry',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1084 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::MVUgqP5hPkPaQHFq',
          ),
          1 => 
          array (
            0 => 'enquiry',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1093 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::HBvjXQ1PUs1Ff5J7',
          ),
          1 => 
          array (
            0 => 'enquiry',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1125 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::nZIvVnGHuvjDABob',
          ),
          1 => 
          array (
            0 => 'industry',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GUl3gczkP3GJtncN',
          ),
          1 => 
          array (
            0 => 'industry',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => 
          array (
            '_route' => 'generated::12fcchhcwl1cy6x0',
          ),
          1 => 
          array (
            0 => 'industry',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1152 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::VG4EljeHTvctxkGd',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'generated::dgBa5mI4T6FEg04L',
          ),
          1 => 
          array (
            0 => 'user',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1179 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AcBfLK4VGVX21sDh',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1211 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::AhLTXfFjnnHuUfm9',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1220 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::k2Tnl2OWYgQhbDRu',
          ),
          1 => 
          array (
            0 => 'type',
            1 => 'id',
          ),
          2 => 
          array (
            'DELETE' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1242 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::GTe2UC4wiXIDirQi',
          ),
          1 => 
          array (
            0 => 'type',
          ),
          2 => 
          array (
            'POST' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => false,
          6 => NULL,
        ),
      ),
      1260 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'generated::c4nZpinZ4RkEn1I6',
          ),
          1 => 
          array (
            0 => 'any',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
      ),
      1285 => 
      array (
        0 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'GET' => 0,
            'HEAD' => 1,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        1 => 
        array (
          0 => 
          array (
            '_route' => 'storage.local.upload',
          ),
          1 => 
          array (
            0 => 'path',
          ),
          2 => 
          array (
            'PUT' => 0,
          ),
          3 => NULL,
          4 => false,
          5 => true,
          6 => NULL,
        ),
        2 => 
        array (
          0 => NULL,
          1 => NULL,
          2 => NULL,
          3 => NULL,
          4 => false,
          5 => false,
          6 => 0,
        ),
      ),
    ),
    4 => NULL,
  ),
  'attributes' => 
  array (
    'login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@create',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@create',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'login.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'login',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
          2 => 'throttle:login',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'login.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'logout' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'logout',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@destroy',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\AuthenticatedSessionController@destroy',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'logout',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.request' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\PasswordResetLinkController@create',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\PasswordResetLinkController@create',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.request',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.reset' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'reset-password/{token}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\NewPasswordController@create',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\NewPasswordController@create',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.reset',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.email' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'forgot-password',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\PasswordResetLinkController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\PasswordResetLinkController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.email',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.update' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'reset-password',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\NewPasswordController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\NewPasswordController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.update',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\RegisteredUserController@create',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\RegisteredUserController@create',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'register.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'register',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\RegisteredUserController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\RegisteredUserController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'register.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.notice' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/verify',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\EmailVerificationPromptController@__invoke',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\EmailVerificationPromptController@__invoke',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.notice',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.verify' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'email/verify/{id}/{hash}',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'signed',
          3 => 'throttle:6,1',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\VerifyEmailController@__invoke',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\VerifyEmailController@__invoke',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.verify',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'verification.send' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'email/verification-notification',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'throttle:6,1',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\EmailVerificationNotificationController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\EmailVerificationNotificationController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'verification.send',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/confirm-password',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmablePasswordController@show',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmablePasswordController@show',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirmation' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/confirmed-password-status',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmedPasswordStatusController@show',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmedPasswordStatusController@show',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirmation',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'password.confirm.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/confirm-password',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmablePasswordController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmablePasswordController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'password.confirm.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.login' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'two-factor-challenge',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticatedSessionController@create',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticatedSessionController@create',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.login',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.login.store' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'two-factor-challenge',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'guest:web',
          2 => 'throttle:two-factor',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticatedSessionController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticatedSessionController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.login.store',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.enable' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/two-factor-authentication',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticationController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticationController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.enable',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.confirm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/confirmed-two-factor-authentication',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmedTwoFactorAuthenticationController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\ConfirmedTwoFactorAuthenticationController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.confirm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.disable' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'user/two-factor-authentication',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticationController@destroy',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorAuthenticationController@destroy',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.disable',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.qr-code' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/two-factor-qr-code',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorQrCodeController@show',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorQrCodeController@show',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.qr-code',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.secret-key' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/two-factor-secret-key',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorSecretKeyController@show',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\TwoFactorSecretKeyController@show',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.secret-key',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.recovery-codes' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'user/two-factor-recovery-codes',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\RecoveryCodeController@index',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\RecoveryCodeController@index',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.recovery-codes',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'two-factor.regenerate-recovery-codes' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'user/two-factor-recovery-codes',
      'action' => 
      array (
        'domain' => NULL,
        'middleware' => 
        array (
          0 => 'web',
          1 => 'auth:web',
          2 => 'password.confirm',
        ),
        'uses' => 'Laravel\\Fortify\\Http\\Controllers\\RecoveryCodeController@store',
        'controller' => 'Laravel\\Fortify\\Http\\Controllers\\RecoveryCodeController@store',
        'namespace' => 'Laravel\\Fortify\\Http\\Controllers',
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'two-factor.regenerate-recovery-codes',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'sanctum.csrf-cookie' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'sanctum/csrf-cookie',
      'action' => 
      array (
        'uses' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'controller' => 'Laravel\\Sanctum\\Http\\Controllers\\CsrfCookieController@show',
        'namespace' => NULL,
        'prefix' => 'sanctum',
        'where' => 
        array (
        ),
        'middleware' => 
        array (
          0 => 'web',
        ),
        'as' => 'sanctum.csrf-cookie',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AiNJ8N9NsaBUv53M' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/login',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@login',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::AiNJ8N9NsaBUv53M',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gnf52wX69QF16z5m' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/register',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@register',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::gnf52wX69QF16z5m',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::q4vNupmhMBvX6jsm' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/2fa/verify',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@verifyTwoFactorEmail',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@verifyTwoFactorEmail',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::q4vNupmhMBvX6jsm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VWN1WdJWIO8Hvm2c' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/2fa/resend',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@resendTwoFactorEmail',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@resendTwoFactorEmail',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::VWN1WdJWIO8Hvm2c',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::H1RWxaYvEVEYTj2b' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/auth/google/redirect',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SocialAuthController@redirectToGoogle',
        'controller' => 'App\\Http\\Controllers\\Api\\SocialAuthController@redirectToGoogle',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::H1RWxaYvEVEYTj2b',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fSnGUEWFvuwzE8o2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/auth/google/callback',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\SocialAuthController@handleGoogleCallback',
        'controller' => 'App\\Http\\Controllers\\Api\\SocialAuthController@handleGoogleCallback',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::fSnGUEWFvuwzE8o2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NxdKe4KGg9Ykq2cZ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/auth/user',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@user',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@user',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::NxdKe4KGg9Ykq2cZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::RCCS46wbg7RGyKZi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/logout',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@logout',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::RCCS46wbg7RGyKZi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::w4FQNjy5uv8mRnHi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/auth/2fa/toggle',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AuthController@toggleTwoFactorEmail',
        'controller' => 'App\\Http\\Controllers\\Api\\AuthController@toggleTwoFactorEmail',
        'namespace' => NULL,
        'prefix' => 'api/v1/auth',
        'where' => 
        array (
        ),
        'as' => 'generated::w4FQNjy5uv8mRnHi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::aNpfjHsvwEBIHvfI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/home',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\HomeController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\HomeController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::aNpfjHsvwEBIHvfI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::74JE9JP3G89hk5sh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/home/faqs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\HomeController@faqs',
        'controller' => 'App\\Http\\Controllers\\Api\\HomeController@faqs',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::74JE9JP3G89hk5sh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AQgQ1Gh9nwvG1BtK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/home/team',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\HomeController@team',
        'controller' => 'App\\Http\\Controllers\\Api\\HomeController@team',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::AQgQ1Gh9nwvG1BtK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::rIxiBYyNbQiJduSC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/home/map-data',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\HomeController@mapData',
        'controller' => 'App\\Http\\Controllers\\Api\\HomeController@mapData',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::rIxiBYyNbQiJduSC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1FJ29GxxqAgIIzpx' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ServiceController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\ServiceController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::1FJ29GxxqAgIIzpx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::eN9IsRPDv8wIJpiy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/services/category/{category}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ServiceController@byCategory',
        'controller' => 'App\\Http\\Controllers\\Api\\ServiceController@byCategory',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::eN9IsRPDv8wIJpiy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::txvANsOvLfVxZl6V' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/services/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ServiceController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\ServiceController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::txvANsOvLfVxZl6V',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::S4vEGiEQxgoE1Pfi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::S4vEGiEQxgoE1Pfi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::JN17JGfaKip923Mw' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@categories',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@categories',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::JN17JGfaKip923Mw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Lx8F3BGyptRqFtBU' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/products/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ProductController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\ProductController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Lx8F3BGyptRqFtBU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::82ujxFuEEr0TkcVO' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bundles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BundleController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\BundleController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::82ujxFuEEr0TkcVO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vv9O4MHU02nlmgP8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/bundles/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BundleController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\BundleController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::vv9O4MHU02nlmgP8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cC7sSlQsj0D2Wvbp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/faqs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\FaqController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\FaqController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::cC7sSlQsj0D2Wvbp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5ouiuNrLgwACb0dX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/faqs/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\FaqController@search',
        'controller' => 'App\\Http\\Controllers\\Api\\FaqController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::5ouiuNrLgwACb0dX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::azR9FifgDEmrsfit' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/reviews/{type}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::azR9FifgDEmrsfit',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::mOvYYCQkciMc6a0I' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\ReviewController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\ReviewController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::mOvYYCQkciMc6a0I',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::n4fEKhzHQiFHUa8U' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/enquiries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\EnquiryController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\EnquiryController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::n4fEKhzHQiFHUa8U',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EZk6HkIC1j0ueKgU' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/newsletter/subscribe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\NewsletterController@subscribe',
        'controller' => 'App\\Http\\Controllers\\Api\\NewsletterController@subscribe',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::EZk6HkIC1j0ueKgU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yGoejLChQ2FRfyb8' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/newsletter/unsubscribe',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\NewsletterController@unsubscribe',
        'controller' => 'App\\Http\\Controllers\\Api\\NewsletterController@unsubscribe',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::yGoejLChQ2FRfyb8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::a340kwA0axGR8Q1X' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/blogs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BlogController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\BlogController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::a340kwA0axGR8Q1X',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hzj1q064maK2pDWY' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/blogs/categories',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BlogController@categories',
        'controller' => 'App\\Http\\Controllers\\Api\\BlogController@categories',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::hzj1q064maK2pDWY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::F8FtkrVXUyTa2xf7' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/blogs/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\BlogController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\BlogController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::F8FtkrVXUyTa2xf7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2ns3Wx6hOQCPAjcP' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/case-studies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CaseStudyController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\CaseStudyController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::2ns3Wx6hOQCPAjcP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NeqhhZ8QUWO0wfK8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/case-studies/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\CaseStudyController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\CaseStudyController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::NeqhhZ8QUWO0wfK8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::R3xSCMOvVQ2vc49O' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/industries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\IndustryController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\IndustryController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::R3xSCMOvVQ2vc49O',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::IjnGxR8AkhXLS38S' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/industries/{industry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\IndustryController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\IndustryController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::IjnGxR8AkhXLS38S',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::E8r1NnnCB3qaIoSF' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@publicSettings',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@publicSettings',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::E8r1NnnCB3qaIoSF',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Q3jGMAA7c3vtLhHH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/pages/{slug}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@showBySlug',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@showBySlug',
        'namespace' => NULL,
        'prefix' => 'api/v1',
        'where' => 
        array (
        ),
        'as' => 'generated::Q3jGMAA7c3vtLhHH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tYXWGs2N3xTT6Cf9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/dashboard',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::tYXWGs2N3xTT6Cf9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tXB8A1K9ngeyt2Hi' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/enquiries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@enquiries',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@enquiries',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::tXB8A1K9ngeyt2Hi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::r9rkeN9xmlsJwl5R' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@reviews',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@reviews',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::r9rkeN9xmlsJwl5R',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MWE6ptHo5xwbb1bd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@profile',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@profile',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::MWE6ptHo5xwbb1bd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lLkKrU2Z1qs19MST' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/user/profile',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@profile',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@profile',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::lLkKrU2Z1qs19MST',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::61OFbdYUFlyLWQYV' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/user/password',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@changePassword',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DashboardController@changePassword',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::61OFbdYUFlyLWQYV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::z86sBh1LIPfFApCC' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/profile/full',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::z86sBh1LIPfFApCC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Z7uIovKi4wPtH8mf' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/user/profile/full',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::Z7uIovKi4wPtH8mf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3Q01HXoxOXMntL4o' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/profile/avatar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@uploadAvatar',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@uploadAvatar',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::3Q01HXoxOXMntL4o',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::e5p4VWIQrYy09Kjx' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/user/profile/avatar',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@removeAvatar',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@removeAvatar',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::e5p4VWIQrYy09Kjx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::vWNn3k0l4AkPUKH6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/profile/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@sessions',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@sessions',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::vWNn3k0l4AkPUKH6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qdLwSPKFnMqTie2E' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/profile/activity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@activityLog',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ProfileController@activityLog',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::qdLwSPKFnMqTie2E',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WSEktYrUG4fkJhlu' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/wishlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::WSEktYrUG4fkJhlu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qfJuk8XZRcKe3DlP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/wishlist',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::qfJuk8XZRcKe3DlP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Z9FUSo9w0CiVnMCc' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/user/wishlist/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\WishlistController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::Z9FUSo9w0CiVnMCc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wVD8knukEWbdDO8o' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/chat/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ChatController@sessions',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ChatController@sessions',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::wVD8knukEWbdDO8o',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::cFdbLOC7uRwYblBw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/chat/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ChatController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ChatController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::cFdbLOC7uRwYblBw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8Wq3ty9ss4yXJY4n' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/chat/sessions/{sessionId}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\ChatController@messages',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\ChatController@messages',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::8Wq3ty9ss4yXJY4n',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qWQgnuIsk9MvoVvd' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/dm/conversations',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@conversations',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@conversations',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::qWQgnuIsk9MvoVvd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::7qK3hUFWHVfKUT2U' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/dm/conversations/{conversation}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@messages',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@messages',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::7qK3hUFWHVfKUT2U',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5hxhPh6K691D1cuL' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/dm/send',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@send',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@send',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::5hxhPh6K691D1cuL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PL3fZ0gEutHEqcvK' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/dm/conversations/{conversation}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@markRead',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@markRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::PL3fZ0gEutHEqcvK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MNKpexYmUAxHQUkQ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/user/dm/users/online',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@onlineUsers',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@onlineUsers',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::MNKpexYmUAxHQUkQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fiuGs0k1gdTROm8l' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/user/dm/presence',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@updatePresence',
        'controller' => 'App\\Http\\Controllers\\Api\\User\\DirectMessageController@updatePresence',
        'namespace' => NULL,
        'prefix' => 'api/v1/user',
        'where' => 
        array (
        ),
        'as' => 'generated::fiuGs0k1gdTROm8l',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Gc97NXWozsNOruV7' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/generate-content',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@generateContent',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@generateContent',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Gc97NXWozsNOruV7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YpFawI42fM53gtds' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/generate-seo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@generateSEO',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@generateSEO',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::YpFawI42fM53gtds',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dKr8i64ubWtHuJ2d' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/analyze-sentiment',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@analyzeSentiment',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@analyzeSentiment',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::dKr8i64ubWtHuJ2d',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gDA3crbA4vH6GDnQ' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/chatbot',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@chatbot',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@chatbot',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::gDA3crbA4vH6GDnQ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::pbAIBXVAnKwe3OMM' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/generate-steps',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@generateSteps',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@generateSteps',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::pbAIBXVAnKwe3OMM',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::KjqWswrHg1Xuud9H' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/ai/improve-text',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\AIController@improveText',
        'controller' => 'App\\Http\\Controllers\\Api\\AIController@improveText',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::KjqWswrHg1Xuud9H',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hnSdlXH46b3QXa4p' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/sliders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@sliders',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@sliders',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::hnSdlXH46b3QXa4p',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::CdSRvj2ALIPoAZ81' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/sliders',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeSlider',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeSlider',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::CdSRvj2ALIPoAZ81',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dbT2t1V4ZZREiTgy' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/sliders/{slider}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateSlider',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateSlider',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::dbT2t1V4ZZREiTgy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::yKZxcbtFwTHYpPUj' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/sliders/{slider}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroySlider',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroySlider',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::yKZxcbtFwTHYpPUj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8cShwgz5afd4oyWa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/cms/services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@services',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@services',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::8cShwgz5afd4oyWa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::wAnSaHHrEP7OGXHz' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/cms/services',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeService',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeService',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::wAnSaHHrEP7OGXHz',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::D7PeosZV4Zl8hP2F' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/cms/services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateService',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateService',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::D7PeosZV4Zl8hP2F',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::s8SBqWoBVqRypSdK' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/cms/services/{service}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyService',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyService',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::s8SBqWoBVqRypSdK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nZj6N7CaxEa3negc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/cms/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@products',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@products',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::nZj6N7CaxEa3negc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nsaoaaMBrJWyXnf5' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/cms/products',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeProduct',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeProduct',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::nsaoaaMBrJWyXnf5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kUoxeQiN7X1mGhjL' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/cms/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateProduct',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateProduct',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::kUoxeQiN7X1mGhjL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HIKfQuDRjDmWYGm7' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/cms/products/{product}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyProduct',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyProduct',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::HIKfQuDRjDmWYGm7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::m5lBdsjYNhjRbuyV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/cms/clients',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@clients',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@clients',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::m5lBdsjYNhjRbuyV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ptyp83zEDbhoQdnu' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/cms/clients',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeClient',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeClient',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ptyp83zEDbhoQdnu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jyoHN5wb5nhm8R0t' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/cms/clients/{client}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateClient',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateClient',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::jyoHN5wb5nhm8R0t',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::J0BBqsgWTM91Qnm3' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/cms/clients/{client}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyClient',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyClient',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::J0BBqsgWTM91Qnm3',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::l8tMa7nPQlkDhpgK' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/cms/counters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@counters',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@counters',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::l8tMa7nPQlkDhpgK',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lXHx1XZo4Omh91NP' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/cms/counters',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeCounter',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@storeCounter',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::lXHx1XZo4Omh91NP',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tXjCKWKbXIUZduFq' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/cms/counters/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateCounter',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@updateCounter',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::tXjCKWKbXIUZduFq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::o2bzW336unlgv4Dp' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/cms/counters/{counter}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyCounter',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\CMSController@destroyCounter',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::o2bzW336unlgv4Dp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NweVDwoQEvr4FFqc' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::NweVDwoQEvr4FFqc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::olM92cEoLQfcxmmj' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/settings',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::olM92cEoLQfcxmmj',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::whUtJcHJAfPhPxBw' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/settings/logo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadLogo',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadLogo',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::whUtJcHJAfPhPxBw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iKONPGVZbTQfne89' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/settings/footer-logo',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadFooterLogo',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadFooterLogo',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::iKONPGVZbTQfne89',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x9Jm5uhT50z24WZv' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/settings/favicon',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadFavicon',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SettingController@uploadFavicon',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::x9Jm5uhT50z24WZv',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::TH8YnJ0qNLyTlTHf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::TH8YnJ0qNLyTlTHf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::WTmXng16AS1eYaao' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/media/upload',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@upload',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@upload',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::WTmXng16AS1eYaao',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ceO5re9ARZGVv6nq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/media/upload-multiple',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@uploadMultiple',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@uploadMultiple',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ceO5re9ARZGVv6nq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::oiGS8lDvOOvoIOdi' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/media',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::oiGS8lDvOOvoIOdi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::j3vptzmf0KeBDPBx' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/media/delete-multiple',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@destroyMultiple',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\MediaController@destroyMultiple',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::j3vptzmf0KeBDPBx',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GvbwT3iAfoTRRrKs' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/blogs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::GvbwT3iAfoTRRrKs',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::iztBwE9Qnb3lLKDt' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/blogs',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::iztBwE9Qnb3lLKDt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Fb704TCJp4FzTIYI' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/blogs/{blog}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Fb704TCJp4FzTIYI',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::jXtQhhOmNrSO1KQo' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/blogs/{blog}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::jXtQhhOmNrSO1KQo',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::5iDHgmPlvarpoVcT' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/blogs/{blog}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\BlogController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::5iDHgmPlvarpoVcT',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2sgknKsskcHQWR8B' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::2sgknKsskcHQWR8B',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x8LmfIBWlzQrhKlO' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/pages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::x8LmfIBWlzQrhKlO',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nHVOLIWUoD7Xkxyr' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/pages/{page}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::nHVOLIWUoD7Xkxyr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::6WeeM223l73ygtKb' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/pages/{page}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::6WeeM223l73ygtKb',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NnMEyss0BwbnbqdH' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/pages/{page}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::NnMEyss0BwbnbqdH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::R0gRR0IIoWQhH1cq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/pages/{page}/sections',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@addSection',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@addSection',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::R0gRR0IIoWQhH1cq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HQquHIrDwKRh6oAw' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/sections/{section}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@updateSection',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@updateSection',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::HQquHIrDwKRh6oAw',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Uh87KoeEmnTsPF1B' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/sections/{section}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@destroySection',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@destroySection',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Uh87KoeEmnTsPF1B',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1vvZzmmtHOAne6W9' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/pages/{page}/reorder',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@reorderSections',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\PageController@reorderSections',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::1vvZzmmtHOAne6W9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::EN29NpjGWmJlClJL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/dashboard/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@stats',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::EN29NpjGWmJlClJL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Wz55xjvwJQKhqWLX' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/dashboard/activity',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@recentActivity',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@recentActivity',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Wz55xjvwJQKhqWLX',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::XdSsYEybxzBWzedk' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/dashboard/overview',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@overview',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@overview',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::XdSsYEybxzBWzedk',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2GHeI5yugXEJ36tN' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/search',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SearchController@search',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SearchController@search',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::2GHeI5yugXEJ36tN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hga0vItbLodc62mp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/search/suggestions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\SearchController@suggestions',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\SearchController@suggestions',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::hga0vItbLodc62mp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::c3mTLLV6ZMGhBLG5' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@notifications',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@notifications',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::c3mTLLV6ZMGhBLG5',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::tQ6OyiqU2eeaT78s' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/notifications/{id}/read',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markNotificationRead',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markNotificationRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::tQ6OyiqU2eeaT78s',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::96VgNKJkRPCyF5Qd' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/notifications/{id}/unread',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markNotificationUnread',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markNotificationUnread',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::96VgNKJkRPCyF5Qd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::FkcRpSnApfEBEhuW' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/notifications/read-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markAllNotificationsRead',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@markAllNotificationsRead',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::FkcRpSnApfEBEhuW',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::hWbwDcVP6IM2VUQY' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/notifications/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@deleteNotification',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@deleteNotification',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::hWbwDcVP6IM2VUQY',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::R5bCW0PqXRSzOIw8' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/notifications',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@deleteAllNotifications',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminDashboardController@deleteAllNotifications',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::R5bCW0PqXRSzOIw8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ta1sdt8GskYVoKEa' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/reviews',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ta1sdt8GskYVoKEa',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::QpVqvV7x6U9lNPY9' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/reviews/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@stats',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::QpVqvV7x6U9lNPY9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bClaKsrojGhOjEc4' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/reviews/{review}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::bClaKsrojGhOjEc4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DaxcgF8xE1JWCHEr' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/reviews/{review}/approve',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@approve',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@approve',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::DaxcgF8xE1JWCHEr',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PNKDIGcFBV9ZZcg0' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/reviews/{review}/reject',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@reject',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@reject',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::PNKDIGcFBV9ZZcg0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GY9lweiILB9fcZqU' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/reviews/{review}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminReviewController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::GY9lweiILB9fcZqU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MzOiKbnYgvld6kOp' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/enquiries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::MzOiKbnYgvld6kOp',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ubWH5q7pdqwJvSXL' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/enquiries/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@stats',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ubWH5q7pdqwJvSXL',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::w1cc2L7uGq8xHdbZ' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/enquiries/{enquiry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::w1cc2L7uGq8xHdbZ',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ttJsF9N9M9OOETqt' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/enquiries/{enquiry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ttJsF9N9M9OOETqt',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::MVUgqP5hPkPaQHFq' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/enquiries/{enquiry}/reply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@reply',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@reply',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::MVUgqP5hPkPaQHFq',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::HBvjXQ1PUs1Ff5J7' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/enquiries/{enquiry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminEnquiryController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::HBvjXQ1PUs1Ff5J7',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::PyKuX5ajYd5RNog8' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/bundles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::PyKuX5ajYd5RNog8',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::lUAlOPwqkFSw0vkC' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/bundles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::lUAlOPwqkFSw0vkC',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::v3qNwyXiJpXLk4ZU' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/bundles/{bundle}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::v3qNwyXiJpXLk4ZU',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2VYuAR9x0yiYRJku' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/bundles/{bundle}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminBundleController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::2VYuAR9x0yiYRJku',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dzo7FoRwLgw3iA8h' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/chat/sessions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@sessions',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@sessions',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::dzo7FoRwLgw3iA8h',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::1F3LrH1Y6OZj1qP0' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/chat/sessions/{session}/messages',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@messages',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@messages',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::1F3LrH1Y6OZj1qP0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::E3Pa7jko6XdtGeyc' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/chat/sessions/{session}/reply',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@reply',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@reply',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::E3Pa7jko6XdtGeyc',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::o4Hb72SHCd2yMyTR' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/chat/sessions/{session}/close',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@closeSession',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@closeSession',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::o4Hb72SHCd2yMyTR',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::gSRhDdgywAgBhFxH' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/chat/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@stats',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::gSRhDdgywAgBhFxH',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::x2vWTCpWUE8jaGz2' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/chat/metrics',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@metrics',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminChatController@metrics',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::x2vWTCpWUE8jaGz2',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::fCluwzHHIaWFPp7P' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/case-studies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::fCluwzHHIaWFPp7P',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::YtxcAZBUteTJ4XR0' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/case-studies',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::YtxcAZBUteTJ4XR0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::Gp7X547q8MLtkgBy' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/case-studies/{caseStudy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::Gp7X547q8MLtkgBy',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NCsDvcl6IXIMsqYm' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/case-studies/{caseStudy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::NCsDvcl6IXIMsqYm',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::DM5oEK1892S7bs4N' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/case-studies/{caseStudy}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminCaseStudyController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::DM5oEK1892S7bs4N',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::2y2Q5alMI0kWHP1a' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/industries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::2y2Q5alMI0kWHP1a',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::ViM76e8xDEWyenMD' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/industries',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::ViM76e8xDEWyenMD',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::nZIvVnGHuvjDABob' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/industries/{industry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@show',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@show',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::nZIvVnGHuvjDABob',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GUl3gczkP3GJtncN' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/industries/{industry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::GUl3gczkP3GJtncN',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::12fcchhcwl1cy6x0' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/industries/{industry}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\IndustryController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::12fcchhcwl1cy6x0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::kgE1jwttqnMUdogV' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::kgE1jwttqnMUdogV',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::3GyDAEkbWfFwrPv4' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/users/stats',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@stats',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@stats',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::3GyDAEkbWfFwrPv4',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::NjPO6RlLu6nq0081' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/users',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::NjPO6RlLu6nq0081',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::VG4EljeHTvctxkGd' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::VG4EljeHTvctxkGd',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::dgBa5mI4T6FEg04L' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/users/{user}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminUserController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::dgBa5mI4T6FEg04L',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::qPaulECJRlNan6az' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/roles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::qPaulECJRlNan6az',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::8ZboI2DRnvXdKQ82' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/permissions',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@permissions',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@permissions',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::8ZboI2DRnvXdKQ82',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::f8fo6vk1DYt1Wkd0' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/roles',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@store',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@store',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::f8fo6vk1DYt1Wkd0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::bktTnX4v8tyYUk3X' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'api/v1/admin/roles/{role}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@update',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@update',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::bktTnX4v8tyYUk3X',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::58QDnPbk6FQiOyE0' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/roles/{role}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@destroy',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\AdminRoleController@destroy',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::58QDnPbk6FQiOyE0',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AcBfLK4VGVX21sDh' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'api/v1/admin/trash/{type}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@index',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@index',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::AcBfLK4VGVX21sDh',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::AhLTXfFjnnHuUfm9' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/trash/{type}/{id}/restore',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@restore',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@restore',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::AhLTXfFjnnHuUfm9',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::k2Tnl2OWYgQhbDRu' => 
    array (
      'methods' => 
      array (
        0 => 'DELETE',
      ),
      'uri' => 'api/v1/admin/trash/{type}/{id}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@forceDelete',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@forceDelete',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::k2Tnl2OWYgQhbDRu',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::GTe2UC4wiXIDirQi' => 
    array (
      'methods' => 
      array (
        0 => 'POST',
      ),
      'uri' => 'api/v1/admin/trash/{type}/restore-all',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'api',
          1 => 'auth:sanctum',
          2 => 'role:admin|superadmin',
        ),
        'uses' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@restoreAll',
        'controller' => 'App\\Http\\Controllers\\Api\\Admin\\TrashController@restoreAll',
        'namespace' => NULL,
        'prefix' => 'api/v1/admin',
        'where' => 
        array (
        ),
        'as' => 'generated::GTe2UC4wiXIDirQi',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::xWjzfKYvlzTKoXYf' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'up',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:835:"function () {
                    $exception = null;

                    try {
                        \\Illuminate\\Support\\Facades\\Event::dispatch(new \\Illuminate\\Foundation\\Events\\DiagnosingHealth);
                    } catch (\\Throwable $e) {
                        if (app()->hasDebugModeEnabled()) {
                            throw $e;
                        }

                        report($e);

                        $exception = $e->getMessage();
                    }

                    return response(\\Illuminate\\Support\\Facades\\View::file(\'/Users/robaa/Documents/Projects/TechSmart/vendor/laravel/framework/src/Illuminate/Foundation/Configuration\'.\'/../resources/health-up.blade.php\', [
                        \'exception\' => $exception,
                    ]), status: $exception ? 500 : 200);
                }";s:5:"scope";s:54:"Illuminate\\Foundation\\Configuration\\ApplicationBuilder";s:4:"this";N;s:4:"self";s:32:"00000000000009ac0000000000000000";}}',
        'as' => 'generated::xWjzfKYvlzTKoXYf',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'generated::c4nZpinZ4RkEn1I6' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => '{any}',
      'action' => 
      array (
        'middleware' => 
        array (
          0 => 'web',
        ),
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:0:{}s:8:"function";s:40:"function () {
    return \\view(\'app\');
}";s:5:"scope";s:37:"Illuminate\\Routing\\RouteFileRegistrar";s:4:"this";N;s:4:"self";s:32:"00000000000009830000000000000000";}}',
        'namespace' => NULL,
        'prefix' => '',
        'where' => 
        array (
        ),
        'as' => 'generated::c4nZpinZ4RkEn1I6',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'any' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local' => 
    array (
      'methods' => 
      array (
        0 => 'GET',
        1 => 'HEAD',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:61:"/Users/robaa/Documents/Projects/TechSmart/storage/app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:323:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ServeFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000008fe0000000000000000";}}',
        'as' => 'storage.local',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
    'storage.local.upload' => 
    array (
      'methods' => 
      array (
        0 => 'PUT',
      ),
      'uri' => 'storage/{path}',
      'action' => 
      array (
        'uses' => 'O:55:"Laravel\\SerializableClosure\\UnsignedSerializableClosure":1:{s:12:"serializable";O:46:"Laravel\\SerializableClosure\\Serializers\\Native":5:{s:3:"use";a:3:{s:4:"disk";s:5:"local";s:6:"config";a:5:{s:6:"driver";s:5:"local";s:4:"root";s:61:"/Users/robaa/Documents/Projects/TechSmart/storage/app/private";s:5:"serve";b:1;s:5:"throw";b:0;s:6:"report";b:0;}s:12:"isProduction";b:0;}s:8:"function";s:325:"function (\\Illuminate\\Http\\Request $request, string $path) use ($disk, $config, $isProduction) {
                    return (new \\Illuminate\\Filesystem\\ReceiveFile(
                        $disk,
                        $config,
                        $isProduction
                    ))($request, $path);
                }";s:5:"scope";s:47:"Illuminate\\Filesystem\\FilesystemServiceProvider";s:4:"this";N;s:4:"self";s:32:"00000000000008fc0000000000000000";}}',
        'as' => 'storage.local.upload',
      ),
      'fallback' => false,
      'defaults' => 
      array (
      ),
      'wheres' => 
      array (
        'path' => '.*',
      ),
      'bindingFields' => 
      array (
      ),
      'lockSeconds' => NULL,
      'waitSeconds' => NULL,
      'withTrashed' => false,
    ),
  ),
)
);
