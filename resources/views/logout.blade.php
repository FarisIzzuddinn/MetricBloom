<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: inline;">
    @csrf
    @method('DELETE')
    <button type="submit" class="dropdown-item">
        Logout
    </button>
</form>