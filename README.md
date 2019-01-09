[![Build Status](https://travis-ci.com/php-unified/state.svg?branch=master)](https://travis-ci.com/php-unified/state)

# PHP Unified State

This package provides a standard for tracking states of applications in PHP.
The package aims to create a multi-use standard.

This package contains an interface and a simple implementation for tracking states.

## Installation

```bash
composer require php-unified/state
```

## Usage

### Provided interface

#### PhpUnified\State\Common\StateInterface

This interface provides a standard for implementing state tracking into applications.
The following functions are expected to be implemented.

For this interface, an implementation is provided. See: `PhpUnified\State\State`.

##### Setters and getters

The object has 2 setters and 2 getters.
These methods are:
- `setValue` and `getValue` for setting and getting the value of the object.
- `setIdentifier` and `getIdentifier` for setting and getting the identifier of the object.

##### Exporting states

###### String conversion

The output of the method `__toString` should convert a state to a human readable string.
The result of this method with a single state could look like:

```
version: 1.0.0
```

Where `version` is the set identifier and `1.0.0` the set version.

For a state with multiple sub-states, output could look like:

```
packages:
    name: php-unified/state
    version: 1.0.0
```

Every line is a new state, with their respective `identifier: value` pairs.

###### Array conversion

The method for exporting states to an array is `exportState`.
The output of the method could look like:

```php
$output = [
    'packages' => '',
    'states' => [
        'name' => 'php-unified/state',
        'version' => '1.0.0'
    ]
]
```

##### Adding a sub-state

To add a state to a state, the method `addState` is expected to be implemented.
These states should be iterated over in both of the exporting states implementations.

## Tips

### Using nested states

By taking the approach of using nested states, the application can actively update their values.
This would result a single repository of states, which can be used in logging.
And thus creating more insight for debugging purposes.

For example, the application could monitor the last action from a database connection like so:
```php
use PhpUnified\State\State;
use Application\Database\Connection;
use Application\Logger\Logger;

$systemState = new State();
$systemState->setIdentifier('system-state');

$databaseTransactionState = new State();
$databaseTransactionState->setIdentifier('last-db-transaction-state');

$systemState->addState($databaseTransactionState);

$logger = new Logger();
$connection = new Connection($databaseTransactionState);
try {
    $connection->doQuery();
} catch (Throwable $e) {
    $logger->log('warning', $e->getMessage());
    $logger->info($systemState->__toString());
}

```

Then the (fictional) Connection class could look like:

```php
namespace Application\Database;

use PhpUnified\State\Common\StateInterface;

class Connection
{
    /**
     * State tracker
     *
     * @var StateInterface
     */
    private $state;

    /**
     * Constructor
     *
     * @param StateInterface $state
     */
    public function __construct(StateInterface $state)
    {
        $this->state = $state;
    }

    /**
     * Fictional doQuery function
     *
     * @return void
     */
    public function doQuery(): void
    {
        $state->setValue('Starting database connection');
        $connection = connectToDatabase();

        $state->setValue('Starting transaction');
        $connection->startTransaction();

        $state->setValue('Executing transaction');
        if($connection->doTransaction()) {
            $state->setValue(
                sprintf(
                    'Transaction with id %d transaction success',
                    $connection->getLastTransactionId()
                )
            );
            return true;
        }

        $state->setValue('Rolling back transaction');
        $connection->rollBackTransaction();
        $state->setValue('Rollback executed');
    }
}
```

If any of the above function calls in the `doQuery` function would result in an
exception being thrown, the latest state can still be logged.


## MIT License

Copyright (c) 2019 Jyxon

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
