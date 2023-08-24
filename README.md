
## 1 CONFIGURACIÓN Y INSTALACIÓN DE LA APLICACIÓN EN UN ENTORNO LOCAL CON WINDOWS Y WSL2

He optado por crear un entorno local Dockerizado utilizando Laravel Sail y Mysql desde cero. Esto me ha permitido establecer un entorno de desarrollo consistente y aislado que facilita el desarrollo, las pruebas y la identificación temprana de problemas en mi aplicación Laravel.

Los pasos para su instalacion son:

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

### Paso 7: Configurar el Entorno y la Base de Datos
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

### Paso 10: Configurar el Entorno y la Base de Datos
    -Generar la clave de la aplicación:
     sail php artisan key:generate

    -Generar las tablas y datos de la base de datos:
     sail artisan migrate --seed

    -Instalar paquete NPM
     sail npm install

### Paso 11: Iniciar la Aplicación en Local
    -Iniciar la compilación de los recursos de la aplicación:
     sail npm run dev

### Paso 12: Acceder al navegador
    -Escribir en la barra de navegador http://localhost/


## 2 ANALISIS DE RENDIMIENTO EN LAS CONSULTAS

 ### Uso de "Benchmarking":
  -He aprovechado la herramienta incorporada en Laravel conocida como "Benchmarking" para medir con precisión el tiempo que lleva ejecutar consultas hacia la base de datos. Esto me permite tener una idea clara del rendimiento de mi aplicación y detectar posibles cuellos de botella en las consultas.
 ### Uso de "Eager Loading":
  -He implementado la estrategia de "eager loading" en determinadas consultas de mi aplicación. Esta técnica me permite cargar relaciones asociadas de manera anticipada, lo que reduce drásticamente el número de consultas ejecutadas en la base de datos. Al cargar relaciones específicas de antemano, evito el problema de "N + 1" consultas, lo que a su vez mejora 
   significativamente la eficiencia y el tiempo de respuesta de mi aplicación.
 ### Uso de metodos para optimizar consultas:
  -He aplicado métodos específicos de optimización de consultas provistos por Laravel, como "sync" y "attach". Estos métodos me permiten realizar operaciones de sincronización y vinculación de manera eficiente, reduciendo así la cantidad de consultas que se necesitan para realizar tareas como actualizar categorías asociadas a tareas. Esta optimización no solo 
  agiliza las operaciones, sino que también contribuye a un mejor rendimiento general de la base de datos.

  En conjunto, al utilizar estas estrategias, he logrado mejorar el rendimiento de mi aplicación al reducir el número de consultas realizadas, reduciendo la latencia y mejorando la experiencia del usuario. La combinación de Benchmarking, Eager Loading y métodos de optimización específicos me ha permitido crear una aplicación más rápida y eficiente
