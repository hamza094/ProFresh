# Contributing Guide

We welcome contributions to the Laravel.io project. Please read the following guide before posting an issue or sending
in pull requests. Please also read our [Code of Conduct](CODE_OF_CONDUCT.md) before contributing or engaging in
discussions.

## Issues

- **Feature requests** need to describe as thoroughly as possible and perhaps contain some info on how you would implement it
- **Bug reports** need to be described in detail what the problem is, how it was triggered and perhaps contain a possible solution
- **Questions** are free to be asked about the internals of the codebase and about the project

## Pull Requests

We very much appreciate any help with [open issues labeled with "help wanted"](https://github.com/hamza094/ProFresh/issues?q=state%3Aopen%20label%3A%22help%20wanted%22).

- **Feature requests** we're welcoming pull requests for new features (although we might not accept every single one). You can also first discuss new feature requests [through an issue](https://github.com/hamza094/ProFresh/issues) before sending in a pull request
- **Bug fixes** should contain regression tests
- All pull requests should follow the [coding standards](#coding-standards)
- Pull requests will be merged after being reviewed by [the maintainers](README.md#maintainers)
- Please be respectful to other contributors and hold to [The Code Manifesto](http://codemanifesto.com/)
- Please post screenshots if you make any changes to the UI

## Coding Standards

- It's a good practice to write tests for your contribution
- Write the full namespace in DocBlocks for `@param`, `@var` or `@return` tags
- The rest of the coding standards will automatically be fixed by [GitHub Actions](https://github.com/hamza094/ProFresh/actions)

## Testing

All tests can be run with the following commands.

    $ vendor/bin/phpunit
