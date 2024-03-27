{{-- Determine if we're adding a new file or editing an existing one --}}
@php
    $isEdit = isset($file);
    $formAction = $isEdit ? route('menu.file.update', $file->id) : route('menu.files.store');
    $submitButtonText = $isEdit ? 'Zaktualizuj Plik' : 'Dodaj Plik';
@endphp



<div class="file-upload-component">
    <h2 class="text-xl font-semibold mb-4">{{ $isEdit ? 'Edytuj Plik' : 'Pliki / Nowy Plik' }}</h2>

    <form action="{{ $formAction }}" method="post" enctype="multipart/form-data">
        @csrf
        @if($isEdit) @method('PATCH') @endif

        <div class="row">
            <div class="col">
                {{-- Menu Item Selection --}}
                <div class="mb-3">
                    <label for="menu_id" class="form-label">Zakładka</label>
                    <select id="menu_id" name="menu_id" class="form-select">
                        <option value="">Wybierz zakładkę</option>
                        @foreach($menuItemsToSelect as $menuItem)
                            <option value="{{ $menuItem->id }}" {{ $isEdit && $file->menu_id == $menuItem->id ? 'selected' : '' }}>{{ $menuItem->name }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- File Name --}}
                <div class="mb-3">
                    <label for="file_name" class="form-label">Nazwa Pliku*</label>
                    <input type="text" id="file_name" name="name" class="form-control" required value="{{ $isEdit ? $file->name : '' }}">
                </div>

                {{-- File Location --}}
                {{-- File Source Selection --}}
                <div class="mb-3">
                    <label class="form-label">Lokalizacja pliku:</label>
                    <select name="file_source" id="file_source" class="form-select" onchange="toggleFileSource(this.value)">
                        <option value="pc">import pliku z dysku</option>
                        <option value="external">plik z zewnętrznego serwera</option>
                        <option value="server">wskaż plik uprzednio wgrany na serwer</option>
                    </select>
                </div>

                {{-- Inputs for each file source --}}
                <div id="file_pc" class="file-source">
                    <input type="file" name="file" />
                </div>
                <div id="file_external" class="file-source" style="display: none;">
                    <input type="text" name="file_url" placeholder="URL pliku" />
                </div>
                <div id="file_server" class="file-source" style="display: none;">
                    <select name="server_file" class="form-select">
                        <option value="">Wybierz plik</option>
                        @foreach($serverFiles as $serverFile)
                        <option value="{{ $serverFile }}">{{ basename($serverFile) }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- File Upload Dropzone Area --}}
                <div class="mb-3">
                    <label for="dropzoneFileUpload" class="form-label">Plik*</label>
                    <div id="dropzoneFileUpload" name="file" class="dropzone"></div>
                </div>

            </div>

            <div class="col">
                {{-- Visibility Start --}}
                <div class="mb-3">
                    <label for="start" class="form-label">Widoczny Od</label>
                    <input type="date" id="start" name="start" class="form-control" value="{{ $isEdit ? optional($file->start)->format('Y-m-d') : '' }}">
                </div>

                {{-- Visibility End --}}
                <div class="mb-3">
                    <label for="end" class="form-label">Widoczny Do</label>
                    <input type="date" id="end" name="end" class="form-control" value="{{ $isEdit ? optional($file->end)->format('Y-m-d') : '' }}">
                </div>

                {{-- Keywords --}}
                <div class="mb-3">
                    <label for="tags" class="form-label">Słowa Kluczowe</label>
                    <input type="text" id="tags" name="tags" class="form-control" placeholder="(oddzielone spacją)" value="{{ $isEdit ? $file->tags : '' }}">
                </div>

                {{-- Car Association --}}
                <div class="mb-3">
                    <label for="auto_id" class="form-label">Dotyczy Samochodu</label>
                    <select id="auto_id" name="auto_id" class="form-select">
                        <option value="">Wybierz samochód</option>
                        @foreach($autos as $auto)
                            <option value="{{ $auto->id }}" {{ $isEdit && $file->auto_id == $auto->id ? 'selected' : '' }}>{{ $auto->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        {{-- Submit and Delete Buttons --}}
        <div class="mb-3">
            <button type="submit" class="btn btn-primary">{{ $submitButtonText }}</button>
            @if($isEdit)
                <button type="button" class="btn btn-danger" id="deleteFileButton">Usuń Plik</button>
            @endif
        </div>
    </form>
</div>

{{-- Scripts section for the dropzon adn file uploader --}}
<script>
    @if($isEdit && $file->path)
        var existingFileUrl = "{{ Storage::url($file->path) }}";
        var existingFileName = "{{ $file->name }}";
    @else
        var existingFileUrl = '';
        var existingFileName = '';
    @endif
</script>
