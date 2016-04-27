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

## Schedule

 * 10m - presentation round
 * 10m - pairing - discussion is at the core of the process
 * 10m - base concepts: aggregate root/value object
 * 5m - domain (and the 3 boundaries - auth, library, enforcement):
    * library
    * library contains books
    * each book has an ISBN and some metadata
    * can add books to the library
    * can register users
    * can lend books to users
    * users have a max lent books amount
    * users need to be notified when a lend is overdue
    * overdue lend must be enforced after a certain threshold (external API)
    * returned books should cancel enforcement requests (external API)
    * ask questions - what else can a library do? Is the specification sufficient?
 * 5m - domain bits to be implemented:
    * adding books
    * listing available books (assuming small to large bibliotheque)
    * lend a book (user)
    * return a book
    * notify user of late lent return
    * enforce return of very late lent
    * logging all operations (audit log or immutable structures)
    * avoid lazy-loading all the book catalogue
 * 30m - try designing a library or repository with just "add book" and "list all books" without memory issues
 * 15m - writing the library object together
    * custom repositories
    * passing repositories to entities?
 * 10m - hardening the logic with value-objects
 * 5m - transactional safety - it is needed now that we do live-queries at all times
 * 10m - transactional safety at the base of every interaction via a command bus
 * 45m - implementing book lends and returns (with commands, VOs and serialize/unserialize)
 * 15m - implementing lending books/returning books together
 * 15m - wiring together everything via XML mappings
 * 10m - installing and configuring doctrine migrations, generating first migration files
 * 20m - send notifications to users with overdue returns, don't dog-pile notifications
 * 10m - code notifications for overdue returns together
 * 20m - interaction with external system: coding together the notification system
 * 5m - logging some queries
 * 15m - setting up the second level cache, seeing it in action
