@extends('layouts.app')
@section('content')
    <div class="">
        <div class="max-w-9xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-900">

                    <p class="content-tab-name">
                        {{ __('Struktura menu / Edytuj zakładkę menu') }}
                    <p class="content-tab-name">

                    @include('components.menu-form-component.menu-form-component', ['menuItemsToSelect' => $menuItemsToSelect])
                </div>
            </div>
        </div>
    </div>
@endsection
