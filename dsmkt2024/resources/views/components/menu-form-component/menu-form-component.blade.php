{{-- Blade Template for Creating or Editing Menu Items --}}
{{-- Assumes $menuItem exists and is not null when editing --}}

@php
    $isEdit = isset($menuItem);
    $formAction = $isEdit ? route('menu.menu-items.update', $menuItem->id) : route('menu.menu-items.store');
    $formMethod = $isEdit ? 'PATCH' : 'POST';
@endphp

<form id="create-menu-item-form" action="{{ $formAction }}" method="POST">
    @csrf
    @if($isEdit)
        @method($formMethod)
    @endif

    {{-- Type --}}
    <div>
        <label for="type">Typ zakładki:</label>
        <select id="type" name="type" required>
            <option value="main" @if($isEdit && $menuItem->type == 'main') selected @endif>Główna</option>
            <option value="sub" @if($isEdit && $menuItem->type == 'sub') selected @endif>Podrzędna</option>
        </select>
    </div>

    {{-- Name --}}
    <div>
        <label for="name">Nazwa zakładki:</label>
        <input type="text" id="name" name="name" value="{{ $isEdit ? $menuItem->name : '' }}" required>
    </div>

    {{-- Parent ID --}}
    <div>
        <label for="parent_id">Element nadrzędny:</label>
        <select id="parent_id" name="parent_id">
            <option value="">Brak (jest to element nadrzędny)</option>
            @foreach($menuItemsToSelect as $item)
                <option value="{{ $item->id }}" @if($isEdit && $menuItem->parent_id == $item->id) selected @endif>{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- Owners --}}
    <div>
        <label for="owners">Opiekuny/Administratorzy:</label>
        <select id="owners" name="owners[]" multiple>
            @foreach($users as $user)
                <option value="{{ $user->id }}" @if($isEdit && in_array($user->id, $menuItem->owners->pluck('id')->toArray())) selected @endif>{{ $user->name }}</option>
            @endforeach
        </select>
    </div>

   {{-- Visibility Start --}}
    <div>
        <label for="visibility_start">Zakładka widoczna od:</label>
        <input type="date" id="visibility_start" name="visibility_start" value="{{ $isEdit && $menuItem->visibility_start ? $menuItem->visibility_start->format('Y-m-d') : '' }}">
    </div>

    {{-- Visibility End --}}
    <div>
        <label for="visibility_end">Zakładka widoczna do:</label>
        <input type="date" id="visibility_end" name="visibility_end" value="{{ $isEdit && $menuItem->visibility_end ? $menuItem->visibility_end->format('Y-m-d') : '' }}">
    </div>


    {{-- Banner --}}
    <div>
        <label for="banner">Przypisanie banera:</label>
        <select id="banner" name="banner">
            <option value="random_banner" @if($isEdit && $menuItem->banner == 'random_banner') selected @endif>Baner losowy</option>
            <option value="dedicated_banner" @if($isEdit && $menuItem->banner == 'dedicated_banner') selected @endif>Baner dedykowany</option>
        </select>
    </div>

    {{-- Form Actions --}}
    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Aktualizuj' : 'Dodaj' }}</button>
        <button type="reset" class="btn btn-secondary">Wyczyść</button>
    </div>
</form>
