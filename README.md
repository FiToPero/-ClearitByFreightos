
1) Primero crear el file .env copiando el contenido de .env.example y completando las credenciales

2) tener docker y docker-compose instalado y ejecutar el comando docker compose up -d para que cree las imagenes y inicie los contenedores.

3) ingresar al contenedor de php con el comando docker compose exec -it php bash

4) una ves dentro ejecutar los siguientes comando 
   -- composer install
   -- npm install
   -- php artisan key:generate
   -- php artisan migrate --seed

5) he iniciar el compilador de vite con el comando npm run dev

6) he ir al navegador la localhost y para el simulador de email la localhost:8025

