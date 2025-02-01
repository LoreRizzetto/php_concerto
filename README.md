# Usage
1. Setup the database.
    - Either run the polyglot as bash which creates a low privlege user:
        - `$ bash setup.sql | mysql` 
        - Move config.?.php to config.php
    - Or as SQL which sets up only the database:
        - `$ mariadb < setup.sql # or from the mysql repl invoke 'source setup.sql'`
        - Populate config.php:
```php
<?php
class DbConf{
    public static $host='127.0.0.1';
    public static $database='concerti';

    public static $username='?';
    public static $password='?';
}
```

2. Run it (it might fail if doas isn't installed, in that case comment out `system(...)`):
```
$ php example.php
doas (user@host) password:
id      codice  titolo  descrizione     data
1       cod1    titolo1 descrizione1    1970-01-01 01:01:01
2       cod2    titolo2 descrizione2    1970-02-02 02:02:02
=============
id      codice  titolo  descrizione     data
1       cod1    titolo1 descrizione1    1970-01-01 01:01:01
2       cod2    titolo2 descrizione2    1970-02-02 02:02:02
=============
```

# Usage of Concerto.php
To use this ""ORM"" you must first create a class with an instance of PDO bound to it.
When using the obtained class the ""ORM"" will use the bound PDO to interact with the database. 

```php
ConcertoFactory::bind("MyConcertoClass", $pdo);

MyConcertoClass::create(...); // no need to pass $pdo again
```
