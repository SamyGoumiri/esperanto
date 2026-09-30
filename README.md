# Esperanto

> Application web d'apprentissage des langues, inspirée de Duolingo : leçons par unités, exercices, mini-jeu de vocabulaire et tuteur IA.

![PHP](https://img.shields.io/badge/PHP-777BB4?logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL%2FMariaDB-003545?logo=mariadb&logoColor=white)
![HTML/CSS/JS](https://img.shields.io/badge/HTML%20%7C%20CSS%20%7C%20JS-E34F26?logo=html5&logoColor=white)
![Licence](https://img.shields.io/badge/licence-MIT-green)

## Contexte

Projet réalisé en équipe lors du **hackathon du club Devshroom de l'ESST** (École Supérieure des Sciences et de la Technologie), en **2025**. L'objectif était de livrer en un temps très court un prototype fonctionnel de plateforme d'apprentissage des langues.

C'est un prototype de hackathon : il illustre la conception d'un produit complet (authentification, contenu pédagogique, gamification, IA) mais n'est pas destiné à la production en l'état. Voir [Limites connues](#limites-connues).

## Fonctionnalités

- **Authentification** : inscription, connexion, déconnexion, profil et paramètres.
- **4 langues** : français, allemand, espagnol et italien, chacune organisée en 4 unités avec leçons, exercices et tests de fin d'unité.
- **Mini-jeu Word Master** : traduction de mots contre la montre (15, 30 ou 60 secondes) avec meilleur score.
- **Chatbot IA** basé sur l'API Gemini, en trois modes : tuteur, traducteur et partenaire de conversation.
- **Suivi de progression** : le schéma de la base prévoit l'expérience, les séries, les succès et les résultats de tests.

## Stack technique

| Couche | Technologies |
|---|---|
| Backend | PHP (mysqli, requêtes préparées) |
| Base de données | MySQL / MariaDB |
| Frontend | HTML, CSS, JavaScript, Boxicons |
| IA | API Google Gemini, appelée côté serveur via un proxy PHP |

## Structure du projet

```
index.php, index.css         Page d'accueil
config.example.php           Modèle de configuration (clé API Gemini)
database/
  connect.php                Connexion MySQL
  esperanto.sql              Schéma et données de démonstration
content/
  auth/                      Inscription, connexion, déconnexion
  main/
    dashboard.php            Tableau de bord
    french/ german/ italian/ spanish/   Leçons, exercices, tests par langue
    games/word-master/       Mini-jeu de vocabulaire
    chatbot/                 Tuteur, traducteur, conversation et proxy Gemini
docs/                        Présentation du projet (PDF)
```

## Installation

**Prérequis** : PHP 8+ avec l'extension `mysqli` et `curl`, et un serveur MySQL ou MariaDB.

1. Cloner le dépôt :
   ```bash
   git clone https://github.com/SamyGoumiri/esperanto.git
   cd esperanto
   ```
2. Créer la base et importer le schéma :
   ```bash
   mysql -u root -e "CREATE DATABASE Esperanto CHARACTER SET utf8mb4"
   mysql -u root Esperanto < database/esperanto.sql
   ```
3. Adapter si besoin les identifiants MySQL dans `database/connect.php` (par défaut : `localhost`, `root`, sans mot de passe).
4. *(Optionnel, pour le chatbot)* Créer sa propre clé sur [Google AI Studio](https://aistudio.google.com/apikey), puis :
   ```bash
   cp config.example.php config.php
   ```
   et renseigner `gemini_api_key` dans `config.php`. Ce fichier est ignoré par Git.
5. Lancer le serveur et ouvrir http://localhost:8000 :
   ```bash
   php -S localhost:8000
   ```

Il suffit ensuite de créer un compte depuis la page d'inscription.

## Limites connues

- Prototype de hackathon : pas de tests automatisés, pas de protection CSRF, identifiants MySQL en dur dans `database/connect.php`.
- Sans clé Gemini dans `config.php`, les pages du chatbot s'affichent mais les réponses de l'IA échouent.
- Le modèle Gemini par défaut (`gemini-1.5-flash-latest`) est configurable dans `config.php` ; il peut avoir été retiré par Google.

## Équipe

Projet réalisé par l'équipe du hackathon, dont les contributeurs GitHub suivants :

- [Samy Goumiri](https://github.com/SamyGoumiri)
- [Ahmed Allali](https://github.com/ahmed1802)
- [elaminemahmoud-lab](https://github.com/elaminemahmoud-lab)
- [Lotfi Akachouche](https://github.com/Lotfi-Akachouche)
- [xBillCipherx](https://github.com/xBillCipherx)
- [Saberyns](https://github.com/Saberyns)

## Licence

Distribué sous licence [MIT](LICENSE).
