# Cakrawala
Cakrawala Simple PHP MVC Framework

---

## Description
PHP MVC Framework for simple web application.

## Installation
1. Clone this repository to your web server directory.
2. Change the directory name to your project name.
3. Assign correct settings in `.env` file.
4. Access your project in browser, for example: `http://localhost/projectdirname`.

## Routing
This framework detect route based on module folder name, controller file name, and method name. For example:
- `http://localhost/projectdirname/index/login` will call `login` method in `Index_Controller` class in `index` module folder.