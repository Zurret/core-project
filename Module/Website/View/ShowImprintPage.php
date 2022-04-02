<?php

declare(strict_types=1);

namespace Core\Module\Website\View;

use Core\Module\Core\CoreControllerInterface;

class ShowImprintPage
{
    private CoreControllerInterface $core;

    public function __construct(
        CoreControllerInterface $core
    ) {
        $this->core = $core;
    }

    /**
     * @route GET /
     */
    public function __invoke(): void
    {
        $this->core->setTemplateTitle('Impressum');

        $this->core->setTemplateVar('IMPRINT_NAME', $this->core->getConfig('imprint.name'));
        $this->core->setTemplateVar('IMPRINT_ADDRESS', $this->core->getConfig('imprint.address'));
        $this->core->setTemplateVar('IMPRINT_ZIP', $this->core->getConfig('imprint.zip'));
        $this->core->setTemplateVar('IMPRINT_CITY', $this->core->getConfig('imprint.city'));
        $this->core->setTemplateVar('IMPRINT_COUNTRY', $this->core->getConfig('imprint.country'));
        $this->core->setTemplateVar('IMPRINT_EMAIL', $this->encode_email($this->core->getConfig('imprint.email')));
        $this->core->render('Index/showImprintPage.twig');
    }

    private function encode_email(string $email): string
    {
        $output = '';
        for ($i = 0; $i < strlen($email); $i++) {
            $output .= '&#'.ord($email[$i]).';';
        }

        return $output;
    }
}
