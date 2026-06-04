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

- **Photos** : les visuels sont des emplacements rayés (« photo · … »). Remplacez-les par vos vraies photos d'interventions et les portraits des fondateurs.
- **Carte** : dans `contact.html`, l'emplacement carte peut recevoir une iframe Google Maps.
- **Formulaire** : il ouvre la messagerie vers `contact@ecopurnettoyage.com`. Pour un envoi sans ouverture de boîte mail, branchez un service type [Formspree](https://formspree.io) (un commentaire dans `contact.html` l'indique).
- **Coordonnées** : téléphones, adresse et e-mail sont déjà renseignés ; ajustez si besoin.

## Coordonnées

- 130 avenue Danielle Casanova, 94200 Ivry-sur-Seine
- 06 66 30 24 43 · contact@ecopurnettoyage.com
