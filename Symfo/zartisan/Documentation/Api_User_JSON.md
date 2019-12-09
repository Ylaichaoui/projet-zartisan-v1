
## Routes api particulier Front->Back->Front

### GET /api/v1/user/single
#### api_user_single
On recupère l'email de l'utilisateur pour vérifier si exeistant.
```
{
    "email":"fsfsdf@oclock.io"
}
```

on affiche toutes les données de celui-ci.

```
{
    "id":1,
    "email":"fsdf@oclock.io",
    "roles":
        [json
    "mailtoken":"gdfgdfgg231g321g1",
    "isConfirmMail":true,
    "isStatus":"true",
    "firstname":"prénom",
    "lastname":"nom",
    "birdthday":"1982-10-12",
    "adressSupp":"adresse suplémentaire",
    "specialDistribution":"ipsimu",
    "extnumberWay":1,
    "typeWay":"rue de",
    "way":"Mozard",
    "postalCode":75120,
    "city":"Paris",
    "phone":0645201023,
    "picture":"public/assets/images/idnomprenom/imgavatarcreatedAt",
    "createdAt":"2019-12-02T23:21:40+01:00",
    "updatedAt":"2019-12-02T23:21:40+01:00",
    "nickname":"pseudo"
} 
```

### POST /api/v1/user/edit
#### api_user_edit
Création, modification du profil de l'utilisateur.
On recupère l'email de l'utilisateur pour vérifier si existant.
```
{
    "email":"fsfsdf@oclock.io"
}
```
Si l'utilisateur a un role user et est enable, on injectre dans la base de données les données reçues.
on récupère les informations enregistées par l'utilisateur pour les mettre en base de données.
on recupère som email, son nom, son prénom, sa date de naissance, son adresse suplémentaire, sson adresse de distribution, son numéro externe de la voie, le type de voie, le nom de la voie, le code postal,la ville, le numéro de téléphone, l'avatar, le pseudo de l'utilisateur.

```
{
    "id":2,
    "email":"fsf@oclock.io",
    "firstname":"prénom",
    "lastname":"nom",
    "birdthday":"1982-10-12",
    "adressSupp":"adresse suplémentaire",
    "specialDistribution":"ipsimu",
    "extnumberWay":1,
    "typeWay":"rue de",
    "way":"Mozard",
    "postalCode":75120,
    "city":"Paris",
    "phone":0645201023,
    "picture":"public/assets/images/idnomprenom/imgavatarcreatedAt",
    "nickname":"pseudo"
}
```

### GET /api/v1/user/delete
#### api_user_delete
On recupère l'email de l'utilisateur pour vérifier si existant.
On passe l'utilisateur à l'état disable et on garde les données en base.
on récupère l'id de l'utilisateur, son email.

```
{
    "email":"fsfsdf@oclock.io"
}
```


### POST /api/v1/advice/add
#### api_advice_add
Ajout par un utilisateur connecté d'un avis sur un artisan en consultation
on récupère l'email de l'utilisateur, l'avis posté, l'id de l'auteur, l'id de l'artisan
```
{
    "email":1,
    "body":"lorem ipsumloremipsum",
    "artisanid":5
}

```
on renvoie l'avis

```
{
    "id":1,
    "body":"lorem ipsumloremipsum"
}

```