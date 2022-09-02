# ecfBack_rattrapage

## Installation

Installer le projet sur votre ordinateur local

```bash
  git clone https://github.com/st3rbenn/ecfBack_rattrapage
```

ensuite il faut crée a la racine du projet un fichier .env.local et ajouté ceci 
`DATABASE_URL="mysql://DBUSERNAME:DBPASSWORD@127.0.0.1:3306/ecf_backend"`

pensez a changer DBUSERNAME et DBPASSWORD par leurs valeurs respective

hydrater la BDD a l'aide du fichier sql proposer dans le repo

ensuite il ne vous restera plus qu'a lancé la commande
`npm run full-install` ou `yarn full-install`

enfin suivez les différentes étapes affiché dans le terminal et voila !
