<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Registro Moderno</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900 min-h-screen flex items-center justify-center">

  <div class="w-full max-w-md bg-white/10 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-8">

    <h2 class="text-3xl font-bold text-white text-center mb-6">Crear cuenta</h2>
    <p class="text-center text-gray-300 mb-8">Regístrate para comenzar</p>

    <form class="space-y-5" action="{{route('register')}}" method="POST">
    @csrf
      <div>
        <label class="text-gray-200 text-sm">Nombre completo</label>
        <input type="text" name="name"
          class="w-full mt-1 p-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label class="text-gray-200 text-sm">Correo electrónico</label>
        <input type="email" name="email"
          class="w-full mt-1 p-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label class="text-gray-200 text-sm">Contraseña</label>
        <input type="password" name="password"
          class="w-full mt-1 p-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div>
        <label class="text-gray-200 text-sm">Confirmar contraseña</label>
        <input type="password" name="password_confirmation"
          class="w-full mt-1 p-3 rounded-xl bg-white/10 border border-white/20 text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500">
      </div>

      <div class="flex items-center text-sm text-gray-300">
        <input type="checkbox" class="accent-indigo-500 mr-2">
        Acepto los términos y condiciones
      </div>

      <button type="submit"
        class="w-full py-3 rounded-xl bg-indigo-600 hover:bg-indigo-700 text-white font-semibold transition">
        Registrarme
      </button>

    </form>

    <p class="text-center text-gray-400 mt-6 text-sm">
      ¿Ya tienes cuenta? <a href="{{route('login')}}" class="text-indigo-400 hover:underline">Inicia sesión</a>
    </p>

  </div>

</body>
</html>