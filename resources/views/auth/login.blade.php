@extends("index")

@section("module", "Login")

@section('content')
    <div class="flex justify-center items-center min-h-screen bg-base-100">
        <form method="POST" action="{{ route('login') }}" class="glass p-8 rounded-lg shadow-lg w-96 h-auto">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Serveradresse:</label>
                <input type="text" name="server" value="{{ old('server') }}" placeholder="https://dein-server:port" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-4">
                <label class="block mb-1 font-semibold">Benutzername:</label>
                <input type="text" name="username" value="{{ old('username') }}" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <div class="mb-6">
                <label class="block mb-1 font-semibold">Passwort:</label>
                <input type="password" name="password" required
                       class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-purple-500">
            </div>
            <button type="submit" class="w-full bg-purple-600 text-white py-2 rounded hover:bg-purple-700 transition">Login</button>
        </form>
    </div>
@endsection

