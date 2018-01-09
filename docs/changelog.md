# CHANGELOG

## develop branch

### New

Initial support for understanding what's in a PHP source file
- source file docblock
- namespace declarations
- namespaced imports
- classes
  - class constants
  - class properties
  - class methods
    - method params
    - method return type
- interfaces
  - interface methods
    - method params
    - method return type
- traits
  - trait constants
  - trait properties
  - trait methods
    - method params
    - method return type
- functions
  - function params
  - function return type
- type safety
  - type-aliases for namespace names

Initial support for understanding what's in a Composer project
- composer project
- installed composer packages
- autoloaded PSR0 classes
- autoloaded PSR4 classes
- autoloaded files
- autoloaded classmaps