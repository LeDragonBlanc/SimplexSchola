# Utiliser une image de base Node.js
FROM node:14

# Créer un répertoire de travail
WORKDIR /app

# Copier les fichiers de package et installer les dépendances
COPY package*.json ./
RUN npm install

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Exposer le port sur lequel l'application écoute
EXPOSE 3000

# Commande pour lancer l'application
CMD ["npm", "start"]
