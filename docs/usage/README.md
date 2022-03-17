# Usage Guide

## Creating Users

Users are `event-sourced` using [spatie/laravel-event-sourcing](https://github.com/spatie/laravel-event-sourcing) and created using the User Aggregate defined in `app/Aggregates/UserAggregate.php`

> See the [Spatie Docs](https://spatie.be/docs/laravel-event-sourcing/v7/introduction) for more information on event sourcing.

The following method is available for creating users:

```php
createUser(
        string $name,
        string $email,
        string $password,
        ?bool  $withPersonalTeam = false,
        ?string $teamUuid = null,
        ?string $teamName = null,
    )
```

Users must be identified prior to creation, a  `uuid` must first be generated.  

Example:

```php
$uuid = (string) \Illuminate\Support\Str::uuid();

$userAggregate = \App\Aggregates\UserAggregate::retrieve($uuid);

$userAggregate->createUser(
    name: 'inmanturbo',
    email: 'inmanturbo@mailinator.com',
    password: 'secret',
    withPersonalTeam: true,
)->persist();
```
