<x-base>
  <h1>Home</h1>

  <p :isset="$user">Hello, {{ $user -> username }}</p>
</x-base>
