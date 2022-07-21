# Wikiki

## Maquette
Figma : https://www.figma.com/file/XpUJAFpK78t3fzxXDc7W23/CMS?node-id=31%3A4

## Suivi du projet

Github Project :  https://github.com/orgs/ESGI-69/projects/1/

## Prod

https://wikiki.timdev0.com/

## Installation & lancement

### Development

Build & watch scss files:

Don't forget to install sass (https://sass-lang.com/install)[https://sass-lang.com/install]

```sh
sass -w www/scss/main.scss www/css/index.css
```

And finally go on :
```ssh 
localhost:3000
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
- 2 Singletons: Singleton for logger `\www\Core\Logger.class.php` and db connection `\www\Core\Sql.class.php` & `\www\Core\DbConnection.class.php` done
- Observer:  `\www\Core\Observer.class.php` linked to the mailer done
