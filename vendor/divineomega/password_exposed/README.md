# 🔒 Password Exposed Helper Function

This PHP package provides a `password_exposed` helper function, that uses the haveibeenpwned.com API to check if a password has been exposed in a data breach.

<p align="center">
    <img src="assets/images/password-exposed.png">
</p>

<p align="center">
    <a href="https://travis-ci.org/DivineOmega/password_exposed">
        <img src="https://travis-ci.org/DivineOmega/password_exposed.svg?branch=master" alt="Build Status" />
    </a>
    <a href="https://styleci.io/repos/119845896">
        <img src="https://styleci.io/repos/119845896/shield?branch=master" alt="StyleCI" />
    </a>
</p>

## Installation

The `password_exposed` package can be easily installed using Composer. Just run the following command from the root of your project.

```
composer require "divineomega/password_exposed"
```

If you have never used the Composer dependency manager before, head to the [Composer website](https://getcomposer.org/) for more information on how to get started.

## Usage

To check if a password has been exposed in a data breach, just pass it to the `password_exposed` method.

Here is a basic usage example:

```php
switch(password_exposed('hunter2')) {

    case PasswordStatus::EXPOSED:
        // Password has been exposed in a data breach.
        break;

    case PasswordStatus::NOT_EXPOSED:
        // Password has not been exposed in a known data breach.
        break;

    case PasswordStatus::UNKNOWN:
        // Unable to check password due to an API error.
        break;
}
```