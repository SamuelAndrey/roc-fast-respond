<?php

namespace App\Helpers;

class KeyPrompt
{
    private const KEY_CLOSING = [
        'close_ogp' => 'Closing OGP',
        'close_sqm' => 'Closing SQM',
        'close_ggl_scc' => 'Closing GGL SCC',
    ];

    private const KEY_UNBIND = [
        'unbind_testing' => 'Unbind Testing',
    ];


    public static function validate($action): array
    {
        if (array_key_exists($action, self::KEY_CLOSING)) {
            return [
                'status' => true,
                'type' => self::KEY_CLOSING[$action],
            ];
        }

        if (array_key_exists($action, self::KEY_UNBIND)) {
            return [
                'status' => true,
                'type' => self::KEY_UNBIND[$action],
            ];
        }

        return [
            'status' => false,
            'type' => null,
        ];
    }
}
