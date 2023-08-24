
### CONFIGURACIÓN Y INSTALACIÓN DE LA APLICACIÓN EN UN ENTORNO LOCAL CON WINDOWS Y WSL2

### Paso 1: Instalar Docker Desktop
    -Descargar Docker Desktop desde aquí https://www.docker.com/products/docker-desktop/-
    -Completar la instalación siguiendo las instrucciones. 
    -Asegurarse de que Docker Desktop esté en funcionamiento.

### Paso 2: Activar la Virtualización
    -Reiniciar el ordenador y acceder a la BIOS (presionar F2 o Supr durante el arranque).
    -Activar la opción de virtualización (puede llamarse "Virtualization Technology" o "Intel Virtualization Technology").

### Paso 3: Instalar Windows Terminal
    -Abrir Microsoft Store desde el menú Inicio.
    -Buscar "Windows Terminal" en la barra de búsqueda.
    -Seleccionar "Windows Terminal" y hacer clic en "Instalar".

### Paso 4: Instalar Ubuntu 20.04
    -Abrir Microsoft Store desde el menú Inicio.
    -Buscar "Ubuntu 20.04" en la barra de búsqueda.
    -Seleccionar "Ubuntu 20.04" y hacer clic en "Instalar".

### Paso 5: Clonar el Repositorio
    -Abrir Ubuntu Terminal (buscar "Terminal" en la barra de búsqueda y seleccionar la de Ubuntu).
    -Navegar a la ubicación deseada:
     cd /ruta/del/directorio

    -Clonar el repositorio:
     git clone https://github.com/DanielSalvador94/prueba_tecnica_daniel.git

### Paso 6: Acceder al Repositorio del Proyecto
    -En la terminal de Ubuntu, acceder al directorio del proyecto:
     cd prueba_tecnica_daniel

    -Ejecutar en la terminal
     docker run --rm \
     -u "$(id -u):$(id -g)" \
     -v $(pwd):/var/www/html \
     -w /var/www/html \
     laravelsail/php81-composer:latest \
     composer install --ignore-platform-reqs

### Paso 7 Configurar el Entorno y la Base de Datos
    -Duplicar el archivo .env.example y renómbrarlo como .env:
     cp .env.example .env

### Paso 8: Inicializar Laravel Sail con Docker
    Iniciar Laravel Sail usando Docker:

    ./vendor/bin/sail up -d

### Paso 9: Cambiar Alias para Laravel Sail

    -Abrir el archivo .zshrc con el comando:
     nano ~/.zshrc

    -Agregar la siguiente línea para definir un alias para Laravel Sail:
     alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'

    -Guardar y cerrar el archivo.

### Paso 10 Configurar el Entorno y la Base de Datos
    -Generar la clave de la aplicación:
     sail php artisan key:generate

    -Generar las tablas y datos de la base de datos:
     sail artisan migrate --seed

    -Instalar paquete NPM
     sail npm install

### Paso 11: Iniciar la Aplicación en Local
    -Iniciar la compilación de los recursos de la aplicación:
     sail npm run dev

### Paso 12 Acceder al navegador
    -Escribir en la barra de navegador http://localhost/
