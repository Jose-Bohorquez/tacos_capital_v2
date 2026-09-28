<div class="bg-white rounded-xl shadow-xl w-full max-w-sm p-6 sm:p-8">
    <div class="text-center mb-6">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-full bg-blue-100 text-blue-600 mb-3">
            <i class="fas fa-lock" aria-hidden="true"></i>
        </div>
        <h1 class="text-xl font-bold">Acceso administrador</h1>
        <p class="text-sm text-gray-500 mt-1">Tacos Capital</p>
    </div>

    <?php if ($mensaje = Session::flash('error')): ?>
        <div class="mb-4 bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded text-sm"><?= e($mensaje) ?></div>
    <?php endif; ?>

    <form method="post" action="/admin/login" class="space-y-4">
        <?= csrf_field() ?>
        <div>
            <label class="block text-sm font-medium mb-1">Usuario</label>
            <input type="text" name="username" required autofocus autocapitalize="off" autocorrect="off"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Contraseña</label>
            <input type="password" name="password" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2.5 text-base focus:outline-none focus:ring-2 focus:ring-blue-500">
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 text-white font-semibold py-2.5 rounded-lg transition">
            Entrar
        </button>
    </form>
</div>
