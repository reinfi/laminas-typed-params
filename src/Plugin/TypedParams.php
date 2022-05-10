<?php

declare(strict_types=1);

namespace Reinfi\TypedParams\Plugin;

use Laminas\Mvc\Controller\AbstractController;
use Laminas\Mvc\Controller\Plugin\AbstractPlugin;
use Reinfi\TypedParams\Value\TypedValue;

/**
 * @method AbstractController getController()
 */
class TypedParams extends AbstractPlugin
{
    public function __invoke(): self
    {
        return $this;
    }

    /**
     * @param string $param
     * @param mixed $default
     *
     * @return TypedValue
     */
    public function fromFiles(string $param, $default = null): TypedValue
    {
        return new TypedValue($this->getController()->getRequest()->getFiles($param, $default));
    }

    /**
     * @param string $header
     * @param mixed $default
     *
     * @return TypedValue
     */
    public function fromHeader(string $header, $default = null): TypedValue
    {
        return new TypedValue($this->getController()->getRequest()->getHeaders($header, $default));
    }

    /**
     * @param string $param
     * @param mixed $default
     *
     * @return TypedValue
     */
    public function fromPost(string $param, $default = null): TypedValue
    {
        return new TypedValue($this->getController()->getRequest()->getPost($param, $default));
    }

    /**
     * @param string $param
     * @param mixed $default
     *
     * @return TypedValue
     */
    public function fromQuery(string $param, $default = null): TypedValue
    {
        return new TypedValue($this->getController()->getRequest()->getQuery($param, $default));
    }

    /**
     * @param string $param
     * @param mixed $default
     *
     * @return TypedValue
     */
    public function fromRoute(string $param, $default = null): TypedValue
    {
        $routeMatch = $this->getController()->getEvent()->getRouteMatch();

        if ($routeMatch === null) {
            return new TypedValue(null);
        }

        return new TypedValue($routeMatch->getParam($param, $default));
    }
}
