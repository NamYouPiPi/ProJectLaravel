<aside class="sidebar">
  <ul class="menu">

    <li>
      <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard</a>
    </li>

    <li>
      <a href="{{ route('suppliers.index') }}" class="nav-link">Suppliers</a>
    </li>

    <li>
      <a href="{{ route('inventory.index') }}" class="nav-link">Inventory</a>
    </li>

    <li>
      <a href="{{ route('sale.index') }}" class="nav-link">Sales</a>
    </li>

    <li>
      <a href="{{ route('hall_locations.index') }}" class="nav-link">Hall Locations</a>
    </li>

    <li>
      <a href="{{ route('hallCinema.index') }}" class="nav-link">Hall Cinema</a>
    </li>

    <li>
      <a href="{{ route('movies.index') }}" class="nav-link">Movies</a>
    </li>

    <li>
      <a href="{{ route('genre.index') }}" class="nav-link">Genres</a>
    </li>

    <li>
      <a href="{{ route('classification.index') }}" class="nav-link">Classifications</a>
    </li>

    <li>
        <a href="{{ route('showtimes.index') }}" class="nav-link">
    </li>

  </ul>
</aside>

<style>
  .sidebar {
    width: 240px;
    height: 100vh;
    background: #0b1017;
    color: #fff;
    padding: 20px;
    position: fixed;
    left: 0;
    top: 0;
    overflow-y: auto;
  }
  .menu {
    list-style: none;
    padding: 0;
    margin: 0;
  }
  .menu li {
    margin-bottom: 12px;
  }
  .menu a {
    color: #cbd5e1;
    text-decoration: none;
    display: block;
    padding: 8px 12px;
    border-radius: 8px;
  }
  .menu a:hover {
    background: #1e293b;
    color: #fff;
  }
</style>

