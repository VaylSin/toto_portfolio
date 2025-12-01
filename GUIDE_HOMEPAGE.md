# Guide d'utilisation - Toto Portfolio Theme

## 🎉 Félicitations ! Votre homepage est maintenant créée !

Votre thème WordPress "Toto Portfolio" est maintenant équipé d'une homepage moderne avec :

### ✨ Fonctionnalités implémentées :

#### 1. **Header avec navigation**

- Logo à gauche, menu à droite
- Menu avec ancres pour la homepage (Accueil, À propos, Galeries, Réservation)
- Menu responsive pour mobile
- Effet de transparence au scroll

#### 2. **Slider plein écran**

- Prend 100vh x 100vw comme demandé
- Navigation avec flèches et points
- Lecture automatique configurable
- Support tactile pour mobile
- Images configurables via **Apparence > Personnaliser > Slider**

#### 3. **Trois sections de 100vh**

- **À propos** : Présentation du photographe et services
- **Galeries** : Grille des catégories de galeries avec images
- **Réservation** : Formulaire de contact et informations

#### 4. **Navigation fluide**

- Smooth scrolling entre les sections
- Mise à jour automatique du menu actif au scroll
- Indicateur de scroll sur le slider

### 🛠 Configuration nécessaire :

#### 1. **Configurer le slider**

1. Allez dans **Apparence > Personnaliser**
2. Cliquez sur **"Slider de la page d'accueil"**
3. Ajoutez jusqu'à 5 images
4. Configurez la vitesse de défilement (par défaut : 5 secondes)

#### 2. **Ajouter des galeries**

- Créez des galeries via **Galeries > Ajouter**
- Assignez des catégories pour l'affichage homepage
- Les images apparaîtront automatiquement dans la section Galeries

#### 3. **Personnaliser les informations de contact**

Modifiez le fichier `front-page.php` aux lignes 175-185 pour changer :

- Adresse email
- Numéro de téléphone
- Localisation
- Liens réseaux sociaux

### 📱 Fonctionnalités responsive :

- Header adaptatif avec menu hamburger
- Grille de galeries responsive
- Formulaire de contact optimisé mobile
- Slider avec gestes tactiles

### 🎨 Customisation avancée :

#### Couleurs principales (dans `style.css`) :

- Bleu principal : `#007cba`
- Backgrounds : `#f8f9fa` et `white`
- Texte : `#333`, `#555`, `#666`

#### Polices et tailles :

- Titres sections : `3rem` (desktop), `2rem` (mobile)
- Lead text : `1.25rem`
- Corps de texte : `1rem`

### 🔧 Prochaines étapes suggérées :

1. **Tester la homepage** : Visitez votre site pour voir le résultat
2. **Ajouter du contenu** :
   - Uploadez vos photos dans le slider
   - Créez vos premières galeries
   - Personnalisez le texte "À propos"
3. **Configurer le formulaire** : Le formulaire envoie actuellement un email à l'admin du site
4. **Personnaliser les couleurs** : Adaptez la palette à votre marque

### 💡 Notes techniques :

- **JavaScript** : `homepage.js` gère slider et navigation
- **CSS** : Styles dans `style.css` (sections à partir de la ligne ~450)
- **PHP** : Template `front-page.php` pour la structure
- **Customizer** : Options dans `functions.php` (lignes ~385+)

### 📞 Assistance :

Si vous souhaitez modifier quelque chose, je peux vous aider à :

- Personnaliser les couleurs ou polices
- Modifier la structure des sections
- Ajouter d'autres fonctionnalités
- Optimiser pour le SEO

Votre homepage est maintenant fonctionnelle ! 🚀
