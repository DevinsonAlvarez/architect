# A simple way to use _**Data Structures**_ - Work in Progress

This is a simple package for handling the most common data structures

## Installation

First we need to create a composer project.

```sh
composer create-project my_project
```

Go inside your composer project and open your `composer.json` file, here you must add the follow lines.

```json
{
  "require": {
    "devinson/architect": "dev-main"
  },
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/DevinsonAlvarez/architect.git"
    }
  ]
}
```

And then install the package.

```sh
composer install
```

## Usage

coming soon...

### TODO

1. Add generic types and types hinting to:

   - List
   - Linked List
   - Linked Node
   - Double Linked Node
   - Stack
   - Queue

2. Create Non-Linear data structures (Binary Trees, Heap, Graphs, etc...).
