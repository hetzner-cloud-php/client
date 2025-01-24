---
outline: deep
---

# [Actions](https://docs.hetzner.cloud/#actions)

Actions show the results and progress of asynchronous requests to the API.

## Get actions

Retrieves all available actions for a project, with a optional query parameters.

```php
$response = $client->actions()->getActions();
$response->actions; // array<int, Action>

foreach ($response->actions as $action) {
    echo $action->command;
}

$response->toArray(); // ['actions' => ['id => 1337', ...], 'meta' => [...]]
```

## Get an action

Retrieves a single action for a project.

```php
$response = $client->actions()->getAction(1337);
$response->action; // Action::class
$response->toArray(); // ['action' => 'id' => 1337, ...]
```
