<?php

namespace App\Helpers;

class SupportCommand
{
    public const SUPPORT_MESSAGE = [

        '/help' => <<<TEXT
        Daftar command yang tersedia:

        /closing - Cara melakukan closing.
        /unbind - Cara melakukan unbind.

        TEXT,

        '/closing' => <<<TEXT
        Berikut adalah tata cara melakukan closing:


        /moban#kategori closing#

        Nama =
        NIK =
        Unit =

        Perihal =
        TIKET

        Alasan =
        Alasan melakukan closing

        #approval
        Nama Atasan =
        NIK Atasan =
        TEXT,

        '/unbind' => <<<TEXT
        Berikut adalah template melakukan unbind:


        UNBIND
        TEXT,
    ];
}
