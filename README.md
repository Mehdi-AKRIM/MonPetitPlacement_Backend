### Mon Petit Placement _ API (Symfony 5.3 - ApiPlatform 2.6.6)




### Timing
- Démarage projet + quelques soucis docker en local : 1 heure



### Bundles used
- ApiPlatform
- jwt-auth
- orm-fixtures (dev only)

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

Get the User Jwt token (Or get it directly form Swagger)
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


Try Tests
```
docker-compose exec php php bin/phpunit
```
