### Mon Petit Placement _ API (Symfony 5.3.9 - ApiPlatform 2.6.6)



### Link :
https://monpetitplacement.herokuapp.com/docs
(admin - password) to get a user


### Timing
- Démarage projet + quelques soucis docker en local : 1 heure
- Configuration JWT : 1 heure
- Entities Configuration and gedmo installation : 1 heure
- Serialisation : 1 heure
- Search Filters + Security Config : 1 heure
- Divers soucis techniques : 2 heures
- Deploiment : 2 heures
- Tentative des tests Behat : 2 heure


### Bundles used
- ApiPlatform
- jwt-auth
- orm-fixtures (dev only)
- Stof doctrine-extensions-bundle (for Timestampable)
- Alice (tests branch)
- Behat (tests branch)

### Commands !

Server Start :
```
docker-compose up
```
Database update
```
docker-compose exec php php bin/console d:s:u --force
```
Generate JWT keys
```
docker-compose exec php sh -c '
set -e
apk add openssl
php bin/console lexik:jwt:generate-keypair
setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
'
```
Load Fixtures (to get a User)
```
docker-compose exec php php bin/console doctrine:fixtures:load
```

Get the User Jwt token (Or get it directly from Swagger)
```
curl -X 'POST' \
'https://localhost/authentication_token' \
-H 'accept: application/json' \
-H 'Content-Type: application/json' \
-d '{
"username": "admin",
"password": "password"
}'
```



### To resume :
- Entities created
- Jwt Authentification configured with username and password
- Fixtures
- Used Gedmo Timestampable
- Filters and Security settings
- Deployement by Heroku
