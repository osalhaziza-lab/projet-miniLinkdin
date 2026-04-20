Mini LinkedIn — API Backend Laravel
Projet de fin de module — Programmation Backend avec Laravel  
Département Génie Informatique et IA
---
Description
Mini LinkedIn est une API REST backend construite avec Laravel permettant de mettre en relation des candidats et des recruteurs. Un candidat peut créer son profil, publier ses compétences et postuler à des offres d'emploi. Un recruteur peut publier des offres et consulter les candidatures reçues. Un administrateur supervise l'ensemble de la plateforme.
---
Équipe
AYA SMALI — ProfilController, OffreController, Events (CandidatureDeposee, StatutCandidatureMis),factories&seeders
AZIZA OSALH — CandidatureController, AdminController, Listeners, Auth-JWT
---
Prérequis
PHP >= 8.1
Composer
MySQL
Laravel 10+
Package JWT : `tymon/jwt-auth`
---
Installation
1. Cloner le projet
```bash
git clone https://github.com/osalhaziza-lab/projet-miniLinkdin.git
cd projet-miniLinkdin
```
2. Installer les dépendances
```bash
composer install
```
3. Configurer l'environnement
```bash
cp .env.example .env
```
Modifier le fichier `.env` :
```env
DB\_CONNECTION=mysql
DB\_HOST=127.0.0.1
DB\_PORT=3306
DB\_DATABASE=projet
DB\_USERNAME=root
DB\_PASSWORD=
```
4. Générer la clé de l'application
```bash
php artisan key:generate
```
5. Générer la clé JWT
```bash
php artisan jwt:secret
```
6. Créer les tables et remplir la base de données
```bash
php artisan migrate
php artisan db:seed
```
>  Assurez-vous que MySQL est démarré WAMP avant cette étape.
7. Lancer le serveur
```bash
php artisan serve
```
L'API sera accessible sur : `http://127.0.0.1:8000`
---
 Workflow Git — Branches
Le projet a été développé en suivant un workflow par feature branches. Chaque fonctionnalité a été développée dans une branche dédiée, mergée dans `dev`, puis dans `main`.
```
main
 └── dev
      ├── feature/auth-jwt              → Authentification JWT (register, login, logout, refresh)
      ├── feature/profil-controller     → ProfilController (CRUD profil + compétences)
      ├── feature/offre-controllers     → OffreController (CRUD offres + filtres + pagination)
      ├── feature/candidature-admin     → CandidatureController + AdminController
      └── feature/events                → Events CandidatureDeposee + StatutCandidatureMis
```
Étapes suivies :
Création du projet Laravel et configuration initiale
Mise en place des migrations (users, profils, compétences, offres, candidatures)
Création des modèles Eloquent avec leurs relations
Création des factories et seeders (2 admins, 5 recruteurs, 10 candidats)
Mise en place de l'authentification JWT (`tymon/jwt-auth`)
Développement du `ProfilController` sur `feature/profil-controller`
Développement du `OffreController` sur `feature/offre-controllers`
Développement du `CandidatureController` et `AdminController` sur branche dédiée
Implémentation des Events & Listeners sur `feature/events`
Merge de chaque branche dans `dev` via Pull Request
Merge final de `dev` dans `main`
---
 Note importante — Branches vides
> \*\*À l'attention du professeur :\*\*
>
> Les branches `feature/candidature ET feature/Admin` créées par \*\*AZIZA\*\* apparaissent vides sur GitHub.
> Cela est dû à une erreur de manipulation Git : AZIZA a codé le `CandidatureController` et l'`AdminController`
> localement mais a oublié de faire `git add` et `git commit` avant de pusher la branche.
> Les fichiers ont donc été pushés \*\*vides\*\* (générés par `php artisan make:controller` sans le code).
>
> Le code a ensuite été ajouté et pushé \*\*directement dans la branche `dev`\*\* pour ne pas bloquer
> l'avancement du projet. Le contenu du `CandidatureController` et de l'`AdminController`
> est bien présent et fonctionnel dans la branche `dev` et `main`.
>
> — \*\*AYA \& AZIZA\*\*
---
 Récapitulatif des Routes
 Routes publiques
Méthode	Route	Description
POST	`/api/register`	Créer un compte (candidat ou recruteur)
POST	`/api/login`	Se connecter et obtenir un token JWT
 Routes protégées (auth:api)
Auth
Méthode	Route	Description
POST	`/api/logout`	Se déconnecter
POST	`/api/refresh`	Renouveler le token JWT
GET	`/api/me`	Voir son propre compte
Profil (candidat uniquement)
Méthode	Route	Description
POST	`/api/profil`	Créer son profil (une seule fois)
GET	`/api/profil`	Consulter son profil
PUT	`/api/profil`	Modifier son profil
POST	`/api/profil/competences`	Ajouter une compétence avec niveau
DELETE	`/api/profil/competences/{competence\_id}`	Retirer une compétence
Offres d'emploi
Méthode	Route	Description
GET	`/api/offres`	Liste des offres actives (pagination + filtres)
GET	`/api/offres/{offre}`	Détail d'une offre
POST	`/api/offres`	Créer une offre (recruteur uniquement)
PUT	`/api/offres/{offre}`	Modifier une offre (recruteur propriétaire)
DELETE	`/api/offres/{offre}`	Supprimer une offre (recruteur propriétaire)
> Filtres disponibles : `?type=CDI|CDD|stage` et `?localisation=ville`  
> Pagination : 10 offres par page — `?page=2`  
> Tri : par date de création décroissante
Candidatures
Méthode	Route	Description
POST	`/api/offres/{offre}/postuler`	Postuler à une offre (candidat)
GET	`/api/mes-candidatures`	Voir ses propres candidatures (candidat)
GET	`/api/offres/{offre}/candidatures`	Voir les candidatures reçues (recruteur propriétaire)
PUT	`/api/candidatures/{candidature}/statut`	Changer le statut d'une candidature (recruteur)
Administration (admin uniquement)
Méthode	Route	Description
GET	`/api/admin/users`	Liste de tous les utilisateurs
DELETE	`/api/admin/users/{user}`	Supprimer un compte utilisateur
PUT	`/api/admin/offres/{offre}/toggle`	Activer / désactiver une offre
---
 Règles d'autorisation
Un recruteur ne peut modifier ou supprimer que ses propres offres → `403` sinon
Un candidat ne peut consulter que ses propres candidatures → `403` sinon
Seul un admin peut accéder aux routes `/api/admin/\*` → `403` sinon
Un candidat ne peut postuler qu'une seule fois à la même offre
---
 Rôles disponibles
Rôle	Permissions
`candidat`	Gérer son profil, consulter les offres, postuler
`recruteur`	Publier des offres, consulter les candidatures reçues
`admin`	Superviser tous les utilisateurs et toutes les offres
---
 Events & Listeners
Event	Listener	Déclencheur	Log
`CandidatureDeposee`	`LogCandidatureDeposee`	Quand un candidat postule	`storage/logs/candidatures.log`
`StatutCandidatureMis`	`LogStatutCandidatureMis`	Quand le statut d'une candidature change	`storage/logs/candidatures.log`
---
 Structure du projet
```
app/
├── Events/
│   ├── CandidatureDeposee.php
│   └── StatutCandidatureMis.php
├── Http/Controllers/
│   ├── AuthController.php
│   ├── ProfilController.php
│   ├── OffreController.php
│   ├── CandidatureController.php
│   └── AdminController.php
├── Listeners/
│   ├── LogCandidatureDeposee.php
│   └── LogStatutCandidatureMis.php
├── Models/
│   ├── User.php
│   ├── Profil.php
│   ├── Competence.php
│   ├── Offre.php
│   └── Candidature.php
database/
├── migrations/
├── factories/
└── seeders/
routes/
└── api.php
```
---
 Tester l'API avec Postman
Importer la collection Postman disponible dans le repo : `miniLinkedIn.json`
Faire un POST /api/login pour obtenir le token JWT
Toutes les routes protégées utilisent `{{token}}` via Authorization Bearer
---
 Données de test (Seeders)
Rôle	Nombre	Mot de passe
Admin	2	`password`
Recruteur	5 (avec 2-3 offres chacun)	`password`
Candidat	10 (avec profil et compétences)	`password`
