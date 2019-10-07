<?php declare(strict_types=1);
/**
 * This File is part of JTL-Software
 *
 * User: pkanngiesser
 * Date: 2019/10/07
 */

namespace JTL\SCX\Lib\Channel\Controller;


use JTL\SCX\Lib\Channel\Template\TwigTemplateRenderer;

abstract class AbstractSignUpController
{
    /**
     * @var TwigTemplateRenderer
     */
    protected $templateRenderer;

    /**
     * SignUpController constructor.
     * @param TwigTemplateRenderer $templateRenderer
     */
    public function __construct(TwigTemplateRenderer $templateRenderer)
    {
        $this->templateRenderer = $templateRenderer;
    }

    /**
     * @param string|null $session
     */
    abstract public function index(?string $session): void;

    /**
     * @param string|null $username
     * @param string|null $password
     * @param string|null $session
     */
    abstract public function signUp(?string $username, ?string $password, ?string $session): void;

    /**
     * @param array $params
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    protected function renderTemplate(array $params = []): void
    {
        echo $this->templateRenderer->render('signup.twig', $params);
    }
}