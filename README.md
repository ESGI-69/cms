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
