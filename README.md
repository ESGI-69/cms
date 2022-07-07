# Wikiki

## Installation & lancement

### Development

Build & watch scss files:

Don't forget to install sass (https://sass-lang.com/install)[https://sass-lang.com/install]

```sh
sass -w www/scss/main.scss www/css/index.css
```

### Production

Build scss files:

```sh
sass www/scss/main.scss www/css/index.css
```

```sh
docker-compose up
```

## Cookies

- `wikikiToken` Cookie contenant le token de session d'un utilisateur. Utiliser le AuthManager voir les info des user sur des veiws.

## Design pattern

- Builder : Query Builder with JOIN and LIMIT `\www\Core\MysqlBuilder.class.php` done
- Singleton: Singleton for logger `\www\Core\Logger.class.php` and db connection `\www\Core\Sql.class.php` & `\www\Core\DbConnection.class.php` done
