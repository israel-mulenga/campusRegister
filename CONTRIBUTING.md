# Guide de Contribution

Merci de prendre le temps de contribuer à ce projet ! Pour maintenir la qualité du code et assurer une collaboration fluide au sein de l'équipe, nous suivons un workflow Git strict. Merci de respecter les règles suivantes.

---

## 1. Gestion des Branches

Le dépôt principal contient une branche stable : `main`. **Il est strictement interdit de push directement sur cette branche.**

Toute nouvelle fonctionnalité, correction de bug ou modification doit être développée sur une branche dédiée.

### Nommage des branches
Utilisez un préfixe explicite suivi d'un nom court en *kebab-case* (séparé par des tirets) :

* **Fonctionnalité :** `feat/nom-de-la-feature`
* **Correction de bug :** `fix/nom-du-bug`
* **Documentation :** `docs/titre-doc`
* **Refactorisation / Amélioration :** `refactor/nom-de-la-modif`
* **Optimisation :** `perf/nom-de-l-optimisation`

### Exemple :

```zsh
git checkout -b feat/ajout-authentification
```

## 2. Règle des Commits

Pour garder un historique clair et lisible, nous adoptons la convention des **Conventional Commits.** Chaque message de commit doit être rédigé en minuscules et structuré de la manière suivante :

<type>: <description courte et claire en français>

### Les types autorisés :
- **`feat` :** Ajout d'une nouvelle fonctionnalité.
- **`fix` :** Correction d'un bug.
- **`docs` :** Modifications de la documentation.
- **`style` :** Changements qui n'affectent pas le sens du code (espaces, mise en forme, point-virgule manquant, etc.).
- **`refactor` :** Modification du code qui ne corrige pas un bug et n'ajoute pas de fonctionnalité.
- **`test` :** Ajout ou modification de tests unitaires.
- **`chore` :** Mise à jour des tâches de build, configuration des outils, dépendances, etc.

### Exemples :

```zsh
git commit -m "feat: ajouter le formulaire de connexion"
git commit -m "fix: corriger l'erreur d'affichage du profil"
```

## 3. Processus de Pull Request (PR)

Une fois vos modifications terminées, vous devez ouvrir une Pull Request pour fusionner votre branche vers la branche principale.

### Étapes à suivre :

1. **Mettre à jour votre branche :** Avant d'ouvrir la PR, récupérez les dernières modifications de la branche principale pour éviter les conflits.

```zsh
git checkout main
git pull origin main
git checkout votre-branche
git merge main
```
2. **Ouvrir la Pull Request :** Allez sur la plateforme (GitHub/GitLab) et créez la PR

3. **Titre et Description :** Donnez un titre explicite à votre PR et décrivez brièvement les changements apportés, le pourquoi, et comment tester.

4. **Revue de code (Code Review) :** Assignez au moins un membre de l'équipe pour relire votre code.

5. **Validation et Fusion :** La PR ne pourra être fusionnée que si :
- Les tests automatiques (si existants) passent au vert.
- Elle a reçu au moins une approbation (Approve).
- Il n'y a aucun conflit.

## 4. cycle de travail résumé
Pour résumer, voici la routine à suivre au quotidien :

1. Mettre à jour son dépôt local :`git pull origin main`
2. Créer sa branche :`git checkout -b feat/ma-feature`
3. Travailler et faire des commits réguliers :`git commit -m "feat: ..."`
4. Pousser sa branche :`git push origin feat/ma-feature`
5. Ouvrir une PR et attendre la validation de l'équipe.

*Merci pour vos contributions !*