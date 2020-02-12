<?php

namespace App\Services;

class FoldersUser
{

    private $file;

    public function __construct($file = '')
    {
        $this->file = $file;
    }

    /**
     * @param string $email, $userRole
     * @return void
     */
    public function isFolder(string $email, string $userRole = '')
    {


        $this->file = "assets/images/" . $email;
        if (!file_exists("assets/images/" . $email)) {
            mkdir("assets/images/" . $email);
            mkdir("assets/images/" . $email . "/logo");
            if ($userRole  == "ARTISAN") {
                mkdir("assets/images/" . $email . "/compagny");
            }
        }
        return;
    }
}
