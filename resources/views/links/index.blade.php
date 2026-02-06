<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mes Liens') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <form action="{{ route('links.store') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex gap-4">
                        <input type="url" name="original_url" placeholder="Collez votre lien ici..." class="flex-1 rounded-md border-gray-300">
                        <x-primary-button>Raccourcir</x-primary-button>
                    </div>
                </form>

                <table class="w-full text-left">
                    <thead>
                        <tr class="border-b">
                            <th class="pb-2">URL Originale</th>
                            <th class="pb-2">Lien Court</th>
                            <th class="pb-2 text-center">Clics</th>
                            <th class="pb-2">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($links as $link)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="py-3 truncate max-w-xs">{{ $link->original_url }}</td>
                            <td class="py-3">
                                <a href="{{ route('redirect', $link->short_code) }}"
                                    target="blank"
                                    class="text-indigo-600 hover:text-indigo-900 font-mono underline"> 
                                    {{ url($link->short_code) }}
                                </a>

                                <button class="copy-btn bg-gray-800 text-white px-2 py-1 rounded text-xs" 
                                        data-url="{{ url($link->short_code) }}">
                                    Copier
                                </button>
                            </td>
                            <td class="py-3 text-center">{{ $link->clicks_count }}</td>
                            <td class="py-3">
                                <button class="text-blue-500 hover:underline ml-2"
                                    x-data="" x-on:click.prevent="$dispatch('open-modal', 'edit-link-{{ $link->id }}')">
                                    Éditer
                                </button>
                                <form action="{{ route('links.destroy', $link->id) }}" method="POST" onsubmit="return confirm('Supprimer ?')">
                                    @csrf @method('DELETE')
                                    <button class="bnt btn-danger hover:underline">Supprimer</button>
                                </form>
                            </td>
                        </tr>


                            <x-modal name="edit-link-{{ $link->id }}" focusable>
                                <form method="post" action="{{ route('links.update', $link->id) }}" class="p-6">
                                    @csrf
                                    @method('PUT')

                                    <h2 class="text-lg font-medium text-gray-900">
                                        Modifier le lien
                                    </h2>

                                    <div class="mt-6">
                                        <x-input-label for="original_url" value="URL Originale" class="sr-only" />
                                        <x-text-input 
                                            id="original_url" 
                                            name="original_url" 
                                            type="url" 
                                            class="mt-1 block w-3/4" 
                                            value="{{ $link->original_url }}" 
                                            required 
                                        />
                                        <x-input-error :messages="$errors->get('original_url')" class="mt-2" />
                                    </div>

                                    <div class="mt-6 flex justify-end">
                                        <x-secondary-button x-on:click="$dispatch('close')">
                                            Annuler
                                        </x-secondary-button>

                                        <x-primary-button class="ms-3">
                                            Enregistrer les modifications
                                        </x-primary-button>
                                    </div>
                                </form>
                            </x-modal>

                        @endforeach
                    </tbody>
                </table>
                
                <div class="mt-4">
                    {{ $links->links() }} </div>
            </div>
        </div>
    </div>

</x-app-layout>



<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        $('.copy-btn').on('click', function() {
            const $btn = $(this);
            const url = $btn.attr('data-url');

            navigator.clipboard.writeText(url).then(() => {
                const originalText = $btn.text();

                $btn.text('Copié !')
                    .css('background-color', '#22c55e')
                    .css('color', '#ffffff');
                
                setTimeout(() => {
                    $btn.text(originalText)
                        .css('background-color', '')
                        .css('color', '');
                }, 2000);
            }).catch(err => {
                console.error('Erreur lors de la copie : ', err);
            });
        });
    });

</script>