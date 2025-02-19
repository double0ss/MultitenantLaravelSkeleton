<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus />
        </div>

        <div>
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required />
        </div>

        <div>
            <button type="submit">
                Log in
            </button>
        </div>
    </form>
</x-guest-layout>