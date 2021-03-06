<?php

return [

    /*
     * X-Content-Type-Options
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Content-Type-Options
     *
     * Available Value: 'nosniff'
     */

    'x-content-type-options' => 'nosniff',

    /*
     * X-Download-Options
     *
     * Reference: https://msdn.microsoft.com/en-us/library/jj542450(v=vs.85).aspx
     *
     * Available Value: 'noopen'
     */

    'x-download-options' => 'noopen',

    /*
     * X-Frame-Options
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/X-Frame-Options
     *
     * Available Value: 'deny', 'sameorigin', 'allow-from <uri>'
     */

    'x-frame-options' => 'sameorigin',

    /*
     * X-Permitted-Cross-Domain-Policies
     *
     * Reference: https://www.adobe.com/devnet/adobe-media-server/articles/cross-domain-xml-for-streaming.html
     *
     * Available Value: 'all', 'none', 'master-only', 'by-content-type', 'by-ftp-filename'
     */

    'x-permitted-cross-domain-policies' => 'none',

    /*
     * X-XSS-Protection
     *
     * Reference: https://blogs.msdn.microsoft.com/ieinternals/2011/01/31/controlling-the-xss-filter
     *
     * Available Value: '1', '0', '1; mode=block'
     */

    'x-xss-protection' => '1; mode=block',

    /*
     * Referrer-Policy
     *
     * Reference: https://w3c.github.io/webappsec-referrer-policy
     *
     * Available Value: 'no-referrer', 'no-referrer-when-downgrade', 'origin', 'origin-when-cross-origin',
     *                  'same-origin', 'strict-origin', 'strict-origin-when-cross-origin', 'unsafe-url'
     */

    'referrer-policy' => 'no-referrer',

    /*
     * HTTP Strict Transport Security
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/HTTP_strict_transport_security
     *
     * Please ensure your website had set up ssl/tls before enable hsts.
     */

    'hsts' => [
        'enable' => false,

        'max-age' => 15552000,

        'include-sub-domains' => false,
    ],

    /*
     * Expect-CT
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/HTTP/Headers/Expect-CT
     */

    'expect-ct' => [
        'enable' => false,

        'max-age' => 2147483648,

        'enforce' => false,

        'report-uri' => null,
    ],

    /*
     * Public Key Pinning
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/Public_Key_Pinning
     *
     * hpkp will be ignored if hashes is empty.
     */

    'hpkp' => [
        'hashes' => [
            // 'sha256-hash-value',
        ],

        'include-sub-domains' => false,

        'max-age' => 15552000,

        'report-only' => false,

        'report-uri' => null,
    ],

    /*
     * Content Security Policy
     *
     * Reference: https://developer.mozilla.org/en-US/docs/Web/Security/CSP
     *
     * csp will be ignored if custom-csp is not null. To disable csp, set custom-csp to empty string.
     *
     * Note: custom-csp does not support report-only.
     */

    'custom-csp' => null,

    'csp' => [
        'report-only' => false,

        'report-uri' => null,

        'block-all-mixed-content' => false,

        'upgrade-insecure-requests' => false,

        /*
         * Please references script-src directive for available values, only `script-src` and `style-src`
         * supports `add-generated-nonce`.
         *
         * Note: when directive value is empty, it will use `none` for that directive.
         */

        'script-src' => [
            'allow' => [
                "cdn.jsdelivr.net",
                "code.jquery.com",
                'maxcdn.bootstrapcdn.com',
                "cdnjs.cloudflare.com",
                "cdn.datatables.net",
                "unpkg.com",
            ],

            'hashes' => [
                // 'sha256' => [
                //     'hash-value',
                // ],
            ],

            'nonces' => [
                // base64-encoded,
            ],

            'schemes' => [
                // https:,
            ],

            'self' => true,

            'unsafe-inline' => true,

            'unsafe-eval' => true,

            'strict-dynamic' => false,

            'unsafe-hashed-attributes' => false,

            'add-generated-nonce' => false,
        ],

        'style-src' => [
            'allow' => [
                "cdnjs.cloudflare.com",
                "cdn.jsdelivr.net",
                'maxcdn.bootstrapcdn.com',
                "fonts.googleapis.com",
                "cdn.datatables.net",
            ],

            'hashes' => [
                // 'sha256' => [
                //     'hash-value',
                // ],
            ],

            'nonces' => [
                //
            ],

            'schemes' => [
                // https:,
            ],

            'self'          => true,
            'unsafe-inline' => true,

            'add-generated-nonce' => false,
        ],

        'img-src' => [
            'allow'   => [
                "secure.gravatar.com",
                "cdn.datatables.net",
            ],
            'schemes' => [
                "data:",
            ],
            'self'    => true,
        ],

        'default-src' => [
            'self' => true,
        ],

        'base-uri' => [
            'self' => true,

        ],

        'connect-src' => [
            'self' => true,

        ],

        'font-src' => [
            'allow' => [
                "maxcdn.bootstrapcdn.com",
            ],
            'self'  => true,
        ],

        'form-action' => [
            'self' => true,
        ],

        'frame-ancestors' => [
            'self' => true,

        ],

        'frame-src' => [
            'self' => true,

        ],

        'manifest-src' => [
            'self' => true,
        ],

        'media-src' => [
            'self' => true,

        ],

        'object-src' => [
            'self' => true,

        ],

        'worker-src' => [
            'self' => true,
        ],

        'plugin-types' => [
            // application/x-shockwave-flash,
        ],

        'require-sri-for' => '',

        'sandbox' => '',

    ],

];
