# Authentification Utilisateur — TheTwin

## Vue d'ensemble

Toute la gestion des utilisateurs est sur la branche `feature/user-auth`.
Elle couvre trois fonctionnalités : inscription, connexion et modification du profil.

---

## 1. Entité User

**Fichier :** `src/Entity/User.php`

L'entité implémente `UserInterface` et `PasswordAuthenticatedUserInterface` (requis par Symfony Security).

| Champ       | Type          | Contraintes                        |
|-------------|---------------|------------------------------------|
| id          | int           | Auto-généré                        |
| username    | string (180)  | Unique, NotBlank                   |
| email       | string (180)  | NotBlank, Email valide             |
| firstName   | string (100)  | NotBlank                           |
| lastName    | string (100)  | NotBlank                           |
| password    | string        | Hashé (bcrypt auto)                |
| roles       | JSON          | Défaut : `["ROLE_USER"]`           |

La migration correspondante se trouve dans `migrations/Version20260308200725.php`.

---

## 2. Sécurité

**Fichier :** `config/packages/security.yaml`

- **Provider :** `app_user_provider` — charge l'utilisateur depuis la DB via `username`
- **Firewall `main` :** utilise un authenticator personnalisé + logout + remember_me (7 jours)
- **Hashage :** algorithme `auto` (bcrypt)

---

## 3. Inscription

**Route :** `GET/POST /register` → `app_register`


`src/Controller/RegistrationController.php` -> Traite le formulaire, hash le mot de passe, connecte automatiquement après inscription 
`src/Form/RegistrationFormType.php` -> Champs : username, email, firstName, lastName, plainPassword, agreeTerms 
`templates/registration/register.html.twig` -> Template du formulaire 

**Comportement :**
- Après inscription réussie → connexion automatique → redirect vers `/`
- `UniqueEntity` sur `username` empêche les doublons

---

## 4. Connexion

**Route :** `GET/POST /login` → `app_login`
**Route :** `GET /logout` → `app_logout`


`src/Controller/SecurityController.php` -> Affiche le formulaire, redirige vers `/` si déjà connecté 
`src/Security/LoginFormAuthenticator.php` -> Authentifie via username + password, gère le redirect après login 
`templates/security/login.html.twig` -> Template du formulaire 

**Comportement :**
- Login via **username** (pas email)
- Après login réussi → redirect vers `/` (`app_home`)
- Si une page protégée était visée → redirect vers cette page (via `TargetPathTrait`)
- Case "Se souvenir de moi" → session de 7 jours

---

## 5. Modification du profil

**Route :** `GET/POST /profile/edit` → `app_profile_edit`
**Accès :** uniquement pour les utilisateurs connectés (`#[IsGranted('ROLE_USER')]`)


`src/Controller/ProfileController.php` -> Traite le formulaire, hash le nouveau mot de passe si fourni 
`src/Form/ProfileFormType.php` -> Champs : firstName, lastName, email, newPassword (optionnel) 
`templates/profile/edit.html.twig` -> Template avec layout 2 colonnes pour prénom/nom |

**Comportement :**
- Les champs sont pré-remplis avec les données actuelles
- Le mot de passe est optionnel : laisser vide = aucun changement
- Message flash de succès après sauvegarde
- Redirect vers la même page après soumission

---

## 6. Styles


`assets/styles/app.css` -> Reset, navigation, inputs, bouton primaire, alertes (partagés) 
`assets/styles/auth.css` -> Card login/register, footer, divider 
`assets/styles/profile.css` -> Card profil, layout 2 colonnes, flash success 

Couleur principale : **`#e8622a`** (orange)
Font : **Inter** (Google Fonts)
Les styles sont compilés via Webpack Encore dans `public/build/`.

---

## 7. Routes résumées

| URL              | Nom                | Accès       |
|------------------|--------------------|-------------|
| `/`              | `app_home`         | Public      |
| `/register`      | `app_register`     | Public      |
| `/login`         | `app_login`        | Public      |
| `/logout`        | `app_logout`       | Connecté    |
| `/profile/edit`  | `app_profile_edit` | ROLE_USER   |

---

## 8. Infrastructure

- **Base de données :** MySQL via Docker (`compose.yaml`)
- **Port Docker :** 3307 (3306 déjà utilisé en local)
- **`DATABASE_URL` dans `.env` :** `mysql://app:!ChangeMe!@127.0.0.1:3307/app`
- **Lancer la DB :** `docker compose up -d`
- **Lancer le serveur :** `symfony serve`
- **Builder les assets :** `npm run dev`
