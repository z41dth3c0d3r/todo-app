<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My ToDos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="flex justify-end">
                        <a href="{{route('todo.index')}}">

                            <x-primary-button type="button">
                                {{__('Create a
                                ToDo')}}</x-primary-button>

                        </a>
                    </div>

                    <table class="table border w-full border-collapse mt-4">
                        <thead>
                            <tr class="border">
                                <th class="text-left py-2">ToDo</th>
                                <th class="text-left py-2">Description</th>
                                <th class="text-left py-2">Created At</th>
                                <th class="text-left py-2">Expires At</th>
                                <th class="text-left py-2">Completed At</th>
                                <th class="text-left py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($todos as $todo)
                            <tr class="border">
                                <td class="text-left py-2">{{ $todo->todo }}</td>
                                <td class="text-left py-2">{{ $todo->description }}</td>
                                <td class="text-left py-2">{{ $todo->created_at }}</td>
                                <td class="text-left py-2">{{ $todo->expireAt }}</td>
                                <td class="text-left py-2">{{ $todo->completedAt }}</td>
                                <td class="text-left py-2">
                                    <div class="flex gap-4">
                                        @if($todo->completedAt == null)
                                        <form action="{{ route('todo.complete') }}" method="POST">
                                            @csrf
                                            @method("POST")
                                            <input type="hidden" name="id" value="{{ $todo->id }}">
                                            <x-primary-button>
                                                {{__('Complete ToDo')}}
                                            </x-primary-button>
                                        </form>
                                        <a href="{{ route('todo.edit', ['id' => $todo->id]) }}">
                                            <x-primary-button type="button">
                                                {{__('Edit ToDo')}}
                                            </x-primary-button>
                                        </a>
                                        @endif
                                        <form action="{{ route('todo.destroy') }}" method="POST">
                                            @csrf
                                            @method("DELETE")
                                            <input type="hidden" name="id" value="{{ $todo->id }}">
                                            <x-primary-button>
                                                {{__('Delete ToDo')}}
                                            </x-primary-button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4 flex justify-end">
                        @if (session('status') === 'todo-completed')
                        <p x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-green-600 dark:text-green-400">{{ __('ToDo Completed.') }}</p>
                        @elseif(session('status') === 'todo-deleted')
                        <p x-data="{ show: true }" x-show="show" x-transition
                            x-init="setTimeout(() => show = false, 2000)"
                            class="text-sm text-red-600 dark:text-red-400">{{ __('ToDo Deleted.') }}</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>