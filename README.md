# maw-andi-alex
A clone of "Exercise Looper" that can be found at: https://stormy-plateau-54488.herokuapp.com/

Trello : https://trello.com/b/AIqE4hIN/

# Prerequisite

- PHP 7.4+
- MariaDB 10.3.23
- Composer 1.8.4 

# Installing

Create a new MariaDB user

```sql

CREATE USER 'exercise_looper'@localhost IDENTIFIED BY 'password';

GRANT ALL PRIVILEGES ON 'exercise_looper'.* TO 'exercise_looper'@localhost IDENTIFIED BY 'password';

```

In order to create the schema run the sql script at : 'db/ScriptDB.sql'

Then run :

`composer install`

# Structure

```sh
src/
├── components	    Reusable PHP components
├── core	    Core files such as the Component and Renderer class
├── index.php 	    Contains the router, every requests are handled by this file
├── layout.php	    The layout used by the Renderer class, contains the head and
		    body HTML tags
├── models	    The models used by Expreql, the QueryBuidler/ORM
├── static	    Static files
└── views	    Views being renderer by the Renderer class

```

# Run 

You have to be in the src/ directory.

`php -S localhost:8080`

# Docs

- [expreql (QueryBuilder)](https://github.com/AlexandrePhilibertCPNV/expreql)
- [routier (Router)](https://github.com/AlexandrePhilibertCPNV/routier)
