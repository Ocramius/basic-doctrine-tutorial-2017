# Maintainable Doctrine ORM tutorial

This tutorial will introduce you to using Doctrine ORM in a more maintainable way.

Specifically, following concepts will be covered:

 1. Aggregate root (Is it an Entity?)
 2. Value Object
 3. Commands
 4. Command bus
 5. Isolating domain and application logic
 6. Maintaining transactional integrity whilst keeping domain boundaries separate
 7. Transactional integrity and domain boundaries
 8. Maintaining schema changes versioned

## The domain

The domain used as reference is a Library (books) management system.
We will not focus much on DDD-style exploration, but we will instead
focus on writing the logic for an already existing specification:

 * User management system will be mocked out
 * Searching for books
 * Lending books to users
 * Managing maximum number of books that can be lent by a user at any given time
 * Getting books back from users
 * Notifying users that they should return a book
 * Fine users that didn't return a book after a notice (communication with external "enforcement" context)

## Installation

First, [install composer](https://getcomposer.org/download/).

After that, you can run:

```sh
composer require doctrine/orm
```

We now need to set up autoloading:

```json
{
    "autoload": {
        "psr-4": {
            "Authentication": "src/Authentication",
            "Library":        "src/Library",
            "Enforcement":    "src/Enforcement",
        }
    }
}
```
