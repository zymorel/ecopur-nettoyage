# ECOPUR Nettoyage — Site vitrine

Site vitrine statique (HTML / CSS) de l'entreprise de propreté **ECOPUR Nettoyage**, basée à Ivry-sur-Seine (94). Aucune dépendance, aucun build : il suffit de déposer les fichiers sur un hébergement web.

## Pages

| Fichier | Page |
|---|---|
| `index.html` | Accueil |
| `services.html` | Services (9 prestations) |
| `a-propos.html` | À propos / fondateurs |
| `contact.html` | Contact + formulaire de devis |
| `404.html` | Page d'erreur |

Le style commun est dans `assets/style.css`, le logo dans `assets/logo.png`.

## Aperçu en local

Ouvrez simplement `index.html` dans un navigateur, ou lancez un petit serveur :

```bash
python -m http.server 8000
# puis http://localhost:8000
```

## Déploiement sur Hostinger via GitHub

1. **Pousser le code sur GitHub** (voir section suivante).
2. Dans le **hPanel Hostinger** : `Sites web` → votre domaine → `Avancé` → `GitHub`.
3. **Connecter le compte GitHub**, choisir le dépôt `ecopur-nettoyage` et la branche `main`.
4. Hostinger déploie le contenu à la racine `public_html`. Activez le **déploiement automatique** pour que chaque `git push` mette le site à jour.
5. Vérifiez que le site répond bien sur votre domaine.

> Les fichiers étant à la racine du dépôt, aucun réglage de sous-dossier n'est nécessaire.

## Pousser sur GitHub

```bash
git init
git add .
git commit -m "Site vitrine ECOPUR Nettoyage"
git branch -M main
git remote add origin https://github.com/<votre-compte>/ecopur-nettoyage.git
git push -u origin main
```

## À personnaliser avant la mise en ligne

- **Photos** : des photos de démonstration (libres, dans `assets/img/`) sont en place pour l'accueil, la page À propos et les portraits des fondateurs. Remplacez-les par vos vraies photos en gardant les mêmes noms de fichiers, ou ajustez les chemins dans le HTML.
- **Carte** : une carte Google Maps centrée sur le 130 av. Danielle Casanova est intégrée dans `contact.html`.
- **Formulaire** : les demandes sont envoyées directement à `contact@ecopurnettoyage.com` par le script `envoi.php` (fonction `mail()` de Hostinger). Aucun service tiers requis. Voir la section ci-dessous.
- **Coordonnées** : téléphones, adresse et e-mail sont déjà renseignés ; ajustez si besoin.

## URL propres (sans .html)

Le fichier `.htaccess` (Apache / Hostinger) donne des adresses réalistes :

- `ecopurnettoyage.com/` (accueil)
- `ecopurnettoyage.com/services`
- `ecopurnettoyage.com/a-propos`
- `ecopurnettoyage.com/contact`

Toute ancienne adresse en `.html` (ex. `/services.html`) est **redirigée** (301) vers
la version propre, et `/index.html` renvoie vers `/`. Les liens internes du site sont
déjà écrits sans extension.

> Ces règles ne s'appliquent **qu'en ligne sur Hostinger** (serveur Apache). En aperçu
> local via `python -m http.server`, les URL propres ne fonctionnent pas : ouvrez alors
> directement `index.html`, `services.html`, etc.

## Formulaire de contact (envoi.php)

Le formulaire de la page Contact poste vers `envoi.php`, qui envoie un e-mail à
`contact@ecopurnettoyage.com` via la fonction `mail()` de Hostinger.

- **Hostinger exécute PHP nativement** : rien à installer.
- L'e-mail part depuis une adresse du domaine (`From: contact@ecopurnettoyage.com`) et
  le `Reply-To` est celui du visiteur, pour répondre en un clic.
- Un champ caché anti-spam (honeypot) filtre les robots.
- Avec JavaScript : envoi en arrière-plan, message de confirmation sans quitter la page.
- Sans JavaScript : le formulaire est posté puis redirige vers `contact.html?envoi=ok`.

> **Important** : ce formulaire ne fonctionne **qu'une fois en ligne sur Hostinger**
> (ou tout hébergement PHP). En ouvrant `contact.html` en local (file://), le PHP ne
> s'exécute pas. Pour tester en local, lancez un serveur PHP : `php -S localhost:8000`.
>
> Si les e-mails n'arrivent pas, vérifiez dans le hPanel que la boîte
> `contact@ecopurnettoyage.com` existe, et regardez le dossier spam.

## Coordonnées

- 130 avenue Danielle Casanova, 94200 Ivry-sur-Seine
- 06 66 30 24 43 · contact@ecopurnettoyage.com
