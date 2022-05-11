Laminas controller plugin for params to solve static code analysis.

=======

1. [Installation](#installation)
2. [Configuration](#configuration)
3. [Differences](#differences)

### Installation

1. Install with Composer: `composer require reinfi/laminas-typed-params`.
2. Enable the module via config in `appliation.config.php` under `modules` key:

```php
    return [
        'modules' => [
            'Reinfi\TypedParams',
            // other modules
        ],
    ];
```

### Configuration

To enable static code analysis to find your controller plugin you need to add it to your controller class.

```php
use Laminas\Mvc\Controller\AbstractActionController;
use Reinfi\TypedParams\Plugin\TypedParams;

/**
 * @method TypedParams typedParams() 
 */
class MyController extends AbstractActionController {

    public function indexAction()
    {
        $id = $this->typedParams()->fromRoute('id')->asNonEmptyString();
    }
}
```

In this example static code analysis will now know that id is always a non empty string.

### Differences

As of now you can not have conditional return types in the `@method` Annotation, i.e.

```php 
/**
 * @method ($param is string ? TypedValue : TypedParams) typedParams(string $param, $defualt = null)
 */
```
For that reason the invocation of the plugin always returns the plugin itself and you need to use the public methods.

In difference to the laminas mvc controller plugin `params` which returns route parameters if invoked with a parameter.

```php
public function __invoke($param = null, $default = null)
{
    if ($param === null) {
        return $this;
    }
    return $this->fromRoute($param, $default);
}
```

