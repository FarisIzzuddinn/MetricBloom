<x-createButton target="#addUserModal" name="Tambah Pengguna" />

{{-- add modal  --}}
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Tambah Pengguna Baharu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            <form action="{{ url('users') }}" method="POST">
                    @csrf

                    {{-- Username --}}
                    <x-floating-form labelName="Nama" id="addUsername" name="name" type="text" placeholder="Nama Penuh" /> 

                    {{-- email --}}
                    <x-floating-form labelName="Email" id="addEmail" name="email" type="email" placeholder="Alamat Email" />

                    {{-- password  --}}
                    <x-floating-form labelName="Kata Laluan" id="addPassword" name="password" type="password" placeholder="Kata Laluan" />
                 
                    {{-- roles  --}}
                    <x-select-dropdown id="addRole" name="roles" :options="$roles" label="Peranan"/>
                
                    {{-- state  --}}
                    <x-select-dropdown-none id="state-container" name="state_id" style="display: none" :options="$states" label="Negeri"/>

                    {{-- institution  --}}
                    <x-select-dropdown-none id="institution-container" name="institution_id" style="display: none" :options="$institutions" label="Institusi"/>

                    <div class="mb-3" id="sector-container" style="display: none;">
                        <label for="sector_id">Select Sector:</label>
                        <select name="sector_id" id="sector_id" class="form-control">
                            <option value="">Select Sector</option>
                            @foreach($sectors as $sector)
                                <option value="{{ $sector->id }}">{{ $sector->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3" id="bahagian-container" style="display: none;">
                        <label for="bahagian_id">Select bahagian:</label>
                        <select name="bahagian_id" id="bahagian_id" class="form-control">
                            <option value="">Select bahagian</option>
                            @foreach($bahagians as $bahagian)
                                <option value="{{ $bahagian->id }}">{{ $bahagian->nama_bahagian }}</option>
                            @endforeach
                        </select>
                    </div>
                
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">Simpan</button> 
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Batalkan</button> 
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>