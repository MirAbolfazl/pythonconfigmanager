# PythonConfigManager

`PythonConfigManager` is a PHP class designed to manage configuration files in a Python-like syntax. It allows you to load, parse, modify, and save configuration data easily.

## Features

- Load configuration from a file
- Parse values into appropriate PHP types (boolean, integer, float, array, object)
- Modify configuration values
- Save configuration back to the file

## Usage

### Loading a Configuration File

To load a configuration file, create an instance of `PythonConfigManager` with the file path:

```php
$configManager = new PythonConfigManager('/path/to/config/file');
```

### Accessing Configuration Values

You can access configuration values using the magic `__get` method:

```php
$value = $configManager->propertyName;
```

### Modifying Configuration Values

You can modify configuration values using the magic `__set` method:

```php
$configManager->propertyName = $newValue;
```

### Saving Configuration

To save the modified configuration back to the file, use the `cleanConfig` method:

```php
$configManager->cleanConfig();
```

### Example

```php
<?php
require 'path/to/PythonConfigManager.php';

$configManager = new PythonConfigManager('/path/to/config/file');

// Access a configuration value
echo $configManager->someProperty;

// Modify a configuration value
$configManager->someProperty = 'newValue';

// Save the changes
$configManager->cleanConfig();
?>
```

## Methods

- `__construct($filePath)`: Loads the configuration from the specified file.
- `cleanConfig()`: Saves the current configuration back to the file.
- `getConfig()`: Returns the entire configuration array.
- `__get($name)`: Magic method to get a configuration value.
- `__set($name, $value)`: Magic method to set a configuration value.
- `__isset($name)`: Magic method to check if a configuration value is set.
- `__unset($name)`: Magic method to unset a configuration value.

## License

This project is licensed under the MIT License.

## Author

Abolfazl Ebrahimi
