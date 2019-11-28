# Modèle React

Bienvenue dans ce modèle/template de projet React !

Il va vous servir de base de travail pour :

- travailler sur un challenge récupéré depuis classroom
- démarrer un nouveau projet

Il contient tout ce qu'il faut pour écrire une application React avec du code ES6+.

## Première utilisation

**Récupérez en local une copie du modèle :**

```sh
git clone git@github.com:O-clock-Vortex/React-modele.git
```

Testez que le modèle fonctionne correctement :

``` sh
cd React-modele

yarn install # ou "npm install" - installe les dépendances du projet

yarn start # ou "npm start" - lance le serveur de développement Webpack
```

Direction http://localhost:3000/ pour constater que le modèle tourne ! Ok, c'est super, mais…

## Comment utiliser le modèle dans un autre projet ?

Le but du modèle n'est pas de le regarder tourner, mais bien de l'utiliser pour démarrer un *nouveau* projet ou pour l'intégrer à un projet / challenge _existant_. Dans les deux cas, il va concrètement falloir copier/coller les parties intéressantes du modèle dans le dossier du projet où on veut l'utiliser, en faisant attention à ne pas écraser les éventuels fichiers existants.

Plus facile à dire qu'à faire, donc **on vous conseille d'utiliser la procédure suivante :**

``` sh
# Après avoir cloné le repo :

yarn link # reproduit une installation (globale) de module !
```

À partir de maintenant, **une commande `react-modele` est disponible** partout :

``` sh
# Crée un nouveau projet en se basant sur le modèle :
react-modele ~/un-nouveau-projet
```

``` sh
# Importe le modèle dans le challenge existant, sans écraser les fichiers existants :
cd ~/oclock/challenge-existant
react-modele
```

<details>
<summary>Que fait la commande <code>react-modele</code> ?</summary>

``` sh
# Exemple : un projet ou un challenge se trouve dans mon-projet/

# on se place dans le dossier du projet dans lequel intégrer le modèle React
cd mon-projet

# on copie les fichiers (non-cachés) présents à la racine du modèle React
# note : des alertes sont affichées à propos de dossiers ignorés, c'est normal
cp -n ../React-modele/* .

# on copie les fichiers (cachés) présents à la racine du modèle React
# note : des alertes sont affichées à propos de dossiers ignorés, c'est normal
cp -n ../React-modele/.* .

# on fait une copie (récursive) du dossier src/ du modèle React
cp -nr ../React-modele/src .
```

</details>

## Build du projet

Par défaut, `yarn start` lance le projet React en mode développment, avec webpack-dev-server. C'est pratique pour développer, mais on ne voit jamais le résultat concret du travail de Webpack/Babel, car tout est géré en mémoire (ie. rien n'est généré dans le dossier dist/). On peut toutefois demander à Webpack de générer un build de prod (dans le dossier dist/).

En résumé :

- `yarn build:dev` pour faire un build de prod mais sans traitements particuliers ;
- `yarn build:prod` pour faire un build de prod avec minification et optimisation des fichiers en plus (version 100% prête pour hébergement).

```sh
cd mon-projet

# build de dev : les fichiers sont rassemblés en mémoire et directement envoyés au navigateur
yarn build:dev

# build de prod : les fichiers sont rassemblés *et optimisés*, puis écrits sur le disque dur
yarn build:prod
```

## Contenu du modèle

---

**STOP -- Ce modèle React est déjà prêt à l'emploi : les informations & commandes ci-dessous sont simplement indiquées pour mémoire / pour expliquer la construction du modèle => ne pas les lancer ! -- STOP**

---

### Dépendances de développement

#### [Webpack](https://webpack.js.org/)

*Task Runner* & *Builder* — Webpack est un chef d'orchestre qui permet d'automatiser et/ou coordonner certaines tâches : transpilations par Babel, conversion Sass vers CSS, optimisation du build (minification etc.), …

``` sh
# Webpack
yarn install --dev webpack webpack-cli
# serveur de developpement
yarn install --dev webpack-dev-server
# Plugins
yarn install --dev html-webpack-plugin
yarn install --dev mini-css-extract-plugin
yarn install --dev optimize-css-assets-webpack-plugin
yarn install --dev uglifyjs-webpack-plugin
```

Fichier de configuration :

- webpack.config.js

#### [Babel](https://babeljs.io/)

Transpilation (pour ce modèle : ES6/JSX -> ES5).

``` sh
# Babel
yarn install --dev babel-core
# Babel pour webpack
yarn install --dev babel-loader
# vocabulaire ES6 -> ES5 de base
yarn install --dev babel-preset-env
# vocabulaire React
yarn install --dev babel-preset-react
# Plugin : propriétés de classes
yarn install --dev babel-plugin-transform-class-properties
# Plugin : rest et spread operator pour les objets
yarn install --dev babel-plugin-transform-object-rest-spread
```

Fichier de configuration :

- .babelrc

#### [ESLint](https://eslint.org/)

_Linter_ pour JavaScript (détection des erreurs de syntaxe / logiques).

``` sh
# ESLint
yarn install --dev eslint
# Config ESLint
yarn install --dev eslint-config-airbnb babel-eslint
# ESLint résolution des imports
yarn install --dev eslint-import-resolver-webpack
yarn install --dev eslint-plugin-import 
# ESLint pour React
yarn install --dev eslint-plugin-jsx-a11y eslint-plugin-react
```

Fichiers de configuration :

- .eslintrc
- .eslintignore

#### CSS ([Sass](https://sass-lang.com/), [PostCSS](https://postcss.org/), [autoprefixer](https://github.com/postcss/autoprefixer))

Ensembles d'outils pour écrire & générer du CSS en utilisant des fonctionnalités avancées (variables, fonctions…)

``` sh
# Traitement des styles et assets
yarn install --dev style-loader css-loader file-loader
# PostCSS et autoprefixer
yarn install --dev postcss autoprefixer postcss-loader
# SASS
yarn install --dev node-sass sass-loader
```

### Dépendances de production

#### Utilitaires

``` sh
# https://babeljs.io/docs/en/babel-polyfill/
yarn install babel-polyfill
```

#### [React](https://reactjs.org/)

```sh
yarn install react react-dom
```

### Outils pratiques à installer en complément du modèle

#### Extension « React Dev Tools »
  
- [pour Chrome](https://chrome.google.com/webstore/detail/react-developer-tools/fmkadmapgofadopljbjfkapdkoienihi)
- [pour Firefox](https://addons.mozilla.org/en-US/firefox/addon/react-devtools/)
