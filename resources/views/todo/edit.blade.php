<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Edit a ToDo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white dark:bg-gray-800 shadow sm:rounded-lg">
                @if ($errors->any())
                @foreach ($errors->all() as $error)
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-red-600 dark:text-red-600">{{ $error }}</p>
                @endforeach
                @endif
                @if (session('status') === 'todo-updated')
                <p x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-green-600 dark:text-green-600">{{ __('ToDo Updated.') }}</p>
                @endif
                <div>
                    <form method="POST" action="{{ route('todo.update') }}" class="mt-6 space-y-6">
                        @csrf
                        @method('PUT')
                        <input type="text" hidden name="id" value="{{$todo->id}}">
                        <div>
                            <x-input-label for="todo" :value="__('ToDo')" />
                            <x-text-input id="todo" name="todo" type="text" value="{{$todo->todo}}"
                                class="mt-1 block w-full" />
                            <x-input-error :messages="$errors->addTodo->get('todo')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="description" :value="__('Description')" />
                            <x-text-input id="description" name="description" value="{{$todo->description}}" type="text"
                                class="mt-1 block w-full" />
                        </div>
                        <div>
                            <x-input-label for="expireAt" :value="__('Expire at')" />
                            <x-text-input id="expireAt" name="expireAt" value="{{$todo->expireAt}}"
                                type="datetime-local" class="mt-1 block w-full" />
                        </div>
                        <div class="flex justify-end gap-4">
                            <x-primary-button>{{ __('Edit') }}</x-primary-button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>