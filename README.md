# Inventory Manager

A simple inventory management system written in OOP PHP. Create, edit, delete products & categories, manage users, create reports, etc.

![Inventory manager](https://github.com/greeeg/inventory-manager/blob/master/src/img/screenshot.png?raw=true)

### Features
* Products with quantity, price
* Categories linked to products
* Dashboard with graphs & important data
* Inventory reports
* Users

### Usage

#### Requirements
* [Node.js](https://nodejs.org/en/) installed
* [Composer](https://getcomposer.org/) installed
* [Maildev](https://www.npmjs.com/package/maildev) installed globally

#### Installation

- Use `composer install` on root folder
- Use `composer dump-autoload` on root folder
- Import database structure from `database.sql`
- Update config values in `App/config.yml`
- Run `maildev` to start capturing emails locally

#### Edit the project
If you wish to update project files, all assets sources are available in the `src` folder with a gulp configuration to update output assets.

### Dependencies used
#### Front-end
* [Moment.js](https://github.com/moment/moment/)
* [Chart.js](https://github.com/chartjs/Chart.js)

#### Back-end
* [Twig](https://github.com/twigphp/Twig)
* [PHPMailer](https://github.com/PHPMailer/PHPMailer)
* [YAML Parser](https://github.com/symfony/yaml)

### TO DO
* [ ] Users roles (Administrator, Editor, etc.)
* [ ] Flash notifications
* [ ] Website editable settings
* [ ] Basic front-end interface
