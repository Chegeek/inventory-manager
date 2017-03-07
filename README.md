# Inventory Manager

A simple inventory management system written in OOP PHP. Create, edit, delete products & categories, manage users, create reports, etc.

### Types of content
* Products
* Categories
* Users
* Reports

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
