---
extends: _layouts.post
section: content
title: "How to write code: General Guidelines"
date: 2021-01-13
description: regergergre
cover_image: /assets/img/how-to-write-code/jordan-madrid-iDzKdNI7Qgc-unsplash.jpg
---


## Use services

Almost every Orchid application implements specific business logic algorithms. And the best place for these algorithms is in services, into which you need to transfer business logic from all other classes - screen methods, application listeners, etc. This approach has certain advantages:

- There will be only one implementation of business logic that is in one place
- This business logic can be called from different places in the application and also published as a REST service.

Remember that business logic includes conditions, loops, etc. This means that service calls should ideally be single-line. Suppose we have code like this in a screen method:

```php
if ($item->isActive()) {
  $service->doPlanA($item);
} else {
  $service->doPlanB($item);
}
```

If you see this code, it might be worth moving it from the screen method to the "Service" as a separate `processItem(Item $item)` method since it looks like part of the business logic. After that, the code will look like this:

```php
$item = Item::find(1);

$service->processItem($item);
```

And since different teams can develop screens and APIs, keeping the business logic in one place will help avoid inconsistent application behavior when going into production.


## Use logging

Sometimes when an application is running in a production environment, something goes wrong. And when it does, it can be difficult to figure out what exactly caused the crash. You can't debug an application deployed to production, can you? Always use logging to make it easier for yourself, your fellow developers, and the support team and help you understand the problem and reproduce it.

Logging can help in troubleshooting problems that do not arise in the application itself but in the services with which it is integrated. For example, to determine why a payment gateway is rejecting certain transactions, you might need to record all of the data and then use it when you contact support.

Laravel already has good helpers for this, for example:

```php
use Illuminate\Support\Facades\Log;

Log::emergency($message);
Log::alert($message);
Log::critical($message);
Log::error($message);
Log::warning($message);
Log::notice($message);
Log::info($message);
Log::debug($message);
```

Remember that the logs' messages must be meaningful and contain enough information to understand what happened in the application.


## Handle exceptions

Software exceptions are significant because they carry valuable information when something goes wrong in an application as intended. Therefore, the rule should not be ignored.

For example, never do this:

```php
try {
    $service->doPlanA($item); 
} catch (Exception $exception) {

}
```

If an error appears, no one will know about it.

It's a little better, but far from ideal.

```php
try {
    $service->doPlanA($item);  
} catch (ServiceException $exception) {
    Log::error($exception->getMessage());
}
```

An error message will appear in the logs, and we will only receive certain classes of exceptions. But there will be no information about the context: the name of the object, from which user it originated. Moreover, there will be no stack trace, so it will not be easy to find where the exception was thrown. And one more thing - the user will not be notified of the problem.

This can be considered a relatively good approach.

```php
try {
   $service->doPlanA($item);  
} catch (ServiceException $exception) {
    throw new RuntimeException("Error service for process plan A");
}
```

We know the error, don't lose the original exception, add an informative message. The caller will be notified of the exception. The current username and more context data could be added.

## Conclusion

Orchid simplifies development, so you will surely finish your project earlier than expected. But following these simple rules of worries will become even less.


