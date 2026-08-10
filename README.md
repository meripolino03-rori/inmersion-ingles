# Inmersión Inglés

Sistema de **gestión académica para la adquisición del idioma inglés**, construido con **Laravel 13** y **Filament v5**. Combina un panel administrativo para docentes/administradores con un portal para estudiantes que usa **inteligencia artificial** para generar **planes de estudio personalizados** según el nivel y progreso de cada alumno de acuerdo a la carrera profesional.

## ✨ Características principales

### Panel del docente
- Registro de **calificaciones** (grades) por estudiante, criterio y rúbrica
- Asignación de **evaluaciones** a estudiantes o grupos
- Creación y gestión de **assignments** (tareas/trabajos)
- Visualización del progreso académico de sus estudiantes a cargo

### Panel administrativo (Filament)
- Gestión de **ciclos**, **unidades** y **asignaciones** (assignments)
- **Rúbricas** y **criterios** de evaluación configurables
- Registro y seguimiento de **evaluaciones** y **calificaciones** (grades)
- Administración de **estudiantes**, **docentes** y **colegios/facultades**
- Sistema de **roles y permisos** granular
- Reportes exportables por grupo
- Dashboard con estadísticas y gráficos (calificaciones por habilidad, estudiantes por colegio, etc.)

### Portal del estudiante — aprendizaje con IA
- **Examen de ubicación** (placement exam) para determinar el nivel inicial de inglés del alumno
- **Plan de estudios personalizado**, generado con IA en función del resultado del examen y el avance del estudiante
- **Prácticas** y **retos** (challenges) interactivos adaptados al nivel de cada alumno
- Seguimiento de **progreso** individual a lo largo del ciclo académico
- Asistencia impulsada por IA que acompaña al estudiante durante su proceso de aprendizaje del idioma

## 🛠️ Stack tecnológico

- **Backend:** Laravel
- **Panel admin:** Filament
- **Frontend:** Blade + Tailwind CSS + Vite
- **Permisos:** Spatie Laravel Permission
- **IA:** Integración con Groq
- **Testing:** Pest

## 📋 Requisitos previos

- PHP >= 8.2
- Composer
- Node.js y npm
- MySQL (u otra base de datos compatible con Laravel)

## 🚀 Instalación

```bash
# Clonar el repositorio
git clone https://github.com/meripolino03-rori/inmersion-ingles.git
cd inmersion-ingles

# Instalar dependencias de PHP
composer install

# Instalar dependencias de JS
npm install

# Copiar el archivo de entorno y generar la clave de aplicación
cp .env.example .env
php artisan key:generate

# Configurar la base de datos en el archivo .env
# DB_DATABASE, DB_USERNAME, DB_PASSWORD, etc.

# Ejecutar migraciones y seeders
php artisan migrate --seed

# Compilar assets
npm run build

# Levantar el servidor local
php artisan serve
```

La aplicación quedará disponible en `http://localhost:8000`.

## 🔑 Variables de entorno

Copia `.env.example` a `.env` y configura al menos:

```
APP_NAME=
APP_URL=

DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=

GROQ_API_KEY=
```

## 🧪 Testing

```bash
php artisan test
```

## 📁 Estructura del proyecto

```
app/
├── Filament/          # Recursos, páginas y widgets del panel admin
├── Http/Controllers/  # Controladores (auth, portal de estudiante, IA, reportes)
├── Models/             # Modelos Eloquent (Student, Teacher, Grade, etc.)
├── Policies/           # Autorización por recurso
└── Services/           # Servicios externos (ej. GroqService)

database/
├── migrations/
└── seeders/

resources/
└── views/portal/       # Vistas del portal del estudiante
```

## 📄 Licencia

Este proyecto es de uso educativo/privado.

## 👤 Autora

**Merari Polino**
- GitHub: [@meripolino03-rori](https://github.com/meripolino03-rori)
- LinkedIn: [in/merari-polino](https://linkedin.com/in/merari-polino)
