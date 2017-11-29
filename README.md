# UNNAMED AKA DENSIPROM

Microservicios de apoyo para software de Groupalia, Letsbonus, etc.

Está compuesto por los siguientes modulos:

### Adwords
Hace cosas

### Analytics
Hace cosas

### Densilo
Hace cosas

### FeedGroupalia
Hace cosas

### Geolocation
Servicio que traduce coordenadas/direcciones utilizando una API externa configurable.

### PixelTracking
Hace cosas

---

# Instalación

1. Clonar este repositorio
2. Ejecutar `composer install` sobre el directorio raíz
3. Definir un archivo `app/config/company.yml` con la siguiente sintaxis adaptada a la empresa que esté implementando el proyecto
    <pre>
    company:
        company_name: Company Name
        company_slug: companyname
    </pre>

4. Crear la base de datos y su esquema desde la consola

   `php bin/console doctrine:database:create`

   `php app/console doctrine:schema:update --force`

5. Instalar los Data Fixtures desde la consola

    `php bin/console doctrine:fixtures:load`

6. ???

7. Profit

