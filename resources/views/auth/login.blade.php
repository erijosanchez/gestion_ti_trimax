<x-guest-layout>

    <form method="POST" action="{{ route('login') }}" class="form">
        @csrf

        <div class="textbox">
            <input required type="email" name="email" value="{{ old('email') }}" />
            <label>Correo</label>
            @error('email')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <div class="textbox">
            <input required type="password" name="password" />
            <label>Contraseña</label>
            @error('password')
                <small style="color: red;">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit">Login</button>
    </form>

    
</x-guest-layout>
