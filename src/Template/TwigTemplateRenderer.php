<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/04
 */

namespace JTL\SCX\Lib\Channel\Template;

use JTL\SCX\Lib\Channel\Core\Environment\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;

class TwigTemplateRenderer
{
    private \Twig\Environment $twig;

    public function __construct(Environment $environment)
    {
        $loader = new FilesystemLoader($environment->get('ROOT_DIRECTORY') . '/' . $environment->get('TEMPLATE_DIR'));
        $this->twig = new \Twig\Environment($loader, [
            'cache' => $environment->get('ROOT_DIRECTORY') . '/' . $environment->get('TEMPLATE_CACHE'),
            'auto_reload' => $environment->isDevelopment()
        ]);
    }

    /**
     * @param string $template
     * @param array $variables
     * @return string
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function render(string $template, array $variables = []): string
    {
        $twigTemplate = $this->twig->load($template);
        return $twigTemplate->render($variables);
    }
}
