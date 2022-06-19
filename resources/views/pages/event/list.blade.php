<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Liste des évenements') }}
        </h2>
        @if(session('successMsg'))
            <p class="text-center">{{ session('successMsg') }}</p>
        @elseif(session('errorMsg') || !empty($errorMsg))
            <p class="text-center">{{ session('errorMsg') }}</p>
        @endif
    </x-slot>
    
    
    @if(count($events) > 0)
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <a href="{{ route('event.create') }}" class="flex justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Créer un évènement</a>
                <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Nom
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Description
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Date
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Place
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    <span class="sr-only">Action</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($events as $event)     
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                        {{ $event->title }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $event->description }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ date('d/m/Y', strtotime($event->date)) }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $event->subcriptions()->count() }} / {{ $event->slots }}
                                    </td>
                                    @if(Auth::user()->id == $event->author_id)
                                        <td class="px-6 py-4 text-right">
                                            @if(!Auth::user()->is_registered($event->id, Auth::user()->id))
                                                @if($event->subcriptions()->count() < $event->slots)
                                                    @if ($event->date >= date('Y-m-d'))
                                                        <a href="{{ url('event/'.$event->id.'/subscribe') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">S'inscrire</a>
                                                    @else
                                                        <a href="#" class="bubble-text bg-gray-700 text-gray font-bold py-2 px-4 rounded tooltip">
                                                            S'inscrire
                                                            <span class="tooltiptext">Cet event est déjà passé !</span>
                                                        </a>
                                                    @endif
                                                @else
                                                    <a href="#" class="bubble-text bg-gray-700 text-gray font-bold py-2 px-4 rounded tooltip">
                                                        S'inscrire
                                                        <span class="tooltiptext">Cet event est complet !</span>
                                                    </a>
                                                @endif
                                            @else
                                                <a href="{{ url('event/'.$event->id.'/unsubscribe') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Se désinscrire</a>
                                            @endif
                                            <a href="{{ url('event/'.$event->id.'/show') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Voir</a>
                                            <a href="{{ url('event/'.$event->id.'/edit') }}" class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Modifier</a>
                                            <a href="{{ url('event/'.$event->id.'/delete') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Supprimer</a>
                                        </td>
                                    @else
                                        @if(!Auth::user()->is_registered($event->id, Auth::user()->id))
                                            <td class="px-6 py-4 text-right">
                                                @if($event->subcriptions()->count() < $event->slots)
                                                    <a href="{{ url('event/'.$event->id.'/subscribe') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">S'inscrire</a>
                                                @else
                                                    <a href="#" class="bg-gray-700 text-gray font-bold py-2 px-4 rounded">S'inscrire</a>
                                                @endif
                                            </td>
                                        @else
                                            <td class="px-6 py-4 text-right">
                                                <a href="{{ url('event/'.$event->id.'/unsubscribe') }}" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Se désinscrire</a>
                                            </td>
                                        @endif
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @else
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 dark:text-white rounded-lg shadow-lg p-6">
                    <div class="flex flex-col items-center justify-center">
                        <div class="text-center">
                            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-600">
                                {{ __('Aucun évenement') }}
                            </h3>
                            <p class="mt-3 text-gray-600 dark:text-gray-400">
                                {{ __('Aucun évenement n\'a été créé pour le moment.') }}
                            </p>
                        </div>
                        <a href="{{ route('event.create') }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Créer un évènement</a>
                    </div>
                </div>
            </div>
        </div>
    @endif
</x-app-layout>
