<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    <button type="submit" class="dropdown-item">Logout</button>
</form>