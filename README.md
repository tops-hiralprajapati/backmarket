# BackMarket Marketplace API



## Installation

To add the tops-hiralprajapati/backmarket GitHub repository to your Laravel project, follow these steps:

## Add the GitHub Repository to Composer
In the Laravel project where you want to add the GitHub repository, follow these steps:

- Open the composer.json file located in the root directory of your Laravel project.
- Add the GitHub repository under the repositories section. If the repositories section doesn't exist, create it.
```
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/tops-hiralprajapati/backmarket.git"
    }
  ],
  "require": {
    "tops/backmarketapi": "dev-master"
  }
}
```
##  Install the Package
After adding the repository, you need to install the package. Run the following Composer command in the terminal:
```
composer update
```
This will fetch the package from the GitHub repository and install it in your Laravel project.

