<?php

/*
| Omdirigeringer fra det gamle One.com-site (m-tha.dk før go-live 2026).
| Nøgler matches uden forskel på store/små bogstaver og efter URL-afkodning.
*/

return [
    'pages' => [
        '/test' => '/',
        '/index.html' => '/',
        '/kontakt.html' => '/kontakt',
    ],

    'onewebmedia' => [
        '21208_domea a5 flyer boligselskabet nykøbing mors (1) (002).pdf' => '/assets/billeder/vaerelser/domea-brochure.pdf',
        'mth_vi skaber fremtidens stjerner_a4_2023 (2).pdf' => '/assets/brochure/mth_vi-skaber-fremtidens-stjerner_a4_2023-(2).pdf',
        'kontrakt til hjemmeside_sizeoptimized.pdf' => '/assets/brochure/kontrakt-til-hjemmeside_sizeoptimized.pdf',
        'mth_velkommen_a4_aug23 (2).pdf' => '/brochurer',
        'forældreovervejelser, alle sider.pdf' => '/assets/brochure/foraeldreovervejelser,-alle-sider.pdf',
        'privatlivspolitik.pdf' => '/assets/brochure/privatlivspolitik.pdf',
        'referat fra generalforsamling oktober 2025 - underskrevet.pdf' => '/assets/brochure/referat-fra-generalforsamling-oktober-2025-underskrevet.pdf',
        'vedtægter - underskrevet.pdf' => '/assets/brochure/vedtaegter-underskrevet.pdf',
    ],
];
