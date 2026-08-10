<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Intranet</title>
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    @keyframes fadeIn {
      from { opacity: 0; transform: translateX(-20px); }
      to { opacity: 1; transform: translateX(0); }
    }
  </style>
</head>

<body class="h-screen flex overflow-hidden">

  <!-- IZQUIERDA LOGIN -->
  <div class="w-full md:w-1/3 bg-white flex flex-col justify-center px-10 py-12 
              animate-[fadeIn_0.8s_ease-out] shadow-2xl">

    <div class="w-full max-w-sm mx-auto">
      
      <div class="mb-4">
        <img src="images/banner.png" class="w-full max-w-[260px] mx-auto">
      </div>

      <div class="h-1 w-full bg-gradient-to-r from-blue-500 to-indigo-500 rounded mb-6"></div>

      <div class="text-center mb-8">
        <h2 class="text-lg font-semibold text-gray-700 uppercase tracking-wide">
          Sistema de Inmersión Lingüística
        </h2>
      </div>

      <form class="space-y-5" action="{{ route('login') }}" method="POST">
        @csrf

        <div>
          <label class="text-sm text-gray-600 font-medium">Correo electrónico</label>
          <input type="email" name="email"
            class="w-full mt-1 p-3 rounded-lg border border-gray-300 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 
                   transition duration-300"
            placeholder="Ingresa tu correo">
        </div>

        <div>
          <div class="flex justify-between text-sm text-gray-600 font-medium">
            <label>Contraseña</label>
            <a href="#" class="text-blue-500 hover:underline text-xs">
              ¿Olvidaste tu contraseña?
            </a>
          </div>

          <input type="password" name="password"
            class="w-full mt-1 p-3 rounded-lg border border-gray-300 
                   focus:outline-none focus:ring-2 focus:ring-blue-500 
                   transition duration-300"
            placeholder="Ingresa tu contraseña">
        </div>

        <div class="flex items-center text-sm text-gray-600">
          <input type="checkbox" class="mr-2 accent-blue-600">
          Recordarme
        </div>

        <button type="submit"
          class="w-full py-3 bg-blue-600 hover:bg-blue-700 text-white 
                 rounded-lg font-semibold transition transform 
                 hover:scale-[1.02] active:scale-95 shadow-md hover:shadow-lg">
          Iniciar sesión
        </button>

      </form>

      <div class="text-center mt-10 text-xs text-gray-500 font-medium tracking-widest uppercase">
        Desarrollado por Rori
      </div>

    </div>
  </div>

  <!-- DERECHA INMERSIÓN -->
  <div class="hidden md:flex md:w-2/3 relative items-center justify-center text-white overflow-hidden">

    <!-- FONDO -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-900 to-blue-600"></div>

    <!-- EFECTO QUE TENÍAS (movido aquí) -->
    <div class="absolute w-[130%] h-[130%] bg-white opacity-5 rounded-full 
                animate-[spin_20s_linear_infinite] -top-[20%] -left-[20%]"></div>

    <!-- CÍRCULOS EXTRA (como tu imagen) -->
    <div class="absolute w-[800px] h-[800px] border border-white/10 rounded-full"></div>
    <div class="absolute w-[1000px] h-[1000px] border border-white/5 rounded-full"></div>

    <!-- CONTENIDO -->
    <div class="relative z-10 text-center px-10 max-w-xl">

      <!-- etiqueta -->
      <div class="mb-6">
        <span class="px-5 py-2 border border-white/30 rounded-full text-sm tracking-widest">
          UNHEVAL — INMERSIÓN
        </span>
      </div>

      <!-- título -->
      <h1 class="text-4xl md:text-5xl font-bold leading-tight mb-6">
        Intercultural <br> Communication
      </h1>

      <!-- descripción -->
      <p class="text-lg opacity-90 mb-6">
        Gestión avanzada de la comunicación y adquisición lingüística en entornos académicos.
      </p>
    </div>
  </div>

</body>
</html>