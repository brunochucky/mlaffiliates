@php
$emailHash = md5(Auth::user()->email);
$registrationLink = route('register') . '?uid=' . $emailHash;
@endphp

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}

                    <p class="mt-4"><strong>{{ __("Your Unique Identifier") }}:</strong> {{ $emailHash }}</p>
                    <p class="mt-4"><strong>{{ __("Your Affiliate Link") }}:</strong> <a href="{{ $registrationLink }}">{{ $registrationLink }}</a></p>

                    <!-- Botão para copiar o link -->
                    <button id="copyButton" class="bg-green-500 text-white px-4 py-2 rounded-md mt-4">
                        Copiar Link
                    </button>

                    <!-- Mensagem de confirmação -->
                    <p id="copyMessage" class="text-green-500 mt-2" style="display:none;">Link copiado!</p>

                    <!-- Script para copiar o link -->
                    <script>
                        document.getElementById('copyButton').addEventListener('click', () => {
                            // Cria um campo de texto temporário
                            const tempInput = document.createElement('input');
                            tempInput.value = '{{ $registrationLink }}';

                            // Adiciona ao DOM
                            document.body.appendChild(tempInput);

                            // Seleciona e copia o conteúdo do campo de texto
                            tempInput.select();
                            document.execCommand('copy');

                            // Remove o campo temporário
                            document.body.removeChild(tempInput);

                            // Exibe uma mensagem de confirmação
                            const message = document.getElementById('copyMessage');
                            message.style.display = 'block';

                            // Remove a mensagem após 2 segundos
                            setTimeout(() => {
                                message.style.display = 'none';
                            }, 2000);
                        });
                    </script>

                    <p class="mt-4"><strong>{{ __("Your QR Code") }}:</strong></p>
                    <p class="mt-4">{!! QrCode::size(200)->generate($registrationLink) !!}</p>


                    <!-- Share Button -->
                    <button id="shareButton" class="bg-blue-500 text-white px-4 py-2 rounded-md mt-4">
                        Compartilhar
                    </button>

                    <!-- JavaScript to handle sharing -->
                    <script>
                        document.getElementById('shareButton').addEventListener('click', async () => {
                            if (navigator.share) {
                                try {
                                    await navigator.share({
                                        title: 'Indica Calvo',
                                        text: 'Utilize meu link para cadastro:',
                                        url: '{{ $registrationLink }}'
                                    });
                                    //alert('Link shared successfully!');
                                } catch (err) {
                                    console.error('Error sharing the link:', err);
                                }
                            } else {
                                alert('Your browser does not support the share feature.');
                            }
                        });
                    </script>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>