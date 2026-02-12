<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\Extension\GlobalsInterface;

class AppExtension extends AbstractExtension implements GlobalsInterface
{
    private string $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getGlobals(): array
    {
        $logoDir = $this->projectDir . '/public/uploads/logo/';
        $extensions = ['png', 'jpg', 'jpeg', 'svg'];
        $lgFile = null;

        foreach ($extensions as $ext) {
            if (file_exists($logoDir . 'logo.' . $ext)) {
                $lgFile = '/uploads/logo/logo.' . $ext;
                break;
            }
        }

        return [
            'lgFile' => $lgFile,
        ];
    }
}
